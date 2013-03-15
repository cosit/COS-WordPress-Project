<?php
/**
 * The Template for displaying custom taxonomies (mostly people).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<?php 
	$terms = get_the_terms( $post->ID, 'minutes_cat'); 
	$tax_array = array();
	foreach($terms as $tax_cats){
		$tax_array[] = $tax_cats->name;
	}
	$my_categories = join(" - ", $tax_array);
?>

<section id="main_content">
	<div class="wrap clearfix">
	<?php //if (function_exists('breadcrumbs')) breadcrumbs(); ?>	

		<div class="innerContent fullwidth">	
		<?php if ( have_posts() ) while ( have_posts() ) : the_post();
				
			$title = substr($post->post_title, -8, 2);	

			switch($title){
				case '01': $title = "January"; break;
				case '02': $title = "February"; break;
				case '03': $title = "March"; break;
				case '04': $title = "April"; break;
				case '05'; $title = "May"; break;
				case '06'; $title = "June"; break;
				case '07'; $title = "July"; break;
				case '08'; $title = "August"; break;
				case '09'; $title = "September"; break;
				case '10'; $title = "October"; break;
				case '11'; $title = "November"; break;
				case '12'; $title = "December"; break;
			}			
			?>

			<h1><?php echo $my_categories.' - '.$title; ?> </h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> >
				<h2>Meeting Minutes</h2>
				<?php 	$content = get_field('content');
						echo $content;
						
				 ?> 
				
					<footer>
						<?php edit_post_link( __( 'Edit Meeting Minutes', 'starkers' ), '', '' ); ?>
					</footer>
				</article>
		</div>
	
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>

