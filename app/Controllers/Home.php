<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index($param1='', $param2='', $para3='') {
        // check login
        $log_id = $this->session->get('pr_id');

        $data['log_id'] = $log_id;
        $p_chat = array();
        
        $mod = 'home';
        $data['title'] = ''.app_name;
        $data['page_active'] = $mod;
        return view('home/land', $data);
    }


}
