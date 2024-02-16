<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Titles extends Application_Controller {

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
    private $tablename = 'titles';
    private $url = '/app/titles';
    private $permissionValues = array(
 		'index' => 'App.Titles.View',
 		'add' => 'App.Titles.Add',
 		'edit' => 'App.Titles.Edit',
        'delete' => 'App.Titles.Delete',
        'update_status' => 'App.Titles.UpdateStatus',
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
        $search['deleted'] = 0;

        $data['list'] = $this->App_model->get_title_list($search);
        $data['page'] = 'titles';
    	$data['page_title'] = SITE_NAME.' :: Title Management';

    	$data['main_content'] = 'titles/list';
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
    		$this->form_validation->set_rules('name', 'Title Name', 'trim|required');
			//$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
			
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			$topics = $this->input->post('topics');
                $description = $this->input->post('description');
				//new implementation for validation in topics and description field
                $newTopics = array();
                $newDescription = array();
                for($i=0; $i<count($topics); $i++){
					$trim_topics = trim($topics[$i]);
					$len = strlen($trim_topics);
					if($len == 0){
						$topics[$i] = '';
					}
                    if($topics[$i] != ''){
                        $newTopics[] = $topics[$i];
                        $newDescription[] = $description[$i];
                    }
                }
                // echo '<pre>'; print_r($newTopics);
                // echo '<pre>'; print_r($newDescription); die();
                //end of new implementationfor validation in topics and description field
    			$data_to_store = array(
    				'grade_teachers' => htmlspecialchars($this->input->post('grade_teachers'), ENT_QUOTES, 'utf-8'),
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			//if the insert has returned true then we show the flash message
    			if ($title_id = $this->App_model->insert($this->tablename, $data_to_store)) {
					// Insert Title Topics
					$this->App_model->replace_title_topic($title_id, $newTopics, $newDescription);
					
    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Title has been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Title already exists.');
    			}
    			redirect('/app/titles/');
    		} //validation run
    	}

        $data['page'] = 'titles';
    	$data['page_title'] = SITE_NAME.' Title Management &raquo; Add Title';

        $data['main_content'] = 'titles/add';
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
    		$this->form_validation->set_rules('name', 'Title Name', 'trim|required');
			//$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
			
     		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');

     		//if the form has passed through the validation
     		if ($this->form_validation->run())
     		{
     			$topics = $this->input->post('topics');
                $description = $this->input->post('description');
                $topic_title_id = $this->input->post('topic_title_id');
				//new implementation for validation in topics and description field
                $newTopics = array();
                $newDescription = array();
                for($i=0; $i<count($topics); $i++){
					$trim_topics = trim($topics[$i]);
					$len = strlen($trim_topics);
					if($len == 0){
						$topics[$i] = '';
					}
                    if($topics[$i] != ''){
                        $newTopics[] = $topics[$i];
                        $newDescription[] = $description[$i];
                    }
                }
                // echo '<pre>'; print_r($newTopics);
                // echo '<pre>'; print_r($newDescription); die();
                //end of new implementationfor validation in topics and description field
     			$data_to_store = array(
    				'name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
					'grade_teachers' => htmlspecialchars($this->input->post('grade_teachers'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
                    'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
     			);

     			//if the insert has returned true then we show the flash message
     			if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
					// Insert Title Topics
					//$this->App_model->update_title_topic($id, $newTopics, $newDescription, $topic_title_id);
					// start 09-09-2021
                    if(empty($newTopics)){
                        $this->App_model->delete_title($id);
                    }else{
                        $this->App_model->update_title_topic($id, $newTopics, $newDescription, $topic_title_id);
                    }
                    // end
     				$this->session->set_flashdata('message_type', 'success');
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Title successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}
     			redirect('/app/titles/');
     		} //validation run
     	}

     	$data['title'] = $this->App_model->get_title_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['title'])) {
     		redirect('/app/titles/');
     	}

        //print "<pre>"; print_r($data); print "</pre>"; die;
     	$data['page'] = 'titles';
    	$data['page_title'] = SITE_NAME.' Title Management &raquo; Edit Title';

        $data['main_content'] = 'titles/edit';
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
        // echo "<pre>";print_r($data);exit;

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/titles/');
    	}
        if(!empty($data['info']) && $data['info']->order_id !=''){
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Title is already associated with order so you cannot delete.');
            redirect('/app/titles/');
        }

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Title successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/titles/');
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
    		$this->form_validation->set_rules('item_id[]', 'Title', 'trim|required');

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

                        $data['info'] = $this->App_model->get_category_details($id);

                        if(!empty($data['info']) && $data['info']->order_id ==''){
                            $data_to_store = array(
                                'is_deleted' => 1
                            );
                            if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
                                $count++;
                            }
                        }

    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "active")?'active':'inactive'
				    	);
                        if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
                            $count++;
                        }
    				}

    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' title(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/titles');
    	}
    }

	/* Check category name validation */
	public function deplicate_category($name) {

    	if($this->Product_model->deplicate_category($name)) {
        	$this->form_validation->set_message('deplicate_category', 'Title / Sub-Title already exists.');
    		return FALSE;
    	} else {
     		return TRUE;
     	}
	}
	// added 09-09-2021
    public function remove_titles(){
        $id = $this->input->post('id');
        $this->App_model->remove_titles($id);
		echo 1;
    }
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
