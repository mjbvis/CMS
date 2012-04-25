<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Application {

	function __construct()
	{
		parent::__construct();
	}

    function get_progress($key)
	{
        if (function_exists('uploadprogress_get_info'))
        {
            echo json_encode(uploadprogress_get_info($key));
        }
	}
}

/* End of file ajax.php */
/* Location: ./system/application/controllers/ajax.php */
