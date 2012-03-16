		<!-- Addition of Footer sidebars in theme -->
        <div id="footer-sidebar" class="secondary">		<div style="clear:both;"></div>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
        <?php endif; ?>        
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer2") ) : ?>
        <?php endif; ?>        
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer3") ) : ?>
        <?php endif; ?>        
		</div>        
		<div style="clear-both"></div>
        <!-- End Addition of Footer sidebars in theme -->
        
        <div id="footer">
			<h2><span>UCF</span>College of Sciences</h2>&nbsp;&nbsp;&nbsp;
            <a href="http://biology.cos.ucf.edu">Biology</a>&nbsp;&nbsp;&nbsp;
            <a href="http://chemistry.cos.ucf.edu">Chemistry</a>&nbsp;&nbsp;&nbsp;
            <a href="http://communication.cos.ucf.edu">Communication</a>&nbsp;&nbsp;&nbsp;
            <a href="http://math.cos.ucf.edu">Mathematics</a>&nbsp;&nbsp;&nbsp;
            <a href="http://physics.cos.ucf.edu">Physics</a>&nbsp;&nbsp;&nbsp;
            <a href="http://politicalscience.cos.ucf.edu">Political Science</a>&nbsp;&nbsp;&nbsp;
            <a href="http://psychology.cos.ucf.edu">Psychology</a>&nbsp;&nbsp;&nbsp;
            <a href="http://sociology.cos.ucf.edu">Sociology</a>&nbsp;&nbsp;&nbsp;
            <a href="http://statistics.cos.ucf.edu">Statistics</a>&nbsp;&nbsp;&nbsp;
            <br />
            <small>&copy;<?php echo date("Y"); echo " "; ?> University of Central Florida, College of Sciences, All Rights Reserved</small>
		</div>

	</div>

	<?php wp_footer(); ?>
	
	<!-- Don't forget analytics -->
	
</body>

</html>
