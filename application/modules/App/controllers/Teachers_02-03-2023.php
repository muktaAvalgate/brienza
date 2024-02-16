<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teachers extends Application_Controller {

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
 	private $tablename = 'teachers';
 	private $url = '/app/teachers';
 	private $permissionValues = array(
 		'index' => 'App.Teachers.View',
 		'add' => 'App.Teachers.Add',
 		'edit' => 'App.Teachers.Edit',
        'delete' => 'App.Teachers.Delete',
 		'update_status' => 'App.Teachers.UpdateStatus',
    );

    public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
        $this->load->model('App_model');
        $this->load->model('../../Admin/models/Admin_model');
    }



    public function index() {

        // Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        // Include the Module JS file.
		add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');

        // Set the filters
        $filter = array('deleted' => 0);
		
		// Check if the logged in user is admin
		if ($this->session->userdata('role') != "administrator") {
			$filter['school_id'] = $this->session->userdata('id');
            redirect('app/teachers/edit/'.$this->session->userdata('id'));
		}
		
        $default_uri = array('page');
        $uri = $this->uri->uri_to_assoc(2, $default_uri);
        //$pegination_uri = array();

        // Get the category List
        //$cat_filter = array('deleted' => 0, 'status' => 'active', 'parent_id' => 0, 'tag' => "&ndash;");
        //$data['categories'] = $this->App_model->get_category_by_parent($cat_filter);


        //$default_uri = array('page');
    	//$uri = $this->uri->uri_to_assoc(4, $default_uri);

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

        // Get the total rows without limit
	    $total_rows = $this->App_model->get_teacher_list($filter, 'created_on', 'desc', true);

	    $config = $this->init_pagination('app/teachers/index/page/', 5, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;


	    // Get the Teachers List
	    $data['list'] = $this->App_model->get_teacher_list($filter, 'created_on', 'desc');

        $data['filter'] = $filter;
    	$data['page'] = 'teachers';
    	$data['page_title'] = SITE_NAME.' :: Teacher Management';

    	$data['main_content'] = 'teachers/list';
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
			$this->form_validation->set_rules('school_id', 'School', 'trim|required');
			$this->form_validation->set_rules('grade_id', 'Grade', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		/*$this->form_validation->set_rules('email', 'Email', 'trim|required');
	    	$this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');*/

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    		//if the form has passed through the validation

    		if ($this->form_validation->run())
    		{
    			$data = array(
					'school_id' => htmlspecialchars($this->input->post('school_id'), ENT_QUOTES, 'utf-8'),
					'grade_id' => htmlspecialchars($this->input->post('grade_id'), ENT_QUOTES, 'utf-8'),
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    /*'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
                    'phone' => htmlspecialchars($this->input->post('phone'), ENT_QUOTES, 'utf-8'),*/
                    'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($teacher_id = $this->App_model->insert($this->tablename, $data)) {                    

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Teacher been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
    			}
    			redirect($this->url);
    		} //validation run
    	}

        $filter = array(
            'deleted' => 0,
            'status' => 'active'
        );

        //$data['schools'] = $this->App_model->get_school_list($filter);
		$data['grades'] = $this->App_model->get_grade_list($filter);
		
		$this->load->model('../../Admin/models/Admin_model');
		$filter['role_token'] = 'school_admin';
		$data['schools'] = $this->Admin_model->get_users_list($filter);
        //print "<pre>"; print_r($data); die;

    	$data['page'] = 'teachers';
    	$data['page_title'] = SITE_NAME.' :: Teachers Management &raquo; Add Teacher';

    	$data['main_content'] = 'teachers/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	/**
	 *
	 * @param unknown_type $id
	 */
    public function edit($school_id = 0) {

        // Permission Checking
        parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        $data['school_id'] = $school_id;
        $data['school_titles'] = $this->App_model->get_school_titles($school_id);
        $data['school'] = '';
        $data['titleData'] = array();
        if(!empty($data['school_titles'])){
            foreach ($data['school_titles'] as $k1 => $val1) {
                $data['titleData'][$k1] = $this->App_model->get_school_teacher($school_id, $k1, 'teachers.grade_id');
                if(!empty($data['titleData'][$k1]) && $data['titleData'][$k1][0]['school_name'] !=''){
                    $data['school'] = $data['titleData'][$k1][0]['school_name'];
                }
            }
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            //$this->form_validation->set_rules('school_id', 'School', 'trim|required');
            $this->form_validation->set_rules('titles[]', 'Title', 'trim|required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $titles = $this->input->post('titles');
                $grades = $this->input->post('grades');
                $teachers = $this->input->post('teachers');
                // print "<pre>"; print_r($_POST); print "</pre>";die;
                
                // Relation - School / Teacher
                // First Delete
                /* $this->db->where('school_id', $school_id);
                $this->db->delete('school_titles');

                $this->db->where('school_id', $school_id);
                $this->db->delete('teachers'); */
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

                    // Relation - School / Teacher
                    // First Delete
                    $this->db->where('school_id', $school_id);
                    $this->db->delete('school_titles');

                    $this->db->where('school_id', $school_id);
                    $this->db->delete('teachers');

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
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> Titles successfully updated.');
                    if($this->session->userdata('role') == 'school_admin'){
                        redirect('/app/teachers/edit/'.$school_id);
                    }
                    // redirect($this->url);
                    redirect('/app/teachers/edit/'.$school_id);
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please enter at least one grade & teacher for the selected title.');
                    redirect('/app/teachers/edit/'.$school_id); 
                }
                //------------end of validation for grade and teacher field
        
                // Add to school_titles
                /* foreach ($titles as $key => $title_id) {
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
                $this->session->set_flashdata('message', '<strong>Well done!</strong> Titles successfully updated.');
                if($this->session->userdata('role') == 'school_admin'){
                    redirect('/app/teachers/edit/'.$school_id);
                }
                redirect($this->url); */
            } //validation run
        }

        $data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
        
        //print "<pre>";print_r($data);die;
        // if (!is_numeric($id) || $id == 0 || empty($data['teacher'])) {
        //  redirect('/app/teachers');
        // }

        $filter = array();
        $filter['deleted'] = 0;
        $filter['role_token'] = 'school_admin';

        // $data['schools'] = $this->Admin_model->get_school_details($filter);
        
        $data['grades'] = $this->App_model->get_grade_list($filter);
        
        $data['page'] = 'teachers';
        $data['page_title'] = SITE_NAME.' :: Teacher Management &raquo; Edit Teacher';

        $data['main_content'] = 'teachers/edit';
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
    		$this->form_validation->set_rules('item_id[]', 'Teacher', 'trim|required');

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' teacher(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect($this->url);
    	}
    }



    

    public function delete($id = null) {

        $data['teacher']  = $this->App_model->get_teacher_details($id);
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['teacher'])) {
     		redirect($this->url);
     	}

        $data_to_store = array(
            'is_deleted' => 1
        );

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Teacher successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect($this->url);
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
    
    public function get_assign_title_grade(){
        $school_id = $this->input->post('school_id');
        $data['school_titles'] = $this->App_model->get_school_titles($school_id);

        $filter = array();
        $filter['deleted'] = 0;
        $filter['role_token'] = 'school_admin';
        $data['grades'] = $this->App_model->get_grade_list($filter);
        $data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
        
        $data['titleData'] = array();
        if(!empty($data['school_titles'])){
            foreach ($data['school_titles'] as $k1 => $val1) {
                $data['titleData'][$k1] = $this->App_model->get_school_teacher($school_id, $k1);
            }
        }

        // echo "<pre>";print_r($data);exit;

        echo $this->load->view('teachers/assign_title_grade_list', $data);


    }
}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
