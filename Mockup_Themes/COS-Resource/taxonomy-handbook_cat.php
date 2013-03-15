<?php
/**
 * The Template for displaying custom taxonomies (Meeting Type).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

<section id="main_content">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php //get_search_form(); 
	/*

		<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
			<?php if(get_option('COS_pagenav_type')=='custom') {
				custom_menu_nav();
			} else {
				page_nav(); 
			}?>
			<?php if(get_option('COS_show_sidebar')=='show') {
				get_sidebar();
			}?>
		</div>	
	*/?>
<?php
	//Enable pagniation
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$args = array(
		'post_type' => 'handbook',
		/*Filter only the taxonomies of minutes_cat that equal the slug of the page we're on*/
		'handbook_cat' => $term->slug, 		
		'orderby' => 'name',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'paged' => $paged,
	);

	query_posts($args); 

	//Grab the current term's parent
	$parentTermID = $term->parent;

	//If the current term is a child term, grab the parent's info
	if($parentTermID != '0')
		$parentTerm = get_term_by('id', $parentTermID, get_query_var( 'taxonomy' ));
?>	
		<div class="innerContent fullwidth" id="meetings">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<?php
						//If current term is a child term print the parent's name
						if($parentTerm != '')
							echo "<h1>$parentTerm->name ";
						else  
							echo "<h1>$term->name ";
					?>					
						Handbook</h1>
				</header>							
				<div class='meeting-span2'><h6></h6></div>
		<?php if( have_posts() ) : ?>					
				
			<?php
				while( have_posts() ) : the_post();
				$thisID = $post->ID;
				/*Grabs all the taxonomies of the minutes_cat post type associated with the current post*/
				$cats =  get_the_terms($thisID, "handbook_cat");				

				foreach ($cats as $cat) {					
					/*If the current post's taxonomy matches the taxonomy of the page then display it*/
					if($cat->term_id == $term->term_id): ?>					
				
						
						<div class="handbook_title"><a class="title"><span></span><?php echo the_title();?></a>
							<div class="handbook_content"><?php echo the_content();?>
							<!-- <footer>
								<?php edit_post_link( __( 'Edit Handbook Entry', 'starkers' ), '', '' ); ?>
							</footer>  -->
							<?php edit_post_link( __( 'Edit Page', 'starkers' ), '', '' ); ?>					
							</div>
					
							

						</div>
					<?php  endif; 
				}
			?>		
																
				<?php endwhile;  ?>
			
		

		<?php 
			posts_nav_link();
			else:
				echo "<h3>There are no entries at this time.  Please check back soon.</h3>";
			endif; 
		?>
			<div style="clear:both;"></div>
		
			</article>				
		</div>


	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>