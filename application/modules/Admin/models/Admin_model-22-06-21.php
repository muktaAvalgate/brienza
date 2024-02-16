<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	/**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_users_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.status, users.headerImg, roles.role_name,CONCAT(users.first_name, " ", users.last_name) as presenter');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');

		if (isset($filter['status']) && ($filter['status'] == 'active' || $filter['status'] == 'inactive')) {
    		$this->db->where('users.status', $filter['status']);
   		}

		if (isset($filter['role']) && $filter['role'] <> 0) {
    		$this->db->where('users.role_id', $filter['role']);
   		}
		
		if (isset($filter['role_token']) && $filter['role_token'] <> "") {
    		$this->db->where('roles.role_token', $filter['role_token']);
   		}
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('users.is_deleted', $filter['deleted']);
   		}

   		if (isset($filter['company']) && $filter['company'] !== "") {
            $this->db->where('users.id', $filter['company']);
   		}

   		if (isset($filter['presenter']) && $filter['presenter'] !== "") {
            $this->db->where('users.id', $filter['presenter']);
   		}
   		
   		if (isset($filter['role_token']) && $filter['role_token'] == "coordinator" && isset($filter['baa_co_id']) && $filter['baa_co_id'] != "") {
            $this->db->where_not_in('users.id', $filter['baa_co_id']);
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
   			$this->db->order_by('users.updated_on ASC');
    	}

    	$this->db->group_by("users.id");
		$query = $this->db->get();
   		//echo $this->db->last_query()."<br>";
		
   		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}
   		return $result;
    }
	
	
	/**
	 * Following method will be used
	 * to get assigned presenters list
	 * for the coordinator ...
	 */
	public function get_presenter_list($filter = array(), $order = null, $dir = null, $count = false) 
	{
		$this->db->select('coordinator_presentator_school.id as cps_id, coordinator_presentator_school.*, users.*');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.presenter_id = users.id');

		if (isset($filter['coordinator_id'])) {
			$this->db->where('coordinator_presentator_school.coordinator_id', $filter['coordinator_id']);
		}

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
			$this->db->where('coordinator_presentator_school.is_deleted', $filter['deleted']);
		}

		if ($count) {
			return $this->db->count_all_results();
		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
			$this->db->limit($filter['limit'], $filter['offset']);
		}
		
		$order = 'users.'.$order;

		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('coordinator_presentator_school.from_date ASC');
		}

		$query = $this->db->get();

		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) 
		{
			$new_array 		= explode(",", $row->school_ids);
			foreach($row as $inner_key=>$key_values)
			{
				if($inner_key != 'school_ids')
					$result[$i][$inner_key] = $key_values;
			}

			$result[$i]['meta'] = $this->get_user_meta($row->id);

			$school_name 	= array();
			foreach($new_array as $inner_val)
			{
					$this->db->select('meta_value');
					$this->db->from('user_meta');
					$this->db->where('user_id', $inner_val);
					$this->db->where('meta_key', 'school_name');

					$metaquery 			= $this->db->get();
					$metavalarr 		= $metaquery->row();
					$school_name[] 		= $metavalarr->meta_value;
			}
			$result[$i]['school_name'] = implode(",", $school_name);
			$i++;
		}
		return $result;
	}	

	// Create new function for BAA Coordinator By Ahmed on 2019-12-11
	public function get_presenter_list_for_coordinator($filter = array(), $order = null, $dir = null, $count = false) {
		$this->db->select('users.*');
		$this->db->from('users');

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
			$this->db->where('users.is_deleted', $filter['deleted']);
		}
		$this->db->where('users.role_id', 3);
		$this->db->where('users.status', 'active');


		if ($count) {
			return $this->db->count_all_results();
		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
			$this->db->limit($filter['limit'], $filter['offset']);
		}
		
		$order = 'users.'.$order;

		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('users.from_date ASC');
		}

		$query = $this->db->get();

		$result = $query->result_array();

		$i = 0;

		foreach ($result as $key => $row) 
		{
			$result[$key]['meta'] = $this->get_user_meta($row['id']);
		}
		
		return $result;
	}	
	// End of code by Ahmed on 2019-12-11

	public function get_coordinator_assign_presenter_school($coordinator_id, $presenter_id){
		$this->db->select('coordinator_presentator_school.id as cps_id, coordinator_presentator_school.*');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.presenter_id = users.id');

		$this->db->where('coordinator_presentator_school.coordinator_id', $coordinator_id);
		$this->db->where('coordinator_presentator_school.presenter_id', $presenter_id);
		$this->db->where('coordinator_presentator_school.is_deleted', '0');

		$query = $this->db->get();
		$records = $query->row();
		
		$schoolName = array();
		if(!empty($records) && $records->school_ids != ''){

			$schoolIds = explode(",", $records->school_ids);
			foreach ($schoolIds as $k => $val) {
				$this->db->select('meta_value');
				$this->db->from('user_meta');
				$this->db->where('user_id', $val);
				$this->db->where('meta_key', 'school_name');

				$metaquery 			= $this->db->get();
				$metavalarr 		= $metaquery->row();
				$schoolName[] = array('id' => $val, 'school_name' => $metavalarr->meta_value);
			}
		}
		return $schoolName;
	}

	public function get_coordinator_assign_school_presenter($coordinator_id, $school_id){
		
		$this->db->select('coordinator_presentator_school.*, users.first_name, users.last_name');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.presenter_id = users.id');

		$this->db->where('coordinator_presentator_school.coordinator_id', $coordinator_id);
		$this->db->where("FIND_IN_SET(".$school_id.",coordinator_presentator_school.school_ids) >",0);
		$this->db->where('coordinator_presentator_school.is_deleted', '0');

		$query = $this->db->get();
		$records = $query->result_array();
		// echo $this->db->last_query();exit;
		return $records;
	}


	public function get_coordinator_assign_school($school_id){
		$this->db->select('coordinator_presentator_school.*, users.first_name, users.last_name');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.coordinator_id = users.id');
		$this->db->where("FIND_IN_SET(".$school_id.",coordinator_presentator_school.school_ids) >",0);
		$this->db->where('coordinator_presentator_school.is_deleted', '0');
		
    	$this->db->group_by("coordinator_presentator_school.coordinator_id");
		$query = $this->db->get();
		$records = $query->result_array();
		// echo $this->db->last_query();exit;
		return $records;
	}


 		/**
		* Following method has been used
		* to get assigned presenters detaiils
	 	*/
		function get_assigned_presenter_details($id) 
		{
			$id = (int) $id;

			$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.updated_on, users.status, roles.role_name, roles.role_token, users.created_by, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, users.updated_by, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
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


	public function get_coordinator_presenter_list($coordinator_id)
	{
		$this->db->select('coordinator_presentator_school.*, users.first_name, users.last_name,users.email');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.presenter_id = users.id');
		$this->db->where('coordinator_presentator_school.coordinator_id', $coordinator_id);
		$this->db->where('coordinator_presentator_school.is_deleted', '0');

		$query = $this->db->get();

		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->presenter_id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}
		//$records = $query->result_array();
		// echo $this->db->last_query();exit;
		return $result;
	}


    /**
     *
     * @param unknown_type $filter
     * @param unknown_type $order
     * @param unknown_type $dir
     * @param unknown_type $count
     */
    public function get_roles_list($filter = array(), $order = null, $dir = null, $count = false) {

    	$this->db->select('roles.id, roles.role_token, roles.role_name, roles.description, roles.default, roles.can_delete, (SELECT count(id) FROM users WHERE role_id = roles.id) as no_of_users');
		$this->db->from('roles');

		if (isset($filter['default']) && $filter['default'] <> "") {
    		$this->db->where('roles.default', $filter['default']);
   		}

		if (isset($filter['token']) && $filter['token'] <> "") {
    		$this->db->where('roles.role_token', $filter['token']);
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
   			$this->db->order_by('role_name ASC');
    	}

		$query = $this->db->get();
		return $query->result();
    }


	public function get_permissions_list($filter = array(), $order = null, $dir = null, $count = false) {

    	$this->db->select('permissions.id, permissions.name, permissions.description, permissions.status');
		$this->db->from('permissions');

   		if ($count) {
   			return $this->db->count_all_results();
   		}

		if (isset($filter['status']) && ($filter['status'] == 'active' || $filter['status'] == 'inactive')) {
    		$this->db->where('permissions.status', $filter['status']);
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('id ASC');
    	}

		$query = $this->db->get();//echo $this->db->last_query()."<br>";
		return $query->result();
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

    	$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.updated_on, users.status, roles.role_name, roles.role_token, users.created_by, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, users.updated_by, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name, users.email_link');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');
		$this->db->join('users AS users_created', 'users.created_by = users_created.id', 'left');
		$this->db->join('users AS users_updated', 'users.updated_by = users_updated.id', 'left');
		$this->db->where('users.id', $id);
		$this->db->where('users.is_deleted', 0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();
		if(!empty($result)){
   			$result->meta = $this->get_user_meta($id);
   		}
   		return $result;
    }

    function get_user_meta($user_id) {
    	$user_id = (int) $user_id;

    	$this->db->from('user_meta');
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get();
		$meta = array();
		foreach ($query->result() as $key => $value) {
			// Add condition for string first letter is upper case
			$meta[$value->meta_key] = (gettype($value->meta_value) == 'string') ? ucwords($value->meta_value) : $value->meta_value;
		}
		//echo $this->db->last_query()."<br>";
		return $meta;
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

	function check_valid_email($tablename, $condition) {

		$this->db->where($condition);
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

	function get_category_name($id) {
		$id = (int) $id;
		
		$this->db->select('name');
		$this->db->from('categories');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row()->name;
	}
	
	function get_title_name($id) {
		$id = (int) $id;
		
		$this->db->select('name');
		$this->db->from('titles');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row()->name;
	}

	
	public function get_schedule_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('schedules.*, CONCAT(schedule_created.first_name, " ", schedule_created.last_name) as created_by_name, CONCAT(schedule_updated.first_name, " ", schedule_updated.last_name) as updated_by_name');
		$this->db->from('schedules');
		$this->db->join('users AS schedule_created', 'schedules.created_by = schedule_created.id', 'left');
		$this->db->join('users AS schedule_updated', 'schedules.updated_by = schedule_updated.id', 'left');
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('schedules.is_deleted', $filter['deleted']);
   		}

		if ($count) {
            $this->db->group_by("schedules.id");
            $query = $this->db->get();
            return $query->num_rows();
   		}
		
		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('id ASC');
		}

		$this->db->group_by("schedules.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}
	
	// ===== Start Code ======= //
	// Create new function for assigned school presenter by: Ahmed on: 2019-08-01
	public function get_school_presenter($filter = array(), $order = null, $dir = null, $count = false) 
	{
		$this->db->select('order_assigned_presenters.*, users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.status');
		$this->db->from('order_assigned_presenters');
		$this->db->join('orders', 'orders.id = order_assigned_presenters.order_id');
		$this->db->join('users', 'order_assigned_presenters.presenter_id = users.id');

		if (isset($filter['school_id']) && $filter['school_id'] !== "") {
			$this->db->where('orders.school_id', $filter['school_id']);
		}
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
			$this->db->where('users.is_deleted', $filter['deleted']);
		}
		if (isset($filter['status']) && $filter['status'] !== "") {
			$this->db->where('users.status', $filter['status']);
		}

		if ($order <> null) {
			$this->db->order_by('order_assigned_presenters.'.$order, $dir);
		}

		$this->db->group_by('order_assigned_presenters.presenter_id');

		$query = $this->db->get();

   		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}
   		return $result;		 
	}	

	//  ==== End Of the Code =======//
	
	
	/*
	Following Methods will be dealing
	with add / update and fetch settings
	data 
	*/
	public function get_settings_data()
	{
		$this->db->select('*');
		$this->db->from('site_settings');
		
		$settings_query = $this->db->get();
		$settings_num	= $settings_query->num_rows();
		
		if($settings_num > 0)
		{
			$settings_query_obj = $settings_query->result();
			
			$return_array = array();
			foreach($settings_query_obj as $values)
			{
				$return_array[$values->token] = $values->value;
			}
			return $return_array;
		}
		else
		{
			return false;
		}
	}

	public function update_settings_data($data_update)
	{
		foreach($data_update['token'] as $key=>$val)
		{
			$this->db->select('*');
			$this->db->from('site_settings');
			$this->db->where('token', $key);

			$update_query 	= $this->db->get();
			$update_num		= $update_query->num_rows();
			
			$data['token'] 	= $key;
			$data['value'] 	= $val;

			if($update_num > 0)
			{
				$this->db->where('token', $key);
				$this->db->update('site_settings', $data);				
			}
			else
			{
				$this->db->insert('site_settings', $data);
			}		
		}
		return true;
	}

	public function get_presenter_by_id($co_id,$presenter_id)
	{
		$this->db->select('coordinator_presentator_school.*, users.id as presenter,users.*');
		$this->db->from('coordinator_presentator_school');
		$this->db->join('users', 'coordinator_presentator_school.presenter_id = users.id');
		$this->db->where('presenter_id',$presenter_id);
		$this->db->where('coordinator_id',$co_id);
		$query=$this->db->get();
		return $query->row();

	}

	public function update_presenter_school($co_id,$presenter_id,$data)
	{
		$this->db->where('coordinator_id', $co_id);
		$this->db->where('presenter_id', $presenter_id);

    	if ($this->db->update('coordinator_presentator_school', $data)) {
    		return true;
    	} else {
    		return false;
    	}
	}


	public function get_all_sessions($filter = array(), $order = null, $dir = null, $count = false)
	{
		$co_id=$this->session->userdata('id');

		 // if(isset($filter['presenter']) && $filter['presenter'] !== "")
   //      {
   //         $this->db->select('order_id');
   //         $this->db->from('order_assigned_presenters');
   //         $this->db->where('presenter_id', $filter['presenter']);

   //         $query       = $this->db->get();
   //         $array       = $query->result_array(); 
   //         $order_ids   = array();

   //         if(!empty($array))
   //          {
   //             foreach ($array as $key => $value) 
   //              {
   //                 # code...
   //                 $order_ids[] = $value['order_id']; 
   //              }
   //          }
   //          else
   //          {
   //              $order_ids = NULL;
   //          }
   //      }

       $this->db->select('orders.id,orders.order_no,orders.school_id,orders.created_on,orders.coordinator_id,orders.hours, order_schedules.order_id,order_schedules.start_date,order_schedules.end_date,order_schedules.status,order_assigned_presenters.presenter_id,users.id,CONCAT(users.first_name, " ", users.last_name) as presenter,CONCAT(user_school.first_name, " ", user_school.last_name) as school,order_schedules.total_hours');
		$this->db->from('orders');
		$this->db->join('order_schedules', 'orders.id = order_schedules.order_id');
		$this->db->join('order_assigned_presenters', 'orders.id = order_assigned_presenters.order_id');
		$this->db->join('users', 'orders.presenter_id = users.id', 'left');
		$this->db->join('users AS user_school', 'orders.school_id = user_school.id', 'left');

	

		$this->db->where('orders.coordinator_id', $co_id);
		$this->db->where('orders.is_deleted', 0);
  
        if (isset($filter['start_date']) && $filter['start_date'] !== "") {
            $start_date = str_replace('~', '/', $filter['start_date']);
            $start_date = $this->format_date($start_date);
			$this->db->like('order_schedules.start_date', $start_date);
        }
       
        if (isset($filter['school']) && $filter['school'] !== "") {
            $this->db->where('orders.school_id', $filter['school']);
           }

        if (isset($filter['presenter']) && $filter['presenter'] !== "") {
            $this->db->where('orders.presenter_id', $filter['presenter']);
           }
//echo $filter['status'];die;
        
        if (isset($filter['status']) && $filter['status'] !== "") {
            $this->db->where('order_schedules.status', $filter['status']);
        }
        
        if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('orders.is_deleted', $filter['deleted']);
        }

        // if (isset($filter['billing_date']) && $filter['billing_date'] !== "") {
        //     $this->db->where('order_schedules.end_date <', $filter['billing_date']);
        // }

     

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

        $query = $this->db->get();
        $result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->school_id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}

