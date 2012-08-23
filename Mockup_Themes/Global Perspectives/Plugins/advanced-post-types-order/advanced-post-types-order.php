<?php
/*
Plugin Name: Advanced Post Types Order
Plugin URI: http://www.nsp-code.com
Description: Order Post Types Objects using a Drag and Drop Sortable javascript capability
Author: Nsp Code
Author URI: http://www.nsp-code.com 
Version: 2.5.1.3
*/

define('CPTPATH',   plugin_dir_path(__FILE__));
define('CPTURL',    plugins_url('', __FILE__));

define('CPTVERSION', '2.5.1.3');
define('CPT_VERSION_CHECK_URL', 'http://www.nsp-code.com/version-check/vcheck.php?app=advanced-post-types-order-v2');

load_plugin_textdomain('apto', FALSE, CPTPATH. "lang/");

include_once(CPTPATH . '/include/functions.php');

register_deactivation_hook(__FILE__, 'CPTO_deactivated');
register_activation_hook(__FILE__, 'CPTO_activated');

function CPTO_activated() 
    {
        cpto_create_plugin_tables();
        
        //make sure the vars are set as default
        $options = get_option('cpto_options');
        if (!isset($options['autosort']))
            $options['autosort'] = '1';
            
        if (!isset($options['adminsort']))
            $options['adminsort'] = '1';
            
        if (!isset($options['level']))
            $options['level'] = 8;
            
        if (!isset($options['code_version']))
            $options['code_version'] = CPTVERSION;
            
        update_option('cpto_options', $options);

    }

function CPTO_deactivated() 
    {
        
    }
    
add_action('admin_print_scripts', 'CPTO_admin_scripts');
function CPTO_admin_scripts()
    {
        wp_enqueue_script('jquery'); 
        
        if (!isset($_GET['page']))
            return;
        
        if (isset($_GET['page']) && strpos($_GET['page'], 'order-post-types-') === FALSE)
            return;
           
        $myJavascriptFile = CPTURL . '/js/interface.js';
        wp_register_script('interface.js', $myJavascriptFile);
        wp_enqueue_script( 'interface.js');

        
        $myJavascriptFile = CPTURL . '/js/inestedsortable.js';
        wp_register_script('inestedsortable.js', $myJavascriptFile);
        wp_enqueue_script( 'inestedsortable.js');
        
        $myJavascriptFile = CPTURL . '/js/apto-javascript.js';
        wp_register_script('apto-javascript.js', $myJavascriptFile);
        wp_enqueue_script( 'apto-javascript.js');
           
    }


add_filter('pre_get_posts', 'CPTO_pre_get_posts');
function CPTO_pre_get_posts($query)
    {
        //check for the force_no_custom_order param
        if (isset($query->query_vars['force_no_custom_order']) && $query->query_vars['force_no_custom_order'] === TRUE)
            return $query;
            
        $options = get_option('cpto_options');
        if (is_admin())
            {
                //no need if it's admin interface
                return false;   
            }
        //if auto sort    
        if ($options['autosort'] > 0)
            {
                //check if the current post_type is active in the setings
                if (isset($options['allow_post_types']) && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] != '')
                    {
                        if (is_array($query->query_vars['post_type']))
                            {
                                if (count($query->query_vars['post_type']) > 1)
                                    return $query;
                                
                                $_post_type = $query->query_vars['post_type'][0];
                            }
                            else
                            {
                                $_post_type = $query->query_vars['post_type'];   
                            }

                        if (!in_array($_post_type, $options['allow_post_types']))
                            return $query;
                        unset ($_post_type);
                    }
                
                //remove the supresed filters;
                if (isset($query->query['suppress_filters']))
                    $query->query['suppress_filters'] = FALSE;    
                
                if (isset($query->query_vars['suppress_filters']))
                    //$query->query_vars['suppress_filters'] = FALSE;
                    
                //update the sticky if required or not
                if (isset($options['ignore_sticky_posts']) && $options['ignore_sticky_posts'] == "1")
                    {
                        if (!isset($query->query_vars['ignore_sticky_posts']))
                            $query->query_vars['ignore_sticky_posts'] = TRUE;
                    }
            }
            
        return $query;
    }

