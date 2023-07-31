<?php

namespace App\Controllers;

class Payment extends BaseController {
    public function index() {}

    public function response() {
		
      echo '<div class="text-sucess">PAYMENT COMPLETED!</div>';
		// return view('payment/response', $data);
	}
}
