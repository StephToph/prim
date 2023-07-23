<?php

namespace App\Controllers;

class Accounts extends BaseController {

	//Fueling Station
	public function partner($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('fls_id') == ''){
			$request_uri = uri_string();
			$this->session->set('fls_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/partner';

        $log_id = $this->session->get('fls_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
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
						$del_id =  $this->request->getVar('d_partner_id');
                        $code = $this->Crud->read_field('id', $del_id, 'user', 'fullname');
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$action = $by.' deleted Administrator ('.$code.')';
							
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {

							///// store activities
							$this->Crud->activity('user', $del_id, $action);
							
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
								$data['e_fullname'] = $e->fullname;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_country_id'] = $e->country_id;
								$data['e_state_id'] = $e->state_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_address'] = $e->address;
								$data['e_ban'] = $e->activate;
								$data['e_img'] = $e->img_id;
								$data['e_logo'] = $e->logo;
								
							}
						}
					}
				}

				//profile view
				if($param2 == 'profile') {
					$vendor_id = $param3;
					$data['v_id'] = $vendor_id;
					$data['fullname'] = $this->Crud->read_field('id', $vendor_id, 'user', 'fullname');
					$data['v_phone'] = $this->Crud->read_field('id', $vendor_id, 'user', 'phone');
					$data['v_dob'] = $this->Crud->read_field('id', $vendor_id, 'user', 'dob');
					$data['reg_date'] = $this->Crud->read_field('id', $vendor_id, 'user', 'reg_date');
					$data['v_email'] = $this->Crud->read_field('id', $vendor_id, 'user', 'email');

					$v_img_id = $this->Crud->read_field('id', $vendor_id, 'user', 'img_id');
					$data['v_img'] = site_url($this->Crud->image($v_img_id, 'big'));

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
					$fullname =  $this->request->getVar('fullname');
					$email =  $this->request->getVar('email');
					$phone =  $this->request->getVar('phone');
					$country_id =  $this->request->getVar('country_id');
					$lga_id =  $this->request->getVar('lga');
					$state =  $this->request->getVar('state');
					$img =  $this->request->getVar('img');
					$password =  $this->request->getVar('password');
					$logo_id =  $this->request->getVar('logo');
					$address =  $this->request->getVar('address');
					$ban =  $this->request->getVar('ban');

					//// Image upload
					if(file_exists($this->request->getFile('pics'))) {
						$path = 'assets/backend/images/users/'.$log_id.'/';
						$file = $this->request->getFile('pics');
						$getImg = $this->Crud->img_upload($path, $file);
						
						if(!empty($getImg->path)) $img_id = $this->Crud->save_image($log_id, $getImg->path);
					} elseif(empty($img) && $img == 0){
						echo $this->Crud->msg('warning', 'Please Select Image');
						die;
					} else {
						$img_id = $img;
					}

					if(file_exists($this->request->getFile('logo'))) {
						$path = 'assets/backend/images/users/'.$log_id.'/';
						$file = $this->request->getFile('logo');
						$getImg = $this->Crud->img_upload($path, $file);
						
						if(!empty($getImg->path)) $logo = $this->Crud->save_image($log_id, $getImg->path);
					} elseif(empty($logo_id) && $logo_id == 0){
						echo $this->Crud->msg('warning', 'Please Select Logo');
						die;
					} else {
						$logo = $logo_id;
					}

					
					// do create or update
					if($user_i) {
						if($password) { $upd_data['password'] = md5($password); }
						$upd_data = array(
							'fullname' => $fullname,
							'email' => $email,
							'phone' => $phone,
							'address' => $address,
							'country_id' => $country_id,
							'state_id' => $state,
							'lga_id' => $lga_id,
							'activate' => $ban,
							'logo' => $logo,
							'img_id' => $img_id
							
						);
						$upd_rec = $this->Crud->updates('id', $user_i, $table, $upd_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $user_i, 'user', 'fullname');
							$action = $by.' updated Partner ('.$code.') Record';
							$this->Crud->activity('user', $user_i, $action);

							echo $this->Crud->msg('success', 'Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
                        die;
					} else {
						if($this->Crud->check2('fullname', $fullname, 'email', $email, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							if($password) { $ins_data['password'] = md5($password); }
							$ins_data = array(
								'fullname' => $fullname,
								'email' => $email,
								'phone' => $phone,
								'address' => $address,
								'country_id' => $country_id,
								'state_id' => $state,
								'lga_id' => $lga_id,
								'password' => md5($password),
								'role_id' => 3,
								'is_partner' => 1,
								'activate' => $ban,
								'reg_date' => date(fdate),
								'logo' => $logo,
								'img_id' => $img_id
							
							);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'user', 'fullname');
								$action = $by.' created Partner ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}

					}die;
						
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

			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">Fueling Station</span></div>
					<div class="nk-tb-col"><span class="sub-text">Contact</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">Address</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Date Joined</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Action</span></div>
				</div><!-- .nk-tb-item -->
				
			';

            //echo $status;
			$log_id = $this->session->get('fls_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_partner('', '', $log_id, $state_id, $status, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_partner($limit, $offset, $log_id, $state_id, $status, $search);
				$data['count'] = $counts;
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$address = $q->address;
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$img = $this->Crud->image($q->logo, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y', strtotime($q->reg_date));

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
									<li><a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$fullname.'" pageName="'.site_url($mod.'/manage/edit/'.$id).'">
										<i class="ni ni-edit-alt"></i> Edit
									</a></li>
									<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$fullname.'" pageName="'.site_url($mod.'/manage/delete/'.$id).'">
										<i class="ni ni-trash-alt"></i> Delete
									</a></li>
								</div>
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="'.site_url($img).'" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">'.ucwords($fullname).' <span class="dot dot-success d-md-none ms-1"></span></span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col	">
									<span class="text-dark"><b>'.$phone.'</b></span><br>
									<span>'.$email.'</span>
								</div>
								<div class="nk-tb-col tb-col-mb">
									<span>'.ucwords($address).'</span><br>
									<span class="tb-amount">'.$country.'</span><span class="text-info">'.$state.'&rarr; '.$city.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">'.$reg_date.'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														'.$all_btn.'
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>No Filling Station Returned
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
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
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = 'Fueling Station | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Customer
	public function customer($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('fls_id') == ''){
			$request_uri = uri_string();
			$this->session->set('fls_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/customer';

        $log_id = $this->session->get('fls_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
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
						$del_id =  $this->request->getVar('d_customer_id');
                        $code = $this->Crud->read_field('id', $del_id, 'user', 'fullname');
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$action = $by.' deleted Customer ('.$code.')';
							
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {

							///// store activities
							$this->Crud->activity('user', $del_id, $action);
							
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
								$data['e_fullname'] = $e->fullname;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_country_id'] = $e->country_id;
								$data['e_state_id'] = $e->state_id;
								$data['e_role_id'] = $e->role_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_address'] = $e->address;
								$data['e_ban'] = $e->activate;
								$data['e_img'] = $e->img_id;
								
							}
						}
					}
				}

				//profile view
				if($param2 == 'profile') {
					$vendor_id = $param3;
					$data['v_id'] = $vendor_id;
					$data['fullname'] = $this->Crud->read_field('id', $vendor_id, 'user', 'fullname');
					$data['v_phone'] = $this->Crud->read_field('id', $vendor_id, 'user', 'phone');
					$data['v_dob'] = $this->Crud->read_field('id', $vendor_id, 'user', 'dob');
					$data['reg_date'] = $this->Crud->read_field('id', $vendor_id, 'user', 'reg_date');
					$data['v_email'] = $this->Crud->read_field('id', $vendor_id, 'user', 'email');

					$v_img_id = $this->Crud->read_field('id', $vendor_id, 'user', 'img_id');
					$data['v_img'] = site_url($this->Crud->image($v_img_id, 'big'));

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
					$fullname =  $this->request->getVar('fullname');
					$email =  $this->request->getVar('email');
					$phone =  $this->request->getVar('phone');
					$country_id =  $this->request->getVar('country_id');
					$lga_id =  $this->request->getVar('lga');
					$state =  $this->request->getVar('state');
					$password =  $this->request->getVar('password');
					$address =  $this->request->getVar('address');
					$ban =  $this->request->getVar('ban');

					
					
					// do create or update
					if($user_i) {
						if($password) { $upd_data['password'] = md5($password); }
						$upd_data = array(
							'fullname' => $fullname,
							'email' => $email,
							'phone' => $phone,
							'address' => $address,
							'country_id' => $country_id,
							'state_id' => $state,
							'lga_id' => $lga_id,
							'activate' => $ban
							
						);
						$upd_rec = $this->Crud->updates('id', $user_i, $table, $upd_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $user_i, 'user', 'fullname');
							$action = $by.' updated Customer ('.$code.') Record';
							$this->Crud->activity('user', $user_i, $action);

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

			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">Fueling Station</span></div>
					<div class="nk-tb-col"><span class="sub-text">Contact</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">Address</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Date Joined</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Action</span></div>
				</div><!-- .nk-tb-item -->
				
			';

            //echo $status;
			$log_id = $this->session->get('fls_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_customer('', '', $log_id, $state_id, $status, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_customer($limit, $offset, $log_id, $state_id, $status, $search);
				$data['count'] = $counts;
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$address = $q->address;
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$img = $this->Crud->image($q->logo, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y', strtotime($q->reg_date));

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
									<li><a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$fullname.'" pageName="'.site_url($mod.'/manage/edit/'.$id).'">
										<i class="ni ni-edit-alt"></i> Edit
									</a></li>
									<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$fullname.'" pageName="'.site_url($mod.'/manage/delete/'.$id).'">
										<i class="ni ni-trash-alt"></i> Delete
									</a></li>
								</div>
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="'.site_url($img).'" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">'.ucwords($fullname).' <span class="dot dot-success d-md-none ms-1"></span></span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col	">
									<span class="text-dark"><b>'.$phone.'</b></span><br>
									<span>'.$email.'</span>
								</div>
								<div class="nk-tb-col tb-col-mb">
									<span>'.ucwords($address).'</span><br>
									<span class="tb-amount">'.$country.'</span><span class="text-info">'.$state.'&rarr; '.$city.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">'.$reg_date.'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														'.$all_btn.'
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>No Filling Station Returned
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
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
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = 'Customers | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Fueling Station Staff
	public function staff($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('fls_id') == ''){
			$request_uri = uri_string();
			$this->session->set('fls_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'accounts/staff';

        $log_id = $this->session->get('fls_id');
        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }
        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
       
		$table = 'user';
		$form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
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
						$del_id =  $this->request->getVar('d_staff_id');
                        $code = $this->Crud->read_field('id', $del_id, 'user', 'fullname');
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$action = $by.' deleted Staff ('.$code.')';
							
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {

							///// store activities
							$this->Crud->activity('user', $del_id, $action);
							
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
								$data['e_fullname'] = $e->fullname;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_country_id'] = $e->country_id;
								$data['e_state_id'] = $e->state_id;
								$data['e_lga_id'] = $e->lga_id;
								$data['e_branch_id'] = $e->branch_id;
								$data['e_role_id'] = $e->role_id;
								$data['e_address'] = $e->address;
								$data['e_ban'] = $e->activate;
								$data['e_img'] = $e->img_id;
								$data['e_logo'] = $e->logo;
								
							}
						}
					}
				}

				//profile view
				if($param2 == 'profile') {
					$vendor_id = $param3;
					$data['v_id'] = $vendor_id;
					$data['fullname'] = $this->Crud->read_field('id', $vendor_id, 'user', 'fullname');
					$data['v_phone'] = $this->Crud->read_field('id', $vendor_id, 'user', 'phone');
					$data['v_dob'] = $this->Crud->read_field('id', $vendor_id, 'user', 'dob');
					$data['reg_date'] = $this->Crud->read_field('id', $vendor_id, 'user', 'reg_date');
					$data['v_email'] = $this->Crud->read_field('id', $vendor_id, 'user', 'email');

					$v_img_id = $this->Crud->read_field('id', $vendor_id, 'user', 'img_id');
					$data['v_img'] = site_url($this->Crud->image($v_img_id, 'big'));

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
					$fullname =  $this->request->getVar('fullname');
					$email =  $this->request->getVar('email');
					$phone =  $this->request->getVar('phone');
					$country_id =  $this->request->getVar('country_id');
					$lga_id =  $this->request->getVar('lga');
					$state =  $this->request->getVar('state');
					$branch =  $this->request->getVar('branch');
					$password =  $this->request->getVar('password');
					$role =  $this->request->getVar('role');
					$ban =  $this->request->getVar('ban');
					$partner_id =  $this->Crud->read_field('id', $branch, 'branch', 'partner_id');
					
					
					// do create or update
					if($user_i) {
						if($password) { $upd_data['password'] = md5($password); }
						$upd_data = array(
							'fullname' => $fullname,
							'email' => $email,
							'phone' => $phone,
							'branch_id' => $branch,
							'country_id' => $country_id,
							'state_id' => $state,
							'lga_id' => $lga_id,
							'activate' => $ban,
							'role_id' => $role
							
						);
						$upd_rec = $this->Crud->updates('id', $user_i, $table, $upd_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $user_i, 'user', 'fullname');
							$action = $by.' updated Staff ('.$code.') Record';
							$this->Crud->activity('user', $user_i, $action);

							echo $this->Crud->msg('success', 'Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
                        die;
					} else {
						if($this->Crud->check2('fullname', $fullname, 'email', $email, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							if($password) { $ins_data['password'] = md5($password); }
							$ins_data = array(
								'fullname' => $fullname,
								'email' => $email,
								'phone' => $phone,
								'branch_id' => $branch,
								'country_id' => $country_id,
								'state_id' => $state,
								'partner_id' => $partner_id,
								'lga_id' => $lga_id,
								'password' => md5($password),
								'role_id' => $role,
								'is_staff' => 1,
								'activate' => $ban,
								'reg_date' => date(fdate)
							
							);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'user', 'fullname');
								$action = $by.' created Staff ('.$code.') Record';
								$this->Crud->activity('user', $ins_rec, $action);
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}

					}die;
						
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

			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">Fueling Station</span></div>
					<div class="nk-tb-col"><span class="sub-text">Contact</span></div>
					<div class="nk-tb-col tb-col-mb"><span class="sub-text">Address</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Date Joined</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Action</span></div>
				</div><!-- .nk-tb-item -->
				
			';

            //echo $status;
			$log_id = $this->session->get('fls_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_staff('', '', $log_id, $state_id, $status, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_staff($limit, $offset, $log_id, $state_id, $status, $search);
				$data['count'] = $counts;
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$fullname = $q->fullname;
						$email = $q->email;
						$phone = $q->phone;
						$address = $q->address;
						$state = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
						$country = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
						$city = $this->Crud->read_field('id', $q->lga_id, 'city', 'name');
						$img = $this->Crud->image($q->logo, 'big');
						$activate = $q->activate;
						$u_role = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
						$reg_date = date('M d, Y', strtotime($q->reg_date));

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
									<li><a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$fullname.'" pageName="'.site_url($mod.'/manage/edit/'.$id).'">
										<i class="ni ni-edit-alt"></i> Edit
									</a></li>
									<li><a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$fullname.'" pageName="'.site_url($mod.'/manage/delete/'.$id).'">
										<i class="ni ni-trash-alt"></i> Delete
									</a></li>
								</div>
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="'.site_url($img).'" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">'.ucwords($fullname).' <span class="dot dot-success d-md-none ms-1"></span></span>
										</div>
									</div>
								</div>
								<div class="nk-tb-col tb-col	">
									<span class="text-dark"><b>'.$phone.'</b></span><br>
									<span>'.$email.'</span>
								</div>
								<div class="nk-tb-col tb-col-mb">
									<span>'.ucwords($address).'</span><br>
									<span class="tb-amount">'.$country.'</span><span class="text-info">'.$state.'&rarr; '.$city.'</span>
								</div>
								<div class="nk-tb-col tb-col-md">
									<span class="tb-amount">'.$reg_date.'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-tools">
									<ul class="nk-tb-actions gx-1">
										<li>
											<div class="drodown">
												<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
												<div class="dropdown-menu dropdown-menu-end">
													<ul class="link-list-opt no-bdr">
														'.$all_btn.'
													</ul>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div><!-- .nk-tb-item -->
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="ni ni-users" style="font-size:150px;"></i><br/><br/>No Filling Station Returned
					</div>
				';
			} else {
				$resp['item'] = $items . $item;
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
			return view($mod.'_form', $data);
		} else { // view for main page
			
			$data['title'] = 'Staff | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	public function get_state($country){
		if(empty($country)){
			echo '<label for="activate">State</label>
			<input type="text" class="form-control" name="state" id="state" readonly placeholder="Select Country First">';
		} else {
			$state = $this->Crud->read_single_order('country_id', $country, 'state', 'name', 'asc');
			echo '<label for="activate">State</label>
				<select class="form-select js-select2" data-search="on" id="state" name="state" onchange="lgaa();">
					<option value="">Select</option>
			';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			echo '</select>
			<script> $(".js-select2").select2();</script>';
		}
	}

	public function get_lga($state){
		if(empty($state)){
			echo '<label for="activate">Local Goverment Area</label>
			<input type="text" class="form-control" name="lga" id="lga" readonly placeholder="Select State First">';
		} else {
			$state = $this->Crud->read_single_order('state_id', $state, 'city', 'name', 'asc');
			echo '<label for="activate">Local Goverment Area</label>
				<select class="form-select js-select2" data-search="on" id="lga" name="lga" onchange="branc();">
					<option value="">Select</option>
			';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			echo '</select>
			<script> $(".js-select2").select2();</script>';
		}
	}

	public function get_branch($state){
		if(empty($state)){
			echo '<label for="activate">Branch</label>
			<input type="text" class="form-control" name="branch" id="branch" readonly placeholder="Select LGA First">';
		} else {
			$state = $this->Crud->read_single_order('city_id', $state, 'branch', 'name', 'asc');
			echo '<label for="activate">Branch</label>
				<select class="form-select js-select2" data-search="on" id="branch" name="branch" onchange="load();">
					<option value="">Select</option>
			';
			foreach($state as $qr) {
				$hid = '';
				$sel = '';
				echo '<option value="'.$qr->id.'" '.$sel.'>'.$qr->name.'</option>';
			}
			echo '</select>
			<script> $(".js-select2").select2();</script>';
		}
	}

}
