<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public $seller;

    public function __construct() {
        parent::__construct();
        $this->seller = $this->session->userdata('seller');
        $this->load->language('product', 'id');
        $this->load->model('product_model', 'product');
        $this->load->library('my_encrypt');
        $this->load->library('api');
        if (!$this->seller) {
            redirect(base_url('auth'));
        }
    }

	public function index() {
		$data = [
			'judul' => 'Seller',
			'deskripsi' => lang('product_page'),
			'content' => 'product/index',
			'menu' => 'product',
			'javascripts' => [
                base_url('assets/admin/js/product.js'),
            ],
			'seller' => $this->seller
		];

        $this->load->view('layout/full', $data);
	}

    public function get_list() {
        $this->input->is_ajax_request() or exit("No direct post submit allowed!");

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $output['data'] = [];
        $datas = $this->product->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = [
                    '<img class="img-thumbnail" src="' . $data->thumbnail . '" style="width: 200px;" />',
                    $data->name,
                    $data->category_name,
                    rupiah($data->price),
                    $data->stock,
                    lang('status_' . $data->status),
                    // '<button class="btn btn-warning btn-sm">Ubah</button><a href="' . base_url('product/delete/' . $data->id) . '" class="btn btn-danger btn-sm ml-2 hapus" onclick="deleteRow(event,this)">' . lang('delete') . '</a>'
                    '<a class="btn btn-warning btn-sm" href="' . base_url('product/edit/' . $data->id) . '">Ubah</a>'
                ];
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->product->count_all();
        $output['recordsFiltered'] = $this->product->count_all($search);
        echo json_encode($output);
    }

    public function add() {
        $data = [
			'judul' => 'Seller',
			'deskripsi' => lang('add') . ' ' . lang('product'),
			'content' => 'product/form',
			'menu' => 'product',
			'javascripts' => [
                base_url('assets/admin/js/product_form.js'),
            ],
			'seller' => $this->seller,
            'action' => 'add'
		];

        $data['categories'] = $this->main->gets('categories');

        $this->load->view('layout/full', $data);
    }

    public function do_add() {
        $this->input->is_ajax_request() or exit("No direct post submit allowed!");

        $this->form_validation->set_rules('name', 'lang:name', 'required|trim');
        $this->form_validation->set_rules('price', 'lang:price', 'required|trim');
        $this->form_validation->set_rules('category', 'lang:category', 'required|trim');
        $this->form_validation->set_rules('stock', 'lang:stock', 'required|trim');
        // $this->form_validation->set_rules('seo_url', 'lang:seo_url', 'required|trim');
        $this->form_validation->set_rules('weight', 'lang:weight', 'required|trim');
        $this->form_validation->set_rules('thumbnail', 'lang:thumbnail', 'required|trim');

        $this->form_validation->set_message('required', 'Kolom {field} harus diisi!');

        $return = [
            'status' => 'error',
            'message' => 'Terjadi suatu kesalahan!'
        ];
        if ($this->form_validation->run() === FALSE) {
            $return['message'] = validation_errors();
        } else {
            $return['status'] = 'success';
            $return['message'] = 'Produk berhasil ditambah!';
            $post = $this->input->post(null, true);
            $post['price'] = str_replace(".", "", $post['price']);
            $post['category_id'] = $post['category'];
            $post['seller_id'] = $this->seller->id;
            unset($post['category']);

            do {
                $post['seo_url'] = generate_url($post['name']);
            } while($this->main->get('products', ['seo_url' => $post['seo_url']]));
            
            $images = [];
            if (isset($post['images'])) {
                $images = $post['images'];
                unset($post['images']);
            }


            $request_thumbnail = [
                'image' => 'data:image/jpeg;base64,' . $post['thumbnail']
            ];

            $response = $this->api->post($this->api->url_media . 'media', $request_thumbnail);
            if ($response['status'] == 'success') {
                $post['thumbnail'] = $response['data']['image'];
                $product_id = $this->main->insert('products', $post);

                if (count($images) > 0) {
                    foreach ($images as $image) {
                        $request_image = [
                            'image' => 'data:image/jpeg;base64,' . $image,
                        ];
                        $response_image = $this->api->post($this->api->url_media . 'media', $request_image);
                        if ($response_image['status'] == 'success') {
                            $image_name = $response_image['data']['image'];
                            $this->main->insert('product_images', [
                                'product_id' => $product_id,
                                'image' => $image_name
                            ]);
                        }
                    }
                }

                $return = [
                    'status' => 'success',
                    'message' => 'Produk berhasil ditambah!'
                ];
            } else {
                $return = $response;
            }

        }
        echo json_encode($return);
    }

    public function edit($id = '') {
        if ($id == '') {
            redirect(base_url('product'));
        }

        $product = $this->main->get('products', ['id' => $id, 'seller_id' => $this->seller->id]);

        if (!$product) {
            redirect(base_url('product'));
        }

        $data = [
			'judul' => 'Seller',
			'deskripsi' => lang('edit') . ' ' . lang('product'),
			'content' => 'product/form',
			'menu' => 'product',
			'javascripts' => [
                base_url('assets/admin/js/product_form.js'),
            ],
			'seller' => $this->seller,
            'action' => 'edit',
            'data' => $product,
            'product_images' => [],
		];

        $product_images = $this->main->gets('product_images', ['product_id' => $id]);
        if ($product_images) {
            foreach ($product_images->result() as $image) {
                $getImage = file_get_contents($image->image);
                if ($getImage !== false) {
                    array_push($data['product_images'], [
                        'image' => $image->image,
                        'base64' => base64_encode($getImage)
                    ]);
                }
            }
        }

        $data['categories'] = $this->main->gets('categories');
        $this->load->view('layout/full', $data);
    }

    public function do_edit($id) {
        $this->input->is_ajax_request() or exit("No direct post submit allowed!");

        if (!$id) {
           $return = [
               'status' => 'error',
               'message' => "Terjadi suatu kesalahan!"
           ]; 
           echo json_encode($return);exit();
        }
        $product = $this->main->get('products', ['id' => $id, 'seller_id' => $this->seller->id]);

        if (!$product) {
            $return = [
                'status' => 'error',
                'message' => "Terjadi suatu kesalahan!"
            ]; 
            echo json_encode($return);exit();
        }

        $this->form_validation->set_rules('name', 'lang:name', 'required|trim');
        $this->form_validation->set_rules('price', 'lang:price', 'required|trim');
        $this->form_validation->set_rules('category', 'lang:category', 'required|trim');
        $this->form_validation->set_rules('stock', 'lang:stock', 'required|trim');
        // $this->form_validation->set_rules('seo_url', 'lang:seo_url', 'required|trim');
        $this->form_validation->set_rules('weight', 'lang:weight', 'required|trim');
        // $this->form_validation->set_rules('thumbnail', 'lang:thumbnail', 'required|trim');

        $this->form_validation->set_message('required', 'Kolom {field} harus diisi!');

        $return = [
            'status' => 'error',
            'message' => 'Terjadi suatu kesalahan!'
        ];
        if ($this->form_validation->run() === FALSE) {
            $return['message'] = validation_errors();
        } else {
            $return['status'] = 'success';
            $return['message'] = 'Produk berhasil diubah!';
            $post = $this->input->post(null, true);
            $post['price'] = str_replace(".", "", $post['price']);
            $post['category_id'] = $post['category'];
            $post['seller_id'] = $this->seller->id;
            unset($post['category']);

            $images = [];
            if (isset($post['images'])) {
                $images = $post['images'];
                unset($post['images']);
            }

            if ($post['thumbnail']) {
                $request_thumbnail = [
                    'image' => 'data:image/jpeg;base64,' . $post['thumbnail'],
                ];
                $response_thumbnail = $this->api->post($this->api->url_media . 'media', $request_thumbnail);
                if ($response_thumbnail['status'] == 'success') {
                    $post['thumbnail'] = $response_thumbnail['data']['image'];
                    $this->main->update('products', $post, ['id' => $id]);
                    if (count($images) > 0) {
                        $this->main->delete('product_images', ['product_id' => $id]);
                        foreach ($images as $image) {
                            $request_image = [
                                'image' => 'data:image/jpeg;base64,' . $image,
                            ];
                            $response_image = $this->api->post($this->api->url_media . 'media', $request_image);
                            if ($response_image['status'] == 'success') {
                                $image_name = $response_image['data']['image'];
                                $this->main->insert('product_images', [
                                    'product_id' => $id,
                                    'image' => $image_name
                                ]);
                            }
                        }
                    }
                } else {
                    $return = $response_thumbnail;
                }
            } else {
                unset($post['thumbnail']);
                $this->main->update('products', $post, ['id' => $id]);
                if (count($images) > 0) {
                    $this->main->delete('product_images', ['product_id' => $id]);
                    foreach ($images as $image) {
                        $request_image = [
                            'image' => 'data:image/jpeg;base64,' . $image,
                        ];
                        $response_image = $this->api->post($this->api->url_media . 'media', $request_image);
                        if ($response_image['status'] == 'success') {
                            $image_name = $response_image['data']['image'];
                            $this->main->insert('product_images', [
                                'product_id' => $id,
                                'image' => $image_name
                            ]);
                        }
                    }
                }
            }
        }

        echo json_encode($return);
    }
}