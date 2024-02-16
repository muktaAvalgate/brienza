<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinator extends Application_Controller {

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
	private $tablename = 'users';
	private $url = '/app/coordinator';
	private $permissionValues = array(
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
				'sessions'			        => 'App.Coordinators.Sessions',					
			);
																																																																																																																																																																																																																																																																																																							
	private $role 		= 5; // Coordinator Role ID
	private $role_token = 'coordinator';		
	private $baa_co_id 	= 129; // BAA Coordinator ID

	//protected $data = array();
	
	public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
		$this->load->model('../../Admin/models/Admin_model');
        $this->load->model('App_model');
    }

	public function index() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		$default_uri = array('status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

    	// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = $this->role_token;
		$filter['baa_co_id'] = $this->baa_co_id;

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_users_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/coordinator/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');

    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Coordinator Management';

    	$data['main_content'] = 'coordinators/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	/**
	 * Following method will 
	 * list down the coordinators
	 * associated with schools
	 */
	public function list_coordinators()
	{
		$school_id = $this->session->userdata('id');

		$default_uri = array('status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

    	// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = $this->role_token;

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }

	    // Get the total rows without limit
	    $total_rows = $this->App_model->get_coordinator_list($filter, $school_id, 'id', 'asc', true);

	    $config = $this->init_pagination('app/coordinator/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 9, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['list'] 		= $this->App_model->get_coordinator_list($filter, $school_id, 'id', 'asc');
		$data['school_id']	= $school_id;
    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Coordinator Permission';

    	$data['main_content'] = 'coordinators/list_coordinators';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


	/**
	 * Method to add or revoke 
	 * permissions for coordinators
	 * for placing orders
	 */
	public function permission_manage($flag, $coordinator_id, $school_id)
	{
		if($flag == 'add'){
			$data_update['has_order_permission'] = 1;
			$data_update['notify_status'] = 'no';
		}else{
			$data_update['has_order_permission'] = 0;
			$data_update['notify_status'] = 'yes';
		}
			
		$data_update['coordinator_id'] 	= $coordinator_id;
		$data_update['school_id'] 		= $school_id;
		
		$update_permission = $this->App_model->assign_permission($data_update);

		if($update_permission)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator permission has been modified.');			
		}
		else
		{
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Coordinator already exists.');
		}

		$url = '/app/coordinator/list_coordinators';
		redirect($url);
	}

	/**
	 * Method to add order 
	 * by a coordinator to the 
	 * system. 
	 * Date: 11-06-2019
	 */
	public function order_add()
	{
		if($this->session->userdata('role') == 'coordinator'){
			$co_id = $this->session->userdata('id');
		}
		else
		{
			$co_id = $this->input->get('id');
		}

		if($this->session->userdata('role') == 'school_admin')
		{
			$data['schools'] = $this->App_model->get_user_meta($this->session->userdata('id'));
			$presenters = $this->Admin_model->get_school_presenter(array('school_id'=> $this->session->userdata('id')), 'first_name', 'asc');
			$data['presenters'] = json_decode(json_encode($presenters), true);

			// Get assing school titles
			$titles = $this->App_model->get_school_titles($this->session->userdata('id'));
			$data['titles'] = array();
			foreach ($titles as $key => $val) {
			 	$data['titles'][] = (object) array('id' => $key, 'name' => $val);
			 } 
		}
		else
		{
			$data['schools'] = $this->App_model->get_mappedschool_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'), $co_id);
			$data['presenters'] = $this->Admin_model->get_presenter_list(array('deleted'=>0, 'status'=>'active', 'coordinator_id'=>$co_id), 'first_name', 'asc');
			$data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		}

		// echo $this->db->last_query();
		// echo "<pre>";print_r($data);exit;

		$this->load->model('../../Admin/models/Admin_model');
		$filter['coordinator_id']=$this->input->get('id');
		// $data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));	
			

		$data['page'] 		= 'orders'; 
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'coordinators/order_add';
    	$this->load->view(TEMPLATE_PATH, $data);		
	}
	## -------- End of the code --------- ##

	/**
	* Method to delete temp oders
	* by delete buttons 
	* Created on: 20-06-2019 
	* Created by: Soumya
	**/	
	public function delete_temp_order($id = null)
	{
		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_temp_order_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/coordinator/order');
    	}

		$data_to_store = array(
		   'is_deleted' => 1
	   	);

	   	if ($this->App_model->update('orders_temp', 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Order has been successfully cancelled.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/coordinator/order');		
	}
	## --------- End of the code --------- ##


	/**
	* Following method will be used 
	* for run a cron job to push temp order
	* data to temp table 
	**/
	public function cron_moveorder_to_master()
	{
		$current_date	 	= date("Y-m-d");
		$filter['expire']	= $current_date; 
		$filter['deleted']	= 0;
		$get_temp_orders 	= $this->App_model->get_order_list_coordinator($filter, 'created_on', 'desc');
		if(!empty($get_temp_orders)){
			foreach($get_temp_orders as $order_values)
			{
				$data_create['order_no'] 		= $order_values->order_no;
				$data_create['school_id'] 		= $order_values->school_id;
				$data_create['presenter_id'] 	= $order_values->presenter_id;
				$data_create['coordinator_id'] 	= $order_values->coordinator_id;
				$data_create['booking_date'] 	= $order_values->booking_date;
				$data_create['title_id'] 		= $order_values->title_id;
				$data_create['hours'] 			= $order_values->hours;
				$data_create['created_by'] 		= $order_values->coordinator_id;
				$data_create['co_rate_type'] 		= $order_values->co_rate_type;
				$data_create['co_rate'] 		= $order_values->co_rate;

				$data_populate = $this->App_model->insert('orders', $data_create);

				if(!empty($data_populate))
				{
					$data_update['is_deleted'] 	= 1;
					$data_update_ret 			= $this->App_model->update('orders_temp', 'id', $order_values->id, $data_update);
				}
			}

			echo 'success';
		}else{
			echo "No record found";
		}
	}

    /**
     * Clean up by removing unwanted characters
     *
     * @param unknown_type $str
     */
    private function clean_value($str) {

		$str = str_replace('/', '~', $str);
		return preg_replace('/[^A-Za-z0-9_\-~]/', '', $str);
    }

	private function format_date($date) {
	   if ($date == "")
	   	return "";

	   $newdate = date_create($date);
	   return date_format($newdate,"Y-m-d");
	}    	

	/**
	* Method for placeing of order
	* Extended from Order controller
	* Added On: 19-06-2019
	* Added By: Soumya
	**/
	public function place_order() 
	{
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour 			= $this->clean_value($this->input->post('hour'));
			$booking_date 	= date("Y-m-d");
			$title_id 		= $this->clean_value($this->input->post('title_id'));
			$presenter_id 	= $this->clean_value($this->input->post('presenter_id'));

			// Check the title exists
			//$school_id = $this->session->userdata('id');
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}
			$school_titles = $this->App_model->get_school_titles($school_id);

			## Modified on 24-06-2019
			if($this->session->userdata('role') == 'coordinator'){
				$coordinator_id	= $this->session->userdata('id');
			}else{
				$coordinator_id	= $this->input->post('coordinator_id');
			}
			$has_order_permission 	= $this->App_model->has_coordinator_permission($coordinator_id, $school_id);

			if(empty($has_order_permission))
			{
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "You don't have permission to create order for this school.")));
				return;				
			}
			## End of the modification 

			$school_titles_ids = array_keys($school_titles);

			if (!in_array($title_id, $school_titles_ids)) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Please assign title before choosing it.")));
				return;
			}
			
			// Get the topics for chossen title
			$topics = array();
			//$topics = $this->App_model->get_title_topics($title_id);
			//topic data with description
            $topics = $this->App_model->get_title_topic_data($title_id);
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('success' => true, 'topics' => $topics, 'hour' => $hour, 'booking_date' => $booking_date, 'title_id' => $title_id, 'school_id' => $school_id, 'presenter_id' => $presenter_id, 'coordinator_id' => $coordinator_id,'msg' => "")));
			return;
		}
	}
	## ---------- End of the code -------------- ##

	/**
	Method for get confirmation of order
	Extended from Order controller
	Added On: 19-06-2019
	Added By: Soumya	
	**/
	public function place_order_confirm() 
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour 			= $this->clean_value($this->input->post('hour'));
			$booking_date 	= $this->input->post('booking_date');
			$title_id 		= $this->clean_value($this->input->post('title_id'));
			$presenter_id 	= $this->clean_value($this->input->post('presenter_id'));
			$topics 		= $this->input->post('topics[]');
			
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}

			$new_time = date("Y-m-d H:i:s", strtotime('+24 hours'));
			
			// Get presenter rate
			/*
			$data = array(
					'order_no' 		=> "WQ".date("ymd").rand(100, 999),
					'school_id' 	=> $school_id,
					'coordinator_id'=> $this->session->userdata('id'),
					'title_id' 		=> $title_id,
					'presenter_id' 	=> $presenter_id,
					'hours' 		=> $hour,
					'booking_date' 	=> $this->format_date($booking_date),
					'created_on' 	=> date('Y-m-d H:i:s'),
					'created_by' 	=> $this->session->userdata('id'),
					'expired_on'	=> $new_time			
				);
			*/

			$this->load->model('../../Admin/models/Admin_model');
			$school_mail_id=$this->Admin_model->get_mail($school_id);
			$school_mail=$school_mail_id->email;
			if($this->session->userdata('role') == 'coordinator')
				$coordinator_id = $this->session->userdata('id');
			else
				$coordinator_id = $this->input->post('coordinator_id');	

			$coordinatorData = array();
			$coordinator_name = '--';
			if($coordinator_id != ''){
				$coordinatorData = $this->Admin_model->get_user_details($coordinator_id);
				if(!empty($coordinatorData)){
					$coordinator_name = $coordinatorData->first_name." ".$coordinatorData->last_name;
				}
			}

			$presenter = $this->Admin_model->get_user_details($presenter_id);
			$presenter_name = '--';
			if(!empty($presenter)){
				$presenter_name = $presenter->first_name." ".$presenter->last_name;
			}
			// Get school meta data
			$schoolData = $this->Admin_model->get_user_meta($school_id);

			// Get title Name from database
			$titleName = $this->Admin_model->get_title_name($title_id);

			$data = array(
					'order_no' 		=> '',
					'school_id' 	=> $school_id,
					'coordinator_id'=> $coordinator_id,
					'title_id' 		=> $title_id,
					'presenter_id' 	=> $presenter_id,
					'hours' 		=> $hour,
					'booking_date' 	=> $this->format_date($booking_date),
					'created_on' 	=> date('Y-m-d H:i:s'),
					'created_by' 	=> $this->session->userdata('id'),
					'expired_on'	=> $new_time			
				);	
			if(!empty($coordinatorData)){
				$data['co_rate_type'] = $coordinatorData->meta['rate_type'];
				$data['co_rate'] = $coordinatorData->meta['rate'];

			}	
			
			if ($order_id = $this->Admin_model->insert('orders_temp', $data)) {
				// Insert the Order Topics
				if (!empty($topics)) {
					$this->App_model->insert_order_topics($order_id, $topics);
				}
				
                // ======== Start Code By Ahmed on 2019-09-21 ======= //
                // Send notification on Site admin
                $msg = "<p><b>School Name:</b> ".$schoolData['school_name']."<br/><b>Coordinator Name:</b> ".$coordinator_name."<br/><b>Presenter Name:</b> ".$presenter_name."<br/><b>Title:</b> ".$titleName."<br/><b>Booking Date:</b> ".$data['booking_date']."<br/><b>Status:</b> pending </p>";

                $this->load->library('mail_template');
				if($this->session->userdata('role') == 'coordinator')
                {
	                $role='coordinator';
	                $this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, $role, 'Coordinator Order');
	                $this->mail_template->notification_email_to_school(null, $school_mail, $msg, $role, 'Coordinator Order');
                }
                if($this->session->userdata('role') == 'administrator')
                {		
                	$role='administrator';
                	$this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, $role, 'Coordinator Order');
               		$this->mail_template->notification_email_to_school(null, $school_mail, $msg, $role , 'Coordinator Order');
                 }
                // ======== End of the Code 2019-09-21 ====== //

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => true, 'coordinator_id' => $coordinator_id, 'msg' => "Order successfully placed. Please note that orders are only processed Monday through Friday, from 10am to 4pm. Approval takes up to 5 to 10 days depending on the amount requested.")));
				return;
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Error placing order. Please try again.")));
				return;
			}
		}
	}
	## ---------- End of the code -------------- ##



    /**
     *
     */
    public function add() {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
     		//form validation
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|callback_check_email|valid_email');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('meta[phone]', 'Phone', 'trim|required|numeric|min_length[10]');
			$this->form_validation->set_rules('meta[rate]', 'Rate', 'trim|required|numeric');
			

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'first_name' 	=> htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
					'last_name' 	=> htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
					'role_id' 		=> $this->role,
    				'email' 		=> htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
    				'status' 		=> htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' 	=> $this->session->userdata('id'),
     				'created_on' 	=> date('Y-m-d H:i:s')
    			);

				$meta = $this->input->post('meta');

    			//if the insert has returned true then we show the flash message
				if ($user_id = $this->Admin_model->insert($this->tablename, $data)) 
				{
					// Insert the Mata Data
					$this->Admin_model->replace_user_meta($user_id, $meta);

					// Send Email to users
					$this->load->library('mail_template');
    				$this->mail_template->register_coordinator_email($data['first_name'], $data['email'], $user_id);

                    // ======== Start Code By Ahmed on 2019-09-21 ======= //
                    // Send notification on Site admin
                    $rate1 = ($meta['rate_type'] == 'percentage') ? $meta['rate']."%" : "$".number_format($meta['rate'], 2);
                    $msg = "<p><b>First Name:</b> ".$data['first_name']."<br/><b>Last Name:</b> ".$data['last_name']."<br/><b>Email:</b> ".$data['email']."<br/><b>Contact No.:</b> ".$meta['phone']."<br/><b>Rate Type:</b> ".$meta['rate_type']."<br/><b>Rate:</b> ".$rate1."</p>";

                    $this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, 'Coordinator');
                    // ======== End of the Code 2019-09-21 ====== //

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator has been added successfully.');
				} 
				else 
				{
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Coordinator already exists.');
    			}
    			redirect('/app/coordinator');
    		} //validation run
    	}
		
    	$data['page'] = 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Coordinator Management &raquo; Add Coordinator';

    	$data['main_content'] = 'coordinators/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	/**
	 *
	 * @param unknown_type $id
	 */
	public function edit($id = 0) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	//add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');


     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('meta[phone]', 'Phone', 'trim|required|numeric|min_length[10]');
			$this->form_validation->set_rules('meta[rate]', 'Rate', 'trim|required|numeric');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$data = array(
					'first_name' 	=> htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
					'last_name' 	=> htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
					'role_id' 		=> $this->role,
    				'status' 		=> htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
     				'updated_by' 	=> $this->session->userdata('id'),
     				'updated_on' 	=> date('Y-m-d H:i:s')
    			);

				$meta = $this->input->post('meta');				

     			//if the insert has returned true then we show the flash message
     			if ($this->Admin_model->update($this->tablename, 'id', $id, $data)) {

					// Insert the Mata Data
    				$this->Admin_model->replace_user_meta($id, $meta);

     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect('/app/coordinator');
     		} //validation run
     	}

     	$data['teacher']  = $this->Admin_model->get_user_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['teacher'])) {
     		redirect('/app/coordinator');
     	}

     	$data['page'] = 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Coordinator Management &raquo; Edit Presenter';

    	$data['main_content'] = 'coordinators/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     */
    public function update_status($order_page='') {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'User', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count = 0;
    			$items = $this->input->post('item_id');
    			$operation = $this->input->post('operation');
    			$coordinator_id = $this->input->get('id');

	    		$data_to_store = array(
		    		'status' => ($operation == "active")?'active':'inactive'
		    	);

    			foreach ($items as $id=>$value) {

					if ($operation == 'delete') {

						$data_to_store = array(
				    		'is_deleted' => 1
				    	);
    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "active")?'active':'inactive'
				    	);
    				}
    				if($order_page=='co_order')
    				{
    					if ($this->App_model->update('orders', 'id', $id, $data_to_store)) {
							$count++;
						}
    				}else{
						if ($this->App_model->update('users', 'id', $id, $data_to_store)) {
							$count++;
						}
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Coordinator(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		if(isset($coordinator_id) && $coordinator_id != ''){
				redirect('/app/coordinator/main_orders/?id='.$coordinator_id);
    		}else{
    			redirect('/app/coordinator');
    		}
    	}
    }

    /**
	Following method has been used to delete
	or update the status for temp orders
	Created on: 20-06-2019
	Created by: Soumya
    **/
	public function update_status_temporder()
	{
		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'User', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count 		= 0;
    			$items 		= $this->input->post('item_id');
    			$operation 	= $this->input->post('operation');


	    		$data_to_store = array(
		    		'status' => ($operation == "active")?'active':'inactive'
		    	);

    			foreach ($items as $id=>$value) {

					if ($operation == 'delete') {

						$data_to_store = array(
				    		'is_deleted' => 1
				    	);
    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "active")?'1':'0'
				    	);
    				}

					if ($this->App_model->update('orders_temp', 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Order(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/coordinator/order');
    	}
	}

    ## --------- End of the code ---------- ##

	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->Admin_model->get_user_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/coordinator');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->Admin_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/coordinator');
    }


	/**
	 *
	 */
	function reset_pass($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		$data['info'] = $this->Admin_model->get_user_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/presenters');
    	}

		$password = $this->random_string();
		$user['password'] = md5($password);

		//if the insert has returned true then we show the flash message
		if ($this->Admin_model->update($this->tablename, 'id', $id, $user)) {

			$name = $data['info']->first_name . " " . $data['info']->last_name;
			$email = $data['info']->email;

			// Send Email to users
			$this->load->library('mail_template');
			$this->mail_template->new_password_email($name, $email, $password);

			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Password successfully updated and emailed to user.');
		} else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/presenters');
	}

	public function check_email($email) {

    	if($this->Admin_model->validate_data($this->tablename, 'email', $email)) {
        	$this->form_validation->set_message('check_email', 'Email address already exists.');
    		return FALSE;
    	} else {
     		return TRUE;
     	}
	}
	
    /**
     *
     * @param unknown_type $uri
     * @param unknown_type $total_rows
     * @param unknown_type $segment
     */
    private function init_pagination($uri, $segment=4, $total_rows) {

    	$this->config->load('pagination');
    	$this->load->library('pagination');

    	$config = $this->config->item('pagination');

       	$ci                          =& get_instance();
       	$config['uri_segment']       = $segment;
       	$config['base_url']          = base_url().$uri;
       	$config['total_rows']        = $total_rows;
       	$config['reuse_query_string'] = true;
       	
       	$ci->pagination->initialize($config);
       	return $config;
   	}

	/**
	 * @param int $limit
	 */
   	private function random_string($limit = 10) {

	    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789!@#$%^&*()'); // and any other characters
	    shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, $limit) as $k) $rand .= $seed[$k];

		return $rand;
	}
	
	/**
	 * Order controller
	 * has been modified so that
	 * coordinator can create orders for school and 
	 * view the list ...
	 */
	public function order($coordinator = '') {
		
		$filter 		= array('deleted' => 0);
		$default_uri 	= array('page', 'status', 'school', 'order_start_date', 'order_end_date', 'order_no');
    	$uri 			= $this->uri->uri_to_assoc(5, $default_uri);
		$pegination_uri = array();

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
		
		if($coordinator != '')
			$filter['coordinator'] = $coordinator;

		if ($this->session->userdata('role') == 'coordinator') {
			$filter['coordinator'] = $this->session->userdata('id');
		}

		if ($this->session->userdata('role') == 'school_admin') {
			$filter['school'] = $this->session->userdata('id');
		}	

    	// Get the total rows without limit
	   	$total_rows = $this->App_model->get_order_list_coordinator($filter, null, null, true);
	    $config 	= $this->init_pagination('app/coordinator/order/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 15, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the order List
	    $data['orders'] = $this->App_model->get_order_list_coordinator($filter, 'created_on', 'desc');
		$data['filter'] = $filter;
	
		$this->load->model('../../Admin/models/Admin_model');
		//$data['schools'] 	= $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		if ($this->session->userdata('role') == 'coordinator') {
            $coordinator_id = $this->session->userdata('id');
            $data['schools']    = $this->App_model->get_mappedschool_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'),$coordinator_id);
        }else{
            $data['schools']    = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
        }
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));

	    $data['page'] 		= 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'coordinators/order_list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	## ---------- End of the controller ----------- ##


	/**
	Following method will show the 
	main order list related to the 
	coordinator 
	Created on: 27-06-2019
	**/
	public function main_orders()
	{
		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
		add_js('assets/js/plugins/colResizable-1.6.min.js');

		$filter = array('deleted' => 0);
		$default_uri = array('page', 'status', 'school', 'presenter', 'order_start_date', 'order_end_date', 'order_no');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);
		$pegination_uri = array();

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
		
		if ($this->session->userdata('role') == 'coordinator') {
			$filter['coordinator'] = $this->session->userdata('id');
		}
		else {
			if($this->input->get('id') == ''){
 				$this->session->set_flashdata('message_type', 'danger');
 				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
 				redirect('app/coordinator');
			}
			$filter['coordinator'] = $this->input->get('id');
		}		
		
		// echo "<pre>";print_r($filter);exit;

    	// Get the total rows without limit
	   	$total_rows = $this->App_model->get_order_list($filter, null, null, true);
	    $config = $this->init_pagination('app/coordinator/main_orders/'.$this->uri->assoc_to_uri($pegination_uri).'/page/', 17, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the order List
	    $data['orders'] = $this->App_model->get_order_list($filter, 'created_on', 'desc');

    	//print "<pre>"; print_r($data);print "</pre>";
		$data['filter'] = $filter;
	
		$this->load->model('../../Admin/models/Admin_model');
		//$data['schools'] = $this->App_model->get_school_list(array('deleted'=>0));
		//$data['teachers'] = $this->App_model->get_teacher_list(array('deleted'=>0));

		$data['schools'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		//$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));
		if ($this->session->userdata('role') == 'coordinator') {
            $data['presenters'] = $this->Admin_model->get_coordinator_presenter_list_unique($this->session->userdata('id'));
        }else{
            $data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));
        }
		
		$data['co_id']=$this->input->get('id');
	    $data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/list';
    	$this->load->view(TEMPLATE_PATH, $data);		
	}


	## -------------- End of the code ------------- ##

	/**
	 * Following methods will be used
	 * to assign providers and 
	 * schools for a coordinator and 
	 * manage them ....
	 */

	## assigned presenters list method  
	public function assign_presenter_school_list($id)
	{
		$default_uri = array('status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

    	// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = $this->role_token;

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
		}
		
		$filter['coordinator_id'] = $id;

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_presenter_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/coordinator/assign_presenter_school_list/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 9, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;		
		
		// Get the Users List
		$data['list'] 			= $this->Admin_model->get_presenter_list($filter, 'id', 'asc');
		$data['teacher']  		= $this->Admin_model->get_user_details($id);
		$data['coordinator_id'] = $id;

    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Assign presenter and school list';

    	$data['main_content'] = 'coordinators/presenter_school_list';
    	$this->load->view(TEMPLATE_PATH, $data);

	}

	## assigned presenters method  
	public function assign_presenter_school($id)
	{
		$data['presenters'] 		= $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));
		$data['schools'] 			= $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		
     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
			$this->form_validation->set_rules('presenter_id', 'Presenter', 'required');
			$this->form_validation->set_rules('school_id[]', 'Schools', 'required');
			$this->form_validation->set_rules('from_date', 'From Date', 'required');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$data = array(
					'coordinator_id' 	=> $this->input->post('coordinator_id'),
					'presenter_id' 		=> $this->input->post('presenter_id'),
					'school_ids' 		=> implode(",", $this->input->post('school_id')),
    				'from_date' 		=> date("Y-m-d", strtotime($this->input->post('from_date')))
    			);

     			//if the insert has returned true then we show the flash message
     			if ($this->Admin_model->insert('coordinator_presentator_school', $data)) {

     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenters assigned successfully.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect('/app/coordinator/assign_presenter_school_list/'.$id);
     		} //validation run
     	}		

     	// echo "<pre>";print_r($data);exit;
		$data['page'] 				= 'coordinator';
		$data['coordinator_id'] 	= $id;
    	$data['page_title'] 		= SITE_NAME.' :: Preseneter Assignment';
		$data['main_content'] 		= 'coordinators/assign_presenter';
		
    	$this->load->view(TEMPLATE_PATH, $data);		


	}	

	## Delete presenter from coordinator method
	public function delete_assigned_presenter($id = NULL)
	{
		$id 					= $this->input->post('pId');
		$coordinator_id			= $this->input->post('coordinator_id');

		$data['effective_date'] = date("Y-m-d", strtotime($this->input->post('effective_date')));
		$data['is_deleted'] 	= 1;

		if ($this->Admin_model->update('coordinator_presentator_school', 'id', $id, $data)) {
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Assigned presenter deleted successfully.');
		} 
		else {
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
		}

		redirect('/app/coordinator/assign_presenter_school_list/'.$coordinator_id);		
	}
	//--------- End of the section -----------//


	/**
	* Following methods will deal
	* with invoice generation and 
	* view invoice part
	* Created on:01-07-2019
	* Created by: Soumya  
	**/
	## Method to generate invoice (it will run as cron job)
	public function generate_invoice($order_id)
	{
		$update_invoice = $this->App_model->generate_invoice_coordinator($order_id);

		if($update_invoice)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Invoice has been generated successfully.');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
		}

		redirect('/app/coordinator/main_orders');
	}

	## Method to list invoices 
	public function coordinator_invoice_list()
	{
		$default_uri = array('status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
		}

    	// Create the filters
	    $filter = array();

		if($this->session->userdata('role') == 'coordinator'){
			$filter['coordinator'] = $this->session->userdata('id');
		}

	    // Get the total rows without limit
	    $total_rows = $this->App_model->get_billing_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/coordinator/assign_presenter_school_list/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 9, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] 	= $config['per_page'];
	    $filter['offset'] 	= $limit_end;		
		
		// Get the Users List
		$data['list'] 			= $this->App_model->get_billing_list($filter, 'id', 'asc');

    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Invoice list';

    	$data['main_content'] = 'coordinators/billing_list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	## Method to show PDF view
	public function view_invoice_coordinator($billing_id)
	{
		// Generate Invoice
		$billing			= $this->App_model->get_billing_master($billing_id);
		$billing_details 	= $this->App_model->get_billing_details($billing_id);
		
		$coordinator_det	= $this->App_model->get_paymentinfo_co($billing->coordinator_id); 

		// echo "<pre>";print_r($billing);print_r($billing_details);print_r($coordinator_det);exit;

		$invoice = '<table width="100%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
			<tr>
				<td colspan="3"><img src="'. base_url("assets/images/logo.png").'"></td>
				<td colspan="2" align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
			</tr>
			<tr>
				<td style="height:40px;" colspan="5"><strong>CO INVOICE:</strong></td>
			</tr>
			<tr>
				<td align="left" colspan="3"><strong>Invoice No#:</strong> '. $billing->billing_no.'</td>
				<td align="left" colspan="2"><strong>Invoice Date:</strong> '. date('m/d/Y', strtotime($billing->invoice_generated_on)).'</td>
			</tr>
			<tr>
				<td colspan="3"><strong>Coordinator :</strong> '. ucwords($billing->coordinator_name).'</td>
				<td colspan="2"><strong>Phone number:</strong> '.$billing->co_phone.'</td>
			</tr>
			<tr>
				<td align="left" colspan="5"><strong>School:</strong> '. ucwords($billing->school_name).'</td>
			</tr>
			<tr>
				<td colspan="5" align="right"></td>
			</tr>
			<tr>
				<th>Presenters</th>
				<th>Rate</th>
				<th>Total Hours</th>
				<th>Co Rate</th>
				<th>Co Payable</th>
			</tr>';

			foreach ($billing_details as $schedule) 
			{
				$invoice .= '<tr>
					<td align="center">'.ucwords($schedule->presenter_name).'</td>
					<td align="center">$'.$schedule->presenter_rate.'</td>
					<td align="center">'.$schedule->presenter_allocated_hour.'</td>';
				
				if($coordinator_det['rate_type'] == 'fixed')		
					$co_rate = 	'$'.$coordinator_det['rate'];
				else
					$co_rate = 	$coordinator_det['rate'].'%';
			
				$invoice .= '<td align="center">'.$co_rate.'</td>
					<td align="center">$'.number_format($schedule->coordicator_amount,2).'</td>
				</tr>';
			}
			
			$invoice .= '<tr>
				<td align="left"></td>
				<td colspan="2" align="right"><strong>Total Hours:</strong> '. $billing->total_hours_allocated.'</td>
				<td align="right"><strong>Total:</strong> $'. number_format($billing->amount_payable,2).'</td>
			</tr>
			<tr>
				<td align="right">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">&nbsp;</td>
			</tr>
		</table>';

		//load mPDF library
		$this->load->library('m_pdf');

		//this the the PDF filename that user will get to download
		$data['attachment'] = "coordinator_invoice_".date('YmdHis').".pdf";		
		$this->m_pdf->pdf->SetTitle('Coordinator Invoice');	
		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($invoice);
		
		//download it.
		$this->m_pdf->pdf->Output($data['attachment'], "I"); 

		$data['content'] = $content;
	}

	## Method to pay to codeigniter 
	public function pay_to_coordinator($billing_id)
	{
		$get_update = $this->App_model->pay_to_coordinator_model($billing_id);

		if($get_update)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Invoice get paid successfully.');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
		}

		redirect('/app/coordinator/coordinator_invoice_list');
	}

	## ------- End of the code segment -------- ##

	/**
	 * Following method will
	 * show the presenter list
	 * mapped with the coordinator
	 */
	public function list_presenters()
	{
		$default_uri = array('status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
		}

    	// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = $this->role_token;
		$filter['baa_co_id'] = $this->baa_co_id;

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
		}
		
		$id = $this->session->userdata('id');
		$filter['coordinator_id'] = $id;

	    // Get the total rows without limit
	    if($this->baa_co_id == $id){
	    	$total_rows = $this->Admin_model->get_presenter_list_for_coordinator($filter, 'id', 'asc', true);
	    }else{
	    	$total_rows = $this->Admin_model->get_presenter_list($filter, 'id', 'asc', true);
	    }

	    $config = $this->init_pagination('app/coordinator/list_presenters/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;		
		
		// Get the Users List
		if($this->baa_co_id == $id){
	    	$data['list'] = $this->Admin_model->get_presenter_list_for_coordinator($filter, 'id', 'asc');
	    	// $data['list'] = json_decode(json_encode($list), true);
	    }else{
			$data['list'] = $this->Admin_model->get_presenter_list($filter, 'id', 'asc');
		}

		$data['teacher']  		= $this->Admin_model->get_user_details($id);
		$data['coordinator_id'] = $id;

    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'coordinator';
    	$data['page_title'] = SITE_NAME.' :: Assign presenter list';

    	$data['main_content'] = 'coordinators/presenter_list';
    	$this->load->view(TEMPLATE_PATH, $data);	
	}


	public function view($id)
	{
		//echo $id;die;
     	$data['presenter_details'] 	= $this->Admin_model->get_assigned_presenter_details($id);
	
        $data['main_content'] = 'coordinators/view';
    	$output_string = $this->load->view('coordinators/view', $data, TRUE);
    	//$output_string='<table><tr><td>jhbjhbjh</td></tr></table>';
    	echo $output_string;				
		
	}

	//////// presenter list for particuler coordinator/////

	public function presenter_view($id)
	{
		$data['presenter_list'] 	= $this->Admin_model->get_coordinator_presenter_list($id);
		//echo "<pre>";print_r($data['presenter_list']);die;
	
        $data['main_content'] = 'coordinators/presenter_view';
    	$output_string = $this->load->view('coordinators/presenter_view', $data, TRUE);
    	//$output_string='<table><tr><td>jhbjhbjh</td></tr></table>';
    	echo $output_string;	
	}


	/////////
	
	
	public function scheduling() 
	{
		
		$school_id = $this->input->get('school_id');
		$order_id = $this->input->get('order_id');
		$topic_id = $this->input->get('topic_id');


		if ($order_id) {
			// Get the types
			$data['types'] = $this->App_model->get_worktype_list(array('deleted'=>0, 'status'=>'active'));
			
			// Get order details
			$data['order'] = $this->App_model->get_order_details($order_id);
			
			// Get the Topics
			$data['topics'] = $this->App_model->get_title_topics($data['order']->title_id);
			
			$data['selected_order'] = $order_id;
			
			// Get the existing schedule
			$data['schedules'] = $this->App_model->get_order_schedule($order_id);

			$remaining_schedule_hrs = $data['order']->hours - $data['order']->total_hours_scheduled;


			// echo "<pre>";print_r($data);exit;
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{

			$this->form_validation->set_rules('date', 'Date', 'trim|required');
	    	$this->form_validation->set_rules('start_time', 'Start time', 'trim|required');
			$this->form_validation->set_rules('end_time', 'End time', 'trim|required');
			$this->form_validation->set_rules('topics', 'Topic', 'trim|required|numeric');
			$this->form_validation->set_rules('types', 'Type', 'trim|required|numeric');
			$this->form_validation->set_rules('grades', 'Grade', 'trim|required|numeric');
			$this->form_validation->set_rules('teachers', 'Teacher', 'trim|required');
			$this->form_validation->set_rules('total_hours', 'Total hours', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		// if the form has passed through the validation
     		if ($this->form_validation->run())
     		{

				if ($remaining_schedule_hrs <  $this->input->post('total_hours')) {
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is not greater than remaining hours.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
				}

				$date = htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
				$start_time = htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
				$end_time = htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
				
				$start_ts = new DateTime($date." ".$start_time);
				$start_date = $start_ts->format('Y-m-d H:i:s');

				$end_ts = new DateTime($date." ".$end_time);
				$end_date = $end_ts->format('Y-m-d H:i:s');




				$checkSchedule = $this->App_model->check_schedule_datetime($this->session->userdata('id'), $start_date, $end_date);
		
 				if(!empty($checkSchedule)){
					
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is already booked.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
 				}

     			$data = array(
					'order_id' => $order_id,
					'start_date' => $start_date,
    				'end_date' => $end_date,
					'topic_id' => $this->input->post('topics'),
					'type_id' => $this->input->post('types'),
					'grade_id' => $this->input->post('grades'),
					'teacher' => htmlspecialchars($this->input->post('teachers'), ENT_QUOTES, 'utf-8'),
					'total_hours' => htmlspecialchars($this->input->post('total_hours'), ENT_QUOTES, 'utf-8'),
     				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);
				
				if ($schedule_id = $this->App_model->insert('order_schedules', $data)) {
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule have been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
    			}
    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
				//print "<pre>"; print_r($data); print "</pre>"; die;
			}
		}
		
				
		// Get the School List
	    // $data['schools'] = $this->Admin_model->get_users_list(array('deleted' => 0, 'status' => 'active', 'role_token' => 'school_admin'), 'id', 'asc');
	    $data['schools'] = $this->App_model->get_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));


		if ($school_id) {
			// Get the Orders for drop-down
			$data['purchase_orders'] = $this->App_model->get_order_list(array('deleted' => 0, 'school' => $school_id, 'presenter' =>  $this->session->userdata('id'), 'status' => 'approved'), 'created_on', 'desc');
			
			// Get the Grade list
			$data['grades'] = $this->App_model->get_teacher_list(array('deleted' => 0, 'school_id' => $school_id, 'status' => 'active'), 'created_on', 'desc');
			$data['selected_school'] = $school_id;
		}
		
		
		if ($topic_id) {
			$data['selected_topic'] = $topic_id;
		}
				
		//print "<pre>"; print_r($data); print "</pre>";		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Scheduling';
		
    	$data['main_content'] = 'presenters/scheduling';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	
	public function show_calendar() {
		
		$order_id = $this->input->get('order_id');
		
		if ($order_id) {
			
			// Get order details
			$order = $this->App_model->get_order_details($order_id);
			
			// Get School Details
			$school = $this->Admin_model->get_user_details($order->school_id);
			
			// Get Holiday Schedule details
			$holidays = array();
			if (isset($school->meta['holiday_schedule_id']) && $school->meta['holiday_schedule_id'] > 0) {
				$holidays = $this->App_model->get_schedule_details($school->meta['holiday_schedule_id']);
			}
			
			$data['holidays'] = array();
			if (!empty($holidays)) {
				$data['holidays']['workingdays'] = array_keys($holidays->workingdays);
				$data['holidays']['vacation'] = $holidays->holiday_details;
			}
			
		}
		
		// print "<pre>"; print_r($holidays); print "</pre>";exit;
		
		$prefs = array(
			'start_day'    			=> 'sunday',
			'show_next_prev'  		=> TRUE,
			'next_prev_url'   		=> base_url('app/presenters/show_calendar'),
			'next_prev_url_qrstr'   => 'order_id='.$order_id,
			'day_type'				=> 'short',				
			'template' 		  		=> array(
				'table_open'           	=> '<table class="calendar-container" border="1" cellpadding="2" cellspacing="2" width="100%">',
				'heading_previous_cell'	=> '<th class="text-center"><a href="#" onclick="loadCalendar(\'{previous_url}\');">&lt;&lt;</a></th>',
				'heading_title_cell'	=> '<th class="text-center" colspan="{colspan}">{heading}</th>',
				'heading_next_cell'		=> '<th class="text-center"><a href="#"  onclick="loadCalendar(\'{next_url}\');">&gt;&gt;</a></th>',
				'week_day_cell'		   	=> '<th class="text-center">{week_day}</th>',
				'cal_cell_start'		=> '<td class="text-center">',
				'cal_cell_content'		=> '<td class="text-center">',
				'cal_cell_start_today'	=> '<td class="text-center">',
				'cal_cell_no_content'	=> '<a href="#" onclick="inputCalendarDate(\'{year}\',\'{month}\',\'{day}\','.$order_id.','.$order->school_id.');">{day}</a>',
			),
			'holidays'				=> $data['holidays'],
		);
		
		
		$this->load->library('my_calendar', $prefs);
		$data['calendar'] = $this->my_calendar->generate($this->uri->segment(4), $this->uri->segment(5));
		// echo "<pre>"; print_r($data);exit;
    	$this->load->view('presenters/show_calendar', $data);
	}
	
	public function calendar() {
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Calendar';
		
		// Get the existing schedule
		$schedules = $this->App_model->get_order_schedule(null, $this->session->userdata('id'));
		
		$data['schedules'] = array();
		foreach ($schedules as $key => $value) {
			$data['schedules'][$value->start_date_ymd][] = $value;
		}
		
		$prefs = array(
			'start_day'    			=> 'sunday',
			'show_next_prev'  		=> TRUE,
			'next_prev_url'   		=> base_url('app/presenters/calendar'),
			//'next_prev_url_qrstr'   => 'order_id='.$order_id,
			'day_type'				=> 'short',				
			'template' 		  		=> array(
				'table_open'           	=> '<table class="calendar-container" border="1" cellpadding="2" cellspacing="2" width="100%">',
				'heading_previous_cell'	=> '<th class="text-center"><a href="#" onclick="loadCalendar(\'{previous_url}\');">&lt;&lt;</a></th>',
				'heading_title_cell'	=> '<th class="text-center" colspan="{colspan}">{heading}</th>',
				'heading_next_cell'		=> '<th class="text-center"><a href="#"  onclick="loadCalendar(\'{next_url}\');">&gt;&gt;</a></th>',
				'week_day_cell'		   	=> '<th class="text-center">{week_day}</th>',
				'cal_cell_start'		=> '<td class="text-center">',
				'cal_cell_content'		=> '<td class="text-center">',
				'cal_cell_start_today'	=> '<td class="text-center">',
				'cal_cell_no_content'	=> '<a href="#" onclick="inputCalendarDate(\'{year}\',\'{month}\',\'{day}\');">{day}</a>',
			),
			//'holidays'				=> $data['holidays'],
			'schedules'					=> $data['schedules'],
		);
		
		//print "<pre>"; print_r($data); print "</pre>";	
		$this->load->library('my_calendar', $prefs);
		$data['calendar'] = $this->my_calendar->generate($this->uri->segment(4), $this->uri->segment(5));
		
		$data['main_content'] = 'presenters/calendar';
    	$this->load->view(TEMPLATE_PATH, $data);		
	}
	
	public function billing() {
		
		$order_id = $this->input->get('order_id');
		
		if(!$order_id) {
			redirect('/app/presenters/order/billing');
		}
		
		// Redirect to Order > Billing
		redirect('app/orders/billing/?order_id='.$order_id);
	}
	
	public function display_schedule($schedule_id){
		
		$schedule = $this->App_model->get_order_schedule_details($schedule_id);
		
		$content = '';
		$content .= "<div class='row'><div class='col-sm-4'>School: </div><div class='col-sm-8'>".$schedule->school_name."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Date: </div><div class='col-sm-8'>".date("m/d/Y", strtotime($schedule->start_date))."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Time: </div><div class='col-sm-8'>".date("h:i a", strtotime($schedule->start_date))." - ".date("h:i a", strtotime($schedule->end_date)). " (".$schedule->total_hours." hrs)"."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Order no: </div><div class='col-sm-8'>".$schedule->order_no."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Topic: </div><div class='col-sm-8'>".$schedule->topic_name."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Teacher: </div><div class='col-sm-8'>".$schedule->teacher."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Grade: </div><div class='col-sm-8'>".$schedule->grade_name."</div></div>";
		$content .= "<div class='row'><div class='col-sm-4'>Type: </div><div class='col-sm-8'>".$schedule->worktype_name."</div></div>";
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('success' => true, 'content' => $content)));
		return;
	}
	
	public function create_log() {
		$id = $this->input->get('id');
		
		if ($id) {			
			// Get the existing schedule
			$data['schedule'] = $this->App_model->get_order_schedule_details($id);	

			// Get order details
			$data['order'] = $this->App_model->get_order_details($data['schedule']->order_id);
		}
		//print "<pre>"; print_r($data); print "</pre>";
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Create Log';
		
    	//$data['main_content'] = ;
    	$this->load->view('presenters/create_log', $data);
	}
	
	public function library() {
		
		$data['libraries'] = $this->App_model->get_library_list($this->session->userdata('id'));
		
		//print "<pre>"; print_r($data); print "</pre>";		
		$data['page'] = 'library';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Library';
		
    	$data['main_content'] = 'presenters/library';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	public function upload_header(){
		$id = $this->input->post('pId');
		$header_image = $_FILES['headerImg'];

		// Upload Header Image
		if (!empty($header_image['name'])) {

			$config['upload_path'] = 'assets/header_image/';
			$config['max_size'] = '5000';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['overwrite'] = FALSE;
			$config['remove_spaces'] = TRUE;
			$config['height'] = 1374;
			$config['width'] = 135;

		    $this->load->library('upload', $config);

			$config['file_name'] = 'header-image-'.date('YmdHis');
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('headerImg')) {
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', $this->upload->display_errors());

                redirect('/app/presenters/');
			} else {
				$upload_data =  $this->upload->data();
				$data['headerImg'] = $upload_data['file_name'];
			}

			if($this->Admin_model->update($this->tablename, 'id', $id, $data)){
	            $this->session->set_flashdata('message_type', 'success');
	            $this->session->set_flashdata('message', 'Header Image successfully uploaded');
	        }else{
	        	$this->session->set_flashdata('message_type', 'danger');
	            $this->session->set_flashdata('message', 'Something want to wrong, please try again');
	        }
            redirect('/app/presenters/');
 		}
	}

	public function schedule_availability(){

		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$order_id = $this->input->post('order_id');
		$school_id = $this->input->post('school_id');
		// echo $school_id;exit;

		$scheduleData = $this->App_model->check_schedule_timeBySchool($this->session->userdata('id'), $date, $order_id, $school_id);
		$time = array();
		// $end_time = array();
		foreach ($scheduleData as $key => $val) {
			$start_time = date('h:i a',strtotime($val['start_date']));
			$end_time = date('h:i a', strtotime('+30 minutes', strtotime($val['end_date'])));
			$time[$start_time] = $end_time;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('disable_time' => $time)));
		return;
	}


	public function co_search_submit() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$order_no = $this->clean_value($this->input->post('order_no'));
    		$order_start_date = $this->clean_value($this->input->post('order_start_date'));
    		$order_end_date = $this->clean_value($this->input->post('order_end_date'));
			$school = $this->clean_value($this->input->post('school'));

			$coID = ($this->uri->segment(4) != '') ? $this->uri->segment(4) : '~';
			$url = "app/coordinator/order/".$coID.'/';

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
			
			$school = urlencode($school);
			if ($school != '' && $school != '~') {
				$url .= "school/".$school."/";
			}

			redirect($url);
    	}
    }
	

	public function search_submit() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$order_no = $this->clean_value($this->input->post('order_no'));
    		$order_start_date = $this->clean_value($this->input->post('order_start_date'));
    		$order_end_date = $this->clean_value($this->input->post('order_end_date'));
			$school = $this->clean_value($this->input->post('school'));
			$presenter = $this->clean_value($this->input->post('presenter'));
			$status = $this->clean_value($this->input->post('status'));

			$url = "app/coordinator/main_orders/";
			
			$order_no = urlencode($order_no);
            if ($order_no != '' && $order_no != '~') {
                $url .= "order_no/". $order_no."/";
            }
			
			$order_start_date = urlencode($order_start_date);
            if ($order_start_date != '' && $order_start_date != '~') {
                $url .= "order_start_date/". $order_start_date."/";
            }

			$order_end_date = urlencode($order_end_date);
			if ($order_end_date != '' && $order_end_date != '~') {
				$url .= "order_end_date/". $order_end_date."/";
			}
			
			$school = urlencode($school);
			if ($school != '' && $school != '~') {
				$url .= "school/".$school."/";
			}

			$presenter = urlencode($presenter);
			if ($presenter != '' && $presenter != '~') {
				$url .= "presenter/". $presenter."/";
			}

			$status = urlencode($status);
			if ($status != '' && $status != '~') {
				$url .= "status/". $status."/";
			}

			$url .= '?id='.$this->input->get('id');

			redirect($url);
    	}
    }
	
	public function get_assign_presenter_school(){
		$co_id = $this->input->post('co_id');
		$p_id = $this->input->post('p_id');

		$res = $this->Admin_model->get_coordinator_assign_presenter_school($co_id, $p_id);
		$assinged_presenter = array_column($res, 'id');
		$schools = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));

		// echo "<pre>";print_r($res);print_r($assinged_presenter);print_r($schools);exit;

		// array_multisort(array_column($res, 'school_name'),  SORT_ASC, $res);
		$opt = '';
		foreach ($schools as $key => $val) {
			$selected = (in_array($val->id, $assinged_presenter)) ? 'selected' : '';
			$opt .= '<option value="'.$val->id.'" '.$selected.'>'.$val->meta['school_name'].'</option>';
		}
		echo json_encode($opt);
	}

	public function get_assign_school_presenter(){
		$co_id = $this->input->post('co_id');
		$school_id = $this->input->post('school_id');

		$res = $this->Admin_model->get_coordinator_assign_school_presenter($co_id, $school_id);
		array_multisort(array_column($res, 'first_name'),  SORT_ASC, $res);
		echo json_encode($res);
	}

	public function get_assign_school_titles(){
		$school_id = $this->input->post('school_id');

		$res = $this->App_model->get_school_titles($school_id);
		$resArr = array();
		if(!empty($res)){
			foreach ($res as $key => $val) {
				$resArr[] = array('id' => $key, 'title' => $val);
			}
		}
		sort($resArr);
		echo json_encode($resArr);
	}

	public function assign_presenter_school_edit($co_id,$presenterid)
	{

		$data['presenters'] 		= $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));
		
		$data['schools'] 			= $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		
     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//echo "<pre>";print_r($_POST);die;
     		//form validation
			//$this->form_validation->set_rules('presenter_id', 'Presenter', 'required');
			$this->form_validation->set_rules('school_id[]', 'Schools', 'required');
			$this->form_validation->set_rules('from_date', 'From Date', 'required');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$data = array(
					'coordinator_id' 	=> $co_id,
					//'presenter_id' 		=> $this->input->post('presenter_id'),
					'school_ids' 		=> implode(",", $this->input->post('school_id')),
    				'from_date' 		=> date("Y-m-d", strtotime($this->input->post('from_date')))
    			);

    			
     		
     			//if the insert has returned true then we show the flash message
     			if ($this->Admin_model->update_presenter_school($co_id,$presenterid,$data)) {
     				 $this->session->set_flashdata('message_type', 'success');
	                $this->session->set_flashdata('message', 'Presenter School list is successfully updated');

     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     				
     			}

     			redirect('/app/coordinator/assign_presenter_school_list/'.$co_id);
     		} //validation run
     	}		

     	$data['presenter_list']     =$this->Admin_model->get_presenter_by_id($co_id,$presenterid);

     	//$school_ids=$data['presenter_list']->school_ids;
     	//
     	//$ids=explode(',',$school_ids);
     		
     	// foreach($ids as $user_id){
     	// 	$data['school_list']    =$this->Admin_model->get_school_by_id($user_id);
     	// }

     	//$data['schools'] 			= $this->Admin_model->get_school_by_id();

		$data['coordinatorData']  		= $this->Admin_model->get_user_details($co_id);
     	
		$data['page'] 				= 'coordinator';
		$data['coordinator_id'] 	= $co_id;
		$data['presenterid'] 	    = $presenterid;
    	$data['page_title'] 		= SITE_NAME.' :: Preseneter Assignment';
		$data['main_content'] 		= 'coordinators/presenter_school_edit';
		//echo "<pre>";print_r($data['presenter_list'] );print_r($ids);die;
    	$this->load->view(TEMPLATE_PATH, $data);	
	}

	public function sessions()
	{	
		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
		add_js('assets/js/plugins/colResizable-1.6.min.js');

		$filter = array('deleted' => 0);
		$default_uri = array('page', 'status', 'school', 'presenter', 'start_date');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);
		$pegination_uri = array();

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}
		
	
		
		if ($uri['status'] <> "" && $uri['status'] <> "~") {
            $filter['status'] = str_replace("_"," ",$uri['status']);
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
		
		if ($uri['start_date'] <> "" && $uri['start_date'] <> "~") {
            $filter['start_date'] =  str_replace('~', '/', $uri['start_date']);
			$pegination_uri['q'] = $uri['start_date'];
        } else {
			$filter['start_date'] = "";
			$pegination_uri['start_date'] = "~";
		}
		
		
		//echo "<pre>";print_r($filter);die;
		
    	// Get the total rows without limit
	   	$total_rows = $this->Admin_model->get_all_sessions($filter, null, null, true);
	    $config = $this->init_pagination('app/coordinator/sessions/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 17, $total_rows);
	   

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;
//echo "<pre>";print_r($filter);die;
	    // Get the order List
	    $data['list'] = $this->Admin_model->get_all_sessions($filter, 'created_on', 'DESC');

    	
		$data['filter'] = $filter;
	
		$this->load->model('../../Admin/models/Admin_model');
		
		 //print "<pre>"; print_r($filter);print "</pre>";exit;

		$coordinator_id          =$this->session->userdata('id');
		//echo $coordinator_id;die;
		//$data['list']          =$this->Admin_model->get_all_sessions($coordinator_id);
		$data['search']          =$this->Admin_model->get_all_sessions_search($coordinator_id);

		$data['page'] 				= 'coordinator';
		//$data['coordinator_id'] 	= $co_id;
		//$data['presenterid'] 	    = $presenterid;
    	$data['page_title'] 		= SITE_NAME.' :: Preseneter Assignment';
		$data['main_content'] 		= 'coordinators/sessions';
		
    	$this->load->view(TEMPLATE_PATH, $data);		
	}

		public function search_submit_n() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//echo "<pre>";print_r($_POST);die;
			$start_date = $this->clean_value($this->input->post('start_date'));
    		//$order_start_date = $this->clean_value($this->input->post('order_start_date'));
    		//$order_end_date = $this->clean_value($this->input->post('order_end_date'));
			$school = $this->clean_value($this->input->post('school'));
			$presenter = $this->clean_value($this->input->post('presenter'));
			$status = $this->input->post('status');

			$url = "app/coordinator/sessions/";
			
					
			// $order_start_date = urlencode($order_start_date);
            if ($start_date != '' && $start_date != '~') {
                $url .= "start_date/". $start_date."/";
            }

			
			
			$school = urlencode($school);
			if ($school != '' && $school != '~') {
				$url .= "school/".$school."/";
			}

			$presenter = urlencode($presenter);
			if ($presenter != '' && $presenter != '~') {
				$url .= "presenter/". $presenter."/";
			}

			$status = urlencode($status);
			if ($status != '' && $status != '~') {
				$url .= "status/". $status."/";
			}

			redirect($url);
    	}
    }
}
