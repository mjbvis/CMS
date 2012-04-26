<?php if (!$grid->is_ajax): ?>
<div id="carbogrid_<?php echo $grid->id; ?>" class="carbogrid">
    <?php if ($grid->ajax): // Create client side object ?>
    <script type="text/javascript">
    <?php
        echo '' .
        "" .
            "if (cgSettings == undefined) var cgSettings = {}; cgSettings['" . $grid->id . "'] = {" .
                "baseUrl: '" . base_url() . ($this->config->item('index_page') ? ($this->config->item('index_page') . '/') : '') . "'," .
                "gridUrl: '" . $grid->url . "'," .
                "paramsBefore: '" . $grid->params_before . "'," .
                "paramsAfter: '" . $grid->params_after . "'," .
                "pageSize: '" . $grid->page_size . "'," .
                "page: '" . $grid->page . "'," .
                "limit: " . (is_null($grid->limit) ? 'null' : $grid->limit) . "," .
                "offset: " . $grid->offset . "," .
                "columnString: '" . $grid->column_string . "'," .
                "orderString: '" . $grid->order_string . "'," .
                "filterString: '"  . $grid->filter_string . "'," .
                "allowFilter: " . ($grid->allow_filter ? 'true' : 'false') . "," .
                "allowSelect: " . ($grid->allow_select ? 'true' : 'false') . "," .
                "allowColumns: " . ($grid->allow_columns ? 'true' : 'false') . "," .
                "ajaxHistory: " . ($grid->ajax_history ? 'true' : 'false') . "," .
                "monthNames: [\"" . implode('","', $grid->month_names) . "\"]," .
                "monthNamesShort: [\"" . implode('","', $grid->month_names_short) . "\"]," .
                "dayNames: [\"" . implode('","', $grid->day_names) . "\"]," .
                "dayNamesShort: [\"" . implode('","', $grid->day_names_short) . "\"]," .
                "dayNamesMin: [\"" . implode('","', $grid->day_names_min) . "\"]," .
                "timeOnlyTitle: '" . lang('cg_time_only_title') . "'," .
                "timeText: '" . lang('cg_time') . "'," .
                "hourText: '" . lang('cg_hour') . "'," .
                "minuteText: '" . lang('cg_minute') . "'," .
                "secondText: '" . lang('cg_second') . "'," .
                "currentText: '" . lang('cg_now') . "'," .
                "closeText: '" . lang('cg_done') . "'," .
                "commands: {";
        $commands_str = "";
        foreach ($grid->commands as $command) {
            $commands_str .= "'" . $command['name'] . "': {";
            $command_str = "";
            foreach ($command as $key => $value) {
                $command_str .= "'" . $key . "': '" . $value . "',";
            }
            $commands_str .= rtrim($command_str, ',') . "},";
        }
        echo rtrim($commands_str, ',');
        echo "}};";
        //echo "cgInstances['" . $grid->id . "'] = new Carbogrid('carbogrid_" . $grid->id . "', settings);";
        //echo "});\n";
    ?>
    </script>
    <?php endif ?>

    <?php if (!$grid->nested) echo form_open_multipart($this->uri->uri_string(), 'class="cg-grid-form"'); ?>

    <?php $this->load->view('carbo/carbo_dialog', array('dialog' => $grid->dialog)); ?>

    <?php if ($grid->allow_filter): ?>
    <div style="width:0;height:0;overflow:hidden;">
        <input type="submit" name="<?php echo "cg_{$grid->id}_apply_filter"; ?>" value="<?php echo lang('cg_filter'); ?>" class="cg-apply-filter" />
    </div>
    <?php endif ?>

    <div class="cg-rel">
        <!--[if lt IE 7]>
        <iframe class="cg-grid-overlay ui-widget-overlay" border="0" frameborder="0" scrolling="no"></iframe>
        <![endif]-->
        <div class="cg-grid-overlay ui-widget-overlay"><div class="cg-grid-loading ui-corner-all"></div></div>

    <?php if (count($grid->commands) OR $grid->allow_columns): ?>
    <div class="cg-toolbar">

        <div class="cg-left">
        <?php foreach ($grid->commands as $command) if ($command['toolbar']) { ?>
            <input type="submit" name="<?php echo "cg_{$grid->id}_command_{$command['name']}"; ?>" value="<?php echo $command['text']; ?>" class="cg-<?php echo $command['name']; ?> cg-icon-<?php echo $command['icon']; ?> cg-type-<?php echo $command['type']; ?> cg-button cg-command ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon ui-button-text-icon-primary" />
        <?php } ?>
        <?php if ($grid->allow_filter): ?>
            <input type="submit" name="<?php echo "cg_{$grid->id}_apply_filter"; ?>" value="<?php echo lang('cg_filter'); ?>" class="cg-apply-filter cg-button cg-icon-circle-triangle-s ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon ui-button-text-icon-primary" />
        <?php endif ?>
        </div>

        <?php if ($grid->allow_columns): ?>
        <div class="cg-right">
            <input type="submit" name="<?php echo "cg_{$grid->id}_columns"; ?>" value="<?php echo lang('cg_columns'); ?>" class="cg-columns cg-button cg-icon-circle-triangle-s ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon ui-button-text-icon-primary" />
            <div class="cg-columns-list<?php echo $grid->show_col_list ? '' : ' cg-hidden' ?> ui-shadow ui-widget ui-widget-content ui-corner-all">
                <table cellpadding="0" cellspacing="0" border="0">
                <?php foreach ($grid->columns as $key => $column): if ($column->visible) : ?>
                    <tr>
                        <td><input class="cg-checkbox cg-col-visible" type="checkbox"<?php echo in_array($key, $grid->columns_visible) ? ' checked="checked"' : ''; ?> value="<?php echo $key; ?>" name="<?php echo "cg_{$grid->id}_columns_visible[]"; ?>" id="cg_<?php echo $grid->id; ?>_columns_visible_<?php echo $key; ?>" /></td>
                        <td><label for="cg_<?php echo $grid->id; ?>_columns_visible_<?php echo $key; ?>"><?php echo $column->header; ?></label></td>
                    </tr>
                <?php endif; endforeach ?>
                </table>
                <?php if ($grid->ajax) { ?><noscript><?php } ?>
                    <input type="submit" name="<?php echo "cg_{$grid->id}_columns_list"; ?>" value="<?php echo lang('cg_go'); ?>" class="cg-button cg-button-text-only ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" />
                <?php if ($grid->ajax) { ?></noscript><?php } ?>
            </div>
        </div>
        <?php endif ?>
        <div class="cg-clear"></div>
    </div>
    <?php endif ?>

    <div class="cg-table">
