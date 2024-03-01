<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Application_Controller {

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
	protected $data = array();

	public function __construct() {

        parent::__construct();
    }

	public function index() {

		if ($this->session->userdata('is_logged_in')) {
        	redirect('dashboard');
        } else {

        	$this->data['page_title'] = $this->lang->line('auth_login_page_title');
        	$this->load->view('login', $this->data);
        }
	}

	/**
     * Login into account
     * Sets sesstion data
     */
    public function do_login() {

    	$this->load->library('form_validation');

    	$this->data['page_title'] = $this->lang->line('auth_login_page_title');

    	if ($this->session->userdata('is_admin_login')) {
            redirect('dashboard');
        } else {

        	$email = $this->input->post('email');
        	$password = $this->input->post('password');

            $this->form_validation->set_rules('email', $this->lang->line('auth_login_form_email_label'), 'required');
            $this->form_validation->set_rules('password', $this->lang->line('auth_login_form_password_label'), 'required');

            if ($this->form_validation->run() == FALSE) {

            	$this->data['error'] = $this->lang->line('auth_login_validation_error');
                $this->load->view('login', $this->data);

            } else {

            	$this->load->model('Auth_model');
            	//$this->load->helper('date');

            	if($is_valid_details = $this->Auth_model->validate($email, $this->_encrip_password($password)))
            	{
                    $data = array(
            			'id' => $is_valid_details->id,
            			'name' => $is_valid_details->name,
            			'email' => $is_valid_details->email,
            			//'last_login' => mdate("%m/%d/%Y - %h:%i %a", strtotime($is_valid_details->last_login)),
						'last_login' => $is_valid_details->last_login,
                    	'role' => $is_valid_details->role_token,
						'profile_pic' => $this->Auth_model->get_user_pic($is_valid_details->id),
                    	'permissions' => $this->Auth_model->get_user_permissions($is_valid_details->id),
                    	'navmenu' => $this->Auth_model->get_main_menu($is_valid_details->role_id),
            			'is_logged_in' => true
            		);
					
            		$this->session->set_userdata($data);
					//IP addition work 
                    $ip_address=null;
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    }else{
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                    }
            		//$this->Auth_model->update('id', $is_valid_details->id, array('last_login' => date('Y-m-d H:i:s')));
					$this->Auth_model->update('id', $is_valid_details->id, array('last_login' => date('Y-m-d H:i:s'),'last_login_ip'=>$ip_address));
					
					// For first time School login, go to title page
					if ($data['last_login'] == "" && $data['role'] == "school_admin"){ 
						redirect('/app/schools/titles');
					}
            		redirect('dashboard');
            	}
                else {

                	$this->data['error'] = $this->lang->line('auth_login_error');
                    $this->load->view('login', $this->data);
                }
            }
        }
    }

    /**
     *  Admin Forgot Password
     */
    function forgot_password() {

        $this->data['page_title'] = $this->lang->line('auth_forgot_password_page_title');

    	if ($this->input->server('REQUEST_METHOD') === 'POST') {

    		$this->load->library('form_validation');

    		//form validation
    		$this->form_validation->set_rules('email', $this->lang->line('auth_forgot_form_email_label'), 'required');
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run()) {

    			$email = $this->input->post('email');

    			$this->load->model('Auth_model');

    			if ($info = $this->Auth_model->is_valid_data('users', array('email' => $email))) {

    				$user_id = $info->id;
    				$user_info = $this->Auth_model->get_user_by_id($user_id);

    				$data_to_insert = array(
    					'user_id' => $user_info->id,
    					'token' => md5(time()),
    					'create_date' => date('Y-m-d H:i:s')
    				);

    				$this->Auth_model->save_password_log($data_to_insert);

    				// Send Email to reset admin password starts
    				$activation_link = BASE_URL.'recover_password/'.$data_to_insert['token'];
    				$to_email = $email;

    				$this->load->library('mail_template');
    				$this->mail_template->password_reset_email($activation_link, $to_email);


    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', $this->lang->line('auth_forgot_password_success_msg'));
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', $this->lang->line('auth_forgot_password_failure_msg'));
    			}
    		}

    		//redirect('forgot_password');
    	}

    	$this->load->view('forgot_password', $this->data);
    }


   /**
    *
    * @param unknown_type $enc_str
    */
   function recover_password ($encrypted_string) {

   		$this->load->library('encrypt');
   		$this->load->model('Auth_model');

   		$this->data['page_title'] = $this->lang->line('auth_recover_password_page_title');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

        	$this->load->library('form_validation');

        	//form validation
        	$this->form_validation->set_rules('new_pwd', $this->lang->line('auth_recover_password_form_password_label'), 'trim|required|matches[re_new_pwd]');
        	$this->form_validation->set_rules('re_new_pwd', $this->lang->line('auth_recover_password_form_confirm_password_label'), 'trim|required');
        	$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

        	//if the form has passed through the validation
        	if ($this->form_validation->run()) {

        		$key = $this->input->post('key');
        		$user_id = $this->encrypt->decode($key);
        		$pwd = $this->_encrip_password($this->input->post('new_pwd'));

        		if ($this->Auth_model->update('id', $user_id, array('password' => $pwd))) {

        			$pass_info = $this->Auth_model->is_valid_data('user_password_log', array('token' => $encrypted_string, 'user_id' => $id));
        			$this->Auth_model->update_password_log($pass_info->id, array('visited' => 1));

        			$this->session->set_flashdata('message_type', 'success');
        			$this->session->set_flashdata('message', $this->lang->line('auth_recover_password_success_msg'));
        		}
        		redirect(BASE_URL);
        	}
        }

    	if ($encrypted_string) {

    		if ($this->data['link_info'] = $this->Auth_model->is_valid_data('user_password_log', array('token' => $encrypted_string, 'visited' => 0))) {
    			//$data['user_info'] = $this->common_db_model->get(1, 0, '', array('token' => $encrypted_string));

    			if (empty($this->data['link_info'])) {
    				redirect(BASE_URL);
    			}

    			// Check for validity of the link (1 hr)
    			$time = strtotime($this->data['link_info']->create_date);
    			$now = time();
    			if ($now - $time > RESET_PASSWORD_LINK_VALIDITY) {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Allowed timelimit exceed.');
    				redirect(BASE_URL);
    			}

    			$this->data['link_info']->enc_key = $this->encrypt->encode($this->data['link_info']->user_id);
    			$this->load->view('recover_password', $this->data);

    		} else {

    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Not a valid link.');

    			redirect(BASE_URL);
    		}
    	} else {
    		redirect(BASE_URL);
    	}

    }


    /**
     * encript the password
     * @return mixed
     */
    function _encrip_password($password) {
    	return md5($password);
    }

    /**
     * Logout from account
     */
    public function logout() {

        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        redirect('', 'refresh');
    }

    /**
     *
     */
    public function dashboard() {

    	// Validate Login
		parent::checkLoggedin();

		$this->data['dashboard'] = array();

		$this->load->model('Auth_model');
        $this->load->model('../../App/models/App_model');

		//echo $this->session->userdata('role'); die;
		if ($this->session->userdata('role') == "super_administrator") {
			$this->data['dashboard'] = $this->Auth_model->get_admin_dashboard();
		} else if ($this->session->userdata('role') == "teacher") {
			$this->data['dashboard'] = $this->Auth_model->get_teacher_dashboard();
			$this->data['last_hrs_to_cnf_ord_id'] = $this->Auth_model->get_teacher_orders_horstoconfirm();
            $this->data['new_tag_ready_to_invoice'] = $this->Auth_model->get_status_createInvoice_sessionwise_dashboard();
            $this->data['total_hours_ready_to_invoice'] = $this->Auth_model->total_hours_ready_to_invoice_dashboard();
            //session from table
            $this->data['session_array'] = $this->App_model->get_sessions();
            $curr_date = date("Y-m-d h:i:s");
            $this->data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		} else if ($this->session->userdata('role') == "school_admin") {
            $this->data['dashboard'] = $this->Auth_model->get_school_dashboard();
        } ## Following elseif part has been created on: 18-07-2019 by: Soumya
        elseif ($this->session->userdata('role') == "coordinator") {
            $this->data['dashboard'] = $this->Auth_model->get_admin_dashboard();
        }  else {
			$this->data['dashboard'] = $this->Auth_model->get_dashboard();
            // Count unread logs
            $this->load->model('../../App/models/Notify_model');
            $this->data['log_details'] = $this->Notify_model->get_log_details();
            
            $this->data['total_new_schedule_hour'] = $this->Auth_model->get_new_schedule_hour($this->session->userdata('last_login'), date('Y-m-d H:i:s'));
		}

        //session from table
		$this->data['s_array'] = $this->App_model->get_sessions();
        $curr_date = date("Y-m-d h:i:s");
        $this->data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		
		//print "<pre>"; print_r($this->data); print "</pre>";
        $this->data['new_billing'] = $this->Auth_model->get_new_billing_count();
        $this->data['page'] = 'dashboard';
        $this->data['page_title'] = $this->lang->line('auth_dashboard_page_title');

    	$this->data['main_content'] = 'dashboard';
    	$this->load->view(TEMPLATE_PATH, $this->data);
    }

    
    /**
     * Following method will be used 
     * to list down those order which got payment 
     * for at least one shedule
     * Created on: 23/07/2019
     * Created by: Soumya
    */
    public function paidorders($export = '') 
    {
        $this->load->model('Auth_model');

        // Include the Module JS file.
        add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
        add_js('assets/js/plugins/colResizable-1.6.min.js');

        $filter             = array('deleted' => 0);
        $default_uri        = array('page', 'status', 'school', 'presenter', 'order_start_date', 'order_end_date', 'order_no');
        $uri                = $this->uri->uri_to_assoc(2, $default_uri);
        $pegination_uri     = array();

        // echo "<pre>";print_r($uri);exit;

        if ($uri['page'] > 0) {
            $page = $uri['page'];
        } else {
            $page = 0;
        }
        
        if ($uri['order_no'] <> "" && $uri['order_no'] <> "~") {
            $filter['order_no'] = $uri['order_no'];
            $pegination_uri['order_no'] = $uri['order_no'];
        } else {
            $filter['order_no'] = "";
            $pegination_uri['order_no'] = "~";
        }
        
        if ($uri['status'] <> "" && $uri['status'] <> "~") {
            $filter['status'] = $uri['status'];
            $pegination_uri['status'] = $uri['status'];
        } else {
            $filter['status'] = "";
            $pegination_uri['status'] = "~";
        }
        
        if ($uri['school'] <> "" && $uri['school'] <> "~") {
            $filter['school'] = $uri['school'];
            $pegination_uri['school'] = $uri['school'];
        } else {
            $filter['school'] = "";
            $pegination_uri['school'] = "~";
        }
        
        if ($uri['presenter'] <> "" && $uri['presenter'] <> "~") {
            $filter['presenter'] = $uri['presenter'];
            $pegination_uri['presenter'] = $uri['presenter'];
        } else {
            $filter['presenter'] = "";
            $pegination_uri['presenter'] = "~";
        }
        
        if ($uri['order_start_date'] <> "" && $uri['order_start_date'] <> "~") {
            $filter['order_start_date'] =  str_replace('~', '/', $uri['order_start_date']);
            $pegination_uri['q'] = $uri['order_start_date'];
        } else {
            $filter['order_start_date'] = "";
            $pegination_uri['order_start_date'] = "~";
        }
        
        if ($uri['order_end_date'] <> "" && $uri['order_end_date'] <> "~") {
            $filter['order_end_date'] = str_replace('~', '/', $uri['order_end_date']);
            $pegination_uri['q'] = $uri['order_end_date'];
        } else {
            $filter['order_end_date'] = "";
            $pegination_uri['order_end_date'] = "~";
        }
        
        if ($this->session->userdata('role') != 'administrator') {
            $filter['school'] = $this->session->userdata('id');
        }
        
        // Get the total rows without limit
        $total_rows     = $this->Auth_model->get_orderpaid_list($filter, null, null, true);
        $config         = $this->init_pagination('app/orders/index/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 15, $total_rows);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }

        $filter['limit'] = $config['per_page'];
        $filter['offset'] = $limit_end;

        // Get the order List
        $data['orders'] = $this->Auth_model->get_orderpaid_list($filter, 'created_on', 'desc');

        if($export == 'export_excel'){

            require_once APPPATH . "/third_party/PHPExcel/PHPExcel.php";
            
            //header info for browser
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Order No');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Work Plan No');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'School');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Presenter');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Title'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Hours'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Order Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Paid To Brienza'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Unbilled Brienza'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Paid To Presenter'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Unbilled Presenter');      
            // set Row
            $rowCount = 2;
            foreach ($data['orders'] as $element) {
                $pData = $this->Auth_model->get_user_by_id($element->schedule_presenter_id);
                $presenterName = $pData->first_name.' '.$pData->last_name;

                $BrienzaPaid = '$'.number_format(($element->brienza_price*$element->paid_to_brienza), 2);
                $BrienzaUnbilled = '$'.number_format(($element->brienza_price*($element->hours-$element->paid_to_brienza)), 2);

                $pData = json_decode(json_encode($element->assigned_presenter), true);
                $PaidPresenter = '$'.number_format(array_sum(array_column($pData, 'paid')), 2);
                $unbilledPresenter = '$'.number_format(array_sum(array_column($pData, 'unbilled_payment')), 2);

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->order_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->work_plan_number);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->school_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $presenterName);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element->title_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element->hours.' Hours');
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, date('m/d/Y', strtotime($element->booking_date)));
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $BrienzaPaid);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $BrienzaUnbilled);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $PaidPresenter);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $unbilledPresenter);
                $rowCount++;
            }
            $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray(array('font' => array('bold' => true)));
            $object_excel_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');// Explain format of Excel data
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="total-billed-'.date('YmdHis').'.xls"');
            $object_excel_writer->save('php://output'); // For automatic download to local computer
        
            exit;
        }

        $data['filter'] = $filter;
        //echo "<pre>";print_r($data['orders']);die;
        $data['page'] = 'orders';
        $data['page_title'] = SITE_NAME.' :: Billed Orders';

        $data['main_content'] = 'invoices';
        $this->load->view(TEMPLATE_PATH, $data);
    }
    ## ------------- End of the code --------------- ## 

    /**
     * Method to show the invoice
     * details in terms of check numbers
     * per schedule of an order
     * Created on: 30-07-2019
     * Created by: Soumya
    */

    public function search_submit() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $order_no = $this->clean_value($this->input->post('order_no'));
            $order_start_date = $this->clean_value($this->input->post('order_start_date'));
            $order_end_date = $this->clean_value($this->input->post('order_end_date'));
            $school = $this->clean_value($this->input->post('school'));
            $presenter = $this->clean_value($this->input->post('presenter'));
            $status = $this->clean_value($this->input->post('status'));

            $url = "totalbilled/";
            
            $order_no = urlencode($order_no);
            if ($order_no != '' && $order_no != '~') {
                $url .= "order_no/". $order_no."/";
            }
            
            // $order_start_date = urlencode($order_start_date);
            if ($order_start_date != '' && $order_start_date != '~') {
                $url .= "order_start_date/". $order_start_date."/";
            }

            // $order_end_date = urlencode($order_end_date);
            if ($order_end_date != '' && $order_end_date != '~') {
                $url .= "order_end_date/". $order_end_date."/";
            }
            
            // $school = urlencode($school);
            // if ($school != '' && $school != '~') {
            //     $url .= "school/".$school."/";
            // }

            // $presenter = urlencode($presenter);
            // if ($presenter != '' && $presenter != '~') {
            //     $url .= "presenter/". $presenter."/";
            // }

            // $status = urlencode($status);
            // if ($status != '' && $status != '~') {
            //     $url .= "status/". $status."/";
            // }

            redirect($url);
        }
    }
    
    private function clean_value($str) {

        $str = str_replace('/', '~', $str);
        return preg_replace('/[^A-Za-z0-9_\-~]/', '', $str);
    }

    public function get_invoice_details($order_id = NULL)
    {
        $this->load->model('Auth_model');
        $order_id = (int)$order_id;

        $data['order_details']  = $this->Auth_model->get_order_details($order_id);
        $order_schedule_details = $this->Auth_model->get_order_schedule_details($order_id);

        $data['schedule_list']  = $order_schedule_details['billed_schedule_list'];
        $data['total_hours']    = $order_schedule_details['fianl_total_hours'];
        $data['total_amount']   = $order_schedule_details['final_total_amount'];

        $data['page']           = 'orders';
        $data['page_title']     = SITE_NAME.' :: Billed Invoice Details';
        $data['main_content']   = 'invoice_details';

        // echo "<pre>";print_r($data);exit;
        
        $this->load->view(TEMPLATE_PATH, $data);
    }
    ## --------------- End of the code ------------------ ##

    /**
     * Method for pagination
     * Created on: 23/07/2019
     * Implement by: Soumya
     */
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
    ## --------- End of the code ------------ ##    

    public function agenda_schedule() 
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url1 = "https://";   
        else  
            $url1 = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url1.= $_SERVER['HTTP_HOST'];   
        
        // Append the requested resource location to the URL   
        $url1.= $_SERVER['REQUEST_URI'];    
        
        $key = 'sessionSort';
        $key2 = 'statusSort';
        if (strpos($url1, $key) == true) {
            $session_sort = 'sessionSort';
        }
        if(strpos($url1, $key2) == true){
            $status_sort = 'statusSort';
        }

        $this->load->model('Auth_model');
        $this->load->model('../../Admin/models/Admin_model');

        // Include the Module JS file.
        add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
        add_js('assets/js/plugins/colResizable-1.6.min.js');

        $filter             = array('deleted' => 0);
        // $default_uri        = array('page', 'status', 'school', 'presenter', 'order_start_date', 'order_end_date', 'order_no');
        if(!empty($session_sort) && !empty($status_sort)){
            $default_uri        = array('page', 'date', 'presenter', 'status', 'sessionSort', 'statusSort');
        }else if(!empty($session_sort) && empty($status_sort)){
            $default_uri        = array('page', 'date', 'presenter', 'status', 'sessionSort');
        }else if(!empty($status_sort) && empty($session_sort)){
            $default_uri        = array('page', 'date', 'presenter', 'status', 'statusSort');
        }else{
            $default_uri        = array('page', 'date', 'presenter', 'status');
        }


        // $uri                = $this->uri->uri_to_assoc(2, $default_uri);
        $uri                = $this->uri->uri_to_assoc(3, $default_uri);

        $pegination_uri     = array();

        if ($uri['page'] > 0) {
            $page = $uri['page'];
        } else {
            $page = 0;
        }

        if ($uri['date'] <> "" && $uri['date'] <> "~") {
            $filter['date'] =  str_replace('~', '/', $uri['date']);
			$pegination_uri['date'] = $uri['date']; 
        } else {
			$filter['date'] = "";
			$pegination_uri['date'] = "~";
		}

        if ($uri['presenter'] <> "" && $uri['presenter'] <> "~") {
            $filter['presenter'] = $uri['presenter'];
			$pegination_uri['presenter'] = $uri['presenter'];
        } else {
			$filter['presenter'] = "";
			$pegination_uri['presenter'] = "~";
		}

        if ($uri['status'] <> "" && $uri['status'] <> "~") {
            $filter['status'] = $uri['status'];
			$pegination_uri['status'] = $uri['status'];
        } else {
			$filter['status'] = "";
			$pegination_uri['status'] = "~";
		}
        

        if(isset($session_sort) && ($session_sort == 'sessionSort')){
            if ($uri['sessionSort'] <> "" && $uri['sessionSort'] <> "~") {
                $filter['sessionSort'] = $uri['sessionSort'];
                $pegination_uri['sessionSort'] = $uri['sessionSort'];
            } else {
                $filter['sessionSort'] = "";
                $pegination_uri['sessionSort'] = "~";
            }
        }
        if(isset($status_sort) && ($status_sort == 'statusSort')){
            if ($uri['statusSort'] <> "" && $uri['statusSort'] <> "~") {
                $filter['statusSort'] = $uri['statusSort'];
                $pegination_uri['statusSort'] = $uri['statusSort'];
            } else {
                $filter['statusSort'] = "";
                $pegination_uri['statusSort'] = "~";
            }
        }
        echo '<pre>'; print_r($filter);die;
        // Get the total rows without limit
        $total_rows     = $this->Auth_model->get_agenda_schedule($filter, null, null, true);
        // $config         = $this->init_pagination('agenda_schedule/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 3, $total_rows);
        if(!empty($session_sort) && !empty($status_sort)){
            $config         = $this->init_pagination('auth/agenda_schedule/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 14, $total_rows);
        }else if(!empty($session_sort) && empty($status_sort)){
            $config         = $this->init_pagination('auth/agenda_schedule/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 12, $total_rows);
        }else if(!empty($status_sort) && empty($session_sort)){
            $config         = $this->init_pagination('auth/agenda_schedule/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 12, $total_rows);
        }else{
            $config         = $this->init_pagination('auth/agenda_schedule/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 10, $total_rows);
        }

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }

        $filter['limit'] = $config['per_page'];
        $filter['offset'] = $limit_end;

        // Get the order List
        $data['schedules'] = $this->Auth_model->get_agenda_schedule($filter, 'created_on', 'desc');
        $data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
        $data['filter'] = $filter;

        $data['page'] = 'orders';
        $data['page_title'] = SITE_NAME.' :: Agenda Schedule';

        $data['main_content'] = 'agenda_schedule';
        $this->load->view(TEMPLATE_PATH, $data);
    }

    public function session_details(){
        $this->load->model('../../App/models/App_model');
        $session_id = $this->input->post('session');
        $totHoursAssgnd = $this->App_model->get_total_hours_assigned($session_id);
        $totHoursSchedule = $this->App_model->get_total_hours_schedule($session_id);
        if($totHoursAssgnd && $totHoursSchedule){
            $return_arr = array('totHoursAssgnd'=>round($totHoursAssgnd->total_assigned_hours),'totHoursSchedule'=>round($totHoursSchedule->total_scheduled_hours));
        }else{
            $return_arr = array('totHoursAssgnd'=>0,'totHoursSchedule'=>0);
        }
        echo json_encode($return_arr);
    }

    public function session_details_presenter(){
        // echo 'aa'; die();
        $this->load->model('../../App/models/App_model');
        $session_id = $this->input->post('session');
        $totHoursAssgnd = $this->App_model->get_total_hours_assigned($session_id, $this->session->userdata('id'));
        // print_r($data['totHoursAssgnd']); die();
        $totHoursSchedule = $this->App_model->get_total_hours_schedule($session_id, $this->session->userdata('id'));
        //print_r($data['totHoursSchedule']); die();
        // $return_arr = array('totHoursAssgnd'=>round($totHoursAssgnd->total_assigned_hours),'totHoursSchedule'=>round($totHoursSchedule->total_scheduled_hours));
        if($totHoursAssgnd && $totHoursSchedule){
            $return_arr = array('totHoursAssgnd'=>round($totHoursAssgnd->total_assigned_hours),'totHoursSchedule'=>round($totHoursSchedule->total_scheduled_hours));
        }else{
            $return_arr = array('totHoursAssgnd'=>0,'totHoursSchedule'=>0);
        }
        // print_r($return_arr); die();
        echo json_encode($return_arr);
        // $details = array($totHoursAssgnd,$totHoursSchedule);
        // // print_r($details);
        // echo $details;
    }

    public function submit_agenda_search(){
        // $url = "auth/agenda_schedule/";
        if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$date = $this->clean_value($this->input->post('date')); 
            // die;
			$presenter = $this->clean_value($this->input->post('presenter'));
			$status = $this->input->post('status');
            $byDefaultAscending = 'DefaultAscending';
            $sessionSort = $this->input->post('sessionSort');
            // $sessionSortDefault = $this->input->post('sessionSortDefault');
            $statusSort = $this->input->post('statusSort');
            $onlySessionSort = $this->input->post('onlySessionSort');
            $onlyStatusSort = $this->input->post('onlyStatusSort');

			$url = "auth/agenda_schedule/";
			
			// $date = urlencode($date);
            if ($date != '' && $date != '~') {
                $url .= "date/". $date."/";
            }

			$presenter = urlencode($presenter);
			if ($presenter != '' && $presenter != '~') {
				$url .= "presenter/". $presenter."/";
			}

			$status = urlencode($status);
			if ($status != '' && $status != '~') {
				$url .= "status/". $status."/";
			}

            if(!empty($onlySessionSort)){
                $sessionSort = urlencode($sessionSort);
                if ($sessionSort != '' && $sessionSort != '~') {
                    $url .= "sessionSort/". $sessionSort."/";
                }
            }
            else if(!empty($onlyStatusSort)){
                $statusSort = urlencode($statusSort);
                if ($statusSort != '' && $statusSort != '~') {
                    $url .= "statusSort/". $statusSort."/";
                }
            }
			redirect($url);
    	}
        
    }

    public function privacyPolicyView(){
        $this->load->view('privacy', TRUE);
    }

    public function termsConditionView(){
        $this->load->view('termsCondition', TRUE);
    }


}
