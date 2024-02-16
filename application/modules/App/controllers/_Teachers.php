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
    }



    public function index() {

        // Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

        // Include the Module JS file.
		add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');

        // Set the filters
        $filter = array('deleted' => 0);

        $default_uri = array('page');
        $uri = $this->uri->uri_to_assoc(2, $default_uri);
        //$pegination_uri = array();

        // Get the category List
        $cat_filter = array('deleted' => 0, 'status' => 'active', 'parent_id' => 0, 'tag' => "&ndash;");
        $data['categories'] = $this->App_model->get_category_by_parent($cat_filter);


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

		//print "<pre>"; print_r($data); die;
        $data['filter'] = $filter;
    	$data['page'] = 'teachers';
    	$data['page_title'] = SITE_NAME.' :: Products Management';

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
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		$this->form_validation->set_rules('info', 'Info', 'trim|required');
	    	$this->form_validation->set_rules('rate', 'Rate', 'trim|required|numeric');

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    		//if the form has passed through the validation

    		if ($this->form_validation->run())
    		{
    			$data = array(
					'category_id' => htmlspecialchars($this->input->post('category_id'), ENT_QUOTES, 'utf-8'),
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    'info' => $this->input->post('info'),
                    'rate' => htmlspecialchars($this->input->post('rate'), ENT_QUOTES, 'utf-8'),
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

        $filter['parent_id'] = 0;
        $filter['tag'] = "&ndash;";
        $data['categories'] = $this->App_model->get_category_by_parent($filter);
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
	public function edit($id = 0) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    		$this->form_validation->set_rules('info', 'Info', 'trim|required');
	    	$this->form_validation->set_rules('rate', 'Rate', 'trim|required|numeric');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
                $data = array(
					'category_id' => htmlspecialchars($this->input->post('category_id'), ENT_QUOTES, 'utf-8'),
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    'info' => $this->input->post('info'),
                    'rate' => htmlspecialchars($this->input->post('rate'), ENT_QUOTES, 'utf-8'),
                    'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

                //print "<pre>"; print_r($data); print "</pre>"; die;
     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data)) {
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Teacher successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect($this->url);
     		} //validation run
     	}

     	$data['teacher']  = $this->App_model->get_teacher_details($id);
		
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['teacher'])) {
     		redirect('/app/teachers');
     	}

        $filter = array(
            'deleted' => 0,
            'status' => 'active'
        );

        $filter['parent_id'] = 0;
        $filter['tag'] = "&ndash;";
        $data['categories'] = $this->App_model->get_category_by_parent($filter);
        //print "<pre>"; print_r($data); die;

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
	

    // Product Search form submit
    public function search_submit() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$name = $this->clean_value($this->input->post('name'));
    		$manufacturer_id = $this->clean_value($this->input->post('manufacturer_id'));
			$category_id = $this->clean_value($this->input->post('category_id'));
			$exp_date = $this->clean_value($this->input->post('exp_date'));

			$url = "app/products/index/";

            if ($name != '') {
                $url .= "name/". urlencode($name)."/";
            }

			if ($manufacturer_id != '') {
				$url .= "manufacturer_id/". urlencode($manufacturer_id)."/";
			}

			if ($category_id != '') {
				$url .= "category_id/". urlencode($category_id) ."/";
			}

			if ($exp_date != '') {
				$url .= "exp_date/". urlencode($exp_date)."/";
			}

			redirect($url);
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
}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
