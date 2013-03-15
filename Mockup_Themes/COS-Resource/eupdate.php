<?php
/*
Template Name: eUpdate List
*/
?>
<?php get_header(); ?>

<section id="main_content">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	
		<? /*<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
			<?php people_nav(); ?>
			<?php if(get_option('COS_show_sidebar')=='show') {
				get_sidebar();
			}?>
		</div>	*/ ?>
		<div class="innerContent" style="width: 100%;">
			<article id="eupdates" <?php post_class(); ?> >
				<header>
					<h1><?php the_title(); ?></h1>				
				</header>				
<?php
	

	$curYear = date('Y');
	$firstEntry = true;

	$args = array(
		'post_type' => 'eupdate',		
		'meta_key' => 'date',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'showposts' => -1,	
	);

	$the_query = new WP_Query($args); 
	//$number_of_eupdates = (int)($the_query->post_count / 3)+1;

	//echo "Num: $number_of_eupdates";
	
	$counter = 0;
?>					
<?php if ( $the_query->have_posts() ){
	 
	 while ( $the_query->have_posts() ) : $the_query->the_post(); 
			$meetingYear = substr(get_field('date'), 0, 4);		

			if($firstEntry==true){
				echo "<div class='meeting-span2 year'><h6 class=\"$meetingYear\">$meetingYear eUpdates</h6><ul>";
				$firstEntry = false;
				$counter = 0;
			} elseif($meetingYear < $curYear){

				$curYear = $meetingYear;
				echo "</ul></div><div class='meeting-span2 year'>";
				echo "<h6>$curYear eUpdates</h6><ul>";	
				$counter = 0;
			} elseif($counter >= 20){
				echo "</ul></div><div class='meeting-span3'><ul>";
				$counter = 0;
			}
			$counter++;

?>			
		<li class="minutes"><a href="<?php echo get_field("url"); ?>" target="_blank"><?php the_title();?></a></li>
				
<?php endwhile; ?>
		</ul></div>		
<?php }else{
		echo "<p>There are no <strong>eUpdates</strong> at this time?";
	  } ?>
				
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>