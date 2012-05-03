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
            	<option value="UCF" <?php if($title_prefix='UCF') echo 'selected';?>>UCF</option>
            	<option value="COS" <?php if($title_prefix='COS') echo 'selected';?>>COS</option>
            </select>

            <h4>Title Size</h4>
            <?php $title_size = get_option('COS_title_size') > 0 ? get_option('title_size') : 24; ?>
            <p><input type="text" name="title_size" id="title_size" value="<?php echo $title_size; ?>"></p>

            <?php $news_cat = get_option('COS_news_cat'); ?>
            <h4>News Category to Display (default: <em><?php echo $news_cat; ?></em>)</h4>
            <select name="news_cat" id="">
            	<option value="<?php echo $news_cat?> selected">Default</option>
            	<option value="anthropology">Anthropology</option>
            	<option value="biology-departments">Biology</option>
            	<option value="chemistry-departments">Chemistry</option>
            	<option value="communication">Communication, Nicholson School of</option>
            	<option value="forensic-science">Forensic Science, National Center of</option>
            	<option value="global-perspectives">Global Perspectives</option>
            	<option value="lou-frey-institute">Lou Frey Institute</option>
            	<option value="mathematics">Mathematics</option>
            	<option value="physics-departments">Physics</option>
            	<option value="political-science-departments">Political Science</option>
            	<option value="psychology-departments">Psychology</option>
            	<option value="sociology">Sociology</option>
            	<option value="statistics">Statistics</option>
            </select>

  
<!--             <h4>Colour Stylesheet To Use</h4>  
            <select name ="colour">  
                <option value="red">Red Stylesheet</option>  
                <option value="green">Green Stylesheet</option>  
                <option value="blue">Blue Stylesheet</option>  
            </select>  
  
            <h4>Advertising Spot #1</h4>  
            <p><input type="text" name="ad1image" id="ad1image" size="32" value=""/> Advert Image</p>  
            <p><input type="text" name="ad1url" id="ad1url" size="32" value=""/> Advert Link</p>  
  
            <h4>Advertising Spot #2</h4>  
            <p><input type="text" name="ad2image" id="ad2image" size="32" value=""/> Advert Image</p>  
            <p><input type="text" name="ad2url" id="ad2url" size="32" value=""/> Advert Link</p>  
  
            <h4><input type="checkbox" name="display_sidebar" id="display_sidebar" /> Display Sidebar</h4>  
  
            <h4><input type="checkbox" name="display_search" id="display_search" /> Display Search Box</h4>  
  
            <h4><input type="checkbox" name="display_twitter" id="display_twitter" /> Display Twitter Stream</h4>  
            <p><input type="text" name="twitter_username" id="twitter_username" size="32" value="" /> Twitter Username</p>    -->
  
            <p><input type="submit" name="search" value="Update Options" class="button" /></p>  
        </form>  
  
    </div>  
    <?php  

}

function COS_themeoptions_update() {
	// this is where validation would go
	update_option('COS_title_prefix', 	$_POST['title_prefix']);

	update_option('COS_title_size', 	$_POST['title_size']);
	update_option('COS_news_cat', 		$_POST['news_cat']);

}

add_action('admin_menu', 'COS_themeoptions_admin_menu');


