<?php

/*
Plugin Name: Envato FlexSlider
Plugin URI: 
Description: A simple plugin that integrates FlexSlider (http://flex.madebymufffin.com/) with WordPress using custom post types!
Author: Joe Casabona
Version: 0.5
Author URI: http://www.casabona.org
*/

/*Some Set-up*/
define('EFS_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('EFS_NAME', "Envato FlexSlider");
define ("EFS_VERSION", "0.5");

/*Files to Include*/
require_once('slider-img-type.php');


/*Add the Javascript/CSS Files!*/
wp_enqueue_script('flexslider', EFS_PATH.'jquery.flexslider-min.js', array('jquery'));
wp_enqueue_style('flexslider_css', EFS_PATH.'flexslider.css');


/*Add the Hooks to place the javascript in the header*/

function efs_script(){

print '<script type="text/javascript" charset="utf-8">
  jQuery(window).load(function() {
    jQuery(\'.flexslider\').flexslider();
  });
</script>';

}

add_action('wp_head', 'efs_script');

function efs_get_slider(){
	
	$slider= '<div class="flexslider">
	  <ul class="slides">';

	$efs_query= "post_type=slider-image";
	query_posts($efs_query);
	
	
	if (have_posts()) : while (have_posts()) : the_post(); 
		$img= get_the_post_thumbnail( $post->ID, 'large' );
		
		//Code for Captions
		//Get custom fields
		//Get the first 230 characters for the image description		
		$caption= substr(get_the_content(), 0, 230);
		//Get the Image title
		$captionTitle = the_title('','',false);
		$slider.='<li>'.$img;
		$slider.= '<span class="flexCaptionTitle">'.$captionTitle.'</span>';
		$slider.= '<span class="flexCaptionDescription">'.$caption.'...</span>';
		$slider.= '</li>';
			
	endwhile; endif; wp_reset_query();


	$slider.= '</ul>
	</div>';
	
	return $slider;
}


/**add the shortcode for the slider- for use in editor**/

function efs_insert_slider($atts, $content=null){

$slider= efs_get_slider();

return $slider;

}

/* Actual shortcode to insert the slider */
add_shortcode('ef_slider', 'efs_insert_slider');



/**add template tag- for use in themes**/

function efs_slider(){

	print efs_get_slider();
}


?>