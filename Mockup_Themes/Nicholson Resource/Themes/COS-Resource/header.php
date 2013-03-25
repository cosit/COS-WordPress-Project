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
    $titleFontSize = get_option('COS_title_size');
    $brandingPrefix = get_option('COS_title_prefix');
    $brandingLink = '';

    if($brandingPrefix == "COS")
        $brandingLink = "http://www.cos.ucf.edu/";
    elseif($brandingPrefix == "UCF")
        $brandingLink = "http://www.ucf.edu";       

    if(!is_home()){ wp_title( '', true, 'left' ); echo " - "; } 
    echo $brandingPrefix . ' ' . $thisDept;     

    wp_title( '', true, 'left' ); 
 
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel='shortcut icon' href='http://communication.cos.ucf.edu/main/wp-content/themes/UCF-Nicholson/static/img/favicon.ico'/> 
<?php if(is_home()): ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body id="top" <?php body_class(); ?>>
    <header id="main_header">
        <div class="wrap clearfix">
            <?php show_social(); ?>

            <hgroup id="header_title">
                <h1 style="font-size: <?php echo $titleFontSize; ?>px !important;"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class=" branding_dept"><?php bloginfo( 'name' ); ?></span>
                </a></h1>
                <h2><a href="http://communication.cos.ucf.edu"><?php bloginfo('description'); ?></a></h2>
            </hgroup>

            <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => 'nav', 'fallback_cb' => 'starkers_menu' ) ); ?>

            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>

        </div>
    </header>
<div id="container">