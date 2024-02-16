<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends Application_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	/**
	 *
	 * @var unknown_type
	 */
	private $tablename = 'users';
	private $url = '/app/calendar';
	private $permissionValues = array(
		'index' => 'App.Calendar.View',
    );
	private $role = 3; // Presenter Role ID
	private $role_token = 'teacher';
	//protected $data = array();
	
	public function __construct() {

        parent::__construct();

		// Validate Login
		parent::checkLoggedin();

		$this->session->set_userdata('page_data', array('url' => $this->url, 'permissions' => $this->permissionValues));
		$this->load->model('../../Admin/models/Admin_model');
        $this->load->model('App_model');
    }

	public function index() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		if(isset($_POST) && !empty($_POST)){
			$data['srch_type'] = $this->input->post('srch_type');
			$presenter = $this->input->post('presenter');
			$school = $this->input->post('school');
			$title = $this->input->post('title');
			$data['presenterids'] = (isset($presenter) && !empty($presenter)) ? $presenter : array();
			$data['schoolids'] = (isset($school) && !empty($school)) ? $school : array();
			$data['titleids'] = (isset($title) && !empty($title)) ? $title : array();

			$data['session'] = $this->input->post('hdnSession');
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($data['session']);
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($data['session']);
			$session_dates = $this->App_model->get_session_dates_by_id($data['session']);
			$sdate = explode(" ",$session_dates->start_date);
			$data['start_date'] = $sdate[0];
			$edate = explode(" ",$session_dates->end_date);
			$data['end_date'] = $edate[0];
			$schedules = $this->App_model->get_order_schedule_for_calendar($data['presenterids'], $data['schoolids'], $data['titleids'], $data['session']);
			// $schedules = $this->App_model->get_order_schedule_for_calendar($data['presenterids'], $data['schoolids'], $data['titleids']);
		}else{
			$data['srch_type'] = '';
			$data['presenterids'] = array();
			$data['schoolids'] = array();
			$data['titleids'] = array();

			$curr_date = date("Y-m-d h:i:s");
			$data['session'] = $this->App_model->get_curr_session_id($curr_date);
			$data['totHoursAssgnd'] = $this->App_model->get_total_hours_assigned($data['session']);
			$data['totHoursSchedule'] = $this->App_model->get_total_hours_schedule($data['session']);
			$session_dates = $this->App_model->get_session_dates_by_id($data['session']);
			$sdate = explode(" ",$session_dates->start_date);
			$data['start_date'] = $sdate[0];
			$edate = explode(" ",$session_dates->end_date);
			$data['end_date'] = $edate[0];
			// Get the existing schedule
			$schedules = $this->App_model->get_order_schedule_for_calendar($data['presenterids'], $data['schoolids'], $data['titleids'], $data['session']);
			// Get the existing schedule
			// $schedules = $this->App_model->get_order_schedule_for_calendar();
		}
		$data['s_array'] = $this->App_model->get_sessions();
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Calendar';
		

		$data['schedules'] = array();
		foreach ($schedules as $key => $value) {

			$data['schedules'][$key]['title'] = $value->presenter_name;
            $data['schedules'][$key]['start'] = $value->start_date;
            $data['schedules'][$key]['end'] = $value->end_date;
            // $data['schedules'][$key]['backgroundColor'] = "#00a65a";
			$data['schedules'][$key]['backgroundColor'] = $value->color;

			$str_date=date("m/d/Y", strtotime($value->start_date));
			$total_time = date("h:i a", strtotime($value->start_date))." - ".date("h:i a", strtotime($value->end_date)). " (".$value->total_hours." hrs)";

			$data['schedules'][$key]['oder_no'] = $value->order_no;
			$data['schedules'][$key]['school_name'] = $value->school_name;
			$data['schedules'][$key]['total_time'] = $total_time;
			$data['schedules'][$key]['start_date'] = $str_date;

		}
		
		// echo "<pre>";
		// print_r($schedules);die;
		$data['presenter'] = $this->App_model->get_presenters();
		$data['school'] = $this->App_model->get_schools();
		$data['title'] = $this->App_model->get_title_list();

		$data['main_content'] = 'fullcalendar';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


    /**
     *
     * @param unknown_type $uri
     * @param unknown_type $total_rows
     * @param unknown_type $segment
     */
    private function init_pagination($uri, $segment=4, $total_rows) {

    	$this->config->load('pagination');
    	$this->load->library('pagination');

    	$config = $this->config->item('pagination');

       	$ci                          =& get_instance();
       	$config['uri_segment']       = $segment;
       	$config['base_url']          = base_url().$uri;
       	$config['total_rows']        = $total_rows;

       	$ci->pagination->initialize($config);
       	return $config;
   	}

	public function fullcalendar() {

		// Permission Checking
		parent::checkMethodPermission($this->permissionValues[$this->router->method]);

		if(isset($_POST) && !empty($_POST)){
			$data['srch_type'] = $this->input->post('srch_type');
			$presenter = $this->input->post('presenter');
			$school = $this->input->post('school');
			$title = $this->input->post('title');
			$data['presenterids'] = (isset($presenter) && !empty($presenter)) ? $presenter : array();
			$data['schoolids'] = (isset($school) && !empty($school)) ? $school : array();
			$data['titleids'] = (isset($title) && !empty($title)) ? $title : array();
			$schedules = $this->App_model->get_order_schedule_for_calendar($data['presenterids'], $data['schoolids'], $data['titleids']);
		}else{
			// Get the existing schedule
			$schedules = $this->App_model->get_order_schedule_for_calendar();
		}
		
		$data['page'] = 'presenters';
    	$data['page_title'] = SITE_NAME.' :: Presenters Management &raquo; Calendar';
		

		$data['schedules'] = array();
		foreach ($schedules as $key => $value) {

			$data['schedules'][$key]['title'] = $value->presenter_name;
            $data['schedules'][$key]['start'] = $value->start_date;
            $data['schedules'][$key]['end'] = $value->end_date;
            // $data['schedules'][$key]['backgroundColor'] = "#00a65a";
			$data['schedules'][$key]['backgroundColor'] = $value->color;

			$str_date=date("m/d/Y", strtotime($value->start_date));
			$total_time = date("h:i a", strtotime($value->start_date))." - ".date("h:i a", strtotime($value->end_date)). " (".$value->total_hours." hrs)";

			$data['schedules'][$key]['oder_no'] = $value->order_no;
			$data['schedules'][$key]['school_name'] = $value->school_name;
			$data['schedules'][$key]['total_time'] = $total_time;
			$data['schedules'][$key]['start_date'] = $str_date;
		}
		
		$data['presenter'] = $this->App_model->get_presenters();
		$data['school'] = $this->App_model->get_schools();
		$data['title'] = $this->App_model->get_title_list();

		$data['main_content'] = 'calendar/fullcalendar';
    	$this->load->view(TEMPLATE_PATH, $data);		
	}
	
	function randomColor(){
	    $result = array('rgb' => '', 'hex' => '');
	    foreach(array('r', 'b', 'g') as $col){
	        $rand = mt_rand(0, 255);
	        $result['rgb'][$col] = $rand;
	        $dechex = dechex($rand);
	        if(strlen($dechex) < 2){
	            $dechex = '0' . $dechex;
	        }
	        $result['hex'] .= $dechex;
	    }
	    echo "<pre>";print_r($result);
	}
	

}
