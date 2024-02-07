<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
global $post;
$currentserviceID = $post->ID;
$page_slug = 'site-general-settings';
$generalpageid = get_id_by_slug($page_slug);
?>
 <!--Page Title-->
    <section class="page-title" style="background-image:url(<?php the_field('inner_banner'); ?>);">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <h1>service detail</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
                    <li>Service detail</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Service Detail Section -->
    <div class="service-detail-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Content Side-->
                <div class="content-side pull-right col-lg-9 col-md-12 col-sm-12">
                    <div class="service-detail">
                        <?php $bannersliderepeat = CFS()->get('banner_slide_repeat'); ?>
                        <div class="service-detail-slider owl-carousel owl-theme">
                            <?php foreach($bannersliderepeat as $eachbanner){ ?>

                            <div class="slide-item">
                                <div class="image-box">
                                    <figure><img src="<?php echo $eachbanner['each_banner_image']; ?>" alt=""></figure>
                                </div>
                            </div>
                        <?php } ?>
                            
                        </div>

                        <div class="lower-content">
                            <?php while (have_posts()):the_post(); ?>
                            <h2><?php the_title(); ?></h2>
                             <?php the_content();
                                endwhile;
                              ?>

                            <div class="two-column">
                                <div class="row clearfix">
                                <?php if(get_field('additional_info')!=''){ ?>
                                    <div class="info-column col-lg-5 col-md-12 col-sm-12">
                                      <?php the_field('additional_info'); ?>
                                    </div>
                                

                                    <div class="video-column col-lg-7 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <figure class="image"><img src="<?php the_field('training_video_image'); ?>" alt="">
                                                <a href="<?php the_field('training_video'); ?>" class="link" data-fancybox="gallery" data-caption=""><span class="icon fab fa-google-play"></span></a>
                                            </figure>
                                        </div>
                                    </div>
                                    <?php }
                                    else{
                                        ?>
                                         <div class="video-column col-lg-12 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <figure class="image"><img src="<?php the_field('training_video_image'); ?>" alt="">
                                                <a href="<?php the_field('training_video'); ?>" class="link" data-fancybox="gallery" data-caption=""><span class="icon fab fa-google-play"></span></a>
                                            </figure>
                                        </div>
                                    </div>

                                  <?php   }


                                     ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- Service Detail -->

                    <!-- Pricing Feature -->
                    <div class="pricing-feature">
                        <div class="sec-title">
                            <h2><span>Feature</span> Pricing</h2>
                            <div class="separator"><span class="flaticon-settings-2"></span></div>
                        </div>

                     
                        <?php the_field('price_table'); ?>


                    </div>
                    <!-- End pricing -->

                </div>

                <!--Sidebar Side-->
                <div class="sidebar-side col-lg-3 col-md-4 col-sm-12">
                    <aside class="sidebar services-sidebar">
                        <?php $allservices = new WP_Query(array('post_type'=>'ourservice','posts_per_page'=>-1,'post_status'=>'publish')); ?>

                        <!-- Services Cat List -->
                        <div class="sidebar-widget categories">
                            <ul class="service-cat-list">
                                <?php while($allservices->have_posts()): $allservices->the_post();
                                   if(get_the_ID()==$currentserviceID){
                                 ?>
                                <li class="active"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php }
                            else
                            {
                                ?>
                                 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                           <?php
                             }


                             ?>
                               
                            <?php endwhile; wp_reset_query(); ?>
                            </ul>
                        </div>

                        <!-- Brochure -->
                        <div class="sidebar-widget brochures">
                            <h3>Our Brochures</h3>
                     <?php      $allbrochures = CFS()->get('brochurerepeat');
                                $brochureimg = CFS()->get('brochure_section_image'); 

                      ?>
                            <div class="brochure-box">
                                <div class="image-box"><img src="<?php echo $brochureimg;  ?>" alt=""></div>
                                <div class="link-box">
                                    <?php foreach($allbrochures as $eachbrochure){ ?>
                                    <a href="<?php echo $eachbrochure['each_brochure'];  ?>"><span class="fa fa-file-pdf"></span>Service Brochure. PDF</a>
                                <?php } ?>
                                 
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- End Service Detail Section -->

    <!-- Contact Info Section -->
    <section class="contact-info-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- Contact Info Block -->
                <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-placeholder"></span>
                        <p><?php  echo get_field('address',$generalpageid); ?></p>
                    </div>
                </div>

                <!-- Contact Info Block -->
                <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-phone"></span>
                        <p><?php echo get_field('phone',$generalpageid); ?></p>
                        <p><a href="mailto:<?php echo get_field('email',$generalpageid); ?>"><?php echo get_field('email',$generalpageid); ?></a></p>
                    </div>
                </div>

                <!-- Contact Info Block -->
                <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-stopwatch"></span>
                       <p> <?php echo get_field('workshop_timings',$generalpageid); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Info Section -->
      <?php 

get_footer();
