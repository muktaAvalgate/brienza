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
				if(isset($meta_pic)){
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



	
 

}
?>