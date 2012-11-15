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
<!--[if lt IE 9]>  <html id="ie"> <![endif]-->
<!--[if IE 9]>     <html> <![endif]-->
<!--[if !IE]><!--> <html> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
 
    global $page, $paged;

    $thisDept = get_bloginfo('name');
    $brandingPrefix = get_option('COS_title_prefix');
    $brandingLink = '';

    if($brandingPrefix == "COS")
        $brandingLink = "http://www.cos.ucf.edu/";
    elseif($brandingPrefix == "UCF")
        $brandingLink = "http://www.ucf.edu"; 

    echo $brandingPrefix . ' ' . $thisDept;

    wp_title( '', true, 'left' ); 
 
?></title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">

<!-- Stylesheet for printing -->
<link rel="stylesheet/less" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.less" media="all">
<!-- <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/responsive.less" media="all"> -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">

<link rel="icon" href="http://www.ucf.edu/img/pegasus-icon.png" type="image/png" />
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>

<?php wp_head(); ?>

</head>
 
<body id="top" <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap clearfix">
            <?php show_social(); ?>

            <hgroup>
                <h1 style="font-size: <?php get_option('COS_title_prefix'); ?>"><span class="branding_prefix"><?php echo "<a href=".$brandingLink.">".$brandingPrefix."</a>" ; ?></span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class=" branding_dept"><?php bloginfo( 'name' ); ?></span>
                </a></h1>
                <a class="mobile_menu" href="#main_menu">=</a>
            </hgroup>

            <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => 'nav', 'fallback_cb' => 'starkers_menu' ) ); ?>

            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>

        </div>

    </header>

<div id="container">