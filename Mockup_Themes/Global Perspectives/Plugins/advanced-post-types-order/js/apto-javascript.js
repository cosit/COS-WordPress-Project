
    function toggle_thumbnails()
        {
            jQuery('#sortable .post_type_thumbnail').toggle();        
        }
        
    function apto_change_taxonomy(element, is_archive)
        {
            //select the default category (0)
            if (is_archive === true)
                {
                    jQuery('#apto_form #cat').remove();   
                }
                else
                {
                    jQuery('#apto_form #cat').val(jQuery("#apto_form #cat option:first").val());        
                }
            jQuery('#apto_form').submit();
        }
        
    function apto_change_post_type(element)
        {
            var menu_post_type = jQuery('#apto_form').find('input#apto_post_type').val();
            var post_type = jQuery(element).val();
            
            var new_url = 'edit.php?post_type='+menu_post_type+'&page=order-post-types-'+menu_post_type+'&selected_post_type='+post_type;
            
            window.location = new_url;
        }
