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
            $this->response(array(
                "status" => FALSE,
                "message" =>$this->form_validation->error_array()
            ),REST_Controller::HTTP_BAD_REQUEST);

        }else{
            $is_exists_presenter = $this->Api_model->is_exists_presenter($presenter_id);
            if($is_exists_presenter == false){
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'Presenter not exists.'
                ),REST_Controller::HTTP_BAD_REQUEST);
            }else{
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
                        $total_hours = $dashboard['total_hours'];
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
                        'totalOrders' => $totOrders,
                        'new_order' => $new_order,
                        'new_tag_ready_to_invoice' => $new_tag_ready_to_invoice[0],
                        'new_count_for_confirm_hrs' => $new_count,
                        'total_hours_for_confirm_hrs' => $total_hours,
                        'new_msg_for_inbox' => $new_msg,
                        'total_notification_for_inbox' => $total_notification
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

   
   

}