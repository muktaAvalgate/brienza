<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Application_Controller {
	
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
	protected $data = array();

	public function __construct() {
        parent::__construct();
    }

	public function index() {

		redirect('/');
		// Include the Module JS file.
    	//add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
	}
	
	public function register_teachers($encrypted_string = null) {

		if ($encrypted_string == null) {
			return false;
		}
		//	echo $encrypted_string;die;
		$this->load->library('encrypt');
		
		$base64 = strtr($encrypted_string, '-_', '+/');
		$id = $this->encrypt->decode($base64);
		//$id = 160;
		
		$this->load->model('../../Admin/models/Admin_model');
		$this->data['teacher'] = $this->Admin_model->get_user_details($id);
		
		$this->load->model('App_model');
		$this->data['question1'] = $this->App_model->get_signup_questions_list(array('status' => 1, 'deleted' => 0, 'question_group' => 'Group 1'));
		$this->data['question2'] = $this->App_model->get_signup_questions_list(array('status' => 1, 'deleted' => 0, 'question_group' => 'Group 2'));
		
		if (empty($this->data['teacher'])) {
     		redirect('/');
     	}
		$this->data['msg'] = 1;
		//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{
			$id = $this->input->post('user_id');
			
			// Edit Tacher
			if ($this->input->post('action') == 'edit') {
		
				//form validation
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('meta[phone]', 'Phone', 'trim|required|numeric');

				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
				
				//if the form has passed through the validation
				if ($this->form_validation->run())
				{
					$email = htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8');
					$created_by = htmlspecialchars($this->input->post('created_by'), ENT_QUOTES, 'utf-8');
					$data = array(
						'first_name' => htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
						'updated_by' => $id,
						'updated_on' => date('Y-m-d H:i:s')
					);

					$meta = $this->input->post('meta');				


					//if the insert has returned true then we show the flash message
					if ($this->Admin_model->update('users', 'id', $id, $data)) {

						// Insert the Mata Data
						// $this->Admin_model->replace_user_meta($id, $meta);
						$this->Admin_model->update_user_meta_specific($id, $meta);
						
						// Send Email to Admin
						$admin = $this->Admin_model->get_user_details($created_by); // Get admin details
						
						$this->load->library('mail_template');
						//$this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, $admin->email);
						$this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, 'brienzaportalstaging@gmail.com');
						// $emails = array('ereinertsen@brienzas.com','dmaddaloni@brienzas.com','agangi@brienzas.com ');
						// $emails = array('brienzaportalstaging@gmail.com','fraidy@thekgroupny.com','fraidy@thekgroupny.com','fraidy@thekgroupny.com');
						// $this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, $emails);
						
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully updated.');
					} else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}

					
				}else{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please provide all the fields value to proceed!');
				}
				redirect($this->uri->uri_string());
			}
			
			if ($this->input->post('action') == 'register') {
				
				//form validation
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
				$this->form_validation->set_rules('question1', 'Question 1', 'trim|required');
				$this->form_validation->set_rules('answer1', 'Answer 1', 'trim|required');
				$this->form_validation->set_rules('question2', 'Question 2', 'trim|required');
				$this->form_validation->set_rules('answer2', 'Answer 2', 'trim|required');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
				
				//if the form has passed through the validation
				if ($this->form_validation->run())
				{
					$user_data = array(
						'password' => md5(htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8')),
						'updated_by' => $id,
						'updated_on' => date('Y-m-d H:i:s')
					);

					$question_data = array(
						'user_id' => $id,
						'question1_id' => htmlspecialchars($this->input->post('question1'), ENT_QUOTES, 'utf-8'),
						'answer1' => htmlspecialchars($this->input->post('answer1'), ENT_QUOTES, 'utf-8'),
						'question2_id' => htmlspecialchars($this->input->post('question2'), ENT_QUOTES, 'utf-8'),
						'answer2' => htmlspecialchars($this->input->post('answer2'), ENT_QUOTES, 'utf-8'),
					);


					//if the insert has returned true then we show the flash message
					if ($this->Admin_model->update('users', 'id', $id, $user_data)) {

						// Update Registration Questions
						$this->Admin_model->insert('user_question_answer', $question_data);
						
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Presenter successfully registered. Now you can login.');
						$this->data['msg'] = 2;
					} else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}

				}else{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please provide all the fields value to proceed!');
				}

			}
     	}

		//print "<pre>"; print_r($this->data['teacher']); die;
		
		$this->data['page'] = 'teachers';
    	$this->data['page_title'] = SITE_NAME.' :: Teachers Management &raquo; Edit Store';
		
		$this->load->view('register_teachers', $this->data);
		/*if ($this->Customer_model->verify_email($email)) {
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', "You email is now activated. You can login to your account now.");
		} else {
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', "Error! Please try again later.");
		}
		redirect('login');*/
	}
	public function register_coordinator($encrypted_string = null) {

		if ($encrypted_string == null) {
			return false;
		}
		//	echo $encrypted_string;die;
		$this->load->library('encrypt');
		
		$base64 = strtr($encrypted_string, '-_', '+/');
		$id = $this->encrypt->decode($base64);
		//$id = 159;
		
		$this->load->model('../../Admin/models/Admin_model');
		$this->data['coordinator'] = $this->Admin_model->get_user_details($id);
		//echo '<pre>';
		//print_r($this->data['coordinator']);die;
		$this->load->model('App_model');
		$this->data['question1'] = $this->App_model->get_signup_questions_list(array('status' => 1, 'deleted' => 0, 'question_group' => 'Group 1'));
		$this->data['question2'] = $this->App_model->get_signup_questions_list(array('status' => 1, 'deleted' => 0, 'question_group' => 'Group 2'));
		
		if (empty($this->data['coordinator'])) {
     		redirect('/');
     	}
		$this->data['msg'] = 1;
		//if save button was clicked, get the data sent via post
     	if ($this->input->server('REQUEST_METHOD') === 'POST')
     	{

			$id = $this->input->post('user_id');
			
			// Edit Tacher
			if ($this->input->post('action') == 'edit') {

				//form validation
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
				
				$this->form_validation->set_rules('meta[rate_type]', 'Rate', 'trim|required');
				$this->form_validation->set_rules('meta[rate]', 'Rate Type', 'trim|required');
				$this->form_validation->set_rules('meta[phone]', 'Phone', 'trim|required|numeric');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
				
				if ($this->form_validation->run())
				{
					
					$email = htmlspecialchars($this->input->post('email'), ENT_QUOTES, 'utf-8');
					$created_by = htmlspecialchars($this->input->post('created_by'), ENT_QUOTES, 'utf-8');
					$data = array(
						'first_name' => htmlspecialchars($this->input->post('first_name'), ENT_QUOTES, 'utf-8'),
						'last_name' => htmlspecialchars($this->input->post('last_name'), ENT_QUOTES, 'utf-8'),
						'updated_by' => $id,
						'updated_on' => date('Y-m-d H:i:s')
					);

					$meta = $this->input->post('meta');				
					//echo '<pre>';
					//print_r($meta);die;
					//if the insert has returned true then we show the flash message
					if ($this->Admin_model->update('users', 'id', $id, $data)) {

						// Insert the Mata Data
						$this->Admin_model->replace_user_meta($id, $meta);
						
						// Send Email to Admin
						$admin = $this->Admin_model->get_user_details($created_by); // Get admin details
						
						$this->load->library('mail_template');
						// $this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, $admin->email);
						$this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, 'brienzaportalstaging@gmail.com');
						// $emails = array('ereinertsen@brienzas.com','dmaddaloni@brienzas.com','agangi@brienzas.com ');
						// $emails = array('brienzaportalstaging@gmail.com','fraidy@thekgroupny.com','fraidy@thekgroupny.com','fraidy@thekgroupny.com');
						// $this->mail_template->send_teacher_update($data['first_name'], $email, $admin->first_name, $emails);
						
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator successfully updated.');
					} else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}
				}else{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please provide all the fields value to proceed!');
				} 
				redirect($this->uri->uri_string());
			}
			
			if ($this->input->post('action') == 'register') {
				
				//form validation
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
				$this->form_validation->set_rules('question1', 'Question 1', 'trim|required');
				$this->form_validation->set_rules('answer1', 'Answer 1', 'trim|required');
				$this->form_validation->set_rules('question2', 'Question 2', 'trim|required');
				$this->form_validation->set_rules('answer2', 'Answer 2', 'trim|required');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
				//echo $validation_errors();die;
				//if the form has passed through the validation
				if ($this->form_validation->run())
				{
					$user_data = array(
						'password' => md5(htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8')),
						'updated_by' => $id,
						'updated_on' => date('Y-m-d H:i:s')
					);

					$question_data = array(
						'user_id' => $id,
						'question1_id' => htmlspecialchars($this->input->post('question1'), ENT_QUOTES, 'utf-8'),
						'answer1' => htmlspecialchars($this->input->post('answer1'), ENT_QUOTES, 'utf-8'),
						'question2_id' => htmlspecialchars($this->input->post('question2'), ENT_QUOTES, 'utf-8'),
						'answer2' => htmlspecialchars($this->input->post('answer2'), ENT_QUOTES, 'utf-8'),
					);


					//if the insert has returned true then we show the flash message
					if ($this->Admin_model->update('users', 'id', $id, $user_data)) {

						// Update Registration Questions
						$this->Admin_model->insert('user_question_answer', $question_data);
						
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Coordinator successfully registered. Now you can login.');
						$this->data['msg'] = 2;
					} else{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
					}
					
				}else{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Please provide all the fields value to proceed!');
				}
			}
     	}

		//print "<pre>"; print_r($this->data['teacher']); die;
		
		$this->data['page'] = 'coordinator';
    	$this->data['page_title'] = SITE_NAME.' :: Coordinator Management &raquo; Edit Store';
		
		$this->load->view('register_coordinator', $this->data);
		/*if ($this->Customer_model->verify_email($email)) {
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', "You email is now activated. You can login to your account now.");
		} else {
			$this->session->set_flashdata('message_type', 'danger');
			$this->session->set_flashdata('message', "Error! Please try again later.");
		}
		redirect('login');*/
	}
}