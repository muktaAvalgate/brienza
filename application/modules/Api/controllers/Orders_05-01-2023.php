<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Orders extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Api_model');
        $this->load->model('../../App/models/App_model');

    }

    public function dashboard_post(){
        $presenter_id = $this->input->post('presenter_id');

        $this->form_validation->set_rules('presenter_id', 'Presenter id', 'trim|required|numeric');
        // do validation.  check validation in all apis
        // do role validation in login

        if($this->form_validation->run() === FALSE){
            $error = $this->form_validation->error_array();
            $message = '';
            foreach($error as $key => $val){
                if($message == ''){
                    $message = $val;
                }else{
                    $message = $message .' '.$val;
                }
            }
            $this->response(array(
                "status" => FALSE,
                "message" =>$message
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
            $is_exists_presenter = $this->Api_model->is_exists_presenter($presenter_id);
            if($is_exists_presenter == false){
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'Presenter not exists.'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }else{
                // echo 'a'; die;
                // $presenter_details = $this->Api_model->get_presenter_details($presenter_id);
                // print_r($presenter_details); die;
                $presenter_name = $this->Api_model->get_presenter_name($presenter_id);
                $presenter_pic = $this->Api_model->get_presenter_profilepic($presenter_id);
                if($presenter_pic == false){
                    $pre_pic = '';
                }else{
                    $pre_pic = BASE_URL.DIR_PROFILE_PICTURE_THUMB.$presenter_pic->profile_pic;
                }
                $dashboard = $this->Api_model->get_teacher_dashboard($presenter_id);
                $new_tag_ready_to_invoice = $this->Api_model->get_status_createInvoice_sessionwise_dashboard($presenter_id);
                if(!empty($dashboard)){
                    if(!empty($dashboard['tot_order'])){
                        $totOrders = $dashboard['tot_order'];
                    }else{
                        $totOrders = 0;
                    }
                    if(!empty($dashboard['new_order'])){
                        $new_order = $dashboard['new_order'];
                    }else{
                        $new_order = 0;
                    }
                    if(!empty($dashboard['new_count'])){
                        $new_count = $dashboard['new_count'];
                    }else{
                        $new_count = 0;
                    }
                    if(!empty($dashboard['total_hours'])){
                        $total_hours = round($dashboard['total_hours']);
                    }else{
                        $total_hours = 0;
                    }
                    if(!empty($dashboard['new_msg'])){
                        $new_msg = $dashboard['new_msg'];
                    }else{
                        $new_msg = 0;
                    }
                    if(!empty($dashboard['total_notification'])){
                        $total_notification = $dashboard['total_notification'];
                    }else{
                        $total_notification = 0;
                    }
                }
                    
                    $dashboard_details = array(
                        'totalOrders' => strval($totOrders) ,
                        'new_order' => strval($new_order),
                        'new_tag_ready_to_invoice' => strval($new_tag_ready_to_invoice[0]),
                        'new_count_for_confirm_hrs' => strval($new_count),
                        'total_hours_for_confirm_hrs' => strval($total_hours),
                        'new_msg_for_inbox' => strval($new_msg),
                        'total_notification_for_inbox' => strval($total_notification),
                        'first_name' => $presenter_name->first_name,
                        'last_name' => $presenter_name->last_name,
                        'profile_pic' => $pre_pic
                    );
            
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $dashboard_details
                ), REST_Controller::HTTP_OK);
                // echo $totOrders;
            }
        }
    }

    public function presenterSchoolList_post(){
        $presenter_id = $this->input->post('presenter_id');
        $this->form_validation->set_rules('presenter_id', 'Presenter id', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $error = $this->form_validation->error_array();
            $message = '';
            foreach($error as $key => $val){
                if($message == ''){
                    $message = $val;
                }else{
                    $message = $message .' '.$val;
                }
            }
            $this->response(array(
                "status" => FALSE,
                "message" =>$message
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
            $is_exists_presenter = $this->Api_model->is_exists_presenter($presenter_id);
            if($is_exists_presenter == true){
                $schools = $this->Api_model->get_all_school_by_presenter_api(array('deleted'=>0, 'presenter_id' => $presenter_id));
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error'  => NULL,
                    'data'=> $schools
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'Wrong credentials'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }
           
        }
       
    }

    public function presenterTotlalOrderList_post(){
        $presenter_id = $this->input->post('presenter_id');
        $school_id = $this->input->post('school_id');
        $this->form_validation->set_rules('presenter_id', 'Presenter id', 'trim|required|numeric');
        $this->form_validation->set_rules('school_id', 'School id', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $error = $this->form_validation->error_array();
            $message = '';
            foreach($error as $key => $val){
                if($message == ''){
                    $message = $val;
                }else{
                    $message = $message .' '.$val;
                }
            }
            $this->response(array(
                "status" => FALSE,
                "message" =>$message
            ),REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $is_exists_presenter = $this->Api_model->is_exists_presenter($presenter_id);
            if($is_exists_presenter == true){
                // Get the Orders for drop-down
                $purchase_orders = $this->Api_model->get_order_list(array('deleted' => 0, 'school' => $school_id, 'presenter' =>  $presenter_id, 'status' => 'approved'), 'created_on', 'desc');
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $purchase_orders
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'Wrong credentials'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }
    }

    public function getSchedulesByOrder_post(){
        $order_id = $this->input->post('order_id');
        $presenter_id = $this->input->post('presenter_id');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $error = $this->form_validation->error_array();
            $message = '';
            foreach($error as $key => $val){
                if($message == ''){
                    $message = $val;
                }else{
                    $message = $message .' '.$val;
                }
            }
            $this->response(array(
                "status" => FALSE,
                "message" =>$message
            ),REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $schedules = $this->Api_model->get_order_schedules($order_id, $presenter_id, "order_schedules.id");
            if(!empty($schedules)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $schedules
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'No records.'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }
           
        } 
    }

   
   

}