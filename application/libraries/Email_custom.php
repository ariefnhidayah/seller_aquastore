<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Email_custom {

    public $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function verification_email($data) {
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'aquastore.id@gmail.com',  // Email gmail
            'smtp_pass'   => 'aquastoreid123',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

		$this->CI->load->library('email', $config);

		$this->CI->email->initialize($config);
		
		$this->CI->email->from($data['from_email'], $data['account_name']);
		$this->CI->email->to($data['to_email']);
		
		$this->CI->email->subject($data['subject']);
        $this->CI->email->message($data['message']);
		
		if($this->CI->email->send()){
			$this->CI->main->insert('email_logs', [
                'email' => $data['to_email'],
                'value' => json_encode($data)
            ]);
		} else {
			$this->CI->main->insert('email_logs', [
                'email' => $data['to_email'],
                'value' => $this->CI->email->print_debugger()
            ]);
		}
    }

}