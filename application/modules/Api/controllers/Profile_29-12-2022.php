<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Profile extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Api_model');

    }

    public function login_post(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('email', 'Email Address', 'required|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[255]');

        if($this->form_validation->run() === FALSE){
            $this->response(array(
                "status" => FALSE,
                "message" =>$this->form_validation->error_array()
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
                if( ($is_valid_details = $this->Api_model->validate($email, $this->_encrip_password($password))))
                {
                    //IP addition work 
                    $ip_address=null;
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    }else{
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                    }
                    $this->Api_model->update('id', $is_valid_details->id, array('last_login' => date('Y-m-d H:i:s'),'last_login_ip'=>$ip_address));



                    // $currentLoginYear= '2022';
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Login Successfully',
                        'error' => NULL,
                        'data'=>$is_valid_details
                    ), REST_Controller::HTTP_OK);
                }
                else {
                    $this->response(array(
                        'status' => FALSE,
                        'message' => 'Login Unsuccessfull',
                        'error' => 'Please give correct credentials'
                    ), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
                }
        }
    }

    function _encrip_password($password) {
    	return md5($password);
    }

    public function getprofile_post(){
        $id=$this->input->post('id');
        // $role_id=$this->input->post('role_id');
        $this->form_validation->set_rules('id', 'User id', 'trim|required|numeric');
        // $this->form_validation->set_rules('role_id', 'Role', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $this->response(array(
                "status" => FALSE,
                "message" =>$this->form_validation->error_array()
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
            $user_details = $this->Api_model->checkid($id);
            // print_r($user_details);
            if($user_details == FALSE){
                $this->response(array(
                    "status" => FALSE,
                    "message" =>'User not exists'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $user_meta = $this->Api_model->user_metaDetails($id);
                // echo '<pre>'; print_r($user_details);
                $final_meta_array=array();
                foreach($user_meta as $k => $v){
                    if($v->meta_key == 'phone' || $v->meta_key == 'info' || $v->meta_key == 'rate'){
                        $final_meta_array[$v->meta_key]=$v->meta_value;
                    }
                    // if(!empty($v->meta_key == 'profile_pic')){
                    if($v->meta_key == 'profile_pic'){
                        if(!empty($v->meta_key)){
                            $final_meta_array[$v->meta_key]=$v->meta_value;
                        }else{
                            $final_meta_array['profile_pic']='';
                        }
                    }else{
                        $final_meta_array['profile_pic']='';
                    }
                    
                }

                $get_updated_by_user_name = $this->Api_model->get_user_name_from_users($user_details->updated_by);
                $get_created_by_user_name = $this->Api_model->get_user_name_from_users($user_details->created_by);
                
                $final_meta_array['first_name']=$user_details->first_name;
                $final_meta_array['last_name']=$user_details->last_name;
                $final_meta_array['email']=$user_details->email;
                $final_meta_array['created_on']=$user_details->created_on;
                $final_meta_array['updated_on']=$user_details->updated_on;
                // $final_meta_array['created_by']=$user_details->created_by;
                // $final_meta_array['updated_by']=$user_details->updated_by;
                $final_meta_array['created_by']=$get_created_by_user_name;
                $final_meta_array['updated_by']=$get_updated_by_user_name;
                $final_meta_array['last_login']=$user_details->last_login;
                $final_meta_array['role']=$user_details->role_name;
                // echo '<pre>'; print_r($final_meta_array);

                if(!empty($user_meta)){
                    $this->response(array(
                        "status" => TRUE,
                        "message" => "Success.",
                        'assets_thumb_folder'=> BASE_URL.DIR_PROFILE_PICTURE_THUMB,
                        'error' => NULL,
                        'data'=> $final_meta_array
                        // 'presenter_meta'=> $cjdcj
                    ),REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => FALSE,
                        "message" =>'Something is wrong.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }

    public function updateprofile_post(){
        $user_id = $this->input->post('user_id');

        $get_role_id = $this->Api_model->get_role_id($user_id);
        if($get_role_id == '3'){
            
            $this->form_validation->set_rules('user_id', 'User id', 'trim|required|numeric');
            $this->form_validation->set_rules('first_name', 'First name', 'required|max_length[255]');
            $this->form_validation->set_rules('last_name', 'Last name', 'required|max_length[255]');
            // $this->form_validation->set_rules('profile_pic', 'Profile pic', 'required');
            $this->form_validation->set_rules('rate', 'Rate', 'required|max_length[255]');
            $this->form_validation->set_rules('info', 'Info', 'max_length[255]');
            $this->form_validation->set_rules('phone', 'Phone Number ', 'required|regex_match[/^[0-9]{10}$/]'); //{10} for 10 digits number

            $a = $this->input->post('password');
            $b = $this->input->post('confirm_password');
           
            if(isset($a) || isset($b)){
                $this->form_validation->set_rules('password', 'Password', 'matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim');
            }
        

            if($this->form_validation->run() === FALSE){
                $this->response(array(
                    "status" => FALSE,
                    "message" =>$this->form_validation->error_array()
                ),REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $rate = $this->input->post('rate');
                $info = $this->input->post('info');
                $phone = $this->input->post('phone');
                if((isset($a) && isset($b)) && (!empty($a) && !empty($b))){
                    // insert into user table.  user_id, email,first, last
                    $data = array(
                        'first_name' 	=> $first_name,
                        'last_name' 	=> $last_name,
                        // 'role_id' 		=> 3,
                        'password'      => md5(htmlspecialchars($this->input->post('password'), ENT_QUOTES, 'utf-8')),
                        // 'updated_by' => $this->session->userdata('id'),
                        'updated_by' => $user_id,
                        'updated_on' => date('Y-m-d H:i:s')
                    );
                }else{
                    // insert into user table.  user_id, email,first, last
                    $data = array(
                        'first_name' 	=> $first_name,
                        'last_name' 	=> $last_name,
                        'updated_by' => $user_id,
                        'updated_on' => date('Y-m-d H:i:s')
                    );
                }

                // print_r($data);
                // die;

                if($this->Api_model->update('id', $user_id, $data)){
                    // echo 'true';
                    $meta['rate'] = $rate;
                    if(isset($info)){
                        $meta['info'] = $info;
                    }
                    $meta['phone'] = $phone;

                    if(isset($_FILES['profile_pic'])){
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
                            }
                        }
                    }
                    

                    // update the Meta Data
                    $this->Api_model->update_user_meta($user_id, $meta);

                    // print_r($meta);
                    // die;
                    $this->response(array(
                        "status" => TRUE,
                        "message" => "Updated Successfully."
                    ),REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => FALSE,
                        "message" =>'Something went wrong.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
                }

            }
        }else{
            $this->response(array(
                "status" => FALSE,
                "message" =>'This is not a presenter.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }

        
    }

    public function forgetPassword_post(){
        $email=$this->input->post('email');
        $this->form_validation->set_rules('email', 'Email Address', 'required|max_length[255]');
        if($this->form_validation->run() === FALSE){
            $this->response(array(
                "status" => FALSE,
                "message" =>$this->form_validation->error_array()
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
            if ($info = $this->Api_model->is_valid_data('users', array('email' => $email))) {
                $user_id = $info->id;

                $data_to_insert = array(
                    'user_id' => $user_id,
                    'token' => md5(time()),
                    'create_date' => date('Y-m-d H:i:s')
                );

                $this->Api_model->save_password_log($data_to_insert);

                // Send Email to reset admin password starts
                $activation_link = BASE_URL.'recover_password/'.$data_to_insert['token'];
                
                $to_email = $email;
                // $to_email = 'bm.avalgate@gmail.com';

                $this->load->library('mail_template');
                $this->mail_template->password_reset_email($activation_link, $to_email);


                $this->response(array(
                    "status" => TRUE,
                    "message" => "Link has been sent to your given email id. Please check your mail.",
                    'error' => NULL
                ),REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => TRUE,
                    "message" => "Email does not exists"
                ),REST_Controller::HTTP_OK);
            }
        }

    }

    public function resetPassword_post(){
        $user_id = $this->input->post('user_id');
        $get_role_id = $this->Api_model->get_role_id($user_id);
        if($get_role_id == '3'){
            //form validation
            $this->form_validation->set_rules('user_id', 'User id', 'trim|required|numeric');
            $this->form_validation->set_rules('new_pwd', $this->lang->line('auth_recover_password_form_password_label'), 'trim|required|matches[re_new_pwd]');
            $this->form_validation->set_rules('re_new_pwd', $this->lang->line('auth_recover_password_form_confirm_password_label'), 'trim|required');

            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $pwd = $this->_encrip_password($this->input->post('new_pwd'));
                $pass_update = array(
                    'password'      => $pwd,
                    'updated_by' => $user_id
                );

                if ($this->Api_model->update('id', $user_id, $pass_update)) {

                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Password Reset Successfully.',
                        'error' => NULL,
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => FALSE,
                        "message" =>'Something went wrong.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
                $this->response(array(
                    "status" => FALSE,
                    "message" =>$this->form_validation->error_array()
                ),REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response(array(
                "status" => FALSE,
                "message" =>'This is not a presenter.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function privacyPolicy_get(){
        $privacy_link = BASE_URL.'auth/privacyPolicyView';
        $this->response(array(
            "status" => TRUE,
            "message" => $privacy_link,
            'data'=>NULL
        ),REST_Controller::HTTP_OK);
    }

    public function termsCondition_get(){
        $termsCondition_link = BASE_URL.'auth/termsConditionView';
        $this->response(array(
            "status" => TRUE,
            "message" => $termsCondition_link,
            'data'=>NULL
        ),REST_Controller::HTTP_OK);
    }

    

}