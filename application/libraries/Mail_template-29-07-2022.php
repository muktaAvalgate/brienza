<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "Mail.php";

class Mail_template {

    private $CI;

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        //parent::__construct();
        $this->CI = &get_instance();
        $this->CI->load->library('email');

        $this->CI->lang->load('application');
    }

	public function register_teacher_email($name = NULL, $email = NULL, $id = NULL) {

        if ($email == NULL) {
            return false;
        }
		
		$this->CI->load->library('encrypt');
		$base64 = $this->CI->encrypt->encode($id);
		
		$urisafe = strtr($base64, '+/', '-_');
		
		$activation_link = BASE_URL.'register_teachers/'.$urisafe;
		
        $message = "<p><strong>Dear ".$name.",</strong><br/></p>
                <p>You have been added as a presenter at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
                Email: ".$email."<br/><br /></p>";
		
		$message .= "<p>Please click the below link to 'Accept' or 'Decline' the request.<br /></p>";
		$message .= "<p><a href='".$activation_link."' >".$activation_link."</a></p><br /><br />";

        //echo $message;die;
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - New Presenter Registration', $message);
    }
	
	
	public function send_teacher_update($teacher_name = NULL, $teacher_email = NULL, $admin_name = NULL, $admin_email = NULL) {

        if ($admin_email == NULL) {
            return false;
        }
		
        $message = "<p><strong>Dear ".$admin_name.",</strong><br/></p>
                <p>Presenter info is updated at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
                Name: ".$teacher_name."<br/>Email: ".$teacher_email."<br/><br /></p>";

        //echo $message;die;
        $this->email_to_user($admin_email, $teacher_name, $this->CI->lang->line('app_site_name').' - Presenter Info Updated', $message);
        // if(is_array($admin_email)){
        //   foreach($admin_email as $eml){
        //     $this->email_to_user($eml, $teacher_name, $this->CI->lang->line('app_site_name').' - Presenter Info Updated', $message);
        //   }
        // }else{
        //   $this->email_to_user($admin_email, $teacher_name, $this->CI->lang->line('app_site_name').' - Presenter Info Updated', $message);
        // }
    }
	

  /**
  * Registration email
  * for coordinator   
  * */  
  public function register_coordinator_email($name = NULL, $email = NULL, $id = NULL) {

        if ($email == NULL) {
            return false;
        }
    
    $this->CI->load->library('encrypt');
    $base64 = $this->CI->encrypt->encode($id);
    
    $urisafe = strtr($base64, '+/', '-_');
    
    $activation_link = BASE_URL.'register_coordinator/'.$urisafe;
    
        $message = "<p><strong>Dear ".$name.",</strong><br/></p>
                <p>You have been added as a coordinator at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
                Email: ".$email."<br/><br /></p>";
    
    $message .= "<p>Please click the below link to 'Accept' or 'Decline' the request.<br /></p>";
    $message .= "<p><a href='".$activation_link."' >".$activation_link."</a></p><br /><br />";

        //echo $message;die;
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - New Coordinator Registration', $message);
  }   
  
    public function send_coordinator_update($teacher_name = NULL, $teacher_email = NULL, $admin_name = NULL, $admin_email = NULL) {

      if ($admin_email == NULL) {
          return false;
      }
  
      $message = "<p><strong>Dear ".$admin_name.",</strong><br/></p>
              <p>Coordinator info is updated at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
              Name: ".$teacher_name."<br/>Email: ".$teacher_email."<br/><br /></p>";

      //echo $message;die;
      $this->email_to_user($admin_email, $teacher_name, $this->CI->lang->line('app_site_name').' - Coordinator Info Updated', $message);
  }   
  
	
    public function new_user_email($name = NULL, $email = NULL, $password = NULL, $subject = NULL) {

        if ($email == NULL) {
            return false;
        }

        if ($subject == NULL) {
            $sub = ' - New User';
        }else{
            $sub = ' - New '.$subject;
        }

        $message = "<p><strong>Dear ".$name.",</strong><br/></p>
                <p>You have been added as an user at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
                Email: ".$email."<br/>
                Password: ".$password."<br/><br /></p>
                <p><a href='".base_url()."'> Click here</a> to login.</p>";
        //$message .= "<p>Thanks,<br /><i>".$this->CI->lang->line('app_site_name')." Team</i></p>";

        //echo $message;die;
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').$sub, $message);
    }

    public function new_password_email($name = NULL, $email = NULL, $password = NULL) {

        if ($email == NULL) {
            return false;
        }

        $message = "<p><strong>Dear ".$name.",</strong><br/></p>
                <p>Your password have been reset at ".$this->CI->lang->line('app_site_name')." with the following details.<br /><br />
                Email: ".$email."<br/>
                Password: ".$password."<br/><br/></p>";
        $message .= "<p>Please try using the new password and you can also reset it.</p><br/>";
        //$message .= "<p>Thanks,<br /><i>".$this->CI->lang->line('app_site_name')." Team</i></p>";

        //echo $message;die;
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - Reset Password', $message);
    }

    public function password_reset_email($activation_link = NULL, $to_email = NULL) {

        $message = "<p><strong>Dear User, </strong></p>";
        $message .= "<p>A password reset request has been submitted on your behalf.</p>";
        $message .= "<p>If you feel that this has been done in error, delete and disregard this email.
        				Your account is still secure and no one has been given access to it.
        				It is not locked and your password has not been reset.
        				Someone could have mistakenly entered your email address. </p>";
        $message .= "<p>Follow the link below to login and change your password. </p>";

        $message .= "<p><a href='".$activation_link."' >".$activation_link."</a></p><br /><br />";
        //$message .= "<p>Thanks,<br /><i>".$this->CI->lang->line('app_site_name')." Team</i></p>";
        //echo $message;die;

        $this->email_to_user($to_email, NULL, $this->CI->lang->line('app_site_name').' - Password Reset', $message);
    }
    
    public function email_activation_email($activation_link = NULL, $to_email = NULL) {

        $message = "<p><strong>Dear Customer, </strong></p>";
        $message .= "<p>Thank you for signing up with PHIT.</p>";
        $message .= "<p></p>";
        $message .= "<p>Follow the link below to activate your email address. </p>";

        $message .= "<p><a href='".$activation_link."' >".$activation_link."</a></p><br /><br />";

        $this->email_to_user($to_email, NULL, $this->CI->lang->line('app_site_name').' - Activate Email', $message);
    }

    public function bar_request_email($name = NULL, $bar_name = NULL, $status = NULL, $email = NULL) {

        if ($email == NULL) {
            return false;
        }

        $message = "<p><strong>Dear ".$name.",</strong><br/></p>
                <p>Your administrator request for ".$bar_name." has been ".$status." at ".$this->CI->lang->line('app_site_name').".<br /></p>";
        $message = "<p>Please login to view details<br /><br /></p>";

        //echo $message;die;
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - New User', $message);
    }


    public function notification_email($name = NULL, $email = NULL, $message = NULL, $roll = NULL,  $moduleName = NULL) {

      if ($email == NULL) {
          return false;
      }
      if($moduleName == NULL){
        $message = "<p><strong>Dear ".$name.",</strong><br/></p>".$message;
      }else{

          if(isset($role) && $role=='coordinator')
          {
              $message = "<p><strong>Dear ".$this->CI->lang->line('app_site_name').",</strong><br/><br/></p> <p>Coordinator has been successfully created new ".$moduleName.". See details below:-</p>".$message;
              
          }
          if(isset($role) && $role =='administrator')
          {
              $message = "<p><strong>Dear ".$this->CI->lang->line('app_site_name').",</strong><br/><br/></p> <p>Administrator has been successfully created new ".$moduleName.". See details below:-</p>".$message;
          }
        }

      //echo $message;die;
      // $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - Notification', $message);
      if(is_array($email)){
        foreach($email as $eml){
          $this->email_to_user($eml, $name, $this->CI->lang->line('app_site_name').' - Notification', $message);
        }
      }else{
        $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - Notification', $message);
      }
    }


   public function notification_email_to_school($name = NULL, $email = NULL, $message = NULL, $role=NULL , $moduleName = NULL)
    {
      
      if ($email == NULL) {
          return false;
      }
      if($moduleName == NULL){
        $message = "<p><strong>Dear ".$name.",</strong><br/></p>".$message;
      }else{

          if(isset($role) && $role =='coordinator')
          {
            $message = "<p><strong>Dear ".$this->CI->lang->line('app_site_name').",</strong><br/><br/></p> <p>Coordinator has been successfully created new ".$moduleName.". See details below:-</p>".$message;

          }
          if(isset($role) && $role =='administrator')
          {
          $message = "<p><strong>Dear ".$this->CI->lang->line('app_site_name').",</strong><br/><br/></p> <p>Administrator has been successfully created new ".$moduleName.". See details below:-</p>".$message;
          }
      }

      //echo $message;die;
      $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - Notification', $message);
    }

    public function invoice_notification_email($name = NULL, $email = NULL, $message = NULL) {

      if ($email == NULL) {
          return false;
      }
        $message = "<p><strong>Dear ".$name.",</strong><br/></p>".$message;
      
      $this->email_to_user($email, $name, $this->CI->lang->line('app_site_name').' - Notification for create invoice', $message);
    }
    public function email_to_user($to_email = NULL, $name = NULL, $subject = NULL, $message = NULL) {

        /*$config['protocol'] = 'sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->CI->email->initialize($config);

        $this->CI->email->from(NO_REPLY_EMAIL, $this->CI->lang->line('app_site_name'), CONTACT_EMAIL);
        $this->CI->email->reply_to(CONTACT_EMAIL, $this->CI->lang->line('app_site_name'));
        $this->CI->email->to($to_email);

        $this->CI->email->subject($subject);*/
        //$from = $this->CI->lang->line('app_site_name')." <".NO_REPLY_EMAIL.">";
		$from = "noreplymail@noreplymail.link";
		
        //SMTP & mail configuration
        $host = "smtp.gmail.com";
		$port = "587";
		$username = "noreplymail@noreplymail.link";
		$password = "BcUH55uDaa9gw98a";												


        $headers = array (
            'MIME-Version' => '1.0rn',
            'Content-Type' => "text/html; charset=ISO-8859-1rn",
            'From' => $from,
            'To' => $to_email,
            'Subject' => $subject,
        );

        $smtp = Mail::factory('smtp',
            array (
                'host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password
            )
        );

        $message .= "<p>Thank you,<br /><i><strong>".$this->CI->lang->line('app_site_name')."</strong></i></p>";

        $header = '<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<style>
/* -------------------------------------
    GLOBAL
------------------------------------- */
* {
  font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  font-size: 100%;
  line-height: 1.6em;
  margin: 0;
  padding: 0;
}
img {
  width: auto;
}
body {
  -webkit-font-smoothing: antialiased;
  height: 100%;
  -webkit-text-size-adjust: none;
  width: 100% !important;
}
/* -------------------------------------
    ELEMENTS
------------------------------------- */
a {
  color: #348eda;
}
.padding {
  padding: 10px 0;
}
/* -------------------------------------
    BODY
------------------------------------- */
table.body-wrap {
  padding: 0;
  width: 100%;
  border: 5px solid #753099;
}
table.body-wrap .container {
  border: 1px solid #ccc;
}
/* -------------------------------------
    FOOTER
------------------------------------- */
table.footer-wrap {
  clear: both !important;
  width: 100%;
  margin-top:20px;
}
.footer-wrap .container p {
  color: #666666;
  font-size: 12px;

}
table.footer-wrap a {
  color: #999999;
}
/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1,
h2,
h3 {
  color: #111111;
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  font-weight: 200;
  line-height: 1.2em;
  margin: 40px 0 10px;
}
h1 {
  font-size: 36px;
}
h2 {
  font-size: 28px;
}
h3 {
  font-size: 22px;
}
p,
ul,
ol {
  font-size: 14px;
  font-weight: normal;
  margin-bottom: 10px;
}
ul li,
ol li {
  margin-left: 5px;
  list-style-position: inside;
}
/* ---------------------------------------------------
    RESPONSIVENESS
------------------------------------------------------ */
/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
  clear: both !important;
  display: block !important;
  margin: 0 auto !important;
}
/* Set the padding on the td rather than the div for Outlook compatibility */
.body-wrap .container {
  padding: 20px;
}
/* This should also be a block element, so that it will fill 100% of the .container */
.content {
  display: block;
  /*margin: 0 auto;*/
}
/* Lets make sure tables in the content area are 100% wide */
.content table {
  width: 100%;
}

