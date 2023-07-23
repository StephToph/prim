<?php

namespace App\Controllers;

class Dashboard extends BaseController {
    public function index($param1='', $param2='', $para3='') {
        // check login
        $log_id = $this->session->get('ang_id');
        if(empty($log_id)) return redirect()->to(site_url('auth'));
        $mod = 'dashboard';

        $role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
        $role = strtolower($this->Crud->read_field('id', $role_id, 'access_role', 'name'));
        $role_c = $this->Crud->module($role_id, $mod, 'create');
        $role_r = $this->Crud->module($role_id, $mod, 'read');
        $role_u = $this->Crud->module($role_id, $mod, 'update');
        $role_d = $this->Crud->module($role_id, $mod, 'delete');
        if($role_r == 0){
            return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;
        
        $p_chat = array();
        for($i =1; $i <= 12; $i++){
            $date_start = date('Y-m-d', strtotime(date('Y-'.$i.'-01')));
            $date_end = date('Y-m-d', strtotime(date('Y-'.$i.'-31')));
            $date = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'role_id', '3', 'user');
            $p_chat[] = $date;
           
        }
        $p_jan = 100;$p_feb = 0;$p_mar = 0;$p_apr = 0;$p_may = 0;$p_jun = 330;$p_jul = 760;$p_aug = 0;$p_sep = 0;$p_oct = 0;$p_nov = 0;$p_dec = 0;

        $partner_chat = array($p_jan, $p_feb, $p_mar, $p_apr, $p_may, $p_jun, $p_jul, $p_aug, $p_sep, $p_oct, $p_nov, $p_dec);
        $data['partner_chat'] = json_encode($p_chat);
        
        $data['title'] = 'Dashboard | '.app_name;
        $data['page_active'] = $mod;
        return view('dashboard', $data);
    }

    ///// LOGIN
    public function land() {
        $data['title'] = 'Welcome | '.app_name;
        return view('land', $data);
    }

