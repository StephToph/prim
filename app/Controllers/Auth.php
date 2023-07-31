<?php

namespace App\Controllers;

class Auth extends BaseController {
    public function index() {
        return $this->login();
    }

    ///// LOGIN
    public function login() {
        // check login
        $log_id = $this->session->get('plx_id');
        if(!empty($log_id)) return redirect()->to(site_url('dashboard'));

        if($this->request->getMethod() == 'post') {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            if(!$email || !$password) {
                echo $this->Crud->msg('danger', 'Please provide Email and Password');
            } else {
                // check user login detail
                $user_id = $this->Crud->read_field2('email', $email, 'password', md5($password), 'user', 'id');
                if(empty($user_id)) {
                    echo $this->Crud->msg('danger', 'Invalid Authentication!');
                } else {
                    ///// store activities
					$code = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
					$action = $code.' logged in from the Web ';
					$this->Crud->activity('authentication', $user_id, $action);

                    echo $this->Crud->msg('success', 'Login Successful!');
                    $this->session->set('plx_id', $user_id);
                    echo '<script>window.location.replace("'.site_url('dashboard').'");</script>';
                }
            }

            die;
        }
        
        $data['title'] = 'Log In | '.app_name;
        return view('auth/login', $data);
    }

    ///// LOGOUT
    public function logout() {
        if (!empty($this->session->get('plx_id'))) {
            $user_id = $this->session->get('plx_id');
            ///// store activities
            $code = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
            $action = $code . ' logged out';
            $this->Crud->activity('authentication', $user_id, $action);

            $this->session->remove('plx_id');
        }
        return redirect()->to(site_url());
    }
}
