<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class Carbo_model extends CI_Model
{
    // Types
    private $types = array(
        1   => 'integer',
        2   => 'string',
        3   => 'boolean',
        4   => '1-n',
        5   => 'text',
        6   => 'multilang',
        7   => 'n-m',
        8   => 'date',
        9   => 'datetime',
        10  => 'file'
    );

    /**
     * Constructor
    **/
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get table dropdown
    **/
    function get_table_dropdown($table, $id_name, $field_main, $type, $filters = array())
    {
        $data = array("" => lang("cg_select"));

        $this->db->from("{$table} {$table}_main");
        $this->db->select("{$table}_main.{$id_name} AS id");
        $this->db->select("{$table}_main.{$field_main} AS field");

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data[$row->id] = $row->field;
            }
        }
        return $data;
    }

    /**
     * Get items
    **/
    function get_items($table, $id_name, $fields = NULL, $item_id = NULL, $filters = array(), $limit = NULL, $offset = 0, $order = NULL, $ref_ids = FALSE)
    {
        $data = array();

        if (count($fields))
        {
            //$this->db->from("{$table} {$table}_main");
            //$this->db->select("{$table}_main.{$id_name} AS id");
            $this->db->from("{$table}");
            $this->db->select("{$table}.{$id_name}");
            $join = 0;
            $multilang = FALSE;
            foreach ($fields as $field)
            {
                switch ($field->type)
                {
                    // Reference
                    case '1-n':
                        $id1 = $table . "." . $field->db_name;
                        //$id2 = $field->ref_table_db_name . "_join" . $join . ".{$field->ref_table_id_name}";
                        //$this->db->join("{$field->ref_table_db_name} {$field->ref_table_db_name}_join{$join}", $id1 . " = " . $id2, "left");
                        $id2 = $field->ref_table_db_name . "." . $field->ref_table_id_name;
                        $this->db->join("{$field->ref_table_db_name}", $id1 . " = " . $id2, "left");

                        //$this->db->select("{$field->ref_table_db_name}_join{$join}.{$field->ref_field_db_name} AS `{$field->unique_name}`");
                        $this->db->select("{$field->ref_table_db_name}.{$field->ref_field_db_name} AS `{$field->unique_name}`");

                        $field->table_name = $field->ref_table_db_name;// . "_join" . $join;
                        $field->order_name = $field->ref_field_db_name;

                        $join++;
                        // Select foreign keys as well
                        if ($ref_ids)
                        {
                            //$this->db->select("{$table}_main.{$field->db_name} AS `{$field->db_name}`");
                            $this->db->select("{$table}.{$field->db_name} AS `{$field->unique_name}_id`");
                        }
                        break;

                    default:
                        $field->table_name = $table;// . "_main";
                        $field->order_name = $field->db_name;
                        //$this->db->select("{$table}_main.{$field->db_name} AS `{$field->unique_name}`");
                        $this->db->select("{$table}.{$field->db_name} AS `{$field->unique_name}`");
                }
            }
            // Set filters
            $this->set_filters($filters);
            /*foreach ($filters as $field_id => $value)
            {
                if (isset($fields[$field_id]))
                {
                    $field_data = $fields[$field_id];
                    switch ($field_data->type)
                    {
                        case 'integer':
                            $this->db->where($field_data->table_name . "." . $field_data->db_name, $value);
                            break;
                        case '1-n':
                            $this->db->where("{$table}_main." . $field_data->db_name, $value);
                            break;
                        default:
                            $this->db->like($field_data->table_name . "." . $field_data->db_name, $value);
                    }
                }
            }*/
            if (!is_null($item_id))
            {
                //$this->db->where("{$table}_main.{$id_name}", $item_id);
                $this->db->where("{$table}.{$id_name}", $item_id);
            }
            if (!is_null($order))
            {
                foreach ($order as $field_id => $dir)
                {
                    $this->db->order_by($fields[$field_id]->table_name . "." . $fields[$field_id]->order_name, $dir);
                }
            }
            if (!is_null($limit))
            {
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get();
            /*if ($query->num_rows() > 0)
            {
                foreach ($query->result() as $row)
                {
                    //$id = $row->id;
                    //unset($row->id);
                    $id = $row->{$id_name};
                    foreach ($fields as $field)
                    {
                        switch ($field->type)
                        {
                            // Format date
                            case 'date':
                                if (!is_null($row->{$field->unique_name}))
                                {
                                    //$row->{$field->db_name} = carbo_parse_date($row->{$field->db_name});
                                    $row->{$field->unique_name} = carbo_parse_date($row->{$field->unique_name});
                                }
                                break;
                        }
                    }
                    $data[$id] = $row;
                }
            }*/
            return $query->result();
        }
        return $data;
    }

    /**
     * Get item
    **/
    function get_item($table, $id_name, $fields, $item_id)
    {
        $data = $this->get_items($table, $id_name, $fields, $item_id, array(), NULL, 0, NULL, TRUE);

        return reset($data);
    }

    /**
     * Get duplicate
    **/
    function get_duplicate($table, $id_name, $field, $value, $item_id = NULL)
    {
        if (!is_null($item_id))
        {
            $this->db->where("{$id_name} !=", $item_id);
        }

        $this->db->where($field, $value);

        $query = $this->db->get($table);

        if ($query->num_rows() > 0)
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Count items
    **/
    function count_items($table, $id_name, $fields, $filters = array())
    {
        if (count($fields))
        {
            //$this->db->from($table . " " . $table . "_main");
            $this->db->select("COUNT(*) AS count");
            $this->db->from("{$table}");
            $this->db->select("{$table}.{$id_name}");
            $join = 0;
            foreach ($fields as $field)
            {
                switch ($field->type)
                {
                    // Reference
                    case '1-n':
                        //$id1 = $table . "_main.{$id_name}";
                        //$id2 = $field->ref_table_db_name . "_join" . $join . ".{$field->ref_table_id_name}";
                        //$this->db->join("{$field->ref_table_db_name} {$field->ref_table_db_name}_join{$join}", $id1 . " = " . $id2, "left");
                        //$join++;

                        //$field->table_name = $field->ref_table_db_name . "_join" . $join;
                        //$field->order_name = $field->ref_field_db_name;
                        $id1 = $table . ".{$id_name}";
                        $id2 = $field->ref_table_db_name . "." . $field->ref_table_id_name;
                        $this->db->join("{$field->ref_table_db_name}", $id1 . " = " . $id2, "left");

                        break;

                    default:
                        //$field->table_name = $table . "_main";
                        //$field->order_name = $field->db_name;
                }
            }
            // Set filters
            $this->set_filters($filters);
            /*foreach ($filters as $field_id => $value)
            {
                if (isset($fields[$field_id]))
                {
                    $field_data = $fields[$field_id];
                    switch ($field_data->type)
                    {
                        case 'integer':
                            $this->db->where($field_data->table_name . "." . $field_data->db_name, $value);
                            break;
                        case '1-n':
                            $this->db->where("{$table}_main." . $field_data->db_name, $value);
                            break;
                        default:
                            $this->db->like($field_data->table_name . "." . $field_data->db_name, $value);
                    }
                }
            }*/

            $query = $this->db->get();
            return $query->row()->count;
        }
        return 0;
    }

    /**
     * Save item
    **/
    function save_item($table, $id_name, $fields, $item_id = NULL, $item_data = NULL, $filters = array())
    {
        if (count($fields))
        {
            //$table_data = array("timestamp" => date("Y-m-d H:i:s"));
            $table_data = array();
            foreach ($fields as $key => $field)
            {
                $value = $this->input->post("cg_field_" . $key);
                $value = ($value === FALSE) ? $field->form_default : $value;
                //$value = $values[$key];
                switch ($field->type)
                {
                    // Boolean
                    case 'boolean':
                        $table_data[$field->db_name] = $value ? 1 : 0;
                        break;

                    // Date
                    case 'date':
                        // Convert to MySQL date
                        $table_data[$field->db_name] = $value ? carbo_format_date($value, $field->date_format, 'Y-m-d') : NULL;
                        break;

                    case 'datetime':
                        // Convert to MySQL datetime
                        $table_data[$field->db_name] = $value ? carbo_format_date($value, $field->date_format . ' ' . $field->time_format, 'Y-m-d H:i:s') : NULL;
                        break;

                    // Date
                    case 'time':
                        // Convert to MySQL time
                        $table_data[$field->db_name] = $value ? carbo_format_date($value, $field->time_format, 'H:i:s') : NULL;
                        break;

                    // File
                    case 'file':

                        $path = rtrim($field->upload_path, '/') . '/';
                        $path_temp = rtrim($field->upload_path_temp, '/') . '/';

                        // Delete old file
                        if (!is_null($item_data) AND ($item_data->{$field->db_name} !== $value) AND file_exists($path . $item_data->{$field->db_name}))
                        {
                            @unlink($path . $item_data->{$field->db_name});
                        }
                        // Copy new file to permanent location
                        if (file_exists($path_temp . $value))
                        {
                            @rename($path_temp . $value, $path . $value);
                        }

                    default:
                        if ($value !== FALSE)
                        {
                            $table_data[$field->db_name] = ($value === "") ? NULL : $value;
                        }
                }
            }

            if (is_null($item_id))
            {
                // Insert the item
                $this->db->insert($table, $table_data);
                $insert_id = $this->db->insert_id();
            }
            else
            {
                // Update the item
                $this->db->where($id_name, $item_id);
                $this->set_filters($filters);
                $this->db->update($table, $table_data);
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Delete items
    **/
    function delete_items($table, $id_name, $item_ids = array(), $filters = array())
    {
        // @todo - Cascade
        // Delete the rows
        $this->db->where_in($id_name, $item_ids);
        $this->set_filters($filters);
        $this->db->delete($table);
    }

    /**
     * Set filters
    **/
    function set_filters($filters = array())
    {
        foreach ($filters as $filter)
        {
            if (!isset($filter['operator']))
            {
                $filter['operator'] = 'eq';
            }
            switch ($filter['operator'])
            {
                case 'noteq':
                    $this->db->where($filter['field'] . ' !=', $filter['value']);
                    break;
                case 'lt':
                    $this->db->where($filter['field'] . ' <', $filter['value']);
                    break;
                case 'lte':
                    $this->db->where($filter['field'] . ' <=', $filter['value']);
                    break;
                case 'gt':
                    $this->db->where($filter['field'] . ' >', $filter['value']);
                    break;
                case 'gte':
                    $this->db->where($filter['field'] . ' >=', $filter['value']);
                    break;
                case 'in':
                    $this->db->where_in($filter['field'], $filter['value']);
                    break;
                case 'notin':
                    $this->db->where_not_in($filter['field'], $filter['value']);
                    break;
                case 'like':
                    $this->db->like($filter['field'], $filter['value']);
                    break;
                case 'notlike':
                    $this->db->not_like($filter['field'], $filter['value']);
                    break;
                case 'starts':
                    $this->db->where($filter['field'] . ' LIKE \'' . $this->db->escape_like_str($filter['value']) . '%\'');
                    break;
                case 'ends':
                    $this->db->where($filter['field'] . ' LIKE \'%' . $this->db->escape_like_str($filter['value']) . '\'');
                    break;

                default:
                    $this->db->where($filter['field'], $filter['value']);
            }
        }
    }


}

/* End of file carbo_model.php */
/* Location: ./application/models/carbo_model.php */
