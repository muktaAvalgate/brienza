<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {


	/**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_log_list($filter = array(), $order = null, $dir = null, $count = false) {

    	//$this->db->distinct();
    	$this->db->select('app_logs.id, app_logs.type, app_logs.subtype, app_logs.title, app_logs.description, app_logs.created_on, app_logs.created_by, CONCAT(log_users.first_name, " ", log_users.last_name) as created_by_name');
		$this->db->from('app_logs');
   		$this->db->join('users AS log_users', 'app_logs.created_by = log_users.id', 'left');

    	if (isset($filter['type']) && $filter['type'] <> "") {
      		$this->db->where('app_logs.type', $filter['type']);
    	}

		if (isset($filter['subtype']) && $filter['subtype'] <> "") {
    		$this->db->where('app_logs.subtype', $filter['subtype']);
   		}

		if (isset($filter['title']) && $filter['title'] <> "") {
    		$this->db->like('app_logs.title', $filter['title']);
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
   			$this->db->order_by('created_on DESC');
    	}

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>"; die;
		return $query->result();
  	}





}

/* End of file Report_model.php */
/* Location: ./application/modules/Report/models/Report_model.php */