if ( ! function_exists( 'starkers_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Starkers HTML5 3.0
 */


// Simple function for getting the excerpt of a body of text
// Takes in two parameters: $text = body of text, $cutoff = number of characters in excerpt
function excerpt( $text, $cutoff ){
	if( is_int($cutoff) && $cutoff > 0 ){
		return substr( $text, 0, $cutoff ) == $text ? $text : substr( $text, 0, $cutoff ) . '...';
	} else { return $text; }
}

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

	echo '<nav class="pageNav"><h2><a href="'.$parent.'">'. $title . '</a></h2><ul>';
	echo $children;
	echo '</ul></nav>';
}
add_shortcode('page_nav', 'page_nav');

function people_nav( $pageID = '' ){
	$pageID = $pageID || get_the_ID();
	$term_id = get_query_var('term_id');
	$currentPage = get_post( $pageID );
	// Check if post/page is a child or a parent

	echo '<nav class="pageNav"><h2>People</h2><ul>';
	echo show_people_cats( false );
	echo '</ul></nav>';
}
add_shortcode('people_nav', 'people_nav');

// Footer Widget
function footer_widget() {
	$labels = array(
		'name' => _x('Footer Widgets', 'post type general name'),
		'singular_name' => _x('Footer Widget', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Footer Widget'),
		'edit_item' => __('Edit Footer Widget'),
		'new_item' => __('New Footer Widget'),
		'all_items' => __('All Footer Widgets'),
		'view_item' => __('View Footer Widget'),
		'search_items' => __('Search Footer Widgets'),
		'not_found'  => __('No footer widgets found.'),
		'not_found_in_trash'  => __('No footer widgets found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Footer Widgets'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Footer Widget'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'supports' => array('title','custom-fields'),
	);

	register_post_type( 'footer_widget', $args );
}
add_action('init', 'footer_widget');

function show_footer_widgets() {
	$fWidgetsArgs = array(
		'post_type' => 'footer_widget',
	);

	query_posts( $fWidgetsArgs );

	echo '<section id="widgets">';
	echo '<div class="wrap clearfix">';

	if(have_posts()) : while (have_posts()) : the_post();	
		$thisID = get_the_ID();

		$f_widget = array(
			'title' => get_the_title(),
			'content' => get_field('content'),
			'is_disabled' => get_field('disabled') == 'true' ? true : false, // TRUE if disabled
			'edit' => get_edit_post_link( $thisID ),
		);

		 // Skip slider item if it's expired
		if( $f_widget['is_disabled']  ) continue;

		echo '<div class="widget"><h1>';
		echo $f_widget['title'];
		echo '</h1><p>';
		echo $f_widget['content'];
		edit_post_link( 'Edit Widget', '<span class="edit_footer_widget">', '</span>' );
		echo '</p></div>';

		echo '</li>';

	endwhile; endif; wp_reset_query();

	echo '</div>';
	echo '</section>';
}

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
		$expires = get_field('expires');
		$isExpired = trim( get_field('expires') ) != '' ? 
			( strtotime( get_field('expires') ) < time() ? true : false )
			: false;

		$slide = array(
			'title' => get_field('title'),
			'content' => get_field('content'),
			'image' => get_field('image'),
			'position' => ucwords( get_field('position') ),
			'is_disabled' => get_field('disabled') == 'true' ? true : false, // TRUE if disabled
			'is_expired' => $isExpired, // TRUE if expired
			'edit' => get_edit_post_link( $thisID ),
		);

		 // Skip slider item if it's expired
		if( $slide['is_expired'] || $slide['is_disabled']  ) continue;

		echo <<<SLIDE
			<li class="slide{$slide['position']}">
				<h2>{$slide['title']}</h2>
				<img src="{$slide['image']}" />
				<p>{$slide['content']}</p>
SLIDE;
		edit_post_link( 'Edit This Slide', '', '' );
		echo '</li>';

	endwhile; endif; wp_reset_query();

	echo '</ul>';
	echo '</div>';
}

add_filter('title_save_pre','custom_titles');

function custom_titles() {
	$postID = get_the_ID();
	$postType = $_POST['post_type'];
	$title = $_POST['post_title'];

	// Update post first, but prevent infinite loop (happens when post type = revision)
	// if( $postType != 'revision' ){
	// 	wp_update_post( $postID );
	// }

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
	} else {
		$title = $title;
	}

	// Only return title if it has been successfully generated
	if( $title != '' ) return $title;
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
		'supports' => array('custom-fields'),
	);

	register_post_type( 'mainlink', $args );
}
add_action('init', 'mainLink');

