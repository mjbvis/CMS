var Carbo = Carbo || {};

if (cfSettings == undefined) var cfSettings = {};
if (cfInstances == undefined) var cfInstances = {};

Carbo.Form = function(id, opt) {
    // If element does not exist, return
    if (!$('#' + id).length) return false;

    // Public members
    this.id = id;
    this.container = $('#' + id);

    // Private members
    var context = this.container[0];
    var me = this;
    var settings = opt;

    this.init = function() {
        this.load();
    }

    this.load = function() {
        // Init show/hide sections
        $('.cg-group-header', context).disableSelection();
        $('.cg-group-header .ui-icon', context).click(function() {
            $(this).closest('.cg-group').find('.cg-group-content').slideToggle();
            $(this).toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e');
        });
        $('.cg-group-header', context).dblclick(function() {
            $(this).closest('.cg-group').find('.cg-group-content').slideToggle();
            $('.ui-icon', this).toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e');
        });
        // Init datepickers
        $('.cg-datepicker', context).each(function() {
            var df = $(this).attr('data-cg-date-format');
            // Convert php formats
            df = df.replace(/Y/, 'yy')
                .replace(/n/, 'm')
                .replace(/m/, 'mm')
                .replace(/j/, 'd')
                .replace(/d/, 'dd');
            $(this).datepicker({
                dateFormat: df,
                monthNames: settings.monthNames,
                monthNamesShort: settings.monthNamesShort,
                dayNames: settings.dayNames,
                dayNamesShort: settings.dayNamesShort,
                dayNamesMin: settings.dayNamesMin
            });
        });
        $('.cg-datetimepicker', context).each(function() {
            var df = $(this).attr('data-cg-date-format');
            var tf = $(this).attr('data-cg-time-format');
            var ap = tf.match(/[ghaA]/);
            var ss = tf.match(/s/);
            // Convert php formats
            df = df.replace(/Y/, 'yy')
                .replace(/n/, 'm')
                .replace(/m/, 'mm')
                .replace(/M/, 'M')
                .replace(/F/, 'MM')
                .replace(/j/, 'd')
                .replace(/d/, 'dd');
            tf = tf.replace(/[hH]/, 'hh')
                .replace(/[gG]/, 'h')
                .replace(/a/, 'tt')
                .replace(/A/, 'TT')
                .replace(/i/, 'mm')
                .replace(/s/, 'ss');
            $(this).datetimepicker({
                dateFormat: df,
                timeFormat: tf,
                ampm: ap,
                showSecond: ss,
                monthNames: settings.monthNames,
                monthNamesShort: settings.monthNamesShort,
                dayNames: settings.dayNames,
                dayNamesShort: settings.dayNamesShort,
                dayNamesMin: settings.dayNamesMin,
                timeOnlyTitle: settings.timeOnlyTitle,
                timeText: settings.timeText,
                hourText: settings.hourText,
                minuteText: settings.minuteText,
                secondText: settings.secondText,
                currentText: settings.currentText,
                closeText: settings.closeText
            });
        });
        $('.cg-timepicker', context).each(function() {
            var tf = $(this).attr('data-cg-time-format');
            var ap = tf.match(/[ghaA]/);
            var ss = tf.match(/s/);
            // Convert php formats
            tf = tf.replace(/[hH]/, 'hh')
                .replace(/[gG]/, 'h')
                .replace(/a/, 'tt')
                .replace(/A/, 'TT')
                .replace(/i/, 'mm')
                .replace(/s/, 'ss');
            $(this).timepicker({
                timeFormat: tf,
                ampm: ap,
                showSecond: ss,
                timeOnlyTitle: settings.timeOnlyTitle,
                timeText: settings.timeText,
                hourText: settings.hourText,
                minuteText: settings.minuteText,
                secondText: settings.secondText,
                currentText: settings.currentText,
                closeText: settings.closeText
            });
        });
    }

    this.init();
}

$(function() {
    // Init forms if any
    for (var id in cfSettings) {
        cfInstances[id] = new Carbo.Form('carboform_' + id, cfSettings[id]);
    }
});

/*$(document).ready(function() {
    var baseUrl = $('.form-base-url').text();

    // Init show/hide sections
    $('.cg-group-header').disableSelection();
    $('.cg-group-header .ui-icon').click(function() {
        $(this).closest('.cg-group').find('.cg-group-content').slideToggle();
        $(this).toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e');
    });
    $('.cg-group-header').dblclick(function() {
        $(this).closest('.cg-group').find('.cg-group-content').slideToggle();
        $('.ui-icon', this).toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e');
    });
    // Init datepickers
    $('.cg-datepicker').datepicker();
    // Disable empty dropdowns
    $('.cg-form select').each(function() {
        if ($('option', this).length == 1) $(this).attr('disabled', 'disabled');
    });
    $('.cg-filter').live('change', function() {
        var nr = $(this).data('nr') - 0;
        var name = $(this).data('name');
        var filter = $(this).data('filter');
        var value = $(this).val();
        var target = $('#cm_field_' + name + '_filter' + (nr + 1)).length ? $('#cm_field_' + name + '_filter' + (nr + 1)) : $('#cm_field_' + name);
        var table = target.data('table');
        var field = target.data('field');
        var type = target.data('type');
        // Disable further filters
        var i = nr + 1;
        while ($('#cm_field_' + name + '_filter' + i).length) {
            $('#cm_field_' + name + '_filter' + i).val('').attr('disabled', 'disabled');
            i++;
        }
        $('#cm_field_' + name).val('').attr('disabled', 'disabled');
        // Get data
        $.post(baseUrl + 'carbogrid/ajax/get_dropdown',
            {
                table: table,
                field: field,
                type: type,
                filter: filter,
                value: value
            },
            function(resp) {
                target.html(resp);
                if ($('option', target).length > 1) target.attr('disabled', '');
        });
    });
});*/
