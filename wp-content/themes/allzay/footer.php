
<?php $pageid = get_id_by_slug('site-general-settings');  ?>

<div class="gift-section">
    <img src="<?php echo get_field('gift_card_first_image',$pageid); ?>" alt class="gift-img1">
    <img src="<?php echo get_field('gift_card_second_image',$pageid); ?>" alt class="gift-img2">
    <div class="container-lg container-fluid">
        <div class="gift-wrapper">
            <h5><?php echo get_field('gift_section_heading',$pageid); ?></h5>
            <div class="gift-card-content">
                <?php echo get_field('gift_section_text',$pageid); ?>
            </div>
            <a href="<?php echo get_site_url(); ?>/shop" class="primary-btn1 hover-btn3"><?php echo get_field('shop_gift_cards_label',$pageid); ?></a>
        </div>
    </div>
</div>
  <footer class="footer-section">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/vector-2.svg" alt class="vector1">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/banner-vector1.svg" alt class="vector2">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/vector-4.svg" alt class="vector3">
        <div class="container">
            <div class="footer-top">
                <div class="row g-lg-4 gy-5 justify-content-center">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-widget">
                           <?php echo get_field('footer_extreme_left_text',$pageid); ?>
                            <a href="<?php echo get_site_url(); ?>/shop" class="primary-btn1 hover-btn3">*Shop Now*</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-start justify-content-sm-end">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h5><?php echo get_field('support_heading',$pageid); ?></h5>
                            </div>

                              <?php wp_nav_menu( array('menu' => 'Support links', 'items_wrap' => '<ul class="widget-list">%3$s</ul>' )); ?>
                            
                    </div>
                </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-center justify-content-md-end">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h5><?php echo get_field('company_heading',$pageid); ?></h5>
                            </div>
                               <?php wp_nav_menu( array('menu' => 'Company details', 'items_wrap' => '<ul class="widget-list">%3$s</ul>' )); ?>
                        </div>
                    </div>
                    <div
                        class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-center justify-content-md-start justify-content-sm-end">
                        <?php

  
                $args = array(
                'hide_empty' => false,
                'parent'        => 0
                );

                $productcategories = get_terms('product_cat',$args ) ;  
                
                         ?>
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h5><?php echo get_field('category_heading',$pageid); ?></h5>
                            </div>
                            <ul class="widget-list">
                                 <?php foreach($productcategories as $eachproductcat ){
                                          if($eachproductcat->name=='Uncategorized')
                                          {
                                            continue;
                                          }
                                  ?>
                                <li><a href="<?php echo get_term_link( $eachproductcat->term_id );  ?>"><?php echo $eachproductcat->name; ?></a></li>
                                
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-lg-end justify-content-md-center">
                        <div class="footer-widget">
                            <div class="widget-title style-2">
                                <h5><?php echo get_field('install_app_heading',$pageid); ?></h5>
                            </div>
                            <p><?php echo get_field('install_app_sub_heading',$pageid); ?></p>
                            <div class="app-store">
                                <a href="https://play.google.com/store/apps/" target="_blank">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/google-play.png" alt>
                                </a>
                                <a href="https://www.apple.com/app-store/" target="_blank">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/app-store.png" alt>
                                </a>
                            </div>
                            <div class="payment-gateway">
                                <p><?php echo get_field('payment_gateway_heading',$pageid); ?></p>
                                <div class="icons">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/visa.png" alt>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/mastercard.png" alt>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/american-express.png" alt>
                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/maestro.png" alt>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div
                        class="col-lg-12 d-flex flex-md-row flex-column align-items-center justify-content-md-between justify-content-center flex-wrap gap-3">
                        <div class="footer-left">
                            <p>©Copyright <?php echo date('Y'); ?> | Design By ZAY
                            </p>
                        </div>
                        <div class="footer-logo">
                            <a href="<?php echo get_site_url(); ?>" style="color:#fff; font-weight: bold; font-size: 22px;">ZAY</a>
                        </div>
                        <div class="footer-contact">
                            <div class="logo">
                                ZAY
                            </div>
                            <div class="content">
                                <p><?php echo get_field('inquiry_heading',$pageid); ?></p>
              <h6><a href="tel:<?php echo get_field('first_phone_number',$pageid); ?>"><?php echo get_field('first_phone_number',$pageid); ?></a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery-3.6.0.min.js"></script>
      <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.js"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/popper.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.nice-select.min.js"></script>

    <!-- <script src="assets/js/jquery.fancybox.min.js"></script> -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/slick.js"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
    <!-- <script src="assets/js/waypoints.min.js"></script> -->

  
    <?php wp_footer(); ?>
</body>

</html>