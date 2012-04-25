<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {

        parent::__construct();

        $this->CI = & get_instance();

        $this->CI->load->language('carbo');
    }

    /**
     * Check unique
    **/
    function carbo_check_unique($value, $str)
    {
        $str = explode(':', $str);
        $table = $str[0];
        $id_name = $str[1];
        $field = $str[2];
        $item_id = isset($str[3]) ? $str[3] : NULL;

        if ($this->CI->Carbo_model->get_duplicate($table, $id_name, $field, $value, $item_id))
        {
            return TRUE;
        }
        else
        {
            $this->set_message('carbo_check_unique', lang('cg_check_unique'));
            return FALSE;
        }
    }

    /**
     * Check upload
    **/
    function carbo_check_upload($value, $str)
    {
        //return $this->CI->carboform->check_upload($value, $str);
        $str = explode(':', $str);
        $field = $str[0];
        $upload_path_temp = isset($str[1]) ? $str[1] : './files/temp';
        $allowed_types = isset($str[2]) ? preg_replace('/\&/', '|', $str[2]) : 'gif|jpg|png';
        $max_size = isset($str[3]) ? $str[3] : 1024;
        
        if (isset($_FILES[$field]) && $_FILES[$field]['name'])
        {
            $config['upload_path'] = $upload_path_temp;
            $config['allowed_types'] = $allowed_types;
            $config['max_size'] = $max_size;

            $this->CI->load->library('upload', $config);

            if (!$this->CI->upload->do_upload($field))
            {
                $this->CI->form_validation->set_message('carbo_check_upload', '%s: ' . $this->CI->upload->display_errors('', ''));
                return FALSE;
            }
            else
            {
                $data = $this->CI->upload->data();
                return $data['file_name'];
            }
        }
        return TRUE;
    }

    /**
     * Check date
    **/
    function carbo_check_date($date, $format)
    {
        $this->set_message('carbo_check_date', lang('cg_check_date'));

        if (!$format)
        {
            $format = 'm/d/Y';
        }

        $pformat = preg_replace('/([dDljmMFnYyGgHhAais])/', '%$1', $format);

        $ret = carbo_strptime($date, $pformat);

        if ($ret === FALSE OR !isset($ret['tm_mon']) OR !isset($ret['tm_mday']) OR !isset($ret['tm_year']))
        {
            return FALSE;
        }

        if (!checkdate($ret['tm_mon'], $ret['tm_mday'], $ret['tm_year']))
        {
            return FALSE;
        }

        return carbo_format_date($ret, $format, $format);
    }

    /*function carbo_check_daterange($value, $params)
    {
        $params = explode(':', $params);
        $params[2] = isset($params[2]) ? $params[2] : 'm/d/Y';

        $from = carbo_parse_date($this->CI->input->post($params[0]), $params[2]);
        $to = carbo_parse_date($this->CI->input->post($params[1]), $params[2]);

        if ($from === FALSE)
        {
            $this->set_message('carbo_check_daterange', 'Invalid start date.');
            return FALSE;
        }

        if ($to === FALSE)
        {
            $this->set_message('carbo_check_daterange', 'Invalid end date.');
            return FALSE;
        }

        if ($to < $from)
        {
            $this->set_message('carbo_check_daterange', 'End date is before start date.');
            return FALSE;
        }

        return TRUE;
    }*/

}

/* End of file MY_Form_validation.php */
/* Location: ./system/application/libraries/MY_Form_validation.php */
