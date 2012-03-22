<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
 
get_header(); ?>
 

<section id="slider">
	<!-- jQuery slider will be implemented here, and pulled from 'slider' category of posts -->
	<div class="sliderItems wrap">
		<ul class="slides">
		<?php 
			//Query slider posts
			query_posts( array ( 'category_name' => 'Featured', 'posts_per_page' => -1 ) );

			// Loop slider posts
			while( have_posts() ) : the_post();
				echo '<li><h2>';
				the_title();
				echo '</h2>';
				the_content();
				echo '</li>';
			endwhile;
		?>
	 	</ul>
	</div>
</section>

<!-- Contact box - not a section because it lies on top of slider -->
<div id="contact">
	<?php get_search_form(); ?> <!-- grabs custom search form at searchform.php -->

	<h2>Contact Us</h2>

	<?php home_contact_area(); ?>


</div>

<!-- List all department links for main site (can be hidden) -->
<section id="dept_links">
	<div class="wrap">
		<ul>		
			<li>Anthropology</li>
			<li>Biology</li>
			<li>Etc.</li>
		</ul>
	</div>
</section>

<!-- Main box links for dept websites; e.g. "Undergraduate", "Graduate", "Research" -->
<section id="main_links">
	<div class="wrap">
		<div id="main_link_undergrad">
			<h2>Undergraduate</h2>
		</div>
		<div id="main_link_grad">
			<h2>Graduate</h2>
		</div>
		<div id="main_link_research">
			<h2>Research</h2>
		</div>
	</div>
</section>

<!-- Central content for dept home page - default shown is News + Events -->
<section id="main_content">
	<div class="wrap clearfix">
		<!-- Divs given class of "news" or "events" because they will be adapted for use as a sidebar item -->
		<div class="news">
	 		<h1>News</h1>
			<?php try {
				include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
				$feed = fetch_rss('http://news.cos.ucf.edu/?category_name='.get_bloginfo('title').'&feed=rss2'); // specify feed url
				$items = array_slice($feed->items, 0, 7); // specify first and last item
				} catch(Exception $e) {
					echo '<span class="error">Unable to retrieve feed. Please try again later.</span>';
				}
			?>

				<?php if (!empty($items)) : ?>
				<?php foreach ($items as $item) : ?>
				<article>
					<h2><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></h2>
					<p><?php echo str_replace('[...]', '... <a href="'.$item['link'].'">Read more</a>', $item['description']); ?></p>
					<aside><?php echo substr($item['pubdate'], 0, 16); ?></aside>
				</article>
				<?php endforeach; ?>
				<?php endif; ?>
		</div>

		<div class="events">
			<h1>Events	</h1>
			<?php try {
				include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
				$feed = fetch_rss('http://events.ucf.edu/?calendar_id=217&upcoming=upcoming&format=rss&limit=100'); // specify feed url
				$items = array_slice($feed->items, 0, 7); // specify first and last item
				} catch(Exception $e) {
					echo '<span class="error">Unable to retrieve feed. Please try again later.</span>';
				}
			?>

			<?php if (!empty($items)) : ?>

			<?php foreach ($items as $item) : ?>
				<article>

					<span class="eventDate"><?php echo substr($item['ucfevent']['startdate'],5,11); ?> </span>
					<ul class="eventInfo">
						<li class="eventTitle"><a href="<?php echo $item['link']; ?>" title="<?php echo($item['title']); ?>"
							<?php echo(substr($item['title'],0,43)==$item['title']?
								'>'.$item['title']
								:' class="expandEventTitle">'.substr($item['title'],0,43).'...'); ?>
						</a></li>
						<li class="eventTime"><?php echo substr($item['ucfevent']['startdate'],17,5); ?> - <?php echo substr($item['ucfevent']['enddate'],17,5); ?></li>
						<li class="eventLocation"><?php echo $item['ucfevent']['location_name']; ?></li>
					</ul>
				</article>
			<?php endforeach; ?>
			
			<?php endif; ?>
				<!-- expanded into li.eventMonth, li.eventDay, li.eventYear via jQuery -->
<!-- 		<article>
				<span class="eventDate">07/31/204</span>
				<ul class="eventInfo">
					<li class="eventTitle">Sample Title</li>
					<li class="eventTime">03:00 - 04:00</li>
					<li class="eventLocation">CSB 214</li>
				</ul>
			</article>

			<article>
				<span class="eventDate">04/21/2013</span>
				<ul class="eventInfo">
					<li class="eventTitle">Sample Title Two</li>
					<li class="eventTime">03:00 - 04:00</li>
					<li class="eventLocation">CSB 214</li>
				</ul>
			</article> -->
		</div>
	</div>


</section>
 
<!-- <?php // get_sidebar(); ?>  Sidebar is hidden on main page -->

<?php get_footer(); ?>

