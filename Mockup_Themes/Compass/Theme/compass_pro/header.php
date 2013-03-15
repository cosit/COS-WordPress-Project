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

<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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

    if(!is_home()){ wp_title( '', true, 'left' ); echo " - "; } 
    echo $brandingPrefix . ' ' . $thisDept;  
 
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">

<!-- Stylesheet for printing -->
<link rel="stylesheet/less" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.less" media="all">
<!-- Stylesheed for Responsive -->
<!-- <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/responsive.less" media="all"> -->

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php if(is_home()): ?>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">
<?php endif; ?>

<!-- Hook up the FlexSlider -->
<script type="text/javascript">
    $(window).load(function() {
        $('.sliderItems').flexslider({
                    animation: "fade",
            slideshow: "true",
            slideshowSpeed: 7000,
            directionNav: true,
            controlNav: true
        });
    });
</script>
<!-- ADD UCF HEADER -->
<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');     bsa.type = 'text/javascript';     bsa.async = true;
     bsa.src = 'http://universityheader.ucf.edu/bar/js/university-header.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
<!-- END UCF HEADER -->
<?php wp_head(); ?>
</head>
 
<body id="top" <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap clearfix">
            <?php show_social(); ?>

            <hgroup>
                 <h1><span class="branding_prefix"><?php echo "<a href=".$brandingLink.">".$brandingPrefix."</a>" ; ?></span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class="branding_dept">C&nbsp;&nbsp;&nbsp;&nbsp;MPASS</span>
                </a></h1>
                <a class="mobile_menu" href="#main_menu">=</a>
            </hgroup>

            <span id="tagline"><?php echo get_bloginfo ( 'description' ); ?></span>

            <!-- <span id="contactNav">Contact Us - <a href="mailto:compass@ucf.edu">COMPASS@ucf.edu</a></span> -->
            <?php wp_nav_menu( array( 
                'theme_location' => 'primary-menu', 
                'container' => 'nav', 
                'fallback_cb' => 'starkers_menu' 
            ) ); ?>

            <span id="pageID" style="display:none;"><?php echo get_query_var('page_id'); ?></span>            
        <hr />
        </div>

    </header>
<div id="container">