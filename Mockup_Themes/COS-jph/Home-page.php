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


<?php get_footer(); ?>
