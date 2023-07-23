<?php

namespace App\Controllers;

class Auth extends BaseController {
    public function index() {
        return $this->login();
    }

    ///// LOGIN
    public function login() {
        // check login
        $log_id = $this->session->get('ang_id');
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
                    $up_data['last_log'] = date(fdate);
                    $up_data['status'] = 1;
                    $this->Crud->updates('id', $user_id, 'user', $up_data);
					///// store activities
					$code = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
					$action = $code.' logged in from the Web on ';
					$this->Crud->activity('authentication', $user_id, $action);

                    echo $this->Crud->msg('success', 'Login Successful!');
                    $this->session->set('ang_id', $user_id);
                    echo '<script>window.location.replace("'.site_url('dashboard').'");</script>';
                }
            }

            die;
        }
        
        $data['title'] = 'Log In | '.app_name;
        return view('auth/login', $data);
    }

    ///// REGISTER//////////////////////////
    public function register() {
        if($this->request->getMethod() == 'post') {
            $fullname = $this->request->getPost('fullname');
            $email = $this->request->getPost('email');
            $user_role = $this->request->getPost('user_role');
            $password = $this->request->getPost('password');
            $confirm = $this->request->getPost('confirm');
            $agree = $this->request->getPost('agree');

            $Error = '';
			if($this->Crud->check('email', $email, 'user') > 0) {$Error .= 'Email Taken <br/>';}
			if($password != $confirm) {$Error .= 'Password Not Match';}
            if(empty($agree)) {$Error .= 'You must agree to Terms and Conditions';}

			if($Error) {
				echo $this->Crud->msg('danger', $Error);
				die;
			}

            $ins_data['fullname'] = $fullname;
			$ins_data['email'] = $email;
			$ins_data['role_id'] = $user_role;
			$ins_data['password'] = md5($password);
			$ins_data['reg_date'] = date(fdate);

			$ins_id = $this->Crud->create('user', $ins_data);
			if($ins_id > 0) {
				echo $this->Crud->msg('success', 'Record Created<br/>Please <a href="'.site_url('auth').'">Sign In</a> here');
				// echo '<script>location.reload(false);</script>';
			} else {
				echo $this->Crud->msg('danger', 'Please Try Again Later');
			}

			die;
        }
        
        $data['title'] = 'Register | '.app_name;
        return view('auth/register', $data);
    }

    /////////////Check if Email Exist////////////////////
    public function check_email() {
		$email = $this->request->getVar('email');
		if($email) {
			if($this->Crud->check('email', $email, 'user') <= 0) {
				echo '<span class="text-success small">Email Available</span>';
			} else {
				echo '<span class="text-danger small">Email Taken</span>';
			}
			die;
		}
	}

    //////////////Check if Password Matchs////////////////////////////
	public function check_password($param1 = '', $param2 = '') {
		if($param1 && $param2) {
			if($param1 == $param2) {
				echo '<span class="text-success small">Password Matched</span>';
			} else {
				echo '<span class="text-danger small">Password Not Matched</span>';
			}
			die;
		}
	}


    ///// LOGOUT
    public function logout() {
		$user_id = $this->session->get('ang_id');
		///// store activities
		$code = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
		$action = $code.' logged out';
		$this->Crud->activity('authentication', $user_id, $action);

        if(!empty($this->session->get('ang_id'))) $this->session->remove('ang_id');
		
        return redirect()->to(site_url('login'));
    }

    ////////////Profile////////////////////////////
    public function profile() {
        // check login
        $log_id = $this->session->get('ang_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $main_email = $this->Crud->read_field('id', $log_id, 'user', 'email');

        $data['log_id'] = $log_id;
        $data['role'] = $role;

        if($this->request->getMethod() == 'post') {
			$email = $this->request->getVar('email');
			$fullname = $this->request->getVar('fullname');
            $phone = $this->request->getVar('phone');
			$gender = $this->request->getVar('gender');
			$dob = $this->request->getVar('dob');
			$address = $this->request->getVar('address');
			$state_id = $this->request->getVar('state_id');
			$country_id = $this->request->getVar('country_id');
			$img_id = $this->request->getVar('img_id');

			if(!$email || !$fullname) {
				echo $this->Crud->msg('danger', 'Full Name and Email field(s) missing');
				die;
			}

			if($email != $main_email) {
				if($this->Crud->check('email', $email, 'user') > 0) {
					echo $this->Crud->msg('danger', 'Email already taken, try another');
					die;
				}
			}

            //// Image upload
			if(file_exists($this->request->getFile('pics'))) {
				$path = 'assets/backend/images/users/'.$log_id.'/';
				$file = $this->request->getFile('pics');
				$getImg = $this->Crud->img_upload($path, $file);
				
				if(!empty($getImg->path)) $img_id = $this->Crud->save_image($log_id, $getImg->path);
			}

			// update profile
			$upd_data['email'] = $email;
			$upd_data['fullname'] = $fullname;
            $upd_data['phone'] = $phone;
			$upd_data['sex'] = $gender;
			$upd_data['dob'] = $dob;
			$upd_data['address'] = $address;
			$upd_data['state_id'] = $state_id;
			$upd_data['country_id'] = $country_id;
			$upd_data['img_id'] = $img_id;
			if($this->Crud->updates('id', $log_id, 'user', $upd_data) > 0) {
				echo $this->Crud->msg('success', 'Record Updated');
			} else {
				echo $this->Crud->msg('info', 'No Changes');
			}

			die;
		}

		$data['email'] = $this->Crud->read_field('id', $log_id, 'user', 'email');
		$data['fullname'] = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
        $data['phone'] = $this->Crud->read_field('id', $log_id, 'user', 'phone');
		$data['sex'] = $this->Crud->read_field('id', $log_id, 'user', 'sex');
		$data['state_id'] = $this->Crud->read_field('id', $log_id, 'user', 'state_id');
		$data['country_id'] = $this->Crud->read_field('id', $log_id, 'user', 'country_id');
		$img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
		$data['img_id'] = $img_id;
		$data['img'] = $this->Crud->image($img_id, 'big');
        
        $data['title'] = 'Profile | '.app_name;
        $data['page_active'] = 'profile';
        return view('auth/profile', $data);

    }

	////////////Change Password////////////////////////////
	public function password() {
		// check login
        $log_id = $this->session->get('ang_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $data['log_id'] = $log_id;

		if($this->request->getMethod() == 'post') {
			$old = $this->request->getVar('old');
			$new = $this->request->getVar('new');
			$confirm = $this->request->getVar('confirm');

			if($this->Crud->check2('id', $log_id, 'password', md5($old), 'user') <= 0) {
				echo $this->Crud->msg('danger', 'Current Password not correct');
			} else {
				if($new != $confirm) {
					echo $this->Crud->msg('info', 'New and Confirm Password not matched');
				} else {
					if($this->Crud->updates('id', $log_id, 'user', array('password'=>md5($new))) > 0) {
						echo $this->Crud->msg('success', 'Password changed successfully');
					} else {
						echo $this->Crud->msg('danger', 'Please try later');
					}
				}
			}

			die;
		}

		$data['title'] =  'Change Password | '.app_name;
		$data['page_active'] = 'profile';

		return view('profile/password', $data);
	}

    /////////////Get state from Country////////////////////
    public function get_state($country_id) {
        $states = '';

		$state_id = $this->request->getGet('state_id');

		$all_states = $this->Crud->read_single_order('country_id', $country_id, 'state', 'name', 'asc');
		if(!empty($all_states)) {
			foreach($all_states as $as) {
				$s_sel = '';
				if(!empty($state_id)) if($state_id == $as->id) $s_sel = 'selected';
				$states .= '<option value="'.$as->id.'" '.$s_sel.'>'.$as->name.'</option>';
			}
		}

		echo $states;
		die;
	}

    //////////////////////Manage Users///////////////////////////
    public function users($param1='', $param2='', $param3='') {
        // check session login
		if($this->session->get('ang_id') == ''){
			$request_uri = uri_string();
			$this->session->set('kgf_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} else {
			$log_id = $this->session->get('ang_id');
			$role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
			$role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
            $role_c = $this->Crud->module($role_id, 'users', 'create');
			$role_r = $this->Crud->module($role_id, 'users', 'read');
			$role_u = $this->Crud->module($role_id, 'users', 'update');
			$role_d = $this->Crud->module($role_id, 'users', 'delete');
            if($role_r == 0){
				return redirect()->to(site_url('dashboard'));
			}
			$data['role'] = $role;
			$data['role_c'] = $role_c;
		}
		
		$table = 'user';

        $form_link = site_url('auth/users');
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		$data['user_id'] = $log_id;
        $data['role_id'] = $role_id;
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = $form_link;
		
        
        
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
                    //echo var_dump($edit);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($this->request->getMethod() == 'post'){
						$del_id =  $this->request->getVar('d_user_id');
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						die;	
					}
				}
			} else {
				// prepare for edit
				if($param2 == 'edit') {
					if($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_activate'] = $e->activate;
								$data['e_role_id'] = $e->role_id;

                                
							
							}
						}
					}
				}

				//profile view
				if($param2 == 'profile') {
					$vendor_id = $param3;
					$data['v_id'] = $vendor_id;
					$data['v_name'] = $this->Crud->read_field('id', $vendor_id, 'user', 'fullname');
					$data['v_phone'] = $this->Crud->read_field('id', $vendor_id, 'user', 'phone');
					$data['v_email'] = $this->Crud->read_field('id', $vendor_id, 'user', 'email');

					$v_img_id = $this->Crud->read_field('id', $vendor_id, 'user', 'img_id');
					$data['v_img'] = base_url($this->Crud->image($v_img_id, 'big'));

					$v_status = $this->Crud->read_field('id', $vendor_id, 'user', 'activate');
					if(!empty($v_status)) { $v_status = '<span class="text-success">VERIFIED</span>'; } else { $v_status = '<span class="text-danger">UNVERIFIED</span>'; }
					$data['v_status'] = $v_status;

					$data['v_address'] = $this->Crud->read_field('id', $vendor_id, 'user', 'address');

					$v_state_id = $this->Crud->read_field('id', $vendor_id, 'user', 'state_id');
					$data['v_state'] = $this->Crud->read_field('id', $v_state_id, 'state', 'name');

					$v_country_id = $this->Crud->read_field('id', $vendor_id, 'user', 'country_id');
					$data['v_country'] = $this->Crud->read_field('id', $v_country_id, 'country', 'name');
					
				}
				
				if($this->request->getMethod() == 'post'){
					$user_i =  $this->request->getVar('user_id');
					$activate =  $this->request->getVar('activate');
					$role_id =  $this->request->getVar('role_id');
					
					// do create or update
					if($user_i) {
						$upd_data = array(
							'activate' => $activate,
							'role_id' => $role_id
							
						);
						$upd_rec = $this->Crud->updates('id', $user_i, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
                        die;
					}
						
				}
			}
		}

        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';

			if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			if(!empty($this->request->getPost('state_id'))) { $state_id = $this->request->getPost('state_id'); } else { $state_id = ''; }
			if(!empty($this->request->getPost('status'))) { $status = $this->request->getPost('status'); } else { $status = ''; }
			$search = $this->request->getPost('search');

            //echo $search;
			$log_id = $this->session->get('ang_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_user('', '', $log_id, $state_id, $status, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_user($limit, $offset, $log_id, $state_id, $status, $search);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$address = $q->address;
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$img = $this->Crud->image($q->img_id, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						$approved = '';
						if($activate == 1) { 
							$color = 'success';
							$approve_text = 'Account Activated';
							$approved = '<span class="text-primary"><i class="ri-check-circle-line"></i></span> '; 
						} else {
							$color = 'danger';
							$approve_text = 'Account Deactivated';
						}

						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<div class="text-right">
									<a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$fullname.'" pageName="'.base_url('auth/users/manage/edit/'.$id).'">
										<i class="ri-ball-pen-line"></i> Edit
									</a><br/><br/>
									<a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$fullname.'" pageName="'.base_url('auth/users/manage/delete/'.$id).'">
										<i class="ri-delete-bin-4-line"></i> Delete
									</a>
								</div>
							';
						}

						$item .= '
							<li class="list-group-item">
								<div class="row pt-7">
									<div class="col-3 col-md-1">
										<img alt="" src="'.site_url($img).'" class="avatar-md rounded-circle img-thumbnail" />
									</div>
									<div class="col-9 col-sm-3 col-md-3 mb-2" >
										<div class="single">
											<div class="text-muted" style="font-size: 12px;">'.$reg_date.'</div>
											<b class="text-primary" style="font-size: 16px;"><a href="javascript:;" class="text-primary pop" pageTitle="'.$fullname.' Profile" pageName="'.base_url('auth/users/manage/profile/'.$id).'" pageSize="modal-lg">'.strtoupper($fullname).'</a>
											</b>
										</div>
									</div>
									<div class="col-12 col-sm-4 col-md-4 mb-1">
										<div class="text-muted font-size-12">'.strtoupper($u_role).'</div>
										<div class="font-size-14" style="font-size:14px">
											'.$email.'<br>
											<span class="text-danger font-size-12">'.$phone.'</span>
										</div>
									</div>
									
									<div class="col-12 col-sm-3 col-md-3 mb-1">
										<div class="font-size-14" style="font-size:14px">
											'.$address.'
											<div><b>'.$state.'</b></div>
										</div>
									</div>
									<div class="col-12 col-sm-1 col-md-1" align="right">
										<b class="font-size-12">'.$all_btn.'</b>
									</div>
								</div>
							</li>
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ri-team-line" style="font-size:150px;"></i><br/><br/>No User Returned
					</div>
				';
			} else {
				$resp['item'] = $item;
			}

			$resp['count'] = $counts;

			$more_record = $counts - ($offset + $rec_limit);
			$resp['left'] = $more_record;

			if($counts > ($offset + $rec_limit)) { // for load more records
				$resp['limit'] = $rec_limit;
				$resp['offset'] = $offset + $limit;
			} else {
				$resp['limit'] = 0;
				$resp['offset'] = 0;
			}

			echo json_encode($resp);
			die;
		}

        if($param1 == 'manage') { // view for form data posting
            $data['page_active'] = 'users';
			return view('auth/user_form', $data);
		} else { // view for main page
			// for datatable
			//$data['table_rec'] = 'auth/users/list'; // ajax table
			//$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			//$data['no_sort'] = '5,6'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Users | '.app_name;
			$data['page_active'] = 'users';
			
			return view('auth/user', $data);
		}
    }
}
