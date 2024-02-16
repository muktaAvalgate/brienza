<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goals extends Application_Controller {

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
	private $tablename = 'goals';
	private $url = '/app/goals';
	private $permissionValues = array(
										'index' 					=> 'App.Goals.View',
										'add' 						=> 'App.Goals.Add',
										'edit' 						=> 'App.Goals.Edit',
										
										'delete' 					=> 'App.Goals.Delete',
										'update_status' 			=> 'App.Goals.UpdateStatus',
														
									);
																																																																																																																																																																																																																																																																																																								
	private $role 		= 5; // Presenter Role ID
	private $role_token = 'goals';

	//protected $data = array();
	
	public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
		$this->load->model('../../Admin/models/Admin_model');
        $this->load->model('App_model');
        $this->load->model('Goal_model');
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

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }
       // echo "<pre>";print_r($filter);die;
	    // Get the total rows without limit
	    $total_rows = $this->Goal_model->get_goals_list($filter, 'id', 'asc', true);


	    $config = $this->init_pagination('app/goals/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
	        $limit_end = 0;

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['list'] = $this->Goal_model->get_goals_list($filter, 'id', 'asc');

    	$data['filters'] 	= $uri;
	    $data['page'] 		= 'goals';
    	$data['page_title'] = SITE_NAME.' :: Goal Management';

    	$data['main_content'] = 'goals/list';

    	$this->load->view(TEMPLATE_PATH, $data);
	}

	/**
	 * Following method will 
	 * list down the coordinators
	 * associated with schools
	 */

	   public function add() {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
     		//form validation
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
			
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
			

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'title' 	=> htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
					'start_date' 	=> $this->format_date(htmlspecialchars($this->input->post('start_date'), ENT_QUOTES, 'utf-8')),
					
    				'end_date' 		=> $this->format_date(htmlspecialchars($this->input->post('end_date'), ENT_QUOTES, 'utf-8')),
    				'amount' 		=> htmlspecialchars($this->input->post('amount'), ENT_QUOTES, 'utf-8'),
    				'status' 		=> htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' 	=> $this->session->userdata('id'),
     			   	'created_on' 	=> date('Y-m-d H:i:s')
    			);
    			//echo "<pre>";print_r($data);die;

			

    			//if the insert has returned true then we show the flash message
				if ($goal_id = $this->Goal_model->insert($this->tablename, $data)) 
				{
					//echo 'khb';die;
					
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Goal been added successfully.');
				} 
				else 
				{
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Coordinator already exists.');
    			}
    			redirect('/app/goals');
    		} //validation run
    	}
		
    	$data['page'] = 'goals';
    	$data['page_title'] = SITE_NAME.' :: Goal Management &raquo; Add Goal';

    	$data['main_content'] = 'goals/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	// /**
	//  *
	//  * @param unknown_type $id
	//  */
	public function edit($id) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	//add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');


     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
			$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
			
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
			

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$data = array(
					'title' 	=> htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
					'start_date' 	=> $this->format_date(htmlspecialchars($this->input->post('start_date'), ENT_QUOTES, 'utf-8')),
					
    				'end_date' 		=> $this->format_date(htmlspecialchars($this->input->post('end_date'), ENT_QUOTES, 'utf-8')),
    				'amount' 		=> htmlspecialchars($this->input->post('amount'), ENT_QUOTES, 'utf-8'),
    				'status' 		=> htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' 	=> $this->session->userdata('id'),
     			   	'created_on' 	=> date('Y-m-d H:i:s')
    			);
    			//echo "<pre>";print_r($data);die();
								

     			//if the insert has returned true then we show the flash message
     			if ($this->Goal_model->update($this->tablename, 'id', $id, $data)) {


					// Insert the Mata Data
    				

     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Goal successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect('/app/goals');
     		} //validation run
     	}

     	$data['goals']  = $this->Goal_model->get_goal_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['goals'])) {
     		redirect('/app/goals');
     	}

     	$data['page'] = 'goals';
    	$data['page_title'] = SITE_NAME.' :: Goal Management &raquo; Edit Goal';

    	$data['main_content'] = 'goals/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
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
     *
     */
   public function update_status() {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'Goal', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count = 0;
    			$items = $this->input->post('item_id');
    			$operation = $this->input->post('operation');


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

					if ($this->Goal_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' goal(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect($this->url);
    	}
    }

 
	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->Goal_model->get_goal_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/goals');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->Goal_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Goal successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/goals');
    }


	

	// public function check_email($email) {

 //    	if($this->Admin_model->validate_data($this->tablename, 'email', $email)) {
 //        	$this->form_validation->set_message('check_email', 'Email address already exists.');
 //    		return FALSE;
 //    	} else {
 //     		return TRUE;
 //     	}
	// }
	
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

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
		}
		
		$id = $this->session->userdata('id');
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
    	$data['page_title'] = SITE_NAME.' :: Assign presenter list';

    	$data['main_content'] = 'coordinators/presenter_list';
    	$this->load->view(TEMPLATE_PATH, $data);	
	}
	
	
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
}
