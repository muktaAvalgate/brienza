<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Orders extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Api_model');
        $this->load->model('../../App/models/App_model');
        $this->load->model('../../Admin/models/Admin_model');

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
                $last_hrs_to_cnf_ord_id = $this->Api_model->get_teacher_orders_horstoconfirm($presenter_id);
                if($last_hrs_to_cnf_ord_id == 0){
                    $latest_order_id = '';
                }else{
                    $latest_order_id = $last_hrs_to_cnf_ord_id;
                }
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
                        'profile_pic' => $pre_pic,
                        'last_hrs_to_cnf_ord_id' => $latest_order_id
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
                if(!empty($schools)){
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Success',
                        'error'  => NULL,
                        'data'=> $schools
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'No schools found.',
                        'error'  => NULL,
                        'data'=> array()
                    ),REST_Controller::HTTP_OK);
                }
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
                $purchase_orders = $this->App_model->get_order_list(array('deleted' => 0, 'school' => $school_id, 'presenter' =>  $presenter_id, 'status' => 'approved'), 'created_on', 'desc');
                if(!empty($purchase_orders)){
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Success',
                        'error' => NULL,
                        'data'=> $purchase_orders
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'No orders found.',
                        'error' => NULL,
                        'data'=> array()
                    ),REST_Controller::HTTP_OK);
                }
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
        $this->form_validation->set_rules('presenter_id', 'Presenter Id', 'trim|required|numeric');
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
            
            // get holidays,vacations and session list
            // Get order details
            $order = $this->App_model->get_order_details($order_id);
            // echo '<pre>'; print_r($order); die;
            $get_session = $this->App_model->get_session_dates_by_id($order->session_id);
            // Get School Details
            $school = $this->Admin_model->get_user_details($order->school_id);
            
            $holidays = array();
            if (isset($school->meta['holiday_schedule_id']) && $school->meta['holiday_schedule_id'] > 0) {
                $holidays = $this->App_model->get_schedule_details($school->meta['holiday_schedule_id']);
            }
            
            $data = array();
            $date = array();
            $name = array();
            $workingDays = array();

            if (!empty($holidays)) {
                $workingDays = array_keys($holidays->workingdays);
                // $data['vacation'] = $holidays->holiday_details;
                $vacation = $holidays->holiday_details;

                foreach($vacation as $key => $val){
                    $date[] = $key;
                    $name[] = $val;
                }
            }
           
            $data['workingdays'] = $workingDays;
            $data['date'] = $date;
            $data['name'] = $name;
            // End of Holiday and vacations Schedule details


            // remaining hours
            $schedulable_hr         = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
            $scheduled_hr           = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

            if($schedulable_hr){
                $schedulable_hr = $schedulable_hr;
            }else {
                $schedulable_hr = 0;
            }
                
            if($scheduled_hr){
                $scheduled_hr   = $scheduled_hr;
            }else{
                $scheduled_hr   = 0;
            }
                

            $remaining_schedule_hrs  = $schedulable_hr - $scheduled_hr;
            // end of remaining hours
            // get total hours of order by presenter
            $total_hours = $this->Api_model->get_total_hours_assigned_preseneter($order_id, $presenter_id);
            // end get total hours of order by presenter
            
            if(!empty($schedules)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $schedules,
                    'holidays'=> $data,
                    'session'=> $get_session,
                    'remaining_schedule_hours' => $remaining_schedule_hrs
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    "status" => TRUE,
                    "message" => 'No records.',
                    'error' => NULL,
                    'data'=> $schedules,
                    'holidays'=> $data,
                    'session'=> $get_session,
                    'remaining_schedule_hours' => (int)$total_hours
                ),REST_Controller::HTTP_OK);
            }
           
        } 
    }

    public function types_get(){
        $types = $this->App_model->get_worktype_list(array('deleted'=>0, 'status'=>'active')); 
        if(!empty($types)){
            $this->response(array(
                'status' => TRUE,
                'message' => 'Success',
                'error' => NULL,
                'data'=> $types
            ), REST_Controller::HTTP_OK);
        }else{
            $this->response(array(
                'status' => FALSE,
                'message' => 'No type found.',
                'error' => NULL,
                'data'=> $types
            ), REST_Controller::HTTP_OK);
        }
    }

    public function topics_post(){
        // $this->form_validation->set_rules('presenter_id', 'Presenter id', 'trim|required|numeric');
        $this->form_validation->set_rules('order_id', 'Order id', 'trim|required|numeric');
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
            // $presenter_id = $this->input->post('presenter_id');
            $order_id = $this->input->post('order_id');
            // $order  = $this->App_model->get_order_details_specific($order_id,$presenter_id); 
            $order  = $this->Api_model->get_order_details_by_order($order_id); 
            // $topics = $this->Api_model->get_selected_topics($order->title_id, $order_id);
            $topics = $this->Api_model->get_title_topics($order->title_id); 
            if(!empty($topics)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $topics
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'No topic found.',
                    'error' => NULL,
                    'data'=> $topics
                ), REST_Controller::HTTP_OK);
            }
        } 
    }

    public function grades_post(){
        $this->form_validation->set_rules('order_id', 'Order id', 'trim|required|numeric');
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
            $order_id = $this->input->post('order_id');
            $school_id = $this->input->post('school_id');
            $title_id = $this->App_model->get_title_id($order_id);
            // $teacher_grades=$this->App_model->get_teacher_grades_title($school_id,$title_id);
            $teacher_grades=$this->App_model->get_teacher_grades($school_id);
            if(!empty($teacher_grades)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $teacher_grades
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'No grade found.',
                    'error' => NULL,
                    'data'=> array()
                ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function teachers_post()
    {
        $this->form_validation->set_rules('grade_id', 'Grade id', 'trim|required|numeric');
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
            $grade_id=$this->input->post('grade_id');
            $school_id=$this->input->post('school_id');
            $teacher=$this->App_model->get_teacher($grade_id,$school_id);
            if(!empty($teacher)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $teacher
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'No teacher found.',
                    'error' => NULL,
                    'data'=> array()
                ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function submitSchedule_post(){
		// $school_id 		= $this->input->get('school_id');
		// $order_id 		= $this->input->get('order_id');
		// $presenter_id 	= $this->session->userdata('id');

		// if ($this->input->server('REQUEST_METHOD') === 'POST')
    	// {
			// echo 'submit';  

			$this->form_validation->set_rules('date', 'Date', 'trim|required');
	    	$this->form_validation->set_rules('start_time', 'Start time', 'trim|required');
			$this->form_validation->set_rules('end_time', 'End time', 'trim|required');
			$this->form_validation->set_rules('topics', 'Topic', 'trim|required'); // added
			$this->form_validation->set_rules('types', 'Type', 'trim|required|numeric');
			$this->form_validation->set_rules('grades', 'Grade', 'trim|required');
			$this->form_validation->set_rules('teachers', 'Teacher', 'trim|required');
			$this->form_validation->set_rules('total_hours', 'Total hours', 'trim|required');

            $this->form_validation->set_rules('school_id', 'School', 'trim|required|numeric');
            $this->form_validation->set_rules('order_id', 'Order', 'trim|required|numeric');
            $this->form_validation->set_rules('presenter_id', 'Presenter', 'trim|required|numeric');
			
     		// $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
     		// if the form has passed through the validation
     		if ($this->form_validation->run())
     		{

                $school_id 		= $this->input->post('school_id');
		        $order_id 		= $this->input->post('order_id');
                $presenter_id 		= $this->input->post('presenter_id');


                $schedulable_hr			= $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
                $scheduled_hr			= $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

                // echo $schedulable_hr; echo '++';
                // echo $scheduled_hr; echo '++';
                

                if($schedulable_hr)
                    $data['schedulable_hr']	= $schedulable_hr;
                else
                    $data['schedulable_hr']	= 0;

                if($scheduled_hr)			
                    $data['scheduled_hr']	= $scheduled_hr;
                else
                    $data['scheduled_hr']	= 0;

                $remaining_schedule_hrs 		= $data['schedulable_hr'] - $data['scheduled_hr'];
                // echo $remaining_schedule_hrs; echo '++';

				if ($remaining_schedule_hrs <  $this->input->post('total_hours')) {
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'Schedule hours is greater than remaining hours.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
				}

				$date 		= htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
				$start_time = htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
				$end_time 	= htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
			
				$start_ts 	= new DateTime($date." ".$start_time);
				$start_date = $start_ts->format('Y-m-d H:i:s');

				$end_ts 	= new DateTime($date." ".$end_time);
				$end_date 	= $end_ts->format('Y-m-d H:i:s');

				$myDateArray = explode(' ', $date);
				// print_r($myDateArray); 
				$m = $myDateArray[1]."-".$myDateArray[3];
				$number_month = date("m", strtotime($m));
				$myDayArray = explode(',', $myDateArray[2]);
				// echo $myDayArray[0]; 
				$fdate = $myDateArray[3]."-".$number_month."-".$myDayArray[0];
				// echo $fdate; die;
				// $checkDateIfExitsSubmittedInvoice = $this->App_model->check_date_if_exits_submitted_invoice('2021-08-20',$presenter_id,$order_id);

                $checkDateIfExitsSubmittedInvoice = 
				$this->App_model->check_date_if_exits_submitted_invoice($fdate,$presenter_id,$order_id);

				// echo $checkDateIfExitsSubmittedInvoice; die;
				if($checkDateIfExitsSubmittedInvoice == true){
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'The selected date of range is already submitted the invoice for this scheduled period.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
				}

				// $checkSchedule = $this->App_model->check_schedule_datetime($this->session->userdata('id'), $start_date, $end_date);

                $checkSchedule = $this->App_model->check_schedule_datetime($presenter_id, $start_date, $end_date);
		
 				if(!empty($checkSchedule)){
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'Schedule hours is already booked'
                    ),REST_Controller::HTTP_BAD_REQUEST);
 				}

				$diff30Min = $this->App_model->check_schedule_30min_diff($presenter_id, $start_date, $end_date);
				//print_r($diff30Min);die;
 				if(!empty($diff30Min)){
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'Please 30 mins gap between two schedule.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
 				}
 				// ======= End Code ====== //

                $title_id = $this->App_model->get_title_id($order_id);
                $data['order']  = $this->App_model->get_order_details_specific($order_id,$presenter_id); 
                // $data['topics'] = $this->App_model->get_selected_topics($data['order']->title_id, $order_id);
                $data['topics'] = $this->App_model->get_title_topics($data['order']->title_id); 
                // $data['teacher_grades']=$this->App_model->get_teacher_grades_title($school_id,$title_id);
                $data['teacher_grades']=$this->App_model->get_teacher_grades($school_id);


 				if(!empty($data['topics'])){
					$topicId = $this->input->post('topics');
				}else{
					$topicString = $this->input->post('topics');
					$topicId = $this->App_model->check_topic_string($topicString,$data['order']->title_id);
					$inserdata['order_id']=$order_id;
					$this->App_model->insert('order_topics', $inserdata);
				}
				// echo $topicString; echo "  "; die();
				//for inputting grade as string/number
				// echo count($data['teacher_grades']); die;
				if(!empty($data['teacher_grades'])){
					// echo "old grade"; die;
					$gradeId = $this->input->post('grades');
				}else{
					// echo "new grade"; die;
					//insert in grades field
					$gradesString = $this->input->post('grades');
					$gradeId = $this->App_model->check_grade_string($gradesString,$presenter_id);
					// insert in teachers field
					$insertdata['school_id'] = $school_id;
					$insertdata['title_id'] = $data['order']->title_id;
					$insertdata['grade_id'] = $gradeId;
					$insertdata['created_by'] = $presenter_id;
					$insertdata['name'] = htmlspecialchars($this->input->post('teachers'), ENT_QUOTES, 'utf-8');
					$this->App_model->insert('teachers', $insertdata);
					$updateTitles['grade_teachers'] = '1';
					$this->App_model->update('titles', 'id', $data['order']->title_id, $updateTitles);
				}

				// echo $gradeId; die;

     			$data = array(
					'order_id' => $order_id,
					'start_date' => $start_date,
    				'end_date' => $end_date,
					// 'topic_id' => $this->input->post('topics'),
					'topic_id' => $topicId,
					'type_id' => $this->input->post('types'),
					// 'grade_id' => $this->input->post('grades'),
					'grade_id' => $gradeId,
					'teacher' => htmlspecialchars($this->input->post('teachers'), ENT_QUOTES, 'utf-8'),
					'total_hours' => htmlspecialchars($this->input->post('total_hours'), ENT_QUOTES, 'utf-8'),
     				'created_by' => $presenter_id,
     				'created_on' => date('Y-m-d H:i:s')
    			);
				
				if ($schedule_id = $this->App_model->insert('order_schedules', $data)) {
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Schedule has been added successfully.',
                        'error' => NULL
                    ), REST_Controller::HTTP_OK);
    			} else {
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'Please try again.'
                    ),REST_Controller::HTTP_BAD_REQUEST);
    			}
    			// redirect('/app/presenters/scheduling/?order_id='.$order_id.'&school_id='.$school_id);
			}
		// }
	
    }


    public function editSchedule_post(){
        $school_id      = $this->input->post('school_id');
        $order_id       = $this->input->post('order_id');
        $schedule_id    = $this->input->post('order_schedule_id');
        $topic_id       = $this->input->post('topics');
        $type_id        = $this->input->post('types');
        $grade_id       = $this->input->post('grades');
        $date           = htmlspecialchars($this->input->post('date'), ENT_QUOTES, 'utf-8');
        $start_time     = htmlspecialchars($this->input->post('start_time'), ENT_QUOTES, 'utf-8');
        $end_time       = htmlspecialchars($this->input->post('end_time'), ENT_QUOTES, 'utf-8');
        // $teacher         = $this->input->post('teachers');
        $teacher1        = $this->input->post('teachers1');
        $total_hours    = $this->input->post('total_hours');
        $presenter_id   = $this->input->post('presenter_id');
      
        if($this->input->post('teachers1') != ''){
            $teacherName  = $this->input->post('teachers1');
        }else{
            $teacherName  = '';
        }

        $err = "";
        if($start_time == ""){
            $err .= "Start time field is required.<br/>";
        }
        if($end_time == ""){
            $err .= "End time field is required.<br/>";
        }
        if($topic_id == ""){
            $err .= "Topics field is required.<br/>";
        }
        if($type_id == ""){
            $err .= "Types field is required.<br/>";
        }
        if($grade_id == ""){
            $err .= "Grade field is required.<br/>";
        }
        if($teacherName == ""){
            $err .= "Teachers field is required.<br/>";
        }
        if($total_hours == ""){
            $err .= "Total hours field is required.<br/>";
        }

        if($err != ""){
            $this->response(array(
                "status" => FALSE,
                "message" => $err
            ),REST_Controller::HTTP_BAD_REQUEST);
        }

        $scheduleData = $this->App_model->get_order_schedule_details($schedule_id);

        $scheduled_hour = (int) $scheduleData->total_hours;

        // echo $scheduled_hour; die;

        if(empty($scheduleData)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Something went to wrong please try again.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }

        // $data['order']          = $this->App_model->get_order_details($order_id); // Get order details
        // $data['topics']         = $this->App_model->get_title_topics($data['order']->title_id); // Get the Topics
        // $data['selected_order'] = $order_id;

        $schedulable_hr         = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
        $scheduled_hr           = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

        // echo $schedulable_hr; echo '+';
        // echo $scheduled_hr; die;

        if($schedulable_hr){
            $data['schedulable_hr'] = $schedulable_hr;
        }else{
            $data['schedulable_hr'] = 0;
        }

        if($scheduled_hr){
           $data['scheduled_hr']    = $scheduled_hr;
        }else{
            $data['scheduled_hr']   = 0;
        }

        $remaining_schedule_hrs = $data['schedulable_hr'] - $data['scheduled_hr'];
        // echo $remaining_schedule_hrs; die;

        // if($scheduled_hour <> $this->input->post('total_hours')){

        //     $scheduleHour = abs($this->input->post('total_hours') - $scheduled_hour);

        //     if ($remaining_schedule_hrs <  $scheduleHour) {
        //         $this->response(array(
        //             "status" => FALSE,
        //             "message" => 'Schedule hours is greater than remaining hours.'
        //         ),REST_Controller::HTTP_BAD_REQUEST);
        //     }
        // }

        $current_hrs = $this->input->post('total_hours');
		$total_remaining_hrs = $scheduled_hour + $remaining_schedule_hrs;

		if ($current_hrs >  $total_remaining_hrs) {
            $this->response(array(
                "status" => FALSE,
                "message" => 'Schedule hours is greater than remaining hours.'
            ),REST_Controller::HTTP_BAD_REQUEST);
		}


        $start_ts   = new DateTime($date." ".$start_time);
        $start_date = $start_ts->format('Y-m-d H:i:s');

        $end_ts     = new DateTime($date." ".$end_time);
        $end_date   = $end_ts->format('Y-m-d H:i:s');

        $checkSchedule = $this->App_model->check_exist_schedule_datetime($presenter_id, $start_date, $end_date, $schedule_id);

        if(!empty($checkSchedule)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Schedule hours is already booked.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }
    
        $diff30Min = $this->App_model->check_schedule_30min_diff($presenter_id, $start_date, $end_date);
        if(!empty($diff30Min)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Please 30 mins gap between two schedule.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }
        // ======= End Code ====== //
        $data = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
            'topic_id' => $this->input->post('topics'),
            'type_id' => $this->input->post('types'),
            'grade_id' => $this->input->post('grades'),
            'teacher' => $teacherName,
            'total_hours' => htmlspecialchars($this->input->post('total_hours'), ENT_QUOTES, 'utf-8'),
        );
        
        if ($schedule_id = $this->App_model->update('order_schedules', 'id', $schedule_id, $data)) {
            $this->response(array(
                "status" => TRUE,
                "message" => 'Schedule has been updated successfully.'
            ),REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "status" => FALSE,
                "message" => 'Please try again.'
            ),REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // calender starts
    public function calender_post(){
        $presenter_id = $this->input->post('presenter_id');
        $session_id = $this->input->post('session_id');
       
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        if($year != NULL && $month !=NULL){
            $curr_date = $year.'-'.$month.'-01';
        }else{
            $curr_date = date("Y-m-d");
        }

        
		// $data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		

        if($session_id != ''){
			$data['curr_session_id'] = $session_id;
		}else{
			$data['curr_session_id'] = $this->App_model->get_curr_session_id($curr_date);
		}

		$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($data['curr_session_id'], $presenter_id);
		$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($data['curr_session_id'], $presenter_id);
		$session = $this->App_model->get_session_dates_by_id($data['curr_session_id']);
		if($session->start_date){
			
			$data['start_date'] = $session->start_date;
			$data['end_date'] = $session->end_date;

		}else{
		
			$data['start_date'] = '2017-01-01';
			$data['end_date'] = '2050-12-31';
			
		}
		
		
		// Get the existing schedule
		$schedules = $this->App_model->get_order_schedule_session(null, $presenter_id,null, $data['curr_session_id']);
		
		$data['schedules'] = array();
		foreach ($schedules as $key => $value) {
            $schedule_det= $this->App_model->get_order_schedule_details($value->id);
            $value->details = $schedule_det;
			$data['schedules'][] = $value;
		}
		
		$data['s_array'] = $this->App_model->get_sessions();
		

        $this->response(array(
            'status' => TRUE,
            'message' => 'Success.',
            'error' => NULL,
            'data'=> $data
        ), REST_Controller::HTTP_OK);
    }

    public function sessionsList_get(){
        $session = $this->Api_model->get_sessions();
        $this->response(array(
            'status' => TRUE,
            'message' => 'Success',
            'error' => NULL,
            'data'=> $session
        ), REST_Controller::HTTP_OK);
    }


    // for orders section 
    public function getOrderList_post($billing='') {
        $presenter_id 	= $this->input->post('presenter_id');
        $session_id 	= $this->input->post('session_id');
		$filter = array(
			'deleted' => 0,
			'presenter' => $presenter_id,
			'status' => 'approved'
		);
		
		$pre_session = $this->input->get('pre_session_id');
		
	    $filter['presenter_session'] = $session_id;
		
		
		// if($billing!='' && $billing=='billing'){
		// 	$filter['billing_date'] = date("Y-m-d");
		// 	$data['billing'] = true;
		// }else{
		// 	$data['billing'] = false;
		// }

		$orders = $this->Api_model->get_order_list_order($filter, 'created_on', 'desc');
        foreach ($orders as $item) {
            $item->complete_by = $this->App_model->getorder_billing_date($item->id);
            $item->belling_period = $this->App_model->getorder_billing_period($item->id);
            $item->confirm_hours = $this->App_model->get_confirm_hours($item->id);
			$item->c_hours = $this->App_model->get_confirm_hours_by_odrId_preId($item->id,$presenter_id);
        }
		//session from table
		// $data['s_array'] = $this->App_model->get_sessions();
		$data['presenter_session_id'] = $filter['presenter_session'];
		$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($filter['presenter_session'], $presenter_id);
		$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($filter['presenter_session'], $presenter_id);

		$data['orders'] = $orders;
		// $data['page'] = 'presenters';
    	// $data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Orders';

		//print "<pre>"; print_r($data); die;
    	// $data['main_content'] = 'presenters/orders';
    	// $this->load->view(TEMPLATE_PATH, $data);

        $this->response(array(
            'status' => TRUE,
            'message' => 'Success',
            'error' => NULL,
            'data'=> $data
        ), REST_Controller::HTTP_OK);
	}

    
    public function ordersBilling_post(){
        // echo "bb"; die();
        $order_id = $this->input->post('order_id');
        $presenter_id = $this->input->post('presenter_id');
        // echo $order_id; die;
        $order = $this->App_model->get_order_details($order_id);

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);
        
        
        if ($order_id) {
            $p_name = $this->App_model->principal($school_id);
            if(isset($p_name)){
                $data['principal_name_final'] = $p_name->meta_value;
            }else{
                $data['principal_name_final'] = '';
            }
            // $data['principal_name_final'] = $p_name->meta_value;
            // Get order details
            $data['order'] = $this->App_model->get_order_details($order_id);
            $data['selectConBtn'] = FALSE;
            
                $schedulable_hr = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
                // echo $schedulable_hr; die;
                $scheduled_hr   = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

                // $data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");
                $data['schedules'] = $this->Api_model->get_order_schedule_for_api($order_id, $presenter_id, "order_schedules.id");
                
                if($schedulable_hr)
                    $data['schedulable_hr'] = $schedulable_hr;
                else
                    $data['schedulable_hr'] = 0;

                if($scheduled_hr)           
                    $data['scheduled_hr']   = $scheduled_hr;
                else
                    $data['scheduled_hr']   = 0;

                $remaining_schedule_hrs         = $data['schedulable_hr'] - $data['scheduled_hr'];
                $data['remaining_schedule_hrs'] = $remaining_schedule_hrs;              
           
        }
        // print "<pre>"; print_r($data['schedules']); print "</pre>";die();
        $data['previewButton'] = FALSE;
        
        $scheduled_ids = $this->App_model->get_schedule_ids($order_id, $presenter_id);
        foreach ($scheduled_ids  as $row) {
            $res = $this->App_model->checkCreateLog($row->id);
            if($res){
                $data['previewButton'] = TRUE;
            }else{
                $data['previewButton'] = FALSE;
                break;
            }
        }
        // $data['presentersForAdmin'] = $this->App_model->get_presenters_for_admin();
        $data['approvedStatus'] = $this->App_model->getApprovedStatus($order_id, $presenter_id);

        $data['attachtment_base_url'] = base_url().DIR_TEACHER_FILES;
        $data['sign_base_url'] = 'https://img247.managed.center/';

        $this->response(array(
            'status' => TRUE,
            'message' => 'Success',
            'error' => NULL,
            'order_details' => $order,
            'data'=> $data
        ), REST_Controller::HTTP_OK);
    }


    public function multipleConfirmhoursUpdate_post(){

        $order_id = $this->input->post('order_id');
        $presenter_id = $this->input->post('presenter_id');

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);
        $order_schedule_ids = $this->input->post('scheduled_id');
        $order_schedule_id = explode(',',$order_schedule_ids);
        // echo '<pre>'; print_r($order_schedule_id); 
        // die;

        // checking if schedule assignes to this presenter
        $schedule = 0;
        $noSchedule = 0;
        for($i=0;$i<count($order_schedule_id);$i++){
            $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id[$i],$presenter_id);
            if(!empty($checkSchedule)){
                $schedule++;
            }else{
                $noSchedule ++;
            }
        }
        if($noSchedule > 0){
            // echo 4; exit;
            $this->response(array(
                "status" => FALSE,
                "message" => 'Oops... One or more schedules has no longer been assigned to you!',
                'error' => NULL
            ),REST_Controller::HTTP_OK);
        }else{
            $multipleCounter = 0;
            $finalHolidaySet = 0;
            $finalUnselectedWorkingDay = 0;
            for($i=0;$i<count($order_schedule_id);$i++){
                //check if exists in this presenter
                $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id[$i],$presenter_id);
                $dayName = $this->App_model->get_day_name_of_schedule($order_schedule_id[$i]);
                // $date = date('Y-m-d H:i:s');
                $day = strtolower(date('l', strtotime($dayName))); 
    
                //21-09-2021
                $dayName_without_time = date("Y-m-d",strtotime($dayName));
                $holiday_counter = 0;
                foreach($holiday_ids as $key => $val){
                    $dates = $this->App_model->get_sdate_edate($val);
                    if($dates->end_date == ''){
                        if($dates->start_date == $dayName_without_time){
                            $holiday_counter ++;
                        }
                    }else{
                        if($dayName_without_time >= $dates->start_date && $dayName_without_time <= $dates->end_date){
                            $holiday_counter ++;
                        }
                    }
                }
                
                if(in_array( $day, $daysArray) && $holiday_counter == 0){
                    // do multiple update 
                    $multipleCounter++;
                }else{
                    if($holiday_counter > 0){
                        $finalHolidaySet++;
                    }else{
                        $finalUnselectedWorkingDay++;
                    }
                }
            } 
        }
        
        
        if($finalHolidaySet > 0){
            // echo 2;
            $this->response(array(
                "status" => FALSE,
                "message" => 'Cannot approve, as there is one or more sessions that is/are scheduled on a holiday day.',
                'error' => NULL
            ),REST_Controller::HTTP_OK);
        }else if($finalUnselectedWorkingDay > 0){
            // echo 3;
            $this->response(array(
                "status" => FALSE,
                "message" => 'Cannot approve, as there is one or more session that is/are scheduled on a unselected working day.',
                'error' => NULL
            ),REST_Controller::HTTP_OK);
        }else{
            // $order_schedule_id = $this->input->post('scheduled_id');
            $data_schedule = array(
            			'status' => 'Confirm hours',
            			'updated_on' => date("Y-m-d H:i:s"),
            			'updated_by' => $presenter_id
            		);
            		$this->App_model->multipleConfirmhoursUpdate($order_schedule_id, $data_schedule);
                    $dataLog['updated_by'] = $presenter_id;
                    $dataLog['new_status'] = 'Confirm hours';
                    $dataLog['old_status'] = 'Approved';
                    $dataLog['updated_on'] = date("Y-m-d H:i:s");
                    $this->App_model->multipleConfirmhoursInsert($order_schedule_id, $dataLog);
            // return true;
            $this->response(array(
                "status" => TRUE,
                "message" => 'Success',
                'error' => NULL
            ),REST_Controller::HTTP_OK);
        }
	}

    public function ordersBillingStatusUpdate_post() {
        $order_id = $this->input->post('order_id');
        $presenter_id = $this->input->post('presenter_id');

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);

            
        $status = $this->input->post('status');
        $old_status = $this->input->post('old_status');
        $content  = $this->input->post('content');
        $principal_nameForLog  = $this->input->post('principal_nameForLog');
        
        $order_schedule_id = $this->input->post('order_schedule_status_id');
        $attachment = (isset($_FILES['attachment'])?$_FILES['attachment']:"");
            //20-09-2021
            if($status == 'Confirm hours'){
                //check if exists in this presenter
                $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id,$presenter_id);
                if(!empty($checkSchedule)){
                    // echo '<pre>'; print_r($daysArray);
                    $dayName = $this->App_model->get_day_name_of_schedule($order_schedule_id);
                    // $date = date('Y-m-d H:i:s');
                    $day = strtolower(date('l', strtotime($dayName))); 
                    // echo $day;
                    // die();

                    //21-09-2021
                    $dayName_without_time = date("Y-m-d",strtotime($dayName));
                    $holiday_counter = 0;
                    foreach($holiday_ids as $key => $val){
                        $dates = $this->App_model->get_sdate_edate($val);
                        // echo '<pre>'; print_r($dates); die();
                        if($dates->end_date == ''){
                            // echo 'aa';
                            if($dates->start_date == $dayName_without_time){
                                $holiday_counter ++;
                            }
                        }else{
                            // echo 'bb';
                            if($dayName_without_time >= $dates->start_date && $dayName_without_time <= $dates->end_date){
                                $holiday_counter ++;
                            }
                        }
                    }
                    // echo $holiday_counter; die();
                    if(in_array( $day, $daysArray) && $holiday_counter == 0){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $presenter_id;
                        $data['new_status'] = 'Confirm hours';
                        $data['old_status'] = $old_status;
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status == 'Create log') ? 'Awaiting Review' : $status,
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $presenter_id,
                            'log_status' => ($status == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
    
                        // $this->session->set_flashdata('message_type', 'success');
                        // $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                        // if($this->input->post('ajaxCall')){
                        //     echo true;exit;
                        // }else{
                        //     redirect('/app/orders/billing/?order_id='.$order_id);               
                        // }

                        $this->response(array(
                            'status' => TRUE,
                            'message' => 'Status successfully updated.',
                            'error' => NULL
                        ), REST_Controller::HTTP_OK);

                    }else{
                        if($holiday_counter > 0){
                            // echo 2; exit;
                            $this->response(array(
                                "status" => FALSE,
                                "message" => 'Cannot approve, as there is one or more sessions that is/are scheduled on a holiday day.',
                                'error' => NULL
                            ),REST_Controller::HTTP_OK);
                        }else{
                            // echo 3; exit;
                            $this->response(array(
                                "status" => FALSE,
                                "message" => 'Cannot approve, as there is one or more session that is/are scheduled on a unselected working day.',
                                'error' => NULL
                            ),REST_Controller::HTTP_OK);
                        }
                        // echo false; exit;
                    }
                }else{
                    // echo 4; exit;
                    $this->response(array(
                        "status" => FALSE,
                        "message" => 'Oops... One or more schedules has no longer been assigned to you!',
                        'error' => NULL
                    ),REST_Controller::HTTP_OK);
                }
            }



            if ($status == "Log sent - awaiting principal signature") {
                $order = $this->App_model->get_order_details($order_id);
                $schedule = $this->App_model->get_order_schedule_details($order_schedule_id); 
                
                $data['content'] = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif; ">
                <tr>
                    <td><img src="'. base_url("assets/images/logo.png").'"></td>
                    <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                </tr>
                <tr>
                    <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="border-top:solid 1px;">'.$content.'</td>
                </tr>

                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                </tr>

                <tr>
                    <td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal’s Signature:</strong></td>
                    <td align="right" style="height:50px; border-top:solid 1px;"><strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                </tr>
                
                </table>';

                $data['content_for_print'] = '<table width="100%" cellpadding="5" cellspacing="0"  style="border:1px solid black; font-family:\'Ubuntu\', sans-serif;">
                <tr>
                    <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 95%;"></td>
                    <td align="right" style="color:#813D97 !important; padding-right: 20px; padding-top: 10px; width: 50%; ">8696 18th Ave, Brooklyn, NY 11214 <br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px; font-size: 15px;"><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px; "><strong><br>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Start Time:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'<br></td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                </tr>
                <tr> 
                    <td align="left" colspan="2" style="border-top:solid 1px; padding: 20px;">'.$content.'</td>
                </tr>

                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                </tr>

                <tr>
                    <td align="left" style="height:50px; padding-left: 20px;"><strong>Principal’s Signature:</strong></td>
                    <td colspan="2"><strong style = "margin-left: 12rem;">Total Hours:</strong> '. $schedule->total_hours.'</td>
                </tr>
                
                </table>';
            
                $arr = explode(" ",$content);
                $arr_length = sizeof($arr);
                $logDatanew= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                <tr>
                    <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 50% !importent;"></td>
                    <td align="right" style="color:#813D97; !important; padding-right: 20px; padding-top: 10px; width: 50%;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                </tr>';

            
                // // echo $arr[$index]. " ";
                // $index_first_page=470;
                // $max_loop_count = $arr_length;
                // if($max_loop_count>$index_first_page){
                //     $max_loop_count = $index_first_page;
                // }
                
                // $logDatanew .= '<tr>
                //     <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px;">';
                //     for ($index = 0; $index < $max_loop_count; $index++) {
                //         $logDatanew .= $arr[$index]." ";
                //     }
                //     $logDatanew .='</td>
                // </tr>
                // ';    
                // // ...........................................
                // $index_rest_pages = 814;
                // $arr_length_rest_page=$arr_length-$index_first_page;

                // $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                // // $arr_loop_count = ($arr_length_rest_page / $index_rest_pages);
                // $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                // if($last_loop_data_count>0) {
                //     $arr_loop_count = $arr_loop_count+1;
                // }

                // // while($arr_length_2pg >= 0){
                // for( $i=0; $i < $arr_loop_count; $i++){
                // // if(!empty($arr[$last_index])){
                //     $index_j = $index_first_page+($index_rest_pages*$i);
                //     $index_max_j = 0;
                //     if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                //         $index_max_j = $index_j+$last_loop_data_count;
                //     }else{
                //         $index_max_j = $index_j+$index_rest_pages;
                //     }
                    
                //     $logDatanew .= '<tr>
                //     <td  align="left" colspan="2" style="padding-left: 2px;">';
                //     for ($j= $index_j; $j < $index_max_j; $j++) {
                //         $logDatanew .= $arr[$j]." ";    
                        
                //     }
                //     $logDatanew .='</td>
                //     </tr>
                //     '; 
                // }




                    $index_first_page=470;

                        $max_loop_count = $arr_length;
                        if($max_loop_count>$index_first_page){
                            $max_loop_count = $index_first_page;
                        }
                          
                        $logDatanew .= '<tr>
                            <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px; ">';
                            for ($index = 0; $index <= $max_loop_count; $index++) {
                                // if (strpos($arr[$index], "<br>") != false && $max_loop_count>=$index_first_page) {
                                if($index <= sizeof($arr)){
                                    if (strpos($arr[$index], "<br>") != false) {
                                        $break_pos = (15-($index % 15));
                                        if($break_pos>2 && ($index % 15)!=0){
                                            // $break_pos = 15-($index % 15);
                                            $max_loop_count = ($max_loop_count-$break_pos);
                                        }
                                    }
                                
                                        $logDatanew .= $arr[$index]." ";
                                }
                            }
                            $logDatanew .='</td>
                        </tr>
                        ';   
                        $index_first_page=$max_loop_count; 
                        // ...........................................
                        $index_rest_pages = 800;

                            $arr_length_rest_page = ($arr_length-$index_first_page);
    
                            $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                            // $arr_loop_count = ($arr_length_rest_page / $index_rest_pages);
                            $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                            if($last_loop_data_count>0) {
                                $arr_loop_count = $arr_loop_count+1;
                            }

                            // while($arr_length_2pg >= 0){
                            $index_break = 0;
                            $index_break_word=0;
                            for( $i=0; $i < $arr_loop_count; $i++){
                                // if(!empty($arr[$last_index])){

                                    if($index_break==0){
                                        $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                                    }else{
                                        $index_j=$index_max_j;
                                    }

                                    // $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                                    // $index_j = ($index_first_page+($index_rest_pages*$i))-$index_break;
                                    $index_max_j = 0;
                                    if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                                        $index_max_j = $index_j+$last_loop_data_count;
                                    }else{
                                        $index_max_j = $index_j+$index_rest_pages;
                                    }

                                    
                                    $logDatanew .= '<tr>
                                    <td  align="left" colspan="2" style="padding-left: 2px;">';
                                    for ($j= $index_j; $j < $index_max_j; $j++) {
                                        // if (strpos($arr[$j], "<br>") != false) {
                                        if(($index_max_j - $index_j)<$index_rest_pages){
                                            $index_max_j = $index_max_j+$index_break_word;
                                        }
                                        if($j <= sizeof($arr)){
                                            if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                                                $break_pos_rest_page = (15-($j%15));
                                                if($break_pos_rest_page>2 && ($j%15)!=0){
                                                    // $break_pos_rest_page = ($j%15);
                                                    $index_max_j = ($index_max_j-$break_pos_rest_page);
                                                    // $index_break = ($index_break+$break_pos_rest_page);
                                                    $index_break_word = ($index_break_word+$break_pos_rest_page);
                                                    $index_break = 1;

                                                }
                                            }
                                        
                                                $logDatanew .= $arr[$j]." ";  
                                        }
                                          
                                        
                                }
                                $logDatanew .='</td>
                                </tr>
                                '; 
                        }



                

                $logDatanew .= '
                    <tr>
                        <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                    </tr>

            


                    <tr>
                    <td align="left" style="height:50px; padding-left: 5px;"><strong>Principal’s Signature:</strong></td>
                    <td colspan="2"><strong>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Total Hours:</strong> '. $schedule->total_hours.'</td>
                </tr>
                    
                
                
                
                </table>';

            
                $data['log_pdf_admin'] =$logDatanew;
                


                $data['order_schedule_id'] = $order_schedule_id;
                $data['new_status'] = 'Log sent - awaiting principal signature';
                $data['old_status'] = 'Create log';
                $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                $data['updated_by'] = $presenter_id;
                $data['content_txt'] = $content;
                $data['principal_name'] = $principal_nameForLog;
                $this->App_model->insert('order_schedule_status_log', $data);

                // Update Schedule Table
                $data_schedule = array(
                    'status' => ($status == 'Create log') ? 'Awaiting Review' : $status,
                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by' => $presenter_id,
                    'log_status' => ($status == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                );
                $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Status successfully updated.',
                    'error' => NULL
                ), REST_Controller::HTTP_OK);

            }


            if($status == 'Create log'){
                // echo 'bbbbbbbbbbbbb'; die;
                if (!empty($attachment['name'])) {

                    $config['upload_path'] = DIR_TEACHER_FILES;
                    $config['max_size'] = '25000';
                    $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);

                    $attach = array();

                    $_FILES['attach[]']['name'] = $attachment['name'];
                    $_FILES['attach[]']['type'] = $attachment['type'];
                    $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'];
                    $_FILES['attach[]']['error'] = $attachment['error'];
                    $_FILES['attach[]']['size'] = $attachment['size'];

                    $config['file_name'] = ($status == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                    $attach[] = $config['file_name'];

                    //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('attach[]')) {
                        $upload_data =  $this->upload->data();
                        $data['attachment'] = $upload_data['file_name'];
                    } else {
                        // //$this->upload->display_errors(); die;
                        // $this->session->set_flashdata('message_type', 'danger');
                        // $this->session->set_flashdata('message', $this->upload->display_errors());

                        // redirect('/app/orders/billing/?order_id='.$order_id);
                        $this->response(array(
                            'status' => FALSE,
                            'message' => 'Unsuccessfull.',
                            'error' => $this->upload->display_errors()
                        ), REST_Controller::HTTP_OK);
                    }

                    $data['order_schedule_id'] = $order_schedule_id;
                    $data['new_status'] = 'Log sent - awaiting principal signature';
                    $data['old_status'] = 'Create log';
                    $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                    $data['updated_by'] = $presenter_id;
                    $this->App_model->insert('order_schedule_status_log', $data);

                    $data_another['order_schedule_id'] = $order_schedule_id;
                    $data_another['attachment'] = $data['attachment'];
                    // $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
                    $data_another['new_status'] = ($status == 'Create log') ? 'Create invoice' : $status;
                    $data_another['old_status'] = ($status == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status;
                    $data_another['updated_on'] = date("Y-m-d H:i:s");
                    $data_another['updated_by'] = $presenter_id;
                    $this->App_model->insert('order_schedule_status_log', $data_another);

                    // Update Schedule Table
                    $data_schedule = array(
                        // 'status' => ($status == 'Create log') ? 'Awaiting Review' : $status,
                        'status' => ($status == 'Create log') ? 'Create invoice' : $status,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => $presenter_id,
                        'log_status' => ($status == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                    );
                    $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                    
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Status successfully updated.',
                        'error' => NULL
                    ), REST_Controller::HTTP_OK);
                }
            }
            

                    
        // print "<pre>"; print_r($data['schedules']); print "</pre>";die();
        // $data['previewButton'] = FALSE;
        // if($this->session->userdata('role') == "teacher"){
        //     $pid = $this->session->userdata('id');
        // }else{
            // $pid = $presenter_id;
        // }
        // $scheduled_ids = $this->App_model->get_schedule_ids($order_id, $pid);
        // foreach ($scheduled_ids  as $row) {
        //     $res = $this->App_model->checkCreateLog($row->id);
        //     if($res){
        //         $data['previewButton'] = TRUE;
        //     }else{
        //         $data['previewButton'] = FALSE;
        //         break;
        //     }
        // }
        //echo $data['previewButton'];die;
        // $data['approvedStatus'] = $this->App_model->getApprovedStatus($order_id, $pid);
       
    }

    function declineSchedule_post(){
        // $schedule_id = $this->input->post('schedule_id');
        // $tablename = 'order_schedules';
        // $decline = $this->App_model->delete($tablename, $schedule_id);
        // if($decline){
        //     $this->response(array(
        //         'status' => TRUE,
        //         'message' => 'Successfully declined.',
        //         'error' => NULL
        //     ), REST_Controller::HTTP_OK);
        // }else{
        //     $this->response(array(
        //         'status' => FALSE,
        //         'message' => 'Unsuccessfull.',
        //         'error' => NULL
        //     ), REST_Controller::HTTP_OK);
        // }

        $order_schedule_ids = $this->input->post('schedule_id');
        $order_schedule_id = explode(',',$order_schedule_ids);
        $tablename = 'order_schedules';
        foreach($order_schedule_id as $schedule_id){
            $this->App_model->delete($tablename, $schedule_id);
        }
        
        $this->response(array(
            'status' => TRUE,
            'message' => 'Successfully declined.',
            'error' => NULL
        ), REST_Controller::HTTP_OK);

    }

    public function reUploadDocument_post() {
        $presenter_id = $this->input->post('presenter_id');
        $attachment = (isset($_FILES['attachment'])?$_FILES['attachment']:"");
        $log_id = $this->input->post('order_log_id');
        $order_schedule_id = $this->input->post('order_schedule_id');
        
        $schedule = $this->App_model->get_schedule_log($log_id);

        // $existing_path = $_SERVER['DOCUMENT_ROOT'].'brienza/assets/teachers/'.$schedule->attachment;
        $existing_path = FCPATH.'assets/teachers/'.$schedule->attachment;

        // echo '<pre>'; print_r($attachment);
        // echo $log_id;
        // echo $order_schedule_id;
        // print_r($schedule);
        // echo $existing_path;
        // die;
        
        if(!empty($attachment['name'])){
            // echo 'aa'; die();
            $config['upload_path'] = DIR_TEACHER_FILES;
            $config['max_size'] = '25000';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
            $config['overwrite'] = FALSE;
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            $attach = array();

            $_FILES['attach[]']['name'] = $attachment['name'];
            $_FILES['attach[]']['type'] = $attachment['type'];
            $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'];
            $_FILES['attach[]']['error'] = $attachment['error'];
            $_FILES['attach[]']['size'] = $attachment['size'];

            $config['file_name'] =  'billing_attachment-'.rand().date('YmdHis');
            $attach[] = $config['file_name'];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('attach[]')) {
                $upload_data =  $this->upload->data();

                if ($schedule->old_status == 'Create log' && $schedule->new_status == 'Log sent - awaiting principal signature'){

                    $data['updated_by'] = $presenter_id;
                    $data['updated_on'] = date("Y-m-d H:i:s");
                    $data['old_status'] = 'Log sent - awaiting principal signature';
                    //$data['new_status'] = 'Awaiting Review';
                    $data['new_status'] = 'Create invoice';
                    $data['attachment'] = $upload_data['file_name'];
                    $data['order_schedule_id'] = $order_schedule_id;
                    
                    $insert = $this->App_model->insert('order_schedule_status_log', $data);

                    $upadate_data['attachment'] = $upload_data['file_name'];
                    $upadate_data['updated_by'] = $presenter_id;
                    $upadate_data['updated_on'] = date("Y-m-d H:i:s");
                    $upadate_data['content'] = '';

                    $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $upadate_data);
                    if(isset($schedule->attachment)){
                        if($isSuccess && (file_exists($existing_path))){
                            unlink($existing_path);
                        }
                    }
                    // print_r($insert);die;
                }else{

                    $data['attachment'] = $upload_data['file_name'];
                    $data['updated_by'] = $presenter_id;
                    $data['updated_on'] = date("Y-m-d H:i:s");
                    $data['content'] = '';

                    $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $data);
                    if(isset($schedule->attachment)){
                        if($isSuccess && (file_exists($existing_path))){
                            unlink($existing_path);
                        }
                    }
                    // Update order_schedule_status_log Table.
                    $schedules = $this->App_model->get_all_log_content($order_schedule_id);

                    foreach ($schedules as $schedule) {

                        if ($schedule['old_status'] == 'Create invoice'){
                            $isDeleteSuccess = $this->App_model->delete('order_schedule_status_log', $schedule['id']);
                        }
                        if ($schedule['old_status'] == 'Create log'){
                            // echo "Hi";die;
                            $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $schedule['id'], $data);
                            
                        }         

                    }
                }

                    // Update Schedule Table
                    $data_schedule = array(
                    // 'status' => 'Awaiting Review',
                    'status' => 'Create invoice',
                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by' => $presenter_id,
                    'log_status' => 'file upload',
                    're_upload_change' => '1'
                );

                $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Status successfully updated.',
                    'error' => NULL
                ), REST_Controller::HTTP_OK);
            
            }else{
                $this->response(array(
                    'status' => FALSE,
                    'message' => $this->upload->display_errors(),
                    'error' => NULL
                ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function multiplePrincipalSign_post(){

        // file upload
        $attachment = (isset($_FILES['sign'])?$_FILES['sign']:"");
        $config['upload_path'] = DIR_SIGN;
        // $config['max_size'] = '25000';
        $config['allowed_types'] = 'png';
        $config['overwrite'] = FALSE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);

        $attach = array();

        $_FILES['attach[]']['name'] = $attachment['name'];
        $_FILES['attach[]']['type'] = $attachment['type'];
        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'];
        $_FILES['attach[]']['error'] = $attachment['error'];
        $_FILES['attach[]']['size'] = $attachment['size'];

        $config['file_name'] = md5(date("dmYhisA"));
        $attach[] = $config['file_name'];

        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
        $this->upload->initialize($config);

        if ($this->upload->do_upload('attach[]')) {
            $upload_data =  $this->upload->data();
            $content = $upload_data['file_name'];
            // echo $content;die;
        } else {
            $this->response(array(
                'status' => FALSE,
                'message' => 'Unsuccessfull.',
                'error' => $this->upload->display_errors()
            ), REST_Controller::HTTP_OK);
        }
        // file upload

        $order_id = $this->input->post('order_id');
        $presenter_id = $this->input->post('presenter_id');
        $status = $this->input->post('status');
        $old_status = $this->input->post('old_status');
        
        $order_schedule_ids = $this->input->post('order_schedule_status_id');
        $order_schedule_id_mul = explode(',',$order_schedule_ids);
        $img = $this->input->post('img_data');
        // save sign in folder
		// $imagedata = base64_decode($img);
		// $filename = md5(date("dmYhisA"));
		// //Location to where you want to created sign image
		// $file_name = DIR_SIGN.$filename.'.png';
		// file_put_contents($file_name,$imagedata);
        // $content = $file_name;

        if ($status == "Awaiting Review") {
            foreach($order_schedule_id_mul as $order_schedule_id){
                // if ($status == "Awaiting Review") {
                    // $data['content'] = isset($content) ? $content : '';
                    $data['content'] = DIR_SIGN.$content;
                    $logData = $this->App_model->get_schedule_logContent($order_schedule_id);
            
                    // placing signatures in new position 
                    $logs_principal_name = $this->App_model->logs_principal_name($order_schedule_id);
                    $content_txt = $this->App_model->get_schedule_logContent_txt($order_schedule_id);
                    $order = $this->App_model->get_order_details($order_id);
                    $schedule = $this->App_model->get_order_schedule_details($order_schedule_id); 
                    $arr = explode(" ",$content_txt);
                    $arr_length = sizeof($arr);
                    $logDatanew= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                    <tr>
                        <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 50% !important;"></td>
                        <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                    </tr>
                    <tr>
                        <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                    </tr>
                    <tr>
                        <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                    </tr>';
            
                    
                    //     // echo $arr[$index]. " ";
                    //     $index_first_page=470;
                    //     $max_loop_count = $arr_length;
                    //     if($max_loop_count>$index_first_page){
                    //         $max_loop_count = $index_first_page;
                    //     }
                    
                    // $logDatanew .= '<tr>
                    //     <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px;">';
                    //     for ($index = 0; $index < $max_loop_count; $index++) {
                    //         $logDatanew .= $arr[$index]." ";
                    //     }
                    //     $logDatanew .='</td>
                    // </tr>
                    // ';    
                    // // ...........................................
                    // $index_rest_pages = 814;
                    //     $arr_length_rest_page=$arr_length-$index_first_page;
            
                    //     $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);
            
                    //     // $arr_loop_count = ($arr_length_rest_page / $index_rest_pages);
                    //     $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                    //     if($last_loop_data_count>0) {
                    //         $arr_loop_count = $arr_loop_count+1;
                    //     }
            
                    // // while($arr_length_2pg >= 0){
                    // for( $i=0; $i < $arr_loop_count; $i++){
                    //     // if(!empty($arr[$last_index])){
                    //         $index_j = $index_first_page+($index_rest_pages*$i);
                    //         $index_max_j = 0;
                    //         if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                    //             $index_max_j = $index_j+$last_loop_data_count;
                    //         }else{
                    //             $index_max_j = $index_j+$index_rest_pages;
                    //         }
                            
                    //         $logDatanew .= '<tr>
                    //         <td  align="left" colspan="2" style="padding-left: 2px;">';
                    //         for ($j= $index_j; $j < $index_max_j; $j++) {
                    //             $logDatanew .= $arr[$j]." ";    
                                
                    //     }
                    //     $logDatanew .='</td>
                    //     </tr>
                    //     '; 
                    // }




                    $index_first_page=470;

                    $max_loop_count = $arr_length;
                    if($max_loop_count>$index_first_page){
                        $max_loop_count = $index_first_page;
                    }
                  
                $logDatanew .= '<tr>
                    <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px; ">';
                    for ($index = 0; $index <= $max_loop_count; $index++) {

                        // if (strpos($arr[$index], "<br>") != false &&        $max_loop_count>=$index_first_page) {
                        if($index <= sizeof($arr)){
                            if (strpos($arr[$index], "<br>") != false) {
                                $break_pos = (15-($index % 15));
                                if($break_pos>2 && ($index % 15)!=0){
                                    // $break_pos = 15-($index % 15);
                                    $max_loop_count = ($max_loop_count-$break_pos);
                                }
                            }

                            
                                $logDatanew .= $arr[$index]." ";
                        }
                    }
                  
                    $logDatanew .='</td>
                </tr>
                ';    
                $index_first_page=$max_loop_count;
                $index_rest_pages = 800;

                    $arr_length_rest_page = ($arr_length-$index_first_page);

                    $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                    $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                    if($last_loop_data_count>0) {
                        $arr_loop_count = $arr_loop_count+1;
                    }
                    $index_break = 0;
                    $index_break_word=0;
                    for( $i=0; $i < $arr_loop_count; $i++){
                        if($index_break==0){
                            $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                        }else{
                            $index_j=$index_max_j;
                        }
                            // $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                            // $index_j = ($index_first_page+($index_rest_pages*$i)) - $index_break;
                            $index_max_j = 0;

                            if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                                $index_max_j = $index_j+$last_loop_data_count;
                            }else{
                                $index_max_j = $index_j+$index_rest_pages;
                            }
                            $logDatanew .= '<tr>
                            <td  align="left" colspan="2" style="padding-left: 2px; ">';
                            for ($j= $index_j; $j < $index_max_j; $j++) {

                                if(($index_max_j - $index_j)<$index_rest_pages){
                                    $index_max_j = $index_max_j+$index_break_word;
                                }
                                // if (strpos($arr[$j], "<br>") != false) {
                                if($j <= sizeof($arr)){
                                    if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                                        $break_pos_rest_page = (15-($j%15));
                                        if($break_pos_rest_page>2 && ($j%15)!=0){
                                            // $break_pos_rest_page = ($j%15);
                                            $index_max_j = ($index_max_j-$break_pos_rest_page);
                                            // $index_break = ($index_break+$break_pos_rest_page);
                                            $index_break_word = ($index_break_word+$break_pos_rest_page);
                                            $index_break = 1;
                                        }
                                    }
                                    
                                        $logDatanew .= $arr[$j]." ";   
                                } 
                                
                        }
                        $logDatanew .='</td>
                        </tr>
                        '; 
                    }



                    
            
                    $logDatanew .= '
                        <tr>
                            <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Principal:</strong> '. $logs_principal_name.'</td>
                        </tr>
            
                
            
            
                        <tr>
                            <td><strong>Principal’s Signature:</strong><img src="'.base_url().$data['content'].'"width="100" height="50" style="margin-top:-15px; margin-bottom:-7px;"></td>
                            <td align="right" style="padding-top:22px; width:120px;"><strong>Total Hours:</strong>'.$schedule->total_hours.'</td>
                    </tr>
                        
                    
                    
                    
                    </table>';
                    $pdfnew= $logDatanew;
                    
                    // $pdf = $logData.'<img src="'.FCPATH.$data['content'].'">';
            
                    // end
            
                    $this->load->library('m_pdf');
            
                    //this the the PDF filename that user will get to download
                    $data['school_pdf'] = DIR_TEACHER_FILES."log_".time().".pdf";       
                                
                    //generate the PDF from the given html
                    // $this->m_pdf->pdf->WriteHTML($pdf);
                    $this->m_pdf->pdf->WriteHTML($pdfnew);
                    
                    
                    //download it.
                    $this->m_pdf->pdf->Output($data['school_pdf']); 
            
            
                    $data['order_schedule_id'] = $order_schedule_id;
                    // $data['new_status'] = 'Awaiting Review';
                    $data['new_status'] = 'Create invoice';
                    $data['old_status'] = 'Log sent - awaiting principal signature';
                    $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                    $data['updated_by'] = $presenter_id;
            
                    // echo '<pre>'; print_r($data); 
                    $this->App_model->insert('order_schedule_status_log', $data);
            
                    // Update Schedule Table
                    $data_schedule = array(
                        // 'status' => ($status == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                        'status' => 'Create invoice',
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => $presenter_id,
                        'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                    );
            
                    // echo '<pre>'; print_r($data_schedule); die;
                    $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
            
            
                    //New implementation for updatin content field
                    $data_schedule_oldrow = array( 
                        'content' => $logDatanew,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' =>$presenter_id
                        
                    );
                    // $data_schedule_oldrow['content'] = $logDatanew;
            
                    $this->App_model->update_for_old_row('order_schedule_status_log', 'order_schedule_id', $order_schedule_id, $data_schedule_oldrow);
            
                    // $count++;
            
                // }
            }
            $this->response(array(
                'status' => TRUE,
                'message' => 'Status successfully updated.',
                'error' => NULL
            ), REST_Controller::HTTP_OK);
        }else{
            $this->response(array(
                'status' => FALSE,
                'message' => 'Something went wrong.',
                'error' => NULL
            ), REST_Controller::HTTP_OK);
        }

       
    }



   
   

}