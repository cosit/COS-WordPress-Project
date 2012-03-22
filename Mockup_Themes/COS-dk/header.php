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
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
 
    global $page, $paged;

    $thisDept = get_bloginfo('name');

    echo 'UCF '; // eventually add function to recognize whether this is "UCF" or "COS"

    echo $thisDept;
 
    wp_title( '', true, 'left' ); 
 
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.less" media="all">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" media="all">

 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-1.6.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/less-1.2.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<?php if (is_home()) : ?> <!-- Only download slider if on home page -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>
<?php endif; ?>
 
<?php
    /* We add some JavaScript to pages with the comment form
     * to support sites with threaded comments (when in use).
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
 
    /* Always have wp_head() just before the closing </head>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to add elements to <head> such
     * as styles, scripts, and meta tags.
     */
    wp_head();
?>
</head>
 
<body <?php body_class(); ?>>
 
    <header id="main_header">
        <div class="wrap">
            <ul id="socialMedia">
                <li><a href="http://www.facebook.com" title="Facebook" class="facebook"></a></li>
                <li><a href="http://www.twitter.com" title="Twitter" class="twitter"></a></li>
            </ul>

            <hgroup>
                <h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <span class="branding_prefix">UCF</span><span class=" branding_dept"><?php bloginfo( 'name' ); ?></span>
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