var Carbo = Carbo || {};

if (cgSettings == undefined) var cgSettings = {};
if (cgInstances == undefined) var cgInstances = {};

Carbo.Grid = function(id, opt) {
    // If element does not exist, return
    if (!$('#' + id).length) return false;

    // Public members
    this.id = id;
    this.container = $('#' + id);
    this.defHash = '';
    this.hash = '';
    this.preventLoad = false;
    this.settings = {};

    // Private members
    var context = this.container[0];
    var shortID = this.id.replace(/^carbogrid_/, '')
    var form;
    var poll;
    var posted = false;
    var me = this;
    var formOptions = {};
    var defaults = {
        baseUrl: '',
        gridUrl: '',
        paramsBefore: '',
        paramsAfter: '',
        pageSize: 10,
        page: 1,
        limit: 10,
        offset: 0,
        allowSelect: true,
        allowColumns: true,
        columnString: 'all',
        orderString: 'none',
        filterString: '',
        commands: {},
        // Regional
        monthNames: [],
        monthNamesShort: [],
        dayNames: [],
        dayNamesShort: [],
        dayNamesMin: [],
        timeOnlyTitle: "Choose Time",
        timeText: "Time",
        hourText: "Hour",
        minuteText: "Minute",
        secondText: "Second",
        currentText: "Now",
        closeText: "Done"
    };
    var settings = $.extend({}, defaults, opt);
    settings.url = settings.baseUrl + settings.gridUrl;

    // Methods
    this.block = function() {
        //this.container.block({ message: null });
        $('.cg-grid-overlay', context).height(this.container.outerHeight()).show();
    }

    this.unblock = function() {
        //this.container.unblock();
        $('.cg-grid-overlay', context).hide();
    }

    this.setParams = function(params) {
        $.extend(settings, params);
        this.settings = settings;
    }

    this.createUri = function(p) {
        if (p === undefined) p = {};
        var ret =
            (p.pageSize !== undefined ? p.pageSize : settings.pageSize) + '-' +
            settings.page + '-' +
            settings.columnString + '-' +
            settings.orderString + '-' +
            settings.filterString;
        return ret;
    }

    this.pushState = function(uri) {
        if (settings.ajaxHistory) {
            $.bbq.pushState(shortID + '=' + uri);
            /*var url = settings.url + settings.paramsBefore + uri + settings.paramsAfter;
            data = {};
            data[shortID] = uri;
            history.pushState(data, 'Carbo', url);
            me.get(uri);*/
        }
        else {
            me.get(uri);
        }
    }

    this.checkButtons = function() {
        // Enable/disable buttons
        if ($('.cg-grid td :checkbox:checked', context).length) {
            $('.cg-toolbar .cg-delete', context).button('enable');
        }
        else {
            $('.cg-toolbar .cg-delete', context).button('disable');
        }
    }

    this.progress = function() {
        $('.cg-dialog-progress', context).progressbar('value', 0).show();
        var skip = false;
        poll = setInterval(function() {
            if (!skip) {
                skip = true;
                $.getJSON(settings.baseUrl + 'carbo/ajax/get_progress/' + $('input[name="UPLOAD_IDENTIFIER"]', context).val(), function(resp) {
                    skip = false;
                    if (resp) {
                        var percent = Math.floor(100 * parseInt(resp['bytes_uploaded']) / parseInt(resp['bytes_total']));
                        $('.cg-dialog-progress', context).progressbar('value', percent)
                    }
                });
            }
        }, 1000);
    }

    this.command = function(name, value) {
        var command = settings.commands[name];
        if (command === undefined) return false;
        if (command.confirm) {
            $('.cg-dialog-wrapper .ui-dialog', context).addClass('cg-dialog-confirm').removeClass('cg-dialog-form');
            $('.cg-dialog-wrapper .ui-dialog-title', context).html(command.confirm_title);
            $('.cg-dialog-wrapper .ui-dialog-content', context).html('<div class="ui-widget"><div class="cg-error ui-state-highlight ui-corner-all"><p><span class="cg-left ui-icon ui-icon-alert"></span>' + command.confirm_text + '</p></div></div>');
            $('.cg-dialog-wrapper .cg-hidden-command', context).html('<input type="hidden" name="cg_' + shortID + '_command_' + command.name + '" value="' + value + '" />');
            $('.cg-dialog-wrapper .cg-dialog-yes', context).val(command.confirm_yes).unbind('click').click(function() { $('.cg-dialog-wrapper', context).hide(); me.block(); });
            $('.cg-dialog-wrapper .cg-dialog-no', context).val(command.confirm_no).unbind('click').click(function() {
                $('.cg-dialog-wrapper', context).hide();
                $('.cg-dialog-wrapper .cg-hidden-command', context).html('');
                return false;
            });
            $('.cg-dialog-wrapper', context).show();
            return false;
        }
        if (command.type == 'dialog') {
            $('.cg-dialog-wrapper .ui-dialog', context).removeClass('cg-dialog-confirm').addClass('cg-dialog-form');
            $('.cg-dialog-wrapper .ui-dialog-title', context).html(command.text);
            $('.cg-dialog-wrapper .ui-dialog-content', context).html('');
            $('.cg-dialog-wrapper .cg-hidden-command', context).html('<input type="hidden" name="cg_' + shortID + '_command_' + command.name + '" value="' + value + '" />');
            $('.cg-dialog-wrapper .cg-dialog-yes', context).val(command.dialog_save).unbind('click');
            $('.cg-dialog-wrapper .cg-dialog-no', context).val(command.dialog_cancel).unbind('click').click(function() {
                $('.cg-dialog-wrapper', context).hide();
                $('.cg-dialog-wrapper .cg-hidden-command', context).html('');
                return false;
            });
            $('.cg-dialog-wrapper', context).show();
        }
        else {
            me.block();
        }
        return true;
    }

    this.init = function() {
        // Init buttons
        $('.cg-toolbar .cg-button', context).each(function() {
            var icon = $(this).attr('class').match(/cg-icon-[^\s]*/i);
            if (icon) icon = icon[0].replace(/cg-icon-/i, 'ui-icon-');
            $('<a href="#" class="' + $(this).attr('class') + '">' + $(this).val() + '</a>')
                .data('name', $(this).attr('name'))
                .data('value', $(this).val())
                .button({ icons: { primary: icon } }).insertAfter($(this));
            $(this).remove();
        });
        // Init Columns button
        $('.cg-columns', context).live('click', function() {
            $('.cg-columns-list', context).toggleClass('cg-hidden');
            return false;
        });
        $('.cg-columns-list', context).live('click', function(e) {
            e.stopPropagation();
        });
        $(document).click(function() {
            $('.cg-columns-list', context).addClass('cg-hidden');
        });
        // Init pagination links
        $('a.cg-pag', context).live('click', function() {
            settings.page = $(this).attr('data-page');
            me.pushState(me.createUri());
            return false;
        });
        // Init sort links
        $('a.cg-sort', context).live('click', function() {
            settings.orderString = $(this).attr('data-order');
            me.pushState(me.createUri());
            return false;
        });
        // Init dialog
        $('.cg-dialog-wrapper .cg-button').button();
        $('.cg-dialog-wrapper .ui-dialog-titlebar-close').hover(
            function() { $(this).addClass('ui-state-hover'); },
            function() { $(this).removeClass('ui-state-hover');}
        );
        $('.cg-dialog-wrapper .ui-dialog-titlebar-close', context).live('click', function() {
            $('.cg-dialog-wrapper', context).hide();
            $('.cg-dialog-wrapper .cg-hidden-command', context).html('');
            return false;
        });
        // Init columns show/hide
        if (settings.allowColumns) {
            $('.cg-col-visible', context).live('click', function() {
                if (this.checked) {
                    $('.cg-column-' + $(this).val(), context).removeClass('cg-hidden');
                }
                else {
                    $('.cg-column-' + $(this).val(), context).addClass('cg-hidden');
                }
                var columnString = '';
                var nr = 0;
                var l = 0;
                $('.cg-col-visible', context).each(function() {
                    l++;
                    if (this.checked) {
                        columnString += $(this).val() + ':';
                        nr++;
                    }
                });
                settings.columnString = (nr == l) ? 'all' : (columnString ? columnString.replace(/:$/, '') : 'none');
                if (settings.ajaxHistory) {
                    me.preventLoad = true;
                    me.pushState(me.createUri());
                }
            });
        }
        // Init row selection
        if (settings.allowSelect) {
            $('.cg-data', context).live('click', function(e) {
                $(this).closest('tr').find('td').toggleClass('ui-state-highlight').toggleClass('ui-widget-content');
                if ($(e.target).attr('type') !== 'checkbox') {
                    var checkbox = $(this).closest('tr').find('td.cg-select :checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
                if ($('td :checkbox', context).length == $('td :checkbox:checked', context).length) {
                    $('th.cg-select :checkbox', context).prop('checked', true);
                }
                else {
                    $('th.cg-select :checkbox', context).prop('checked', false);
                }
                me.checkButtons();
            });
            // Init select all checkbox
            $('.cg-grid th.cg-select :checkbox', context).live('click', function() {
                $(this).closest('table').find('td :checkbox').prop('checked', this.checked);
                if (this.checked) {
                    $(this).closest('table').find('tbody td.cg-data').addClass('ui-state-highlight').removeClass('ui-widget-content');
                }
                else {
                    $(this).closest('table').find('tbody td.cg-data').removeClass('ui-state-highlight').addClass('ui-widget-content');
                }
                me.checkButtons();
            });
        }
        // Init filter
        if (settings.allowFilter) {
            $('.cg-apply-filter', context).click(function() {
                var filterString = '';
                $('.cg-filter', context).each(function() {
                    var id = $(this).attr('name').replace('cg_' + shortID + '_filter_', '');
                    var op = $(':input[name=' + 'cg_' + shortID + '_filter_op_' + id + ']').val();
                    if (op && $(this).val() !== '') {
                        filterString += id + ':' + encode($(this).val()) + ':' + op + '_';
                    }
                });
                settings.filterString = filterString ? filterString.replace(/_$/, '') : 'all';
                settings.page = 1;
                me.pushState(me.createUri());
                return false;
            });
        }
        // Init command buttons
        $('.cg-toolbar a.cg-command', context).live('click', function() {
            var name = $(this).data('name').replace('cg_' + shortID + '_command_', '');
            var value = $(this).data('value');
            if (me.command(name, value)) {
                form.ajaxSubmit(formOptions);
            }
            return false;
        });
        $('.cg-data input.cg-command', context).live('click', function() {
            var name = $(this).attr('name').replace('cg_' + shortID + '_command_', '')
            var value = $(this).val();
            if (me.command(name, value)) {
                form.ajaxSubmit(formOptions);
            }
            return false;
        });
        // Init dialog buttons
        $('.cg-dialog-yes', context).live('click', function() {
            formOptions.data['cg_' + shortID + '_dialog_yes'] = $(this).val();
            form.ajaxSubmit(formOptions);
            return false;
        });
        $('.cg-dialog-wrapper .cg-icon-button', context).live('click', function() {
            formOptions.data[$(this).attr('name')] = $(this).val();
            form.ajaxSubmit(formOptions);
            return false;
        });
        // Prevent row selection for cell controls
        $('.cg-data', context).find('a,object,:input').live('click', function(e) {
            if (!$(this).hasClass('cg-cb-select')) e.stopPropagation();
        });
        // Init cancel on ESC
        $(document).bind('keyup.cg-dialog', function(e) {
            if (e.keyCode == 27) {
                $('.cg-dialog-wrapper', context).hide();
                $('.cg-dialog-wrapper .cg-hidden-command', context).html('');
                return false;
            }
        });
        me.defHash = me.createUri();
        me.settings = settings;
        // Call load event
        this.load();
    }

    this.load = function() {
        // Enable/disable buttons by selection
        this.checkButtons();
        // Init row hover
        $('.cg-data', context).hover(
            function() {
                $(this).closest('tr').find('td').addClass('ui-state-hover');
            },
            function() {
                $(this).closest('tr').find('td').removeClass('ui-state-hover');
            }
        );
        // Init pagination buttons
        $('.cg-pag-first', context).html($('.cg-pag-first', context).text()).button({ icons: { primary: 'ui-icon-seek-first' }, text: false, disabled: $('.cg-pag-first', context).hasClass('cg-disabled') }).removeClass('ui-corner-all').addClass('ui-corner-left');
        $('.cg-pag-prev', context).html($('.cg-pag-prev', context).text()).button({ icons: { primary: 'ui-icon-seek-prev' }, text: false, disabled: $('.cg-pag-prev', context).hasClass('cg-disabled') }).removeClass('ui-corner-all');
        $('.cg-pag-next', context).html($('.cg-pag-next', context).text()).button({ icons: { primary: 'ui-icon-seek-next' }, text: false, disabled: $('.cg-pag-next', context).hasClass('cg-disabled') }).removeClass('ui-corner-all');
        $('.cg-pag-last', context).html($('.cg-pag-last', context).text()).button({ icons: { primary: 'ui-icon-seek-end' }, text: false, disabled: $('.cg-pag-last', context).hasClass('cg-disabled') }).removeClass('ui-corner-all').addClass('ui-corner-right');
        $('.cg-pag-nr', context).each(function() { $(this).html($(this).text()).button({ disabled: $(this).hasClass('cg-disabled') }); }).removeClass('ui-corner-all');;
        // Init page size change
        $('.cg-page-size', context).change(function() {
            me.pushState(me.createUri({ pageSize: $(this).val() }));
        });
        // Init dialog progressbar
        clearInterval(poll);
        $('.cg-dialog-progress', context).hide().progressbar();
        // Set column visibility checkboxes
        if (settings.columnString == 'all') {
            $('.cg-col-visible', context).prop('checked', true);
        }
        else if (settings.columnString == 'none') {
            $('.cg-col-visible', context).prop('checked', false);
        }
        else {
            $('.cg-col-visible', context).prop('checked', false);
            var ids = settings.columnString.split(':');
            for (var i = 0; i < ids.length; i++) {
                $('.cg-col-visible[value=' + ids[i] + ']', context).prop('checked', true);
            }
        }
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
        // Init filter on Enter
        $('.cg-filter', context).keyup(function(e) {
            if (e.keyCode == 13) {
                $('.cg-apply-filter', context).click();
                return false;
            }
        });
        // Init form post
        me.hash = me.createUri();
        var fdata = {};
        fdata['cg_ajax_' + shortID] = 1
        formOptions = {
            url: settings.url + settings.paramsBefore + me.hash + settings.paramsAfter,
            data: fdata,
            dataType: 'json',
            beforeSubmit: function() {
                // Prevent multiple submit
                if (posted) return false;
                posted = true;
                $('.cg-dialog-loading', context).show();
                return true;
            },
            success: loadResponse
        };
        form = $('.cg-table', context).closest('form');
        try {
            form.removeAttr('encoding');
            form.removeAttr('enctype');
        }
        catch (e) {}
    }

    this.refresh = function() {
        me.get(me.createUri());
    }

    this.get = function(uri) {
        var url = settings.url + settings.paramsBefore + uri + settings.paramsAfter;
        // Hide column dropdown
        $('.cg-columns-list', context).addClass('cg-hidden');
        me.block();
        //$.getJSON(url, loadResponse);
        var fdata = {};
        fdata['cg_ajax_' + shortID] = 1
        $.post(url, fdata, loadResponse, 'json')
    }

    // Init datagrid
    this.init();

    // Private functions
    function loadResponse(resp) {
        if (resp.redirect) {
            window.location.href = settings.baseUrl + resp.redirect;
            return false;
        }
        if (resp.table) {
            $('.cg-table', context).html(resp.table);
            me.load();
        }
        if (resp.dialog) {
            $('.cg-dialog-wrapper .ui-dialog-content', context).html(resp.dialog).scrollTop(0);
            // Init form
            if (cfSettings[shortID]) {
                cfInstances[shortID] = cfInstances[shortID] = new Carbo.Form('carboform_' + shortID, cfSettings[shortID]);
            }
        }
        else {
            $('.cg-dialog-wrapper .cg-hidden-command', context).html('');
            $('.cg-dialog-wrapper', context).hide();
        }
        $('.cg-dialog-loading', context).hide();
        //$('.cg-dialog-progress', context).hide();
        // Reset post data
        var fdata = {};
        fdata['cg_ajax_' + shortID] = 1
        formOptions.data = fdata;
        // Unblock ui and init table
        me.unblock();
        posted = false;
        return true;
    }

    function encode(s) {
        return Base64.encode(s).replace(/\+/g, '%').replace(/\//g, '.').replace(/\=/g, '~');
    }

    function decode(s) {
        return Base64.decode(s.replace(/%/g, '+').replace(/\./g, '/').replace(/~/, '='));
    }

    return true;
}

Carbo.hashchange = function(e) {
    //var hash = e.originalEvent.state || {};
    var hash = $.deparam.fragment();
    for (var id in cgInstances) {
        if (hash[id] === undefined) hash[id] = cgInstances[id].defHash;
        if (cgInstances[id].hash != hash[id] && !cgInstances[id].preventLoad && cgInstances[id].settings.ajaxHistory)
            cgInstances[id].get(hash[id]);
        else
            cgInstances[id].preventLoad = false;
    }
}

$(function() {
    // Init grids if any
    for (var id in cgSettings) {
        cgInstances[id] = new Carbo.Grid('carbogrid_' + id, cgSettings[id]);
    }
    // Init history plugin
    $(window).bind('hashchange', Carbo.hashchange);
    if ($.param.fragment()) {
        setTimeout(function() { $(window).trigger('hashchange'); }, 100);
    }

    //$(window).bind('popstate', Carbo.hashchange);
});

// ---------------------------------------------------------------------

var Base64 = {

    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
        input = Base64._utf8_encode(input);
        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);
            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;
            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }
            output = output +
            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
        }
        return output;
    },

    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (i < input.length) {
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        output = Base64._utf8_decode(output);
        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
        }
        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
        while ( i < utftext.length ) {
            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }
        return string;
    }
}
