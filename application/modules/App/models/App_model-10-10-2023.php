<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends CI_Model {

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
	function deleteData($tablename, $column_name, $id) {
    	$id = (int) $id;

    	if ($id) {
    		$this->db->where($column_name, $id);
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
     * @param $bar_id
     * @return array
     */
    function get_title_details($id) {
    	$id = (int) $id;

    	$this->db->select('titles.*, CONCAT(titles_created.first_name, " ", titles_created.last_name) as created_by_name, CONCAT(titles_updated.first_name, " ", titles_updated.last_name) as updated_by_name');
		$this->db->from('titles');
		$this->db->join('users AS titles_created', 'titles.created_by = titles_created.id', 'left');
		$this->db->join('users AS titles_updated', 'titles.updated_by = titles_updated.id', 'left');
		$this->db->where('titles.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();
   	
		$result->topics = $this->get_title_topic_data($id);

   		return $result;
    }

    // Add new function by Ahmed
    // Start Code 2019-07-18
    function get_title_topic_data($title_id){

        $this->db->select('title_topics.*');
        $this->db->from('title_topics');
        $this->db->where('title_id', $title_id);

        return $this->db->get()->result();

    }
    // end code 2019-07-18

    function get_title_topics($title_id) {
    	$title_id = (int) $title_id;

    	$this->db->from('title_topics');
    	$this->db->where('title_id', $title_id);

    	$query = $this->db->get();
		$data = array();
		foreach ($query->result() as $key => $value) {
			$data[$value->id] = $value->topic;
		}
		return $data;
    }

   function get_title_topics_des($title_id)
    {
        $title_id = (int) $title_id;

        $this->db->from('title_topics');
        $this->db->where('title_id', $title_id);

        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $key => $value) {
            $data[$value->id]['topic_name'] = $value->topic;
            $data[$value->id]['topic_des'] = $value->description;
            $data[$value->id]['topic_id'] = $value->id;
        }
        return $data;
    }

    /**
     *
     * @param $filter
     */
    function get_title_list($filter = array()) {

    	$this->db->select('titles.*, CONCAT(titles_created.first_name, " ", titles_created.last_name) as created_by_name, CONCAT(titles_updated.first_name, " ", titles_updated.last_name) as updated_by_name');
		$this->db->from('titles');
		$this->db->join('users AS titles_created', 'titles.created_by = titles_created.id', 'left');
		$this->db->join('users AS titles_updated', 'titles.updated_by = titles_updated.id', 'left');
		
    	if (isset($filter['status']) && $filter['status'] <> "") {
   			$this->db->where('titles.status', $filter['status']);
   		}
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('titles.is_deleted', $filter['deleted']);
   		}

   		$this->db->order_by('name ASC');

		$this->db->group_by("titles.id");

   		$query = $this->db->get();
   		//$query = $this->db->get();
   		//echo $this->db->last_query()."<br>";
   		return $query->result();
    }

	/**
	 *
	 * @param unknown_type $title_id
	 * @param unknown_type $meta
	 */
    // Modified replace_title_topic() function by Ahmed on 2019-12-04
	function replace_title_topic($title_id, $topics = array(), $description = array()) {

		$title_id = (int) $title_id;
		if ($title_id <= 0) {
			return false;
		}
		if (empty($topics)) {
			return false;
		}

		// First Delete
		$this->db->where('title_id', $title_id);
		$this->db->delete('title_topics');

		foreach($topics as $key => $value) {
    		$data = array(
						'title_id' => $title_id,
					    'topic'  => htmlspecialchars($value, ENT_QUOTES, 'utf-8'),
                        'description'  => htmlspecialchars($description[$key], ENT_QUOTES, 'utf-8')
					);
			$this->db->insert('title_topics', $data);
    	}
    	return;
	}

    function update_title_topic($title_id, $topics = array(), $description = array(), $topic_title_id = array()) {

        $title_id = (int) $title_id;
        if ($title_id <= 0) {
            return false;
        }
        if (empty($topics)) {
            return false;
        }

        foreach($topic_title_id as $key => $value) {
            if($value > 0){
				if (array_key_exists($key,$topics)) { 
					$data = array(
						'topic'  => htmlspecialchars($topics[$key], ENT_QUOTES, 'utf-8'),
						'description'  => htmlspecialchars($description[$key], ENT_QUOTES, 'utf-8')
					);

					$this->db->where('title_id', $title_id);
					$this->db->where('id', $value);
					$this->db->update('title_topics', $data);
				}   //added 09-09-2021
                else{   
                    $this->delete_single_title_topic($value);     //added 09-09-2021
                }  //added 09-09-2021 
            }elseif($value == 'new'){
				if (array_key_exists($key,$topics)) {  
					$data = array(
                        'title_id' => $title_id,
                        'topic'  => htmlspecialchars($topics[$key], ENT_QUOTES, 'utf-8'),
                        'description'  => htmlspecialchars($description[$key], ENT_QUOTES, 'utf-8')
                    );
					$this->db->insert('title_topics', $data);
				}
            }
        }
        return;
    }


	/*public function get_category_by_parent($search = array()) {

        $this->db->select('categories.*, CONCAT(categories_created.first_name, " ", categories_created.last_name) as created_by_name, CONCAT(categories_updated.first_name, " ", categories_updated.last_name) as updated_by_name');
        $this->db->from('categories');
        $this->db->join('users AS categories_created', 'categories.created_by = categories_created.id', 'left');
		$this->db->join('users AS categories_updated', 'categories.updated_by = categories_updated.id', 'left');

        if (isset($search['deleted']) && $search['deleted'] !== "") {
            $this->db->where('categories.is_deleted', $search['deleted']);
   		}

		if (isset($search['status']) && $search['status'] <> "") {
            $this->db->where('categories.status', $search['status']);
   		}

        if (isset($search['parent_id']) && $search['parent_id'] !== "") {
            $this->db->where('categories.parent_id', $search['parent_id']);
   		}
        $query = $this->db->get();

        //echo $this->db->last_query()."<br>";
        $result = array();

        if (!isset($search['level'])) {
        	$search['level'] = 0;
        } else {
        	$search['level']++;
        }

        if($query->num_rows())
        {
            foreach ($query->result() as $row)
            {
            	if (!isset($search['tag'])) {
            		$search['tag'] = '';
            	}

                if ($search['parent_id'] <> 0) {
                    $row->name = $search['tag']." ".$row->name;
                }

                //$no_of_product = $this->get_product_count($row->id);
                $no_of_product = 0;
                $no_of_subcategory = $this->get_subcategory_count($row->id);

                $result[] = array (
                	'id' => $row->id,
                	'name' => $row->name,
                	'status' => $row->status,
                	'parent_id' => $row->parent_id,
					'bonus' => '',
                	'no_of_product' => $no_of_product,
                	'no_of_subcategory' => $no_of_subcategory,
                    'created_by_name' => $row->created_by_name,
                    'created_on' => $row->created_on,
                    'updated_by_name' => $row->updated_by_name,
                    'updated_on' => $row->updated_on,
                	'level' => $search['level']
                );

                $res = array();

                //if ($search['parent_id'] == 0) {

                $arg['parent_id'] = $row->id;
                if (isset($search['status']) && $search['status'] <> "") {
	                   $arg['status'] = $search['status'];
                }
                if (isset($search['deleted']) && $search['deleted'] !== "") {
	                   $arg['deleted'] = $search['deleted'];
                }
                $arg['level'] = $search['level'];
                $arg['tag'] = $search['tag'].$search['tag'];
                //print "<pre>"; print_r($arg); print "</pre>";
                $res = $this->get_category_by_parent($arg);
                //}

                $result = array_merge($result, $res);

            }
        }
        //print "<pre>"; print_r($result); print "</pre>";
        return $result;
    }




	public function get_subcategory_count($category_id) {

        $this->db->select('count(*) as count');
        $this->db->from('categories');
        $this->db->where('parent_id', $category_id);

        $query = $this->db->get();
   	   	$result = $query->row();
   		return $result->count;
    }
*/




    /**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_teacher_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('teachers.*, user_meta.meta_value as school_name, titles.name as title_name, grades.name as grade_name, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name, ');
		$this->db->from('teachers');
        $this->db->join('users as schools', 'schools.id = teachers.school_id');
		$this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
		$this->db->join('grades', 'grades.id = teachers.grade_id');
		$this->db->join('titles', 'titles.id = teachers.title_id');
        $this->db->join('users AS users_created', 'teachers.created_by = users_created.id', 'left');
        $this->db->join('users as users_updated', 'teachers.updated_by = users_updated.id', 'left');

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('teachers.is_deleted', $filter['deleted']);
   		}

        if (isset($filter['name']) && $filter['name'] != "") {
            $this->db->like('teachers.name', $filter['name']);
   		}

        if (isset($filter['category_id']) && $filter['category_id'] > 0) {
            $this->db->where('teachers.category_id', $filter['category_id']);
   		}
		
		if (isset($filter['school_id']) && $filter['school_id'] > 0) {
            $this->db->where('teachers.school_id', $filter['school_id']);
   		}

		if (isset($filter['status']) && ($filter['status'] == 'active' || $filter['status'] == 'inactive')) {
    		$this->db->where('teachers.status', $filter['status']);
   		}


   		if ($count) {
            $this->db->group_by("teachers.school_id");
            $query = $this->db->get();
            return $query->num_rows();

            //$this->db->distinct();
   			//echo $this->db->count_all_results();
            //echo $this->db->last_query()."<br>";die;
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('users.updated_on DESC');
    	}

    	$this->db->group_by("teachers.school_id");

		$query = $this->db->get();

   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();
    }

	/**
     *
     * @param $user_id
     * @return array
     */
    function get_teacher_details($id) {
    	$id = (int) $id;

    	$this->db->select("teachers.*, CONCAT(schools.first_name, ' ', schools.last_name) as school_name, CONCAT(teachers_created.first_name, ' ', teachers_created.last_name) as created_by_name, CONCAT(teachers_updated.first_name, ' ', teachers_updated.last_name) as updated_by_name");
		$this->db->from('teachers');
        $this->db->join('users as schools', 'schools.id = teachers.school_id');
		$this->db->join('users AS teachers_created', 'teachers.created_by = teachers_created.id', 'left');
		$this->db->join('users AS teachers_updated', 'teachers.updated_by = teachers_updated.id', 'left');
		$this->db->where('teachers.id', $id);
        $this->db->group_by("teachers.id");

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
    }
	
	
	
	
	public function get_cms_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('cms.*, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
		$this->db->from('cms');
		$this->db->join('users AS users_updated', 'cms.updated_by = users_updated.id', 'left');

		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('id ASC');
		}

		$this->db->group_by("cms.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}


	/**
     *
     * @param $id
     * @return array
     */
    function get_cms_details($id) {
    	$id = (int) $id;

    	$this->db->select('cms.*, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
		$this->db->from('cms');
		$this->db->join('users AS users_updated', 'cms.updated_by = users_updated.id', 'left');
		$this->db->where('cms.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
    }
	
	
	/**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_school_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('schools.*, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name, ');
		$this->db->from('schools');
        $this->db->join('users AS users_created', 'schools.created_by = users_created.id', 'left');
        $this->db->join('users as users_updated', 'schools.updated_by = users_updated.id', 'left');

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('schools.is_deleted', $filter['deleted']);
   		}


   		if ($count) {
            $this->db->group_by("schools.id");
            $query = $this->db->get();
            return $query->num_rows();

            //$this->db->distinct();
   			//echo $this->db->count_all_results();
            //echo $this->db->last_query()."<br>";die;
   		}

		if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
    		$this->db->limit($filter['limit'], $filter['offset']);
   		}

   		if ($order <> null) {
    		$this->db->order_by($order, $dir);
    	} else {
   			$this->db->order_by('updated_on DESC');
    	}

    	$this->db->group_by("schools.id");

		$query = $this->db->get();

   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();
    }
	
	
	/**
     *
     * @param $user_id
     * @return array
     */
    function get_school_details($id) {
    	$id = (int) $id;

    	$this->db->select("schools.*, CONCAT(schools_created.first_name, ' ', schools_created.last_name) as created_by_name, CONCAT(schools_updated.first_name, ' ', schools_updated.last_name) as updated_by_name");
		$this->db->from('schools');
		$this->db->join('users AS schools_created', 'schools.created_by = schools_created.id', 'left');
		$this->db->join('users AS schools_updated', 'schools.updated_by = schools_updated.id', 'left');
		$this->db->where('schools.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
    }
	
    function get_school_data($id) {
        $id = (int) $id;

        $this->db->select("users.*, CONCAT(schools_created.first_name, ' ', schools_created.last_name) as created_by_name, CONCAT(schools_updated.first_name, ' ', schools_updated.last_name) as updated_by_name");
        $this->db->from('users');
        $this->db->join('users AS schools_created', 'users.created_by = schools_created.id', 'left');
        $this->db->join('users AS schools_updated', 'users.updated_by = schools_updated.id', 'left');
        $this->db->where('users.id', $id);

        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        return $query->row();
    }
	
	/**
	 *
	 * @param unknown_type $filter
	 * @param unknown_type $order
	 * @param unknown_type $dir
	 * @param unknown_type $count
	 */
	public function get_order_list_old($filter = array(), $order = null, $dir = null, $count = false) {

		//$this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(presenters.first_name, " ", presenters.last_name) as teacher_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, titles.name as title_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled');

        $this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, titles.name as title_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled');    
		$this->db->from('orders');
		$this->db->join('titles', 'orders.title_id = titles.id');
		$this->db->join('users AS schools', 'orders.school_id = schools.id');
		$this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");
		//$this->db->join('users AS presenters', 'orders.presenter_id = presenters.id');
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users AS orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('order_schedules', 'orders.id = order_schedules.order_id', 'left');
		
		/*if (isset($filter['order_start_date']) && $filter['order_start_date'] !== "") {
			$order_start_date = str_replace('~', '/', $filter['order_start_date']);
			$order_start_date = $this->format_date($order_start_date);
				
            $this->db->where('orders.created_on >=', $order_start_date);
   		}
		
		if (isset($filter['order_end_date']) && $filter['order_end_date'] !== "") {
			$order_end_date = str_replace('~', '/', $filter['order_end_date']);
			$order_end_date = $this->format_date($order_end_date);
			
            $this->db->where('orders.created_on <=', $order_end_date);
   		}*/
		
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
		
		if (isset($filter['presenter']) && $filter['presenter'] !== "") {
            $this->db->where('orders.presenter_id', $filter['presenter']);
   		}
		
		if (isset($filter['school']) && $filter['school'] !== "") {
            $this->db->where('orders.school_id', $filter['school']);
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

            //$this->db->distinct();
   			//echo $this->db->count_all_results();
            //echo $this->db->last_query()."<br>";die;
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

   		//echo $this->db->last_query()."<br>";die;
   		return $query->result();
    }
	
    /**
     *
     * @param unknown_type $filter
     * @param unknown_type $order
     * @param unknown_type $dir
     * @param unknown_type $count
     */
    public function get_order_list($filter = array(), $order = null, $dir = null, $count = false) 
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
        if($this->session->userdata('role') == 'teacher'){
            $selectQuery = ', order_assigned_presenters.assigned_hours';
            $appendCondForPersenter = ' LEFT JOIN order_assigned_presenters ON order_schedules.presenter_id="'.$this->session->userdata('id').'" AND orders.id=order_assigned_presenters.order_id';
            $scheduleByPresenter = '  AND order_schedules.created_by = "'.$this->session->userdata('id').'"';
        }else{
            $selectQuery = '';
            $appendCondForPersenter = '';
            $scheduleByPresenter = '';
        }

        $this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, titles.name as title_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id'.$scheduleByPresenter.') AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled'.$selectQuery);
        $this->db->from('orders');
        $this->db->join('titles', 'orders.title_id = titles.id');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");
        //$this->db->join('users AS presenters', 'orders.presenter_id = presenters.id');
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users AS orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('order_schedules', 'orders.id = order_schedules.order_id', 'left');

        if($this->session->userdata('role') == 'teacher'){
            $this->db->join('order_assigned_presenters', 'orders.id = order_assigned_presenters.order_id AND order_assigned_presenters.presenter_id="'.$this->session->userdata('id').'"', 'left');
        }

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

        if(isset($filter['presenter']) && $filter['presenter'] !== "")
        {
            if(!empty($order_ids))
                $this->db->where_in('orders.id', $order_ids);
            else
                $this->db->where('orders.id', 0);
        }

        if($this->session->userdata('role') != 'school_admin'){
            if (isset($filter['session']) && $filter['session'] !== "") {
                if($filter['session'] == 1){
                    $this->db->where('orders.session_id >', 0);    
                }else{
                    $this->db->where('orders.session_id', $filter['session']);
                }
            }
        }

        //presenter's wise session
        if (isset($filter['presenter_session']) && $filter['presenter_session'] !== "") {
            if($filter['presenter_session'] == 1){
                $this->db->where('orders.session_id >', 0);    
            }else{
                $this->db->where('orders.session_id', $filter['presenter_session']);
            }
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

        $query = $this->db->get();

        return $query->result();
    }
    function get_confirm_hours($order_id){
        $this->db->select('sum(total_hours) as total');
        $this->db->from('order_schedules');
        $this->db->where('status', 'Confirm hours');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row()->total;
    }
    ## ------------ End of the code ----------------- ## 
    
    /**
    Following method is replica of 
    orlisting method used to list
    element from order temp
    Created on: 20-06-2019
    Created by: Soumya
    **/
    public function get_order_list_coordinator($filter = array(), $order = null, $dir = null, $count = false) {

        $this->db->select('orders_temp.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, titles.name as title_name');

        $this->db->from('orders_temp');
        $this->db->join('titles', 'orders_temp.title_id = titles.id');
        $this->db->join('users AS schools', 'orders_temp.school_id = schools.id');
        $this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");

        $this->db->join('users AS orders_created', 'orders_temp.created_by = orders_created.id', 'left');
        $this->db->join('users AS orders_updated', 'orders_temp.updated_by = orders_updated.id', 'left');
        
        
        if (isset($filter['order_start_date']) && $filter['order_start_date'] !== "") {
            $booking_start_date = str_replace('~', '/', $filter['order_start_date']);
            $booking_start_date = $this->format_date($booking_start_date);
                
            $this->db->where('orders_temp.booking_date >=', $booking_start_date);
        }
        
        if (isset($filter['order_end_date']) && $filter['order_end_date'] !== "") {
            $booking_end_date = str_replace('~', '/', $filter['order_end_date']);
            $booking_end_date = $this->format_date($booking_end_date);
            
            $this->db->where('orders_temp.booking_date <=', $booking_end_date);
        }
        
        if (isset($filter['order_no']) && $filter['order_no'] !== "") {
            $this->db->like('orders_temp.order_no', $filter['order_no'], 'after');
        }

        if (isset($filter['expire']) && $filter['expire'] !== "") {
            $this->db->like('orders_temp.expired_on', $filter['expire'], 'after');
        }        
        
        if (isset($filter['school']) && $filter['school'] !== "") {
            $this->db->where('orders_temp.school_id', $filter['school']);
           }
        
        // This part has been added on 11-06-2019 for coordinatrs ...   
        if (isset($filter['coordinator']) && $filter['coordinator'] !== "~") {
            $this->db->where('orders_temp.coordinator_id', $filter['coordinator']);
        }          
        
        if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('orders_temp.is_deleted', $filter['deleted']);
        }

        if ($count) {
            $this->db->group_by("orders_temp.id");
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

        $this->db->group_by("orders_temp.id");

        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        return $query->result();
    }
    ## ---------- End of the code ------------- ##  
    
    
    /**
     *
     * @param $user_id
     * @return array
     */
    function get_order_details_old($id) {
        $id = (int) $id;

        $this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(presenters.first_name, " ", presenters.last_name) as teacher_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, titles.name as title_name, presenters.headerImg, schools.first_name as principle_name');
        $this->db->from('orders');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->join('users AS presenters', 'orders.presenter_id = presenters.id');
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users as orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('titles', 'orders.title_id = titles.id', 'left');
        $this->db->where('orders.id', $id);

        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        return $query->row();
    }
    
    function get_order_data($id) {
        $id = (int) $id;

        $this->db->select('orders.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, titles.name as title_name, schools.first_name as principle_name');
        $this->db->from('orders');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users as orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('titles', 'orders.title_id = titles.id', 'left');
        $this->db->where('orders.id', $id);

        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        return $query->row();
    }
    
    /**
    New version of get_order_details 
    has been introdued for new implementation
    Created on: 23-06-2019
    Creaed by: Soumya
    **/
    function get_order_details($id, $presenter_id='') {
        $id = (int) $id;

        $this->db->select('orders.*, user_meta.meta_value as school_name, p_company.meta_value as company_name, p_phone.meta_value as presenter_phone, p_address.meta_value as presenter_address, p_rate.meta_value as hourly_rate, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, (SELECT SUM(total_hours) FROM order_schedules WHERE order_id = orders.id) AS total_hours_scheduled, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, titles.name as title_name, titles.public_school_title_status as public_school_title_status, schools.first_name as principle_name, CONCAT(presenters.first_name, " ", presenters.last_name) as teacher_name, presenters.headerImg');
        $this->db->from('orders');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->join('order_assigned_presenters AS assigned_presenters', 'orders.id = assigned_presenters.order_id', 'left');
        $this->db->join('users AS presenters', 'assigned_presenters.presenter_id = presenters.id', 'left');
        $this->db->join('user_meta AS p_company', 'assigned_presenters.presenter_id = p_company.user_id AND p_company.meta_key = \'company_name\'', 'left');
        $this->db->join('user_meta AS p_phone', 'assigned_presenters.presenter_id = p_phone.user_id AND p_phone.meta_key = \'phone\'', 'left');
        $this->db->join('user_meta AS p_rate', 'assigned_presenters.presenter_id = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('user_meta AS p_address', 'assigned_presenters.presenter_id = p_address.user_id AND p_address.meta_key = \'address\'', 'left'); //Update by Ahmed
        $this->db->join('users AS orders_created', 'orders.created_by = orders_created.id', 'left');
        $this->db->join('users as orders_updated', 'orders.updated_by = orders_updated.id', 'left');
        $this->db->join('titles', 'orders.title_id = titles.id', 'left');
        $this->db->where('orders.id', $id);
        if($presenter_id !=''){
            $this->db->where('assigned_presenters.presenter_id', $presenter_id);
        }

        $query = $this->db->get();
        return $query->row();
    }

    /**
    Followig method will be used 
    to fetch data from orders_temp table
    Created on: 20-06-2019
    Created by: Soumya
    **/
    function get_temp_order_details($id) {
        $id = (int) $id;

        $this->db->select('orders_temp.*, user_meta.meta_value as school_name, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name,
            titles.name as title_name');
        $this->db->from('orders_temp');
        $this->db->join('users AS schools', 'orders_temp.school_id = schools.id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->join('users AS orders_created', 'orders_temp.created_by = orders_created.id', 'left');
        $this->db->join('users as orders_updated', 'orders_temp.updated_by = orders_updated.id', 'left');
        $this->db->join('titles', 'orders_temp.title_id = titles.id', 'left');
        $this->db->where('orders_temp.id', $id);

        $query = $this->db->get();
        return $query->row();
    }   
    
    ## ------------ End of the code ------------- ##

    /**
     * Method to create the list
     * of coordinators associated 
     * with school who will login
     */
    public function get_coordinator_list($filter = array(), $school_id, $order = null, $dir = null, $count = false)
    {
        $this->db->select('coordinator_id');
        $this->db->from('coordinator_presentator_school');
        $this->db->like('school_ids', $school_id);

        $get_matched_que = $this->db->get();
        $get_matched_arr = $get_matched_que->result_array();

        $mapped_coordinator_array = array();

        if(!empty($get_matched_arr)){
            foreach($get_matched_arr as $get_string)
            {
                $mapped_coordinator_array[] = $get_string['coordinator_id'];
            }
        }

        $this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.status, users.headerImg, roles.role_name');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id');
        
        if(!empty($mapped_coordinator_array))
          $this->db->where_in('users.id', $mapped_coordinator_array);
        else
            $this->db->where_in('users.id', 0);


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
            $result[$i]->meta = $this->Admin_model->get_user_meta($row->id);

            $this->db->select('coordinator_id, school_id, has_order_permission');
            $this->db->from('coordinator_permission');
            $this->db->where('coordinator_id', $row->id);
            $this->db->where('school_id', $school_id);

            $get_permission_que = $this->db->get();
            $get_permission_arr = $get_permission_que->row_array();

            $result[$i]->permissions = $get_permission_arr;

            
            /*if (isset($result[$i]->meta['title_id']) && $result[$i]->meta['title_id'] <> "") {
                $result[$i]->meta['title_name'] = $this->get_title_name($result[$i]->meta['title_id']);
            }*/
            $i++;
        }

        return $result;     
    }


    public function assign_permission($data)
    {
        $this->db->select('id');
        $this->db->from('coordinator_permission');
        $this->db->where('coordinator_id',  $data['coordinator_id']);
        $this->db->where('school_id',       $data['school_id']);

        $check_que = $this->db->get();
        $num_rows  = $check_que->num_rows();
        
        if($num_rows > 0)
        {
            $data_update['has_order_permission'] = $data['has_order_permission'];
            $data_update['updated_on']           = date("Y-m-d H:i:s");
            $data_update['notify_status'] = $data['notify_status'];

            $this->db->where('coordinator_id',  $data['coordinator_id']);
            $this->db->where('school_id',       $data['school_id']);
            // echo "<pre>";print_r($data_update);exit;
            $update_que = $this->db->update('coordinator_permission', $data_update);
        }
        else
        {
            $update_que = $this->db->insert('coordinator_permission', $data);
        }

        if($update_que)
            return true;
        else
            return false;   
    }

    /**
     * Method to get mapped schools
     * for a particular coordinator
     */
    public function get_mappedschool_list($filter = array(), $coordinator_id)
    {
        $this->db->select('school_ids');
        $this->db->from('coordinator_presentator_school');
        $this->db->where('coordinator_id', $coordinator_id);
        $this->db->where('is_deleted', 0);

        $get_schoolID_que = $this->db->get();
        $get_schoolID_arr = $get_schoolID_que->result_array();

        $result = array();
        
        if(!empty($get_schoolID_arr)){
            $id_string = '';
            foreach($get_schoolID_arr as $school_inner_value)
            {
                if(empty($id_string))
                    $id_string = $school_inner_value['school_ids'];
                else
                    $id_string .= ",".$school_inner_value['school_ids'];
            }

            $id_array = array_unique(explode(",", $id_string));

            $this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.status, users.headerImg, roles.role_name');
            $this->db->from('users');
            $this->db->join('roles', 'users.role_id = roles.id');
            $this->db->where_in('users.id', $id_array);

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

            $this->db->order_by('users.id DESC');   
            $this->db->group_by("users.id");
            
            $query = $this->db->get();
            
            $i = 0;

            foreach ($query->result() as $key => $row) {
                $result[$i] = $row;
                $result[$i]->meta = $this->get_user_meta($row->id);
                $i++;
            }
        }
        return $result;     
    }
	
	
	public function get_signup_questions_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('signup_questions.*, CONCAT(signup_questions_created.first_name, " ", signup_questions_created.last_name) as created_by_name, CONCAT(signup_questions_updated.first_name, " ", signup_questions_updated.last_name) as updated_by_name');
		$this->db->from('signup_questions');
		$this->db->join('users AS signup_questions_created', 'signup_questions.created_by = signup_questions_created.id', 'left');
		$this->db->join('users AS signup_questions_updated', 'signup_questions.updated_by = signup_questions_updated.id', 'left');
		
		if (isset($filter['question_group']) && $filter['question_group'] !== "") {
            $this->db->where('signup_questions.question_group', $filter['question_group']);
   		}
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('signup_questions.is_deleted', $filter['deleted']);
   		}
		
		if (isset($filter['status']) && $filter['status'] !== "") {
            $this->db->where('signup_questions.status', $filter['status']);
   		}
		
        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }

		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('id ASC');
		}

		$this->db->group_by("signup_questions.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}
	
	
	/**
     *
     * @param $id
     * @return array
     */
    function get_signup_questions_details($id) {
    	$id = (int) $id;

    	$this->db->select('signup_questions.*, CONCAT(signup_questions_created.first_name, " ", signup_questions_created.last_name) as created_by_name, CONCAT(signup_questions_updated.first_name, " ", signup_questions_updated.last_name) as updated_by_name');
		$this->db->from('signup_questions');
		$this->db->join('users AS signup_questions_created', 'signup_questions.created_by = signup_questions_created.id', 'left');
		$this->db->join('users AS signup_questions_updated', 'signup_questions.updated_by = signup_questions_updated.id', 'left');
		$this->db->where('signup_questions.id', $id);
        $this->db->where('signup_questions.is_deleted', 0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
   	}
	
	
	private function format_date($date) {
		if($date == "") {
			return "";
		}
		return date('Y-m-d', strtotime($date));
	}
	
	
	/*function get_user_by_email($email) {

    	$this->db->select('users.id, users.role_id, users.first_name, users.last_name, users.email, users.last_login, users.created_on, users.updated_on, users.status, roles.role_name, roles.role_token, users.created_by, CONCAT(users_created.first_name, " ", users_created.last_name) as created_by_name, users.updated_by, CONCAT(users_updated.first_name, " ", users_updated.last_name) as updated_by_name');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');
		$this->db->join('users AS users_created', 'users.created_by = users_created.id', 'left');
		$this->db->join('users AS users_updated', 'users.updated_by = users_updated.id', 'left');
		$this->db->where('users.email', $email);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();

   		$result->meta = $this->get_user_meta($result->id);

   		return $result;
	}
	
	function get_user_meta($user_id) {
    	$user_id = (int) $user_id;

    	$this->db->from('user_meta');
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get();
		$meta = array();
		foreach ($query->result() as $key => $value) {
			$meta[$value->meta_key] = $value->meta_value;
		}
		//echo $this->db->last_query()."<br>";
		return $meta;
    }*/
	
	
	public function get_grade_list($filter = array(), $order = null, $dir = null, $count = false) {

		$this->db->select('grades.*, CONCAT(grades_created.first_name, " ", grades_created.last_name) as created_by_name, CONCAT(grades_updated.first_name, " ", grades_updated.last_name) as updated_by_name');
		$this->db->from('grades');
		$this->db->join('users AS grades_created', 'grades.created_by = grades_created.id', 'left');
		$this->db->join('users AS grades_updated', 'grades.updated_by = grades_updated.id', 'left');
		
		if (isset($filter['question_group']) && $filter['question_group'] !== "") {
            $this->db->where('grades.question_group', $filter['question_group']);
   		}
		
		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('grades.is_deleted', $filter['deleted']);
   		}
		
		if (isset($filter['status']) && $filter['status'] !== "") {
            $this->db->where('grades.status', $filter['status']);
   		}
		
		if ($order <> null) {
			$this->db->order_by($order, $dir);
		} else {
			$this->db->order_by('id ASC');
		}

		$this->db->group_by("grades.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}
	
	/**
     *
     * @param $bar_id
     * @return array
     */
    function get_grade_details($id) {
    	$id = (int) $id;

    	$this->db->select('grades.*, CONCAT(grades_created.first_name, " ", grades_created.last_name) as created_by_name, CONCAT(grades_updated.first_name, " ", grades_updated.last_name) as updated_by_name');
		$this->db->from('grades');
		$this->db->join('users AS grades_created', 'grades.created_by = grades_created.id', 'left');
		$this->db->join('users AS grades_updated', 'grades.updated_by = grades_updated.id', 'left');
		$this->db->where('grades.id', $id);
        $this->db->where('grades.is_deleted', 0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
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
	
	/**
     *
     * @param $bar_id
     * @return array
     */
    function get_schedule_details($id) {
    	$id = (int) $id;

    	$this->db->select('schedules.*, CONCAT(schedule_created.first_name, " ", schedule_created.last_name) as created_by_name, CONCAT(schedule_updated.first_name, " ", schedule_updated.last_name) as updated_by_name');
		$this->db->from('schedules');
		$this->db->join('users AS schedule_created', 'schedules.created_by = schedule_created.id', 'left');
		$this->db->join('users AS schedule_updated', 'schedules.updated_by = schedule_updated.id', 'left');
		$this->db->where('schedules.id', $id);
        $this->db->where('schedules.is_deleted', 0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		$result = $query->row();
        if(!empty($result)){
            $result->workingdays = $this->get_schedule_workingdays($id);
            $result->holidays = $this->get_schedule_holidays($id);
            
            $result->holiday_details = $this->get_schedule_holidays_detail($id);
        }
		return $result;
   	}
	
	public function get_holiday_list($filter = array()) {

		$this->db->select('holidays.*');
		$this->db->from('holidays');
		
		if (isset($filter['batch']) && $filter['batch'] !== "") {
            $this->db->where('holidays.batch', $filter['batch']);
   		}
        if (isset($filter['start_date']) && $filter['start_date'] !== "") {
            $this->db->where('holidays.start_date >=', $filter['start_date']);
        }

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('holidays.is_deleted', $filter['deleted']);
   		}
		
		$this->db->order_by('start_date ASC');

		$this->db->group_by("holidays.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}
	
	/**
     *
     * @param $bar_id
     * @return array
     */
    function get_holiday_details($id) {
    	$id = (int) $id;

		$this->db->from('holidays');
		$this->db->where('holidays.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
   	}
	
	/**
	 *
	 * @param unknown_type $schedule_id
	 * @param unknown_type $holidays
	 */
	function replace_schedule_holidays($schedule_id, $holidays = array()) {

		$schedule_id = (int) $schedule_id;
		if ($schedule_id <= 0) {
			return false;
		}
		if (empty($holidays)) {
			return false;
		}

		// First Delete
		$this->db->where('schedule_id', $schedule_id);
		$this->db->delete('schedule_holidays');

		foreach($holidays as $holiday_id => $value) {
    		$data = array(
						'schedule_id' => $schedule_id,
					    'holiday_id'  => $holiday_id
					);
			$this->db->insert('schedule_holidays', $data);
    	}
    	return;
	}
	
	/**
	 *
	 * @param unknown_type $schedule_id
	 * @param unknown_type $workingdays
	 */
	function replace_schedule_workingdays($schedule_id, $workingdays = array()) {

		$schedule_id = (int) $schedule_id;
		if ($schedule_id <= 0) {
			return false;
		}
		if (empty($workingdays)) {
			return false;
		}

		// First Delete
		$this->db->where('schedule_id', $schedule_id);
		$this->db->delete('schedule_weekdays');

		foreach($workingdays as $workingday => $value) {
    		$data = array(
						'schedule_id' => $schedule_id,
					    'day'  => $workingday
					);
			$this->db->insert('schedule_weekdays', $data);
    	}
    	return;
	}
	
	function get_schedule_workingdays($schedule_id) {
    	$schedule_id = (int) $schedule_id;

    	$this->db->from('schedule_weekdays');
    	$this->db->where('schedule_id', $schedule_id);

    	$query = $this->db->get();
		$workingdays = array();
		foreach ($query->result() as $key => $value) {
			$workingdays[$value->day] = "Y";
		}
		//echo $this->db->last_query()."<br>";
		return $workingdays;
    }
	
	function get_schedule_holidays($schedule_id) {
    	$schedule_id = (int) $schedule_id;

    	$this->db->from('schedule_holidays');
    	$this->db->where('schedule_id', $schedule_id);

    	$query = $this->db->get();
		$holidays = array();
		foreach ($query->result() as $key => $value) {
			$holidays[$value->holiday_id] = "Y";
		}
		//echo $this->db->last_query()."<br>";
		return $holidays;
    }
	
	function get_schedule_holidays_detail($schedule_id) {
    	$schedule_id = (int) $schedule_id;

    	$this->db->from('schedule_holidays');
		$this->db->join('holidays', 'schedule_holidays.holiday_id = holidays.id');
    	$this->db->where('schedule_id', $schedule_id);
		$this->db->where('holidays.is_deleted', 0);
		
    	$query = $this->db->get();
		$holidays = array();
		
		foreach ($query->result() as $key => $value) {
			//$holidays[$value->holiday_id] = $value;
			if ($value->end_date == null) {
				$holidays[$value->start_date] = $value->name;
			} else {
				
				// Get the date difference
				$datetime1 = date_create($value->end_date);
				$datetime2 = date_create($value->start_date);
				$interval = date_diff($datetime1, $datetime2);
				
				$start_date =  new DateTime($value->start_date);
				$diff = $interval->format('%a');
				
				//print_r($start_date);
				
				for ($i=0; $i<=$diff; $i++) {
					
					if ($i == 0) {
						$holidays[$start_date->format('Y-m-d')] = $value->name;
					} else {
						$start_date->add(new DateInterval('P1D'));					
						$holidays[$start_date->format('Y-m-d')] = $value->name;
					}
				}
			}
		}
		//echo $this->db->last_query()."<br>";
		return $holidays;
    }
	
	public function get_worktype_list($filter = array()) {

		$this->db->select('worktypes.*');
		$this->db->from('worktypes');
		

		if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('worktypes.is_deleted', $filter['deleted']);
   		}
		
		$this->db->order_by('name ASC');

		$this->db->group_by("worktypes.id");

		$query = $this->db->get(); //echo $this->db->last_query()."<br>";
		return $query->result();
	}
	
	/**
     *
     * @param $bar_id
     * @return array
     */
    function get_worktype_details($id) {
    	$id = (int) $id;

		$this->db->from('worktypes');
		$this->db->where('worktypes.id', $id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		return $query->row();
   	}
	
	function get_school_titles($school_id) {
		$school_id = (int) $school_id;
		
		$this->db->select('school_titles.title_id, titles.name');
		$this->db->from('school_titles');
		$this->db->join('titles', 'school_titles.title_id = titles.id');
		$this->db->where('school_titles.school_id', $school_id);
        $this->db->where('school_titles.is_deleted', 0); // 10-07-2023

		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";die;
   		//return $query->result();
		$data = array();
		foreach ($query->result() as $key => $value) {
			$data[$value->title_id] = $value->name;
		}
		return $data;
	}
	
	function insert_order_topics($order_id, $topics = array()) {

		$order_id = (int) $order_id;
		if ($order_id <= 0) {
			return false;
		}
		if (empty($topics)) {
			return false;
		}

		foreach($topics as $key => $topic_id) {
    		$data = array(
				'order_id' => $order_id,
				'topic_id'  => $topic_id
			);
			$this->db->insert('order_topics', $data);
    	}
    	return;
	}
	
	function get_order_schedule($order_id=null, $presenter_id=null, $group_by='') {
		
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
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.id DESC');
            $this->db->group_by('order_schedule_status_log.old_status');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
	}
	
    function get_log_content($order_schedule_id){
        $order_schedule_id = (int) $order_schedule_id;

        $this->db->select('order_schedule_status_log.*, (SELECT content FROM order_schedule_status_log WHERE order_schedule_status_log.id="'.$order_schedule_id.'" AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content');
        $this->db->from('order_schedule_status_log');         
        $this->db->where('order_schedule_status_log.id', $order_schedule_id);
        
        $query = $this->db->get();
        return $query->row();
    }   
    
    function get_log_pdf_content($order_schedule_id){
        $order_schedule_id = (int) $order_schedule_id;

        $this->db->select('order_schedule_status_log.*, (SELECT content FROM order_schedule_status_log WHERE order_schedule_status_log.order_schedule_id="'.$order_schedule_id.'" AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content');
        $this->db->from('order_schedule_status_log');         

        $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
        $this->db->where('order_schedule_status_log.old_status','Log sent - awaiting principal signature');
        // $this->db->where('order_schedule_status_log.new_status','Awaiting Review');
        $this->db->where('order_schedule_status_log.new_status','Create invoice');

        
        $query = $this->db->get();
        return $query->row();
    }

	/**
     *
     * @param $bar_id
     * @return array
     */
    function get_order_schedule_details($id) {
    	$id = (int) $id;

    	$this->db->select('order_schedules.*, orders.order_no, orders.school_id, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name, order_schedule_status_log.attachment, log.attachment AS log_attachment, order_schedule_status_log.content, user_meta.meta_value AS school_name, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log" LIMIT 1) AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review" LIMIT 1) AS log_signature, users.first_name, users.last_name');
		$this->db->from('order_schedules');
		$this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
		$this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
		$this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
		$this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('order_schedule_status_log', "order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status", 'left');
        $this->db->join('order_schedule_status_log AS log', "order_schedules.id = log.order_schedule_id AND log.old_status = 'Log sent - awaiting principal signature'", 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_name'", "left outer");
		$this->db->join('users', "users.id = order_schedules.created_by", "left outer");
		$this->db->where('order_schedules.id', $id);
		
		$this->db->order_by('order_schedules.start_date ASC');

        $this->db->limit(1);
		
		$query = $this->db->get();		
   		return $query->row();
   	}
	
    function get_library_list($presenter_id = null) {
        
        $this->db->select('orders.*, titles.id as titles_id, titles.name as title_name, title_topics.description as topic_description');
        $this->db->from('orders');
        $this->db->join('titles', 'orders.title_id = titles.id');
        $this->db->join('title_topics', 'titles.id = title_topics.title_id');
        if ($presenter_id <> null) {
            $this->db->where('orders.presenter_id', $presenter_id);
        }
        $this->db->where('orders.is_deleted', 0);
        $this->db->where('orders.status', 'approved');
        
        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $key => $value) {
            
            $title_id = $value->title_id;
            
            $data[$value->id] = $value;
            $data[$value->id]->topics = $this->get_title_topics($title_id);         
        }
        return $data;
    }

    function get_library_list_des($presenter_id = null) {
        
        $this->db->select('orders.*, titles.id as titles_id,titles.name as title_name,title_topics.description as topic_description,title_topics.id as topic_id');
        $this->db->from('orders');
        $this->db->join('titles', 'orders.title_id = titles.id');
        $this->db->join('title_topics', 'titles.id = title_topics.title_id');
        if ($presenter_id <> null) {
            $this->db->where('orders.presenter_id', $presenter_id);
        }
        $this->db->where('orders.is_deleted', 0);
        $this->db->where('orders.status', 'approved');
        
        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $key => $value) {
            
            $title_id = $value->title_id;
            
            $data[$value->id] = $value;
            $data[$value->id]->topics = $this->get_title_topics_des($title_id);         
        }
        return $data;
    }

    function check_schedule_datetime($presenter_id = '', $start_date='', $end_date='') {

        $this->db->select('order_schedules.*');
        $this->db->from('order_schedules');
        
        if ($presenter_id != '') {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }
        if($start_date != '' && $end_date != ''){
            $where = '((start_date<="'.$start_date.'" AND end_date>"'.$start_date.'") OR (start_date<"'.$end_date.'" AND end_date>="'.$end_date.'"))';
            $this->db->where($where);
        }
        $this->db->join('orders', 'orders.id = order_schedules.order_id');
        $this->db->where('orders.is_deleted', 0);
        $query = $this->db->get();
        $data = $query->result();

        // echo $this->db->last_query();
        // echo "<pre>";print_r($data);exit;
        return $data;
    }

    // New function created by Ahmed on 2019-08-07
    function check_schedule_30min_diff($presenter_id = '', $start_date='', $end_date='',$schedule_id = null) {
        //$minus30mins = date('Y-m-d H:i:s', strtotime('-30 minutes', strtotime($start_date)));
        //$plus30mins = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($end_date)));
        $minus30mins = date('Y-m-d H:i:s', strtotime('-29 minutes', strtotime($start_date)));
        $plus30mins = date('Y-m-d H:i:s', strtotime('+29 minutes', strtotime($end_date)));
        $minus5hours = date('Y-m-d H:i:s', strtotime('-300 minutes', strtotime($start_date)));
        //echo $minus5hours;
        $this->db->select('order_schedules.*');
        $this->db->from('order_schedules');
        
        if ($presenter_id != '') {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }
        //$where = '(start_date<"'.$plus30mins.'" AND start_date>"'.$end_date.'") OR (end_date<"'.$start_date.'" AND end_date>"'.$minus30mins.'") OR (start_date>"'.$minus30mins.'" AND start_date<"'.$start_date.'") OR (end_date>"'.$end_date.'" AND end_date<"'.$plus30mins.'")';
        
        $where = ' ((start_date <= "'.$plus30mins.'" AND start_date >= "'.$end_date.'") OR (end_date <= "'.$start_date.'" AND end_date >= "'.$minus30mins.'") OR (start_date >= "'.$minus30mins.'" AND start_date <= "'.$start_date.'") OR (end_date >= "'.$end_date.'" AND end_date <= "'.$plus30mins.'"))';       
        
        $this->db->where($where);
        
        $query = $this->db->get();
        $data = $query->result();
        // //print_r($data);die;
        // //calculation 5 hours contineu task

        $this->db->select('sum(total_hours) as tot_hours');
        $this->db->from('order_schedules');
        $whereCon = ' created_by="'.$presenter_id.'" AND end_date >= "'.$minus5hours.'" AND end_date <= "'.$start_date.'"';
        $this->db->where($whereCon);
        if($schedule_id != null){
            $this->db->where_not_in('order_schedules.id', $schedule_id);
             }
        
        $tot_time_query = $this->db->get()->row();
        $tot_time = $tot_time_query->tot_hours;
        // if($tot_time >=5.0 && $data){
        //     return array('data'=>true);
        // }else{
        //     return array();
        // }
       // return $data;

        $this->db->select('*');
        $this->db->from('order_schedules');
        $whereCon = ' created_by="'.$presenter_id.'" AND end_date >= "'.$minus5hours.'" AND end_date <= "'.$start_date.'"';
        $this->db->where($whereCon);
        if($schedule_id != null){
            $this->db->where_not_in('order_schedules.id', $schedule_id);
             }
        
        $tot_query = $this->db->get();
        $tot_data = $tot_query->result();
        
        $count=count($tot_data);
        //echo '<pre>';
        //print_r($tot_data);
        $temp =TRUE;
        if($count == 1){
            if((strtotime($minus5hours) - strtotime($tot_data[0]->start_date) > 15*60)){
                $tot_time = $tot_time - 0.1;
            }
        }
    
        if($count == 2){
            if($tot_data[0]->start_date < $minus5hours){
                if(strtotime($minus5hours) - strtotime($tot_data[0]->start_date) > 15*60){
                    $interval = strtotime($minus5hours) - strtotime($tot_data[0]->start_date);
                    $tot_time = ($tot_time - ($interval/3600))+0.25;
                }
            }
            if($tot_data[0]->end_date != $tot_data[1]->start_date){
                $temp = FALSE;
            }
    
        }
        if($count == 3){
            if($tot_data[0]->start_date < $minus5hours){
                if(strtotime($minus5hours) - strtotime($tot_data[0]->start_date) > 15*60){
                    $interval = strtotime($minus5hours) - strtotime($tot_data[0]->start_date);
                    $tot_time = ($tot_time - ($interval/3600))+0.25;
                }
            }
            if(($tot_data[0]->end_date != $tot_data[1]->start_date) || ($tot_data[1]->end_date != $tot_data[2]->start_date)){
                 $temp = FALSE;
            }
        }

        

        // for($i=0;$i<$count;$i++){
        //     for($j=$i+1;$j<$count;$j++){
        //         if($tot_data[$i]->end_date != $tot_data[$j]->start_date){
        //             $temp = FALSE;
        //             break;
        //         }
        //     }
        // }
        //echo $temp;
        //die;
        if(($tot_time >=5.0 && $temp) && $data ){
            return array('data'=>true);
        }else{
            return array();
        }
    }
    
    // New function created by Ahmed on 2019-07-26
    function check_exist_schedule_datetime($presenter_id = '', $start_date='', $end_date='', $schedule_id = '') {
        
        $this->db->select('order_schedules.*');
        $this->db->from('order_schedules');
        
        if ($presenter_id != '') {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }
        if($schedule_id != ''){
            $this->db->where_not_in('order_schedules.id', $schedule_id);
        }

        $where = '((start_date<="'.$start_date.'" AND end_date>"'.$start_date.'") OR (start_date<"'.$end_date.'" AND end_date>="'.$end_date.'"))';
        $this->db->where($where);

        $this->db->join('orders', 'orders.id = order_schedules.order_id');
        $this->db->where('orders.is_deleted', 0);
        
        $query = $this->db->get();
        $data = $query->result();

        // echo $this->db->last_query();
        // echo "<pre>";print_r($data);exit;
        return $data;
    }
    // ======= end of the code=====//
 
    public function get_school_by_presenter($filter = array(), $order = null, $dir = null) {

        $this->db->select('orders.*, user_meta.meta_value as school_name');
        $this->db->from('orders');
        $this->db->join('user_meta', 'orders.school_id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
                
        if (isset($filter['presenter_id']) && $filter['presenter_id'] !== "") {
            $this->db->where('orders.presenter_id', $filter['presenter_id']);
        }
        
        if (isset($filter['school']) && $filter['school'] !== "") {
            $this->db->where('orders.school_id', $filter['school']);
        }
        
        if (isset($filter['status']) && $filter['status'] !== "") {
            $this->db->where('orders.status', $filter['status']);
        }
        
        if (isset($filter['deleted']) && $filter['deleted'] !== "") {
            $this->db->where('orders.is_deleted', $filter['deleted']);
        }

        $this->db->order_by('updated_on DESC');
        $this->db->group_by("orders.school_id");

        $query = $this->db->get();

        //echo $this->db->last_query()."<br>";die;
        return $query->result();
    }
    
    public function get_category_details($id='') {

        $this->db->select('titles.*, orders.id AS order_id');
        $this->db->from('titles');
        $this->db->join('orders', 'orders.title_id = titles.id', 'left');
        
        if ($id != '') {
            $this->db->where('titles.id', $id);
        }
        
        $query = $this->db->get();

        return $query->row();
    }

    // 20190101

    function get_school_teacher($school_id, $title_id, $group_by='') {
        $school_id = (int) $school_id;
        
        $this->db->select('teachers.title_id, teachers.grade_id, teachers.name as teacher_name, grades.name as grade_name, titles.name as title_name, user_meta.meta_value as school_name');
        $this->db->from('teachers');
        $this->db->join('grades', 'teachers.grade_id = grades.id', 'left');
        $this->db->join('titles', 'teachers.title_id = titles.id', 'left');
        $this->db->join('user_meta', 'teachers.school_id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->where('teachers.school_id', $school_id);
        $this->db->where('teachers.title_id', $title_id);
        $this->db->where('teachers.is_deleted', 0);
        if($group_by != ''){
            $this->db->group_by($group_by);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    function check_schedule_timeBySchool($presenter_id = '', $date='', $order_id='', $school_id='') {
        
        $this->db->select('order_schedules.*, schools.id as school_id');
        $this->db->from('order_schedules');
        $this->db->join('orders', 'orders.id = order_schedules.order_id');
        $this->db->join('users as schools', 'schools.id = orders.school_id');
        
        if ($presenter_id != '') {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }

        // $where = 'DATE(start_date)="'.$date.'"';

        $where = 'DATE(start_date)="'.$date.'" AND school_id!="'.$school_id.'"';
        $this->db->where($where);
        
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    /**
    This method will be used to get
    order details from order table ..
    Created on: 23-06-2019
    Created by: Soumya 
    **/
    public function get_specific_order($order_id)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('id', $order_id);

        $get_specific_order_que = $this->db->get();
        $get_specific_order_arr = $get_specific_order_que->row_array();

        if(!empty($get_specific_order_arr))
        {
            return $get_specific_order_arr;
        }
        else
        {
            return false;
        }    
    }
    ## End of the code ##

    /**
    This method will be used to 
    get the list of grades
    Created on: 23-06-2019
    Created by: Soumya     
    **/
    public function get_grade_list_assignment()
    {
        $this->db->select('id, name');
        $this->db->from('grades');
        $this->db->where('status', 'active');

        $get_grade_que = $this->db->get();
        $get_grade_arr = $get_grade_que->result_array();

        if(!empty($get_grade_arr[0]))
        {
            return $get_grade_arr;
        }
        else
        {
            return false;
        }
    }
    ## End of the code ##


    /**
    This method will be used 
    to list presenters with respective
    grades depending upon schools they 
    are mapped ....
    Created on: 23-06-2019
    Created by: Soumya
    **/
    public function get_assignable_presenters($coordinator_id = NUll, $school_id= NULL, $presenter_id= NULL)
    {
        if(!empty($coordinator_id))
        {
            $this->db->select('coordinator_presentator_school.coordinator_id, coordinator_presentator_school.presenter_id, coordinator_presentator_school.school_ids, coordinator_presentator_school.from_date, coordinator_presentator_school.effective_date, users.first_name, users.last_name');

            $this->db->from('coordinator_presentator_school');
            $this->db->join('users', 'users.id = coordinator_presentator_school.presenter_id', 'left');
            $this->db->where('coordinator_presentator_school.coordinator_id', $coordinator_id);
            $this->db->where('coordinator_presentator_school.is_deleted', 0);
            $this->db->order_by('users.first_name');
            if($school_id != NULL){
                $this->db->where("FIND_IN_SET(".$school_id.",coordinator_presentator_school.school_ids) >",0);
            }
            if($presenter_id != NULL){
                $this->db->where('users.id',$presenter_id);
            }
        }
        else
        {
            $this->db->select('users.id as presenter_id, users.first_name, users.last_name');
            $this->db->from('users');
            $this->db->where('users.role_id',       3);
            $this->db->where('users.is_deleted',    0); 
            $this->db->where('users.status', 'active'); 
            $this->db->order_by('users.first_name');
            if($school_id != NULL){
                $this->db->where('users.id', $school_id);
            }   
            if($presenter_id != NULL){
                $this->db->where('users.id',$presenter_id);
            }        
        }

        $presenter_data_que = $this->db->get();
        $presenter_data_arr = $presenter_data_que->result_array();

        if(!empty($presenter_data_arr[0]))
        {
            return $presenter_data_arr;
        }
        else
        {
            return false;
        }    
    }
    ## End of the code ##


    /**
    This method will be used to
    get the details of specific hour assignment 
    for a specific order
    Created on: 23-06-2019
    Created by: Soumya
    **/
    public function get_specific_assignment($order_id)
    {
        $return_array = array();

        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);

        $get_assignedhours_que = $this->db->get();
        $get_assignedhours_arr = $get_assignedhours_que->result_array();
        $total_number_element  = count($get_assignedhours_arr);

        if($total_number_element > 0)
        {
            $presenter_array = array();
            $allowed_hrs_arr = array();
            $allowed_grd_arr = array();

            foreach($get_assignedhours_arr as $key=>$vals)
            {
                $presenter_array[$key]              = $vals['presenter_id'];
                $presenter_key                      = $vals['presenter_id']; 
                $allowed_hrs_arr[$presenter_key]    = $vals['assigned_hours'];
                $allowed_grd_arr[$presenter_key]    = $vals['grade_id'];
            }

            $this->db->select('SUM(assigned_hours) as total_hours');
            $this->db->from('order_assigned_presenters');
            $this->db->where('order_id', $order_id);

            $get_totalhours_que = $this->db->get();
            $get_totalhours_arr = $get_totalhours_que->row_array();            

            $return_array = array(  'presenters'        => $presenter_array, 
                                    'assigned_hours'    => $allowed_hrs_arr, 
                                    'grade_id'          => $allowed_grd_arr, 
                                    'total_used_hours'  => $get_totalhours_arr['total_hours']);

            return $return_array;
        } 
        else
        {
            return false;
        }

    }
    ## End of the code ##

    /**
    This method will delete all 
    previous allocation of hours
    for an order ..
    Created on: 23-06-2019
    Created by: Soumya     
    **/
    public function delete_previous_assignment($order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->delete('order_assigned_presenters');

        return true;
    }
    ## End of the code ##

    /**
    Following method will be used
    to get Presenter list from order master 
    or assign order presenter table
    Created on: 24-06-2019
    Created by: Soumya
    **/
    public function get_presenters_view($order_id)
    {
        $this->db->select('presenter_id');
        $this->db->from('orders');
        $this->db->where('id', $order_id);

        $query = $this->db->get();
        $array = $query->row_array();

        if(!empty($array['presenter_id']))
        {
            $this->db->select("CONCAT_WS(' ', first_name, last_name) AS name");
            $this->db->from('users');
            $this->db->where('id', $array['presenter_id']);

            $get_presenter_name_que     = $this->db->get();
            $get_presenter_name_arr     = $get_presenter_name_que->row_array();
            $requested_presenter_str    = '<p> <b> Requested Presenter: </b>'.$get_presenter_name_arr['name'] .'</p>';            
        }
        else
        {
            $requested_presenter_str    = '<p> <b> No Requested Presenter Available </b> </p>'; 
        }

        $this->db->select('presenter_id');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);

        $query1 = $this->db->get();
        $array1 = $query1->result_array();

        if(!empty($array1[0]))
        {
            $presenter_name = '';

            foreach($array1 as $value1)
            {
                $this->db->select("CONCAT_WS(' ', first_name, last_name) AS name");
                $this->db->from('users');
                $this->db->where('id', $value1['presenter_id']);

                $get_presenter_name_que     = $this->db->get();
                $get_presenter_name_arr     = $get_presenter_name_que->row_array();

                if(empty($presenter_name))
                   $presenter_name =  $get_presenter_name_arr['name'];
                else
                   $presenter_name =  $presenter_name.", ".$get_presenter_name_arr['name'];        
            }

            $assigned_presenter_str    = '<p> <b> Assigned Presenter(s): </b>'.$presenter_name .'</p>';   
        }
        else
        {
            $assigned_presenter_str    = '<p> <b> No Assigned Presenter Available </b> </p>'; 
        } 

        $final_string = $requested_presenter_str.$assigned_presenter_str;
        return $final_string;
    }
    ## End of the code ##   
    
    /**
     * get meta value for user
     * has been resued here 
     * On : 11-06-2019
     */
    function get_user_meta($user_id) {
        $user_id = (int) $user_id;

        $this->db->from('user_meta');
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();
        $meta = array();
        foreach ($query->result() as $key => $value) {
            $meta[$value->meta_key] = $value->meta_value;
        }
        //echo $this->db->last_query()."<br>";
        return $meta;
    }   
    ## End of the code ##

    /**
    Method which will check
    whether the coordinator
    has permission or not to create order
    Created on: 24-06-2019
    Created by: Soumya
    **/
    public function has_coordinator_permission($coordinator_id, $school_id)
    {
        $this->db->select('has_order_permission');
        $this->db->from('coordinator_permission');
        $this->db->where('coordinator_id',  $coordinator_id);
        $this->db->where('school_id',       $school_id);

        $query = $this->db->get();
        $array = $query->row_array();

        if(!empty($array))
            return $array['has_order_permission'];
        else
            return false;    
    }
    ## End of the code ##

   /**
    Following code will be 
    involved to get the hours 
    left for that presenter ..
    Created by : Soumya
    Created on : 30-06-2019
    **/
    public function get_allowed_hours_preseneter($order_id, $presenter_id)
    {
        $this->db->select('assigned_hours');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('order_id', $order_id);

        $get_allowed_hours_que = $this->db->get();
        $get_allowed_hours_arr = $get_allowed_hours_que->row_array();

        if(!empty($get_allowed_hours_arr))
        {
            $presenter_alloted_hrs = $get_allowed_hours_arr['assigned_hours'];
            return $presenter_alloted_hrs;
        }
        else
        {
            return false;
        }
    }

    public function get_utilized_hours_presenter($order_id, $presenter_id)
    {
        $this->db->select('SUM(total_hours) as utilized_hours');
        $this->db->from('order_schedules');
        $this->db->where('created_by', $presenter_id);
        $this->db->where('order_id', $order_id);

        $get_used_hours_que = $this->db->get();
        $get_used_hours_arr = $get_used_hours_que->row_array();

        if(!empty($get_used_hours_arr))
        {
            $presenter_used_hrs = $get_used_hours_arr['utilized_hours'];
            return $presenter_used_hrs;
        }
        else
        {
            return false;
        }
    }
    ## --- End of the code ----- ##

    /**
    Following method will
    get the detaills of orders and 
    its schedule plus populate billing master and details table
    Created on: 01-07-2019
    Created by: Soumya
    **/
    public function generate_invoice_coordinator($order_id)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('id', $order_id);

        $get_orderdetails_que = $this->db->get();
        $get_orderdetails_arr = $get_orderdetails_que->row_array();

        ## -------- Set update data to update master table ---------- ##
        $data_master['coordinator_id']          = $get_orderdetails_arr['coordinator_id'];
        $data_master['order_id']                = $get_orderdetails_arr['id'];
        $data_master['billing_no']              = "WQCO".date("ymd").rand(100, 999);
        $data_master['school_id']               = $get_orderdetails_arr['school_id'];
        $data_master['total_hours_allocated']   = $get_orderdetails_arr['hours'];
        $data_master['invoice_generated_on']    = date("Y-m-d H:i:s");
        ## -------- Set update data to update master table ---------- ##

        $this->db->insert('coordinator_billing_master', $data_master);
        $billing_master_id = $this->db->insert_id();

        ## ----- Get coordinator data ------- ##
        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'rate_type');
        $this->db->where('user_id', $get_orderdetails_arr['coordinator_id']);

        $get_ratetype_que = $this->db->get();
        $get_ratetype_arr = $get_ratetype_que->row_array();


        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'rate');
        $this->db->where('user_id', $get_orderdetails_arr['coordinator_id']);

        $get_rate_que = $this->db->get();
        $get_rate_arr = $get_rate_que->row_array();
        ## ----- Get coordinator data ------- ##        

        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);

        $get_presenterdetails_que = $this->db->get();
        $get_presenterdetails_arr = $get_presenterdetails_que->result_array();

        $amount_payable = 0;
        foreach($get_presenterdetails_arr as $inner_values)
        {
            ## ----- Get presenter meta data --------##
            $this->db->select('meta_value');
            $this->db->from('user_meta');
            $this->db->where('meta_key', 'rate');
            $this->db->where('user_id', $inner_values['presenter_id']);

            $get_rate_que1 = $this->db->get();
            $get_rate_arr1 = $get_rate_que1->row_array();
            ## ----- Get presenter meta data --------##

            $data_details['presenter_id']               = $inner_values['presenter_id'];
            $data_details['presenter_rate']             = $get_rate_arr1['meta_value'];
            $data_details['presenter_allocated_hour']   = $inner_values['assigned_hours'];
            $data_details['presenter_amount']           = ($inner_values['assigned_hours'] * $get_rate_arr1['meta_value']);

            if($get_ratetype_arr['meta_value'] == 'percentage')
            {
                $coordinator_amount = (($data_details['presenter_amount'] * $get_orderdetails_arr['co_rate']) / 100);
            }
            else
            {
                $coordinator_amount = (($get_orderdetails_arr['co_rate'] - $get_rate_arr1['meta_value']) * $inner_values['assigned_hours']) ;
            }

            $amount_payable += $coordinator_amount;

            $data_details['coordicator_amount']         = $coordinator_amount;
            $data_details['billing_master_id']          = $billing_master_id;

            $details_id = $this->db->insert('coordinator_billing_details', $data_details);
        } 

        $data_amount_update['amount_payable'] = $amount_payable;

        $this->db->where('id', $billing_master_id);
        $this->db->update('coordinator_billing_master', $data_amount_update);

        return true;
    }

    ## --- End of the code ----##

    /**
    Following method will be used 
    to show the invoices generated
    by coordinators 
    Created on: 02-07-2019
    Created by: Soumya
    **/
    public function get_billing_list($filter = array(), $order = null, $dir = null, $count = false)
    {
        $this->db->select("coordinator_billing_master.*, CONCAT_WS(' ', users.first_name, users.last_name) AS coordinator_name, user_meta.meta_value AS school_name, orders.order_no, orders.work_plan_number");
        $this->db->from('coordinator_billing_master');
        $this->db->join('users', 'users.id = coordinator_billing_master.coordinator_id', 'left');
        $this->db->join('orders', 'orders.id = coordinator_billing_master.order_id', 'left');
        $this->db->join('user_meta', "user_meta.user_id = coordinator_billing_master.school_id AND user_meta.meta_key = 'school_name'", "left outer");

        
        if (isset($filter['coordinator']) && $filter['coordinator'] !== "") {
            $this->db->where('coordinator_billing_master.coordinator_id', $filter['coordinator']);
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
        //echo $this->db->last_query();

        $array = $query->result();

        return $array;
    }
    ## ------ End of the code ------ ##


    /**
    Following methods are being 
    generated to show invoice in PDF
    Created on: 02-07-2019
    Created by: Soumya
    **/
    public function get_billing_master($billing_id)
    {
        $this->db->select("coordinator_billing_master.*, CONCAT_WS(' ', users.first_name, users.last_name) AS coordinator_name, user_meta.meta_value AS school_name, orders.order_no, co_addr.meta_value AS co_phone");
        $this->db->from('coordinator_billing_master');
        $this->db->join('users', 'users.id = coordinator_billing_master.coordinator_id', 'left');
        $this->db->join('orders', 'orders.id = coordinator_billing_master.order_id', 'left');
        $this->db->join('user_meta', "user_meta.user_id = coordinator_billing_master.school_id AND user_meta.meta_key = 'school_name'", "left outer");
        $this->db->join('user_meta as co_addr', "co_addr.user_id = coordinator_billing_master.coordinator_id AND co_addr.meta_key = 'phone'", "left outer");
        $this->db->where('coordinator_billing_master.id', $billing_id);

        $query = $this->db->get();
        $array = $query->row();

        return $array;
    }

    public function get_billing_details($billing_id)
    {
        $this->db->select("coordinator_billing_details.*, CONCAT_WS(' ', users.first_name, users.last_name) AS presenter_name");
        $this->db->from('coordinator_billing_details');
        $this->db->join('users', 'users.id = coordinator_billing_details.presenter_id', 'left');
        $this->db->where('coordinator_billing_details.billing_master_id', $billing_id);

        $query = $this->db->get();
        $array = $query->result();

        return $array;
    }

    public function pay_to_coordinator_model($billing_id)
    {
        $data['paid_on'] = date("Y-m-d H:i:s");
 
        $this->db->where('id', $billing_id);
        $this->db->update('coordinator_billing_master', $data);

        return true;
    }
    ## ------ End of the code -------- ##   

    public function get_all_logs($filter = array(), $order = null, $dir = null, $count = false) {

        //$this->db->select('order_schedules.*, orders.order_no, orders.work_plan_number, user_meta.meta_value as school_name');
		$this->db->select('title_topics.topic,order_schedules.*, orders.order_no, orders.work_plan_number, user_meta.meta_value as school_name');
        $this->db->from('orders');
		$this->db->join('title_topics', 'orders.title_id = title_topics.title_id');
        $this->db->join('order_schedules', 'orders.id = order_schedules.order_id');
        $this->db->join('order_schedule_status_log', 'order_schedule_status_log.order_schedule_id = order_schedules.id');
        $this->db->join('order_assigned_presenters', 'order_assigned_presenters.order_id=orders.id');
        $this->db->join('users as schools', 'schools.id = orders.school_id');
        $this->db->join('user_meta', 'schools.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');

        $condit = "(order_schedules.status='Log sent - awaiting principal signature' OR order_schedule_status_log.old_status='Log sent - awaiting principal signature' OR order_schedule_status_log.new_status='Log sent - awaiting principal signature')";

        $condit .= " AND order_schedules.created_by= ".$this->session->userdata('id');

        if (isset($filter['order_no']) && $filter['order_no'] != "") {
            $condit .= " AND  orders.order_no LIKE '%".$filter['order_no']."%'";
            // $this->db->like('orders.order_no', $filter['order_no']);
        }

        if (isset($filter['school']) && $filter['school'] != "") {
            $condit .= " AND orders.school_id='".$filter['school']."'";
            // $this->db->where('schools.school', $filter['school']);
        }
        
        if (isset($filter['presenter']) && $filter['presenter'] != "") {
            $condit .= " AND order_assigned_presenters.presenter_id= '".$filter['presenter']."'";
            // $this->db->where('orders.presenter_id', $filter['presenter']);
        }
		if (isset($filter['topic']) && $filter['topic'] != "") {
            $condit .= " AND title_topics.id='".$filter['topic']."'";
        }

        if (isset($filter['date']) && $filter['date'] !== "") {
            $date = str_replace('~', '/', $filter['date']);
            $date = $this->format_date($date);

            // $condit .= " AND order_schedules.start_date >='".$date."'";
            $condit .= " AND DATE_FORMAT(order_schedules.start_date, '%Y-%m-%d') ='".$date."'";
        }
        // echo $condit;exit;
        $this->db->where($condit);
        $this->db->group_by("order_schedule_status_log.order_schedule_id");

        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }

        if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }

        if ($order <> null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('orders.created_on DESC');
        }


        $query = $this->db->get();

        return $query->result();
    }

    public function get_download_log($order_schedule_id=""){

        $condition = "order_schedule_status_log.order_schedule_id= '".$order_schedule_id."' AND (new_status='Log sent - awaiting principal signature' AND old_status='Create log')";
        $this->db->select('order_schedule_status_log.*, (SELECT content FROM order_schedule_status_log WHERE order_schedule_status_log.order_schedule_id="'.$order_schedule_id.'" AND (new_status="Awaiting Review" AND old_status="Log sent - awaiting principal signature")) AS create_log_content');
        $this->db->from('order_schedule_status_log');         
        $this->db->where($condition);
        $this->db->group_by("order_schedule_status_log.order_schedule_id");
        
        $query = $this->db->get()->row();
        return $query;
    }
    
    // ======= Start Code ====== //
    // created by Ahmed on 2019-07-31     
    function get_order_schedule_for_calendar($presenterids=array(), $schoolids=array(), $titleids=array(),$session) {
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, orders.school_id, orders.presenter_id, orders.order_no, CONCAT_WS(" ", users.first_name, users.last_name) as presenter_name');
        $this->db->from('order_schedules');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
        $this->db->join('orders', 'order_schedules.order_id = orders.id');
        $this->db->join('users', 'users.id = order_schedules.created_by');

        if (!empty($presenterids)) {
            $this->db->where_in('order_schedules.created_by', $presenterids);
        }
        if (!empty($schoolids)) {
            $this->db->where_in('orders.school_id', $schoolids);
        }
        if (!empty($titleids)) {
            $this->db->where_in('orders.title_id', $titleids);
        }

         //session
         if (!empty($session)) {
            if($session == 1){
                $this->db->where('orders.session_id >', 0);    
            }else{
                $this->db->where('orders.session_id', $session);
            }
        }
        
        $query = $this->db->get(); 
        // echo $this->db->last_query();die;      
        $record = $query->result();

       // School color and name.. 
       for($j=0;$j<count($record);$j++)
       {
          $school_id=$record[$j]->school_id;
          $this->db->select('user_meta.meta_value');
          $this->db->from('user_meta'); 
          $this->db->where('user_meta.meta_key', 'school_color');
          $this->db->where('user_meta.user_id', $school_id);
          
          $query1 = $this->db->get();
          $record1 = $query1->row();
          $color=$record1->meta_value;
          $record[$j]->color=$color; 
          
          $this->db->select('user_meta.meta_value');
          $this->db->from('user_meta'); 
          $this->db->where('user_meta.meta_key', 'school_name');
          $this->db->where('user_meta.user_id', $school_id);
          
          $query1 = $this->db->get();
          $record1 = $query1->row();
          $school_name=$record1->meta_value;
          $record[$j]->school_name=$school_name;  
       }

        return $record;
    }
       
    public function get_presenters($filter = array(), $order = null, $dir = null, $count = false) {

        $this->db->select('users.*, CONCAT(users.first_name, " ", users.last_name) as presenter_name');
        $this->db->from('users');
        $this->db->where('users.role_id', 3);
        $this->db->where('users.is_deleted', 0);

        if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }

        if ($order <> null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('first_name ASC');
        }


        $query = $this->db->get();
        return $query->result();
    }    

    public function get_schools($filter = array(), $order = null, $dir = null, $count = false) {

        $this->db->select('users.*, user_meta.meta_value as school_name');
        $this->db->from('users');
        $this->db->join('user_meta', 'users.id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        $this->db->where('users.role_id', 4);
        $this->db->where('users.is_deleted', 0);

        if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }
        $this->db->group_by('users.id');
        if ($order <> null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('school_name ASC');
        }

        $query = $this->db->get();
        return $query->result();
    }
    
    // ====== End of the code ====== //
    
    // Method to know Coordinator billing info ..
    public function get_paymentinfo_co($coordinator_id)
    {
        ## ----- Get coordinator data ------- ##
        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'rate_type');
        $this->db->where('user_id', $coordinator_id);

        $get_ratetype_que = $this->db->get();
        $get_ratetype_arr = $get_ratetype_que->row_array();

        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'rate');
        $this->db->where('user_id', $coordinator_id);

        $get_rate_que = $this->db->get();
        $get_rate_arr = $get_rate_que->row_array();
        ## ----- Get coordinator data ------- ##        
        
        $return              = array();
        $return['rate_type'] = $get_ratetype_arr['meta_value'];
        $return['rate']      = $get_rate_arr['meta_value'];
        
        return $return;
    }
    
    public function get_invoice_data($order_schedule_id){

        $this->db->select('order_schedule_status_log.*');
        $this->db->from('order_schedule_status_log');
        $this->db->where('order_schedule_status_log.new_status', 'Invoice created');
        $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
        return $this->db->get()->row_array();
    }
    

     public function get_assign_presenter_grade($order_id='', $presenter_id='')
    {
        $return_array = array();

        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);

        $assign_grade = $this->db->get()->row_array();
        $res = array();
        if(!empty($assign_grade)){
            if($assign_grade['grade_id'] != ''){
                $gradeId = explode(',', $assign_grade['grade_id']);
                foreach ($gradeId as $key => $id) {
                    $this->db->select('*');
                    $this->db->from('grades');
                    $this->db->where('id', $id);

                    $res[] = $this->db->get()->row();
                }
                
            }
        }
        return $res;

    }

    public function get_teacher_grades($id)
    {
        $this->db->select('teachers.id,teachers.school_id,teachers.grade_id,teachers.name as teacher_name,grades.name as grade_name');
        $this->db->from('teachers');
        $this->db->where('teachers.school_id', $id);
        $this->db->join('school_titles', 'school_titles.title_id = teachers.title_id');
        $this->db->where('teachers.is_deleted', 0);
        $this->db->join('grades', 'teachers.grade_id = grades.id');
		// $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
		$this->db->where('grades.status', 'active');
        $this->db->group_by('teachers.grade_id');
        $query=$this->db->get();
        //echo "<pre>";print_r($query->result());die;
        return $query->result();
    } 

    public function get_grades_with_teachers($school_id, $id)
    {

        $this->db->select('teachers.id,teachers.school_id,teachers.grade_id,teachers.name as teacher_name');
        $this->db->from('teachers');
        $this->db->where('teachers.school_id', $school_id);
        $this->db->where('teachers.grade_id', $id);
        $query=$this->db->get();
        // echo "<pre>";print_r($query->result());die;
        return $query->result_array();
    } 

    public function get_teacher($id,$sc_id)
    {
        $this->db->select('teachers.name as teacher_name');
        $this->db->from('teachers');
        $this->db->join('grades', 'teachers.grade_id = grades.id');
        $this->db->where('teachers.grade_id', $id);
        $this->db->where('teachers.school_id', $sc_id);
        $this->db->where('teachers.is_deleted', 0);
        $this->db->group_by('teachers.name');
      
        $query=$this->db->get();
        //echo "<pre>";print_r($query->result());die;
        return $query->result();
    }
    
    public function get_teacher_order($schedul_id)
    {   

        $this->db->select('order_schedules.teacher');
        $this->db->from('order_schedules');
        $this->db->where('order_schedules.id', $schedul_id);
      
        $query=$this->db->get();
        return $query->row();
    }
    
     public function get_favourites_topic($presenter_id)
    {
        $this->db->select('order_schedules.topic_id,title_topics.topic');
        $this->db->from('order_schedules');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
        $this->db->where('order_schedules.created_by', $presenter_id);
        $this->db->group_by('title_topics.id');
        $this->db->order_by('count(order_schedules.topic_id) DESC');
        $query=$this->db->get();
       
       return $query->result();
    }
    
    // Added by Ahmed on 2020-03-16
    public function get_payment_schedule_by_date($date=NULL){
        $this->db->select('*');
        $this->db->from('payment_schedule');
        $this->db->where('is_deleted', 0);

        if($date != NULL)
            $this->db->where('email_remonder_date', date('Y-m-d', strtotime($date)));

        $query  = $this->db->get();  
        // echo $this->db->last_query();exit;

        return $query->result();

    }

    public function get_schedule_details_by_bw_date($fromDate, $toDate) {

        $this->db->select('*');
		$this->db->from('order_schedules');
		$this->db->where('DATE(start_date) >=', date('Y-m-d',strtotime($fromDate)));
		$this->db->where('DATE(start_date) <=', date('Y-m-d',strtotime($toDate)));
		$this->db->group_by('created_by');
		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";exit;      
		return $query->result();
    }
    // End added on 2020-03-16
    public function multipleConfirmhoursUpdate($scheduled_id, $data){
        for($i=0;$i<count($scheduled_id);$i++){
            $this->db->where('id', $scheduled_id[$i]);
            $this->db->update('order_schedules', $data);
        }
        return true;
    }

    public function multipleConfirmhoursInsert($scheduled_id, $data){
        // echo '<pre>'; print_r ($scheduled_id); die;
         for($i=0;$i<count($scheduled_id);$i++){
           $data['order_schedule_id']= $scheduled_id[$i];
             $this->db->insert('order_schedule_status_log', $data);
         }
         return true;
     }

    public function getApprovedStatus($order_id,$pid){
        $this->db->select('*');
        $this->db->from('order_schedules');
        $this->db->where('status', 'Approved');
        $this->db->where('order_id', $order_id);
		$this->db->where('created_by', $pid);
        $query=$this->db->get();
         //echo $this->db->last_query()."<br>";die;      
        return $query->result();
    }
    public function getAdminBilling($prsenter_id,$billing_due_date,$purchase_order_no,$limit=NULL,$offset=NULL,$session,$count=false){
        $this->db->select('billing.*,orders.order_no,orders.work_plan_number,orders.hours,orders.hourly_rate,orders.booking_date,user_meta.meta_value as school_name,CONCAT(presenter.first_name," ",presenter.last_name) as presenter_name,titles.public_school_title_status');
        $this->db->from('billing');
        $this->db->join('orders', 'orders.id = billing.order_id','left');
        $this->db->join('users AS schools', 'orders.school_id = schools.id','left');
        $this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");
        $this->db->join('users AS presenter', 'billing.presenter_id = presenter.id','left');
        // $this->db->join('order_schedules', 'order_schedules.order_id = billing.order_id','left');
        $this->db->join('titles', 'titles.id = orders.title_id','left');

        $this->db->where('orders.is_deleted', '0');
        if (!empty($prsenter_id)) {
            $this->db->where('billing.presenter_id', $prsenter_id);
        }
        if (!empty($billing_due_date)) {
            // $this->db->where('orders.booking_date', date("Y-m-d",strtotime($billing_due_date)));
            $this->db->where('billing.billing_date', date("Y-m-d",strtotime($billing_due_date)));
            $this->db->where('billing.is_public_title', 'unchecked');
        }
        if (!empty($purchase_order_no)) {
            $this->db->where('orders.order_no', $purchase_order_no);
        }

        //session
        if (!empty($session)) {
            if($session == 1){
                $this->db->where('orders.session_id >', 0);    
            }else{
                $this->db->where('orders.session_id', $session);
            }
        }
       

        $this->db->order_by('billing.id DESC');

        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }

        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";
        return $query->result();
    }
    public function getAdminBillingcount($presenter,$billing_due_date,$purchase_order_no,$session){
       //echo $presenter;die;
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->join('orders', 'orders.id = billing.order_id','left');
        if (!empty($presenter)) {
            $this->db->where('billing.presenter_id', $presenter);
        }
         if (!empty($billing_due_date)) {
            // $this->db->where('orders.booking_date', date("Y-m-d",strtotime($billing_due_date)));
            $this->db->where('billing.billing_date', date("Y-m-d",strtotime($billing_due_date)));
            $this->db->where('billing.is_public_title', 'unchecked');
        }
        if (!empty($purchase_order_no)) {
            $this->db->where('orders.order_no', $purchase_order_no);
        }
        if (!empty($session)) {
            if($session == 1){
                $this->db->where('orders.session_id >', 0);    
            }else{
                $this->db->where('orders.session_id', $session);
            }
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getbilling_due_date($order_id){
        $this->db->select('MAX(start_date) as start_date');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        // $this->db->last_query()."<br>";
        $lastScheduleDateTime = $query->row()->start_date;
        $lastScheduleDate = explode(" ", $lastScheduleDateTime);
        $this->db->select('billing_date');
        $this->db->from('payment_schedule');
        $this->db->where('session_from <= ',$lastScheduleDate[0]);
        $this->db->where('session_to >=',$lastScheduleDate[0]);
        $query1 = $this->db->get();
        //return $this->db->last_query()."<br>";
        if($query1->num_rows() > 0){
            return date("m/d/y", strtotime($query1->row()->billing_date));
        }else{
            return 'N/A';
        }
    }
    public function getorder_billing_date($order_id){
        $this->db->select('MAX(start_date) as start_date');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        //echo $lastScheduleDate = $query->row()->start_date;die;
        if($query->num_rows() > 0 && !is_null($query->row()->start_date)){
            $lastScheduleDateTime = $query->row()->start_date;
            $lastScheduleDate = explode(" ", $lastScheduleDateTime);
            $this->db->select('billing_date');
            $this->db->from('payment_schedule');
            $this->db->where('session_from <= ',$lastScheduleDate[0]);
            $this->db->where('session_to >=',$lastScheduleDate[0]);
            $query1 = $this->db->get();
            //return $this->db->last_query()."<br>";
            if($query1->num_rows() >0 && !is_null($query1->row()->billing_date)){
                return date("m/d/y", strtotime($query1->row()->billing_date));
            }else{
                return 'N/A';
            }
        }else{
            return 'N/A';
        }
        
    }
    public function getorder_billing_period($order_id){
        $this->db->select('MAX(start_date) as start_date');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows() > 0 && !is_null($query->row()->start_date)){
            $lastScheduleDateTime = $query->row()->start_date;
            $lastScheduleDate = explode(" ", $lastScheduleDateTime);
            $this->db->select('*');
            $this->db->from('payment_schedule');
            $this->db->where('session_from <= ',$lastScheduleDate[0]);
            $this->db->where('session_to >=',$lastScheduleDate[0]);
            $query1 = $this->db->get();

            if($query1->num_rows() >0 && !is_null($query1->row()->billing_date)){
                return date("m/d/Y", strtotime($query1->row()->session_from)).' to '.date("m/d/Y", strtotime($query1->row()->session_to));
            }else{
                return 'N/A';
            }
            //return $this->db->last_query()."<br>";
            
        }else{
            return 'N/A';
        }
        
    }
    public function getInvprsenter($order_id){
        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_billing_order_count($order_id, $presenter_id){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
		$this->db->where('presenter_id', $presenter_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function presenter_invoice_number($presenter_id){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('presenter_id', $presenter_id);
        $query = $this->db->get();
        return $query->num_rows()+1;
    }
    public function get_billing_invoice_documents($id){
        $this->db->select('invoice_document');
        $this->db->from('billing');
        $this->db->where('id',$id);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";      
        return $query->row()->invoice_document;
    }
    public function get_billing_presenter_id($id){
        $this->db->select('presenter_id');
        $this->db->from('billing');
        $this->db->where('id',$id);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";      
        return $query->row()->presenter_id;
    }
    public function get_schedule_ids($order_id, $pid){
        $this->db->select('id');
        $this->db->from('order_schedules');
        $this->db->where('order_id',$order_id);       
        $this->db->where('created_by', $pid);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";      
        return $query->result();
    }
    public function get_schedule_ids_pdf($id,$old_status,$new_status){
        // $sql ="SELECT attachment FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND ((`old_status`='Draft attached' AND `new_status`='Approved') OR (`old_status`='Create log' AND `new_status`='Log sent - awaiting principal signature'))";
        $sql ="SELECT attachment,id FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='".$old_status."' AND `new_status`='".$new_status."')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query()."<br>";      
        return $query->result();

    }
	public function get_schedule_logdetails($id){
        
        // $sql ="SELECT school_pdf FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Log sent - awaiting principal signature' AND `new_status`='Awaiting Review')";
        $sql ="SELECT school_pdf,id FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Log sent - awaiting principal signature' AND `new_status`='Create invoice')";

        $query = $this->db->query($sql);
        return $query->result();
        // return $query->row()->school_pdf;
    }
    public function get_schedule_logContent($id){
        $sql ="SELECT content FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Create log' AND `new_status`='Log sent - awaiting principal signature') LIMIT 1";
        $query = $this->db->query($sql);
        //echo $this->db->last_query()."<br>";      
        return $query->row()->content;
    }
     public function checkCreateLog($id){
        $sql ="SELECT * FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Create log' OR `new_status`='Create log')";
        $query = $this->db->query($sql);
        //$query = $this->db->get();
        if($query->num_rows()>0){
            return true;
        }else{
            return false;
        }

    }
	function get_confirm_hours_by_odrId_preId($order_id, $presenter_id){
        $this->db->select('SUM(total_hours) as c_total');
        $this->db->from('order_schedules');
        // $this->db->where('status', 'Confirm hours');
        // $where = '(status != "Hours scheduled" or status != "Draft attached" or status != "Approved")';
        // $this->db->where($where);
        $this->db->where('status !=', 'Hours scheduled');
        $this->db->where('status !=', 'Draft attached');
        $this->db->where('status !=', 'Approved');

        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $query = $this->db->get();
        $result = $query->row();
        if(isset($result)){
            $cHours =$result->c_total;
            if($cHours == NULL){
                return '0';
            }
            return $cHours;
            // print_r($result); die();
        }
    }
	public function get_bill_rate($presenter_id){
        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key','rate');
        $this->db->where('user_id',$presenter_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row()->meta_value;
    }
	public function get_orders_by_presenters($presenters_id){
        // $this->db->select('order_id');
        // $this->db->from('order_schedules');
        // $this->db->where('created_by',$presenters_id);
        // $this->db->order_by('order_id', 'DESC');
        // $this->db->group_by('order_id');
        
        // $query = $this->db->get();
        // // echo $this->db->last_query(); die();
        // return $query->result();
        $this->db->select('order_schedules.order_id');
        $this->db->from('order_schedules');
        $this->db->join('orders', 'order_schedules.order_id = orders.id');
        $this->db->where('order_schedules.created_by',$presenters_id);
        $this->db->where('orders.is_deleted', '0');
        $this->db->order_by('order_schedules.order_id', 'DESC');
        $this->db->group_by('order_schedules.order_id');
        
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->result();
    }
	public function get_orderSchedules_by_order_id($order_id){
        $this->db->select('DISTINCT DATE_FORMAT(start_date,"%Y-%m") as date');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->order_by('start_date', 'DESC');
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->result();
    }
	public function get_presenter_orders_details($order_id,$presenter_id){
        $this->db->select('orders.order_no, orders.school_id, user_meta.meta_value as school_name, titles.name as title_name,titles.public_school_title_status as public_school_title_status,order_assigned_presenters.assigned_hours');
        $this->db->from('orders');
        $this->db->join('titles', 'orders.title_id = titles.id');
        $this->db->join('users AS schools', 'orders.school_id = schools.id');
        $this->db->join('user_meta', "user_meta.user_id = schools.id AND user_meta.meta_key = 'school_name'", "left outer");
        $this->db->join('order_assigned_presenters', 'orders.id = order_assigned_presenters.order_id');
        $this->db->where('orders.id',$order_id);
        $this->db->where('order_assigned_presenters.order_id', $order_id);
        $this->db->where('order_assigned_presenters.presenter_id', $presenter_id);
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
	 public function get_invoice_created_date($order_id,$date){
        $this->db->select('DATE_FORMAT(created_date, "%Y-%m-%d") as created_date');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
		$this->db->where('session_from', $date);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	public function get_invoice($order_id){
        $this->db->select('invoice_document');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }
	public function get_scheduled_hours($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));   
            $this->db->SELECT('SUM(total_hours) as schedule_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->row()->schedule_hours;
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('SUM(total_hours) as schedule_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $query = $this->db->get();
            // echo $this->db->last_query();  die();
            return $query->row()->schedule_hours;
        }
    }
	public function get_total_scheduled_hours($order_id, $presenter_id){
        $this->db->SELECT('SUM(total_hours) as total_schedule_hours');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row()->total_schedule_hours;
    }
	public function get_scheduled_hours_confirm($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));   
            $this->db->SELECT('SUM(total_hours) as schedule_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status !=', 'Hours scheduled');
            $this->db->where('status !=', 'Draft attached');
            $this->db->where('status !=', 'Approved');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->row()->schedule_hours;
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('SUM(total_hours) as schedule_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status !=', 'Hours scheduled');
            $this->db->where('status !=', 'Draft attached');
            $this->db->where('status !=', 'Approved');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->row()->schedule_hours;
        }
    }
	public function get_status_createInvoice($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));   
            $this->db->SELECT('status');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status', 'Create invoice');
            // $this->db->where('status', 'Invoice created');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
            // return $query->result();
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('status');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status', 'Create invoice');
            // $this->db->where('status', 'Invoice created');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
            // return $query->result();
        }
    }
	public function no_of_rows($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));   
            $this->db->SELECT('*');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('*');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
        }
    }
	public function get_billing_date($date){

        $this->db->select('*');
        $this->db->from('payment_schedule');
        $this->db->where('session_from = ',$date);
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        if($query->num_rows() >0){
            return $query->row();
        }
    }
	public function get_order_schedule_with_range($order_id=null, $presenter_id=null,$firstDate, $endDate, $group_by='') {
        $order_id = (int) $order_id;
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate,titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);

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
        // echo $this->db->last_query(); die();
        $record = $query->result();
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.id DESC');
            $this->db->group_by('order_schedule_status_log.old_status');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
    }
	public function get_download_status($order_id, $presenter_id, $session_from, $session_to){
       $this->db->select('*');
       $this->db->from('billing');
       $this->db->where('order_id', $order_id);
       $this->db->where('presenter_id', $presenter_id);
       $this->db->where('session_from', $session_from);
       $this->db->where('session_to', $session_to);
       $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }

    }
	public function get_payment_date($order_id, $presenter_id, $session_from, $session_to){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('session_from', $session_from);
        $this->db->where('session_to', $session_to);
        $query = $this->db->get();
         // echo $this->db->last_query(); die();
         if($query->num_rows() > 0 ){
             $result = $query->row();
             return $result->payment_date;
         }else{
             return null;
         }
 
    }
	public function get_payementDate($currentDate){
        $this->db->SELECT('*');
        $this->db->from('payment_schedule');
        $this->db->where('billing_date >=', $currentDate);
		$this->db->order_by('pshedule_id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	public function update_status_orderSchedules($schedule_ids, $late_flag){
        if($late_flag == 1){
            $data['late_flag'] = $late_flag;
        }
        $data['status'] = 'Invoice created';
        $this->db->where_in('id', $schedule_ids);
        $this->db->update('order_schedules', $data);
    }
	public function get_payementDetails_bypid($pid){
        $this->db->SELECT('*');
        $this->db->from('payment_schedule');
        $this->db->where('pshedule_id', $pid);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	public function get_pre_payementDetails_bypid($pid){
        $this->db->SELECT('*');
        $this->db->from('payment_schedule');
        $this->db->where('pshedule_id <', $pid);
		$this->db->where('billing_date !=','');
        $this->db->order_by('pshedule_id',"desc");
        $this->db->limit(1);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	public function getBilling_records_by_billingDate($crr_billingDate, $pre_billingDate){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('DATE(created_date) >', $pre_billingDate);
        $this->db->where('DATE(created_date) <=', $crr_billingDate);
        $query = $this->db->get();
         // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $result = $query->row();
            return true;
        }else{
            return false;
        }
 
    }
	public function get_schedule_ids_by_bllngDate($crr_billingDate, $pre_billingDate){
        $this->db->select('*');
        $this->db->from('order_billing_details');
        $this->db->where('DATE(created_date) >', $pre_billingDate);
        $this->db->where('DATE(created_date) <=', $crr_billingDate);
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $result = $query->result();
            return $result;
        }else{
            return false;
        } 
    }
    public function get_schedules_byPaymentdetails_nolate($session_from, $session_to){
        $this->db->select('*');
        $this->db->from('order_schedules');
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $session_from);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $session_to);
        $this->db->where('late_flag', '0');
        $this->db->where('is_public_school', 'unchecked'); // 21-04-2023
        $query = $this->db->get();
        //  echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $result = $query->result();
            return $result;
        }else{
            return false;
        } 
    }
    public function get_schedule_detailsFrm_odrdetls($order_schedule_ids, $billing_date){
        $this->db->select('*');
        $this->db->from('order_billing_details');
        // $this->db->where('created_date >=', $pre_billingDate);
        // $this->db->where('created_date <=', $crr_billingDate);
        $this->db->where('DATE(created_date) <=', $billing_date);
        $this->db->where_in('order_schedule_id', $order_schedule_ids);
        $query = $this->db->get();
        //  echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $result = $query->result();
            return $result;
        }else{
            return false;
        } 
    }
    public function get_payementDate_inRange($session_from,$session_to){
        $this->db->SELECT('*');
        $this->db->from('payment_schedule');
        $this->db->where('session_from', $session_from);
        $this->db->where('session_to', $session_to);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
    public function get_schedule_ids_frm_odrdetls_by_billingId($billing_id){
        $this->db->select('order_schedule_id');
        $this->db->from('order_billing_details');
        $this->db->where('billing_id',$billing_id);       
        // $this->db->where('created_by', $pid);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";      
        return $query->result();
    }
	public function get_order_schedules_by_pid_odrid($presenter_id, $order_id){
        $this->db->select('*');
        $this->db->from('order_schedules');
        $this->db->where('order_id',$order_id);       
        $this->db->where('created_by', $presenter_id);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";    
        if($query->num_rows() > 0 ){
            // $res = $query->result();
            $this->db->select('SUM(ROUND(order_schedules.total_hours)) as total_hours_scheduled,CONCAT(users.first_name, " ", users.last_name) as presenter_name');
            $this->db->from('order_schedules');
            $this->db->join('users', 'order_schedules.created_by = users.id');
            $this->db->where('order_schedules.order_id',$order_id);       
            $this->db->where('order_schedules.created_by', $presenter_id);
            $query1=$this->db->get();
            $res = $query1->row();
        }  
        // return $query->result();
        return $res;
    }
	public function get_all_school_by_presenter($filter = array(), $order = null, $dir = null) {
        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $filter['presenter_id']);
        $query1 = $this->db->get();
        $final_orders = $query1->result();
        $final_order_ids = array();
        foreach($final_orders as $final_orders_id){
            $final_order_ids[] = $final_orders_id->order_id;
        }
        // echo $this->db->last_query();die;
        // echo '<pre>'; print_r($final_order_ids); die();

        $this->db->select('orders.*, user_meta.meta_value as school_name');
        $this->db->from('orders');
        $this->db->join('user_meta', 'orders.school_id = user_meta.user_id AND user_meta.meta_key = \'school_name\'');
        if(!empty($final_order_ids)){
            $this->db->where_in('orders.id', $final_order_ids);
        }
        // $this->db->where_in('orders.id', $final_order_ids);
        $this->db->where('orders.is_deleted', $filter['deleted']);
        $this->db->order_by('updated_on DESC');
        $this->db->group_by("orders.school_id");
        $query2 = $this->db->get();
        // $final_result = $query2->result();
        // echo $this->db->last_query();die;
        return $query2->result();
    }
	public function get_invoice_by_pid_odrid($presenter_id, $order_id){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id',$order_id);       
        $this->db->where('presenter_id', $presenter_id);
        $query=$this->db->get();
        //echo $this->db->last_query()."<br>";      
        // return $query->result();
        if($query->num_rows() > 0 ){
            $this->db->select('first_name, last_name');
            $this->db->from('users');
            $this->db->where('id',$presenter_id);      
            $query1=$this->db->get();
            $presenter_detls = $query1->row();
            $pre_name = $presenter_detls->first_name." ".$presenter_detls->last_name;
            return $pre_name;
        }else{
            return false;
        } 
    } 
	//only fetch selected_topics from the topic window.
    function get_selected_topics($title_id, $order_id) {
        $title_id = (int) $title_id;

        $this->db->from('order_topics');
        $this->db->where('order_id', $order_id);
        $query1 = $this->db->get();
        $selctd_res = $query1->result();
        // $total_row = count($selctd_res);

        // echo '<pre>'; print_r($selctd_res); die();

        $this->db->from('title_topics');
        $this->db->where('title_id', $title_id);
        // $this->db->limit($total_row);

        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $key => $value) {
            foreach($selctd_res as $k => $val){
                if($val->topic_id == $key){
                    $data[$value->id] = $value->topic;
                }
            }
            // $data[$value->id] = $value->topic;
        }
        return $data;
    }
	function get_order_details_specific($id, $presenter_id) {
        $id = (int) $id;
        $this->db->select('orders.*, user_meta.meta_value as school_name, p_company.meta_value as company_name, p_phone.meta_value as presenter_phone, p_address.meta_value as presenter_address, p_rate.meta_value as hourly_rate,SUM(order_schedules_hours.total_hours) as total_hours_scheduled, CONCAT(orders_created.first_name, " ", orders_created.last_name) as created_by_name, CONCAT(orders_updated.first_name, " ", orders_updated.last_name) as updated_by_name, (SELECT MAX(start_date) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS last_day_scheduled, titles.name as title_name, titles.public_school_title_status as public_school_title_status, schools.first_name as principle_name, CONCAT(presenters.first_name, " ", presenters.last_name) as teacher_name, presenters.headerImg');
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

        $this->db->where('order_schedules_hours.created_by', $presenter_id);
        $this->db->where('order_schedules_hours.order_id', $id);

        $this->db->where('assigned_presenters.presenter_id', $presenter_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	function presenter_total_hours($order_id,$presenter_id) {
       
        $this->db->select('assigned_hours');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('order_id', $order_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row();
    }
	function get_schedule_in_assigned_school($id){
        $this->db->select('*');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'holiday_schedule_id');
        $this->db->where('meta_value', $id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        // return $query->row();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }
    }
	function get_school_titles_without_inactive($school_id) {
        $school_id = (int) $school_id;
        $this->db->select('school_titles.title_id, titles.name');
        $this->db->from('school_titles');
        $this->db->join('titles', 'school_titles.title_id = titles.id');
        $this->db->where('school_titles.school_id', $school_id);
        $this->db->where('titles.status', 'active');
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";die;
        //return $query->result();
        $data = array();
        foreach ($query->result() as $key => $value) {
            $data[$value->title_id] = $value->name;
        }
        return $data;
    }
	 // added 09-09-2021
    function delete_title($id){
        // echo 'sssssd'; die();
        // echo $id;
        $this->db->where('title_id', $id);
        $this->db->delete('title_topics');
    }
	// added 09-09-2021
    function delete_single_title_topic($topic_title_id){
        $this->db->where('id', $topic_title_id);
        $this->db->delete('title_topics');
        return;
    }
	// added 09-09-2021
    function remove_titles($id){
        $this->db->where('id', $id);
        $this->db->delete('title_topics');
        // also delete template from admin_library_topic table
        $this->db->where('admin_library_topic.topic_id', $id);
        $this->db->delete('admin_library_topic');
    }
	// 27-09-2021
    public function get_teacher_by_title($id,$sc_id,$tid)
    {
        $this->db->select('teachers.name as teacher_name');
        $this->db->from('teachers');
        $this->db->join('grades', 'teachers.grade_id = grades.id');
        $this->db->where('teachers.grade_id', $id);
        $this->db->where('teachers.school_id', $sc_id);
        $this->db->where('teachers.title_id', $tid);
        // $this->db->group_by('teachers.name');
      
        $query=$this->db->get();
        //echo "<pre>";print_r($query->result());die;
        return $query->result();
    }
	// 27-09-2021
    public function get_title_id($odr_id)
    {
        $this->db->select('title_id');
        $this->db->from('orders');
        $this->db->where('id', $odr_id);
        // $this->db->group_by('teachers.name');
      
        $query=$this->db->get();
        //echo "<pre>";print_r($query->result());die;
        return $query->row()->title_id;
    }
	// added 29-09-2021
    public function get_teacher_grades_title($id,$title_id){

        $this->db->select('teachers.id,teachers.school_id,teachers.grade_id,teachers.name as teacher_name,grades.name as grade_name');
        $this->db->from('teachers');
        $this->db->where('teachers.school_id', $id);
        $this->db->where('teachers.title_id', $title_id);
        $this->db->join('grades', 'teachers.grade_id = grades.id');
       // $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
        $this->db->group_by('teachers.grade_id');
        $this->db->where('grades.status', 'active');
        $query=$this->db->get();
        //echo "<pre>";print_r($query->result());die;
        return $query->result();
    } 
	//05-10-2021
    public function get_previous_orders($presenter_id){
        $static_date = '2021-10-05 00:00:00';

        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $presenter_id);
        //$this->db->where('created_on <=', $static_date);


        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $results = $query->result();
        // echo '<pre>'; print_r($result); die();
        // return $result;
        $order_ids = array();
        foreach($results as $result){
            $order_ids[] = $result->order_id;
        }
        // echo '<pre>'; print_r($order_ids); die();

        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where_in('id', $order_ids);
		$this->db->where('created_on <=', $static_date);
        $this->db->where('is_deleted', 0);
        $query1 = $this->db->get();
        $results1 = $query1->result();
        // echo '<pre>'; print_r($results1); die();

        $final_order_ids = array();
        foreach($results1 as $result1){
            $final_order_ids[] = $result1->id;
        }
        // echo '<pre>'; print_r($final_order_ids); die();

        $results2 = array();
        foreach($results1 as $result1){
            // $this->db->select('orders.order_no, user_meta.meta_value as school_name, order_assigned_presenters.assigned_hours, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS total_hours_scheduled');
            $this->db->select('orders.order_no, orders.created_on, users.first_name, users.last_name, user_meta.meta_value as school_name, order_assigned_presenters.assigned_hours, (SELECT SUM(total_hours) FROM order_schedules WHERE order_schedules.order_id = orders.id) AS total_hours_scheduled');
            $this->db->from('orders');
            // $this->db->where_in('orders.id', $final_order_ids);
            $this->db->where('orders.id', $result1->id);
            $this->db->where('orders.is_deleted', 0);
            $this->db->group_by('order_schedules.order_id');

            $this->db->join('users', 'orders.school_id = users.id', 'left');
            $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_name'", "left outer");
            $this->db->join('order_schedules', 'orders.id = order_schedules.order_id', 'left');
            $this->db->join('order_assigned_presenters', 'orders.id = order_assigned_presenters.order_id', 'left');

            // $this->db->where_in('id', $order_ids);
            // $this->db->where('is_delete', 0);
            $query2 = $this->db->get();
            // echo $this->db->last_query(); die();
            $results2[] = $query2->result();
        }
        //  echo '<pre>'; print_r($results2); die();
        return $results2;
    }

     // added 20-09-2021
     function get_school_id($order_id){
        $this->db->select('school_id');
        $this->db->from('orders');
        $this->db->where('id', $order_id);

        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->row()->school_id;
        }else{
            return false;
        }
    }

    // added 20-09-2021
    function get_holiday_schedule_id($school_id){
        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('user_id', $school_id);
        $this->db->where('meta_key', 'holiday_schedule_id');
        
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->row()->meta_value;
        }else{
            return false;
        }
    }

    // added 20-09-2021
    function get_holiday_schedule_days($holiday_schedule_id){
        $this->db->select('day');
        $this->db->from('schedule_weekdays');
        $this->db->where('schedule_id', $holiday_schedule_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $result = $query->result();
        $days = array();
        foreach($result as $day){
            $days[]=$day->day;
        }
        return $days;
    }

    // added 20-09-2021
    function get_day_name_of_schedule($order_schedule_id){
        $this->db->select('start_date');
        $this->db->from('order_schedules');
        $this->db->where('id', $order_schedule_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row()->start_date;
    }

     // added 21-09-2021
     function get_sdate_edate($holiday_id){
        $this->db->select('start_date, end_date');
        $this->db->from('holidays');
        $this->db->where('id', $holiday_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $result = $query->row();
        return $result;
    }

    // added 21-09-2021
    function get_holidays($holiday_schedule_id){
        $this->db->select('holiday_id');
        $this->db->from('schedule_holidays');
        $this->db->where('schedule_id', $holiday_schedule_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $result = $query->result();
        $holiday_ids = array();
        foreach($result as $holiday_id){
            $holiday_ids[]=$holiday_id->holiday_id;
        }
        return $holiday_ids;
    }

    // added 28-09-2021
    public function get_min_date($order_id){
        // DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d")
        $this->db->select('MIN(DATE_FORMAT(start_date, "%Y-%m-%d")) as min_start_date');
        // $this->db->select('start_date');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        // $this->db->order_by('created_date', 'desc');
        // $this->db->limit(1);
        $q = $this->db->get();
        $res = $q->row();
        return $res->min_start_date;
    }
    public function older_submitted_invoice($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));  
            $this->db->SELECT('status');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $where = '(status = "Hours scheduled" or status = "Draft attached" or status = "Approved" or status = "Confirm hours" or status = "Create log" or status = "Log sent - awaiting principal signature" or status = "Awaiting Review" or status = "Create invoice")';
            $this->db->where($where);
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
            // return $query->result();
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('status');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $where = '(status = "Hours scheduled" or status = "Draft attached" or status = "Approved" or status = "Confirm hours" or status = "Create log" or status = "Log sent - awaiting principal signature" or status = "Awaiting Review" or status = "Create invoice")';
            $this->db->where($where);
            // $this->db->where('status', 'Invoice created');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->num_rows();
            // return $query->result();
        }
    }

    public function total_hours_ready_to_invoice_dashboard($order_id, $presenter_id, $date, $flag){
        if($flag == 1){
            $endDate =  date('Y-m-d', strtotime($date. ' + 14 days'));   
            $this->db->SELECT('SUM(total_hours) AS total_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status', 'Create invoice');
            // $this->db->where('status', 'Invoice created');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->row()->total_hours;
            // return $query->result();
        }else{
            $dArray = explode('-',$date);
            $endDate = $dArray[0].'-'.$dArray[1].'-31';
            $this->db->SELECT('SUM(total_hours) AS total_hours');
            $this->db->from('order_schedules');
            $this->db->where('order_id', $order_id);
            $this->db->where('created_by', $presenter_id);
            $this->db->where('DATE(start_date) >=', $date);
            $this->db->where('DATE(start_date) <=', $endDate);
            $this->db->where('status', 'Create invoice');
            // $this->db->where('status', 'Invoice created');
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->row()->total_hours;
            // return $query->result();
        }
    }
	public function get_titles_id_for_order_filter($order_no){
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('order_no', $order_no);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $result = $query->row();
            $this->db->select('order_id');
            $this->db->from('order_assigned_presenters');
            $this->db->where('order_id', $result->id);
            $this->db->where('presenter_id', $this->session->userdata('id'));
            $query1 = $this->db->get();
            // echo $this->db->last_query(); die();
            if($query1->num_rows() > 0 ){
                $result1 = $query1->row();
                $this->db->select('title_id');
                $this->db->from('orders');
                $this->db->where('id', $result1->order_id);
                $query2 = $this->db->get();
                $result2 = $query2->row();
                return $result2->title_id;
            }  
        }
    }
	public function get_titles_id_for_school_filter($school_id){
        $this->db->select('title_id');
        $this->db->from('school_titles');
        $this->db->where('school_id', $school_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            $titles = $query->result();
            foreach($titles as $title){
                $title_id[] = $title->title_id;
            }
        }
        // echo '<pre>'; print_r($title_id); die();
        return $title_id;
    }
	public function get_titles_by_filter($filter = array(), $order = null, $dir = null, $count = false) {
        // echo '<pre>'; print_r($filter); die();
        $this->db->select('*');
        $this->db->from('titles');
        $this->db->where('is_deleted', 0);
        $this->db->where('status', 'active');
		$this->db->order_by('name ASC');

        // if (isset($filter['title_id_for_order_id']) && $filter['title_id_for_order_id'] != "") {
        //     $this->db->where_in('id', $filter['title_id_for_order_id']);
        // }

        // if (isset($filter['title_id_for_school']) && $filter['title_id_for_school'] != "") {
        //     // $condit .= " AND titles.id='".$title_id."'";
        //     $this->db->where_in('id', $filter['title_id_for_school']);
        // }

        if (isset($filter['title_id_for_order_id']) && isset($filter['order_no']) && $filter['order_no'] !='') {
            $this->db->where_in('id', $filter['title_id_for_order_id']);
        }

        if (isset($filter['title_id_for_school']) && $filter['title_id_for_school'] != "") {
            // $condit .= " AND titles.id='".$title_id."'";
            $this->db->where_in('id', $filter['title_id_for_school']);
            // print_r($filter['title_id_for_school']);
            // echo "if"; die();
        }
       

        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }

        if ( (isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }

        $query = $this->db->get();
        // echo $this->db->last_query(); die();

        return $query->result();
    }
	public function get_topics_list(){
        $this->db->select('*');
        $this->db->from('title_topics');

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->result();
    }

    function get_title_topics_des_order_wise($title_id, $order_no){
        $this->db->select('id');
        $this->db->from('orders');
        $this->db->where('order_no', $order_no);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $result = $query->row();

        $this->db->select('topic_id');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $result->id);
        $this->db->where('created_by', $this->session->userdata('id'));
        $query1 = $this->db->get();
        // echo $this->db->last_query(); die();
        $result1 = $query1->result();
        $topic_ids = array();
        foreach($result1 as $topic){
            $topic_ids[] = $topic->topic_id;
        }
        // print_r($topic_ids);

        // $title_id = (int) $title_id;

        $this->db->from('title_topics');
        $this->db->where_in('id', $topic_ids);

        $query3 = $this->db->get();
        $data = array();
        foreach ($query3->result() as $key => $value) {
            $data[$value->id]['topic_name'] = $value->topic;
            $data[$value->id]['topic_des'] = $value->description;
            $data[$value->id]['topic_id'] = $value->id;
        }
        return $data;
    }

    public function get_schedule_log($log_id){

        $this->db->select('order_schedule_status_log.*');
        $this->db->from('order_schedule_status_log');
        $this->db->where('order_schedule_status_log.id', $log_id);
        return $this->db->get()->row();
    }

    function get_all_log_content($order_schedule_id){
        $order_schedule_id = (int) $order_schedule_id;

        $this->db->select('order_schedule_status_log.*');
        $this->db->from('order_schedule_status_log');         
        $this->db->where('order_schedule_status_log.order_schedule_id', $order_schedule_id);
        
        $query = $this->db->get();
       
        return $query->result_array();;
    } 
   
    function get_reupload_status($orderId, $presenterId, $sessionTo, $sessionFrorm, $public_status){

        $this->db->select('order_schedules.re_upload_change');
        $this->db->from('order_schedules');
        $this->db->where('order_schedules.re_upload_change', '1');
        $this->db->where('order_schedules.order_id', $orderId);
        $this->db->where('order_schedules.created_by', $presenterId);

        $this->db->where('DATE(order_schedules.start_date) >=', $sessionFrorm);
        $this->db->where('DATE(order_schedules.end_date) <=', $sessionTo);
        if($public_status == 'checked'){
            $this->db->where('invoice_id', 0);
        }

        $query = $this->db->get();
        // echo $this->db->last_query()."<br>";die;
        return $query->result();
    }

    public function get_sessions(){
        $this->db->select('*');
        $this->db->from('sessions');

        $query = $this->db->get();
        $result = $query->result();
        $s_array = array();
		foreach($result as $session){
			$s_array[$session->id] = $session->name;
		}
        return $s_array;
    }

    public function get_curr_session_id($curr_date){
        $dates_array = explode(' ', $curr_date);
        $this->db->select('id');
        $this->db->from('sessions');
        $this->db->where('start_date <=', $dates_array[0]);
        $this->db->where('end_date >=', $dates_array[0]);
        $query = $this->db->get();
        $result = $query->row();
        return $result->id;
    }

    public function get_total_hours_assigned($session_id, $presenter_id = NULL){
        $this->db->select('id');
        $this->db->from('orders');
        if($session_id == 1){
            $this->db->where('session_id >', 0);
        }else{
            $this->db->where('session_id', $session_id);
        }
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        $order_ids= array();
        if($query->num_rows() > 0 && !empty($result)){
            foreach($result as $order_id){
                $order_ids[] = $order_id->id;
            }
            $this->db->select('SUM(assigned_hours) as total_assigned_hours');
            $this->db->from('order_assigned_presenters');
            $this->db->where_in('order_id', $order_ids);
            if(isset($presenter_id) && $presenter_id != ''){
                $this->db->where('presenter_id', $presenter_id);
            }
            $query1 = $this->db->get();
            $result1 = $query1->row();
            return $result1;
        }else{
            return false;
        }
    }

    public function get_total_hours_schedule($session_id, $presenter_id = NULL){
        $this->db->select('id');
        $this->db->from('orders');
        if($session_id == 1){
            $this->db->where('session_id >', 0);
        }else{
            $this->db->where('session_id', $session_id);
        }
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        $order_ids= array();
        if($query->num_rows() > 0 ){
            foreach($result as $order_id){
                $order_ids[] = $order_id->id;
            }
            $this->db->select('SUM(total_hours) as total_scheduled_hours');
            $this->db->from('order_schedules');
            $this->db->where_in('order_id', $order_ids);
            if(isset($presenter_id) && $presenter_id != ''){
                $this->db->where('created_by', $presenter_id);
            }
            $query1 = $this->db->get();
            $result1 = $query1->row();
            return $result1; 
        }else{
            return false;
        }
    }

    public function get_session_for_create_order(){
        // $curr_date = date("Y-m-d h:i:s");
        $curr_date = date("Y-m-d");
        $this->db->select('id');
        $this->db->from('sessions');
        $this->db->where('start_date <=', $curr_date);
        $this->db->where('end_date >=', $curr_date);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        $result = $query->row();
        // return $result->id;
        $this->db->select('*');
        $this->db->from('sessions');
        $this->db->where('id >=', $result->id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        $result = $query->result();
        // print_r($result); die();
        // return $result;
        $session_array = array();
		foreach($result as $session){
			// echo '<pre>'; print_r($session); echo '</br>';
			// echo $session->id;
			$session_array[$session->id] = $session->name;
		}
        return $session_array;
    }

    public function get_session_dates_by_id($id){
        $this->db->select('*');
        $this->db->from('sessions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function get_orders_by_presenters_sessionwise($presenters_id, $session_id){
        $static_date = '2021-10-05 00:00:00';
        if($session_id == 2){
            return false;
        }else{
            $this->db->select('order_schedules.order_id');
            $this->db->from('order_schedules');
            $this->db->join('orders', 'order_schedules.order_id = orders.id');
            $this->db->where('order_schedules.created_by',$presenters_id);
            $this->db->where('orders.is_deleted', '0');
            if($session_id == 1){
                $this->db->where('orders.session_id >', 0);    
                $this->db->where('orders.created_on >', $static_date);  
            }else{
                $this->db->where('orders.session_id', $session_id);
                $this->db->where('orders.created_on >', $static_date); 
            }
            // $this->db->where('orders.session_id', $session_id);
            $this->db->order_by('order_schedules.order_id', 'DESC');
            $this->db->group_by('order_schedules.order_id');
            
            $query = $this->db->get();
            // echo $this->db->last_query(); die();
            return $query->result();
        }
    }
    function get_order_schedule_session($order_id=null, $presenter_id=null, $group_by='',$session_id=null) {
		
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
        if ($session_id <> null) {
			if($session_id == 1){
                $this->db->where('orders.session_id >', 0);    
            }else{
                $this->db->where('orders.session_id', $session_id);
            }
		}
        if($group_by != ''){
          $this->db->group_by($group_by);
        }
		$this->db->order_by('order_schedules.start_date ASC');
		
		$query = $this->db->get();
        //echo $this->db->last_query(); die();
        $record = $query->result();
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.updated_on DESC');
            $this->db->group_by('order_schedule_status_log.old_status');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
	}

    public function getSessionIdByOdrId($order_id){
        $this->db->select('session_id');
        $this->db->from('orders');
        $this->db->where('id', $order_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->session_id;
    }

    public function get_presenters_for_admin() {

        $this->db->select('users.*, CONCAT(users.first_name, " ", users.last_name) as presenter_name');
        $this->db->from('users');
        $this->db->where('users.role_id', 3);
        $this->db->where('users.is_deleted', 0);
        $this->db->order_by('first_name ASC');
        $query = $this->db->get();
        return $query->result();
    }   
	public function get_schedule_details_specific($schedule_id){
        $this->db->select('*');
        $this->db->from('order_schedules');
        $this->db->where('id', $schedule_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
	public function get_order_assigned_presenters($order_id,$presenter_id){
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->result();
    }
	public function update_assignedhrs_presenter($tablename,$order_id,$presenter_id,$data){
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function get_schedule_details_specific_by_presenter($schedule_id,$presenter_id){
        $this->db->select('*');
        $this->db->from('order_schedules');
        $this->db->where('id', $schedule_id);
        $this->db->where('created_by', $presenter_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function check_topic_string($topic_string,$title_id){
        $this->db->select('*');
        $this->db->from('title_topics');
        $this->db->where('title_id', $title_id);
        $this->db->where('topic', $topic_string);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->id;
        }else{
            $data['title_id'] = $title_id;
            $data['topic'] = $topic_string;
            $topic_id = $this->insert('title_topics', $data);
            return $topic_id;
        }
    }

    public function get_schedule_details_by_bw_date_presenter($fromDate, $toDate, $presenter) {

        $this->db->select('*');
		$this->db->from('order_schedules');
		$this->db->where('DATE(start_date) >=', date('Y-m-d',strtotime($fromDate)));
		$this->db->where('DATE(start_date) <=', date('Y-m-d',strtotime($toDate)));
		$this->db->where('created_by', 258);
		$query = $this->db->get();
		// echo $this->db->last_query()."<br>";exit;      
		return $query->result();
    }

    public function check_schedule_submitted($schedule_id){
        $this->db->select('*');
		$this->db->from('order_schedules');
		$this->db->where('id', $schedule_id);
        $this->db->where('status !=', 'Hours scheduled');
        $this->db->where('status !=', 'Draft attached');
        $this->db->where('status !=', 'Approved');
        $this->db->where('status !=', 'Confirm hours');
        $this->db->where('status !=', 'Create log');
        $this->db->where('status !=', 'Log sent - awaiting principal signature');
        $this->db->where('status !=', 'Awaiting Review');
        $this->db->where('status !=', 'Create invoice');
		$query = $this->db->get();
		// echo $this->db->last_query()."<br>";die();  
		if($query->num_rows()>0){
            return false;
        }else{
            return true;
        }
    }

    public function schedules_for_cron($fromDate, $toDate) {

        $this->db->select('*');
		$this->db->from('order_schedules');
		$this->db->where('DATE(start_date) >=', date('Y-m-d',strtotime($fromDate)));
		$this->db->where('DATE(start_date) <=', date('Y-m-d',strtotime($toDate)));
        $this->db->where('status !=', 'Invoice created');
        $this->db->where('status !=', 'Payment sent');
        $this->db->where('status !=', 'Completed');
        $this->db->where('status !=', 'Rejected - reschedule');
        $this->db->where('status !=', 'Rejected - don&#39;t want');
        $this->db->where('is_public_school !=', 'checked');
		$this->db->group_by('created_by');
		$query = $this->db->get();
		// echo $this->db->last_query()."<br>";exit;      
		return $query->result();
    }

    public function check_grade_string($grade_string,$user_id){
        $this->db->select('*');
        $this->db->from('grades');
        $this->db->where('name', $grade_string);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->id;
        }else{
            $data['created_by'] = $user_id;
            // $data['status'] = $user_id;
            $data['name'] = $grade_string;
            $grade_id = $this->insert('grades', $data);
            return $grade_id;
        }
    }
    public function check_is_same_billing_submitted($order_id, $presenter_id, $start_date, $end_date){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('session_from <=', $start_date);
        $this->db->where('session_to >=', $end_date);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function check_date_if_exits_submitted_invoice($date, $presenter_id, $order_id){
        $flag = 0;
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $records = $query->result();
            foreach($records as $record){
                if($date >= $record->session_from && $date <= $record->session_to){
                    $flag++;
                }
            }
            if($flag != 0){
                return true;
            }
        }else{
            return false;
        }
    }

    public function get_total_hours_assigned_by_order($order_id, $presenter_id)
    {
        $this->db->select('SUM(assigned_hours) as tot_assigned_hours');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id !=', $presenter_id);

        $get_assigned_hours_que = $this->db->get();
        $get_assigned_hours_arr = $get_assigned_hours_que->row_array();

        if(!empty($get_assigned_hours_arr))
        {
            $order_assigned_hrs = $get_assigned_hours_arr['tot_assigned_hours'];
            return $order_assigned_hrs;
        }
        else
        {
            return false;
        }
    }

    public function get_presenter_name($presenter_id){
        $this->db->select('first_name,last_name');
        $this->db->from('users');
        $this->db->where('id', $presenter_id);

        $query1=$this->db->get();
        // echo $this->db->last_query(); die;
        $res = $query1->row();
        // return $query->result();
        // return $res;
        if($query1->num_rows() > 0){
            return $res;
        }else{
            return false;
        }

    }

    public function get_presenter_grade_ids($order_id, $presenter_id)
    {
        $this->db->select('grade_id');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);

        $get_grade_ids = $this->db->get();
        $get_grade_ids_arr = $get_grade_ids->row_array();

        if(!empty($get_grade_ids_arr))
        {
            $order_grade_ids = $get_grade_ids_arr['grade_id'];
            return $order_grade_ids;
        }
        else
        {
            return false;
        }
    }

    public function delete_prev_presntrOdr($order_id, $presenter_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->delete('order_assigned_presenters');

        return true;
    }

    public function get_assigned_hurs_specific($presenter_id, $order_id){   
        // $res = $query->result();
        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id',$order_id);       
        $this->db->where('presenter_id', $presenter_id);
        $query1=$this->db->get();
        $res = $query1->row();
        // return $query->result();
        // return $res;
        if($query1->num_rows() > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function get_order_details_by_orderId($order_id){   
        // $res = $query->result();
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('id',$order_id);       
        $query1=$this->db->get();
        $res = $query1->row();
        // return $query->result();
        // return $res;
        if($query1->num_rows() > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function get_school_name($schl_id){   
        // $res = $query->result();
        $this->db->select('*');
        $this->db->from('user_meta');
        $this->db->where('user_id',$schl_id);   
        $this->db->where('meta_key','school_name');     
        $query1=$this->db->get();
        $res = $query1->row();
        // return $query->result();
        // return $res;
        if($query1->num_rows() > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function get_title_name($title_id){   
        // $res = $query->result();
        $this->db->select('*');
        $this->db->from('titles');
        $this->db->where('id',$title_id);     
        $query1=$this->db->get();
        $res = $query1->row();
        // return $query->result();
        // return $res;
        if($query1->num_rows() > 0){
            return $res;
        }else{
            return false;
        }
    }

    function principal($id){
        $this->db->select('meta_value');
        $this->db->from('user_meta');
        $this->db->where('meta_key', 'principal_name');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_schedule_logContent_txt($id){
        $sql ="SELECT content_txt FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Create log' AND `new_status`='Log sent - awaiting principal signature') LIMIT 1";
        $query = $this->db->query($sql);
        //echo $this->db->last_query()."<br>";      
        return $query->row()->content_txt;
    }

    public function logs_principal_name($id){
        $sql ="SELECT principal_name FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Create log' AND `new_status`='Log sent - awaiting principal signature') LIMIT 1";
        $query = $this->db->query($sql);
        // echo $this->db->last_query()."<br>";  die;    
        return $query->row()->principal_name;
    }

    function update_for_old_row($tablename, $field_name, $field_value, $data) {
        $this->db->where($field_name, $field_value);
        $this->db->where('new_status', 'Log sent - awaiting principal signature');
        $this->db->where('old_status', 'Create log');
        //   echo $this->db->last_query(); die;
        if ($this->db->update($tablename, $data)) {
            return true;
        }else{
            return false;
        }
    }

    public function get_order_schedule_content($id){
        $sql ="SELECT content FROM `order_schedule_status_log` WHERE `order_schedule_id`=".$id." AND (`old_status`='Create log' AND `new_status`='Log sent - awaiting principal signature')";
        $query = $this->db->query($sql);
        // echo $this->db->last_query()."<br>";  die;    
        return $query->row()->content;
    }

    public function get_schedules_of_notSubmitted($fromDate, $toDate) {

        $this->db->select('*');
		$this->db->from('order_schedules');
		$this->db->where('DATE(start_date) >=', date('Y-m-d',strtotime($fromDate)));
		$this->db->where('DATE(start_date) <=', date('Y-m-d',strtotime($toDate)));
        $this->db->where('status !=', 'Invoice created');
        $this->db->where('status !=', 'Payment sent');
        $this->db->where('status !=', 'Completed');
        $this->db->where('status !=', 'Rejected - reschedule');
        $this->db->where('status !=', 'Rejected - don&#39;t want');
		$this->db->group_by('created_by');
		$query = $this->db->get();
		//echo $this->db->last_query()."<br>";exit;      
		// return $query->result();

        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }

    }

    public function get_specific_assignment_by_presenter($order_id, $presenter_id)
    {
        $return_array = array();

        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('order_id', $order_id);

        $get_assignedhours_que = $this->db->get();
        $get_assignedhours_arr = $get_assignedhours_que->result_array();
        $total_number_element  = count($get_assignedhours_arr);

        if($total_number_element > 0)
        {
            $presenter_array = array();
            $allowed_hrs_arr = array();
            $allowed_grd_arr = array();

            foreach($get_assignedhours_arr as $key=>$vals)
            {
                $presenter_array[$key]              = $vals['presenter_id'];
                $presenter_key                      = $vals['presenter_id']; 
                $allowed_hrs_arr[$presenter_key]    = $vals['assigned_hours'];
                $allowed_grd_arr[$presenter_key]    = $vals['grade_id'];
            }

            $this->db->select('SUM(assigned_hours) as total_hours');
            $this->db->from('order_assigned_presenters');
            $this->db->where('order_id', $order_id);
            if($presenter_id != NULL){
                $this->db->where('presenter_id !=', $presenter_id);
            }
            

            $get_totalhours_que = $this->db->get();
            $get_totalhours_arr = $get_totalhours_que->row_array();            

            $return_array = array(  'presenters'        => $presenter_array, 
                                    'assigned_hours'    => $allowed_hrs_arr, 
                                    'grade_id'          => $allowed_grd_arr, 
                                    'total_used_hours'  => $get_totalhours_arr['total_hours']);

            return $return_array;
        } 
        else
        {
            return false;
        }

    }

    // public function teacher_report($id){
    //     $this->db->select('*');
    //     $this->db->from('orders');
    //     $this->db->where('school_id', $id);
        
    //     $query = $this->db->get();
    //     // echo $this->db->last_query();die;
    //     $orders = $query->result_array();
    //     $order_ids =array();
    //     foreach($orders as $orderid){
    //         $order_ids[] = $orderid['id'];
    //     }
    //     if(!empty($order_ids)){
    //         $this->db->select('order_schedules.*,Order.session_id AS session_id');
    //         // $this->db->select('*,Order.session_id AS session_id,CONCAT(presenters.first_name, " ", presenters.last_name) as presenter_name');
    //         $this->db->from('order_schedules');
    //         $this->db->join('orders AS Order', 'Order.id = order_schedules.order_id');
    //         // $this->db->join('users AS presenters', 'order_schedules.created_by = presenters.id', 'left');
    //         $this->db->where_in('order_schedules.order_id', $order_ids);
    //         $this->db->where('Order.school_id', $id);
    //         $this->db->order_by('Order.session_id');
    //         $this->db->order_by('order_schedules.start_date DESC');
    //         $this->db->order_by('order_schedules.teacher');
    //         $this->db->order_by('order_schedules.grade_id');
    //         $this->db->order_by('order_schedules.created_by');
    //         $this->db->order_by('order_schedules.topic_id');
    //         // $this->db->order_by('order_schedules.start_date DESC');
    //         // $this->db->group_by('teacher');
    //         $query2 = $this->db->get();
    //         // echo $this->db->last_query();die;
    //         $order_schedules_details = $query2->result_array();
    //         $finalArray = array();
    //         $firstDate = '';
    //         foreach($order_schedules_details as $key => $val){
    //             if($key == 0){
    //                 $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
    //                 $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
    //                 $finalArray[] = $val;
    //             }else{
    //                 $lastItem = end($finalArray);
                    
    //                 if(($val['session_id'] == $lastItem['session_id']) && ($val['teacher'] == $lastItem['teacher']) && ($val['grade_id'] == $lastItem['grade_id']) && ($val['created_by'] == $lastItem['created_by']) && ($val['topic_id'] == $lastItem['topic_id'])){
                        
    //                     $total_hours = $lastItem['total_hours'] + $val['total_hours'];
    //                     if($firstDate != date("Y/m/d",strtotime($val['start_date']))){
    //                         $dateRange = $firstDate."-".date("Y/m/d",strtotime($val['start_date']));
    //                         // $dateRange = date("Y/m/d",strtotime($val['start_date']))." -".$firstDate;
    //                     }else{
    //                         $dateRange = date("Y/m/d",strtotime($lastItem['start_date']));
    //                     }
    //                     $lastItem['total_hours'] =$total_hours;
    //                     $lastItem['start_date'] =$dateRange;
    //                     array_pop($finalArray);
    //                     $finalArray[] = $lastItem;
    //                 }else{
    //                     $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
    //                     $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
    //                     $finalArray[] = $val;
    //                 }
    //             }
    //         }
           
    //         // return $finalArray;
    //         $resultArray = array();
    //         foreach($finalArray as $key => $val){
    //             $name = $this->get_presenter_name($val['created_by']);
    //             $grade_name = $this->get_grade_name($val['grade_id']);
    //             $topic_name = $this->get_topic_name($val['topic_id']);
    //             $session_name = $this->get_session_dates_by_id($val['session_id']);
    //             // print_r($session_name);
    //             // echo $session_name->name; echo " ----- ";
    //             // die;
    //             $val['created_by'] = $name->first_name." ".$name->last_name;
    //             if(isset($grade_name->name)){
    //                 $val['grade_id'] = $grade_name->name;
    //             }else{
    //                 $val['grade_id'] = 'N/A';
    //             }
                
    //             if(isset($topic_name->topic)){
    //                 $val['topic_id'] = $topic_name->topic;
    //             }else{
    //                 $val['topic_id'] = 'N/A';
    //             }
    //             if(isset($session_name->name)){
    //                 $val['session_id'] = $session_name->name;
    //             }else{
    //                 $val['session_id'] = 'N/A';
    //             }
                
    //             $resultArray[] = $val;
    //         }
    //         // echo '<pre>'; print_r($resultArray);
    //         // die;

    //         $dateSort = array();
    //         foreach ($resultArray as $key => $row)
    //         {
    //             $dateSort[$key] = $row['start_date'];
    //         }
    //         array_multisort($dateSort, SORT_DESC, $resultArray);

    //         return $resultArray;
    //     }else{
    //         return $resultArray = array();
    //     }
    //     // $this->db->select('order_schedules.*,Order.session_id AS session_id');
    //     // // $this->db->select('*,Order.session_id AS session_id,CONCAT(presenters.first_name, " ", presenters.last_name) as presenter_name');
    //     // $this->db->from('order_schedules');
    //     // $this->db->join('orders AS Order', 'Order.id = order_schedules.order_id');
    //     // // $this->db->join('users AS presenters', 'order_schedules.created_by = presenters.id', 'left');
    //     // $this->db->where_in('order_schedules.order_id', $order_ids);
    //     // $this->db->where('Order.school_id', $id);
    //     // $this->db->order_by('order_schedules.start_date DESC');
    //     // $this->db->order_by('Order.session_id');
    //     // $this->db->order_by('order_schedules.teacher');
    //     // $this->db->order_by('order_schedules.grade_id');
    //     // $this->db->order_by('order_schedules.created_by');
    //     // $this->db->order_by('order_schedules.topic_id');
    //     // // $this->db->group_by('teacher');
    //     // $query2 = $this->db->get();
    //     // // echo $this->db->last_query();die;
    //     // $order_schedules_details = $query2->result_array();
    //     // $finalArray = array();
    //     // $firstDate = '';
    //     // foreach($order_schedules_details as $key => $val){
    //     //     if($key == 0){
    //     //         $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
    //     //         $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
    //     //         $finalArray[] = $val;
    //     //     }else{
    //     //         $lastItem = end($finalArray);
                
    //     //         if(($val['session_id'] == $lastItem['session_id']) && ($val['teacher'] == $lastItem['teacher']) && ($val['grade_id'] == $lastItem['grade_id']) && ($val['created_by'] == $lastItem['created_by']) && ($val['topic_id'] == $lastItem['topic_id'])){
                    
    //     //             $total_hours = $lastItem['total_hours'] + $val['total_hours'];
    //     //             if($firstDate != date("Y/m/d",strtotime($val['start_date']))){
    //     //                 // $dateRange = $firstDate."-".date("Y/m/d",strtotime($val['start_date']));
    //     //                 $dateRange = date("Y/m/d",strtotime($val['start_date']))." -".$firstDate;
    //     //             }else{
    //     //                 $dateRange = date("Y/m/d",strtotime($lastItem['start_date']));
    //     //             }
    //     //             $lastItem['total_hours'] =$total_hours;
    //     //             $lastItem['start_date'] =$dateRange;
    //     //             array_pop($finalArray);
    //     //             $finalArray[] = $lastItem;
    //     //         }else{
    //     //             $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
    //     //             $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
    //     //             $finalArray[] = $val;
    //     //         }
    //     //     }
    //     // }
       
    //     // // return $finalArray;
    //     // $resultArray = array();
       

    // }

    public function teacher_report($id){
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('school_id', $id);
        
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $orders = $query->result_array();
        $order_ids =array();
        foreach($orders as $orderid){
            $order_ids[] = $orderid['id'];
        }
        if(!empty($order_ids)){
            $this->db->select('order_schedules.*,Order.session_id AS session_id');
            $this->db->from('order_schedules');
            $this->db->join('orders AS Order', 'Order.id = order_schedules.order_id');
            $this->db->where_in('order_schedules.order_id', $order_ids);
            $this->db->where('Order.school_id', $id);
            $this->db->order_by('Order.session_id DESC');
            // $this->db->order_by('order_schedules.start_date DESC');
            $this->db->order_by('order_schedules.teacher');
            $this->db->order_by('order_schedules.grade_id');
            $this->db->order_by('order_schedules.created_by');
            $this->db->order_by('order_schedules.topic_id');
            $this->db->order_by('order_schedules.start_date ASC');
            // $this->db->group_by('teacher');
            $query2 = $this->db->get();
            // echo $this->db->last_query();die;
            $order_schedules_details = $query2->result_array();
            $finalArray = array();
            $firstDate = '';
            $testingFDate = '';
            $sortedSessionArray = array();
            $sortedDateArray = array();
            // echo '<pre>'; print_r($order_schedules_details); 
            foreach($order_schedules_details as $key => $val){
                if($key == 0){

                    $fdToCom = date_create($val['start_date']);
                    $testingFDate = date_format($fdToCom, "Y-m-d");

                    $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
                    $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
                    $sortedDateArray[$key]  = strtotime($val['start_date']);
                    $sortedSessionArray[$key]  = $val['session_id'];
                    $finalArray[] = $val;
                }else{
                    $lastItem = end($finalArray);
                    
                    if(($val['session_id'] == $lastItem['session_id']) && ($val['teacher'] == $lastItem['teacher']) && ($val['grade_id'] == $lastItem['grade_id']) && ($val['created_by'] == $lastItem['created_by']) && ($val['topic_id'] == $lastItem['topic_id'])){
                        
                        $total_hours = $lastItem['total_hours'] + $val['total_hours'];
                        if($firstDate != date("Y/m/d",strtotime($val['start_date']))){
                          
                           
                            $startDateToCom = date_create($val['start_date']);
                            $startDate = date_format($startDateToCom, "Y-m-d");
                            // echo $startDate; echo " --- ";
                            // echo $testingFDate; 
                            if($testingFDate < $startDate){
                                // echo 't date less..';
                                // echo $firstDate;
                                $dateRange = $firstDate."-".date("Y/m/d",strtotime($val['start_date']));
                            }else{
                                // echo 't date greater..';
                                $dateRange = date("Y/m/d",strtotime($val['start_date']))." -".$firstDate;
                            }
                            // echo '#######</br>';

                            
                        }else{
                            $dateRange = date("Y/m/d",strtotime($lastItem['start_date']));
                        }
                        $lastItem['total_hours'] =$total_hours;
                        $lastItem['start_date'] =$dateRange;
                        array_pop($finalArray);
                        $finalArray[] = $lastItem;
                    }else{
                        $fdToCom = date_create($val['start_date']);
                        $testingFDate = date_format($fdToCom, "Y-m-d");

                        $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
                        $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
                        $sortedDateArray[$key]  = strtotime($val['start_date']);
                        $sortedSessionArray[$key]  = $val['session_id'];
                        $finalArray[] = $val;
                    }
                }
            }
            // Sort the finalArray with session descending, date descending
            array_multisort($sortedSessionArray, SORT_DESC,$sortedDateArray, SORT_DESC,$finalArray);
                //    echo '<pre>'; print_r($finalArray); die;
                // return $finalArray;
            $resultArray = array();
            foreach($finalArray as $key => $val){
                $name = $this->get_presenter_name($val['created_by']);
                $grade_name = $this->get_grade_name($val['grade_id']);
                $topic_name = $this->get_topic_name($val['topic_id']);
                $session_name = $this->get_session_dates_by_id($val['session_id']);
                // print_r($session_name);
                // echo $session_name->name; echo " ----- ";
                // die;
                $val['created_by'] = $name->first_name." ".$name->last_name;
                if(isset($grade_name->name)){
                    $val['grade_id'] = $grade_name->name;
                }else{
                    $val['grade_id'] = 'N/A';
                }
                
                if(isset($topic_name->topic)){
                    $val['topic_id'] = $topic_name->topic;
                }else{
                    $val['topic_id'] = 'N/A';
                }
                // if(isset($session_name->name)){
                    $val['session_id'] = $session_name->name;
                // }else{
                //     $val['session_id'] = 'N/A';
                // }
                $resultArray[] = $val;
            }
            // echo '<pre>'; print_r($resultArray);
            // die;
            return $resultArray;
        }else{
            return $resultArray = array();
        }
        

    }

    public function get_grade_name($grade_id){
        $this->db->select('*');
        $this->db->from('grades');
        $this->db->where('id', $grade_id);

        $query=$this->db->get();
        // echo $this->db->last_query(); die;
        
        // return $query->result();
        // return $res;
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res;
        }else{
            return false;
        }

    }

    public function get_topic_name($topic_id){
        $this->db->select('*');
        $this->db->from('title_topics');
        $this->db->where('id', $topic_id);

        $query=$this->db->get();
        // echo $this->db->last_query(); die;
        
        // return $query->result();
        // return $res;
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res;
        }else{
            return false;
        }

    }

    public function export_teacher_report_from_provider($presenter_id){
        $this->db->select('*');
        $this->db->from('order_assigned_presenters');
        $this->db->where('presenter_id', $presenter_id);
        $query = $this->db->get();
        $orders = $query->result_array();
        $order_ids = array();
        foreach($orders as $orderid){
            $order_ids[] = $orderid['order_id'];
        } 
        
        if(!empty($order_ids)){
            $this->db->select('order_schedules.*,Order.session_id AS session_id, Order.school_id AS school_id');
            $this->db->from('order_schedules');
            $this->db->join('orders AS Order', 'Order.id = order_schedules.order_id');
            $this->db->where_in('order_schedules.order_id', $order_ids);
            $this->db->where('order_schedules.created_by', $presenter_id);
            $this->db->order_by('Order.session_id DESC');
            $this->db->order_by('order_schedules.teacher');
            $this->db->order_by('order_schedules.grade_id');
            $this->db->order_by('order_schedules.created_by');
            $this->db->order_by('order_schedules.topic_id');
            $this->db->order_by('order_schedules.start_date ASC');
            $query2 = $this->db->get();
            $order_schedules_details = $query2->result_array();
            $finalArray = array();
            $firstDate = '';
            $testingFDate = '';
            $sortedSessionArray = array();
            $sortedDateArray = array();
            foreach($order_schedules_details as $key => $val){
                if($key == 0){
                    $fdToCom = date_create($val['start_date']);
                    $testingFDate = date_format($fdToCom, "Y-m-d");

                    $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
                    $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
                    $sortedDateArray[$key]  = strtotime($val['start_date']);
                    $sortedSessionArray[$key]  = $val['session_id'];
                    $finalArray[] = $val;
                }else{
                    $lastItem = end($finalArray);
                    
                    if(($val['session_id'] == $lastItem['session_id']) && ($val['teacher'] == $lastItem['teacher']) && ($val['grade_id'] == $lastItem['grade_id']) && ($val['created_by'] == $lastItem['created_by']) && ($val['topic_id'] == $lastItem['topic_id'])){
                        
                        $total_hours = $lastItem['total_hours'] + $val['total_hours'];
                        // if($firstDate != date("Y/m/d",strtotime($val['start_date']))){
                        //     $dateRange = $firstDate."-".date("Y/m/d",strtotime($val['start_date']));
                        // }else{
                        //     $dateRange = date("Y/m/d",strtotime($lastItem['start_date']));
                        // }


                        if($firstDate != date("Y/m/d",strtotime($val['start_date']))){
                          
                           
                            $startDateToCom = date_create($val['start_date']);
                            $startDate = date_format($startDateToCom, "Y-m-d");
                            if($testingFDate < $startDate){
                                $dateRange = $firstDate."-".date("Y/m/d",strtotime($val['start_date']));
                            }else{
                                $dateRange = date("Y/m/d",strtotime($val['start_date']))." -".$firstDate;
                            }

                            
                        }else{
                            $dateRange = date("Y/m/d",strtotime($lastItem['start_date']));
                        }


                        $lastItem['total_hours'] =$total_hours;
                        $lastItem['start_date'] =$dateRange;
                        array_pop($finalArray);
                        $finalArray[] = $lastItem;
                    }else{

                        $fdToCom = date_create($val['start_date']);
                        $testingFDate = date_format($fdToCom, "Y-m-d");



                        $firstDate = " ".date("Y/m/d",strtotime($val['start_date']));
                        $val['start_date'] = " ".date("Y/m/d",strtotime($val['start_date']));
                        $sortedDateArray[$key]  = strtotime($val['start_date']);
                        $sortedSessionArray[$key]  = $val['session_id'];
                        $finalArray[] = $val;
                    }
                }
            }
            // Sort the finalArray with session descending, date descending
            array_multisort($sortedSessionArray, SORT_DESC,$sortedDateArray, SORT_DESC,$finalArray);
            // return $finalArray;
            $resultArray = array();
            foreach($finalArray as $key => $val){
                $name = $this->get_presenter_name($val['created_by']);
                $grade_name = $this->get_grade_name($val['grade_id']);
                $topic_name = $this->get_topic_name($val['topic_id']);
                $session_name = $this->get_session_dates_by_id($val['session_id']);
                $school_name = $this->get_school_name($val['school_id']);
                $val['created_by'] = $name->first_name." ".$name->last_name;
                if(isset($grade_name->name)){
                    $val['grade_id'] = $grade_name->name;
                }else{
                    $val['grade_id'] = 'N/A';
                }
                if(isset($topic_name->topic)){
                    $val['topic_id'] = $topic_name->topic;
                }else{
                    $val['topic_id'] = 'N/A';
                }
                $val['session_id'] = $session_name->name;
                $val['school_name'] = $school_name->meta_value;
                $resultArray[] = $val;
            }
            return $resultArray;
        }else{
            return $resultArray = array();
        }
    }

    public function log_template()
    {
        $this->db->select('*');
        $this->db->from('presenters_log');
       
  
        $query=$this->db->get();
        return $query->result();
    }
    public function get_presenter_log($id){
        $this->db->select('*');
        $this->db->from('presenters_log');
        $this->db->where('id', $id);
  
        $query=$this->db->get();
        return $query->row();
    }

    public function custom_tmp($filterLogWritingRm, $count=null, $id=null){
        // echo '<pre>'; print_r($filterLogWritingRm);
        $this->db->select('*, custom_templates.id as template_id');
        $this->db->from('custom_templates');
        $this->db->join('title_topics', 'custom_templates.topic = title_topics.id');
        $this->db->where('presenter_id',$id);
  
        // $query=$this->db->get();

        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }

        if ( (isset($filterLogWritingRm['limit']) && $filterLogWritingRm['limit'] > 0) && (isset($filterLogWritingRm['offset']) ) ) {
            $this->db->limit($filterLogWritingRm['limit'], $filterLogWritingRm['offset']);
        }
        $query=$this->db->get();
        // echo $this->db->last_query();

        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }

    public function custom_template_log($id){
        $this->db->select('*');
        $this->db->from('custom_templates');
        $this->db->where('id', $id);
  
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_topic_from_custom_template($id){
        $this->db->select('topic');
        $this->db->from('custom_templates');
        $this->db->where('presenter_id', $id);

        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_topic($id){
        $this->db->select('*');
        $this->db->from('title_topics');
        $this->db->join('order_schedules', 'order_schedules.topic_id = title_topics.id');
        $this->db->where('order_schedules.created_by', $id);
        $this->db->where('title_topics.topic !=' , '');
        $this->db->group_by("order_schedules.topic_id");
        
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }

    public function topic_name(){
        $this->db->select('title_topics.topic');
        $this->db->from('title_topics');
        $this->db->join('custom_templates', 'title_topics.id = custom_templates.topic');
        
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }

    public function favorite_template($presenter_id){
        $this->db->select('*');
        $this->db->from('favorite_template');
        $this->db->where('presenter_id',$presenter_id);

  
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_template_message($template_id){
        $this->db->select('custom_templates.*,title_topics.*');
        $this->db->from('custom_templates');
        $this->db->join('title_topics', 'title_topics.id = custom_templates.topic');
        $this->db->where('custom_templates.id', $template_id);
  
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_custom_template($topic_id, $id){
        $this->db->select('message');
        $this->db->from('custom_templates');
        $this->db->where('topic', $topic_id);
        $this->db->where('presenter_id', $id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }
    }
    public function get_favorite_template($id){
        $this->db->select('message');
        $this->db->from('favorite_template');
        $this->db->where('presenter_id', $id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }
    
    // public function get_library_topic($topic_id){
    //     $this->db->select('description');
    //     $this->db->from('title_topics');
    //     $this->db->where('id', $topic_id);
    //     $query=$this->db->get();
    //     if($query->num_rows() > 0){
    //         $res = $query->row();
    //         return $res; 
    //     }else{
    //         return false;
    //     }
    // }

    
    public function get_brienza_template($brienza_template_id){
        $this->db->select('*');
        $this->db->from('presenters_log');
        $this->db->where('id', $brienza_template_id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function print_log($log_id){
        $this->db->select('*');
        $this->db->from('order_schedule_status_log');
        $this->db->where('order_schedule_id', $log_id);
        $this->db->where('new_status', 'Log sent - awaiting principal signature');

        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function check_title_assigned_to_school($id){
        $this->db->select('*');
        $this->db->from('school_titles');
		$this->db->join('titles', 'school_titles.title_id = titles.id');
		$this->db->where('school_titles.title_id', $id);

        $query=$this->db->get();
        if($query->num_rows() > 0){
            // $res = $query->row();
            return true; 
        }else{
            return false;
        }
    }

    public function get_title_status($title_id){
        $this->db->select('public_school_title_status');
        $this->db->from('titles');
        $this->db->where('id', $title_id);
        $query=$this->db->get();
        return $query->row()->public_school_title_status;
    }

    public function public_school_title($order_id){
        $this->db->select('titles.public_school_title_status');
        $this->db->from('titles');
        $this->db->join('orders', 'titles.id = orders.title_id');
        $this->db->where('orders.id', $order_id);

        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    // suggestive log fr admin  10-03-2023

    public function get_admin_library_list($id,$filter,$count){
        $this->db->select('admin_library_topic.*,title_topics.topic');
        $this->db->from('admin_library_topic');
        $this->db->join('title_topics', 'admin_library_topic.topic_id = title_topics.id');
        $this->db->where('admin_library_topic.title_id', $id);
        if ($count) {
            $query = $this->db->get();
            return $query->num_rows();
        }
        if ((isset($filter['limit']) && $filter['limit'] > 0) && (isset($filter['offset']) ) ) {
            $this->db->limit($filter['limit'], $filter['offset']);
        }
        
        $query=$this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_topic_from_admin_library_template(){
        $this->db->select('topic_id');
        $this->db->from('admin_library_topic');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res; 
        }else{
            return false;
        }

        // $query=$this->db->get();
        // return $query->result();
    }

    public function get_topics_list_by_title($title_id){
        $this->db->select('*');
        $this->db->from('title_topics');

        // $this->db->join('order_schedules', 'order_schedules.topic_id = title_topics.id');
        // $this->db->where('title_topics.topic !=' , '');

        $this->db->where('title_topics.title_id', $title_id);

        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_template_message_by_admin($template_id){
        $this->db->select('admin_library_topic.*, title_topics.topic');
        $this->db->from('admin_library_topic');
        $this->db->join('title_topics', 'title_topics.id = admin_library_topic.topic_id');
        $this->db->where('admin_library_topic.id', $template_id);
  
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_library_tmplate($id){
        $this->db->select('admin_library_topic.*,title_topics.topic');
        $this->db->from('admin_library_topic');
        $this->db->join('title_topics', 'admin_library_topic.topic_id = title_topics.id');
        $this->db->where('admin_library_topic.id', $id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_admin_library_topic($topic_id){
        $this->db->select('description');
        $this->db->from('admin_library_topic');
        $this->db->where('topic_id', $topic_id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_invoice_new($order_id,$session_from, $session_to,$presenter_id){
        $this->db->select('invoice_document');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('session_from <=', $session_from);
        $this->db->where('session_to >=', $session_to);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_order_schedule_with_range_not_submitted($order_id=null, $presenter_id=null,$firstDate, $endDate, $group_by='',$schedule_stat) {
        $order_id = (int) $order_id;
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate, titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $this->db->where('order_schedules.invoice_id', 0);
        $this->db->where('order_schedules.is_public_school', $schedule_stat); // 19-04-2023

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
        // echo $this->db->last_query(); die();
        $record = $query->result();
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.id DESC');
            $this->db->group_by('order_schedule_status_log.old_status');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
    }

    public function update_invoice_id_public_title($schedule_ids, $billing_id){
        $data['invoice_id'] = $billing_id;
        // print_r($data['invoice_id']); die;
        $this->db->where_in('id', $schedule_ids);
        $this->db->update('order_schedules', $data);
    }

    public function check_is_unique_invoice_id($schedules_id){
        $this->db->select('invoice_id');
        $this->db->from('order_schedules');
        $this->db->where_in('id', $schedules_id);
        // $this->db->where('invoice_id !=', 0);
        $this->db->group_by('invoice_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        } 
    }

    // public function get_scheduled_hours_by_inv_id($order_id, $presenter_id, $inv_id){
    //     $this->db->SELECT('SUM(total_hours) as schedule_hours');
    //     $this->db->from('order_schedules');
    //     $this->db->where('order_id', $order_id);
    //     $this->db->where('created_by', $presenter_id);
    //     $this->db->where('invoice_id', $inv_id);
    //     $query = $this->db->get();
    //     // echo $this->db->last_query(); die();
    //     return $query->row()->schedule_hours;
    // }

    public function get_scheduled_hours_by_inv_id($order_id, $presenter_id, $inv_id,$schedules_id,$is_checked){
        $this->db->SELECT('SUM(total_hours) as schedule_hours');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $this->db->where_in('id', $schedules_id);
        if($is_checked == '0'){
            $this->db->where('order_schedules.is_public_school', 'unchecked');
        }else if($is_checked == '1'){
            $this->db->where('order_schedules.is_public_school', 'checked');
        }else{
            // $curr_date = date("Y-m-d h:i:s");
            $this->db->where('order_schedules.is_public_school', 'checked');
            $this->db->where('order_schedules.end_date <', date('Y-m-d H:i:s'));
        }
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->row()->schedule_hours;
    }


    // public function get_scheduled_hours_confirm_by_inv_id($order_id, $presenter_id,$inv_id){
    //     $this->db->SELECT('SUM(total_hours) as schedule_hours');
    //     $this->db->from('order_schedules');
    //     $this->db->where('order_id', $order_id);
    //     $this->db->where('created_by', $presenter_id);
    //     $this->db->where('invoice_id', $inv_id);
    //     $this->db->where('status !=', 'Hours scheduled');
    //     $this->db->where('status !=', 'Draft attached');
    //     $this->db->where('status !=', 'Approved');
    //     $query = $this->db->get();
    //     return $query->row()->schedule_hours;
    // }

    public function get_scheduled_hours_confirm_by_inv_id($order_id, $presenter_id,$inv_id,$schedules_id,$is_checked){
        $this->db->SELECT('SUM(total_hours) as schedule_hours');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $this->db->where('status !=', 'Hours scheduled');
        $this->db->where('status !=', 'Draft attached');
        $this->db->where('status !=', 'Approved');
        $this->db->where_in('id', $schedules_id);
        if($is_checked == '0'){
            $this->db->where('order_schedules.is_public_school', 'unchecked');
        }else if($is_checked == '1'){
            $this->db->where('order_schedules.is_public_school', 'checked');
        }else{
            // $curr_date = date("Y-m-d h:i:s");
            $this->db->where('order_schedules.is_public_school', 'checked');
            $this->db->where('order_schedules.end_date <', date('Y-m-d H:i:s'));
        }

        $query = $this->db->get();
        return $query->row()->schedule_hours;
    }

    public function get_status_createInvoice_by_inv_id($order_id, $presenter_id, $inv_id){
        $this->db->SELECT('status');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $this->db->where('status', 'Create invoice');
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->num_rows();
    }

    public function no_of_rows_by_inv_id($order_id, $presenter_id, $inv_id){ 
        $this->db->SELECT('*');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->num_rows();
    }

    public function older_submitted_invoice_by_inv_id($order_id, $presenter_id, $inv_id){
        $this->db->SELECT('status');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $where = '(status = "Hours scheduled" or status = "Draft attached" or status = "Approved" or status = "Confirm hours" or status = "Create log" or status = "Log sent - awaiting principal signature" or status = "Awaiting Review" or status = "Create invoice")';
        $this->db->where($where);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        return $query->num_rows();
        // return $query->result();
    }

    public function get_invoice_new_by_inv_id($order_id,$inv_id,$presenter_id){
        $this->db->select('invoice_document');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('id', $inv_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_download_status_by_inv_id($order_id, $presenter_id, $inv_id){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('id', $inv_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); echo '</br>';
        // die();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    // public function get_order_schedule_by_inv_id($order_id=null, $presenter_id=null,$inv_id, $group_by='',$firstDate,$endDate) {
    //     $order_id = (int) $order_id;
        
    //     $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate, titles.public_school_title_status');
    //     $this->db->from('order_schedules');
    //     $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
    //     $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
    //     $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
    //     $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
    //     $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
    //     $this->db->join('titles', 'titles.id = orders.title_id', 'left');
    //     $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
    //     $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

    //     // $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
    //     // $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
    //     $this->db->where('order_schedules.invoice_id', $inv_id);
    //     $this->db->where('order_schedules.is_public_school', 'unchecked'); // 19-04-2023

    //     if ($order_id <> null) {
    //         $this->db->where('order_schedules.order_id', $order_id);
    //     }
    //     if ($presenter_id <> null) {
    //         $this->db->where('order_schedules.created_by', $presenter_id);
    //     }
    //     if($group_by != ''){
    //       $this->db->group_by($group_by);
    //     }
    //     $this->db->order_by('order_schedules.start_date ASC');
        
    //     $query = $this->db->get();
    //     // echo $this->db->last_query(); die();
    //     $record = $query->result();
    //     foreach ($record as $k => $v) {
    //         $this->db->select('order_schedule_status_log.*');
    //         $this->db->from('order_schedule_status_log');
    //         $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
    //         $this->db->order_by('order_schedule_status_log.id DESC');
    //         $this->db->limit(20);
    //         $q = $this->db->get();
    //         $res = $q->result();
    //         $record[$k]->order_log = $res;
    //     }
    //     return $record;
    // }

    public function get_order_schedule_by_inv_id($order_id=null, $presenter_id=null,$inv_id, $firstDate,$endDate,$schedules_id,$is_checked) {
        $order_id = (int) $order_id;
        // $curr_date = date("Y-m-d h:i:s");
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate, titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $this->db->where('order_schedules.invoice_id', $inv_id);
        // $this->db->where('order_schedules.is_public_school', 'unchecked'); // 19-04-2023
        $this->db->where_in('order_schedules.id', $schedules_id);
        if($is_checked == '0'){
            $this->db->where('order_schedules.is_public_school', 'unchecked');
        }else if($is_checked == '1'){
            $this->db->where('order_schedules.is_public_school', 'checked');
        }else{
            // $curr_date = date("Y-m-d h:i:s");
            $this->db->where('order_schedules.is_public_school', 'checked');
            $this->db->where('order_schedules.end_date <', date('Y-m-d H:i:s'));
        }

        // $this->db->where('start_date <', $curr_date);

        if ($order_id <> null) {
            $this->db->where('order_schedules.order_id', $order_id);
        }
        if ($presenter_id <> null) {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }
        
        $query = $this->db->get();
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        // die();
        $record = $query->result();
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.id DESC');
            $this->db->group_by('order_schedule_status_log.old_status');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
    }

    public function get_order_schedule_by_inv_id_past($order_id=null, $presenter_id=null,$inv_id, $group_by='',$firstDate,$endDate) {
        $order_id = (int) $order_id;
        $curr_date = date("Y-m-d h:i:s");
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate, titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $this->db->where('order_schedules.invoice_id', $inv_id);
        $this->db->where('order_schedules.is_public_school', 'checked');
        

        $this->db->where('end_date <', $curr_date);

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
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        // die();
        $record = $query->result();
        foreach ($record as $k => $v) {
            $this->db->select('order_schedule_status_log.*');
            $this->db->from('order_schedule_status_log');
            $this->db->where('order_schedule_status_log.order_schedule_id', $v->id);
            $this->db->order_by('order_schedule_status_log.id DESC');
            $this->db->limit(20);
            $q = $this->db->get();
            $res = $q->result();
            $record[$k]->order_log = $res;
        }
        return $record;
    }

    public function get_download_status_public($order_id, $presenter_id, $session_from, $session_to, $inv_id){
        $this->db->select('*');
        $this->db->from('billing');
        $this->db->where('order_id', $order_id);
        $this->db->where('presenter_id', $presenter_id);
        $this->db->where('session_from', $session_from);
        $this->db->where('session_to', $session_to);
        $this->db->where('id', $inv_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }
 
    }

    public function get_order_schedule_by_inv_id_by_time($order_id=null, $presenter_id=null,$inv_id, $group_by='',$firstDate,$endDate) {
        $order_id = (int) $order_id;
        $curr_date = date("Y-m-d h:i:s");
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate, titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $this->db->where('invoice_id', $inv_id);
        

        $this->db->where('end_date <', $curr_date);

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
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        // die();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }
     
    }

    // public function get_status_createInvoice_by_inv_id_range($order_id, $presenter_id, $inv_id,$firstDate,$endDate,$stat){
    //     $this->db->SELECT('status');
    //     $this->db->from('order_schedules');
    //     $this->db->where('order_id', $order_id);
    //     $this->db->where('created_by', $presenter_id);
    //     $this->db->where('invoice_id', $inv_id);
    //     $this->db->where('is_public_school', $stat); // 19-04-2023
    //     $this->db->where('status', 'Create invoice');
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
    //     $query = $this->db->get();
    //     // echo $this->db->last_query(); die();
    //     return $query->num_rows();
    // }

    public function get_status_createInvoice_by_inv_id_range($order_id, $presenter_id, $inv_id,$firstDate,$endDate,$stat,$schedules_id){
        $this->db->SELECT('status');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $this->db->where('status', 'Create invoice');
        $this->db->where('is_public_school', $stat); // 19-04-2023
        $this->db->where_in('id', $schedules_id); // 20-04-2023
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $query = $this->db->get();
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        // die();
        return $query->num_rows();
    }


    // public function no_of_rows_by_inv_id_range($order_id, $presenter_id, $inv_id,$firstDate,$endDate,$stat){ 
    //     $this->db->SELECT('*');
    //     $this->db->from('order_schedules');
    //     $this->db->where('order_id', $order_id);
    //     $this->db->where('created_by', $presenter_id);
    //     $this->db->where('invoice_id', $inv_id);
    //     $this->db->where('is_public_school', $stat); // 19-04-2023
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
    //     $query = $this->db->get();
    //     // echo $this->db->last_query(); die();
    //     return $query->num_rows();
    // }

    public function no_of_rows_by_inv_id_range($order_id, $presenter_id, $inv_id,$firstDate,$endDate,$stat,$schedules_id){ 
        $this->db->SELECT('*');
        $this->db->from('order_schedules');
        $this->db->where('order_id', $order_id);
        $this->db->where('created_by', $presenter_id);
        $this->db->where('invoice_id', $inv_id);
        $this->db->where('is_public_school', $stat); // 19-04-2023
        $this->db->where_in('id', $schedules_id); // 20-04-2023
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);
        $query = $this->db->get();
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        return $query->num_rows();
    }

    
    public function get_order_schedule_with_range_without_public($order_id=null, $presenter_id=null,$firstDate, $endDate, $group_by='',$inv_id) {
        $order_id = (int) $order_id;
        
        $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate,titles.public_school_title_status');
        $this->db->from('order_schedules');
        $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
        $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
        $this->db->join('titles', 'titles.id = orders.title_id', 'left');
        $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
        $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);

        $this->db->where('order_schedules.invoice_id', $inv_id);
        $this->db->where('order_schedules.is_public_school', 'unchecked');

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
        // echo $this->db->last_query(); die();
        if($query->num_rows() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    // public function get_order_schedule_with_range_with_public($order_id=null, $presenter_id=null,$firstDate, $endDate, $group_by='',$inv_id) {
    //     $order_id = (int) $order_id;
        
    //     $this->db->select('order_schedules.*, DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") AS start_date_ymd, grades.name AS grade_name, worktypes.name AS worktype_name, title_topics.topic AS topic_name,title_topics.description AS topic_description, order_schedule_status_log.attachment, order_schedule_status_log.content, order_schedule_status_log.id AS order_schedule_status_id,order_schedule_status_log.order_schedule_id, orders.school_id, user_meta.meta_value AS school_color, p_rate.meta_value as hourly_rate,titles.public_school_title_status');
    //     $this->db->from('order_schedules');
    //     $this->db->join('user_meta AS p_rate', 'order_schedules.created_by = p_rate.user_id AND p_rate.meta_key = \'rate\'', 'left');
    //     $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id', 'left');
    //     $this->db->join('grades', 'order_schedules.grade_id = grades.id', 'left');
    //     $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id', 'left');
    //     $this->db->join('orders', 'order_schedules.order_id = orders.id', 'left');
    //     $this->db->join('titles', 'titles.id = orders.title_id', 'left');
    //     $this->db->join('order_schedule_status_log', 'order_schedules.id = order_schedule_status_log.order_schedule_id AND order_schedule_status_log.new_status = order_schedules.status', 'left');
    //     $this->db->join('user_meta', "user_meta.user_id = orders.school_id AND user_meta.meta_key = 'school_color'", "left outer");

    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
    //     $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);

    //     $this->db->where('order_schedules.invoice_id', $inv_id);
    //     $this->db->where('order_schedules.is_public_school', 'checked');

    //     if ($order_id <> null) {
    //         $this->db->where('order_schedules.order_id', $order_id);
    //     }
    //     if ($presenter_id <> null) {
    //         $this->db->where('order_schedules.created_by', $presenter_id);
    //     }
    //     if($group_by != ''){
    //       $this->db->group_by($group_by);
    //     }
    //     $this->db->order_by('order_schedules.start_date ASC');
        
    //     $query = $this->db->get();
    //     // echo $this->db->last_query(); echo '</br>'; echo '</br>';
    //     if($query->num_rows() > 0 ){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    public function get_order_schedule_with_range_with_public($order_id=null, $presenter_id=null,$firstDate, $endDate,$inv_id,$schedules_id,$is_checked) {
        $order_id = (int) $order_id;
        
        $this->db->select('order_schedules.id');
        $this->db->from('order_schedules');

        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") >= ', $firstDate);
        $this->db->where('DATE_FORMAT(order_schedules.start_date, "%Y-%m-%d") <= ', $endDate);

        $this->db->where('order_schedules.invoice_id', $inv_id);
        if($is_checked == '0'){
            $this->db->where('order_schedules.is_public_school', 'unchecked');
        }else if($is_checked == '1'){
            $this->db->where('order_schedules.is_public_school', 'checked');
        }else{
            // $curr_date = date("Y-m-d h:i:s");
            $this->db->where('order_schedules.is_public_school', 'checked');
            $this->db->where('order_schedules.end_date <', date('Y-m-d H:i:s'));
        }

        
        $this->db->where_in('order_schedules.id', $schedules_id);

        if ($order_id <> null) {
            $this->db->where('order_schedules.order_id', $order_id);
        }
        if ($presenter_id <> null) {
            $this->db->where('order_schedules.created_by', $presenter_id);
        }
        
        $query = $this->db->get();
        // echo $this->db->last_query(); echo '</br>'; echo '</br>';
        if($query->num_rows() > 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    public function get_order_number_formail($order_id){
        $this->db->select('orders.order_no');
        $this->db->from('orders');
        $this->db->where('orders.id', $order_id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    public function get_order_schedule_formail($schedule_id){
        // echo $order_id;
        $this->db->select('order_schedules.*,grades.name AS grades_name, title_topics.topic AS topic_name, worktypes.name AS type_name');
        $this->db->from('order_schedules');
        $this->db->join('grades', 'order_schedules.grade_id = grades.id');
        $this->db->join('title_topics', 'order_schedules.topic_id = title_topics.id');
        $this->db->join('worktypes', 'order_schedules.type_id = worktypes.id');
        $this->db->where('order_schedules.id', $schedule_id);
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }
    public function is_teacher_exist($id, $title_id, $grade_id, $teacher_name){
        $this->db->select('*');
        $this->db->from('teachers');
        $this->db->where('school_id', $id);
        $this->db->where('title_id', $title_id);
        $this->db->where('grade_id', $grade_id);
        $this->db->where('name', $teacher_name);
        
        $query=$this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }

    function get_existing_title_for_school($school_id,$title_id){
        $this->db->select('*');
    	$this->db->from('school_titles');
    	$this->db->where('school_id', $school_id);
        $this->db->where('title_id', $title_id);
    	$query = $this->db->get();
		if($query->num_rows() > 0){
            $res = $query->row();
            return $res; 
        }else{
            return false;
        }
    }
    public function check_pdf_in_db($filename){
        $result = false;
        $this->db->select('id');
        $this->db->from('user_meta');
        $this->db->where('meta_value', $filename); 
        $query_meta = $this->db->get();
        if ($query_meta->num_rows() > 0) {
            $result = true;
        } 
        $this->db->select('id');
        $this->db->from('order_schedule_status_log');
        $this->db->where('attachment', $filename); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = true;
        } 
        $match_filename ="assets/teachers/".$filename;
        $this->db->select('id');
        $this->db->from('billing');
        $this->db->where('invoice_document', $match_filename); 
        $this->db->or_where('download_document', $match_filename); 
        $query_billing = $this->db->get();
        if ($query_billing->num_rows() > 0) {
            $result = true;
        } 
        return $result;
    }
    public function getpdf_merge() {
        $this->db->select('
            DISTINCT CONCAT(users.first_name, " ", users.last_name) AS presenter_name,
            order_schedule_status_log.attachment,
            order_schedule_status_log.pdf_merge_status,
            order_schedule_status_log.school_pdf,order_schedule_status_log.id,billing.id AS billing_id,billing.is_merged,billing.presenter_invoice AS invoice_id'
        );
        $this->db->from('users');
        $this->db->join('order_schedules', 'order_schedules.created_by = users.id');
        
        // $this->db->join('orders', 'orders.id = order_schedules.order_id');
        $this->db->join('order_billing_details', 'order_billing_details.order_schedule_id = order_schedules.id');
        $this->db->join('order_schedule_status_log', 'order_schedule_status_log.order_schedule_id = order_schedules.id');
        $this->db->join('billing', 'billing.id = order_billing_details.billing_id','left');
        
        // $this->db->where('order_schedule_status_log.pdf_merge_status', '0');
        $this->db->where_in('order_schedule_status_log.pdf_merge_status', array(0, 1));
        // $this->db->where('orders.is_deleted', '0');
        
        // $this->db->group_by('billing.presenter_invoice');
        
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        // echo $this->db->last_query()."<br>";
        
        return $query->result();
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
