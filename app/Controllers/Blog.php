<?php

namespace App\Controllers;

class Blog extends BaseController {
	private $db;

    public function __construct() {
		$this->db = \Config\Database::connect();
	}

    //// PARENTS
    public function index($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'blog', 'create');
        $role_r = $this->Crud->module($role_id, 'blog', 'read');
        $role_u = $this->Crud->module($role_id, 'blog', 'update');
        $role_d = $this->Crud->module($role_id, 'blog', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'blog';

		$form_link = site_url('blog/index/');
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
						$del_id = $this->request->getVar('d_blog_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							echo $this->Crud->msg('success', 'Blog Deleted');
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
								$data['e_title'] = $e->title;
								$data['e_status'] = $e->status;
								$data['e_img'] = $e->image;
								$data['e_content'] = $e->content;
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$blog_id = $this->request->getVar('blog_id');
					$title = $this->request->getVar('title');
					$content = $this->request->getVar('content');
					$status = $this->request->getVar('status');
					$img = $this->request->getVar('img');

                    /// upload image
                    if(file_exists($this->request->getFile('pics'))) {
                        $path = 'assets/backend/images/blogs/';
                        $file = $this->request->getFile('pics');
                        $getImg = $this->Crud->img_upload($path, $file);
                        $img = $getImg->path;
                    }

					$ins_data['title'] = $title;
					$ins_data['content'] = $content;
					$ins_data['status'] = $status;
					$ins_data['image'] = $img;
					
					
					$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
					
					// do create or update
					if ($blog_id) {
						$upd_rec = $this->Crud->updates('id', $blog_id, $table, $ins_data);
						if ($upd_rec > 0) {
							///// store activities
							$code = $this->Crud->read_field('id', $blog_id, $table, 'title');
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$action = $by.' updated Blog '.$code.' Record';
							$this->Crud->activity('blog', $blog_id, $action);

							echo $this->Crud->msg('success', 'Blog Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
						}
					} else {
						
						$ins_data['reg_date'] = date(fdate);
						$ins_data['author'] = $log_id;

						$user_id = $this->Crud->create('blog', $ins_data);
						if($user_id > 0) {
							///// store activities
							$action = $by.' created an Blog';
							$this->Crud->activity('blog', $blog_id, $action);

							echo $this->Crud->msg('success', 'Blog Created');
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
				$all_rec = $this->Crud->filter_blog('', '', $log_id, $search, $status, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_blog($limit, $offset, $log_id, $search, $status, $start_date, $end_date);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$title = $q->title;
						$content = $q->content;
						$author = $q->author;
						$status = $q->status;
						$author = $this->Crud->read_field('id', $author, 'user', 'fullname');
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));
						$a_img = $q->image;
						if(!empty($a_img)) $a_img = '<img alt="" class="img-fluid" src="'.site_url($a_img).'" style="max-width:100%;" />';

						$img = '<img alt="" class="img-fluid" src="'.site_url('assets/avatar.jpeg').'" style="max-width:100%;" />';

						if(empty($status) && $status == 0){
							$b = '<span class="text-success font-size-12">BLOG ACTIVE</span>';
						} else {
							$b = '<span class="text-danger font-size-12">BLOG DISABLED</span>';
						}
						
						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<div class="textright">
									<a href="javascript:;" class="text-info pop m-b-5 m-r-5" pageTitle="Edit '.$title.' Details" pageName="'.base_url('blog/index/manage/edit/'.$id).'" pageSize="modal-lg">
										<i class="anticon anticon-rollback"></i> EDIT
									</a>
									<a href="javascript:;" class="text-danger pop m-b-5 m-l-5  m-r-5" pageTitle="Delete '.$title.' Record" pageName="'.base_url('blog/index/manage/delete/'.$id).'" pageSize="modal-sm">
										<i class="anticon anticon-delete"></i> DELETE
									</a>
									
								</div>
							';
						}
						

						$item .= '
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-4">
												'.$a_img.'
											</div>
											<div class="col-md-8">
												<h4 class="m-b-10">'.$title.'</h4>
												<div class="d-flex align-items-center m-t-5 m-b-15">
													<div class="avatar avatar-image avatar-sm">
														'.$img.'
													</div>
													<div class="m-l-10">
														<span class="text-gray font-weight-semibold">'.$author.'</span>
														<span class="m-h-5 text-gray">|</span>
														<span class="text-gray">'.$reg_date.'</span><br>'.$b.'
													</div>
												</div>
												<p class="m-b-20">'.$content.'</p>
												<div class="text-right">
													'.$all_btn.'
												</div>
											</div>
										</div>
									</div>
								</div>
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = '
					<div class="text-center text-muted">
						<br/><br/><br/><br/>
						<i class="anticon anticon-book" style="font-size:150px;"></i><br/><br/>No Blog Returned
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
			return view('blog/manage_form', $data);
		} else { // view for main page
            $data['title'] = 'Blog | '.app_name;
            $data['page_active'] = 'blog';
            return view('blog/manage', $data);
        }
    }
 //// PARENTS
    public function faq($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, 'blog/faq', 'create');
        $role_r = $this->Crud->module($role_id, 'blog/faq', 'read');
        $role_u = $this->Crud->module($role_id, 'blog/faq', 'update');
        $role_d = $this->Crud->module($role_id, 'blog/faq', 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('dashboard'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        $table = 'faq';

		$form_link = site_url('blog/faq/');
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
						$del_id = $this->request->getVar('d_faq_id');
						if($this->Crud->deletes('id', $del_id, $table) > 0) {
							
							echo $this->Crud->msg('success', 'FAQ Deleted');
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
								$data['e_title'] = $e->title;
								$data['e_status'] = $e->status;
								$data['e_content'] = $e->content;
							}
						}
					}
				}

