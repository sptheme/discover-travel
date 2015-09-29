<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Discover Travel
 */

?>
            </div> <!-- .row -->
        </div> <!-- .container -->
	</div><!-- #content -->

    <?php wpsp_hook_content_bottom(); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-widget">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        
                        <?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
                        <div class="row">    
                        <?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
                        </div>
                        <?php else :?>    
                            Go to <strong>Widget</strong> in Appearance menu to add widget into <strong>Footer Sidebar 1</strong>.
                        <?php endif; ?> 
                        
                    </div> <!-- .col-lg-6 -->
                    <div class="col-lg-6">
                        <?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : dynamic_sidebar( 'footer-sidebar-2' ); 
                        else :?>    
                            Go to <strong>Widget</strong> in Appearance menu to add widget into <strong>Footer Sidebar 2</strong>.
                        <?php endif; ?> 
                        
                    </div> <!-- .col-lg-6 -->
                </div>
            </div>
        </div> <!-- .site-widget -->

        <div class="site-info">
            <div class="row">
                <div class="col-sm-6">
                    <p class="copyright"><?php echo esc_html__(ot_get_option( 'copyright' )); ?></p>
                    <div class="payment-getway">
                        <ul>
                            <li><span class="sprite credit-card"></span></li>
                            <li><span class="sprite visa-card"></span></li>
                            <li><span class="sprite american-express"></span></li>
                            <li><span class="sprite discover"></span></li>
                            <li><span class="sprite bank-transfer"></span></li>
                            <li><span class="sprite amex"></span></li>
                            <li><span class="sprite paypal"></span></li>
                        </ul>
                    </div>
                </div> <!-- .col-lg-6 -->
                <div class="col-sm-6">
                    <div class="awards">
                        <ul>
                            <li><a href="#" title="Ministry of Tourism"><span class="sprite mot"></span></a></li>
                            <li><a href="#" title="Member of PATA"><span class="sprite pata"></span></a></li>
                            <li><a href="#" title="Cambodia of Wonder"><span class="sprite cow"></span></a></li>
                            <li><a href="#" title="CATA - Cambodia Association of Travel Agency"><span class="sprite cata"></span></a></li>
                            <li><a href="#" title="Clean City Day - Let Do it!"><span class="sprite doit"></span></a></li>
                            <li><a href="#" title="Cambodia Community-Base Ecotourism Network"><span class="sprite ccben"></span></a></li>
                        </ul>
                    </div>
                </div> <!-- .col-lg-6 -->
            </div> <!-- .row -->
        </div> <!-- .site-info -->
    </footer> <!-- .site-footer -->
</div><!-- #page -->

<nav id="sitemenu-container" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
    <div class="mobile-logo"><img src="<?php echo ot_get_option( 'custom-logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>"></div>
    
    <?php wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'mobile-menu' ) ); ?>
    
    <div class="side-nav-contact">
    <?php if ( is_active_sidebar( 'mobile-sidebar' ) ) : dynamic_sidebar( 'mobile-sidebar' ); 
    else :?>    
        <small>Go to <strong>Widget</strong> in Appearance menu to add quick contact inofrmation in <strong>Mobile Sidebar</strong>.</small>
    <?php endif; ?>   
    </div> <!-- .side-nav-contact -->

    <!-- TODO: Add social option -->
    <!-- 
    <div class="social-icon-menu"> 
        <a target="_blank" href="#" title="Facebook"><i class="fa fa-facebook-square"></i></a>
        <a target="_blank" href="#" title="Twitter"><i class="fa fa-twitter-square"></i></a>
        <a target="_blank" href="#" title="Linkedin"><i class="fa fa-linkedin-square"></i></a>
        <a target="_blank" href="#" title="Tripadvisor"><i class="fa fa-tripadvisor"></i></a>
    </div> --> <!-- .social-icon-menu -->
</nav>

<?php wp_footer(); ?>

</body>
</html>
