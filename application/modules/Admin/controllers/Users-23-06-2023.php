<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Application_Controller {

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
	private $tablename = 'users';

	private $permissionValues = array(
		'index' => 'Admin.Users.View',
		'add' => 'Admin.Users.Add',
		'edit' => 'Admin.Users.Edit',
		'reset_pass' => 'Admin.Users.ResetPass',
        'delete' => 'Admin.Users.Delete',
    );

    private $module_dir;

	public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->module_dir = APPPATH.'modules/'.$this->router->fetch_module();
        $this->load->model('Admin_model');
        $this->load->config('config');
    }

	public function index() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		$default_uri = array('role', 'status', 'page');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);

    	$role = $uri['role'];
		$status = $uri['status'];

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}

    	// Create the filters
	    $filter = array();

	    if ($role > 0) {
		    $filter['role'] = $role;
	    } else {
	    	$role = 0;
	    }

	    if ($status <> '') {
		    $filter['status'] = $status;
	    } else {
	    	$status = 0;
	    }

	    // Get the total rows without limit
	    $total_rows = $this->Admin_model->get_users_list($filter, 'id', 'asc', true);

	    $config = $this->init_pagination('admin/users/index/'.$this->uri->assoc_to_uri(array('role' => $role, 'status' => $status)).'/page/', 9, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the Users List
	    $data['users'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');

	    // Get the Roles List (for tab)
	    $data['roles'] = $this->Admin_model->get_roles_list();
    	//print "<pre>"; print_r($data);print "</pre>";
    	$data['filters'] = $uri;
	    $data['page'] = 'users';
    	$data['page_title'] = SITE_NAME.' :: Users Management';

    	$data['main_content'] = 'users/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


    /**
     *
     */
    public function add() {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
    	$config = $this->config->item('module_config');

    	$data['user_meta'] = $config['users']['meta'];

    	//if save button was clicked, get the data sent via post
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
     		//form validation
     		$this->form_validation->set_rules('role_id', 'Role', 'trim|required');
    		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
    		$this->form_validation->set_rules('email', 'Email address', 'trim|required|callback_check_email');
	    	$this->form_validation->set_rules('password', 'Password', 'matches[c_password]');
	    	$this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');

			// Custom field validation
	    	foreach ($data['user_meta'] as $fields) {
	    		$field_name = $fields['attributes']['name'];
	    		$field_label = $fields['label'];
	    		if (isset($fields['attributes']['required']) && $fields['attributes']['required'] == true) {
	    			$this->form_validation->set_rules($field_name, $field_label, 'required');
	    		}
	    	}
    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
    		//if the form has passed through the validation

    		if ($this->form_validation->run())
    		{
				$raw_password = htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8');

    			$user = array(
					'first_name' => htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
					'last_name' => htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
    				'role_id' => htmlspecialchars($this->input->post('role_id'), ENT_QUOTES, 'utf-8'),
    				'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
    				'password' => md5($raw_password),
    				'created_by' => $this->session->userdata('id'),
     				'created_on' => date('Y-m-d H:i:s')
    			);

    			$meta = $this->input->post('meta');

    			//if the insert has returned true then we show the flash message
    			if ($user_id = $this->Admin_model->insert($this->tablename, $user)) {

    				// Insert the Mata Data
    				$this->Admin_model->replace_user_meta($user_id, $meta);

					// Send Email to users
					$this->load->library('mail_template');
    				$this->mail_template->new_user_email($user['first_name'] . " " .$user['last_name'], $user['email'], $raw_password);

    				$this->session->set_flashdata('message_type', 'success');
    				$this->session->set_flashdata('message', '<strong>Well done!</strong> User have been added successfully.');
    			} else {
    				$this->session->set_flashdata('message_type', 'danger');
    				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> User already exists.');
    			}
    			redirect('/admin/users');
    		} //validation run
    	}

		// Roles List (for dropdown)
    	$data['roles'] = $this->Admin_model->get_roles_list(); //array('token' => 'bar_admin')

    	$data['page'] = 'users';
    	$data['page_title'] = SITE_NAME.' :: User Management &raquo; Add User';

    	$data['main_content'] = 'users/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


	/**
	 *
	 * @param unknown_type $id
	 */
	public function edit($id = 0) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		if ($id === 0) {
			$id = $this->session->userdata('id');
		}

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
    	$config = $this->config->item('module_config');

    	$data['user_meta'] = $config['users']['meta'];

     	//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{

     		//form validation
     		$this->form_validation->set_rules('role_id', 'Role', 'trim|required');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			// $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
    		$this->form_validation->set_rules('email', 'Email address', 'trim|required');

    		if ($this->input->post('password')) {
	    		$this->form_validation->set_rules('password', 'Password', 'matches[c_password]');
	    		$this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');
    		}

     		// Custom field validation
	    	foreach ($data['user_meta'] as $fields) {
	    		$field_name = $fields['attributes']['name'];
	    		$field_label = $fields['label'];
	    		if (isset($fields['attributes']['required']) && $fields['attributes']['required'] == true) {
	    			$this->form_validation->set_rules($field_name, $field_label, 'required');
	    		}
	    	}

     		// $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			 $this->form_validation->set_error_delimiters('', '');
     		//if the form has passed through the validation

     		if ($this->form_validation->run())
     		{
     			$user = array(
    				'first_name' => htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
					// 'last_name' => htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
					'last_name' =>'',
    				'role_id' => htmlspecialchars($this->input->post('role_id'), ENT_QUOTES, 'utf-8'),
    				'email' => htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8'),
    				'status' => htmlspecialchars($this->input->post('status'), ENT_QUOTES, 'utf-8'),
     				'updated_by' => $this->session->userdata('id'),
     				'updated_on' => date('Y-m-d H:i:s')
    			);

    			$meta = $this->input->post('meta');

    			if ($this->input->post('password')) {
    				$user['password'] = md5(htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8'));
    			}
				
				$pic = $_FILES['profile_pic'];

    			// Upload Pic File
    			if (!empty($pic['name'])) {

	    			$config['upload_path'] = DIR_PROFILE_PICTURE;
					$config['max_size'] = '5000';
					$config['allowed_types'] = 'jpg|png|jpeg|bmp';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;

				    $this->load->library('upload', $config);

					$config['file_name'] = 'pic-'.rand().date('YmdHis');
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('profile_pic')) {
						$this->upload->display_errors(); die;
					} else {

						// Crete thumbnail
						$config_thumb['image_library'] = 'gd2';
						$config_thumb['source_image'] = DIR_PROFILE_PICTURE.$this->upload->file_name;
						$config_thumb['create_thumb'] = FALSE;
						$config_thumb['maintain_ratio'] = TRUE;
						$config_thumb['master_dim'] = 'auto';
						$config_thumb['width'] = PROFILE_THUMB_SIZE; // image re-size  properties
						$config_thumb['height'] = PROFILE_THUMB_SIZE; // image re-size  properties
						$config_thumb['new_image'] = DIR_PROFILE_PICTURE_THUMB.$this->upload->file_name; // image re-size  properties

						$this->load->library('image_lib', $config_thumb); //codeigniter default function

						$this->image_lib->initialize($config_thumb);
						if (!$this->image_lib->resize()) {
							 echo $this->image_lib->display_errors();
						}
						$this->image_lib->clear();
						// ...

						$upload_data =  $this->upload->data();
						$meta['profile_pic'] = $upload_data['file_name'];

						$this->session->set_userdata('profile_pic', $meta['profile_pic']);
					}
	     		}

     			//if the insert has returned true then we show the flash message
     			if ($this->Admin_model->update($this->tablename, 'id', $id, $user)) {

					if(isset($meta['profile_pic'])){
						$check_profile_pic_key = $this->Admin_model->exists_profile_pic_key($id);
						if($check_profile_pic_key){
							$this->Admin_model->update_user_meta_specific($id, $meta);
						}else{
							$this->Admin_model->replace_user_meta($id, $meta);
						}
					}else{
						$this->Admin_model->update_user_meta_specific($id, $meta);
					}

     				// Insert the Mata Data
    				// $this->Admin_model->replace_user_meta($id, $meta);

                    // $this->session->set_userdata('profile_pic', $meta['profile_pic']);

     				$this->session->set_flashdata('message_type', 'success');
     				if ($this->input->post('ref') == 'profile') {
     					$this->session->set_flashdata('message', '<strong>Well done!</strong> Profile successfully updated.');
     				} else {
     					$this->session->set_flashdata('message', '<strong>Well done!</strong> User successfully updated.');
     				}
     			} else{
     				$this->session->set_flashdata('message_type', 'danger');
     				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
     			}

     			// If from profile page - redirect there
     			if ($this->input->post('ref') == 'profile') {
     				redirect('/profile');
     			}

     			redirect('/admin/users');
     		}else{
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', validation_errors());
                redirect('profile');
            }
     	}

     	$data['user']  = $this->Admin_model->get_user_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['user'])) {
     		redirect('/admin/users');
     	}

		// Roles List (for dropdown)
    	$data['roles'] = $this->Admin_model->get_roles_list();

     	$data['page'] = 'users';
    	$data['page_title'] = SITE_NAME.' :: User Management &raquo; Edit User';

    	$data['main_content'] = 'users/edit';
    	$this->load->view(TEMPLATE_PATH, $data);
    }


    /**
     *
     */
    public function update_status() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		//form validation
    		$this->form_validation->set_rules('operation', 'Operation', 'required');
    		$this->form_validation->set_rules('item_id[]', 'User', 'trim|required');

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

    				// Restrict to update yourself
    				if ($id == $this->session->userdata('id')) {
    					continue;
    				}

    				if ($operation == 'delete') {
    					if ($this->Admin_model->delete($this->tablename, $id)) {
	    					$count++;
	    				}
    				} else {

	    				if ($this->Admin_model->update($this->tablename, 'id', $id, $data_to_store)) {
	    					$count++;
	    				}
    				}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' user(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/admin/users');
    	}
    }


	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

    	// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	// Can't delete yourself
    	if ($id == $this->session->userdata('id')) {
    		$this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');

            redirect('/admin/users');
    	}

    	$data['info'] = $this->Admin_model->get_user_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/admin/users');
    	}

      	if ($this->Admin_model->delete($this->tablename, $id)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> User successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/admin/users');
    }


	/**
	 *
	 */
	function reset_pass($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		$data['info'] = $this->Admin_model->get_user_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/admin/users');
    	}

		$password = $this->random_string();
		$user['password'] = md5($password);

		//if the insert has returned true then we show the flash message
		if ($this->Admin_model->update($this->tablename, 'id', $id, $user)) {

			$name = $data['info']->first_name . " " . $data['info']->last_name;
			$email = $data['info']->email;

			// Send Email to users
			$this->load->library('mail_template');
			$this->mail_template->new_password_email($name, $email, $password);

			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', '<strong>Well done!</strong> Password successfully updated and emailed to user.');
		} else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/admin/users');
	}

	/**
	 *
	 * @param unknown_type $id
	 */
	public function profile() {

		$id = $this->session->userdata('id');

		// Include the Module JS file.
    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
    	$config = $this->config->item('module_config');

    	$data['user_meta'] = $config['users']['meta'];

     	$data['user']  = $this->Admin_model->get_user_details($id);

     	if (!is_numeric($id) || $id == 0 || empty($data['user'])) {
     		redirect('/dashboard');
     	}

        $data['schedules'] = $this->Admin_model->get_schedule_list(array('deleted'=>0));
        
		// Roles List (for dropdown)
    	$data['roles'] = $this->Admin_model->get_roles_list();

     	$data['page'] = 'profile';
    	$data['page_title'] = SITE_NAME.' :: Update Profile';

    	$data['main_content'] = 'users/profile';
    	$this->load->view(TEMPLATE_PATH, $data);
    }

	public function check_email($email) {

    	if($this->Admin_model->validate_data($this->tablename, 'email', $email)) {
        	$this->form_validation->set_message('check_email', 'Email address already exists.');
    		return FALSE;
    	} else {
     		return TRUE;
     	}
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

	/**
	 * @param int $limit
	 */
   	private function random_string($limit = 10) {

	    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789!@#$%^&*()'); // and any other characters
	    shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, $limit) as $k) $rand .= $seed[$k];

		return $rand;
	}
}
