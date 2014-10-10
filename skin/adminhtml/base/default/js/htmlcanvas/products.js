jQuery.noConflict();

function viewProductsByCategory(select)
{
    if(select.val() > 0)
    {
        jQuery('.productsList').hide();
        jQuery('#productsList' + select.val()).show();
    }
    else
        jQuery('.productsList').show();
}