<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends Application_Controller {

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
    private $tablename = 'categories';
    private $url = '/app/categories';
    private $permissionValues = array(
 		'index' => 'App.Category.View',
 		'add' => 'App.Category.Add',
 		'edit' => 'App.Category.Edit',
        'delete' => 'App.Category.Delete',
        'update_status' => 'App.Category.UpdateStatus',
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

    	//echo $this->router->class."/".$this->router->method;die;
    	$search['parent_id'] = 0;
        $search['deleted'] = 0;
        $search['tag'] = "<strong>&ndash;</strong>";

        $data['list'] = $this->App_model->get_category_by_parent($search);
        $data['page'] = 'categories';
    	$data['page_title'] = SITE_NAME.' :: Category Management';

    	$data['main_content'] = 'categories/list';
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
    		$this->form_validation->set_rules('parent_id', 'Parent', 'trim|required');
    		$this->form_validation->set_rules('name', 'Category Name', 'trim|required');
			//$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$image = $_FILES['pic'];

    			$data_to_store = array(
    				'parent_id' => htmlspecialchars($this->input->post('parent_id'), ENT_QUOTES, 'utf-8'),
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'topic' => htmlspecialchars($this->input->post('topic'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($this->App_model->insert($this->tablename, $data_to_store)) {
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Category have been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> User already exists.');
    			}
    			redirect('/app/categories/');
    		} //validation run
    	}

    	$search['parent_id'] = 0;
        $search['deleted'] = 0;
       	$search['tag'] = "&ndash;";
        $data['list'] = $this->App_model->get_category_by_parent($search);
        //$data['list'] = $this->category_model->get_category_list($search);

        $data['page'] = 'categories';
    	$data['page_title'] = SITE_NAME.' Category Management &raquo; Add Category';

        $data['main_content'] = 'categories/add';
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
            $this->form_validation->set_rules('parent_id', 'Parent', 'trim|required');
    		$this->form_validation->set_rules('name', 'Category Name', 'trim|required');
			//$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
     			$image = $_FILES['pic'];

     			$data_to_store = array(
     				'parent_id' => htmlspecialchars($this->input->post('parent_id'), ENT_QUOTES, 'utf-8'),
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'topic' => htmlspecialchars($this->input->post('topic'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
     			);

     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Category successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}
     			redirect('/app/categories/');
     		} //validation run
     	}

     	$category = $this->App_model->get_category_details($id);
     	$data['category'] = $category;

     	if (!is_numeric($id) || $id == 0 || empty($data['category'])) {
     		redirect('/app/categories/');
     	}

     	$search['parent_id'] = '0';
        $search['deleted'] = 0;
       	$search['tag'] = "&ndash;";
        $data['list'] = $this->App_model->get_category_by_parent($search);


        //print "<pre>"; print_r($data['list']); print "</pre>"; die;
     	$data['page'] = 'categories';
    	$data['page_title'] = SITE_NAME.' Category Management &raquo; Edit Category';

        $data['main_content'] = 'categories/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_category_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/categories/');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Category successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/categories/');
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
    		$this->form_validation->set_rules('item_id[]', 'Category', 'trim|required');

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' category(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/categories');
    	}
    }

	/* Check category name validation */
	public function deplicate_category($name) {

    	if($this->Product_model->deplicate_category($name)) {
        	$this->form_validation->set_message('deplicate_category', 'Category / Sub-Category already exists.');
    		return FALSE;
    	} else {
     		return TRUE;
     	}
	}
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
