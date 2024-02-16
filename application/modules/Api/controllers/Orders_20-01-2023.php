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
                        "message" => 'No schools found.'
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
                        "message" => 'No orders found.'
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
                    "status" => FALSE,
                    "message" => 'No records.'
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
            $topics = $this->Api_model->get_selected_topics($order->title_id, $order_id);
            if(!empty($topics)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $topics
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'No topic found.',
                    'error' => NULL
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
            $teacher_grades=$this->App_model->get_teacher_grades_title($school_id,$title_id);
            if(!empty($teacher_grades)){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Success',
                    'error' => NULL,
                    'data'=> $teacher_grades
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'No grade found.',
                    'error' => NULL
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
                    'status' => FALSE,
                    'message' => 'No teacher found.',
                    'error' => NULL
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
                $data['topics'] = $this->App_model->get_selected_topics($data['order']->title_id, $order_id);
                $data['teacher_grades']=$this->App_model->get_teacher_grades_title($school_id,$title_id);


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
					$gradeId = $this->App_model->check_grade_string($gradesString,$this->session->userdata('id'));
					// insert in teachers field
					$insertdata['school_id'] = $school_id;
					$insertdata['title_id'] = $data['order']->title_id;
					$insertdata['grade_id'] = $gradeId;
					$insertdata['created_by'] = $this->session->userdata('id');
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
        $presenter_id   = $this->session->userdata('id');
      
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

        if(empty($scheduleData)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Something went to wrong please try again.'
            ),REST_Controller::HTTP_OK);
        }

        // $data['order']          = $this->App_model->get_order_details($order_id); // Get order details
        // $data['topics']         = $this->App_model->get_title_topics($data['order']->title_id); // Get the Topics
        // $data['selected_order'] = $order_id;

        $schedulable_hr         = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
        $scheduled_hr           = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

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

        if($scheduled_hour <> $this->input->post('total_hours')){

            $scheduleHour = abs($this->input->post('total_hours') - $scheduled_hour);

            if ($remaining_schedule_hrs <  $scheduleHour) {
                $this->response(array(
                    "status" => FALSE,
                    "message" => 'Schedule hours is greater than remaining hours.'
                ),REST_Controller::HTTP_OK);
            }
        }

        $start_ts   = new DateTime($date." ".$start_time);
        $start_date = $start_ts->format('Y-m-d H:i:s');

        $end_ts     = new DateTime($date." ".$end_time);
        $end_date   = $end_ts->format('Y-m-d H:i:s');

        $checkSchedule = $this->App_model->check_exist_schedule_datetime($this->session->userdata('id'), $start_date, $end_date, $schedule_id);

        if(!empty($checkSchedule)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Schedule hours is already booked.'
            ),REST_Controller::HTTP_OK);
        }
    
        $diff30Min = $this->App_model->check_schedule_30min_diff($this->session->userdata('id'), $start_date, $end_date);
        if(!empty($diff30Min)){
            $this->response(array(
                "status" => FALSE,
                "message" => 'Please 30 mins gap between two schedule.'
            ),REST_Controller::HTTP_OK);
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

   
   

}