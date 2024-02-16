<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presenters extends Application_Controller {

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
	private $url = '/app/presenters';
	private $permissionValues = array(
		'index' => 'App.Presenters.View',
		'add' => 'App.Presenters.Add',
		'edit' => 'App.Presenters.Edit',
		'reset_pass' => 'App.Presenters.ResetPass',
        'delete' => 'App.Presenters.Delete',
		'update_status' => 'App.Presenters.UpdateStatus',
    );
	private $role = 3; // Presenter Role ID
	private $role_token = 'teacher';
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

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_users_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('product/presenters/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 9, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');

    	//print "<pre>"; print_r($data);print "</pre>";
    	$data['filters'] = $uri;
	    $data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management';

    	$data['main_content'] = 'presenters/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


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
    		//$this->form_validation->set_rules('meta[category_id]', 'Title', 'trim|required');
			$this->form_validation->set_rules('email', 'Email address', 'trim|required|callback_check_email');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		//$this->form_validation->set_rules('meta[info]', 'Info', 'trim|required');
	    	$this->form_validation->set_rules('meta[rate]', 'Rate', 'trim|required|numeric');

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    		//if the form has passed through the validation

    		if ($this->form_validation->run())
    		{
				//$raw_password = htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8');

    			$data = array(
					'first_name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'role_id' => $this->role,
    				'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

				$meta = $this->input->post('meta');

				$rate_file = $_FILES['rate_file'];

				// Upload Category Image
    			if (!empty($rate_file['name'])) {

	    			$config['upload_path'] = DIR_TEACHER_FILES;
					$config['max_size'] = '5000';
					$config['allowed_types'] = 'jpg|png|jpeg|pdf';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;

				    $this->load->library('upload', $config);

					$config['file_name'] = 'teacher-'.rand().date('YmdHis');
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('rate_file')) {
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', $this->upload->display_errors());

                        redirect('/app/presenters/');
					} else {
						$upload_data =  $this->upload->data();
						$meta['rate_file'] = $upload_data['file_name'];
					}
	     		}

    			//if the insert has returned true then we show the flash message
    			if ($user_id = $this->Admin_model->insert($this->tablename, $data)) {

					// Insert the Mata Data
					$this->Admin_model->replace_user_meta($user_id, $meta);

					// Send Email to users
					$this->load->library('mail_template');
    				$this->mail_template->register_teacher_email($data['first_name'], $data['email'], $user_id);

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Presenter already exists.');
    			}
    			redirect('/app/presenters');
    		} //validation run
    	}
		
		/*$filter = array(
            'deleted' => 0,
            'status' => 'active'
        );

        $data['title'] = $this->App_model->get_title_list($filter);*/
		
    	$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Add Presenter';

    	$data['main_content'] = 'presenters/add';
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
			//$this->form_validation->set_rules('meta[category_id]', 'Title', 'trim|required');
			//$this->form_validation->set_rules('email', 'Email address', 'trim|required|callback_check_email');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		//$this->form_validation->set_rules('meta[info]', 'Info', 'trim|required');
	    	$this->form_validation->set_rules('meta[rate]', 'Rate', 'trim|required|numeric');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$data = array(
					'first_name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'role_id' => $this->role,
    				//'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
     				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

				$meta = $this->input->post('meta');				

				$rate_file = $_FILES['rate_file'];

				// Upload Category Image
    			if (!empty($rate_file['name'])) {

	    			$config['upload_path'] = DIR_TEACHER_FILES;
					$config['max_size'] = '5000';
					$config['allowed_types'] = 'jpg|png|jpeg|pdf';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;

				    $this->load->library('upload', $config);

					$config['file_name'] = 'teacher-'.rand().date('YmdHis');
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('rate_file')) {
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', $this->upload->display_errors());

                        redirect('/app/presenters/');
					} else {
						$upload_data =  $this->upload->data();
						$meta['rate_file'] = $upload_data['file_name'];
					}
	     		}

     			//if the insert has returned true then we show the flash message
     			if ($this->Admin_model->update($this->tablename, 'id', $id, $data)) {

					// Insert the Mata Data
    				$this->Admin_model->replace_user_meta($id, $meta);

     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect('/app/presenters');
     		} //validation run
     	}

     	$data['teacher']  = $this->Admin_model->get_user_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['teacher'])) {
     		redirect('/app/presenters');
     	}
		
		/*$filter = array(
            'deleted' => 0,
            'status' => 'active'
        );

        $data['title'] = $this->App_model->get_title_list($filter);*/
		
		//print "<pre>"; print_r($data);die;
     	$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Edit Presenter';

    	$data['main_content'] = 'presenters/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
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
    		$this->form_validation->set_rules('item_id[]', 'User', 'trim|required');

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
				    		'status' => ($operation == "active")?'1':'0'
				    	);
    				}

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' teacher(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/presenters');
    	}
    }


	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->Admin_model->get_user_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/presenters');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->Admin_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/presenters');
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
	
	
	public function order() {
		
		$filter = array(
			'deleted' => 0,
			'presenter' => $this->session->userdata('id'),
			'status' => 'approved'
		);
		$data['orders'] = $this->App_model->get_order_list($filter, 'created_on', 'desc');
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Orders';

		//print "<pre>"; print_r($data); die;
    	$data['main_content'] = 'presenters/orders';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	
	
	public function scheduling() {
		
		$school_id = $this->input->get('school_id');
		$order_id = $this->input->get('order_id');
		$topic_id = $this->input->get('topic_id');
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			//print "<pre>"; print_r($_POST); print "</pre>";
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
				$date = htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
				$start_time = htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
				$end_time = htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
				
				$start_ts = new DateTime($date." ".$start_time);
				$start_date = $start_ts->format('Y-m-d H:i:s');

				$end_ts = new DateTime($date." ".$end_time);
				$end_date = $end_ts->format('Y-m-d H:i:s');
				
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
	    $data['schools'] = $this->Admin_model->get_users_list(array('deleted' => 0, 'status' => 'active', 'role_token' => 'school_admin'), 'id', 'asc');
		
		if ($school_id) {
			// Get the Orders for drop-down
			$data['purchase_orders'] = $this->App_model->get_order_list(array('deleted' => 0, 'school' => $school_id, 'presenter' =>  $this->session->userdata('id'), 'status' => 'approved'), 'created_on', 'desc');
			
			// Get the Grade list
			$data['grades'] = $this->App_model->get_teacher_list(array('deleted' => 0, 'school_id' => $school_id, 'status' => 'active'), 'created_on', 'desc');
			$data['selected_school'] = $school_id;
		}
		
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
		
		//print "<pre>"; print_r($holidays); print "</pre>";
		
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
				'cal_cell_no_content'	=> '<a href="#" onclick="inputCalendarDate(\'{year}\',\'{month}\',\'{day}\');">{day}</a>',
			),
			'holidays'				=> $data['holidays'],
		);
		
		
		$this->load->library('my_calendar', $prefs);
		$data['calendar'] = $this->my_calendar->generate($this->uri->segment(4), $this->uri->segment(5));
		
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
			redirect('/app/presenters/order');
		}
		
		// Redirect to Order > Billing
		redirect('app/orders/billing/?order_id='.$order_id);
	}
	
	public function display_schedule($schedule_id){
		
		$schedule = $this->App_model->get_order_schedule_details($schedule_id);
		
		$content = '';
		//$content .= "School name: "."<br>";
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
}
