<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends Application_Controller {

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
 	private $tablename = 'signup_questions';
 	private $url = '/app/questions';
 	private $permissionValues = array(
 		'index' => 'App.Questions.View',
 		'add' => 'App.Questions.Add',
 		'edit' => 'App.Questions.Edit',
        'delete' => 'App.Questions.Delete',
 		'update_status' => 'App.Questions.UpdateStatus',
    );

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
		//add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');

        // Set the filters
        $filter = array('deleted' => 0);

	    // Get the Questions List
	    $data['list'] = $this->App_model->get_signup_questions_list($filter, 'created_on', 'desc');

		//print "<pre>"; print_r($data); die;
        $data['filter'] = $filter;
    	$data['page'] = 'questions';
    	$data['page_title'] = SITE_NAME.' :: Questions Management';

    	$data['main_content'] = 'questions/list';
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
			$this->form_validation->set_rules('question_group', 'Group', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'question_group' => htmlspecialchars($this->input->post('question_group'), ENT_QUOTES, 'utf-8'),
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($question_id = $this->App_model->insert($this->tablename, $data)) {                    

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Question been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
    			}
    			redirect($this->url);
    		} //validation run
    	}


    	$data['page'] = 'questions';
    	$data['page_title'] = SITE_NAME.' :: Questions Management &raquo; Add Question';

    	$data['main_content'] = 'questions/add';
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
            $this->form_validation->set_rules('question_group', 'Group', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
                $data = array(
					'question_group' => htmlspecialchars($this->input->post('question_group'), ENT_QUOTES, 'utf-8'),
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

                //print "<pre>"; print_r($data); print "</pre>"; die;
     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data)) {
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Question successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect($this->url);
     		} //validation run
     	}

     	$data['question']  = $this->App_model->get_signup_questions_details($id);
		
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['question'])) {
     		redirect('/app/questions');
     	}

     	$data['page'] = 'questions';
    	$data['page_title'] = SITE_NAME.' :: Question Management &raquo; Edit Question';

    	$data['main_content'] = 'questions/edit';
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
    		$this->form_validation->set_rules('item_id[]', 'Question', 'trim|required');

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' question(s) successfully '.$msg);

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
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Question successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect($this->url);
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
}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
