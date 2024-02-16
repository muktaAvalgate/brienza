<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_sms {

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
        
        //$this->CI->lang->load('application');
    }

    public function send_shipment_notification($shipment, $users) {

        //echo $message = "A shipment (PO no. ".$shipment['purchase_order_no'].") is posted on ".SITE_NAME." for your info.";
        $message = "A shipment (PO no. ".$shipment['purchase_order_no'].") is posted on ".SITE_NAME." for your info.";
        
        if (is_array($users)) {
        	/*foreach ($users as $user_id => $phone) {
        		$this->send_sms($phone, $message);
        	}*/
        	return $this->send_sms($users, $message);
        }        
    }
    
    public function send_otp_notification($otp, $number) {
    	
    	$message = "Your ".SITE_NAME." One Time Password (OTP) is ".$otp.". Please use it in next step.";
    	
    	return $this->send_sms(array($number), $message);
    }

    public function send_sms($phone = array(), $message = NULL) {
			
		$numbers = implode(',', $phone);

		// A single number or a comma-seperated list of numbers
		$message = urlencode($message);
		
		try {			
            /*$data = "username=".SMS_USER."&hash=".SMS_HASH."&message=".$message."&sender=".SMS_SENDER."&numbers=".$numbers."&test=".SMS_TEST;
			$ch = curl_init('http://api.textlocal.in/send/?');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // This is the result from the API
			curl_close($ch);*/
			
            $parameters = "UserName=".SMS_USER."&Password=".SMS_PASS."&Type=Bulk&To=".$numbers."&Mask=".SMS_SENDER."&Message=".$message."&Language=".SMS_LANG;
            $apiurl = "https://www.smsgatewaycenter.com/library/send_sms_2.php";
            
            $ch = curl_init($apiurl);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_HEADER,0);
            // DO NOT RETURN HTTP HEADERS
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            // RETURN THE CONTENTS OF THE CALL
            $result = curl_exec($ch);
            curl_close($ch);

			return json_decode($result);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n"; die;
		}
    }




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */