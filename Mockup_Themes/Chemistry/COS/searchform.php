<form role="search" method="get" id="<?php if(!is_front_page()) echo 'inner_'; ?>searchform" action="<?php echo home_url( '/' ); ?>" >
    <div>
        <input type="text" value="Search <?php bloginfo( 'name' ); ?>..." name="s" id="s" />
    </div>
</form>