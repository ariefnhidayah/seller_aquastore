<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->language('auth', 'id');
        $this->load->library("HereMap", "heremap");
    }    

	public function index()
	{
		if ($this->session->userdata('seller')) {
            redirect(base_url());
        }

        $data = [
            'judul' => lang('login_page'),
            'content' => 'auth/login'
        ];

        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required');

        $this->form_validation->set_message('required', 'Kolom {field} diperlukan!');
        $this->form_validation->set_message('valid_email', 'Email tidak valid!');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/layout', $data);
        } else {
            $post = $this->input->post(null, true);
            // cek email
            $check_email = $this->main->get('sellers', ['email' => $post['email']]);
            if ($check_email) {
                if (password_verify($post['password'], $check_email->password)) {
                    $this->session->set_userdata(['seller' => $check_email]);
                    redirect(base_url(''));
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect(base_url('auth'));
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar!');
                redirect(base_url('auth'));
            }
        }
	}

    public function logout() {
        $this->session->unset_userdata('seller');
        redirect(base_url('auth'));
    }

    public function register() {
        if ($this->session->userdata('seller')) {
            redirect(base_url());
        }

        $this->load->library('Email_custom');

        $data = [
            'judul' => lang('register_page'),
            'content' => 'auth/register',
            'javascripts' => [
                base_url('assets/admin/js/register.js')
            ]
        ];

        $data['shippings'] = ['pos', 'jne', 'tiki'];
        $data['provincies'] = $this->main->gets('provincies');

        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|is_unique[sellers.email]');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required');
        $this->form_validation->set_rules('store_name', 'lang:store_name', 'trim|required');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|is_unique[sellers.phone]');
        $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[6]|matches[password]');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required');
        $this->form_validation->set_rules('province', 'lang:province', 'trim|required');
        $this->form_validation->set_rules('city', 'lang:city', 'trim|required');
        $this->form_validation->set_rules('district', 'lang:district', 'trim|required');
        $this->form_validation->set_rules('postcode', 'lang:postcode', 'trim|required');
        $this->form_validation->set_rules('couriers[]', 'lang:courier', 'trim|required');
        $this->form_validation->set_rules('bank_name', 'lang:bank_name', 'trim|required');
        $this->form_validation->set_rules('account_number', 'lang:account_number', 'trim|required');
        $this->form_validation->set_rules('account_holder', 'lang:account_holder', 'trim|required');

        $this->form_validation->set_message('required', 'Kolom {field} diperlukan!');
        $this->form_validation->set_message('valid_email', 'Email tidak valid!');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/layout', $data);
        } else {
            $post = $this->input->post(null, true);

            $post['verification_code'] = rand(1000, 9999);
            $post['verification_sent_time'] = date('Y-m-d H:i:s');

            $province = $this->main->get('provincies', ['id' => $post['province']]);
            $city = $this->main->get('cities', ['id' => $post['city']]);
            $district = $this->main->get('districts', ['id' => $post['district']]);

            $full_address = $post['address'] . ' ' . $district->name . ', ' . $city->type . ' ' . $city->name . ', ' . $province->name . ', ' . $post['postcode'];
            $location = $this->heremap->geocode($full_address);
            $post['latitude'] = $location['position']['lat'];
            $post['longitude'] = $location['position']['lng'];
            
            $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
            $post['courier'] = json_encode($post['couriers']);
            $post['province_id'] = $post['province'];
            $post['city_id'] = $post['city'];
            $post['district_id'] = $post['district'];
            unset($post['couriers']);
            unset($post['province']);
            unset($post['city']);
            unset($post['district']);
            unset($post['confirm_password']);
            $this->main->insert('sellers', $post);

            $data_message = [
                'subject' => 'Verifikasi Akun Seller',
                'name' => $post['name'],
                'code' => $post['verification_code']
            ];

            $message = $this->load->view('email/email_verification', $data_message, true);

            $send_email = [
                'from_email' => 'aquastore.id@gmail.com',
                'account_name' => 'No Reply AquaStore ID',
                'to_email' => $post['email'],
                'subject' => 'Verifikasi Akun Seller',
                'message' => $message
            ];

            // $this->email_custom->verification_email($send_email);
            $this->session->set_flashdata('message', 'Registrasi berhasil. Silahkan cek email untuk melihat kode verifikasi akun anda!');
			redirect(base_url('auth'));
        }
    }

    public function get_cities() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $post = $this->input->post(null, true);
        $cities = $this->main->gets('cities', ['province' => $post['province_id']]);
        echo json_encode($cities->result());
    }

    public function get_districts() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $post = $this->input->post(null, true);
        $districts = $this->main->gets('districts', ['city' => $post['city_id']]);
        echo json_encode($districts->result());
    }

    public function test_email() {
        $data = [
            'name' => "Arief",
            'subject' => 'Ini subject',
            'code' => '5555'
        ];
        $this->load->view('email/email_verification', $data);
    }
    
}