function show_main_links() {
	$mainLinkArgs = array( 
		'post_type' => 'mainlink',
		'orderby' => 'modified',
		'order' => 'ASC',
	);

	query_posts( $mainLinkArgs );

	if(have_posts()) : while (have_posts()) : the_post();			
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$mainLink = array(
			'title' => get_field('title'),
			'link' => get_field('link'),
			'image' => get_field('image'),
			'slice' => ucwords(get_field('slice')),
			'open' => get_field('open'),
		);

		echo <<<MAINLINK
			<div style="background-image: url({$mainLink['image']})" class="slice{$mainLink['slice']}">
				<h2><a href="{$mainLink['link']}" target="_{$mainLink['open']}">{$mainLink['title']}</a></h2>
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

		echo <<<SOCIAL
			<li>
				<a href="{$social['link']}" title="{$social['label']}" class="{$social['type']}"></a>
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
			'rewrite' => array( 'slug' => 'group' )
		)
	);
}
add_action( 'init', 'people_cat' ); 

function show_people_cats( $displayCats = true ) {
	$cats = get_terms( 'people_cat' );
	if( !empty( $cats ) ){
		
		foreach ($cats as $cat){
			$peopleCatList .= '<li><a href="' . esc_attr(get_term_link($cat, 'people_cat' )) . '" title="' . sprintf(__('View All %s', 'my_localization_domain'), $cat->name) . '">' . $cat->name . '</a></li>';
		}
		if( $displayCats ){
			echo '<ul id="people_cats" class="children" style="display:none;">';
			echo $peopleCatList;
			echo '</ul>';
		}
	}
	return $peopleCatList;
}

function show_person( $id ) {

	// All fields beginning with 'p_' are default fields that don't appear as tabular data
	$person = array(
		'p_first_name'  => get_field('first_name'),
		'p_last_name'   => get_field('last_name'),
		'p_photo'       => get_field('headshot'),
		'p_phone'       => get_field('phone'),
		'p_email'       => get_field('email'),
		'p_location'    => get_field('location'),
		'p_position'    => get_field('position'),
		'biography' => get_field('biography'),
		'research'  => '<p>'.get_field('research_areas').'</p>',
		'misc'      => get_field('miscellaneous'),
		'p_cv'          => get_field('curriculum_vitae'),
		'p_link'        => get_permalink(),
	);

	// Create array of tabs to display (and populate them), only if content exists
	$contentTabs = '<ul class="personTabs">';
	$content = '<ul class="personContent">';
	foreach  ($person as $field => $value ) {
		if( substr( $field, 0, 2 ) != 'p_' && !empty($value) ){
			$contentTabs .= '<li><a href="#person_' . $field . '">' . $field . '</a>';
			$content     .= '<li id="person_' . $field . '">' . $value . '</li>';
		}
	}
	$contentTabs .= '</ul>';
	$content .= '</ul>';

	echo <<<PERSON
	<article class="person clearfix">
		<figure><img src="{$person['p_photo']}"/></figure>
		<ul class="personBasics">
			<li class="person_position">{$person['p_position']}</h3>
			<li class="person_location">{$person['p_location']}</h3>
			<li class="person_phone">{$person['p_phone']}</h3>
			<li class="person_email"><a href="mailto:{$person['p_email']}">{$person['p_email']}</a></h3>
			<li class="person_cv"><a href="{$person['p_cv']}">Curriculum Vitae</a></li>

		</ul>
	</article>

	{$contentTabs}
	{$content}
PERSON;
}

