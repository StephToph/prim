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
            return redirect()->to(site_url('profile'));	
        }

        $data['log_id'] = $log_id;
        $data['role'] = $role;
        $data['role_c'] = $role_c;

        // sales statistics
        $sales = $this->sales();

        $total_sales = $sales->total_sales;
        $online_sales = $sales->online_sales;
        $offline_sales = $sales->offline_sales;
        $maxSales = $sales->maxSales;
        
        $net_revenue = $sales->net_revenue;
        $corporate_revenue = $sales->corporate_revenue;
        $individual_revenue = $sales->individual_revenue;
        $revenues = $sales->revenues;;

        // expenses statistics
        $total_expenses = 0;
        
        // percentage
        $sales_perc = 0;
        $expenses_perc = 0;

        if($total_sales > 0 || $total_expenses > 0) {
            $sum_up = $total_sales + $total_expenses;
            $sales_perc = ($total_sales / $sum_up) * 100;
            $expenses_perc = ($expenses_perc / $sum_up) * 100;
        }

        // account metrics
        $partners = $this->db->table('user')->where('role_id', 2)->countAllResults();
        $corporates = $this->db->table('user')->where('role_id', 3)->countAllResults();
        $individuals = $this->db->table('child')->countAllResults();

        // recent payments
        $recent_payments = $this->recent_payment($log_id);
        
        $data['total_sales'] = number_format($total_sales,2);
        $data['total_expenses'] = number_format($total_expenses,2);
        $data['sales_perc'] = $sales_perc;
        $data['expenses_perc'] = $expenses_perc;
        $data['online_sales'] = $online_sales;
        $data['offline_sales'] = $offline_sales;
        $data['net_revenue'] = number_format($net_revenue,2);
        $data['corporate_revenue'] = number_format($corporate_revenue,2);
        $data['individual_revenue'] = number_format($individual_revenue,2);
        $data['revenues'] = $revenues;
        $data['maxSales'] = $maxSales;
        $data['partners'] = $partners;
        $data['corporates'] = $corporates;
        $data['individuals'] = $individuals;
        $data['recent_payments'] = $recent_payments;
        
        $data['title'] = 'Dashboard | '.app_name;
        $data['page_active'] = 'dashboard';
        return view('dashboard', $data);
    }

    // sales statistics
    public function sales($year='') {
        // $year ='2022';
        if(empty($year)) $year = date('Y');
        $start_date = $year.'-01-01';
        $end_date = $year.'-12-31';
        // echo $start_date;
        // $year = '2022';
        // offline and online sales
        $total_sales = 0;
        $jan1=0; $feb1=0; $mar1=0; $apr1=0; $may1=0; $jun1=0; $jul1=0; $aug1=0; $sep1=0; $oct1=0; $nov1=0; $dec1=0;
        $jan2=0; $feb2=0; $mar2=0; $apr2=0; $may2=0; $jun2=0; $jul2=0; $aug2=0; $sep2=0; $oct2=0; $nov2=0; $dec2=0;

        // revenues
        $net_revenue = 0;
        $corporate_revenue = 0;
        $individual_revenue = 0;
        $jan=0; $feb=0; $mar=0; $apr=0; $may=0; $jun=0; $jul=0; $aug=0; $sep=0; $oct=0; $nov=0; $dec=0;

        $payments = $this->Crud->date_range($start_date, 'reg_date', $end_date, 'reg_date', 'sub');
        $maxs = 0;
        // print_r($payments);
        if(!empty($payments)) {
            foreach($payments as $p) {
                $is_offline = $p->coupon_id;
                $date = $p->reg_date;
                $amount = 1;
                 // compute online and offline payments
                if(date('Y-m', strtotime($date)) == $year.'-01') {
                    if($is_offline) { $jan1 += $amount; } else { $jan2 += $amount; }
                    $jan += $amount;
                    // echo $jan.'<br>';
                }
                if(date('Y-m', strtotime($date)) == $year.'-02') {
                    if($is_offline) { $feb1 += $amount; } else { $feb2 += $amount; }
                    $feb += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-03') {
                    if($is_offline) { $mar1 += $amount; } else { $mar2 += $amount; }
                    $mar += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-04') {
                    if($is_offline) { $apr1 += $amount; } else { $apr2 += $amount; }
                    $apr += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-05') {
                    if($is_offline) { $may1 += $amount; } else { $may2 += $amount; }
                    $may += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-06') {
                    if($is_offline) { $jun1 += $amount; } else { $jun2 += $amount; }
                    $jun += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-07') {
                    if($is_offline) { $jul1 += $amount; } else { $jul2 += $amount; }
                    $jul += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-08') {
                    if($is_offline) { $aug1 += $amount; } else { $aug2 += $amount; }
                    $aug += $amount; 
                } 
                if(date('Y-m', strtotime($date)) == $year.'-09') {
                    if($is_offline) { $sep1 += $amount; } else { $sep2 += $amount; }
                    $sep += $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-10') {
                    if($is_offline) { $oct1 += $amount; } else { $oct2 += $amount; }
                    $oct += $amount;
                }
                if(date('Y-m', strtotime($date)) == $year.'-11') {
                    if($is_offline) { $nov1 += $amount; } else { $nov2 += $amount; }
                    $nov1 = $amount;
                } 
                if(date('Y-m', strtotime($date)) == $year.'-12') {
                    if($is_offline) { $dec1 += $amount; } else { $dec2 += $amount; }
                    $dec += $amount;
                }
            }

           
            $maxs = max($jan,$feb,$mar,$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec);
        
        }
        
        $offline_sales = "{$jan1},{$feb1},{$mar1},{$apr1},{$may1},{$jun1},{$jul1},{$aug1},{$sep1},{$oct1},{$nov1},{$dec1}";
        $online_sales = "{$jan2},{$feb2},{$mar2},{$apr2},{$may2},{$jun2},{$jul2},{$aug2},{$sep2},{$oct2},{$nov2},{$dec2}";

        // echo $offline_sales.'<br>'.$online_sales;die;
        $revenues = "{$jan},{$feb},{$mar},{$apr},{$may},{$jun},{$jul},{$aug},{$sep},{$oct},{$nov},{$dec}";
        
        $resp['total_sales'] = $total_sales;
        $resp['online_sales'] = $online_sales;
        $resp['offline_sales'] = $offline_sales;
        $resp['maxSales'] = ceil($maxs * 0.1)/0.1;
        $resp['revenues'] = $revenues;
        $resp['individual_revenue'] = $individual_revenue;
        $resp['corporate_revenue'] = $corporate_revenue;
        $resp['net_revenue'] = $net_revenue;

        return (object)$resp;
    }

    // recent payments
    public function recent_payment($log_id) {
        $resp = '';
        if(!empty($log_id)){
            $sub = $this->Crud->read('sub');
            $count = 0;
            if(!empty($sub)){
                foreach($sub as $s){

                    if ($count > 6)
                        continue;
                    $start_date = date('M d, Y', strtotime($s->start_date));
                    $sub_id = $s->sub_id;
                    $user_id = $s->user_id;

                    $sub = $this->Crud->read_field('id', $sub_id, 'subscription', 'name');
                    $amount = $this->Crud->read_field('id', $sub_id, 'subscription', 'amount');
                    $user = $this->Crud->read_field('id', $user_id, 'user', 'fullname');

                    $resp .= '
                        <tr>
                            <td>'.$start_date.'</td>
                            <td>'.strtoupper($user).'</td>
                            <td>'.$sub.'</td>
                            <td>$'.number_format($amount, 2).'</td>
                        </tr>
                    
                    ';
                    $count++;
                }
            }
        }
        return $resp;
    }

    public function codes($sub_id=1, $count=10) {
        $rands = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for($i = 1; $i <= $count; $i++) {
            $code = substr(str_shuffle($rands), 0, 10);

            $vdata['sub_id'] = $sub_id;
            $vdata['code'] = $code;
            $vdata['reg_date'] = date(fdate);
            $this->Crud->create('coupon', $vdata);
        }
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
}
