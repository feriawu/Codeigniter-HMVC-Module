<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

/* load the HMVC_Loader class */
require APPPATH . 'third_party/MX/Loader.php';

class MY_Loader extends MX_Loader {
	public function __construct() {
        parent::__construct();
    }

    public function show_something() {
        echo "something shown";
    }
}