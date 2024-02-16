<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "libraries/tcpdf/PDFMerger.php";
require_once APPPATH . "libraries/tcpdf/tcpdf.php";
require_once APPPATH . "libraries/vendor/autoload.php";
require_once APPPATH . "libraries/fpdi2/src/autoload.php"; // 12-06-2023
use setasign\Fpdi; // 12-06-2023
use PDFMerger\PDFMerger;
class Orders extends Application_Controller {

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
	private $tablename = 'orders';
	private $url = '/app/orders';
	private $permissionValues = array(
		'index' => 'App.Orders.View',
		'update_status' => 'App.Orders.UpdateStatus',
        'delete' => 'App.Orders.Delete',
		'add' => 'App.Orders.Add',
    );

	private $baa_co_id 	= 129; // BAA Coordinator ID
    //private $allowed_roles = array('bar_admin');

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
		add_js('assets/js/plugins/colResizable-1.6.min.js');

		$filter = array('deleted' => 0);
		$default_uri = array('page', 'status', 'school', 'presenter', 'order_start_date', 'order_end_date', 'order_no', 'session');
    	$uri = $this->uri->uri_to_assoc(4, $default_uri);
		$pegination_uri = array();

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    	} else {
    		$page = 0;
    	}
		
		if ($uri['order_no'] <> "" && $uri['order_no'] <> "~") {
            $filter['order_no'] = $uri['order_no'];
			$pegination_uri['order_no'] = $uri['order_no'];
        } else {
			$filter['order_no'] = "";
			$pegination_uri['order_no'] = "~";
		}
		
		if ($uri['status'] <> "" && $uri['status'] <> "~") {
            $filter['status'] = $uri['status'];
			$pegination_uri['status'] = $uri['status'];
        } else {
			$filter['status'] = "";
			$pegination_uri['status'] = "~";
		}
		
		if ($uri['school'] <> "" && $uri['school'] <> "~") {
            $filter['school'] = $uri['school'];
			$pegination_uri['school'] = $uri['school'];
        } else {
			$filter['school'] = "";
			$pegination_uri['school'] = "~";
		}
		
		if ($uri['presenter'] <> "" && $uri['presenter'] <> "~") {
            $filter['presenter'] = $uri['presenter'];
			$pegination_uri['presenter'] = $uri['presenter'];
        } else {
			$filter['presenter'] = "";
			$pegination_uri['presenter'] = "~";
		}
		
		if ($uri['order_start_date'] <> "" && $uri['order_start_date'] <> "~") {
            $filter['order_start_date'] =  str_replace('~', '/', $uri['order_start_date']);
			$pegination_uri['order_start_date'] = $uri['order_start_date']; //changed

        } else {
			$filter['order_start_date'] = "";
			$pegination_uri['order_start_date'] = "~";
		}
		
		if ($uri['order_end_date'] <> "" && $uri['order_end_date'] <> "~") {
            $filter['order_end_date'] = str_replace('~', '/', $uri['order_end_date']);
			$pegination_uri['order_end_date'] = $uri['order_end_date']; //changed
        } else {
			$filter['order_end_date'] = "";
			$pegination_uri['order_end_date'] = "~";
		}

        $curr_date = date("Y-m-d h:i:s");
		$curr_session_id = $this->App_model->get_curr_session_id($curr_date);
		//for session
		if ($uri['session'] <> "" && $uri['session'] <> "~") {
			//fetching range
			$filter['session'] = str_replace('~', '/', $uri['session']);
			$pegination_uri['session'] = $uri['session']; //changed
        } else {
			$filter['session'] = $curr_session_id;
			$pegination_uri['session'] = $curr_session_id;
		}
		//end

		$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($filter['session']);
		$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($filter['session']);
		
		if ($this->session->userdata('role') != 'administrator') {
			$filter['school'] = $this->session->userdata('id');
		}
		
    	// Get the total rows without limit
	   	$total_rows = $this->App_model->get_order_list($filter, null, null, true);
        $config = $this->init_pagination('app/orders/index/'.$this->uri->assoc_to_uri($pegination_uri).'//page/', 19, $total_rows);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Get the order List
	    $data['orders'] = $this->App_model->get_order_list($filter, 'created_on', 'desc');

    	//print "<pre>"; print_r($data);print "</pre>";
		$data['filter'] = $filter;
	
		$this->load->model('../../Admin/models/Admin_model');
		//$data['schools'] = $this->App_model->get_school_list(array('deleted'=>0));
		//$data['teachers'] = $this->App_model->get_teacher_list(array('deleted'=>0));
		$schools = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		//$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
		//$data['presenters'] = $this->Admin_model->get_school_presenter(array('deleted'=>0, 'status'=>'active', 'school_id'=>$this->session->userdata('id'), 'first_name', 'ASC'));
		if ($this->session->userdata('role') == 'school_admin') {
            $data['presenters'] = $this->Admin_model->get_school_presenter(array('deleted'=>0, 'status'=>'active', 'school_id'=>$this->session->userdata('id'), 'first_name', 'ASC'));
        }else{
            $data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
        }
		// Sort by school name
		usort($schools, function($a, $b){
			return ($a->meta['school_name'] <= $b->meta['school_name']) ? -1 : 1;
		});
		$data['schools'] = $schools;

        //session from table
		$data['s_array'] = $this->App_model->get_sessions();
		//end

	    $data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	function method1($a,$b) 
	{
		return ($a['meta']['school_name'] <= $b['meta']['school_name']) ? -1 : 1;
	}

    /**
     *
     */
    public function add() {
		

		$data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		
		$this->load->model('../../Admin/models/Admin_model');
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'users.first_name', 'ASC');
		
		$schools = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'school_admin'));
		
		// Sort by school name
		usort($schools, function($a, $b){
			return ($a->meta['school_name'] <= $b->meta['school_name']) ? -1 : 1;
		});
		$data['schools'] = $schools;

		if($this->session->userdata('role') == 'school_admin')
		{
		    $filter = array();
			$filter['deleted'] = 0;
			$filter['role_token'] = 'coordinator';
			$status = '';

		    if ($status <> '') {
			    $filter['status'] = $status;
		    } else {
		    	$status = 0;
		    }	
		    		
			$school_id = $this->session->userdata('id');
			$data['school_meta'] = $this->Admin_model->get_user_meta($school_id);
			$titles = $this->App_model->get_school_titles($school_id);
			$data['titles'] = array();
			foreach ($titles as $key => $val) {
				$data['titles'][] = (object) array('id' => $key, 'name' => $val);
			}
			$data['presenters'] = $this->Admin_model->get_school_presenter(array('deleted'=>0, 'status'=>'active', 'school_id'=>$school_id, 'first_name', 'ASC'));
			$data['coordinator_list'] = $this->App_model->get_coordinator_list($filter, $school_id, 'id', 'asc');
		}
		elseif($this->session->userdata('role') == 'administrator')
		{
		    $filter 				= array();
			$filter['deleted'] 		= 0;
			$filter['role_token'] 	= 'coordinator';
			$status = '';

		    if ($status <> '') {
			    $filter['status'] = $status;
		    } else {
		    	$status = 0;
		    }

			$school_id = $this->input->get('school_id');
			$data['coordinator_list'] = $this->App_model->get_coordinator_list($filter, $school_id, 'first_name', 'asc');
		}		

		if($this->session->userdata('role') == 'coordinator'){
			$data['schools'] = $this->App_model->get_mappedschool_list(array('delete' => 0, 'status' => 'active'), $this->session->userdata('id'));
		}

		// echo "<pre>";print_r($data['schools']);exit;

        $data['sessions'] = $this->App_model->get_session_for_create_order();
		
		$data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/add';
    	$this->load->view(TEMPLATE_PATH, $data);
    }

    /**
	Following method will be used to
	show the providers involved for a
	order
	Created on: 24-06-2019
	Created by: Soumya
    **/
    public function presenter_view($order_id)
    {
    	$get_presenters = $this->App_model->get_presenters_view($order_id);
    	echo $get_presenters;
    }

    /**
	Following method will be used 
	to allocate provided hours to 
	presenters with grades.
	Created on: 20-06-2019
	Created by: Soumya
    **/
    public function assign_hours($order_id = NULL) 
    {

        $uri2=$this->uri->segment(6);
       // echo $uri2;die;
        if ($uri2<> "" && $uri2 <> "~") {
            $filter['presenter'] = $uri2;
           
        } else {
            $filter['presenter'] = "";
           
        }

    	## Populate data like order details, school list, grade list, presenter list ##
    	if(isset($_POST['order_id']))
    		$order_id = $this->input->post('order_id');

    	$data['order_details'] 		= $this->App_model->get_specific_order($order_id);
    	$get_assignment_details		= $this->App_model->get_specific_assignment($order_id);

    	if(!empty($get_assignment_details))
    		$data['assignment_det']	= $get_assignment_details;
    	else
    		$data['assignment_det']	= '';

    	if(!empty($data['order_details']['coordinator_id'])  && $data['order_details']['coordinator_id'] != $this->baa_co_id)
    		$data['coordinator_id'] = $data['order_details']['coordinator_id'];
    	elseif(!empty($data['order_details']))
			$data['coordinator_id'] = '';
    	else
    		$data['coordinator_id'] = '';

    	$data['order_no']			= $data['order_details']['order_no'];
    	$data['order_id']			= $order_id;
    	$data['alloted_hours']		= $data['order_details']['hours'];
        //22-07-2022
        $data['presenterfilter']             = $filter['presenter'];

    	$data['presenter_list'] 	= $this->App_model->get_assignable_presenters($data['coordinator_id'], $data['order_details']['school_id'],$data['presenterfilter'] );
    	if(empty($data['presenter_list'])){
    		$data['presenter_list'] 	= $this->App_model->get_assignable_presenters($data['coordinator_id'], $data['presenterfilter'] );
    	}

         //new
         $data['presenter_full_list']    = $this->App_model->get_assignable_presenters($data['coordinator_id'], $data['order_details']['school_id']);
         if(empty($data['presenter_full_list'])){
             $data['presenter_full_list']    = $this->App_model->get_assignable_presenters($data['coordinator_id']);
         }

    	$data['grade_list']			= $this->App_model->get_school_teacher($data['order_details']['school_id'], $data['order_details']['title_id']);

    	// After the form submission 
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$order_id 		= $this->input->post('order_id');
    		$presenter_id 	= $this->input->post('presenter_id[]');

    		$grade 			= $this->input->post('grade[]');
    		$assigned_hours = $this->input->post('assigned_hours[]');
			$hidden_pre_id = $this->input->post('hdn_pre_id[]');

            $is_filter = $this->input->post('is_filter');
            if($is_filter != 0){
                // print_r($presenter_id);
                // echo $presenter_id[0]; die;
                $get_assignment_details_by_presenter= $this->App_model->get_specific_assignment_by_presenter($order_id, $presenter_id[0]);
                $data['remaining_hours_filter'] = $data['alloted_hours'] - $get_assignment_details_by_presenter['total_used_hours'];
            }
    		//form validation
    		$this->form_validation->set_rules('presenter_id[]', 'Checkbox', 'required');

    		if(empty(array_filter($assigned_hours))){
    			$this->form_validation->set_rules('assigned_hours[]', 'Assign hour', 'required');
    		}
    		// if(empty(array_filter($grade))){
    		// 	$this->form_validation->set_rules('grade[]', 'Grade', 'required');
    		// }

    		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
			//08-09-2021
            $flag = 0;
            foreach($hidden_pre_id as $hdn_key => $hdn_val){
                if(!empty($hidden_pre_id[$hdn_key]) && empty($assigned_hours[$hdn_key])){
                    $flag =1;
                }
            }
            foreach($assigned_hours as $key => $val){
                if(!empty($assigned_hours[$key]) && empty($hidden_pre_id[$key])){
                    $flag =1;
                }
            }
            // echo $flag;die;
            if($flag == 0){  // end 08-09-2021
			
				//if the form has passed through the validation
				// if ($this->form_validation->run())
				// {	
					$posted_hours	= 0;
					$check_one_hr	= 0;

					foreach($assigned_hours as $hours_val)
					{
						// $rest_hours = ($data['alloted_hours'] - $posted_hours);
                        if($is_filter != 0){
                            $rest_hours = $data['remaining_hours_filter'];
                        }else{
                            $rest_hours = ($data['alloted_hours'] - $posted_hours);
                        }

						if(!empty($hours_val))
						{
							if($rest_hours == 1)
							{
								$hours_input[] 	= $hours_val;
								$posted_hours 	= $posted_hours + $hours_val;   					
							}
							else
							{
								if($hours_val >= 2)
								{
									$hours_input[] 	= $hours_val;
									$posted_hours 	= $posted_hours + $hours_val;    						
								}
								else
								{
									$check_one_hr = 1;
									break;
								}
							}

						}
					} 

					if($check_one_hr)
					{
						$this->session->set_flashdata('message_type', 'danger');
						$this->session->set_flashdata('message', '<strong>Oops!</strong> 1 hour can only be given if left hour will be 1.');
						$check_one_hr = 0;
					}
					else
					{
						// if($posted_hours > $data['alloted_hours']) 
						// {
						// 	$this->session->set_flashdata('message_type', 'danger');
						// 	$this->session->set_flashdata('message', '<strong>Oops!</strong> Total submitted hours are more than allowed hours for the order.');

						// 	redirect('/app/orders/assign_hours/'.$order_id);    			
						// }
                        if($is_filter != 0){
                            if($posted_hours > $data['remaining_hours_filter']){
                                
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', '<strong>Oops!</strong> Total submitted hours are more than allowed hours for the order.');

                                redirect('/app/orders/assign_hours/'.$order_id);    			
                            }
                        }else{
                                if($posted_hours > $data['alloted_hours']){
                                
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', '<strong>Oops!</strong> Total submitted hours are more than allowed hours for the order.');

                                redirect('/app/orders/assign_hours/'.$order_id);    			
                            }
                        }

						$errMsg = '';
						$update_data = array();
						foreach($presenter_id as $outerKey=>$outerValue)
						{

							$gradeId = '';
							foreach($grade[$outerValue] as $grade_val)
							{
								if($gradeId == '')
									$gradeId .= $grade_val;
								else
									$gradeId .= ','.$grade_val;
							}

				        // echo "<pre>";print_r($presenter_id);print_r($grade);print_r($gradeId);exit;

							$scheduledHrs = $this->App_model->get_utilized_hours_presenter($order_id, $outerValue);

							if($scheduledHrs > $hours_input[$outerKey]){
								$presenterNameKey = array_search($outerValue, array_column($data['presenter_list'], 'presenter_id'));
								$presenterName= $data['presenter_list'][$presenterNameKey]['first_name'];

								if($errMsg == ''){
									$errMsg .= '<b>'.$presenterName.'</b> has already scheduled '.$scheduledHrs.' hrs for this order';
								}else{
									$errMsg .= '<br/><b>'.$presenterName.'</b> has already scheduled '.$scheduledHrs.' hrs for this order';
								}
							}

							$update_data[$outerKey]['order_id'] 		= $order_id;
							$update_data[$outerKey]['presenter_id'] 	= $outerValue;
							$update_data[$outerKey]['assigned_hours']	= $hours_input[$outerKey];
							// $update_data[$outerKey]['grade_id'] 		= $grade_input[$outerKey];
							$update_data[$outerKey]['grade_id'] 		= $gradeId;

							// $data_populate_status			= $this->App_model->insert('order_assigned_presenters', $update_data);
						}

						if($errMsg != ''){
							$this->session->set_flashdata('message_type', 'danger');
							$this->session->set_flashdata('message', '<strong>Oops!</strong> '.$errMsg);

							redirect('/app/orders/assign_hours/'.$order_id); 
						}else{
                            // modified for filter 
                            if($is_filter != 0){
                                $check_is_exist = $this->App_model->get_assigned_hurs_specific($is_filter,$order_id);
                                if($check_is_exist == FALSE){
                                    // echo 'false';
                                    // die;
                                    if(!empty($update_data)){
                                        $this->db->insert_batch('order_assigned_presenters', $update_data);
                                    }
                                }else{
                                    $delete_prev_presntrOdr = $this->App_model->delete_prev_presntrOdr($order_id, $is_filter);
                                    if(!empty($update_data)){
                                        $this->db->insert_batch('order_assigned_presenters', $update_data);
                                    }
                                }
                            }else{
                                $deleted_prevd	= $this->App_model->delete_previous_assignment($order_id);
                                if(!empty($update_data)){
                                    $this->db->insert_batch('order_assigned_presenters', $update_data);
                                }
                            }
                            // end

							// $deleted_prevd	= $this->App_model->delete_previous_assignment($order_id);
							// $this->db->insert_batch('order_assigned_presenters', $update_data);

                                //sending mail to presenters 25-07-2022
                                $odrDtls = $this->App_model->get_order_details_by_orderId($order_id);
                            
                                foreach($update_data as $updtData){
                                    // echo $updtData['presenter_id']; echo '<br/>';
                                    //presenter name
                                    $presenterName= $this->App_model->get_presenter_name($updtData['presenter_id']);
                                    // print_r($presenterName); die;
                                    $odrDtls->presenter_name = $presenterName->first_name.''.$presenterName->last_name;
                                    //school name
                                    $schlname = $this->App_model->get_school_name($odrDtls->school_id);
                                    $odrDtls->school_name = $schlname->meta_value;
                                    //title name
                                    $titlename = $this->App_model->get_title_name($odrDtls->title_id);
                                    $odrDtls->title_name = $titlename->name;
                                    // Send notification on Site admin
                                    $msg ="An order has been assigned, please check the details below.<br/><br/>";
                                    $msg .= "<p><b>Order Number:</b> ".$odrDtls->order_no."<br/><b>Work Plan Number:</b> ".$odrDtls->work_plan_number."<br/><b>Presenter Name:</b> ".$odrDtls->presenter_name."<br/><b>School name:</b> ".$odrDtls->school_name."<br/><b>Title:</b> ".$odrDtls->title_name."<br/><b>Total hours assigned:</b> ".$updtData['assigned_hours']."<br/><b>Order Date:</b> ".$odrDtls->booking_date."</p>";

                                    $this->load->library('mail_template');
                                    // $this->mail_template->notification_email('Kate', 'brienzaportalstaging@gmail.com', $msg, NULL);
                                    $this->mail_template->notification_email('Brienza', 'brienzaportalstaging@gmail.com', $msg, NULL);
                                    // $this->mail_template->notification_email('Brienza', 'gs.avalgate@gmail.com', $msg, NULL);

                                }
                                //end
						}

						/*
						$update_order_data['status'] = 'approved';
						$update_order_data_return	 = $this->App_model->update('orders', 'id', $order_id, $update_order_data);	
						*/

						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', '<strong>Well done!</strong> Hours are successfully assigned to presenters.');

						redirect('/app/orders/assign_hours/'.$order_id);
					}
				// }
			}else{
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', '<strong>Oops!</strong> The "assign hour(s)" field cannot be zero or empty and also the presenter name must be selected as respectively for the "assigned hour(s)" field.');
                redirect('/app/orders/assign_hours/'.$order_id); 
            }
            //end

    	}    	

		$data['page'] = 'Assign Hours';
    	$data['page_title'] = SITE_NAME.' :: Assign Presenters Hours';

    	$data['main_content'] = 'orders/assign_hours';
    	$this->load->view(TEMPLATE_PATH, $data);
    }    
	## ------- End of the code --------- ##
	
	
	public function presenter() {
		
		// Create the filters
	    $filter = array();
		$filter['deleted'] = 0;
		$filter['role_token'] = 'teacher';
		$filter['status'] = 'active';
		$filter['school_id'] = $this->session->userdata('id');
		
		// Get the Users List
		$this->load->model('../../Admin/models/Admin_model');
		
	    // $data['list'] = $this->Admin_model->get_users_list($filter, 'id', 'asc');
	    $data['list'] = $this->Admin_model->get_school_presenter($filter, 'id', 'asc');
		
		$data['titles'] = $this->App_model->get_title_list(array('deleted'=>0, 'status'=>'active'));
		
		//print "<pre>"; print_r($data); print "</pre>";
		$data['page'] = 'orders';
    	$data['page_title'] = SITE_NAME.' :: Manage Orders';

    	$data['main_content'] = 'orders/presenter';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

	/**
     *
     * @param int $id
     */
    public function delete($id = null) {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

    	$data['info'] = $this->App_model->get_order_details($id);

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/orders');
    	}

		$data_to_store = array(
		   'is_deleted' => 1
	   	);

	   	if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Order successfully deleted.');
        } else {
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
        }
    	redirect('/app/orders');
    }
	
	
	/**
     *
     * @param int $id
     */
    public function change_status($status = null, $id = null) {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);
    	$data['info'] = $this->App_model->get_order_details($id);

        $this->load->library('user_agent'); 
		$refer = $this->agent->referrer(); 

    	if (!is_numeric($id) || $id == 0 || empty($data['info'])) {
    		redirect('/app/orders');
    	}

		if($status == 'approved'){
            if ($this->input->server('REQUEST_METHOD') === 'POST')
            {
                //form validation
                $this->form_validation->set_rules('order_no', 'Order number', 'required');
                $this->form_validation->set_rules('work_plan_number', 'Work plan number', 'required');
                //if the form has passed through the validation
                if ($this->form_validation->run())
                {
                    $data_to_store = array(
                        'status' => $status,
                        'order_no'          => $this->input->post('order_no'),
                        'work_plan_number'  => $this->input->post('work_plan_number')
                        );
            
            
                    if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
                        $this->session->set_flashdata('message_type', 'success');
                        $this->session->set_flashdata('message', '<strong>Well done!</strong> Order successfully '.$status);
                    }else {
                        $this->session->set_flashdata('message_type', 'danger');
                        $this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
                    }

                    $redirection_url = $this->input->post('redirection');

                    if(empty($redirection_url))
                        // redirect('/app/orders');
                        redirect($refer);
                    else
                        redirect($redirection_url);
                }else{
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', validation_errors());

                    $redirection_url = $this->input->post('redirection');

                    if(empty($redirection_url))
                        // redirect('/app/orders');
                        redirect($refer);
                    else
                        redirect($redirection_url);
                }
            }
        }else{
            $data_to_store = array(
			'status' => $status,
			'order_no'          => $this->input->post('order_no'),
			'work_plan_number'  => $this->input->post('work_plan_number')
			);
 
 
			if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', '<strong>Well done!</strong> Order successfully '.$status);
			} else {
				$this->session->set_flashdata('message_type', 'danger');
				$this->session->set_flashdata('message', '<strong>Oh snap!</strong> Change something and try again.');
			}

			$redirection_url = $this->input->post('redirection');

			if(empty($redirection_url))
				// redirect('/app/orders');
                redirect($refer);
			else
				redirect($redirection_url);
        }
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
    		$this->form_validation->set_rules('item_id[]', 'Order', 'trim|required');

    		$this->form_validation->set_error_delimiters('', '');

    		//if the form has passed through the validation
    		if ($this->form_validation->run())
    		{
    			//print "<pre>"; print_r($_POST);die;
    			$count = 0;
    			$items = $this->input->post('item_id');
    			$operation = $this->input->post('operation');

				// 28-09-2021
             /*   $not_deleteFlag = 0;
                foreach ($items as $id=>$value) {
                    $min_date = $this->App_model->get_min_date($id);
                    // print_r($min_date);
                    $current_date = date('Y-m-d');
                    if($min_date <= $current_date){
                        $not_deleteFlag++;
                    }
                }*/

    			foreach ($items as $id=>$value) {

					if ($operation == 'delete') {

						$data_to_store = array(
				    		'is_deleted' => 1
				    	);

						//adding 28-09-2021
                    /*    if($not_deleteFlag > 0){
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', '<strong>Oh snap!</strong> One or more order have passed their session date, so u cannot delete that order.');
                            redirect('/app/orders');
                        }else{
                            $data_to_store = array(
                                'is_deleted' => 1
                            );
                        }*/

    				} else {
						$data_to_store = array(
				    		'status' => ($operation == "approved")?'approved':'cancelled'
				    	);
    				}

					if ($this->App_model->update($this->tablename, 'id', $id, $data_to_store)) {
						$count++;
					}
    			}

    			$msg = ($operation=='delete')?'deleted.':'updated.';

    			$this->session->set_flashdata('message_type', 'success');
    			$this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' order(s) successfully '.$msg);

    		} else {
    			$this->session->set_flashdata('message_type', 'danger');
    			$this->session->set_flashdata('message', validation_errors());
    		}
    		redirect('/app/orders');
    	}
    }


	public function subscriptions($customer_id = null) {

		if ($customer_id == null) {
			return false;
		}

		// Get all the subsciptions
    	$data['subscriptions'] = $this->Customer_model->get_customer_subsciptions($customer_id);

    	//$data['main_content'] = ;
    	$this->load->view("orders/subscriptions", $data);
	}

	public function place_order() {
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour = $this->clean_value($this->input->post('hour'));

			$booking_date = date("Y-m-d");
			$title_id = $this->clean_value($this->input->post('title_id'));
			$presenter_id = $this->clean_value($this->input->post('presenter_id'));
			$coordinator_id 	= $this->clean_value($this->input->post('coordinator_id'));
            $session_id 	= $this->clean_value($this->input->post('session_id'));
						
			// Check the title exists
			//$school_id = $this->session->userdata('id');
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}
			$school_titles = $this->App_model->get_school_titles($school_id);
			$school_titles_ids = array_keys($school_titles);
			
			if (!in_array($title_id, $school_titles_ids)) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Please assign title before choosing it.")));
				return;
			}
			
			// Get the topics for chossen title
			$topics = array();
			$topics = $this->App_model->get_title_topic_data($title_id);
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('success' => true, 'topics' => $topics, 'hour' => $hour, 'booking_date' => $booking_date, 'title_id' => $title_id, 'presenter_id' => $presenter_id, 'coordinator_id' => $coordinator_id, 'school_id' => $school_id, 'msg' => "", 'session_id' => $session_id)));
			return;
		}
	}
	
	public function place_order_confirm() {
		if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$hour = $this->clean_value($this->input->post('hour'));

			if($hour > 0){
			$booking_date = $this->input->post('booking_date');
			$title_id = $this->clean_value($this->input->post('title_id'));
			$presenter_id = $this->clean_value($this->input->post('presenter_id'));
			$coordinator_id 	= $this->clean_value($this->input->post('coordinator_id'));
			$topics = $this->input->post('topics[]');	
            $session_id = $this->clean_value($this->input->post('session_id'));
			
			$coordinator_id = ($coordinator_id > 0) ? $coordinator_id : $this->baa_co_id;
			if ($this->input->post('school_id')) {
				$school_id = $this->input->post('school_id');
			} else {
				$school_id = $this->session->userdata('id');
			}
			
			// Get presenter rate
			$this->load->model('../../Admin/models/Admin_model');
			$presenter = $this->Admin_model->get_user_details($presenter_id);
			
			// ======== Start Code By Ahmed on 2019-09-21 ======= //
			$coordinatorData = $this->Admin_model->get_user_details($coordinator_id);
    		
			if(!empty($presenter) && isset($presenter->first_name)){
				$presenter_name = $presenter->first_name." ".$presenter->last_name;
			}else{
				$presenter_name = "--";
			}
			if(!empty($coordinatorData) && isset($coordinatorData->first_name)){
				$coordinator_name = $coordinatorData->first_name." ".$coordinatorData->last_name;
			}else{
				$coordinator_name = "--";
			}
			// Get school meta data
			$schoolData = $this->Admin_model->get_user_meta($school_id);

			// Get title Name from database
			$titleName = $this->Admin_model->get_title_name($title_id);
			// ======== End of the Code 2019-09-21 ====== //
			
			/*
			$data = array(
				'order_no' => "WQ".date("ymd").rand(100, 999),
				'school_id' => $school_id,
				'presenter_id' => $presenter_id,
				'title_id' => $title_id,
				'hours' => $hour,
				'hourly_rate' => $presenter->meta['rate'],
				'booking_date' => $this->format_date($booking_date),
				'status' => 'pending',
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('id')				
			);
			*/

			$data = array(
				'order_no' 			=> '',
				'school_id' 		=> $school_id,
				'presenter_id' 		=> $presenter_id,
				'coordinator_id'	=> $coordinator_id,
				'title_id' 			=> $title_id,
				'hours' 			=> $hour,
				'hourly_rate' 		=> (!empty($presenter)) ? $presenter->meta['rate'] : 0,
				'booking_date' 		=> $this->format_date($booking_date),
				'status' 			=> 'pending',
				'created_on' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $this->session->userdata('id'),
				'co_rate_type'		=> $coordinatorData->meta['rate_type'],
				'co_rate' 			=> $coordinatorData->meta['rate'],
                'session_id'        => $session_id,
			);				
			
			if ($order_id = $this->Admin_model->insert('orders', $data)) {
				// Insert the Order Topics
				if (!empty($topics)) {
					$this->App_model->insert_order_topics($order_id, $topics);
				}
				
                // ======== Start Code By Ahmed on 2019-09-21 ======= //
                // disabled on 25-08-2022
                // // Send notification on Site admin
                // $msg = "<p><b>School Name:</b> ".$schoolData['school_name']."<br/><b>Coordinator Name:</b> ".$coordinator_name."<br/><b>Presenter Name:</b> ".$presenter_name."<br/><b>Title:</b> ".$titleName."<br/><b>Booking Date:</b> ".$data['booking_date']."<br/><b>Status:</b> ".$data['status']."</p>";

                // $this->load->library('mail_template');
                // $emails = array('brienzaportalstaging@gmail.com','fraidy@thekgroupny.com');
                // // $emails = array('ereinertsen@brienzas.com','dmaddaloni@brienzas.com','agangi@brienzas.com ');
                // $this->mail_template->notification_email(null, $emails, $msg, 'Order');
                // // $this->mail_template->notification_email(null, 'brienzaportalstaging@gmail.com', $msg, 'Order');
                // ======== End of the Code 2019-09-21 ====== //

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => true, 'msg' => "Order successfully placed. Please note that orders are only processed Monday through Friday, from 10am to 4pm. Approval takes up to 5 to 10 days depending on the amount requested.")));
				return;
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('success' => false, 'msg' => "Error placing order. Please try again.")));
				return;
			}
		}else{
			$this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'msg' => "Error placing order. You cannot assign negative hours.")));
                return;
		}
		
	}
			//print_r($presenter);print_r($data); die;
}
	
	public function search_submit() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$order_no = $this->clean_value($this->input->post('order_no'));
    		$order_start_date = $this->clean_value($this->input->post('order_start_date'));
    		$order_end_date = $this->clean_value($this->input->post('order_end_date'));
			$school = $this->clean_value($this->input->post('school'));
			$presenter = $this->clean_value($this->input->post('presenter'));
			$status = $this->clean_value($this->input->post('status'));
            $session = $this->input->post('hdnSession');

			$url = "app/orders/index/";
			
			$order_no = urlencode($order_no);
            if ($order_no != '' && $order_no != '~') {
                $url .= "order_no/". $order_no."/";
            }
			
			// $order_start_date = urlencode($order_start_date);
            if ($order_start_date != '' && $order_start_date != '~') {
                $url .= "order_start_date/". $order_start_date."/";
            }

			// $order_end_date = urlencode($order_end_date);
			if ($order_end_date != '' && $order_end_date != '~') {
				$url .= "order_end_date/". $order_end_date."/";
			}
			
			$school = urlencode($school);
			if ($school != '' && $school != '~') {
				$url .= "school/".$school."/";
			}

			$presenter = urlencode($presenter);
			if ($presenter != '' && $presenter != '~') {
				$url .= "presenter/". $presenter."/";
			}

			$status = urlencode($status);
			if ($status != '' && $status != '~') {
				$url .= "status/". $status."/";
			}

            //for session
			if ($session != '' && $session != '~') {
                $url .= "session/". $session."/";
				// $url .= "order_start_date/". str_replace('~', '/', $order_start_date)."/";
            }

			redirect($url);
    	}
    }

	public function billing() {
        // echo "bb"; die();
        $order_id = $this->input->get('order_id');

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);
        
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
        
            $attachment = (isset($_FILES['attachment'])?$_FILES['attachment']:"");
            // print "<pre>"; print_r($attachment); die();
            $status = $this->input->post('status');
            // print "<pre>"; print_r($status); die();
            $old_status = $this->input->post('old_status');
            $content_without_break  = $this->input->post('content');
            $content = str_replace("\n","<br>", $content_without_break);
            $principal_nameForLog  = $this->input->post('principal_nameForLog');
            $order_schedule_status_id = $this->input->post('order_schedule_status_id');

            $count = 0;
            $payemntFlag = 0;
            $completeFlag = 0;
            $approveFlag = 0;
            $draftFlag = 0;
            $createlog = 0;
            foreach ($status as $order_schedule_id => $stat) {
                if($status[$order_schedule_id] == 'Payment sent'){
                    $payemntFlag++;
                }else if($status[$order_schedule_id] == 'Completed'){
                    $completeFlag++;
                }else if($status[$order_schedule_id] == 'Create invoice'){
                    $approveFlag++;
                }else if($status[$order_schedule_id] == 'Draft attached'){
                    $draftFlag++;
                }else if($status[$order_schedule_id] == 'Create log'){
                    $createlog++;
                }
            }


            // if($payemntFlag > 0 && $completeFlag > 0 && $approveFlag > 0){
            if($approveFlag > 0 || $payemntFlag > 0){
                $set = 1;
            }
            // if($completeFlag > 0 && ($set == 1 || !empty($attachment))){
            if($completeFlag > 0 && $set == 1){
                // echo "enter"; die();
                foreach($status as $order_schedule_id => $stat){
                    // echo "enter"; die();
                    if($status[$order_schedule_id] == 'Completed'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Completed';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => 'Completed',
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
                        $count++;
                    }   

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }
    
                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }

                }
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                if($this->input->post('ajaxCall')){
                    echo true;exit;
                }else{
                    redirect('/app/orders/billing/?order_id='.$order_id);               
                }
            }else if(!empty($attachment) && ($approveFlag > 0 || $payemntFlag > 0 || $createlog > 0)){
                // echo "createlog"; die();
                $flag = 1;
                if (!empty($attachment)) {
                    $attacmnt_counter = 0;
                    foreach ($attachment['name'] as $order_schedule_id => $atach) {
                        if (!empty($attachment['name'][$order_schedule_id])) {
                            $attacmnt_counter++;
                        }
                    }

                    $stat_counter = 0;
                    foreach ($status as $order_schedule_id => $stat) {
                        if ($status[$order_schedule_id] <> $old_status[$order_schedule_id] && ($status[$order_schedule_id] == 'Draft attached' || $status[$order_schedule_id] == 'Approved' || $status[$order_schedule_id] == 'Create log')) {
                            $stat_counter++;
                        }
                    }

                    
                    if($stat_counter == $attacmnt_counter){
                        $flag = 1;
                    }else{
                        $flag = 0;
                    }
                }

                // if($flag == 0){
                //  $this->session->set_flashdata('message_type', 'danger');
                //  $this->session->set_flashdata('message', 'Oops! Please choose the attachment file for all the selected sessions.');

                //  redirect('/app/orders/billing/?order_id='.$order_id);
                // }


                foreach($status as $order_schedule_id => $stat){

                    if($status[$order_schedule_id] == 'Create log'){

                        if (!empty($attachment['name'][$order_schedule_id])) {

                            $config['upload_path'] = DIR_TEACHER_FILES;
                            $config['max_size'] = '25000';
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
        
                            $this->load->library('upload', $config);
        
                            $attach = array();
        
                            $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                            $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                            $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                            $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                            $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
        
                            $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                            $attach[] = $config['file_name'];
        
                            //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                            $this->upload->initialize($config);
        
                            if ($this->upload->do_upload('attach[]')) {
                                $upload_data =  $this->upload->data();
                                $data['attachment'] = $upload_data['file_name'];
                            } else {
                                //$this->upload->display_errors(); die;
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', $this->upload->display_errors());
        
                                redirect('/app/orders/billing/?order_id='.$order_id);
                            }

                            $data['order_schedule_id'] = $order_schedule_id;
                            $data['new_status'] = 'Log sent - awaiting principal signature';
                            $data['old_status'] = 'Create log';
                            $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                            $data['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data);

                            $data_another['order_schedule_id'] = $order_schedule_id;
                            $data_another['attachment'] = $data['attachment'];
                            // $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
                            $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id];
                            $data_another['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status[$order_schedule_id];
                            $data_another['updated_on'] = date("Y-m-d H:i:s");
                            $data_another['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data_another);

                            // Update Schedule Table
                            $data_schedule = array(
                                // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                            $count++;
                        }
                    }

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }
    
                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }

                }
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                if($this->input->post('ajaxCall')){
                    echo true;exit;
                }else{
                    redirect('/app/orders/billing/?order_id='.$order_id);               
                }
                
            }
            // else if(){

            // }
            else{

                // echo "else"; die();
            

            // $flag = 1;
            // if (!empty($attachment)) {
            //  $attacmnt_counter = 0;
            //  foreach ($attachment['name'] as $order_schedule_id => $atach) {
            //      if (!empty($attachment['name'][$order_schedule_id])) {
            //          $attacmnt_counter++;
            //      }
            //  }

            //  $stat_counter = 0;
            //  foreach ($status as $order_schedule_id => $stat) {
            //      if ($status[$order_schedule_id] <> $old_status[$order_schedule_id] && ($status[$order_schedule_id] == 'Draft attached' || $status[$order_schedule_id] == 'Approved' || $status[$order_schedule_id] == 'Create log')) {
            //          $stat_counter++;
            //      }
            //  }

                
            //  if($stat_counter == $attacmnt_counter){
            //      $flag = 1;
            //  }else{
            //      $flag = 0;
            //  }
            // }

            // if($flag == 0){
            //  $this->session->set_flashdata('message_type', 'danger');
            //  $this->session->set_flashdata('message', 'Oops! Please choose the attachment file for all the selected sessions.');

            //  redirect('/app/orders/billing/?order_id='.$order_id);
            // }
                        
            $count = 0;
            foreach ($status as $order_schedule_id => $stat) {
                $data = array();

                // If status not same, update the log
                if ($status[$order_schedule_id] <> $old_status[$order_schedule_id]) {

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }

                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;

                    }

                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/orders/billing/?order_id='.$order_id);
                        }

                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;

                    }

                    
                    if($status[$order_schedule_id] == 'Create invoice'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Create invoice';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    // if($status[$order_schedule_id] == 'Confirm hours'){
                    //     $data['order_schedule_id'] = $order_schedule_id;
                    //     $data['updated_by'] = $this->session->userdata('id');
                    //     $data['new_status'] = 'Confirm hours';
                    //     $data['old_status'] = $old_status[$order_schedule_id];
                    //     $data['updated_on'] = date("Y-m-d H:i:s");
                    //     $this->App_model->insert('order_schedule_status_log', $data);

                    //  // Update Schedule Table
                    //  $data_schedule = array(
                    //      'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                    //      'updated_on' => date("Y-m-d H:i:s"),
                    //      'updated_by' => $this->session->userdata('id'),
                    //      'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                    //  );
                    //  $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                    //  $count++;
                    // }


                    //20-09-2021
                if($status[$order_schedule_id] == 'Confirm hours'){
                    //check if exists in this presenter
                    $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id,$this->session->userdata('id'));
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
                            $data['updated_by'] = $this->session->userdata('id');
                            $data['new_status'] = 'Confirm hours';
                            $data['old_status'] = $old_status[$order_schedule_id];
                            $data['updated_on'] = date("Y-m-d H:i:s");
                            $this->App_model->insert('order_schedule_status_log', $data);
        
                            // Update Schedule Table
                            $data_schedule = array(
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
        
                            $count++;
        
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                            if($this->input->post('ajaxCall')){
                                echo true;exit;
                            }else{
                                redirect('/app/orders/billing/?order_id='.$order_id);               
                            }
                        }else{
                            if($holiday_counter > 0){
                                echo 2; exit;
                            }else{
                                echo 3; exit;
                            }
                            // echo false; exit;
                        }
                    }else{
                        echo 4; exit;
                    }
                    

                    // if(in_array( $day, $daysArray)){
                    //  $data['order_schedule_id'] = $order_schedule_id;
                    //  $data['updated_by'] = $this->session->userdata('id');
                    //  $data['new_status'] = 'Confirm hours';
                    //  $data['old_status'] = $old_status[$order_schedule_id];
                    //  $data['updated_on'] = date("Y-m-d H:i:s");
                    //  $this->App_model->insert('order_schedule_status_log', $data);
    
                    //  // Update Schedule Table
                    //  $data_schedule = array(
                    //      'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                    //      'updated_on' => date("Y-m-d H:i:s"),
                    //      'updated_by' => $this->session->userdata('id'),
                    //      'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                    //  );
                    //  $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                    //  $count++;
    
                    //  $this->session->set_flashdata('message_type', 'success');
                    //  $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                    //  if($this->input->post('ajaxCall')){
                    //      echo true;exit;
                    //  }else{
                    //      redirect('/app/orders/billing/?order_id='.$order_id);               
                    //  }
                    // }else{
                    //  // $this->session->set_flashdata('message_type', 'danger');
                    //  // $this->session->set_flashdata('message', 'Oops! You cannot approve this.');
                    //  echo false; exit;
                    //  // redirect('/app/orders/billing/?order_id='.$order_id);
                    // }
                    
                }



                    if($status[$order_schedule_id] == 'Completed'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Completed';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    if($status[$order_schedule_id] == 'Payment sent'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Payment sent';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    // For log uploaded file by presenter
                    if($status[$order_schedule_id] == 'Create log'){

                        if (!empty($attachment['name'][$order_schedule_id])) {

                            $config['upload_path'] = DIR_TEACHER_FILES;
                            $config['max_size'] = '25000';
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
        
                            $this->load->library('upload', $config);
        
                            $attach = array();
        
                            $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                            $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                            $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                            $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                            $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
        
                            $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                            $attach[] = $config['file_name'];
        
                            //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                            $this->upload->initialize($config);
        
                            if ($this->upload->do_upload('attach[]')) {
                                $upload_data =  $this->upload->data();
                                $data['attachment'] = $upload_data['file_name'];
                            } else {
                                //$this->upload->display_errors(); die;
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', $this->upload->display_errors());
        
                                redirect('/app/orders/billing/?order_id='.$order_id);
                            }

                            $data['order_schedule_id'] = $order_schedule_id;
                            $data['new_status'] = 'Log sent - awaiting principal signature';
                            $data['old_status'] = 'Create log';
                            $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                            $data['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data);

                            $data_another['order_schedule_id'] = $order_schedule_id;
                            $data_another['attachment'] = $data['attachment'];
                            // $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
                            $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id];
                            $data_another['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status[$order_schedule_id];
                            $data_another['updated_on'] = date("Y-m-d H:i:s");
                            $data_another['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data_another);

                            // Update Schedule Table
                            $data_schedule = array(
                                // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                            $count++;
                        }
                    }

                    if ($status[$order_schedule_id] == "Log sent - awaiting principal signature") {
                        
                        $order = $this->App_model->get_order_details($order_id);
                        $schedule = $this->App_model->get_order_schedule_details($order_schedule_id);   
                        
                        // $data['content'] = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                        //     <tr>
                        //         <td><img src="'. base_url("assets/images/logo.png").'"></td>
                        //         <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        //     </tr>
                        //     <tr>
                        //         <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="border-top:solid 1px;">'.$content.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" colspan="2" style="height:35px; border-top:solid 1px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal’s Signature:</strong></td>
                        //         <td align="right" style="height:50px; border-top:solid 1px;"><strong>Total Hours: </strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                           
                        // </table>';

                    //     $data['content'] = '
                    //     <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 13.5px; font-family:Calibri;">
                    //     <tr>
                    //         <td style="float: left; margin-top: 1.1rem;">' . $schedule->worktype_name . ' & Sign- In Log</td>
                    //         <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                    //     </tr>
                    //     <tr>
                    //         <td style="margin-top: 0.8rem; float: left;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                    //         <td align="right" style=""><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 33px;"><strong><u>' . intval($schedule->total_hours) . '</u> </strong></span> </td>
                    //     </tr>
                    //     <tr>
                    //         <td colspan="2" style="" style=" float: left;  top: -8px; position: relative;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style=" float: left; top: -14px; position: relative;"><strong>School:</strong> <strong>' . $order->school_name . '</strong> </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style="float: left; top: -21px; position: relative;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                    //     </tr>
                    // </table>
                    // <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 13.5px; font-family:Calibri; width: 99.5%; margin-left: 7px; margin-top: -1rem;">
                    //     <tr style="height:40px;">
                    //         <td colspan="4" style="text-align: center;">
                    //             <table style="width: 100%; font-size: 13.5px;">
                    //                 <tr>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"> <strong>Date of Service:&emsp;&emsp;&emsp; </strong> <br> <strong>' . date("j/n/Y", strtotime($schedule->start_date)) . '<strong> &emsp;&emsp;&emsp;</td>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"><strong>&emsp;&emsp;Teacher(s) Name and Grade &emsp;&emsp;</strong> <br>&emsp;&emsp; <strong>['. $schedule->teacher .'],[ '. $schedule->grade_name .']<strong> &emsp;&emsp;</td>
                    //                     <td style="text-align: center; font-size: 13.5px;"><strong>&emsp;&emsp;&emsp;Session Time:</strong> <br> &emsp;&emsp;&emsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                    //                 </tr>
                    //             </table>
                    //         </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style="border-top:solid 1px; height: 250px; font-size: 11.5px;">'.$content.'</td>
                    //     </tr>
                    //     <tr style="font-family: Times New Roman;">
                    //         <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> '.$schedule->teacher.'</td>
                    //         <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong></td>
                    //     </tr>
                    //     <tr style="font-family: Times New Roman;">
                    //          <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> '. $principal_nameForLog.'</td>
                    //          <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong></td>
                    //     </tr>
                    // </table>';
                    //////////////////////////////////////////////////////////////
                    $arr = explode(" ",$content);
                    $arr_length = sizeof($arr);
                    $data['content'] = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px;  font-family: Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td align="right" style=" padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                        </tr>
                        <tr>
                            <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                        </tr>
                    </table>

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                        <tr style="height:40px;">
                            <td colspan="4" style="text-align: center;">
                                <table style="width: 100%;" style="font-size: 14.5px;">
                                    <tr>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center; font-size: 14.5px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        // if ($arr_length <= 1060) {
                        //     for ($index = 0; $index < $arr_length; $index++) {
                        //         if (isset($arr[$index]) && strpos($arr[$index], "<br>") !== false) {
                        //             $arr_length += 20;
                        //         }
                        //     }
                        // }

                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 750) {
                            $font_size = '14.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9.5px';
                        }else if($arr_length <= 1800) {
                            $font_size = '8.5px';
                        }else if($arr_length <= 2700) {
                            $font_size = '8px';
                        }else if($arr_length <= 3800) {
                            $font_size = '7px';
                        }else if($arr_length <= 4300) {
                            $font_size = '6px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }

                    
                          $data['content'] .= '
                            <tr>
                                <td align="left" colspan="4" style="border-top: 1px solid;border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                         $data['content'] .= '
                        <tr>
                            <td align="left" style="height:30px; width: 52%; border-right: 1px solid; font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                            <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr>
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid; font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                        // $data['content_for_print'] = '<table width="100%" cellpadding="5" cellspacing="0"  style="border:1px solid black; font-family:\'Ubuntu\', sans-serif;">
                        //     <tr>
                        //         <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 95%;"></td>
                        //         <td align="right" style="color:#813D97 !important; padding-right: 20px; padding-top: 10px; width: 50%;">8696 18th Ave, Brooklyn, NY 11214 <br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px; font-size: 15px;"><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong><br>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Start Time:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'<br></td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="border-top:solid 1px; padding: 20px;">'.$content.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" style="height:50px; padding-left: 20px;"><strong>Principal’s Signature:</strong></td>
                        //         <td colspan="2"><strong style = "margin-left: 12rem;">Total Hours:</strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                            
                        // </table>';

                        $arr = explode(" ",$content);
                        $arr_length = sizeof($arr);
                        $data['content_for_print'] = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px; font-family:Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td><img src="' . base_url("assets/images/logo.png") . '" style="width: 36%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.8rem; float: left;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="position: relative; top: -6px;"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 33px;"><strong><u>' . intval($schedule->total_hours) . '</u></strong> </span> </td>
                        </tr>
                        <tr>
                            <td colspan="2"  style=" float: left;  top: -8px; position: relative;"><strong>PRESENTER:</strong>  <strong>' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; top: -14px; position: relative;"><strong>School:</strong> ' . $order->school_name . ' </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; top: -21px; position: relative;"><strong>Purchase Order:</strong>  <strong>' . $order->order_no . ' </strong> </td>
                        </tr>
                    </table>

                    <div><img src="'. base_url('assets/images/hr_line.png').'" style="position: absolute;margin-left: 13rem;width: 1px;height: 49px;margin-top: -16px;"></div>

                    <div><img src="'. base_url('assets/images/hr_line.png').'" style="position: absolute;margin-left: 30rem;width: 1px;height: 49px;margin-top: -16px;"></div>

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px; font-family:Calibri; width: 99.5%; margin-left: 7px;  margin-top: -1rem;">
                        <tr style="height:40px;">
                            <td colspan="2" style="">
                                <table style="width: 100%;" style="border: 1px solid black; border-collapse: collapse; font-size: 14.5px;">
                                    <tr>
                                        <td style="text-align: center;  font-size: 14.5px;"> <strong>Date of Service:</strong> <br> <strong>' . date("j/n/Y", strtotime($schedule->start_date)) . '</strong></td>
                                        <td style="text-align: center;  font-size: 14.5px;"><strong>Teacher(s) Name and Grade</strong> <br> <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> </td>
                                        <td style="text-align: center; font-size: 14.5px;"><strong>Session Time:</strong> <br> ' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 800) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9px';
                        }else if($arr_length <= 2100) {
                            $font_size = '8px';
                        }else if($arr_length <= 2700) {
                            $font_size = '7px';
                        }else if($arr_length <= 3800) {
                            $font_size = '6px';
                        }else if($arr_length <= 4300) {
                            $font_size = '5px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }
                    
                         $data['content_for_print'] .= '
                            <tr>
                                <td align="left" colspan="2" style="border-top:solid 1px; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                        $data['content_for_print'] .= '
                        <tr style="font-family: Times New Roman;">
                            <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'</strong></td>
                            <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr style="font-family: Times New Roman;">
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                        // $arr = explode(" ",$content);
                        // $arr_length = sizeof($arr);
                        // $logDatanew= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                        // <tr>
                        //      <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 50%!important;"></td>
                        //     <td align="right" style="color:#813D97; !important; padding-right: 20px; padding-top: 10px; width: 50%;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        // </tr>
                        // <tr>
                        //      <td align="center" colspan="2" style="height:40px; "><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px; "><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px; "><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        // </tr>';

                        
                        //     // echo $arr[$index]. " ";
                        //     $index_first_page=470;

                        //     $max_loop_count = $arr_length;
                        //     if($max_loop_count>$index_first_page){
                        //         $max_loop_count = $index_first_page;
                        //     }
                          
                        // $logDatanew .= '<tr>
                        //     <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px; ">';
                        //     for ($index = 0; $index <= $max_loop_count; $index++) {
                        //         // if (strpos($arr[$index], "<br>") != false && $max_loop_count>=$index_first_page) {
                        //         if($index <= sizeof($arr)){
                        //             if (strpos($arr[$index], "<br>") != false) {
                        //                 $break_pos = (15-($index % 15));
                        //                 if($break_pos>2 && ($index % 15)!=0){
                        //                     // $break_pos = 15-($index % 15);
                        //                     $max_loop_count = ($max_loop_count-$break_pos);
                        //                 }
                        //             }
                                
                        //                 $logDatanew .= $arr[$index]." ";
                        //         }
                        //     }
                        //     $logDatanew .='</td>
                        // </tr>
                        // ';   
                        
                        // $index_first_page=$max_loop_count; 
                        // // ...........................................
                        // $index_rest_pages = 800;

                        //     $arr_length_rest_page = ($arr_length-$index_first_page);
    
                        //     $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                        //     // $arr_loop_count = ($arr_length_rest_page / $index_rest_pages);
                        //     $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                        //     if($last_loop_data_count>0) {
                        //         $arr_loop_count = $arr_loop_count+1;
                        //     }

                        //     // while($arr_length_2pg >= 0){
                        //     $index_break = 0;
                        //     $index_break_word=0;
                        //     for( $i=0; $i < $arr_loop_count; $i++){
                        //         // if(!empty($arr[$last_index])){

                        //             if($index_break==0){
                        //                 $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                        //             }else{
                        //                 $index_j=$index_max_j;
                        //             }

                        //             // $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                        //             // $index_j = ($index_first_page+($index_rest_pages*$i))-$index_break;
                        //             $index_max_j = 0;
                        //             if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                        //                 $index_max_j = $index_j+$last_loop_data_count;
                        //             }else{
                        //                 $index_max_j = $index_j+$index_rest_pages;
                        //             }

                                    
                        //             $logDatanew .= '<tr>
                        //             <td  align="left" colspan="2" style="padding-left: 2px;">';
                        //             for ($j= $index_j; $j < $index_max_j; $j++) {
                        //                 // if (strpos($arr[$j], "<br>") != false) {
                        //                 if(($index_max_j - $index_j)<$index_rest_pages){
                        //                     $index_max_j = $index_max_j+$index_break_word;
                        //                 }
                        //                 if($j <= sizeof($arr)){
                        //                     if(isset($arr[$j])){
                        //                         if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                        //                             $break_pos_rest_page = (15-($j%15));
                        //                             if($break_pos_rest_page>2 && ($j%15)!=0){
                        //                                 // $break_pos_rest_page = ($j%15);
                        //                                 $index_max_j = ($index_max_j-$break_pos_rest_page);
                        //                                 // $index_break = ($index_break+$break_pos_rest_page);
                        //                                 $index_break_word = ($index_break_word+$break_pos_rest_page);
                        //                                 $index_break = 1;
                        //                             }
                        //                         }
                        //                         $logDatanew .= $arr[$j]." ";  
                        //                     }
                        //                     // if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                        //                     //     $break_pos_rest_page = (15-($j%15));
                        //                     //     if($break_pos_rest_page>2 && ($j%15)!=0){
                        //                     //         // $break_pos_rest_page = ($j%15);
                        //                     //         $index_max_j = ($index_max_j-$break_pos_rest_page);
                        //                     //         // $index_break = ($index_break+$break_pos_rest_page);
                        //                     //         $index_break_word = ($index_break_word+$break_pos_rest_page);
                        //                     //         $index_break = 1;
                        //                     //     }
                        //                     // }
                                        
                        //                         // $logDatanew .= $arr[$j]." ";  
                        //                 }
                                          
                                        
                        //         }
                        //         $logDatanew .='</td>
                        //         </tr>
                        //         '; 
                        //     }
                         

                        // $logDatanew .= '
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px; "><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                        //     </tr>

                     


                        //     <tr>
                        //     <td align="left" style="height:50px; padding-left: 5px; "><strong>Principal’s Signature:</strong></td>
                        //     <td colspan="2"><strong>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Total Hours:</strong> '. $schedule->total_hours.'</td>
                        //    </tr>
                            
                        
                        
                        
                        // </table>';
                        // font-family:\'Ubuntu\', sans-serif;
                        $logDatanew = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px !important;  font-family: Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem; font-size: 14.5px !important;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td style="float: right; padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                        </tr>
                        <tr>
                            <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                        </tr>
                    </table>

                    

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px !important;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                        <tr style="height:40px;">
                            <td colspan="4" style="text-align: center;">
                                <table style="width: 100%;" style="font-size: 14.5px !important;">
                                    <tr style="height:40px;">
                                        <td style="text-align: center;  border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td style="text-align: center;  border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 750) {
                            $font_size = '14.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9.5px';
                        }else if($arr_length <= 1900) {
                            $font_size = '8.5px';
                        }else if($arr_length <= 2700) {
                            $font_size = '8px';
                        }else if($arr_length <= 3800) {
                            $font_size = '7px';
                        }else if($arr_length <= 4300) {
                            $font_size = '6px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }

                    
                          $logDatanew .= '
                            <tr>
                                <td align="left" colspan="4" style="border-top: 1px solid;  border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                         $logDatanew .= '
                        <tr>
                            <td align="left" style="height:30px; width: 52%; border-right: 1px solid;font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                            <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr>
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                     // .............................................................................
                        $data['log_pdf_admin'] =$logDatanew;

                       


                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['new_status'] = 'Log sent - awaiting principal signature';
                        $data['old_status'] = 'Create log';
                        $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['content_txt'] = $content;
                        $data['principal_name'] = $principal_nameForLog;
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    if ($status[$order_schedule_id] == "Awaiting Review") {
                        $data['content'] = isset($content) ? $content : '';
                        $logData = $this->App_model->get_schedule_logContent($order_schedule_id);

                        // placing signatures in new position 
                        $logs_principal_name = $this->App_model->logs_principal_name($order_schedule_id);
                        $content_txt = $this->App_model->get_schedule_logContent_txt($order_schedule_id);
                        $order = $this->App_model->get_order_details($order_id);
                        $schedule = $this->App_model->get_order_schedule_details($order_schedule_id); 

                        $arr = explode(" ",$content_txt);
                        $arr_length = sizeof($arr);

                        // $logDatanew= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                        // <tr>
                        //     <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 50% !important;"></td>
                        //     <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        // </tr>
                        // <tr>
                        //     <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        // </tr>';

                        // // ...........................................
                        // $index_first_page=470;

                        //     $max_loop_count = $arr_length;
                        //     if($max_loop_count>$index_first_page){
                        //         $max_loop_count = $index_first_page;
                        //     }
                          
                        // $logDatanew .= '<tr>
                        //     <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px; ">';
                        //     for ($index = 0; $index <= $max_loop_count; $index++) {

                        //         // if (strpos($arr[$index], "<br>") != false &&        $max_loop_count>=$index_first_page) {
                        //         if($index <= sizeof($arr)){
                        //             if (strpos($arr[$index], "<br>") != false) {
                        //                 $break_pos = (15-($index % 15));
                        //                 if($break_pos>2 && ($index % 15)!=0){
                        //                     // $break_pos = 15-($index % 15);
                        //                     $max_loop_count = ($max_loop_count-$break_pos);
                        //                 }
                        //             }

                                    
                        //                 $logDatanew .= $arr[$index]." ";
                        //         }
                        //     }
                          
                        //     $logDatanew .='</td>
                        // </tr>
                        // ';    
                        // $index_first_page=$max_loop_count;
                        // $index_rest_pages = 800;

                        //     $arr_length_rest_page = ($arr_length-$index_first_page);
    
                        //     $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                        //     $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                        //     if($last_loop_data_count>0) {
                        //         $arr_loop_count = $arr_loop_count+1;
                        //     }
                        //     $index_break = 0;
                        //     $index_break_word=0;
                        //     for( $i=0; $i < $arr_loop_count; $i++){
                        //         if($index_break==0){
                        //             $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                        //         }else{
                        //             $index_j=$index_max_j;
                        //         }
                        //             // $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                        //             // $index_j = ($index_first_page+($index_rest_pages*$i)) - $index_break;
                        //             $index_max_j = 0;

                        //             if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                        //                 $index_max_j = $index_j+$last_loop_data_count;
                        //             }else{
                        //                 $index_max_j = $index_j+$index_rest_pages;
                        //             }
                        //             $logDatanew .= '<tr>
                        //             <td  align="left" colspan="2" style="padding-left: 2px; ">';
                        //             for ($j= $index_j; $j < $index_max_j; $j++) {
                        //                 if(($index_max_j - $index_j)<$index_rest_pages){
                        //                     $index_max_j = $index_max_j+$index_break_word;
                        //                 }
                        //                 // if (strpos($arr[$j], "<br>") != false) {
                        //                 if($j <= sizeof($arr)){
                        //                     if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                        //                         $break_pos_rest_page = (15-($j%15));
                        //                         if($break_pos_rest_page>2 && ($j%15)!=0){
                        //                             // $break_pos_rest_page = ($j%15);
                        //                             $index_max_j = ($index_max_j-$break_pos_rest_page);
                        //                             // $index_break = ($index_break+$break_pos_rest_page);
                        //                             $index_break_word = ($index_break_word+$break_pos_rest_page);
                        //                             $index_break = 1;
                        //                         }
                        //                     }
                                            
                        //                         $logDatanew .= $arr[$j]." ";   
                        //                 } 
                                        
                        //         }
                        //         $logDatanew .='</td>
                        //         </tr>
                        //         '; 
                        //     }

                        //     $logDatanew .= '

                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; "><strong>Principal:</strong> '. $logs_principal_name.'</td>
                        //     </tr>

                     


                        //     <tr>
                        //         <td><strong>Principal’s Signature:</strong><img src="'.base_url().$data['content'].'"width="100" height="50" style="margin-top:-15px; margin-bottom:-7px;"></td>
                        //         <td align="right" style="padding-top:22px; width:120px; "><strong style = "">Total Hours: </strong>'.$schedule->total_hours.'</td>
                        //     </tr>
                        

                        
                        // </table>';
                   

                    /////////////////////////////////////////////////////////////////////////////
                  
                    $logDatanew = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px;  font-family: Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td align="right" style=" padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                        </tr>
                        <tr>
                            <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                        </tr>
                    </table>

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                        <tr style="height:40px;">
                            <td colspan="4" style="text-align: center;">
                                <table style="width: 100%;" style="font-size: 14.5px;">
                                    <tr>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center; font-size: 14.5px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 750) {
                            $font_size = '14.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9.5px';
                        }else if($arr_length <= 1900) {
                            $font_size = '8.5px';
                        }else if($arr_length <= 2700) {
                            $font_size = '8px';
                        }else if($arr_length <= 3800) {
                            $font_size = '7px';
                        }else if($arr_length <= 4300) {
                            $font_size = '6px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }

                    
                          $logDatanew .= '
                            <tr>
                                <td align="left" colspan="4" style="border-top: 1px solid; border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content_txt.'</td>
                            </tr>';
        
                         $logDatanew .= '
                        <tr>
                            <td align="left" style="height:30px; border-right: 1px solid; font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                            <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr>
                            <td align="left" style="height:30px; width:50%;  border-right: 1px solid; font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $logs_principal_name.'</strong></td>
                            <td align="left" style="height:30px; width:50%; font-family: timesnewroman;"><strong>Principal’s Signature:</strong> <img src="'.base_url().$data['content'].'"width="100" height="33" style="margin-top:-10px; margin-bottom:-7px;"> </td>
                        </tr>
                    </table>';

                    /////////////////////////////////////////////////////////////////////////////
               
                        $pdfnew= $logDatanew;

                        // end
                        
                        // $pdf = $logData.'<img src="'.FCPATH.$data['content'].'">';

                        $this->load->library('m_pdf');

                        //this the the PDF filename that user will get to download
                        $data['school_pdf'] = DIR_TEACHER_FILES."log_".rand().date('YmdHis').".pdf";       
                                    
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
                        $data['updated_by'] = $this->session->userdata('id');
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'status' => 'Create invoice',
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        //New implementation for updatin content field
                        $data_schedule_oldrow = array( 
                            'content' => $logDatanew,
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' =>$this->session->userdata('id')
                            
                        );
                        // $data_schedule_oldrow['content'] = $logDatanew;

                        $this->App_model->update_for_old_row('order_schedule_status_log', 'order_schedule_id', $order_schedule_id, $data_schedule_oldrow);

                        $count++;

                    }

                    if ($status[$order_schedule_id] == "Invoice created") {
                        
                        // Generate Invoice
                        $presenter_id = $this->input->post('presenter_id');
                        $order = $this->App_model->get_order_details($order_id, $presenter_id);
                        $schedules =$this->App_model->get_order_schedule_details($order_schedule_id);
                        // echo "<pre>";print_r($schedules);exit;
                                
                        // ======== Start Code By Ahmed on 2019-08-28 ======= //
                        $logData = $this->App_model->get_log_pdf_content($order_schedule_id);
                        // ======= End of the code 2019-08-28 ====== // 
                        $invoice = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                            <tr>
                                <td style="height:40px;" colspan="4">
                                <img src="'.base_url().'assets/header_image/'.$order->headerImg.'" height="135" width="100%">
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;" colspan="4"><strong>INVOICE:</strong></td>
                                <td style="height:40px; text-align:right"><strong>BILL TO</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Company Name:</strong> '. $order->company_name.'</td>
                                <td style="text-align:right"><strong>Brienza\'s Academic Advantage, Inc. 8696 18th Avenue Brooklyn, New York 11214</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Presenter:</strong> '. $order->teacher_name.'</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Address:</strong> '. $order->presenter_address.'</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Phone number:</strong> '. $order->presenter_phone.'</td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4"><strong>PO#:</strong> '. $order->order_no.' <strong>School:</strong> '. $order->school_name.'</td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Rate</th>
                                <th>Hours</th>
                                <th>Total</th>
                            </tr>';
                            
                            $g_total = 0;
                            $g_hrs = 0;
                            // foreach ($schedules as $schedule) {
                                $total = ($schedules->total_hours*$order->hourly_rate);
                                $invoice .= '<tr>
                                    <td>'.$schedules->start_date.'-'.$schedules->end_date.'</td>
                                    <td align="right">$'.$order->hourly_rate.'</td>
                                    <td align="right">'.$schedules->total_hours.'</td>
                                    <td align="right">$'.number_format($total,2).'</td>
                                </tr>';
                                $g_hrs += $schedules->total_hours;
                                $g_total += $total;
                            // }
                            
                            $invoice .= '<tr>
                                <td align="left"></td>
                                <td colspan="2" align="right"><strong>Total Hours:</strong> '. $g_hrs.'</td>
                                <td align="right"><strong>Total:</strong>$'. number_format($g_total,2).'</td>
                            </tr>
                            <tr>
                                <td align="right">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">Signature: <img src="'.FCPATH.$content.'"></td>
                                <td align="right" colspan="2">Date: '.date("m/d/Y").'</td>
                            </tr>
                            <tr>
                                <td align="right">&nbsp;</td>
                            </tr>
                        </table>';
                        $invoice .= '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
                        
                        // ======== Start Code By Ahmed on 2019-08-08 ======= //
                        if(isset($logData->attachment) && $logData->attachment != ''){
                            $invoice .= '<img src="'.FCPATH."/assets/teachers/".$logData->attachment.'">';
                        }else{
                            $invoice .=$logData->create_log_content.'<img src="'.FCPATH.$logData->content.'">';
                        }
                        // ======= End od the Code 2019-08-08 ====== //
                        //load mPDF library
                        $this->load->library('m_pdf');

                        //this the the PDF filename that user will get to download
                        $data['attachment'] = DIR_TEACHER_FILES."invoice_".date('YmdHis').".pdf";       
                                    
                        //generate the PDF from the given html
                        $this->m_pdf->pdf->WriteHTML($invoice);
                        
                        //download it.
                        $this->m_pdf->pdf->Output($data['attachment']); 

                        $data['content'] = $content;

                        // // Update Log table
                        // if ($this->App_model->insert('order_schedule_status_log', $data)) {
                        //     $count++;
                        // } 
                        
                    }


                    // $count++;
                     
                }else{

                    $data['updated_on'] = date("Y-m-d H:i:s");
                    $data['updated_by'] = $this->session->userdata('id');
                    
                    // Update Schedule Table
                    $this->App_model->update('order_schedule_status_log', 'id', $order_schedule_status_id[$order_schedule_id], $data);
                }
 
            }
            
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
            if($this->input->post('ajaxCall')){
                echo true;exit;
            }else{
                redirect('/app/orders/billing/?order_id='.$order_id);               
            }
        }
        }
        
        if ($order_id) {
            
            // Get order details
            $data['order'] = $this->App_model->get_order_details($order_id);
            $data['selectConBtn'] = FALSE;
            if($this->session->userdata('role') == 'teacher')
            {
                $presenter_id   = $this->session->userdata('id');

                $schedulable_hr = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
                $scheduled_hr   = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

                $data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");
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
            }else{
                
                // Get the existing schedule
                $data['schedules'] = $this->App_model->get_order_schedule($order_id, NULL, "order_schedules.id");   
                //echo "<pre>";print_r($data['schedules']);die;         
            }
        }
        // print "<pre>"; print_r($data['schedules']); print "</pre>";die();
        $data['previewButton'] = FALSE;
        if($this->session->userdata('role') == "teacher"){
            $pid = $this->session->userdata('id');
        }else{
            $pid='';
        }
        $scheduled_ids = $this->App_model->get_schedule_ids($order_id, $pid);
        foreach ($scheduled_ids  as $row) {
            $res = $this->App_model->checkCreateLog($row->id);
            if($res){
                $data['previewButton'] = TRUE;
            }else{
                $data['previewButton'] = FALSE;
                break;
            }
        }
        //echo $data['previewButton'];die;
        $data['presentersForAdmin'] = $this->App_model->get_presenters_for_admin();
        $data['page'] = 'order';
        $data['page_title'] = SITE_NAME.' :: Order Management &raquo; Billing';
        $data['approvedStatus'] = $this->App_model->getApprovedStatus($order_id, $pid);
        // echo '<pre>'; print_r($data); die(); 
        $data['main_content'] = 'orders/billing';
        $this->load->view(TEMPLATE_PATH, $data);
    }

	
	
	function save_sign() {
		
		$result = array();
		$imagedata = base64_decode($_POST['img_data']);
		$filename = md5(date("dmYhisA"));
		//Location to where you want to created sign image
		$file_name = DIR_SIGN.$filename.'.png';
		file_put_contents($file_name,$imagedata);
		$result['status'] = 1;
		$result['file_name'] = $file_name;
		//echo json_encode($result);
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
		return;
	}
	
	function display_log($schedule_id) {
		// $schedule = $this->App_model->get_order_schedule_details($schedule_id);

		// // echo "<pre>";print_r($schedule);exit;
		
		// // if ($schedule->content) {
		// // 	echo $schedule->content;
		// // }

		// if ($schedule->log_signature) {
		// 	$dir1 = substr($schedule->log_signature, 0, 6);
		// 	$dir2 = substr($schedule->log_signature, 7, 9);

		// 	if($dir1=='assets' && $dir2=='doc_signs'){
		// 		echo $schedule->create_log_content;
		// 		echo '<img src="https://img247.managed.center/'.str_replace('assets/doc_signs/', '', $schedule->log_signature).'">';
		// 	}else{
		// 		echo $schedule->content;
		// 	}
			
		// }else{
		// 	echo $schedule->content;
		// }

        $schedule_new = $this->App_model->get_order_schedule_content($schedule_id);
        echo $schedule_new;
	}
	
	function display_old_log($order_schedule_id) {
		$schedule = $this->App_model->get_log_content($order_schedule_id);
		
		if ($schedule->content) { 
			$dir1 = substr($schedule->content, 0, 6);
			$dir2 = substr($schedule->content, 7, 9);

			if($dir1=='assets' && $dir2=='doc_signs'){
				echo $schedule->create_log_content;
				echo '<img src="'.base_url($schedule->content).'">';
			}else{
				echo $schedule->content;
			}
			
		}
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
	   if ($date == "")
	   	return "";

	   $newdate = date_create($date);
	   return date_format($newdate,"Y-m-d");
   }

	public function get_assign_school_presenter(){

		$school_id = $this->input->post('school_id');
		$co_id = $this->input->post('co_id');
		
		$this->load->model('../../Admin/models/Admin_model');

		if(isset($co_id) && $co_id > 0){			
			$res = $this->Admin_model->get_coordinator_assign_school_presenter($co_id, $school_id);
			array_multisort(array_column($res, 'first_name'),  SORT_ASC, $res);
		}else{
			$res = $this->Admin_model->get_school_presenter(array('school_id'=>$school_id, 'first_name', 'ASC'));
		}
		echo json_encode($res);
	}

	public function get_assign_school_titles(){
		$school_id = $this->input->post('school_id');

		//$res = $this->App_model->get_school_titles($school_id);
		$res = $this->App_model->get_school_titles_without_inactive($school_id);
		$resArr = array();
		if(!empty($res)){
			foreach ($res as $key => $val) {
				$resArr[] = array('id' => $key, 'title' => $val);
			}
		}
		sort($resArr);
		echo json_encode($resArr);
	}

	public function get_assign_school_coordinator(){
		$school_id = $this->input->post('school_id');

		$this->load->model('../../Admin/models/Admin_model');
		$res = $this->Admin_model->get_coordinator_assign_school($school_id);
		// echo "<pre>";print_r($res);exit;
		echo json_encode($res);
	}

	public function save_cheque_no(){
		$order_schedule_id = $this->input->post('order_schedule_id');
		$cheque_no = $this->input->post('cheque_no');
		$schedule = $this->App_model->get_order_schedule_details($order_schedule_id);
		
		if(!empty($schedule)){
			$this->App_model->update('order_schedules', 'id', $order_schedule_id, array('check_number' => $cheque_no));

            $this->session->set_flashdata('message_type', 'success');
    		$this->session->set_flashdata('message', '<strong>Well done!</strong> Check number has been successfully updated.');
		}else{
			$this->session->set_flashdata('message_type', 'danger');
    		$this->session->set_flashdata('message', '<strong>Opps!</strong> Somthing went wrong please try again.');
		}
		echo true;
	}
	
    public function download($id = NULL, $status = NULL) {

    	if($status == NULL){
	    	// Get Order schedule data
	    	$record = $this->App_model->get_order_schedule_details($id);
	    }else{
	    	// Get Order schedule log data
	    	$record = $this->App_model->get_log_content($id);
	    	//echo "<pre>";print_r($record);die;
	   }

		if (!empty($record)) {
			if((isset($record->new_status) && $record->new_status == 'Invoice created') || (isset($record->status) && $record->status == 'Invoice created')){
				$file = $record->attachment;
			}else{
				$file = DIR_TEACHER_FILES.$record->attachment;
			}

			// check file exists
			if (file_exists($file)) {
				// get file content
				$data = file_get_contents ( $file );
				//force download
   				$this->load->helper('download');
				force_download ( $record->attachment, $data );
			}
		}
	}
	public function multipleConfirmhoursUpdate(){
        $order_id = $this->input->post('order_id');

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);
        $order_schedule_id = $this->input->post('scheduled_id');

        // checking if schedule assignes to this presenter
        $schedule = 0;
        $noSchedule = 0;
        for($i=0;$i<count($order_schedule_id);$i++){
            $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id[$i],$this->session->userdata('id'));
            if(!empty($checkSchedule)){
                $schedule++;
            }else{
                $noSchedule ++;
            }
        }
        if($noSchedule > 0){
            echo 4; exit;
        }else{
            $multipleCounter = 0;
            $finalHolidaySet = 0;
            $finalUnselectedWorkingDay = 0;
            for($i=0;$i<count($order_schedule_id);$i++){
                //check if exists in this presenter
                $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id[$i],$this->session->userdata('id'));
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
            echo 2;
        }else if($finalUnselectedWorkingDay > 0){
            echo 3;
        }else{
            $order_schedule_id = $this->input->post('scheduled_id');
            $data_schedule = array(
            			'status' => 'Confirm hours',
            			'updated_on' => date("Y-m-d H:i:s"),
            			'updated_by' => $this->session->userdata('id')
            		);
            		$this->App_model->multipleConfirmhoursUpdate($order_schedule_id, $data_schedule);
            
                    
            $dataLog['updated_by'] = $this->session->userdata('id');
            $dataLog['new_status'] = 'Confirm hours';
            $dataLog['old_status'] = 'Approved';
            $dataLog['updated_on'] = date("Y-m-d H:i:s");
            $this->App_model->multipleConfirmhoursInsert($order_schedule_id, $dataLog);


            return true;
        }


		// $scheduled_id = $this->input->post('scheduled_id');
		// $data_schedule = array(
		// 			'status' => 'Confirm hours',
		// 			'updated_on' => date("Y-m-d H:i:s"),
		// 			'updated_by' => $this->session->userdata('id')
		// 		);
		// 		$this->App_model->multipleConfirmhoursUpdate($scheduled_id, $data_schedule);
		// return true;
	}
	public function billings(){

    	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
		add_js('assets/js/plugins/colResizable-1.6.min.js');
		$this->load->model('../../Admin/models/Admin_model');
		$this->load->library('pagination');
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
		$presenter='';
		$purchase_order_no='';
		$billing_due_date='';
		// $session='';

        $this->session->set_userdata('presenterFilter', '');
        $this->session->set_userdata('billing_due_dateFilter', '');
        $this->session->set_userdata('purchase_order_noFilter', '');
	
		if($this->session->userdata('billingsSessionFilter')){
			$billings = $this->App_model->getAdminBilling($presenter,$billing_due_date,$purchase_order_no,20,$this->uri->segment(4),$this->session->userdata('billingsSessionFilter'),false);
			// $count= $this->App_model->getAdminBillingcount($presenter,$billing_due_date,$purchase_order_no,$this->session->userdata('billingsSessionFilter'));
            $count= $this->App_model->getAdminBilling($presenter,$billing_due_date,$purchase_order_no,null,null,$this->session->userdata('billingsSessionFilter'),true);
		}else{
			$curr_date = date("Y-m-d h:i:s");
			$session = $this->App_model->get_curr_session_id($curr_date);
			$billings = $this->App_model->getAdminBilling($presenter,$billing_due_date,$purchase_order_no,20,$this->uri->segment(4),$session,false);
			// $count= $this->App_model->getAdminBillingcount($presenter,$billing_due_date,$purchase_order_no,$session);
            $count= $this->App_model->getAdminBilling($presenter,$billing_due_date,$purchase_order_no,null,null,$session,true);
		}
		foreach ($billings as $item) {
			$item->billing_due_date = $this->App_model->getbilling_due_date($item->order_id);
		}

		if($this->session->userdata('billingsSessionFilter')){
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($this->session->userdata('billingsSessionFilter'));
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($this->session->userdata('billingsSessionFilter'));
		}else{
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($session);
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($session);
		}
		$data['s_array'] = $this->App_model->get_sessions();
		// $data['session'] = $session;
		if($this->session->userdata('billingsSessionFilter')){
			$data['session'] = $this->session->userdata('billingsSessionFilter');
		}else{
			$data['session'] = $session;
		}
		// $data['session'] = $_SESSION["sessionIdFilter"];
 
		$data['presenter'] = $presenter;
		$data['purchase_order_no'] = $purchase_order_no;
		$data['billing_due_date'] = $billing_due_date;
		// $data['session'] = $session;
		$data['billings'] = $billings;



		//pagination
		$config = [
			'base_url' => base_url('app/orders/billings'),
			'per_page' => 20,
			'total_rows' => $count,
			'full_tag_open' => '<ul class="pagination">', 
			'full_tag_close' => '</ul>', 
			'num_tag_open' => '<li class="page-item"><span class="page-link">', 
			'num_tag_close' => '</span></li>', 
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
			'cur_tag_close' => '</a></li>', 
			'prev_tag_open' => '<li class="page-item"><span class="page-link">', 
			'prev_tag_close' => '</span></li>', 
			'next_tag_open' => '<li class="page-item"><span class="page-link">', 
			'next_tag_close' => '</span></li>', 
			'last_tag_open' => '<li class="page-item"><span class="page-link">',
			'last_tag_close' => '</span></li>', 
			'first_tag_open' => '<li class="page-item"><span class="page-link">', 
			'first_tag_close' => '</span></li>',
		];

		$this->pagination->initialize($config);


	    $data['page'] = 'billing';
    	$data['page_title'] = SITE_NAME.' :: Manage Billing';

    	$data['main_content'] = 'orders/billings';
    	$this->load->view(TEMPLATE_PATH, $data);
	}

    // public function billings_search_old_08_05_23(){
	// 	add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
	// 	add_js('assets/js/plugins/colResizable-1.6.min.js');
	// 	$this->load->model('../../Admin/models/Admin_model');
	// 	$this->load->library('pagination');
	// 	$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');
	// 	// $presenter = $this->input->post('presenter');
	// 	// $billing_due_date = $this->input->post('billing_due_date');
	// 	// $purchase_order_no = $this->input->post('purchase_order_no');

    //     $checkpresenter = (isset($_POST['presenter'])?$this->input->post('presenter'):'not by post'); 
    //     $checkbilling_due_date = (isset($_POST['billing_due_date'])?$this->input->post('billing_due_date'):'not by post'); 
    //     $checkpurchase_order_no = (isset($_POST['purchase_order_no'])?$this->input->post('purchase_order_no'):'not by post'); 

    //     if($checkpresenter == 'not by post'){
    //         if($this->session->userdata('presenterFilter')){
    //             $presenter = $this->session->userdata('presenterFilter');
    //         }else{
    //             $presenter1 = $this->input->post('presenter');
    //             $this->session->set_userdata('presenterFilter', $presenter1);
    //             $presenter = $this->session->userdata('presenterFilter');
    //         }
    //     }else{
    //         $presenter1 = $checkpresenter;
    //         $this->session->set_userdata('presenterFilter', $presenter1);
    //         $presenter = $this->session->userdata('presenterFilter');
    //     }

    //     if($checkbilling_due_date == 'not by post'){
    //         if($this->session->userdata('billing_due_dateFilter')){
    //             $billing_due_date = $this->session->userdata('billing_due_dateFilter');
    //         }else{
    //             $billing_due_date1 = $this->input->post('billing_due_date');
    //             $this->session->set_userdata('billing_due_dateFilter', $billing_due_date1);
    //             $billing_due_date = $this->session->userdata('billing_due_dateFilter');
    //         }
    //     }else{
    //         $billing_due_date1 = $checkbilling_due_date;
    //         $this->session->set_userdata('billing_due_dateFilter', $billing_due_date1);
    //         $billing_due_date = $this->session->userdata('billing_due_dateFilter');
    //     }

    //     if($checkpurchase_order_no == 'not by post'){
    //         if($this->session->userdata('purchase_order_noFilter')){
    //             $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
    //         }else{
    //             $purchase_order_no1 = $this->input->post('purchase_order_no');
    //             $this->session->set_userdata('purchase_order_noFilter', $purchase_order_no1);
    //             $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
    //         }
    //     }else{
    //         $purchase_order_no1 = $checkpurchase_order_no;
    //         $this->session->set_userdata('purchase_order_noFilter', $purchase_order_no1);
    //         $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
    //     }
		
	// 	//$_SESSION["sessionIdFilter"] = $this->clean_value($this->input->post('hdnSession'));
	// 	// $this->session->set_userdata('billingsSessionFilter', $this->clean_value($this->input->post('hdnSession')));

    //     $checkhdnSession = (isset($_POST['hdnSession'])?$this->input->post('hdnSession'):'not by post'); 
    //     if($checkhdnSession == 'not by post'){
    //         $this->session->set_userdata('billingsSessionFilter', $this->session->userdata('billingsSessionFilter'));
    //     }else{
    //         $this->session->set_userdata('billingsSessionFilter', $this->clean_value($this->input->post('hdnSession')));
    //     }

    //     if($checkpurchase_order_no != 'not by post' || $checkbilling_due_date != 'not by post' || $checkpresenter != 'not by post'){
    //         $offset1 = 0;
    //         $this->session->set_userdata('offsetforsearch', $offset1);
    //         $offset = $this->session->userdata('offsetforsearch');
    //     }else{
    //         // $currentURL = current_url();
    //         // $currentURLarray = explode('billings_search/', $currentURL);
    //         // $offset1 = $currentURLarray[1];
    //         // $this->session->set_userdata('offsetforsearch', $offset1);
    //         // $offset = $this->session->userdata('offsetforsearch');
    //         $currentURL = current_url();
    //         $currentURLarray = explode('billings_search', $currentURL);
    //         $offset1 = $currentURLarray[1];
    //         if($offset1 == ''){
    //             $this->session->set_userdata('offsetforsearch', 0);
    //         }else{
    //             $offset1array = explode('/', $offset1);
    //             $this->session->set_userdata('offsetforsearch', $offset1array[1]);
    //         }
    //         $offset = $this->session->userdata('offsetforsearch');
    //     }
		
	// 	$billings = $this->App_model->getAdminBilling($presenter, $billing_due_date, $purchase_order_no,20,$offset,$this->session->userdata('billingsSessionFilter'));
	// 	$count= $this->App_model->getAdminBillingcount($presenter,$billing_due_date,$purchase_order_no,$this->session->userdata('billingsSessionFilter'));
	// 	foreach ($billings as $item) {
	// 	$item->billing_due_date = $this->App_model->getbilling_due_date($item->order_id);
		
	// 	}
		
		
	// 	if($this->session->userdata('billingsSessionFilter')){
	// 	$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($this->session->userdata('billingsSessionFilter'));
	// 	// print_r($data['totHoursAssgnd']); die();
	// 	$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($this->session->userdata('billingsSessionFilter'));
	// 	// print_r($data['totHoursSchedule']); die();
	// 	}else{
    //         $curr_date = date("Y-m-d h:i:s");
	// 		$session = $this->App_model->get_curr_session_id($curr_date);
	// 	$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($session);
	// 	// print_r($data['totHoursAssgnd']); die();
	// 	$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($session);
	// 	// print_r($data['totHoursSchedule']); die();
	// 	}
		
	// 	// $data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($session);
	// 	// // print_r($data['totHoursAssgnd']); die();
	// 	// $data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($session);
	// 	// // print_r($data['totHoursSchedule']); die();
	// 	$data['s_array'] = $this->App_model->get_sessions();
	// 	// $data['session'] = $session;
	// 	if($this->session->userdata('billingsSessionFilter')){
	// 	$data['session'] = $this->session->userdata('billingsSessionFilter');
	// 	}else{
	// 	$data['session'] = $session;
	// 	}
	// 	// $data['session'] = $_SESSION["sessionIdFilter"];
		 
	// 	$data['presenter'] = $presenter;
	// 	$data['purchase_order_no'] = $purchase_order_no;
	// 	$data['billing_due_date'] = $billing_due_date;
	// 	// $data['session'] = $session;
	// 	$data['billings'] = $billings;
		
		
		
	// 	//pagination
	// 	$config = [
	// 		// 'base_url' => base_url('app/orders/billings'),
    //         'base_url' => base_url('app/orders/billings_search'),
	// 		'per_page' => 20,
	// 		'total_rows' => $count,
	// 		'full_tag_open' => '<ul class="pagination">',
	// 		'full_tag_close' => '</ul>',
	// 		'num_tag_open' => '<li class="page-item"><span class="page-link">',
	// 		'num_tag_close' => '</span></li>',
	// 		'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
	// 		'cur_tag_close' => '</a></li>',
	// 		'prev_tag_open' => '<li class="page-item"><span class="page-link">',
	// 		'prev_tag_close' => '</span></li>',
	// 		'next_tag_open' => '<li class="page-item"><span class="page-link">',
	// 		'next_tag_close' => '</span></li>',
	// 		'last_tag_open' => '<li class="page-item"><span class="page-link">',
	// 		'last_tag_close' => '</span></li>',
	// 		'first_tag_open' => '<li class="page-item"><span class="page-link">',
	// 		'first_tag_close' => '</span></li>',
	// 	];
		
	// 	$this->pagination->initialize($config);
		
		
	// 	$data['page'] = 'billing';
	// 	$data['page_title'] = SITE_NAME.' :: Manage Billing';
	
	// 	$data['main_content'] = 'orders/billings';
	// 	// echo '<pre>';
	// 	// print_r($data);
	// 	// die();
	// 	$this->load->view(TEMPLATE_PATH, $data);
	// }

    public function billings_search(){
        header("Cache-Control: max-age=3600, must-revalidate");
		add_js('assets/modules/'.$this->router->fetch_module().'/js/'.$this->router->fetch_module().'.js');
		add_js('assets/js/plugins/colResizable-1.6.min.js');
		$this->load->model('../../Admin/models/Admin_model');
		$this->load->library('pagination');
		$data['presenters'] = $this->Admin_model->get_users_list(array('deleted'=>0, 'status'=>'active', 'role_token'=>'teacher'), 'first_name', 'ASC');

        $checkpresenter = (isset($_POST['presenter'])?$this->input->post('presenter'):'not by post'); 
        $checkbilling_due_date = (isset($_POST['billing_due_date'])?$this->input->post('billing_due_date'):'not by post'); 
        $checkpurchase_order_no = (isset($_POST['purchase_order_no'])?$this->input->post('purchase_order_no'):'not by post'); 

        if($checkpresenter == 'not by post'){
            if($this->session->userdata('presenterFilter')){
                $presenter = $this->session->userdata('presenterFilter');
            }else{
                $presenter1 = $this->input->post('presenter');
                $this->session->set_userdata('presenterFilter', $presenter1);
                $presenter = $this->session->userdata('presenterFilter');
            }
        }else{
            $presenter1 = $checkpresenter;
            $this->session->set_userdata('presenterFilter', $presenter1);
            $presenter = $this->session->userdata('presenterFilter');
        }

        if($checkbilling_due_date == 'not by post'){
            if($this->session->userdata('billing_due_dateFilter')){
                $billing_due_date = $this->session->userdata('billing_due_dateFilter');
            }else{
                $billing_due_date1 = $this->input->post('billing_due_date');
                $this->session->set_userdata('billing_due_dateFilter', $billing_due_date1);
                $billing_due_date = $this->session->userdata('billing_due_dateFilter');
            }
        }else{
            $billing_due_date1 = $checkbilling_due_date;
            $this->session->set_userdata('billing_due_dateFilter', $billing_due_date1);
            $billing_due_date = $this->session->userdata('billing_due_dateFilter');
        }

        if($checkpurchase_order_no == 'not by post'){
            if($this->session->userdata('purchase_order_noFilter')){
                $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
            }else{
                $purchase_order_no1 = $this->input->post('purchase_order_no');
                $this->session->set_userdata('purchase_order_noFilter', $purchase_order_no1);
                $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
            }
        }else{
            $purchase_order_no1 = $checkpurchase_order_no;
            $this->session->set_userdata('purchase_order_noFilter', $purchase_order_no1);
            $purchase_order_no = $this->session->userdata('purchase_order_noFilter');
        }

        $checkhdnSession = (isset($_POST['hdnSession'])?$this->input->post('hdnSession'):'not by post'); 
        if($checkhdnSession == 'not by post'){
            if($this->session->userdata('billingsSessionFilter_search')){
                $this->session->set_userdata('billingsSessionFilter_search', $this->session->userdata('billingsSessionFilter_search'));
                $hdnSession = $this->session->userdata('billingsSessionFilter_search');
            }else{
                $hdnSession1 = $this->input->post('hdnSession');
                $this->session->set_userdata('billingsSessionFilter_search', $hdnSession1);
                $hdnSession = $this->session->userdata('billingsSessionFilter_search');
            }
        }else{
            $hdnSession1 = $checkhdnSession;
            $this->session->set_userdata('billingsSessionFilter_search', $hdnSession1);
            $hdnSession = $this->session->userdata('billingsSessionFilter_search');
        }
       

        if($checkpurchase_order_no != 'not by post' || $checkbilling_due_date != 'not by post' || $checkpresenter != 'not by post'){
            $offset1 = 0;
            $this->session->set_userdata('offsetforsearch', $offset1);
            $offset = $this->session->userdata('offsetforsearch');
        }else{
            $currentURL = current_url();
            $currentURLarray = explode('billings_search', $currentURL);
            // print_r($currentURLarray);
            $offset1 = $currentURLarray[1];
            if($offset1 == ''){
                $this->session->set_userdata('offsetforsearch', 0);
            }else{
                $offset1array = explode('/', $offset1);
                $this->session->set_userdata('offsetforsearch', $offset1array[1]);
            }
            // $this->session->set_userdata('offsetforsearch', $offset1);
            $offset = $this->session->userdata('offsetforsearch');
        }
        // $offset = 0;
		
		$billings = $this->App_model->getAdminBilling($presenter, $billing_due_date, $purchase_order_no,20,$offset,$hdnSession);
		// $count= $this->App_model->getAdminBillingcount($presenter,$billing_due_date,$purchase_order_no,$hdnSession);
        $count= $this->App_model->getAdminBilling($presenter, $billing_due_date, $purchase_order_no,null,null,$hdnSession,true);
		foreach ($billings as $item) {
		    $item->billing_due_date = $this->App_model->getbilling_due_date($item->order_id);
		
		}
		
		
		if($hdnSession){
            $data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($hdnSession);
            // print_r($data['totHoursAssgnd']); die();
            $data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($hdnSession);
            // print_r($data['totHoursSchedule']); die();
		}else{
            $curr_date = date("Y-m-d h:i:s");
			$session = $this->App_model->get_curr_session_id($curr_date);
            $data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($session);
            // print_r($data['totHoursAssgnd']); die();
            $data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($session);
            // print_r($data['totHoursSchedule']); die();
		}
		
		$data['s_array'] = $this->App_model->get_sessions();
		// $data['session'] = $session;
		if($hdnSession){
		    $data['session'] = $hdnSession;
		}else{
		    $data['session'] = $session;
		}
		// $data['session'] = $_SESSION["sessionIdFilter"];
		 
		$data['presenter'] = $presenter;
		$data['purchase_order_no'] = $purchase_order_no;
		$data['billing_due_date'] = $billing_due_date;
		// $data['session'] = $session;
		$data['billings'] = $billings;
		
		
		
		//pagination
		$config = [
			'base_url' => base_url('app/orders/billings_search'),
			'per_page' => 20,
			'total_rows' => $count,
			'full_tag_open' => '<ul class="pagination">',
			'full_tag_close' => '</ul>',
			'num_tag_open' => '<li class="page-item"><span class="page-link">',
			'num_tag_close' => '</span></li>',
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
			'cur_tag_close' => '</a></li>',
			'prev_tag_open' => '<li class="page-item"><span class="page-link">',
			'prev_tag_close' => '</span></li>',
			'next_tag_open' => '<li class="page-item"><span class="page-link">',
			'next_tag_close' => '</span></li>',
			'last_tag_open' => '<li class="page-item"><span class="page-link">',
			'last_tag_close' => '</span></li>',
			'first_tag_open' => '<li class="page-item"><span class="page-link">',
			'first_tag_close' => '</span></li>',
		];
		
		$this->pagination->initialize($config);
		
		
		$data['page'] = 'billing';
		$data['page_title'] = SITE_NAME.' :: Manage Billing';
	
		$data['main_content'] = 'orders/billings';
		// echo '<pre>';
		// print_r($data);
		// die();
		$this->load->view(TEMPLATE_PATH, $data);
	}

	public function preview_invoice() {
		
		$order_id = $this->input->get('order_id');
		
		if ($order_id) {
			
			// Get order details
			$data['order'] = $this->App_model->get_order_details($order_id);
			//print_r($data['order']);die;
			
			if($this->session->userdata('role') == 'teacher')
			{
				$presenter_id 	= $this->session->userdata('id');

				$schedulable_hr	= $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
				$scheduled_hr	= $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

				$data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");

				if($schedulable_hr)
					$data['schedulable_hr']	= $schedulable_hr;
				else
					$data['schedulable_hr']	= 0;

				if($scheduled_hr)			
					$data['scheduled_hr']	= $scheduled_hr;
				else
					$data['scheduled_hr']	= 0;

				$remaining_schedule_hrs 		= $data['schedulable_hr'] - $data['scheduled_hr'];
				$data['remaining_schedule_hrs'] = $remaining_schedule_hrs;				
			}else{
				
				// Get the existing schedule
				$data['schedules'] = $this->App_model->get_order_schedule($order_id, NULL, "order_schedules.id");	
				//echo "<pre>";print_r($data['schedules']);die;			
			}
		}
		// print "<pre>"; print_r($data); print "</pre>";exit;
		$data['isBilling'] = $this->App_model->get_billing_order_count($order_id, $presenter_id);
		$data['page'] = 'order';
    	$data['page_title'] = SITE_NAME.' :: Order Management &raquo; Billing';
    	$data['main_content'] = 'orders/preview_invoice';
    	$this->load->view(TEMPLATE_PATH, $data);
	}
	public function save_billing(){
		$data=array();
		$data['order_id'] = $this->input->post('order_id');
		$data['total_amount'] = $this->input->post('total_amount');
		$content = $this->input->post('content');
		$data['presenter_id'] 	= $this->session->userdata('id');
		$data['presenter_invoice'] = $this->App_model->presenter_invoice_number($this->session->userdata('id'));
		$order = $this->App_model->get_order_details($data['order_id'], $this->session->userdata('id'));
		$schedules = $this->App_model->get_order_schedule($data['order_id'], $data['presenter_id'], "order_schedules.id");
		$invoice ='<table width="100%">
					<tr>
						<td colspan="6" style="text-align: right">BAA INVOICE #:'.$data['presenter_invoice'].'</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: right"><img src="'.base_url().'assets/header_image/'.$order->headerImg.'" height="135" width="100%"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Independent Contractor Invoice</b></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Name:</b><span style="color:blue;">'. $order->teacher_name.'</span></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Address:</b><span style="color:blue;">'. $order->presenter_address.'</span></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Phone Number:</b><span style="color:blue;">'. $order->presenter_phone.'</span></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Date of Submission:</b><span style="color:blue;">'. date("m-d-Y").'</span></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6">
							<table class="table table-responsive table-hover sub-order" width="100%">
						    	<thead>
						    		<tr style="border:2px solid #763199;background-color:#763199;color:#fff;">
										<th style="color:#fff;">Dates of Service</th>
						          		<th style="color:#fff;">Total Hours</th>
						          		<th style="color:#fff;">Rate Per Hour</th>
										<th style="color:#fff;">Amount Due</th>
						          	</tr>
						        </thead>
						        <tbody>';
						        if(count($schedules)>0){
									$sum = 0;
						        	foreach($schedules as $row) {
						        		$sum+=$row->hourly_rate*$row->total_hours;
										$invoice.='<tr style="background-color: #e9e9e9">
							        		<td style="border:2px solid #763199;">'.date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).' to '.time_display($row->end_date, true).' with '.$row->teacher.', Grade -'.$row->grade_name.', Topic -'.$row->topic_name.'</td>
							        		<td style="border:2px solid #763199;background-color: #fff;">'.round($row->total_hours).'</td>
							        		<td style="border:2px solid #763199;background-color: #fff;""><span style="background-color: #fff;padding: 10px 20px;">$'.$row->hourly_rate.'</span></td>
							        		<td style="border:2px solid #763199;background-color: #fff;""><span style="background-color: #fff;padding: 10px 20px;">$'.$row->hourly_rate*$row->total_hours.'</span></td>
							        		
							        	</tr>';
						        	}
						        }
						        	
						        $invoice.='<tr>
						        		<td colspan="3" style="text-align: right;color:#763199;">Total:</td>
						        		<td style="border:2px solid #763199;">$'.$sum.'</td>
						        		<td></td>
						        	</tr>
						        </tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: left"><b>Independent Contractor’s Signature</b><img src="'.FCPATH.$content.'"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6" style="text-align: center"><b><h1>Thank you for your business!</h1></b></td>
					</tr>
				</table>';
		$this->load->library('m_pdf');
		//this the the PDF filename that user will get to download
		$data['invoice_document'] = DIR_TEACHER_FILES."invoice_".date('YmdHis').".pdf";		
					
		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($invoice);
		
		//download it.
		$this->m_pdf->pdf->Output($data['invoice_document']); 

		$data['created_by'] 	= $this->session->userdata('id');

		$this->App_model->insert('billing', $data);
	}
	public function save_billing_from_billing(){
        $data=array();
        $data['session_from'] = $this->input->post('session_from');
        $data['session_to'] = $this->input->post('session_end');
        $data['late_flag'] = $this->input->post('late_flag');
		$data['billing_date'] = $this->input->post('hdn_completed_by_DateFormat');
        $schedule_status = $this->input->post('schedule_status');

        // echo $data['late_flag']; die();


        $data['order_id'] = $this->input->post('order_id');
        //$data['total_amount'] = $this->input->post('total_amount');
        $content = $this->input->post('content');
        $data['presenter_id']   = $this->session->userdata('id');
        $data['presenter_invoice'] = $this->App_model->presenter_invoice_number($this->session->userdata('id'));
        // print_r($data); die();
        $order = $this->App_model->get_order_details($data['order_id'], $this->session->userdata('id'));
       
        // $reupload_status = $this->App_model->get_reupload_status($data['order_id'],$data['presenter_id'],$data['session_to'],$data['session_from']);
        $reupload_status = $this->App_model->get_reupload_status($data['order_id'],$data['presenter_id'],$data['session_to'],$data['session_from'],$order->public_school_title_status);
        if(count($reupload_status) > 0){
            $data['re_upload_change'] = $reupload_status[0]->re_upload_change;
        }

        // if($order->public_school_title_status == 'checked'){
        //     $schedules = $this->App_model->get_order_schedule_with_range_not_submitted($data['order_id'], $data['presenter_id'], $data['session_from'], $data['session_to'], "order_schedules.id");
        // }else{
        //     $schedules = $this->App_model->get_order_schedule_with_range($data['order_id'], $data['presenter_id'], $data['session_from'], $data['session_to'], "order_schedules.id");
        // }

        $schedules = $this->App_model->get_order_schedule_with_range_not_submitted($data['order_id'], $data['presenter_id'], $data['session_from'], $data['session_to'], "order_schedules.id",$schedule_status);


        // $schedules = $this->App_model->get_order_schedule_with_range($data['order_id'], $data['presenter_id'], $data['session_from'], $data['session_to'], "order_schedules.id");
        // echo '<pre>'; print_r($schedules); die();
        $schedule_ids = array();
        foreach ($schedules as $row) {
            $schedule_ids[] = $row->id;
        }
        // echo '<pre>'; print_r($schedule_ids); die();
        
        
        if(count($schedules)> 0){
            $total = 0;
            foreach ($schedules as $row) {
                // echo $row->id; die();
                $total+=$row->hourly_rate*$row->total_hours;
            }
        }
        $data['total_amount'] = $total;
        // echo $sum; die();

                // $invoice ='<table width="100%">
                //     <tr>
                //         <td colspan="6" style="text-align: right">BAA INVOICE #:'.$data['presenter_invoice'].'</td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: right"><img src="'.base_url().'assets/header_image/'.$order->headerImg.'" height="135" width="100%"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Independent Contractor Invoice</b></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Name:</b><span style="color:blue;">'. $order->teacher_name.'</span></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Address:</b><span style="color:blue;">'. $order->presenter_address.'</span></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Phone Number:</b><span style="color:blue;">'. $order->presenter_phone.'</span></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Date of Submission:</b><span style="color:blue;">'. date("m-d-Y").'</span></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6">
                //             <table class="table table-responsive table-hover sub-order" width="100%">
                //                 <thead>
                //                     <tr style="border:2px solid #763199;background-color:#763199;color:#fff;">
                //                         <th style="color:#fff;">Dates of Service</th>
                //                         <th style="color:#fff;">Total Hours</th>
                //                         <th style="color:#fff;">Rate Per Hour</th>
                //                         <th style="color:#fff;">Amount Due</th>
                //                     </tr>
                //                 </thead>
                //                 <tbody>';
                //                 if(count($schedules)>0){
                //                     $sum = 0;
                //                     foreach ($schedules as $row) {
                //                         $sum+=$row->hourly_rate*$row->total_hours;
				// 						$invoice.='<tr style="background-color: #e9e9e9">
                //                             <td style="border:2px solid #763199;">'.date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).' to '.time_display($row->end_date, true).' with '.$row->teacher.', Grade -'.$row->grade_name.', Topic -'.$row->topic_name.'</td>
                //                             <td style="border:2px solid #763199;background-color: #fff;">'.round($row->total_hours).'</td>
                //                             <td style="border:2px solid #763199;background-color: #fff;"><span style="background-color: #fff;padding: 10px 20px;">$'.$row->hourly_rate.'</span></td>
                //                             <td style="border:2px solid #763199;background-color: #fff;"><span style="background-color: #fff;padding: 10px 20px;">$'.$row->hourly_rate*$row->total_hours.'</span></td>
                                            
                //                         </tr>';
                //                     }
                //                 }
                                    
                //                 $invoice.='<tr>
                //                         <td colspan="3" style="text-align: right;color:#763199;">Total:</td>
                //                         <td style="border:2px solid #763199;">$'.$sum.'</td>
                //                         <td></td>
                //                     </tr>
                //                 </tbody>
                //             </table>
                //         </td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: left"><b>Independent Contractor’s Signature</b><img src="'.FCPATH.$content.'"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6"></td>
                //     </tr>
                //     <tr>
                //         <td colspan="6" style="text-align: center"><b><h1>Thank you for your business!</h1></b></td>
                //     </tr>
                // </table>';


                    // calculation for address showing 
                    $pre_ad = $order->presenter_address;
                    // $length = strlen($pre_ad);
                    // if()
                    $presenter_address = (strlen($pre_ad) > 90) ? substr($pre_ad,0,90).'...' : $pre_ad;
                    // echo $presenter_address; die;
                    // calculation for multiple page
                    $fixed_counter = 43;
                    $noofschedules = count($schedules);
                    if($noofschedules > 43){
                        $remainder = $noofschedules % 43;
                        if(isset($remainder) && $remainder != ''){
                            $setremainder = 1;
                        }else{
                            $setremainder = 0;
                        }
                        // $page = round($noofschedules / 43);
                        $page = (int)($noofschedules / 43);
                        $nopage = $page + $setremainder;

                        // calculation of foreach counter
                        
                    }else{
                        $nopage= 1;
                    }

                    if($noofschedules <= 43){
                        $invoice_single ='
                        <style>
                            #footer {
                                    position: fixed;
                                    bottom: 5px;
                                    width: 100%;
                                }
                               
                              
                        </style>
                        <div style="padding-top:-40px; margin-bottom:10px;padding-left:4.2px;">
                            <table width="100%" style="font-family: Calibri;">
                                <tr class="basic_desc">
                                    <td style="text-align: left; font-family:Calibri;font-size: 16px;font-weight: bold;">Independent Contractor Invoice</td>
                                    <td colspan="4" style="text-align: right;padding-right:30px;font-family:Calibri;font-size: 14px;">BAA INVOICE #:'.$data['presenter_invoice'].'</td>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: left; font-family: Calibri;font-size: 14px; padding-top:-8px;"><b>Name: </b><span style="font-family: Calibri;font-size: 14px;">'. $order->teacher_name.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: left;font-family: Calibri;font-size: 14px; padding-top:-2px;"><b>Address: </b><span style="font-family:Calibri;font-size: 14px;">'. $presenter_address.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: left;font-family:Calibri;font-size: 14px; padding-top:-2px;"><b>Phone Number: </b><span style="font-family:Calibri;font-size: 14px;">'. $order->presenter_phone.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: left;font-family:Calibri;font-size: 14px; padding-top:-2px;"><b>Date of Submission: </b><span style="font-family:Calibri;font-size: 14px;">'. date("m-d-Y").'</span></td>
                                    </tr>
            
                                    
                                    
                                </tr>
                            </table>
                        </div>
                            <div>
                                <table width="96.2%" style="padding-top:-2px; padding-left:4.2px;font-size: 14px;" >
                                    <tr>
                                        <td colspan="6">
                                            <table class="table table-responsive table-hover sub-order" width="100%" cellpadding="0.4" cellspacing="0.2" style="border:0.2px solid #8149ab;">
                                                <thead>
                                                    <tr style="border:1px solid #8149ab;background-color:#9900cc;color:#fff;">
                                                        <th style="color:#fff;text-align: center;font-family:Calibri;width:214px;border:0.2px solid #8149ab;">Dates of Service</th>
                                                        <th style="color:#fff;text-align: center;width:115px;font-family:Calibri;border:0.2px solid #8149ab;">Type</th>
                                                        <th style="color:#fff;text-align: center;width:55px;font-family:Calibri;border:0.2px solid #8149ab;">Total<br> Hours</th>
                                                        <th style="color:#fff;text-align: center;width:71px;font-family:Calibri;border:0.2px solid #8149ab;">Rate Per<br> Hour</th>
                                                        <th style="color:#fff;text-align: center;width:79px;font-family:Calibri;border:0.2px solid #8149ab;">Amount<br> Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                if(count($schedules)>0){
                                                    $sum = 0;
                                                    $totalHrs = 0;
                                                    foreach(array_slice($schedules, 0, $fixed_counter) as $row ){
                                                        $sum+=$row->hourly_rate*$row->total_hours;
                                                        $totalHrs+=$row->total_hours;
                                                    $invoice_single.='<tr style="background-color: #e0c1ff;">
                                                            <td style="border:0.2px solid #8149ab; background-color: #e0c1ff; font-family:Calibri;width:214px;">&nbsp;&nbsp;'.date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).' to '.time_display($row->end_date, true).'</td>
                                                            <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;font-family: Calibri;width:115px;">'.$row->worktype_name.'</td>
                                                            <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:55px;font-family:Calibri;">'.round($row->total_hours).'</td>
                                                            <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:71px;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate.'</span></td>
                                                            <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center; width:79px;font-family:Calibri;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate*$row->total_hours.'</span></td>
                                                            
                                                        </tr>';
                                                    }
                                                    
                                                }
                                                    
                                                $invoice_single.='<tr>';
                                                
                                                $invoice_single.='</tbody>
                                            </table>
                                                
                                        </td>
                                    </tr>
                                </table>  
                            </div>';
                            if($nopage == 1){
                                $invoice_single.='<div style="display: flex;float:right; margin-right:30px;height: 14px;width: 229px !important;border:2px double #8149ab; padding: 5px 0px; 0px 0px; margin-top:6px;background-color:yellow;">                        
                                        
                                            <table width="100%" style="font-family: Calibri;">
                                                    <tr>
                                                        <td style="font-size:14px;width:70px;background-color:green;">&nbsp;Total: '.$totalHrs.'</td>
                                                        <td style="font-size:14px;width:65px;background-color:red;">&nbsp;</td>
                                                        <td style="font-size:14px;width:90px;background-color:blue;">Total: $'.$sum.'</td>
                                                    </tr>
                                            </table>
                                        
                                    </div>';
                            }
                                
                            $invoice_single.='<div style="margin-top: -10px;" id="footer">
                                <div style="text-align: left;margin-top: -15px;  margin-left:10px;"><tr>
                                    <td colspan="6" style="font-family:Calibri; font-size: 16px;"><b>Independent Contractor’s Signature</b><img src="'.FCPATH.$content.'" width="150" height="40" style="margin-bottom:-5px;position:fixed;"></td>
                                </tr></div>';
                            
            
                        
                                
                                $invoice_single.='<div style="margin-left:272px;padding-top:10px;">
                                    <strong style="font-family:Calibri;font-size: 16px;">Thank you for your business!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>';
                                    if($nopage != 1){
                                    $invoice_single.='<strong class="pull-right;" style="font-family:Calibri;font-size: 16px;">Page 1/'.$nopage.'</strong>';
                                    }
                                
            
            
                                $invoice_single.='</div></div>';
                    }else{
                    
                        $invoice ='
                            <style>
                                #footer {
                                        position: fixed;
                                        bottom: 5px;
                                        width: 100%;
                                    }
                            </style>';
                            if($nopage == 1){
                                $invoice ='<div style="padding-top:-40px; margin-bottom:10px;">';
                            }else{
                                $invoice ='<div style=" margin-bottom:10px;">';
                            }
                            $invoice ='<table width="100%">
                                <tr class="basic_desc">
                                    <td style="text-align: left;font-family:Calibri;font-size: 16px;"><b>Independent Contractor Invoice</b></td>
                                    <td colspan="4" style="text-align: right;padding-right:30px;font-family:Calibri;font-size: 14px;">BAA INVOICE #:'.$data['presenter_invoice'].'</td>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: left;padding-top:-8px;font-family: Calibri;font-size: 14px;"><b>Name: </b><span style="font-family: Calibri;font-size: 14px;">'. $order->teacher_name.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Address: </b><span style="font-family: Calibri;font-size: 14px;">'. $presenter_address.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Phone Number: </b><span style="font-family: Calibri;font-size: 14px;">'. $order->presenter_phone.'</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Date of Submission: </b><span style="font-family: Calibri;font-size: 14px;">'. date("m-d-Y").'</span></td>
                                    </tr>
            
                                    
                                    
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table width="96.2%" style="padding-top:12px;font-family: Calibri;font-size: 14px">
                                <tr>
                                    <td colspan="6">
                                        <table class="table table-responsive table-hover sub-order" width="100%" cellpadding="0.4" cellspacing="0.2" style="border:0.2px solid #8149ab;">
                                            <thead>
                                                <tr style="border:1px solid #8149ab;background-color:#9900cc;color:#fff;">
                                                <th style="color:#fff;text-align: center;font-family:Calibri;width:214px;border:0.2px solid #8149ab;">Dates of Service</th>
                                                <th style="color:#fff;text-align: center;width:115px;font-family:Calibri;border:0.2px solid #8149ab;">Type</th>
                                                <th style="color:#fff;text-align: center;width:55px;font-family:Calibri;border:0.2px solid #8149ab;">Total<br> Hours</th>
                                                <th style="color:#fff;text-align: center;width:71px;font-family:Calibri;border:0.2px solid #8149ab;">Rate Per<br> Hour</th>
                                                <th style="color:#fff;text-align: center;width:79px;font-family:Calibri;border:0.2px solid #8149ab;">Amount<br> Due</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            if(count($schedules)>0){
                                                $sum = 0;
                                                $totalHrs = 0;
                                                foreach(array_slice($schedules, 0, $fixed_counter) as $row ){
                                                    $sum+=$row->hourly_rate*$row->total_hours;
                                                    $totalHrs+=$row->total_hours;
                                                $invoice.='<tr style="background-color: #e0c1ff;">
                                                    <td style="border:0.2px solid #8149ab; background-color: #e0c1ff; font-family:Calibri;width:214px;">&nbsp;&nbsp;'.date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).' to '.time_display($row->end_date, true).'</td>
                                                    <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;font-family: Calibri;width:115px;">'.$row->worktype_name.'</td>
                                                    <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:55px;font-family:Calibri;">'.round($row->total_hours).'</td>
                                                    <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:71px;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate.'</span></td>
                                                    <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center; width:79px;font-family:Calibri;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate*$row->total_hours.'</span></td>
                                                    
                                                </tr>';
                                                }
                                                
                                            }
                                                
                                            $invoice.='<tr>';
                                            
                                            $invoice.='</tbody>
                                        </table>
                                            
                                    </td>
                                </tr>
                            </table>  
                        </div>';
                        if($nopage == 1){
                            $invoice.='<div style="display: flex;float:right; margin-right:30px; height: 14px;width: 229px !important;border:2px double #8149ab; padding: 5px 0px; 0px 0px; margin-top:6px;background-color:yellow;">                        
                                        
                                            <table width="100%" style="font-family: Calibri;">
                                                    <tr>
                                                        <td style="font-size:14px;width:70px;background-color:green;">&nbsp;Total: '.$totalHrs.'</td>
                                                        <td style="font-size:14px;width:65px;background-color:red;">&nbsp;</td>
                                                        <td style="font-size:14px;width:90px;background-color:blue;">Total: $'.$sum.'</td>
                                                    </tr>
                                            </table>
                                       
                                    </div>';
                        }
                            
                        $invoice.='<div style="margin-top: -10px;" id="footer">
                                <div style="text-align: left;margin-top: -15px;  margin-left:10px;"><tr>
                                    <td colspan="6" style="font-family:Calibri; font-size: 16px;"><b>Independent Contractor’s Signature</b><img src="'.FCPATH.$content.'" width="150" height="40" style="margin-bottom:-5px;position:fixed;"></td>
                                </tr></div>';
                        
            
                                $invoice.='<div style="margin-left:272px;padding-top:10px;">
                                    <strong style="font-family:Calibri;font-size: 16px;">Thank you for your business!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>';
                                if($nopage != 1){
                                    $invoice.='<strong class="pull-right;" style="font-family:Calibri;font-size: 16px;">Page 1/'.$nopage.'</strong>';
                                }
                            
            
            
                            $invoice.='</div></div>';
                            
            
                        if($nopage >1){
                        for($i=1;$i<$nopage;$i++){
                            $start_counter = $fixed_counter * $i;
                            $invoice .='
                                <style>
                                    #footer {
                                        position: fixed;
                                        bottom: 5px;
                                        width: 100%;
                                    }
                                </style>';
                                    if($i == 1){
                                        $invoice .='<div style="margin-top:65px; padding-top:10px; margin-bottom:10px;">';
                                    }else if($i == 2){
                                        $invoice .='<div style="margin-top:45px; margin-bottom:10px;">';
                                    }else{
                                        $invoice .='<div style="margin-top:35px; margin-bottom:10px;">';
                                    }
                                    $invoice .='<table width="100%">
                                    <tr class="basic_desc">
                                        <td style="text-align: left;font-family: Calibri;font-size: 16px;"><b>Independent Contractor Invoice</b></td>
                                        <td colspan="4" style="text-align: right;padding-right:30px;font-family: Calibri;font-size: 14px;">BAA INVOICE #:'.$data['presenter_invoice'].'</td>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="6" style="text-align: left;padding-top:-5px;padding-top:-8px;font-family: Calibri;font-size: 14px;"><b>Name: </b><span style="font-family: Calibri;font-size: 14px;">'. $order->teacher_name.'</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Address: </b><span style="font-family: Calibri;font-size: 14px;">'. $presenter_address.'</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Phone Number: </b><span style="font-family: Calibri;font-size: 14px;">'. $order->presenter_phone.'</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: left;font-family: Calibri;font-size: 14px;padding-top:-2px;"><b>Date of Submission: </b><span style="font-family: Calibri;font-size: 14px;">'. date("m-d-Y").'</span></td>
                                        </tr>
            
                                        
                                        
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <table width="96.2%" style="padding-top:2px;font-family: Calibri;font-size: 14px;">
                                    <tr>
                                        <td colspan="6">
                                            <table class="table table-responsive table-hover sub-order" width="100%" cellpadding="0.4" cellspacing="0.2" style="border:0.2px solid #8149ab;">
                                                <thead>
                                                    <tr style="border:1px solid #8149ab;background-color:#9900cc;color:#fff;">
                                                        <th style="color:#fff;text-align: center;font-family:Calibri;width:214px;border:0.2px solid #8149ab;">Dates of Service</th>
                                                        <th style="color:#fff;text-align: center;width:115px;font-family:Calibri;border:0.2px solid #8149ab;">Type</th>
                                                        <th style="color:#fff;text-align: center;width:55px;font-family:Calibri;border:0.2px solid #8149ab;">Total<br> Hours</th>
                                                        <th style="color:#fff;text-align: center;width:71px;font-family:Calibri;border:0.2px solid #8149ab;">Rate Per<br> Hour</th>
                                                        <th style="color:#fff;text-align: center;width:79px;font-family:Calibri;border:0.2px solid #8149ab;">Amount<br> Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                if(count($schedules)>0){
                                                    // $sum = 0;
                                                    // $totalHrs = 0;
                                                    foreach(array_slice($schedules, $start_counter, $fixed_counter) as $row ){
                                                        $sum+=$row->hourly_rate*$row->total_hours;
                                                        $totalHrs+=$row->total_hours;
                                                    $invoice.='<tr style="background-color: #e0c1ff;">
                                                        <td style="border:0.2px solid #8149ab; background-color: #e0c1ff; font-family:Calibri;width:214px;">&nbsp;&nbsp;'.date_display($row->start_date, "m/d/Y").' @ '.time_display($row->start_date, true).' to '.time_display($row->end_date, true).'</td>
                                                        <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;font-family: Calibri;width:115px;">'.$row->worktype_name.'</td>
                                                        <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:55px;font-family:Calibri;">'.round($row->total_hours).'</td>
                                                        <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center;width:71px;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate.'</span></td>
                                                        <td style="border:0.2px solid #8149ab;background-color: #fff;text-align: center; width:79px;font-family:Calibri;"><span style="background-color: #fff;padding: 10px 20px;font-family:Calibri;">$'.$row->hourly_rate*$row->total_hours.'</span></td>
                                                        
                                                    </tr>';
                                                    }
                                                    
                                                }
                                                    
                                                $invoice.='<tr>';
                                            
                                            $invoice.='</tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>';
            
                            if($i == ($nopage-1)){
                                $invoice.='<div style="display: flex;float:right; margin-right:30px; height: 14px;width: 229px !important;border:2px double #8149ab; padding: 5px 0px; 0px 0px; margin-top:6px; background-color:yellow;">                        
                                       
                                            <table width="100%" style="font-family: Calibri;">
                                                    <tr>
                                                        <td style="font-size:14px;width:70px;background-color:green;">&nbsp;Total: '.$totalHrs.'</td>
                                                        <td style="font-size:14px;width:65px;background-color:red;">&nbsp;</td>
                                                        <td style="font-size:14px;width:90px;background-color:blue;">Total: $'.$sum.'</td>
                                                    </tr>
                                            </table>
                                        
                                    </div>';
                            }
            
                            $invoice.='<div style="margin-top: -10px;" id="footer">
                                <div style="text-align: left;margin-top: -15px;  margin-left:10px;"><tr>
                                    <td colspan="6" style="font-family:Calibri; font-size: 16px;"><b>Independent Contractor’s Signature</b><img src="'.FCPATH.$content.'" width="150" height="40" style="margin-bottom:-5px;position:fixed;"></td>
                                </tr></div>';
                            
            
                                $invoice.='<div style="margin-left:272px;padding-top:10px;">
                                    <strong style="font-family:Calibri;font-size: 16px;">Thank you for your business!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>';
                                if($nopage != 1){
                                    $invoice.='<strong class="pull-right;" style="font-family:Calibri;font-size: 16px;">Page '.($i+1).'/'.$nopage.'</strong>';
                                }
            
                            $invoice.='</div></div><br>';
                        }
                        }
                    }



        // echo $invoice; die();    
        $this->load->library('m_pdf');
        //this the the PDF filename that user will get to download
        $data['invoice_document'] = DIR_TEACHER_FILES."invoice_".date('YmdHis').".pdf";     
        $this->m_pdf->pdf->AddPageByArray([
            // 'margin-left' => '10mm',
            // 'margin-right' => '10mm',
            // 'margin-top' => '10mm',
            'margin-bottom' => '8mm',
        ]);
        //generate the PDF from the given html
        // $this->m_pdf->pdf->WriteHTML($invoice);
        if($noofschedules <= 43){
            $this->m_pdf->pdf->WriteHTML($invoice_single);
        }else{
            $this->m_pdf->pdf->WriteHTML($invoice);
        }
        
        //download it.
        $this->m_pdf->pdf->Output($data['invoice_document']); 

        $data['created_by']     = $this->session->userdata('id');

        $data['total_amount'] = $sum;
        // echo '<pre>'; print_r($data); die();
        //get payment date calculation for this billing.
        $currentDate = date("Y-m-d");
		if($data['late_flag'] == 1){
            $pymSchDetails = $this->App_model->get_payementDate($currentDate);
            // echo '<pre>'; print_r($pymSchDetails); die();
            $data['payment_date'] = $pymSchDetails->payment_date;
        }else{
            $pymSchDetails = $this->App_model->get_payementDate_inRange($data['session_from'], $data['session_to']);
            $data['payment_date'] = $pymSchDetails->payment_date;
        }
        // $pymSchDetails = $this->App_model->get_payementDate($currentDate);
        // $data['payment_date'] = $pymSchDetails->payment_date;
        $data['is_old_order'] = '1';
        $data['is_public_title']= $schedule_status;
        $billing_id = $this->App_model->insert('billing', $data);
        foreach($schedule_ids as $s_id){
            $odr_bllng_dtls['billing_id'] = $billing_id;
            $odr_bllng_dtls['order_schedule_id'] = $s_id;
            $this->App_model->insert('order_billing_details', $odr_bllng_dtls);
        }
        $this->App_model->update_status_orderSchedules($schedule_ids,$data['late_flag']);
        // if($order->public_school_title_status == 'checked'){
            $this->App_model->update_invoice_id_public_title($schedule_ids,$billing_id);
        // }
    }

	
    function mergePDFFiles($filenames) {
		$this->load->library('m_pdf');
		$outputfile=DIR_TEACHER_FILES."abc".date('YmdHis').".pdf";
		$this->m_pdf->pdf->SetImportUse();
		$count=count($filenames)-1;
		for ($k=0;$k<count($filenames);$k++) {
		
			$pagecount = $this->m_pdf->pdf->SetSourceFile($filenames[$k]);
		    for ($i=1; $i<=$pagecount; $i++) {
		        $import_page = $this->m_pdf->pdf->ImportPage();
		        $this->m_pdf->pdf->UseTemplate($import_page);

		        
		           
		    }
		if($k<$count)
		 $this->m_pdf->pdf->AddPage("L");
		}
		$this->m_pdf->pdf->Output($outputfile);
		return	$outputfile;
    }
    function billingProcess(){
    	$data=array();
    	$documents = array();
    	$order_id = $this->input->post('order_id');
    	$id = $this->input->post('billing_id');
    	$invoice_document = $this->App_model->get_billing_invoice_documents($id);
    	if(file_exists($invoice_document)){
    		array_push($documents,$invoice_document);
    	}
    	$presenter_id = $this->App_model->get_billing_presenter_id($id);
		$scheduled_ids = $this->App_model->get_schedule_ids_frm_odrdetls_by_billingId($id);
        // print_r($scheduled_ids); die();
        foreach ($scheduled_ids  as $row) {
            $pdf = $this->App_model->get_schedule_ids_pdf($row->order_schedule_id,'Draft attached','Approved');
            if(file_exists(DIR_TEACHER_FILES.$pdf)){
                array_push($documents,DIR_TEACHER_FILES.$pdf);
            }
            
            $pdf1 = $this->App_model->get_schedule_ids_pdf($row->order_schedule_id,'Create log','Log sent - awaiting principal signature');
            if(file_exists(DIR_TEACHER_FILES.$pdf1) && $pdf1){
                array_push($documents,DIR_TEACHER_FILES.$pdf1);
            }else{
                $pdf2 = $this->App_model->get_schedule_logdetails($row->order_schedule_id);
                array_push($documents,$pdf2);
            }
        }
    	// $scheduled_ids = $this->App_model->get_schedule_ids($order_id, $presenter_id);
    	// //print_r($scheduled_ids);
    	// foreach ($scheduled_ids	 as $row) {
    	// 	$pdf = $this->App_model->get_schedule_ids_pdf($row->id,'Draft attached','Approved');
    	// 	if(file_exists(DIR_TEACHER_FILES.$pdf)){
	    // 		array_push($documents,DIR_TEACHER_FILES.$pdf);
	    // 	}
    		
    	// 	$pdf1 = $this->App_model->get_schedule_ids_pdf($row->id,'Create log','Log sent - awaiting principal signature');
    	// 	if(file_exists(DIR_TEACHER_FILES.$pdf1) && $pdf1){
	    // 		array_push($documents,DIR_TEACHER_FILES.$pdf1);
	    // 	}else{
	    // 		$pdf2 = $this->App_model->get_schedule_logdetails($row->id);
	    // 		array_push($documents,$pdf2);
	    // 	}
    	// }
    	//echo '<pre>';
    	//print_r($documents);die;

    	$data['is_read'] = '1';
    	$data['process'] = '1';
    	//$data['download_document']=$this->mergePDFFiles($documents);
    	$data['download_document']=$this->margePdf($documents);
    	//echo '<pre>';
    	//print_r($data);
    	if($this->App_model->update('billing', 'id', $id, $data)){
    		return 1;
    	}else{
    		return 0;
    	}
    }
    public function update_tpd_tag(){
    	$data=array();
    	$data['tpd_tag'] = $this->input->post('tpd_tag');
    	$data['updated_date'] = date("Y-m-d H:i:s");
    	if($this->App_model->update('billing', 'id', $this->input->post('billing_id'), $data)){
    		echo 1;
    	}else{
    		echo 0;
    	}
    }
    function imagetopdf($imagefile){
		// $file= base_url($imagefile);
        $file= $_SERVER['DOCUMENT_ROOT'].$imagefile;
		//$save_file = DIR_TEACHER_FILES.date('YmdHis').".pdf";
		$save_file = DIR_TEACHER_FILES.md5(time().rand(1,100)).".pdf";

		// $pagelayout = array('700', '600'); //  or array($height, $width)

        // getting image size and passing that dimensions in pagelayout 23-06-2023
        // // Get image dimensions
        // $image_info = getimagesize($imagefile);
        // $image_width = $image_info[0];
        // $image_height = $image_info[1];
        // $pagelayout = array($image_width, $image_height);


        // resizing image and then it pass through pagelayout
        // // Load the image
        // $image = imagecreatefromstring(file_get_contents($imagefile));

        // // Get original image dimensions
        // $original_width = imagesx($image);
        // $original_height = imagesy($image);

        // $target_width = 650;
        // $target_height = 700;

        // getting image size and calculating image aspect ratio in pagelayout 23-06-2023
        $image = imagecreatefromstring(file_get_contents($imagefile));

        // Get original image dimensions
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        // $imageWidth = 500;    // Width of the portrait image in pixels
        // $imageHeight = 800;   // Height of the portrait image in pixels

        $desiredWidth = 700;  // Desired width of the layout in pixels
        $desiredHeight = 600; // Desired height of the layout in pixels

        // Calculate the aspect ratio of the image
        $imageAspectRatio = $imageWidth / $imageHeight;

        // Calculate the aspect ratio of the desired layout
        $layoutAspectRatio = $desiredWidth / $desiredHeight;

        // Calculate the maximum dimensions that maintain the image's aspect ratio within the layout
        if ($imageAspectRatio > $layoutAspectRatio) {
            // Image is wider than the desired layout, so adjust the width
            $maxWidth = $desiredWidth;
            $maxHeight = $maxWidth / $imageAspectRatio;
        } else {
            // Image is taller than the desired layout, so adjust the height
            $maxHeight = $desiredHeight;
            $maxWidth = $maxHeight * $imageAspectRatio;
        }
        // Set the maximum dimensions to the page layout array
        $pagelayout = array($maxWidth, $maxHeight);
        // end 23-06-2023

		$pdf = new TCPDF('', 'pt', $pagelayout, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false); // 23-06-2023
        $pdf->SetPrintFooter(false); // 23-06-2023
		$pdf->AddPage();
		$pdf->Image($file);
		//local
		//$pdf->Output($_SERVER['DOCUMENT_ROOT']."brienza/".$save_file,'F');
		//server
		$pdf->Output($_SERVER['DOCUMENT_ROOT'].$save_file,'F');
		//$pdf->Output($save_file,'F');
		return $save_file;
	}
	function wordtopdf($wordfile){
		$objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
		//local
		//$contents=$objReader->load($_SERVER['DOCUMENT_ROOT']."brienza/".$wordfile);
		//server
		$contents=$objReader->load($_SERVER['DOCUMENT_ROOT'].$wordfile);
		$rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

		$renderLibrary="tcpdf";
		$renderLibraryPath=APPPATH.'libraries/' . $renderLibrary;
		if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
			die("Provide Render Library And Path");
		}
		$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
		$save_file= DIR_TEACHER_FILES.md5(time().rand(201,300)).".pdf";
		$objWriter->save($save_file);
		return $save_file;
	}
	function margePdf($files){
		$checkImage =array('jpg','JPG','png','PNG','jpeg','JPEG');
		$checkDoc = array('doc','docx');
		$pdf_files=array();
		foreach($files as $file){
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if($ext){
				if(in_array($ext, $checkImage)){
					$imgPdf=$this->imagetopdf($file);
					array_push($pdf_files, $imgPdf);
				}else if(in_array($ext, $checkDoc)){
					$docPdf=$this->wordtopdf($file);
					array_push($pdf_files, $docPdf);
				}else{
					// array_push($pdf_files, $file);
                    $pdfToPdf=$this->pdftopdf($file);
					array_push($pdf_files, $pdfToPdf);
				}
			}
		}
		//echo '<pre>';
		//print_r($files);
		//print_r($pdf_files);
		//die;
		$pdf = new PDFMerger;

		if($pdf_files){
			foreach($pdf_files as $file){
				$pdf->addPDF( $file, 'all');
			}

			$new_file = md5(time().rand(401,500)) .'.pdf';
			//$new_file = 'abcde.pdf';
			$pdf->merge('file', APPPATH . '../assets/teachers/'.$new_file);

		} else {
			$new_file = '';
		}
		return DIR_TEACHER_FILES.$new_file;
	}

    function pdftopdf($pdffile){
		// $file= base_url($pdffile);
        // $file= base_url('assets/teachers/log_attachment-7207465420230227153901.pdf');
        
        $file= $_SERVER['DOCUMENT_ROOT'].$pdffile;
        // echo $pdffile; echo '#####';
        // echo $file; 
		// $save_file = DIR_TEACHER_FILES.date('YmdHis').".pdf";
        $save_file = DIR_TEACHER_FILES.md5(time().rand(301,400)).".pdf";

        $pdfi = new Fpdi\Tcpdf\Fpdi();
        $pages_count = $pdfi->setSourceFile($file);

        for($i = 1; $i <= $pages_count; $i++)
        {
            $pdfi->SetPrintHeader(false);
            $pdfi->SetPrintFooter(false);
            $pdfi->AddPage(); 
            // $tplIdx = $i.'tpl';
            $tplIdx = $pdfi->importPage($i);
            $pdfi->useTemplate($tplIdx, 0, 0); 
            $pdfi->SetCompression(true);
        }

        // echo '$$$$$';
        // echo $_SERVER['DOCUMENT_ROOT'].$save_file; echo '====';
		//server
		$pdfi->Output($_SERVER['DOCUMENT_ROOT'].$save_file,'F');
		//$pdf->Output($save_file,'F');
        // usleep(90000);
        // sleep(1);
		return $save_file;
	}

	function testmargePdf(){
		$checkImage =array('jpg','JPG','png','PNG','jpeg','JPEG');
		$checkDoc = array('doc','docx');
		$files = array(
    				'assets/teachers/invoice_20201012083656.pdf',
    				'assets/teachers/billing_attachment-158880946120200918141455.jpg',
    				'assets/teachers/log_attachment-64683352020200918143430.pdf',
    				'assets/teachers/billing_attachment-48578907420200918141456.jpg',
    				'assets/teachers/log_attachment-88088323920200918143430.pdf',
    				'assets/teachers/billing_attachment-195883262020200918142034.pdf',
    				'assets/teachers/log_attachment-94230251920200918143431.pdf',
    				'assets/teachers/billing_attachment-190434126820200918145920.pdf',
    				'assets/teachers/log_attachment-108598478020200918150530.pdf',
    				'assets/teachers/billing_attachment-136550330720201016135938.pdf',
    				'assets/teachers/billing_attachment-151255879220181101021135.docx');
		$pdf_files=array();
		foreach($files as $file){
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if($ext){
				if(in_array($ext, $checkImage)){
					$imgPdf=$this->imagetopdftest($file);
					array_push($pdf_files, $imgPdf);
				}else if(in_array($ext, $checkDoc)){
					$docPdf=$this->wordtopdftest($file);
					array_push($pdf_files, $docPdf);
				}else{
					array_push($pdf_files, $file);
				}
			}
		}
		// echo '<pre>';
		// print_r($files);
		// print_r($pdf_files);die;
		
		$pdf = new PDFMerger;

		if($pdf_files){
			foreach($pdf_files as $file){
				$pdf->addPDF( $file, 'all');
			}

			$new_file = md5(time().rand(1,10)) .'.pdf';
			//$new_file = 'abcde.pdf';
			$pdf->merge('file', APPPATH . '../assets/teachers/'.$new_file);

		} else {
			$new_file = '';
		}
		echo DIR_TEACHER_FILES.$new_file;
	}
	function imagetopdftest($imagefile){
		$file= base_url($imagefile);
		$save_file= DIR_TEACHER_FILES.date('YmdHis').".pdf";
		//$save_file = DIR_TEACHER_FILES.date('YmdHis').".pdf";
		$pagelayout = array('700', '600'); //  or array($height, $width)

		$pdf = new TCPDF('', 'pt', $pagelayout, true, 'UTF-8', false);
		$pdf->AddPage();
		$pdf->Image($file);
		$pdf->Output($_SERVER['DOCUMENT_ROOT'].$save_file,'F');
		//$pdf->Output($save_file,'F');
		return $save_file;
	}
	function wordtopdftest($wordfile){
		//$wordfile='assets/teachers/billing_attachment-151255879220181101021135.docx';
		$objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
		$contents=$objReader->load($_SERVER['DOCUMENT_ROOT'].$wordfile);
		//server
		//$contents=$objReader->load(base_url($wordfile));
		$rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

		$renderLibrary="tcpdf";
		
		$renderLibraryPath=APPPATH.'libraries/' . $renderLibrary;
		if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
			die("Provide Render Library And Path");
		}
		$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
		$save_file= DIR_TEACHER_FILES.date('YmdHis').".pdf";
		$objWriter->save($save_file);
		return $save_file;
	}

	public function presenter_billing() {
        
        $order_id = $this->input->get('order_id');

        $school_id = $this->App_model->get_school_id($order_id);
        $holiday_schedule_id = $this->App_model->get_holiday_schedule_id($school_id);
        $daysArray = $this->App_model->get_holiday_schedule_days($holiday_schedule_id);
        //21-09-2021
        $holiday_ids = $this->App_model->get_holidays($holiday_schedule_id);
        
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           
            $attachment = (isset($_FILES['attachment'])?$_FILES['attachment']:"");
         
            $status = $this->input->post('status');
       
            $old_status = $this->input->post('old_status');
            $content_without_break  = $this->input->post('content');
            $content = str_replace("\n","<br>", $content_without_break);
            $principal_nameForLog  = $this->input->post('principal_nameForLog');
            $order_schedule_status_id = $this->input->post('order_schedule_status_id');

            $count = 0;
            $payemntFlag = 0;
            $completeFlag = 0;
            $approveFlag = 0;
            $draftFlag = 0;
            $createlog = 0;
            foreach ($status as $order_schedule_id => $stat) {
                if($status[$order_schedule_id] == 'Payment sent'){
                    $payemntFlag++;
                }else if($status[$order_schedule_id] == 'Completed'){
                    $completeFlag++;
                }else if($status[$order_schedule_id] == 'Create invoice'){
                    $approveFlag++;
                }else if($status[$order_schedule_id] == 'Draft attached'){
                    $draftFlag++;
                }else if($status[$order_schedule_id] == 'Create log'){
                    $createlog++;
                }
            }

            if($approveFlag > 0 || $payemntFlag > 0){
                $set = 1;
            }

            if($completeFlag > 0 && $set == 1){
                // echo "enter"; die();
                foreach($status as $order_schedule_id => $stat){
                    // echo "enter"; die();
                    if($status[$order_schedule_id] == 'Completed'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Completed';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => 'Completed',
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
                        $count++;
                    }   

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            // redirect('/app/orders/billing/?order_id='.$order_id);
                            redirect('/app/presenters/billing');
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }
    
                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/presenters/billing');
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }

                }
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                if($this->input->post('ajaxCall')){
                    echo true;exit;
                }else{
                    // redirect('/app/orders/billing/?order_id='.$order_id);  
                    redirect('/app/presenters/billing');            
                }
            }else if(!empty($attachment) && ($approveFlag > 0 || $payemntFlag > 0 || $createlog > 0)){
                // echo "createlog"; die();
                $flag = 1;
                if (!empty($attachment)) {
                    $attacmnt_counter = 0;
                    foreach ($attachment['name'] as $order_schedule_id => $atach) {
                        if (!empty($attachment['name'][$order_schedule_id])) {
                            $attacmnt_counter++;
                        }
                    }

                    $stat_counter = 0;
                    foreach ($status as $order_schedule_id => $stat) {
                        if ($status[$order_schedule_id] <> $old_status[$order_schedule_id] && ($status[$order_schedule_id] == 'Draft attached' || $status[$order_schedule_id] == 'Approved' || $status[$order_schedule_id] == 'Create log')) {
                            $stat_counter++;
                        }
                    }

                    
                    if($stat_counter == $attacmnt_counter){
                        $flag = 1;
                    }else{
                        $flag = 0;
                    }
                }

                foreach($status as $order_schedule_id => $stat){

                    if($status[$order_schedule_id] == 'Create log'){

                        if (!empty($attachment['name'][$order_schedule_id])) {

                            $config['upload_path'] = DIR_TEACHER_FILES;
                            $config['max_size'] = '25000';
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
        
                            $this->load->library('upload', $config);
        
                            $attach = array();
        
                            $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                            $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                            $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                            $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                            $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
        
                            $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                            $attach[] = $config['file_name'];
        
                            //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                            $this->upload->initialize($config);
        
                            if ($this->upload->do_upload('attach[]')) {
                                $upload_data =  $this->upload->data();
                                $data['attachment'] = $upload_data['file_name'];
                            } else {
                                //$this->upload->display_errors(); die;
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', $this->upload->display_errors());
        
                                // redirect('/app/orders/billing/?order_id='.$order_id);
                                redirect('/app/presenters/billing');
                            }

                            $data['order_schedule_id'] = $order_schedule_id;
                            $data['new_status'] = 'Log sent - awaiting principal signature';
                            $data['old_status'] = 'Create log';
                            $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                            $data['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data);

                            $data_another['order_schedule_id'] = $order_schedule_id;
                            $data_another['attachment'] = $data['attachment'];
                            // $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
                            $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id];
                            $data_another['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status[$order_schedule_id];
                            $data_another['updated_on'] = date("Y-m-d H:i:s");
                            $data_another['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data_another);

                            // Update Schedule Table
                            $data_schedule = array(
                                // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                            $count++;
                        }
                    }

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            // redirect('/app/orders/billing/?order_id='.$order_id);
                            redirect('/app/presenters/billing');
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }
    
                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            // redirect('/app/orders/billing/?order_id='.$order_id);
                            redirect('/app/presenters/billing');
                        }
    
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);
    
                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
    
                        $count++;
    
                    }

                }
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                if($this->input->post('ajaxCall')){
                    echo true;exit;
                }else{
                    // redirect('/app/orders/billing/?order_id='.$order_id);  
                    redirect('/app/presenters/billing');            
                }
                
            } else {

            $count = 0;
            foreach ($status as $order_schedule_id => $stat) {
                $data = array();

                // If status not same, update the log
                if ($status[$order_schedule_id] <> $old_status[$order_schedule_id]) {

                    if($status[$order_schedule_id] == 'Draft attached' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            // redirect('/app/orders/billing/?order_id='.$order_id);
                            redirect('/app/presenters/billing');
                        }

                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Draft attached';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;

                    }

                    if($status[$order_schedule_id] == 'Approved' && !empty($attachment['name'][$order_schedule_id])){
                        $config['upload_path'] = DIR_TEACHER_FILES;
                        $config['max_size'] = '25000';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                        $config['overwrite'] = FALSE;
                        $config['remove_spaces'] = TRUE;
    
                        $this->load->library('upload', $config);
    
                        $attach = array();
    
                        $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                        $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                        $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                        $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                        $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
    
                        $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                        $attach[] = $config['file_name'];
    
                        //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                        $this->upload->initialize($config);
    
                        if ($this->upload->do_upload('attach[]')) {
                            $upload_data =  $this->upload->data();
                            $data['attachment'] = $upload_data['file_name'];
                        } else {
                            //$this->upload->display_errors(); die;
                            $this->session->set_flashdata('message_type', 'danger');
                            $this->session->set_flashdata('message', $this->upload->display_errors());
    
                            redirect('/app/presenters/billing');
                        }

                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Approved';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;

                    }

                    
                    if($status[$order_schedule_id] == 'Create invoice'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Create invoice';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    //20-09-2021
                if($status[$order_schedule_id] == 'Confirm hours'){
                    //check if exists in this presenter
                    $checkSchedule = $this->App_model->get_schedule_details_specific_by_presenter($order_schedule_id,$this->session->userdata('id'));
                    if(!empty($checkSchedule)){
                        $dayName = $this->App_model->get_day_name_of_schedule($order_schedule_id);
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
                        // echo $holiday_counter; die();
                        if(in_array( $day, $daysArray) && $holiday_counter == 0){
                            $data['order_schedule_id'] = $order_schedule_id;
                            $data['updated_by'] = $this->session->userdata('id');
                            $data['new_status'] = 'Confirm hours';
                            $data['old_status'] = $old_status[$order_schedule_id];
                            $data['updated_on'] = date("Y-m-d H:i:s");
                            $this->App_model->insert('order_schedule_status_log', $data);
        
                            // Update Schedule Table
                            $data_schedule = array(
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
        
                            $count++;
        
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
                            if($this->input->post('ajaxCall')){
                                echo true;exit;
                            }else{
                                // redirect('/app/orders/billing/?order_id='.$order_id);  
                                redirect('/app/presenters/billing');            
                            }
                        }else{
                            if($holiday_counter > 0){
                                echo 2; exit;
                            }else{
                                echo 3; exit;
                            }
                            // echo false; exit;
                        }
                    }else{
                        echo 4; exit;
                    }
             
                    
                    
                }



                    if($status[$order_schedule_id] == 'Completed'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Completed';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    if($status[$order_schedule_id] == 'Payment sent'){
                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['new_status'] = 'Payment sent';
                        $data['old_status'] = $old_status[$order_schedule_id];
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    // For log uploaded file by presenter
                    if($status[$order_schedule_id] == 'Create log'){

                        if (!empty($attachment['name'][$order_schedule_id])) {

                            $config['upload_path'] = DIR_TEACHER_FILES;
                            $config['max_size'] = '25000';
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
        
                            $this->load->library('upload', $config);
        
                            $attach = array();
        
                            $_FILES['attach[]']['name'] = $attachment['name'][$order_schedule_id];
                            $_FILES['attach[]']['type'] = $attachment['type'][$order_schedule_id];
                            $_FILES['attach[]']['tmp_name'] = $attachment['tmp_name'][$order_schedule_id];
                            $_FILES['attach[]']['error'] = $attachment['error'][$order_schedule_id];
                            $_FILES['attach[]']['size'] = $attachment['size'][$order_schedule_id];
        
                            $config['file_name'] = ($status[$order_schedule_id] == 'Create log') ? 'log_attachment-'.rand().date('YmdHis') : 'billing_attachment-'.rand().date('YmdHis');
                            $attach[] = $config['file_name'];
        
                            //print "<pre>"; print_r($_FILES['attach[]']); print "</pre>"; die;
                            $this->upload->initialize($config);
        
                            if ($this->upload->do_upload('attach[]')) {
                                $upload_data =  $this->upload->data();
                                $data['attachment'] = $upload_data['file_name'];
                            } else {
                                //$this->upload->display_errors(); die;
                                $this->session->set_flashdata('message_type', 'danger');
                                $this->session->set_flashdata('message', $this->upload->display_errors());
        
                                // redirect('/app/orders/billing/?order_id='.$order_id);
                                redirect('/app/presenters/billing');
                            }

                            $data['order_schedule_id'] = $order_schedule_id;
                            $data['new_status'] = 'Log sent - awaiting principal signature';
                            $data['old_status'] = 'Create log';
                            $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                            $data['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data);

                            $data_another['order_schedule_id'] = $order_schedule_id;
                            $data_another['attachment'] = $data['attachment'];
                            // $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id];
                            $data_another['new_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id];
                            $data_another['old_status'] = ($status[$order_schedule_id] == 'Create log') ? 'Log sent - awaiting principal signature' : $old_status[$order_schedule_id];
                            $data_another['updated_on'] = date("Y-m-d H:i:s");
                            $data_another['updated_by'] = $this->session->userdata('id');
                            $this->App_model->insert('order_schedule_status_log', $data_another);

                            // Update Schedule Table
                            $data_schedule = array(
                                // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                                'status' => ($status[$order_schedule_id] == 'Create log') ? 'Create invoice' : $status[$order_schedule_id],
                                'updated_on' => date("Y-m-d H:i:s"),
                                'updated_by' => $this->session->userdata('id'),
                                'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                            );
                            $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                            $count++;
                        }
                    }

                    if ($status[$order_schedule_id] == "Log sent - awaiting principal signature") {
                        
                        $order = $this->App_model->get_order_details($order_id);
                        $schedule = $this->App_model->get_order_schedule_details($order_schedule_id);   
                        
                        // $data['content'] = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                        //     <tr>
                        //         <td><img src="'. base_url("assets/images/logo.png").'"></td>
                        //         <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        //     </tr>
                        //     <tr>
                        //         <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="border-top:solid 1px;">'.$content.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal’s Signature:</strong></td>
                        //         <td align="right" style="height:50px; border-top:solid 1px;"><strong>Total Hours: </strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                           
                        // </table>';
                    //     $data['content'] = '
                    //     <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 13.5px; font-family:\'Calibri\', sans-serif;">
                    //     <tr>
                    //         <td style="float: left;">' . $schedule->worktype_name . ' Sign- In Log</td>
                    //         <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                    //     </tr>
                    //     <tr>
                    //         <td style="margin-top: 1rem; float: left;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                    //         <td align="right" style=""><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . number_format($schedule->total_hours, 1) . '</u> </strong></span> </td>
                    //     </tr>
                    //     <tr>
                    //         <td colspan="2" style="" style=" float: left;"><strong>PRESENTER:</strong>  ' . $schedule->first_name . ' ' . $schedule->last_name . '  </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style=""><strong>School:</strong> ' . $order->school_name . ' </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style=""><strong>Purchase Order:</strong> ' . $order->order_no . ' </td>
                    //     </tr>
                    // </table>
                    // <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 13.5px; font-family:\'Calibri\', sans-serif; width: 99.5%; margin-left: 7px;">
                    //     <tr style="height:40px;">
                    //         <td colspan="4" style="text-align: center;">
                    //             <table style="width: 100%; font-size: 13.5px;">
                    //                 <tr>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"> <strong>Date of Service:&emsp;&emsp;&emsp;</strong> <br> ' . date("j/n/Y", strtotime($schedule->start_date)) . '&emsp;&emsp;&emsp;</td>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"><strong>&emsp;&emsp;Teacher(s) Name and Grade&emsp;&emsp;</strong> <br>&emsp;&emsp; '. $schedule->teacher .', '. $schedule->grade_name .' &emsp;&emsp;</td>
                    //                     <td style="text-align: center; font-size: 13.5px;"><strong>&emsp;&emsp;&emsp;Session Time:</strong> <br> &emsp;&emsp;&emsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                    //                 </tr>
                    //             </table>
                    //         </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style="border-top:solid 1px; height: 250px; font-size: 11px;">'.$content.'</td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> '.$schedule->teacher.'</td>
                    //         <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong>____________________</td>
                    //     </tr>
                    //     <tr>
                    //          <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> '. $principal_nameForLog.'</td>
                    //          <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong></td>
                    //     </tr>
                    // </table>';
                    $arr = explode(" ",$content);
                    $arr_length = sizeof($arr);
                    $data['content'] = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px;  font-family: Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td align="right" style=" padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                        </tr>
                        <tr>
                            <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                        </tr>
                    </table>

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                        <tr style="height:40px;">
                            <td colspan="4" style="text-align: center;">
                                <table style="width: 100%;" style="font-size: 14.5px;">
                                    <tr>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center; font-size: 14.5px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        // if ($arr_length <= 1060) {
                        //     for ($index = 0; $index < $arr_length; $index++) {
                        //         if (isset($arr[$index]) && strpos($arr[$index], "<br>") !== false) {
                        //             $arr_length += 20;
                        //         }
                        //     }
                        // }

                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 750) {
                            $font_size = '14.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9.5px';
                        }else if($arr_length <= 1900) {
                            $font_size = '8.5px';
                        }else if($arr_length <= 2700) {
                            $font_size = '8px';
                        }else if($arr_length <= 3800) {
                            $font_size = '7px';
                        }else if($arr_length <= 4300) {
                            $font_size = '6px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }

                    
                          $data['content'] .= '
                            <tr>
                                <td align="left" colspan="4" style="border-top: 1px solid;border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                         $data['content'] .= '
                        <tr>
                            <td align="left" style="height:30px; width: 52%; border-right: 1px solid; font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                            <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr>
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid; font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                        // $data['content_for_print'] = '<table width="100%" cellpadding="5" cellspacing="0"  style="border:1px solid black; font-family:\'Ubuntu\', sans-serif;">
                        //     <tr>
                        //         <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 95%;"></td>
                        //         <td align="right" style="color:#813D97 !important; padding-right: 20px; padding-top: 10px; width: 50%;">8696 18th Ave, Brooklyn, NY 11214 <br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px; font-size: 15px;"><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong><br>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="center" colspan="2" style="height:40px;"><strong>Start Time:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'<br></td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        //     </tr>
                        //     <tr>
                        //         <td align="left" colspan="2" style="border-top:solid 1px; padding: 20px;">'.$content.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px; padding-left: 20px;"><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                        //     </tr>

                        //     <tr>
                        //         <td align="left" style="height:50px; padding-left: 20px;"><strong>Principal’s Signature:</strong></td>
                        //         <td colspan="2"><strong style = "margin-left: 12rem;">Total Hours:</strong> '. $schedule->total_hours.'</td>
                        //     </tr>
                            
                        // </table>';
                        
                        $arr = explode(" ",$content);
                        $arr_length = sizeof($arr);
                        $data['content_for_print'] = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px; font-family:Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td><img src="' . base_url("assets/images/logo.png") . '" style="width: 36%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.8rem; float: left;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="position: relative; top: -6px;"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 33px;"><strong><u>' . intval($schedule->total_hours) . '</u></strong> </span> </td>
                        </tr>
                        <tr>
                            <td colspan="2"  style=" float: left;  top: -8px; position: relative;"><strong>PRESENTER:</strong>  <strong>' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; top: -14px; position: relative;"><strong>School:</strong> ' . $order->school_name . ' </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; top: -21px; position: relative;"><strong>Purchase Order:</strong>  <strong>' . $order->order_no . ' </strong> </td>
                        </tr>
                    </table>

                    <div><img src="'. base_url('assets/images/hr_line.png').'" style="position: absolute;margin-left: 13rem;width: 1px;height: 49px;margin-top: -16px;"></div>

                    <div><img src="'. base_url('assets/images/hr_line.png').'" style="position: absolute;margin-left: 30rem;width: 1px;height: 49px;margin-top: -16px;"></div>

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px; font-family:Calibri; width: 99.5%; margin-left: 7px;  margin-top: -1rem;">
                        <tr style="height:40px;">
                            <td colspan="2" style="">
                                <table style="width: 100%;" style="border: 1px solid black; border-collapse: collapse; font-size: 14.5px;">
                                    <tr>
                                        <td style="text-align: center;  font-size: 14.5px;"> <strong>Date of Service:</strong> <br> <strong>' . date("j/n/Y", strtotime($schedule->start_date)) . '</strong></td>
                                        <td style="text-align: center;  font-size: 14.5px;"><strong>Teacher(s) Name and Grade</strong> <br> <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> </td>
                                        <td style="text-align: center; font-size: 14.5px;"><strong>Session Time:</strong> <br> ' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 800) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9px';
                        }else if($arr_length <= 2100) {
                            $font_size = '8px';
                        }else if($arr_length <= 2700) {
                            $font_size = '7px';
                        }else if($arr_length <= 3800) {
                            $font_size = '6px';
                        }else if($arr_length <= 4300) {
                            $font_size = '5px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }
                    
                         $data['content_for_print'] .= '
                            <tr>
                                <td align="left" colspan="2" style="border-top:solid 1px; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                        $data['content_for_print'] .= '
                        <tr style="font-family: Times New Roman;">
                            <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'</strong></td>
                            <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr style="font-family: Times New Roman;">
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                    //     $arr = explode(" ",$content);
                    //     $arr_length = sizeof($arr);
                    //     $logDatanew= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                    //     <tr>
                    //          <td><img src="'. base_url("assets/images/logo.png").'" style="padding-left: 20px; padding-top: 10px; width: 50% !important;"></td>
                    //         <td align="right" style="color:#813D97; !important; padding-right: 20px; padding-top: 10px; width: 50%;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                    //     </tr>
                    //     <tr>
                    //          <td align="center" colspan="2" style="height:40px; "><strong><br>'. $schedule->worktype_name.' Sign- In Log</strong></td>
                    //     </tr>
                    //     <tr>
                    //         <td align="center" colspan="2" style="height:40px; "><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                    //     </tr>
                    //     <tr>
                    //         <td align="center" colspan="2" style="height:40px; "><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                    //     </tr>
                    //     <tr>
                    //         <td align="center" colspan="2" style="height:40px; "><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px; "><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px; "><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                    //     </tr>';

                        
                    //         // echo $arr[$index]. " ";
                    //         $index_first_page=470;

                    //         $max_loop_count = $arr_length;
                    //         if($max_loop_count>$index_first_page){
                    //             $max_loop_count = $index_first_page;
                    //         }
                          
                    //     $logDatanew .= '<tr>
                    //         <td  align="left" colspan="2" style="border-top:solid 1px; padding-left: 2px; ">';
                    //         for ($index = 0; $index <= $max_loop_count; $index++) {

                    //             // if (strpos($arr[$index], "<br>") != false && $max_loop_count>=$index_first_page) {
                    //             if($index <= sizeof($arr)){
                    //                 if (strpos($arr[$index], "<br>") != false) {
                    //                     $break_pos = (15-($index % 15));
                    //                     if($break_pos>2 && ($index % 15)!=0){
                    //                         // $break_pos = 15-($index % 15);
                    //                         $max_loop_count = ($max_loop_count-$break_pos);
                    //                     }
                    //                 }

                                    
                    //                     $logDatanew .= $arr[$index]." ";
                    //             }
                    //         }
                            
                    //         $logDatanew .='</td>
                    //     </tr>
                    //     ';    
                    //     $index_first_page=$max_loop_count;
                    //     // ...........................................
                    //     $index_rest_pages = 800;

                    //         $arr_length_rest_page= ($arr_length-$index_first_page);
    
                    //         $arr_loop_count = floor($arr_length_rest_page / $index_rest_pages);

                    //         // $arr_loop_count = ($arr_length_rest_page / $index_rest_pages);
                    //         $last_loop_data_count = ($arr_length_rest_page % $index_rest_pages);
                    //         if($last_loop_data_count>0) {
                    //             $arr_loop_count = $arr_loop_count+1;
                    //         }

                    //         $index_break = 0;
                    //         $index_break_word=0;
                    //     // while($arr_length_2pg >= 0){
                    //  for( $i=0; $i < $arr_loop_count; $i++){
                    //     if($index_break==0){
                    //         $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                    //     }else{
                    //         $index_j=$index_max_j;
                    //     }
                    //     // if(!empty($arr[$last_index])){
                    //         // $index_j = ($index_first_page+($index_rest_pages*$i))+1;
                    //         // $index_j = ($index_first_page+($index_rest_pages*$i)) - $index_break;
                    //         $index_max_j = 0;

                    //         if($i == ($arr_loop_count-1) && $last_loop_data_count>0){
                    //              $index_max_j = $index_j+$last_loop_data_count;
                    //         }else{
                    //              $index_max_j = $index_j+$index_rest_pages;
                    //         }
                            

                    //         $logDatanew .= '<tr>
                    //         <td  align="left" colspan="2" style="padding-left: 2px; ">';
                    //         for ($j= $index_j; $j < $index_max_j; $j++) {
                    //             // if (strpos($arr[$j], "<br>") != false) {
                    //                 if(($index_max_j - $index_j)<$index_rest_pages){
                    //                     $index_max_j = $index_max_j+$index_break_word;
                    //                 }
                    //             if($j <= sizeof($arr)){
                    //                 if (strpos($arr[$j], "<br>") != false && ($index_max_j - $index_j) >= $index_rest_pages){
                    //                     $break_pos_rest_page = (15-($j%15));
                    //                     if($break_pos_rest_page>2 && ($j%15)!=0){
                    //                     // $break_pos_rest_page = ($j%15);
                    //                     $index_max_j = ($index_max_j-$break_pos_rest_page);
                    //                     // $index_break = ($index_break+$break_pos_rest_page);
                    //                     $index_break_word = ($index_break_word+$break_pos_rest_page);
                    //                     $index_break = 1;
                    //                     }
                    //                 }
                                    
                    //                     $logDatanew .= $arr[$j]." ";    
                    //             }
                                
                    //     }
                    //     $logDatanew .='</td>
                    //     </tr>
                    //     '; 
                    // }
                         

                    //     $logDatanew .= '
                    //         <tr>
                    //             <td align="left" colspan="2" style="height:50px; border-top:solid 1px;padding-left: 5px; "><strong>Principal:</strong> '. $principal_nameForLog.'</td>
                    //         </tr>

                     


                    //         <tr>
                    //         <td align="left" style="height:50px; padding-left: 5px; "><strong>Principal’s Signature:</strong></td>
                    //         <td colspan="2"><strong>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Total Hours:</strong> '. $schedule->total_hours.'</td>
                    //        </tr>
                            
                        
                        
                        
                    //     </table>';

                    $logDatanew = '
                        <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px !important;  font-family: Calibri;">
                        <tr>
                            <td style="float: left; margin-top: 1.1rem; font-size: 14.5px !important;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                            <td style="float: right; padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                        </tr>
                        <tr>
                            <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                            <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                        </tr>
                        <tr>
                            <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                        </tr>
                    </table>

                    

                    <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px !important;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                        <tr style="height:40px;">
                            <td colspan="4" style="text-align: center;">
                                <table style="width: 100%;" style="font-size: 14.5px !important;">
                                    <tr style="height:40px;">
                                        <td style="text-align: center;  border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td style="text-align: center;  border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align: center;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                        if ($arr_length <= 1060) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+20;
                                }
                            }
                        } else if($arr_length <= 1130) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+21;
                                }
                            }
                        }else if($arr_length <= 1230) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+22;
                                }
                            }
                        }else if($arr_length <= 1300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+23;
                                }
                            }
                        }else if($arr_length <= 1500) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+26;
                                }
                            }
                        }else if($arr_length <= 2100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+30;
                                }
                            }
                        }else if($arr_length <= 2700) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+35;
                                }
                            }
                        }else if($arr_length <= 3800) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+43;
                                }
                            }
                        }else if($arr_length <= 4300) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+50;
                                }
                            }
                        }else if($arr_length <= 5200) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+55;
                                }
                            }
                        }else if($arr_length <= 6100) {
                            for ($index = 0; $index <= $arr_length; $index++) {
                                if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                    $arr_length = $arr_length+65;
                                }
                            }
                        }else{
                            $arr_length = 6200;
                        }

                        if ($arr_length <= 750) {
                            $font_size = '14.5px';
                        }else if($arr_length <= 900) {
                            $font_size = '12.5px';
                        }else if($arr_length <= 1030) {
                            $font_size = '11.5px';
                        }else if($arr_length <= 1300) {
                            $font_size = '10.5px';
                        }else if($arr_length <= 1500) {
                            $font_size = '9.5px';
                        }else if($arr_length <= 1900) {
                            $font_size = '8.5px';
                        }else if($arr_length <= 2700) {
                            $font_size = '8px';
                        }else if($arr_length <= 3800) {
                            $font_size = '7px';
                        }else if($arr_length <= 4300) {
                            $font_size = '6px';
                        }else if($arr_length <= 5200) {
                            $font_size = '5.5px';
                        }else if($arr_length <= 6100) {
                            $font_size = '4px';
                        }else{
                            $font_size = '1px';
                        }

                    
                          $logDatanew .= '
                            <tr>
                                <td align="left" colspan="4" style="border-top: 1px solid;  border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content.'</td>
                            </tr>';
        
                         $logDatanew .= '
                        <tr>
                            <td align="left" style="height:30px; width: 52%; border-right: 1px solid;font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                            <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                        </tr>
                        <tr>
                             <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $principal_nameForLog.'</strong></td>
                             <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Principal’s Signature:</strong></td>
                        </tr>
                    </table>';

                     // .............................................................................
                        $data['log_pdf_admin'] =$logDatanew;


                        $data['order_schedule_id'] = $order_schedule_id;
                        $data['new_status'] = 'Log sent - awaiting principal signature';
                        $data['old_status'] = 'Create log';
                        $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['content_txt'] = $content;
                        $data['principal_name'] = $principal_nameForLog;
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $count++;
                    }

                    if ($status[$order_schedule_id] == "Awaiting Review") {
                        $data['content'] = isset($content) ? $content : '';
                        $logData = $this->App_model->get_schedule_logContent($order_schedule_id);
                        
                        // $pdf = $logData.'<img src="'.FCPATH.$data['content'].'">';

                        // placing signatures in new position 
                        $logs_principal_name = $this->App_model->logs_principal_name($order_schedule_id);
                        $content_txt = $this->App_model->get_schedule_logContent_txt($order_schedule_id);
                        $order = $this->App_model->get_order_details($order_id);
                        $schedule = $this->App_model->get_order_schedule_details($order_schedule_id); 

                        // $logDatanew= '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                        // <tr>
                        //     <td><img src="'. base_url("assets/images/logo.png").'"></td>
                        //     <td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
                        // </tr>
                        // <tr>
                        //     <th colspan="2" style="height:40px;">'. $schedule->worktype_name.' Sign- In Log</th>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Presenter\'s Name:</strong> '. $schedule->first_name." ".$schedule->last_name.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Date:</strong>'. date_display($schedule->start_date, "l, F j, Y").'</td>
                        // </tr>
                        // <tr>
                        //     <td align="center" colspan="2" style="height:40px;"><strong>Start TIme:</strong> '. time_display($schedule->start_date, true).' <strong>End Time:</strong> '. time_display($schedule->end_date, true).' <strong>Total Hours:</strong> '. $schedule->total_hours.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> '. $order->school_name.' <strong>Title:</strong> '. $order->title_name.' <strong>PO#:</strong> '. $order->order_no.'</td>
                        // </tr>
                        // <tr>
                        //     <td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> '. $schedule->topic_name.'</td>
                        // </tr>
                        // <tr>
                        //         <td align="left" colspan="2" style="border-top:solid 1px;">'.$content_txt.'</td>
                        //     </tr>


                        //     <tr>
                        //         <td align="left" colspan="2" style="height:35px; border-top:solid 1px;"><strong>Principal:</strong> '. $logs_principal_name.'</td>
                        //     </tr>

                     


                        //     <tr>
                        //         <td style="height:50px;"><strong>Principal’s Signature:</strong><img src="'.base_url().$data['content'].'"width="100" height="50" style="margin-top:-10px; margin-bottom:-7px;"></td>
                        //         <td align="right" style="padding-top:22px; width:120px;"><strong>Total Hours: </strong>'.$schedule->total_hours.'</td>
                        //     </tr>
                        

                        
                        // </table>';

                        $arr = explode(" ",$content_txt);
                        $arr_length = sizeof($arr);
                    //     $logDatanew = '
                    //     <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 13.5px; font-family:\'Calibri\', sans-serif;">
                    //     <tr>
                    //         <td style="float: left;">' . $schedule->worktype_name . ' Sign- In Log</td>
                    //         <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<img src="' . base_url("assets/images/logo.png") . '" style="width: 36%; float: right;"></td>
                    //     </tr>
                    //     <tr>
                    //         <td style="margin-top: 1rem; float: left;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                    //         <td align="right" style=""><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . number_format($schedule->total_hours, 1) . '</u></strong> </span> </td>
                    //     </tr>
                    //     <tr>
                    //         <td colspan="2" style="" style=" float: left;"><strong>PRESENTER:</strong>  ' . $schedule->first_name . ' ' . $schedule->last_name . '  </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style=""><strong>School:</strong> ' . $order->school_name . ' </td>
                    //     </tr>
                    //     <tr>
                    //         <td align="left" colspan="2" style=""><strong>Purchase Order:</strong> ' . $order->order_no . ' </td>
                    //     </tr>
                    // </table>
                    // <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 13.5px; font-family:\'Calibri\', sans-serif; width: 99.5%; margin-left: 7px;">
                    //     <tr style="height:40px;">
                    //         <td colspan="4" style="text-align: center;">
                    //             <table style="width: 100%; font-size: 13.5px;">
                    //                 <tr>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"> <strong>Date of Service:&emsp;&emsp;&emsp;</strong> <br> ' . date("j/n/Y", strtotime($schedule->start_date)) . '&emsp;&emsp;&emsp;</td>
                    //                     <td style="text-align: center; border-right: 1px solid; font-size: 13.5px;"><strong>&emsp;&emsp;Teacher(s) Name and Grade&emsp;&emsp;</strong> <br> &emsp;&emsp;'. $schedule->teacher .', '. $schedule->grade_name .'&emsp;&emsp; </td>
                    //                     <td style="text-align: center; font-size: 13.5px;"><strong>&emsp;&emsp;&emsp;Session Time:</strong> <br> &emsp;&emsp;&emsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                    //                 </tr>
                    //             </table>
                    //         </td>
                    //     </tr>';
                    //     for ($index = 0; $index <= $arr_length; $index++) {
                    //         if (strpos($arr[$index], "<br>") != false) {
                    //             $arr_length = $arr_length+20;
                    //         }
                    //     }

                    //     if ($arr_length <= 970) {
                    //         $font_size = '11.5px';
                    //     } else if($arr_length <= 1060) {
                    //         $font_size = '11px';
                    //     }else if($arr_length <= 1130) {
                    //         $font_size = '10.5px';
                    //     }else if($arr_length <= 1230) {
                    //         $font_size = '10px';
                    //     }else if($arr_length <= 1300) {
                    //         $font_size = '9.5px';
                    //     }else if($arr_length <= 1500) {
                    //         $font_size = '9px';
                    //     }else if($arr_length <= 2100) {
                    //         $font_size = '8px';
                    //     }else if($arr_length <= 2700) {
                    //         $font_size = '7px';
                    //     }else if($arr_length <= 3800) {
                    //         $font_size = '6px';
                    //     }else if($arr_length <= 4300) {
                    //         $font_size = '5px';
                    //     }else if($arr_length <= 5200) {
                    //         $font_size = '4.5px';
                    //     }else if($arr_length <= 6100) {
                    //         $font_size = '4px';
                    //     }else{
                    //         $font_size = '1px';
                    //     }

                    
                    //       $logDatanew .= '
                    //         <tr>
                    //             <td align="left" colspan="2" style="border-top:solid 1px; height: 250px; font-size: '.$font_size.';">'.$content_txt.'</td>
                    //         </tr>';
        
                    //      $logDatanew .= '
                    //     <tr>
                    //         <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> '.$schedule->teacher.'</td>
                    //         <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong>____________________</td>
                    //     </tr>
                    //     <tr>
                    //          <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> '. $principal_nameForLog.'</td>
                    //          <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong><img src="'.base_url().$data['content'].'"width="100" height="33" style="margin-top:-10px; margin-bottom:-7px;"></td>
                    //     </tr>
                    // </table>';
                    /////////////////////////////////////////////////////////
                    $logDatanew = '
                    <table width="100%" cellpadding="5" cellspacing="0"  style = "font-size: 14.5px;  font-family: Calibri;">
                    <tr>
                        <td style="float: left; margin-top: 1.1rem;">' . mb_strtoupper($schedule->worktype_name) . ' & Sign-In Log</td>
                        <td align="right" style=" padding-left:20rem;"><img src="' . base_url("assets/images/logo.png") . '" style="width: 25%; float: right;"></td>
                    </tr>
                    <tr>
                        <td style="margin-top: 0.4rem; float: left; width: 17rem;"><strong>Vendor: Brienza’s Academic Advantage</strong></td>
                        <td align="right" style="margin-top: -10px"><strong>Total Hours of Service:</strong> <span style="color: #51c03de3; font-size: 30px;"><strong><u>' . intval($schedule->total_hours) . '</u> <strong></span> </td>
                    </tr>
                    <tr>
                        <td colspan="2" style=" float: left; padding-top:-5px;"><strong>PRESENTER:</strong> <strong> ' . $schedule->first_name . ' ' . $schedule->last_name . ' </strong> </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>School:</strong> ' . $order->school_name . '</td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" style="float: left; padding-top:-5px;"><strong>Purchase Order:</strong> <strong>' . $order->order_no . '</strong> </td>
                    </tr>
                </table>

                <table cellpadding="5" cellspacing="0"  style="border:1px solid black; font-size: 14.5px;  font-family: Calibri; width: 99.5%; margin-left: 7px;">
                    <tr style="height:40px;">
                        <td colspan="4" style="text-align: center;">
                            <table style="width: 100%;" style="font-size: 14.5px;">
                                <tr>
                                    <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"> <strong>Date of Service:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br><strong> ' . date("j/n/Y", strtotime($schedule->start_date)) . ' </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align: center;  font-size: 14.5px; border-right: 1px solid;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher(s) Name and Grade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'. $schedule->teacher .', '. $schedule->grade_name .'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align: center; font-size: 14.5px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session Time:</strong> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . time_display($schedule->start_date, true) . ' <span> to </span> ' . time_display($schedule->end_date, true) . ' </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
                    if ($arr_length <= 1060) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+20;
                            }
                        }
                    } else if($arr_length <= 1130) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+21;
                            }
                        }
                    }else if($arr_length <= 1230) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+22;
                            }
                        }
                    }else if($arr_length <= 1300) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+23;
                            }
                        }
                    }else if($arr_length <= 1500) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+26;
                            }
                        }
                    }else if($arr_length <= 2100) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+30;
                            }
                        }
                    }else if($arr_length <= 2700) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+35;
                            }
                        }
                    }else if($arr_length <= 3800) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+43;
                            }
                        }
                    }else if($arr_length <= 4300) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+50;
                            }
                        }
                    }else if($arr_length <= 5200) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+55;
                            }
                        }
                    }else if($arr_length <= 6100) {
                        for ($index = 0; $index <= $arr_length; $index++) {
                            if (isset($arr[$index]) && strpos($arr[$index], "<br>") != false) {
                                $arr_length = $arr_length+65;
                            }
                        }
                    }else{
                        $arr_length = 6200;
                    }

                    if ($arr_length <= 750) {
                        $font_size = '14.5px';
                    }else if($arr_length <= 900) {
                        $font_size = '12.5px';
                    }else if($arr_length <= 1030) {
                        $font_size = '11.5px';
                    }else if($arr_length <= 1300) {
                        $font_size = '10.5px';
                    }else if($arr_length <= 1500) {
                        $font_size = '9.5px';
                    }else if($arr_length <= 1900) {
                        $font_size = '8.5px';
                    }else if($arr_length <= 2700) {
                        $font_size = '8px';
                    }else if($arr_length <= 3800) {
                        $font_size = '7px';
                    }else if($arr_length <= 4300) {
                        $font_size = '6px';
                    }else if($arr_length <= 5200) {
                        $font_size = '5.5px';
                    }else if($arr_length <= 6100) {
                        $font_size = '4px';
                    }else{
                        $font_size = '1px';
                    }

                
                      $logDatanew .= '
                        <tr>
                            <td align="left" colspan="4" style="border-top: 1px solid; border-bottom: 1px solid; height: 250px; vertical-align: top; font-size: '.$font_size.';">'.$content_txt.'</td>
                        </tr>';
    
                     $logDatanew .= '
                    <tr>
                        <td align="left" style="height:30px; border-right: 1px solid; font-family: timesnewroman;"><strong>Teacher’s Name:</strong> <strong>'.$schedule->teacher.'<strong></td>
                        <td align="left" style="height:30px; font-family: timesnewroman;"><strong>Teacher’s Signature:</strong></td>
                    </tr>
                    <tr>
                        <td align="left" style="height:30px; width:50%;  border-right: 1px solid; font-family: timesnewroman;"><strong>Principal’s Name: </strong> <strong>'. $logs_principal_name.'</strong></td>
                        <td align="left" style="height:30px; width:50%; font-family: timesnewroman;"><strong>Principal’s Signature:</strong> <img src="'.base_url().$data['content'].'"width="100" height="33" style="margin-top:-10px; margin-bottom:-7px;"> </td>
                    </tr>
                </table>';
                        //print_r($logDatanew);die;
                        $pdfnew= $logDatanew;
                        
                        // $pdf = $logData.'<img src="'.FCPATH.$data['content'].'">';

                        // end


                        $this->load->library('m_pdf');

                        //this the the PDF filename that user will get to download
                        $data['school_pdf'] = DIR_TEACHER_FILES."log_".rand().date('YmdHis').".pdf";       
                                    
                        //generate the PDF from the given html
                        $this->m_pdf->pdf->WriteHTML($pdfnew);
                        
                        //download it.
                        $this->m_pdf->pdf->Output($data['school_pdf']); 


                        $data['order_schedule_id'] = $order_schedule_id;
                        // $data['new_status'] = 'Awaiting Review';
                        $data['new_status'] = 'Create invoice';
                        $data['old_status'] = 'Log sent - awaiting principal signature';
                        $data['updated_on'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 1);
                        $data['updated_by'] = $this->session->userdata('id');
                        $this->App_model->insert('order_schedule_status_log', $data);

                        // Update Schedule Table
                        $data_schedule = array(
                            // 'status' => ($status[$order_schedule_id] == 'Create log') ? 'Awaiting Review' : $status[$order_schedule_id],
                            'status' => 'Create invoice',
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata('id'),
                            'log_status' => ($status[$order_schedule_id] == 'Create log' && !empty($attachment['name'])) ? 'file upload' : 'template'
                        );
                        $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);

                        $data_schedule_oldrow = array( 
                            'content' => $logDatanew,
                            'updated_on' => date("Y-m-d H:i:s"),
                            'updated_by' =>$this->session->userdata('id')
                            
                        );

                        $this->App_model->update_for_old_row('order_schedule_status_log', 'order_schedule_id', $order_schedule_id, $data_schedule_oldrow);

                        $count++;

                    }

                    if ($status[$order_schedule_id] == "Invoice created") {
                        
                        // Generate Invoice
                        $presenter_id = $this->input->post('presenter_id');
                        $order = $this->App_model->get_order_details($order_id, $presenter_id);
                        $schedules =$this->App_model->get_order_schedule_details($order_schedule_id);
                        // echo "<pre>";print_r($schedules);exit;
                                
                        // ======== Start Code By Ahmed on 2019-08-28 ======= //
                        $logData = $this->App_model->get_log_pdf_content($order_schedule_id);
                        // ======= End of the code 2019-08-28 ====== // 
                        $invoice = '<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:\'Ubuntu\', sans-serif;">
                            <tr>
                                <td style="height:40px;" colspan="4">
                                <img src="'.base_url().'assets/header_image/'.$order->headerImg.'" height="135" width="100%">
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;" colspan="4"><strong>INVOICE:</strong></td>
                                <td style="height:40px; text-align:right"><strong>BILL TO</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Company Name:</strong> '. $order->company_name.'</td>
                                <td style="text-align:right"><strong>Brienza\'s Academic Advantage, Inc. 8696 18th Avenue Brooklyn, New York 11214</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Presenter:</strong> '. $order->teacher_name.'</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Address:</strong> '. $order->presenter_address.'</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Phone number:</strong> '. $order->presenter_phone.'</td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4"><strong>PO#:</strong> '. $order->order_no.' <strong>School:</strong> '. $order->school_name.'</td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Rate</th>
                                <th>Hours</th>
                                <th>Total</th>
                            </tr>';
                            
                            $g_total = 0;
                            $g_hrs = 0;
                            // foreach ($schedules as $schedule) {
                                $total = ($schedules->total_hours*$order->hourly_rate);
                                $invoice .= '<tr>
                                    <td>'.$schedules->start_date.'-'.$schedules->end_date.'</td>
                                    <td align="right">$'.$order->hourly_rate.'</td>
                                    <td align="right">'.$schedules->total_hours.'</td>
                                    <td align="right">$'.number_format($total,2).'</td>
                                </tr>';
                                $g_hrs += $schedules->total_hours;
                                $g_total += $total;
                            // }
                            
                            $invoice .= '<tr>
                                <td align="left"></td>
                                <td colspan="2" align="right"><strong>Total Hours:</strong> '. $g_hrs.'</td>
                                <td align="right"><strong>Total:</strong>$'. number_format($g_total,2).'</td>
                            </tr>
                            <tr>
                                <td align="right">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">Signature: <img src="'.FCPATH.$content.'"></td>
                                <td align="right" colspan="2">Date: '.date("m/d/Y").'</td>
                            </tr>
                            <tr>
                                <td align="right">&nbsp;</td>
                            </tr>
                        </table>';
                        $invoice .= '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
                        
                        // ======== Start Code By Ahmed on 2019-08-08 ======= //
                        if(isset($logData->attachment) && $logData->attachment != ''){
                            $invoice .= '<img src="'.FCPATH."/assets/teachers/".$logData->attachment.'">';
                        }else{
                            $invoice .=$logData->create_log_content.'<img src="'.FCPATH.$logData->content.'">';
                        }
                        // ======= End od the Code 2019-08-08 ====== //
                        //load mPDF library
                        $this->load->library('m_pdf');

                        //this the the PDF filename that user will get to download
                        $data['attachment'] = DIR_TEACHER_FILES."invoice_".date('YmdHis').".pdf";       
                                    
                        //generate the PDF from the given html
                        $this->m_pdf->pdf->WriteHTML($invoice);
                        
                        //download it.
                        $this->m_pdf->pdf->Output($data['attachment']); 

                        $data['content'] = $content;

                        // // Update Log table
                        // if ($this->App_model->insert('order_schedule_status_log', $data)) {
                        //     $count++;
                        // } 
                        
                    }


                    // $count++;
                     
                }else{

                    $data['updated_on'] = date("Y-m-d H:i:s");
                    $data['updated_by'] = $this->session->userdata('id');
                    
                    // Update Schedule Table
                    $this->App_model->update('order_schedule_status_log', 'id', $order_schedule_status_id[$order_schedule_id], $data);
                }
                

            }
            
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('message', '<strong>Well done!</strong> '.$count.' Status successfully updated.');
            if($this->input->post('ajaxCall')){
                echo true;exit;
            }else{
                   
                redirect('/app/presenters/billing');            
            }
        }
        }
        
        if ($order_id) {
            
            // Get order details
            $data['order'] = $this->App_model->get_order_details($order_id);
            $data['selectConBtn'] = FALSE;
            if($this->session->userdata('role') == 'teacher')
            {
                $presenter_id   = $this->session->userdata('id');

                $schedulable_hr = $this->App_model->get_allowed_hours_preseneter($order_id, $presenter_id);
                $scheduled_hr   = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);

                $data['schedules'] = $this->App_model->get_order_schedule($order_id, $presenter_id, "order_schedules.id");
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
            }else{
                
                // Get the existing schedule
                $data['schedules'] = $this->App_model->get_order_schedule($order_id, NULL, "order_schedules.id");   
                //echo "<pre>";print_r($data['schedules']);die;         
            }
        }
     
        $data['previewButton'] = FALSE;
        if($this->session->userdata('role') == "teacher"){
            $pid = $this->session->userdata('id');
        }else{
            $pid='';
        }
        $scheduled_ids = $this->App_model->get_schedule_ids($order_id, $pid);
        foreach ($scheduled_ids  as $row) {
            $res = $this->App_model->checkCreateLog($row->id);
            if($res){
                $data['previewButton'] = TRUE;
            }else{
                $data['previewButton'] = FALSE;
                break;
            }
        }
       
        $data['page'] = 'order';
        $data['page_title'] = SITE_NAME.' :: Order Management &raquo; Billing';
        $data['approvedStatus'] = $this->App_model->getApprovedStatus($order_id, $pid);
        // echo '<pre>'; print_r($data); die(); 
        $data['main_content'] = 'orders/billing';
        $this->load->view(TEMPLATE_PATH, $data);
    }


	public function check_schedules(){
        $order_id       = $this->input->post('odrid');
        $presenter_id   = $this->input->post('presenter_id');
        $orderSchedulesExits = $this->App_model->get_order_schedules_by_pid_odrid($presenter_id, $order_id);
       
        if(!empty($orderSchedulesExits)){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($orderSchedulesExits));
            return;
        }else{
            echo 0;
        }
    }
	public function check_submit_invoice(){
        $order_id       = $this->input->post('odrid');
        $presenter_id   = $this->input->post('presenter_id');
        $isInvoiceCreated = $this->App_model->get_invoice_by_pid_odrid($presenter_id, $order_id);
        // echo $isInvoiceCreated; die();
        if($isInvoiceCreated != false){
            $result = $isInvoiceCreated;
        }else{
            $result = 0;
        }
        echo $result; 
        // echo json_encode($result);

    }
	function download_previous_billing_csv(){
        $presenter_id = $this->session->userdata('id');

        $results = $this->App_model->get_previous_orders($presenter_id);
        // echo '<pre>'; print_r($results); die();

        $delimiter = ",";
        $filename = "previous_order_" . date('YmdHis') . ".csv";
        
        //create a file pointer
        $f = fopen('php://memory', 'w');
        
        //set column headers
        $fields = array('Order Id', 'Created on', 'School', 'Assigned hours', 'Worked hours');
        fputcsv($f, $fields, $delimiter);
        
        //output each row of the data, format line as csv and write to file pointer
        //  for CSV
        foreach ($results as $key => $val) {
            $time = date('Y-m-d', strtotime($val[0]->created_on));
            $t_hours = ($val[0]->total_hours_scheduled == '')? '0' : $val[0]->total_hours_scheduled;
            $lineData = array($val[0]->order_no, $time, $val[0]->school_name, $val[0]->assigned_hours, $t_hours);
            fputcsv($f, $lineData, $delimiter);
        }

        //move back to beginning of file
        fseek($f, 0);
        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        fpassthru($f);

    }

	function declineSchedule(){
        $schedule_id = $this->input->post('schedule_id');
        $tablename = 'order_schedules';
        $decline = $this->App_model->delete($tablename, $schedule_id);
        if($decline){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function reUpload_document() {


        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           
            $attachment = (isset($_FILES['file'])?$_FILES['file']:"");
            $log_id = $this->input->post('log_id');
            $order_schedule_id = $this->input->post('row_id');
            $order_id = $this->input->post('order_id');
          
            // echo $row_id;die;
            $schedule = $this->App_model->get_schedule_log($log_id);
       
            $existing_path = $_SERVER['DOCUMENT_ROOT'].'brienza/assets/teachers/'.$schedule->attachment;
          
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
                    $data['attachment'] = $upload_data['file_name'];
                    $data['updated_by'] = $this->session->userdata('id');
                    $data['updated_on'] = date("Y-m-d H:i:s");
                
                    $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $data);
                    if($isSuccess && (file_exists($existing_path))){
                        unlink($existing_path);
                    }

                      // Update Schedule Table
                      $data_schedule = array(
                        // 'status' => $schedule->new_status,
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => $this->session->userdata('id'),
                        'log_status' => 'file upload',
                        're_upload_change' => '1'
                    );
                 
                    $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
                
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> Status successfully updated.');
                    echo true;exit;

                } else {
                    //$this->upload->display_errors(); die;
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', $this->upload->display_errors());

                    redirect('/app/orders/billing/?order_id='.$order_id);
                }
            }
        }
    }


    public function reUpload_document_for_presenter() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           
            $attachment = (isset($_FILES['file'])?$_FILES['file']:"");
            $log_id = $this->input->post('log_id');
            $order_schedule_id = $this->input->post('row_id');
           
            $schedule = $this->App_model->get_schedule_log($log_id);

            $existing_path = $_SERVER['DOCUMENT_ROOT'].'brienza/assets/teachers/'.$schedule->attachment;
          
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

                        $data['updated_by'] = $this->session->userdata('id');
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $data['old_status'] = 'Log sent - awaiting principal signature';
                        // $data['new_status'] = 'Awaiting Review';
                        $data['new_status'] = 'Create invoice';
                        $data['attachment'] = $upload_data['file_name'];
                        $data['order_schedule_id'] = $order_schedule_id;
                        
                        $insert = $this->App_model->insert('order_schedule_status_log', $data);

                        $upadate_data['attachment'] = $upload_data['file_name'];
                        $upadate_data['updated_by'] = $this->session->userdata('id');
                        $upadate_data['updated_on'] = date("Y-m-d H:i:s");
                        $upadate_data['content'] = '';
    
                        $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $upadate_data);
                        if($isSuccess && (file_exists($existing_path))){
                            unlink($existing_path);
                        }
                        // print_r($insert);die;
                    }else{

                        $data['attachment'] = $upload_data['file_name'];
                        $data['updated_by'] = $this->session->userdata('id');
                        $data['updated_on'] = date("Y-m-d H:i:s");
                        $data['content'] = '';
    
                        $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $data);
                        if($isSuccess && (file_exists($existing_path))){
                            unlink($existing_path);
                        }
    
                        // Update order_schedule_status_log Table.
                        $schedules = $this->App_model->get_all_log_content($order_schedule_id);
    
                        foreach ($schedules as $schedule) {
    
                            // if ($schedule['old_status'] == 'Awaiting Review'){
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
                        'updated_by' => $this->session->userdata('id'),
                        'log_status' => 'file upload',
                        're_upload_change' => '1'
                    );

                    // print_r($data_schedule);die;
                    $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> Status successfully updated.');
                    echo true;exit;
                
                } else {
                    //$this->upload->display_errors(); die;
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', $this->upload->display_errors());

                    redirect('/app/orders/billing');
                }

            }
        }
    }

  /*  public function reUpload_document_for_presenter() {


        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
           
            $attachment = (isset($_FILES['file'])?$_FILES['file']:"");
            $log_id = $this->input->post('log_id');
            $order_schedule_id = $this->input->post('row_id');
           
            $schedule = $this->App_model->get_schedule_log($log_id);
       
            $existing_path = $_SERVER['DOCUMENT_ROOT'].'brienza/assets/teachers/'.$schedule->attachment;
          
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
                    $data['attachment'] = $upload_data['file_name'];
                    $data['updated_by'] = $this->session->userdata('id');
                    $data['updated_on'] = date("Y-m-d H:i:s");
                    $data['content'] = '';

                    $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $log_id, $data);
                    if($isSuccess && (file_exists($existing_path))){
                        unlink($existing_path);
                    }

                    // Update order_schedule_status_log Table.
                    $schedules = $this->App_model->get_all_log_content($order_schedule_id);

                    foreach ($schedules as $schedule) {
                        if ($schedule['old_status'] == 'Awaiting Review'){
                            $isDeleteSuccess = $this->App_model->delete('order_schedule_status_log', $schedule['id']);
                        }
                        if ($schedule['old_status'] == 'Create log'){
                            $isSuccess = $this->App_model->update('order_schedule_status_log', 'id', $schedule['id'], $data);
                           
                        } 

                    }

                      // Update Schedule Table
                      $data_schedule = array(
                        'status' => 'Awaiting Review',
                        'updated_on' => date("Y-m-d H:i:s"),
                        'updated_by' => $this->session->userdata('id'),
                        'log_status' => 'file upload',
                        're_upload_change' => '1'
                    );

                    $this->App_model->update('order_schedules', 'id', $order_schedule_id, $data_schedule);
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('message', '<strong>Well done!</strong> Status successfully updated.');
                    echo true;exit;
                
                } else {
                    //$this->upload->display_errors(); die;
                    $this->session->set_flashdata('message_type', 'danger');
                    $this->session->set_flashdata('message', $this->upload->display_errors());

                    redirect('/app/orders/billing');
                }
            }
        }
    }*/

    public function delete_schedule(){

        $scheduledIds = $this->input->post('scheduled_id');
 
        if(count($scheduledIds)>0){
            $scheduleCount = 0;
            foreach ($scheduledIds as $scheduleId){
               
                $schedules = $this->App_model->get_all_log_content($scheduleId);
                foreach ($schedules as $schedule) {
                    $isDeleteScheduleLog = $this->App_model->delete('order_schedule_status_log', $schedule['id']);
                }

                $isDeleteSchedule = $this->App_model->delete('order_schedules', $scheduleId);  
                if ($isDeleteSchedule){
                    $scheduleCount++;
                }
            }

            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('message',' '.$scheduleCount.' schedule has been successfully deleted.');
            echo true;exit;   
        }
     
    }

    function destroy_session_filter(){
		unset($_SESSION['sessionIdFilter']);
		echo 1;
	}

    function destroySessionFilter(){
        if($this->session->userdata('billingsSessionFilter')){
			$this->session->unset_userdata('billingsSessionFilter');
		}
        echo 1;
    }
	function change_presenter(){
        $presenter_id = $this->input->post('presenter_id');
        $schedule_id = $this->input->post('schedule_id');
        $order_id = $this->input->post('order_id');
        $get_schedule_details = $this->App_model->get_schedule_details_specific($schedule_id);
        // check if schedule is confirmed
        if($get_schedule_details->status == 'Hours scheduled' || $get_schedule_details->status == 'Draft attached' || $get_schedule_details->status == 'Approved'){
            //check if presenter is available
            $checkSchedule = $this->App_model->check_schedule_datetime($presenter_id,$get_schedule_details->start_date,  $get_schedule_details->end_date);
            // print_r($checkSchedule); 
            
            //checking for same billing period
            $checkBilngSubmtd = $this->App_model->check_is_same_billing_submitted($order_id, $presenter_id, $get_schedule_details->start_date,  $get_schedule_details->end_date);

            if(!empty($checkSchedule)){
                //blocking from scheduling
                // echo 5;
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', '<strong>Oops...</strong> The selected presenter is already booked for this scheduled period.');
                echo false;exit;
            }else if($checkBilngSubmtd == true){
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', '<strong>Oops...</strong> The selected presenter has already submitted the invoice for this scheduled period.');
                echo false;exit;
            }else{
                // check presenter is assigned or not
                $orderAssignedPresenters = $this->App_model->get_order_assigned_presenters($order_id,$presenter_id);
                if(!empty($orderAssignedPresenters)){ // assigned
                    //check if the schedule hours is less than equal to assigned hours or not.
                    if(round($get_schedule_details->total_hours) <= $orderAssignedPresenters[0]->assigned_hours){
                        // minus and plus the hours of old and new presenters in order_assigned_presenters.
                        // add hrs to new presenters
                        $data['assigned_hours'] = $orderAssignedPresenters[0]->assigned_hours + $get_schedule_details->total_hours;
                        // update schedules with new presenter id.
                        $update_new_assignedhrs_presenter = $this->App_model->update_assignedhrs_presenter('order_assigned_presenters',$order_id,$presenter_id, $data);
                        // minus hrs from old presenter.

                        $getdetailsOldPre = $this->App_model->get_order_assigned_presenters($order_id,$get_schedule_details->created_by);

                        $data2['assigned_hours'] = $getdetailsOldPre[0]->assigned_hours - $get_schedule_details->total_hours;
                        // update schedules with old presenter id.
                        $update_new_assignedhrs_presenter1 = $this->App_model->update_assignedhrs_presenter('order_assigned_presenters',$order_id,$get_schedule_details->created_by, $data2);
                        // if assigned hours is get zero then delete the record.
                        $getNewAssignedPresenterAfterUpdate = $this->App_model->get_order_assigned_presenters($order_id,$get_schedule_details->created_by);
                        if($getNewAssignedPresenterAfterUpdate[0]->assigned_hours == 0){
                            $this->App_model->delete('order_assigned_presenters',$getNewAssignedPresenterAfterUpdate[0]->id);
                        }
                        
                        // update new presenter id in order_schedules table.
                        $data3['created_by'] = $presenter_id;
                        $changedPresenter = $this->App_model->update('order_schedules','id',$schedule_id, $data3);
                        if($changedPresenter){
                            // echo 2;
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('message', '<strong>Well done!</strong> The presenter has been successfully changed.');
                            echo false;exit;
                        }else{
                            echo 0;
                        }

                    }else{
                        echo 0;
                    }
                }else{ // not assigned
                    // get details of old order assigned presenter
                    $getOldAssignedPresenter = $this->App_model->get_order_assigned_presenters($order_id,$get_schedule_details->created_by);
                    // update: by minus hours from old presenter.
                    $olddata['assigned_hours'] = $getOldAssignedPresenter[0]->assigned_hours - $get_schedule_details->total_hours;
                    $this->App_model->update_assignedhrs_presenter('order_assigned_presenters',$order_id,$get_schedule_details->created_by, $olddata);
                    // if assigned hours is get zero then delete the record.
                    $getOldAssignedPresenterAfterUpdate = $this->App_model->get_order_assigned_presenters($order_id,$get_schedule_details->created_by);
                    if($getOldAssignedPresenterAfterUpdate[0]->assigned_hours == 0){
                        $this->App_model->delete('order_assigned_presenters',$getOldAssignedPresenterAfterUpdate[0]->id);
                    }
                
                    // assign hours with that scheduled hours to orders assigned presenter
                    $oAPdata['order_id'] = $order_id;
                    $oAPdata['presenter_id'] = $presenter_id;
                    $oAPdata['assigned_hours'] = $get_schedule_details->total_hours;
                    $this->App_model->insert('order_assigned_presenters',$oAPdata);
                    // update new presenter id in order_schedules table.
                    $odrSchdldata['created_by'] = $presenter_id;
                    $changedPresenter = $this->App_model->update('order_schedules','id',$schedule_id, $odrSchdldata);
                    if($changedPresenter){
                        // echo 2;
                        $this->session->set_flashdata('message_type', 'success');
                        $this->session->set_flashdata('message', '<strong>Well done!</strong> The presenter has been successfully changed.');
                        echo false;exit;
                    }else{
                        echo 0;
                    }
                }

            }
        }else{
            // echo 6;
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message', ' <strong>Oops...</strong> The presenter cannot be changed for a confirmed session.');
            echo false;exit;
        }
    }

    function assign_hours_specific(){
        $presenter_id = $this->input->post('presenter_id');
        $order_id = $this->input->post('order_id');
        $assign_hours = $this->input->post('assign_hours');
        $grade = $this->input->post('grade');
        

        $data['order_details'] 		= $this->App_model->get_specific_order($order_id);
        $data['alloted_hours']		= $data['order_details']['hours'];

        $total_hours_assigned_by_order = $this->App_model->get_total_hours_assigned_by_order($order_id,$presenter_id);
        $remainning_hours = $data['alloted_hours'] - $total_hours_assigned_by_order;
        


        
            $posted_hours	= 0;
            $check_one_hr	= 0;

           
                $rest_hours = $remainning_hours - $assign_hours;
         
                    if($rest_hours == 1)
                    {
                       
                        $hours_input[] 	= $assign_hours;
                        
                        $posted_hours 	= $posted_hours + $assign_hours;   					
                    }
                    else
                    {
                        if($assign_hours >= 2)
                        {
                            $hours_input[] 	= $assign_hours;
                            $posted_hours 	= $posted_hours + $assign_hours;    						
                        }
                        else
                        {
                            $check_one_hr = 1;
                        }
                    }


            if($check_one_hr)
            {
                // $check_one_hr = 0;
                // echo 5;
                // exit;
                $check_one_hr = 0;
                $assigndetailsForOneHour = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
                if($assigndetailsForOneHour == false){
                    echo 13;
                    exit;
                }else{
                    $assigndetailsForOneHour->assignForOneHour = 5;
                    $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($assigndetailsForOneHour));
                    return;
                }
            }
            else
            {
                    
                if($posted_hours > $remainning_hours) 
                {
                    $assigndetailsIfExists = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
                    if($assigndetailsIfExists == false){
                        echo 6;   
                        exit;
                    }else{
                        $assigndetailsIfExists->assigndetailsOfExists = 12;
                        $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($assigndetailsIfExists));
                        return;
                    }
                    // echo 6;   
                    // exit;			
                }

                $errMsg = '';
                $assign_data = array();

                    $gradeId = '';
                    if(!empty($grade)){
                        foreach($grade as $grade_val){
                            if($gradeId == ''){
                                $gradeId .= $grade_val;
                            }
                            else{
                                $gradeId .= ','.$grade_val;
                            }
                        }
                    }

                     
                    $scheduledHrs = $this->App_model->get_utilized_hours_presenter($order_id, $presenter_id);
                    // echo "<pre>";print_r($scheduledHrs); die;
                    if($scheduledHrs > $assign_hours){
                        $presenterName= $this->App_model->get_presenter_name($presenter_id);
                      
                        $presenter_grade_ids = $this->App_model->get_presenter_grade_ids($order_id,$presenter_id);
                   
                        $presenterName->presenter_name = $presenterName->first_name.''.$presenterName->last_name;
                        $presenterName->schedule_hours = round($scheduledHrs);
                        $presenterName->toCheckScheduleHours = 11;
                        $presenterName->gradeIds = $presenter_grade_ids;

                        $errMsg = $presenterName;
                    }

                  

                if(!empty($errMsg)){    
                        $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($errMsg));
                        return;
                   
                   
                }else{
                    $delete_prev_presntrOdr = $this->App_model->delete_prev_presntrOdr($order_id, $presenter_id);
                    $assign_data['presenter_id'] =$presenter_id;
                    $assign_data['order_id'] =$order_id;
                    $assign_data['assigned_hours'] =$assign_hours;
                    // $assign_data['grade_id'] =$gradeId;
                    if($gradeId == NULL){
                        $assign_data['grade_id'] ='';
                    }else{
                        $assign_data['grade_id'] =$gradeId;
                    }
                    $assigndetails = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
                    
                    if($assigndetails == FALSE){
                        $this->App_model->insert('order_assigned_presenters', $assign_data);
                    }else{
                        $this->App_model->update('order_assigned_presenters', 'id', $assigndetails->id, $assign_data);
                    }


                    $assigndetails1 = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
                    // echo '<pre>'; print_r($assigndetails1); 
                    
                    $assigndetails1->tocheckExistence = 10;
                    $get_assignment_details		= $this->App_model->get_specific_assignment($order_id);
                    $assigndetails1->used_hours = $get_assignment_details['total_used_hours'];
                    // echo '<pre>'; print_r($assigndetails1); die;
                    // send mail to kate with Order No., Work Plan No., School, Presenter, Title, Total hrs assigned, Order /date
                    $odrDtls = $this->App_model->get_order_details_by_orderId($order_id);
                    //presenter name
                    $presenterName= $this->App_model->get_presenter_name($presenter_id);
                    // print_r($presenterName); die;
                    $odrDtls->presenter_name = $presenterName->first_name.''.$presenterName->last_name;
                    //school name
                    $schlname = $this->App_model->get_school_name($odrDtls->school_id);
                    $odrDtls->school_name = $schlname->meta_value;
                    //title name
                    $titlename = $this->App_model->get_title_name($odrDtls->title_id);
                    $odrDtls->title_name = $titlename->name;
                    // echo '<pre>'; print_r($odrDtls); die;

                    // Send notification on Site admin

                    $msg ="An order has been assigned, please check the details below.<br/><br/>";
                    $msg .= "<p><b>Order Number:</b> ".$odrDtls->order_no."<br/><b>Work Plan Number:</b> ".$odrDtls->work_plan_number."<br/><b>Presenter Name:</b> ".$odrDtls->presenter_name."<br/><b>School name:</b> ".$odrDtls->school_name."<br/><b>Title:</b> ".$odrDtls->title_name."<br/><b>Total hours assigned:</b> ".$assigndetails1->assigned_hours."<br/><b>Order Date:</b> ".$odrDtls->booking_date."</p>";

                    $this->load->library('mail_template');
                    // $this->mail_template->notification_email('Kate', '', $msg, NULL);
                    $this->mail_template->notification_email('Brienza', 'brienzaportalstaging@gmail.com', $msg, NULL);
                    // $this->mail_template->notification_email('Brienza', 'gs.avalgate@gmail.com', $msg, NULL);


                    if(!empty($assigndetails1)){
                        $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($assigndetails1));
                        return;
                    }else{
                        echo 9;
                        exit;
                    }

                }
            }
    }

    public function assign_hours_filters(){

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
            $url = "https://";   
        }else{
            $url = "http://";  
        } 
                 
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        
        // Append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];
        $url_array = explode('/',$url);   
        $orderid = $url_array[6];
        $presenter = $url_array[7];
        
        $url = "app/orders/assign_hours/".$orderid;

        $presenter = urlencode($presenter);
        if ($presenter != '' && $presenter != '~') {
            $url .= "/presenter/". $presenter."/";
        }

        redirect($url);  
    }

    public function check_is_assigned(){
        $presenter_id = $this->input->post('presenter_id');
        $order_id = $this->input->post('order_id');
        $assigndetailsAfterUnassign = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
        if($assigndetailsAfterUnassign == false){
            echo 20;
            exit;
        }else{
            //delete hrs
            $delete_presntrOdr = $this->App_model->delete_prev_presntrOdr($order_id, $presenter_id);
            $get_assignment_details		= $this->App_model->get_specific_assignment($order_id);
            // print_r($get_assignment_details); die;
            if($get_assignment_details['total_used_hours'] == ''){
                $assigndetailsAfterUnassign->used_hours = 0;
            }else{
                $assigndetailsAfterUnassign->used_hours = $get_assignment_details['total_used_hours'];
            }
            $assigndetailsAfterUnassign->unassignHrs = 21;
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($assigndetailsAfterUnassign));
            return;
            // echo 21;
            // exit;
        }
    }

    public function get_hrs(){
        $presenter_id = $this->input->post('presenter_id');
        $order_id = $this->input->post('order_id');
        $assigndetails = $this->App_model->get_assigned_hurs_specific($presenter_id, $order_id);
        if($assigndetails == false){
            echo 22;
            exit;
        }else{
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($assigndetails));
            return;
        }
    }
}
