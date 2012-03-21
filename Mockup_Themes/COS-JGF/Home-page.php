<?php
/*
Template Name: Home Page
*/

?>
<?php get_header(); ?>
	<style type="text/css">
	#searchform{		
		background-color: #f5f5f5;
		padding: 0;
		padding-left:7px;
		margin: 15px 0 0 -15px;
		height: 24px;
		width: 197px;
	}
	#searchform input{
		border:none;
		background:#f5f5f5;
	}
	</style>
	<div id="slider_bg">
		<div id="slider_container">
			<?php echo do_shortcode('[ef_slider]');?>
			<?php echo do_shortcode('[home_contact]');?>
		</div>
	</div>
	<div id="fc_bg">
		<?php echo do_shortcode('[home_fa]');?>
	</div>
	<div id="body_bg">
		<div id="body_content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<div class="post-full" id="post-<?php the_ID(); ?>">

					<div class="entry">

						<?php the_content(); ?>

						<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

					</div>

					<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

				</div>
		
				<?php comments_template(); ?>

				<?php endwhile; endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
