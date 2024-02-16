<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	protected $current_level, $level;

    /**
    * Validate the login's data with the database
    * @param string $email
    * @param string $password
    * @return void
    */
	function validate($email, $password) {

		$this->db->select('users.id, CONCAT(users.first_name, " ", users.last_name) AS name, users.email, users.last_login, roles.role_name, users.role_id, roles.role_token');
		$this->db->from('users');
   		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('users.email', $email);
		$this->db->where('users.password', $password);
		$this->db->where('users.status', 1);
		$this->db->where('users.is_deleted', 0);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}


	/**
	 * Get admin by his is
	 * @param string $fieldname
	 * @param int $field_value
	 * @return array
	 */
	public function get_user_by_id($id) {

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->row();
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


	/**
	 *
	 */
	function save_password_log($data) {

		if ($this->db->insert('user_password_log', $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update user
	 * @param array $data - associative array with data to store
	 * @return boolean
	 */
	function update($field_name, $field_value, $data) {

		$this->db->where($field_name, $field_value);
		if ($this->db->update('users', $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 */
	public function update_password_log($id, $data = array()) {

		$this->db->where('id', $id);
		if ($this->db->update('user_password_log', $data)) {
			return true;
		} else {
			return false;
		}
	}


	function check_password($id, $old_password) {

		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('id', $id);
		$this->db->where('password', $old_password);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return TRUE;
		} else {

			return FALSE;
		}
	}

	/**
	 *
	 * @param unknown_type $user_id
	 */
	function get_user_permissions($user_id) {

		$this->db->select('permissions.name');
		$this->db->from('permissions');
		$this->db->join('role_permissions', 'permissions.id = role_permissions.permission_id');
		$this->db->join('users', 'users.role_id = role_permissions.role_id');
		$this->db->where('users.id', $user_id);

		$query = $this->db->get();
		$result = array();

		foreach ($query->result() as $row) {
			$result[] = $row->name;
		}
		return $result;
	}

	/**
	 *
	 * @param unknown_type $user_id
	 */
	function get_user_pic($user_id) {

		$this->db->select('user_meta.meta_value');
		$this->db->from('user_meta');
		$this->db->where('user_meta.user_id', $user_id);
		$this->db->where('user_meta.meta_key', 'profile_pic');

		$query = $this->db->get();
		$row = $query->row();
		
		if (isset($row->meta_value)) {
			return $row->meta_value;
		} else {
			return;
		}
	}
	
	/**
	 *
	 * @param unknown_type $role_id
	 */
	public function get_menulink_by_role($role_id = 0)
	{
		$role_id = (int) $role_id;

		try {
			$this->db->select('menu_links.id, menu_links.parent_id, menu_links.title, menu_links.description, menu_links.url, menu_links.status, menu_links.weight');
			$this->db->from('menu_links');
			$this->db->join('menus', 'menus.id = menu_links.menu_id');
			$this->db->join('menu_roles', 'menu_roles.menu_id = menus.id');
			$this->db->where('menu_roles.role_id', $role_id);

			$this->db->where('menu_links.status', 'active');
			$this->db->where('menus.status', 'active');
			$this->db->order_by('weight ASC');

			$query = $this->db->get();

			return $query->result();
		}
        catch (Exception $ex) {
			echo $ex->getMessage(); die;
		}
	}


	/**
	 *
	 * @param $role_id
	 */
	public function get_main_menu($role_id = 0)
    {
        $table = array();
        $items = $this->get_menulink_by_role($role_id);

        foreach($items as $item){
            $table[$item->parent_id][$item->id] = array('title' => $item->title, 'description' => $item->description, 'url' => $item->url);
        }

        //print "<pre>"; print_r($table); print "</pre>";
        $output = $this->get_menu_branch(0, $table, 0, 0);

        // Close off nested lists
        for ($nest = 0; $nest <= $this->current_level-1; $nest++) {
            $output .= '</ul>';
        }
        return $output;
    }


	/**
	 *
	 * @param unknown_type $parent
	 * @param unknown_type $table
	 * @param unknown_type $level
	 * @param unknown_type $maxlevel
	 */
	protected function get_menu_branch($parent, $table, $level, $maxlevel)
	{
		$list = array();
		if (isset($table[$parent])) {
			$list = $table[$parent];
		}

		$output = "";
		while(list($id, $val) = each($list)){

			if ($this->current_level != $level) {

				if ($this->current_level < $level) {
						$output .= "\n".'<ul class="nav child_menu">';
				} else {
					for ($nest = 1; $nest <= ($this->current_level - $level); $nest++) {
						$output .= '</ul></li>'."\n";
					}
				}
				$this->current_level = $level;
			}

			if ($this->has_sub_menu($id)) {
				$hasSubMenu = true;
			} else {
				$hasSubMenu = false;
			}

			if ($hasSubMenu) {
				$output .= '<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ';
			} else {
				$output .= '<li><a href="'.base_url($val['url']).'" ';
			}

			$output .= 'title="'.$val['description'].'">'.$val['title'];

			if ($hasSubMenu) {
				//$output .= ' <span class="caret"></span></a>';
				$output .= '</a>';
			} else {
				$output .= '</a>';
			}

			$this->level++;

			if (!$hasSubMenu) {
				$output .= '</li>'."\n";
			}


			if ((isset($table[$id])) && (($maxlevel > $level + 1) || ($maxlevel == '0'))) {
				$output .= $this->get_menu_branch($id, $table, $level + 1, $maxlevel);
			}

		} // End while loop

		return $output;
	}


	/**
	 * Getting the child existance ..
	 * @param $id
	 */
	public function has_sub_menu($id)
	{
		$id = (int) $id;

		try {
			$this->db->select('id');
			$this->db->from('menu_links');
			$this->db->where('parent_id', $id);
			$query = $this->db->get();

   			if($query->num_rows() > 0) {
				return true;
   			} else {
				return false;
			}
		}
        catch (\Exception $ex) {
			echo $ex->getMessage();die;
		}
	}


	public function get_admin_dashboard()
	{
		try {

			$result = array();

			// Total Customers
			/*$this->db->where('is_deleted', 0);
			$this->db->from('customers');
			$result['total_customers'] = $this->db->count_all_results();

			// Total Rewards
			$this->db->where('is_deleted', 0);
			$this->db->from('rewards');
			$result['total_rewards'] = $this->db->count_all_results();

			// Total Bars
			$this->db->where('is_deleted', 0);
			$result['total_bars'] = $this->db->count_all_results('bars');

			// Total Users
			$result['total_users'] = $this->db->count_all_results('users');

			// Number of users per role
			$this->db->select('roles.id, roles.role_name, count(users.id) as total_users');
			$this->db->from('roles');
			$this->db->join('users', 'roles.id = users.role_id', 'LEFT OUTER');
			$this->db->group_by("roles.id");

			$query = $this->db->get();
			$result['role_users'] = $query->result();

			// Get pending rewards customers
			$this->db->select('customer_rewards.id, rewards.points as points, customer_rewards.status, CONCAT(customers.first_name, " ", customers.last_name) as customer_name, CONCAT(rewards_created.first_name, " ", rewards_created.last_name) as created_by_name');
			$this->db->from('customer_rewards');
			$this->db->join('rewards', "customer_rewards.reward_id = rewards.id");
			$this->db->join('customers', 'customer_rewards.customer_id = customers.id');
			$this->db->join('users AS rewards_created', 'customer_rewards.created_by = rewards_created.id', 'left');
			$this->db->where('customer_rewards.status', 0);
			//$this->db->group_by("customers.id");

			$query = $this->db->get();
			$result['pending_rewards'] = $query->result();

			// Get pending bar request
			$this->db->select('bar_requests.id, bar_requests.bar_id, bar_requests.user_id, bar_requests.status, bars.bar_name, CONCAT(users.first_name, " ", users.last_name) as user_name');
			$this->db->from('bar_requests');
			$this->db->join('bars', "bar_requests.bar_id = bars.id");
			$this->db->join('users', 'bar_requests.user_id = users.id');
			$this->db->where('bar_requests.status', 1);
			//$this->db->group_by("customers.id");

			$query = $this->db->get();
			$result['pending_requests'] = $query->result();*/

			return $result;
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();die;
		}
	}

	public function get_dashboard()
	{
		try {

			$result = array();
			$current_year 	= date("Y");
			$previous_year	= date("Y",strtotime("-1 year"));	

			// Total School
			$this->db->select('count(users.id) as total_school');
			$this->db->from('users');
			$this->db->where('users.is_deleted', '0');
			$this->db->where('users.role_id', '4');
			$result['total_school'] = $this->db->count_all_results();

			// Total presenter
			$this->db->select('count(users.id) as total_presenter');
			$this->db->from('users');
			$this->db->where('users.is_deleted', '0');
			$this->db->where('users.role_id', '3');
			$result['total_presenter'] = $this->db->count_all_results();

			// Total Coordinator implemented by: Soumya
			$this->db->select('count(users.id) as total_coordinator');
			$this->db->from('users');
			$this->db->where('users.is_deleted', '0');
			$this->db->where('users.id !=', '129');
			$this->db->where('users.role_id', '5');
			$result['total_coordinator'] = $this->db->count_all_results();
			//End of the section ...	

			// Total Remaining implemented by: Soumya
			$this->db->select('id, school_id, coordinator_id, title_id, hours, created_on');
			$this->db->from('orders');
			$this->db->where('is_deleted', 0);
			$this->db->where('status', 'approved');
			$this->db->like('created_on', $current_year, 'after');
			$this->db->or_like('created_on', $previous_year, 'after');

			$get_approved_orders_query = $this->db->get();
			$get_approved_orders_array = $get_approved_orders_query->result_array();

			$total_hours 		= 0;
			$total_used_hours 	= 0;

			foreach($get_approved_orders_array as $key=>$value)
			{
				$total_hours = $total_hours + $value['hours']; 

				$this->db->select('SUM(total_hours) AS used_hours');
				$this->db->from('order_schedules');
				$this->db->where('order_id', $value['id']);
				$this->db->where("(status != 'Approved' OR status != 'Confirm hours' OR status != 'Invoice created' OR status != 'Payment sent' OR status != 'Completed' OR status NOT LIKE 'Rejected%')");

				$get_used_hours_que = $this->db->get();
				$get_used_hours_arr = $get_used_hours_que->row_array();
				$total_used_hours 	= $total_used_hours + $get_used_hours_arr['used_hours'];
			}

			$remaining_hours 			= $total_hours - $total_used_hours;
			$result['remaining_hours'] 	= $remaining_hours;
			//End of the section ...


			// Total Remaining in terms of price implemented by: Soumya
			$this->db->select('id');
			$this->db->from('orders');
			$this->db->where('status', 'approved');
			$this->db->like('created_on', $current_year, 'after');
			$this->db->or_like('created_on', $previous_year, 'after');

			$get_approved_orders_query_1 = $this->db->get();
			$get_approved_orders_array_1 = $get_approved_orders_query_1->result_array();

			$remaining_price = 0;
			foreach($get_approved_orders_array_1 as $remaining_values)
			{
				## Get total assigned hours for a presenter ...
				$this->db->select('assigned_hours, presenter_id');
				$this->db->from('order_assigned_presenters');
				$this->db->where('order_id', 	$remaining_values['id']);

				$get_total_hours_que = $this->db->get();
				$get_total_hours_arr = $get_total_hours_que->result_array();	

				foreach($get_total_hours_arr as $presenter_id_values)
				{
					## Get total hours used by that presenter ...
					$this->db->select('SUM(total_hours) AS total_used_hours');
					$this->db->from('order_schedules');
					$this->db->where('created_by', 	$presenter_id_values['presenter_id']);
					$this->db->where('order_id', 	$remaining_values['id']);

					$get_used_hours_que = $this->db->get();
					//echo $this->db->last_query();
					$get_used_hours_arr = $get_used_hours_que->row_array();

					## Get rate for presenter 
					$this->db->select('meta_value');
					$this->db->from('user_meta');
					$this->db->where('user_id',  $presenter_id_values['presenter_id']);
					$this->db->where('meta_key', 'rate');

					$get_rate_que = $this->db->get();
					$get_rate_arr = $get_rate_que->row_array();

					## Get calculation of remaining prices
					$total_unsed_hours 	= ((int)$presenter_id_values['assigned_hours'] - (int)$get_used_hours_arr['total_used_hours']);
					$remaining_amount	= (int)($total_unsed_hours * $get_rate_arr['meta_value']);
					$remaining_price	= $remaining_price + $remaining_amount;
				}				
			}
			$result['remaining_price'] = $remaining_price;

			$this->db->select('ROUND(SUM(order_schedules.total_hours*user_meta.meta_value),2) AS total_billed_amount');
			$this->db->from('order_schedules');
			$this->db->join('user_meta', 'user_meta.user_id=order_schedules.created_by AND AND user_meta.meta_key = \'rate\'');
			$this->db->where('order_id', $remaining_values['id']);
			$this->db->where('status', 'completed');
			$this->db->or_where('status', 'Payment sent');

			$billed_amount = $this->db->get()->row_array();

			$result['billed_amount'] = $billed_amount['total_billed_amount'];
			#echo $billed_amount."<yes>";
			//End of the section ...
			
			// Total secured implemented by: Soumya ..
			$this->db->select('count(orders.id) as total_order');
			$this->db->from('orders');
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_no IS NOT NULL');
			$this->db->where('status', 'approved');

			$result['total_secured'] = $this->db->count_all_results();
			//End of the section ...


			// Total agenda hours secured implemented by: Soumya ..
			$agenda_schedule_date = $previous_year.'-09-01'; // added 10-01-2022
			$this->db->select('presenter_id,order_id');
			$this->db->from('order_assigned_presenters');

			$get_total_presenters_que = $this->db->get();
			$get_total_presenters_arr = $get_total_presenters_que->result_array();

			$total_agenda_hours = 0;
			foreach($get_total_presenters_arr as $presenter_values)
			{
				$this->db->select('SUM(total_hours) as total_agenda_hrs');
				$this->db->from('order_schedules');
				$this->db->where('created_by', $presenter_values['presenter_id']);
				$this->db->where('order_id', $presenter_values['order_id']);
				$this->db->where('status !=', 'Payment sent');
				$this->db->where('status !=', 'Completed');
				$this->db->where('order_schedules.status !=', "Rejected - don't want");
				// $this->db->like('created_on', $current_year, 'after');
				$this->db->where('created_on >=', $agenda_schedule_date); // added 10-01-2022

				$get_agenda_hours_que = $this->db->get();
				$get_agenda_hours_arr = $get_agenda_hours_que->row_array();

				$total_agenda_hours   = $total_agenda_hours + $get_agenda_hours_arr['total_agenda_hrs'];
			}
			$result['total_agenda_hours'] = $total_agenda_hours;
			//End of the section ...			

			// Total Teachers
			$this->db->select('count(teachers.id) as total_teacher');
			$this->db->from('teachers');
			$this->db->where('teachers.is_deleted', '0');
			$result['total_teacher'] = $this->db->count_all_results();
			
			// Total Category
			$this->db->select('count(titles.id) as total_category');
			$this->db->from('titles');
			$this->db->where('titles.is_deleted', '0');
			$result['total_title'] = $this->db->count_all_results();
			
			// Total Order
			$this->db->select('count(orders.id) as total_order');
			$this->db->from('orders');
			$this->db->where('orders.is_deleted', 0);
			$result['total_order'] = $this->db->count_all_results();
			
			// Total Order
			$this->db->select('notifications.id, notifications.created_on');
			$this->db->from('notifications');
			$this->db->join('notification_users', "notification_users.notification_id = notifications.id");
			$this->db->where('notifications.is_deleted', '0');
			$this->db->where('notifications.type', 'admin');
			$this->db->where('notifications.category', 'inbox');
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
			$result['total_inbox'] = $counter;
			$result['new_msg'] = $newMsg;
			
			// Total Goals
			$this->db->select('count(goals.id) as total_goal');
			$this->db->from('goals');
			$this->db->where('goals.is_deleted', '0');
			$result['total_goal'] = $this->db->count_all_results();

			// Total Reports Storage
			$this->db->select('count(reports_storage.id) as total_reports_storage');
			$this->db->from('reports_storage');
			$this->db->where('reports_storage.is_deleted', '0');
			$result['total_reports_storage'] = $this->db->count_all_results();
			
			return $result;
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();die;
		}
	}
	
	public function get_teacher_dashboard()
	{
		try {

			$result = array();

			// Total Order
			// $this->db->select('count(orders.id) as total_order');
			// $this->db->from('orders');
			// $this->db->where('orders.is_deleted', '0');
			// $this->db->where('orders.status', 'approved');
			// $this->db->where('orders.presenter_id', $this->session->userdata('id'));

			$this->db->select('count(order_assigned_presenters.id) as total_order');
			$this->db->from('order_assigned_presenters');
			$this->db->where('order_assigned_presenters.presenter_id', $this->session->userdata('id'));

			$result['total_order'] = $this->db->count_all_results();
			
			// Total "Ready to invoice"
			//$this->db->select('count(order_schedules.total_hours) as total');
			$this->db->select('SUM(order_schedules.total_hours) as total');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Create invoice');
			$this->db->where('order_schedules.created_by', $this->session->userdata('id'));
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
			$this->db->where('orders.presenter_id', $this->session->userdata('id'));
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
            $this->db->where('order_assigned_presenters.presenter_id', $this->session->userdata('id'));
            $query2 = $this->db->get();
            if ($query2->num_rows()>0){
                $res2 = $query2->result();
                // echo '<pre>'; print_r($res); die();
                $order_ids = array();
                foreach ($res2 as $order_id) {
                    $order_ids[] = $order_id->order_id;
                }
                $this->db->select('sum(assigned_hours) as total_assign_hrs');
                $this->db->from('order_assigned_presenters');
                $this->db->where('presenter_id', $this->session->userdata('id'));
                $query1 = $this->db->get();
                $res1 = $query1->row();
                $total_assigned_hours = $res1->total_assign_hrs;

                $this->db->select('sum(total_hours) as total_confirm_hr');
                $this->db->from('order_schedules');
                $this->db->where('created_by', $this->session->userdata('id'));
                $this->db->where_in('order_id', $order_ids);
                //$this->db->where('status !=', 'Hours scheduled');
                //$this->db->where('status !=', 'Draft attached');
                $this->db->where('status', 'Approved');
				$this->db->where('DATE_FORMAT(order_schedules.end_date, "%Y-%m-%d %H:%i") <=', date('Y-m-d H:i:s'));
                $query3 = $this->db->get();
                $res3 = $query3->row();
                $confirm_hours = $res3->total_confirm_hr;

                //$result['total_hours'] = $total_assigned_hours - $confirm_hours;
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
			$this->db->where('notification_users.user_id', $this->session->userdata('id'));
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
			$this->db->where('orders.presenter_id', $this->session->userdata('id'));
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
			$this->db->where('order_schedules.created_by', $this->session->userdata('id'));
			$query = $this->db->get();
			$result['new_invoice'] = $query->num_rows();
			//echo $this->db->last_query();die;
			// if ($query->row())
			// 	$result['new_invoice'] = 1;
			// else
			// 	$result['new_invoice'] = 0;

			$this->db->select('*');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.status', 'Approved');
			$this->db->where('DATE_FORMAT(order_schedules.end_date, "%Y-%m-%d %H:%i") <=', date('Y-m-d H:i:s'));
			$this->db->where('order_schedules.created_by', $this->session->userdata('id'));
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
			$this->db->where('order_assigned_presenters.presenter_id', $this->session->userdata('id'));
			$totOrder = $this->db->get();
			$totOrdCnt = $totOrder->num_rows();
			
			$this->db->select('order_schedules.*');
			$this->db->from('order_schedules');
			$this->db->join('orders', "orders.id = order_schedules.order_id");
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('order_schedules.created_by', $this->session->userdata('id'));
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
	
	public function get_school_dashboard()
	{
		$school_id= $this->session->userdata('id');
		try {

			$result = array();

			// Total Order
			$this->db->select('count(orders.id) as total_order');
			$this->db->from('orders');
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('orders.status', 'approved');
			$this->db->where('orders.school_id', $this->session->userdata('id'));

			$result['total_order'] = $this->db->count_all_results();
			
			// Get Total title
			$this->db->select('teachers.*');
			$this->db->from('teachers');
			$this->db->where('teachers.is_deleted', '0');
			$this->db->where('teachers.school_id', $this->session->userdata('id'));
			$result['total_title'] = $this->db->count_all_results();

			//Get total coordinator//
			$this->db->select('coordinator_presentator_school.coordinator_id as total_coordinator');
			$this->db->from('coordinator_presentator_school');
			$this->db->where("FIND_IN_SET('$school_id',coordinator_presentator_school.school_ids) !=", 0);
			$this->db->where('coordinator_presentator_school.is_deleted',0);
			
			$query = $this->db->get()->result();
			//print "<pre>"; print_r($query); print "</pre>";exit;
			//echo $this->db->last_query();die;
			
			$result['total_coordinator'] = count($query);

			// Get total Presenter
			// $this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, roles.role_name');
			// $this->db->from('users');
			// $this->db->join('roles', 'users.role_id = roles.id');
			// $this->db->where('users.status', 'active');
			// $this->db->where('roles.role_token', 'teacher');
			// $this->db->where('users.is_deleted', 0);
			// $result['total_presenter'] = $this->db->count_all_results();

			$this->db->select('COUNT(order_assigned_presenters.presenter_id) as total_presenter');
			$this->db->from('order_assigned_presenters');
			$this->db->join('orders', 'orders.id = order_assigned_presenters.order_id');
			$this->db->join('users', 'order_assigned_presenters.presenter_id = users.id');
			$this->db->where('orders.school_id', $this->session->userdata('id'));
			$this->db->group_by('order_assigned_presenters.presenter_id');
			$query = $this->db->get()->result();
			
			$result['total_presenter'] = count($query);
			
			// Get Total Hours
			$this->db->select('sum(orders.hours) as total_hours');
			$this->db->from('orders');
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('orders.status', 'approved');
			$this->db->where('orders.school_id', $this->session->userdata('id'));
			$res = $this->db->get()->row();
			$result['total_hours'] = $res->total_hours;
			
			// Get Total Approved Hours
			$this->db->select('sum(order_schedules.total_hours) as total_approved_hours');
			$this->db->from('orders');
			$this->db->join('order_schedules', 'order_schedules.order_id=orders.id');
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('orders.status', 'approved');
			$this->db->where('orders.school_id', $this->session->userdata('id'));
			$res = $this->db->get()->row();
			$result['total_approved_hours'] = $res->total_approved_hours;
			
			// Get Total sign log
			$this->db->select('COUNT(order_schedules.id) as total_signlog, orders.id as orderId');
			$this->db->from('orders');
			$this->db->join('order_schedules', 'order_schedules.order_id=orders.id');
			$this->db->where('orders.is_deleted', '0');
			$this->db->where('orders.status', 'approved');
			$this->db->where('orders.school_id', $this->session->userdata('id'));
			$this->db->where('order_schedules.status', 'Log sent - awaiting principal signature');
			$res = $this->db->get()->row();
			$result['total_signlog'] = $res;

			return $result;
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();die;
		}
	}
	
	/**
	 * Following code will return 
	 * the list of those order which 
	 * are already been paid for at least one of schedule 
	 * Created on: 23/07/2019
	 * Created by: Soumya
	*/
	public function get_orderpaid_list($filter = array(), $order = null, $dir = null, $count = false) 
	{
		/**
		 * Following code will trace
		 * the order id whose at lease schedule get paid
		*/
		$this->db->select('DISTINCT(order_id) AS orderid');
		$this->db->from('order_schedules');
		$this->db->join('orders', 'orders.id = order_schedules.order_id');
		$this->db->where('order_schedules.status', 'Completed');
		$this->db->where('orders.order_no !=', '');

		$get_orderids_que = $this->db->get();
		$get_orderids_arr = $get_orderids_que->result_array();
		$order_ids		  = array(); 		

		foreach($get_orderids_arr as $orderid)
		{
			$order_ids[] = $orderid['orderid'];
		}
		## ---- End of the code ----- ##

		$this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, titles.name as title_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id AND order_schedules.check_number!="") AS paid_to_brienza, order_schedules.created_by AS schedule_presenter_id');
		$this->db->from('orders');
		$this->db->join('titles', 'orders.title_id = titles.id');
		$this->db->join('users AS schools', 'orders.school_id = schools.id');
		$this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");

        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users AS orders_updated', 'orders.updated_by = orders_updated.id', 'left');
		$this->db->join('order_schedules', 'orders.id = order_schedules.order_id', 'left');

		$this->db->where_in('orders.id', $order_ids);

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


   		if ($count) {
            $this->db->group_by("orders.id");
            $query = $this->db->get();
            return $query->num_rows();
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('updated_on DESC');
    	}

    	$this->db->group_by("orders.id");

		$query1 = $this->db->get();
		$query=$query1->result();

		for($j=0;$j<count($query);$j++)
        {
            $orders_id=$query[$j]->id;
          
             $this->db->select('order_assigned_presenters.presenter_id,order_assigned_presenters.assigned_hours,user_meta.meta_value as rate');
             $this->db->from('order_assigned_presenters'); 
             $this->db->join('user_meta', 'order_assigned_presenters.presenter_id = user_meta.user_id', 'left');
             $this->db->where('order_assigned_presenters.order_id',$orders_id);
             $this->db->where('user_meta.meta_key','rate');
             $orders_query = $this->db->get();
             $orders=$orders_query->result(); 

             $sets=$orders;
             $query[$j]->assigned_presenter=$sets;

	             for($k=0;$k<count($sets);$k++){
	             	$presenter_id=$sets[$k]->presenter_id;
	             	$rate=$sets[$k]->rate;
	             	$assigned_hour=$sets[$k]->assigned_hours;

	             $this->db->select('SUM(order_schedules.total_hours) as total_schedule_hour,order_schedules.created_by,order_schedules.status');
	             $this->db->from('order_schedules'); 

	             $this->db->where('order_schedules.created_by',$presenter_id);
	             $this->db->where('order_schedules.order_id',$orders_id);
	             $presenter_query = $this->db->get();
	             $prsenters=$presenter_query->row(); 

	            
	             $sets[$k]->total_hour=$prsenters;
	             // if($sets[$k]->total_hour->status == 'Completed')
	             // {
	             $sets[$k]->paid=$rate * $sets[$k]->total_hour->total_schedule_hour;
	             //}
	             $sets[$k]->unbilled_hour=$assigned_hour-$sets[$k]->total_hour->total_schedule_hour;
	             $sets[$k]->unbilled_payment=$rate * $sets[$k]->unbilled_hour;
	          //  //  $p=$sets[$k]->paid;
           //   	    echo "<pre>";
           // print_r($sets);
           // exit;
              }
          
             
        }

   		//echo $this->db->last_query()."<br>";die;
   		return $query;
	}
	## ------------ end of the code ------------ ##	


	/**
	 * Following methods will be used
	 * to get the paid order details and 
	 * paid schedule list
	 * Created on: 30-07-2019
	 * Created by: Soumya 
	*/
	public function get_order_details($order_id)
	{
		//====== Get order basic details =========//
		$this->db->select('orders.*, user_meta.meta_value as school_name, titles.name as title');
		$this->db->from('orders');
		$this->db->join('user_meta', 'user_meta.user_id=orders.school_id', 'left');
		$this->db->join('titles', 'titles.id = orders.title_id', 'left');
		$this->db->where('user_meta.meta_key', 'school_name');
		$this->db->where('orders.id', $order_id);

		$basic_oder_details_que = $this->db->get();
		$basic_oder_details_arr = $basic_oder_details_que->row_array();
		//====== Get order basic details =========//


		//===== Get order's total scheduled hours, remaining hours =====//
		$this->db->select('SUM(total_hours) as hours_bill_paid');
		$this->db->from('order_schedules');
		$this->db->where('order_id', $order_id);
		$this->db->where('status', 'Completed');

		$get_billedpaid_hours_que = $this->db->get();
		$get_billedpaid_hours_arr = $get_billedpaid_hours_que->row_array();

		$get_billedpaid_hours	  = $get_billedpaid_hours_arr['hours_bill_paid'];
		$get_remaining_hours	  = ($basic_oder_details_arr['hours'] - $get_billedpaid_hours);	

		$basic_oder_details_arr['hours_bill_paid']  = $get_billedpaid_hours;
		$basic_oder_details_arr['hour_remains']  	= $get_remaining_hours;
		//===== Get order's total scheduled hours, remaining hours =====//


		//====== Get total amount of billing and total remaining amount of billing =======//
		$this->db->select('SUM(order_schedules.total_hours) as hours_bill_paid, order_schedules.created_by, user_meta.meta_value as rate');
		$this->db->from('order_schedules');
		$this->db->join('user_meta', 'user_meta.user_id = order_schedules.created_by', 'left');
		$this->db->where('order_schedules.order_id', 	$order_id);
		$this->db->where('order_schedules.status', 		'Completed');
		$this->db->where('order_schedules.check_number !=', 	'');
		$this->db->where('user_meta.meta_key', 			'rate');

		$get_billed_amount_que = $this->db->get();
		$get_billed_amount_arr = $get_billed_amount_que->row_array();

		$total_amount_billed = 0;
		if(!empty($get_billed_amount_arr)){
			$total_amount_billed += $get_billed_amount_arr['hours_bill_paid']*$basic_oder_details_arr['brienza_price'];
		}

		$this->db->select('SUM(order_schedules.total_hours) as hours_unbill');
		$this->db->from('order_schedules');
		$this->db->where('order_schedules.order_id', 	$order_id);
		$this->db->where('order_schedules.status', 	'Completed');
		$this->db->where('order_schedules.check_number', 	NULL);

		$get_unbilled_amount_que = $this->db->get();
		$get_unbilled_amount_arr = $get_unbilled_amount_que->row_array();

		$total_amount_unbilled = 0;	
		if(!empty($get_unbilled_amount_arr)){	
			$total_amount_unbilled += $get_unbilled_amount_arr['hours_unbill']*$basic_oder_details_arr['brienza_price'];
		}

		$basic_oder_details_arr['total_amount_billed']  	= $total_amount_billed;
		$basic_oder_details_arr['total_amount_unbilled']  	= $total_amount_unbilled;		
		//====== Get total amount of billing and total remaining amount of billing =======//
		//pr($basic_oder_details_arr); exit();

		return $basic_oder_details_arr;

	}

	public function get_order_schedule_details($order_id)
	{
		//====== Get schedule billing details =========//
		$this->db->select('order_schedules.*, user_meta.meta_value as rate, (user_meta.meta_value *order_schedules.total_hours) as total_amount');
		$this->db->from('order_schedules');
		$this->db->join('user_meta', 'user_meta.user_id = order_schedules.created_by', 'left');
		$this->db->where('order_id', $order_id);
		$this->db->where('user_meta.meta_key', 'rate');

		$basic_oder_scdetails_que = $this->db->get();
		$basic_oder_scdetails_arr = $basic_oder_scdetails_que->result_array();
		//====== Get schedule billing details =========//

		$final_array 	= array();
		$total_amount 	= 0;
		$total_hours	= 0;

		foreach($basic_oder_scdetails_arr as $keys=>$schedule_values)
		{
			foreach($schedule_values as $inner_key=>$schedule_values_inner)
			{
				$final_array[$keys][$inner_key] = $schedule_values_inner;
			}	

			$total_hours 	= $total_hours + $schedule_values['total_hours'];
			$total_amount 	= $total_amount + $schedule_values['total_amount'];
		}

		$return_array = array();

		$return_array['billed_schedule_list'] 	= $final_array;
		$return_array['fianl_total_hours'] 		= $total_hours;
		$return_array['final_total_amount'] 	= $total_amount;

		return $return_array;
	}
	## ---------- End of the segment ------------ ##	
	

	public function get_new_schedule_hour($last_login, $curr_login){
		
		$this->db->select('SUM(order_schedules.total_hours) as total_new_hour');
		$this->db->from('order_schedules');
		$this->db->where('order_schedules.created_on>=', $last_login);
		$this->db->where('order_schedules.created_on<=', $curr_login);
		$res = $this->db->get()->row_array();
		return $res['total_new_hour'];
	}
	public function get_agenda_schedule($filter = array(), $order = null, $dir = null, $count = false){

		/**
		 * Following code will trace
		 * the order id whose at lease schedule get paid
		*/
		$previous_year = date("Y",strtotime("-1 year")); // added 10-01-2022
		$agenda_schedule_date = $previous_year.'-09-01';  // added 10-01-2022
		$this->db->select('order_assigned_presenters.presenter_id, order_schedules.*, CONCAT(users.first_name, " ", users.last_name) AS presenter_name, orders.order_no');
		$this->db->from('order_assigned_presenters');
		$this->db->join('order_schedules', 'order_schedules.created_by = order_assigned_presenters.presenter_id');
		$this->db->join('users', 'users.id = order_assigned_presenters.presenter_id', 'left');
		$this->db->join('orders', 'orders.id = order_schedules.order_id');
		$this->db->where('order_schedules.status !=', 'Completed');
		$this->db->where('order_schedules.status !=', 'Payment sent');
		$this->db->where('order_schedules.status !=', "Rejected - don't want");
		// $this->db->like('order_schedules.created_on', date("Y"), 'after');
		$this->db->where('order_schedules.created_on >=', $agenda_schedule_date); // added 10-01-2022

		// $this->db->order_by('order_schedules.status');
		if(empty($filter['statusSort'])){
			$this->db->order_by('order_schedules.status');
		}
		if (isset($filter['statusSort']) && $filter['statusSort'] !== "") {
			$this->db->order_by('order_schedules.status',$filter['statusSort']);
			$this->db->order_by('order_schedules.start_date',$filter['statusSort']);
		}

		if(empty($filter['sessionSort'])){
			// if (isset($filter['byDefaultAscending']) && $filter['byDefaultAscending'] !== "") {
				$this->db->order_by('order_schedules.start_date');
			// }
		}
		
		if (isset($filter['sessionSort']) && $filter['sessionSort'] !== "") {
            $this->db->order_by('order_schedules.start_date',$filter['sessionSort']);
			$this->db->order_by('order_schedules.status',$filter['sessionSort']);
        }

		$this->db->order_by('order_schedules.id DESC');

		if (isset($filter['presenter']) && $filter['presenter'] !== "") {
            $this->db->where('order_schedules.created_by', $filter['presenter']);
        }
		if (isset($filter['date']) && $filter['date'] !== "") {
            $date = str_replace('~', '/', $filter['date']);
            $s_date = $this->format_date($date);
                
            $this->db->where('DATE(order_schedules.start_date)', $s_date);
        }
		if (isset($filter['status']) && $filter['status'] !== "") {
            $status = str_replace('+', ' ', $filter['status']);
                
            $this->db->where('order_schedules.status', $status);
        }

   		if ($count) {
   			$this->db->group_by("order_schedules.id");
            $query = $this->db->get();
            return $query->num_rows();
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		$this->db->group_by("order_schedules.id");

		$query = $this->db->get();
   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();
	}

	
	private function format_date($date) {
		if($date == "") {
			return "";
		}
		return date('Y-m-d', strtotime($date));
	}
	public function get_new_billing_count(){
		$this->db->select('*');
        $this->db->from('billing');
        $this->db->where('is_read', '0');
        $query = $this->db->get();
        return $query->num_rows();
	}
	public function get_teacher_orders_horstoconfirm(){
        // Total "Hours to confirm" new implementation 17-09-2021

        $this->db->select('order_id');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $this->session->userdata('id'));
        $query2 = $this->db->get();
        if ($query2->num_rows()>0){
            $res2 = $query2->result();
            // echo '<pre>'; print_r($res); die();
            $order_ids = array();
            foreach ($res2 as $order_id) {
                $order_ids[] = $order_id->order_id;
            }
            $this->db->select('sum(assigned_hours) as total_assign_hrs');
            $this->db->from('order_assigned_presenters');
            $this->db->where('presenter_id', $this->session->userdata('id'));
            $query1 = $this->db->get();
            $res1 = $query1->row();
            $total_assigned_hours = $res1->total_assign_hrs;

            $this->db->select('order_id');
            $this->db->from('order_schedules');
            $this->db->where('created_by', $this->session->userdata('id'));
            $this->db->where_in('order_id', $order_ids);
            $this->db->order_by("order_id", "asc");
            $this->db->limit(1);
            // $this->db->where('status !=', 'Hours scheduled');
            // $this->db->where('status !=', 'Draft attached');
            $this->db->where('status', 'Approved');
			$this->db->where('DATE_FORMAT(end_date, "%Y-%m-%d %H:%i") <=', date('Y-m-d H:i:s'));
            $query3 = $this->db->get();
            // echo $this->db->last_query(); die();
            if($query3->num_rows() > 0){
                $res3 = $query3->row();
                return $res3->order_id;
            }else{
                return 0;
            }
        }else{
            
        }
    }

	public function get_status_createInvoice_sessionwise_dashboard(){
        $this->load->model('../../App/models/App_model');
        $data['billing'] = false;
        $presenter_id = $this->session->userdata('id');

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



public function total_hours_ready_to_invoice_dashboard(){
        $this->load->model('../../App/models/App_model');
        $data['billing'] = false;
        $presenter_id = $this->session->userdata('id');

        // $current_date = date("Y-m-d");
        // getting billing rate of the presenter 
        // $billRate = $this->App_model->get_bill_rate($presenter_id);
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
        $totalhours = 0;
        foreach($orderArray as $key => $value){
            foreach($value as $val){
                // echo $val; 
                $flag = date("d", strtotime($val)) == '01' ? 1 : 2;
                $totalhoursinvoice = $this->App_model->total_hours_ready_to_invoice_dashboard($key, $presenter_id, $val, $flag);
                $totalhours = $totalhours + $totalhoursinvoice;
            }
        }
        return $totalhours; 
        //die();
    }

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */
