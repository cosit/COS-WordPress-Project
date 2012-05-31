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

<!-- ADD UCF HEADER -->
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<!-- END UCF HEADER -->

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
 
    global $page, $paged;

    $thisDept = get_bloginfo('name');
    $brandingPrefix = get_option('COS_title_prefix');

    echo $brandingPrefix . ' ' . $thisDept;

    wp_title( '', true, 'left' ); 
 
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">



 
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
<!--<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>-->
<!--<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-1.6.min.js"></script>-->
<!--<script src="<?php bloginfo('template_directory'); ?>/js/less-1.2.2.min.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>-->
<?php wp_head(); ?>



</head>
 
<body name="top" <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap clearfix">
            <?php show_social(); ?>

            <hgroup>
                <h1 style="font-size: <?php get_option('COS_title_prefix'); ?>"><span class="branding_prefix"><?php echo( $brandingPrefix ); ?></span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class=" branding_dept"><?php bloginfo( 'name' ); ?></span>
                </a></h1>
            </hgroup>

            <?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to the 'starkers_menu' function which can be found in functions.php.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
            <?php wp_nav_menu( array( 
                'container' => 'nav', 
                'fallback_cb' => 'starkers_menu', 
                'theme_location' => 'primary' 
            ) ); ?>
            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>

        </div>

    </header>


<div id="container">