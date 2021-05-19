<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public $seller;

    public function __construct() {
        parent::__construct();
        $this->seller = $this->session->userdata('seller');
        $this->load->language('profile_lang', 'id');
        if (!$this->seller) {
            redirect(base_url('auth'));
        }
    }

    public function index() {
        $data = [
			'judul' => 'Seller',
			'deskripsi' => lang('profile_page'),
			'content' => 'profile/index',
			'menu' => 'profile',
			'javascripts' => [
                base_url('assets/admin/js/profile.js'),
            ],
			'seller' => $this->seller
		];

        $data['provincies'] = $this->main->gets('provincies');
        $data['cities'] = $this->main->gets('cities', ['province' => $this->seller->province_id]);
        $data['districts'] = $this->main->gets('districts', ['city' => $this->seller->city_id]);

        $data['shippings'] = ['pos', 'jne', 'tiki'];
        $data['couriers'] = json_decode($this->seller->courier);

        $this->form_validation->set_rules('name', 'lang:name', 'trim|required');
        $this->form_validation->set_rules('store_name', 'lang:store_name', 'trim|required');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|callback_check_phone');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required');
        $this->form_validation->set_rules('province', 'lang:province', 'trim|required');
        $this->form_validation->set_rules('city', 'lang:city', 'trim|required');
        $this->form_validation->set_rules('district', 'lang:district', 'trim|required');
        $this->form_validation->set_rules('postcode', 'lang:postcode', 'trim|required');
        $this->form_validation->set_rules('couriers[]', 'lang:courier', 'trim|required');
        $this->form_validation->set_rules('bank_name', 'lang:bank_name', 'trim|required');
        $this->form_validation->set_rules('account_number', 'lang:account_number', 'trim|required');
        $this->form_validation->set_rules('account_holder', 'lang:account_holder', 'trim|required');

        $this->form_validation->set_message('required', 'Kolom {field} ini dibutuhkan!');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layout/full', $data);
        } else {
            $post = $this->input->post(null, true);
            
            $post['courier'] = json_encode($post['couriers']);
            $post['province_id'] = $post['province'];
            $post['city_id'] = $post['city'];
            $post['district_id'] = $post['district'];
            unset($post['couriers']);
            unset($post['province']);
            unset($post['city']);
            unset($post['district']);

            $this->main->update('sellers', $post, ['id' => $this->seller->id]);
            $seller = $this->main->get('sellers', ['id' => $this->seller->id]);
            $this->session->set_userdata(['seller' => $seller]);
            $this->session->set_flashdata('message_success', 'Profil berhasil diubah!');
            redirect(base_url('profile'));
        }
    }

    public function check_phone($value) {
        $check = $this->main->get('sellers', ['phone' => $value, 'id !=' => $this->seller->id]);
        if ($check) {
            $this->form_validation->set_message('check_phone', '{field} sudah terpakai.');
            return false;
        } else {
            return true;
        }
    }

    public function verification_account() {
        if ($this->seller->status == 'active') {
            redirect(base_url('profile'));
        }
        $data = [
			'judul' => 'Seller',
			'deskripsi' => 'Halaman Verifikasi Akun',
			'content' => 'profile/verification_account',
			'menu' => 'profile',
			'javascripts' => [
                base_url('assets/admin/js/verification.js'),
            ],
			'seller' => $this->seller
		];

        $this->form_validation->set_rules('verification_code', 'lang:verification_code', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layout/full', $data);
        } else {
            $post = $this->input->post(null, true);
            $seller = $this->main->get('sellers', ['id' => $this->seller->id]);

            if ($seller->verification_code == $post['verification_code']) {
                $this->main->update('sellers', ['status' => 'active'], ['id' => $this->seller->id]);
                $seller = $this->main->get('sellers', ['id' => $this->seller->id]);
                $this->session->set_userdata(['seller' => $seller]);
                $this->session->set_flashdata('message_success', 'Akun anda berhasil diverifikasi!');
                redirect(base_url('profile'));
            } else {
                $this->session->set_flashdata('message_error', 'Kode verifikasi salah!');
                redirect(base_url('profile/verification_account'));
            }
        }

    }

    public function resend_code() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->load->library('Email_custom');

        $seller = $this->main->get('sellers', ['id' => $this->seller->id]);

        $time = time();
        $verification_sent_time = strtotime($seller->verification_sent_time);
        $range = $time - $verification_sent_time;
        if ($range < 120) {
            $return = [
                'status' => 'delay',
                'message' => 'Tunggu beberapa saat untuk mengirim ulang kode verifikasi!'
            ];
            echo json_encode($return);
            exit();
        }
        
        $code = rand(1000, 9999);
        $this->main->update('sellers', [
            'verification_code' => $code,
            'verification_sent_time' => date('Y-m-d H:i:s')
        ], ['id' => $this->seller->id]);
        
        $data_message = [
            'subject' => 'Verifikasi Akun Seller',
            'name' => $this->seller->name,
            'code' => $code
        ];

        $message = $this->load->view('email/email_verification', $data_message, true);

        $send_email = [
            'from_email' => 'aquastore.id@gmail.com',
            'account_name' => 'No Reply AquaStore ID',
            'to_email' => $this->seller->email,
            'subject' => 'Verifikasi Akun Seller',
            'message' => $message
        ];

        $this->email_custom->verification_email($send_email);

        $return = [
            'status' => 'success',
            'message' => "Kode verifikasi berhasil dikirim!"
        ];
        echo json_encode($return);

    }

}