/**/
.logo-wrap {
  margin: 10px 0 0;
  width:100%;
  text-align:left;
}
.logo-wrap, .content, table.body-wrap, img{
  max-width: 600px;
}
</style>
</head>
<body>
<div class="logo-wrap"><h1><a href="'.BASE_URL.'"><img src="https://baasolutionsonline.com/assets/images/logo.png" alt="'.$this->CI->lang->line('app_site_name').'" title="'.$this->CI->lang->line('app_site_name').'"></a></h1></div>
<!-- body -->
<table class="body-wrap" cellpadding="0" cellspacing="0">
  <tr>
    <td class="container">
      <!-- content -->
      <div class="content">
      <table>
        <tr>
          <td>';

        $footer = '</td>
        </tr>
      </table>
      </div>
      <!-- /content -->
    </td>
    <td></td>
  </tr>
</table>
<!-- /body -->
<!-- footer -->
<table class="footer-wrap">
  <tr>
    <td></td>
    <td class="container">
      <!-- content -->
      <div class="content">
        <table>
          <tr>
            <td align="center">
              <p>
              </p>
            </td>
          </tr>
        </table>
      </div>
      <!-- /content -->
    </td>
    <td></td>
  </tr>
</table>
<!-- /footer -->
</body>
</html>';
        /*$this->CI->email->message($header.$message.$footer);
        $this->CI->email->send();*/
		
        $htmlContent = $header.$message.$footer;
        $mail = $smtp->send($to_email, $headers, $htmlContent);
		
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>"); die;
		} 
    }




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
