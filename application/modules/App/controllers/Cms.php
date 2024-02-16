<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends Application_Controller {

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
	private $tablename = 'cms';
	private $url = '/app/cms';
	private $permissionValues = array(
		'index' => 'App.CMS.View',
		'edit' => 'App.CMS.Edit',
    );

    //private $allowed_roles = array('bar_admin');

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

	    // Get the bars List
	    $data['cms'] = $this->App_model->get_cms_list(array(), 'name', 'asc');

	    $data['page'] = 'cms';
    	$data['page_title'] = SITE_NAME.' :: Content Management System';

    	$data['main_content'] = 'cms/list';
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
		add_css('assets/css/bootstrap-wysihtml5.css');
		add_js('assets/js/plugins/wysihtml5-0.3.0.min.js');
		add_js('assets/js/plugins/bootstrap3-wysihtml5.js');
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');

     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
     		//form validation
			$this->form_validation->set_rules('page_type', 'Page URL', 'trim|required|alpha_dash');
     		$this->form_validation->set_rules('name', 'Page Name', 'trim|required');
	    	$this->form_validation->set_rules('description', 'Content', 'trim|required');
			$this->form_validation->set_rules('title', 'Meta Title', 'trim|required');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

			//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
     			$data = array(
					'page_type' => htmlspecialchars($this->input->post('page_type'), ENT_QUOTES, 'utf-8'),
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'description' => $this->input->post('description'),
					'title' => htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
					'meta_keyword' => htmlspecialchars($this->input->post('meta_keyword'), ENT_QUOTES, 'utf-8'),
					'meta_description' => htmlspecialchars($this->input->post('meta_description'), ENT_QUOTES, 'utf-8'),
     				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data)) {
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> CMS page successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}
     			redirect('/app/cms');
     		} //validation run
     	}

     	$data['cms']  = $this->App_model->get_cms_details($id);
     	if (!is_numeric($id) || $id == 0 || empty($data['cms'])) {
     		redirect('/app/cms');
     	}

     	$data['page'] = 'cms';
    	$data['page_title'] = SITE_NAME.' :: Content Management System &raquo; Edit Page';

    	$data['main_content'] = "cms/edit";
    	$this->load->view(TEMPLATE_PATH, $data);
	}


	/**
	 */
   	private function format_date($date) {
	   if ($date == "")
	   	return "";

	   $newdate = date_create($date);
	   return date_format($newdate,"Y-m-d");
   }
}
