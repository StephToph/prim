<?php

namespace App\Controllers;

class Rhapsody extends BaseController {
    //Rhapsody of Reality
	public function list($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('ang_id') == ''){
			$request_uri = uri_string();
			$this->session->set('ang_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'rhapsody/list';

        $log_id = $this->session->get('ang_id');
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
       
		$table = 'rhapsody';
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
						$del_id =  $this->request->getVar('d_rhapsody_id');
                        $code = $this->Crud->read_field('id', $del_id, 'rhapsody', 'title');
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$action = $by.' deleted Rhapsody of Reality ('.ucwords($code).')';
							
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {

							///// store activities
							$this->Crud->activity('rhapsody', $del_id, $action);
							
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
								$data['e_title'] = $e->title;
								$data['e_content'] = $e->content;
								$data['e_language'] = $e->language;
								$data['e_date'] = $e->date;
								$data['e_featured_image'] = $e->featured_image;
								
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
								$data['e_title'] = $e->title;
								$data['e_content'] = $e->content;
								$data['e_language'] = $e->language;
								$data['e_date'] = $e->date;
								$data['e_featured_image'] = $e->featured_image;
								
							}
						}
					}
				}

				
				if($this->request->getMethod() == 'post'){
					$rhapsody_id =  $this->request->getVar('rhapsody_id');
					$title =  $this->request->getVar('title');
					$content =  $this->request->getVar('content');
					$date =  $this->request->getVar('dates');
					$language =  $this->request->getVar('language');
					$featured_image =  $this->request->getVar('featured_image');
					
					 //// Image upload
					 if(file_exists($this->request->getFile('pics'))) {
						$path = 'assets/backend/images/users/'.$log_id.'/';
						$file = $this->request->getFile('pics');
						$getImg = $this->Crud->img_upload($path, $file);
						
						if(!empty($getImg->path)) $img_id = $getImg->path;
					}
					$ins_data['title'] = $title;
					$ins_data['content'] = $content;
					$ins_data['date'] = $date;
					$ins_data['language'] = $language;
					if(!empty($img_id) || !empty($getImg->path))$ins_data['featured_image'] = $img_id;
					$lang = $this->Crud->read_field('id', $language, 'language', 'name');	
					// do create or update
					if($rhapsody_id) {
						
						$upd_rec = $this->Crud->updates('id', $rhapsody_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $rhapsody_id, 'rhapsody', 'title');
							$action = $by.' updated Rhapsody of Reality titled ('.ucwords($code).') with '.ucwords($lang).' Record';
							$this->Crud->activity('rhapsody', $rhapsody_id, $action);

							echo $this->Crud->msg('success', 'Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
                        die;
					} else {
						if($this->Crud->check2('title', $title, 'date', $date, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data['reg_date'] = date(fdate);
							
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'rhapsody', 'title');
								$action = $by.' created Rhapsody of Reality titled ('.ucwords($code).') with '.ucwords($lang).' Record';
								$this->Crud->activity('rhapsody', $ins_rec, $action);
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
			
			if(!empty($this->request->getPost('partner'))) { $partner = $this->request->getPost('partner'); } else { $partner = ''; }
			$search = $this->request->getPost('search');

			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">Date</span></div>
					<div class="nk-tb-col"><span class="sub-text">Title</span></div>
					<div class="nk-tb-col tb-col-md"><span class="sub-text">Language</span></div>
					<div class="nk-tb-col tb"><span class="sub-text">Action</span></div>
				</div><!-- .nk-tb-item -->
				
			';

            //echo $status;
			$log_id = $this->session->get('ang_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_rhapsody('', '', $log_id, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_rhapsody($limit, $offset, $log_id, $search);
				$data['count'] = $counts;
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$title = $q->title;
						$content = $q->content;
						$featured_image = $q->featured_image;
						$lang = $this->Crud->read_field('id', $q->language, 'language', 'name');
						$country = $this->Crud->read_field('id', $q->language, 'language', 'country');
						$date = date('l M d, Y', strtotime($q->date));
						$reg_date = date('M d, Y', strtotime($q->reg_date));

						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
									<a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$title.'" pageName="'.site_url($mod.'/manage/edit/'.$id).'">
										<i class="ni ni-edit-alt"></i> Edit
									</a>
									<a href="javascript:;" class="text-success pop" pageTitle="View '.$title.'" pageName="'.site_url($mod.'/manage/view/'.$id).'">
										<i class="ni ni-eye"></i> View
									</a>
									<a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$title.'" pageName="'.site_url($mod.'/manage/delete/'.$id).'">
										<i class="ni ni-trash-alt"></i> Delete
									</a>
								
							';
						}

						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col">
									<span class="text-dark"><b>'.ucwords($date).'</b></span>
								</div>
								<div class="nk-tb-col">
									<div class="user-card">
										<div class="user-avatar ">
											<img alt="" src="'.site_url($featured_image).'" style="width:100%" height="40px"/>
										</div>
										<div class="user-info">
											<span class="tb-lead">'.ucwords($title).'
										</div>
									</div>
								</div>
								
								<div class="nk-tb-col tb-col-mb">
									<span>'.ucwords($lang.' - '.$country).'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-mb">
                                   '.$all_btn.'
								</div>
							</div><!-- .nk-tb-item -->
						';
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
                    <div class="nk-tb-item">
                        <div class="nk-tb-col">
                            <div class="text-center text-muted">
                                <br/><br/><br/><br/>
                                <i class="ni ni-template" style="font-size:150px;"></i><br/><br/>No Rhapsody of Reality Returned
                            </div>
                        </div>
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
			return view('rhapsody/form', $data);
		} else { // view for main page
			
			$data['title'] = 'Rhapsody  | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }

	//Add Rhapsody
	public function add($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('ang_id') == ''){
			$request_uri = uri_string();
			$this->session->set('ang_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'rhapsody/add';

        $log_id = $this->session->get('ang_id');
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
       
		$table = 'rhapsody';
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
		
		if($this->request->getMethod() == 'post'){
			$rhapsody_id =  $this->request->getVar('rhapsody_id');
			$title =  $this->request->getVar('title');
			$content =  $this->request->getVar('content');
			$date =  $this->request->getVar('dates');
			$language =  $this->request->getVar('language');
			$featured_image =  $this->request->getVar('featured_image');
			
				//// Image upload
				if(file_exists($this->request->getFile('pics'))) {
				$path = 'assets/backend/images/users/'.$log_id.'/';
				$file = $this->request->getFile('pics');
				$getImg = $this->Crud->img_upload($path, $file);
				
				if(!empty($getImg->path)) $img_id = $getImg->path;
			}
			$ins_data['title'] = $title;
			$ins_data['content'] = $content;
			$ins_data['date'] = $date;
			$ins_data['language'] = $language;
			if(!empty($img_id) || !empty($getImg->path))$ins_data['featured_image'] = $img_id;
			$lang = $this->Crud->read_field('id', $language, 'language', 'name');	
			// do create or update
			if($rhapsody_id) {
				
				$upd_rec = $this->Crud->updates('id', $rhapsody_id, $table, $ins_data);
				if($upd_rec > 0) {
					///// store activities
					$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
					$code = $this->Crud->read_field('id', $rhapsody_id, 'rhapsody', 'title');
					$action = $by.' updated Rhapsody of Reality titled ('.ucwords($code).') with '.ucwords($lang).' Record';
					$this->Crud->activity('rhapsody', $rhapsody_id, $action);

					echo $this->Crud->msg('success', 'Updated');
					echo '<script>location.reload(false);</script>';
				} else {
					echo $this->Crud->msg('info', 'No Changes');	
				}
				die;
			} else {
				if($this->Crud->check2('title', $title, 'date', $date, $table) > 0) {
					echo $this->Crud->msg('warning', 'Record Already Exist');
				} else {
					$ins_data['reg_date'] = date(fdate);
					
					$ins_rec = $this->Crud->create($table, $ins_data);
					if($ins_rec > 0) {
						echo $this->Crud->msg('success', 'Record Created');
						///// store activities
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$code = $this->Crud->read_field('id', $ins_rec, 'rhapsody', 'title');
						$action = $by.' created Rhapsody of Reality titled ('.ucwords($code).') with '.ucwords($lang).' Record';
						$this->Crud->activity('rhapsody', $ins_rec, $action);
						echo '<script>location.reload(false);</script>';
					} else {
						echo $this->Crud->msg('danger', 'Please try later');	
					}	
				}

			}die;
				
		}
			
		

			
		$data['title'] = 'Add Rhapsody  | '.app_name;
		$data['page_active'] = $mod;
		return view('rhapsody/add', $data);
		
    }

     //Language
	public function language($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('ang_id') == ''){
			$request_uri = uri_string();
			$this->session->set('ang_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'rhapsody/language';

        $log_id = $this->session->get('ang_id');
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
       
		$table = 'language';
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
						$del_id =  $this->request->getVar('d_language_id');
                        $code = $this->Crud->read_field('id', $del_id, 'language', 'name');
						$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
						$action = $by.' deleted Language ('.$code.')';
							
                        if($this->Crud->deletes('id', $del_id, $table) > 0) {

							///// store activities
							$this->Crud->activity('rhapsody', $del_id, $action);
							
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
								$data['e_name'] = $e->name;
								
							}
						}
					}
				}

				
				if($this->request->getMethod() == 'post'){
					$language_id =  $this->request->getVar('language_id');
					$name =  $this->request->getVar('name');
					
                    $ins_data['name'] = $name;
                	// do create or update
					if($language_id) {
						$upd_rec = $this->Crud->updates('id', $language_id, $table, $ins_data);
						if($upd_rec > 0) {
							///// store activities
							$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
							$code = $this->Crud->read_field('id', $language_id, 'language', 'name');
							$action = $by.' updated language ('.$code.') Record';
							$this->Crud->activity('rhapsody', $language_id, $action);

							echo $this->Crud->msg('success', 'Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
                        die;
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								///// store activities
								$by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
								$code = $this->Crud->read_field('id', $ins_rec, 'language', 'name');
								$action = $by.' created language ('.$code.') Record';
								$this->Crud->activity('rhapsody', $ins_rec, $action);
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
			
			$search = $this->request->getPost('search');

			$items = '
				<div class="nk-tb-item nk-tb-head">
					<div class="nk-tb-col"><span class="sub-text">S/N</span></div>
					<div class="nk-tb-col tb-col"><span class="sub-text">Language</span></div>
					<div class="nk-tb-col"><span class="sub-text">Action</span></div>
				</div>
			';

            //echo $status;
			$log_id = $this->session->get('ang_id');
			if(!$log_id) {
				$item = '<div class="text-center text-muted">Session Timeout! - Please login again</div>';
			} else {
				$all_rec = $this->Crud->filter_language('', '', $log_id, $search);
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				$query = $this->Crud->filter_language($limit, $offset, $log_id, $search);
				$data['count'] = $counts;
				if(!empty($query)) {$a= 1;
					foreach($query as $q) {
						$id = $q->id;
						$name = $q->name;
						
						// add manage buttons
						if($role_u != 1) {
							$all_btn = '';
						} else {
							$all_btn = '
									<a href="javascript:;" class="text-primary pop" pageTitle="Manage '.$name.'" pageName="'.site_url($mod.'/manage/edit/'.$id).'">
										<i class="ni ni-edit-alt"></i> Edit
									</a>
									<a href="javascript:;" class="text-danger pop" pageTitle="Delete '.$name.'" pageName="'.site_url($mod.'/manage/delete/'.$id).'">
										<i class="ni ni-trash-alt"></i> Delete
									</a>
								
							';
						}
						$item .= '
							<div class="nk-tb-item">
								<div class="nk-tb-col tb-col">
									<span class="text-dark"><b>'.ucwords($a).'</b></span>
								</div>
								<div class="nk-tb-col tb-col">
									<span>'.ucwords($name).'</span>
								</div>
								<div class="nk-tb-col nk-tb-col-mb">
                                    '.$all_btn.'
								</div>
							</div><!-- .nk-tb-item -->
						';
						$a++;
					}
				}
			}
			
			if(empty($item)) {
				$resp['item'] = $items.'
                    <div class="nk-tb-item">
                        <div class="nk-tb-col">
                            <div class="text-center text-muted">
                                <br/><br/><br/><br/>
                                <i class="ni ni-home-alt" style="font-size:150px;"></i><br/><br/>No Language Returned
                            </div>
                        </div>
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
			
			$data['title'] = 'Language  | '.app_name;
			$data['page_active'] = $mod;
			return view($mod, $data);
		}
    }
}
