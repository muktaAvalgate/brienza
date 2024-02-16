<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedules extends Application_Controller {

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
 	private $tablename = 'schedules';
 	private $url = '/app/schedules';
 	private $permissionValues = array(
 		'index' => 'App.Schedules.View',
 		'add' => 'App.Schedules.Add',
 		'edit' => 'App.Schedules.Edit',
        'delete' => 'App.Schedules.Delete',
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

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

        // Get the total rows without limit
	    $total_rows = $this->App_model->get_schedule_list($filter, 'created_on', 'desc', true);

	    $config = $this->init_pagination('app/schedules/index/page/', 5, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;


	    // Get the Schools List
	    $data['list'] = $this->App_model->get_schedule_list($filter, 'created_on', 'desc');

		//print "<pre>"; print_r($data); die;
        $data['filter'] = $filter;
    	$data['page'] = 'schedules';
    	$data['page_title'] = SITE_NAME.' :: Schedule Management';

    	$data['main_content'] = 'schedules/list';
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
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('workingdays[]', 'Working Days', 'trim|required');
			$this->form_validation->set_rules('holidays[]', 'Holidays', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
				//print "<pre>"; print_r($_POST); die;
				$workingdays = $this->input->post('workingdays');
				$holidays = $this->input->post('holidays');
				
    			$data = array(
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($schedule_id = $this->App_model->insert($this->tablename, $data)) {                    
					// Add Schedule Holidays
					$this->App_model->replace_schedule_holidays($schedule_id, $holidays);
					
					// Add Schedule Workingdays
					$this->App_model->replace_schedule_workingdays($schedule_id, $workingdays);
					
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule has been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
    			}
    			redirect($this->url);
    		} //validation run
    	}
		
		// Get the Holiday List
	    $data['holidays'] = $this->App_model->get_holiday_list(array('deleted'=>0,'batch'=>date('Y')));
		
		// Get the days list
		$data['weekdays'] = $this->get_weekdays();
		
    	$data['page'] = 'schedules';
    	$data['page_title'] = SITE_NAME.' :: Schedules Management &raquo; Add Schedule';

    	$data['main_content'] = 'schedules/add';
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
	    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('workingdays[]', 'Working Days', 'trim|required');
			$this->form_validation->set_rules('holidays[]', 'Holidays', 'trim|required');

     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
				$workingdays = $this->input->post('workingdays');
				$holidays = $this->input->post('holidays');
				
                $data = array(
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

                //print "<pre>"; print_r($data); print "</pre>"; die;
     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data)) {
					
					// Add Schedule Holidays
					$this->App_model->replace_schedule_holidays($id, $holidays);
					
					// Add Schedule Workingdays
					$this->App_model->replace_schedule_workingdays($id, $workingdays);
					
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			redirect($this->url);
     		} //validation run
     	}

     	$data['schedule']  = $this->App_model->get_schedule_details($id);
		
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['schedule'])) {
     		redirect($this->url);
     	}

		// Get the Holiday List
	    $data['holidays'] = $this->App_model->get_holiday_list(array('deleted'=>0,'batch'=>date('Y')));
		
		// Get the days list
		$data['weekdays'] = $this->get_weekdays();
		
     	$data['page'] = 'schedules';
    	$data['page_title'] = SITE_NAME.' :: Schedule Management &raquo; Edit Schedule';

    	$data['main_content'] = 'schedules/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     */
    public function update_status() {

		// Permission Checking
		// parent::checkMethodPermission($this->permissionValues[$this->router->method]);
		parent::checkActionPermission($this->permissionValues[$this->router->method]);

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'Schedule', 'trim|required');

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' schedule(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect($this->url);
    	}
    }

    public function delete($id = null) {

        $is_assigned = $this->App_model->get_schedule_in_assigned_school($id);
        // echo $is_assigned; die();
        if(!empty($is_assigned)){
            // echo 'no delete'; die();
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Cannot delete this holiday schedule as this is already assigned to school.');
            redirect($this->url);
        }else{
            $data['schedule']  = $this->App_model->get_schedule_details($id);
        
            //print "<pre>";print_r($data);die;
            if (!is_numeric($id) || $id == 0 || empty($data['schedule'])) {
                redirect($this->url);
            }

            $data_to_store = array(
                'is_deleted' => 1
            );

            if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done!</strong> Schedule successfully deleted.');
            } else {
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
            }
            redirect($this->url);
        }
    }
	
	
	private function get_weekdays() {

		$timestamp = strtotime('next Sunday');
		$days = array();
		for ($i = 0; $i < 7; $i++) {
			$days[] = strftime('%A', $timestamp);
			$timestamp = strtotime('+1 day', $timestamp);
		}

		return $days;
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

}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
