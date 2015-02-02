/*function show_calendar()
{
    var $j = jQuery.noConflict(); 
    
    $j("#change_block").slideToggle();
}
function delete_date(id,url)
{
    if(id == 0)
        {
             new Ajax.Request(url, {
                    method: 'post',
                    parameters: { date_id: id  },
                    onComplete: function(data) {
                        jQuery.noConflict();
                       jQuery(".date_list").html(data.responseText);
                    }
                    });
        }
        else
            {                         
                if(confirm("Do you want to delete this date from holidays?"))
                {
                    new Ajax.Request(url, {
                    method: 'post',
                    parameters: { date_id: id  },
                    onComplete: function(data) {
                        jQuery.noConflict();
                       jQuery(".date_list").html(data.responseText);
                    }
                    });
                }
            }
}
function get_dates_without(date_id,url)
{
    new Ajax.Request(url, {
                    method: 'post',
                    parameters: { id: date_id  },
                    onComplete: function(data) {
                  //    alert(data.responseText);
                  console.log(data);
                    }
                    });
}*/


