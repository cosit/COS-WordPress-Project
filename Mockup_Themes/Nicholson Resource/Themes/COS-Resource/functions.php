<?php
/**
 * Starkers functions and definitions
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

/** Tell WordPress to run starkers_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'starkers_setup' );

// Do shortcodes in widgets, woohoo!
add_filter('widget_text', 'do_shortcode');

add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}

function filter_search($query) {    
    if ($query->is_search) {
	$query->set('post_type', array('post', 'pages', 'minutes', 'handbook'));
    };
    return $query;
};
if (!is_admin()){
	add_filter('pre_get_posts', 'filter_search');
}

// *********************************************
// COS JAVASCRIPT FILES
// *********************************************

function load_custom_script() {

    wp_register_script('modernizr', get_bloginfo('template_directory').'/js/modernizr-1.6.min.js');
    wp_enqueue_script('modernizr');

    wp_register_script('less', get_bloginfo('template_directory').'/js/less-1.2.2.min.js');
    wp_enqueue_script('less');

    //wp_register_script('jquery.ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js', false, '1.8.18');

    wp_enqueue_script('jquery.ui');
    wp_enqueue_script('jquery');

    if(is_home()){
    	wp_register_script('flexslider-min', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js');
    	wp_enqueue_script('flexslider-min');
    }

}

function load_custom_style() {	}

add_action('wp_print_scripts', 'load_custom_script');
add_action('wp_print_styles', 'load_custom_style');

//*********Google Analytics*********/
add_action('wp_head', 'add_googleanalytics');
function add_googleanalytics(){
	$analyticsCode = get_option('COS_Google_Analytics'); 
	?>
<!--- Google Analytics -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $analyticsCode; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--- End Google Analytics -->
<?}
/***********End Google Analytics************/

// *********************************************
// COS THEME OPTIONS
// *********************************************

function COS_themeoptions_admin_menu() {
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page("COS Theme Options", "COS Theme Options", 'edit_themes', basename(__FILE__), 'COS_themeoptions_page');
}

function COS_themeoptions_page() {
	// here is the main function that will generate our options page
	if ( $_POST['update_themeoptions'] == 'true' ) { COS_themeoptions_update(); } 

    ?>  
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

    <div class="wrap">  
        <div id="icon-themes" class="icon32"><br /></div>  
        <h2>COS Theme Options</h2>  
  
        <form method="POST" action="">  
            <input type="hidden" name="update_themeoptions" value="true" />  

            <?php $title_prefix = get_option('COS_title_prefix'); ?>
            <h3>Title Prefix: <em><?php echo $title_prefix; ?></em></h3>
            <select name="title_prefix" id="">
            	<option value="UCF" <?php if($title_prefix=='UCF') echo 'selected';?>>UCF</option>
            	<option value="COS" <?php if($title_prefix=='COS') echo 'selected';?>>COS</option>
            </select>

            <h4>Title Size</h4>
            <?php $title_size = get_option('COS_title_size') ?>
            <p><input type="text" name="title_size" id="title_size" value="<?php echo $title_size; ?>"></p>

			<h4>Sidebar Location</h4>
            <?php $sidebar_location = get_option('COS_sidebar_location') ?>
			<select name="sidebar_location" id="">
            	<option value="left" <?php if($sidebar_location =='left') echo 'selected';?>>Left</option>
            	<option value="right" <?php if($sidebar_location =='right') echo 'selected';?>>Right</option>
            </select>

            <?php $pagenav_type = get_option('COS_pagenav_type'); ?>
            <h4>Show navigation for custom menus in page sidebar?</h4>
            <input type="checkbox" name="pagenav_type" id="pagenav_type" value="custom" <?php if($pagenav_type=="custom"){echo "checked";}?>/>
            <span style="padding-left: 10px;">Yes (only check if this theme uses <em>custom</em> menus)</span><br />

            <?php $analyticsCode = get_option('COS_Google_Analytics'); ?>
            <h4 style="margin-bottom: 0px;">Google Analytics</h4>
            Enter your UA code:<br/>
            <input type="text" name="google_analytics" id="events_items" value="<?php echo $analyticsCode; ?>" >
  
            <p><input type="submit" name="search" value="Update Options" class="button" /></p>  
        </form>  
  
    </div>  
    <?php  

}

function COS_themeoptions_update() {
	// this is where validation would go
	update_option('COS_title_prefix', 	$_POST['title_prefix']);
	update_option('COS_title_size', 	$_POST['title_size']);
	update_option('COS_sidebar_location',   $_POST['sidebar_location']);
	update_option('COS_pagenav_type', 	$_POST['pagenav_type']);
	update_option('COS_Google_Analytics', $_POST['google_analytics']);

}
add_action('admin_menu', 'COS_themeoptions_admin_menu');


