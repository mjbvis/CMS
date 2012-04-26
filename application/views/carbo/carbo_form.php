<div id="carboform_<?php echo $form->id; ?>" class="cg-form ui-widget ui-helper-reset ui-accordion-icons">

<?php if (!$form->nested) echo form_open_multipart($this->uri->uri_string()); ?>

<?php if (validation_errors()) { ?>
<div class="cg-error ui-state-error ui-corner-all">
    <ul>
<?php echo validation_errors(); ?>
    </ul>
</div>
<?php } ?>

<script type="text/javascript">
    if (cfSettings == undefined) var cfSettings = {};
    cfSettings['<?php echo $form->id; ?>'] = {
        baseUrl: '<?php echo base_url() . ($this->config->item('index_page') ? ($this->config->item('index_page') . '/') : ''); ?>',
        monthNames: ["<?php echo implode('","', $form->month_names); ?>"],
        monthNamesShort: ["<?php echo implode('","', $form->month_names_short); ?>"],
        dayNames: ["<?php echo implode('","', $form->day_names); ?>"],
        dayNamesShort: ["<?php echo implode('","', $form->day_names_short); ?>"],
        dayNamesMin: ["<?php echo implode('","', $form->day_names_min); ?>"],
        timeOnlyTitle: '<?php echo lang('cg_time_only_title'); ?>',
        timeText: '<?php echo lang('cg_time'); ?>',
        hourText: '<?php echo lang('cg_hour'); ?>',
        minuteText: '<?php echo lang('cg_minute'); ?>',
        secondText: '<?php echo lang('cg_second'); ?>',
        currentText: '<?php echo lang('cg_now'); ?>',
        closeText: '<?php echo lang('cg_done'); ?>'
    };
</script>

