<?php

    /**
    * @desc 
    * 
    * Return UserLevel
    * 
    */
    function userdata_get_user_level($return_as_numeric = FALSE)
        {
            global $userdata;
            
            $user_level = '';
            for ($i=10; $i >= 0;$i--)
                {
                    if (current_user_can('level_' . $i) === TRUE)
                        {
                            $user_level = $i;
                            if ($return_as_numeric === FALSE)
                                $user_level = 'level_'.$i; 
                            break;
                        }    
                }        
            return ($user_level);
        }    
        
    
    /**
    * @desc 
    * 
    * Reset Order for given post type
    * 
    */
    function reset_post_order($post_type, $cat, $current_taxonomy)
        {
            global $wpdb, $blog_id;
            
            $post_type_info = get_post_type_object($post_type);
            
            if ($post_type_info->hierarchical === TRUE && $cat == '-1' && $current_taxonomy == '_archive_')
                {
                    //this is a hirarhical which is being saved as default wp_posts order
                    $query = "UPDATE `". $wpdb->base_prefix ."posts`
                                SET menu_order = 0
                                WHERE `post_type` = '".$post_type ."'";
                     $result = $wpdb->get_results($query);   
                }
                else
                {
                    $lang = apto_get_blog_language(); 
                    
                    $query = "DELETE FROM `". $wpdb->base_prefix ."apto`
                                WHERE `post_type` = '".$post_type ."' AND `term_id` = '". $cat ."' AND `taxonomy` = '". $current_taxonomy ."' AND `blog_id` = ".$blog_id . " AND `lang` = '".$lang."'";
                    $result = $wpdb->get_results($query); 
                }          
        } 
    
    /**
    * @desc 
    * 
    * Check the latest plugin version
    * 
    */
    function cpto_create_plugin_tables()
        {
            $options = get_option('cpto_options');
            
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            global $wpdb;
            
            $query = "CREATE TABLE ". $wpdb->base_prefix ."apto (
                          id int(11) NOT NULL AUTO_INCREMENT,
                          blog_id int(11) NOT NULL default '1',
                          post_id int(11) NOT NULL,
                          term_id int(11) NOT NULL,
                          post_type varchar(128) NOT NULL,
                          taxonomy varchar(128) NOT NULL,
                          lang varchar(3) NOT NULL default 'en',
                          PRIMARY KEY  (id),
                          KEY term_id (term_id),
                          KEY post_type (post_type),
                          KEY taxonomy (taxonomy)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
            dbDelta($query);
            
            $options['apto_tables_created'] = TRUE;
            update_option('cpto_options', $options); 
        }
    
    /**
    * 
    * return the order by
    * 
    */
    function apto_get_orderby($orderBy, $query)
        {
            global $wpdb;
            
            $options = get_option('cpto_options');
            
            if (isset($query->query_vars['post_type']))
                {
                    $post_type = is_array($query->query_vars['post_type']) ? $query->query_vars['post_type'][0] : $query->query_vars['post_type'];   
                }
                else $post_type = '';
            $taxonomy   = isset($query->query_vars['taxonomy']) ? $query->query_vars['taxonomy'] : '';

            if ($taxonomy == '')
                {
                    $taxonomy = apto_get_query_taxonomy($query);
                }
            
        
            if ($taxonomy != '' && $post_type == '')
                {
                    //try to identify the post_type, get the first assigned to that taxonomy
                    $post_types = get_post_types();
                    foreach( $post_types as $post_type_name ) 
                        {
                            if (is_object_in_taxonomy($post_type_name, $taxonomy) === TRUE)
                                {
                                    //use only if is not in the ignore list
                                    if (isset($options['allow_post_types']) && !in_array($post_type_name, $options['allow_post_types']))
                                        continue; 
                                        
                                    $post_type = $post_type_name;
                                    break;
                                }
                        }   
                }
        
                
            if ($post_type == '')
                $post_type = 'post';

            if ($taxonomy == '')
                $taxonomy = '_archive_';
            
            //pageline fix
            if ($post_type != '' && !post_type_exists($post_type))
                return $orderBy;

            if ($post_type != '')
                $post_type_info = get_post_type_object($post_type);
            
            //check if it's hiearhical and _archive_ to use the default in wp_posts in that case
            if ($taxonomy == '_archive_' && $post_type_info->hierarchical)
                {
                    return  "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";
                }

            $term_id = -1;
            if ($taxonomy != '' && $taxonomy != '_archive_' && isset($query->tax_query->queries[0]['terms']))
                {
                    //cat update
                    if (isset($query->query['cat']) && $query->query['cat'] > 0)
                        {
                            $term_id = $query->query['cat'];
                        }
                         
                    else if (count($query->tax_query->queries[0]['terms']) === 1)
                        {
                            if(isset($query->tax_query->queries[0]['field']))
                                {
                                    switch ($query->tax_query->queries[0]['field'])
                                        {
                                            case 'term_id':
                                            case 'id':
                                                        $term_id    = $query->tax_query->queries[0]['terms'][0];
                                                        break;
                                            case 'slug':
                                                        $term_data  = get_term_by('slug', $query->tax_query->queries[0]['terms'][0], $taxonomy);    
                                                        $term_id    = $term_data->term_id;
                                                        break;
                                        }
                                }
                                else
                                {
                                    //try to identify   
                                    preg_match("|\d+|",$query->tax_query->queries[0]['terms'][0], $_found);
                                    if (is_array($_found) && count($_found) > 0)
                                        {
                                            $_terms_0 = $_found[0];
                                            if ($_terms_0 == $query->tax_query->queries[0]['terms'][0])
                                                $term_id    = $query->tax_query->queries[0]['terms'][0];
                                                else
                                                    {
                                                        $term_data  = get_term_by('slug', $query->tax_query->queries[0]['terms'][0], $taxonomy);    
                                                        $term_id    = $term_data->term_id;
                                                    }
                                        }
                                        else
                                            {
                                                //unable to identify
                                                $taxonomy   =   '_archive_';
                                                $term_id    =   '';   
                                            }
                                }
                        }
                     
                     //this needs multiple terms order, use _archive_instead   
                     else if (count($query->tax_query->queries[0]['terms']) > 1)
                        {
                            $taxonomy   =   '_archive_';
                            $term_id    =   '';
                        }
                    
                    
                }
            
            //build the order list
            $order_list  = apto_get_order_list($post_type, $term_id, $taxonomy);
                        
            if (count($order_list) > 0 )
                $orderBy = "FIELD(".$wpdb->posts.".ID, ". implode(",", $order_list) ."), ".$wpdb->posts.".post_date DESC";
                else    
                $orderBy = $wpdb->posts.".post_date DESC";
                
            return($orderBy);   
            
        }
    
    /**
    * 
    *  Try to identify if there is a taxonomy query
    */
    function apto_get_query_taxonomy($query)
        {
            //check for category tax
            if ($query->query_vars['cat'] != '' || $query->query_vars['category_name'] != '' || (is_array($query->query_vars['category__in']) && count($query->query_vars['category__in']) > 0) || (is_array($query->query_vars['category__and']) && count($query->query_vars['category__and']) > 0))
                return 'category';
            
            if (isset($query->query_vars['tax_query'][0]['taxonomy']))
                {
                    $taxonomy = $query->query_vars['tax_query'][0]['taxonomy'];
                    return $taxonomy;
                }
                
            return '';
        }
    
    /**
    * 
    *  Get Order List
    * 
    */
    function apto_get_order_list($post_type, $term_id = '-1', $taxonomy = '_archive_')
        {
            $order_list = array();
            
            global $wpdb, $blog_id;
            
            if ($term_id == '' || $term_id === FALSE)
                $term_id = -1;
            
            if ($taxonomy == '' || $taxonomy === FALSE)
                $taxonomy = '_archive_';
                
            if ($post_type == '' && $taxonomy == "_archive_")
                {
                    $post_type = 'post';
                }
            
            $query = "SELECT post_id FROM `". $wpdb->base_prefix ."apto` WHERE `blog_id` = " . $blog_id;
            if ($post_type !== '')
                $query .= " AND `post_type` = '".$post_type."'";
            if ($term_id !== '')
                $query .= " AND `term_id` = '".$term_id."'";
            if ($taxonomy !== '')
                $query .= " AND `taxonomy` = '".$taxonomy."'";
                
            //apply language if WPML deployed
            $lang = apto_get_blog_language();
            if ($lang != '')
                $query .= " AND `lang` = '".$lang."'";
               
            $query .= " ORDER BY id ASC";
            
            $results = $wpdb->get_results($query);
            
            foreach ($results as $result)
                $order_list[] = $result->post_id;
            
            
            $order_list = apply_filters('apto_get_order_list', $order_list);
            
            return $order_list;   
        }
        
        
    /**
    * 
    * Get first term of a category
    * 
    */
    function cpto_get_first_term($taxonomy)
        {
            $argv = array(
                            'hide_empty'        => 0, 
                            'hierarchical'      => 1,
                            'show_count'        => 1, 
                            'orderby'           => 'name', 
                            'taxonomy'          =>  $taxonomy
                            );
            
            $terms = get_terms( $taxonomy, $argv );
            
            //find first term with parent = 0
            for ($i = 0; $i <= count($terms); $i++)
                {
                    if ($terms[$i]->parent == 0)
                        return $terms[$i]->term_id;       
                } 
            
            return FALSE;
        }
    
    /**
    * 
    * Filter to return the posts for the given interval
    * 
    * timestamp in unix format
    * 
    */
    function apto_filter_posts_where_interval($where)
        {
            global $_apto_filter_posts_where_interval_after_time, $_apto_filter_posts_where_interval_before_time;
            
            if ($_apto_filter_posts_where_interval_after_time == '')
                return $where;
            
            if ($_apto_filter_posts_where_interval_before_time == '')
                $_apto_filter_posts_where_interval_before_time = strtotime('+1 day');
                
            $where .= " AND post_date >= '" . date('Y-m-d', $_apto_filter_posts_where_interval_after_time) . "' AND post_date <= '" . date('Y-m-d', $_apto_filter_posts_where_interval_before_time) . "'";
            
            return $where;   
        }
    
    /**
    * 
    * Return the burrent blog language
    * This check for WPMU install
    * 
    */
    function apto_get_blog_language()
        {
            $lang = '';
            
            //check if WPML is active
            if (defined('ICL_LANGUAGE_CODE'))
                {
                    $lang = ICL_LANGUAGE_CODE;
                }
            
            if ($lang == '')
                $lang = 'en';
            
            return $lang;   
        }
    
        
    /**
    * @desc 
    * 
    * Check the latest plugin version
    * 
    */
    function cpto_check_plugin_version($plugin)
        {
            if( strpos( CPTPATH . '/advanced-post-types-order.php', $plugin ) !== FALSE )
                {
                    //check last update check attempt
                    $last_check = get_option('acpto_last_version_check');
                    if (is_numeric($last_check) && (time() - 60*60*12) > $last_check)
                        {
                            $last_version_data = wp_remote_fopen(CPT_VERSION_CHECK_URL);
                            update_option('acpto_last_version_check_data', $last_version_data);    
                        }
                        else
                            {
                                $last_version_data = get_option('acpto_last_version_check_data');  
                            }
                    
                    if($last_version_data !== FALSE && $last_version_data != '') 
                        {
                            $info_raw = explode( '/',$last_version_data );
                            $info = array();
                            foreach ($info_raw as $line)
                                {
                                    list($name, $value)= explode("=", $line);
                                    $info[$name] = $value;
                                }
                                
                            if( ( version_compare( strval( $info['version'] ), CPTVERSION , '>' ) == 1 ) ) 
                                {
                                    ?>
                                        <tr class="plugin-update-tr">
                                            <td colspan="3" class="plugin-update colspanchange">
                                                <div class="update-message"><?php _e( "There is a new version of Advanced Post Types Order. Use your purchase link to update or contact us if you lost it.", 'apto' ) ?></div>
                                            </td>
                                        </tr>
                                    <?php
                                } 
                        }
                        
                    //update last version check attempt
                    update_option('acpto_last_version_check', time());
                }   
            
        }
        
        
        
    function cpto_get_previous_post_where($where, $in_same_cat, $excluded_categories)
        {
            global $post;
            
            //fetch the order for the current post type 
            add_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            $posts_order = apto_get_order_list($post->post_type);
            remove_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            
            //check if there is no defined order
            if (count($posts_order) == 0)
                return $where;
                
            $where = '';
            
            return $where;
        }
        
    function cpto_get_previous_post_sort($sort)
        {
            add_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            $sort = apto_get_adjacent_post_sort(TRUE, $sort);
            remove_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            
            return $sort;
        }

    function cpto_get_next_post_where($where, $in_same_cat, $excluded_categories)
        {
            global $post;
            
            //fetch the order for the current post type
            add_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter'); 
            $posts_order = apto_get_order_list($post->post_type);
            remove_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            
            //check if there is no defined order
            if (count($posts_order) == 0)
                return $where; 
            
            $where = '';
            
            return $where;
        }

    function cpto_get_next_post_sort($sort)
        {
            add_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            $sort = apto_get_adjacent_post_sort(FALSE, $sort);
            remove_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
            
            return $sort;    
        }
        
    function apto_get_adjacent_post_sort($previous = TRUE, $sort)
        {
            global $post, $wpdb, $blog_id;
            
            $options = get_option('cpto_options');
                
            //check if the current post_type is active in the setings
            if (isset($options['allow_post_types']) && !in_array($post->post_type, $options['allow_post_types']))
                return $sort;

            $post_type = $post->post_type;
                
            //fetch the order for the current post type 
            $term_id = -1;
            $taxonomy = '_archive_';
            $posts_order = apto_get_order_list($post->post_type, $term_id, $taxonomy);
            
            //check if there is no defined order
            if (count($posts_order) == 0)
                return $sort; 
            
            //get the current element key
            $current_position_key = array_search($post->ID, $posts_order);
            
            if ($previous === TRUE)
                $required_index = $current_position_key + 1;
                else
                $required_index = $current_position_key - 1;
            
            //check if there is another position after the current in the list
            if (isset($posts_order[ ($required_index) ]))
                {
                    //found
                    $sort = 'ORDER BY FIELD(p.ID, "'. $posts_order[ ($required_index) ] .'") DESC LIMIT 1 ';   
                }
                else
                {
                    //not found 
                    $sort = 'ORDER BY p.post_date DESC LIMIT 0';  
                }
   
            return $sort;
        
        
        } 
    
    /**
    * Enhanced post adjancent links
    * 
    * @param mixed $format
    * @param mixed $link
    * @param mixed $ignore_custom_sort
    * Ignore the custom order if defined
    * 
    * @param mixed $in_term
    * Provide a term_id if the links should be returned for other post types in the same term_id. The $in_taxonomy is require along with
    * 
    * @param mixed $in_taxonomy
    * Provide a taxonomy name if the links should be returned for other post types in the same term_id. The $in_taxonomy is require along with
    * 
    * @return mixed
    */
    function previous_post_type_link($format='&laquo; %link', $link='%title', $ignore_custom_sort = FALSE, $term_id = '', $taxonomy = '')
        {
            adjacent_post_type_link($format, $link, $ignore_custom_sort, $term_id, $taxonomy, TRUE);   
        }
        
    /**
    * Enhanced post adjancent links
    * 
    * @param mixed $format
    * @param mixed $link
    * @param mixed $ignore_custom_sort
    * Ignore the custom order if defined
    * 
    * @param mixed $in_term
    * Provide a term_id if the links should be returned for other post types in the same term_id. The $in_taxonomy is require along with
    * 
    * @param mixed $in_taxonomy
    * Provide a taxonomy name if the links should be returned for other post types in the same term_id. The $in_taxonomy is require along with
    * 
    * @return mixed
    */
    function next_post_type_link($format='&laquo; %link', $link='%title', $ignore_custom_sort = FALSE, $term_id = '', $taxonomy = '')
        {
            adjacent_post_type_link($format, $link, $ignore_custom_sort, $term_id, $taxonomy, FALSE);   
        }
    
    
    function adjacent_post_type_link($format, $link, $ignore_custom_sort = FALSE, $term_id = '', $taxonomy = '', $previous = TRUE) 
        {
            if ( $previous && is_attachment() )
                $post = & get_post($GLOBALS['post']->post_parent);
                else
                $post = apto_get_adjacent_post($ignore_custom_sort, $term_id, $taxonomy, $previous);

            if ( !$post )
                return;

            $title = $post->post_title;

            if ( empty($post->post_title) )
            $title = $previous ? __('Previous Post') : __('Next Post');

            $title = apply_filters('the_title', $title, $post->ID);
            $date = mysql2date(get_option('date_format'), $post->post_date);
            $rel = $previous ? 'prev' : 'next';

            $string = '<a href="'.get_permalink($post).'" rel="'.$rel.'">';
            $link = str_replace('%title', $title, $link);
            $link = str_replace('%date', $date, $link);
            $link = $string . $link . '</a>';

            $format = str_replace('%link', $link, $format);

            $adjacent = $previous ? 'previous' : 'next';
            echo apply_filters( "{$adjacent}_post_link", $format, $link );
        }
        
        
    function apto_get_adjacent_post( $ignore_custom_sort = FALSE, $term_id = '', $taxonomy = '', $previous = TRUE ) 
        {
            global $post, $wpdb;
            
            if ( empty( $post ) )
                return null;
            
            $posts_order = array();
            
            if ($ignore_custom_sort !== TRUE)
                {
                    //fetch the order for the current post type 
                    add_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
                    $posts_order = apto_get_order_list($post->post_type, $term_id, $taxonomy);
                    remove_filter('apto_get_order_list', 'apto_get_order_list_post_status_filter');
                }
            
            if ($ignore_custom_sort === TRUE || count($posts_order) == 0)
                {
    
                    $current_post_date = $post->post_date;
                    
                    $in_same_cat = false;
                    $excluded_categories = '';
                    
                    $adjacent = $previous ? 'previous' : 'next';
                    $op = $previous ? '<' : '>';
                    $order = $previous ? 'DESC' : 'ASC';
                    
                    $join = $where = $sort = $group = '';
                    
                    $where = $wpdb->prepare(" WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish'", $current_post_date, $post->post_type);
                    
                    if ($term_id != '' && $taxonomy != '')
                        {
                            $join  = $wpdb->prepare(" INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id "); 
                            
                            $children = array();
                            $children = array_merge( $children, get_term_children( $term_id, $taxonomy ) );
                            $children[] = $term_id;
                            
                            $where .= " AND ( tr.term_taxonomy_id IN (". implode(",", $children) .") ) ";
                            $group = $wpdb->prepare(" GROUP BY p.ID");  
                        }

                    $sort =  $wpdb->prepare(" ORDER BY p.post_date $order LIMIT 1");
                    
                    $join  = apply_filters( "get_{$adjacent}_post_type_join", $join, $term_id, $taxonomy );
                    $where = apply_filters( "get_{$adjacent}_post_type_where", $where, $term_id, $taxonomy);
                    $group = apply_filters( "get_{$adjacent}_post_type_group", $group, $term_id, $taxonomy);
                    $sort  = apply_filters( "get_{$adjacent}_post_type_sort", $sort, $term_id, $taxonomy);
 
                    $query = "SELECT p.* FROM $wpdb->posts AS p $join $where $group $sort";
                    $query_key = 'adjacent_post_type_' . md5($query);
                    $result = wp_cache_get($query_key, 'counts');
                    if ( false !== $result )
                        return $result;

                    $result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $group $sort");
                    if ( null === $result )
                        $result = '';

                    wp_cache_set($query_key, $result, 'counts');
                    return $result;
                }

            //get the current element key
            $current_position_key = array_search($post->ID, $posts_order);
            
            if ($previous === TRUE)
                $required_index = $current_position_key + 1;
                else
                $required_index = $current_position_key - 1;
            
            //check if there is another position after the current in the list
            if (isset($posts_order[ ($required_index) ]))
                {
                    //found
                    $sort = 'ORDER BY FIELD(p.ID, "'. $posts_order[ ($required_index) ] .'") DESC LIMIT 1 ';   
                }
                else
                {
                    //not found 
                    $sort = 'ORDER BY p.post_date DESC LIMIT 0';  
                }

            $adjacent = $previous ? 'previous' : 'next';
            $join = $where = '';
            
            $join  = apply_filters( "get_{$adjacent}_post_type_join",   $join,  $term_id, $taxonomy );
            $where = apply_filters( "get_{$adjacent}_post_type_where",  $where, $term_id, $taxonomy );
            $sort  = apply_filters( "get_{$adjacent}_post_type_sort",   $sort,  $term_id, $taxonomy);

            $query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
            $query_key = 'adjacent_post_type_' . md5($query);
            $result = wp_cache_get($query_key, 'counts');
            if ( false !== $result )
                return $result;

            $result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
            if ( null === $result )
                $result = '';

            wp_cache_set($query_key, $result, 'counts');
            return $result;
        }
        
    
    function apto_get_order_list_post_status_filter($order_list)
        {
            if (count($order_list) == 0)
                return $order_list;
            
            global $wpdb;
                
            $allow_post_status = array (
                                        'publish'
                                            );
            
            $query = "SELECT ID FROM " . $wpdb->posts ." 
                        WHERE ID IN (".implode(",", $order_list).") AND post_status IN ('". implode("','", $allow_post_status) ."')
                        ORDER BY FIELD(".$wpdb->posts.".ID, ". implode(",", $order_list) .")";
            $results = $wpdb->get_results($query); 
            
            $order_list = array();
            
            foreach ($results as $result)
                $order_list[] = $result->ID;
            
            return $order_list;   
        }
    
    /**
    * Update the order of the archive/taxonomy for this post type to make sure it's always in top of the list as is the latest
    * 
    * @param mixed $post_ID
    * @param mixed $post
    */
    function apto_wp_insert_post($post_ID, $post)
        {
            if (wp_is_post_revision($post_ID))
                return;   
            
            if ($post->post_status != 'publish')
                return;
            
            global $wpdb, $blog_id;
            
            $lang = apto_get_blog_language();
            $post_type_data = get_post_type_object($post->post_type);

            //put the post type in the top of the archive list if thre is a custom order defined list
            $posts_order = apto_get_order_list($post->post_type, "-1", "_archive_");
            if (count($posts_order) > 0 && array_search($post_ID, $posts_order) === FALSE && $post_type_data->hierarchical === FALSE)
                {
                    //remove the current order
                    $query = "DELETE FROM `". $wpdb->base_prefix ."apto`
                                WHERE `post_type` = '".$post->post_type ."' AND `term_id` = '-1' AND `taxonomy` = '_archive_' AND `blog_id` = ".$blog_id . " AND `lang` = '".$lang."'";
                    $result = $wpdb->get_results($query);
                    
                    array_unshift($posts_order, $post_ID);
                    
                    //add the list
                    $position = 0;
                    foreach( $posts_order as $list_post_ID ) 
                        {
                            //maintain the simple order 
                            $wpdb->update( $wpdb->posts, array('menu_order' => ($position + 1)), array('ID' => $post_ID) );
                            
                            $query = "INSERT INTO `". $wpdb->base_prefix ."apto` 
                                        (`post_id`, `term_id`, `post_type`, `taxonomy`, `blog_id`, `lang`) 
                                        VALUES ('".$list_post_ID."', '-1', '".$post->post_type."', '_archive_', ".$blog_id.", '".$lang."');"; 
                            $results = $wpdb->get_results($query);
                        }
                }
            
            $object_taxonomies = get_object_taxonomies($post->post_type);
            if (count($object_taxonomies) === 0)
                return;
            
            //retrieve the terms for each taxonomy that the current post belong
            foreach ($object_taxonomies as $object_taxonomy)
                {
                    $object_terms = wp_get_object_terms($post_ID, $object_taxonomy);
                    if (count($object_terms) > 0)
                        {
                            foreach ($object_terms as $main_object_term)
                                {
                                    //we need to process all child terms too
                                    $children = array();
                                    $children = array_merge( $children, get_term_children( $main_object_term->term_id, $object_taxonomy ) );
                                    $children[] = $main_object_term->term_id;
                                    
                                    foreach ($children as $object_term)
                                    //put the post type in the top of the archive list if thre is a custom order defined list
                                    $posts_order = apto_get_order_list($post->post_type, $object_term, $object_taxonomy);
                                    if (count($posts_order) > 0 && array_search($post_ID, $posts_order) === FALSE)
                                        {
                                            //remove the current order
                                            $query = "DELETE FROM `". $wpdb->base_prefix ."apto`
                                                        WHERE `post_type` = '".$post->post_type ."' AND `term_id` = '".$object_term."' AND `taxonomy` = '".$object_taxonomy."' AND `blog_id` = ".$blog_id . " AND `lang` = '".$lang."'";
                                            $result = $wpdb->get_results($query);
                                            
                                            array_unshift($posts_order, $post_ID);
                                            
                                            //add the list
                                            $position = 0;
                                            foreach( $posts_order as $list_post_ID ) 
                                                {
                                                    //maintain the simple order 
                                                    $wpdb->update( $wpdb->posts, array('menu_order' => ($position + 1)), array('ID' => $post_ID) );
                                                    
                                                    $query = "INSERT INTO `". $wpdb->base_prefix ."apto` 
                                                                (`post_id`, `term_id`, `post_type`, `taxonomy`, `blog_id`, `lang`) 
                                                                VALUES ('".$list_post_ID."', '".$object_term."', '".$post->post_type."', '".$object_taxonomy."', ".$blog_id.", '".$lang."');"; 
                                                    $results = $wpdb->get_results($query);
                                                }
                                        }
                                } 
                        }
                }
        }
  
?>