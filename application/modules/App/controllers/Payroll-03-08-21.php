<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends Application_Controller 
{

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
	* Basic member variable setup
	* mostly private types	
	*/
	private $tablename 			= 'payment_schedule';
	private $url 				= 'app/payroll';

	private $permissionValues 	= array(
											'index' 					=> 'App.Coordinators.View',
											'add' 						=> 'App.Coordinators.Add',
											'edit' 						=> 'App.Coordinators.Edit',
											'reset_pass' 				=> 'App.Coordinators.ResetPass',
											'delete' 					=> 'App.Coordinators.Delete',
											'update_status' 			=> 'App.Coordinators.UpdateStatus',
											'order' 		    		=> 'App.Orders.View',
											'update_status_temporder'	=> 'App.Temporders.UpdateStatus',
											'order_delete' 				=> 'App.Orders.Delete',
											'order_add' 				=> 'App.Orders.Add',
											'delete_temp_order'			=> 'App.Temporders.Delete',					
										); 

	private $role 				= 2;
	private $role_token 		= 'administrator';
	// ------- End of the segment ---------- //


	/**
	* Constructor defined
	*/
	public function __construct() 
	{
	    parent::__construct();
		parent::checkLoggedin(); // Validate Login

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
		$this->load->model('../../Admin/models/Admin_model');
	    $this->load->model('App_model');
	    $this->load->model('Payroll_model');
	}
	// --------- End of the code ---------- //


	/**
	* Following method will be used to
	* show list of payment configuration
	* created for the system
	* Created on: 03-08-2019
	* Created by: Soumya
	*/
	public function index()
	{
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]); // Permission checking

		if ($this->input->server('REQUEST_METHOD') === 'POST')	
		{
			$filter = array();
			if($this->input->post('session_start_date'))
				$filter['session_start_date'] 	= $this->input->post('session_start_date');
			if($this->input->post('session_end_date'))
				$filter['session_end_date'] 	= $this->input->post('session_end_date');
			if($this->input->post('month'))
				$filter['month'] 				= $this->input->post('month');
			if($this->input->post('year'))
				$filter['year'] 				= $this->input->post('year');

			$data['list'] = $this->Payroll_model->list_payment_schedules($filter);
		}	
		else
		{
			$data['list'] = $this->Payroll_model->list_payment_schedules();
		}
		foreach($data['list'] as $schedules){
            $current_row = $this->App_model->get_payementDetails_bypid($schedules->pshedule_id);
            $previous_row = $this->App_model->get_pre_payementDetails_bypid($schedules->pshedule_id);
            // echo '<pre>'; print_r($previous_row); die();
            $schedules->record = $this->App_model->getBilling_records_by_billingDate($current_row->billing_date, $previous_row->billing_date);
        }
	    $data['page'] 		= 'payroll';
    	$data['page_title'] = SITE_NAME.' :: Payment Schedule List';

    	$data['main_content'] = 'payroll/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	// ---------- End of the code --------- //


	/**
	* Following method will be used to
	* add payment configuration
	* Created on: 03-08-2019
	* Created by: Soumya
	*/
	public function payment_schedules_add()
	{
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]); // Permission checking

		if ($this->input->server('REQUEST_METHOD') === 'POST')	
		{
     		//form validation
			$this->form_validation->set_rules('session_from', 'Session From ', 'trim|required');
			$this->form_validation->set_rules('session_to', 'Session To', 'trim|required');
			$this->form_validation->set_rules('billing_date', 'Billing Date', 'trim|required');
			$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
			$this->form_validation->set_rules('email_remonder_date', 'Email Remider Date', 'trim|required');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
								'session_from'          => date('Y-m-d', strtotime($this->input->post('session_from'))),
                                'session_to'            => date('Y-m-d', strtotime($this->input->post('session_to'))),
								'billing_date' 			=> date('Y-m-d', strtotime($this->input->post('billing_date'))),
								'payment_date' 			=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
								'email_remonder_date' 	=> date('Y-m-d', strtotime($this->input->post('email_remonder_date'))),
				 				'month' 				=> date('m', strtotime($this->input->post('session_from'))),
				 				'year' 					=> date('Y', strtotime($this->input->post('session_from')))
    						);

    			$populate_schedule_data = $this->Payroll_model->insert($this->tablename, $data);

    			if($populate_schedule_data)
    			{
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Payment schedule been added successfully.');
    			}
    			else
    			{
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Unable to add data.');
    			}	

    			redirect('/app/payroll');
    		}						
		}
		//calculation for fixed startdate.
        $last_payment_details = $this->Payroll_model->get_last_payement_details();
        // echo '<pre>'; print_r($last_payment_details); die();
        $session_fromD = $last_payment_details->session_from;
        $startdateArray = explode("-", $session_fromD);
        $s_year = $startdateArray[0];
        $s_month = $startdateArray[1];
        $s_days = $startdateArray[2];

        if($s_days == 16){
            //chck current month''s days.
            //add days to date. 
            $noOfdays = cal_days_in_month(CAL_GREGORIAN,$s_month,$s_year);
            if($noOfdays == 31){
                $daysToAdd = '16';
            }else if($noOfdays == 29){
                $daysToAdd = '14';
            }else if($noOfdays == 28){
                $daysToAdd = '13';
            }else{
                $daysToAdd = '15';
            }
            $startDate = strtotime("+".$daysToAdd." days", strtotime($session_fromD));
            $sessionstartDate = date("Y-m-d", $startDate);
        }else{
            //add 15 days.
            $daysToAdd = '15';
            $startDate = strtotime("+".$daysToAdd." days", strtotime($session_fromD));
            $sessionstartDate = date("Y-m-d", $startDate); 
        }
        // echo $sessionstartDate; die();

        //cal for fixed enddate.
        $session_toD = $last_payment_details->session_to;
        // $session_toD = '2021-02-28';
        // echo $session_toD; die();
        $enddateArray = explode("-", $session_toD);
        $e_year = $enddateArray[0];
        $e_month = $enddateArray[1];
        $e_days = $enddateArray[2];
        // echo $e_days; 

        if($e_days == 15){
            $noOfdays = cal_days_in_month(CAL_GREGORIAN,$e_month,$e_year);
            //echo $noOfdays; die();
            if($noOfdays == 31){
                $daysToAdd = '16';
            }else if($noOfdays == 29){
                $daysToAdd = '14';
            }else if($noOfdays == 28){
                $daysToAdd = '13';
            }else{
                $daysToAdd = '15';
            }
            $endDate = strtotime("+".$daysToAdd." days", strtotime($session_toD));
            $sessionendDate = date("Y-m-d", $endDate); 
        }else{
            //add +1 day.
            $daysToAdd = '15';
            $endDate = strtotime("+".$daysToAdd." days", strtotime($session_toD));
            $sessionendDate = date("Y-m-d", $endDate); 
        }
        // echo $sessionendDate; die();
        $data['sessionstartDate'] = $sessionstartDate;
        $data['sessionendDate'] = $sessionendDate;
        //end---
	    $data['page'] 		= 'payroll';
    	$data['page_title'] = SITE_NAME.' :: Payment Schedule Add';

    	$data['main_content'] = 'payroll/add';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	// ---------- End of the code --------- //

	/**
	* Following method will be used to
	* edit payment configuration
	* Created on: 03-08-2019
	* Created by: Soumya
	*/
	public function payment_schedules_edit($id=null)
	{
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]); // Permission checking
		if($id == null){
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Something wrong pleasse try again.');
			redirect('app/payroll');
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')	
		{
     		//form validation
			$this->form_validation->set_rules('session_from', 'Session From ', 'trim|required');
			$this->form_validation->set_rules('session_to', 'Session To', 'trim|required');
			$this->form_validation->set_rules('billing_date', 'Billing Date', 'trim|required');
			$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
			$this->form_validation->set_rules('email_remonder_date', 'Email Remider Date', 'trim|required');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
								'session_from' 			=> date('Y-m-d', strtotime($this->input->post('session_from'))),
								'session_to' 			=> date('Y-m-d', strtotime($this->input->post('session_to'))),
								'billing_date' 			=> date('Y-m-d', strtotime($this->input->post('billing_date'))),
								'payment_date' 			=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
								'email_remonder_date' 	=> date('Y-m-d', strtotime($this->input->post('email_remonder_date'))),
				 				'month' 				=> date('m', strtotime($this->input->post('session_from'))),
				 				'year' 					=> date('Y', strtotime($this->input->post('session_from')))
    						);
    			
    			$populate_schedule_data = $this->Payroll_model->update($this->tablename,'pshedule_id', $id, $data);

    			if($populate_schedule_data)
    			{
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Payment schedule been updated successfully.');
    			}
    			else
    			{
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Unable to update data.');
    			}	

    			redirect('/app/payroll');
    		}						
		}		
	
		$data['schedule']	= $this->Payroll_model->getdetails_payment_schedule($id);
		$data['id']			= $id;
	    $data['page'] 		= 'payroll';
    	$data['page_title'] = SITE_NAME.' :: Payment Schedule Edit';

    	$data['main_content'] = 'payroll/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	// ---------- End of the code --------- //

	/**
	* Following method will be used to
	* to delete payment schedule from list
	* Created on: 03-08-2019
	* Created by: Soumya
	*/
	public function payment_schedules_delete($id)
	{
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]); // Permission checking
		$data['billing_date'] = "";
        $data['payment_date'] = "";
        $data['email_remonder_date'] = "";
		$update 			= $this->Payroll_model->update($this->tablename,'pshedule_id', $id, $data);

		if($update)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Payment schedule been deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Unable to delete data.');
		}

		redirect('/app/payroll');
	}
	// ---------- End of the code --------- //	

	/**
	 * Following method has been
	 * created to show the payable 
	 * schedule for a payment date
	 * Created by: Soumya
	 * Created on: 07-08-2019
	*/
	public function show_payable_schedules($id)
	{
        //echo "<pre>";print_r($uri);die;
        /* $order      = $this->Payroll_model->get_payable_schedules_order($id);
        $orderschedules = array();
		
        foreach ($order as $row) {
			if($row->session_from && $row->session_to){
				$schedules = $this->Payroll_model->get_payable_schedules_order_schedules($row->order_id, $row->session_from, $row->session_to);
				array_push($orderschedules, $schedules);
			}
        }
        // echo '<pre>'; print_r($orderschedules); die();
        $processed = $this->remove_level($orderschedules);
        foreach ($processed as $key => $val) {          
            $logData = $this->Payroll_model->get_schedule_logs($val->id);
            $processed[$key]->order_log = $logData;
        }
        // echo '<pre>'; print_r($processed); die();
        $data['order'] = $processed; */
        //2021-07-30---------start
        $crr_row = $this->App_model->get_payementDetails_bypid($id);
		$pre_row = $this->App_model->get_pre_payementDetails_bypid($id);
		
        $get_schedule_details = $this->App_model->get_schedule_ids_by_bllngDate($crr_row->billing_date, $pre_row->billing_date);
        //echo "<pre>";print_r($get_schedule_details);die;
        $order_schedule_ids = array();
        if(!empty($get_schedule_details)){
            foreach($get_schedule_details as $row){
                $order_schedule_ids[] = $row->order_schedule_id;
            }
            // echo "<pre>";print_r($order_schedule_ids);die;
            $processed = $this->Payroll_model->get_payable_schedules_order_schedules_new($order_schedule_ids);
            // echo "<pre>";print_r($processed);die;
            foreach ($processed as $key => $val) {          
                $logData = $this->Payroll_model->get_schedule_logs($val->id);
                $processed[$key]->order_log = $logData;
            }
            $data['order'] = $processed;
        }
        //2021-07-30---------end
        
        $data['id']         = $id;
        $data['page']       = 'payroll';
        $data['page_title'] = SITE_NAME.' :: Payable Schedule List';

        $data['main_content'] = 'payroll/scheduling';
        // echo "<pre>";print_r($data);die;
        $this->load->view(TEMPLATE_PATH, $data);
	}
	// ---------- End of the code ------------ //	

	public function download_log($order_schedule_id=0){
		
		$logData = $this->App_model->get_log_pdf_content($order_schedule_id);
		
		if($logData->attachment == ''){
			$log = $logData->create_log_content.'<img src="'.base_url().$logData->content.'">';

			//load mPDF library
			$this->load->library('m_pdf');

			//this the the PDF filename that user will get to download
			$data['attachment'] = "log_".date('YmdHis').".pdf";		
						
			//generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($log);
			$this->m_pdf->pdf->setTitle('Log-'.date('YmdHis'));
			
			//download it.
			$this->m_pdf->pdf->Output($data['attachment'], 'I');
		}else{
			$log = '<img src="'.base_url().$logData->attachment.'">';
			echo $log;
		}
	}

	public function download_csv($payment_schedule_id=0){

		$pScheduleData = $this->Payroll_model->getdetails_payment_schedule($payment_schedule_id);

		if(!empty($pScheduleData)){
			//$records = $this->Payroll_model->get_payable_schedules($payment_schedule_id);
			/* $orderschedules = array();
            $records = $this->Payroll_model->get_payable_schedules_order($payment_schedule_id);
            foreach ($records as $row) {
                if($row->session_from && $row->session_to){
                    $schedules = $this->Payroll_model->get_payable_schedules_order_schedules($row->order_id, $row->session_from, $row->session_to);
                    array_push($orderschedules, $schedules);
                }   
            }
            // echo '<pre>'; print_r($orderschedules); die();
            $processed = $this->remove_level($orderschedules); */
			//2021-07-30---------------start
            $crr_row = $this->App_model->get_payementDetails_bypid($payment_schedule_id);
            $pre_row = $this->App_model->get_pre_payementDetails_bypid($payment_schedule_id);

            $get_schedule_details = $this->App_model->get_schedule_ids_by_bllngDate($crr_row->billing_date, $pre_row->billing_date);
            // echo "<pre>";print_r($get_schedule_details);die;
            foreach($get_schedule_details as $row){
                $order_schedule_ids[] = $row->order_schedule_id;
            }
            // echo "<pre>";print_r($order_schedule_ids);die;
            $processed = $this->Payroll_model->get_payable_schedules_order_schedules_new($order_schedule_ids);
            // echo "<pre>";print_r($processed);die;
            //2021-07-30---------------end
			$delimiter = ",";
		    $filename = "payment_schedule_" . date('YmdHis') . ".csv";
		    
		    //create a file pointer
		    $f = fopen('php://memory', 'w');
		    
		    //set column headers
		    $fields = array('Session', 'PO', 'Presenter', 'Email', 'Phone Number', 'Status');
		    fputcsv($f, $fields, $delimiter);
		    
		    //output each row of the data, format line as csv and write to file pointer

			/*foreach ($records as $key => $row) {
				$session = date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).'-'.time_display($row->end_date, true).' with '.$row->teacher;
				$lineData = array($session, $row->order_no, $row->persenter_name, $row->presenter_email, $row->presenter_phone, $row->new_status);
				fputcsv($f, $lineData, $delimiter);
			}*/
			
			foreach ($processed as $key => $row) {
                $session = date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).'-'.time_display($row->end_date, true).' with '.$row->teacher;
                $lineData = array($session, $row->order_no, $row->persenter_name, $row->presenter_email, $row->presenter_phone, $row->status);
                fputcsv($f, $lineData, $delimiter);
            }
		    
		    //move back to beginning of file
		    fseek($f, 0);
		    
		    //set headers to download file rather than displayed
		    header('Content-Type: text/csv');
		    header('Content-Disposition: attachment; filename="' . $filename . '";');
		    
		    //output all remaining data on a file pointer
		    fpassthru($f);exit;
		}
	}
	

	 private function init_pagination($uri, $segment=4, $total_rows) {

    	$this->config->load('pagination');
    	$this->load->library('pagination');

    	$config = $this->config->item('pagination');

       	$ci                          =& get_instance();
       	$config['uri_segment']       = $segment;
       	$config['base_url']          = base_url().$uri;
       	$config['total_rows']        = $total_rows;

       	$ci->pagination->initialize($config);
       	return $config;
   	}

   	public function search_submit($id) {
   		//echo $id;die;
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //echo "<pre>";print_r($_POST);die;
            $presenter = $this->clean_value($this->input->post('presenter'));
           
            $url = "app/payroll/show_payable_schedules/".$id.'/';
            
          
            $presenter = urlencode($presenter);
            if ($presenter != '' && $presenter != '~') {
                $url .= "presenter/". $presenter."/";
            }

         

            //$url .= '?id='.$this->input->get('id');

            redirect($url);
        }
    }
    private function clean_value($str) {

		$str = str_replace('/', '~', $str);
		return preg_replace('/[^A-Za-z0-9_\-~]/', '', $str);
    }
	public function remove_level($array) { 
        $result = array(); 
        foreach ($array as $key => $value) { 
            if (is_array($value)) { 
                $result = array_merge($result, $value);
            } 
        } 
        return $result;
    }

}