//echo "<pre>";print_r($query->result());die;

        return $query->result();
	}
	public function get_all_sessions_search($co_id)
	{
		$this->db->select('orders.id,orders.order_no,orders.school_id,orders.coordinator_id,orders.hours, order_schedules.order_id,order_schedules.start_date,order_schedules.end_date,order_schedules.status,order_assigned_presenters.presenter_id,users.id,CONCAT(users.first_name, " ", users.last_name) as presenter,CONCAT(user_school.first_name, " ", user_school.last_name) as school');
		$this->db->from('orders');
		$this->db->join('order_schedules', 'orders.id = order_schedules.order_id');
		$this->db->join('order_assigned_presenters', 'orders.id = order_assigned_presenters.order_id');
		$this->db->join('users', 'orders.presenter_id = users.id');
		$this->db->join('users AS user_school', 'orders.school_id = user_school.id', 'left');

	

		$this->db->where('orders.coordinator_id', $co_id);
		$this->db->where('orders.is_deleted', 0);

		$this->db->group_by('users.id');
		//$this->db->group_by('orders.school_id');
		$query=$this->db->get();
		
		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->school_id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}
   		return $result;
		//return $query->result();
	}

	private function format_date($date) {
		if($date == "") {
			return "";
		}
		return date('Y-m-d', strtotime($date));
	}

	public function get_mail($id)
	{
		$this->db->select('users.email');
		$this->db->from('users');
		$this->db->where('users.id',$id);

		$query=$this->db->get();
		return $query->row();
	}

	public function get_users_list_search()
	{
		$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.status, users.headerImg, roles.role_name,CONCAT(users.first_name, " ", users.last_name) as presenter');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');
		$this->db->where('users.is_deleted',0);
		$this->db->where('users.status','active');
		$this->db->where('users.role_id',3);
		$this->db->group_by("users.id");
    	$this->db->order_by('users.first_name ASC');
		$query = $this->db->get();
   		//echo $this->db->last_query()."<br>";
		
   		$result = array();
		$i = 0;

		foreach ($query->result() as $key => $row) {
			$result[$i] = $row;
			$result[$i]->meta = $this->get_user_meta($row->id);
			
			/*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
				$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
			}*/
			$i++;
		}
   		return $result;
	}


	## --------------- End of the code -------------- ##	


}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
