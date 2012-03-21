	<div id="widget_bg">
        <div id="widget_container">	
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
        </div>
    </div>
        


	<!-- </div> -->

    <div id="site-generator">
                <a href="http://www.cos.ucf.edu" class="link-to-cos"><span class="cos_f">UCF</span> College of Sciences</a>
                <a href="http://anthropology.cos.ucf.edu" class="dept">Anthropology</a>
                <a href="http://biology.cos.ucf.edu" class="dept">Biology</a>
                <a href="http://chemistry.cos.ucf.edu" class="dept">Chemistry</a>
                <a href="http://communication.cos.ucf.edu" class="dept">Communication</a>
                <a href="http://math.ucf.edu" class="dept">Mathematics</a>
                <a href="http://physics.cos.ucf.edu" class="dept">Physics</a>
                <a href="http://politicalscience.cos.ucf.edu" class="dept">Political Science</a>
                <a href="http://psychology.cos.ucf.edu" class="dept">Psychology</a>
                <a href="http://sociology.cos.ucf.edu" class="dept">Sociology</a>
                <a href="http://statistics.cos.ucf.edu" class="dept">Statistics</a>
                <p>
            <small>&copy;<?php echo date("Y"); echo " "; ?> University of Central Florida, College of Sciences, All Rights Reserved</small>
        </div>

	<?php wp_footer(); ?>
	
	<!-- Don't forget analytics -->
	
</body>

</html>
