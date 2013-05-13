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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="icon" href="http://www.ucf.edu/img/pegasus-icon.png" type="image/png" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/font-awesome.less" media="all">
<!--[if IE 7]>
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/font-awesome-ie7.less" media="all">
<![endif]-->    
<!--[if gt IE 8]><!-->
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/responsive.less" media="all">
<!--<![endif]-->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.less">

<?php if(is_home()){ ?>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">
<?php } ?>

<?php wp_head(); ?>

</head>
 
<body id="top" <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap clearfix">            
            <hgroup>
                <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo('template_directory'); ?>/css/img/UCF_ICRC_logo.png" alt="ICRC Conference" class="logo" /></a>                    
            </hgroup>
            <?php if ( is_active_sidebar( 'header-above-navigation' ) ) : 
                dynamic_sidebar( 'header-above-navigation' ); 
                  endif; 
            
                  show_social(); 
            ?>        
            <div class="outerNav">
                <h3><i class='icon-calendar'></i><?php echo esc_attr(get_bloginfo('description')); ?></h3>
                <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => 'nav', 'fallback_cb' => 'starkers_menu' ) ); ?>
            </div>

            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>

        </div>

    </header>

<div id="container">