<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Application_Controller {

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
	private $tablename = '';

	private $permissionValues = array(
		'index' => 'Report.Reprots.View',
    );


	public function __construct() {

        parent::__construct();

        // Validate Login
		parent::checkLoggedin();

        $this->load->model('Report_model');
    }

	public function index() {

		// Permission Checking
		//parent::checkMethodPermission($this->permissionValues[$this->router->method]);
		$page_segment = 0;
		$filter = array();

        $default_uri = array('page', 'type', 'title', 'action');
		$uri = $this->uri->uri_to_assoc(4, $default_uri);

		if ($uri['page'] > 0) {
    		$page = $uri['page'];
    		$page_segment = array_search('page', array_keys($uri));
    	} else {
    		$page = 1;
    	}
    	//print_r($uri);

        if ($uri['title'] <> "") {
            $filter['title'] = $uri['title'];
        }

    	if ($uri['type'] <> "") {
    		$filter['type'] = $uri['type'];
    	}

    	//print_r($filter);
	    // Get the total rows without limit
	    $data['total_rows'] = $this->Report_model->get_log_list($filter, 'created_on', 'desc', true);

	    $config = $this->init_pagination('report/reports/index/'.$this->uri->assoc_to_uri($filter).'/page/', (5+($page_segment*2)), $data['total_rows']);

		$limit_end = ($page * $config['per_page']) - $config['per_page'];
	    if ($limit_end < 0){
	        $limit_end = 0;
	    }

	    $filter['limit'] = $config['per_page'];
	    $filter['offset'] = $limit_end;

	    // Overwite it for print
	    if ($uri['action'] == "print" || $uri['action'] == "csv") {
	    	$filter['limit'] = -1;
	    }



	    // Get the Reports
	    $data['rows'] = $this->Report_model->get_log_list($filter, 'created_on', 'desc');
    	//print "<pre>"; print_r($data['rows']);print "</pre>";

        //print "<pre>"; print_r($data['rows']);print "</pre>";
	    $data['page_no'] = $page;
	    $data['filter'] = $filter;
	    $data['page'] = 'reports';
    	$data['page_title'] = SITE_NAME.' :: Reports';

        if ($uri['action'] == "csv") {
            $this->load->helper('download');

            $delimiter = ',';

            if (count($data['rows']) > 0) {

                $name = 'report_export_'.time().'.csv';

                // prepare the file
                $fp = fopen(DIR_PROFILE_PICTURE.$name, 'w+');

                // Save header
                $header = array_keys((array)$data['rows'][0]);
                fputcsv($fp, $header, $delimiter);

                // Save data
                foreach ($data['rows'] as $element) {
                    fputcsv($fp, (array)$element, $delimiter);
                }
                fclose($fp);

                $data = file_get_contents(DIR_PROFILE_PICTURE.$name); // Read the file's contents

                force_download($name, $data);
                exit;
            }
        }

    	$data['main_content'] = 'reports/list';
    	$this->load->view(TEMPLATE_PATH, $data);
	}


 	public function search_submit() {

    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$type = $this->clean_value($this->input->post('type'));
    		$title = $this->clean_value($this->input->post('title'));

			$url = "report/reports/index/";

            if ($title != '') {
                $url .= "title/". urlencode($title)."/";
            }

			if ($type != '') {
				$url .= "type/". urlencode($type)."/";
			}

			redirect($url);
    	}
    }


    /**
     * Clean up by removing unwanted characters
     *
     * @param unknown_type $str
     */
    private function clean_value($str) {
		return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
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
}
