<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schools extends Application_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 * 	- or -
	 * 		http://example.com/index.php/welcome/index
	 * 	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

     /**
 	 *
 	 * @var unknown_type
 	 */
 	private $tablename = 'users';
 	private $url = '/app/schools';
 	private $permissionValues = array(
 		'index' => 'App.Schools.View',
 		'add' => 'App.Schools.Add',
 		'edit' => 'App.Schools.Edit',
        'delete' => 'App.Schools.Delete',
 		'update_status' => 'App.Schools.UpdateStatus',
    );
	private $role = 4; // Presenter Role ID
	private $role_token = 'school_admin';
	
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
		
		$default_uri = array('status', 'page', 'school', 'contact_person', 'email');
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

        if ($uri['school'] <> "" && $uri['school'] <> "~") {
            $filter['school'] = $uri['school'];
            $pegination_uri['school'] = $uri['school'];
        } else {
            $filter['school'] = "";
            $pegination_uri['school'] = "~";
        }

        if ($uri['contact_person'] <> "" && $uri['contact_person'] <> "~") {
            $filter['contact_person'] = $uri['contact_person'];
            $pegination_uri['contact_person'] = $uri['contact_person'];
        } else {
            $filter['contact_person'] = "";
            $pegination_uri['contact_person'] = "~";
        }

        if ($uri['email'] <> "" && $uri['email'] <> "~") {
            $filter['email'] = $uri['email'];
            $pegination_uri['email'] = $uri['email'];
        } else {
            $filter['email'] = "";
            $pegination_uri['email'] = "~";
        }

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_users_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('app/schools/index/'.$this->uri->assoc_to_uri(array('status' => $status)).'/page/', 7, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;
        $data['filter'] = $filter;
	    // Get the Users List
	    $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');
        $data['search'] = $this->Admin_model->get_schools_list_search();

    	//print "<pre>"; print_r($data);print "</pre>";
    	$data['filters'] = $uri;
    	$data['page'] = 'schools';
    	$data['page_title'] = SITE_NAME.' :: School Management';

    	$data['main_content'] = 'schools/list';
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
	    	$this->form_validation->set_rules('meta[school_name]', 'Name', 'trim|required');
            $this->form_validation->set_rules('meta[principal_name]', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email');

            // ======== Start Code By Ahmed on 2019-09-25 ======= //
            $this->form_validation->set_rules('titles[]', 'Titles', 'trim|required');
            // ======== End of the Code 2019-09-25 ====== //

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
				$this->load->helper('string');
				$password = random_string('alnum', 8);
				
    			$data = array(
                    'role_id' => $this->role,
                    'first_name' => htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
                    'last_name' => htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
                    'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
					'password' => md5($password),
    				'status' => $this->input->post('status'),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);
				
				$meta = $this->input->post('meta');

                // ======== Start Code By Ahmed on 2019-09-25 ======= //
                $titles = $this->input->post('titles');
                $grades = $this->input->post('grades');
                $teachers = $this->input->post('teachers');
                // ======== End of the Code 2019-09-25 ====== //

    			//if the insert has returned true then we show the flash message
    			/* if ($user_id = $this->Admin_model->insert($this->tablename, $data)) {

					// Insert the Mata Data
					$this->Admin_model->replace_user_meta($user_id, $meta);

                    // ======== Start Code By Ahmed on 2019-09-25 ======= //
                    // Add to school_titles
                    foreach ($titles as $key => $title_id) {
                        $titleData = array ('school_id' => $user_id, 'title_id' => $title_id);
                        $this->App_model->insert('school_titles', $titleData);
                    }


                    // Add Grades & Teachers
                    foreach ($grades as $title_id => $grade_inner) {
                        foreach ($grade_inner as $index => $grade_id) {
                            
                            if ($grade_id <> "") {
                                $teacher_name = $teachers[$title_id][$index];
                                
                                $teacher = array ('school_id' => $user_id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
                                $this->App_model->insert('teachers', $teacher);
                                    
                            }                       
                        }
                    }
                    // ======== End of the Code 2019-09-25 ====== //

					// Send Email to users
					$principal_name = $data['first_name']." ".$data['last_name'];
					$this->load->library('mail_template');
    				$this->mail_template->new_user_email($principal_name, $data['email'], $password);
					
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> School has been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
    			}
    			redirect($this->url); */
				//------------Start validation for grade and teacher field
                $title_key = array();
                for($k=0; $k < count($titles); $k++){
                    // $title_key[$titles[$k]] = $titles[$k];
                    foreach($grades as $title_id => $grade_inner){
                        // foreach($grade_inner as $index => $grade_id){
                            if($title_id == $titles[$k]){
                                $title_key[] = $titles[$k];
                            }
                        // }
                    }
                }
                // echo '<pre>'; print_r($title_key); die();

                $notemptyFlag = array();
                $temp = 0;
                $success = true;
                for($i=0; $i < count($title_key); $i++){
                    $temp = 0;
                    foreach($grades as $title_id => $grade_inner){
                        foreach($grade_inner as $index => $grade_id){
                            if($title_id == $title_key[$i]){
                                // echo $title_id; echo $index;
                                if(($grade_id != '') && ($teachers[$title_id][$index]) != ''){
                                    $temp++;
                                } 
                            }
                        }
                    }
                    // echo $temp.'temp value';
                    $notemptyFlag[] = $temp;
                }

                // echo '<pre>'; print_r($notemptyFlag); die();

                for($j=0; $j<count($notemptyFlag); $j++){
                    if($notemptyFlag[$j] == 0){
                        $success = false;
                    }
                }

                // echo $emptyFlag; die();
                if($success){
                    if ($user_id = $this->Admin_model->insert($this->tablename, $data)) {
                        // Insert the Mata Data
                        $this->Admin_model->replace_user_meta($user_id, $meta);
                        // Add to school_titles
                        foreach ($titles as $key => $title_id) {
                            $titleData = array ('school_id' => $user_id, 'title_id' => $title_id);
                            $this->App_model->insert('school_titles', $titleData);
                        }
                        // Add Grades & Teachers
                        foreach ($grades as $title_id => $grade_inner) {
                            foreach ($grade_inner as $index => $grade_id) {
                                
                                if ($grade_id <> "") {
                                    $teacher_name = $teachers[$title_id][$index];
                                    
                                    $teacher = array ('school_id' => $user_id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
                                    $this->App_model->insert('teachers', $teacher);
                                        
                                }                       
                            }
                        }
                        // Send Email to users
                        $principal_name = $data['first_name']." ".$data['last_name'];
                        $this->load->library('mail_template');
                        $this->mail_template->new_user_email($principal_name, $data['email'], $password);
                        
                        $this->session->set_flashdata('message_type', 'success');
                        $this->session->set_flashdata('message', '<strong>Well done!</strong> School has been added successfully.');
                    }else {
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
                    }
                    redirect($this->url);
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please enter at least one grade & teacher for the selected title.');
                    redirect('/app/schools/add');   
                }
                //------------end of validation for grade and teacher field
    		} //validation run
    	}

        $data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
        
        $data['schedules'] = $this->App_model->get_schedule_list(array('deleted'=>0));

        $data['grades'] = $this->App_model->get_grade_list(array('deleted'=>0, 'role_token'=>'school_admin', 'status'=>'active'));

    	$data['page'] = 'schools';
    	$data['page_title'] = SITE_NAME.' :: School Management &raquo; Add School';

    	$data['main_content'] = 'schools/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	/**
	 *
	 * @param unknown_type $id
	 */
	public function edit($id = 0) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
	    	$this->form_validation->set_rules('meta[school_name]', 'School Name', 'trim|required');
            $this->form_validation->set_rules('meta[principal_name]', 'Principal Name', 'trim|required');
    		//$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('meta[holiday_schedule_id]', 'Holiday Schedule', 'trim|required');
			
            // ======== Start Code By Ahmed on 2019-09-25 ======= //
            $this->form_validation->set_rules('titles[]', 'Titles', 'trim|required');
            // ======== End of the Code 2019-09-25 ====== //
            
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
				$data = array(
					'first_name' => htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
                    'last_name' => htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
    				//'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
					//'password' => md5($password),
    				'status' => $this->input->post('status'),
    				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);
				
				$meta = $this->input->post('meta');
                
                // ======== Start Code By Ahmed on 2019-09-25 ======= //
                $titles = $this->input->post('titles');
                $grades = $this->input->post('grades');
                $teachers = $this->input->post('teachers');
                // ======== End of the Code 2019-09-25 ====== //
                
                $pic = $_FILES['profile_pic'];

                // Upload Pic File
                if (!empty($pic['name'])) {

                    $config['upload_path'] = DIR_PROFILE_PICTURE;
                    $config['max_size'] = '5000';
                    $config['allowed_types'] = 'jpg|png|jpeg|bmp';
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);

                    $config['file_name'] = 'pic-'.rand().date('YmdHis');
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('profile_pic')) {
                        $this->upload->display_errors(); die;
                    } else {

                        // Crete thumbnail
                        $config_thumb['image_library'] = 'gd2';
                        $config_thumb['source_image'] = DIR_PROFILE_PICTURE.$this->upload->file_name;
                        $config_thumb['create_thumb'] = FALSE;
                        $config_thumb['maintain_ratio'] = TRUE;
                        $config_thumb['master_dim'] = 'auto';
                        $config_thumb['width'] = PROFILE_THUMB_SIZE; // image re-size  properties
                        $config_thumb['height'] = PROFILE_THUMB_SIZE; // image re-size  properties
                        $config_thumb['new_image'] = DIR_PROFILE_PICTURE_THUMB.$this->upload->file_name; // image re-size  properties

                        $this->load->library('image_lib', $config_thumb); //codeigniter default function

                        $this->image_lib->initialize($config_thumb);
                        if (!$this->image_lib->resize()) {
                             echo $this->image_lib->display_errors();
                        }
                        $this->image_lib->clear();
                        // ...

                        $upload_data =  $this->upload->data();
                        $meta['profile_pic'] = $upload_data['file_name'];
                    }
                }


                //print "<pre>"; print_r($data); print "</pre>"; die;
     			//if the insert has returned true then we show the flash message
     			/* if ($this->Admin_model->update($this->tablename, 'id', $id, $data)) {
					
					// Insert the Mata Data
					$this->Admin_model->replace_user_meta($id, $meta);
					
                    // ======== Start Code By Ahmed on 2019-09-25 ======= //
                    // Add to school_titles
                    //first delete then insert
					$titledelRes = $this->App_model->deleteData('school_titles', 'school_id',$id);
					if($titledelRes){
						foreach ($titles as $key => $title_id) {
							$titleData = array ('school_id' => $id, 'title_id' => $title_id);
							$this->App_model->insert('school_titles', $titleData);
						}
					}


                    // Add Grades & Teachers
                    //first delete then insert
					$graddelRes = $this->App_model->deleteData('teachers', 'school_id',$id);
					if($graddelRes){
						foreach ($grades as $title_id => $grade_inner) {
							foreach ($grade_inner as $index => $grade_id) {
								
								if ($grade_id <> "") {
									$teacher_name = $teachers[$title_id][$index];
									
									$teacher = array ('school_id' => $id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
									$this->App_model->insert('teachers', $teacher);
										
								}                       
							}
						}
					}
                    // ======== End of the Code 2019-09-25 ====== //

     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> School successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect($this->url); */
				//------------Start validation for grade and teacher field
                $title_key = array();
                for($k=0; $k < count($titles); $k++){
                    // $title_key[$titles[$k]] = $titles[$k];
                    foreach($grades as $title_id => $grade_inner){
                        // foreach($grade_inner as $index => $grade_id){
                            if($title_id == $titles[$k]){
                                $title_key[] = $titles[$k];
                            }
                        // }
                    }
                }
                // echo '<pre>'; print_r($title_key); die();

                $notemptyFlag = array();
                $temp = 0;
                $success = true;
                for($i=0; $i < count($title_key); $i++){
                    $temp = 0;
                    foreach($grades as $title_id => $grade_inner){
                        foreach($grade_inner as $index => $grade_id){
                            if($title_id == $title_key[$i]){
                                // echo $title_id; echo $index;
                                if(($grade_id != '') && ($teachers[$title_id][$index]) != ''){
                                    $temp++;
                                } 
                            }
                        }
                    }
                    // echo $temp.'temp value';
                    $notemptyFlag[] = $temp;
                }

                // echo '<pre>'; print_r($notemptyFlag); die();

                for($j=0; $j<count($notemptyFlag); $j++){
                    if($notemptyFlag[$j] == 0){
                        $success = false;
                    }
                }

                // echo $emptyFlag; die();
                if($success){
                    //if the insert has returned true then we show the flash message
                    if ($this->Admin_model->update($this->tablename, 'id', $id, $data)) {
                    
                        // Insert the Mata Data
                        $this->Admin_model->replace_user_meta($id, $meta);
                        
                        // ======== Start Code By Ahmed on 2019-09-25 ======= //
                        // Add to school_titles
                        //first delete then insert
                        $titledelRes = $this->App_model->deleteData('school_titles', 'school_id',$id);
                        if($titledelRes){
                            foreach ($titles as $key => $title_id) {
                                $titleData = array ('school_id' => $id, 'title_id' => $title_id);
                                $this->App_model->insert('school_titles', $titleData);
                            }
                        }
    
    
                        // Add Grades & Teachers
                        //first delete then insert
                        $graddelRes = $this->App_model->deleteData('teachers', 'school_id',$id);
                        if($graddelRes){
                            foreach ($grades as $title_id => $grade_inner) {
                                foreach ($grade_inner as $index => $grade_id) {
                                    if(in_array($title_id ,$titles) ){
                                        if ($grade_id <> "") {
                                            $teacher_name = $teachers[$title_id][$index];
                                            
                                            $teacher = array ('school_id' => $id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
                                            $this->App_model->insert('teachers', $teacher);
                                                
                                        }   
                                    }                    
                                }
                            }
                        }
                        // ======== End of the Code 2019-09-25 ====== //
    
                        $this->session->set_flashdata('message_type', 'success');
                        $this->session->set_flashdata('message', '<strong>Well done!</strong> School successfully updated.');
                    } else{
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                    }
                    redirect($this->url);
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please enter at least one grade & teacher for the selected title.');
                    redirect('/app/schools/edit/'.$id);   
                }
                //------------end of validation for grade and teacher field
     		} //validation run
     	}

     	$data['school'] = $this->Admin_model->get_user_details($id);
		
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['school'])) {
     		redirect('/app/schools');
     	}
		
        $data['school_titles'] = $this->App_model->get_school_titles($id);
        
        if(!empty($data['school_titles'])){
            foreach ($data['school_titles'] as $k1 => $val1) {
                $data['titleData'][$k1] = $this->App_model->get_school_teacher($id, $k1);
            }
        }

        $data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
        
        $data['grades'] = $this->App_model->get_grade_list(array('deleted'=>0, 'role_token'=>'school_admin', 'status'=>'active'));

		$data['schedules'] = $this->App_model->get_schedule_list(array('deleted'=>0));
		
     	$data['page'] = 'schools';
    	$data['page_title'] = SITE_NAME.' :: School Management &raquo; Edit School';

    	$data['main_content'] = 'schools/edit';
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
    		$this->form_validation->set_rules('item_id[]', 'School', 'trim|required');

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

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' school(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect($this->url);
    	}
    }

    public function delete($id = null) {

        //$data['school']  = $this->App_model->get_school_details($id);
		$data['school']  = $this->App_model->get_school_data($id);

        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['school'])) {
     		redirect($this->url);
     	}

        $data_to_store = array(
            'is_deleted' => 1
        );

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Schhol successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect($this->url);
    }
	
	
	/**
	 *
	 * @param unknown_type $id
	 */
	public function titles($school_id = 0) {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		//echo $school_id;
		if ($this->session->userdata('role') != "administrator") {
			$school_id = $this->session->userdata('id');
		}
		
		$data['school_id'] = $school_id;
		$data['school_titles'] = $this->App_model->get_school_titles($school_id);
		
        if(!empty($data['school_titles'])){
            foreach ($data['school_titles'] as $k1 => $val1) {
                $data['titleData'][$k1] = $this->App_model->get_school_teacher($school_id, $k1);
            }
        }
		
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
	    	$this->form_validation->set_rules('school_id', 'School', 'trim|required');
    		$this->form_validation->set_rules('titles[]', 'Title', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
				$school_id = $this->input->post('school_id');
				$titles = $this->input->post('titles');
				$grades = $this->input->post('grades');
				$teachers = $this->input->post('teachers');
				//print "<pre>"; print_r($_POST); print "</pre>";die;
				
				// Relation - School / Teacher
				// First Delete
				/* $this->db->where('school_id', $school_id);
				$this->db->delete('school_titles');
		
				// Add to school_titles
				foreach ($titles as $key => $title_id) {
					$data = array ('school_id' => $school_id, 'title_id' => $title_id);
					//print "<pre>";print_r($data);print "<pre>";
					$this->App_model->insert('school_titles', $data);
				}
				
				// Add Grades & Teachers
				foreach ($grades as $title_id => $grade_inner) {
					foreach ($grade_inner as $index => $grade_id) {
						
						if ($grade_id <> "") {
							//$grade_to_save = array('name' => $grade, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
							//$grade_id = $this->App_model->insert('grades', $grade_to_save);
							//print "<pre>";print_r($grade_to_save);print "<pre>";
							
							$teacher_name = $teachers[$title_id][$index];
							
							
							//if ($teacher_name <> "") {
								$teacher = array ('school_id' => $school_id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
								$this->App_model->insert('teachers', $teacher);
								
								//print "<pre>";print_r($teacher);print "<pre>";
							//}
						}						
					}
				}

                //print "<pre>"; print_r($data); print "</pre>"; die;
     			$this->session->set_flashdata('message_type', 'success');
     			$this->session->set_flashdata('message', '<strong>Well done!</strong> School titles successfully updated.');
     			redirect('/app/schools/titles'); */
				//------------Start validation for grade and teacher field
                $title_key = array();
                for($k=0; $k < count($titles); $k++){
                    // $title_key[$titles[$k]] = $titles[$k];
                    foreach($grades as $title_id => $grade_inner){
                        // foreach($grade_inner as $index => $grade_id){
                            if($title_id == $titles[$k]){
                                $title_key[] = $titles[$k];
                            }
                        // }
                    }
                }
                // echo '<pre>'; print_r($title_key); die();

                $notemptyFlag = array();
                $temp = 0;
                $success = true;
                for($i=0; $i < count($title_key); $i++){
                    $temp = 0;
                    foreach($grades as $title_id => $grade_inner){
                        foreach($grade_inner as $index => $grade_id){
                            if($title_id == $title_key[$i]){
                                // echo $title_id; echo $index;
                                if(($grade_id != '') && ($teachers[$title_id][$index]) != ''){
                                    $temp++;
                                } 
                            }
                        }
                    }
                    // echo $temp.'temp value';
                    $notemptyFlag[] = $temp;
                }

                // echo '<pre>'; print_r($notemptyFlag); die();

                for($j=0; $j<count($notemptyFlag); $j++){
                    if($notemptyFlag[$j] == 0){
                        $success = false;
                    }
                }

                // echo $emptyFlag; die();
                if($success){
                    // // Relation - School / Teacher
                    // // First Delete
                    // $this->db->where('school_id', $school_id);
                    // $this->db->delete('school_titles');

                    // $this->db->where('school_id', $school_id);
                    // $this->db->delete('teachers');
            
                    // Add to school_titles
                    foreach ($titles as $key => $title_id) {
                        $data = array ('school_id' => $school_id, 'title_id' => $title_id);
                        //print "<pre>";print_r($data);print "<pre>";
                        $this->App_model->insert('school_titles', $data);
                    }
                    
                    // Add Grades & Teachers
                    foreach ($grades as $title_id => $grade_inner) {
                        foreach ($grade_inner as $index => $grade_id) {
                            
                            if ($grade_id <> "") {
                                //$grade_to_save = array('name' => $grade, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
                                //$grade_id = $this->App_model->insert('grades', $grade_to_save);
                                //print "<pre>";print_r($grade_to_save);print "<pre>";
                                
                                $teacher_name = $teachers[$title_id][$index];
                                
                                
                                //if ($teacher_name <> "") {
                                    $teacher = array ('school_id' => $school_id, 'title_id' => $title_id, 'grade_id' => $grade_id, 'name' => $teacher_name, 'created_by' => $this->session->userdata('id'),'created_on' => date('Y-m-d H:i:s'));
                                    $this->App_model->insert('teachers', $teacher);
                                    
                                    //print "<pre>";print_r($teacher);print "<pre>";
                                //}
                            }                       
                        }
                    }

                    //print "<pre>"; print_r($data); print "</pre>"; die;
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> School titles successfully updated.');
                    redirect('/app/schools/titles');
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please enter at least one grade & teacher for the selected title.');
                    redirect('/app/schools/titles');
                }
                //------------end of validation for grade and teacher field
     		} //validation run
     	}

        $data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		
        //print "<pre>";print_r($data);die;
     	/*if (!is_numeric($id) || $id == 0 || empty($data['school'])) {
     		redirect('/app/schools');
     	}*/
		
		$filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = 'school_admin';
        $filter['schl_status_fr_assign_titles'] = 'active';

		$data['schools'] = $this->Admin_model->get_users_list($filter);
		
		$data['grades'] = $this->App_model->get_grade_list($filter);
		
     	$data['page'] = 'schools';
    	$data['page_title'] = SITE_NAME.' :: School Management &raquo; Manage Title';

    	$data['main_content'] = 'schools/titles';
    	$this->load->view(TEMPLATE_PATH, $data);
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
 	   if ($date == null)
 	   	return null;
 	   if ($date == "")
 	   	return "";

 	   $newdate = date_create($date);
 	   return date_format($newdate,"Y-m-d");
    }

    public function teacher_report(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $link_array = explode('/', $actual_link);
        $id = $link_array['6'];
        $school_name = $this->App_model->get_school_name($id);
        $results = $this->App_model->teacher_report($id);
        // echo '<pre>'; print_r ($results); 
        // foreach($results as $val){
        //     echo $val['order_no'];
        // }
        // die;
        $delimiter = ",";
        $filename = "Teacher_Report_" . date('YmdHis') . ".csv";

        //create a file pointer
        $f = fopen('php://memory', 'w');

        //set column headers
        $fields = array('Session','School', 'Presenter','Teacher','Grade','Topic','Total hours', 'Date');
        fputcsv($f, $fields, $delimiter);

        //output each row of the data, format line as csv and write to file pointer
        //  for CSV
        foreach ($results as $val) {
            // $lineData = array($val['session_id'], html_entity_decode($school_name->meta_value, ENT_QUOTES, 'UTF-8'), $val['created_by'], $val['teacher'], $val['grade_id'], $val['topic_id'],$val['total_hours'], $val['start_date']);

            $lineData = array(html_entity_decode($val['session_id'], ENT_QUOTES, 'UTF-8'), html_entity_decode($school_name->meta_value, ENT_QUOTES, 'UTF-8'), html_entity_decode($val['created_by'], ENT_QUOTES, 'UTF-8'), html_entity_decode($val['teacher'], ENT_QUOTES, 'UTF-8'), html_entity_decode($val['grade_id'], ENT_QUOTES, 'UTF-8'), html_entity_decode($val['topic_id'], ENT_QUOTES, 'UTF-8'),$val['total_hours'], $val['start_date']);

            //users & user_meta table
            fputcsv($f, $lineData, $delimiter);
        }
        //move back to beginning of file
        fseek($f, 0);

        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        fpassthru($f);
    }


    public function search_submit() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //echo "<pre>";print_r($_POST);die;
            $school = $this->clean_value($this->input->post('school'));
            $contact_person = $this->clean_value($this->input->post('contact_person'));
            $email = $this->clean_value($this->input->post('email'));

            $url = "app/schools/index/";
            
            $school = urlencode($school);
            if ($school != '' && $school != '~') {
                $url .= "school/".$school."/";
            }

            $contact_person = urlencode($contact_person);
            if ($contact_person != '' && $contact_person != '~') {
                $url .= "contact_person/".$contact_person."/";
            }

            $email = urlencode($email);
            if ($email != '' && $email != '~') {
                $url .= "email/".$email."/";
            }
            redirect($url);
        }
    }


}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
