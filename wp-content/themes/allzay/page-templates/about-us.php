<?php /* Template Name: ABOUT */ 
get_header();
?>


    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                     <?php while(have_posts()):the_post(); ?>
<li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>

                </ol>
            </nav>
        </div>
    </div>


    <div class="about-us-banner mt-110  mb-110">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="about-us-thumb hover-img mb-60">
                        <?php if(get_field('inner_banner'))
                        { ?>
                        <img src="<?php echo get_field('inner_banner'); ?>" alt>
                    <?php 
                         }
                    else
                    {
                        ?>
                        <img src="<?php bloginfo('template_url'); ?>/assets/img/inner-page/about-us-banner-img.png" alt>
                     
                   <?php
                     }
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us-content">
            <div class="container">
                <div class="row justify-content-center"> 
                    
                    <div class="col-lg-12">
                        <div class="about-us-wrapper"> 
                           <?php the_content(); ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php endwhile; ?>

    <div class="about-us-video">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="about-video-thumb">
                        <img src="<?php echo get_field('about_video_bg'); ?>" alt>
                        <a data-fancybox="popup-video" href="<?php echo get_field('about_video_youtube_link'); ?>"><i
                                class="bi bi-play-fill"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="best-brand-section style-2 mb-110">
        <div class="container-fluid">
            <div class="section-title style-2 text-center">
                <h3><?php echo CFS()->get( 'brand_section_title' ); ?>  </h3>
            </div>
            <div class="best-brand-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper brand-slider">
                            <div class="swiper-wrapper">
                                <?php $allbrands = CFS()->get('brand_repeat');
                                   foreach($allbrands as $eachbrand){
                                 ?>

                                <div class="swiper-slide">
                                    <div class="brand-icon">
                                        <a href="<?php echo $eachbrand['brand_link']; ?>">
                                            <img src="<?php echo $eachbrand['brand_image']; ?>" alt>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                             
                            
                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="makeup-section mb-110">
        <div class="container">

            <div class="makeup-top-item">
                <div class="row align-items-center justify-content-center g-0 gy-4">
                    <div class="col-lg-6">
                        <div class="makeup-img hover-img">
                            <img src="<?php echo get_field('about_best_sellers_first_image'); ?>" alt>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="makeup-content">
                           <?php echo get_field('about_bestseller_first_text'); ?>
      <a href="<?php echo get_site_url(); ?>/shop" class="primary-btn1 style-2 hover-btn3"><?php echo get_field('about_bestseller_first_shop'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center justify-content-center g-0 gy-4">
                <div class="col-lg-6 order-lg-1 order-2">
                    <div class="makeup-content">
                        <?php echo get_field('perfer_best_makeup_text'); 

                              $prodobjtotry = get_field('select_product_to_try');
                              

                        ?>
                <a href="<?php echo get_the_permalink($prodobjtotry); ?>" class="primary-btn1 style-2 hover-btn3"><?php echo get_field('best_makup_try_text'); ?></a>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1">
                    <div class="makeup-img hover-img">
                        <img src="<?php echo get_the_post_thumbnail_url($prodobjtotry); ?>" alt>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <div class="say-about-section">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/testimonial-vector-2.png" alt class="vector3">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/testimonial-vector-1.png" alt class="vector4">
        <div class="container-fluid p-0">
            <div class="section-title2 style-3">
                <h3><?php echo get_field('about_testimonial_heading'); ?></h3>
                <div class="slider-btn">
                    <div class="about-prev-btn">
                        <i class="bi bi-arrow-left"></i>
                    </div>
                    <div class="about-next-btn">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="say-about-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper say-about-slider">
                            <div class="swiper-wrapper">

                          <?php $alltestimonials = new WP_Query(array('post_type'=>'our-testimonials','post_status'=>'publish','posts_per_page'=>-1)); 
                           
                           while($alltestimonials->have_posts()):$alltestimonials->the_post();
                              $rating = get_field('testimonial_rating');
                                $rateloopcount = 0;
                    $ratebalance = 5-$rating;
                          ?>

                                <div class="swiper-slide">
                                    <div class="say-about-card">
                                        <div class="say-about-card-top">
                                            <ul>
                                                

                                    <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++)
                                    {
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                            </ul>
                                        </div>
                                        <p>“<?php the_content(); ?>”</p>
                                        <div class="say-about-card-bottom">
                                            <div class="author-area">
                                                <div class="author-img">
                                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt>
                                                </div>
                                                <div class="author">
                                                    <h5><?php the_title(); ?></h5>
                                                    <?php if(get_field('author_designation')!='')
                                                    { ?>
                                                    <p><?php echo get_field('author_designation'); ?></p>
                                                <?php
                                                    }
                                                else{ ?>
                                                    <p>Manager at Global Business</p>
                                                    <?php 
                                                   }

                                                 ?>
                                                </div>
                                            </div>
                                            <div class="quote">
                                                <svg width="59" height="41" viewBox="0 0 59 41"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g opacity="0.05">
                                                        <path
                                                            d="M27.8217 13.4959C27.7944 13.2156 27.7396 12.9284 27.6712 12.6481C27.062 5.56517 21.1144 0 13.8664 0C6.2077 0 0 6.20099 0 13.8514C0 21.283 5.85865 27.3268 13.2093 27.6686C11.4367 30.4649 8.58264 32.7278 5.09894 33.7944L4.98259 33.8286C3.36735 34.3208 2.25175 35.8933 2.40232 37.6435C2.57342 39.6604 4.34608 41.1576 6.37196 40.9867C12.3333 40.4808 18.2946 37.4384 22.3464 32.4954C24.3791 30.0341 25.9533 27.1353 26.9114 23.9767C27.8765 20.8249 28.205 17.4202 27.8765 14.0633L27.8217 13.4959Z" />
                                                        <path
                                                            d="M58.8217 13.4959C58.7944 13.2156 58.7396 12.9284 58.6712 12.6481C58.062 5.56517 52.1144 0 44.8664 0C37.2077 0 31 6.20099 31 13.8514C31 21.283 36.8586 27.3268 44.2093 27.6686C42.4367 30.4649 39.5826 32.7278 36.0989 33.7944L35.9826 33.8286C34.3674 34.3208 33.2517 35.8933 33.4023 37.6435C33.5734 39.6604 35.3461 41.1576 37.372 40.9867C43.3333 40.4808 49.2946 37.4384 53.3464 32.4954C55.3791 30.0341 56.9533 27.1353 57.9114 23.9767C58.8765 20.8249 59.205 17.4202 58.8765 14.0633L58.8217 13.4959Z" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile;wp_reset_query(); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination2"></div>
            </div>
        </div>
    </div>

 <?php get_footer(); 