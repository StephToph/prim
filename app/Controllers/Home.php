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
    public function apply($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;
       
        if($param1 == 'transact'){
			/////// CHACK PAYMENT RESPONSE //////
			$ref = $this->request->getPost('ref');
			$trans = $this->request->getPost('trans');
			$status = $this->request->getPost('status');
            
			if($ref && $trans && $status) {
				if($status == 'success') {
					// run order script
					// echo '<script>setTimeout(function(){ icon(); }, 1000);</script>';
					$log_id = $this->session->get('plx_pay_id');

					$up = $this->Crud->updates('id', $log_id, 'user', array('pay_status'=>1));
                    // echo $up;
                    if($up > 0){
                        echo $this->Crud->msg('success', 'Application Payment Successful!');
                        echo '<script>window.location.replace("'.site_url('home/application').'");</script>';
                    }
					
				}
			}
			////////////////////////////////////
			die;
		}

        if($this->request->getMethod() == 'post'){
            $firstname = $this->request->getPost('firstname');
            $lastname = $this->request->getPost('lastname');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $password = $this->request->getPost('password');
            $confirm = $this->request->getPost('confirm');
            $amount = 1000000;
            echo $this->Crud->rave_inline('',$email, $amount);

            if($this->Crud->check('email', $email, 'user') > 0 || $this->Crud->check('phone', $phone, 'user') > 0){
                if($this->Crud->check2('pay_status', 1, 'email', $email, 'user') > 0){
                    $id = $this->Crud->read_field('email', $email, 'user', 'id');
                    $this->session->set('plx_pay_id', $id);
                    echo '<script>window.location.replace("'.site_url('home/application').'");</script>';
                } else {
                    echo $this->Crud->msg('danger', 'Email Already Exist');
                }
               
            } else{
                if($password != $confirm){
                    echo $this->Crud->msg('danger', 'Passwords dont Match. Try Again');
                } else {
                    $name = $lastname.' '.$firstname;
                    $ins['fullname'] = $name;
                    $ins['email'] = $email;
                    $ins['phone'] = $phone;
                    $ins['password'] = md5($password);
                    $ins['role_id'] = $this->Crud->read_field('name', 'Student', 'access_role', 'id');
                    $ins_res = $this->Crud->create('user', $ins);
                    $this->session->set('plx_pay_id', $ins_res);
                    if($ins_res > 0){
                        echo '<script>payWithPaystack();</script>';
                    } else{
                        echo $this->Crud->msg('danger', 'Try Again Later');
                    }
                }
            }
            die;
        }
        $mod = 'apply';
        $data['title'] = 'Apply - '.app_name;
        $data['page_active'] = $mod;
        return view('home/apply', $data);
    }

    public function application($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_pay_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;
       
        if($this->request->getMethod() == 'post'){
            $school_id = $this->request->getPost('school_id');
            $gender = $this->request->getPost('gender');
            $dept_id = $this->request->getPost('dept_id');
            $dob = $this->request->getPost('dob');
            $passport = '';
            $result = '';

            /// upload image
            if(file_exists($this->request->getFile('pics'))) {
                $path = 'assets/backend/images/application/';
                $file = $this->request->getFile('pics');
                $getImg = $this->Crud->img_upload($path, $file);
                $passport = $getImg->path;
            }

             /// upload result
             if(file_exists($this->request->getFile('result'))) {
                $path = 'assets/backend/images/application/';
                $file = $this->request->getFile('result');
                $getImg = $this->Crud->file_upload($path, $file);
                $result = $getImg->path;
            }

            if(empty($passport) || empty($result)){
                echo $this->Crud->msg('danger', 'Please Upload Passport and Waec Result');
                die;
            }
            if($this->Crud->check('user_id', $log_id, 'application') == 0){
                echo $this->Crud->msg('danger', 'Email Already Exist');
            } else{
                
                $ins['school_id'] = $school_id;
                $ins['gender'] = $gender;
                $ins['dob'] = $dob;
                $ins['user_id'] = $log_id;
                $ins['department'] = $dept_id;
                $ins['result'] = $result;
                $ins['passport'] = $passport;
                $ins['reg_date'] = date(fdate);
                $ins_res = $this->Crud->create('application', $ins);
                if($ins_res > 0){
                    ///// store activities
                    $by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
                    $action = $by.' Completed Applications';
                    $this->Crud->activity('application', $ins_res, $action);
                    $email = 'tofunmi015@gmail.com';
                    $name = 'Admin';
                    //Send to Email
                    // Headers
                    

                    $to = 'tophsteve@gmail.com';
                    $subject = 'Admission Application';
                    $body = 'teste';
                    $mailSent = $this->Crud->send_email($to, $subject, $body);

                    if($mailSent > 0) {
                        // unlink(base_url($img));
                        echo $this->Crud->msg('success', 'The email message was sent.');
                    } else {
                        echo $this->Crud->msg('danger', 'The email message was not sent.<br>Try again Later!');
                    }

                    echo $this->Crud->msg('success', 'Application Submitted');
                    // echo '<script>location.reload(false);</script>';
                } else{
                    echo $this->Crud->msg('danger', 'Try Again Later');
                }
            
            }
            die;
        }
        $mod = 'application';
        $data['title'] = 'Application - '.app_name;
        $data['page_active'] = $mod;
        return view('home/application', $data);
    }

    function sends(){
        $to = 'tofunmi015@gmail.com';
        $subject = 'Test Email';
        $message = 'This is a test email sent from PHP.';
        $headers = 'From: your_email@example.com';

        if (mail($to, $subject, $message, $headers)) {
            echo 'Email sent successfully.';
        } else {
            echo 'Failed to send email.';
        }

        if (!mail($to, $subject, $message, $headers)) {
            $lastError = error_get_last(); 
            var_dump($lastError);
            echo 'Failed to send email. Error: ';
        }
    }
}
