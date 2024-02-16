<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_log {

    private $CI;

    public $type = '';
    public $subtype = '';
    public $title = '';
    public $description = '';
    public $created_by = 0;

    private $db_table = 'app_logs';

    const TYPE_DEBUG = 'debug';
    const TYPE_INFO = 'info';
    const TYPE_ERROR = 'error';

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        //parent::__construct();
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    /**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @param	array	config preferences
	 * @return	CI_App_log
	 */
	public function initialize($param = array())
	{
		foreach ($param as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
		return $this;
	}

    public function update($params = array()) {
        try {
            if (empty($params)) {
                throw new Exception("Empty params", 1);
            }

            $this->initialize($params);

            if ($this->CI->db->insert($this->db_table, $params)) {
                return $this->CI->db->insert_id();
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n"; die;
            return false;
        }
    }


}

/* End of file App_Log.php */
/* Location: ./application/libraries/App_Log.php */
