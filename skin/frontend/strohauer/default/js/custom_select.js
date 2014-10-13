jQuery.noConflict();

function reselect(select, addclass, wrap_link ) {

    jQuery(select).each( function(){

        var $this = jQuery(this);

        addclass = typeof(addclass) != 'undefined' ? addclass : '';
        jQuery($this).wrap('<div class="sel_wrap ' + addclass + '"/>');

        var sel_options = '',
            selected_option = false;

        jQuery($this).children('option').each(function() {

            if(jQuery(this).is(':selected')) selected_option = jQuery(this).index();

                if ( wrap_link ){
                    sel_options = sel_options + '<a class="sel_option" href="' + jQuery(this).val() + '">' + jQuery(this).html() + '</a>';
                } else {
                    sel_options = sel_options + '<div class="sel_option" value="' + jQuery(this).val() + '">' + jQuery(this).html() + '</div>';
                }

        });

        var sel_imul = '<div class="sel_imul">\
                    <div class="sel_selected">\
                        <div class="selected-text">' + jQuery($this).children('option').eq(selected_option).html() + '</div>\
                        <div class="sel_arraw"></div>\
                    </div>\
                    <div class="sel_options">' + sel_options + '</div>\
                </div>';

        jQuery($this).before(sel_imul);

    })
}

jQuery('.sel_imul').live('click', function() {

    jQuery('.sel_imul').removeClass('act');
    jQuery(this).addClass('act');

    if (jQuery(this).children('.sel_options').is(':visible')) {
        jQuery('.sel_options').hide();
    }
    else {
        jQuery('.sel_options').hide();
        jQuery(this).children('.sel_options').show();
    }

});

jQuery('.sel_option').live('click', function() {

    var tektext = jQuery(this).html();
    jQuery(this).parent('.sel_options').parent('.sel_imul').children('.sel_selected').children('.selected-text').html(tektext);

    jQuery(this).parent('.sel_options').children('.sel_option').removeClass('sel_ed');
    jQuery(this).addClass('sel_ed');



    var tekval = jQuery(this).attr('value');
    tekval = typeof(tekval) != 'undefined' ? tekval : tektext;
    jQuery(this).parent('.sel_options').parent('.sel_imul').parent('.sel_wrap').children('select').children('option').removeAttr('selected').each(function() {
        if (jQuery(this).val() == tekval) {

            jQuery(this).attr('selected', 'select');

        }
    });

    jQuery(this).parents('.sel_wrap').find('select').change();

});

var selenter = false;

jQuery('.sel_imul').live('mouseenter', function() {
    selenter = true;
});

jQuery('.sel_imul').live('mouseleave', function() {
    selenter = false;
});
jQuery(document).click(function() {
    if (!selenter) {
        jQuery('.sel_options').hide();
        jQuery('.sel_imul').removeClass('act');
    }

})
