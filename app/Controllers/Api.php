<?php 

namespace App\Controllers;

class Api extends BaseController {
	private $token;
	private $db;

	public function __construct() {
		$this->db = \Config\Database::connect();

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
		header("Content-Type: application/json; charset=UTF-8");

		$this->token = 'EAACva1Mk73MBAPCKAh12445IAxF01sWkiFYAwcViL6MXEi';

		// check token
		$token = null;
		$headers = apache_request_headers();
		if(isset($headers['Authorization'])){
			$token = $headers['Authorization'];
			$token = explode(' ', $token)[1];
		}

		if($this->token != $token) {
			echo json_encode(array('status' => false, 'msg' => 'Invalid Token'));
			die;
		}
    }
	
	public function index() { }
	
	// register
	public function register() {
	    $status = false;
		$data = array();
		$msg = '';
		
		// collect call paramters
		$call = json_decode(file_get_contents("php://input"));
		$title = $call->title;
		$fullname = $call->fullname;
		$email = $call->email;
		$password = $call->password;
		$phone = $call->phone;
		$country = $call->country;
		
		if($fullname && $email && $password && $phone && $country) {
			// check if email already exists
			if($this->Crud->check('email', $email, 'user') > 0 || $this->Crud->check('phone', $phone, 'user') > 0) {
				$msg = 'Email and/or Phone Taken! Please choose another.';
			} else {
				$role_id = $this->Crud->read_field('name', 'User', 'access_role', 'id');
				$ins['title'] = $title;
				$ins['fullname'] = $fullname;
				$ins['email'] = $email;
				$ins['password'] = md5($password);
				$ins['phone'] = $phone;
				$ins['country_id'] = $this->Crud->read_field('name', $country, 'country', 'id');
				$ins['role_id'] = $role_id;
				$ins['reg_date'] = date(fdate);
				$user_id = $this->Crud->create('user', $ins);
				if($user_id > 0) {
					$status = true;
					$msg = 'Successful!';
					$data['id'] = $user_id;
				} else {
					$msg = 'Oops! Try later';
				}
			}
		} else {
			$msg = 'Missing field.';
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// login
	public function login() {
	    $status = false;
		$data = array();
		$msg = '';
		
		// collect call paramters
		$call = json_decode(file_get_contents("php://input"));
		$email = $call->email;
		$password = $call->password;
		
		if($email && $password) {
			$password = md5($call->password);
			$type = 'email';
		    $query = $this->Crud->read2('email', $email, 'password', $password, 'user');
			if(empty($query)) {
				$type = 'phone';
				$query = $this->Crud->read2('phone', $email, 'password', $password, 'user');
			}

		    if(empty($query)) {
		        $msg = 'Invalid Authentication!';
		    } else {
				$status = true;
				$msg = 'Login Successful!';

				$id = $this->Crud->read_field($type, $email, 'user', 'id');
		        $data = $this->user_data($id);
		    }
		} else {
			$msg = 'Missing field(s).';
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// reset code
	public function reset_code() {
		$status = false;
		$data = array();
		$msg = '';
		
		// collect call paramters
		$call = json_decode(file_get_contents("php://input"));
		$email = $call->email;
		
		if($email) {
		    $user_id = $this->Crud->read_field('email', $email, 'user', 'id');
		    if(empty($user_id)) {
		        $msg = 'Invalid Email!';
		    } else {
				$code = substr(md5(time().rand()), 0, 6);
				if($this->Crud->updates('id', $user_id, 'user', array('reset_code'=>$code)) > 0) {
					$status = true;
					$msg = 'Login Successfully!';
					$data['code'] = $code;

					$fullname = $this->Crud->read_field('id', $user_id, 'user', 'fullname');

					// email content
					$bcc = '';
					$subject = 'Reset Code';
					$body = '
						<b>Dear '.$fullname.'</b>,<br/><br/>
						You requested to reset your account password. Your secret code is '.$code.'.<br/><br/>
						<i>If you do not request this action, please ignore. Your account will be protected.</i><br/><br/>
						Thank you.<br/>
					';
					$this->Crud->send_email($email, $subject, $body, $bcc);
				}
		    }
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// reset password
	public function reset_password() {
		$status = false;
		$data = array();
		$msg = '';
		
		// collect call paramters
		$call = json_decode(file_get_contents("php://input"));
		$email = $call->email;
		$password = $call->password;
		
		if($email && $password) {
		    $user_id = $this->Crud->read_field('email', $email, 'user', 'id');
		    if(empty($user_id)) {
		        $msg = 'Invalid Email!';
		    } else {
				if($this->Crud->updates('id', $user_id, 'user', array('password'=>md5($password))) > 0) {
					$status = true;
					$msg = 'Password Reset Successfully!';
				}
		    }
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// profile
	public function profile($id, $type='get') {
		$status = false;
		$data = array();
		$msg = '';

		/// GET
		if($type == 'get') {
			$status = true;
			$data = $this->user_data($id);
			$msg = 'Successful';
		}

		/// UPDATE
		if($type == 'update') {
			// collect call paramters
			$call = json_decode(file_get_contents("php://input"));
			$field = $call->field;
			$value = $call->value;

			if($field == 'password') $value = md5($value);

			$process = true;

			// check email
			if($field == 'email') {
				$old_email = $this->Crud->read_field('id', $id, 'user', 'email');
				if($old_email != $value) {
					if($this->Crud->check('email', $value, 'user') > 0) {
						$process = false;
						$msg = 'Email already exists!';
					}
				}
			} 

			// process update
			if($process == true) {
				$this->Crud->updates('id', $id, 'user', array($field=>$value));
				$status = true;
				$msg = 'Successful!';
				$data = $this->user_data($id);
			}
		}

		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// intent
	public function intent() {
		$status = false;
		$msg = '';
		$data = array();

		// collect call paramters
		$call = json_decode(file_get_contents("php://input"));
		$user_id = $call->user_id;
		$intent = $call->intent;
		
		$lang_id = $this->Crud->read_field('id', $user_id, 'user', 'lang_id');

		if(empty($lang_id)) {
			$lang_id = $this->Crud->read_field('name', 'English', 'language', 'id');
			$this->Crud->updates('id', $user_id, 'user', array('lang_id'=>$lang_id));
		}	
		$lang = strtolower($this->Crud->read_field('id', $lang_id, 'language', 'name'));
		if($lang == 'english') $lang_id = $this->Crud->read_field2('country', 'United States', 'name', 'English', 'language', 'id');


		if($user_id && $intent) {
			$intent = strtolower($intent); // utterance

			// greetings
			$greatings = $this->phrase('greetings');
			foreach($greatings as $key=>$value) {
				if($this->find($intent, $value) === true) {
					$data = $this->execute($user_id, $lang_id, 'greetings', $value, $intent);
					
					$status = true;
					echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
					die;
				}
			}

			// language
			$languages = $this->phrase('language');
			foreach($languages as $key=>$value) {
				if($this->find($intent, $value) === true) {
					$data = $this->execute($user_id, $lang_id, 'language', $value, $intent);
					
					$status = true;
					echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
					die;
				}
			}

			// rhapsody search
			

			// rhapsody
			$rhapsodys = $this->phrase('rhapsody');
			foreach($rhapsodys as $key=>$value) {
				if($this->find($intent, $value) === true) {
					$data = $this->execute($user_id, $lang_id, 'rhapsody', $value, $intent);
					
					$status = true;
					echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
					die;
				}
			}

			/// intent not found
			$data = 'Sorry!, I do not understand what you mean. But will find out for you soon';
			$status = true;
			echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
			die;
		}
	}
	private function phrase($type) {
		// greetings
		if($type == 'greetings') {
			return array('hi', 'hello', 'how are you', 'how are you doing', 'hey', 'whats up', 'watz up', 'fine');
		}

		// language
		if($type == 'language') {
			return array('use', 'set language to', 'switch to');
		}

		// rhapsody
		if($type == 'rhapsody') {
			return array('rhapsody');
		}
	}
	private function rhapsody_execute($msg, $lang_id){
		$action = explode(' ', $msg);

		$msg = str_replace($action[0] , '', $msg);
		if($action[1] == 'the'){
			$msg = str_replace('the ', '', $msg);
		}

		if($action[0] == 'from'){
			// for last, next and this
			if($action[1] == 'last' || $action[1] == 'next' || $action[1] == 'this' || $action[1] == 'yesterday'|| $action[1] == 'today'|| $action[1] == 'tomorrow'){
				if($action[1] == 'yesterday' || $action[1] == 'today'|| $action[1] == 'tomorrow'){
					$msg = str_replace($action[1].' ', '', $msg);
					$start_date = date('Y-m-d', strtotime($action[1]));
					$end_date = date(fdate);
					if(!empty($action[2])){
						if($action[2] == 'to'){
							$msg = str_replace('to ', '', $msg);
							$end_date = date('Y-m-d', strtotime($msg));	
						}
					}
				}
				 
				if($action[1] == 'last'  || $action[1] == 'next' || $action[1] == 'this'){
					$msg = str_replace($action[1].' '.$action[2], '', $msg);
					$start_date = date('Y-m-d', strtotime($action[1].' '.$action[2]));
					$end_date = date(fdate);
					if(!empty($action[3])){
						if($action[3] == 'to'){
							$msg = str_replace('to ', '', $msg);
							$end_date = date('Y-m-d', strtotime($msg));	
						}
					}

				}
				$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date', 'language', $lang_id, 'rhapsody');
			} else {
				if(ctype_digit(strval($action[1]))) {
					if($action[1] <= 31){
						if($action[2] == 'to'){
							if(!empty($action[5]) && ctype_digit(strval($action[5]))){
								$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[4].'-'.$action[5]));
								$end_date = date('Y-m-d', strtotime($action[3].'-'.$action[4].'-'.$action[5]));
							} else {
								$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[4]));
								$end_date = date('Y-m-d', strtotime($action[3].'-'.$action[4]));
							}
							
						} else {
							$msg = str_replace($action[1].' '.$action[2].' ', '', $msg);
							$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[2]));
							$end_date = date('Y-m-d');
							if(!empty($action[3]) && ctype_digit(strval($action[3]))){
								$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[2].'-'.$action[3]));
								if(!empty($action[4])){
									if($action[4] == 'to'){
										$msg = str_replace('to ', '', $msg);
										$end_date = date('Y-m-d', strtotime($msg));	
									}
								}
							} else {
								if(!empty($action[3])){
									if($action[3] == 'to'){
										$msg = str_replace('to ', '', $msg);
										$end_date = date('Y-m-d', strtotime($msg));	
									}
								}
							}

						}
						
						$query =  $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
						$response[] = $query;
						return $response;
						
					} else {
						$start_msg = '01-'.$action[2].'-'.$action[1];
						$end_date = date('Y-m-d');
						if(!empty($action[3]) && ctype_digit(strval($action[3]))) {
							$start_msg = $action[3].'-'.$action[2].'-'.$action[1];
							if(!empty($action[4])){
								if($action[4] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' '.$action[3].' to ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							}
						}
						$start_date = date('Y-m-d', strtotime($start_msg));
						if(!empty($action[3]) && $action[3] == 'to'){
							$msg = str_replace($action[1].' '.$action[2].' to ', '', $msg);
							$end_date = date('Y-m-d', strtotime($msg));
						}

						//echo $start_msg.' '.$end_date;die;
						$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
						$response[] = $query;
						return $response;
					}
				}
				
				if(ctype_digit(strval($action[2]))) {
					if($action[2] <= 31){
						if($action[3] == 'to' && empty($action[5])){
							$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[2]));
							$end_date = date('Y-m-d', strtotime($action[1].'-'.$action[4]));
							
						} else {
							$msg = str_replace($action[1].' '.$action[2].' ', '', $msg);
							$start_date = date('Y-m-d', strtotime($action[1].'-'.$action[2]));
							$end_date = date('Y-m-d');
							if(!empty($action[3]) && ctype_digit(strval($action[3]))){
								$start_date = date('Y-m-d', strtotime($action[2].'-'.$action[1].'-'.$action[3]));
								if(!empty($action[4])){
									if($action[4] == 'to'){
										$msg = str_replace('to ', '', $msg);
										$end_date = date('Y-m-d', strtotime($msg));	
									}
								}
							} else {
								if(!empty($action[3])){
									if($action[3] == 'to'){
										$msg = str_replace('to ', '', $msg);
										$end_date = date('Y-m-d', strtotime($msg));	
									}
								}
							}


						}
						
						//echo $start_date;die;

						$query =  $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
						$response[] = $query;
						return $response;
					} else {
						$start_msg = '01-'.$action[2].'-'.$action[1];
						$end_date = date('Y-m-d');
						if(!empty($action[3]) && ctype_digit(strval($action[3]))) {
							$start_msg = $action[3].'-'.$action[2].'-'.$action[1];
							if(!empty($action[4])){
								if($action[4] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' '.$action[3].' to ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							}
						}
						$start_date = date('Y-m-d', strtotime($start_msg));
						if(!empty($action[3]) && $action[3] == 'to'){
							$msg = str_replace($action[1].' '.$action[2].' to ', '', $msg);
							$end_date = date('Y-m-d', strtotime($msg));
						}

						//echo $start_msg.' '.$end_date;die;
						$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
						$response[] = $query;
						return $response;
					}
					
				}

				//Check if word is a number

				if($action[0] == $action[0] && $action[1] == 'the'){
					$wor1 = $action[2];
					$word1 = $this->Crud->wordsToNumber($wor1);
					$wor2 = $action[3];
					$word2 = $this->Crud->wordsToNumber($wor2);
				
				} else {
					$wor1 = $action[1];
					$word1 = $this->Crud->wordsToNumber($wor1);
					$wor2 = $action[2];
					$word2 = $this->Crud->wordsToNumber($wor2);
				}
				
					
				if(ctype_digit(strval($word1)) && ctype_digit(strval($word2))){
					$word1 = $word1 + $word2;
					if($action[0] == $action[0] && $action[1] == 'the'){
						if($action[4] == 'of'){
							if(!empty($action[6])){
								$msg = $word1.' '.$action[5].' '.$action[6];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[5];
								$date = date('Y-m-d', strtotime($msg));
							}
						} else {
							if(!empty($action[5])){
								$msg = $word1.' '.$action[4].' '.$action[5];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[4];
								$date = date('Y-m-d', strtotime($msg));
							}
							
						}
					} else {
						if($action[3] == 'of'){
							if(!empty($action[5])){
								$msg = $word1.' '.$action[4].' '.$action[5];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[4];
								$date = date('Y-m-d', strtotime($msg));
							}
						} else {
							if(!empty($action[4])){
								$msg = $word1.' '.$action[3].' '.$action[4];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[3];
								$date = date('Y-m-d', strtotime($msg));
							}
							
						}
					}
					
					$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
				} elseif(ctype_digit(strval($word1))){
					if($action[0] == 'from' && $action[1] == 'the'){
						if($action[3] == 'of'){
							if(!empty($action[5])){
								$msg = $word1.' '.$action[4].' '.$action[5];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[3];
								$date = date('Y-m-d', strtotime($msg));
							}
							
						} else {
							if(!empty($action[4])){
								$msg = $word1.' '.$action[3].' '.$action[4];
								$date = date('Y-m-d', strtotime($msg));
							} else {
								$msg = $word1.' '.$action[3];
								$date = date('Y-m-d', strtotime($msg));
							}
						}
					} else {
						if($action[2] == 'of'){
							if(!empty($action[4]) && ctype_digit(strval($action[4]))){
								$start_msg = $word1.' '.$action[3].' '.$action[4];
								$start_date = date('Y-m-d', strtotime($start_msg));
								$end_date = date('Y-m-d', strtotime('31 '.$action[3].' '.$action[4]));
								if(!empty($action[5]) && $action[5] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' '.$action[3].' '.$action[4].' to ', '', $msg);
									$msg = str_replace('of ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							} else {
								$start_msg = $word1.' '.$action[3];
								$start_date = date('Y-m-d', strtotime($start_msg));
								$end_date = date('Y-m-d', strtotime('31 '.$action[3]));
								if(!empty($action[4]) && $action[4] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' '.$action[3].' to ', '', $msg);
									$msg = str_replace('of ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							}
						} else {
							if(!empty($action[3]) && ctype_digit(strval($action[3]))){
								$start_msg = $word1.' '.$action[2].' '.$action[3];
								$start_date = date('Y-m-d', strtotime($start_msg));
								$end_date = date('Y-m-d', strtotime('31 '.$action[2].' '.$action[3]));
								if(!empty($action[4]) && $action[4] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' '.$action[3].' to ', '', $msg);
									$msg = str_replace('of ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							} else {
								$start_msg = $word1.' '.$action[2];
								$start_date = date('Y-m-d', strtotime($start_msg));
								$end_date = date('Y-m-d', strtotime('31 '.$action[2]));
								if(!empty($action[3]) && $action[3] == 'to'){
									$msg = str_replace($action[1].' '.$action[2].' to ', '', $msg);
									$msg = str_replace('of ', '', $msg);
									$end_date = date('Y-m-d', strtotime($msg));
								}
							}

						
						}
					}
					
					$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date', 'language', $lang_id, 'rhapsody');
				} 
			}
			
		} else{
			
			if(ctype_digit(strval($action[1]))) {
				if($action[1] <= 31){
					$date = date('Y-m-d', strtotime($msg));
					$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
			
				} else {
					$start_msg = $action[1].'-'.$action[2].'-01';
					$end_msg = '31 '.$action[2].' '.$action[1];
					$start_date = date('Y-m-d', strtotime($start_msg));
					$end_date = date('Y-m-d', strtotime($end_msg));

					//return $start_date.' '.$end_date;die;
					$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
			
				}
			} else {
				$date = date('Y-m-d', strtotime($msg));
				$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
			}
			
			if(!empty($action[2]) && ctype_digit(strval($action[2]))) {
				if($action[2] <= 31){
					$date = date('Y-m-d', strtotime($msg));
					$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
			
				} else {
					$start_msg = $action[2].'-'.$action[1].'-01';
					$end_msg = '31 '.$action[1].' '.$action[2];
					$start_date = date('Y-m-d', strtotime($start_msg));
					$end_date = date('Y-m-d', strtotime($end_msg));

					//return $start_date.' '.$end_date;die;
					$query = $this->Crud->date_range1($start_date, 'date', $end_date, 'date','language', $lang_id,'rhapsody');
			
				}
			}

			//Check if word is a number

			if($action[0] == $action[0] && $action[1] == 'the'){
				$wor1 = $action[2];
				$word1 = $this->Crud->wordsToNumber($wor1);
				$wor2 = $action[3];
				$word2 = $this->Crud->wordsToNumber($wor2);
			
			} else {
				$wor1 = $action[1];
				$word1 = $this->Crud->wordsToNumber($wor1);
				$wor2 = $action[2];
				$word2 = $this->Crud->wordsToNumber($wor2);
			}
			
				
			if(ctype_digit(strval($word1)) && ctype_digit(strval($word2))){
				$word1 = $word1 + $word2;
				if($action[0] == $action[0] && $action[1] == 'the'){
					if($action[4] == 'of'){
						if(!empty($action[6])){
							$msg = $word1.' '.$action[5].' '.$action[6];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[5];
							$date = date('Y-m-d', strtotime($msg));
						}
					} else {
						if(!empty($action[5])){
							$msg = $word1.' '.$action[4].' '.$action[5];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[4];
							$date = date('Y-m-d', strtotime($msg));
						}
						
					}
				} else {
					if($action[3] == 'of'){
						if(!empty($action[5])){
							$msg = $word1.' '.$action[4].' '.$action[5];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[4];
							$date = date('Y-m-d', strtotime($msg));
						}
					} else {
						if(!empty($action[4])){
							$msg = $word1.' '.$action[3].' '.$action[4];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[3];
							$date = date('Y-m-d', strtotime($msg));
						}
						
					}
				}
				
				$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
			} elseif(ctype_digit(strval($word1))){
				if($action[0] == 'for' && $action[1] == 'the'){
					if($action[3] == 'of'){
						if(!empty($action[5])){
							$msg = $word1.' '.$action[4].' '.$action[5];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[3];
							$date = date('Y-m-d', strtotime($msg));
						}
						
					} else {
						if(!empty($action[4])){
							$msg = $word1.' '.$action[3].' '.$action[4];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[3];
							$date = date('Y-m-d', strtotime($msg));
						}
					}
				} else {
					if($action[2] == 'of'){
						if(!empty($action[4])){
							$msg = $word1.' '.$action[3].' '.$action[4];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[3];
							$date = date('Y-m-d', strtotime($msg));
						}
					} else {
						if(!empty($action[3])){
							$msg = $word1.' '.$action[2].' '.$action[3];
							$date = date('Y-m-d', strtotime($msg));
						} else {
							$msg = $word1.' '.$action[2];
							$date = date('Y-m-d', strtotime($msg));
						}

					
					}
				}
				
				$query = $this->Crud->read2('language', $lang_id, 'date', $date, 'rhapsody', 'content');
			}
		}

		
		$response[] = $query;
		return $response;

	}
	private function execute($user_id, $lang_id, $type, $trigger, $msg) {
		$response = array();

		// greetings response
		if($type == 'greetings') {
			if($trigger == 'hi' || $trigger == 'hello' || $trigger == 'hey') {
				$response = 'hi';
			} else if($trigger == 'fine') {
				$response = 'great, good to know';
			} else {
				$response = 'I am fine thanks, and you?';
			}
			echo $trigger;
		}

		// language response
		if($type == 'language') {
			// remove trigger
			$msg = trim(str_replace($trigger, '', $msg));

			// check if its default
			if($msg == 'default') {
				$lang_code = 'en-US';
				$land_id = $this->Crud->read_field2('code', $lang_code, 'name', 'English', 'language', 'id');
				$this->Crud->updates('id', $user_id, 'user', array('lang_id'=>$lang_id));
				$resp = 'I will now be responding in my official voice';
				$response['code'] = $lang_code;
				$response['msg'] = $resp;
			} else {
				// first check if language exists more than 1
				$count = $this->db->table('language')->where('name', $msg)->countAllResults();
				if($count <= 0) {
					$response = 'Sorry, I can not speak '.$msg.' at the moment, but I am learning';
				} else if($count == 1) {
					// get language id
					$lang_id = $this->Crud->read_field('name', $msg, 'language', 'id');
					$lang_code = $this->Crud->read_field('name', $msg, 'language', 'code');
					$this->Crud->updates('id', $user_id, 'user', array('lang_id'=>$lang_id));
					$resp = 'I will now be responding in '.$msg;
					$response['code'] = $lang_code;
					$response['msg'] = $resp;
				} else {
					// get language id by country
					$country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
					$country = $this->Crud->read_field('id', $country_id, 'country', 'name');
					$lang_id = $this->Crud->read_field2('country', $country, 'name', $msg, 'language', 'id');
					$lang_code = $this->Crud->read_field('id', $lang_id, 'language', 'code');
					$this->Crud->updates('id', $user_id, 'user', array('lang_id'=>$lang_id));
					$resp = 'I will now be responding in '.$msg;
					$response['code'] = $lang_code;
					$response['msg'] = $resp;
				}
			}
		}

		// rhapsodys
		if($type == 'rhapsody') {
			// remove trigger
			$msg = trim(str_replace($trigger, '', $msg));
			// determine if it's for, for the, from, or this
			$action = explode(' ', $msg);
			if($action[0] == 'for' || $action[0] == 'from') {
				$get = $this->rhapsody_execute($msg, $lang_id);
				$query = $get[0];
				
				if(!empty($query)) {
					foreach($query as $q) {
						$item = array();

						$sponsor = $this->sponsor();
						$content = $q->content;
						// $content = $sponsor.'<br>'.$content; // remove this later

						$content = strip_tags($content, ['<br/>', '<br>']);
				        $content = preg_replace('/<br(\s+)?\/?>/i', "\n\n", $content);
				        $content = str_replace('&amp;', '&', $content);
				        $content = str_replace('&nbsp;', ' ', $content);

						$item['date'] = date('M d, Y', strtotime($q->date));
						$item['sponsor'] = $sponsor;
						$item['title'] = $q->title;
						$item['content'] = $content;

						$response[] = $item;
					}
				}
			}
		}

		return $response;
	}
	private function find($intent, $phrase) {
		//case in-sensitive
		$intent = strtolower($intent);
		$phrase = strtolower($phrase);
		$intent = explode(" ", $intent);
		$phrase = explode(" ", $phrase);
		$intersect = array_intersect($intent, $phrase);
		if ($intersect == $phrase) { 
			return true;
		}
		return false;
	}
	private function sponsor() {
		$sponsors[] = 'Revolution Properties.';
		$sponsors[] = 'Christmas Promo Sale. Will you like to listen to it?.';
		$sponsors[] = 'PCDL4Kids. That is the Pastor Chris Digital Library for Kids. Stream children contents now.';
		$sponsors[] = 'Loveworld Espees, our official currency. Will you like to know more?.';
		$sponsors[] = 'KingsChat. For free calls and messages.';
		$sponsors[] = 'Qubaors, the christain tech incubators aimed at challenging technical minds in creating kingdom-minded solution for the real world problems.';

		$rand = rand(0, count($sponsors)-1);
		return $sponsors[$rand];
	}

	// wallet
	public function wallet($type='get') {
	    $status = false;
		$msg = '';
		$earnings = 0;
		$withdrawns = 0;
		$balance = 0;
		$bal = 0;
		$data = array();
		
		// get 
		if($type == 'get') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    
		    if(!empty($user_id)) {
		        $query = $this->Crud->read_single('user_id', $user_id, 'wallet');
		        if(!empty($query)) {
		            $status = true;
		            $msg = 'Successful';
		            foreach($query as $q) {
		                $item = array();
		                
		                if($q->type == 'credit') {
		                    $earnings += (float)$q->amount;
		                } else {
		                    $withdrawns += (float)$q->amount;
		                }
		                
		                $item['id'] = $q->id;
		                $item['type'] = $q->type;
		                $item['remark'] = $q->remark;
		                $item['amount'] = number_format((float)$q->amount, 2);
		                $item['date'] = date('M d, Y h:s A', strtotime($q->reg_date));
		                
		                $data[] = $item;
		            }
		            
		            $balance = $earnings - $withdrawns;
		            
		            $earnings = number_format($earnings, 2);
		            $withdrawns = number_format($withdrawns, 2);
					$balance = number_format($balance, 2);
		        }
		    }
		    
		}
		
		// fund
		if($type == 'fund') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    $amount = $call->amount;
		    
		    if(!empty($user_id) && !empty($amount)) {
		        $v_ins['user_id'] = $user_id;
		        $v_ins['type'] = 'credit';
		        $v_ins['amount'] = $amount;
		        $v_ins['item'] = 'fund';
		        $v_ins['item_id'] = $user_id;
		        $v_ins['remark'] = 'Wallet Funding';
		        $v_ins['reg_date'] = date(fdate);
		        
		        $w_id = $this->Crud->create('wallet', $v_ins);
		        if($w_id > 0) {
		            $status = true;
		            $msg = 'Wallet Funded';
		            $data['id'] = $w_id;

					$fullname = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
					$email = $this->Crud->read_field('id', $user_id, 'user', 'email');
					$country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
					$curr = $this->Crud->read_field('id', $country_id, 'country', 'currency');

					// add notification
					$u_content = 'You funded your wallet with '.$curr.number_format($amount);
					$this->notify(0, $user_id, $u_content, 'wallet', $w_id);
					if($email) {
						$u_body = 'Dear '.$fullname.',<br/><br/>Your wallet is funded with '.$curr.number_format($amount).'.<br/><br/>Thank you.';
						$this->send_email($email, 'Wallet Funding', $u_body);
					}
		        } else {
		            $msg = 'Failed! - Please Contact Support.';
		        }
		    }
		}
		
		// withdraw
		if($type == 'withdraw') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    $threshold = 100;
		    
		    if(!empty($user_id)) {
		        $query = $this->Crud->read_single('user_id', $user_id, 'wallet');
		        if(!empty($query)) {
		            $status = true;
		            foreach($query as $q) {
		                if($q->type == 'credit') {
		                    $earnings += (float)$q->amount;
		                } else {
		                    $withdrawns += (float)$q->amount;
		                }
		            }
		            $balance = $earnings - $withdrawns;
		        }
		        
		        if($balance <= 0) {
		            $status = true;
		            $msg = 'You have no Balance to Withdraw';
		        } else {
		            if($balance < $threshold) {
		                $status = true;
		                $msg = 'Minimum Payout of NGN '.$threshold.' required!';
		            } else {
    		            // check rave balance
		                $rave_balance = 0;
		                $grb = $this->Crud->rave_balance();
		                $grb = json_decode($grb);
		                if($grb->status == 'success') {
		                    $rave_balance = $grb->data->available_balance;
		                }
		                
		                // check if there is enough money in rave wallet
		                if($rave_balance <= $balance) {
		                    $status = true;
		                    $msg = 'Withdraw Failed! - Please try later or contact support';
		                } else {
		                    // get user account
		                    $fullname = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
		                    $email = $this->Crud->read_field('id', $user_id, 'user', 'email');
		                    $bank_code = $this->Crud->read_field('user_id', $user_id, 'account', 'code');
		                    $account = $this->Crud->read_field('user_id', $user_id, 'account', 'account');
		                    $ref = 'WMW-'.time();
		                    $narration = 'Withdrawn by '.$fullname.' ('.$email.')';
		            
		                    if(!empty($bank_code) && !empty($account)) {
		                        $r_data['account_bank'] = $bank_code;
		                        $r_data['account_number'] = $account;
		                        $r_data['amount'] = $balance;
		                        $r_data['narration'] = $narration;
		                        $r_data['currency'] = 'NGN';
		                        $r_data['reference'] = $ref;
		                        $r_data['callback_url'] = '';
		                        $r_data['debit_currency'] = 'NGN';
		            
		                        $w_resp = $this->Crud->rave_withdraw($r_data);
		                        $wr = json_decode($w_resp);
		                        if($wr->status == 'success') {
		                            $status = true;
		                            $msg = $wr->message;
		                        
		                            // register wallet
		                            $v_ins['user_id'] = $user_id;
		                            $v_ins['type'] = 'debit';
		                            $v_ins['amount'] = $balance;
		                            $v_ins['item'] = 'withdraw';
		                            $v_ins['item_id'] = $user_id;
		                            $v_ins['remark'] = 'Wallet Withdraw';
		                            $v_ins['reg_date'] = date(fdate);
		                            $this->Crud->create('wallet', $v_ins);
		                        } else {
		                            $status = true;
		                            $msg = 'Withdraw Failed! - Please try later or contact support';
		                        }
		                    } else {
		                        $status = true;
		                        $msg = 'No Account Found! - Please add account.';
		                    }
		                }
		            }
		        }
		    }
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'earnings'=>$earnings, 'withdrawns'=>$withdrawns, 'balance'=>$balance, 'data'=>$data));
		die;
	}

	// pump
	public function pump($type='get') {
	    $status = false;
		$msg = '';
		$data = array();
		
		// get 
		if($type == 'get') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    
		    if(!empty($user_id)) {
		        $query = $this->Crud->read_single('user_id', $user_id, 'pump');
		        if(!empty($query)) {
		            $status = true;
		            $msg = 'Successful';
		            foreach($query as $q) {
		                $item = array();

						$product = $this->Crud->read_field('id', $q->product, 'category', 'name');
		                
		                $item['id'] = $q->id;
						$item['name'] = ucwords($q->name);
		                $item['product'] = $product;
		                $item['price'] = $q->price;
		                
		                $data[] = $item;
		            }
		        }
		    }
		    
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// order
	public function order($method='get') {
	    $status = false;
		$msg = '';
		$data = array();
		
		// POST
		if($method == 'post') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    $category = $call->category;
			$amount = (float)$call->amount;
		    
		    $category_id = $this->Crud->read_field('name', $category, 'category', 'id');
			
			// get balance
			$balance = $this->get_balance($user_id);

			// compute total
			// $comm = 50;
			// $vat = ($amount + $comm) * 0.075;
			$comm = 0;
			$vat = 0;
			$total = $amount + $comm + $vat;

			// check wallet balance
			if($balance < $amount) {
				$msg = 'Please add Fund to Wallet';
			} else {
				$ref = 'FM-'.substr(rand(),0,3).substr(rand(),0,4).substr(rand(),0,3);

				// add order
				$ordData['user_id'] = $user_id;
				$ordData['category_id'] = $category_id;
				$ordData['ref'] = $ref;
				$ordData['amount'] = $this->Crud->to_number($amount);
				$ordData['comm'] = $comm;
				$ordData['vat'] = $vat;
				$ordData['total'] = $total;
				$ordData['status'] = 'Pending';
				$ordData['reg_date'] = date(fdate);
				$order_id = $this->Crud->create('order', $ordData);
				if($order_id > 0) {
					$status = true;
					$msg = 'Order Initialized Successfully';
					
					$data = $this->orderDetails($order_id);
				} else {
					$msg = 'Please try later';
				}
			}
		}

		// SUBMIT
		if($method == 'submit') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    $order_id = $call->order_id;
		    
		    $orderTotal = (float)$this->Crud->read_field('id', $order_id, 'order', 'total');
			$balance = $this->get_balance($user_id);

			if($balance < $orderTotal) {
				$msg = 'Please add Fund to Wallet';
			} else {
				$status = true;
				$msg = 'Order Placed Successfully';

				$rands = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code = substr(str_shuffle($rands), 0, 8);

				// update order
				$this->Crud->updates('id', $order_id, 'order', array('code'=>$code, 'status'=>'Purchased'));

				$cat_id = $this->Crud->read_field('id', $order_id, 'order', 'category_id');
				$cat = $this->Crud->read_field('id', $cat_id, 'category', 'name');

				// register wallet
				$v_ins['user_id'] = $user_id;
				$v_ins['type'] = 'debit';
				$v_ins['amount'] = $orderTotal;
				$v_ins['item'] = 'order';
				$v_ins['item_id'] = $order_id;
				$v_ins['remark'] = 'Purchased of '.$cat;
				$v_ins['reg_date'] = date(fdate);
				$this->Crud->create('wallet', $v_ins);

				$fullname = $this->Crud->read_field('id', $user_id, 'user', 'fullname');
				$email = $this->Crud->read_field('id', $user_id, 'user', 'email');
				$country_id = $this->Crud->read_field('id', $user_id, 'user', 'country_id');
				$curr = $this->Crud->read_field('id', $country_id, 'country', 'currency');

				$amt = (float)$this->Crud->read_field('id', $order_id, 'order', 'amount');

				// add notification
				$u_content = 'You purchase a new token for the value of '.$curr.number_format($amt);
				$this->notify(0, $user_id, $u_content, 'order', $order_id);
				if($email) {
					$u_body = 'Dear '.$fullname.',<br/><br/>You purchase a new token for the value of '.$curr.number_format($amt).'.<br/><br/>Thank you.';
					$this->send_email($email, 'New Order', $u_body);
				}
			}
		}

		// VERIFY
		if($method == 'verify') {
		    $call = json_decode(file_get_contents("php://input"));
		    $user_id = $call->user_id;
		    $code = $call->code;
			$pump = $call->pump;
			$submit = $call->submit;

			$partner_id = $user_id;
		    
		    $order_id = $this->Crud->read_field('code', $code, 'order', 'id');
			if(empty($order_id)) {
				$msg = 'Invalid Transaction Code';
			} else {
				// check if order is already verified
				$used = $this->Crud->read_field('id', $order_id, 'order', 'used');
				if($used > 0) {
					$msg = 'Transaction Code Already Used';
				} else {
					$amount = (float)$this->Crud->read_field('id', $order_id, 'order', 'amount');
					$total = (float)$this->Crud->read_field('id', $order_id, 'order', 'total');
					$perLitre = (float)$this->Crud->read_field('id', $pump, 'pump', 'price');
					$litres = $amount / $perLitre;

					if(!empty($submit)) {
						$country_id = $this->Crud->read_field('id', $partner_id, 'user', 'country_id');
						$state_id = $this->Crud->read_field('id', $partner_id, 'user', 'state_id');
						$lga_id = $this->Crud->read_field('id', $partner_id, 'user', 'lga_id');

						$ins_data['partner_id'] = $partner_id;
						$ins_data['country_id'] = $country_id;
						$ins_data['state_id'] = $state_id;
						$ins_data['city_id'] = $lga_id;
						$ins_data['partner_id'] = $partner_id;
						$ins_data['litre'] = $litres;
						$ins_data['status'] = 'Used';
						$ins_data['used'] = 1;
						$ins_data['pump'] = $pump;
						$ins_data['used_date'] = date(fdate);
						$ins_id = $this->Crud->updates('id', $order_id, 'order', $ins_data);
						if($ins_id > 0) {
							$status = true;
							$msg = 'Transaction Code Approved';

							$u_id = $this->Crud->read_field('id', $order_id, 'order', 'user_id');;
							$fullname = $this->Crud->read_field('id', $u_id, 'user', 'fullname');
							$partner = $this->Crud->read_field('id', $partner_id, 'user', 'fullname');
							$email = $this->Crud->read_field('id', $u_id, 'user', 'email');
							$ct_id = $this->Crud->read_field('id', $u_id, 'user', 'country_id');
							$curr = $this->Crud->read_field('id', $ct_id, 'country', 'currency');

							$amt = (float)$this->Crud->read_field('id', $order_id, 'order', 'amount');

							// add notification
							$u_content = 'Your token ('.$code.') was used at '.$partner;
							$this->notify(0, $u_id, $u_content, 'token', $ins_id);
							if($email) {
								$u_body = 'Dear '.$fullname.',<br/><br/>Your token ('.$code.') was used at '.$partner.'.<br/><br/>Thank you.';
								$this->send_email($email, 'Token Used', $u_body);
							}
						} else {
							$msg = 'Please try later';
						}
					} else {
						$status = true;
						$msg = 'Verified';

						$data['amount'] = number_format($amount, 2);
						$data['total'] = number_format($total, 2);
						$data['litres'] = number_format($litres, 2);
					}
				}
			}
		}
		
		// get 
		if($method == 'get') {
		    $user_id = $this->request->getGet('user_id');
			$used = $this->request->getGet('used');
			if(!empty($this->request->getGet('search'))) {
				$search = $this->request->getGet('search');
			} else {
				$search = '';
			}

			// $query = $this->Crud->read2('user_id', $user_id, 'used', $used, 'order');
			$query = $this->db->table('order')->like('code', $search)->where('user_id', $user_id)->where('used', $used)->get()->getResult();
			if(!empty($query)) {
				$status = true;
				$msg = 'Successful';
				foreach($query as $q) {
					$data[] = $this->orderDetails($q->id);
				}
			}
		}

		// count 
		if($method == 'count') {
		    $user_id = $this->request->getGet('user_id');
			$count = $this->db->table('order')->where('user_id', $user_id)->countAllResults();

			$status = true;
			$msg = 'Successful';
			$data = $count;
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// notification
	public function notification($id='') {
	    $status = false;
		$msg = '';
		$data = array();
		
		// collect call paramters
		$type = $this->request->getGet('type');
		$user_id = $this->request->getGet('user_id');
		// $limit = $this->request->getGet('limit');
		// $offset = $this->request->getGet('offset');
		
		if(empty($limit)) {$limit = 50;}
		if(empty($offset)) {$offset = 0;}
		
		// count total unread notification
		if($type == 'count') {
		    $status = true;
		    $msg = 'Successful';
			$data['count'] = $this->db->table('notify')->where('to_id', $user_id)->where('new', 1)->countAllResults();
		}
		
		// read all notification
		if($type == 'all') {
		    $query = $this->Crud->read_single('to_id', $user_id, 'notify', $limit, $offset);
		    if(!empty($query)) {
		        $status = true;
		        $msg = 'Successful';
		        foreach($query as $q) {
		            $item = array();
		            
		            $isNew = true;
		            if($q->new == 0) { $isNew = false; }
		            
		            $item['id'] = $q->id;
		            $item['content'] = $q->content;
		            $item['item'] = $q->item;
		            $item['item_id'] = $q->item_id;
		            $item['new'] = $isNew;
		            $item['date'] = $this->timeago(strtotime($q->reg_date));
		            
		            $data[] = $item;
		        }
		    }
		}
		
		// push notification
		if($type == 'push') {
		    $query = $this->Crud->read2('to_id', $user_id, 'new', 1, 'notify', 'id', 'DESC', $limit, $offset);
		    if(!empty($query)) {
		        $status = true;
		        $msg = 'Successful';
		        foreach($query as $q) {
		            $item = array();
		            
		            $item['id'] = $q->id;
		            $item['content'] = $q->content;
		            $item['item'] = $q->item;
		            $item['item_id'] = $q->item_id;
					$item['orderId'] = $q->orderId;
		            $item['date'] = $this->timeago(strtotime($q->reg_date));
		            
		            $data[] = $item;
		        }
		    }
		}
		
		// update notification
		if($type == 'update') {
		    if($id && $user_id) {
		        $status = true;
		        $msg = 'Successful';
		        $this->Crud->updates('id', $id, 'notify', array('new'=>0));
		    }
		}

		// delete notification
		if($type == 'delete') {
		    if($id && $user_id) {
		        $status = true;
		        $msg = 'Successful';
		        $this->Crud->deletes('id', $id, 'notify');
		    }
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// station
	public function station($id='') {
	    $status = false;
		$msg = '';
		$data = array();
		
		// collect call paramters
		$type = $this->request->getGet('type');
		$user_id = $this->request->getGet('user_id');
		$user_address = $this->request->getGet('user_address');
		$lga = $this->request->getGet('lga');
		// $limit = $this->request->getGet('limit');
		// $offset = $this->request->getGet('offset');
		
		if(empty($limit)) {$limit = 10;}
		if(empty($offset)) {$offset = 0;}
		
		// read all notification
		if($type == 'all') {
			$field = 'state';
			$lga_id = $this->Crud->read_field('name', trim($lga), $field, 'id');
		    $query = $this->Crud->read2($field.'_id', $lga_id, 'is_partner', 1, 'user', 'id', 'DESC', $limit, $offset);
		    if(!empty($query)) {
		        $status = true;
		        $msg = 'Successful';
		        foreach($query as $q) {
		            $item = array();

					$distance = $this->Crud->getDistance($user_address, $q->address, 'K');
					
					$item['id'] = $q->id;
					$item['fullname'] = $q->fullname;
					$item['image'] = site_url($this->Crud->image($q->logo, 'big'));
					$item['address'] = $q->address;
					$item['distance'] = $distance;

					$petrol = 0;
					$diesel = 0;
					$gas = 0;
					$kerosene = 0;
					$pumps = $this->Crud->read_single('user_id', $q->id, 'pump');
					if(!empty($pumps)) {
						foreach($pumps as $p) {
							$amount = $p->price;

							if($p->product == 1) { $petrol = $amount; }
							if($p->product == 2) { $diesel = $amount; }
							if($p->product == 3) { $gas = $amount; }
							if($p->product == 4) { $kerosene = $amount; }
						}
					}

					$item['petrol'] = number_format($petrol, 2);
					$item['diesel'] = number_format($diesel, 2);
					$item['gas'] = number_format($gas, 2);
					$item['kerosene'] = number_format($kerosene, 2);
					
					$data[] = $item;
		        }
		    }
		}
		
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	// get settings
	public function setting() {
	    $status = false;
		$data = array();
		$msg = '';
		
		$sandbox = true;
		$getsandbox = $this->Crud->read_field('name', 'sandbox', 'setting', 'value');
		if($getsandbox == 'no') { $sandbox = false; }
		
		if($sandbox == true) {
		    $pkey = $this->Crud->read_field('name', 'test_pkey', 'setting', 'value');
		    $ekey = $this->Crud->read_field('name', 'test_ekey', 'setting', 'value');
		} else {
		    $pkey = $this->Crud->read_field('name', 'live_pkey', 'setting', 'value');
		    $ekey = $this->Crud->read_field('name', 'live_ekey', 'setting', 'value');
		}
		
		// responses
		$status = true;
		$msg = 'Successful';
        $data['sandbox'] = $sandbox;
        $data['public_key'] = $pkey;
        $data['encryption_key'] = $ekey;
        
		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'data'=>$data));
		die;
	}

	//// others //////
	private function user_data($id) {
		$query = $this->Crud->read_single('id', $id, 'user');
		if(!empty($query)) {
			foreach($query as $q) {
				$data['id'] = $q->id;
				$data['fullname'] = $q->fullname;
				$data['email'] = $q->email;
				$data['phone'] = $q->phone;
				$data['country'] = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
				// $data['curr'] = $this->Crud->read_field('id', $q->country_id, 'country', 'currency');
				// $data['curr_symbol'] = $this->Crud->read_field('id', $q->country_id, 'country', 'currency_symbol');
				$data['img'] = site_url($this->Crud->image($q->img_id, 'big'));
				$data['role_id'] = $q->role_id;
				$data['role'] = $this->Crud->read_field('id', $q->role_id, 'access_role', 'name');
				$data['reg_date'] = date('M d, Y h:i A', strtotime($q->reg_date));
				return $data;
			}
		} else {
			return false;
		}
	}

	private function get_balance($id) {
		$balance = 0; $earnings = 0; $withdrawns = 0;
		$wallets = $this->Crud->read_single('user_id', $id, 'wallet');
		if(!empty($wallets)) {
			foreach($wallets as $w) {
				if($w->type == 'credit') {
					$earnings += (float)$w->amount;
				} else {
					$withdrawns += (float)$w->amount;
				}
			}
			$balance = $earnings - $withdrawns;
		}
		return $balance;
	}

	private function orderDetails($id) {
		$data = array();

		$query = $this->Crud->read_single('id', $id, 'order');
		if(!empty($query)) {
			foreach($query as $q) {
				$data['id'] = $q->id;
				$data['ref'] = $q->ref;
				$data['code'] = $q->code;
				$data['category'] = $this->Crud->read_field('id', $q->category_id, 'category', 'name');
				$data['amount'] = number_format((float)$q->amount, 2);
				$data['comm'] = number_format((float)$q->comm, 2);
				$data['vat'] = number_format((float)$q->vat, 2);
				$data['total'] = number_format((float)$q->total, 2);
				$data['status'] = $q->status;
				$data['litre'] = $q->litre;
				$data['partner'] = $this->Crud->read_field('id', $q->partner_id, 'user', 'fullname');
				$data['partner_address'] = $this->Crud->read_field('id', $q->partner_id, 'user', 'address');
				$data['city'] = $this->Crud->read_field('id', $q->city_id, 'city', 'name');
				$data['state'] = $this->Crud->read_field('id', $q->state_id, 'state', 'name');
				$data['country'] = $this->Crud->read_field('id', $q->country_id, 'country', 'name');
				$data['used_date'] = date('M d, Y h:iA', strtotime($q->used_date));
				$data['date'] = date('M d, Y h:iA', strtotime($q->reg_date));
			}
		}

		return $data;
	}

	private function notify($from, $to, $content, $item, $item_id) {
	    $ins['from_id'] = $from;
	    $ins['to_id'] = $to;
	    $ins['content'] = $content;
	    $ins['item'] = $item;
	    $ins['item_id'] = $item_id;
	    $ins['new'] = 1;
	    $ins['reg_date'] = date(fdate);
	    
	    $this->Crud->create('notify', $ins);
	}
	
	private function send_email($to, $subject, $body) {
		$from = push_email;
		$name = app_name;
		$subhead = 'Notification';
		$this->Crud->send_email($to, $from, $subject, $body, $name, $subhead);
	}

	private function timeago($ptime) {
		$estimate_time = time() - $ptime;
		if( $estimate_time < 1 ) {
			return 'less than 1 second ago';
		}
	
		$condition = array(
			12 * 30 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60       =>  'month',
			24 * 60 * 60            =>  'day',
			60 * 60                 =>  'hour',
			60                      =>  'minute',
			1                       =>  'second'
		);
	
		foreach($condition as $secs => $str) {
			$d = $estimate_time / $secs;
		
			if($d >= 1) {
				$r = round( $d );
				return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
			}
		}
	}

	private function getIPAddress() {  
		//whether ip is from the share internet  
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) { 
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} //whether ip is from the proxy  
		else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
		} //whether ip is from the remote address  
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}  
		return $ip;  
	} 
}
