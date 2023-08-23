<?php

namespace App\Controllers;

class Activity extends BaseController {

    /////// ACTIVITIES
	public function index($param1='', $param2='', $param3='') {
		// check session login
		if($this->session->get('plx_id') == ''){
			$request_uri = uri_string();
			$this->session->set('plx_redirect', $request_uri);
			return redirect()->to(site_url('auth'));
		} 

        $mod = 'activity';

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
				if(!empty($all_rec)) { $counts = count($all_rec); } else { $counts = 0; }
				
				if(!empty($query)) {
					foreach($query as $q) {
						$id = $q->id;
						$type = $q->item;
						$type_id = $q->item_id;
						$action = $q->action;
						$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

						$timespan = $this->Crud->timespan(strtotime($q->reg_date));

						$icon = 'solution';
						if($type == 'blog') $icon = 'book';
						if($type == 'school') $icon = 'shop';
						if($type == 'business') $icon = 'briefcase';
						if($type == 'ecommerce') $icon = 'bag';
						if($type == 'user') $icon = 'users';
						if($type == 'pump') $icon = 'cc-secure';
						if($type == 'authentication') $icon = 'login';
						if($type == 'enrolment') $icon = 'property-add';
						if($type == 'scholarship') $icon = 'award';

						$item .= '
                        <li class="list-group-item">
                            <div class="row p-t-15">
                                <div class="col-2 p-2 m-t-2 m-b-2">
                                    <em class="anticon anticon-'.$icon.' p-2 text-muted" style="font-size:30px;"></em>
                                </div>
                                <div class="col-10 m-b-2" >
                                    '.$action.' <small>on '.$reg_date.'</small>
                                    <div class="text-muted small text-right" align="right">'.$timespan.'</div>
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
						<em class="icon anticon anticon-property" style="font-size:150px;"></em><br/><br/>No Activity Returned
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
			return view($mod.'_form', $data);
		} else { // view for main page
			// for datatable
			//$data['table_rec'] = $mod.'/list'; // ajax table
			//$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			//$data['no_sort'] = '5,6'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Activity | '.app_name;
			$data['page_active'] = $mod;

			return view($mod.'/list', $data);
		}
	
	}

}
