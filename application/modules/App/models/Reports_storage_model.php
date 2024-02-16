<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_storage_model extends CI_Model {


	 protected $current_level, $level;


    /**
     *
     * @param $tablename
     * @param $data
     */
    function insert($tablename, $data) {
        //echo $table_name;die;

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

  public function get_reports_list($filter = array(), $order = null, $dir = null, $count = false) {


        $this->db->select('reports_storage.id, reports_storage.title, reports_storage.file, reports_storage.created_on');
        $this->db->from('reports_storage');
        $this->db->where('reports_storage.is_deleted',0);
        
  
        if (isset($filter['created_on']) && $filter['created_on'] > 0) {
        $this->db->where('reports_storage.created_on', $filter['created_on']);
        }
        
     
        if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('reports_storage.is_deleted', $filter['deleted']);
        }
        
      
        if (isset($filter['s_by']) && $filter['s_by'] <> "") {
          $this->db->order_by($filter['s_by'], $filter['s_dir']);
          } 
        else if ($order <> null) {
                $this->db->order_by($order, $dir);
          } 
        else {
            $this->db->order_by('reports_storage.id DESC');
         }
       
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        $result=$query->result();
      
        //echo '<pre>';print_r($result);die;
        return $result;
    }

    function get_report_details($id) {
         $id = (int) $id;

          $this->db->select('reports_storage.id, reports_storage.title, reports_storage.file, reports_storage.created_on');
          $this->db->from('reports_storage');
          
          $this->db->where('reports_storage.id', $id);
          $this->db->where('reports_storage.is_deleted', 0);

          $query = $this->db->get();
          //echo $this->db->last_query()."<br>";die;
            $result = $query->row();
            
            return $result;
    }


}
