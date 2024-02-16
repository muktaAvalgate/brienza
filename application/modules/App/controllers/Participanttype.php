<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participanttype extends Application_Controller {

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
    private $tablename = 'participants';
    private $url = '/app/participanttype';
    private $permissionValues = array(
 		'index' => 'App.Participanttype.View',
 		'add' => 'App.Participanttype.Add',
 		'edit' => 'App.Participanttype.Edit',
        'delete' => 'App.Participanttype.Delete',
        'update_status' => 'App.Participanttype.UpdateStatus',
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

        $data['list'] = $this->App_model->get_participant_list($search);
        $data['page'] = 'participants';
    	$data['page_title'] = SITE_NAME.' :: Participant Management';

    	$data['main_content'] = 'participant/participant_list';
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
    		$this->form_validation->set_rules('name', 'Participant Name', 'trim|required');
			
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
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> Participant has been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Participant already exists.');
    			}
    			redirect('/app/participanttype/');
    		} //validation run
    	}

        $data['page'] = 'participants';
    	$data['page_title'] = SITE_NAME.' Participant Management &raquo; Add Participant';

        $data['main_content'] = 'participant/add';
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
    		$this->form_validation->set_rules('name', 'Participant Name', 'trim|required');
			
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
     				$this->session->set_flashdata('message', '<strong>Well done!</strong> Participant successfully updated.');
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}
     			redirect('/app/participanttype/');
     		} //validation run
     	}

     	// $data['grade'] = $this->App_model->get_program_details($id);
     	$data['grade'] = $this->App_model->get_participant_category_details($id);
        // echo '<pre>';print_r($data);echo '</pre>';
     	if (!is_numeric($id) || $id == 0 || empty($data['grade'])) {
     		redirect('/app/participanttype/');
     	}

        //print "<pre>"; print_r($data['list']); print "</pre>"; die;
     	$data['page'] = 'participants';
    	$data['page_title'] = SITE_NAME.' Participant Management &raquo; Edit Participant';

        $data['main_content'] = 'participant/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_participant_category_details($id);
        // echo '<pre>';print_r($data);echo '</pre>';die;

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/participanttype/');
    	}

		$data_to_store = array(
			'is_deleted' => 1
		);

      	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Participant successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/participanttype/');
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
    		$this->form_validation->set_rules('item_id[]', 'Programs', 'trim|required');

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

                        $data['info'] = $this->App_model->get_participant_category_details($id);

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
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' participant(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/participanttype');
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

	public function check_title_assigned_to_school(){
		$id = $this->input->post('title_id');
		$check = $this->App_model->check_title_assigned_to_school($id);
		if($check == true){
			echo 1;
		}else{
			echo 2;
		}
	}

	// suggestive log fr admin 10-03-2023

	public function add_log_templates($id){
        $default_uri = array('page');
        $uri = $this->uri->uri_to_assoc(4, $default_uri);
        
        // $uri = $this->uri->uri_to_assoc(4, $default_uri);
        $pegination_uri =array();
        $filter = array();

        if (isset($uri['page']) && $uri['page'] > 0) {
            $page = $uri['page'];
        } else {
            $page = 0;
        }
        // Get the total rows without limit
        $total_rows_get_admin_library_list = $this->App_model->get_admin_library_list($id,$filter, true);
        $config = $this->init_pagination('app/titles/add_log_templates/'.$id.'/'.$this->uri->assoc_to_uri($pegination_uri).'/page/', 5, $total_rows_get_admin_library_list);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }

        $filter['limit'] = $config['per_page'];
        $filter['offset'] = $limit_end;

        $data['admin_library_list'] = $this->App_model->get_admin_library_list($id,$filter, false);
        $data['title_id'] = $id;
        $data['page'] = 'titles';
        $data['page_title'] = SITE_NAME.' Title Management &raquo; Edit Title';

        $data['main_content'] = 'titles/library_topic_list';
        $this->load->view(TEMPLATE_PATH, $data);
    }

	public function add_library_template_for_admin($title_id){
        // $data['admin_library_list'] = $this->App_model->get_admin_library_list($id,$filter, false);
        // echo $title_id;
        $data['title_id'] = $title_id;
        $data['template_topic_id'] = $this->App_model->get_topic_from_admin_library_template();
        $data['topic_list'] = $this->App_model->get_topics_list_by_title($title_id);
        // echo '<pre>'; print_r($data['topic_list']);
        // $template_topic_id = $this->App_model->get_topic_from_custom_template($id);
        $data['page'] = 'titles';
        $data['page_title'] = SITE_NAME.' Title Management &raquo; Edit Title';

        $data['main_content'] = 'titles/add_library_template';
        $this->load->view(TEMPLATE_PATH, $data);
    }

	public function viewTemplateModal(){
        $template_id = $this->input->post('id');
        $message = $this->App_model->get_template_message_by_admin($template_id);
        $message_val =  $message->description;

        $message_with_break = str_replace("\n","<br>", $message_val);
        $message->final_message = $message_with_break;
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($message));
        return;
    }

	public function add_library_template(){

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // echo $actual_link; die;
        $url=explode('/',$actual_link);
        // echo '<pre>'; print_r($url);die;
        $title_id= $url['6'];
        

        if ($this->input->server('REQUEST_METHOD') === 'POST')
       {
            $this->form_validation->set_rules('topic', 'Topic', 'trim|required');
        //    $this->form_validation->set_rules('tmp_name', 'Subject', 'trim|required');
           $this->form_validation->set_rules('message', 'Message', 'trim|required');
          
 
           if ($this->form_validation->run())
           {
                $topic = $this->input->post('topic');
            //    $tmp_name = htmlspecialchars($this->input->post('tmp_name'), ENT_QUOTES, 'utf-8');
               $message = $this->input->post('message');
            //    $message_with_break = str_replace("\n","<br>", $message);
               

            //    print($message_with_break);die;
 
               $data = array(
                    'topic_id' => $topic,
                //    'tmp_name' => $tmp_name,
                   'description' => $message,
                   'created_by' => $this->session->userdata('id'),
                   'title_id' => $title_id
               );
               if ( $this->App_model->insert('admin_library_topic', $data)){
 
 
                   $this->session->set_flashdata('message_type', 'success');
                   $this->session->set_flashdata('message', '<strong>Well done!</strong> Template successfully added. ');
                   redirect('/app/titles/add_log_templates/'.$title_id);
               }else{
                   $this->session->set_flashdata('message_type', 'danger');
                   $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                   redirect('/app/titles/add_log_templates/'.$title_id);
               }
           }else{ //validation run
               $this->session->set_flashdata('message_type', 'danger');
               $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
               redirect('/app/titles/add_log_templates/'.$title_id);
           }
       }
        // $data['template_topic_id']=$template_topic_id;
        //  $data['topic']=$result;
        $data['template_topic_id'] = $this->App_model->get_topic_from_admin_library_template();
        $data['topic_list'] = $this->App_model->get_topics_list_by_title($title_id);
        $data['main_content'] = 'titles/add_library_template/';
        $this->load->view(TEMPLATE_PATH, $data);
    }

	public function library_template_delete($id,$title_id){
        // echo $title_id; die;
        $this->App_model->delete('admin_library_topic',$id);
        $this->session->set_flashdata('message_type', 'success');
        $this->session->set_flashdata('message', '<strong>Well done!</strong> Template successfully Deleted.');
        redirect('/app/titles/add_log_templates/'.$title_id);
    }

	public function library_template_edit($id,$title_id){
        // echo $id;
        
        $get_library_tmplate = $this->App_model->get_library_tmplate($id);
        // $result = $this->App_model->get_library_topic_list($presenter_id);
        
        // echo '<pre>'; print_r($data['topic_list']);
        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            // $this->form_validation->set_rules('tmp_name', 'Subject', 'trim|required');
            $this->form_validation->set_rules('topic', 'Topic', 'trim|required');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');

            if ($this->form_validation->run())
            {
            
                // $tmp_name = htmlspecialchars($this->input->post('tmp_name'), ENT_QUOTES, 'utf-8');
                $topic = $this->input->post('topic');
                $message = $this->input->post('message');
                // print_r($message);die;

                $data = array(
                    // 'tmp_name' => $tmp_name,
                    'topic_id' => $topic,
                    'description' => $message,
                    // 'created_by' => $this->session->userdata('id'),
                    // 'created_on' => date('Y-m-d H:i:s')
                );
                $this->App_model->update('admin_library_topic', 'id', $id, $data);

                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done! </strong> The template has been successfully updated.');

                redirect('/app/titles/add_log_templates/'.$title_id);
            }
       }else{

            $data['topic_list'] = $this->App_model->get_topics_list_by_title($title_id);
            $data['template_topic_id'] = $this->App_model->get_topic_from_admin_library_template();
            $data['log_content'] = $get_library_tmplate;
            $data['title_id']=$title_id;
            $data['main_content'] = 'titles/edit_library_template';
            $this->load->view(TEMPLATE_PATH, $data);
       }
    }

    public function title_topic_check(){
        // echo 'Hii';
        $title_id = $this->input->post('title_id');
        $title_topic_list = $this->App_model->get_topics_list_by_title($title_id);

        if($title_topic_list == false){
            echo false;
        }else{
            // $library_topic_text =  $library_topic_text->description;
            echo $true;
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

        $ci->pagination->initialize($config);
        return $config;
    }

}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
