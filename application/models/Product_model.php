<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = []) {

        $seller = $this->session->userdata('seller');

        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select("p.thumbnail, p.name, p.price, p.stock, c.name as category_name, p.id, p.status")
                    ->join("categories c", "c.id = p.category_id", "left")
                    ->where('p.seller_id', $seller->id)
                    ->limit($length, $start);
        return $this->db->get("products p");
    }

    function count_all($search = '') {
        $this->where_like($search);
        return $this->db->join("categories c", "c.id = p.category_id", "left")->count_all_results("products p");
    }

    function get_alias_key($key) {
        switch ($key) {
            case 1: $key = 'p.name';
                break;
            case 2: $key = 'c.name';
                break;
            case 3: $key = 'p.price';
                break;
            case 4: $key = 'p.stock';
                break;
        }
        return $key;
    }

    function where_like($search = '') {
        $columns = ['c.name', 'p.name'];
        if ($search) {
            foreach ($columns as $column) {
                $this->db->or_like('IFNULL(' . $column . ',"")', strtolower($search));
            }
        }
    }

}