add_filter('posts_orderby', 'CPTOrderPosts', 99, 2);
function CPTOrderPosts($orderBy, $query) 
    {
        //check for the force_no_custom_order param
        if (isset($query->query_vars['force_no_custom_order']) && $query->query_vars['force_no_custom_order'] === TRUE)
            return $orderBy;
        
        global $wpdb;
        
        $options = get_option('cpto_options');
        
        //check if menu_order provided
        if (isset($query->query['orderby']) && $query->query['orderby'] == 'menu_order')
            {
                $orderBy = apto_get_orderby($orderBy, $query);
                    
                return($orderBy);   
            }
        
        if (is_admin())
                {
                    if (!isset($options['adminsort']) || (isset($options['adminsort']) && $options['adminsort'] == "1"))
                        {
                            //only return custom sort if there is not a column sort
                            if (!isset($_GET['orderby']))
                                $orderBy = apto_get_orderby($orderBy, $query);
                                
                            return($orderBy);
                        }
                }
            else
                {
                    //check if the current post_type is active in the setings
                     if (isset($options['allow_post_types']) && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] != '')
                        {
                            if (is_array($query->query_vars['post_type']))
                                {
                                    //check if it's a multiple posts types order, currently not implemented
                                    if (count($query->query_vars['post_type']) > 1)
                                        return $orderBy;
                                    
                                    $_post_type = $query->query_vars['post_type'][0];
                                }
                                else
                                {
                                    $_post_type = $query->query_vars['post_type'];   
                                }

                            if (!in_array($_post_type, $options['allow_post_types']))
                                return $orderBy;
                            unset ($_post_type);
                        }
                    
                    //check if is feed
                    if (is_feed())
                        {
                            if ($options['feedsort'] != "1")
                                return $orderBy;
                                
                            //else use the set order
                            $orderBy = apto_get_orderby($orderBy, $query);
                            
                            return($orderBy);
                        }
                    
                    
                    if ($options['autosort'] == "1")
                        {
                            //$orderBy = "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";  
                            $orderBy = apto_get_orderby($orderBy, $query);
                                
                            return($orderBy);
                        }
                    if ($options['autosort'] == "2")
                        {
                            //check if the user didn't requested another order
                            if (!isset($query->query['orderby']))
                                {
                                    //$orderBy = "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";  
                                    $orderBy = apto_get_orderby($orderBy, $query);   
                                }
                        }
                }

        return($orderBy);
    }
    
    
add_action('wp_loaded', 'initCPTO' );
add_action('admin_menu', 'cpto_plugin_menu', 1);
add_action('plugins_loaded', 'cpto_load_textdomain', 2 );
add_action('wp_insert_post', 'apto_wp_insert_post', 10, 2);


function cpto_load_textdomain() 
    {
        $locale = get_locale();
        $mofile = CPTPATH . '/lang/cpt-' . $locale . '.mo';
        if ( file_exists( $mofile ) ) {
            load_textdomain( 'cppt', $mofile );
        }
    }
  

function cpto_plugin_menu() 
    {
        include (CPTPATH . '/include/options.php');
        add_options_page('Post Types Order', '<img class="menu_pto" src="'. CPTURL .'/images/menu-icon.gif" alt="" />Post Types Order', 'manage_options', 'cpto-options', 'cpt_plugin_options');
    }
	
function initCPTO() 
    {
	    global $custom_post_type_order, $userdata;

        //make sure the vars are set as default
        $options = get_option('cpto_options');

        //compare if the version require update
        if (!isset($options['code_version']) || $options['code_version'] == '')
            {
                $options['code_version'] = 0.1;
                if (!isset($options['autosort']))
                    $options['autosort'] = '1';
                    
                if (!isset($options['adminsort']))
                    $options['adminsort'] = '1';
                    
                if (!isset($options['level']))
                    $options['level'] = 8;
                                
                update_option('cpto_options', $options);
            }
            
        if (version_compare( strval( CPTVERSION ), $options['code_version'] , '>' ) === TRUE )
            {
                //update the tables
                cpto_create_plugin_tables();
                
                //update the plugin version
                $options['code_version'] = CPTVERSION;
                update_option('cpto_options', $options);
            }

        if (is_admin())
            {
                //check for new version once per day
                add_action( 'after_plugin_row','cpto_check_plugin_version' );
                                
                if (isset($options['level']) && is_numeric($options['level']))
                    {
                        if (userdata_get_user_level(TRUE) >= $options['level'])
                            {
                                include(CPTPATH . '/include/reorder-class.php');
                                $custom_post_type_order = new ACPTO();
                            }
                    }
                    else
                        {
                            include(CPTPATH . '/include/reorder-class.php');
                            $custom_post_type_order = new ACPTO();
                        }
                        
                //backwards compatibility
                if( !isset($options['apto_tables_created']))
                    {
                        cpto_create_plugin_tables();   
                    }
            }
            
        if (isset($options['autosort']) &&  $options['autosort'] == '1') 
            {
                add_filter('get_next_post_where', 'cpto_get_next_post_where', 10, 3);
                add_filter('get_next_post_sort', 'cpto_get_next_post_sort');

                add_filter('get_previous_post_where', 'cpto_get_previous_post_where', 10, 3); 
                add_filter('get_previous_post_sort', 'cpto_get_previous_post_sort');
            }      
    }

?>