<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends Application_Controller {

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
	private $tablename = 'notifications';

	private $permissionValues = array(
		'index' => 'Admin.Permissions.View',
		'add' => 'Admin.Permissions.Add',
    );


	public function __construct() {

        parent::__construct();

        // Validate Login
		parent::checkLoggedin();

        $this->load->model('Notify_model');
    }

	public function index() {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

		$default_uri = array('page');
		$uri = $this->uri->uri_to_assoc(4, $default_uri);

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}
		
		$folder = $this->input->get('folder');
		if ($folder=="") $folder = "inbox";
		
		if ($folder == "sent") {
			$filter = array('delete' => '0', 'category' => 'inbox', 'created_by' => $this->session->userdata('id'));
		} else if ($folder == "announcement") {
			if($this->session->userdata('role') == 'administrator'){
				$filter = array('delete' => '0', 'category' => 'announcement', 'created_by' => $this->session->userdata('id'));
			}else{
				$filter = array('delete' => '0', 'category' => 'announcement', 'user_id' => $this->session->userdata('id'));
			}
		} else {
			$filter = array('delete' => '0', 'category' => 'inbox', 'user_id' => $this->session->userdata('id'));
		}
		
	    // Get the total rows without limit
		$total_rows = $this->Notify_model->get_notifications_list($filter, null, null, true);

	    $config = $this->init_pagination('app/notifications/index/'.$this->uri->assoc_to_uri(array()).'/page/', 5, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Permissions List
	   	$data['notifications'] = $this->Notify_model->get_notifications_list($filter);
		
		$filter_announcement = array(
			'delete' => 0,
			'category' => 'announcement',
			'status' => 'unread',
			'user_id' => $this->session->userdata('id')
		);
		$data['unread_announcement'] = $this->Notify_model->get_notifications_list($filter_announcement, null, null, true);
		
		$filter_inbox = array(
			'delete' => 0,
			'category' => 'inbox',
			'status' => 'unread',
			'user_id' => $this->session->userdata('id')
		);
		$data['unread_inbox'] = $this->Notify_model->get_notifications_list($filter_inbox, null, null, true);
		
		// No unread for sent items
		if ($folder == "sent") {
			$data['unread'] = 0;
		}
    	// print "<pre>"; print_r($filter); print_r($data);print "</pre>";

	    $data['page'] = 'notifications';
		$data['folder'] = $folder;
    	$data['page_title'] = SITE_NAME.' :: Manage Notifications';

    	$data['main_content'] = 'notifications/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


    /**
     *
     */
    public function add() {

    	// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

		// Include the JS & CSS file.
    	add_js(array('assets/js/plugins/wysihtml5-0.3.0.min.js', 'assets/js/plugins/bootstrap3-wysihtml5.js'));
		add_css(array('assets/css/bootstrap-wysihtml5.css'));
		
		$folder = $this->input->get('folder');
		if ($folder=="") $folder = "inbox";
		
    	//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
     		//form validation
			// if ($folder <> "announcement") {
				$this->form_validation->set_rules('type', 'Type', 'trim|required');
			// }
    		$this->form_validation->set_rules('users[]', 'Recipient users', 'trim|required');
    		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('description', 'Message', 'trim|required');

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    		//if the form has passed through the validation

    		if ($this->form_validation->run())
    		{
				$users = $this->input->post('users');
				$type = htmlspecialchars($this->input->post('type'), ENT_QUOTES, 'utf-8');
				$email = htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8');
				$subject = htmlspecialchars($this->input->post('subject'), ENT_QUOTES, 'utf-8');
				$description = $this->input->post('description');

				$send_users = array();

				// if (!isset($users) && empty($users)) {

					if ($type == "admin") {
						$full_users = $this->Notify_model->get_users_list(array('role_token' => 'administrator'));
					} else if ($type == "presenter") {
						$full_users = $this->Notify_model->get_users_list(array('role_token' => 'teacher'));
					} else if ($type == "school") {
						$full_users = $this->Notify_model->get_users_list(array('role_token' => 'school_admin'));
					} else {
						//$full_users = $this->Notify_model->get_teacher_list(array());
						$full_users = array();
					}

					foreach ($full_users as $key => $user) {
						if(in_array($user->id, $users)){
							$send_users[] = array(
								'id' => $user->id,
								'name' => $user->first_name." ".$user->last_name,
								'email' => $user->email
							);
						}
					}
				// }
				
				// if ($folder == "announcement") {
				// 	$full_users = $this->Notify_model->get_users_list(array());
					
				// 	foreach ($full_users as $key => $user) {
				// 		$users[] = array(
				// 			'id' => $user->id,
				// 			'name' => $user->first_name." ".$user->last_name,
				// 			'email' => $user->email
				// 		);
				// 	}
				// }
				
    			$notify = array(
    				'type' => $type,
					'category' => $folder,
					'subject' => $subject,
    				'description' => $description,
					'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($notification_id = $this->Notify_model->insert($this->tablename, $notify)) {

					//$this->load->library('mail_template');

					foreach ($send_users as $key => $user) {

						if ($user['id'] <> "") {
							$data = array(
								'user_id' => $user['id'],
								'notification_id' => $notification_id
							);
							$this->Notify_model->insert('notification_users', $data);
							
							// Send Email to users
			    			//$this->mail_template->email_to_user($user['email'], $user['name'], $subject, $description);
						}

					}
					
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Notification successfully sent. ');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
    			}
    			redirect('/app/notifications');
    		} //validation run
    	}
		
		$data['folder'] = $folder;
    	$data['page'] = 'notifications';
    	$data['page_title'] = SITE_NAME.' :: Manage Notifications &raquo; Send Notification';

    	$data['main_content'] = 'notifications/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }

	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->Notify_model->get_notification_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/notification/notifications');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

		//$users = $this->Notify_model->get_notification_users($id, $data['info']->type);

		// Update all
		/*$count = 0;
		foreach ($users as $key => $user) {
			
			print "<pre>"; print_r($user);
			if ($this->Notify_model->update('notification_users', 'id', $user->id, $data_to_store)) {
				$count++;
			}
		}*/

      	//if ($count > 0) {
      	//if ($this->Bar_model->delete($this->tablename, $id)) {
		if($this->Notify_model->update('notifications', 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Notification successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/notification/notifications');
    }

	public function get_users() {

		//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$type = $this->input->post('type');
			
			if ($type == "admin") {
				$users = $this->Notify_model->get_users_list(array('role_token' => 'administrator'));
			} else if ($type == "presenter") {
				$users = $this->Notify_model->get_users_list(array('role_token' => 'teacher'));
			} else if ($type == "school") {
				$users = $this->Notify_model->get_users_list(array('role_token' => 'school_admin'));
			} else {
				$users = $this->Notify_model->get_teacher_list(array());
			}

			$this->output
	        	->set_content_type('application/json')
	        	->set_output(json_encode(array('type' => $type, 'users' => $users)));
		}
	}

	/**
	 *
	 */
	function get_notification_users($id = 0) {

		if ($id == 0) {
			return;
		}

		$type = $this->input->post('type');

		$users = $this->Notify_model->get_notification_users($id, $type);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('users' => $users)));

	}

	function get_notifications() {

		$filter = array(
			'user_id' => $this->session->userdata('id'),
			'type' => 'users',
			'limit' => 5
		);

		$notifications = $this->Notify_model->get_notifications_list($filter);

		$filter['status'] = 'unread';
		$unread = $this->Notify_model->get_notifications_list($filter, null, null, true);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('notifications' => $notifications, 'unread' => $unread)));
	}


	function get_notification_details($id) {

		$notification = $this->Notify_model->get_notification_details($id);

		// Update the notification status to read
		$this->Notify_model->update_status($id, $this->session->userdata('id'));

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($notification));
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

	function reply_notification() {

		$inserted_id = $this->Notify_model->insert('notification_reply', array('notification_id' => $_POST['notification_id'], 'sender_id' => $_POST['sender_id'], 'reply' => $_POST['description'], 'created_by' => $this->session->userdata('id')));
		if($inserted_id){
			$ins_id = $this->Notify_model->insert('notification_users', array('notification_id' => $_POST['notification_id'], 'reply_id' => $inserted_id, 'user_id' => $_POST['sender_id']));
			$this->Notify_model->update('notifications', 'id', $_POST['notification_id'], array('updated_on' => date('Y-m-d H:i:s')));
		}
		$notification = $this->Notify_model->get_notification_details($_POST['notification_id']);

		// // Update the notification status to read
		// $this->Notify_model->update_status($id, $this->session->userdata('id'));

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($notification));
	}

	// public function request_new_teacher() {

    //     add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

    //     // Include the JS & CSS file.
    //     add_js(array('assets/js/plugins/wysihtml5-0.3.0.min.js', 'assets/js/plugins/bootstrap3-wysihtml5.js'));
    //     add_css(array('assets/css/bootstrap-wysihtml5.css'));
        
    //     $folder = $this->input->get('folder');
    //     if ($folder=="") $folder = "inbox";
        
    //     //if save button was clicked, get the data sent via post
    //     if ($this->input->server('REQUEST_METHOD') === 'POST')
    //         {
    //             //form validation
    //             $this->form_validation->set_rules('teacher_name', 'trim|required');
    //             $this->form_validation->set_rules('grade', 'grade', 'trim|required');

    //             $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    //             //if the form has passed through the validation

    //             if ($this->form_validation->run())
    //             {
    //                 $teacher_name = $this->input->post('teacher_name');
    //                 $grade = $this->input->post('grade');

                        
                        
    //             } //validation run
    //         }
    //         $data['folder'] = $folder;
    //         $data['teacher_name'] = $teacher_name;
    //         $data['grade'] = $grade;
    //         $data['main_content'] = 'notifications/add_blink';
    //         $this->load->view(TEMPLATE_PATH, $data);

    // }

	public function request_new_teacher() {

        add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

        // Include the JS & CSS file.
        add_js(array('assets/js/plugins/wysihtml5-0.3.0.min.js', 'assets/js/plugins/bootstrap3-wysihtml5.js'));
        add_css(array('assets/css/bootstrap-wysihtml5.css'));
        
        $folder = $this->input->get('folder');
        if ($folder=="") $folder = "inbox";

		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $link_array = explode('/', $actual_link);

		// echo '<pre>'; print_r($link_array); die;
		
        // $t_name = str_replace('_', ' ', $link_array['6']);
		// $teacher_name = $t_name;
		// $name = str_replace('_', ' ', $link_array['7']);
		// $grade = $name;

		$teacher_name = base64_decode($link_array['6']);
		$grade = base64_decode($link_array['7']);

		$data['folder'] = $folder;
		$data['teacher_name'] = $teacher_name;
		$data['grade'] = $grade;
		$data['main_content'] = 'notifications/add_blink';
		$this->load->view(TEMPLATE_PATH, $data);

    }

	// public function add_blink() {

    //     // Permission Checking
    //     //parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    //     // Include the Module JS file.
    //     add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

    //     // Include the JS & CSS file.
    //     add_js(array('assets/js/plugins/wysihtml5-0.3.0.min.js', 'assets/js/plugins/bootstrap3-wysihtml5.js'));
    //     add_css(array('assets/css/bootstrap-wysihtml5.css'));
        
    //     $folder = $this->input->get('folder');
    //     if ($folder=="") $folder = "inbox";
        
    //     //if save button was clicked, get the data sent via post
    //     if ($this->input->server('REQUEST_METHOD') === 'POST')
    //     {
    //         //form validation
    //         $this->form_validation->set_rules('type', 'Type', 'trim|required');
    //         $this->form_validation->set_rules('users[]', 'Recipient users', 'trim|required');
    //         $this->form_validation->set_rules('description', 'Message', 'trim|required');
    //         $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
    //         $this->form_validation->set_rules('teacher_name', 'trim|required');

    //         $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    //         //if the form has passed through the validation

    //         if ($this->form_validation->run())
    //         {
    //             $users = $this->input->post('users');
    //             $type = htmlspecialchars($this->input->post('type'), ENT_QUOTES, 'utf-8');
    //             $email = htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8');
    //             $subject = htmlspecialchars($this->input->post('subject'), ENT_QUOTES, 'utf-8');
    //             $description = $this->input->post('description');
    //             $teacher_name = $this->input->post('teacher_name');
    //             $grade = $this->input->post('grade');

    //             $send_users = array();
	// 			if ($type == "admin") {
	// 				$full_users = $this->Notify_model->get_users_list(array('role_token' => 'administrator'));
	// 			} else if ($type == "presenter") {
	// 				$full_users = $this->Notify_model->get_users_list(array('role_token' => 'teacher'));
	// 			} else if ($type == "school") {
	// 				$full_users = $this->Notify_model->get_users_list(array('role_token' => 'school_admin'));
	// 			} else {
	// 				$full_users = array();
	// 			}

	// 			foreach ($full_users as $key => $user) {
	// 				if(in_array($user->id, $users)){
	// 					$send_users[] = array(
	// 						'id' => $user->id,
	// 						'name' => $user->first_name." ".$user->last_name,
	// 						'email' => $user->email
	// 					);
	// 				}
	// 			}
			
			
	// 			$notify = array(
	// 				'type' => $type,
	// 				'category' => $folder,
	// 				'subject' => $subject,
	// 				'description' => $description,
	// 				'teacher_name' => $teacher_name,
	// 				'grade' => $grade,
	// 				'created_by' => $this->session->userdata('id'),
	// 				'created_on' => date('Y-m-d H:i:s')
	// 			);
	// 			// echo "<pre>"; print_r($notify); die;
	// 			//if the insert has returned true then we show the flash message
	// 			if ($notification_id = $this->Notify_model->insert($this->tablename, $notify)) {
	// 				foreach ($send_users as $key => $user) {

	// 					if ($user['id'] <> "") {
	// 						$data = array(
	// 							'user_id' => $user['id'],
	// 							'notification_id' => $notification_id
	// 						);
	// 						$this->Notify_model->insert('notification_users', $data);
	// 					}
	// 				}
					
	// 				$this->session->set_flashdata('message_type', 'success');
	// 				$this->session->set_flashdata('message', '<strong>Well done!</strong> Notification successfully sent. ');
	// 			}else{
	// 				$this->session->set_flashdata('message_type', 'danger');
	// 				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
	// 			}
	// 			redirect('/app/notifications');
	// 		} //validation run
	// 	}
	
	// 	$data['folder'] = $folder;
	// 	$data['page'] = 'notifications';
	// 	$data['page_title'] = SITE_NAME.' :: Manage Notifications &raquo; Send Notification';

	// 	$data['main_content'] = 'notifications/add_blink';
	// 	$this->load->view(TEMPLATE_PATH, $data);
	// }

	public function add_blink() {

        // Permission Checking
        //parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        // Include the Module JS file.
        add_js('assets/modules/'.$this->router->fetch_module().'/js/Notification.js');

        // Include the JS & CSS file.
        add_js(array('assets/js/plugins/wysihtml5-0.3.0.min.js', 'assets/js/plugins/bootstrap3-wysihtml5.js'));
        add_css(array('assets/css/bootstrap-wysihtml5.css'));
        
        $folder = $this->input->get('folder');
        if ($folder=="") $folder = "inbox";
        
		$teacher_name = $this->input->post('teacher_name');
		$grade = $this->input->post('grade');


        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            // if ($folder <> "announcement") {
                $this->form_validation->set_rules('type', 'Type', 'trim|required');
            // }
            $this->form_validation->set_rules('users[]', 'Recipient users', 'trim|required');
            $this->form_validation->set_rules('description', 'Message', 'trim|required');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $this->form_validation->set_rules('teacher_name', 'trim|required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
            //if the form has passed through the validation

            if ($this->form_validation->run())
            {
                $users = $this->input->post('users');
                $type = htmlspecialchars($this->input->post('type'), ENT_QUOTES, 'utf-8');
                $email = htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8');
                $subject = htmlspecialchars($this->input->post('subject'), ENT_QUOTES, 'utf-8');
                $description = $this->input->post('description');
                $teacher_name = $this->input->post('teacher_name');
                $grade = $this->input->post('grade');

                $send_users = array();
				if ($type == "admin") {
					$full_users = $this->Notify_model->get_users_list(array('role_token' => 'administrator'));
				} else if ($type == "presenter") {
					$full_users = $this->Notify_model->get_users_list(array('role_token' => 'teacher'));
				} else if ($type == "school") {
					$full_users = $this->Notify_model->get_users_list(array('role_token' => 'school_admin'));
				} else {
					//$full_users = $this->Notify_model->get_teacher_list(array());
					$full_users = array();
				}

				foreach ($full_users as $key => $user) {
					if(in_array($user->id, $users)){
						$send_users[] = array(
							'id' => $user->id,
							'name' => $user->first_name." ".$user->last_name,
							'email' => $user->email
						);
					}
				}
			
			
				$notify = array(
					'type' => $type,
					'category' => $folder,
					'subject' => $subject,
					'description' => $description,
					'teacher_name' => $teacher_name,
					'grade' => $grade,
					'created_by' => $this->session->userdata('id'),
					'created_on' => date('Y-m-d H:i:s')
				);
				// echo "<pre>"; print_r($notify); die;
				//if the insert has returned true then we show the flash message
				if ($notification_id = $this->Notify_model->insert($this->tablename, $notify)) {

					//$this->load->library('mail_template');

					foreach ($send_users as $key => $user) {

						if ($user['id'] <> "") {
							$data = array(
								'user_id' => $user['id'],
								'notification_id' => $notification_id
							);
							$this->Notify_model->insert('notification_users', $data);
							
							// Send Email to users
							//$this->mail_template->email_to_user($user['email'], $user['name'], $subject, $description);
						}

					}
					
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('message', '<strong>Well done!</strong> Notification successfully sent. ');
				}else{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
				}
				redirect('/app/notifications');
			}else{ //validation run
				$this->session->set_flashdata('message_type', 'danger');
				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
				// app/notifications/request_new_teacher/gyg/fy
				// redirect('/app/notifications/add_blink/'.$teacher_name.'/'.$grade);
			}
		}
	
		$data['teacher_name'] = $teacher_name;
		$data['grade'] = $grade;
		$data['folder'] = $folder;
		$data['page'] = 'notifications';
		$data['page_title'] = SITE_NAME.' :: Manage Notifications &raquo; Send Notification';

		$data['main_content'] = 'notifications/add_blink';
		$this->load->view(TEMPLATE_PATH, $data);
	}

	public function redirect_to_scheduling(){
		if($this->session->userdata('scheduling_link_for_cancel') != ''){
			$scheduling = $this->session->userdata('scheduling_link_for_cancel');
			redirect($scheduling);
		}else{
			redirect('app/notifications/');
		}
	}

	public function add_blink_direct(){

        $folder = $this->input->get('folder');
        if ($folder=="") $folder = "inbox";
        // echo 'hii';
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
  
            if ($this->form_validation->run())
            {
                $users = array(5,6);
                $description = $this->input->post('description');
                $type = htmlspecialchars($this->input->post('type'), ENT_QUOTES, 'utf-8');
                // print_r($type);die;

                // print($message);die;
  
                if ($type == "admin") {
                    $full_users = $this->Notify_model->get_users_list(array('role_token' => 'administrator'));
                }  else {
                    //$full_users = $this->Notify_model->get_teacher_list(array());
                    $full_users = array();
                }
                // echo '<pre>'; print_r($full_users) ; die;

                foreach ($full_users as $key => $user) {
                    if(in_array($user->id, $users)){
                        $send_users[] = array(
                            'id' => $user->id,
                            'name' => $user->first_name." ".$user->last_name,
                            'email' => $user->email
                        );
                    }
                }

                $data = array(
                    // 'description' => $description,
                    // 'created_by' => $this->session->userdata('id'),
                    // 'created_on' => date('Y-m-d H:i:s')
                    'type' => $type,
                    'category' => $folder,
                    'description' => $description,
                    'created_by' => $this->session->userdata('id'),
                    'created_on' => date('Y-m-d H:i:s')
                );

                if ($insert_id =$this->Notify_model->insert('notifications', $data)){
  
                    foreach ($send_users as $key => $user) {

                        if ($user['id'] <> "") {
                            $data = array(
                                'user_id' => $user['id'],
                                'notification_id' => $insert_id
                            );
                            $this->Notify_model->insert('notification_users', $data);
                            
                            // Send Email to users
                            //$this->mail_template->email_to_user($user['email'], $user['name'], $subject, $description);
                        }

                    }
  
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> Notification successfully sent.');
                    redirect('/app/notifications');
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                    redirect('/app/notifications');
                }
            }else{ //validation run
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                redirect('/app/notifications');
            }
        }

    }

}
