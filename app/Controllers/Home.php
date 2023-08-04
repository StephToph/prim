<?php

namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Home extends BaseController {
    public function index($param1='', $param2='', $para3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
        
        $mod = 'home';
        $data['title'] = ''.app_name;
        $data['page_active'] = $mod;
        return view('home/land', $data);
    }
    public function blog($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;

        $data['titles'] = $this->Crud->read_field('id', $param1, 'blog', 'title');
        $data['content'] = $this->Crud->read_field('id', $param1, 'blog', 'content');
        
        $author_id =  $this->Crud->read_field('id', $param1, 'blog', 'author');
        $data['author'] =  $this->Crud->read_field('id', $author_id, 'user', 'fullname');
        
        $image =  $this->Crud->read_field('id', $param1, 'blog', 'image');
        if(empty($image) || !file_exists($image)){
            $image = 'assets/blog.jpg';
        }
        $data['image'] =$image;
        $data['reg_date'] = $this->Crud->read_field('id', $param1, 'blog', 'reg_date');
        
        $mod = 'blog';
        $data['title'] = 'Blog - '.app_name;
        $data['page_active'] = $mod;
        return view('home/blog', $data);
    }
    public function apply($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;
       
        if($param1 == 'transact'){
			/////// CHACK PAYMENT RESPONSE //////
			$ref = $this->request->getPost('ref');
			$trans = $this->request->getPost('trans');
			$status = $this->request->getPost('status');
            
			if($ref && $trans && $status) {
				if($status == 'success') {
					// run order script
					// echo '<script>setTimeout(function(){ icon(); }, 1000);</script>';
					$log_id = $this->session->get('plx_pay_id');

					$up = $this->Crud->updates('id', $log_id, 'user', array('pay_status'=>1));
                    // echo $up;
                    if($up > 0){
                        echo $this->Crud->msg('success', 'Application Payment Successful!');
                        echo '<script>window.location.replace("'.site_url('home/application').'");</script>';
                    }
					
				}
			}
			////////////////////////////////////
			die;
		}

        if($this->request->getMethod() == 'post'){
            $firstname = $this->request->getPost('firstname');
            $lastname = $this->request->getPost('lastname');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $password = $this->request->getPost('password');
            $confirm = $this->request->getPost('confirm');
            $amount = 1000000;
            echo $this->Crud->rave_inline('',$email, $amount);

            if($this->Crud->check('email', $email, 'user') > 0 || $this->Crud->check('phone', $phone, 'user') > 0){
                if($this->Crud->check2('pay_status', 1, 'email', $email, 'user') > 0){
                    $id = $this->Crud->read_field('email', $email, 'user', 'id');
                    $this->session->set('plx_pay_id', $id);
                    echo '<script>window.location.replace("'.site_url('home/application').'");</script>';
                } else {
                    echo $this->Crud->msg('danger', 'Email Already Exist');
                }
               
            } else{
                if($password != $confirm){
                    echo $this->Crud->msg('danger', 'Passwords dont Match. Try Again');
                } else {
                    $name = $lastname.' '.$firstname;
                    $ins['fullname'] = $name;
                    $ins['email'] = $email;
                    $ins['phone'] = $phone;
                    $ins['password'] = md5($password);
                    $ins['role_id'] = $this->Crud->read_field('name', 'Student', 'access_role', 'id');
                    $ins_res = $this->Crud->create('user', $ins);
                    $this->session->set('plx_pay_id', $ins_res);
                    if($ins_res > 0){
                        echo '<script>payWithPaystack();</script>';
                    } else{
                        echo $this->Crud->msg('danger', 'Try Again Later');
                    }
                }
            }
            die;
        }
        $mod = 'apply';
        $data['title'] = 'Apply - '.app_name;
        $data['page_active'] = $mod;
        return view('home/apply', $data);
    }

    public function application($param1='', $param2='', $param3='') {
        // check login
        $log_id = $this->session->get('plx_pay_id');

        $data['log_id'] = $log_id;
       
        $data['param1'] = $param1;
        $data['param3'] = $param3;
        $data['param2'] = $param2;
       
        if($this->request->getMethod() == 'post'){
            $school_id = $this->request->getPost('school_id');
            $gender = $this->request->getPost('gender');
            $dept_id = $this->request->getPost('dept_id');
            $dob = $this->request->getPost('dob');
            $passport = '';
            $result = '';

            /// upload image
            if(file_exists($this->request->getFile('pics'))) {
                $path = 'assets/backend/images/application/';
                $file = $this->request->getFile('pics');
                $getImg = $this->Crud->img_upload($path, $file);
                $passport = $getImg->path;
            }

             /// upload result
             if(file_exists($this->request->getFile('result'))) {
                $path = 'assets/backend/images/application/';
                $file = $this->request->getFile('result');
                $getImg = $this->Crud->file_upload($path, $file);
                $result = $getImg->path;
            }

            if(empty($passport) || empty($result)){
                echo $this->Crud->msg('danger', 'Please Upload Passport and Waec Result');
                die;
            }
            if($this->Crud->check('user_id', $log_id, 'application') == 0){
                echo $this->Crud->msg('danger', 'Email Already Exist');
            } else{
                
                $ins['school_id'] = $school_id;
                $ins['gender'] = $gender;
                $ins['dob'] = $dob;
                $ins['user_id'] = $log_id;
                $ins['department'] = $dept_id;
                $ins['result'] = $result;
                $ins['passport'] = $passport;
                $ins['reg_date'] = date(fdate);
                $ins_res = $this->Crud->create('application', $ins);
                if($ins_res > 0){
                    ///// store activities
                    $by = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
                    $action = $by.' Completed Applications';
                    $this->Crud->activity('application', $ins_res, $action);
                    $email =  $this->Crud->read_field('id', $log_id, 'user', 'email');
                    $name =  $this->Crud->read_field('id', $log_id, 'user', 'fullname');
                    $phone =  $this->Crud->read_field('id', $log_id, 'user', 'phone');
                    $school =  $this->Crud->read_field('id', $school_id, 'school', 'name');
                    $course =  $this->Crud->read_field('id', $dept_id, 'department', 'name');
                        
				    $subject = 'Admission Application Form';
                    $to = 'admin@primroseconsult.com';
                    $message .= "Name: ".strtoupper($by)."\n";
                    $message .= "Email: $email\n";
                    $message .= "Phone: $phone\n";
                    $message .= "Gender: ".$gender."\n";
                    $message .= "Date of Birth: $dob\n";
                    $message .= "School Chosen: $school\n";
                    $message .= "Course: $course\n";

                    
                    // Attachments
                    $attachmentPaths = [$result, $passport];

                    $send_mail = $this->sendEmail($email, $name, $subject, $message, $attachmentPaths);
                    if($this->sendEmail($email, $name, $subject, $message, $attachmentPaths)){
                        echo $this->Crud->msg('success', 'Email Sent');
                    } else {
                        echo $this->Crud->msg('danger', 'Email not Sent');
                    }

                    echo $this->Crud->msg('success', 'Application Submitted');
                    // echo '<script>location.reload(false);</script>';
                } else{
                    echo $this->Crud->msg('danger', 'Try Again Later');
                }
            
            }
            die;
        }
        $mod = 'application';
        $data['title'] = 'Application - '.app_name;
        $data['page_active'] = $mod;
        return view('home/application', $data);
    }

    function sends(){
        $to = 'admin@primroseconsult.com';
        $subject = 'Test Email';
        $message = 'This is a test email sent from PHP.';
        $headers = 'From: ';

         // Boundary for multipart/mixed content
         $boundary = md5(time());
        $name = 'Admin';
        $email = 'tofunmi015@gmail.com';
         // Headers
         $headers = "From: ".strtoupper($name)." <$email>\r\n";
         $headers .= "MIME-Version: 1.0\r\n";
         $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

         // Message content
         $body = "--$boundary\r\n";
         $body .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
         $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
         $body .= "$message\r\n";

        if (mail($to, $subject, $body, $headers)) {
            echo 'Email sent successfully.';
        } else {
            echo 'Failed to send email.';
        }

        if (!mail($to, $subject, $message, $headers)) {
            $lastError = error_get_last(); 
            var_dump($lastError);
            echo 'Failed to send email. Error: ';
        }
    }

    public function sendEmail($from='', $from_name='', $subject='', $message='', $files = '') {
        
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tofunmi015@gmail.com';
            $mail->Password   = 'hgelpcwvwrsoqqve';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Sender and recipient configuration
            $mail->setFrom($from, $from_name);
            $mail->addAddress('tofunmi015@gmail.com', 'Primerose Consult');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            if(!empty($files)){
                foreach($files as $f =>$val){
                      // Attach files to the email
                    $mail->addAttachment($val);

                }
               
            }
            
            // Send the email
            $mail->send();
            echo true;
        } catch (Exception $e) {
            echo false;
        }
    }
}