    public function sales_rev(){
        $type = $this->request->getVar('date_type');
        
        if($type == '' || $type == 'all'){
            $p_chat = array();
            for($i =1; $i <= 12; $i++){
                $date_start = date('Y-m-d', strtotime(date('Y-'.$i.'-01')));
                $date_end = date('Y-m-d', strtotime(date('Y-'.$i.'-31')));
                $date = $this->Crud->date_check($date_start, 'reg_date', $date_end, 'reg_date', 'order');
                $p_chat[] = $date + 29;
            
            }
            $chrt = $p_chat;
            $cat_text = 'All Products Sales Revenue';
            $res = '
                <div class="analytic-data analytic-au-data">
                    <div class="title">Monthly</div>
                    <div class="amount">'.$this->Crud->date_check(date('Y-m-01'), 'reg_date', date('Y-m-31'), 'reg_date', 'order').'</div>
                </div>
                <div class="analytic-data analytic-au-data">
                    <div class="title">Weekly</div>
                    <div class="amount">'.$this->Crud->date_check(date('Y-m-d', strtotime('monday this week')), 'reg_date', date('Y-m-d', strtotime('sunday this week')), 'reg_date', 'order').'</div>
                </div>
                <div class="analytic-data analytic-au-data">
                    <div class="title">Daily</div>
                    <div class="amount">'.$this->Crud->date_check(date('Y-m-d'), 'reg_date', date('Y-m-d'), 'reg_date', 'order').'</div>
                </div>
            ';
        } else {
            $cat = $this->Crud->read_field('name', $type, 'category', 'id');
            
            $p_chat = array();
            for($i =1; $i <= 12; $i++){
                $date_start = date('Y-m-d', strtotime(date('Y-'.$i.'-01')));
                $date_end = date('Y-m-d', strtotime(date('Y-'.$i.'-31')));
                $date = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'category_id', $cat, 'order');
                $p_chat[] = $date;
            
            }
            $chrt = $p_chat;
            $cat_text = ucwords($type).' Revenue ';
           $res = '
                <div class="analytic-data analytic-au-data">
                    <div class="title">Monthly</div>
                    <div class="amount">'.$this->Crud->date_check1(date('Y-m-01'), 'reg_date', date('Y-m-31'), 'reg_date', 'category_id', $cat, 'order').'</div>
                </div>
                <div class="analytic-data analytic-au-data">
                    <div class="title">Weekly</div>
                    <div class="amount">'.$this->Crud->date_check1(date('Y-m-d', strtotime('monday this week')), 'reg_date', date('Y-m-d', strtotime('sunday this week')), 'reg_date', 'category_id', $cat, 'order').'</div>
                </div>
                <div class="analytic-data analytic-au-data">
                    <div class="title">Daily</div>
                    <div class="amount">'.$this->Crud->date_check1(date('Y-m-d'), 'reg_date', date('Y-m-d'), 'reg_date', 'category_id', $cat, 'order').'</div>
                </div>
            ';
        }
        $data['rev_chart'] = json_encode($chrt);
        $data['rev_data'] = $res;
        $data['cat_text'] = $cat_text;
        echo json_encode($data);
		die;
    }

    public function sales_qty(){
        $type = $this->request->getVar('date_type');
        
        $date_start = date('Y-m-d', strtotime('-30 days'));
        $prev_start = date('Y-m-d', strtotime('-60 days'));
        //echo $prev_start.' '.$date_start;
        $date_end = date('Y-m-d');
        $pet = $this->Crud->read_field('name', 'Petrol', 'category', 'id');
        $die = $this->Crud->read_field('name', 'Diesel', 'category', 'id');
        $gas = $this->Crud->read_field('name', 'Gas', 'category', 'id');
        $ker = $this->Crud->read_field('name', 'Kerosene', 'category', 'id');
        $date_pet = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'category_id', $pet, 'order');
        $prev_pet = $this->Crud->date_check1($prev_start, 'reg_date', $date_start, 'reg_date', 'category_id', $pet, 'order');
        $date_die = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'category_id', $die, 'order');
        $prev_die = $this->Crud->date_check1($prev_start, 'reg_date', $date_start, 'reg_date', 'category_id', $die, 'order');
        $date_gas = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'category_id', $gas, 'order');
        $prev_gas = $this->Crud->date_check1($prev_start, 'reg_date', $date_start, 'reg_date', 'category_id', $gas, 'order');
        $date_ker = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'category_id', $ker, 'order');
        $prev_ker = $this->Crud->date_check1($prev_start, 'reg_date', $date_start, 'reg_date', 'category_id', $ker, 'order');

        if($date_pet == $prev_pet){
            $pet_per = 0;
            $pet_sta = '';
        } elseif($date_pet > $prev_pet){
            $change = (1 - $prev_pet / $date_pet) * 100;

            $percentChange = round($change);
            $pet_per = $percentChange;

            $pet_sta = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
        } elseif($date_pet < $prev_pet){
            $change = (1 - $date_pet / $prev_pet) * 100;

            $percentChange = round($change);
            $pet_per = $percentChange;
            $pet_per = $percentChange;
            $pet_sta = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
        }

        if($date_die == $prev_die){
            $die_per = 0;
            $die_sta = '';
        } elseif($date_die > $prev_die){
            $change = (1 - $prev_die / $date_die) * 100;

            $percentChange = round($change, 2);
            $die_per = $percentChange;

            $die_sta = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
        } elseif($date_die < $prev_die){
            $change =  (1 - $date_die / $prev_die) * 100;

            $percentChange = round($change);
            $die_per = $percentChange;
            $die_sta = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
        }

        if($date_ker == $prev_ker){
            $ker_per = 0;
            $ker_sta = '';
        } elseif($date_ker > $prev_ker){
            $change = (1 - $prev_ker / $date_ker) * 100;

            $percentChange = round($change, 2);
            $ker_per = $percentChange;

            $ker_sta = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
        } elseif($date_ker < $prev_ker){
            $change =  (1 - $date_ker / $prev_ker) * 100;

            $percentChange = round($change);
            $ker_per = $percentChange;
            $ker_sta = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
        }

        if($date_gas == $prev_gas){
            $gas_per = 0;
            $gas_sta = '';
        } elseif($date_gas > $prev_gas){
            $change = (1 - $prev_gas / $date_gas) * 100;

            $percentChange = round($change, 2);
            $gas_per = $percentChange;

            $gas_sta = '<span class="change up"><em class="icon ni ni-arrow-long-up"></em></span>';
        } elseif($date_gas < $prev_gas){
            $change =  (1 - $date_gas / $prev_gas) * 100;

            $percentChange = round($change);
            $gas_per = $percentChange;
            $gas_sta = '<span class="change down"><em class="icon ni ni-arrow-long-down"></em></span>';
        }
        
        $category_pet = '
                <div class="nk-tb-col nk-tb-channel">
                    <span class="tb-lead">Petrol</span>
                </div>
                <div class="nk-tb-col nk-tb-sessions">
                    <span class="tb-sub tb-amount"><span>'.$date_pet.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-prev-sessions">
                    <span class="tb-sub tb-amount"><span>'.$prev_pet.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-change">
                    <span class="tb-sub"><span>'.$pet_per.'%</span> '.$pet_sta.'</span>
                </div>
                <div class="nk-tb-col nk-tb-trend text-end">
                    <div class="traffic-channel-ck ms-auto">
                        <canvas class="analytics-line-small" id="OrganicSearchData"></canvas>
                    </div>
                </div>
        ';
        
        $category_die = '
                <div class="nk-tb-col nk-tb-channel">
                    <span class="tb-lead">Diesel</span>
                </div>
                <div class="nk-tb-col nk-tb-sessions">
                    <span class="tb-sub tb-amount"><span>'.$date_die.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-prev-sessions">
                    <span class="tb-sub tb-amount"><span>'.$prev_die.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-change">
                    <span class="tb-sub"><span>'.$die_per.'%</span> '.$die_sta.'</span>
                </div>
                <div class="nk-tb-col nk-tb-trend text-end">
                    <div class="traffic-channel-ck ms-auto">
                        <canvas class="analytics-line-small" id="SocialMediaData"></canvas>
                    </div>
                </div>
        ';

        $category_ker = '
                <div class="nk-tb-col nk-tb-channel">
                    <span class="tb-lead">Kerosene</span>
                </div>
                <div class="nk-tb-col nk-tb-sessions">
                    <span class="tb-sub tb-amount"><span>'.$date_ker.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-prev-sessions">
                    <span class="tb-sub tb-amount"><span>'.$prev_ker.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-change">
                    <span class="tb-sub"><span>'.$ker_per.'%</span> '.$ker_sta.'</span>
                </div>
                <div class="nk-tb-col nk-tb-trend text-end">
                    <div class="traffic-channel-ck ms-auto">
                        <canvas class="analytics-line-small" id="SocialMediaData"></canvas>
                    </div>
                </div>
        ';

        $category_gas = '
                <div class="nk-tb-col nk-tb-channel">
                    <span class="tb-lead">Gas</span>
                </div>
                <div class="nk-tb-col nk-tb-sessions">
                    <span class="tb-sub tb-amount"><span>'.$date_gas.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-prev-sessions">
                    <span class="tb-sub tb-amount"><span>'.$prev_gas.'</span></span>
                </div>
                <div class="nk-tb-col nk-tb-change">
                    <span class="tb-sub"><span>'.$gas_per.'%</span> '.$gas_sta.'</span>
                </div>
                <div class="nk-tb-col nk-tb-trend text-end">
                    <div class="traffic-channel-ck ms-auto">
                        <canvas class="analytics-line-small" id="SocialMediaData"></canvas>
                    </div>
                </div>
        ';
          
        $data['category_pet'] = $category_pet;
        $data['category_die'] = $category_die;
        $data['category_ker'] = $category_ker;
        $data['category_gas'] = $category_gas;
        echo json_encode($data);
		die;
    }

    public function top_fuel(){
        $type = $this->request->getVar('date_type');
        if($type == '' || $type == 'all'){
            $date_start = date('Y-m-d', strtotime('-30 days'));
            $prev_start = date('Y-m-d', strtotime('-60 days'));
            //echo $prev_start.' '.$date_start;
            $date_end = date('Y-m-d');
            
            $or = $this->Crud->read_single('is_partner', 1, 'user');
            $ar = array();

            if(!empty($or)){
                foreach($or as $par){
                    $che = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'partner_id', $par->id,  'order');
                    
                    $ar[$par->id] = $che;
                }
            }
            arsort($ar);
            $res = '';
            if(!empty($ar)){ $i = 0;
                foreach($ar as $ord => $val){
                    if($val == 0) continue;
                    $cat = $this->Crud->read_field('id', $ord, 'user', 'fullname');

                    if($i <= 5) {
                    $res .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($cat).'</div>
                                <div class="progress-amount">'.$val.'%</div>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-orange" data-progress="'.$val.'"></div>
                            </div>
                        </div>
                    ';
                } 
                $i++;
            }}
            
        } else {
            $cat = $this->Crud->read_field('name', $type, 'category', 'id');
            $date_start = date('Y-m-d', strtotime('-30 days'));
            $prev_start = date('Y-m-d', strtotime('-60 days'));
            //echo $prev_start.' '.$date_start;
            $date_end = date('Y-m-d');
            
            $or = $this->Crud->read_single('is_partner', 1, 'user');
            $ar = array();

            if(!empty($or)){
                foreach($or as $par){
                    $che = $this->Crud->date_check2($date_start, 'reg_date', $date_end, 'reg_date', 'partner_id', $par->id,'category_id', $cat,  'order');
                    
                    $ar[$par->id] = $che;
                }
            }
            arsort($ar);
            $res = '';
            if(!empty($ar)){ $i = 0;
                foreach($ar as $ord => $val){
                    if($val == 0) continue;
                    $cat = $this->Crud->read_field('id', $ord, 'user', 'fullname');

                    if($i <= 5) {
                    $res .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($cat).'</div>
                                <div class="progress-amount">'.$val.'%</div>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-orange" data-progress="'.$val.'"></div>
                            </div>
                        </div>
                    ';
                } 
                $i++;
            }}
            
        }
        $data['top_selling'] = $res;
        echo json_encode($data);
		die;
        
    }

    public function least_fuel(){
        $type = $this->request->getVar('date_type');
        if($type == '' || $type == 'all'){
            $date_start = date('Y-m-d', strtotime('-30 days'));
            $prev_start = date('Y-m-d', strtotime('-60 days'));
            //echo $prev_start.' '.$date_start;
            $date_end = date('Y-m-d');
            
            $or = $this->Crud->read_single('is_partner', 1, 'user');
            $ar = array();

            if(!empty($or)){
                foreach($or as $par){
                    $che = $this->Crud->date_check1($date_start, 'reg_date', $date_end, 'reg_date', 'partner_id', $par->id,  'order');
                    
                    $ar[$par->id] = $che;
                }
            }
           
            
            asort($ar);
            $resu = '';
            if(!empty($ar)){ $i = 0;
                foreach($ar as $ord => $val){
                    if($val == 0) continue;
                    $cat = $this->Crud->read_field('id', $ord, 'user', 'fullname');

                    if($i <= 5) {
                    $resu .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($cat).'</div>
                                <div class="progress-amount">'.$val.'%</div>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-orange" data-progress="'.$val.'"></div>
                            </div>
                        </div>
                    ';
                } 
                $i++;
            }}
        } else {
            $cat = $this->Crud->read_field('name', $type, 'category', 'id');
            $date_start = date('Y-m-d', strtotime('-30 days'));
            $prev_start = date('Y-m-d', strtotime('-60 days'));
            //echo $prev_start.' '.$date_start;
            $date_end = date('Y-m-d');
            
            $or = $this->Crud->read_single('is_partner', 1, 'user');
            $ar = array();

            if(!empty($or)){
                foreach($or as $par){
                    $che = $this->Crud->date_check2($date_start, 'reg_date', $date_end, 'reg_date', 'partner_id', $par->id,'category_id', $cat,  'order');
                    
                    $ar[$par->id] = $che;
                }
            }
           
            asort($ar);
            $resu = '';
            if(!empty($ar)){ $i = 0;
                foreach($ar as $ord => $val){
                    if($val == 0) continue;
                    $cat = $this->Crud->read_field('id', $ord, 'user', 'fullname');

                    if($i <= 5) {
                    $resu .= '
                        <div class="progress-wrap">
                            <div class="progress-text">
                                <div class="progress-label">'.ucwords($cat).'</div>
                                <div class="progress-amount">'.$val.'%</div>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-orange" data-progress="'.$val.'"></div>
                            </div>
                        </div>
                    ';
                } 
                $i++;
            }}
        }
        $data['least_selling'] = $resu;
        echo json_encode($data);
		die;
        
    }

    public function test($str) {
        echo date('Y-m-d', strtotime($str));
        echo $this->Crud->wordsToNumber('23rd');
    }
}
