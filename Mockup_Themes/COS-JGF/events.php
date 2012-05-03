<?php
/*
Template Name: Events List
*/
?>
<?php get_header(); ?>
<section id="main_content" class="subPage">
	<div class="wrap clearfix">
		<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
		<div class="events subPage">
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
						<li class="eventTitle"><h2><a href="<?php echo $item['link']; ?>" title="<?php echo($item['title']); ?>"
							<?php echo(substr($item['title'],0,43)==$item['title']?
								'>'.$item['title']
								:' class="expandEventTitle">'.substr($item['title'],0,43).'...'); ?>
						</a></h2></li>
						<li class="eventTime"><?php echo substr($item['ucfevent']['startdate'],17,5); ?> - <?php echo substr($item['ucfevent']['enddate'],17,5); ?></li>
						<li class="eventLocation"><?php echo $item['ucfevent']['location_name']; ?></li>
						<li class="eventDescription"><?php echo $item['description']; ?></li>
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
		</div> <!-- /events -->
	</div>
</section>

<?php get_footer(); ?>