if ( ! function_exists( 'starkers_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * @since Starkers HTML5 3.0
 */

// Simple function for getting the excerpt of a body of text
// Takes in two parameters: $text = body of text, $cutoff = number of characters in excerpt
function excerpt( $text, $cutoff, $link='', $link_text="Read More" ){
	$excerptText = '';
	if( is_int($cutoff) && $cutoff > 0 ){
		$excerptText = substr( $text, 0, $cutoff ) == $text ? $text : substr( $text, 0, $cutoff ) . '...';
		if( $link != ''){
			$excerptText .= ' <a href="' . $link . '" class="readMore">' . $link_text . '</a>';
		}
	} else { return $text; }

	return $excerptText;
}

function custom_menu_nav( $pageID = 0, $menu_name = 'primary-menu' ){

	$args = array(
		'menu'            => $menu_name, 
		'menu_class'      => '', 
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => '',
	);

	echo '<nav class="pageNav" id="custom_menu_nav">';
	wp_nav_menu( $args );
	echo '</nav>';
}
add_action( 'custom_menu_nav', 'custom_menu_nav', 10, 1 );

function page_nav( $pageID = 0 ){
	$pageID = ($pageID == 0 ? get_the_ID() : $pageID);
	$parent = get_permalink( $pageID );

	$currentPage = get_post( $pageID );
	// Check if post/page is a child or a parent
	if( $currentPage->post_parent ){
		$children = wp_list_pages('title_li=&child_of='.$currentPage->post_parent.'&echo=0');
		$title = get_the_title( $currentPage->post_parent );
		$parent = get_permalink( $currentPage->post_parent );

	} else {
		$children = wp_list_pages('title_li=&child_of='.$pageID.'&echo=0');
		$title = get_the_title();
		
	}

	echo '<nav class="pageNav" id="page_nav"><h2><a href="'.$parent.'">'. $title . '</a></h2><ul>';
	echo $children;
	echo '</ul>';

	// Show news categories
	if( $title == 'News' ){
		echo '<ul>';
		echo wp_list_categories('title_li=');
		echo '</ul>';
	}

	echo '</nav>';
}
add_shortcode('page_nav', 'page_nav');

function people_nav( $pageID = '' ){
	$pageID = $pageID || get_the_ID();
	$term_id = get_query_var('term_id');
	$currentPage = get_post( $pageID );

	echo '<nav class="pageNav sidebar"><h2><a href="'.get_bloginfo('url').'/people/">People</a></h2><ul>';
	echo show_people_cats( false );
	echo '</ul></nav>';
}
add_shortcode('people_nav', 'people_nav');

/***
 * Add PDF, DOC, XLS Filtering to Media Library
***/ 
function modify_post_mime_types( $post_mime_types ) {
	// select the mime type, here: 'application/pdf'
	// then we define an array with the label values
	$post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
	$post_mime_types['application/msword'] = array( __( 'DOCs' ), __( 'Manage DOCs' ), _n_noop( 'DOC <span class="count">(%s)</span>', 'DOC <span class="count">(%s)</span>' ) );
    $post_mime_types['application/vnd.ms-excel'] = array( __( 'XLSs' ), __( 'Manage XLSs' ), _n_noop( 'XLS <span class="count">(%s)</span>', 'XLSs <span class="count">(%s)</span>' ) );	
	// then we return the $post_mime_types variable
	return $post_mime_types;
}
// Add Filter Hook
add_filter( 'post_mime_types', 'modify_post_mime_types' );

/******************
 * Custom Icons  *
******************/
add_action('admin_head', 'plugin_header');
function plugin_header() {
        global $post_type;
	?>
	<style>
	<?php if (($_GET['post_type'] == 'people') || ($post_type == 'people')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/people32.png';?>') no-repeat; }		
	<?php elseif (($_GET['post_type'] == 'social_media') || ($post_type == 'social_media')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/social32.png';?>') no-repeat;	}
	<?php elseif (($_GET['post_type'] == 'slider') || ($post_type == 'slider')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/slider32.png';?>') no-repeat;	}		
	<?php elseif (($_GET['post_type'] == 'minutes') || ($post_type == 'minutes')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/full_page32.png';?>') no-repeat;	}	
	<?php elseif (($_GET['post_type'] == 'handbook') || ($post_type == 'handbook')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/handbook32.png';?>') no-repeat;	}	
	<?php elseif (($_GET['post_type'] == 'eupdate') || ($post_type == 'eupdate')) : ?>
		#icon-edit { background:transparent url('<?php echo get_bloginfo('template_directory') . '/images/eUpdate32.png';?>') no-repeat;	}	
	<?php endif; ?>
        </style>
        <?php
}
/******************/

