<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify_model extends CI_Model {

	/**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_notifications_list($filter = array(), $order = null, $dir = null, $count = false) {

		if (isset($filter['user_id']) && $filter['user_id'] <> 0) {
    		$this->db->where('notification_users.user_id', $filter['user_id']);
   		}
		
		if (isset($filter['created_by']) && $filter['created_by'] <> 0) {
    		$this->db->where('notifications.created_by', $filter['created_by']);
   		}

		if (isset($filter['type']) && $filter['type'] <> '') {
    		$this->db->where('notifications.type', $filter['type']);
   		}

		if (isset($filter['status']) && $filter['status'] <> '') {
    		$this->db->where('notification_users.status', $filter['status']);
   		}

		if (isset($filter['delete']) && $filter['delete'] !== "") {
    		$this->db->where('notifications.is_deleted', $filter['delete']);
   		}
		
		if (isset($filter['category']) && $filter['category'] <> "") {
    		$this->db->where('notifications.category', $filter['category']);
   		}

		$this->db->select('notifications.id, notifications.subject, notifications.description, notifications.teacher_name,notifications.grade, notifications.type, notification_users.status, notifications.created_by, notifications.created_on, , CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, notification_reply.reply, notification_reply.created');
		$this->db->from('notifications');
		$this->db->join('users AS users_created', 'notifications.created_by = users_created.id', 'left');
		$this->db->join('notification_users', 'notification_users.notification_id = notifications.id', 'left');
		$this->db->join('notification_reply', 'notification_reply.sender_id = notifications.created_by', 'left');

		$this->db->group_by("notifications.id");

		if ($count) {
			$query = $this->db->get();
			return count($query->result());
   			//return $this->db->count_all_results();
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('notification_users.status DESC, notifications.updated_on DESC');
    	}

		$query = $this->db->get();

   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();

    }

	public function get_teacher_list($filter = array()) {

		$this->db->select('teachers.*, teachers.name as first_name, CONCAT("") as last_name, schools.name as school_name, grades.name as grade_name, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name, ');
		$this->db->from('teachers');
        $this->db->join('schools', 'schools.id = teachers.school_id');
		$this->db->join('grades', 'grades.id = teachers.grade_id');
        $this->db->join('users AS users_created', 'teachers.created_by = users_created.id', 'left');
        $this->db->join('users as users_updated', 'teachers.updated_by = users_updated.id', 'left');

        $this->db->where('teachers.is_deleted', 0);
    	$this->db->where('teachers.status', 'active');
   		$this->db->order_by('name ASC');

    	$this->db->group_by("teachers.id");
		$query = $this->db->get();

   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();
    }


	public function get_users_list($filter = array()) {

		$this->db->select('users.*');
		$this->db->from('users');
   		$this->db->join('roles', 'roles.id = users.role_id');

		if (isset($filter['role_token']) && $filter['role_token'] <> "" ) {
    		$this->db->where('roles.role_token', $filter['role_token']);
   		}

		$this->db->where('users.is_deleted', '0');
		$this->db->group_by('users.id');
   		$this->db->order_by('first_name ASC');

		$query = $this->db->get();//echo $this->db->last_query()."<br>";
		return $query->result();
    }

	function get_notification_users($id, $type) {

		if ($type == "customers") {
			$this->db->select('notification_users.id, notification_users.notification_id, notification_users.status, notification_users.is_deleted, CONCAT(customers.first_name, " ", customers.last_name) as name, customers.email');
			$this->db->from('notification_users');
			$this->db->join('customers', 'notification_users.user_id = customers.id');

			$this->db->where('notification_users.notification_id', $id);
			$this->db->order_by('customers.first_name ASC');
		} else {
			$this->db->select('notification_users.id, notification_users.notification_id, notification_users.status, notification_users.is_deleted, CONCAT(users.first_name, " ", users.last_name) as name, users.email');
			$this->db->from('notification_users');
			$this->db->join('users', 'notification_users.user_id = users.id');

			$this->db->where('notification_users.notification_id', $id);
			$this->db->order_by('users.first_name ASC');
		}

		$query = $this->db->get();

   		//echo $this->db->last_query()."<br>";
   		return $query->result();
	}

	/**
     *
     * @param $notification_id
     * @return array
     */
    function get_notification_details($id) {
    	$id = (int) $id;

    	$this->db->select('notifications.*, DATE_FORMAT(notifications.created_on, "%m/%d/%Y %h:%i %p") as created_on, CONCAT(notifications_created.first_name, " ", notifications_created.last_name) as created_by_name');
		$this->db->from('notifications');
		$this->db->join('users AS notifications_created', 'notifications.created_by = notifications_created.id', 'left');
		$this->db->where('notifications.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$data = $query->row();
   		if(!empty($data)){
	    	$this->db->select('notification_reply.*, DATE_FORMAT(notification_reply.created, "%m/%d/%Y %h:%i %p") as created, CONCAT(notifications_created.first_name, " ", notifications_created.last_name) as created_by_name');
			$this->db->from('notification_reply');
			$this->db->join('users AS notifications_created', 'notification_reply.created_by = notifications_created.id', 'left');
			$this->db->where('notification_reply.notification_id', $data->id);

			$res = $this->db->get()->row();
			$data->reply = $res;
   		}

   		return $data;
   	}

    function get_notification_reply($id) {
    	$id = (int) $id;

    	$this->db->select('notification_reply.*, DATE_FORMAT(notification_reply.created, "%m/%d/%Y %h:%i %p") as created');
		$this->db->from('notification_reply');
		$this->db->where('notification_reply.notification_id', $id);

		$query = $this->db->get();
		echo $this->db->last_query()."<br>";
   		return $query->row();
		// echo "<pre>";print_r($query->row());exit;
   	}


	function update_status($notification_id, $user_id) {
		$notification_id = (int) $notification_id;

		$status = array(
    		'status' => 'read',
        );

		$this->db->where('notification_id', $notification_id);
		$this->db->where('user_id', $user_id);
		$this->db->update('notification_users', $status);
	}
    /**
     *
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

    /**
     *
     * @param $field_name
     * @param $field_value
     * @param $data
     */
	function update($tablename, $field_name, $field_value, $data) {

		$this->db->where($field_name, $field_value);
		if ($this->db->update($tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	function update_notification_user($tablename, $condition, $data) {

		$this->db->where($condition);
		if ($this->db->update($tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * @param unknown_type $tablename
	 * @param unknown_type $id
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


 	/**
     *
     * @param $user_id
     * @return array
     */
    function get_user_details($id) {
    	$id = (int) $id;

    	$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.updated_on, users.status, roles.role_name, roles.role_token, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');
		$this->db->join('users AS users_created', 'users.created_by = users_created.id', 'left');
		$this->db->join('users AS users_updated', 'users.updated_by = users_updated.id', 'left');
		$this->db->where('users.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();

   		$result->meta = $this->get_user_meta($id);

   		return $result;
    }

    function get_user_meta($user_id) {
    	$user_id = (int) $user_id;

    	$this->db->from('user_meta');
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get();
    	return $query->result();
    }

	/**
     *
     * @param $user_id
     * @return array
     */
    function get_role_details($id) {
    	$id = (int) $id;

    	$this->db->select('roles.id, roles.role_token, roles.role_name, roles.description, roles.default, roles.can_delete, roles.created_on, roles.updated_on, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
		$this->db->from('roles');
		$this->db->join('users AS users_created', 'roles.created_by = users_created.id', 'left');
		$this->db->join('users AS users_updated', 'roles.updated_by = users_updated.id', 'left');
		$this->db->where('roles.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
    }

	/**
     *
     * @param $user_id
     * @return array
     */
    function get_permission_details($id) {
    	$id = (int) $id;

    	$this->db->select('permissions.id, permissions.name, permissions.description, permissions.status');
		$this->db->from('permissions');
		$this->db->where('permissions.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
    }

	/**
	 *
	 * @param unknown_type $filter
	 */
    function get_role_permission($filter = array()) {

		$this->db->from('role_permissions');

    	if (isset($filter['role_id']) && $filter['role_id'] > 0) {
    		$this->db->where('role_id', $filter['role_id']);
   		}

    	if (isset($filter['permission_id']) && $filter['permission_id'] > 0) {
    		$this->db->where('permission_id', $filter['permission_id']);
   		}

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;

		//$result = new stdClass();
		$result = array();


		foreach ($query->result() as $row) {

			$this->db->select('permission_id');
			$this->db->from('role_permissions');
			$this->db->where('role_id', $row->role_id);

			$query = $this->db->get();

			//$result[$row->role_id] = array_values($query->result_array());
			foreach ($query->result() as $rowP) {
				$result[$row->role_id][$rowP->permission_id] = 'Y';
			}
		}
   		return $result;
    }

    /**
     *
     * @param $data
     */
    function update_role_permission($data = array()) {

    	if (empty($data)) {
    		return false;
    	}

    	// TRUNCATE table first
    	$this->db->from('role_permissions');
		$this->db->truncate();

    	foreach ($data as $role_id => $permissions) {

    		foreach ($permissions as $permission_id => $value) {

    			$role_permissions = array('role_id' => $role_id, 'permission_id' => $permission_id);

    			// Insert it again
    			$this->insert('role_permissions', $role_permissions);
    			//echo "role = ".$role_id." -> permission = ".$permission_id." -> value = ".$value."<br>";
    		}
    	}
    	return true;
    }
    /**
     *
     * @param $tablename
     * @param $field_name
     * @param $field_value
     */
	function validate_data($tablename, $field_name, $field_value) {

		$this->db->where($field_name, $field_value);
		$this->db->from($tablename);

		if ($this->db->count_all_results() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 *
	 * @param unknown_type $user_id
	 * @param unknown_type $meta
	 */
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
    		$data = array(
						'user_id' => $user_id,
					    'meta_key'  => $meta_key,
					    'meta_value'  => htmlspecialchars($meta_value, ENT_QUOTES, 'utf-8')
					);
			$this->db->insert('user_meta', $data);
    	}
    	return;
	}

	public function get_locations_list($filter = array(), $order = null, $dir = null, $count = false) {

    	$this->db->select('*');
		$this->db->from('locations');

		if (isset($filter['delete']) && $filter['delete'] !== "") {
    		$this->db->where('locations.is_deleted', $filter['delete']);
   		}

		if (isset($filter['status']) && $filter['status'] != "") {
			$this->db->where('locations.status', $filter['status']);
		}

   		if ($count) {
   			return $this->db->count_all_results();
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('id ASC');
    	}

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
    }

	public function get_logs_list($id=null, $filter_logs=null, $count = false){
        $this->db->select('order_schedules.*, orders.order_no, order_schedule_status_log.*');
        $this->db->from('orders');
        $this->db->join('order_schedules', 'orders.id = order_schedules.order_id');
        $this->db->join('order_schedule_status_log', 'order_schedule_status_log.order_schedule_id = order_schedules.id');
        $this->db->where('order_schedule_status_log.new_status', 'Log sent - awaiting principal signature');
        $this->db->where('order_schedule_status_log.content_for_print <>', NULL);
		$this->db->order_by('order_schedule_status_log.status');
        // $this->db->order_by('order_schedule_status_log.id DESC');
		$this->db->order_by('order_schedules.start_date DESC');
        if(isset($id)){
            $this->db->where('order_schedules.order_id', $id);
        }
        if ($count) {
            $query = $this->db->get();
            return count($query->result());
            //return $this->db->count_all_results();
        }
           if ( (isset($filter_logs['limit']) && $filter_logs['limit'] > 0) && (isset($filter_logs['offset']) ) ) {
            $this->db->limit($filter_logs['limit'], $filter_logs['offset']);
        }
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }

	function update_log_status($log_id) {
        // $notification_id = (int) $notification_id;
        $log_id = (int) $log_id;
        $status = array(
            'status' => 'read',
        );
		$this->db->where('id', $log_id);
        $this->db->where('order_schedule_status_log.new_status', 'Log sent - awaiting principal signature');
        $this->db->update('order_schedule_status_log', $status);
	}

	public function get_log_details(){
        $this->db->select('*');
        $this->db->from('order_schedule_status_log');
        $this->db->where('new_status', 'Log sent - awaiting principal signature');
		$this->db->where('order_schedule_status_log.content_for_print <>', NULL);
        $this->db->where('status', 'unread');
        $query=$this->db->get();
        // echo $this->db->last_query()."<br>";die;
        // if($query->num_rows() > 0){
            
            $res = $query->result();
            if(!empty($res)){
            return count($res); 
        }else{
            return false;
        }
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
