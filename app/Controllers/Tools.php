<?php

namespace App\Controllers;

class Tools extends BaseController {
	private $db;

    public function __construct() {
		$this->db = \Config\Database::connect();
	}

    public function index() {
        //return $this->parents();
    }

    //// PARENTS
    public function subscribe($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'tools/subscribe', 'create');
        $role_r = $this->Crud->module($role_id, 'tools/subscribe', 'read');
        $role_u = $this->Crud->module($role_id, 'tools/subscribe', 'update');
        $role_d = $this->Crud->module($role_id, 'tools/subscribe', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'user';

		$form_link = site_url('tools/subscribe/');
		if($param1){$form_link .= $param1.'/';}
		if($param2){$form_link .= $param2.'/';}
		if($param3){$form_link .= $param3.'/';}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = rtrim($form_link, '/');
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_partner_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						exit;	
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
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_company'] = $e->company;
								$data['img_id'] = $e->img_id;
								$data['img'] = $this->Crud->image($e->img_id, 'big');
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$partner_id = $this->request->getVar('partner_id');
					$email = $this->request->getVar('email');
					$phone = $this->request->getVar('phone');
					$company = $this->request->getVar('company');
					$img_id = $this->request->getVar('img_id');

					//// Logo upload
					if(file_exists($this->request->getFile('pics'))) {
						$path = 'assets/images/users/'.$log_id.'/';
						$file = $this->request->getFile('pics');
						$getImg = $this->Crud->img_upload($path, $file);
						
						if(!empty($getImg->path)) $img_id = $this->Crud->save_image($log_id, $getImg->path);
					}

					if(!$company || !$email || !$img_id) {
						echo $this->Crud->msg('warning', 'Partner Name, Logo and Email are required');
						die;
					}

					$ins_data['firstname'] = $company;
					$ins_data['email'] = $email;
					$ins_data['phone'] = $phone;
					$ins_data['company'] = $company;
					$ins_data['img_id'] = $img_id;
					
					// do create or update
					if($partner_id) {
						// check if email changes
						$old_email = $this->Crud->read_field('id', $partner_id, $table, 'email');
						if($old_email == $email || $this->Crud->check('email', $email, $table) <= 0) {
							$upd_rec = $this->Crud->updates('id', $partner_id, $table, $ins_data);
							if($upd_rec > 0) {
								echo $this->Crud->msg('success', 'Record Updated');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('info', 'No Changes');	
							}
						} else {
							echo $this->Crud->msg('danger', 'Email taken! - Please use another');
						}
					} else {
						if($this->Crud->check('email', $email, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data['password'] = md5(123456);
							$ins_data['is_partner'] = 1;
							$ins_data['role_id'] = $this->Crud->read_field('name', 'Partner', 'access_role', 'id');
                            $ins_data['reg_date'] = date(fdate);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
				}
			}
		}

		if($param1 == 'history') {
		    $data['history_id'] = $param2;
		}


        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
			$counts = 0;

			if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			//if(!empty($this->input->post('state_id'))) { $state_id = $this->input->post('state_id'); } else { $state_id = ''; }
			if (!empty($this->request->getPost('start_date'))) {$start_date = $this->request->getPost('start_date');} else {$start_date = '';}
			if (!empty($this->request->getPost('end_date'))) {$end_date = $this->request->getPost('end_date');} else {$end_date = '';}
			if (!empty($this->request->getPost('payment'))) {$payment = $this->request->getPost('payment');} else {$payment = '';}
			if (!empty($this->request->getPost('sub_id'))) {$sub_id = $this->request->getPost('sub_id');} else {$sub_id = '';}
			

			$log_id = $this->session->get('plx_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_subscribe('', '', $log_id, $payment, $sub_id, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_subscribe($limit, $offset, $log_id, $payment, $sub_id, $start_date, $end_date);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$user_id = $q->user_id;
						$coupon_id = $q->coupon_id;
						$response = $q->response;
						$subscription = $this->Crud->read_field('id', $q->sub_id, 'subscription', 'name');

						$start_date = date('M d, Y', strtotime($q->start_date));
						$end_date = date('M d, Y', strtotime($q->end_date));
						

						// user 
						$user = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
						$user_role_id = $this->Crud->read_field('id', $user_id, 'user', 'role_id');
						$user_role = strtoupper($this->Crud->read_field('id', $user_role_id, 'access_role', 'name'));
						$user_image = $this->Crud->image(0, 'big');

						if ($coupon_id > 0) {
							$pay = 'Coupon';
							$coupon = $this->Crud->read_field('id', $coupon_id, 'coupon', 'code');
						}

						if(!empty($response)){
							$pay = 'Card';
							$coupon = '';
						}
						

						$item .= '
							<li class="list-group-item">
								<div class="row p-t-10">
									<div class="col-7 col-sm-2">
										<a href="javascript:;" class="pop" pageTitle="Subscription History" pageName="'.base_url('tools/subscribe/history/'.$user_id).'" pageSize="modal-lg">
										    <img alt="" src="'.base_url($user_image).'" class="p-1 avatar" />
											<div class="font-size-14">'.strtoupper($user).'</div>
									    </a>
									</div>
									<div class="col-8 col-md-2 m-b-10">
										<div class="single">
											<b class="font-size-16 text-primary">'.strtoupper($subscription).'</b>
										</div>
									</div>
									<div class="col-12 col-md-3 m-b-5">
										<div class="single">
											<div class=" font-size-14">Payment: <b>'.$pay.'</b></div>
											<div class="text-muted font-size-12">'.$coupon.'</div>
										</div>
									</div>
									<div class="col-12 col-md-4 m-b-5">
										<div class="single">
											<div class="text-muted font-size-12">Duration</div>
											<div class="font-size-14"><span class="text-success">'.$start_date.'</span> to <span class="text-danger">'.$end_date.'</span</div>
										</div>
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
						<i class="anticon anticon-team" style="font-size:150px;"></i><br/><br/>No Subscription History Returned
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

        if($param1 == 'manage' || $param1 == 'history') { // view for form data posting
			return view('tools/subscribe_form', $data);
		} else { // view for main page
            $data['title'] = 'Auto Subscribe | '.app_name;
            $data['page_active'] = 'tools/subscribe';
            return view('tools/subscribe', $data);
        }
    }

	// Subscription History
	public function history($id=0) {
	    if(empty($id)) { redirect(site_url('tools/subscribe')); }
	    
	    $items = '';
	    
	    $name = $this->Crud->read_field('id', $id, 'user', 'fullname');
	    $query = $this->Crud->read_single_order('user_id', $id, 'sub', 'id', 'asc');
	    if(!empty($query)) {
	        foreach($query as $q) {
	            $date = date('M d, Y h:iA', strtotime($q->start_date));
				$sub = $this->Crud->read_field('id', $q->sub_id, 'subscription', 'name');
				$amount = $this->Crud->read_field('id', $q->sub_id, 'subscription', 'amount');
	        
	            $items .= '
	                <tr>
	                    <td>'.$date.'</td>
	                    <td align="right">'.$sub.'</td>
						<td align="right">$'.$amount.'</td>
	                </tr>
	            ';
	        }
	    }
	    
	    echo '
	        <h3>'.$name.'Subscription History
	            <div style="font-size:small; color:#666;">as at '.date('M d, Y h:sA').'</div>
	        </h3>
	        <table class="table table-striped">
	            <thead>
	                <tr>
	                    <td><b>DATE</b></td>
	                    <td width="200px" align="right"><b>Plan</b></td>
	                    <td width="200px" align="right"><b>Amount</b></td>
	                </tr>
	            </thead>
	            <tbody>'.$items.'</tbody>
	        </table>
	        <hr/>
	    ';
	}

	//// CHILDREN
    public function children($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'accounts/children', 'create');
        $role_r = $this->Crud->module($role_id, 'accounts/children', 'read');
        $role_u = $this->Crud->module($role_id, 'accounts/children', 'update');
        $role_d = $this->Crud->module($role_id, 'accounts/children', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'child';

		$form_link = site_url('accounts/children/');
		if($param1){$form_link .= $param1.'/';}
		if($param2){$form_link .= $param2.'/';}
		if($param3){$form_link .= $param3.'/';}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = rtrim($form_link, '/');
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_partner_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						exit;	
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
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_company'] = $e->company;
								$data['img_id'] = $e->img_id;
								$data['img'] = $this->Crud->image($e->img_id, 'big');
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$partner_id = $this->request->getVar('partner_id');
					$email = $this->request->getVar('email');
					$phone = $this->request->getVar('phone');
					$company = $this->request->getVar('company');
					$img_id = $this->request->getVar('img_id');

					//// Logo upload
					if(file_exists($this->request->getFile('pics'))) {
						$path = 'assets/images/users/'.$log_id.'/';
						$file = $this->request->getFile('pics');
						$getImg = $this->Crud->img_upload($path, $file);
						
						if(!empty($getImg->path)) $img_id = $this->Crud->save_image($log_id, $getImg->path);
					}

					if(!$company || !$email || !$img_id) {
						echo $this->Crud->msg('warning', 'Partner Name, Logo and Email are required');
						die;
					}

					$ins_data['firstname'] = $company;
					$ins_data['email'] = $email;
					$ins_data['phone'] = $phone;
					$ins_data['company'] = $company;
					$ins_data['img_id'] = $img_id;
					
					// do create or update
					if($partner_id) {
						// check if email changes
						$old_email = $this->Crud->read_field('id', $partner_id, $table, 'email');
						if($old_email == $email || $this->Crud->check('email', $email, $table) <= 0) {
							$upd_rec = $this->Crud->updates('id', $partner_id, $table, $ins_data);
							if($upd_rec > 0) {
								echo $this->Crud->msg('success', 'Record Updated');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('info', 'No Changes');	
							}
						} else {
							echo $this->Crud->msg('danger', 'Email taken! - Please use another');
						}
					} else {
						if($this->Crud->check('email', $email, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data['password'] = md5(123456);
							$ins_data['is_partner'] = 1;
							$ins_data['role_id'] = $this->Crud->read_field('name', 'Partner', 'access_role', 'id');
                            $ins_data['reg_date'] = date(fdate);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}

					die;	
				}
			}
		}

        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
			$counts = 0;

			if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			if(!empty($this->request->getPost('age_id'))) { $ageID = $this->request->getPost('age_id'); } else { $ageID = ''; }
			if(!empty($this->request->getPost('parent_id'))) { $parentID = $this->request->getPost('parent_id'); } else { $parentID = ''; }
			$search = $this->request->getPost('search');

			$log_id = $this->session->get('plx_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_children('', '', $log_id, $ageID, $parentID, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); }
				$query = $this->Crud->filter_children($limit, $offset, $log_id, $ageID, $parentID, $search);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$name = $q->name;
						$avatar = $q->avatar;
						$age = $this->Crud->read_field('id', $q->age_id, 'age', 'name');
						$parent = $this->Crud->read_field('id', $q->parent_id, 'user', 'fullname');
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						// count children
						// $children = $this->db->table('child')->where('parent_id', $q->id)->countAllResults();
						
						// add manage buttons
						$all_btn = '';
						if($role_u != 1) {
							$all_btn = '';
						} else {
							
						}

						$item .= '
							<li class="list-group-item">
								<div class="row p-t-10">
									<div class="col-2 col-sm-1">
										<img alt="" src="'.site_url($avatar).'" class="p-1 avatar" />
									</div>
									<div class="col-10 col-md-6 m-b-10">
										<div class="single">
											<b class="font-size-16 text-primary">'.$name.'</b>
											<div class="small text-muted">'.$parent.'</div>
										</div>
									</div>
									<div class="col-12 col-md-5 m-b-5">
										<div class="text-muted font-size-12">AGE</div>
										<div class="font-size-14">
											'.$age.'
										</div>
									</div>
									<div class="col-12 col-md-1">
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
						<i class="anticon anticon-team" style="font-size:150px;"></i><br/><br/>No Children Returned
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

		$data['parents'] = $this->Crud->read_single_order('role_id', 3, 'user', 'fullname', 'ASC');
		$data['ages'] = $this->Crud->read_order('age', 'id', 'ASC');

        if($param1 == 'manage') { // view for form data posting
			return view('account/children_form', $data);
		} else { // view for main page
            $data['title'] = 'Children | '.app_name;
            $data['page_active'] = 'accounts/children';
            return view('account/children', $data);
        }
    }

	/////// ACTIVITIES
	public function activity($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('plx_id') == ''){
			$request_uri = uri_string();
			$this->session->set('fls_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'tools/activity';

        $log_id = $this->session->get('plx_id');
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
		
       $table = 'activity';

        $form_link = site_url($mod);
		if($param1){$form_link .= '/'.$param1;}
		if($param2){$form_link .= '/'.$param2.'/';}
		if($param3){$form_link .= $param3;}
		
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = $form_link;
		
		
		// record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$count = 0;
			$rec_limit = 25;
			$item = '';

			if($limit == '') {$limit = $rec_limit;}
			if($offset == '') {$offset = 0;}
			
			$search = $this->request->getVar('search');
			if(!empty($this->request->getPost('start_date'))) { $start_date = $this->request->getPost('start_date'); } else { $start_date = ''; }
			if(!empty($this->request->getPost('end_date'))) { $end_date = $this->request->getPost('end_date'); } else { $end_date = ''; }
			
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$query = $this->Crud->filter_activity($limit, $offset, $log_id, $search, $start_date, $end_date);
				$all_rec = $this->Crud->filter_activity('', '', $log_id, $search, $start_date, $end_date);
				if(!empty($all_rec)) { $count = count($all_rec); } else { $count = 0; }

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$type = $q->item;
						$type_id = $q->item_id;
						$action = $q->action;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						$timespan = $this->Crud->timespan(strtotime($q->reg_date));

						$icon = 'solution';
						if($type == 'authentication') $icon = 'lock';
						if($type == 'setup') $icon = 'tool';
						if($type == 'account') $icon = 'team';
						if($type == 'tools') $icon = 'team';
						if($type == 'coupon') $icon = 'reconciliation';

						$item .= '
							<li class="list-group-item">
								<div class="row p-t-10 align-items-center">
									<div class="col-1 text-center">
										<i class="anticon anticon-'.$icon.' text-muted" style="font-size:50px;"></i>
									</div>
									<div class="col-11">
										'.$action.' <small>on '.$reg_date.'</small>
										<div class="text-muted small text-right">'.$timespan.'</div>
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
						<i class="anticon anticon-solution" style="font-size:150px;"></i><br/><br/>No Activities Returned
					</div>
				';
			} else {
				$resp['item'] = $item;
			}

			$more_record = $count - ($offset + $rec_limit);
			$resp['left'] = $more_record;

			if($count > ($offset + $rec_limit)) { // for load more records
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
			
			$data['title'] = 'Activity | '.app_name;
			$data['page_active'] = $mod;

			return view($mod, $data);
		}
	
	}

	//// ANNOUNCEMENT
    public function announcement($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'tools/announcement', 'create');
        $role_r = $this->Crud->module($role_id, 'tools/announcement', 'read');
        $role_u = $this->Crud->module($role_id, 'tools/announcement', 'update');
        $role_d = $this->Crud->module($role_id, 'tools/announcement', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'announcement';

		$form_link = site_url('tools/announcement/');
		if($param1){$form_link .= $param1.'/';}
		if($param2){$form_link .= $param2.'/';}
		if($param3){$form_link .= $param3.'/';}
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['form_link'] = rtrim($form_link, '/');
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if($this->request->getMethod() == 'post'){
						$del_id = $this->request->getVar('d_announcement_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						exit;	
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
								$data['e_to_id'] = $e->to_id;
								$data['e_role_id'] = $e->role_id;
								$data['e_from_id'] = $e->from_id;
								$data['e_title'] = $e->title;
								$data['e_type'] = $e->type;
								$data['e_content'] = $e->content;
							}
						}
					}
				}

				if($param2 == 'view') {
					if($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_role_id'] = $e->role_id;
								$data['e_to_id'] = $e->to_id;
								$data['e_from_id'] = $e->from_id;
								$data['e_title'] = $e->title;
								$data['e_type'] = $e->type;
								$data['e_content'] = $e->content;
								$data['e_reg_date'] = date('M d, Y h:i A', strtotime($e->reg_date));
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$announcement_id = $this->request->getVar('announcement_id');
					$title = $this->request->getVar('title');
					$content = $this->request->getVar('content');
					$type = $this->request->getVar('type');
					$parent = $this->request->getVar('parent');

					if (!empty($parent) && $type == 1) {
						$p = json_encode($parent);
						$ins_data['to_id'] = $p;

					} else {
						$parent = array();
						$pa = $this->Crud->read_single('role_id', 3, 'user');
						foreach($pa as $par){
							$parent[] = $par->id;
						}
						$p = json_encode($parent);
						$ins_data['to_id'] = $p;
					}


					$ins_data['title'] = $title;
					$ins_data['type'] = $type;
					$ins_data['role_id'] = 3;
					$ins_data['content'] = $content;
					
					// do create or update
					if ($announcement_id) {
						$upd_rec = $this->Crud->updates('id', $announcement_id, $table, $ins_data);
						if ($upd_rec > 0) {
							foreach(json_decode($p) as $re => $val){
								$in_data['from_id'] = $log_id;
								$in_data['to_id'] = $val;
								$in_data['content'] = $title;
								$in_data['item'] = 'announcement';
								$in_data['new'] = 1;
								$in_data['reg_date'] = date(fdate);
								$in_data['item_id'] = $announcement_id;
								$this->Crud->create('notify', $in_data);
							}
							///// store activities
							$code = $this->Crud->read_field('id', $announcement_id, $table, 'title');
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$action = $by.' updated Announcement '.$code.' Record';
							$this->Crud->activity('tools', $announcement_id, $action);

							echo $this->Crud->msg('success', 'Announcement Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
						}
					} else {
						if($this->Crud->check('id', $announcement_id, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
                            $ins_data['reg_date'] = date(fdate);
                            $ins_data['from_id'] = $log_id;
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
                                echo $this->Crud->msg('success', 'Announcement Created');
								foreach(json_decode($p) as $re => $val){
									$in_data['from_id'] = $log_id;
									$in_data['to_id'] = $val;
									$in_data['content'] = $content;
									$in_data['item'] = 'announcement';
									$in_data['new'] = 1;
									$in_data['reg_date'] = date(fdate);
									$in_data['item_id'] = $ins_rec;
									$this->Crud->create('notify', $in_data);
								}
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'announcement', 'title');
								$action = $by.' created ('.$code.') Announcement ';
								$this->Crud->activity('announcement', $ins_rec, $action);
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}
					die;	
				}
			}
		}

        // record listing
		if($param1 == 'load') {
			$limit = $param2;
			$offset = $param3;

			$rec_limit = 25;
			$item = '';
			$counts = 0;

			if(empty($limit)) {$limit = $rec_limit;}
			if(empty($offset)) {$offset = 0;}
			
			$search = $this->request->getPost('search');
			$log_id = $this->session->get('plx_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$query = $this->Crud->filter_announcement($limit, $offset, $log_id, $search);
				$all_rec = $this->Crud->filter_announcement('', '', $log_id, $search);
				if(!empty($all_rec)) { $count = count($all_rec); } else { $count = 0; }

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$title = $q->title;
						$content = $q->content;
						$to_id = $q->to_id;
						$team = $q->role_id;
						$type = $q->type;
						$user_i = $q->from_id;
						
                        $reg_date = date('M d, Y h:i A', strtotime($q->reg_date));
                        $user = $this->Crud->read_field('id', $user_i, 'user', 'fullname');
                                
                        $teams = '';
						if($role == 'developer' || $role == 'administrator' || $user_i == $log_id){
							if($type == 0){
								$teams .= '<span class="badge badge-pill badge-green mb-1">'.strtoupper('All parents').'</span>';
								
							} else {
								$teams .= '<span class="badge badge-pill badge-green mb-1">'.strtoupper('Selected parents').'</span>';
								
							}
						}
                        // add manage buttons
                        if($role_u != 1) {
                            $all_btn = '';
                        } else {
							$all_btn = '
                                    <a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$title.'" pageName="'.base_url('tools/announcement/manage/edit/'.$id).'" pageSize="modal-lg">
                                        <i class="anticon anticon-edit"></i> Edit
                                    </a> ||  
                                    <a href="javascript:;" class="text-success pop" pageTitle="View '.$title.'" pageName="'.base_url('tools/announcement/manage/view/'.$id).'" pageSize="modal-lg">
                                        <i class="anticon anticon-eye"></i> View
                                    </a>
                                    
                            ';
							
                            
                        }

                        if($role == 'developer' || $role == 'administrator'){
                            $item .= '
                                <tr>
                                    <td>
                                        <div class="media align-items-center">
                                            <div class="m-l-10">
                                                <span class="text-muted small">'.$reg_date.'</span><br>
                                                <h5 class="m-b-0">'.ucwords($title).'</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <div class="d-flex align-items-center">
                                            <div>
                                                '.$teams.'
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            '.$user.'
                                        </div>
                                    </td>
                                    <td width="150px" class="text-right">
                                        '.$all_btn.'
                                    </td>
                                </tr>
                                
                            ';
                        } else {
                            if($user_i == $log_id){
                                $item .= '
                                    <tr>
                                        <td>
                                            <div class="media align-items-center">
                                                <div class="m-l-10">
                                                    <span class="text-muted small">'.$reg_date.'</span><br>
                                                    <h5 class="m-b-0">'.ucwords($title).'</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    '.$teams.'
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                '.$user.'
                                            </div>
                                        </td>
                                        <td width="150px" class="text-right">
                                            '.$all_btn.'
                                        </td>
                                    </tr>
                                    
                                ';
                            } else {
                                if(!empty($team)){
                                    if(in_array($log_id, json_decode($to_id), true)){
                                        $item .= '
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <div class="m-l-10">
                                                            <span class="text-muted small">'.$reg_date.'</span><br>
                                                            <h5 class="m-b-0">'.ucwords($title).'</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            '.$teams.'
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        '.$user.'
                                                    </div>
                                                </td>
                                                <td width="150px" class="text-right">
                                                    '.$all_btn.'
                                                </td>
                                            </tr>
                                            
                                        ';
                                    }
                                }
                            }
                        }
                        
					}
				}
			}
			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted col-sm-12">
						<br/><br/><br/><br/>
						<i class="anticon anticon-notification" style="font-size:120px;"></i><br/><br/>No Announcements Returned
					</div>
				';
			} else {
				$resp['item'] = $item;
			}

			$more_record = $count - ($offset + $rec_limit);
			$resp['left'] = $more_record;

			if($count > ($offset + $rec_limit)) { // for load more records
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
			return view('tools/announcement_form', $data);
		} else { // view for main page
            $data['title'] = 'Announcement | '.app_name;
            $data['page_active'] = 'tools/announcement';
            return view('tools/announcement', $data);
        }
    }

	public function sub_update(){
		$sub = $this->Crud->read('sub');
		if(!empty($sub)){
			foreach($sub as $s){
				$id = $s->id;
				$this->Crud->updates('id', $id, 'sub', array('reg_date'=> $s->start_date));
			}
		}
	}
}
