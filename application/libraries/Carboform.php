<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Carboform
{
    public $id = 'carboform';

    public $item_id = NULL;

    public $columns = array();

    public $filters = array();

    public $formdata = array();

    public $month_names = array();
    public $month_names_short = array();
    public $day_names = array();
    public $day_names_short = array();
    public $day_names_min = array();

    public $is_ajax = FALSE;
    public $nested = FALSE;

    private $table = NULL;
    private $table_id_name = 'id';

    /**
     * Constructor
    **/
    function __construct($params = array())
    {
        $this->CI = & get_instance();

        $this->CI->load->language('carbo');

        $this->CI->load->helper('carbo');

        $this->CI->load->model('Carbo_model');

        // Do we have an ajax call?
        $this->is_ajax = ($this->CI->input->post('cg_ajax') === '1');

        // Set parameters
        foreach ($params as $key => $value)
        {
            $this->$key = $value;
        }

        // Set columns
        /*$this->columns = array();
        foreach ($this->columns as $key => $column)
        {
            //$this->columns[$key] = array_merge($this->column, (array) $column);
            // Convert columns to objects
            $this->columns[$key] = (object) $this->columns[$key];
        }*/
    }

    /**
     * Run
    **/
    function run($validate = FALSE)
    {
        $this->CI->load->library('form_validation');

        $item_data = NULL;
        if (!is_null($this->item_id))
        {
            $item_data = $this->CI->Carbo_model->get_item($this->table, $this->table_id_name, $this->columns, $this->item_id);
        }

        foreach ($this->columns as $key => $column)
        {
            // Set up validation rules
            $validation = 'trim|xss_clean' . ($column->validation ? ('|' . $column->validation) : '');

            // Set type specific validation
            switch ($column->type)
            {
                case 'integer':
                    $validation .= "|integer";
                    break;
                case 'date':
                    $validation .= "|carbo_check_date[{$column->date_format}]";
                    break;
                case 'datetime':
                    $validation .= "|carbo_check_date[{$column->date_format} {$column->time_format}]";
                    break;
                case 'time':
                    $validation .= "|carbo_check_date[{$column->time_format}]";
                    break;
            }

            if (!is_null($column->min_length))
            {
                $validation .= '|min_length[' . $column->min_length . ']';
            }
            if (!is_null($column->max_length))
            {
                $validation .= '|max_length[' . $column->max_length . ']';
            }
            if ($column->required)
            {
                $validation .= '|required';
            }
            if ($column->unique)
            {
                $validation .= '|carbo_check_unique[' . $this->table . ':' . $this->table_id_name . ':' . $column->where_name . (is_null($this->item_id) ? '' : (':' . $this->item_id)) . ']';
            }
            if ($column->form_control == 'file')
            {
                $path_temp = rtrim($column->upload_path_temp, '/') . '/';

                if (isset($_FILES['cg_field_' . $key]) && $_FILES['cg_field_' . $key]['name'])
                {
                    // Delete old file
                    if (file_exists($path_temp . $_POST['cg_field_' . $key]))
                    {
                        @unlink($path_temp . $_POST['cg_field_' . $key]);
                    }
                    $_POST['cg_field_' . $key] = $_FILES['cg_field_' . $key]['name'];
                }
                else if ($this->CI->input->post('cg_delete_file_' . $key) !== FALSE)
                {
                    // Delete old file
                    if (file_exists($path_temp . $_POST['cg_field_' . $key]))
                    {
                        @unlink($path_temp . $_POST['cg_field_' . $key]);
                    }
                    $_POST['cg_field_' . $key] = '';
                }
                $validation .= '|carbo_check_upload[cg_field_'. $key .
                    ':' . $column->upload_path_temp .
                    ':' . preg_replace('/\|/', '&', $column->allowed_types) .
                    ':' . $column->max_size . ']';
            }

            $this->CI->form_validation->set_rules('cg_field_' . $key, $column->name, $validation);
        }

        $this->CI->form_validation->set_error_delimiters('<li>', '</li>');

        if ($validate)
        {
            if ($this->CI->form_validation->run() !== FALSE)
            {
                $this->CI->Carbo_model->save_item($this->table, $this->table_id_name, $this->columns, $this->item_id, $item_data, $this->filters);
                return TRUE;
            }
        }
        // Set form values
        foreach ($this->columns as $key => $column)
        {
            if (($value = $this->CI->input->post('cg_field_' . $key)) !== FALSE)
            {
                if ($column->form_control == 'file' AND form_error('cg_field_' . $key))
                {
                    $this->formdata[$key] = '';
                }
                else
                {
                    $this->formdata[$key] = $value;
                }
            }
            else
            {
                $this->formdata[$key] = is_null($this->item_id) ? $column->form_default : $item_data->{$column->unique_name};
                // Set type specific value formating
                switch ($column->type)
                {
                    case 'date':
                        $this->formdata[$key] = is_null($this->item_id) ? $column->form_default : carbo_format_date($item_data->{$column->unique_name}, 'Y-m-d', $column->date_format);
                        break;
                    case 'datetime':
                        $this->formdata[$key] = is_null($this->item_id) ? $column->form_default : carbo_format_date($item_data->{$column->unique_name}, 'Y-m-d H:i:s', $column->date_format . ' ' . $column->time_format);
                        break;
                    case 'time':
                        $this->formdata[$key] = is_null($this->item_id) ? $column->form_default : carbo_format_date($item_data->{$column->unique_name}, 'H:i:s', $column->time_format);
                        break;
                    case '1-n':
                        $this->formdata[$key] = is_null($this->item_id) ? $column->form_default : $item_data->{$column->unique_name . '_id'};
                        break;
                }
            }
        }
        return FALSE;
    }

    /**
     * Render
    **/
    function render()
    {
        return $this->CI->load->view('carbo/carbo_form', array('form' => $this), TRUE);
    }

}

/* End of file Carboform.php */
/* Location: ./application/libraries/Carboform.php */
