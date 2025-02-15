<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<section id="main_content">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php //get_search_form(); ?>	
	<div class="innerConent fullwidth" >
		
			
				<h1><?php
					printf( __( 'Category Archives: %s', 'starkers' ), '' . single_cat_title( '', false ) . '' );
				?></h1>
			
			
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<h3>' . $category_description . '</h3>';

				get_template_part( 'loop', 'category' ); 

				?>
			
	</div>

</div> 
</section>

<?php get_footer(); ?> 