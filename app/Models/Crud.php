<?php

namespace App\Models;

use CodeIgniter\Model;

class Crud extends Model {

    public function __construct() {
       
    }

    //////////////////// C - CREATE ///////////////////////
	public function create($table, $data) {
		$db = db_connect();
        $builder = $db->table($table);

        $builder->insert($data);

        return $db->InsertID();
        $db->close();
	}
	
	//////////////////// R - READ /////////////////////////
	public function read($table, $limit='', $offset='') {
        $db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy('id', 'DESC');
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function read_order($table, $field, $type, $limit='', $offset='') {
        $db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy($field, $type);
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function read_single($field, $value, $table, $limit='', $offset='') {
		$db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy('id', 'DESC');
        $builder->where($field, $value);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function read_single_order($field, $value, $table, $or_field, $or_value, $limit='', $offset='') {
		$db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy($or_field, $or_value);
        $builder->where($field, $value);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

	public function read2_order($field, $value, $field2, $value2, $table, $or_field, $or_value, $limit='', $offset='') {
		$db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy($or_field, $or_value);
        $builder->where($field, $value);
		$builder->where($field2, $value2);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function read2($field, $value, $field2, $value2, $table, $or_field='id', $or_value='DESC', $limit='', $offset='') {
		$db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy($or_field, $or_value);
        $builder->where($field, $value);
        $builder->where($field2, $value2);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function read3($field, $value, $field2, $value2, $field3, $value3, $table, $limit='', $offset='') {
		$db = db_connect();
        $builder = $db->table($table);

		$builder->orderBy('id', 'DESC');
        $builder->where($field, $value);
        $builder->where($field2, $value2);
        $builder->where($field3, $value3);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}
    

    public function read_field($field, $value, $table, $call) {
		$return_call = '';
		$getresult = $this->read_single($field, $value, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}

    public function read_field2($field, $value, $field2, $value2, $table, $call) {
		$return_call = '';
		$getresult = $this->read2($field, $value, $field2, $value2, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}

    public function read_field3($field, $value, $field2, $value2, $field3, $value3, $table, $call) {
		$return_call = '';
		$getresult = $this->read3($field, $value, $field2, $value2, $field3, $value3, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}

	public function read_group($table, $group, $limit='', $offset='') {
		$db = db_connect();
		$db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $builder = $db->table($table);

		$builder->orderBy('id', 'DESC');
		$builder->groupBy($group);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

	public function read_single_group($field, $value, $table, $group, $limit='', $offset='') {
		$db = db_connect();
		$db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $builder = $db->table($table);

		$builder->orderBy('id', 'DESC');
        $builder->where($field, $value);
		$builder->groupBy($group);

        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

    public function check($field, $value, $table){
		$db = db_connect();
        $builder = $db->table($table);
        
        $builder->where($field, $value);

        return $builder->countAllResults();
        $db->close();
	}

    public function check2($field, $value, $field2, $value2, $table){
		$db = db_connect();
        $builder = $db->table($table);
        
        $builder->where($field, $value);
        $builder->where($field2, $value2);

        return $builder->countAllResults();
        $db->close();
	}

    public function check3($field, $value, $field2, $value2, $field3, $value3, $table){
		$db = db_connect();
        $builder = $db->table($table);
        
        $builder->where($field, $value);
        $builder->where($field2, $value2);
        $builder->where($field3, $value3);

        return $builder->countAllResults();
        $db->close();
	}

    //////////////////// U - UPDATE ///////////////////////
	public function updates($field, $value, $table, $data) {
		$db = db_connect();
        $builder = $db->table($table);

        $builder->where($field, $value);
        $builder->update($data);
        
        return $db->affectedRows();
        $db->close();
	}
	
	//////////////////// D - DELETE ///////////////////////
	public function deletes($field, $value, $table) {
		$db = db_connect();
        $builder = $db->table($table);

        $builder->where($field, $value);
        $builder->delete();
        
        return $db->affectedRows();
        $db->close();
	}
	public function deletes2($field, $value, $field2, $value2, $table) {
		$db = db_connect();
        $builder = $db->table($table);

        $builder->where($field, $value);
        $builder->where($field2, $value2);
        $builder->delete();
        
        return $db->affectedRows();
        $db->close();
	}
	//////////////////// END DATABASE CRUD ///////////////////////

    //////////////////// DATATABLE AJAX CRUD ///////////////////////
	public function datatable_query($builder, $table, $column_order, $column_search, $order, $where='') {
		// where clause
		if(!empty($where)) {
			foreach($where as $key=>$value) {
		        $builder->where($key, $value);
		    }
		}
 
		// here combine like queries for search processing
		$i = 0;
		if($_POST['search']['value']) {
			foreach($column_search as $item) {
				if($i == 0) {
					$builder->like($item, $_POST['search']['value']);
				} else {
					$builder->orLike($item, $_POST['search']['value']);
				}
				
				$i++;
			}
		}
		 
		// here order processing
		if(isset($_POST['order'])) { // order by click column
			$builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else { // order by default defined
			$builder->orderBy(key($order), $order[key($order)]);
		}
	}
 
	public function datatable_load($table, $column_order, $column_search, $order, $where='') {
        $db = db_connect();
        $builder = $db->table($table);

		$this->datatable_query($builder, $table, $column_order, $column_search, $order, $where);
		
		if($_POST['length'] != -1) {
			$builder->limit($_POST['length'], $_POST['start']);
		}
		
		$query = $builder->get();
		return $query->getResult();
        $db->close();
	}
 
	public function datatable_filtered($table, $column_order, $column_search, $order, $where='') {
        $db = db_connect();
        $builder = $db->table($table);

		$this->datatable_query($builder, $table, $column_order, $column_search, $order, $where);
		// $query = $builder->get();
		// return $query->num_rows();
        return $builder->countAllResults();
        $db->close();
	}
 
	public function datatable_count($table, $where='') {
		$db = db_connect();
        $builder = $db->table($table);
        
		// where clause
		if(!empty($where)) {
			foreach($where as $key=>$value) {
				$builder->where($key, $value);
			}
		}

        return $builder->countAllResults();
        $db->close();
	} 
	//////////////////// END DATATABLE AJAX CRUD ///////////////////


    //////////////////// NOTIFICATION CRUD ///////////////////////
	public function msg($type = '', $text = ''){
		if($type == 'success'){
			$icon = 'anticon anticon-check-circle';
			$icon_text = 'Successful!';
		} else if($type == 'info'){
			$icon = 'anticon anticon-info-circle';
			$icon_text = 'Head up!';
		} else if($type == 'warning'){
			$icon = 'anticon anticon-exclamation-circle';
			$icon_text = 'Please check!';
		} else if($type == 'danger'){
			$icon = 'anticon anticon-close-circle';
			$icon_text = 'Oops!';
		}
		
		return '
			<div class="alert alert-'.$type.' alert-dismissible">
				<div class="d-flex justify-content-start">
					<span class="alert-icon m-r-20 font-size-30">
						<i class="'.$icon.'"></i>
					</span>
					<div>
						<div class="alert-heading"><b>'.$icon_text.'</b></div>
						<p>'.$text.'</p>
					</div>
				</div>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  			<span aria-hidden="true">×</span>
				</button>
			</div>
		';	
	}
	//////////////////// END NOTIFICATION CRUD ///////////////////////

	//////////////////// FLUTTERWAVE //////////////////
	public function rave_url($server='') {
		if($server == 'test') return 'https://api.flutterwave.com/v3/';
		return 'https://api.flutterwave.com/v3/';
	}

	public function rave_key($type='', $server='') {
		if($server == 'test') {
			// if($type == 'encryption') return 'FLWSECK_TEST02ec36b8fb09';
			// if($type == 'secret') return 'FLWSECK_TEST-055034f67c5a29532b2d9424631442a4-X';
			// return 'FLWPUBK_TEST-d28ee7274d4a3a7bff3ad0a9a74089e2-X';
			if($type == 'encryption') return 'FLWSECK_TEST611ac22da7b0';
			if($type == 'secret') return 'FLWSECK_TEST-775f459edecfd7e0d3cbc683f4f7050e-X';
			return 'FLWPUBK_TEST-6235656366b21894488153b48df11a1e-X';
		}
		if($type == 'encryption') return '34b4f9e2604cbee6b044f85e';
		if($type == 'secret') return 'FLWSECK-34b4f9e2604c6d80ca5ddad043084daa-X';
		return 'FLWPUBK-fd6c33da431b9f0af1bbad6aa4a7dda1-X';
	}

	public function rave_get($link, $server='') {
		// create a new cURL resource
		$curl = curl_init();

		$link = $this->rave_url($server).$link;
		$secretKey = $this->rave_key('secret', $server);
		
		$chead = array();
		$chead[] = 'Content-Type: application/json';
		$chead[] = 'Authorization: Bearer '.$secretKey;

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $chead);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	}

	public function rave_inline($redir='', $customize='', $amount=0, $customer='', $meta='', $sub='',  $server='live', $options='card,account,ussd', $curr='NGN') {
		$publicKey = $this->rave_key('public', $server);
		$txref = 'PR-'.time().rand();
		$amount = $this->to_number($amount);

		return '
			<script src="https://checkout.flutterwave.com/v3.js"></script>
			<script>
				function ravePay() {
					FlutterwaveCheckout({
						public_key: "'.$publicKey.'",
						tx_ref: "'.$txref.'",
						amount: '.$amount.',
						currency: "'.$curr.'",
						payment_options: "'.$options.'",
						redirect_url: "'.$redir.'",
						customer: '.json_encode($customer).',
						meta: '.json_encode($meta).',
						subaccounts: '.json_encode($sub).',
						customizations: '.json_encode($customize).',
					});
				}
			</script>
		';
	}

	public function rave_save($user_id, $tnx_id, $item_id='', $item='') {
		$trans_id = 0;
		$status = '';

		$resp = $this->rave_get('transactions/'.$tnx_id.'/verify', pay_server);
		$resp = json_decode($resp);
		if(!empty($resp->status) && $resp->status == 'success') {
			$message = $resp->message;

			$code = $resp->data->tx_ref;
			$tnx_id = $resp->data->id;
			$tnx_ref = $resp->data->flw_ref;
			$status = $resp->data->status;

			$ins['amount'] = $resp->data->amount;
			$ins['app_fee'] = $resp->data->app_fee;
			$ins['payment_type'] = $resp->data->payment_type;
			$ins['card'] = json_encode($resp->data->card);
			$ins['customer'] = json_encode($resp->data->customer);
			$ins['status'] = $status;
			$ins['message'] = $message;

			// check transaction
			if($this->check('tnx_ref', $tnx_ref, 'transaction') > 0) {
				$trans_id = $this->read_field('tnx_ref', $tnx_ref, 'transaction', 'id');
				$this->updates('tnx_ref', $tnx_ref, 'transaction', $ins);
			} else {
				if(!empty($user_id)) $ins['user_id'] = $user_id;
				$ins['code'] = $code;
				if(!empty($item_id)) $ins['item_id'] = $item_id;
				if(!empty($item)) $ins['item'] = json_encode($item);
				$ins['tnx_id'] = $tnx_id;
				$ins['tnx_ref'] = $tnx_ref;
				$ins['reg_date'] = date(fdate);
				$trans_id = $this->create('transaction', $ins);
			}
		}

		return (object)array('id'=>$trans_id, 'status'=>$status);
	}
	//////////////////// END FLUTTERWAVE //////////////////

	//////////////////// KINGSPAY //////////////////
	public function kpay_post($link, $data) {
		// create a new cURL resource
		$curl = curl_init();

		$sandbox = $this->read_field('name', 'sandbox', 'setting', 'value');
		if($sandbox == 'yes') {
			$key = $this->read_field('name', 'test_key', 'setting', 'value');
		} else { 
			$key = $this->read_field('name', 'live_key', 'setting', 'value');
		}

		$link = 'https://api.kingspay-gs.com/api/'.$link;
		
		$chead = array();
		$chead[] = 'Content-Type: application/json';
		$chead[] = 'Authorization: Bearer '.$key;

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $link);
		// curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $chead);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	}

	public function kpay_get($payID) {
		// create a new cURL resource
		$curl = curl_init();

		$link = 'https://api.kingspay-gs.com/api/payment/'.$payID;

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	}
	//////////////////// END KINGSPAY //////////////////

    //////////////////// FILE UPLOAD //////////////////
    public function file_validate() {
        $validationRule = [
            'pics' => [
                'rules' => 'uploaded[pics]'
                    . '|is_image[pics]'
                    . '|mime_in[pics,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[pics,100]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return false;
        } else {
            return true;
        }
    }

	///Name to Image
	public function image_name($fullname){
		$str_cou = str_word_count($fullname);
		if($str_cou == 1){
			$wors = substr($fullname, 0, 1);
		} else {
			$wors = '';
			$wor = explode(' ', $fullname);
			$i = 0;
			foreach($wor as $words){
				if($i < 2){$wors .= substr($words, 0, 1);}
				$i++;
			}
			
		}

		return $wors;
	}

    public function img_upload($path, $file, $width=0, $height=0, $ratio=true, $ration_by='width') {
        // file data
        $name = $file->getName();
        $type = $file->getClientMimeType();
        $filename = $file->getRandomName();

        if(empty($width)) $width = 400;
        if(empty($height)) $height = 400;

        // if directory not exit
        if (!is_dir($path)) mkdir($path, 0755);

        $image = \Config\Services::image()
            ->withFile($file)
            ->resize($width, $height, $ratio, $ration_by)
            ->save($path.$filename);

        $resp_data['path'] = $path.$filename;
        $resp_data['name'] = $name;
        $resp_data['type'] = $type;
        return (object)$resp_data;
    }

    public function save_image($log_id, $path, $name='', $type='') {
        $reg_data['user_id'] = $log_id;
        $reg_data['pics'] = $path;
        $reg_data['pics_small'] = $path;
        $reg_data['pics_square'] = $path;
        $reg_data['reg_date'] = date(fdate);
        return $this->create('image', $reg_data);
    }

	public function file_upload($path, $file) {
        // file data
        $name = $file->getName();
        $type = $file->getClientMimeType();
        $filename = $file->getRandomName();
		$size = $file->getSize();
		$ext = $file->guessExtension();

        // if directory not exit
        if (!is_dir($path)) mkdir($path, 0755);
		$file->move($path, $filename);

        $resp_data['path'] = $path.$filename;
        $resp_data['name'] = $name;
        $resp_data['type'] = $type;
		$resp_data['size'] = $size;
		$resp_data['ext'] = $ext;
        return (object) $resp_data;
    }

	public function save_file($log_id, $path, $ext='txt', $size=0) {
        $reg_data['user_id'] = $log_id;
        $reg_data['path'] = $path;
        $reg_data['ext'] = $ext;
        $reg_data['size'] = $size;
        $reg_data['reg_date'] = date(fdate);
        return $this->create('file', $reg_data);
    }
    //////////////////// END FILE UPLOAD //////////////////

    //////////////////// DATETIME ///////////////////////
	public function date_diff($now, $end, $type='days') {
		$now = new \DateTime($now);
		$end = new \DateTime($end);
		$date_left = $end->getTimestamp() - $now->getTimestamp();
		
		if($type == 'seconds') {
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'minutes') {
			$date_left = $date_left / 60;
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'hours') {
			$date_left = $date_left / (60*60);
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'days') {
			$date_left = $date_left / (60*60*24);
			if($date_left <= 0){$date_left = 0;}
		} else {
			$date_left = $date_left / (60*60*24*365);
			if($date_left <= 0){$date_left = 0;}
		}	
		
		return $date_left;
	}
	//////////////////// END DATETIME ///////////////////////

	//////////////////// IMAGE DATA //////////////////
	public function image($id, $size='small') {
		if($id) {
			if($size == 'small') {
				$path = $this->read_field('id', $id, 'image', 'pics_small');
			} else if($size == 'big') {
				$path = $this->read_field('id', $id, 'image', 'pics');
			} else {
				$path = $this->read_field('id', $id, 'image', 'pics_square');
			}
		} 

		if(empty($path) || !file_exists($path)) {
			$path = 'assets/images/avatar.png';
		}

		return $path;
	}
	//////////////////// END /////////////////

	//////////////////// IMAGE DATA //////////////////
	public function file($id) {
		if($id) {
			$ext = $this->read_field('id', $id, 'file', 'ext');
			$ext = str_replace('x', '', $ext);
			$path = 'assets/images/docs/'.$ext.'-128.png';
		} 

		if(empty($path) || !file_exists($path)) {
			$path = 'assets/images/docs/txt-128.png';
		}

		return $path;
	}
	//////////////////// END /////////////////

	//////////////////// SEND EMAIL //////////////////
	public function send_email($to, $subject, $body, $bcc='') {
		$emailServ = \Config\Services::email();

		$config['charset']  = 'iso-8859-1';
		$config['mailType'] = 'html';
		$config['wordWrap'] = true;
		$emailServ->initialize($config);

		$emailServ->setFrom(push_email, app_name);
		$emailServ->setTo($to);
		if(!empty($bcc)) $emailServ->setBCC($bcc);

		$emailServ->setSubject($subject);
		$temp['body'] = $body;

		$template = view('designs/email', $temp);
		$emailServ->setMessage($template);

		if($emailServ->send()) return true;
		return false;
	}
	public function mailgun($body) {
		$ch = curl_init();

		$mailgun_domain = 'mg.pcdl4kids.com';

		$link = 'https://api.mailgun.net/v3/'.$mailgun_domain.'/messages';
		$mailgun_key = $this->read_field('name', 'mailgun', 'setting', 'value');

		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_USERPWD, 'api' . ':' . $mailgun_key);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $result;
	}
	//////////////////// END SEND EMAIL //////////////////

	public function title() {
		return array(
			'Mr',
			'Mrs',
			'Miss',
			'Chief',
			'Engineer',
			'Doctor',
			'Barrister',
			'Pastor',
			'Alhaji',
			'Alhaja',
			'Otunba',
			'Junior',
		);
	}

    public function to_number($text) {
		$number = preg_replace('/\s+/', '', $text); // remove all in between white spaces
		$number = str_replace(',', '', $number); // remove money format
		$number = floatval($number);
		return $number;
	}

	public function to_word(float $number) {
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();

		$words = array(0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
	
		$digits = array('', 'hundred', 'thousand', 'million', 'billion');
		while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
		}
		
		$naira = implode('', array_reverse($str));
		$kobo = ($decimal > 0) ? " " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' kobo' : '';
	
		return ($naira ? $naira . 'naira' : '') . $kobo;
	}

	/// store activities
	public function activity($item, $item_id, $action) {
		$ins['item'] = $item;
		$ins['item_id'] = $item_id;
		$ins['action'] = $action;
		$ins['reg_date'] = date(fdate);
		return $this->create('activity', $ins);
	}

	
    /// filter parents
    public function filter_parent($limit='', $offset='', $log_id='', $search='', $ban='', $start_date='', $end_date= '') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($search)) {
            $builder->like('fullname', $search);
			$builder->orLike('email', $search);
        }

		$builder->where('role_id', 3);
		if($ban != 'all') $builder->where('ban', $ban);
		
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	public function filter_blog($limit='', $offset='', $log_id='', $search='', $status='', $start_date='', $end_date= '') {
        $db = db_connect();
        $builder = $db->table('blog');

        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('content', $search);
        }

		if($status != 'all') $builder->where('status', $status);
		
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	public function filter_faq($limit='', $offset='', $log_id='', $search='', $status='', $start_date='', $end_date= '') {
        $db = db_connect();
        $builder = $db->table('faq');

        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('content', $search);
        }

		if($status != 'all') $builder->where('status', $status);
		
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	public function filter_school($limit='', $offset='', $log_id='', $search='', $status='', $start_date='', $end_date= '') {
        $db = db_connect();
        $builder = $db->table('school');

        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($search)) {
            $builder->like('name', $search);
			$builder->orLike('description', $search);
        }

		if($status != 'all') $builder->where('scholarship_status', $status);
		
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	/// filter coupon
    public function filter_coupon($limit='', $offset='', $log_id='', $search='', $start_date='', $end_date='', $sub_id='') {
        $db = db_connect();
		$db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $builder = $db->table('coupon');

		$builder->orderBy('id', 'DESC');
		$builder->groupBy('code');


        if(!empty($search)) {
            $builder->like('code', $search);
        }
		if($sub_id != 'all') $builder->where('sub_id', $sub_id);
		

		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	/// filter subscription
    public function filter_subscribe($limit='', $offset='', $log_id='', $payment='', $sub_id='', $start_date='', $end_date='') {
        $db = db_connect();
        $builder = $db->table('sub');

        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($payment) && $payment != 'all') {
            if($payment == 'card')$builder->where('response !=', NULL);
			if($payment == 'coupon')$builder->where('coupon_id >', '0');
        }

		if($sub_id != 'all') $builder->where('sub_id', $sub_id);
		

		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	/// filter children
    public function filter_children($limit='', $offset='', $log_id='', $age_id='', $parent_id='', $search='', $start_date='', $end_date='') {
        $db = db_connect();
        $builder = $db->table('child');

        // build query
		$builder->orderBy('id', 'DESC');

		if(!empty($age_id)) { $builder->where('age_id', $age_id); }
		if(!empty($parent_id)) { $builder->where('parent_id', $parent_id); }

        if(!empty($search)) {
            $builder->like('name', $search);
        }
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	//// filter activities
	public function filter_activity($limit='', $offset='', $user_id='', $search='', $start_date='', $end_date='') {
		$db = db_connect();
        $builder = $db->table('activity');
		// build query
		$builder->orderBy('id', 'DESC');
		

		if(!empty($search)) {
			$builder->like('action', $search);
        }
		
		if(!empty($start_date) && !empty($end_date)){
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') >= '".$start_date."'",NULL,FALSE);
			$builder->where("DATE_FORMAT(reg_date,'%Y-%m-%d') <= '".$end_date."'",NULL,FALSE); 
		}
		
		 // limit query
		 if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}

	/// filter claim form
    public function filter_claim_form($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('claim_form');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->select('claim_form.*, user.company, type.name')
			->join('user', 'user.id = claim_form.partner_id')
			->join('type', 'type.id = claim_form.policy_id');

        if(!empty($search)) {
            // $builder->like('tnx_ref', trim($search));
        }
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

    /// filter partners
    public function filter_partner($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
        $builder->where('is_partner', 1);

        if(!empty($search)) {
            $builder->like('company', $search);
            $builder->orLike('email', $search);
        }
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

    /// filter corporates
    public function filter_corporate($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
        $builder->where('is_corporate', 1);

        if(!empty($search)) {
            $builder->like('company', $search);
            $builder->orLike('email', $search);
        }
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

    /// filter customers
    public function filter_customer($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
        $builder->where('is_customer', 1);

        if(!empty($search)) {
            $builder->like('firstname', $search);
            $builder->orLike('lastname', $search);
            $builder->orLike('email', $search);
        }
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	/// filter premium
    public function filter_premium($limit='', $offset='', $log_id='', $search='') {
		// get user type
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');

        $db = db_connect();
        $builder = $db->table('premium');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->select('premium.*, type.name AS policy, user.company AS company, pricing.name AS product, car.name AS car, car_model.name AS model')
			->join('type', 'type.id = premium.policy_id')
			->join('user', 'user.id = premium.partner_id')
			->join('pricing', 'pricing.id = premium.pricing_id')
			->join('car', 'car.id = premium.car_id')
			->join('car_model', 'car_model.id = premium.model_id');

        if(!empty($search)) {
            $builder->like('code', trim($search));
			$builder->orLike('company', trim($search));
			// $builder->orLike('name', trim($search));
        }

		if($role == 'Customer') $builder->where('user_id', $log_id);
		if($role == 'Partner') $builder->where('partner_id', $log_id);
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	public function date_range($firstDate, $col1, $secondDate, $col2, $table, $limit='', $offset=''){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		   $builder->orderBy('id', 'DESC');
		   // limit query
		   if($limit && $offset) {
			   $query = $builder->get($limit, $offset);
		   } else if($limit) {
			   $query = $builder->get($limit);
		   } else {
			   $query = $builder->get();
		   }
   
		   // return query
		   return $query->getResult();
		   $db->close();
	}

	public function date_range1($firstDate, $col1, $secondDate, $col2,$col3, $val3, $table, $limit='', $offset=''){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		 
		 $builder->orderBy('id', 'DESC');
		// limit query
		if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
			$query = $builder->get();
		}

		// return query
		return $query->getResult();
		$db->close();
	}
	/// filter payments
    public function filter_payment($limit='', $offset='', $log_id='', $search='') {
		// get user type
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');

        $db = db_connect();
        $builder = $db->table('transaction');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->select('transaction.*, premium.code AS policy_number')
			->join('premium', 'premium.trans_id = transaction.id');

        if(!empty($search)) {
            $builder->like('tnx_ref', trim($search));
        }

		if($role == 'Customer') $builder->where('transaction.user_id', $log_id);
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	/// filter claim
    public function filter_claim($limit='', $offset='', $log_id='', $search='') {
		// get user type
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');

        $db = db_connect();
        $builder = $db->table('claim');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->select('claim.*, premium.partner_id, premium.policy_id, premium.code, premium.amount')
			->join('premium', 'premium.id = claim.premium_id');

        if(!empty($search)) {
            // $builder->like('tnx_ref', trim($search));
        }

		if($role == 'Customer') $builder->where('claim.user_id', $log_id);
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
    }

	
	//Filter Announements
	public function filter_announcement($limit='', $offset='', $user_id='', $search='') {
		$db = db_connect();
        $builder = $db->table('announcement');

		// build query
		$role_id = $this->read_field('id', $user_id, 'user', 'role_id');
		$role = strtolower($this->read_field('id', $role_id, 'access_role', 'name'));
		
		if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('content', $search);
        }
		// build query
		$builder->orderBy('id', 'DESC');
		
		
        // limit query
        if($limit && $offset) {
			$query = $builder->get($limit, $offset);
		} else if($limit) {
			$query = $builder->get($limit);
		} else {
            $query = $builder->get();
        }

        // return query
        return $query->getResult();
        $db->close();
	}
	/// timspan
	public function timespan($datetime) {
        $difference = time() - $datetime;
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        if ($difference > 0) { 
            $ending = 'ago';
        } else { 
            $difference = -$difference;
            $ending = 'to go';
        }
		
		for($j = 0; $difference >= $lengths[$j]; $j++) {
            $difference /= $lengths[$j];
        } 
        $difference = round($difference);

        if($difference != 1) { 
            $period = strtolower($periods[$j].'s');
        } else {
            $period = strtolower($periods[$j]);
        }

        return "$difference $period $ending";
	}


    //////////////////// MODULE ///////////////////////
	public function module($role, $module, $type) {
		$result = 0;
		
		$mod_id = $this->read_field('link', $module, 'access_module', 'id');
		$crud = $this->read_field('role_id', $role, 'access', 'crud');
		if($mod_id) {
			if(!empty($crud)) {
				$crud = json_decode($crud);
				foreach($crud as $cr) {
					$cr = explode('.', $cr);
					if($mod_id == $cr[0]) {
						if($type == 'create'){$result = $cr[1];}
						if($type == 'read'){$result = $cr[2];}
						if($type == 'update'){$result = $cr[3];}
						if($type == 'delete'){$result = $cr[4];}
						break;
					}
				}
			}
		}
		
		return $result;
	}
	public function mod_read($role, $module) {
		$rs = $this->module($role, $module, 'read');
		return $rs;
	}
	//////////////////// END MODULE ///////////////////////

}