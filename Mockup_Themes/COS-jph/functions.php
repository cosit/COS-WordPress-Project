<?php
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
		
    }
	//Function for Footer Widget Areas
	//Footer Widget 1
	if ( function_exists('register_sidebar') ){
		register_sidebar(array(
			'name' => 'Footer',
			'before_widget' => '<div class="footer-sidebar1">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}
	//Footer Widget 2
	if ( function_exists('register_sidebar') ){
		register_sidebar(array(
			'name' => 'Footer2',
			'before_widget' => '<div class="footer-sidebar2">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}
	//Footer Widget 3	
	if ( function_exists('register_sidebar') ){
		register_sidebar(array(
			'name' => 'Footer3',
			'before_widget' => '<div class="footer-sidebar3">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}		

	//Menu Support
	add_theme_support('nav-menus');
	
	//Register the Main Menu
	register_nav_menu('main', 'Main Navigation Menu');
	
	//Register Side Menu
	register_nav_menu('side_nav', 'Side Navigation Menu');

	//Add Thumbnail Support to Theme
	add_theme_support('post-thumbnails');

	/******Turn off WordPress Auto Paragraph******/
	//Turn off all WordPress Auto Paragraph
	remove_filter('the_content','wpautop');

	 /******End WordPress Auto Paragraph******/


	 /******Home Featured Area******/
	//Custom Post Type for Home Featured Areas below the slider
	//Like Graduate, Undergraduate, Research
	function homeFeatured() {
		$args = array(
		'label' => __('Home_FC'),
		'singular_label' => __('Home_FCs'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
		);
		register_post_type( 'home_FC' , $args );
	}
	add_action('init', 'home_FC');


	//Function to insert Home Featured Areas into ShortCode
	function home_featured_areas(){
		
		$slider= '<div id="fc_Container">';

		$fc_query="post_type=Home_FC";
		query_posts($fc_query);

		if(have_posts()) : while (have_posts()) : the_post();
			$img= get_the_post_thumbnail( $post->ID, 'large');

			$fc_title= the_title('','',false);

			$slider.= '<div class="fc_homepage">';	
			$slider.= $img;
			$slider.= '<span class="fc_title">'.$fc_title.'</span>';
			$slider.= '</div>';			

		endwhile; endif; wp_reset_query();

		
		$slider.= '</div><div class="clear"></div>';

		return $slider;
	}

	//Function to add the shortcode for the Custom Post Type- for use in editor
	function home_insert_fa($atts, $content=null){

		$events = home_featured_areas();
		return $events;
	}

	//Shortcode for adding Custom Post Type
	add_shortcode('home_fa', 'home_insert_fa');
	/******End of Home Featured Areas*****/



	/******Contact Us Home Page Info*****/
	//Custom Post Type for Contact Information that
	//shows up in a box on the slider
	function homeContact() {
		$args = array(
		'label' => __('HomeContact'),
		'singular_label' => __('HomeContacts'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'supports' => array('title', 'custom-fields')
		);
		register_post_type( 'homeContact' , $args );
	}
	add_action('init', 'homeContact');
	
	//Function to insert Home Featured Areas into ShortCode
	function home_contact_area(){
		
		$homeContactInfo= '<div class="homeContactArea">';

		$fc_query="post_type=HomeContact";
		query_posts($fc_query);

		if(have_posts()) : while (have_posts()) : the_post();			
			//Grab the Post ID for the Custom Fields Function			
			$thisId = get_the_ID();
			

			//Drop in the Search Bar Content
			ob_start();
			include('searchform.php');
			$searchContents = ob_get_contents();
			ob_end_clean();
			$homeContactInfo .= $searchContents;

			//Grab the Title
			$hc_title= the_title('','',false);

			//Grab the Custom Field info from the HomeContact CPT
			$homeAddress= get_post_meta($thisId, 'Address', true);
			$homeDepartment= get_post_meta($thisId, 'Department', true);
			$homeEmail= get_post_meta($thisId, 'Email', true);
			$homeFax= get_post_meta($thisId, 'Fax', true);
			$homePhone= get_post_meta($thisId, 'Phone', true);

			$homeContactInfo.= '<span id="homeContactTitle">'.$hc_title.'</span>';
			$homeContactInfo.= '<span class="homeContactInner2">'.$homeDepartment.'</span>';
			$homeContactInfo.= '<span class="homeContactInner1">'.$homeAddress.'</span>';
			$homeContactInfo.= '<span class="homeContactInner2">P: '.$homePhone.' <br />F: '.$homeFax.'</span>';
			$homeContactInfo.= '<span class="homeContactInner1"><a href="mailto:'.$homeEmail.'">'.$homeEmail.'</a></span>';
			

		endwhile; endif; wp_reset_query();

		
		$homeContactInfo.= '</div><div class="clear"></div>';

		return $homeContactInfo;
	}

	//Function to add the shortcode for the Custom Post Type- for use in editor
	function home_insert_contact($atts, $content=null){

		$events = home_contact_area();
		return $events;
	}

	//Shortcode for adding Custom Post Type
	add_shortcode('home_contact', 'home_insert_contact');

	/******Home Page News*****/
	//Function to parse News section RSS feed
	function parseNewsFeed(){

	}

?>