// Displays list of people based on category (default: all)
function show_people( $catID = 0 ) { 
	// Search for Post with Custom Post Type "people"
	// if( $catID == 0){
	// 	$facultyArgs = array( 
	// 		'post_type' => 'people',
	// 	);
	// 	query_posts( $facultyArgs );
	// } else {
	if( $catID ){
		$facultyArgs = array( 
			'post_type' => 'people',
			'people_cat' => $catID,
			'posts_per_page' => -1,
		);
	} else {
		$facultyArgs = array( 
			'post_type' => 'people',
			'posts_per_page' => -1,
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
			'research_ex' => excerpt(get_field('research_areas'), 140),
			'cv'          => get_field('curriculum_vitae'),
			'link'        => get_permalink(),
		);


		// display person if person is in category, or category is 'all'
		echo <<<PEOPLE
		<article class="person clearfix">
			<figure><img src="{$person['photo']}" /></figure>
			<ul class="personBasics">
				<h2><a href="{$person['link']}" class="personLink">{$person['first_name']} {$person['last_name']}</a></h2>
				<li class="person_position">{$person['position']}</h3>
				<li class="person_location">{$person['location']}</h3>
				<li class="person_phone">{$person['phone']}</h3>
				<li class="person_email"><a href="mailto:{$person['email']}">{$person['email']}</a></li>
				<li class="person_research">{$person['research_ex']}</li>
			</ul>
			<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
		</article>
PEOPLE;

	endwhile; endif; wp_reset_query();
	echo '</div>';
}

//Shortcode for displaying all people
add_shortcode('show_people', 'show_people');


// Custom Post Type for Contact information
function contact() {
	$args = array(
	'label'           => __('Contact Info'),
	'singular_label'  => __('Contact Info'),
	'public'          => true,
	'show_ui'         => true,
	'capability_type' => 'post',
	'hierarchical'    => true,
	'rewrite'         => true,
	'supports'        => array('custom-fields')
	);
	register_post_type( 'contact' , $args );
}
add_action('init', 'contact');



/******Contact Us Home Page Info*****/
//Function to insert Home Featured Areas into ShortCode
function show_contact_area(){

	//Search for Post with Custom Post Type "HomeContact"
	$contactArgs = array( 'post_type' => 'contact' );
	query_posts( $contactArgs );

	if(have_posts()) : while (have_posts()) : the_post();			
		//Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();
		
		//Grab the Custom Field info from the HomeContact CPT
		//The second variable in the function is whatever you named your variables
		$contact = array(
			'dept' => get_field('dept'),
			'address'    => get_field('address'),
			'email'      => '<a href="mailto:'.get_field('email').
				'">'.get_field('email').'</a>',
			'fax'        => 'F: ' . get_field('fax'),
			'phone'      => 'P: ' . get_field('phone'),
		);

		// Break each category into list items
		foreach($contact as $key => &$value){
			$value = '<li>' . str_replace("\n", "</li><li>", $value) . '</li>';
		};

		// Display the list items in this format:
		echo <<<CONTACT
			<h2><span class='_1'>Contact Us</span></h2>

			<ul id="contact_department">
				<span class="contactIcon"></span>
				{$contact['dept']}
			</ul>

			<ul id="contact_address">
				<span class="contactIcon"></span>
				{$contact['address']}
			</ul>
			<ul id="contact_phone">
				<span class="contactIcon"></span>
				{$contact['phone']}
				{$contact['fax']}
			</ul>
			<ul id="contact_email">
				<span class="contactIcon"></span>
				{$contact['email']}
			</ul>
CONTACT;

	break; // Prevent loop from displaying more than one post, just in case.

	endwhile; endif; wp_reset_query();

	return true;
}

//Function to add the shortcode for the Custom Post Type- for use in editor
function home_insert_contact($atts, $content=null){
	$events = home_contact_area();
	return $events;
}
//Shortcode for adding contact area
add_shortcode('home_contact', 'home_contact_area');



// Breadcrumbs
function breadcrumbs() {
 
  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '<span class="crumbSep">&raquo;</span>'; // delimiter between crumbs
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
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'starkers' ),
	) );
}
endif;

if ( ! function_exists( 'starkers_menu' ) ):
/**
 * Set our wp_nav_menu() fallback, starkers_menu().
 *
 * @since Starkers HTML5 3.0
 */
function starkers_menu() {
	echo '<nav><ul><li><a href="'.get_bloginfo('url').'">Home</a></li>';
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
		'description' => __( 'The primary widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Bottom Sidebar', 'starkers' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'starkers' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
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
	register_sidebar( array(
		'name' => __( 'Center Footer Widget Area', 'starkers' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'starkers' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );

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

	// // Area 6, located in the footer. Empty by default.
	// register_sidebar( array(
	// 	'name' => __( 'Fourth Footer Widget Area', 'starkers' ),
	// 	'id' => 'fourth-footer-widget-area',
	// 	'description' => __( 'The fourth footer widget area', 'starkers' ),
	// 	'before_widget' => '',
	// 	'after_widget' => '',
	// 	'before_title' => '<h1 class="title">',
	// 	'after_title' => '</h1>',
	// ) );
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
endif;