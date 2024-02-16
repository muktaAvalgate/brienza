<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_storage extends Application_Controller {

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
	private $tablename = 'reports_storage';
	private $url = '/app/reports_storage';
	private $permissionValues = array(
									'index' 					=> 'App.Reports_storage.View',
									'add' 						=> 'App.Reports_storage.Add',
									'delete' 					=> 'App.Reports_storage.Delete',
									'update_status' 			=> 'App.Reports_storage.UpdateStatus',
														
									);
																																																																																																																																																																																																																																																																																																								
	private $role 		= 5; // Presenter Role ID
	private $role_token = 'reports_storage';

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

    	$data['filters'] 	= $uri;
    	$data['filter']     = $filter;
	    $data['page'] 		= 'reports_storage';
    	$data['page_title'] = SITE_NAME.' :: Reports storage Management';

    	$data['main_content'] = 'reports_storage/list';
    	//echo "<pre>";print_r($data);die;

    	$this->load->view(TEMPLATE_PATH, $data);
	}

	 public function add() {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
     		//form validation
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[50]');
			//$this->form_validation->set_rules('file1', 'Report File', 'required');
			
			 $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'title' 	=> htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
				
					'created_by' 	=> $this->session->userdata('id'),
     			   	'created_on' 	=> date('Y-m-d H:i:s')
    			);
    			//echo "<pre>";print_r($data);die;
    			$rate_file = $_FILES['file1'];

				// Upload Category Image
    			if (!empty($rate_file['name'])) {

	    			$config['upload_path'] = DIR_REPORT_FILES;
					$config['max_size'] = '5000';
					$config['allowed_types'] = 'pdf|doc|docx';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					

				    $this->load->library('upload', $config);

					$config['file_name'] = 'report-'.rand().date('YmdHis');
					
					$this->upload->initialize($config);
// echo "<pre>";print_r($this->upload->do_upload('file'));die;
					if (!$this->upload->do_upload('file1')) {
						//echo "<pre>";print_r($this->upload->display_errors());die;
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', $this->upload->display_errors());
					

                        redirect('/app/reports_storage/add');
					} else {

						$upload_data =  $this->upload->data();
						$data['file'] = $upload_data['file_name'];


					}
	     		}
			
	     		//echo "<pre>";print_r($data['file']);die;
    			//if the insert has returned true then we show the flash message
				if ($this->Reports_storage_model->insert($this->tablename, $data)) 
				{
					$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Report has been added successfully.');
				} 
				else 
				{
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong>  Something wrong please try again.');
    			}
    			redirect('/app/reports_storage');
    		} //validation run
    	}
		
    	$data['page'] = 'reports_storage';
    	$data['page_title'] = SITE_NAME.' :: Reports Storage Management &raquo; Add Reports Storage';

    	$data['main_content'] = 'reports_storage/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


      public function delete($id = null) {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->Reports_storage_model->get_report_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/reports_storage');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->Reports_storage_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Report successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/reports_storage');
    }

      public function update_status() {

			// Permission Checking
			//parent::checkMethodPermission($this->permissionValues[$this->router->method]);

	    	if ($this->input->server('REQUEST_METHOD') === 'POST')
	    	{
	    		//form validation
	    		$this->form_validation->set_rules('operation', 'Operation', 'required');
	    		$this->form_validation->set_rules('item_id[]', 'Reports', 'trim|required');

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
	    				} 
	    				else {
							$data_to_store = array(
					    		'status' => ($operation == "active")?'active':'inactive'
					    	);
	    				}

						if ($this->Reports_storage_model->update($this->tablename, 'id', $id, $data_to_store)) {
							$count++;
						}
	    			}

	    			$msg = ($operation=='delete')?'deleted.':'updated.';

	    			$this->session->set_flashdata('message_type', 'success');
	    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' reports(s) successfully '.$msg);

	    		} else {
	    			$this->session->set_flashdata('message_type', 'danger');
	    			$this->session->set_flashdata('message', validation_errors());
	    		}
	    		redirect($this->url);
	    	}
    }


    


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


}
