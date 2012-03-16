<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.2
 */
?>

<section id="main_content">
	<div class="wrap clearfix">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
		<div class="innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<?php if ( is_front_page() ) { ?>
						<h2><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h1><?php the_title(); ?></h1>
					<?php } ?>
				</header>				

					<?php the_content(); ?>
							
					<?php wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'starkers' ), 'after' => '</nav>' ) ); ?>
							
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>

		<nav class="pageNav">
			<h2><?php the_title(); ?></h2>
			<ul>
		<?php
			$pageID = get_query_var('page_id');
			$pageNavArgs = array( 
				'child_of' => $pageID,
				'title_li' => '',
			);

			wp_list_pages( $pageNavArgs );
		?>
			</ul>
		</nav>
<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>