<?php
    $last_group_id = NULL;
    foreach ($form->columns as $key => $column) {
        if (!$column->form_visible) continue;
        if ($last_group_id !== $column->group)
        {
            echo is_null($last_group_id) ? '' : '</div></div>';
            echo '<div class="cg-group">' . "\n";
            echo '<h3 class="cg-group-header ui-helper-reset ui-state-default ui-corner-all"><span class="cg-left ui-icon ui-icon-triangle-1-s"></span><span class="cg-left">&nbsp;' . $column->group . '</span><span class="cg-clear"></span></h3>' . "\n";
            echo '<div class="cg-group-content">' . "\n";
            $last_group_id = $column->group;
        }
        // Display column filters
        $i = 0;
        $dd_filter = array();
        $label = form_label($column->name . ($column->required ? '<span class="cg-req">*</span>' : ''), 'cg_field_' . $key) . "\n";
        /*foreach ($column->filters as $filter)
        {
            // Check if dropdown filter is already on the form
            if ($filter->filter_table_alias == $form->table)
            {
                $value = set_value("cg_field_" . $filter->filter_field_name, $form->formdata[$filter->filter_field_name]);
                $dd_filter = array($filter->filter_field_id => $value);
                echo "
                    <script type=\"text/javascript\">
                        $(document).ready(function() {
                            $('#cg_field_{$filter->filter_field_name}').addClass('cg-filter')
                                .data('nr', '{$i}')
                                .data('name', '{$column->db_name}')
                                .data('filter', '{$filter->filter_field_id}');
                        });
                    </script>
                ";
            }
            // Create the dropdown filter
            else
            {
                $value = set_value("{$column->db_name}_filter{$i}", $form->formdata["{$column->db_name}_filter{$i}"]);
                $dd_data = $this->Carbo_model->get_table_dropdown($filter->filter_table_db_name, $filter->filter_field_name, $filter->filter_field_type, $this->carbomodel->language_id, $dd_filter);
                echo form_label($filter->filter_table_name, "cg_field_{$column->db_name}_filter{$i}") . "\n";
                echo form_dropdown("cg_field_{$column->db_name}_filter{$i}", $dd_data, $value, "id=\"cg_field_{$column->db_name}_filter{$i}\" class=\"cg-long ui-input cg-filter\"") . "\n";
                echo "
                    <script type=\"text/javascript\">
                        $(document).ready(function() {
                            $('#cg_field_{$column->db_name}_filter{$i}')
                                .data('nr', '{$i}')
                                .data('name', '{$column->db_name}')
                                .data('filter', '{$filter->filter_ref_field_id}')
                                .data('table', '{$filter->filter_table_db_name}')
                                .data('field', '{$filter->filter_field_name}')
                                .data('type', '{$filter->filter_field_type}');
                        });
                    </script>
                ";
                echo '<div class="cg-clear"></div>' . "\n";
                $dd_filter = array($filter->filter_ref_field_id => (array_key_exists($value, $dd_data) ? $value : ''));
            }
            $i++;
        }*/
        echo '<div class="cg-field-cont cg-' . $column->form_control . '-field-cont">' . "\n";
        switch ($column->form_control)
        {
            // Short text input
            case 'text_short':
                echo $label;
                echo form_input('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-short ui-widget-content"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Long text input
            case 'text_long':
                echo $label;
                echo form_input('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-long ui-widget-content"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Checkbox
            case 'checkbox':
                echo '<input class="cg-checkbox" type="checkbox" id="cg_field_' . $key . '" name="cg_field_' . $key . '" value="1"' . ($form->formdata[$key] ? ' checked="checked"' : '')  . ' />' . "\n";
                echo $label;
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Dropdown
            case 'dropdown':
                echo $label;
                echo form_dropdown('cg_field_' . $key, $this->Carbo_model->get_table_dropdown($column->ref_table_db_name, $column->ref_table_id_name, $column->ref_field_db_name, $column->ref_field_type, $dd_filter), $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-long ui-widget-content"') . "\n";
                /*if (count($column->filters)) {
                    echo "
                        <script type=\"text/javascript\">
                            $(document).ready(function() {
                                $('#cg_field_{$column->db_name}')
                                    .data('table', '{$column->ref_table_db_name}')
                                    .data('field', '{$column->ref_field_db_name}')
                                    .data('type', '{$column->ref_field_type}');
                            });
                        </script>";
                    echo '<noscript>' . form_submit('refresh', 'Refresh', 'class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"') . '</noscript>' . "\n";
                }*/
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Text
            case 'textarea':
                echo $label;
                echo form_textarea('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="ui-widget-content"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Date
            case 'datepicker':
                echo $label;
                echo form_input('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-long cg-datepicker ui-widget-content" data-cg-date-format="' .  $column->date_format . '"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Datetime
            case 'datetimepicker':
                echo $label;
                echo form_input('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-long cg-datetimepicker ui-widget-content" data-cg-date-format="' .  $column->date_format . '" data-cg-time-format="' . $column->time_format . '"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // Time
            case 'timepicker':
                echo $label;
                echo form_input('cg_field_' . $key, $form->formdata[$key], 'id="cg_field_' . $key . '" class="cg-long cg-timepicker ui-widget-content" data-cg-time-format="' . $column->time_format . '"') . "\n";
                echo '<div class="cg-clear"></div>' . "\n";
            break;

            // File upload
            case 'file':
                echo $label;
                echo '<input type="file" name="cg_field_' . $key . '" id="cg_field_' . $key . '" />' . "\n";
                echo '<input type="hidden" value="' . $form->formdata[$key] . '" name="cg_field_' . $key . '" />';
                echo '<div class="cg-clear"></div>' . "\n";
                if ($form->formdata[$key])
                {
                    echo '<table cellpadding="0" cellspacing="0" class="cg-files"><tr>';
                    echo '<td class="ui-widget-content">' . $form->formdata[$key] . '</td>';
                    echo '<td class="ui-widget-content"><input type="submit" value="1" name="cg_delete_file_' . $key . '" class="ui-icon ui-icon-trash cg-icon-button" /></td>';
                    echo '</tr></table>' . "\n";
                }
            break;
        }
        echo '</div>' . "\n";
    }
    echo is_null($last_group_id) ? '' : '</div></div>';
?>

<?php if (!$form->nested): ?>

    <?php if (!$form->is_ajax): ?>
    <?php echo form_label('&nbsp;', 'submit'); ?>
    <?php echo form_submit('cg_form_submit', lang('cg_save'), 'class="cg-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"'); ?>
    <?php echo form_submit('cg_form_cancel', lang('cg_cancel'), 'class="cg-button cg-form-cancel ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"'); ?>
    <div class="cg-clear"></div>
    <?php endif ?>

    <?php echo form_close(); ?>

<?php endif ?>

</div>
