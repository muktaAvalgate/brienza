<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_model extends CI_Model 
{
    protected $current_level, $level;

    /**
     * @param $tablename
     * @param $data
     */
    function insert($tablename, $data) {

    	if ($this->db->insert($tablename, $data)) {
    		return $this->db->insert_id();
    	} else {
    		return false;
    	}
    }
    // ---- End of the code ------ //


    /**
     * @param $field_name
     * @param $field_value
     * @param $data
     */
	function update($tablename, $field_name, $field_value, $data) 
	{
    	$this->db->where($field_name, $field_value);

    	if ($this->db->update($tablename, $data)) {
    		return true;
    	} else {
    		return false;
    	}
    }
    // ------- End of the code ---------- //


    /**
     * @param $tablename
     * @param $id
     */
	function delete($tablename, $id) {
    	$id = (int) $id;

    	if ($id) {
    		$this->db->where('id', $id);
    		if ($this->db->delete($tablename))
    			return true;
    		else
    			return false;
    	} else {
    		return false;
    	}
    }
    // --------- End of the code -----------//


    /**
	* Following method will be used 
	* to list down the payment schduels
	* of current month
	* Created on: 03-08-2019
	* Create by: Soumya
    */
    public function list_payment_schedules($filters = array())
    {
    	$this->db->select('pshedule_id, session_from, session_to, billing_date, payment_date, invoice_no, email_remonder_date, year, is_deleted');
    	$this->db->from('payment_schedule');
    	$this->db->where('is_deleted', 0);

    	if(!empty($filters['session_start_date']))
    		$this->db->where('session_from', date('Y-m-d', strtotime($filters['session_start_date'])));

    	if(!empty($filters['month']))
    		$this->db->where('month', $filters['month']);  
    		
    	if(!empty($filters['year']))
    		$this->db->where('year', $filters['year']);   
		$this->db->order_by('payment_schedule.pshedule_id DESC');
    	$query 	= $this->db->get();	 
    	//echo $this->db->last_query();

    	$object = $query->result();

    	if(!empty($object))
    		return $object; 
    	else
    		return array();
    }
    // ------------ End of the code ------------//


    /**
	* Following method will be used 
	* to add new payment schedule 
	* Created on: 03-08-2019
	* Created by: Soumya
    */
	public function add_payment_schedule()
	{

	}
    //------------ End of the code --------------//


    /**
	* Following method will be used 
	* to edit existing payment schedule 
	* Created on: 03-08-2019
	* Created by: Soumya
    */
	public function edit_payment_schedule()
	{
		
	}
    //------------ End of the code --------------//


    /**
	* Following method will be used 
	* to get details of payment schedule 
	* Created on: 03-08-2019
	* Created by: Soumya
    */
	public function getdetails_payment_schedule($id)
	{
    	$this->db->select('pshedule_id, session_from, session_to, billing_date, payment_date, invoice_no, email_remonder_date, year, is_deleted');
    	$this->db->from('payment_schedule');
    	$this->db->where('is_deleted', 0);
    	$this->db->where('pshedule_id', $id);

    	$query  = $this->db->get();
		$object = $query->row_array();

		if(!empty($object))
			return $object;
		else
			return false;
	}
    //------------ End of the code --------------//  

    /**
	* Following method will be used 
	* to show list of payable schedules 
	* Created on: 07-08-2019
	* Created by: Soumya
    */
	public function get_payable_schedules_old($payment_schedule_id)
	{
		// Get all the information about the payment schedule first ...
		$this->db->select('session_from, session_to, billing_date, payment_date');
		$this->db->from('payment_schedule');
		$this->db->where('pshedule_id', $payment_schedule_id);

		$get_pshedule_que = $this->db->get();
		$get_pshedule_arr = $get_pshedule_que->row_array();

		$start_date = date("Y-m-d H:i:s", strtotime($get_pshedule_arr['session_from']));
		$end_date	= date("Y-m-d H:i:s", strtotime($get_pshedule_arr['session_to']));

		// Get the list of schedules for which invoice has been generated
		$this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name, order_schedule_status_log.attachment, order_schedule_status_log.new_status, order_schedule_status_log.updated_on, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id, orders.school_id, user_meta.meta_value AS school_color');
		$this->db->from('order_schedules');
		$this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
		$this->db->join('grades', 'order_schedules.grade_id = grades.id');
		$this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
		$this->db->join('orders', 'order_schedules.order_id = orders.id');
		$this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
		$this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");
		
		$this->db->where('order_schedules.status', 			'Invoice created');
		$this->db->where('order_schedules.start_date >= ', 	$start_date);
		$this->db->where('order_schedules.start_date < ', 	$end_date);
		$this->db->where('order_schedules.end_date > ', 	$start_date);
		$this->db->where('order_schedules.end_date <= ', 	$end_date);

		$this->db->order_by('order_schedules.start_date ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$array = $query->result();
		//echo pr($array);
   		return 	$array;	
	}
	
	public function get_payable_schedules($payment_schedule_id)
	{
		//echo "<pre>";print_r($filter);die;
		// Get all the information about the payment schedule first ...
		$this->db->select('session_from, session_to, billing_date, payment_date');
		$this->db->from('payment_schedule');

		// if (isset($filter['payment_schedule_id']) && $filter['payment_schedule_id'] !== "") {
  //           $this->db->where('payment_schedule.pshedule_id', $filter['payment_schedule_id']);
  //       }
		$this->db->where('pshedule_id', $payment_schedule_id);

		$get_pshedule_que 	= $this->db->get();
		$get_pshedule_arr 	= $get_pshedule_que->row_array();
		$session_from 		= date("Y-m-d H:i:s", strtotime($get_pshedule_arr['session_from']));
		$session_to		= date("Y-m-d H:i:s", strtotime($get_pshedule_arr['session_to']));
		
		//echo $first_date_month; die();

		// Get the list of schedules for which invoice has been generated
		$this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name, order_schedule_status_log.attachment, order_schedule_status_log.new_status, order_schedule_status_log.updated_on, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,orders.order_no, orders.work_plan_number, orders.school_id, user_meta.meta_value AS school_color, school.meta_value AS school_name, CONCAT_WS(" ", presenter.first_name, presenter.last_name) AS persenter_name, presenter.email as presenter_email, p_phone.meta_value AS presenter_phone,presenter.id as presenter_id');
		$this->db->from('order_schedules');
		$this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
		$this->db->join('grades', 'order_schedules.grade_id = grades.id');
		$this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
		$this->db->join('orders', 'order_schedules.order_id = orders.id');
		$this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
		$this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");
		$this->db->join('user_meta as school', "school.user_id = orders.school_id AND school.meta_key = 'school_name'", "left outer");
		$this->db->join('order_assigned_presenters', 'order_assigned_presenters.order_id = orders.id', 'left');
		$this->db->join('users as presenter', 'presenter.id=order_assigned_presenters.presenter_id');
		$this->db->join('user_meta as p_phone', "p_phone.user_id = presenter.id AND p_phone.meta_key = 'phone'", "left outer");

		if (isset($filter['presenter']) && $filter['presenter'] !== "") {
            $this->db->where('presenter.id', $filter['presenter']);
   		}
		
		$this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') >= ", 	$get_pshedule_arr['session_from']);
		$this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') <= ", 	$get_pshedule_arr['session_to']);
		$where = " (order_schedules.status='Payment sent' OR order_schedules.status='Completed')";
		$this->db->where($where);

		

		$this->db->order_by('order_schedules.updated_on DESC');
		$this->db->group_by('order_schedules.id');
		$query = $this->db->get();
		 //echo $this->db->last_query();exit;
		$array = $query->result();
		//echo "<pre>";print_r($array);die;
   		return 	$array;	
	}	
	
    public function get_schedule_logs($order_schedule_id){
        $order_schedule_id = (int) $order_schedule_id;

            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
            $this->db->order_by('order_schedule_status_log.updated_on DESC');
            $res = $this->db->get()->result();
            return $res;
    }	
	public function get_last_payement_details(){
        $this->db->select("*");
        $this->db->from("payment_schedule");
        $this->db->limit(1);
        $this->db->order_by('pshedule_id',"DESC");
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
	public function get_payable_schedules_order($payment_schedule_id)
    {
        //get previous row data from payment schedule by given pid.
        $this->db->select('session_from, session_to, billing_date, payment_date');
        $this->db->from('payment_schedule');
        $this->db->where('pshedule_id <', $payment_schedule_id);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('pshedule_id','DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
        $billing_from_date      = date("Y-m-d H:i:s", strtotime($result->billing_date));



        //get data from payment schedule by given pid.
        $this->db->select('session_from, session_to, billing_date, payment_date');
        $this->db->from('payment_schedule');
        $this->db->where('pshedule_id', $payment_schedule_id);

        $get_pshedule_que   = $this->db->get();
        $get_pshedule_arr   = $get_pshedule_que->row_array();
        $billing_to_date        = date("Y-m-d H:i:s", strtotime($get_pshedule_arr['billing_date']));

        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('created_date >', $billing_from_date);
        $this->db->where('created_date <=', $billing_to_date);
        $query = $this->db->get();
        $billing_result = $query->result();
        // echo $this->db->last_query(); die();
        // echo '<pre>'; print_r($billing_result); die();
        
        return $billing_result;
        
        //echo $first_date_month; die();

        // Get the list of schedules for which invoice has been generated
        
    }
	public function get_payable_schedules_order_schedules($order_id, $session_from, $session_to){
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name, order_schedule_status_log.attachment, order_schedule_status_log.new_status, order_schedule_status_log.updated_on, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,orders.order_no, orders.work_plan_number, orders.school_id, user_meta.meta_value AS school_color, school.meta_value AS school_name, CONCAT_WS(" ", presenter.first_name, presenter.last_name) AS persenter_name, presenter.email as presenter_email, p_phone.meta_value AS presenter_phone,presenter.id as presenter_id');
        $this->db->from('order_schedules');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
        $this->db->join('orders', 'order_schedules.order_id = orders.id');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");
        $this->db->join('user_meta as school', "school.user_id = orders.school_id AND school.meta_key = 'school_name'", "left outer");
        $this->db->join('order_assigned_presenters', 'order_assigned_presenters.order_id = orders.id', 'left');
        $this->db->join('users as presenter', 'presenter.id=order_assigned_presenters.presenter_id');
        $this->db->join('user_meta as p_phone', "p_phone.user_id = presenter.id AND p_phone.meta_key = 'phone'", "left outer");
        $this->db->where('order_schedules.order_id', $order_id);
        $this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') >= ",  $session_from);
        $this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') <= ",  $session_to);
        
        //$where = " (order_schedules.status='Payment sent' OR order_schedules.status='Completed')";
		$where = " (order_schedules.status!='Hours Scheduled' OR order_schedules.status!='Draft attached' OR order_schedules.status!='Approved' OR order_schedules.status!='Confirm hours' OR order_schedules.status!='Create log' OR order_schedules.status!='Log sent - awaiting principal signature' OR order_schedules.status!='Awaiting Review' OR order_schedules.status!='Create invoice')";
        $this->db->where($where);

        

        $this->db->order_by('order_schedules.updated_on DESC');
        $this->db->group_by('order_schedules.id');
        $query = $this->db->get();
         //echo $this->db->last_query();exit;
        $array = $query->result();
        //echo "<pre>";print_r($array);die;
        return  $array; 
    }
	public function get_payable_schedules_order_schedules_new($order_schedule_ids, $session_to){
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name, order_schedule_status_log.attachment, order_schedule_status_log.new_status, order_schedule_status_log.updated_on, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,orders.order_no, orders.work_plan_number, orders.school_id, user_meta.meta_value AS school_color, school.meta_value AS school_name, CONCAT_WS(" ", presenter.first_name, presenter.last_name) AS persenter_name, presenter.email as presenter_email, p_phone.meta_value AS presenter_phone,presenter.id as presenter_id, titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
        $this->db->join('orders', 'order_schedules.order_id = orders.id');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");
        $this->db->join('user_meta as school', "school.user_id = orders.school_id AND school.meta_key = 'school_name'", "left outer");
        $this->db->join('order_assigned_presenters', 'order_assigned_presenters.order_id = orders.id', 'left');
        $this->db->join('users as presenter', 'presenter.id=order_assigned_presenters.presenter_id');
        $this->db->join('user_meta as p_phone', "p_phone.user_id = presenter.id AND p_phone.meta_key = 'phone'", "left outer");
		$this->db->join('titles', 'title_topics.title_id = titles.id'); // for public school
        // $this->db->where('order_schedules.order_id', $order_id);
		// $this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') >= ",     $session_from);
        // $this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') <= ",   $session_to);

		// $this->db->where('titles.public_school_title_status', 'unchecked'); // for public school
		$this->db->where('order_schedules.is_public_school', 'unchecked');  // 21-04-2023
		$this->db->where("DATE_FORMAT(order_schedules.start_date,'%Y-%m-%d') <= ",    $session_to);
        $this->db->where_in('order_schedules.id', $order_schedule_ids);
        
        // $where = " (order_schedules.status='Payment sent' OR order_schedules.status='Completed')";
        $where = " (order_schedules.status!='Hours Scheduled' OR order_schedules.status!='Draft attached' OR order_schedules.status!='Approved' OR order_schedules.status!='Confirm hours' OR order_schedules.status!='Create log' OR order_schedules.status!='Log sent - awaiting principal signature' OR order_schedules.status!='Awaiting Review' OR order_schedules.status!='Create invoice')";

        $this->db->where($where);

        

        $this->db->order_by('order_schedules.updated_on DESC');
        $this->db->group_by('order_schedules.id');
        $query = $this->db->get();
         //echo $this->db->last_query();exit;
        $array = $query->result();
        //echo "<pre>";print_r($array);die;
        return  $array; 
    }
    //------------ End of the code --------------//	
	 public function get_presenter_data($created_by){
        $this->db->select("users.*, user_meta.meta_value");
        $this->db->from("users");
        // $this->db->join('user_meta', );
        $this->db->where('users.id',$created_by);
        $this->db->join('user_meta', "user_meta.user_id = users.id AND user_meta.meta_key = 'phone'");
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

}