// Custom Post Type for Slider (for use in FlexSlider)
function slider() {
	$labels = array(
		'name' => _x('Slides', 'post type general name'),
		'singular_name' => _x('Slider Item', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Slider Item'),
		'edit_item' => __('Edit Slider Item'),
		'new_item' => __('New Slider Item'),
		'all_items' => __('All Slides'),
		'view_item' => __('View Slider Item'),
		'search_items' => __('Search Slides'),
		'not_found'  => __('No slider items found.'),
		'not_found_in_trash'  => __('No slider items found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Slides'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Slider Item'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'exclude_from_search' => true,
		'menu_icon' => get_bloginfo('template_directory') . '/images/slider.png', 		
		'supports' => array('custom-fields'),
	);

	register_post_type( 'slider', $args );
}
add_action('init', 'slider');

function show_slider_items() {
	$sliderArgs = array(
		'post_type' => 'slider',
	);

	query_posts( $sliderArgs );

	echo '<div class="sliderItems wrap">';
	echo '<ul class="slides">';

	if(have_posts()) : while (have_posts()) : the_post();	
		$thisID = get_the_ID();
		$expires = trim(get_field('expires'));
		$isExpired = $expires != '' ? 
			( $expires < date(Ymd) ? true : false )
			: false;

		$slide = array(
			'title' => get_field('title'),
			'content' => '',
			'image' => get_field('image'),
			'page' => get_field('page'),
			'file_link' => get_field('file_link'),
			'external_link' => get_field('external_link'),
			'position' => ucwords( get_field('position') ),
			'is_disabled' => get_field('disabled') ,
			'is_expired' => $isExpired, // TRUE if expired
			'edit' => get_edit_post_link( $thisID ),
		);

		// Skip the slide if it's disabled or has expired
		if($slide['is_disabled'] || $slide['is_expired']) continue;		

		 //Link to a file if a File Link is defined in the Custom Post 
		if(!empty($slide['file_link'])){ $slide['page'] = $slide['file_link'];}		
		
		//Link to an external site if an External Link is defined in the Custom Post 
		if(!empty($slide['external_link']) && !preg_match("^(http|https)\:\/\/^", $slide['external_link'])){
			$slide['external_link'] = "http://".$slide['external_link'];
		}
		if(!empty($slide['external_link'])){ $slide['page'] = $slide['external_link'];}

		//Define 'content' here to it's link at the end matches the title link
		$slide['content'] = excerpt( get_field('content'), 150, $slide['page']);

		echo <<<SLIDE
			<li class="slide slide{$slide['position']}">
				<h2><a href="{$slide['page']}">{$slide['title']}</a></h2>
				<img src="{$slide['image']}" alt="{$slide['title']}" />
				<p>{$slide['content']}{$slide['is_disabled']}
SLIDE;
		edit_post_link( 'Edit This Slide', '', '' );
		echo '</p>';
		echo '</li>';

	endwhile; endif; wp_reset_query();

	echo '</ul>';
	echo '</div>';
}

add_filter('title_save_pre','custom_titles');

function custom_titles($title) {
	$postID = get_the_ID();
	$postType = $_POST['post_type'];

	if( $postType == 'people' ){
		// $title = get_field('last_name', $postID ) . ', ' . get_field('first_name', $postID );
		$title = $_POST['fields']['field_4f68940783612'].', '.$_POST['fields']['field_4f6893f51db13'];
	} elseif( $postType == 'slider' ){
		// $title = get_field('title', $postID );
		$title = $_POST['fields']['field_4f7b0930604a6'];
	} elseif( $postType == 'contact' ) {
		// $title = get_field('dept', $postID );
		$title = $_POST['fields']['field_4f7b5041b8cc7'];
	} elseif( $postType == 'mainlink') {
		$title = get_field('title', $postID );
		$title = $_POST['fields']['field_4f7b4058c25a0'];
	} elseif( $postType == 'social_media') {
		$title = get_field('label', $postID );
		$title = $_POST['fields']['field_4f873078a9151'];
	} elseif( $postType == 'minutes') {
		$date = $_POST['fields']['field_8'];
		$date = substr($date, 4, 2)."-".substr($date, 6, 2)."-".substr($date, 2, 2);

		$title = $_POST['fields']['field_11']."-".$date;
	}

	// Only return title if it has been successfully generated
	// if( $title != '' ) 
	return $title;
}

function mainLink() {
	$labels = array(
		'name' => _x('Main Links', 'post type general name'),
		'singular_name' => _x('Main Link', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Main Link'),
		'edit_item' => __('Edit Main Link Details'),
		'new_item' => __('New Main Link'),
		'all_items' => __('All Main Links'),
		'view_item' => __('View Main Link'),
		'search_items' => __('Search Main Links'),
		'not_found'  => __('No links found.'),
		'not_found_in_trash'  => __('No links found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Main Links'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Main Link'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'exclude_from_search' => true,
		'supports' => array('custom-fields'),
	);

	register_post_type( 'mainlink', $args );
}
add_action('init', 'mainLink');

function show_main_links() {
	$mainLinkArgs = array( 
		'post_type' => 'mainlink',		
		'order' => 'ASC',
		'meta_key' => 'order',
		'orderby' => 'meta_value',
	);

	query_posts( $mainLinkArgs );

	if(have_posts()) : while (have_posts()) : the_post();			
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$mainLink = array(
			'title' => get_field('title'),
			'link' => get_field('link'),
			'file_link' => get_field('file_link'),
			'external_link' => get_field('external_link'),
			'image' => get_field('image'),
			'slice' => ucwords(get_field('slice')),
			'open' => get_field('open'),
		);

		//Link to an Internal File
		if(!empty($mainLink['file_link'])){ $mainLink['link'] = $mainLink['file_link'];}
		//Link to an External Site
		if(!empty($mainLink['external_link']) && !preg_match("^(http|https)\:\/\/^", $mainLink['external_link'])){
			$mainLink['external_link'] = "http://".$mainLink['external_link'];
		}		
		if(!empty($mainLink['external_link'])){ $mainLink['link'] = $mainLink['external_link'];}

		echo <<<MAINLINK
			<div class="mainlink-item">
				<div style="background-image: url({$mainLink['image']})" class="slice{$mainLink['slice']}"> <a href="{$mainLink['link']}" target="_{$mainLink['open']}" title="{$mainLink['title']}"></a>
					<h2>{$mainLink['title']}</h2>
				</div>
			</div>
MAINLINK;
	endwhile; endif; wp_reset_query();
}

// Custom Post Type for Social Media
function social_media() {
	$labels = array(
		'name' => _x('Social Media', 'post type general name'),
		'singular_name' => _x('Social Media Item', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Social Media Item'),
		'edit_item' => __('Edit Social Media Info'),
		'new_item' => __('New Social Media Item'),
		'all_items' => __('All Social Media'),
		'view_item' => __('View Social Media Item'),
		'search_items' => __('Search All Social Media'),
		'not_found'  => __('No social media found.'),
		'not_found_in_trash'  => __('No social media found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Social Media'),
	);
	$args = array(
		'labels' => $labels,
		'singular_label' => __('Social Media Item'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'exclude_from_search' => true,
		'menu_icon' => get_bloginfo('template_directory').'/images/social.png',
		'supports' => array('custom-fields'),
	);

	register_post_type( 'social_media', $args );
}
add_action('init', 'social_media');

function show_social() {
	$socialMediaArgs = array( 
			'post_type' => 'social_media',
	);

	query_posts( $socialMediaArgs );

	echo '<ul id="socialMedia">';

	if(have_posts()) : while (have_posts()) : the_post();			
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$social = array(
			'label' => get_field('label'),
			'type' => get_field('type'),
			'link' => get_field('link'),
			'disabled' => get_field('disabled'),
		);

		// Check the URL for 'HTTP://'
		if( !stripos($social['link'], 'http://') || !stripos($social['link'], 'https://') ) {
			$social['link'] = 'http://' . $social['link'];
		}

		echo <<<SOCIAL
			<li>
				<a href="{$social['link']}" title="{$social['label']}" class="{$social['type']}" target="_blank"></a>
			</li>
SOCIAL;
	endwhile; endif; wp_reset_query();

	echo '</ul>';
}

// Custom Post Type for People
function people() {
	$labels = array(
		'name' => _x('People', 'post type general name'),
		'singular_name' => _x('Person', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Person'),
		'edit_item' => __('Edit Person Info'),
		'new_item' => __('New Person'),
		'all_items' => __('All People'),
		'view_item' => __('View Person'),
		'search_items' => __('Search All People'),
		'not_found'  => __('No people found.'),
		'not_found_in_trash'  => __('No people found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('People'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Person'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'menu_icon' => get_bloginfo('template_directory').'/images/people.png',
		'supports' => array('custom-fields'),
		'taxonomies' => array('people_cat'),
	);

	register_post_type( 'people', $args );
}
add_action('init', 'people');

// Custom taxonomy for people classifications
function people_cat() {
	// create a new taxonomy
	register_taxonomy(
		'people_cat',
		'people',
		array(
			'label' => __( 'Classifications' ),
			'sort' => true,
			'hierarchical' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'query_var' => true,
			'rewrite' => false, /*array( 'slug' => 'group' )*/
		)
	);
}
add_action( 'init', 'people_cat' ); 

function show_people_cats( $displayCats = true ) {
	$cats = get_terms( 'people_cat' );
	$subCats = array();
	$has_subCats = false;

	echo '<pre>';
	// print_r($cats);
	echo '</pre>';

	if( !empty( $cats ) ){
		foreach ($cats as $cat){
			if( $cat->parent != 0 ){
				array_push($subCats, $cat);
			}
		}
		
		foreach ($cats as $cat){
			if( $cat->parent != 0 ){
				continue;
			} else {
				$peopleCatList .= '<li>';
			}

			$peopleCatList .= '<a href="' . esc_attr(get_term_link($cat, 'people_cat' )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $cat->name) . '">' . $cat->name . '</a>';
			

			// Add subcategories
			foreach ($subCats as $subCat){
				if( $subCat->parent == $cat->term_id ){
					if( $has_subCats ){
						$peopleCatList .= '<li><a href="' . esc_attr(get_term_link($subCat, 'people_cat' )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $subCat->name) . '">' . $subCat->name . '</a></li>'; 
					} else {
						$peopleCatList .= '<ul class="children"><li><a href="' . esc_attr(get_term_link($subCat, 'people_cat' )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $subCat->name) . '">' . $subCat->name . '</a></li>'; 
						$has_subCats = true;
					}
				}
			}

			if( $has_subCats ){
				$peopleCatList .= '</ul>';
				$has_subCats = false;
			}

			$peopleCatList .= '</li>';

		}
		if( $displayCats ){
			echo '<ul id="people_cats" class="children" style="display: none;">';
			echo $peopleCatList;
			echo '</ul>';
		}
	}

	return $peopleCatList;
}

function person_toolbar( $person ){
	$msg = array(
		'email' => "Send Email",
		'link' => "Visit Page",
		'quickview' => "Quick View",
	);

	echo '<ul class="person_toolbar">';
	echo '<li><a href="mailto:'.$person['email'].'">'.$msg['email'].'</a></li>';
	echo '<li><a href="'.$person['link'].'">'.$msg['link'].'</a></li>';
	echo '<li><a class="peopleModalView" title="'.$person['id'].'" href="#people_modal_person_'.$person['id'].'">'.$msg['quickview'].'</a></li>';
	echo '</ul>';
}

function people_modal( $person ) {
	?>
	<div id="people_modal_person_<?php echo $person['id']?>" class="people_modal">
		<div class="people_modal_bg">	</div>
		<div class="people_modal_person"> 
			<h2><?php echo $person['first_name'] . ' ' . $person['last_name']; ?></h2>
		</div>
	</div>
	<?php
}

function show_person( $id, $is_ie = false ) {

	// All fields beginning with 'p_' are default fields that don't appear as tabular data
	$person = array(
		'p_first_name'  => get_field('first_name'),
		'p_last_name'   => get_field('last_name'),
		'p_photo'       => get_field('headshot'),
		'p_phone'       => get_field('phone'),
		'p_email'       => get_field('email'),
		'p_location'    => get_field('location'),
		'p_position'    => get_field('position'),
		'p_cv'          => get_field('curriculum_vitae'),
		'p_link'        => get_permalink(),
		'biography' 	=> get_field('biography'),
		'research'  	=> get_field('research_areas'),
		'misc'      	=> get_field('miscellaneous'),
		'p_courses'     => get_field('courses'),
		'p_officehours' => get_field('office_hours'),

		// Office Hours
		'p_office_hours_mon' => parse_hrs(get_field('office_hours_mon')),
		'p_office_hours_tue' => parse_hrs(get_field('office_hours_tue')),
		'p_office_hours_wed' => parse_hrs(get_field('office_hours_wed')),
		'p_office_hours_thu' => parse_hrs(get_field('office_hours_thu')),
		'p_office_hours_fri' => parse_hrs(get_field('office_hours_fri')),

		'p_office_hours_private' => get_field('office_hours_private'),
	);

	//Show a default image if there is no image defined
	//Make sure to change when the site goes live
	if( !$person['p_photo']){
			$person['p_photo'] = "http://10.171.92.38/~sociolog/wp-content/uploads/2012/04/NoImagePegasusGrey.jpg";
	}

	// Create array of tabs to display (and populate them), only if content exists

	$contentTabs = '<ul class="tabNavigation">';
	$content = '';
	$contentCounter = '0';

	foreach  ($person as $field => $value ) {
		if( substr( $field, 0, 2 ) != 'p_' && !empty($value) ){
			$contentTabs .= '<li><a href="#' . $field . '">' . $field . '</a></li>';
			$content     .= '<div id="'. $field . '" class="tabcontentstyle">' . $value . '</div>';
		}
	}
	// Office Hours
	
	if( $person['p_officehours'] || $person['p_courses']){
		$contentTabs .= '<li><a href="#office_hrs">Office Hours &amp; Courses</a></li>';
		$content .= '<div id="office_hrs" class="tabcontentstyle">';

		if( $person['p_officehours'] ){	
			$content .= '<h2>Office Hours</h2>' . $person['p_officehours'] .'';
		}
		if ($person['p_courses']){
			$content .='<h2>Courses</h2>' . $person['p_courses'] . '';
		}
		
		$content .= "</div>";
	}

	$contentTabs .= '</ul>';
	
	

	echo <<<PERSON
	<script type="text/javascript" charset="utf-8">
		$(function () {
			var tabContainers = $('div.tabs > div');
			tabContainers.hide().filter(':first').show();
			
			$('div.tabs ul.tabNavigation a').click(function () {
				tabContainers.hide();
				tabContainers.filter(this.hash).show();
				$('div.tabs ul.tabNavigation a').removeClass('selected');
				$(this).addClass('selected');
				return false;
			}).filter(':first').click();
		});
	</script>
	<article class="person clearfix">
		<figure><img src="{$person['p_photo']}"/></figure>
		<ul class="personBasics">
			<li class="person_position">{$person['p_position']}
			<li class="person_location">{$person['p_location']}
			<li class="person_phone">{$person['p_phone']}
			<li class="person_email"><a href="mailto:{$person['p_email']}">{$person['p_email']}</a>
			<li class="person_cv"><a href="{$person['p_cv']}">Curriculum Vitae</a></li>

		</ul>
	</article>

	<div class="tabs">		
		{$contentTabs}
		<br style="clear:left;" />
		{$content}		
	</div>	
PERSON;
}

// Displays list of people based on category (default: all)
function show_people( $catID = 0 ) { 

	if( $catID ){
		$facultyArgs = array( 
			'post_type' => 'people',
			'people_cat' => $catID,
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);
	} else {
		$facultyArgs = array( 
			'post_type' => 'people',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);
	}

	query_posts( $facultyArgs );

	echo '<div id="people_list">';



	if(have_posts()) : while (have_posts()) : the_post();			
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$person = array(
			'first_name'  => get_field('first_name'),
			'last_name'   => get_field('last_name'),
			'photo'       => get_field('headshot'),
			'phone'       => get_field('phone'),
			'email'       => get_field('email'),
			'location'    => get_field('location'),
			'position'    => get_field('position'),
			'biography'   => get_field('biography'),
			//'research_ex' => get_field('research_areas'),
			'cv'          => get_field('curriculum_vitae'),
			'link'        => get_permalink(),

		// Office Hours
			'office_hours_mon' => parse_hrs(get_field('office_hours_mon')),
			'office_hours_tue' => parse_hrs(get_field('office_hours_tue')),
			'office_hours_wed' => parse_hrs(get_field('office_hours_wed')),
			'office_hours_thu' => parse_hrs(get_field('office_hours_thu')),
			'office_hours_fri' => parse_hrs(get_field('office_hours_fri')),
		);

		if( !$person['photo']){
			$person['photo'] = "http://10.171.92.38/~sociolog/wp-content/uploads/2012/04/NoImagePegasusGrey.jpg";
		}

		// display person if person is in category, or category is 'all'
		echo <<<PEOPLE
		<article class="person clearfix">
			<figure><a href="{$person['link']}"><img src="{$person['photo']}" /></a></figure>
			<ul class="personBasics">
				<h2><a href="{$person['link']}" class="personLink">{$person['last_name']}, {$person['first_name']}</a></h2>
				<li class="person_position">{$person['position']}</li>
				<li class="person_location">{$person['location']}</li>
				<li class="person_phone">{$person['phone']}</li>
				<li class="person_email"><a href="mailto:{$person['email']}">{$person['email']}</a></li>
			</ul>
			<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
		</article>
PEOPLE;

	endwhile; endif; wp_reset_query();
	echo '</div>';
}

//Shortcode for displaying all people
add_shortcode('show_people', 'show_people');

function show_office_hours( $is_sidebar=true ) {
	if( is_home() ){
		$is_sidebar = false;
	}
	$officeHoursArgs = array( 
		'post_type' => 'people',
		'people_cat' => 0,
		'posts_per_page' => -1,
	);
	query_posts( $officeHoursArgs );

	// Custom Options
	$title = "Office Hours";
	$subtitle = "Faculty with office hours today (<strong>".date("l")."</strong>):";
	$today = date( "w" ); // Don't change
	$no_office_hrs = "Sorry, we couldn't find any faculty with office hours today.";

	if( $is_sidebar ){
		// echo '<h3>'.$title.'</h3>'; // Shown in widget; not necessary
		echo '<p>'.$subtitle.'</p>';
		echo '<ul class="xoxo">';
	} else {
		echo '<div class="officeHours">';
		// echo '<h1>'.$title.'</h1>'; // Shown in widget; not necessary
		echo '<h2>'.$subtitle.'</h2>';
	}

	if(have_posts()) : while (have_posts()) : the_post();			
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$person = array(
			'id' => $thisID,
			'first_name'  => get_field('first_name'),
			'last_name'   => get_field('last_name'),
			'photo'       => get_field('headshot'),
			'phone'       => get_field('phone'),
			'email'       => get_field('email'),
			'location'    => get_field('location'),
			'position'    => get_field('position'),
			'biography'   => get_field('biography'),
			'research_ex' => excerpt(get_field('research_areas'), 140),
			'cv'          => get_field('curriculum_vitae'),
			'link'        => get_permalink(),

			// Office Hours
			'office_hours_mon' => parse_hrs(get_field('office_hours_mon')),
			'office_hours_tue' => parse_hrs(get_field('office_hours_tue')),
			'office_hours_wed' => parse_hrs(get_field('office_hours_wed')),
			'office_hours_thu' => parse_hrs(get_field('office_hours_thu')),
			'office_hours_fri' => parse_hrs(get_field('office_hours_fri')),

			'office_hours_private' => get_field('office_hours_private'),
		);

		if( $person['office_hours_private'] ) continue;

		switch ($today){
			case 1: // Monday
				if($person['office_hours_mon']) echo_hrs( $person, "mon", $is_sidebar );
				break;
			case 2: // Tuesday	
				if($person['office_hours_tue']) echo_hrs( $person, "tue", $is_sidebar );
				break;
			case 3: // Wednesday
				if($person['office_hours_wed']) echo_hrs( $person, "wed", $is_sidebar );
				break;
			case 4: // Thursday
				if($person['office_hours_thu']) echo_hrs( $person, "thu", $is_sidebar );
				break;
			case 5: // Friday
				if($person['office_hours_fri']) echo_hrs( $person, "fri", $is_sidebar );
				break;
		}

	endwhile; endif; wp_reset_query();

	if( $is_sidebar ){
		echo '</ul>';
	} else {
		echo '</div>';
	}
}
add_action('office_hours', 'show_office_hours');

function parse_hrs( $hours ) {
	$hrs_array = preg_split("/[-,]/", $hours);
	//echo "<pre>"; print_r($hrs_array); echo "</pre>";
	foreach( $hrs_array as &$value ){
		$value = strtotime( $value );
		$value = date( "g:i A", $value );
	}
	unset( $value );


	// There must be an even number of elements in array
	if( count($hrs_array) % 2 == 0 ){
		return $hrs_array;
	} elseif (preg_match('/private/', strtolower($hours)) ){
		return "private";
	}else {
		return false;
	}
}

function echo_hrs( $person, $day, $is_sidebar ) {
	$office_hours_today = 'office_hours_'.$day;
	$parity = true;
	$connector = "&nbsp;to&nbsp;";
	$separator = "</li><li>";
	
	if( !$is_sidebar ){
		echo("<div>");
		echo("<figure><img src=".$person['photo']." /></figure>");
		echo('<ul class="person_office_hrs xoxo">');
		echo("<h4><a href=".$person['link'].">".$person['last_name'].", ".$person['first_name']."</a></h4>");

		echo('<li>');
		foreach( $person[$office_hours_today] as $hour ){
			$separator = ($hour == end($person[$office_hours_today]) ? "" : $separator);

			echo('<strong>'.$hour.'</strong>');
			echo( $parity ? $connector : $separator );
			$parity = !$parity;
		}
		echo('</li>');

		person_toolbar( $person );
		echo "</ul>";
		echo "</div>";
	} else {
		echo '<li>';
		echo("<a href=".$person['link'].">".$person['last_name'].", ".$person['first_name']."</a>");
		echo '</li>';
		echo '<ul class="officeHours"><li>';
		foreach( $person[$office_hours_today] as $hour ){
			$separator = ($hour == end($person[$office_hours_today]) ? "" : $separator);

			echo('<strong>'.$hour.'</strong>');
			echo( $parity ? $connector : $separator );
			$parity = !$parity;
		}
		echo '</li></ul>';
	}
}

function get_hrs( $person ){
	$parity = true;
	$absent_msg = '';
	$connector = "&nbsp;to&nbsp;";
	$separator = "</li><li>";
	$days = array('mon'=>'Monday', 'tue'=>'Tuesday', 'wed'=>'Wednesday', 'thu'=>'Thursday', 'fri'=>'Friday',);
	$hours = '<ul>';

	foreach( $days as $day => $dayTitle ){
		$office_hours_today = 'p_office_hours_'.$day;
		
		$hours .= '<li><h2>' . $dayTitle . '</h2>';
		$hours .= '<ul><li>';

		//echo "<pre>"; print_r($person); echo "</pre>";

		if( is_array($person[$office_hours_today]) ){
			foreach( $person[$office_hours_today] as $hour ){

				$hours .= '<strong>'.$hour.'</strong>';
				$hours .=  $parity ? $connector : $separator ;
				$parity = !$parity;
			}
			$hours = substr( $hours, 0, -9 ); // Remove the extra </li><li>
		} elseif ($person[$office_hours_today] == "private") {			
			$hours .= '<strong><em>By Appointment Only</em></strong>';
		} else {
			
			$hours .= '<em>' . $absent_msg . '</em>';
		}

		
		$hours .= '</li></ul></li>';
	}

	$hours .= '</ul>';

	return $hours;
}

//Custom post type for Meeting Minutes
function minutes() {
	$labels = array(
		'name' => _x('Meeting Minutes', 'post type general name'),
		'singular_name' => _x('Meeting Minutes', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Meeting Minutes'),
		'edit_item' => __('Edit Meeting Minutes'),
		'new_item' => __('New Meeting Minutes'),
		'all_items' => __('All Meeting Minutes'),
		'view_item' => __('View Meeting Minutes'),
		'search_items' => __('Search All Meeting Minutes'),
		'not_found'  => __('No Meeting Minutes found.'),
		'not_found_in_trash'  => __('No Meeting Minutes found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Meeting Minutes'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Meeting Minutes'),
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,		
		'rewrite' => array('slug' => 'minutes'),
		'menu_icon' => get_bloginfo('template_directory').'/images/full_page.png',
		'supports' => array('custom-fields'),
		'taxonomies' => array('minutes_cat'),
	);

	register_post_type( 'minutes', $args );
}
add_action('init', 'minutes');

//Custom Taxonomy for Meeting Minutes Type
function minutes_cat() {
	//Taxonomy for Meeting Types
	$labels = array(
		'name'=>'Meeting Types',
		'singular_name' => 'Meeting Type',
		'update_item' => 'Update Meeting Type',
		'edit_item' => 'Update Meeting Type',
		'all_items' => 'All Meeting Types',
		'add_new_item' => 'Add New Meeting Type',
		'search_items' => 'Search Meeting Types',
		'popular_items' => 'Popular Meeting Types',		
	);
	// create a new taxonomy
	register_taxonomy(
		'minutes_cat',
		'minutes',
		array(
			'labels' => $labels,
				
			'sort' => true,
			'hierarchical' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'query_var' => true,
			'rewrite' => array('slug' => 'meeting-minutes',  'hierarchical' => true),
		)	
	);

}
add_action( 'init', 'minutes_cat' ); 


//Custom post type for the Handbook
function handbook() {
	$labels = array(
		'name' => _x('Handbooks', 'post type general name'),
		'singular_name' => _x('Handbook', 'post type singular name'),
		'add_new' => _x('Add New Entry', 'slider'),
		'add_new_item' => __('Add New Handbook Entry'),
		'edit_item' => __('Edit Handbook Entry'),
		'new_item' => __('New Handbook Entry'),
		'all_items' => __('All Handbooks Entries'),
		'view_item' => __('View Handbook Entry'),
		'search_items' => __('Search All Handbook Entries'),
		'not_found'  => __('No Handbook Entries found.'),
		'not_found_in_trash'  => __('No Handbook Entries found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Handbooks'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Handbook'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'menu_icon' => get_bloginfo('template_directory').'/images/handbook.png',
		'supports' => array('title','editor','custom-fields'),
		'taxonomies' => array('handbook_cat'),
	);

	register_post_type( 'handbook', $args );
}
add_action('init', 'handbook');

// Custom Taxonomy for Handbook Type
function handbook_cat() {
	//Taxonomy for Meeting Types
	$labels = array(
		'name'=>'Handbook Categories',
		'singular_name' => 'Handbook Category',
		'update_item' => 'Update Handbook Category',
		'edit_item' => 'Update Handbook Category',
		'all_items' => 'All Handbook Categories',
		'add_new_item' => 'Add New Handbook Category',
		'search_items' => 'Search Handbook Categories',
		'popular_items' => 'Popular Handbook Categories',		
	);
	// create a new taxonomy
	register_taxonomy(
		'handbook_cat',
		'handbook',
		array(
			'labels' => $labels,
				
			'sort' => true,
			'hierarchical' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'query_var' => true,
			'rewrite' => array( 'slug' => 'handbooks' )
		)	
	);

}
add_action( 'init', 'handbook_cat' ); 


//Custom post type for the eUpdates
function eUpdate() {
	$labels = array(
		'name' => _x('eUpdates', 'post type general name'),
		'singular_name' => _x('eUpdate', 'post type singular name'),
		'add_new' => _x('Add New eUpdate', 'slider'),
		'add_new_item' => __('Add New eUpdate'),
		'edit_item' => __('Edit eUpdate'),
		'new_item' => __('New eUpdate'),
		'all_items' => __('All eUpdates'),
		'view_item' => __('View eUpdate'),
		'search_items' => __('Search All eUpdates'),
		'not_found'  => __('No eUpdates found.'),
		'not_found_in_trash'  => __('No eUpdates found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('eUpdates'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('eUpdate'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'menu_icon' => get_bloginfo('template_directory').'/images/eUpdate.png',
		'supports' => array('title','custom-fields'),		
	);

	register_post_type( 'eupdate', $args );
}
add_action('init', 'eUpdate');


function show_dyk_area( $args ) {
// Grab posts from specified category
	if( get_cat_ID( $args['cat'] ) ){
		$dykArgs = array( 
		'category_name' => $args['cat'],
		'posts_per_page' => -1 
		);
	} else {
		echo "<em>There is nothing to know at this time.</em>";
		return false;
	}
	shuffle( query_posts( $dykArgs ) );

	if(have_posts()) : while (have_posts()) : the_post(); 

	$thisID = get_the_ID();
	the_content();

	break; // Prevent loop from displaying more than one post, just in case.

	endwhile; endif; wp_reset_query();

	return true;
}
add_action( 'show_dyk_area', 'show_dyk_area', 10, 1 );

// Breadcrumbs
function breadcrumbs() {
 
  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '<span class="crumbSep"> &raquo; </span>'; // delimiter between crumbs
  $home = 'Home'; // text for the 'Home' link
  $showCurrent = 0; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<a href="#">'; // tag before the current crumb
  $after = '</a>' . $delimiter; // tag after the current crumb
 
  global $post;
  $homeLink = get_bloginfo('url');
 
  if (is_home() || is_front_page()) {
  	if ($showOnHome == 1) echo '<div id="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
 
  } else {
 
    echo '<div id="breadcrumbs" class="wrap"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());

        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
  }
} 

function show_news( $cat, $items_to_show ) { ?>
	<div class="news">
 		<!-- <h1>News</h1> -->
		<?php 
		//echo $cat . ' - ' . $items_to_show;

		try {
			include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
			$feed = fetch_rss('http://communication.cos.ucf.edu/feed/'); // specify feed url
			$items = array_slice($feed->items, $items, $items_to_show); // specify first and last item
			} catch(Exception $e) {
				echo '<span class="error">Unable to retrieve feed. Please try again later.</span>';
			}
		?>

			<?php if (!empty($items)) : ?>
			<?php foreach ($items as $item) : 
			preg_match("/<img[^>]+\>/i", $item['description'], $myImage);	
			?>
			<article class="widget_news">
				<a href="<?php echo $item['link']; ?>"><?php echo $myImage[0]; ?></a>
				<h2><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></h2>
				<?php 
				//Strip out any image tag
				$item['description'] = substr(preg_replace("/<img[^>]+\>/i", "", $item['description']), 0, 200);
				$item['description'] .= '...'; 
				//$item['description'] .= '... <a href="'.$item['link'].'">Read more</a>';
				?>
				<p><a href="<?php echo $item['link']; ?>"><?php  echo $item['description']; ?></a></p>
				
			</article>
			<?php endforeach; ?>
			<?php endif; ?>
	</div> <?php
}
add_action( 'show_news', 'show_news', 10, 2 );

function show_news_full() { ?>
	<div class="news"> 		
		<?php try {
			include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
			$feed = fetch_rss('http://news.cos.ucf.edu/?category_name='.get_option('COS_news_cat').'&feed=rss2'); // specify feed url
			$items = array_slice($feed->items, 0, 20); // specify first and last item
			} catch(Exception $e) {
				echo '<span class="error">Unable to retrieve feed. Please try again later.</span>';
			}
		?>

			<?php if (!empty($items)) : ?>
			<?php foreach ($items as $item) : 

			preg_match("/<img[^>]+\>/i", $item['description'], $myImage);	
			?>			
			<article>
				<a href="<?php echo $item['link']; ?>"><?php echo $myImage[0]; ?></a>
				<h2><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></h2>
				<?php //Strip out any image tag
				$item['description'] = preg_replace("/<img[^>]+\>/i", "", $item['description']);
				?>
				<p><?php echo str_replace('[...]', '... <a href="'.$item['link'].'">Read more</a>', $item['description']); ?></p>
				<aside><?php echo substr($item['pubdate'], 0, 16); ?></aside>
			</article>
			<?php endforeach; ?>
			<?php endif; ?>
	</div> <?php
}
add_shortcode('show_news_full', 'show_news_full');

function show_events() {?>
	
		<?php try {
			include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
			$feed = fetch_rss('http://events.ucf.edu/?calendar_id=292&upcoming=upcoming&format=rss&limit=10'); // specify feed url
			$items = array_slice($feed->items, 0, 6); // specify first and last item
			$calTitle = "";

			if(empty($items)){
				$feed = fetch_rss('http://events.ucf.edu/?calendar_id=1&upcoming=upcoming&format=rss&limit=10'); 
				$items = array_slice($feed->items, 0, 6); 
				$calTitle = "UCF Calendar";
			}
			} catch(Exception $e) {
				echo '<span class="error">Unable to retrieve feed. Please try again later.</span>';
			}
		?>

		<?php if (!empty($items)) : ?>
		<?php if (!empty($calTitle)) echo "<h3>".$calTitle."</h3>";?>
		<?php foreach ($items as $item) : ?>
			<article>

				<span class="eventDate"><?php echo substr($item['ucfevent']['startdate'],5,11); ?> </span>
				<ul class="eventInfo">
					<li class="eventTitle"><a href="<?php echo $item['link']; ?>" title="<?php echo($item['title']); ?>"
						<?php echo(substr($item['title'],0,40)==$item['title']?
							'>'.$item['title']
							:' class="expandEventTitle">'.substr($item['title'],0,40).'...'); ?>
					</a></li>
					<li class="eventTime"><?php echo substr($item['ucfevent']['startdate'],17,5); ?> - <?php echo substr($item['ucfevent']['enddate'],17,5); ?></li>
					<li class="eventLocation"><?php echo $item['ucfevent']['location_name']; ?></li>
				</ul>
			</article>
		<?php endforeach; ?>
		
		<?php endif; ?><?php
}
add_action('show_events', 'show_events');

function starkers_setup() {

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'starkers', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
}
endif;

if ( ! function_exists( 'starkers_menu' ) ):
/**
 * Set our wp_nav_menu() fallback, starkers_menu().
 *
 * @since Starkers HTML5 3.0
 */
function starkers_menu() {
	echo '<nav id="main_menu">';

	echo '<ul><li><a href="'.get_bloginfo('url').'">Home</a></li>';
	wp_list_pages('title_li=');
	echo '</ul></nav>';
}
endif;

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * @since Starkers HTML5 3.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * @since Starkers HTML5 3.0
 * @deprecated in Starkers HTML5 3.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function starkers_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'starkers_remove_gallery_css' );

if ( ! function_exists( 'starkers_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s says:', 'starkers' ), sprintf( '%s', get_comment_author_link() ) ); ?>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<?php _e( 'Your comment is awaiting moderation.', 'starkers' ); ?>
			<br />
		<?php endif; ?>

		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'starkers' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'starkers' ), ' ' );
			?>

		<?php comment_text(); ?>

			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<p><?php _e( 'Pingback:', 'starkers' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'starkers'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Closes comments and pingbacks with </article> instead of </li>.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_comment_close() {
	echo '</article>';
}

/**
 * Adjusts the comment_form() input types for HTML5.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_fields($fields) {
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
	'author' => '<p><label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '*' : '' ) .
	'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
	'email'  => '<p><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '*' : '' ) .
	'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	'url'    => '<p><label for="url">' . __( 'Website' ) . '</label>' .
	'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
);
return $fields;
}
add_filter('comment_form_default_fields','starkers_fields');

/**
 * Register widgetized areas.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar', 'starkers' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary sidebar widget area', 'starkers' ),
		'before_widget' => '<li class="sidebar_widget">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// register_sidebar( array(
	// 	'name' => __( 'Front Page Slider Right', 'starkers' ),
	// 	'id' => 'front-slider-right-widget-area',
	// 	'description' => __( 'The right side of the slider area on the front page', 'starkers' ),
	// 	'before_widget' => '',
	// 	'after_widget' => '',
	// 	'before_title' => '<h1>',
	// 	'after_title' => '</h1>',
	// ) );

	register_sidebar( array(
		'name' => __( 'Front Page Left Column', 'starkers' ),
		'id' => 'front-left-widget-area',
		'description' => __( 'The left side of the home page', 'starkers' ),
		'before_widget' => '<div id="left_content">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Front Page Right Column', 'starkers' ),
		'id' => 'front-right-widget-area',
		'description' => __( 'The right side of the home page', 'starkers' ),
		'before_widget' => '<div id="right_content">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Left Footer Widget Area', 'starkers' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'starkers' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );

	// Area 4, located in the footer. Empty by default.
	/*register_sidebar( array(
		'name' => __( 'Center Footer Widget Area', 'starkers' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'starkers' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );*/

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Right Footer Widget Area', 'starkers' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'starkers' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );

}
/** Register sidebars by running starkers_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'starkers_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * @updated Starkers HTML5 3.2
 */
function starkers_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'starkers_remove_recent_comments_style' );

if ( ! function_exists( 'starkers_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Starkers HTML5 3.0
 */
function starkers_posted_on() {
	printf( __( 'Posted on %2$s by %3$s', 'starkers' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s" pubdate>%4$s</time></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date('Y-m-d'),
			get_the_date()
		),
		sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'starkers' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'starkers_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Starkers HTML5 3.0
 */
function starkers_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'starkers' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'starkers' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'starkers' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}


//////////// User Role Customization ////////////

	// get the the role object
	$role_object = get_role('editor');

	// add $cap capability to this role object
	$role_object->add_cap( 'edit_theme_options' );

//////////// Dashboard Cusomtization ////////////

// Change Log-In Screen Logo
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/logo.png) !important; }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

// Change Log-In Screen Logo URL
function put_my_url(){
	return ('http://www.cos.ucf.edu/it'); // putting my URL in place of the WordPress one
}
add_filter('login_headerurl', 'put_my_url');

// Change Log-In Screen Logo Hover State
function put_my_title(){
    return ('College of Sciences Information Technology'); // Change the title from "Powered by WordPress"
}
add_filter('login_headertitle', 'put_my_title');

// Add error/info message box to top of the Dashboard
function showMessage($message, $errormsg){
    if ($errormsg) {
        echo '<div id="message" class="error">';
    }
    else {
        echo '<div id="message" class="updated fade">';
    }
    echo "<p><strong>$message</strong></p></div>";
} 

// Write message to show in the error/info box
	// Set boolean to True for red error box, False for yellow info box
function showAdminMessages(){
	showMessage("Please do not update any WordPress software.  If prompted for an update, please contact COSIT at <a href='mailto:cosit@ucf.edu?subject=WordPress Site Update For: ".get_bloginfo('name')."&body=This site (".site_url().") is due for a WordPress update, please forward on to COS Web.'>cosit@ucf.edu</a>", false);
}
add_action('admin_notices', 'showAdminMessages');

// Customize WordPress Dashboard Footer
function remove_footer_admin () {
	echo "&copy; ".date('Y')." - UCF College of Sciences Information Technology";
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Adding a custom widget in WordPress Dashboard
function wpc_dashboard_widget_function() {
	// Entering the text between the quotes
	echo "<ul>
	<li><strong>Release Date:</strong> July 2012</li>
	<li><strong>Author:</strong> College of Sciences Information Technology</li>
	<li><strong>Support E-Mail:</strong> <a href='mailto:cosit@ucf.edu'>cosit@ucf.edu</a></li>
	<li><strong>Support Phone:</strong> 407-823-2793</li>
	</ul>";
}
function wpc_add_dashboard_widgets() {
	//wp_add_dashboard_widget('wp_dashboard_widget', 'Support Contact Information', 'wpc_dashboard_widget_function');
	add_meta_box( 'wp_dashboard_widget', 'Support Contact Information', 'wpc_dashboard_widget_function', 'dashboard', 'side', 'high' );
}
add_action('wp_dashboard_setup', 'wpc_add_dashboard_widgets' );

//Hiding Default Dashboard Widgets
add_action('wp_dashboard_setup', 'wpc_dashboard_widgets');
function wpc_dashboard_widgets() {
	global $wp_meta_boxes;
	//Main Column Widgets
		// Today widget
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		// Last comments
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		// Incoming links
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		// Plugins
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	//Side Column Widgets
		//Quick Press
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		//Recent Drafts
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		//WordPress Blog
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		//Other WordPress News
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

//Custom Pagination from Kriesi.at
//http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

endif;