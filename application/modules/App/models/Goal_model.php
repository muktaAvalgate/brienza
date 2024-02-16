<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goal_model extends CI_Model {

	 protected $current_level, $level;


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
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_goals_list($filter = array(), $order = null, $dir = null, $count = false) {


		$this->db->select('goals.id, goals.title, goals.start_date, goals.end_date, goals.amount, goals.status');
		$this->db->from('goals');
		//$this->db->join('roles', 'users.role_id = roles.id');

		if (isset($filter['status']) && ($filter['status'] == 'active' || $filter['status'] == 'inactive')) {
    		$this->db->where('goals.status', $filter['status']);
   		}

		// if (isset($filter['role']) && $filter['role'] <> 0) {
  //   		$this->db->where('users.role_id', $filter['role']);
  //  		}
		
		// if (isset($filter['role_token']) && $filter['role_token'] <> "") {
  //   		$this->db->where('roles.role_token', $filter['role_token']);
  //  		}
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('goals.is_deleted', $filter['deleted']);
   		}
		
   		// if ($count) {

   		// 	echo  $this->db->count_all_results();die;
   		// }

		// if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
  //   		$this->db->limit($filter['limit'], $filter['offset']);
  //  		}
//echo 'kj';die;
   		// if ($order <> null) {
    	// 	$this->db->order_by($order, $dir);
    	// } else {
   		// 	$this->db->order_by('users.updated_on ASC');
    	// }

    	//$this->db->group_by("goals.id");
		$query = $this->db->get();
   		//echo $this->db->last_query()."<br>";die;
   		$result=$query->result_array();
		//echo 'kj';die;
  //  		$result = array();
		// $i = 0;

		// foreach ($query->result() as $key => $row) {
		// 	$result[$i] = $row;
		// 	$result[$i]->meta = $this->get_user_meta($row->id);
			
		// 	if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
		// 		$result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
		// 	}
		// 	$i++;
		// }
		//echo '<pre>';print_r($result);die;
   		return $result;
    }

      function get_goal_details($id) {
    	$id = (int) $id;

    	$this->db->select('goals.id, goals.title, goals.start_date, goals.end_date, goals.amount, goals.status');
		$this->db->from('goals');
		
		$this->db->where('goals.id', $id);
		$this->db->where('goals.is_deleted', 0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();
   		
   		return $result;
    }
}