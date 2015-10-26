<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Discover Travel
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="top-bar" class="site-top">
        <div class="container clearfix">
            <nav class="language col-sm-4">
                <ul>
                    <li class="en"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/en.png"></li>
                    <li class="kh"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/kh.png"></a></li>
                </ul>
            </nav>    

            <nav id="top-navigation" class="top-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                <?php wp_nav_menu( array( 'theme_location' => 'top', 'menu_id' => 'top-menu' ) ); ?>
            </nav><!-- #top-navigation -->
        </div> <!-- .container .clearfix -->
    </div> <!-- #top-bar -->

    <header id="masthead" class="site-header clearfix" role="banner">
        <div class="container clearfix">
            <div class="site-branding">
                <?php if ( is_front_page() && is_home() ) : ?>
                <h1 class="site-title"><a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo ot_get_option( 'custom-logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
                <?php else : ?>
                    <p class="site-title"><a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo ot_get_option( 'custom-logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></p>
                <?php endif; ?>
            </div> <!-- .site-branding -->

            <div class="custom-tour-btn">
            <?php printf( '<a href="#"><span>%1$s</span><span>%2$s</span></a>',
                    esc_html__( 'Design ', 'discovertravel' ),
                    esc_html__( 'Your tour', 'discovertravel' )
                ); ?>
            </div>

            <div class="header-sidebar-1">
            <?php if ( is_active_sidebar( 'header-sidebar-1' ) ) : dynamic_sidebar( 'header-sidebar-1' ); 
            else :?>    
                <small>Go to <strong>Widget</strong> in Appearance menu to add quick contact inofrmation in <strong>Header Sidebar 1</strong>.</small>
            <?php endif; ?>    
            </div> <!-- .header-sidebar-1 -->

            <nav id="site-navigation" class="main-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'sf-menu' ) ); ?>
            </nav><!-- #site-navigation -->
            
            <a id="mobile-menu-trigger" href="#0"><span class="mobile-menu-text">Menu</span><span class="mobile-menu-icon"></span></a>
        </div> <!-- .container -->
    </header><!-- #masthead -->

    <?php wpsp_hook_content_top(); ?>

	<div id="content" class="site-content">
        <div class="container">
            <div class="row">
