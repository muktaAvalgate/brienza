<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grades extends Application_Controller {

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
    private $tablename = 'grades';
    private $url = '/app/grades';
    private $permissionValues = array(
 		'index' => 'App.Grades.View',
 		'add' => 'App.Grades.Add',
 		'edit' => 'App.Grades.Edit',
        'delete' => 'App.Grades.Delete',
        'update_status' => 'App.Grades.UpdateStatus',
    );

    public function __construct() {

        parent::__construct();

        // Validate Login
		parent::checkLoggedin();

        $this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
        $this->load->model('App_model');
    }

    /**
     *
     */
    public function index() {

        // Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);
		
		//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			//print "<pre>"; print_r($_POST); die;
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'Item', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count = 0;
    			$items = $this->input->post('item_id');
    			$operation = $this->input->post('operation');
				
				if($operation == "teacher_save") {
					
					/*foreach ($items as $id=>$value) {

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
					}*/

					$msg = ($operation=='delete')?'deleted.':'updated.';
				
				} else if ($operation == "title_save") {
					
				}
    			

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' category(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    	}
		
        $data['list'] = $this->App_model->get_grade_list(array('deleted' => 0));
        $data['page'] = 'grades';
    	$data['page_title'] = SITE_NAME.' :: Grade Management';

    	$data['main_content'] = 'grades/list';
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
    		$this->form_validation->set_rules('name', 'Grade Name', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data_to_store = array(
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($this->App_model->insert($this->tablename, $data_to_store)) {
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Grade has been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Grade already exists.');
    			}
    			redirect('/app/grades/');
    		} //validation run
    	}

        $data['page'] = 'grades';
    	$data['page_title'] = SITE_NAME.' Grade Management &raquo; Add Grade';

        $data['main_content'] = 'grades/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	/**
	 *
	 * @param unknown_type $id
	 */
	public function edit($id = 0) {

        // Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
    		$this->form_validation->set_rules('name', 'Grade Name', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
     			$image = $_FILES['pic'];

     			$data_to_store = array(
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
     			);

     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Grade successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}
     			redirect('/app/grades/');
     		} //validation run
     	}

     	$data['grade'] = $this->App_model->get_grade_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['grade'])) {
     		redirect('/app/grades/');
     	}

        //print "<pre>"; print_r($data['list']); print "</pre>"; die;
     	$data['page'] = 'grades';
    	$data['page_title'] = SITE_NAME.' Grade Management &raquo; Edit Grade';

        $data['main_content'] = 'grades/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_grade_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/grades/');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Grade successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/grades/');
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
    		$this->form_validation->set_rules('item_id[]', 'Grade', 'trim|required');

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
				    		'status' => ($operation == "active")?'1':'0'
				    	);
    				}

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Grade(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/grades');
    	}
    }

	public function view_teachers($id = null) {

		if ($id == null) {
			return false;
		}
		
		// Get the teachers List
	    $data['teachers'] = $this->App_model->get_teacher_list(array('deleted' => 0, 'status' => 'active'), 'teachers.name', 'asc');
		
		//print "<pre>"; print_r($data);die;
		// Get all the teachers
    	//$data['teachers'] = $this->App_model->get_customer_subsciptions($id);

    	//$data['main_content'] = ;
    	$this->load->view("grades/teachers", $data);
	}
	
	public function view_titles($id = null) {

		if ($id == null) {
			return false;
		}

		// Get all the titles
    	$data['titles'] = $this->App_model->get_customer_subsciptions($id);

    	//$data['main_content'] = ;
    	$this->load->view("grades/titles", $data);
	}
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
