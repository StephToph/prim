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

    public function check0($table){
		$db = db_connect();
        $builder = $db->table($table);
        
        return $builder->countAllResults();
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

	public function checks($field, $value, $field2, $value2, $field3, $value3, $field4, $value4, $field5, $value5, $table){
		$db = db_connect();
        $builder = $db->table($table);
        
        $builder->where($field, $value);
        $builder->where($field2, $value2);
        $builder->where($field3, $value3);
		$builder->where($field4, $value4);
        $builder->where($field5, $value5);

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
 
	public function datatable_count($table, $where='', $field='', $value='') {
		$db = db_connect();
        $builder = $db->table($table);
        
		// where clause
		if(!empty($where)) {
			$builder->where($field, $value);
		}

        return $builder->countAllResults();
        $db->close();
	} 
	//////////////////// END DATATABLE AJAX CRUD ///////////////////


    //////////////////// NOTIFICATION CRUD ///////////////////////
	public function msg($type = '', $text = ''){
		if($type == 'success'){
			$icon = 'ni ni-check-c';
			$icon_text = 'Successful!';
		} else if($type == 'info'){
			$icon = 'ri-information-line ';
			$icon_text = 'Head up!';
		} else if($type == 'warning'){
			$icon = 'ri-error-warning-line ';
			$icon_text = 'Please check!';
		} else if($type == 'danger'){
			$icon = 'ri-close-circle-line ';
			$icon_text = 'Oops!';
		}
		
		return '
			<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<div class="d-flex justify-content-start align-items-center">
					<i class="'.$icon.'" style="font-size:50px; margin-right:10px;"></i>
					<div>'.$text.'</div>
				</div>
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
			if($type == 'encryption') return 'FLWSECK_TEST996eada5e6e9';
			if($type == 'secret') return 'FLWSECK_TEST-515b1c5d609f89da24d5f256562b588f-X';
			return 'FLWPUBK_TEST-23d0dac840d0f3028893d2761462a39b-X';
		}
		// if($type == 'encryption') return '34b4f9e2604cbee6b044f85e';
		// if($type == 'secret') return 'FLWSECK-34b4f9e2604c6d80ca5ddad043084daa-X';
		// return 'FLWPUBK-fd6c33da431b9f0af1bbad6aa4a7dda1-X';
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
        $reg_data['path'] = $path;
        $reg_data['pics_small'] = $path;
        $reg_data['pics_square'] = $path;
        $reg_data['reg_date'] = date(fdate);
        return $this->create('file', $reg_data);
    }

	public function file_upload($path, $file, $width=0, $height=0, $ratio=true, $ration_by='width') {
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

	
	public function date_range1($firstDate, $col1, $secondDate, $col2,$col3, $val3, $table, $limit='', $offset=''){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		 
		 $builder->orderBy('id', 'ASC');
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
		   $builder->orderBy('id', 'ASC');
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

	public function date_range2($firstDate, $col1, $secondDate, $col2, $col3, $val3, $col4, $val4, $table, $limit='', $offset=''){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where($col4, $val4);		
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

	public function date_range3($firstDate, $col1, $secondDate, $col2, $col3, $val3, $col4, $val4, $col5, $val5, $table, $limit='', $offset=''){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where($col4, $val4);		
		$builder->where($col5, $val5);		
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

	public function date_check($firstDate, $col1, $secondDate, $col2, $table){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		$builder->orderBy('id', 'DESC');

        return $builder->countAllResults();
        $db->close();
	}

	

	public function date_group_check1($firstDate, $col1, $secondDate, $col2, $col3, $val3, $group, $table){
		$db = db_connect();
		$db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $builder = $db->table($table);

		$builder->groupBy($group);
		$builder->where($col3, $val3);
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		$builder->orderBy('id', 'DESC');

        return $builder->countAllResults();
        $db->close();
	}

	public function date_check1($firstDate, $col1, $secondDate, $col2, $col3, $val3, $table){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		   $builder->orderBy('id', 'DESC');

		   return $builder->countAllResults();
		   $db->close();
	}

	public function date_check2($firstDate, $col1, $secondDate, $col2, $col3, $val3, $col4, $val4, $table){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where($col4, $val4);		
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		$builder->orderBy('id', 'DESC');

		return $builder->countAllResults();
		$db->close();
	}

	public function date_check3($firstDate, $col1, $secondDate, $col2, $col3, $val3, $col4, $val4, $col5, $val5, $table){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where($col4, $val4);		
		$builder->where($col5, $val5);		
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		   $builder->orderBy('id', 'DESC');

		   return $builder->countAllResults();
		   $db->close();
	}

	public function date_check4($firstDate, $col1, $secondDate, $col2, $col3, $val3, $col4, $val4, $col5, $val5,$col6, $val6, $table){
		$db = db_connect();
        $builder = $db->table($table);

		$builder->where($col3, $val3);
		$builder->where($col4, $val4);		
		$builder->where($col5, $val5);
		$builder->where($col6, $val6);		
		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') >= '".$firstDate."'",NULL,FALSE);
   		$builder->where("DATE_FORMAT(".$col1.",'%Y-%m-%d') <= '".$secondDate."'",NULL,FALSE);
		   $builder->orderBy('id', 'DESC');

		   return $builder->countAllResults();
		   $db->close();
	}
	//////////////////// END DATETIME ///////////////////////

	//////////////////// IMAGE DATA //////////////////
	public function image($id, $size='small') {
		if($id) {
			if($size == 'small') {
				$path = $this->read_field('id', $id, 'file', 'pics_small');
			} else if($size == 'big') {
				$path = $this->read_field('id', $id, 'file', 'path');
			} else {
				$path = $this->read_field('id', $id, 'file', 'pics_square');
			}
		} 

		if(empty($path) || !file_exists($path)) {
			$path = 'assets/backend/images/avatar.png';
		}

		return $path;
	}
	//////////////////// END /////////////////

	//////////////////// IMAGE DATA //////////////////
	public function file($id) {
		if($id) {
			$ext = $this->read_field('id', $id, 'file', 'ext');
			$ext = str_replace('x', '', $ext);
			$path = 'assets/backend/images/docs/'.$ext.'-128.png';
		} 

		if(empty($path) || !file_exists($path)) {
			$path = 'assets/backend/images/docs/txt-128.png';
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

	public static function wordsToNumber(string $input) {
        static $delims = " \-,.!?:;\\/&\(\)\[\]";
        static $tokens = [
            'zero'        => ['val' => '0', 'power' => 1],
            'a'           => ['val' => '1', 'power' => 1],
            'first'       => ['val' => '1', 'power' => 1],
            '1st'       => ['val' => '1', 'power' => 1],
            'one'         => ['val' => '1', 'power' => 1],
            'second'      => ['val' => '2', 'power' => 1],
            '2nd'      => ['val' => '2', 'power' => 1],
            'two'         => ['val' => '2', 'power' => 1],
            'third'       => ['val' => '3', 'power' => 1],
            '3rd'       => ['val' => '3', 'power' => 1],
            'three'       => ['val' => '3', 'power' => 1],
            'fourth'      => ['val' => '4', 'power' => 1],
            '4th'      => ['val' => '4', 'power' => 1],
            'four'       => ['val' => '4', 'power' => 1],
            'fifth'       => ['val' => '5', 'power' => 1],
            '5th'       => ['val' => '5', 'power' => 1],
            'five'        => ['val' => '5', 'power' => 1],
            'sixth'       => ['val' => '6', 'power' => 1],
            '6th'       => ['val' => '6', 'power' => 1],
            'six'         => ['val' => '6', 'power' => 1],
            'seventh'     => ['val' => '7', 'power' => 1],
            '7th'     => ['val' => '7', 'power' => 1],
            'seven'       => ['val' => '7', 'power' => 1],
            'eighth'      => ['val' => '8', 'power' => 1],
            '8th'      => ['val' => '8', 'power' => 1],
            'eight'       => ['val' => '8', 'power' => 1],
            'ninth'       => ['val' => '9', 'power' => 1],
            '9th'       => ['val' => '9', 'power' => 1],
            'nine'        => ['val' => '9', 'power' => 1],
            'tenth'       => ['val' => '10', 'power' => 1],
            '10th'       => ['val' => '10', 'power' => 1],
            'ten'         => ['val' => '10', 'power' => 10],
            'eleventh'    => ['val' => '11',  'power' => 10],
            '11th'    => ['val' => '11',  'power' => 10],
            'eleven'      => ['val' => '11', 'power' => 10],
            'twelveth'    => ['val' => '12',  'power' => 10],
            '12th'    => ['val' => '12',  'power' => 10],
            'twelfth'    => ['val' => '12',  'power' => 10],
            'twelve'      => ['val' => '12', 'power' => 10],
            'thirteenth'  => ['val' => '13',  'power' => 10],
            '13th'  => ['val' => '13',  'power' => 10],
            'thirteen'    => ['val' => '13', 'power' => 10],
            'fourteenth'  => ['val' => '14',  'power' => 10],
            '14th'  => ['val' => '14',  'power' => 10],
            'fourteen'    => ['val' => '14', 'power' => 10],
            'fifteenth'   => ['val' => '15',  'power' => 10],
            '15th'   => ['val' => '15',  'power' => 10],
            'fifteen'     => ['val' => '15', 'power' => 10],
            'sixteenth'   => ['val' => '16',  'power' => 10],
            '16th'   => ['val' => '16',  'power' => 10],
            'sixteen'     => ['val' => '16', 'power' => 10],
            'seventeenth' => ['val' => '17',  'power' => 10],
            '17th' => ['val' => '17',  'power' => 10],
            'seventeen'   => ['val' => '17', 'power' => 10],
            'eighteenth'  => ['val' => '18',  'power' => 10],
            '18th'  => ['val' => '18',  'power' => 10],
            'eighteen'    => ['val' => '18', 'power' => 10],
            'nineteenth'  => ['val' => '19',  'power' => 10],
            '19th'  => ['val' => '19',  'power' => 10],
            'nineteen'    => ['val' => '19', 'power' => 10],
            'twentieth'   => ['val' => '20',  'power' => 10],
            '20th'   => ['val' => '20',  'power' => 10],
            'twenty'      => ['val' => '20', 'power' => 10],
            'twenty first'   => ['val' => '21',  'power' => 10],
            '21st'   => ['val' => '21',  'power' => 10],
            'twenty one' => ['val' => '21', 'power' => 10],
            'twenty second '   => ['val' => '22',  'power' => 10],
            '22nd'   => ['val' => '22',  'power' => 10],
            'twenty two'      => ['val' => '22', 'power' => 10],
            'twenty third'   => ['val' => '23',  'power' => 10],
            '23rd'   => ['val' => '23',  'power' => 10],
            'twenty three'      => ['val' => '23', 'power' => 10],
            'twenty fourth'   => ['val' => '24',  'power' => 10],
            '24th'   => ['val' => '24',  'power' => 10],
            'twenty four'      => ['val' => '24', 'power' => 10],
            'twenty fifth'   => ['val' => '25',  'power' => 10],
            '25th'   => ['val' => '25',  'power' => 10],
            'twenty five'      => ['val' => '25', 'power' => 10],
            'twenty sixth'   => ['val' => '26',  'power' => 10],
            '26th'   => ['val' => '26',  'power' => 10],
            'twenty six'      => ['val' => '26', 'power' => 10],
            'twenty seventh'   => ['val' => '27',  'power' => 10],
            '27th'   => ['val' => '27',  'power' => 10],
            'twenty seven'      => ['val' => '27', 'power' => 10],
            'twenty eighth'   => ['val' => '28',  'power' => 10],
            '28th'   => ['val' => '28',  'power' => 10],
            'twenty eight'      => ['val' => '28', 'power' => 10],
            'twenty nineth'   => ['val' => '29',  'power' => 10],
            '29th'   => ['val' => '29',  'power' => 10],
            'twenty nine'      => ['val' => '29', 'power' => 10],
            'thirtieth'   => ['val' => '30',  'power' => 10],
            '30th'   => ['val' => '30',  'power' => 10],
            'thirty first'   => ['val' => '31',  'power' => 10],
            '31st'   => ['val' => '31',  'power' => 10],
            'thirty one'      => ['val' => '31', 'power' => 10],
            'thirty'      => ['val' => '30', 'power' => 10],
            'forty'       => ['val' => '40', 'power' => 10],
            'fourty'      => ['val' => '40', 'power' => 10], // common misspelling
            'fifty'       => ['val' => '50', 'power' => 10],
            'sixty'       => ['val' => '60', 'power' => 10],
            'seventy'     => ['val' => '70', 'power' => 10],
            'eighty'      => ['val' => '80', 'power' => 10],
            'ninety'      => ['val' => '90', 'power' => 10],
            'hundred'     => ['val' => '100', 'power' => 100],
            'thousand'    => ['val' => '1000', 'power' => 1000],
            'million'     => ['val' => '1000000', 'power' => 1000000],
            'billion'     => ['val' => '1000000000', 'power' => 1000000000],
            'and'           => ['val' => '', 'power' => null],
        ];
        $powers = array_column($tokens, 'power', 'val');

        $mutate = function ($parts) use (&$mutate, $powers){
            $stack = new \SplStack;
            $sum   = 0;
            $last  = null;

            foreach ($parts as $idx => $arr) {
                $part = $arr['val'];

                if (!$stack->isEmpty()) {
                    $check = $last ?? $part;

                    if ((float)$stack->top() < 20 && (float)$part < 20 ?? (float)$part < $stack->top() ) { //пропускаем спец числительные
                        return $stack->top().(isset($parts[$idx - $stack->count()]['suffix']) ? $parts[$idx - $stack->count()]['suffix'] : '')." ".$mutate(array_slice($parts, $idx));
                    }
                    if (isset($powers[$check]) && $powers[$check] <= $arr['power'] && $arr['power'] <= 10) { //но добавляем степени (сотни, тысячи, миллионы итп)
                        return $stack->top().(isset($parts[$idx - $stack->count()]['suffix']) ? $parts[$idx - $stack->count()]['suffix'] : '')." ".$mutate(array_slice($parts, $idx));
                    }
                    if ($stack->top() > $part) {
                        if ($last >= 1000) {
                            $sum += $stack->pop();
                            $stack->push($part);
                        } else {
                            // twenty one -> "20 1" -> "20 + 1"
                            $stack->push($stack->pop() + (float) $part);
                        }
                    } else {
                        $current = $stack->pop();
                        if (is_numeric($current)) {
                            $stack->push($current * (float) $part);
                        } else {
                            $stack->push($part);
                        }
                    }
                } else {
                    $stack->push($part);
                }

                $last = $part;
            }

            return $sum + $stack->pop();
        };

        $prepared = preg_split('/(['.$delims.'])/', $input, -1, PREG_SPLIT_DELIM_CAPTURE);

        //Замена на токены
        foreach ($prepared as $idx => $word) {
            if (is_array($word)) {continue;}
            $maybeNumPart = trim(strtolower($word));
            if (isset($tokens[$maybeNumPart])) {
                $item = $tokens[$maybeNumPart];
                if (isset($prepared[$idx+1])) {
                    $maybeDelim = $prepared[$idx+1];
                    if ($maybeDelim === " ") {
                        $item['delim'] = $maybeDelim;
                        unset($prepared[$idx + 1]);
                    } elseif ($item['power'] == null && !isset($tokens[$maybeDelim])) {
                        continue;
                    }
                }
                $prepared[$idx] = $item;
            }
        }

        $result      = [];
        $accumulator = [];

        $getNumeral = function () use ($mutate, &$accumulator, &$result) {
            $last        = end($accumulator);
            $result[]    = $mutate($accumulator).(isset($last['suffix']) ? $last['suffix'] : '').(isset($last['delim']) ? $last['delim'] : '');
            $accumulator = [];
        };

        foreach ($prepared as $part) {
            if (is_array($part)) {
                $accumulator[] = $part;
            } else {
                if (!empty($accumulator)) {
                    $getNumeral();
                }
                $result[] = $part;
            }
        }
        if (!empty($accumulator)) {
            $getNumeral();
        }

        return implode('', array_filter($result));
 
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

    /// filter user
    public function filter_user($limit='', $offset='', $log_id, $state_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
		if(!empty($state_id)) $builder->where('state_id', $state_id);
		
        if(!empty($search)) {
            $builder->like('fullname', $search);
			$builder->orLike('email', $search);
			$builder->orLike('phone', $search);
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

	//////////////////////////filter admin//////////////////////////////////
    public function filter_admin($limit='', $offset='', $log_id, $state_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->where('role_id', 2);

		if(!empty($status)){
			if($status != 'all') { 
				if($status == 'activated')$builder->where('activate', 1);
				if($status == 'pending')$builder->where('activate', 0);
			}
		} 
		
        if(!empty($search)) {
            $builder->like('fullname', $search);
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

	//////////////////////////filter support//////////////////////////////////
    public function filter_rhapsody($limit='', $offset='', $log_id, $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('rhapsody');

        // build query
		$builder->orderBy('id', 'DESC');

		if(!empty($status)){
			if($status != 'all') { 
				$builder->where('status', $status);
			}
		} 
		
        if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('content', $search);
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

	public function filter_language($limit='', $offset='', $log_id, $search='') {
        $db = db_connect();
        $builder = $db->table('language');

        // build query
		$builder->orderBy('name', 'ASC');

        if(!empty($search)) {
            $builder->like('name', $search);
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

	//// filter wallet
	public function filter_wallet($limit='', $offset='', $user_id, $product_id='',$station_id='',  $country_id='',$state='',  $lga='',$branch='', $search='', $start_date='', $end_date) {
		$db = db_connect();
        $builder = $db->table('wallet');

        // build query
		$builder->orderBy('id', 'DESC');

		// build query
		$role_id = $this->read_field('id', $user_id, 'user', 'role_id');
		$role = strtolower($this->read_field('id', $role_id, 'access_role', 'name'));
		if($role != 'developer' && $role != 'administrator'){
			if($role == 'partner') {
				$builder->where('station_id', $user_id);

			} else {
				if($role == 'manager'){
					$branch_id = $this->read_field('id', $user_id, 'user', 'branch_id');
					$builder->where('branch_id', $branch_id);
				} 
			} 
		} else {
			$builder->where('user_id', $user_id);
		} 
		// filter
		if(!empty($search)) {
            $builder->like('amount', $search);
        }
		if(!empty($product_id) && $product_id != 'all') { $query = $builder->where('product_id', $product_id); }
		if(!empty($station_id) && $station_id != 'all') { $query = $builder->where('station_id', $station_id); }
		if(!empty($country_id) && $country_id != 'all') { $query = $builder->where('country_id', $country_id); }
		if(!empty($state) && $state != 'all') { $query = $builder->where('state_id', $state); }
		if(!empty($lga) && $lga != 'all') { $query = $builder->where('lga_id', $lga); }
		if(!empty($branch) && $branch != 'all') { $query = $builder->where('branch_id', $branch); }
		
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
	

	//////////////////////////filter pump//////////////////////////////////
    
	public function filter_pump($limit='', $offset='', $log_id, $partner='', $search='') {
        $db = db_connect();
        $builder = $db->table('pump');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role != 'Developer' && $role != 'Administrator'){
			$builder->where('user_id', $log_id);
		}

		if(!empty($partner) && $partner != 'all') $builder->where('user_id', $partner);
		
        if(!empty($search)) {
            $builder->like('name', $search);
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
	//////////////////////////filter branch//////////////////////////////////
    
	public function filter_branch($limit='', $offset='', $log_id, $partner='', $search='') {
        $db = db_connect();
        $builder = $db->table('branch');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role != 'Developer' && $role != 'Administrator'){
			$builder->where('partner_id', $log_id);
		}

		if(!empty($partner) && $partner != 'all') $builder->where('partner_id', $partner);
		
        if(!empty($search)) {
            $builder->like('name', $search);
			$builder->orLike('address', $search);
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

	//////////////////////////filter admin//////////////////////////////////
    public function filter_customers($limit='', $offset='', $log_id, $state_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->where('role_id', 4);

		if(!empty($status)){
			if($status != 'all') { 
				if($status == 'activated')$builder->where('activate', 1);
				if($status == 'pending')$builder->where('activate', 0);
			}
		} 
		
        if(!empty($search)) {
            $builder->like('fullname', $search);
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

	//////////////////////////filter partner//////////////////////////////////
    public function filter_partner($limit='', $offset='', $log_id, $state_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

        // build query
		$builder->orderBy('id', 'DESC');
		//$builder->where('role_id', 3);
		$builder->where('is_partner', 1);

		if(!empty($status)){
			if($status != 'all') { 
				if($status == 'activated')$builder->where('activate', 1);
				if($status == 'pending')$builder->where('activate', 0);
			}
		} 
		
        if(!empty($search)) {
            $builder->like('fullname', $search);
			$builder->like('email', $search);
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

	//////////////////////////filter partner//////////////////////////////////
    public function filter_staff($limit='', $offset='', $log_id, $state_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('user');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$branch_id = $this->read_field('id', $log_id, 'user', 'branch_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role != 'Developer' && $role != 'Administrator'){
			if($role == 'Manager'){
				$builder->where('branch_id', $branch_id);
			} else {
				$builder->where('partner_id', $log_id);
			}
		}

        // build query
		$builder->orderBy('id', 'DESC');
		$builder->where('is_staff', 1);
		//$builder->where('is_partner', 1);

		if(!empty($status)){
			if($status != 'all') { 
				if($status == 'activated')$builder->where('activate', 1);
				if($status == 'pending')$builder->where('activate', 0);
			}
		} 
		
        if(!empty($search)) {
            $builder->like('fullname', $search);
			$builder->like('email', $search);
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

	
	public function filter_quiz($limit='', $offset='', $log_id, $search='') {
        $db = db_connect();
        $builder = $db->table('quiz');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('instructor', $log_id);
		}
        if(!empty($search)) {
            $builder->like('name', $search);
			$builder->orLike('instruction', $search);
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

	//////// Location Distance
	public function getDistance($addressFrom, $addressTo, $unit = ''){
		// Google API key
		$apiKey = 'AIzaSyAx0GVgtUc8BYdE7Vd4ijUW2n0786pwCSo';
		
		// Change address format
		$formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
		$formattedAddrTo     = str_replace(' ', '+', $addressTo);
		
		// Geocoding API request with start address
		$geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
		$outputFrom = json_decode($geocodeFrom);
		
		// Geocoding API request with end address
		$geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
		$outputTo = json_decode($geocodeTo);
		if(!empty($outputTo->error_message)){
			return $outputTo->error_message;
		}

		if(!empty($outputFrom->error_message) || !empty($outputTo->error_message)){
			return 0;
		}
		
		// Get latitude and longitude from the geodata
		if(!empty($outputFrom->results[0]) && !empty($outputTo->results[0])){
			$latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
			$longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
			$latitudeTo        = $outputTo->results[0]->geometry->location->lat;
			$longitudeTo    = $outputTo->results[0]->geometry->location->lng;
			
			// Calculate distance between latitude and longitude
			$theta    = $longitudeFrom - $longitudeTo;
			$dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
			$dist    = acos($dist);
			$dist    = rad2deg($dist);
			$miles    = $dist * 60 * 1.1515;
			
			// Convert unit and return distance
			$unit = strtoupper($unit);
			if($unit == "K") {
				return round($miles * 1.609344, 2);
			} elseif($unit == "M") {
				return round($miles * 1609.344, 2);
			} else {
				return round($miles, 2);
			}
		} else {
			// return 0 if distance not found
			return 0;
		}
	}

	////// store activities
	public function activity($item, $item_id, $action) {
		$ins['item'] = $item;
		$ins['item_id'] = $item_id;
		$ins['action'] = $action;
		$ins['reg_date'] = date(fdate);
		return $this->create('activity', $ins);
	}


	//// filter activities
	public function filter_activity($limit='', $offset='', $user_id, $search='', $start_date='', $end_date) {
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

	public function filter_chapter($limit='', $offset='', $log_id, $course, $search='') {
        $db = db_connect();
        $builder = $db->table('course_chapter');

		$builder->where('course_id', $course);
		
        if(!empty($search)) {
            $builder->like('title', $search);
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

	public function filter_assignment($limit='', $offset='', $log_id, $search='') {
        $db = db_connect();
        $builder = $db->table('assignment');
		
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('instructor', $log_id);
		}
        if(!empty($search)) {
            $builder->like('name', $search);
			$builder->orLike('details', $search);
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

	public function filter_enrollments($limit='', $offset='', $log_id, $course, $instructor, $search='') {
        $db = db_connect();
        $builder = $db->table('enrolment');
		
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('instructor_id', $log_id);
		}
        if(!empty($instructor) && $instructor != 'all') {
            $builder->where('instructor_id', $instructor);
        }
		if(!empty($course) && $course != 'all') {
			$builder->where('course_id', $course);
        }
		if(!empty($search)) {
            $builder->like('schedule', $search);
			$builder->orLike('amount', $search);
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

	public function filter_quiz_question($limit='', $offset='', $log_id, $course, $search='') {
        $db = db_connect();
        $builder = $db->table('quiz_question');
		// build query
		$builder->orderBy('id', 'DESC');
		
		$builder->like('quiz_id', $course);
        if(!empty($search)) {
            $builder->like('question', $search);
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

	public function filter_category($limit='', $offset='', $log_id, $course, $search='') {
        $db = db_connect();
        $builder = $db->table('categories');
		// build query
		$builder->orderBy('id', 'DESC');
		
		if(!empty($search)) {
            $builder->like('name', $search);
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


	 /// filter resources
	 public function filter_resources($limit='', $offset='', $log_id, $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('resources');

        // build query
		$builder->orderBy('id', 'DESC');
		if(!empty($status)) $builder->where('approved', $status);
		
        if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('summary', $search);
			$builder->orLike('content', $search);
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

	 /// filter resources
	 public function filter_courses($limit='', $offset='', $log_id, $programme='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('course');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('instructors', $log_id);
		}
        // build query
		$builder->orderBy('id', 'DESC');
		if(!empty($status)) $builder->where('publish', $status);
		
		if(!empty($programme)) $builder->where('is_programme', $programme);
		
        if(!empty($search)) {
            $builder->like('title', $search);
			$builder->orLike('details', $search);
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

    /// filter product
    public function filter_product($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('product');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('user_id', $log_id);
		}
        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($search)) {
            $builder->like('name', $search);
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

	/// filter order
    public function filter_order($limit='', $offset='', $log_id, $status='', $product_id='',$station_id='',  $country_id='',$state='',  $lga='',$branch='', $search='', $start_date='', $end_date) {
        $db = db_connect();
        $builder = $db->table('order');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Partner'){
			$builder->where('partner_id', $log_id);
		}
        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($status) && $status != 'all') {
            $builder->like('status', $status);
        }
		if(!empty($search)) {
            $builder->like('code', $search);
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

	/// filter order
    public function filter_sales($limit='', $offset='', $log_id, $status='', $product_id='',$station_id='',  $country_id='',$state='',  $lga='',$branch='', $search='', $start_date='', $end_date) {
        $db = db_connect();
        $builder = $db->table('order');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Partner'){
			$builder->where('partner_id', $log_id);
		} else{
			$partner_id = $this->Crud->read_field('id', $log_id, 'user', 'partner_id');
			$branch_id = $this->Crud->read_field('id', $log_id, 'user', 'branch_id');
			$builder->where('partner_id', $partner_id);
			$builder->where('branch_id', $branch_id);
		}
        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($status) && $status != 'all') {
            $builder->like('status', $status);
        }
		if(!empty($search)) {
            $builder->like('code', $search);
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

	/// filter scholar
    public function filter_scholar($limit='', $offset='', $log_id='', $status='', $search='') {
        $db = db_connect();
        $builder = $db->table('scholarship');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Sponsor'){
			$builder->orderBy('sponsor_id', $log_id);
		}
        // build query
		$builder->orderBy('id', 'DESC');

        if(!empty($status) && $status != 'all') {
            $builder->like('status', $status);
        }
		if(!empty($search)) {
            $builder->like('name', $search);
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
    public function filter_reels($limit='', $offset='', $log_id='', $search='') {
        $db = db_connect();
        $builder = $db->table('tv');

        // build query
		$builder->orderBy('id', 'DESC');

		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');
		if($role == 'Instructor'){
			$builder->where('user_id', $log_id);
		}

        if(!empty($search)) {
            $builder->like('instructor', $search);
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
        //$builder->where('is_customer', 1);
		$builder->where('role_id', 4);

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

	/// filter payments
    public function filter_payment($limit='', $offset='', $log_id='', $search='') {
		// get user type
		$role_id = $this->read_field('id', $log_id, 'user', 'role_id');
		$role = $this->read_field('id', $role_id, 'access_role', 'name');

        $db = db_connect();
        $builder = $db->table('payment');

        // build query
		$builder->orderBy('id', 'DESC');
		if($role == 'Instructor'){
			$builder->where('instructor_id', $log_id);
		}
        if(!empty($search)) {
            $builder->like('item', trim($search));
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