				if($this->request->getMethod() == 'post'){
					$faq_id = $this->request->getVar('faq_id');
					$title = $this->request->getVar('title');
					$content = $this->request->getVar('content');
					$status = $this->request->getVar('status');

					$ins_data['title'] = $title;
					$ins_data['content'] = $content;
					$ins_data['status'] = $status;
					
					
					
					$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
					
					// do create or update
					if ($faq_id) {
						$upd_rec = $this->Crud->updates('id', $faq_id, $table, $ins_data);
						if ($upd_rec > 0) {
							///// store activities
							$code = $this->Crud->read_field('id', $faq_id, $table, 'title');
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$action = $by.' updated FAQ '.$code.' Record';
							$this->Crud->activity('blog', $faq_id, $action);

							echo $this->Crud->msg('success', 'FAQ Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
						}
					} else {
						
						$ins_data['reg_date'] = date(fdate);

						$user_id = $this->Crud->create('faq', $ins_data);
						if($user_id > 0) {
							///// store activities
							$action = $by.' created FAQ';
							$this->Crud->activity('blog', $user_id, $action);

							echo $this->Crud->msg('success', 'FAQ Created');
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
				$all_rec = $this->Crud->filter_faq('', '', $log_id, $search, $status, $start_date, $end_date);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_faq($limit, $offset, $log_id, $search, $status, $start_date, $end_date);

				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$title = $q->title;
						$content = $q->content;
						$status = $q->status;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						if(empty($status) && $status == 0){
							$b = '<span class="text-success font-size-12">FAQ ACTIVE</span>';
						} else {
							$b = '<span class="text-danger font-size-12">FAQ DISABLED</span>';
						}
						
						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
								<div class="textright">
									<a href="javascript:;" class="text-info pop m-b-5 m-r-5" pageTitle="Edit '.$title.' Details" pageName="'.base_url('blog/faq/manage/edit/'.$id).'" pageSize="modal-lg">
										<i class="anticon anticon-rollback"></i> EDIT
									</a>
									<a href="javascript:;" class="text-danger pop m-b-5 m-l-5  m-r-5" pageTitle="Delete '.$title.' Record" pageName="'.base_url('blog/faq/manage/delete/'.$id).'" pageSize="modal-sm">
										<i class="anticon anticon-delete"></i> DELETE
									</a>
									
								</div>
							';
						}
						

						$item .= '
						<li class="list-group-item">
							<div class="row p-t-10">
								<div class="col-8 col-md-4 m-b-10">
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
						<i class="anticon anticon-folder" style="font-size:150px;"></i><br/><br/>No FAQ Returned
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
			return view('blog/faq_form', $data);
		} else { // view for main page
            $data['title'] = 'FAQs | '.app_name;
            $data['page_active'] = 'blog/faq';
            return view('blog/faq', $data);
        }
    }

	
}
