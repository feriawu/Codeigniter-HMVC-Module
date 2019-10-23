<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    
    public $LOGO_URL = "";

    public $SUBJECT_REGISTRATION = "Welcome";
    public $SUBJECT_ACTIVATION = "Your verification email";
    public $SUBJECT_FORGOT_PASSWORD = "Forgot your password?";

    public $data 	= 	array();

	public function __construct() {
		//parent::__construct();

       
		@set_time_limit(-1);
        $this->load->library('email'); 

        # sendmail protocol 
        
        
		$this->email->initialize(array(
			'protocol'	=> 'sendmail',
			'mailpath'	=> '/usr/sbin/sendmail',
			'charset'	=> 'utf-8', //'utf-8'
			'wordwrap'	=> TRUE,
			'mailtype'	=> 'html',
            'validation' => TRUE
		));
       

        # smtp protocol with gmail
       /**
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '20';
        $config['smtp_user']    = 'upin.ipin.indonesia@gmail.com';
        $config['smtp_pass']    = 'rieskhahermawanputra';
        $config['charset']    = 'utf-8';
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $config['wordwrap']  = TRUE;
        $this->email->initialize($config);
         */
       
        header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
                
	}
    
    function is_login_session_valid($id_user, $session_key){
        $query = "SELECT session_key FROM User WHERE idUser = ".$id_user;
        $sql = $this->db->query($query);
        $result = $sql->row_array();

        if($session_key == $result['session_key']){
            return true;
        }

        $output = array("result" => "false", "reason" => "Your loggin session has expired, please do relogin.");
        echo json_encode($output);
    }

    function _send_email($param) {
        
        #$this->email->smtp_crypto('ssl');
        $this->email->set_newline("\r\n");
        $this->email->from('admin@hospitality.co');
        $this->email->to($param['to']);
        $this->email->subject($param['subject']);
        $this->email->message($param['message']);
        $this->email->send();
        return $this->email->print_debugger();
       
    } 
        
    

    function _set_upload(){
        $this->load->library('upload');
        $conf['upload_path'] = FCPATH.'/soal';
        $conf['allowed_types'] = '*';
        $conf['overwrite'] = TRUE;
        return $conf;
    }
        
   

     //function for set cookies 1 hour
    function _setCookies($user) {
        setcookie("user", $user, time()+3600);
    }

    //function for checking cookies
    function _checkCookies() {
        if(isset($_COOKIE)) {
            if(isset($_COOKIE['user'])) {
                $_SESSION['is_login'] = true;
                $_SESSION['userid'] = $_COOKIE['user'];
            }
        }
    }

        
    
        
        
}