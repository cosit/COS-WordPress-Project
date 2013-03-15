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

	$curYear = date('Y');
	$firstEntry = true;

	$args = array(
		'post_type' => 'minutes',
		/*Filter only the taxonomies of minutes_cat that equal the slug of the page we're on*/
		'minutes_cat' => $term->slug, 
		'meta_key' => 'date',
		'orderby' => 'meta_value',
		'order' => 'DESC',
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
		<div class="innerContent" id="meetings" style="width: 100%;">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<?php
						//If current term is a child term print the parent's name
						if($parentTerm != '')
							echo "<h1>$parentTerm->name ";
						else  
							echo "<h1>$term->name ";
					?>					
						Meeting Minutes</h1>
				</header>							
			
		<?php if( have_posts() ) : ?>									
			<?php
				while( have_posts() ) : the_post();
				$thisID = $post->ID;
				/*Grabs all the taxonomies of the minutes_cat post type associated with the current post*/
				$cats =  get_the_terms($thisID, "minutes_cat");
				
				foreach ($cats as $cat) {					
				/*If the current post's taxonomy matches the taxonomy of the page then display it*/
				

				if($cat->term_id == $term->term_id):

						$meetingYear = substr(get_field('date'), 0, 4);
						
						$title = substr(get_field('date'), 4, 2);		

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
						$day = substr(get_field('date'), 6, 2);

						if($firstEntry==true){
							echo "<div class='meeting-span2'><h6 class=\"$meetingYear\">$meetingYear Minutes</h6><ul>";
							$firstEntry = false;
						}
						elseif($meetingYear < $curYear){

							$curYear = $meetingYear;
							echo "</ul></div><div class='meeting-span2'>";
							echo "<h6>$curYear Minutes</h6><ul>";	
						} ?>	 										
					<li class="minutes"><a href="<?php echo get_permalink(get_the_id()); ?>"><?php echo $title.' '.$day;?></a></li>
				<?php  endif; 
				}?>				
				<?php endwhile;  ?>
			</ul>
			</div>
		<div style="clear:both;"></div>
		
		</article>
		<?php 
			posts_nav_link();
			else:
				echo "<h3>There are no entries at this time.  Please check back soon.</h3>";
			endif; 
		?>
				
		</div>


	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>