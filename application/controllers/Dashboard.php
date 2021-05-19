<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $seller;

    public function __construct() {
        parent::__construct();
        $this->seller = $this->session->userdata('seller');
        if (!$this->seller) {
            redirect(base_url('auth'));
        }
    }

	public function index() {
		$data = [
			'judul' => 'Seller',
			'deskripsi' => 'Dashboard Page',
			'content' => 'dashboard/index',
			'menu' => 'dashboard',
			// 'javascript' => [
            //     base_url('assets/admin/js/dashboard.js'),
            // ],
			'seller' => $this->seller
		];

        $this->load->view('layout/full', $data);
	}
}