<?php endif ?>

 <?php if ($grid->render_table): ?>
        <?php if ($grid->ajax && $grid->is_ajax): ?>
        <script type="text/javascript">
            cgInstances['<?php echo $grid->id; ?>'].setParams({
                paramsBefore: '<?php echo $grid->params_before; ?>',
                paramsAfter: '<?php echo $grid->params_after; ?>',
                pageSize: '<?php echo $grid->page_size; ?>',
                page: '<?php echo $grid->page; ?>',
                limit: <?php echo is_null($grid->limit) ? 'null' : $grid->limit; ?>,
                offset: <?php echo $grid->offset; ?>,
                columnString: '<?php echo $grid->column_string; ?>',
                orderString: '<?php echo $grid->order_string; ?>',
                filterString: '<?php echo $grid->filter_string; ?>'
            });
        </script>
        <?php endif ?>
        <div class="cg-scroll-o ui-widget-content">
            <div class="cg-scroll">
                <div class="cg-scroll-i">
                    <table class="cg-grid" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="cg-header">
                            <?php if ($grid->allow_select): ?>
                                <th class="ui-widget-header cg-select"><?php echo form_checkbox('cg_select_all', 1, FALSE); ?></th>
                            <?php endif ?>
                            <?php $command_nr = 0; foreach ($grid->commands as $command) if ($command['grid']) { $command_nr++; // Generate command columns ?>
                                <th class="ui-widget-header cg-command"><span class="ui-icon ui-icon-<?php echo $command['icon']; ?>" title="<?php echo $command['text']; ?>"></span></th>
                            <?php } ?>
                            <?php $column_nr = 0; foreach ($grid->columns as $key => $column): if (!$column->visible) continue; $column_nr++; ?>
                                <th class="cg-column-<?php echo $key; ?> ui-widget-header<?php echo in_array($key, $grid->columns_visible) ? '' : ' cg-hidden'; ?>">
                                <?php if ($grid->allow_sort AND $column->allow_sort) { // Orderable header ?>
                                <?php if (isset($grid->order[$key]) && $grid->order[$key] == 'ASC') { ?>
                                    <span class="cg-left">
                                        <?php echo $grid->create_order_url(array('order' => array($key => 'DESC')), $column->header); ?>
                                    </span>
                                    <span class="cg-left ui-icon ui-icon-triangle-1-n"></span>
                                <?php } elseif (isset($grid->order[$key]) && $grid->order[$key] == 'DESC') { ?>
                                    <span class="cg-left">
                                        <?php echo $grid->create_order_url(array('order' => array($key => NULL)), $column->header); ?>
                                    </span>
                                    <span class="cg-left ui-icon ui-icon-triangle-1-s"></span>
                                <?php } else { ?>
                                    <span class="cg-left">
                                        <?php echo $grid->create_order_url(array('order' => array($key => 'ASC')), $column->header); ?>
                                    </span>
                                <?php } ?>
                                <?php } else { // Not orderable header ?>
                                    <span class="cg-left">
                                        <?php echo $column->header; ?>
                                    </span>
                                <?php } ?>
                                    <span class="cg-clear"></span>
                                </th>
                            <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid->allow_filter && $grid->filter_nr > 0) { // Render filters ?>
                            <tr class="cg-filters ui-widget-content">
                                <?php if ($grid->allow_select): ?>
                                <td class="ui-state-default cg-filter-cell">&nbsp;</td>
                                <?php endif ?>
                                <?php foreach ($grid->commands as $command) if ($command['grid']) { // Generate command columns ?>
                                <td class="ui-state-default cg-filter-cell">&nbsp;</td>
                                <?php } ?>
                                <?php $i = 2; foreach ($grid->columns as $key => $column) { if (!$column->visible) continue; ?>
                                <td class="ui-state-default cg-column-<?php echo $key; ?> cg-filter-cell<?php echo in_array($key, $grid->columns_visible) ? '' : ' cg-hidden'; ?>">
                                <?php if ($column->allow_filter) { ?>
                                    <?php if (isset($column->filter_data)) { ?>
                                        <?php echo form_hidden('cg_' . $grid->id . '_filter_op_' . $key, '='); ?>
                                        <?php echo form_dropdown('cg_' . $grid->id . '_filter_' . $key, $column->filter_data, isset($grid->filters[$key]) ? $grid->filters[$key]['value'] : '', 'class="cg-filter ui-widget-content"'); ?>
                                    <?php } else { ?>
                                        <?php
                                            // Render filter control by column type
                                            switch ($column->type)
                                            {
                                                // Boolean
                                                case 'boolean':
                                                    echo form_dropdown('cg_' . $grid->id . '_filter_' . $key, array('' => lang('cg_filter_all'), '1' => lang('cg_filter_true'), '0' => lang('cg_filter_false')), isset($grid->filters[$key]) ? $grid->filters[$key]['value'] : '', 'class="cg-filter ui-widget-content"');
                                                    echo form_hidden('cg_' . $grid->id . '_filter_op_' . $key, 'eq');
                                                    break;

                                                case 'date':
                                                    echo form_dropdown('cg_' . $grid->id . '_filter_op_' . $key, $grid->date_filter_operators, isset($grid->filters[$key]) ? $grid->filters[$key]['operator'] : '', 'class="ui-widget-content"');
                                                    echo form_input('cg_' . $grid->id . '_filter_' . $key, isset($grid->filters[$key]) ? carbo_format_date($grid->filters[$key]['value'], 'Y-m-d', $column->date_format) : '', 'class="cg-filter cg-datepicker ui-widget-content" data-cg-date-format="' .  $column->date_format . '"');
                                                    break;

                                                case 'datetime':
                                                    echo form_dropdown('cg_' . $grid->id . '_filter_op_' . $key, $grid->date_filter_operators, isset($grid->filters[$key]) ? $grid->filters[$key]['operator'] : '', 'class="ui-widget-content"');
                                                    echo form_input('cg_' . $grid->id . '_filter_' . $key, isset($grid->filters[$key]) ? carbo_format_date($grid->filters[$key]['value'], 'Y-m-d H:i:s', $column->date_format . ' ' . $column->time_format) : '', 'class="cg-filter cg-datetimepicker ui-widget-content" data-cg-date-format="' .  $column->date_format . '" data-cg-time-format="' . $column->time_format . '"');
                                                    break;

                                                case 'time':
                                                    echo form_dropdown('cg_' . $grid->id . '_filter_op_' . $key, $grid->date_filter_operators, isset($grid->filters[$key]) ? $grid->filters[$key]['operator'] : '', 'class="ui-widget-content"');
                                                    echo form_input('cg_' . $grid->id . '_filter_' . $key, isset($grid->filters[$key]) ? carbo_format_date($grid->filters[$key]['value'], 'H:i:s', $column->time_format) : '', 'class="cg-filter cg-timepicker ui-widget-content" data-cg-time-format="' .  $column->time_format . '"');
                                                    break;

                                                default:
                                                    echo form_dropdown('cg_' . $grid->id . '_filter_op_' . $key, $grid->filter_operators, isset($grid->filters[$key]) ? $grid->filters[$key]['operator'] : '', 'class="ui-widget-content"');
                                                    echo form_input('cg_' . $grid->id . '_filter_' . $key, isset($grid->filters[$key]) ? $grid->filters[$key]['value'] : '', 'class="cg-filter ui-widget-content"');
                                            }
                                        ?>
                                    <?php } ?>
                                <?php } ?>
                                </td>
                                <?php $i++; } ?>
                            </tr>
                            <?php } ?>

                            <?php $i = 0; foreach ($grid->data as $data_row) { $i++; $data_id = $data_row->{$grid->table_id_name}; $selected = in_array($data_id, $grid->selected_ids); ?>
                            <tr class="ui-widget-content <?php echo (($i % 2) ? 'cg-even' : 'cg-odd') . (($i == 1) ? ' cg-first' : '') . (($i == $grid->limit) ? ' cg-last' : ''); ?>">
                                <?php if ($grid->allow_select): ?>
                                <td class="cg-data cg-select <?php echo $selected ? 'ui-state-highlight' : 'ui-widget-content' ?>"><?php echo form_checkbox('cg_' . $grid->id . '_item_ids[]', $data_id, $selected, 'id="cg_' . $grid->id . '_item_' . $data_id . '" class="cg-cb-select"'); ?></td>
                                <?php endif ?>
                                <?php foreach ($grid->commands as $command) if ($command['grid']) { // Generate command columns ?>
                                    <td class="cg-data cg-command <?php echo $selected ? 'ui-state-highlight' : 'ui-widget-content' ?>">
                                    <?php
                                        if ($grid->check_command($command, $data_row))
                                            switch ($command['type'])
                                            {
                                                case 'link':
                                                    echo anchor(rtrim($command['url'], '/') . '/' . $data_id, $command['text'], 'title="' . $command['text'] . '" class="ui-icon ui-icon-' . $command['icon'] . ' cg-command cg-icon-button"');
                                                    break;
                                                default:
                                                    echo form_submit('cg_' . $grid->id . '_command_' . $command['name'], $data_id, 'title="' . $command['text'] . '" class="ui-icon ui-icon-' . $command['icon'] . ' cg-command cg-icon-button"');
                                            }
                                        else
                                            echo '&nbsp;';
                                    ?>
                                    </td>
                                <?php } ?>
                                <?php foreach ($grid->columns as $key => $column): if (!$column->visible) continue; ?>
                                <td class="cg-data cg-column-<?php echo $key;?> <?php echo $selected ? 'ui-state-highlight' : 'ui-widget-content' ?><?php echo in_array($key, $grid->columns_visible) ? '' : ' cg-hidden'; ?>">
                                    <?php
                                        $data_cell = $data_row->{$column->unique_name};
                                        // Custom display template
                                        if ($column->display AND method_exists($grid->CI, $column->display))
                                        {
                                            echo $grid->CI->{$column->display}($data_id, $key, $data_cell);
                                        }
                                        // Display by column type
                                        else
                                        {
                                            switch ($column->type)
                                            {
                                                // Boolean
                                                case 'boolean':
                                                    echo $data_cell ? '<span class="ui-icon ui-icon-check"></span>' : '';
                                                    break;

                                                case 'date':
                                                    echo carbo_format_date($data_cell, 'Y-m-d', $column->date_format);
                                                    break;

                                                case 'datetime':
                                                    echo carbo_format_date($data_cell, 'Y-m-d H:i:s', $column->date_format . ' ' . $column->time_format);
                                                    break;

                                                case 'time':
                                                    echo carbo_format_date($data_cell, 'H:i:s', $column->time_format);
                                                    break;

                                                case 'url':
                                                    echo $data_cell ? '<a href="' . $data_cell . '" target="' . $column->url_target . '">' . $data_cell . '</a>' : '&nbsp;';
                                                    break;

                                                /*case 'file':
                                                    $path = rtrim(str_replace('./', '', $grid->columns[$j]['upload_path']), '/') . '/';
                                                    echo '<audio src="' . base_url() . $path . $data_cell . '" controls="controls">Your browser does not support audio</audio>';
                                                    break;*/

                                                default:
                                                    // Trim string data to max length
                                                    if (strlen($data_cell) > $grid->max_cell_length)
                                                    {
                                                        $data_cell = '<span title="' . $data_cell . '">' . substr($data_cell, 0, 50) . '...</span>';
                                                    }
                                                    echo $data_cell;
                                            }
                                        }
                                    ?>
                                </td>
                                <?php endforeach ?>
                            </tr>
                            <?php } ?>

                            <?php if (!count($grid->data)): // If no data exists ?>
                            <tr>
                                <?php if ($grid->allow_select): $i++; ?>
                                <td class="ui-widget-content">&nbsp;</td>
                                <?php endif ?>
                                <td class="ui-widget-content" colspan="<?php echo count($grid->columns) + $command_nr; ?>"><?php echo lang('cg_no_items'); ?></td>
                            </tr>
                            <?php endif ?>

                            <?php if ($grid->show_empty_rows AND $i < $grid->limit) for ($j = $i; $j < $grid->limit; $j++) { ?>
                            <tr class="<?php echo (($j % 2) ? 'even' : 'odd') . (($j == 0) ? ' first' : '') . (($j == $grid->limit - 1) ? ' last' : ''); ?>">
                                <td class="cg-empty cg-select ui-widget-content"><input type="checkbox" style="visibility:hidden;" /></td>
                                <?php for ($k = 0; $k < $command_nr; $k++) { ?>
                                <td class="cg-empty ui-widget-content">&nbsp;</td>
                                <?php } ?>
                                <?php foreach ($grid->columns as $key => $column): if (!$column->visible) continue; ?>
                                <td class="cg-empty cg-column-<?php echo $key;?> ui-widget-content<?php echo in_array($key, $grid->columns_visible) ? '' : ' cg-hidden'; ?>">
                                <?php endforeach ?>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="ui-widget-header ui-widget-footer cg-footer">
            <?php if ($grid->allow_pagination): ?>
            <div class="cg-left cg-pagination">

                    <?php echo ($grid->page_curr == 1) ? '<span title="' . lang('cg_page_first') . '" class="cg-pag cg-pag-first cg-disabled ui-button ui-widget ui-state-default ui-corner-left ui-button-disabled ui-state-disabled ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-first"></span><span class="ui-button-text">' . lang('cg_page_first') . '</span></span>' : '<a title="' . lang('cg_page_first') . '" href="' . site_url($grid->first_link) . '" data-page="1" class="cg-pag-first cg-pag ui-button ui-widget ui-state-default ui-corner-left ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-first"></span><span class="ui-button-text">' . lang('cg_page_first') . '</span></a>'; ?>
                    <?php echo ($grid->page_curr == 1) ? '<span title="' . lang('cg_page_prev') . '" class="cg-pag cg-pag-prev cg-disabled ui-button ui-widget ui-state-default ui-button-disabled ui-state-disabled ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-prev"></span><span class="ui-button-text">' . lang('cg_page_prev') . '</span></span>' : '<a title="' . lang('cg_page_prev') . '" href="' . site_url($grid->prev_link) . '" data-page="' . ($grid->page_curr - 1) . '" class="cg-pag-prev cg-pag ui-button ui-widget ui-state-default ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-prev"></span><span class="ui-button-text">' . lang('cg_page_prev') . '</span></a>'; ?>
                    <?php foreach ($grid->page_links as $page_nr => $url) { ?>
                        <?php echo ($page_nr == $grid->page_curr) ? '<span class="cg-pag cg-pag-nr cg-disabled ui-button ui-widget ui-state-default ui-button-disabled ui-state-disabled ui-button-text-only"><span class="ui-button-text">' . $page_nr . '</span></span>' : '<a href="' . site_url($url) . '" data-page="' . $page_nr . '" class="cg-pag cg-pag-nr ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">' . $page_nr . '</span></a>'; ?>
                    <?php } ?>
                    <?php echo ($grid->page_curr == $grid->page_max) ? '<span title="' . lang('cg_page_next') . '" class="cg-pag cg-pag-next cg-disabled ui-button ui-widget ui-state-default ui-button-disabled ui-state-disabled ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-next"></span><span class="ui-button-text">' . lang('cg_page_next') . '</span></span>' : '<a title="' . lang('cg_page_next') . '" href="' . site_url($grid->next_link) . '" data-page="' . ($grid->page_curr + 1) . '" class="cg-pag-next cg-pag ui-button ui-widget ui-state-default ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-next"></span><span class="ui-button-text">' . lang('cg_page_next') . '</span></a>'; ?>
                    <?php echo ($grid->page_curr == $grid->page_max) ? '<span title="' . lang('cg_page_last') . '" class="cg-pag cg-pag-last cg-disabled ui-button ui-widget ui-state-default ui-corner-right ui-button-disabled ui-state-disabled ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-end"></span><span class="ui-button-text">' . lang('cg_page_last') . '</span></span>' : '<a title="' . lang('cg_page_last') . '" href="' . site_url($grid->last_link) . '" data-page="' . $grid->page_max . '" class="cg-pag-last cg-pag ui-button ui-widget ui-state-default ui-corner-right ui-button-icon-only"><span class="ui-button-icon-primary ui-icon ui-icon-seek-end"></span><span class="ui-button-text">' . lang('cg_page_last') . '</span></a>'; ?>
            </div>
            <?php if ($grid->allow_page_size): ?>
            <div class="cg-left cg-size">
                    &nbsp;<?php echo lang('cg_page_size') . '&nbsp;' . form_dropdown('cg_' . $grid->id . '_page_size', $grid->limits, $grid->limit, 'class="cg-page-size"'); ?>&nbsp;
                    <?php if ($grid->ajax) { ?><noscript><?php } ?>
                        <input type="submit" name="cg_<?php echo $grid->id; ?>_change_page_size" value="<?php echo lang('cg_go'); ?>" class="cg-button cg-button-text-only ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" />
                    <?php if ($grid->ajax) { ?></noscript><?php } ?>

            </div>
            <?php endif ?>
            <?php endif ?>
            <div class="cg-right cg-items-nr">
                <?php echo sprintf(lang('cg_page_displaying'), $grid->item_start, $grid->item_end, $grid->total); ?>
            </div>
            <div class="cg-clear"></div>
        </div>

<?php endif ?>

<?php if (!$grid->is_ajax): ?>
    </div><?php // /.cg-table ?>
    </div><?php // /.cg-rel ?>
    <?php if (!$grid->nested) echo form_close(); ?>
</div>
<?php endif ?>
