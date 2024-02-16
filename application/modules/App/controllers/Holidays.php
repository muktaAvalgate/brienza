<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holidays extends Application_Controller {

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
 	private $tablename = 'holidays';
 	private $url = '/app/holidays';
 	private $permissionValues = array(
 		'index' => 'App.Holidays.View',
 		'add' => 'App.Holidays.Add',
 		'edit' => 'App.Holidays.Edit',
        'delete' => 'App.Holidays.Delete',
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
	    $total_rows = $this->App_model->get_holiday_list($filter, 'created_on', 'desc', true);

	    $config = $this->init_pagination('app/holidays/index/page/', 5, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;


	    // Get the Schools List
	    $data['list'] = $this->App_model->get_holiday_list($filter, 'created_on', 'desc');

		//print "<pre>"; print_r($data); die;
        $data['filter'] = $filter;
    	$data['page'] = 'holidays';
    	$data['page_title'] = SITE_NAME.' :: Holiday Management';

    	$data['main_content'] = 'holidays/list';
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
			$this->form_validation->set_rules('batch', 'Batch', 'trim|required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'batch' => htmlspecialchars($this->input->post('batch'), ENT_QUOTES, 'utf-8'),
					'start_date' => $this->format_date(htmlspecialchars($this->input->post('start_date'), ENT_QUOTES, 'utf-8')),
					'end_date' => $this->format_date(htmlspecialchars($this->input->post('end_date'), ENT_QUOTES, 'utf-8')),
    			);

    			//if the insert has returned true then we show the flash message
    			// --start---checking wheather batch year is equals to date year
               
                $expld_syear = explode("-", $data['start_date']);
                $expld_eyear = explode("-", $data['end_date']);
              
                if($expld_syear[0] == $data['batch']){
                    if($expld_eyear[0] == $data['batch'] || $expld_eyear[0] == ''){
                        
                        //if the insert has returned true then we show the flash message
                        if($schedule_id = $this->App_model->insert($this->tablename, $data)){                    
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('message', '<strong>Well done!</strong> Holiday has been added successfully.');
                            redirect($this->url);
                        }else{
                           
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please try again.');
                            redirect($this->url);
                        }
                    }else{
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', '<strong>Oh snap!</strong> The batch year and the holiday year should be the same.');
                        // redirect($this->url);
						redirect('/app/holidays/add');
                    }
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> The batch year and the holiday year should be the same.');
                    // redirect($this->url);
					redirect('/app/holidays/add');
                }
                // end 
    		} //validation run
    	}
		
    	$data['page'] = 'holidays';
    	$data['page_title'] = SITE_NAME.' :: Holidays Management &raquo; Add Holiday';

    	$data['main_content'] = 'holidays/add';
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
			$this->form_validation->set_rules('batch', 'Batch', 'trim|required');
			$this->form_validation->set_rules('start_date', 'Date', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$data = array(
					'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'batch' => htmlspecialchars($this->input->post('batch'), ENT_QUOTES, 'utf-8'),
					'start_date' => $this->format_date(htmlspecialchars($this->input->post('start_date'), ENT_QUOTES, 'utf-8')),
					'end_date' => $this->format_date(htmlspecialchars($this->input->post('end_date'), ENT_QUOTES, 'utf-8')),
    			);

           
     			//if the insert has returned true then we show the flash message
     		// --start---checking wheather batch year is equals to date year
                
                $expld_syear = explode("-", $data['start_date']);
                $expld_eyear = explode("-", $data['end_date']);
               
                if($expld_syear[0] == $data['batch']){
                    if($expld_eyear[0] == $data['batch'] || $expld_eyear[0] == ''){
                        
                        //if the insert has returned true then we show the flash message
                        if ($this->App_model->update($this->tablename, 'id', $id, $data)){                    
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('message', '<strong>Well done!</strong> Holiday successfully updated.');
                            redirect($this->url);
                        }else{
                            
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                            redirect($this->url);
                        }
                    }else{
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', '<strong>Oh snap!</strong> The batch year and the holiday year should be the same.');
                        // redirect($this->url);
						redirect('/app/holidays/edit/'.$id);
                    }
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', '<strong>Oh snap!</strong> The batch year and the holiday year should be the same.');
                    // redirect($this->url);
					redirect('/app/holidays/edit/'.$id);
                }
                // end 
     		} //validation run
     	}

     	$data['holiday']  = $this->App_model->get_holiday_details($id);
		
     	if (!is_numeric($id) || $id == 0 || empty($data['holiday'])) {
     		redirect($this->url);
     	}
		
     	$data['page'] = 'holidays';
    	$data['page_title'] = SITE_NAME.' :: Holiday Management &raquo; Edit Holiday';

    	$data['main_content'] = 'holidays/edit';
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
    		$this->form_validation->set_rules('item_id[]', 'Holiday', 'trim|required');

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' holiday(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect($this->url);
    	}
    }

    public function delete($id = null) {

        $data['holiday']  = $this->App_model->get_holiday_details($id);
		
        //print "<pre>";print_r($data);die;
     	if (!is_numeric($id) || $id == 0 || empty($data['holiday'])) {
     		redirect($this->url);
     	}

        $data_to_store = array(
            'is_deleted' => 1
        );

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Holiday successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect($this->url);
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
