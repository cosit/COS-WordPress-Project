<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); 

?>

<section id="main_content">
	<div class="wrap clearfix">
		<div id="breadcrumbs" class="wrap">
			<a href="http://communication.cos.ucf.edu/nicholsonresource">Home</a> <span class="crumbSep"> &raquo; </span> 
			<a href="#">Search</a>
		</div>	
		<?php //get_search_form(); ?>
		<div id="search_results" class="innerContent fullwidth">
<?php if (have_posts()) : ?>
			<h1><?php printf( __( 'Search Results for: <span>%s</span>', 'starkers' ), '' . get_search_query() . '' ); ?></h1>

			<?php while (have_posts()) : the_post(); 

					$the_post_type = get_post_type();
					$post_title = the_title('','',false);

					$post_minute_type = substr($post_title, 0, strpos($post_title, '-'));
					$post_date = substr($post_title, strpos($post_title, '-')+1);

					if($post_minute_type == 'ccd')
						$post_title = "COS Chairs &amp; Directors";
					elseif($post_minute_type == 'nscac')
						$post_title = "NSC Area Coordinators";
					elseif($post_minute_type == 'nscf')
						$post_title = "NSC Faculty";
					
			?>
				<div <?php post_class('search-seperator') ?> id="post-<?php the_ID(); ?>">
					<?php 	if ($the_post_type == "minutes"){ ?>
								<h2><a href="?page_id=<?php the_ID();?>"><?php echo $post_title." Minutes: $post_date";?></a></h2>
							<?php }else{ ?>
								<h2><a href="?page_id=<?php the_ID();?>"><?php the_title();?></a></h2>
					 		<?php } ?>
						
					<div class="entry">
						<?php							

							if($the_post_type == "minutes"){								
								$text = get_field('content'); 
								$my_excerpt = strip_tags(substr( $text, 0, 250));
								$my_excerpt .= "<a href=\"?page_id=".get_the_ID()."\">[...]</a>";
								
								echo $my_excerpt;
							} else
								the_excerpt(); 
						?>
					</div>
				</div>
			<?php endwhile; ?>
	
			<?php
				kriesi_pagination('','2');

				get_template_part( 'loop', 'search' );
			?>

	<?php else : ?>

		<h1><?php printf( __( 'Nothing Found for: <span>%s</span>', 'starkers' ), '' . get_search_query() . ''); ?></h1>
			<h2><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'starkers' ); ?></h2>
	<?php endif; ?>

		</div> <!-- End innerContent -->
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>