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
		$this->load->model('Reports_storage_model');
    }

	public function index() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

	    $filter = array();
		$default_uri = array('status', 'page' ,'presenter' , 'company');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);
        $pegination_uri = array();

		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

        if ($uri['company'] <> "" && $uri['company'] <> "~") {
            $filter['company'] = $uri['company'];
            $pegination_uri['company'] = $uri['company'];
        } else {
            $filter['company'] = "";
            $pegination_uri['company'] = "~";
        }
        
        if ($uri['presenter'] <> "" && $uri['presenter'] <> "~") {
            $filter['presenter'] = $uri['presenter'];
            $pegination_uri['presenter'] = $uri['presenter'];
        } else {
            $filter['presenter'] = "";
            $pegination_uri['presenter'] = "~";
        }

		$filter['deleted'] = 0;
		$filter['role_token'] = $this->role_token;

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_users_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/presenters/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;
        $data['filter'] = $filter;

	    // Get the Users List
	    $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');
        $data['search'] =$this->Admin_model->get_users_list_search();

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
            if(isset($_FILES['rate_file']) && $_FILES['rate_file']['name'] != ''){
                $this->form_validation->set_rules('rate_file', 'Rate file', 'callback_check_file');
            }
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

                        redirect('/app/presenters/add');
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

                    // ======== Start Code By Ahmed on 2019-09-21 ======= //
                    // Send notification on Site admin
                    $msg = "<p><b>Name:</b> ".$data['first_name']."<br/><b>Email:</b> ".$data['email']."<br/><b>Contact No.:</b> ".$meta['phone']."<br/><b>Hourly Rate:</b> $".number_format($meta['rate'], 2)."<br/><b>Company Name:</b> ".$meta['company_name']."<br/><b>Address:</b> ".$meta['address']."</p>";

					$emails = array('brienzaportalstaging@gmail.com','fraidy@thekgroupny.com');
					// $emails = array('ereinertsen@brienzas.com','dmaddaloni@brienzas.com','agangi@brienzas.com ');
					$this->mail_template->notification_email(null, $emails, $msg, 'Presenter');
                    // $this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, 'Presenter');
                    // ======== End of the Code 2019-09-21 ====== //

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter has been added successfully.');
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

			$this->form_validation->set_rules('email', 'Email address', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		//$this->form_validation->set_rules('meta[info]', 'Info', 'trim|required');
	    	$this->form_validation->set_rules('meta[rate]', 'Rate', 'trim|required|numeric');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{

				$teacher  = $this->Admin_model->get_user_details($id);

				if($teacher->email == $this->input->post('email')){
					// update without mail
					$emailFlag = 1; 
				}else{
					// if($this->form_validation->set_rules('email', 'Email address', 'trim|required|is_unique[users.email]')){
					// 	$emailFlag = 2;
					// }else{
					// 	$emailFlag = 3;
					// }
					// check for duplicate email
					$isExistsEmail = $this->Admin_model->get_duplicate_mail($this->input->post('email'));
					if($isExistsEmail){
						// dont update
						$emailFlag = 2; 
						$this->session->set_flashdata('message_type', 'danger');
    					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Email already exists.');
						redirect('/app/presenters/edit/'.$id);
					}else{
						// update with mail
						$emailFlag = 3; 
					}
				}

				if($emailFlag == 1){
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
	
							redirect('/app/presenters/edit/'.$id);
						} else {
							$upload_data =  $this->upload->data();
							$meta['rate_file'] = $upload_data['file_name'];
						}
					}
	
					 //if the insert has returned true then we show the flash message
					if($this->Admin_model->update($this->tablename, 'id', $id, $data)){
	
						// Insert the Mata Data
						$this->Admin_model->replace_user_meta($id, $meta);
	
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully updated.');
					}else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}
				}else if($emailFlag == 3){
					$data = array(
						'first_name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
						'role_id' => $this->role,
						'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
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
	
							redirect('/app/presenters/edit/'.$id);
						} else {
							$upload_data =  $this->upload->data();
							$meta['rate_file'] = $upload_data['file_name'];
						}
					}
	
					 //if the insert has returned true then we show the flash message
					if($this->Admin_model->update($this->tablename, 'id', $id, $data)){
	
						// Insert the Mata Data
						$this->Admin_model->replace_user_meta($id, $meta);

						// send mail to new mail
						// Send Email to new users
						$this->load->library('mail_template');
						// $this->mail_template->register_teacher_email($data['first_name'], $data['email'], $user_id);

						// ======== Start Code By Ahmed on 2019-09-21 ======= //
						// Send notification on Site admin
				


						// $email = 'bm.avalgate@gmail.com';
						$this->mail_template->notification_email_usernameChanged($data['first_name'], $data['email']);
						// $this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, 'Presenter');
	
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully updated.');
					}else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}
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
		    		'status' => ($operation == "active")?'active':'inactive',
                    'updated_on' => date('Y-m-d H:i:s'),
		    	);

    			foreach ($items as $id=>$value) {

					if ($operation == 'delete') {

						$data_to_store = array(
				    		'is_deleted' => 1,
                            'updated_on' => date('Y-m-d H:i:s'),
				    	);
    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "active")?'active':'inactive',
                            'updated_on' => date('Y-m-d H:i:s'),
				    	);
    				}

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' presenter(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		
            $url= $_SERVER['HTTP_REFERER']; 
            $url2=explode('/',$url);
            if(isset($url2[9]))
            $page=$url2[9];
            if(isset($page))
            {
                redirect('app/presenters/index/status/0/page/'.$page);
            }else{
                redirect($this->url);
            }
    		//redirect('/app/presenters');
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
    public function check_file() {
        $file_name = $_FILES['rate_file']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if(!in_array($ext, array('png', 'jpg', 'jpeg', 'pdf'))){
            $this->form_validation->set_message('check_file', 'The filetype you are attempting to upload is not allowed');
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
	
	
	public function order($billing='') {
		
		$filter = array(
			'deleted' => 0,
			'presenter' => $this->session->userdata('id'),
			'status' => 'approved'
		);
		
		$pre_session = $this->input->get('pre_session_id');
		if(isset($pre_session)){
			$filter['presenter_session'] = $pre_session;
		}else{
			$curr_date = date("Y-m-d h:i:s");
			$curr_session_id = $this->App_model->get_curr_session_id($curr_date);
			$filter['presenter_session'] = $curr_session_id;
		}
		
		if($billing!='' && $billing=='billing'){
			$filter['billing_date'] = date("Y-m-d");
			$data['billing'] = true;
		}else{
			$data['billing'] = false;
		}

		$orders = $this->App_model->get_order_list($filter, 'created_on', 'desc');
        foreach ($orders as $item) {
            $item->complete_by = $this->App_model->getorder_billing_date($item->id);
            $item->belling_period = $this->App_model->getorder_billing_period($item->id);
            $item->confirm_hours = $this->App_model->get_confirm_hours($item->id);
			$item->c_hours = $this->App_model->get_confirm_hours_by_odrId_preId($item->id,$this->session->userdata('id'));
        }
		//session from table
		$data['s_array'] = $this->App_model->get_sessions();
		$data['presenter_session_id'] = $filter['presenter_session'];
		$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($filter['presenter_session'], $this->session->userdata('id'));
		$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($filter['presenter_session'], $this->session->userdata('id'));

		$data['orders'] = $orders;
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Orders';

		//print "<pre>"; print_r($data); die;
    	$data['main_content'] = 'presenters/orders';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	
	public function billing_pre() {

        $order_id = $this->input->get('order_id');

        if(!$order_id) {
            redirect('/app/presenters/order/billing');
        }
        
        // Redirect to Order > Billing
        redirect('app/orders/billing/?order_id='.$order_id);
        
    }
	public function scheduling_old() {
		
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
	
	/**
	Replicaion of method scheduling
	has been done to implement the new 
	logic of scheduling 
	Created by: Soumya
	Created on: 30-06-2019
	**/
	public function scheduling() 
	{
		$school_id 		= $this->input->get('school_id');
		$order_id 		= $this->input->get('order_id');
		$topic_id 		= $this->input->get('topic_id');
		$presenter_id 	= $this->session->userdata('id');

		if ($order_id) 
		{
            // Get the types
			$data['types'] = $this->App_model->get_worktype_list(array('deleted'=>0, 'status'=>'active')); 
            // Get order details
			if($this->session->userdata('role') == 'teacher')
            {
				$data['order']  = $this->App_model->get_order_details_specific($order_id,$presenter_id); 
            }else{
				$data['order']  = $this->App_model->get_order_details($order_id); 
            }
			$data['presenter_hours'] = $this->App_model->presenter_total_hours($order_id,$presenter_id);
            // Get the Topics
			//$data['topics'] = $this->App_model->get_title_topics($data['order']->title_id); 
			// Get the Topics which are only selected in the topic window.
            $data['topics'] = $this->App_model->get_selected_topics($data['order']->title_id, $order_id);

			if($order_id != ''){
                $title_id = $this->App_model->get_title_id($order_id);
                if($this->session->userdata('role') == 'teacher'){
                    $data['teacher_grades']=$this->App_model->get_teacher_grades_title($school_id,$title_id);
                }else{
                    $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);
                }
            }else{
                $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);
            }

			// $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);


			$data['selected_order'] = $order_id;

			$schedulable_hr			= $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
			$scheduled_hr			= $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

			if($schedulable_hr)
				$data['schedulable_hr']	= $schedulable_hr;
			else
				$data['schedulable_hr']	= 0;

			if($scheduled_hr)			
				$data['scheduled_hr']	= $scheduled_hr;
			else
				$data['scheduled_hr']	= 0;

            if($this->session->userdata('role') == 'teacher'){
                // Get the existing schedule
    			$data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");
            }else{
                // Get the existing schedule
                $data['schedules'] = $this->App_model->get_order_schedule($order_id, NULL, "order_schedules.id");
            } 

			//$remaining_schedule_hrs = $data['order']->hours - $data['order']->total_hours_scheduled;

			$remaining_schedule_hrs 		= $data['schedulable_hr'] - $data['scheduled_hr'];
			$data['remaining_schedule_hrs'] = $remaining_schedule_hrs;
            
            $data['grades'] = $this->App_model->get_assign_presenter_grade($order_id, $this->session->userdata('id'));

			//validation for session
			$session_id = $this->App_model->getSessionIdByOdrId($order_id);
			$dates = $this->App_model->get_session_dates_by_id($session_id);
			$s_date = explode(" ", $dates->start_date); 
			$e_date = explode(" ", $dates->end_date); 
			$data['startDate'] = $s_date[0];
			$data['endDate'] = $e_date[0];
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{

			$this->form_validation->set_rules('date', 'Date', 'trim|required');
	    	$this->form_validation->set_rules('start_time', 'Start time', 'trim|required');
			$this->form_validation->set_rules('end_time', 'End time', 'trim|required');
			// $this->form_validation->set_rules('topics', 'Topic', 'trim|required|numeric');
			$this->form_validation->set_rules('topics', 'Topic', 'trim|required'); // added
			$this->form_validation->set_rules('types', 'Type', 'trim|required|numeric');
			// $this->form_validation->set_rules('grades', 'Grade', 'trim|required|numeric');
			$this->form_validation->set_rules('grades', 'Grade', 'trim|required');
			$this->form_validation->set_rules('teachers', 'Teacher', 'trim|required');
			$this->form_validation->set_rules('total_hours', 'Total hours', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		// if the form has passed through the validation
     		if ($this->form_validation->run())
     		{

				if ($remaining_schedule_hrs <  $this->input->post('total_hours')) {
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is greater than remaining hours.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
				}

				$date 		= htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
				$start_time = htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
				$end_time 	= htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
				
				$start_ts 	= new DateTime($date." ".$start_time);
				$start_date = $start_ts->format('Y-m-d H:i:s');

				$end_ts 	= new DateTime($date." ".$end_time);
				$end_date 	= $end_ts->format('Y-m-d H:i:s');

				$myDateArray = explode(' ', $date);
				$m = $myDateArray[1]."-".$myDateArray[3];
				$number_month = date("m", strtotime($m));
				$myDayArray = explode(',', $myDateArray[2]);
				$fdate = $myDateArray[3]."-".$number_month."-".$myDayArray[0];
				$checkDateIfExitsSubmittedInvoice = $this->App_model->check_date_if_exits_submitted_invoice($fdate,$presenter_id,$order_id);
				if($checkDateIfExitsSubmittedInvoice == true){
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> The selected date of range is already submitted the invoice for this scheduled period.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
				}

				$checkSchedule = $this->App_model->check_schedule_datetime($this->session->userdata('id'), $start_date, $end_date);
		
 				if(!empty($checkSchedule)){
					
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is already booked.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
 				}

 				// ===== Start code by Ahmed on 2019-08-07 ====== //
				$diff30Min = $this->App_model->check_schedule_30min_diff($this->session->userdata('id'), $start_date, $end_date);
				//print_r($diff30Min);die;
 				if(!empty($diff30Min)){
					
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please 30 mins gap between two schedule.');
	    			redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
 				}
 				// ======= End Code ====== //

				if(!empty($data['topics'])){
                    $topicId = $this->input->post('topics');
                }else{
                    $topicString = $this->input->post('topics');
                    $topicId = $this->App_model->check_topic_string($topicString,$data['order']->title_id);
                    $inserdata['order_id']=$order_id;
                    $this->App_model->insert('order_topics', $inserdata);
                }
                // echo $topicString; echo "  "; die();

				//for inputting grade as string/number
                if(!empty($data['teacher_grades'])){
                    $gradeId = $this->input->post('grades');
                }else{
                    //insert in grades field
                    $gradesString = $this->input->post('grades');
                    $gradeId = $this->App_model->check_grade_string($gradesString,$this->session->userdata('id'));
                    // insert in teachers field
                    $insertdata['school_id'] = $school_id;
                    $insertdata['title_id'] = $data['order']->title_id;
                    $insertdata['grade_id'] = $gradeId;
                    $insertdata['created_by'] = $this->session->userdata('id');
					$insertdata['name'] = htmlspecialchars($this->input->post('teachers'), ENT_QUOTES, 'utf-8');
                    $this->App_model->insert('teachers', $insertdata);
					$updateTitles['grade_teachers'] = '1';
                    $this->App_model->update('titles', 'id', $data['order']->title_id, $updateTitles);

                }
 				
     			$data = array(
					'order_id' => $order_id,
					'start_date' => $start_date,
    				'end_date' => $end_date,
					// 'topic_id' => $this->input->post('topics'),
					'topic_id' => $topicId,
					'type_id' => $this->input->post('types'),
					// 'grade_id' => $this->input->post('grades'),
					'grade_id' => $gradeId,
					'teacher' => htmlspecialchars($this->input->post('teachers'), ENT_QUOTES, 'utf-8'),
					'total_hours' => htmlspecialchars($this->input->post('total_hours'), ENT_QUOTES, 'utf-8'),
     				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);
				
				if ($schedule_id = $this->App_model->insert('order_schedules', $data)) {
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule has been added successfully.');
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

	    //$data['schools'] = $this->App_model->get_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));
		//getting all school by presenter only in presenter portal.
        if($this->session->userdata('role') == 'teacher'){
            $data['schools'] = $this->App_model->get_all_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));
        }else{
            $data['schools'] = $this->App_model->get_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));
        }

		if ($school_id) {
			// Get the Orders for drop-down
			$data['purchase_orders'] = $this->App_model->get_order_list(array('deleted' => 0, 'school' => $school_id, 'presenter' =>  $this->session->userdata('id'), 'status' => 'approved'), 'created_on', 'desc');
			
			// Get the Grade list
			// $data['grades'] = $this->App_model->get_teacher_list(array('deleted' => 0, 'school_id' => $school_id, 'status' => 'active'), 'created_on', 'desc');
			$data['selected_school'] = $school_id;
		}
		
		
		if ($topic_id) {
			$data['selected_topic'] = $topic_id;
		}
        //$data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);
		//added 29-09-2021
        // if($order_id != ''){
        //     $title_id = $this->App_model->get_title_id($order_id);
        //     if($this->session->userdata('role') == 'teacher'){
        //         $data['teacher_grades']=$this->App_model->get_teacher_grades_title($school_id,$title_id);
        //     }else{
        //         $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);
        //     }
        // }else{
        //     $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);
        // }	
		
		
		
		 //print "<pre>"; print_r($data['schedules']); print "</pre>";
		$data['order_id'] = $order_id;		 
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Scheduling';
		
    	$data['main_content'] = 'presenters/scheduling';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	## --- End of the code --- ##	

    public function get_grades()
    {
        $grade_id=$this->input->post('grade_id');
        $school_id=$this->input->post('school_id');
       

     
        $teacher=$this->App_model->get_teacher($grade_id,$school_id);
		// $order_id=$this->input->post('order_id');
        // // echo $order_id;
        // // die();
        // if($order_id != ''){
        //     $title_id = $this->App_model->get_title_id($order_id);
        //     if($this->session->userdata('role') == 'teacher'){
        //         $teacher=$this->App_model->get_teacher_by_title($grade_id,$school_id,$title_id);
        //     }else{
        //         $teacher=$this->App_model->get_teacher($grade_id,$school_id);
        //     }
        // }else{
        //     $teacher=$this->App_model->get_teacher($grade_id,$school_id);
        // }
        //echo "<pre>";print_r($teacher);die;
        if(count($teacher) > 1)
        {
             $opt = '<option value="">Select </option>';
                 foreach($teacher as $val)
                 {

                    if($val->teacher_name!=''){
                    $opt .= '<option value="'.$val->teacher_name.'">'.$val->teacher_name.'</option>';
                    }
                 }
          
             echo json_encode(array('msg'=>'multiple','opt' =>$opt));exit;
        }else{

            $opt = '';
                 foreach($teacher as $val)
                 {
                    $opt = $val->teacher_name;
                 }
             echo json_encode(array('msg'=>'single','opt' =>$opt));exit;

        }
		// $opt = '';
        // $opt = $teacher[0]->teacher_name;
        // echo json_encode(array('msg'=>'single','opt' =>$opt));exit;

       
    }

    public function get_grade_teacher()
        {
            $grade_id=$this->input->post('grade_id');
            $school_id=$this->input->post('school_id');
            $order_id=$this->input->post('order_id');
            $tid=$this->input->post('tid');

        // echo "<pre>";print_r($_POST);die;
     
        $teacher=$this->App_model->get_teacher($grade_id,$school_id);
        
        if(count($teacher) > 1)
        {
             $opt = '<option value="">Select </option>';
             // echo "<pre>";print_r($teacher);die;
                 foreach($teacher as $val)
                 {

                    $b=$this->App_model->get_teacher_order($tid);
                  // echo "<pre>";print_r($b);print_r($val);die;
                    $selected = (!empty($b) && $b->teacher == $val->teacher_name) ? 'selected' : '';
                    
                  
                        $opt .= '<option value="'.$val->teacher_name.'" '.$selected.'>'.$val->teacher_name.'</option>';
                        // $opt .= '<option value="'.$val->teacher_name.'">'.$val->teacher_name.'</option>';
                       
                 }
                //die;
          
             echo json_encode(array('msg'=>'multiple','opt' =>$opt));exit;
        }else{


            $opt = '';
                 foreach($teacher as $val)
                 {
                    $opt = $val->teacher_name;
                 }
             echo json_encode(array('msg'=>'single','opt' =>$opt));exit;

        }
       
    }
	
	// New function created by Ahmed on 2019-07-26
	public function update_scheduling() 
	{
		$school_id 		= $this->input->post('school_id');
		$order_id 		= $this->input->post('order_id');
		$schedule_id 	= $this->input->post('order_schedule_id');
		$topic_id 		= $this->input->post('topics');
		$type_id		= $this->input->post('types');
		$grade_id		= $this->input->post('grades');
		$date 			= htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
		$start_time 	= htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
		$end_time 		= htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
		$teacher 		= $this->input->post('teachers');
        $teacher1        = $this->input->post('teachers1');
		$total_hours 	= $this->input->post('total_hours');
		$presenter_id 	= $this->session->userdata('id');
      
         if($this->input->post('teachers') != '')
        {
            $teacherName  = $this->input->post('teachers');

        }elseif($this->input->post('teachers1') != ''){
            $teacherName  = $this->input->post('teachers1');
        }else{
            $teacherName  = '';
        }

		$err = "";
        if($start_time == ""){
        	$err .= "Start time field is required.<br/>";
        }
        if($end_time == ""){
        	$err .= "End time field is required.<br/>";
        }
        if($topic_id == ""){
        	$err .= "Topics field is required.<br/>";
        }
        if($type_id == ""){
        	$err .= "Types field is required.<br/>";
        }
        if($grade_id == ""){
        	$err .= "Grade field is required.<br/>";
        }
        if($teacherName == ""){
            $err .= "Teachers field is required.<br/>";
        }
        if($total_hours == ""){
        	$err .= "Total hours field is required.<br/>";
        }

        if($err != ""){
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> '.$err);
			echo json_encode(array('success' => false));exit;
        }

		$scheduleData = $this->App_model->get_order_schedule_details($schedule_id);

		$scheduled_hour = (int) $scheduleData->total_hours;

		if(empty($scheduleData)){
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Something went to wrong please try again.');
	    	//redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
			echo json_encode(array('success' => false));exit;
		}

		$data['order'] 			= $this->App_model->get_order_details($order_id); // Get order details
		$data['topics'] 		= $this->App_model->get_title_topics($data['order']->title_id); // Get the Topics
		$data['selected_order'] = $order_id;

		$schedulable_hr			= $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
		$scheduled_hr			= $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

		if($schedulable_hr)
			$data['schedulable_hr']	= $schedulable_hr;
		else
			$data['schedulable_hr']	= 0;

		if($scheduled_hr)			
			$data['scheduled_hr']	= $scheduled_hr;
		else
			$data['scheduled_hr']	= 0;

		$remaining_schedule_hrs = $data['schedulable_hr'] - $data['scheduled_hr'];


		if($scheduled_hour <> $this->input->post('total_hours')){

			$scheduleHour = abs($this->input->post('total_hours') - $scheduled_hour);

			if ($remaining_schedule_hrs <  $scheduleHour) {
				$this->session->set_flashdata('message_type', 'danger');
				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is greater than remaining hours.');
				//redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
				echo json_encode(array('success' => false));exit;
			}
		}

		$start_ts 	= new DateTime($date." ".$start_time);
		$start_date = $start_ts->format('Y-m-d H:i:s');

		$end_ts 	= new DateTime($date." ".$end_time);
		$end_date 	= $end_ts->format('Y-m-d H:i:s');

		$checkSchedule = $this->App_model->check_exist_schedule_datetime($this->session->userdata('id'), $start_date, $end_date, $schedule_id);

		if(!empty($checkSchedule)){
			
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Schedule hours is already booked.');
			//redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
			echo json_encode(array('success' => false));exit;
		}
        // ===== Start code by Ahmed on 2019-08-07 ====== //
        $diff30Min = $this->App_model->check_schedule_30min_diff($this->session->userdata('id'), $start_date, $end_date);
        //print_r($diff30Min);die;
        if(!empty($diff30Min)){
            
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please 30 mins gap between two schedule.');
           echo json_encode(array('success' => false));exit;
        }
        // ======= End Code ====== //
		$data = array(
			'start_date' => $start_date,
			'end_date' => $end_date,
			'topic_id' => $this->input->post('topics'),
			'type_id' => $this->input->post('types'),
			'grade_id' => $this->input->post('grades'),
			'teacher' => $teacherName,
			'total_hours' => htmlspecialchars($this->input->post('total_hours'), ENT_QUOTES, 'utf-8'),
		);
		
		if ($schedule_id = $this->App_model->update('order_schedules', 'id', $schedule_id, $data)) {
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule has been updated successfully.');
			echo json_encode(array('success' => true));exit;
			
		} else {
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
			echo json_encode(array('success' => false));exit;
			
		}

	}
	// ===== End of the code ===== //
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
				'cal_cell_no_content'	=> '<a href="#" onclick="inputCalendarDate(\'{year}\',\'{month}\',\'{day}\','.$order_id.','.$order->school_id.');">{day}</a>',
			),
			'holidays'				=> $data['holidays'],
		);
		
		
		$this->load->library('my_calendar', $prefs);
		$data['calendar'] = $this->my_calendar->generate($this->uri->segment(4), $this->uri->segment(5));
		
    	$this->load->view('presenters/show_calendar', $data);
	}
	
	public function calendar() {
		if($this->uri->segment(4) !='' && $this->uri->segment(5) !=''){
			$curr_date = $this->uri->segment(4).'-'.$this->uri->segment(5).'-01';
		}else{
			$curr_date = date("Y-m-d");
		}
		if(isset($_SESSION["sessionIdFilterPre"])){
			$data['curr_session_id'] = $_SESSION["sessionIdFilterPre"];
		}else{
			$data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		}
		// $data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($data['curr_session_id'], $this->session->userdata('id'));
		$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($data['curr_session_id'], $this->session->userdata('id'));
		$session = $this->App_model->get_session_dates_by_id($data['curr_session_id']);
		if($session->start_date){
			
			$data['start_date'] = $session->start_date;
			$data['end_date'] = $session->end_date;

		}else{
		
			$data['start_date'] = '2017-01-01';
			$data['end_date'] = '2050-12-31';
			
		}
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Calendar';
		
		// Get the existing schedule
		// $schedules = $this->App_model->get_order_schedule(null, $this->session->userdata('id'));
		$schedules = $this->App_model->get_order_schedule_session(null, $this->session->userdata('id'),null, $data['curr_session_id']);
		
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
		
		$data['s_array'] = $this->App_model->get_sessions();
		//print "<pre>"; print_r($data); print "</pre>";	
		$this->load->library('my_calendar', $prefs);
		$data['calendar'] = $this->my_calendar->generate($this->uri->segment(4), $this->uri->segment(5), $data['curr_session_id'],$data['start_date'],$data['end_date']);
		
		$data['main_content'] = 'presenters/calendar';
    	$this->load->view(TEMPLATE_PATH, $data);		
	}
	
	public function billing($para = NULL) {
		$data['billing'] = false;
        $presenter_id = $this->session->userdata('id');

        $current_date = date("Y-m-d");
        // getting billing rate of the presenter 
        $billRate = $this->App_model->get_bill_rate($presenter_id);
        // getting order_ids by presenters
        // $ordersByPresenter = $this->App_model->get_orders_by_presenters($presenter_id);
		// code for session wise data
		$session_id = $this->input->get('pre_blng_session_id');
		if(isset($session_id)){
			// getting order_ids by presenters sessionwise
			$ordersByPresenter = $this->App_model->get_orders_by_presenters_sessionwise($presenter_id, $session_id);
			$data['session_id'] = $session_id;
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($session_id,$this->session->userdata('id'));
			// print_r($data['totHoursAssgnd']); die();
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($session_id,$this->session->userdata('id'));
			// print_r($data['totHoursSchedule']); die();
		}else{
			$curr_date = date("Y-m-d h:i:s");
			$curr_session_id = $this->App_model->get_curr_session_id($curr_date);
			// getting order_ids by presenters sessionwise
			$ordersByPresenter = $this->App_model->get_orders_by_presenters_sessionwise($presenter_id, $curr_session_id);
			$data['session_id'] = $curr_session_id;
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($curr_session_id,$this->session->userdata('id'));
			// print_r($data['totHoursAssgnd']); die();
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($curr_session_id,$this->session->userdata('id'));
			// print_r($data['totHoursSchedule']); die();
		}
		
		// end of session
        // echo '<pre>'; print_r($ordersByPresenter); die();
        // forming session dates array
        $orderArray = array();
        $dates = array();
		if(is_array($ordersByPresenter) || is_object($ordersByPresenter)){//added 04-01-2022
			foreach($ordersByPresenter as $row){
				$dates = $this->App_model->get_orderSchedules_by_order_id($row->order_id);
				// echo '<pre>'; print_r($dates); die();
				$orderArray[$row->order_id] = array();
				foreach($dates as $dt){
					// array_push($orderArray[$row->order_id],$dt->date.'-01');
					// array_push($orderArray[$row->order_id],$dt->date.'-16');
					array_push($orderArray[$row->order_id],$dt->date.'-16');
					array_push($orderArray[$row->order_id],$dt->date.'-01');
				}
			}
		}//added 04-01-2022
        // echo '<pre>'; print_r($dates); die();
        // echo '<pre>'; print_r($orderArray); die();
        $finalArray = array();

        foreach($orderArray as $key => $value){

            //approved session by order_id and presenter
            // $approvedStatus = $this->App_model->getApprovedStatus($key, $presenter_id);
            // echo '<pre>'; print_r($approvedStatus); die();
			//echo $key.'<br/>';
            // getting order_no,school_id,school_name,title_name,assigned_hours by order_id and presenter
            $ordDtls =  $this->App_model->get_presenter_orders_details($key,$presenter_id);
            //echo '<pre>'; print_r($ordDtls); 
            
            //echo $created_date; 

            $invoicePath = $this->App_model->get_invoice($key);
            // print_r($invoicePath); die();
            if(isset($invoicePath)){
                $doc = $invoicePath->invoice_document;
            }else{
                $doc = 0;
            }
            $displayArray = array();
            $order_schedules = array();
            foreach($value as $val){
                // echo $val; 
                $flag = date("d", strtotime($val)) == '01' ? 1 : 2;
                // total hours scheduled within session dates
                $scheduleHours = $this->App_model->get_scheduled_hours($key, $presenter_id, $val, $flag);
                // echo $scheduleHours; die();
                // total scheduled hours of presenter
                $totalScheduleHours = $this->App_model->get_total_scheduled_hours($key, $presenter_id);
                // total scheduled hours within session dates whose status is confirm. i.e after scheduling status should be confirm hours or after that.
                $scheduleHoursConfirm = $this->App_model->get_scheduled_hours_confirm($key, $presenter_id, $val, $flag);
                // getting status of orders within the session dates whose status is 'create invoice'.
                $statusCreateInvoice = $this->App_model->get_status_createInvoice($key, $presenter_id, $val, $flag);
                // counting total on of records within session dates.
                $no_of_rows = $this->App_model->no_of_rows($key, $presenter_id, $val, $flag);
                // condition to check if submit invoice button be enable or disable.
                if($statusCreateInvoice == $no_of_rows){
                    $submitInvoiceCounter = 1;
                }else{
                    $submitInvoiceCounter = 0;
                }
				$invoice_createdDate = $this->App_model->get_invoice_created_date($key, $val);
				if(isset($invoice_createdDate)){
					$created_date = $invoice_createdDate->created_date;
				}else{
					$created_date = 0;
				}
				//check invoice submit before 2021-10-25
				$oldrSubInv = $this->App_model->older_submitted_invoice($key, $presenter_id, $val, $flag);
                // getting pshedule_id,session_from,session_to,billing_date,payment_date,invoice_no,email_remonder_date,month,year,is_deleted  by checking 'session from' date
                $othersDetails = $this->App_model->get_billing_date($val);
                // echo '<pre>'; print_r($othersDetails); die();
                //payement schedule is set or not. 
                // if(isset($othersDetails)){
                //     $paymentScheduleFlag = 1;
                // }else{
                //     $paymentScheduleFlag = 0;
                // }

				if(isset($othersDetails)){
                    if($othersDetails->billing_date != '0000-00-00'){
                        $paymentScheduleFlag = 1;
                    }else{
                        $paymentScheduleFlag = 0;
                    }
                }else{
                    $paymentScheduleFlag = 0;
                }

                $dateArray = explode("-", $val);
                $year = $dateArray[0];
                $month = $dateArray[1];
                // echo '<pre>'; print_r($dateArray); die();
                $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                $billing_period_s = date("m/d/y", strtotime($val));
                if($flag == 1){
                    $billing_period_e = date("m/d/y", strtotime($val. ' + 14 days'));
                    $daysToAdd = '14';
                }else if($days == 31){
                    $billing_period_e = date("m/d/y", strtotime($val. ' + 15 days'));
                    $daysToAdd = '15';
                }else if($days == 29){
                    $billing_period_e = date("m/d/y", strtotime($val. ' + 13 days'));
                    $daysToAdd = '13';
                }else if($days == 28){
                    $billing_period_e = date("m/d/y", strtotime($val. ' + 12 days'));
                    $daysToAdd = '12';
                }else{
                    $billing_period_e = date("m/d/y", strtotime($val. ' + 14 days'));
                    $daysToAdd = '14';
                }
                // calculation for session period //$val->session from date
                $endDate = strtotime("+".$daysToAdd." days", strtotime($val));
                $sessionEndDate = date("Y-m-d", $endDate);

                $session_to = $sessionEndDate;
                if($session_to < $current_date){
                    if($scheduleHours){
                        
                        $displayArray['order_id'] = $key;
                        if(isset($ordDtls)){
                            $displayArray['school'] = $ordDtls->school_name;
                            $displayArray['title'] = $ordDtls->title_name;
                            $displayArray['order_no'] = $ordDtls->order_no;
                            $displayArray['assigned_hours'] = $ordDtls->assigned_hours;
                            $displayArray['school_id'] = $ordDtls->school_id;
                        }else{
                            $displayArray['school'] = 'N/A';
                            $displayArray['title'] = 'N/A';
                            $displayArray['order_no'] = 'N/A';
                            $displayArray['assigned_hours'] = 'N/A';
                            $displayArray['school_id'] = 'N/A';
                        }
                        $displayArray['schedule_hours'] = $scheduleHours;
                        $displayArray['total_schedule_hours'] = $totalScheduleHours;
                        $displayArray['schedule_hours_confirm'] = $scheduleHoursConfirm;
                        $displayArray['submit_invoice_counter'] = $submitInvoiceCounter;
                        $displayArray['bill_rate'] = $billRate;
                        $displayArray['invoice_document'] = $doc;
                        $displayArray['created_date'] = $created_date;
                        $displayArray['billing_period'] = $billing_period_s.' to '.$billing_period_e;
						$displayArray['sessionEndDate'] = $sessionEndDate;
                        $displayArray['bill_period_start_date'] = $val;
                        
                        $displayArray['dwnld_flag'] = $this->App_model->get_download_status($key, $presenter_id, $val, $sessionEndDate);

                        $displayArray['payment_schedule_flag'] = $paymentScheduleFlag;
                        $displayArray['order_schedules'] = $this->App_model->get_order_schedule_with_range($key, $presenter_id, $val, $sessionEndDate, "order_schedules.id");
                            
                        if($othersDetails){
                            $displayArray['session_from'] = $othersDetails->session_from;
                            $displayArray['session_to'] = $othersDetails->session_to;
                            
                            //$displayArray['completed_by'] = date("m/d/y", strtotime($othersDetails->billing_date));

							if($othersDetails->billing_date != '0000-00-00'){
                                $displayArray['completed_by'] = date("m/d/y", strtotime($othersDetails->billing_date));
								$displayArray['completed_by_DateFormat'] = $othersDetails->billing_date;
                            }else{
                                $displayArray['completed_by'] = 'N/A';
                            }
                            //$displayArray['completed_by_original'] = $othersDetails->billing_date;
                            $displayArray['sessionEndDate'] = $othersDetails->session_to;
                            // getting order schedules within session period
                            
                            //flag set for download button.
                            if($displayArray['dwnld_flag']){
                                $displayArray['payment_date'] = $this->App_model->get_payment_date($key, $presenter_id, $displayArray['session_from'], $displayArray['session_to']);
                            }else{
                                $displayArray['payment_date'] = NULL;
                            }

                            //calculation and setting late flag for late tag and message.

							if($othersDetails->billing_date != '0000-00-00'){
                                $completeDateOriginal = $othersDetails->billing_date;
                                $lateFlag = 0;
                                if($created_date == 0){
                                    $current_date = date("Y-m-d");
                                    if($current_date > $completeDateOriginal && $oldrSubInv != 0){
                                        $lateFlag = 1;
                                    }
                                }else if($completeDateOriginal < $created_date){
                                        $lateFlag = 1;
                                }else{
                                    $lateFlag = 0;
                                }
                            }else{
                                $lateFlag = 0;
                            }

                            $displayArray['late_flag'] = $lateFlag;

                            //calculation for payment date msg.
                            if($displayArray['dwnld_flag']){
                                $payDateFlag = 1;
                            }else{
                                $payDateFlag = 0;
                            }

                            $displayArray['payDate_flag'] = $payDateFlag;
							

                        }else{
                            $displayArray['billing_period'] = $billing_period_s.' to '.$billing_period_e;
                            $displayArray['completed_by'] = 'N/A';
                            // $displayArray['session_from'] = 'N/A';
							$displayArray['session_from'] = $val;
                            $displayArray['session_to'] = 'N/A';
                            $displayArray['dwnld_flag'] = 'N/A';
                            $displayArray['late_flag'] = 0;
                            $displayArray['payDate_flag'] = 0;
							$displayArray['sessionEndDate'] = $sessionEndDate;
                        }
                        $finalArray[]=$displayArray;
                        
                    }
                }
            }
        }
		//die();
        // echo '<pre>'; print_r($invoicePath); die();
        //echo '<pre>'; print_r($finalArray); die();
		$dateSort = array();
        foreach ($finalArray as $key => $row)
        {
            $dateSort[$key] = $row['bill_period_start_date'];
            
        }
        array_multisort($dateSort, SORT_DESC, $finalArray);
		//session from table
		$data['s_array'] = $this->App_model->get_sessions();
		$data['rdyInvc'] = $para;
        $data['orders'] = $finalArray;
        $data['page'] = 'presenters';
        $data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Orders';

        //print "<pre>"; print_r($data); die;
        $data['main_content'] = 'presenters/presenter_billing';
        // $data['main_content'] = 'presenters/presenter_billing_design';
        $this->load->view(TEMPLATE_PATH, $data);
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
			$data['principal_name'] = $this->App_model->principal($data['schedule']->school_id);
			
			$data['order'] = array();
			if(!empty($data['schedule'])){
				// Get order details
				$data['order'] = $this->App_model->get_order_details($data['schedule']->order_id);
			}
		}
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Create Log';
		
    	//$data['main_content'] = ;
    	$this->load->view('presenters/create_log', $data);
	}
	
	public function library() {
		
		$data['libraries'] = $this->App_model->get_library_list_des($this->session->userdata('id'));
		
        $data['favourites_topic']= $this->App_model->get_favourites_topic($this->session->userdata('id'));
        
		//print "<pre>"; print_r($data); print "</pre>";		
		$data['page'] = 'library';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Library';
		
    	$data['main_content'] = 'presenters/library';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	public function upload_header(){
		$id = $this->input->post('pId');
		$header_image = $_FILES['headerImg'];
        if(isset($header_image) && $header_image['name'] != ''){
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
	 	}else{
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', 'Something went to wrong, please try again');
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

	public function logs() {

		// Permission Checking
		// parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		$default_uri = array('page, order_no, school, presenter, topic, date');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);
		$pegination_uri =array();

		if (isset($uri['page']) && $uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

    	// Create the filters
	    $filter = array();

		if (isset($uri['order_no']) && $uri['order_no'] <> "" && $uri['order_no'] <> "~") {
    		$filter['order_no'] = $uri['order_no'];
			$pegination_uri['order_no'] = $uri['order_no'];
    	} else {
    		$filter['order_no'] = '';
			$pegination_uri['order_no'] = "~";
    	}
		if (isset($uri['school']) && $uri['school'] <> "" && $uri['school'] <> "~") {
    		$filter['school'] = $uri['school'];
			$pegination_uri['school'] = $uri['school'];
    	} else {
    		$filter['school'] = '';
			$pegination_uri['school'] = "~";
    	}

		if (isset($uri['presenter']) && $uri['presenter'] <> "" && $uri['presenter'] <> "~") {
    		$filter['presenter'] = $uri['presenter'];
			$pegination_uri['presenter'] = $uri['presenter'];
    	} else {
    		$filter['presenter'] = $this->session->userdata('id');
			$pegination_uri['presenter'] = "~";
    	}
		if (isset($uri['topic']) && $uri['topic'] <> "" && $uri['topic'] <> "~") {
            $filter['topic'] = $uri['topic'];
            $pegination_uri['topic'] = $uri['topic'];
        } else {
            $filter['topic'] = '';
            $pegination_uri['topic'] = "~";
        }

        if (isset($uri['date']) && $uri['date'] <> "" && $uri['date'] <> "~") {
            $filter['date'] =  str_replace('~', '/', $uri['date']);
            $pegination_uri['date'] = $uri['date']; //changed
        } else {
            $filter['date'] = "";
            $pegination_uri['date'] = "~";
        }

	    // Get the total rows without limit
	    $total_rows = $this->App_model->get_all_logs($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/presenters/logs/'.$this->uri->assoc_to_uri($pegination_uri).'/page/', 15, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['list'] = $this->App_model->get_all_logs($filter, 'id', 'asc');
		//$data['schools'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		if ($this->session->userdata('role') == 'teacher'){
            $data['schools'] = $this->App_model->get_all_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));
        }else{
            $data['schools'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
        }

		$data['topics'] = $this->App_model->get_topics_list();

		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'));

    	$data['filter'] = $filter;
	    $data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management';

    	$data['main_content'] = 'presenters/logs';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	public function search_logs() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$order_no = $this->clean_value($this->input->post('order_no'));
			$school = $this->clean_value($this->input->post('school'));
			$presenter = $this->clean_value($this->input->post('presenter'));
			$topic = $this->clean_value($this->input->post('topic'));
            $date = $this->clean_value($this->input->post('date'));
			$url = "app/presenters/logs/";
			
			$order_no = urlencode($order_no);
            if ($order_no != '' && $order_no != '~') {
                $url .= "order_no/". $order_no."/";
            }
			
			$school = urlencode($school);
			if ($school != '' && $school != '~') {
				$url .= "school/".$school."/";
			}

			$presenter = urlencode($presenter);
			if ($presenter != '' && $presenter != '~') {
				$url .= "presenter/". $presenter."/";
			}
			$topic = urlencode($topic);
            if ($topic != '' && $topic != '~') {
                $url .= "topic/".$topic."/";
            }

            $date = urlencode($date);
            if ($date != '' && $date != '~') {
                $url .= "date/".$date."/";
            }
			redirect($url);
    	}
    }
	
    public function log_download($id = NULL, $status = NULL) {

        $record = $this->App_model->get_download_log($id);
        $sign_image = base_url().$record->create_log_content;
        $file = $record->content.'<img src="'.$sign_image.'">';
        
		if (!empty($record) && $record->attachment!=NULL) {
            $file = DIR_TEACHER_FILES.$record->attachment;
            if (file_exists($file)) {
                // get file content
                $data = file_get_contents ( $file );
                //force download
                $this->load->helper('download');
                force_download ( $record->attachment, $data );
            }

        }else{
			
			//load mPDF library
			$this->load->library('m_pdf');

			//this the the PDF filename that user will get to download
			$data['attachment'] = "log_".date('YmdHis').".pdf";		
						
			//generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($file);
			
			//download it.
			$this->m_pdf->pdf->Output($data['attachment'], 'D'); 
		}
	}
	private function clean_value($str) {

		$str = str_replace('/', '~', $str);
		return preg_replace('/[^A-Za-z0-9_\-~]/', '', $str);
    }

    public function search_submit() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //echo "<pre>";print_r($_POST);die;
            $presenter = $this->clean_value($this->input->post('presenter'));
            $company = $this->clean_value($this->input->post('company'));

            $url = "app/presenters/index/";
            
            $company = urlencode($company);
            if ($company != '' && $company != '~') {
                $url .= "company/".$company."/";
            }

            $presenter = urlencode($presenter);
            if ($presenter != '' && $presenter != '~') {
                $url .= "presenter/". $presenter."/";
            }

         

            //$url .= '?id='.$this->input->get('id');

            redirect($url);
        }
    }
	public function viewHistory_ajax(){
        $odrid = $this->input->post('ordr_id');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $schedule_id = $this->input->post('schedule_id');
        $order_schedules['order_schedules'] = $this->App_model->get_order_schedule_with_range($odrid, $this->session->userdata('id'), $startdate, $enddate, "order_schedules.id");
        $order_schedules['schedule_id'] = $schedule_id;
        // print_r($order_schedules);
        $view = $this->load->view('ajax/viewhistory', $order_schedules,true);
        echo $view;
    }
	public function create_log_billing() {
        $id = $this->input->get('id');
        
        if ($id) {          
            // Get the existing schedule
            $data['schedule'] = $this->App_model->get_order_schedule_details($id);  
			$data['principal_name'] = $this->App_model->principal($data['schedule']->school_id);
            
            $data['order'] = array();
            if(!empty($data['schedule'])){
                // Get order details
                $data['order'] = $this->App_model->get_order_details($data['schedule']->order_id);
            }
        }
        
        $data['page'] = 'presenters';
        $data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Create Log';
        
        //$data['main_content'] = ;
        $this->load->view('presenters/create_log_billing', $data);
    }
	public function documents() {

        // Permission Checking
        // parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        $default_uri = array('status', 'page', 's_by', 's_dir');
        $uri = $this->uri->uri_to_assoc(4, $default_uri);
        $pegination_uri = array();
        //echo "<pre>";print_r($uri);die;
        $status = $uri['status'];

        if ($uri['page'] > 0) {
            $page = $uri['page'];
        } else {
            $page = 0;
        }
        $filter = array();
        $filter = array('delete' => 0);

       

        if ($uri['s_by'] <> "") {
            $filter['s_by'] = $uri['s_by'];
            $pegination_uri['s_by'] = $uri['s_by'];
        } else {
            $filter['s_by'] = "created_on";
            $pegination_uri['s_by'] = "created_on";
        }
        if ($uri['s_dir'] <> "") {
            $filter['s_dir'] = $uri['s_dir'];
            $pegination_uri['s_dir'] = $uri['s_dir'];
        } else {
            $filter['s_dir'] = "DESC";
            $pegination_uri['s_dir'] = "DESC";
        }

        // Create the filters
       
        //$filter['deleted'] = 0;
        $filter['role_token'] = $this->role_token;

        if ($status <> '') {
            $filter['status'] = $status;
        } else {
            $status = 0;
        }
        //echo "<pre>";print_r($filter);die;
        // Get the total rows without limit
        $total_rows = $this->Reports_storage_model->get_reports_list($filter, 'id', 'desc', true);


        $config = $this->init_pagination('app/reports_storage/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0)
            $limit_end = 0;

        $filter['limit'] = $config['per_page'];
        $filter['offset'] = $limit_end;

        // Get the Users List
        $data['list'] = $this->Reports_storage_model->get_reports_list($filter, 'id', 'desc');

        $data['filters']    = $uri;
        $data['filter']     = $filter;
        $data['page']       = 'reports_storage';
        $data['page_title'] = SITE_NAME.' :: Reports storage Management';

        $data['main_content'] = 'presenters/documents_list';
        //echo "<pre>";print_r($data);die;

        $this->load->view(TEMPLATE_PATH, $data);
    }
	public function titles(){
        // echo 'titles';
        // Permission Checking
        // parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        $default_uri = array('page, order_no, school');
        $uri = $this->uri->uri_to_assoc(4, $default_uri);

        if (isset($uri['page']) && $uri['page'] > 0) {
            $page = $uri['page'];
        } else {
            $page = 0;
        }

        // Create the filters
        $filter = array();

        if (isset($uri['order_no']) && $uri['order_no'] <> "" && $uri['order_no'] <> "~") {
            $filter['order_no'] = $uri['order_no'];
			$title_id_for_order_id = $this->App_model->get_titles_id_for_order_filter($filter['order_no']); 
			$filter['title_id_for_order_id'] = $title_id_for_order_id?$title_id_for_order_id:0;
            // $filter['title_id_for_order_id'] = $this->App_model->get_titles_id_for_order_filter($filter['order_no']);
            $pegination_uri['order_no'] = $uri['order_no'];
        } else {
            $filter['order_no'] = '';
            $pegination_uri['order_no'] = "~";
            $filter['title_id_for_order_id'] = '';
        }
        if (isset($uri['school']) && $uri['school'] <> "" && $uri['school'] <> "~") {
            $filter['school'] = $uri['school'];
            $filter['title_id_for_school'] = $this->App_model->get_titles_id_for_school_filter($filter['school']);
            $pegination_uri['school'] = $uri['school'];
        } else {
            $filter['school'] = '';
            $pegination_uri['school'] = "~";
            $filter['title_id_for_school'] = '';
        }

        // Get the total rows without limit
        $total_rows = $this->App_model->get_titles_by_filter($filter, 'id', 'asc', true);

        $config = $this->init_pagination('app/presenters/titles/'.$this->uri->assoc_to_uri($pegination_uri).'/page/', 9, $total_rows);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }

        $filter['limit'] = $config['per_page'];
        $filter['offset'] = $limit_end;

        // Get the Users List
        $data['list'] = $this->App_model->get_titles_by_filter($filter, 'id', 'asc');
        // echo '<pre>'; print_r($data['list']); die();
        // $data['schools'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
        $data['schools'] = $this->App_model->get_all_school_by_presenter(array('deleted'=>0, 'presenter_id' => $this->session->userdata('id')));
        // echo '<pre>'; print_r($data['schools']); die();
        
		$data['filter'] = $filter;
        //echo $this->router->class."/".$this->router->method;die;
        // $search['deleted'] = 0;

        // $data['list'] = $this->App_model->get_title_list($search);
        // echo '<pre>'; print_r($data['list']); die();
        $data['page'] = 'titles';
        $data['page_title'] = SITE_NAME.' :: Title Management';

        $data['main_content'] = 'presenters/titles_list';
        $this->load->view(TEMPLATE_PATH, $data);
    }
	public function search_titles() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $order_no = $this->clean_value($this->input->post('order_no'));
            $school = $this->clean_value($this->input->post('school'));

            $url = "app/presenters/titles/";
           
            $order_no = urlencode($order_no);
            if ($order_no != '' && $order_no != '~') {
                $url .= "order_no/". $order_no."/";
            }
           
            $school = urlencode($school);
            if ($school != '' && $school != '~') {
                $url .= "school/".$school."/";
            }

            // echo $url; die();
            redirect($url);
        }
    }
	public function viewTitleDetails_ajax(){
        $title_id = $this->input->post('title_id');
		$order_no = $this->input->post('order_no');
		if($order_no != 'false'){
			$title_data['topics'] = $this->App_model->get_title_topics_des_order_wise($title_id, $order_no);
		
		}else{
			$title_data['topics'] = $this->App_model->get_title_topics_des($title_id);
		}
        // $title_data['topics'] = $this->App_model->get_title_topics_des($title_id);
        // echo '<pre>'; print_r($title_data['topics']); die();
        $view = $this->load->view('ajax/viewtitleDetails', $title_data,true);
        echo $view;
    }
	public function create_calendar_link(){
		$session_id = $this->input->post('session');
		$_SESSION["sessionIdFilterPre"] = $session_id;
		$session = $this->App_model->get_session_dates_by_id($session_id);
		// if($session->start_date){
		// 	$session_start_year = date('Y', strtotime($session->start_date));
		// 	$session_start_month = date('m', strtotime($session->start_date));
		// }else{
		// 	$session_start_year = 2017;
		// 	$session_start_month = 01;
		// }
		
		// echo $response = $session_start_year.'/'.$session_start_month;
		$curr_date = date("Y-m-d");
		if($session->end_date){
			if($curr_date > $session->start_date && $curr_date <= $session->end_date){
				$session_end_year = date("Y");
				$session_end_month = date('m');
			}else{
				$session_end_year = date('Y', strtotime($session->end_date));
				$session_end_month = date('m', strtotime($session->end_date));
			}
		}else{
			$session_end_year = date("Y");
			$session_end_month = date('m');
		}
		
		echo $response = $session_end_year.'/'.$session_end_month;
	}

	function destroySessionFilterForPresenterCalendar(){
        if(isset($_SESSION['sessionIdFilterPre'])){
            unset($_SESSION['sessionIdFilterPre']);
        }
        echo 1;
    }

	function request_teacher_modal(){
		$grade_id = $this->input->post('grade');
		$grade_name = $this->App_model->get_grade_name($grade_id);
		$data['grade_name'] = $grade_name;
        echo $this->load->view('presenters/view_request_teacher_modal',$data, true);
	}
}
