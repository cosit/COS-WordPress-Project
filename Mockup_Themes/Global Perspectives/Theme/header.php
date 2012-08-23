<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 9]>     <html id="ie"> <![endif]-->
<!--[if IE 9]>     <html> <![endif]-->
<!--[if !IE]><!--> <html>             <!--<![endif]-->
<head>



<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
 
    global $page, $paged;

    $thisDept = get_bloginfo('name');

    echo $thisDept;

    wp_title( '', true, 'left' ); 
 
?></title>
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">
<!-- <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout_gp.less" media="all"> -->

<!-- Stylesheet for printing -->
<link rel="stylesheet/less" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.less" media="all">

<!-- <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/responsive.less" media="all"> -->

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/ceebox/css/ceebox-min.css" media="all">
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/cos_gp.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/ceebox/js/jquery.ceebox-min.js"></script>
<!--<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-1.6.min.js"></script>-->
<!--<script src="<?php bloginfo('template_directory'); ?>/js/less-1.2.2.min.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>-->

<?php wp_head(); ?>

</head>
 
<body id="gp" <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap clearfix">
            <?php show_social(); ?>

            <hgroup>
                <h1 class="globe_logo" style="font-size: <?php get_option('COS_title_prefix'); ?>;"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class=" branding_dept"><?php bloginfo( 'name' ); ?></span>
                </a></h1>
                <a class="mobile_menu" href="#main_menu">=</a>
            </hgroup>

            <?php wp_nav_menu( array( 
                'theme_location' => 'primary-menu', 
                'container' => 'nav', 
                'fallback_cb' => 'starkers_menu' 
            ) ); ?>

            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>

        </div>

    </header>

<div id="container">