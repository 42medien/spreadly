/**
 * @combine statistics
 */


/**
 * @source http://www.dev4press.com/jquery/jgd-dropdown/
 */
;(function($){
    $.fn.jgdDropdown = function(options) {
        var settings =  $.extend({}, $.fn.jgdDropdown.defaults, options);
        return this.each(function() {
            var $this = $(this);
            var $id = $.fn.jgdDropdown.convert($this, settings);

            $("#" + $id + " dt a").click(function() {
                $("#" + $id + " dd ul").toggle();
                return false;
            });

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (!$clicked.parents().hasClass(settings.cls)) {
                    $("." + settings.cls + " dd ul").hide();
                }
            });

            $("#" + $id + " dd ul li a").click(function() {
                var $sel = $(this);
                var $val = $sel.find("span.value").html();
                $this.val($val);
                $("#" + $id + " dt a").html($sel.html());
                $("#" + $id + " dd ul").hide();
                if (settings.clsCopySelect) {
                    $("#" + $id + " dt").attr("class", $sel.parent().attr("class"));
                }
                $sel.parent().parent().find("li").removeClass(settings.clsLISelected);
                $sel.parent().addClass(settings.clsLISelected);
                if (settings.callback) {
                    settings.callback($this, $val);
                }
                return false;
            });
        });
    };
    $.fn.jgdDropdown.defaults = {
        callback: null,
        cls: 'jgd-dropdown',
        initTitle: '',
        forceTitle: false,
        clsLIPrefix: '',
        clsLISelected: 'selected',
        clsCopySelect: true,
        clsLIExpand: true,
        selected: ''
    };
    $.fn.jgdDropdown.convert = function($obj, settings) {
        var iTitle = settings.initTitle;
        var iVal = '';
        if (settings.selected !== null && settings.selected !== '') {
            $obj.val(settings.selected);
            if (!settings.forceTitle) {
                iTitle = '';
            }
        }
        var selected = $obj.find("option[selected]");
        var options = $("option", $obj);
        var id = "jgd_dd_" + get_id($obj);
        $obj.after('<dl id="' + id + '" class="' + settings.cls + '"></dl>');
        if (iTitle === '') {
            iTitle = selected.text();
            iVal = selected.val();
        }
        $("#" + id).append('<dt><a href="#">' + iTitle + '<span class="value">' + iVal +  '</span></a></dt>');
        $("#" + id).append('<dd><ul></ul></dd>');
        options.each(function(index){
            var elClass = $(this).attr("class");
            var elStyle = $(this).attr("style");

            var cls = settings.clsLIPrefix + $(this).val();
            if (settings.clsLIExpand) {
                cls += " item-" + index;
                cls += " item-" + ($.fn.jgd.isEven(index) ? "even" : "odd");
                if (index === 0) {
                    cls += " item-first";
                }
                if (index == options.length - 1) {
                    cls += " item-last";
                }
                if(elClass && elClass !== '') {
                    cls+= " " + thisclass;
                }
            }
            if (settings.clsCopySelect) {
                $("#" + id + " dt").attr("class", cls);
            }
            if ($(this).val() == selected.val()) {
                cls += " " + settings.clsLISelected;
            }
            $("#" + id + " dd ul").append('<li class="' + cls + '"><a href="#">' +
                $(this).text() + '<span class="value">' + $(this).val() + '</span></a></li>');
            if (elStyle) {
                $("#" + id + " dd ul").find("li:last a").attr("style", elStyle);
            }
        });
        $obj.hide();
        return id;
    };
    $.fn.jgd = function() {};
    $.fn.jgd.isEven = function($num) {
        return ($num%2 === 0);
    };
    function get_id($obj) {
        var id = $obj.attr("id");
        if (id === "") {
            id = random_id();
        }
        return id;
    }
    function random_id() {
        var dt = new Date().getMilliseconds();
        var num = Math.random();
        var rnd = Math.round(num * 100000);
        return "jgd" + dt + rnd;
    }
    function debug($obj) {
        if (window.console && window.console.log) {
             window.console.log('jgd_dropdown: ' + $obj.size());
        }
    }
})(jQuery);
