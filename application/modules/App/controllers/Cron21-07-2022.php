<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends Application_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	/**
	 *
	 * @var unknown_type
	 */

	private $baa_co_id 	= 177; // BAA Coordinator ID

    //private $allowed_roles = array('bar_admin');

	public function __construct() {

        parent::__construct();

        $this->load->model('App_model');
		$this->load->model('../../Admin/models/Admin_model');
    }
	
	public function invoice_reminder() {
		
		$currDate = date('Y-m-d');
		// $currDate = '2021-09-16';
		// Get all payment schedule by current date
		$payment_schedules = $this->App_model->get_payment_schedule_by_date($currDate);
		foreach ($payment_schedules as $schedule) {
			// Get schedule session
			// $sessions = $this->App_model->get_schedule_details_by_bw_date($schedule->session_from, $schedule->session_to);
			$sessions = $this->App_model->schedules_for_cron($schedule->session_from, $schedule->session_to);
			// echo '<pre>'; print_r($sessions); die();
			foreach ($sessions as $k => $session) {
				if($schedule->billing_date >= date('Y-m-d')){
					// Get presenter details
					$days = array('Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday');
					$dayInt  =  date("w", strtotime($schedule->billing_date));
					$day = $days[$dayInt];
					$presenter = $this->Admin_model->get_user_details($session->created_by);
					$name = ucwords($presenter->first_name)." ".ucwords($presenter->last_name);
					$email = $presenter->email;
					// $email = 'bm.avalgate@gmail.com';
					$msg ='This is a reminder to please submit your <b>'.date("M d", strtotime($schedule->session_from)).' - '.date("M d", strtotime($schedule->session_to)).'</b> billing on or before <b> '.$day.', '. date("M d", strtotime($schedule->billing_date)).'</b> in BAASP. No billing will be accepted by payroll via email. Billing not received by the deadline will result in rate adjustments, as agreed upon in your Independent Contractor Agreement.';
					// Notifying presenter for creating invoice
	                $this->load->library('mail_template');
	                $this->mail_template->invoice_notification_email($name, $email, $msg);
					//notifying kate 
					$msgForKate ='This is a reminder for presenter '.$name.' to submit his/her <b>'.date("M d", strtotime($schedule->session_from)).' - '.date("M d", strtotime($schedule->session_to)).'</b> billing on or before <b> '.$day.', '. date("M d", strtotime($schedule->billing_date)).'</b> in BAASP.<br/>';
					// $this->mail_template->invoice_notification_email('Kate', 'gs.avalgate@gmail.com', $msgForKate);
					$this->mail_template->invoice_notification_email('Brienza', 'brienzaportalstaging@gmail.com', $msgForKate);
				}
			}
			break;
		}


		//$schedules = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");

	}

	public function create_sessions(){
        $curYear = date('Y');
        $curMonth = date('m');
        $curDay = date('d');
        $nextYear = $curYear + 1;
        $session_array=array();
       
        if($curMonth == '09' && $curDay == '01'){
            $session_array = array('name'=>'Summer '.$nextYear,'start_date'=>$nextYear .'-07-01','end_date'=>$nextYear .'-08-31',);
        }

        if($curMonth == '07' && $curDay == '01'){
            $session_array = array('name'=>'Fall/ Spring '.$curYear .'-'.$nextYear,'start_date'=>$curYear .'-09-01','end_date'=>$nextYear .'-06-30',);
        }
        if(!empty($session_array)){
            $this->App_model->insert('sessions', $session_array);
        }
    }

	
}
