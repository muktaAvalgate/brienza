<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Application_Controller {

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
	private $tablename = 'orders';
	private $url = '/app/orders';
	private $permissionValues = array(
		'index' => 'App.Orders.View',
		'update_status' => 'App.Orders.UpdateStatus',
        'delete' => 'App.Orders.Delete',
		'add' => 'App.Orders.Add',
    );

	private $baa_co_id 	= 129; // BAA Coordinator ID
    //private $allowed_roles = array('bar_admin');

	public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
        $this->load->model('App_model');
    }

	public function index() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

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
		
		if ($this->session->userdata('role') != 'administrator') {
			$filter['school'] = $this->session->userdata('id');
		}
		
    	// Get the total rows without limit
	   	$total_rows = $this->App_model->get_order_list($filter, null, null, true);
	    $config = $this->init_pagination('app/orders/index/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 17, $total_rows);

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
		$schools = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
		
		// Sort by school name
		usort($schools, function($a, $b){
			return ($a->meta['school_name'] <= $b->meta['school_name']) ? -1 : 1;
		});
		$data['schools'] = $schools;

	    $data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	function method1($a,$b) 
	{
		return ($a['meta']['school_name'] <= $b['meta']['school_name']) ? -1 : 1;
	}

    /**
     *
     */
    public function add() {
		

		$data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		
		$this->load->model('../../Admin/models/Admin_model');
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'users.first_name', 'ASC');
		
		$schools = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		
		// Sort by school name
		usort($schools, function($a, $b){
			return ($a->meta['school_name'] <= $b->meta['school_name']) ? -1 : 1;
		});
		$data['schools'] = $schools;

		if($this->session->userdata('role') == 'school_admin')
		{
		    $filter = array();
			$filter['deleted'] = 0;
			$filter['role_token'] = 'coordinator';
			$status = '';

		    if ($status <> '') {
			    $filter['status'] = $status;
		    } else {
		    	$status = 0;
		    }	
		    		
			$school_id = $this->session->userdata('id');
			$data['school_meta'] = $this->Admin_model->get_user_meta($school_id);
			$titles = $this->App_model->get_school_titles($school_id);
			$data['titles'] = array();
			foreach ($titles as $key => $val) {
				$data['titles'][] = (object) array('id' => $key, 'name' => $val);
			}
			$data['presenters'] = $this->Admin_model->get_school_presenter(array('deleted'=>0, 'status'=>'active', 'school_id'=>$school_id, 'first_name', 'ASC'));
			$data['coordinator_list'] = $this->App_model->get_coordinator_list($filter, $school_id, 'id', 'asc');
		}
		elseif($this->session->userdata('role') == 'administrator')
		{
		    $filter 				= array();
			$filter['deleted'] 		= 0;
			$filter['role_token'] 	= 'coordinator';
			$status = '';

		    if ($status <> '') {
			    $filter['status'] = $status;
		    } else {
		    	$status = 0;
		    }

			$school_id = $this->input->get('school_id');
			$data['coordinator_list'] = $this->App_model->get_coordinator_list($filter, $school_id, 'first_name', 'asc');
		}		

		if($this->session->userdata('role') == 'coordinator'){
			$data['schools'] = $this->App_model->get_mappedschool_list(array('delete' => 0, 'status' => 'active'), $this->session->userdata('id'));
		}

		// echo "<pre>";print_r($data['schools']);exit;
		
		$data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }

    /**
	Following method will be used to
	show the providers involved for a
	order
	Created on: 24-06-2019
	Created by: Soumya
    **/
    public function presenter_view($order_id)
    {
    	$get_presenters = $this->App_model->get_presenters_view($order_id);
    	echo $get_presenters;
    }

    /**
	Following method will be used 
	to allocate provided hours to 
	presenters with grades.
	Created on: 20-06-2019
	Created by: Soumya
    **/
    public function assign_hours($order_id = NULL) 
    {
    	## Populate data like order details, school list, grade list, presenter list ##
    	if(isset($_POST['order_id']))
    		$order_id = $this->input->post('order_id');

    	$data['order_details'] 		= $this->App_model->get_specific_order($order_id);
    	$get_assignment_details		= $this->App_model->get_specific_assignment($order_id);

    	if(!empty($get_assignment_details))
    		$data['assignment_det']	= $get_assignment_details;
    	else
    		$data['assignment_det']	= '';

    	if(!empty($data['order_details']['coordinator_id'])  && $data['order_details']['coordinator_id'] != $this->baa_co_id)
    		$data['coordinator_id'] = $data['order_details']['coordinator_id'];
    	elseif(!empty($data['order_details']))
			$data['coordinator_id'] = '';
    	else
    		$data['coordinator_id'] = '';

    	$data['order_no']			= $data['order_details']['order_no'];
    	$data['order_id']			= $order_id;
    	$data['alloted_hours']		= $data['order_details']['hours'];

    	$data['presenter_list'] 	= $this->App_model->get_assignable_presenters($data['coordinator_id'], $data['order_details']['school_id']);
    	if(empty($data['presenter_list'])){
    		$data['presenter_list'] 	= $this->App_model->get_assignable_presenters($data['coordinator_id']);
    	}

    	$data['grade_list']			= $this->App_model->get_school_teacher($data['order_details']['school_id'], $data['order_details']['title_id']);

    	// After the form submission 
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$order_id 		= $this->input->post('order_id');
    		$presenter_id 	= $this->input->post('presenter_id[]');

    		$grade 			= $this->input->post('grade[]');
    		$assigned_hours = $this->input->post('assigned_hours[]');

    		//form validation
    		$this->form_validation->set_rules('presenter_id[]', 'Checkbox', 'required');

    		if(empty(array_filter($assigned_hours))){
    			$this->form_validation->set_rules('assigned_hours[]', 'Assign hour', 'required');
    		}
    		// if(empty(array_filter($grade))){
    		// 	$this->form_validation->set_rules('grade[]', 'Grade', 'required');
    		// }

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{	
	    		$posted_hours	= 0;
	    		$check_one_hr	= 0;

	    		foreach($assigned_hours as $hours_val)
	    		{
	    			$rest_hours = ($data['alloted_hours'] - $posted_hours);

	    			if(!empty($hours_val))
	    			{
	    				if($rest_hours == 1)
	    				{
		     				$hours_input[] 	= $hours_val;
		    				$posted_hours 	= $posted_hours + $hours_val;   					
	    				}
	    				else
	    				{
	    					if($hours_val >= 2)
	    					{
			     				$hours_input[] 	= $hours_val;
			    				$posted_hours 	= $posted_hours + $hours_val;    						
	    					}
	    					else
	    					{
	    						$check_one_hr = 1;
	    						break;
	    					}
	    				}

	    			}
	    		} 

	    		if($check_one_hr)
	    		{
		            $this->session->set_flashdata('message_type', 'danger');
		    		$this->session->set_flashdata('message', '<strong>Opps!</strong> 1 hour can only be given if left hour will be 1.');
		    		$check_one_hr = 0;
	    		}
	    		else
	    		{
		    		if($posted_hours > $data['alloted_hours']) 
		    		{
			            $this->session->set_flashdata('message_type', 'danger');
			    		$this->session->set_flashdata('message', '<strong>Opps!</strong> Total submitted hours are more than allowed hours for the order.');

				    	redirect('/app/orders/assign_hours/'.$order_id);    			
		    		}

		    		$errMsg = '';
		    		$update_data = array();
		    		foreach($presenter_id as $outerKey=>$outerValue)
		    		{

    					$gradeId = '';
			    		foreach($grade[$outerValue] as $grade_val)
			    		{
			    			if($gradeId == '')
			    				$gradeId .= $grade_val;
			    			else
			    				$gradeId .= ','.$grade_val;
			    		}

    		// echo "<pre>";print_r($presenter_id);print_r($grade);print_r($gradeId);exit;

		    			$scheduledHrs = $this->App_model->get_utilized_hours_presenter($order_id, $outerValue);

		    			if($scheduledHrs > $hours_input[$outerKey]){
		    				$presenterNameKey = array_search($outerValue, array_column($data['presenter_list'], 'presenter_id'));
		    				$presenterName= $data['presenter_list'][$presenterNameKey]['first_name'];

		    				if($errMsg == ''){
		    					$errMsg .= '<b>'.$presenterName.'</b> has been '.$scheduledHrs.' hrs already scheduled for this order';
		    				}else{
		    					$errMsg .= '<br/><b>'.$presenterName.'</b> has been '.$scheduledHrs.' hrs already scheduled for this order';
		    				}
		    			}

		    			$update_data[$outerKey]['order_id'] 		= $order_id;
		    			$update_data[$outerKey]['presenter_id'] 	= $outerValue;
		    			$update_data[$outerKey]['assigned_hours']	= $hours_input[$outerKey];
		    			// $update_data[$outerKey]['grade_id'] 		= $grade_input[$outerKey];
		    			$update_data[$outerKey]['grade_id'] 		= $gradeId;

		    			// $data_populate_status			= $this->App_model->insert('order_assigned_presenters', $update_data);
		    		}

		    		if($errMsg != ''){
			            $this->session->set_flashdata('message_type', 'danger');
			    		$this->session->set_flashdata('message', '<strong>Opps!</strong> '.$errMsg);

				    	redirect('/app/orders/assign_hours/'.$order_id); 
		    		}else{

		    			$deleted_prevd	= $this->App_model->delete_previous_assignment($order_id);
		    			$this->db->insert_batch('order_assigned_presenters', $update_data);
		    		}

		    		/*
		    		$update_order_data['status'] = 'approved';
		    		$update_order_data_return	 = $this->App_model->update('orders', 'id', $order_id, $update_order_data);	
		    		*/

		            $this->session->set_flashdata('message_type', 'success');
		    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Hours are successfully assgined to presenters.');

			    	redirect('/app/orders/assign_hours/'.$order_id);
	    		}
	    	}


    	}    	

		$data['page'] = 'Assign Hours';
    	$data['page_title'] = SITE_NAME.' :: Assign Presenters Hours';

    	$data['main_content'] = 'orders/assign_hours';
    	$this->load->view(TEMPLATE_PATH, $data);
    }    
	## ------- End of the code --------- ##
	
	
	public function presenter() {
		
		// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = 'teacher';
		$filter['status'] = 'active';
		$filter['school_id'] = $this->session->userdata('id');
		
		// Get the Users List
		$this->load->model('../../Admin/models/Admin_model');
		
	    // $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');
	    $data['list'] = $this->Admin_model->get_school_presenter($filter, 'id', 'asc');
		
		$data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		
		//print "<pre>"; print_r($data); print "</pre>";
		$data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/presenter';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_order_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/orders');
    	}

		$data_to_store = array(
		   'is_deleted' => 1
	   	);

	   	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Order successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/orders');
    }
	
	
	/**
     *
     * @param int $id
     */
    public function change_status($status = null, $id = null) {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);
    	$data['info'] = $this->App_model->get_order_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/orders');
    	}

		$data_to_store = array(
		   'status' => $status,
		   'order_no'			=> $this->input->post('order_no'),
		   'work_plan_number' 	=> $this->input->post('work_plan_number')
	   	);


	   	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Order successfully '.$status);
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }

		$redirection_url = $this->input->post('redirection');

		if(empty($redirection_url))
			redirect('/app/orders');
		else
    		redirect($redirection_url);
    }
	
	/**
     *
     */
    public function update_status() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'Order', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count = 0;
    			$items = $this->input->post('item_id');
    			$operation = $this->input->post('operation');

    			foreach ($items as $id=>$value) {

					if ($operation == 'delete') {

						$data_to_store = array(
				    		'is_deleted' => 1
				    	);
    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "approved")?'approved':'cancelled'
				    	);
    				}

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' order(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/orders');
    	}
    }


	public function subscriptions($customer_id = null) {

		if ($customer_id == null) {
			return false;
		}

		// Get all the subsciptions
    	$data['subscriptions'] = $this->Customer_model->get_customer_subsciptions($customer_id);

    	//$data['main_content'] = ;
    	$this->load->view("orders/subscriptions", $data);
	}

	public function place_order() {
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour = $this->clean_value($this->input->post('hour'));
			$booking_date = date("Y-m-d");
			$title_id = $this->clean_value($this->input->post('title_id'));
			$presenter_id = $this->clean_value($this->input->post('presenter_id'));
			$coordinator_id 	= $this->clean_value($this->input->post('coordinator_id'));
						
			// Check the title exists
			//$school_id = $this->session->userdata('id');
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}
			$school_titles = $this->App_model->get_school_titles($school_id);
			$school_titles_ids = array_keys($school_titles);
			
			if (!in_array($title_id, $school_titles_ids)) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Please assign title before choosing it.")));
				return;
			}
			
			// Get the topics for chossen title
			$topics = array();
			$topics = $this->App_model->get_title_topic_data($title_id);
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('success' => true, 'topics' => $topics, 'hour' => $hour, 'booking_date' => $booking_date, 'title_id' => $title_id, 'presenter_id' => $presenter_id, 'coordinator_id' => $coordinator_id, 'school_id' => $school_id, 'msg' => "")));
			return;
		}
	}
	
	public function place_order_confirm() {
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour = $this->clean_value($this->input->post('hour'));
			$booking_date = $this->input->post('booking_date');
			$title_id = $this->clean_value($this->input->post('title_id'));
			$presenter_id = $this->clean_value($this->input->post('presenter_id'));
			$coordinator_id 	= $this->clean_value($this->input->post('coordinator_id'));
			$topics = $this->input->post('topics[]');	
			
			$coordinator_id = ($coordinator_id > 0) ? $coordinator_id : $this->baa_co_id;
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}
			
			// Get presenter rate
			$this->load->model('../../Admin/models/Admin_model');
			$presenter = $this->Admin_model->get_user_details($presenter_id);
			
			// ======== Start Code By Ahmed on 2019-09-21 ======= //
			$coordinatorData = $this->Admin_model->get_user_details($coordinator_id);
    		
			if(!empty($presenter) && isset($presenter->first_name)){
				$presenter_name = $presenter->first_name." ".$presenter->last_name;
			}else{
				$presenter_name = "--";
			}
			if(!empty($coordinatorData) && isset($coordinatorData->first_name)){
				$coordinator_name = $coordinatorData->first_name." ".$coordinatorData->last_name;
			}else{
				$coordinator_name = "--";
			}
			// Get school meta data
			$schoolData = $this->Admin_model->get_user_meta($school_id);

			// Get title Name from database
			$titleName = $this->Admin_model->get_title_name($title_id);
			// ======== End of the Code 2019-09-21 ====== //
			
			/*
			$data = array(
				'order_no' => "WQ".date("ymd").rand(100, 999),
				'school_id' => $school_id,
				'presenter_id' => $presenter_id,
				'title_id' => $title_id,
				'hours' => $hour,
				'hourly_rate' => $presenter->meta['rate'],
				'booking_date' => $this->format_date($booking_date),
				'status' => 'pending',
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('id')				
			);
			*/

			$data = array(
				'order_no' 			=> '',
				'school_id' 		=> $school_id,
				'presenter_id' 		=> $presenter_id,
				'coordinator_id'	=> $coordinator_id,
				'title_id' 			=> $title_id,
				'hours' 			=> $hour,
				'hourly_rate' 		=> (!empty($presenter)) ? $presenter->meta['rate'] : 0,
				'booking_date' 		=> $this->format_date($booking_date),
				'status' 			=> 'pending',
				'created_on' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $this->session->userdata('id'),
				'co_rate_type'		=> $coordinatorData->meta['rate_type'],
				'co_rate' 			=> $coordinatorData->meta['rate'],
			);				
			
			if ($order_id = $this->Admin_model->insert('orders', $data)) {
				// Insert the Order Topics
				if (!empty($topics)) {
					$this->App_model->insert_order_topics($order_id, $topics);
				}
				
                // ======== Start Code By Ahmed on 2019-09-21 ======= //
                // Send notification on Site admin
                $msg = "<p><b>School Name:</b> ".$schoolData['school_name']."<br/><b>Coordinator Name:</b> ".$coordinator_name."<br/><b>Presenter Name:</b> ".$presenter_name."<br/><b>Title:</b> ".$titleName."<br/><b>Booking Date:</b> ".$data['booking_date']."<br/><b>Status:</b> ".$data['status']."</p>";

                //$this->load->library('mail_template');
                //$this->mail_template->notification_email(null, 'kconte@brienzas.com', $msg, 'Order');
                // ======== End of the Code 2019-09-21 ====== //

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => true, 'msg' => "Order successfully placed. Please note that orders are only processed Monday through Friday, from 10am to 4pm. Approval takes up to 5 to 10 days depending on the amount requested.")));
				return;
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Error placing order. Please try again.")));
				return;
			}
			
			//print_r($presenter);print_r($data); die;
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

			$url = "app/orders/index/";
			
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
	
	public function billing() {
		
		$order_id = $this->input->get('order_id');
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			// print "<pre>"; print_r($_POST); print_r($_FILES); die;
			$attachment = (isset($_FILES['attachment'])?$_FILES['attachment']:"");
			$status = $this->input->post('status');
			$old_status = $this->input->post('old_status');
			$content  = $this->input->post('content');
			$order_schedule_status_id = $this->input->post('order_schedule_status_id');
						
			$count = 0;
			foreach ($status as $order_schedule_id => $stat) {
				
				$data = array();
				
				if (!empty($attachment['name'][$order_schedule_id])) {

	    			$config['upload_path'] = DIR_TEACHER_FILES;
					$config['max_size'] = '25000';
					$config['allowed_types'] = 'jpg|png|jpeg|pdf|txt|doc|docx|xls';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;

				    $this->load->library('upload', $config);

					$attach = array();

				    $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
				    $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
				    $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
				    $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
				    $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];

					$config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
				    $attach[] = $config['file_name'];

				    //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
				    $this->upload->initialize($config);

					if ($this->upload->do_upload('attach[]')) {
						$upload_data =  $this->upload->data();
						$data['attachment'] = $upload_data['file_name'];
					} else {
						//$this->upload->display_errors(); die;
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', $this->upload->display_errors());

						redirect('/app/orders/billing/?order_id='.$order_id);
					}
	     		}
				
				//print "<pre>"; print_r($data); print "</pre>"; die;
				// If status not same, update the log
				if ($status[$order_schedule_id] <> $old_status[$order_schedule_id]) {
					
					// $data['order_schedule_id'] = $order_schedule_id;
					// $data['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $status[$order_schedule_id];
					// $data['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Create log' : $old_status[$order_schedule_id];
					// $data['updated_on'] = date("Y-m-d H:i:s");
					// $data['updated_by'] = $this->session->userdata('id');
					
					// Update by ahmed on 14-02-2020
					$data['order_schedule_id'] = $order_schedule_id;
					$data['updated_by'] = $this->session->userdata('id');

					// For log uploaded file by presenter
					if($status[$order_schedule_id] == 'Create log'){
						$data['new_status'] = 'Log sent - awaiting principal signature';
						$data['old_status'] = 'Create log';
						$data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
						$this->App_model->insert('order_schedule_status_log', $data);
					}


					$data['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
					$data['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status[$order_schedule_id];
					$data['updated_on'] = date("Y-m-d H:i:s");
					// End of code on 14-02-2020
					

					if ($status[$order_schedule_id] == "Log sent - awaiting principal signature") {
						
						$order = $this->App_model->get_order_details($order_id);
						$schedule = $this->App_model->get_order_schedule_details($order_schedule_id);	
						
						$data['content'] = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
							<tr>
								<td><img src="'. base_url("assets/images/logo.png").'"></td>
								<td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
							</tr>
							<tr>
								<th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
							</tr>
							<tr>
								<td align="center" colspan="2" style="height:40px;"><strong>Presenter:</strong> '. $schedule->teacher.'</td>
							</tr>
							<tr>
								<td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
							</tr>
							<tr>
								<td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2" style="border-top:solid 1px;">'.$content.'</td>
							</tr>
							<tr>
								<td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal’s Signature:</strong></td>
								<td align="right" style="height:50px; border-top:solid 1px;"><strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
							</tr>
							<tr>
								<td align="right" colspan="2" style="height:50px; border-top:solid 1px;">
								</td>
							</tr>
						</table>';
					}
					
					if ($status[$order_schedule_id] == "Awaiting Review") {
						$data['content'] = isset($content) ? $content : '';
					}
					
					if ($status[$order_schedule_id] == "Invoice created") {
						
						// Generate Invoice
						$presenter_id = $this->input->post('presenter_id');
						$order = $this->App_model->get_order_details($order_id, $presenter_id);
						$schedules =$this->App_model->get_order_schedule_details($order_schedule_id);
						// echo "<pre>";print_r($schedules);exit;
								
            			// ======== Start Code By Ahmed on 2019-08-28 ======= //
						$logData = $this->App_model->get_log_pdf_content($order_schedule_id);
						// ======= End of the code 2019-08-28 ====== //	
						$invoice = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
							<tr>
								<td style="height:40px;" colspan="4">
								<img src="'.base_url().'assets/header_image/'.$order->headerImg.'" height="135" width="100%">
								</td>
							</tr>
							<tr>
								<td style="height:40px;" colspan="4"><strong>INVOICE:</strong></td>
								<td style="height:40px; text-align:right"><strong>BILL TO</strong></td>
							</tr>
							<tr>
								<td colspan="3"><strong>Company Name:</strong> '. $order->company_name.'</td>
								<td style="text-align:right"><strong>Brienza\'s Academic Advantage, Inc. 8696 18th Avenue Brooklyn, New York 11214</strong></td>
							</tr>
							<tr>
								<td colspan="4"><strong>Presenter:</strong> '. $order->teacher_name.'</td>
							</tr>
							<tr>
								<td colspan="4"><strong>Address:</strong> '. $order->presenter_address.'</td>
							</tr>
							<tr>
								<td colspan="4"><strong>Phone number:</strong> '. $order->presenter_phone.'</td>
							</tr>
							<tr>
								<td align="left" colspan="4"><strong>PO#:</strong> '. $order->order_no.' <strong>School:</strong> '. $order->school_name.'</td>
							</tr>
							<tr>
								<td align="right"></td>
							</tr>
							<tr>
								<th>Date</th>
								<th>Rate</th>
								<th>Hours</th>
								<th>Total</th>
							</tr>';
							
							$g_total = 0;
							$g_hrs = 0;
							// foreach ($schedules as $schedule) {
								$total = ($schedules->total_hours*$order->hourly_rate);
								$invoice .= '<tr>
									<td>'.$schedules->start_date.'-'.$schedules->end_date.'</td>
									<td align="right">$'.$order->hourly_rate.'</td>
									<td align="right">'.$schedules->total_hours.'</td>
									<td align="right">$'.number_format($total,2).'</td>
								</tr>';
								$g_hrs += $schedules->total_hours;
								$g_total += $total;
							// }
							
							$invoice .= '<tr>
								<td align="left"></td>
								<td colspan="2" align="right"><strong>Total Hours:</strong> '. $g_hrs.'</td>
								<td align="right"><strong>Total:</strong>$'. number_format($g_total,2).'</td>
							</tr>
							<tr>
								<td align="right">&nbsp;</td>
							</tr>
							<tr>
								<td align="right" colspan="2">Signature: <img src="'.FCPATH.$content.'"></td>
								<td align="right" colspan="2">Date: '.date("m/d/Y").'</td>
							</tr>
							<tr>
								<td align="right">&nbsp;</td>
							</tr>
						</table>';
						$invoice .= '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
						
            			// ======== Start Code By Ahmed on 2019-08-08 ======= //
            			if(isset($logData->attachment) && $logData->attachment != ''){
							$invoice .= '<img src="'.FCPATH."/assets/teachers/".$logData->attachment.'">';
						}else{
							$invoice .=$logData->create_log_content.'<img src="'.FCPATH.$logData->content.'">';
						}
						// ======= End od the Code 2019-08-08 ====== //
						//load mPDF library
						$this->load->library('m_pdf');

						//this the the PDF filename that user will get to download
						$data['attachment'] = DIR_TEACHER_FILES."invoice_".date('YmdHis').".pdf";		
									
						//generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($invoice);
						
						//download it.
						$this->m_pdf->pdf->Output($data['attachment']); 

						$data['content'] = $content;
						
					}
					
					// Update Log table
					if ($this->App_model->insert('order_schedule_status_log', $data)) {
						$count++;
					} 
				}else{

					$data['updated_on'] = date("Y-m-d H:i:s");
					$data['updated_by'] = $this->session->userdata('id');
					
					// Update Schedule Table
					$this->App_model->update('order_schedule_status_log', 'id', $order_schedule_status_id[$order_schedule_id], $data);
				}
				
				// Update Schedule Table
				$data_schedule = array(
					'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
					'updated_on' => date("Y-m-d H:i:s"),
					'updated_by' => $this->session->userdata('id'),
					'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
				);
				$this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
			}
			
			$this->session->set_flashdata('message_type', 'success');
         	$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully update.');
			if($this->input->post('ajaxCall')){
         		echo true;exit;
         	}else{
				redirect('/app/orders/billing/?order_id='.$order_id);         		
         	}
		}
		
		if ($order_id) {
			
			// Get order details
			$data['order'] = $this->App_model->get_order_details($order_id);
			
			if($this->session->userdata('role') == 'teacher')
			{
				$presenter_id 	= $this->session->userdata('id');

				$schedulable_hr	= $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
				$scheduled_hr	= $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

				$data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");

				if($schedulable_hr)
					$data['schedulable_hr']	= $schedulable_hr;
				else
					$data['schedulable_hr']	= 0;

				if($scheduled_hr)			
					$data['scheduled_hr']	= $scheduled_hr;
				else
					$data['scheduled_hr']	= 0;

				$remaining_schedule_hrs 		= $data['schedulable_hr'] - $data['scheduled_hr'];
				$data['remaining_schedule_hrs'] = $remaining_schedule_hrs;				
			}else{
				
				// Get the existing schedule
				$data['schedules'] = $this->App_model->get_order_schedule($order_id, NULL, "order_schedules.id");	
				//echo "<pre>";print_r($data['schedules']);die;			
			}
		}
		// print "<pre>"; print_r($data); print "</pre>";exit;
		$data['page'] = 'order';
    	$data['page_title'] = SITE_NAME.' :: Order Management &raquo; Billing';
		$data['approvedStatus'] = $this->App_model->getApprovedStatus($order_id);
    	$data['main_content'] = 'orders/billing';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	
	function save_sign() {
		
		$result = array();
		$imagedata = base64_decode($_POST['img_data']);
		$filename = md5(date("dmYhisA"));
		//Location to where you want to created sign image
		$file_name = DIR_SIGN.$filename.'.png';
		file_put_contents($file_name,$imagedata);
		$result['status'] = 1;
		$result['file_name'] = $file_name;
		//echo json_encode($result);
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
		return;
	}
	
	function display_log($schedule_id) {
		$schedule = $this->App_model->get_order_schedule_details($schedule_id);

		// echo "<pre>";print_r($schedule);exit;
		
		// if ($schedule->content) {
		// 	echo $schedule->content;
		// }

		if ($schedule->log_signature) {
			$dir1 = substr($schedule->log_signature, 0, 6);
			$dir2 = substr($schedule->log_signature, 7, 9);

			if($dir1=='assets' && $dir2=='doc_signs'){
				echo $schedule->create_log_content;
				echo '<img src="https://img247.managed.center/'.str_replace('assets/doc_signs/', '', $schedule->log_signature).'">';
			}else{
				echo $schedule->content;
			}
			
		}else{
			echo $schedule->content;
		}
	}
	
	function display_old_log($order_schedule_id) {
		$schedule = $this->App_model->get_log_content($order_schedule_id);
		
		if ($schedule->content) { 
			$dir1 = substr($schedule->content, 0, 6);
			$dir2 = substr($schedule->content, 7, 9);

			if($dir1=='assets' && $dir2=='doc_signs'){
				echo $schedule->create_log_content;
				echo '<img src="'.base_url($schedule->content).'">';
			}else{
				echo $schedule->content;
			}
			
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

       	$ci->pagination->initialize($config);
       	return $config;
   }

   private function format_date($date) {
	   if ($date == "")
	   	return "";

	   $newdate = date_create($date);
	   return date_format($newdate,"Y-m-d");
   }

	public function get_assign_school_presenter(){

		$school_id = $this->input->post('school_id');
		$co_id = $this->input->post('co_id');
		
		$this->load->model('../../Admin/models/Admin_model');

		if(isset($co_id) && $co_id > 0){			
			$res = $this->Admin_model->get_coordinator_assign_school_presenter($co_id, $school_id);
			array_multisort(array_column($res, 'first_name'),  SORT_ASC, $res);
		}else{
			$res = $this->Admin_model->get_school_presenter(array('school_id'=>$school_id, 'first_name', 'ASC'));
		}
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

	public function get_assign_school_coordinator(){
		$school_id = $this->input->post('school_id');

		$this->load->model('../../Admin/models/Admin_model');
		$res = $this->Admin_model->get_coordinator_assign_school($school_id);
		// echo "<pre>";print_r($res);exit;
		echo json_encode($res);
	}

	public function save_cheque_no(){
		$order_schedule_id = $this->input->post('order_schedule_id');
		$cheque_no = $this->input->post('cheque_no');
		$schedule = $this->App_model->get_order_schedule_details($order_schedule_id);
		
		if(!empty($schedule)){
			$this->App_model->update('order_schedules', 'id', $order_schedule_id, array('check_number' => $cheque_no));

            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Check number has been successfully updated.');
		}else{
			$this->session->set_flashdata('message_type', 'danger');
    		$this->session->set_flashdata('message', '<strong>Opps!</strong> Somthing went wrong please try again.');
		}
		echo true;
	}
	
    public function download($id = NULL, $status = NULL) {

    	if($status == NULL){
	    	// Get Order schedule data
	    	$record = $this->App_model->get_order_schedule_details($id);
	    }else{
	    	// Get Order schedule log data
	    	$record = $this->App_model->get_log_content($id);
	    	//echo "<pre>";print_r($record);die;
	   }

		if (!empty($record)) {
			if((isset($record->new_status) && $record->new_status == 'Invoice created') || (isset($record->status) && $record->status == 'Invoice created')){
				$file = $record->attachment;
			}else{
				$file = DIR_TEACHER_FILES.$record->attachment;
			}

			// check file exists
			if (file_exists($file)) {
				// get file content
				$data = file_get_contents ( $file );
				//force download
   				$this->load->helper('download');
				force_download ( $record->attachment, $data );
			}
		}
	}
	public function multipleConfirmhoursUpdate(){
		$scheduled_id = $this->input->post('scheduled_id');
		$data_schedule = array(
					'status' => 'Confirm hours',
					'updated_on' => date("Y-m-d H:i:s"),
					'updated_by' => $this->session->userdata('id')
				);
				$this->App_model->multipleConfirmhoursUpdate($scheduled_id, $data_schedule);
		return true;
	}
	public function billings(){

    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
		add_js('assets/js/plugins/colResizable-1.6.min.js');
		$this->load->model('../../Admin/models/Admin_model');
		$this->load->library('pagination');
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
		$presenter=$purchase_order_no='';
		$billings = $this->App_model->getAdminBilling($presenter,$purchase_order_no,20,$this->uri->segment(4));
		$count= $this->App_model->getAdminBillingcount($presenter,$purchase_order_no);
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$presenter = $this->input->post('presenter');
    		//$billing_due_date = $this->input->post('billing_due_date');
    		$purchase_order_no = $this->input->post('purchase_order_no');

    		$billings = $this->App_model->getAdminBilling($presenter,$purchase_order_no,20,$this->uri->segment(4));
			$count= $this->App_model->getAdminBillingcount($presenter,$purchase_order_no);
    	}
		foreach ($billings as $item) {
			$item->presenters_inv = $this->App_model->getInvprsenter($item->id);
		}
		$data['presenter'] = $presenter;
		$data['purchase_order_no'] = $purchase_order_no;
		$data['billings'] = $billings;



		//pagination
		$config = [
			'base_url' => base_url('app/orders/billings'),
			'per_page' => 20,
			'total_rows' => $count,
			'full_tag_open' => '<ul class="pagination">', 
			'full_tag_close' => '</ul>', 
			'num_tag_open' => '<li class="page-item"><span class="page-link">', 
			'num_tag_close' => '</span></li>', 
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
			'cur_tag_close' => '</a></li>', 
			'prev_tag_open' => '<li class="page-item"><span class="page-link">', 
			'prev_tag_close' => '</span></li>', 
			'next_tag_open' => '<li class="page-item"><span class="page-link">', 
			'next_tag_close' => '</span></li>', 
			'last_tag_open' => '<li class="page-item"><span class="page-link">',
			'last_tag_close' => '</span></li>', 
			'first_tag_open' => '<li class="page-item"><span class="page-link">', 
			'first_tag_close' => '</span></li>',
		];

		$this->pagination->initialize($config);


	    $data['page'] = 'billing';
    	$data['page_title'] = SITE_NAME.' :: Manage Billing';

    	$data['main_content'] = 'orders/billings';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
}