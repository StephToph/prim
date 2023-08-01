<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index($param1='', $param2='', $para3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
        
        $mod = 'home';
        $data['title'] = ''.app_name;
        $data['page_active'] = $mod;
        return view('home/land', $data);
    }
    public function blog($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;

        $data['titles'] = $this->Crud->read_field('id', $param1, 'blog', 'title');
        $data['content'] = $this->Crud->read_field('id', $param1, 'blog', 'content');
        
        $author_id =  $this->Crud->read_field('id', $param1, 'blog', 'author');
        $data['author'] =  $this->Crud->read_field('id', $author_id, 'user', 'fullname');
        
        $image =  $this->Crud->read_field('id', $param1, 'blog', 'image');
        if(empty($image) || !file_exists($image)){
            $image = 'assets/blog.jpg';
        }
        $data['image'] =$image;
        $data['reg_date'] = $this->Crud->read_field('id', $param1, 'blog', 'reg_date');
        
        $mod = 'blog';
        $data['title'] = 'Blog - '.app_name;
        $data['page_active'] = $mod;
        return view('home/blog', $data);
    }


}
