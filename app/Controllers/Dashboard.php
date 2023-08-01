<?php

namespace App\Controllers;

class Dashboard extends BaseController {
    private $db;

    public function __construct() {
		$this->db = \Config\Database::connect();
	}

    public function index() {
        $db = \Config\Database::connect();

        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'dashboard', 'create');
        $role_r = $this->Crud->module($role_id, 'dashboard', 'read');
        $role_u = $this->Crud->module($role_id, 'dashboard', 'update');
        $role_d = $this->Crud->module($role_id, 'dashboard', 'delete');
        if($role_r == 0){
            // return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        
        $data['title'] = 'Dashboard | '.app_name;
        $data['page_active'] = 'dashboard';
        return view('dashboard', $data);
    }

    public function mail() {
        // $body['from'] = 'itcerebral@gmail.com';
        // $body['to'] = 'iyinusa@yahoo.co.uk';
        // $body['subject'] = 'Test Email';
        // $body['text'] = 'Sending test email via mailgun API';
        // echo $this->Crud->mailgun($body);
        $to = 'kennethjames23@yahoo.com, iyinusa@yahoo.co.uk';
        $subject = 'Test Email';
        $body = 'Sending test email from local email server';
        echo $this->Crud->send_email($to, $subject, $body);
    }
}
