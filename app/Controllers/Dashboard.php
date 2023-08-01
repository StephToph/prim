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

    public function school($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'dashboard/school', 'create');
        $role_r = $this->Crud->module($role_id, 'dashboard/school', 'read');
        $role_u = $this->Crud->module($role_id, 'dashboard/school', 'update');
        $role_d = $this->Crud->module($role_id, 'dashboard/school', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'school';

		$form_link = site_url('dashboard/school/');
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
						$del_id = $this->request->getVar('d_school_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							echo $this->Crud->msg('success', 'School Deleted');
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
								$data['e_name'] = $e->name;
								$data['e_description'] = $e->description;
								$data['e_img'] = $e->logo;
								$data['e_status'] = $e->scholarship_status;
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$school_id = $this->request->getVar('school_id');
					$name = $this->request->getVar('name');
					$description = $this->request->getVar('description');
					$status = $this->request->getVar('status');
                    $img = $this->request->getVar('img');

                    /// upload image
                    if(file_exists($this->request->getFile('pics'))) {
                        $path = 'assets/backend/images/blogs/';
                        $file = $this->request->getFile('pics');
                        $getImg = $this->Crud->img_upload($path, $file);
                        $img = $getImg->path;
                    }

					$ins_data['name'] = $name;
					$ins_data['description'] = $description;
					$ins_data['scholarship_status'] = $status;
					$ins_data['logo'] = $img;
					
					
					$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
					
					// do create or update
					if ($school_id) {
						$upd_rec = $this->Crud->updates('id', $school_id, $table, $ins_data);
						if ($upd_rec > 0) {
							///// store activities
							$code = $this->Crud->read_field('id', $school_id, $table, 'name');
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$action = $by.' updated School '.$code.' Record';
							$this->Crud->activity('school', $school_id, $action);

							echo $this->Crud->msg('success', 'School Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
						}
					} else {
						
						$ins_data['reg_date'] = date(fdate);

						$user_id = $this->Crud->create('school', $ins_data);
						if($user_id > 0) {
							///// store activities
							$action = $by.' created School';
							$this->Crud->activity('school', $user_id, $action);

							echo $this->Crud->msg('success', 'School Created');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
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
			
			if(!empty($this->request->getPost('status'))) { $status = $this->request->getPost('status'); } else { $status = ''; }
			$search = $this->request->getPost('search');
			if (!empty($this->request->getPost('start_date'))) {$start_date = $this->request->getPost('start_date');} else {$start_date = '';}
			if (!empty($this->request->getPost('end_date'))) {$end_date = $this->request->getPost('end_date');} else {$end_date = '';}
			$log_id = $this->session->get('plx_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_school('', '', $log_id, $search, $status, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_school($limit, $offset, $log_id, $search, $status, $start_date, $end_date);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$title = $q->name;
						$content = $q->description;
						$status = $q->scholarship_status;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));
                        $a_img = $q->logo;
						if(!empty($a_img)) $a_img = '<img alt="" class="img-fluid" src="'.site_url($a_img).'" style="max-width:100%;" />';

						if(empty($status) && $status == 0){
							$b = '<span class="text-success font-size-12">SCHOLARSHIP ACTIVE</span>';
						} else {
							$b = '<span class="text-danger font-size-12">SCHOLARSHIP DISABLED</span>';
						}
						
						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<div class="textright">
									<a href="javascript:;" class="text-info pop m-b-5 m-r-5" pageTitle="Edit '.$title.' Details" pageName="'.base_url('dashboard/school/manage/edit/'.$id).'" pageSize="modal-lg">
										<i class="anticon anticon-rollback"></i> EDIT
									</a>
									<a href="javascript:;" class="text-danger pop m-b-5 m-l-5  m-r-5" pageTitle="Delete '.$title.' Record" pageName="'.base_url('dashboard/school/manage/delete/'.$id).'" pageSize="modal-sm">
										<i class="anticon anticon-delete"></i> DELETE
									</a>
									
								</div>
							';
						}
						

						$item .= '
						<li class="list-group-item">
							<div class="row p-t-10">
								<div class="col-3 col-md-1 m-b-10">
									<div class="single">
										'.$a_img.'
									</div>
								</div>
								<div class="col-8 col-md-3 m-b-10">
									<div class="single">
										<small>'.$reg_date.'</small><br>
										<b class="font-size-16 text-primary">'.strtoupper($title).'</b>
									</div>
								</div>
								<div class="col-12 col-md-6 m-b-5">
									<div class="single">
										<div class=" font-size-14"><b>'.$b.'</b></div>
										<div class="text-muted font-size-12">'.$content.'</div>
									</div>
								</div>
								<div class="col-12 col-md-2 m-b-5">
									<div class="single">
										<div class="text-muted font-size-14">'.$all_btn.'</div>
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
						<i class="anticon anticon-shop" style="font-size:150px;"></i><br/><br/>No School Returned
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
			return view('setup/school_form', $data);
		} else { // view for main page
            $data['title'] = 'Schools - '.app_name;
            $data['page_active'] = 'dashboard/school';
            return view('setup/school', $data);
        }
    }
}
