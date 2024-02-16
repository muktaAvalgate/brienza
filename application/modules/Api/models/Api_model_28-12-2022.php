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


	
 

}
?>