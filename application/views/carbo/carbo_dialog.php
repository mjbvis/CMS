<div class="cg-dialog-wrapper"<?php if (!$dialog->visible) echo 'style="display:none;"'; ?>>

    <!--[if lt IE 7]>
    <iframe class="cg-overlay ui-widget-overlay" border="0" frameborder="0" scrolling="no"></iframe>
    <![endif]-->

    <div class="cg-overlay ui-widget-overlay"></div>
    <div class="cg-dialog ui-dialog ui-widget ui-widget-content ui-corner-all <?php echo $dialog->class;?>">
        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
            <span class="ui-dialog-title" id="ui-dialog-title-1"><?php echo $dialog->title; ?></span>
            <?php echo anchor($this->uri->uri_string(), '<span class="ui-icon ui-icon-closethick">Close</span>', 'class="ui-dialog-titlebar-close ui-corner-all"'); ?>
        </div>
        <div class="ui-dialog-content ui-widget-content">
            <?php echo $dialog->content; ?>
        </div>
        <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
            <div class="cg-dialog-loading"></div>
            <div class="cg-dialog-progress"></div>
            <div class="ui-dialog-buttonset cg-right">
                <?php echo form_submit('cg_' . $grid->id . '_dialog_yes', $dialog->yes, 'class="cg-button cg-dialog-yes ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"'); ?>
                <?php echo form_submit('cg_' . $grid->id . '_dialog_no', $dialog->no, 'class="cg-button cg-dialog-no ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"'); ?>
                <div class="cg-hidden-command">
                    <?php if (isset($dialog->command)) echo form_hidden('cg_' . $grid->id . '_command_' . $dialog->command, $dialog->command_arg); ?>
                </div>
            </div>
            <div class="cg-clear"></div>
        </div>
    </div>

</div>
