<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Encrypt {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();

        $this->CI->load->library('encryption');
        $this->CI->encryption->initialize(
            array(
                'mode' => 'OFB',
                'cipher' => 'des'
            )
        );
    }

    public function encode($string) {
        return $this->CI->encryption->encrypt($string);
    }

    public function decode($string) {
        return $this->CI->encryption->decrypt($string);
    }

}