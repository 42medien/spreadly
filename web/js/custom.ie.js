$(function(){
    jQuery(document).ready(function($) {
        $('input:text').labelify({labelledClass: "labelinside-dark"}).focus().blur();
        $('textarea').labelify({labelledClass: "labelinside-light"}).focus().blur();
    });

    $('.tooltip').hover(
        function () {
            $(this).append($('<div class="triangle-down-ie"></div>'));
        },
        function () {
            $(this).find('.triangle-down-ie').remove();
        }
    );

    var inputs = $('.bg_checkbox input');
    inputs.live('change', function(){
        var ref = $(this),
            wrapper = ref.parent();
        if(ref.is(':checked')) wrapper.addClass('checked');
        else wrapper.removeClass('checked');
    });
    inputs.trigger('change');    
});
