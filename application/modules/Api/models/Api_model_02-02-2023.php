<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api_model extends CI_Model{
  	function __construct(){
      parent::__construct();
      
  	}

    function validate($email, $password) {
        // echo 'aabb'; die;
        $this->db->select('users.id,users.role_id');
        $this->db->from('users');
        // $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.email', $email);
        $this->db->where('users.password', $password);
		$this->db->where('role_id', '3');
        $this->db->where('users.status', 1);
        $this->db->where('users.is_deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            // echo 'user_pw:<pre>';print_r($query->row());echo '</pre>';die;
            return $query->row();
        } else {
            return false;
        }
    }

    function update($field_name, $field_value, $data) {

		$this->db->where($field_name, $field_value);
		if ($this->db->update('users', $data)) {
			return true;
		} else {
			return false;
		}
	}

    public function is_valid_data($table_name, $search = NULL) {

		$this->db->select('*');
		$this->db->from($table_name);

		if ($search !== NULL) {
			foreach ($search as $field => $match) {
				$this->db->like($field, $match);
			}
		}
    	$this->db->limit(1);

   		$query = $this->db->get();

   		if($query->num_rows() == 1)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return false;
   		}
	}

    public function save_password_log($data) {

		if ($this->db->insert('user_password_log', $data)) {
			return true;
		} else {
			return false;
		}
	}

    public function checkid($id){
		$this->db->select('users.first_name, users.last_name, users.email, users.created_on, users.updated_on, users.created_by, users.updated_by, users.last_login, roles.role_name');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('users.id', $id);
		$this->db->where('users.role_id', '3');
		$this->db->where('users.status', 1);
		$this->db->where('users.is_deleted', 0);
		$query = $this->db->get();
		// echo $this->db->last_query(); die;

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function user_metaDetails($id){
		$this->db->select('*');
		$this->db->from('user_meta');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$user_meta = $query->result();
			return $user_meta;
		}else{
			return false;
		}
	}

	public function get_user_name_from_users($id){
		$this->db->select('CONCAT(users.first_name, " ", users.last_name) as user_name');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		// echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			$users = $query->row();
			// print_r($user_meta); die;
			return $users->user_name;
		}else{
			return false;
		}
	}

	function replace_user_meta($user_id, $meta = array()) {

		$user_id = (int) $user_id;
		if ($user_id <= 0) {
			return false;
		}
		if (empty($meta)) {
			return false;
		}

		// First Delete
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_meta');

		foreach($meta as $meta_key => $meta_value) {
			if($meta_key == 'phone')
	    		$data = array(
							'user_id' 		=> $user_id,
						    'meta_key'  	=> $meta_key,
						    'meta_value'  	=> $meta_value
						);
			else	
	    		$data = array(
							'user_id' 		=> $user_id,
						    'meta_key'  	=> $meta_key,
						    'meta_value'  	=> htmlspecialchars($meta_value, ENT_QUOTES, 'utf-8')
						);
			$this->db->insert('user_meta', $data);
    	}
    	return;
	}

	public function get_role_id($user_id){
		$this->db->select('role_id');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$users = $query->row();
			return $users->role_id;
		}else{
			return false;
		}
	}

	public function is_exists_presenter($presenter_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $presenter_id);
		$this->db->where('role_id', '3');
		$this->db->where('users.status', 1);
        $this->db->where('users.is_deleted', 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$users = $query->row();
			return true;
		}else{
			return false;
		}
	}

	// code starts for orders
	public function get_teacher_dashboard($pre_id)
	{
		try {

			$result = array();
			$this->db->select('count(order_assigned_presenters.id) as total_order');
			$this->db->from('order_assigned_presenters');
			$this->db->where('order_assigned_presenters.presenter_id', $pre_id);

			$result['total_order'] = $this->db->count_all_results();
			
			// Total "Ready to invoice"
			$this->db->select('SUM(order_schedules.total_hours) as total');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Create invoice');
			$this->db->where('order_schedules.created_by', $pre_id);
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			//$result['total_invoice'] = $this->db->count_all_results();
			if ($query->row()->total)
				$result['total_invoice'] = $query->row()->total;
			else
				$result['total_invoice'] = 0;
			// Total "Hours to confirm"
			/* $this->db->select('sum(order_schedules.total_hours) as total');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Confirm hours');
			$this->db->where('orders.presenter_id', $pre_id);
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			if ($query->row()->total)
				$result['total_hours'] = $query->row()->total;
			else
				$result['total_hours'] = 0; */
			// Total "Hours to confirm" new implementation 17-09-2021

            $this->db->select('order_id');
            $this->db->from('order_assigned_presenters');
			$this->db->join('orders', "orders.id = order_assigned_presenters.order_id");
			$this->db->where('orders.is_deleted', '0');
            $this->db->where('order_assigned_presenters.presenter_id', $pre_id);
            $query2 = $this->db->get();
            if ($query2->num_rows()>0){
                $res2 = $query2->result();
                $order_ids = array();
                foreach ($res2 as $order_id) {
                    $order_ids[] = $order_id->order_id;
                }
                $this->db->select('sum(assigned_hours) as total_assign_hrs');
                $this->db->from('order_assigned_presenters');
                $this->db->where('presenter_id', $pre_id);
                $query1 = $this->db->get();
                $res1 = $query1->row();
                $total_assigned_hours = $res1->total_assign_hrs;

                $this->db->select('sum(total_hours) as total_confirm_hr');
                $this->db->from('order_schedules');
                $this->db->where('created_by', $pre_id);
                $this->db->where_in('order_id', $order_ids);
                $this->db->where('status', 'Approved');
				$this->db->where('DATE_FORMAT(order_schedules.end_date, "%Y-%m-%d %H:%i") <=', date('Y-m-d H:i:s'));
                $query3 = $this->db->get();
                $res3 = $query3->row();
                $confirm_hours = $res3->total_confirm_hr;

				$result['total_hours'] = $confirm_hours;


            }else{
                $result['total_hours'] = 0;
            }
            // end Total "Hours to confirm"
			// Total Inbox
			$this->db->select('notifications.id, notifications.created_on');
			$this->db->from('notifications');
			$this->db->join('notification_users', "notifications.id = notification_users.notification_id");
			$this->db->where('notifications.is_deleted', '0');
			$this->db->where('notification_users.user_id', $pre_id);
			$this->db->where('notification_users.status', 'unread');
			$query = $this->db->get()->result_array();

			$counter = 0;
			$newMsg = 0;
			foreach ($query as $k => $v) {
				$counter++;
				if(strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', strtotime($v['created_on'])))){
					$newMsg++;
				}
			}
			$result['total_notification'] = $counter;
			$result['new_msg'] = $newMsg;
			

			///santanu coding
			$this->db->select('sum(order_schedules.total_hours) as total');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Approved');
			$this->db->where('orders.presenter_id', $pre_id);
			$query = $this->db->get();

			
			if ($query->row()->total)
				$result['new_hours'] = 1;
			else
				$result['new_hours'] = 0;

			// Total "Ready to invoice new"
			$this->db->select('*');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Create invoice');
			$this->db->where('order_schedules.created_by', $pre_id);
			$query = $this->db->get();
			$result['new_invoice'] = $query->num_rows();

			$this->db->select('*');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Approved');
			$this->db->where('DATE_FORMAT(order_schedules.end_date, "%Y-%m-%d %H:%i") <=', date('Y-m-d H:i:s'));
			$this->db->where('order_schedules.created_by', $pre_id);
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			$result['new_count'] = $query->num_rows();
			
			//New order calculation
			
			// Total "Hours to confirm"
			$this->db->select('*');
			$this->db->from('order_assigned_presenters');
			$this->db->join('orders', "orders.id = order_assigned_presenters.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('orders.status', 'approved');
			$this->db->where('order_assigned_presenters.presenter_id', $pre_id);
			$totOrder = $this->db->get();
			$totOrdCnt = $totOrder->num_rows();
			
			$this->db->select('order_schedules.*');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.created_by', $pre_id);
			$this->db->group_by('order_schedules.order_id');
			$orderQuery = $this->db->get();
			$order_schedule_count = $orderQuery->num_rows();
			$result['new_order'] = $totOrdCnt - $order_schedule_count;
			$result['tot_order'] = $totOrdCnt;
			
			return $result;
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();die;
		}
	}

	public function get_status_createInvoice_sessionwise_dashboard($presenter_id){
        $this->load->model('../../App/models/App_model');
        $data['billing'] = false;
        // $presenter_id = $this->session->userdata('id');

        $current_date = date("Y-m-d");
        // getting order_ids by presenters
        $ordersByPresenter = $this->App_model->get_orders_by_presenters($presenter_id);
        // echo '<pre>'; print_r($ordersByPresenter); die();
        // forming session dates array
        $orderArray = array();
        $dates = array();
        foreach($ordersByPresenter as $row){
            $dates = $this->App_model->get_orderSchedules_by_order_id($row->order_id);
            // echo '<pre>'; print_r($dates); die();
            $orderArray[$row->order_id] = array();
            foreach($dates as $dt){
                // array_push($orderArray[$row->order_id],$dt->date.'-01');
                // array_push($orderArray[$row->order_id],$dt->date.'-16');
                array_push($orderArray[$row->order_id],$dt->date.'-16');
                array_push($orderArray[$row->order_id],$dt->date.'-01');
            }
        }
        // echo '<pre>'; print_r($dates); die();
        // echo '<pre>'; print_r($orderArray); die();
        // $finalArray = array();
        $submitInvoiceCounter = 0;
		$totalhours = 0;
        foreach($orderArray as $key => $value){
            foreach($value as $val){
                // echo $val; 
                $flag = date("d", strtotime($val)) == '01' ? 1 : 2;
                $statusCreateInvoice = $this->App_model->get_status_createInvoice($key, $presenter_id, $val, $flag);
                // counting total on of records within session dates.
                $no_of_rows = $this->App_model->no_of_rows($key, $presenter_id, $val, $flag);
                // condition to check if submit invoice button be enable or disable.
                if($statusCreateInvoice > 0 && $no_of_rows > 0){
                    if($statusCreateInvoice == $no_of_rows){
                        $submitInvoiceCounter++;
						$totalhoursinvoice = $this->App_model->total_hours_ready_to_invoice_dashboard($key, $presenter_id, $val, $flag);
						$totalhours = $totalhours + $totalhoursinvoice;
                    }
                }
                
            }
        }
        return array($submitInvoiceCounter,$totalhours); 
        //die();
    }

	public function update_user_meta($user_id, $meta) {

        $user_id = (int) $user_id;
        if ($user_id <= 0) {
            return false;
        }
        if (empty($meta)) {
            return false;
        }

        foreach($meta as $meta_key => $meta_value) {
			// echo $meta_key;
			// echo $meta_value;
			if($meta_key == 'profile_pic'){
				$meta_pic = $this->get_meta_pic($user_id);
				if($meta_pic != false){
					$pic_value = $meta_pic->meta_value;
					$data = array(
						//'user_id' => $user_id,
						'meta_key'  => $meta_key,
						// 'meta_value'  => htmlspecialchars($meta_value, ENT_QUOTES, 'utf-8')
						'meta_value'  => $meta_value
					);
					$this->db->where('user_id', $user_id);
					$this->db->where('meta_key', $meta_key);
					$this->db->update('user_meta', $data);
				}else{
					$data = array(
						'user_id'  => $user_id,
						'meta_key'  => $meta_key,
						'meta_value'  => $meta_value
					);
					$this->db->insert('user_meta', $data);
				}
			}else{
				$data = array(
					//'user_id' => $user_id,
					'meta_key'  => $meta_key,
					// 'meta_value'  => htmlspecialchars($meta_value, ENT_QUOTES, 'utf-8')
					'meta_value'  => $meta_value
				);
				$this->db->where('user_id', $user_id);
				$this->db->where('meta_key', $meta_key);
				$this->db->update('user_meta', $data);
			}
        }
		// die;
        return;
    }

	public function get_meta_pic($user_id){
		$this->db->select('meta_value');
        $this->db->from('user_meta');
        // $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('meta_key', 'profile_pic');
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
	}

	public function get_presenter_details($presenter_id){
		$this->db->select('users.first_name, users.last_name, user_meta.meta_value as profilepic');
		$this->db->from('users');
		$this->db->join('user_meta', 'users.id = user_meta.user_id AND user_meta.meta_key = \'profile_pic\'');
		$this->db->where('users.id', $presenter_id);
		$this->db->where('user_meta.user_id', $presenter_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$users = $query->row();
			return $users;
		}else{
			return false;
		}
	}

	public function get_presenter_name($presenter_id){
		$this->db->select('first_name,last_name');
        $this->db->from('users');
        // $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('id', $presenter_id);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            return $query->row();
        }else {
            return false;
        }
	}

	public function get_presenter_profilepic($presenter_id){
		$this->db->select('meta_value as profile_pic');
        $this->db->from('user_meta');
        // $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('user_id', $presenter_id);
		$this->db->where('meta_key', 'profile_pic');
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            return $query->row();
        }else {
            return false;
        }
	}

	public function get_all_school_by_presenter_api($filter = array(), $order = null, $dir = null) {
        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $filter['presenter_id']);
        $query1 = $this->db->get();
		if($query1->num_rows() > 0) {
			$final_orders = $query1->result();
			$final_order_ids=array();
			foreach($final_orders as $final_orders_id){
				$final_order_ids[] = $final_orders_id->order_id;
			}
			// echo $this->db->last_query();die;
			// echo '<pre>'; print_r($final_order_ids); die();

			$this->db->select('orders.school_id, user_meta.meta_value as school_name');
			$this->db->from('orders');
			$this->db->join('user_meta', 'orders.school_id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
			// $this->db->join('users AS schools', 'orders.school_id = schools.id');
			$this->db->where_in('orders.id', $final_order_ids);
			$this->db->where('orders.is_deleted', $filter['deleted']);
			// $this->db->where('schools.is_deleted', 0);
			$this->db->order_by('updated_on DESC');
			$this->db->group_by("orders.school_id");
			$query2 = $this->db->get();
			// $final_result = $query2->result();
			// echo $this->db->last_query();die;
			return $query2->result();
		}else {
            return false;
        }
    }

	public function get_order_list($filter = array(), $order = null, $dir = null) 
    {
        if(isset($filter['presenter']) && $filter['presenter'] !== "")
        {
           $this->db->select('order_id');
           $this->db->from('order_assigned_presenters');
           $this->db->where('presenter_id', $filter['presenter']);

           $query       = $this->db->get();
           $array       = $query->result_array(); 
           $order_ids   = array();

           if(!empty($array))
            {
               foreach ($array as $key => $value) 
                {
                   # code...
                   $order_ids[] = $value['order_id']; 
                }
            }
            else
            {
                $order_ids = NULL;
            }
        }

        $this->db->select('orders.id, orders.order_no');
        $this->db->from('orders');

       

        if (isset($filter['order_start_date']) && $filter['order_start_date'] !== "") {
            $booking_start_date = str_replace('~', '/', $filter['order_start_date']);
            $booking_start_date = $this->format_date($booking_start_date);
                
            $this->db->where('orders.booking_date >=', $booking_start_date);
        }
        
        if (isset($filter['order_end_date']) && $filter['order_end_date'] !== "") {
            $booking_end_date = str_replace('~', '/', $filter['order_end_date']);
            $booking_end_date = $this->format_date($booking_end_date);
            
            $this->db->where('orders.booking_date <=', $booking_end_date);
        }
        
        if (isset($filter['order_no']) && $filter['order_no'] !== "") {
            $this->db->like('orders.order_no', $filter['order_no'], 'after');
        }
        // $this->db->where('schools.is_deleted', 0); 
        if (isset($filter['school']) && $filter['school'] !== "") {
            $this->db->where('orders.school_id', $filter['school']);
           }
        
        // This part has been added on 11-06-2019 for coordinatrs ...   
        if (isset($filter['coordinator']) && $filter['coordinator'] !== "") {
            $this->db->where('orders.coordinator_id', $filter['coordinator']);
        }          
        
        if (isset($filter['status']) && $filter['status'] !== "") {
            $this->db->where('orders.status', $filter['status']);
        }
        
        if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('orders.is_deleted', $filter['deleted']);
        }

        if (isset($filter['billing_date']) && $filter['billing_date'] !== "") {
            $this->db->where('order_schedules.end_date <', $filter['billing_date']);
        }

        if(isset($filter['presenter']) && $filter['presenter'] !== "")
        {
            if(!empty($order_ids))
                $this->db->where_in('orders.id', $order_ids);
            else
                $this->db->where('orders.id', 0);
        }

        if ($order <> null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('updated_on DESC');
        }

        $this->db->group_by("orders.id");

        $query = $this->db->get();
		// echo $this->db->last_query(); die;

        return $query->result();
    }

	function get_order_schedules($order_id=null, $presenter_id=null, $group_by='') {
		
		$order_id = (int) $order_id;
		
		$this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate');
		$this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
		$this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
		$this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
		$this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
		$this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
		$this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

		if ($order_id <> null) {
			$this->db->where('order_schedules.order_id', $order_id);
		}
		if ($presenter_id <> null) {
			$this->db->where('order_schedules.created_by', $presenter_id);
		}
		if($group_by != ''){
			$this->db->group_by($group_by);
		}
        
		$this->db->order_by('order_schedules.start_date ASC');
		
		$query = $this->db->get();
        $record = $query->result();
        return $record;
	}

	function get_selected_topics($title_id, $order_id) {
        $title_id = (int) $title_id;

        $this->db->from('order_topics');
        $this->db->where('order_id', $order_id);
        $query1 = $this->db->get();
        $selctd_res = $query1->result();

        $this->db->from('title_topics');
        $this->db->where('title_id', $title_id);

        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $key => $value) {
            foreach($selctd_res as $k => $val){
                if($val->topic_id == $key){
                    $data[] = $value;
                }
            }
        }
        return $data;
    }

	function get_order_details_by_order($id) {
        // echo $id; 
        // echo $presenter_id;
        // die;
        $id = (int) $id;
        $this->db->select('orders.*, user_meta.meta_value as school_name, p_company.meta_value as company_name, p_phone.meta_value as presenter_phone, p_address.meta_value as presenter_address, p_rate.meta_value as hourly_rate,SUM(order_schedules_hours.total_hours) as total_hours_scheduled, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, titles.name as title_name, schools.first_name as principle_name, CONCAT(presenters.first_name, " ", presenters.last_name) as teacher_name, presenters.headerImg');
        $this->db->from('orders');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->join('order_assigned_presenters AS assigned_presenters', 'orders.id = assigned_presenters.order_id', 'left');

        $this->db->join('order_schedules AS order_schedules_hours', 'orders.id = order_schedules_hours.order_id', 'left');

        $this->db->join('users AS presenters', 'assigned_presenters.presenter_id = presenters.id', 'left');
        $this->db->join('user_meta AS p_company', 'assigned_presenters.presenter_id = p_company.user_id AND p_company.meta_key = \'company_name\'', 'left');
        $this->db->join('user_meta AS p_phone', 'assigned_presenters.presenter_id = p_phone.user_id AND p_phone.meta_key = \'phone\'', 'left');
        $this->db->join('user_meta AS p_rate', 'assigned_presenters.presenter_id = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('user_meta AS p_address', 'assigned_presenters.presenter_id = p_address.user_id AND p_address.meta_key = \'address\'', 'left'); //Update by Ahmed
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users as orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('titles', 'orders.title_id = titles.id', 'left');
        $this->db->where('orders.id', $id);

        // $this->db->where('order_schedules_hours.created_by', $presenter_id);
        $this->db->where('order_schedules_hours.order_id', $id);

        // $this->db->where('assigned_presenters.presenter_id', $presenter_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }

	public function get_total_hours_assigned_preseneter($order_id, $presenter_id){
        $this->db->select('assigned_hours');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows()>0) {
            $res = $query->row();
            return $res->assigned_hours;
        }else {
            return false;
        }
    }

	
 

}
?>