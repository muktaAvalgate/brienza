<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "libraries/tcpdf/PDFMerger.php";
require_once APPPATH . "libraries/tcpdf/tcpdf.php";
require_once APPPATH . "libraries/vendor/autoload.php";
use PDFMerger\PDFMerger;

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
		// $currDate = '2023-05-07';
		// Get all payment schedule by current date
		$payment_schedules = $this->App_model->get_payment_schedule_by_date($currDate);
		foreach ($payment_schedules as $schedule) {
			// Get schedule session
			// $sessions = $this->App_model->get_schedule_details_by_bw_date($schedule->session_from, $schedule->session_to);

			// remainder email to admin
			$is_sessions_exist = $this->App_model->get_schedules_of_notSubmitted($schedule->session_from, $schedule->session_to);
			if($is_sessions_exist == true){
				//notifying kate
				$days = array('Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday');
				$dayInt  =  date("w", strtotime($schedule->billing_date));
				$day = $days[$dayInt];
				// $email = 'bm.avalgate@gmail.com';
				$msg ='This is a reminder to please submit your <b>'.date("M d", strtotime($schedule->session_from)).' - '.date("M d", strtotime($schedule->session_to)).'</b> billing on or before <b> '.$day.', '. date("M d", strtotime($schedule->billing_date)).'</b> in BAASP. No billing will be accepted by payroll via email. Billing not received by the deadline will result in rate adjustments, as agreed upon in your Independent Contractor Agreement.';
				
				$this->load->library('mail_template');
				// $this->mail_template->invoice_notification_email('Brienza', 'gs.avalgate@gmail.com', $msg);
				$this->mail_template->invoice_notification_email('Brienza', 'brienzaportalstaging@gmail.com', $msg);
			}

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
					// $email = 'gs.avalgate@gmail.com';
					$msg ='This is a reminder to please submit your <b>'.date("M d", strtotime($schedule->session_from)).' - '.date("M d", strtotime($schedule->session_to)).'</b> billing on or before <b> '.$day.', '. date("M d", strtotime($schedule->billing_date)).'</b> in BAASP. No billing will be accepted by payroll via email. Billing not received by the deadline will result in rate adjustments, as agreed upon in your Independent Contractor Agreement.';
					// Notifying presenter for creating invoice
	                $this->load->library('mail_template');
	                $this->mail_template->invoice_notification_email($name, $email, $msg);
					// //notifying kate 
					// $msgForKate ='This is a reminder for presenter '.$name.' to submit his/her <b>'.date("M d", strtotime($schedule->session_from)).' - '.date("M d", strtotime($schedule->session_to)).'</b> billing on or before <b> '.$day.', '. date("M d", strtotime($schedule->billing_date)).'</b> in BAASP.<br/>';
					// // $this->mail_template->invoice_notification_email('Brienza', 'gs.avalgate@gmail.com', $msgForKate);
					// $this->mail_template->invoice_notification_email('Brienza', 'brienzaportalstaging@gmail.com', $msgForKate);
					
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

	function sample_billing_process_merge(){

		$data=array();
    	$documents = array();
        $documents = array(
            'assets/teachers/invoice_20230508090458.pdf',
            'assets/teachers/billing_attachment-212313249820230508090210.png',

            'assets/teachers/billing_attachment-155711204520230508090210.png',
            'assets/teachers/log_attachment-97288059320230508090323.pdf',

			'assets/teachers/billing_attachment-57292641220230508090210.png',
            'assets/teachers/log_attachment-57355628820230508090338.pdf',

			'assets/teachers/billing_attachment-183467754320230508090210.png',
            'assets/teachers/log_attachment-105179713220230508090354.png',
		);
		$this->margePdf($documents);
    }

	function margePdf($files){
		$checkImage =array('jpg','JPG','png','PNG','jpeg','JPEG');
		$checkDoc = array('doc','docx');
		$pdf_files=array();
		foreach($files as $file){
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if($ext){
				if(in_array($ext, $checkImage)){
					$imgPdf=$this->imagetopdf($file);
					array_push($pdf_files, $imgPdf);
				}else if(in_array($ext, $checkDoc)){
					$docPdf=$this->wordtopdf($file);
					array_push($pdf_files, $docPdf);
				}else{
					array_push($pdf_files, $file);
				}
			}
		}
		$pdf = new PDFMerger;

		if($pdf_files){
			foreach($pdf_files as $file){
				$pdf->addPDF( $file, 'all');
			}

			$new_file = 'sample_billing_process_merge'.'.pdf';
			//$new_file = 'abcde.pdf';
			$pdf->merge('file', APPPATH . '../assets/teachers/'.$new_file);

		} else {
			$new_file = '';
		}
		// return DIR_TEACHER_FILES.$new_file;
	}

	function imagetopdf($imagefile){ 
		//  ob_start();
		$file= base_url($imagefile);
		$save_file = DIR_TEACHER_FILES.md5(time().rand(1,10))."TESTM.pdf";
		$pagelayout = array('700', '600'); //  or array($height, $width)
		$pdf = new TCPDF('', 'pt', $pagelayout, true, 'UTF-8', false);
		$pdf->AddPage();
		$pdf->Image($file);
		//server
		//  ob_end_clean();
		//  ob_clean();
		//echo $save_file."  #";
		$pdf->Output($_SERVER['DOCUMENT_ROOT'].$save_file,'F');
		return $save_file;
	}

	function wordtopdf($wordfile){
		$objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
		//server
		$contents=$objReader->load($_SERVER['DOCUMENT_ROOT'].$wordfile);
		$rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

		$renderLibrary="tcpdf";
		$renderLibraryPath=APPPATH.'libraries/' . $renderLibrary;
		if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
			die("Provide Render Library And Path");
		}
		$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
		$save_file= DIR_TEACHER_FILES.date('YmdHis')."TESTW.pdf";
		$objWriter->save($save_file);
		return $save_file;
	}

	
}
