<?php /* Template Name: Home */ 
 get_header(); 

$pageid = get_id_by_slug('site-general-settings'); 
$form1='';
 ?>

  <div class="banner-section">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper banner1-slider">
                        <div class="swiper-wrapper">
                            <?php  

                             $bannersliderepeat = CFS()->get( 'home_banner_repeat' );  
                              foreach($bannersliderepeat as $eachbannerslide){
                             ?>
                           
                            <div class="swiper-slide">
                                <div class="banner-wrapper">
                                    <div class="banner-left">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/banner-vector1.svg" alt class="banner-vector1">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/banner-vector2.svg" alt class="banner-vector2">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/icon/banner-vector3.svg" alt class="banner-vector3">
                                        <div class="banner-content">
                                            <div class="discount">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/home1/discount-bg.svg" alt>
                                                <p><?php echo $eachbannerslide['discount_text']; ?></p>
                                            </div>
                                            <?php echo $eachbannerslide['banner_text']; ?>
     <a href="<?php echo $eachbannerslide['shop_now_link']; ?>" class="primary-btn1 hover-btn3"> <?php echo $eachbannerslide['shop_now_label']; ?> </a>
                                        </div>
                                    </div>
                                    <div class="banner-right-wrapper">
                                        <div class="banner-right-img">
                                            <img src="<?php echo $eachbannerslide['banner_right_image']; ?>" alt
                                                class="banner-right-bg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                     

                        </div>
                        <div class="swiper-pagination1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-footer mb-110">
        <div class="container-fluid p-0">
            <div class="banner-footer-wrapper">
                <div class="row g-lg-4 gy-4">
                    <?php 
                       $looprowcount = 0;
                        $featurescount = 0;
                    $allfeatures = CFS()->get('our_features_repeat');
                    foreach($allfeatures as $eachfeature)
                        {$looprowcount++;}

                        foreach($allfeatures as $eachfeature)
                        {
                            $featurescount++;

                            if($featurescount==1)
                            {

                        ?>

                        <div class="col-lg-3 col-sm-6 d-flex justify-content-lg-start justify-content-center">
                      <?php }
                    else if($featurescount == $looprowcount )
                    {
                        ?>
                           <div class="col-lg-3 col-sm-6 d-flex justify-content-lg-end justify-content-center">
                        <?php 
                    }
                    else
                    {
                        ?>
                          <div class="col-lg-3 col-sm-6 d-flex justify-content-center">
                        <?php 
                    }

                     ?>

                        <div class="banner-footer-item">
                            <div class="banner-footer-icon">
                               <?php echo $eachfeature['our_feature_svg']; ?>
                            </div>
                            <div class="banner-footer-content">
                                <?php echo $eachfeature['our_feature_headings']; ?>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <div class="choose-product-section mb-110">
        <div class="container">
            <div class="section-title text-center">
                <h3>Our Category</h3>
            </div>

            <?php   
                $args = array(
                'hide_empty' => false,
                'parent'        => 0
                );

                $productcategories = get_terms('product_cat',$args ) ;  

                $catcounter=0;
                //echo '<pre>'; print_r($productcategories); echo '</pre>'; die();
           
             ?>
            <div class="row gy-4 justify-content-center">
                 <?php foreach($productcategories as $eachproductcat ){ 
                              $catcounter++;
                            if($eachproductcat->name=='Uncategorized')
                            {
                                continue;
                            }
                            if($catcounter > 4)
                                {break;}
                             $thumbnail_id = get_term_meta( $eachproductcat->term_id, 'thumbnail_id', true );
                                // get the medium-sized image url
                                $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                            ?>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-product-card hover-img style-2">
                        <a href="<?php echo get_term_link( $eachproductcat->term_id );  ?>">
                            <img src="<?php echo $image[0];  ?>" alt>
                        </a>
                        <?php if($catcounter==3)
                        { ?>
                        <div class="choose-product-card-content">
                        <?php 
                        } 
                        else
                        {
                            ?>
                            <div class="choose-product-card-content">
                         <?php
                         }

                        ?>
                            <h2 class="first-text"><?php echo $eachproductcat->name; ?></h2>
                          
                        </div>
                    </div>
                </div>
            <?php } ?>
          

            </div>
        </div>
    </div>


    <div class="best-selling-section mb-110">
       <?php  /*$product_id = '297';
$product = new WC_product($product_id);
$attachment_ids = $product->get_gallery_image_ids(); */

/*echo '<pre>'; print_r($attachment_ids); echo '</pre>'; die();*/
//echo $Original_image_url = wp_get_attachment_url( $attachment_id );
/*Array
(
    [0] => 310
    [1] => 311
    [2] => 309
)*/
 ?>
        <div class="container">
            <div class="section-title2">
                <h3>Best Selling Product</h3>
                <div class="all-product hover-underline">
                    <a href="<?php echo get_site_url(); ?>/shop">*View All Product
                      <!--  <svg width="33" height="13" viewBox="0 0 33 13" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M25.5083 7.28L0.491206 7.25429C0.36093 7.25429 0.23599 7.18821 0.143871 7.0706C0.0517519 6.95299 0 6.79347 0 6.62714C0 6.46081 0.0517519 6.3013 0.143871 6.18369C0.23599 6.06607 0.36093 6 0.491206 6L25.5088 6.02571C25.6391 6.02571 25.764 6.09179 25.8561 6.2094C25.9482 6.32701 26 6.48653 26 6.65286C26 6.81919 25.9482 6.9787 25.8561 7.09631C25.764 7.21393 25.6386 7.28 25.5083 7.28Z" />
                            <path
                                d="M33.0001 6.50854C29.2204 7.9435 24.5298 10.398 21.623 13L23.9157 6.50034L21.6317 0C24.5358 2.60547 29.2224 5.06539 33.0001 6.50854Z" />
                        </svg>-->
                    </a>
                </div>
            </div>
            <div class="row gy-4">
                <?php $metaqueries = new WP_Query(
                              array(
                               'post_type'=>'product',
                                'meta_key' => 'total_sales',
                                'orderby' => 'meta_value_num',
  
                             
                              'posts_per_page'=>6,
                              'post_status'=>'publish',
                              'order' => 'DESC'
                              )
                              
                              );  

              while($metaqueries->have_posts()):$metaqueries->the_post();

                         $product = new WC_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( get_the_ID(), '_regular_price', true); 
  $saleprice = get_post_meta( get_the_ID(), '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',get_the_ID());
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;


               ?>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card hover-btn">
                        <div class="product-card-img double-img">
                            <a href="<?php echo get_the_permalink(get_the_ID()); ?>">

                                <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                          <?php 
                             }


                             ?>
                             <!--   <div class="countdown-timer">
                                    <ul data-countdown="2023-10-23 12:00:00">
                                        <li class="times" data-days="00">00</li>
                                        <li>
                                            :
                                        </li>
                                        <li class="times" data-hours="00">00</li>
                                        <li>
                                            :
                                        </li>
                                        <li class="times" data-minutes="00">00</li>
                                        <li>
                                            :
                                        </li>
                                        <li class="times" data-seconds="00">00</li>
                                    </ul>
                                </div> -->
                                <div class="batch">
                                    <span class="new">New offer</span>
                                    <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                </div>
                            </a>
                            <div class="overlay">
                               <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo get_the_ID();  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php }
                               else
                               {
                                ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                              <?php 
                               }

                                ?>
                            </div>
                            <div class="view-and-favorite-area">
                                <ul>
                                    <li>
                                       <!-- <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 18 18">
                                                <g clip-path="url(#clip0_168_378)">
                                                    <path
                                                        d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919ZM15.5971 8.82879H15.5965L9.00132 15.7849L2.40553 8.82879C0.90608 7.21113 0.90608 4.7114 2.40553 3.09374C3.76722 1.61789 6.06755 1.52535 7.5434 2.88703C7.61505 2.95314 7.68401 3.0221 7.75012 3.09374L8.5343 3.92104C8.79272 4.17781 9.20995 4.17781 9.46838 3.92104L10.2526 3.09438C11.6142 1.61853 13.9146 1.52599 15.3904 2.88767C15.4621 2.95378 15.531 3.02274 15.5971 3.09438C17.1096 4.71461 17.1207 7.2189 15.5971 8.82879Z" />
                                                </g>
                                            </svg>
                                        </a>-->
                                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id='.get_the_ID().']'); ?>
                                    </li>
                                <!--    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#product-view">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 22 22">
                                                <path
                                                    d="M21.8601 10.5721C21.6636 10.3032 16.9807 3.98901 10.9999 3.98901C5.019 3.98901 0.335925 10.3032 0.139601 10.5718C0.0488852 10.6961 0 10.846 0 10.9999C0 11.1537 0.0488852 11.3036 0.139601 11.4279C0.335925 11.6967 5.019 18.011 10.9999 18.011C16.9807 18.011 21.6636 11.6967 21.8601 11.4281C21.951 11.3039 21.9999 11.154 21.9999 11.0001C21.9999 10.8462 21.951 10.6963 21.8601 10.5721ZM10.9999 16.5604C6.59432 16.5604 2.77866 12.3696 1.64914 10.9995C2.77719 9.62823 6.58487 5.43955 10.9999 5.43955C15.4052 5.43955 19.2206 9.62969 20.3506 11.0005C19.2225 12.3717 15.4149 16.5604 10.9999 16.5604Z" />
                                                <path
                                                    d="M10.9999 6.64832C8.60039 6.64832 6.64819 8.60051 6.64819 11C6.64819 13.3994 8.60039 15.3516 10.9999 15.3516C13.3993 15.3516 15.3515 13.3994 15.3515 11C15.3515 8.60051 13.3993 6.64832 10.9999 6.64832ZM10.9999 13.9011C9.40013 13.9011 8.09878 12.5997 8.09878 11C8.09878 9.40029 9.40017 8.0989 10.9999 8.0989C12.5995 8.0989 13.9009 9.40029 13.9009 11C13.9009 12.5997 12.5996 13.9011 10.9999 13.9011Z" />
                                            </svg>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="product-card-content">
                            <h6><a href="<?php echo get_the_permalink(); ?>" class="hover-underline"><?php echo get_the_title(); ?></a></h6>
                            <p>
                              <?php   foreach( get_the_terms(get_the_ID(), 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                     }
                                     ?>
                               
                            </p>
                            <p class="price">$<?php echo $saleprice;  ?> <del>$ <?php echo $regularprice; ?></del></p>
                            <div class="rating">
                                <ul>
                                   <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++){
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                </ul>
                                <!--<span>(50)</span> -->
                            </div>
                        </div>
                        <span class="for-border"></span>
                    </div>
                </div>

            <?php endwhile;wp_reset_query(); ?>


              
            </div>
        </div>
    </div>

    <div class="just-for-section mb-110">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/vector-1.svg" alt class="vector1">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/vector-2.svg" alt class="vector2">
        <div class="container">
            <div class="section-title2 style-2">
                <h3>Just For You</h3>
                <div class="all-product hover-underline">
                    <a href="<?php echo get_site_url(); ?>/shop">*View All Product
                        <svg width="33" height="13" viewBox="0 0 33 13" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M25.5083 7.28L0.491206 7.25429C0.36093 7.25429 0.23599 7.18821 0.143871 7.0706C0.0517519 6.95299 0 6.79347 0 6.62714C0 6.46081 0.0517519 6.3013 0.143871 6.18369C0.23599 6.06607 0.36093 6 0.491206 6L25.5088 6.02571C25.6391 6.02571 25.764 6.09179 25.8561 6.2094C25.9482 6.32701 26 6.48653 26 6.65286C26 6.81919 25.9482 6.9787 25.8561 7.09631C25.764 7.21393 25.6386 7.28 25.5083 7.28Z" />
                            <path
                                d="M33.0001 6.50854C29.2204 7.9435 24.5298 10.398 21.623 13L23.9157 6.50034L21.6317 0C24.5358 2.60547 29.2224 5.06539 33.0001 6.50854Z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-Korean-tab" data-bs-toggle="pill"
                            data-bs-target="#v-Korean" type="button" role="tab" aria-controls="v-Korean"
                            aria-selected="true">
                           Men
                          
                            
                        </button>
                        <button class="nav-link" id="v-makeup-tab" data-bs-toggle="pill" data-bs-target="#v-makeup"
                            type="button" role="tab" aria-controls="v-makeup" aria-selected="false">
                            Women
                           
                           
                        </button>
                        <button class="nav-link" id="v-skin-care-tab" data-bs-toggle="pill"
                            data-bs-target="#v-skin-care" type="button" role="tab" aria-controls="v-skin-care"
                            aria-selected="false">
                            Unisex
                           
                          
                        </button>
                    </div>
                    <div class="offer-img hover-img">
                        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/offer-img.png" alt>
                        <div class="discount-buy">
                            <div class="discount">
                                <svg width="65" height="65" viewBox="0 0 65 65" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M30.4435 1.58116C31.4962 0.259924 33.5038 0.259924 34.5565 1.58116V1.58116C35.4448 2.69608 37.0597 2.90009 38.1973 2.0411V2.0411C39.5455 1.02317 41.4901 1.52244 42.1811 3.06395V3.06395C42.7642 4.36476 44.2776 4.96398 45.5932 4.4149V4.4149C47.1521 3.76422 48.9114 4.7314 49.1974 6.39632V6.39632C49.4387 7.80127 50.7556 8.75805 52.1663 8.55338V8.55338C53.8381 8.31084 55.3016 9.68515 55.1645 11.3689V11.3689C55.0488 12.7897 56.0864 14.0439 57.5037 14.1965V14.1965C59.1833 14.3774 60.2591 16.0724 59.7076 17.6692V17.6692C59.2422 19.0166 59.9352 20.4895 61.2701 20.9897V20.9897C62.8519 21.5826 63.4723 23.492 62.5411 24.9014V24.9014C61.7552 26.0907 62.0602 27.6897 63.2287 28.5062V28.5062C64.6134 29.4738 64.7395 31.4775 63.487 32.611V32.611C62.43 33.5675 62.3278 35.1921 63.2565 36.2736V36.2736C64.3571 37.5552 63.9809 39.5272 62.4858 40.3137V40.3137C61.2242 40.9773 60.7212 42.5254 61.3518 43.8039V43.8039C62.0991 45.3189 61.2443 47.1354 59.6006 47.5254V47.5254C58.2136 47.8544 57.3414 49.2288 57.6342 50.6239V50.6239C57.9813 52.2771 56.7016 53.8241 55.0125 53.793V53.793C53.5873 53.7667 52.4007 54.881 52.3374 56.3051V56.3051C52.2623 57.9927 50.6381 59.1728 49.0099 58.7226V58.7226C47.6359 58.3428 46.2095 59.1269 45.794 60.4906V60.4906C45.3017 62.1065 43.435 62.8456 41.9699 62.0047V62.0047C40.7336 61.295 39.157 61.6998 38.4154 62.9173V62.9173C37.5366 64.36 35.5449 64.6117 34.3349 63.4328V63.4328C33.3139 62.438 31.6861 62.438 30.6651 63.4328V63.4328C29.4551 64.6117 27.4634 64.36 26.5846 62.9173V62.9173C25.843 61.6998 24.2664 61.295 23.0301 62.0047V62.0047C21.565 62.8456 19.6983 62.1065 19.206 60.4906V60.4906C18.7905 59.1269 17.3641 58.3428 15.9901 58.7226V58.7226C14.3619 59.1728 12.7377 57.9927 12.6626 56.3051V56.3051C12.5993 54.881 11.4127 53.7667 9.98747 53.793V53.793C8.29845 53.8241 7.01874 52.2771 7.36578 50.6239V50.6239C7.65863 49.2288 6.78642 47.8544 5.3994 47.5254V47.5254C3.75571 47.1354 2.9009 45.3189 3.64819 43.8039V43.8039C4.27879 42.5254 3.77578 40.9773 2.51416 40.3137V40.3137C1.01908 39.5272 0.642888 37.5552 1.74347 36.2736V36.2736C2.67219 35.1921 2.56999 33.5675 1.51304 32.611V32.611C0.260513 31.4775 0.386573 29.4738 1.77129 28.5062V28.5062C2.93979 27.6897 3.24481 26.0907 2.45895 24.9014V24.9014C1.52767 23.492 2.14806 21.5826 3.72992 20.9897V20.9897C5.06477 20.4895 5.75784 19.0166 5.29244 17.6692V17.6692C4.74093 16.0725 5.81667 14.3774 7.49627 14.1965V14.1965C8.9136 14.0439 9.95118 12.7897 9.83549 11.3689V11.3689C9.6984 9.68515 11.1619 8.31084 12.8337 8.55338V8.55338C14.2444 8.75805 15.5613 7.80127 15.8026 6.39632V6.39632C16.0886 4.7314 17.8479 3.76422 19.4068 4.4149V4.4149C20.7224 4.96398 22.2358 4.36475 22.8189 3.06395V3.06395C23.5099 1.52244 25.4545 1.02317 26.8027 2.0411V2.0411C27.9403 2.90009 29.5552 2.69608 30.4435 1.58116V1.58116Z" />
                                </svg>
                                <h6>30% <br><span>off</span></h6>
                            </div>
                            <a href="#" class="buy-btn hover-btn4">*Buy Now*</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">

                <?php     $taxquery1 = new WP_Query(
                              array(
                               'post_type'=>'product',
                                 'tax_query' => array(
                                    array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'men'
                                     )
                                   ),                             
                                  'posts_per_page'=>6,
                                  'post_status'=>'publish',
                                  'order' => 'DESC'
                              )
                              
                              );  
                              ?>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-Korean" role="tabpanel"
                            aria-labelledby="v-Korean-tab">
                            <div class="row gy-4">
                                <?php 
                                while($taxquery1->have_posts()):$taxquery1->the_post();
                                $product = new WC_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( get_the_ID(), '_regular_price', true); 
  $saleprice = get_post_meta( get_the_ID(), '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',get_the_ID());
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;

                    ?>

               

                                <div class="col-xl-4 col-md-6">
                                    <div class="product-card style-2 hover-btn">
                                        <div class="product-card-img double-img">
                                              <a href="<?php echo get_the_permalink(get_the_ID()); ?>">

                                <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                          <?php 
                             }

                             ?>
                                                <div class="batch">
                                                    <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                              

                              <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo get_the_ID();  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php 
                                   }
                                   else
                                   {
                                    ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                                  <?php 
                                   }

                                    ?>


                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="hover-underline"><?php echo get_the_title(); ?></a></h6>
                                            <p><?php   foreach( get_the_terms(get_the_ID(), 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                               }
                                            ?>
                                              </p>


                                            <p class="price">$<?php echo $saleprice; ?> <del>$<?php echo $regularprice; ?></del></p>
                                            <div class="rating">
                                                <ul>
                                                     <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++){
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                                </ul>
                                                <!--<span>(50)</span> -->
                                            </div>
                                        </div>
                                        <span class="for-border"></span>
                                    </div>
                                </div>

                                <?php endwhile;wp_reset_query(); ?>
                                

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-makeup" role="tabpanel" aria-labelledby="v-makeup-tab">
                            <div class="row gy-4">

                             <!--- starting --->


     <?php     $taxquery2 = new WP_Query(
                              array(
                               'post_type'=>'product',
                                 'tax_query' => array(
                                    array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'women'
                                     )
                                   ),                             
                                  'posts_per_page'=>6,
                                  'post_status'=>'publish',
                                  'order' => 'DESC'
                              )
                              
                              );  
                             

                                while($taxquery2->have_posts()):$taxquery2->the_post();
                                $product = new WC_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( get_the_ID(), '_regular_price', true); 
  $saleprice = get_post_meta( get_the_ID(), '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',get_the_ID());
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;

                    ?>

               

                                <div class="col-xl-4 col-md-6">
                                    <div class="product-card style-2 hover-btn">
                                        <div class="product-card-img double-img">
                                              <a href="<?php echo get_the_permalink(get_the_ID()); ?>">

                                <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                          <?php 
                             }

                             ?>
                                                <div class="batch">
                                                    <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                              

                              <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo get_the_ID();  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php 
                                   }
                                   else
                                   {
                                    ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                                  <?php 
                                   }

                                    ?>


                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="hover-underline"><?php echo get_the_title(); ?></a></h6>
                                            <p><?php   foreach( get_the_terms(get_the_ID(), 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                               }
                                            ?>
                                              </p>


                                            <p class="price">$<?php echo $saleprice; ?> <del>$<?php echo $regularprice; ?></del></p>
                                            <div class="rating">
                                                <ul>
                                                     <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++){
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                                </ul>
                                                <!--<span>(50)</span> -->
                                            </div>
                                        </div>
                                        <span class="for-border"></span>
                                    </div>
                                </div>

                                <?php endwhile;wp_reset_query(); ?>


<!-- Ending -->

                    
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-skin-care" role="tabpanel" aria-labelledby="v-skin-care-tab">
                            <div class="row gy-4">

                                 <?php     $taxquery3 = new WP_Query(
                              array(
                               'post_type'=>'product',
                                 'tax_query' => array(
                                    array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'unisex'
                                     )
                                   ),                             
                                  'posts_per_page'=>6,
                                  'post_status'=>'publish',
                                  'order' => 'DESC'
                              )
                              
                              );  
                             

                                while($taxquery3->have_posts()):$taxquery3->the_post();
                                $product = new WC_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( get_the_ID(), '_regular_price', true); 
  $saleprice = get_post_meta( get_the_ID(), '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',get_the_ID());
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;

                    ?>


                                 <div class="col-xl-4 col-md-6">
                                    <div class="product-card style-2 hover-btn">
                                        <div class="product-card-img double-img">
                                              <a href="<?php echo get_the_permalink(get_the_ID()); ?>">

                                <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                          <?php 
                             }

                             ?>
                                                <div class="batch">
                                                    <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                              

                              <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo get_the_ID();  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php 
                                   }
                                   else
                                   {
                                    ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                                  <?php 
                                   }

                                    ?>


                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="hover-underline"><?php echo get_the_title(); ?></a></h6>
                                            <p><?php   foreach( get_the_terms(get_the_ID(), 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                               }
                                            ?>
                                              </p>


                                            <p class="price">$<?php echo $saleprice; ?> <del>$<?php echo $regularprice; ?></del></p>
                                            <div class="rating">
                                                <ul>
                                                     <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++){
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                                </ul>
                                                <!--<span>(50)</span> -->
                                            </div>
                                        </div>
                                        <span class="for-border"></span>
                                    </div>
                                </div>

                                <?php endwhile;wp_reset_query(); ?>
                              
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="offer-banner mb-110">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="offer-banner-left hover-img">
                        <img src="<?php echo get_field('limited_offer_image');  ?>" alt>
                        <div class="offer-banner-left-content">
                            <div class="left-text">
                                <?php echo get_field('limited_offer_title_and_text') ?>
                            </div>
                            <a href="<?php echo get_field('buy_now_link'); ?>" class="buy-btn2 hover-btn3"><?php echo get_field('buy_now_label'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="offer-banner-right hover-img">
                        <img src="<?php echo get_field('all_product_image'); ?>" alt>
                        <div class="offer-banner-right-content">
                           <?php echo get_field('all_product_offer_text'); ?>
                            <a href="<?php echo get_field('all_product_by_now_link'); ?>" class="buy-btn2 hover-btn3"><?php echo get_field('all_product_buy_now_label') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="newest-product-section mb-110">
        <div class="container">
            <div class="section-title2 style-2">
                <h3>Newest Product</h3>
                <div class="slider-btn">
                    <div class="prev-btn">
                        <i class="bi bi-arrow-left"></i>
                    </div>
                    <div class="next-btn">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
  <?php  $allproducts = new WP_Query(array('post_type'=>'product','posts_per_page'=>4,'post_status'=>'publish','orderby'=>'date','order'=>'DESC'));



   ?>
                    <div class="swiper newest-slider">
                        <div class="swiper-wrapper">
                            <?php  while($allproducts->have_posts()):$allproducts->the_post();
$product = new WC_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( get_the_ID(), '_regular_price', true); 
  $saleprice = get_post_meta( get_the_ID(), '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',get_the_ID());
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;


                             ?>
                            <div class="swiper-slide">

                                <div class="product-card hover-btn">
                                    <div class="product-card-img double-img">
                                        <a href="<?php echo get_the_permalink(get_the_ID()); ?>">

                                 <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt class="img0">

                          <?php 
                             }

                             ?>


                                          <!--  <div class="countdown-timer">
                                                <ul data-countdown="2023-10-23 12:00:00">
                                                    <li class="times" data-days="00">60 <span>Days</span> <span>D</span>
                                                    </li>
                                                    <li>
                                                        :
                                                    </li>
                                                    <li class="times" data-hours="00">16 <span>Hours</span>
                                                        <span>H</span></li>
                                                    <li>
                                                        :
                                                    </li>
                                                    <li class="times" data-minutes="00">40 <span>Minutes</span>
                                                        <span>M</span></li>
                                                    <li>
                                                        :
                                                    </li>
                                                    <li class="times" data-seconds="00">34 <span>Seconds</span>
                                                        <span>S</span></li>
                                                </ul>
                                            </div> -->
                                            <div class="batch">
                                            
                                                <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                            </div>
                                        </a>
                                        <div class="overlay">
                                            <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo get_the_ID();  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php 
                                   }
                                   else
                                   {
                                    ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                                  <?php 
                                   }

                                    ?>
                                        </div>
                                        <div class="view-and-favorite-area">
                                            <ul>
                                                <li>
                                                   <!-- <a href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                            viewBox="0 0 18 18">
                                                            <g clip-path="url(#clip0_168_378)">
                                                                <path
                                                                    d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919ZM15.5971 8.82879H15.5965L9.00132 15.7849L2.40553 8.82879C0.90608 7.21113 0.90608 4.7114 2.40553 3.09374C3.76722 1.61789 6.06755 1.52535 7.5434 2.88703C7.61505 2.95314 7.68401 3.0221 7.75012 3.09374L8.5343 3.92104C8.79272 4.17781 9.20995 4.17781 9.46838 3.92104L10.2526 3.09438C11.6142 1.61853 13.9146 1.52599 15.3904 2.88767C15.4621 2.95378 15.531 3.02274 15.5971 3.09438C17.1096 4.71461 17.1207 7.2189 15.5971 8.82879Z" />
                                                            </g>
                                                        </svg>
                                                    </a>-->
                                                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id='.get_the_ID().']'); ?>
                                                </li>
                                               <!-- <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#product-view">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                            viewBox="0 0 22 22">
                                                            <path
                                                                d="M21.8601 10.5721C21.6636 10.3032 16.9807 3.98901 10.9999 3.98901C5.019 3.98901 0.335925 10.3032 0.139601 10.5718C0.0488852 10.6961 0 10.846 0 10.9999C0 11.1537 0.0488852 11.3036 0.139601 11.4279C0.335925 11.6967 5.019 18.011 10.9999 18.011C16.9807 18.011 21.6636 11.6967 21.8601 11.4281C21.951 11.3039 21.9999 11.154 21.9999 11.0001C21.9999 10.8462 21.951 10.6963 21.8601 10.5721ZM10.9999 16.5604C6.59432 16.5604 2.77866 12.3696 1.64914 10.9995C2.77719 9.62823 6.58487 5.43955 10.9999 5.43955C15.4052 5.43955 19.2206 9.62969 20.3506 11.0005C19.2225 12.3717 15.4149 16.5604 10.9999 16.5604Z" />
                                                            <path
                                                                d="M10.9999 6.64832C8.60039 6.64832 6.64819 8.60051 6.64819 11C6.64819 13.3994 8.60039 15.3516 10.9999 15.3516C13.3993 15.3516 15.3515 13.3994 15.3515 11C15.3515 8.60051 13.3993 6.64832 10.9999 6.64832ZM10.9999 13.9011C9.40013 13.9011 8.09878 12.5997 8.09878 11C8.09878 9.40029 9.40017 8.0989 10.9999 8.0989C12.5995 8.0989 13.9009 9.40029 13.9009 11C13.9009 12.5997 12.5996 13.9011 10.9999 13.9011Z" />
                                                        </svg>
                                                    </a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-card-content">
                                               <h6><a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="hover-underline"><?php echo get_the_title(); ?></a></h6>
                                            <p><?php   foreach( get_the_terms(get_the_ID(), 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                               }
                                            ?>
                                              </p>


                                            <p class="price">$<?php echo $saleprice; ?> <del>$<?php echo $regularprice; ?></del></p>
                                            <div class="rating">
                                                <ul>
                                                     <?php for($i=1;$i<=$rating;$i++)
                                    { ?>
                                       <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                    <?php 
                                    }
                                    if($ratebalance>0)
                                    {
                                    for($j=1;$j<=$ratebalance;$j++){
                                    ?>
                                          <li><a href="#"><i class="bi bi-star"></i></a></li>
                                    <?php 
                                    }
                                    }


                                    ?>
                                                </ul>
                                                <!--<span>(50)</span> -->
                                            </div>
                                    </div>
                                    <span class="for-border"></span>
                                </div>


                            </div>
                        <?php endwhile;wp_reset_query(); ?>
                    
                                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="exclusive-product-section mb-110">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/vector-3.svg" alt class="vector3">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/icon/vector-4.svg" alt class="vector4">
        <div class="container">
            <div class="section-title style-2 text-center">
                <h3><?php echo get_field('exclusive_product_title'); ?></h3>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper exclusive-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="exclusive-product-left">
                                            <h2><?php echo get_field('first_product_title'); ?></h2>
                                            <?php echo get_field('first_product_sub_text'); ?>
                                              <?php echo get_field('first_product_features'); ?>
                                            <a href="<?php the_field('first_product_buy_now_link') ?>" class="primary-btn1 hover-btn3"><?php the_field('first_product_buy_now_text') ?></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="exclusive-product-right">
                                            <div class="product-right-img hover-img">
                                                <a href="#">
                                                    <img src="<?php the_field('first_product_hover_image'); ?>" alt>
                                                </a>
                                            </div>
                                            <div class="product-right-content">
                                                <a href="#">
                                                    <img src="<?php the_field('first_product_image'); ?>" alt>
                                                </a>
                                                <div class="star-bg">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/star.svg" alt>
                                                    <span>NEW</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="exclusive-product-left">
                                            <h2><?php echo get_field('second_product_title'); ?></h2>
                                           <?php echo get_field('second_product_subtext'); ?>
                                           <?php echo get_field('second_product_features'); ?>
                                            <a href="<?php echo get_field('second_product_buy_now_'); ?>" class="primary-btn1 hover-btn3"><?php echo get_field('second_product_buy_now_text'); ?></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="exclusive-product-right">
                                            <div class="product-right-img hover-img">
                                                <a href="#">
                                                    <img src="<?php echo get_field('second_product_hover_image') ?>" alt>
                                                </a>
                                            </div>
                                            <div class="product-right-content">
                                                <a href="#">
                                                    <img src="<?php echo get_field('second_product_image'); ?>" alt>
                                                </a>
                                                <div class="star-bg">
                                                    <img src="<?php bloginfo('template_url'); ?>assets/img/home1/star.svg" alt>
                                                    <span>NEW</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="slider-btn">
                        <div class="prev-btn exclusive-prev-btn">
                            <i class="bi bi-arrow-up"></i>
                        </div>
                        <div class="next-btn exclusive-next-btn">
                            <i class="bi bi-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="special-offer-section mb-110">
        <div class="container">
            <div class="section-title2 style-2">
                <h3><?php echo get_field('special_offer_title'); ?></h3>
            </div>
            <div class="special-offer-wrapper">
                <div class="row">
                    <div class="col-lg-4 p-lg-0">
                        <div class="special-offer-left">
                            <?php echo get_field('special_offer_intro_text'); ?>
                            <div class="hurry-bg">
                                <svg width="65" height="65" viewBox="0 0 65 65" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M30.4435 1.58116C31.4962 0.259924 33.5038 0.259924 34.5565 1.58116V1.58116C35.4448 2.69608 37.0597 2.90009 38.1973 2.0411V2.0411C39.5455 1.02317 41.4901 1.52244 42.1811 3.06395V3.06395C42.7642 4.36476 44.2776 4.96398 45.5932 4.4149V4.4149C47.1521 3.76422 48.9114 4.7314 49.1974 6.39632V6.39632C49.4387 7.80127 50.7556 8.75805 52.1663 8.55338V8.55338C53.8381 8.31084 55.3016 9.68515 55.1645 11.3689V11.3689C55.0488 12.7897 56.0864 14.0439 57.5037 14.1965V14.1965C59.1833 14.3774 60.2591 16.0724 59.7076 17.6692V17.6692C59.2422 19.0166 59.9352 20.4895 61.2701 20.9897V20.9897C62.8519 21.5826 63.4723 23.492 62.5411 24.9014V24.9014C61.7552 26.0907 62.0602 27.6897 63.2287 28.5062V28.5062C64.6134 29.4738 64.7395 31.4775 63.487 32.611V32.611C62.43 33.5675 62.3278 35.1921 63.2565 36.2736V36.2736C64.3571 37.5552 63.9809 39.5272 62.4858 40.3137V40.3137C61.2242 40.9773 60.7212 42.5254 61.3518 43.8039V43.8039C62.0991 45.3189 61.2443 47.1354 59.6006 47.5254V47.5254C58.2136 47.8544 57.3414 49.2288 57.6342 50.6239V50.6239C57.9813 52.2771 56.7016 53.8241 55.0125 53.793V53.793C53.5873 53.7667 52.4007 54.881 52.3374 56.3051V56.3051C52.2623 57.9927 50.6381 59.1728 49.0099 58.7226V58.7226C47.6359 58.3428 46.2095 59.1269 45.794 60.4906V60.4906C45.3017 62.1065 43.435 62.8456 41.9699 62.0047V62.0047C40.7336 61.295 39.157 61.6998 38.4154 62.9173V62.9173C37.5366 64.36 35.5449 64.6117 34.3349 63.4328V63.4328C33.3139 62.438 31.6861 62.438 30.6651 63.4328V63.4328C29.4551 64.6117 27.4634 64.36 26.5846 62.9173V62.9173C25.843 61.6998 24.2664 61.295 23.0301 62.0047V62.0047C21.565 62.8456 19.6983 62.1065 19.206 60.4906V60.4906C18.7905 59.1269 17.3641 58.3428 15.9901 58.7226V58.7226C14.3619 59.1728 12.7377 57.9927 12.6626 56.3051V56.3051C12.5993 54.881 11.4127 53.7667 9.98747 53.793V53.793C8.29845 53.8241 7.01874 52.2771 7.36578 50.6239V50.6239C7.65863 49.2288 6.78642 47.8544 5.3994 47.5254V47.5254C3.75571 47.1354 2.9009 45.3189 3.64819 43.8039V43.8039C4.27879 42.5254 3.77578 40.9773 2.51416 40.3137V40.3137C1.01908 39.5272 0.642888 37.5552 1.74347 36.2736V36.2736C2.67219 35.1921 2.56999 33.5675 1.51304 32.611V32.611C0.260513 31.4775 0.386573 29.4738 1.77129 28.5062V28.5062C2.93979 27.6897 3.24481 26.0907 2.45895 24.9014V24.9014C1.52767 23.492 2.14806 21.5826 3.72992 20.9897V20.9897C5.06477 20.4895 5.75784 19.0166 5.29244 17.6692V17.6692C4.74093 16.0725 5.81667 14.3774 7.49627 14.1965V14.1965C8.9136 14.0439 9.95118 12.7897 9.83549 11.3689V11.3689C9.6984 9.68515 11.1619 8.31084 12.8337 8.55338V8.55338C14.2444 8.75805 15.5613 7.80127 15.8026 6.39632V6.39632C16.0886 4.7314 17.8479 3.76422 19.4068 4.4149V4.4149C20.7224 4.96398 22.2358 4.36475 22.8189 3.06395V3.06395C23.5099 1.52244 25.4545 1.02317 26.8027 2.0411V2.0411C27.9403 2.90009 29.5552 2.69608 30.4435 1.58116V1.58116Z" />
                                </svg>
                                <?php echo get_field('hurry_up_text'); ?>
                            </div>
                           <!-- <div class="offer-timer">
                                <p>Offer Will Be End:</p>
                               <div class="countdown-timer">
                                    <ul data-countdown="2023-10-23 12:00:00">
                                        <li data-days="00">00</li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="13"
                                                viewBox="0 0 4 13">
                                                <path
                                                    d="M0 11.0633C0 11.5798 0.186992 12.0317 0.560976 12.419C0.95122 12.8063 1.43089 13 2 13C2.58537 13 3.06504 12.8063 3.43903 12.419C3.81301 12.0317 4 11.5798 4 11.0633C4 10.5146 3.81301 10.0546 3.43903 9.68343C3.06504 9.29609 2.58537 9.10242 2 9.10242C1.43089 9.10242 0.95122 9.29609 0.560976 9.68343C0.186992 10.0546 0 10.5146 0 11.0633ZM0 1.96089C0 2.49348 0.186992 2.95345 0.560976 3.34078C0.95122 3.72812 1.43089 3.92179 2 3.92179C2.58537 3.92179 3.06504 3.72812 3.43903 3.34078C3.81301 2.95345 4 2.49348 4 1.96089C4 1.42831 3.81301 0.968343 3.43903 0.581006C3.06504 0.193669 2.58537 0 2 0C1.43089 0 0.95122 0.193669 0.560976 0.581006C0.186992 0.968343 0 1.42831 0 1.96089Z" />
                                            </svg>
                                        </li>
                                        <li data-hours="00">00</li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="13"
                                                viewBox="0 0 4 13">
                                                <path
                                                    d="M0 11.0633C0 11.5798 0.186992 12.0317 0.560976 12.419C0.95122 12.8063 1.43089 13 2 13C2.58537 13 3.06504 12.8063 3.43903 12.419C3.81301 12.0317 4 11.5798 4 11.0633C4 10.5146 3.81301 10.0546 3.43903 9.68343C3.06504 9.29609 2.58537 9.10242 2 9.10242C1.43089 9.10242 0.95122 9.29609 0.560976 9.68343C0.186992 10.0546 0 10.5146 0 11.0633ZM0 1.96089C0 2.49348 0.186992 2.95345 0.560976 3.34078C0.95122 3.72812 1.43089 3.92179 2 3.92179C2.58537 3.92179 3.06504 3.72812 3.43903 3.34078C3.81301 2.95345 4 2.49348 4 1.96089C4 1.42831 3.81301 0.968343 3.43903 0.581006C3.06504 0.193669 2.58537 0 2 0C1.43089 0 0.95122 0.193669 0.560976 0.581006C0.186992 0.968343 0 1.42831 0 1.96089Z" />
                                            </svg>
                                        </li>
                                        <li data-minutes="00">00</li>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="13"
                                                viewBox="0 0 4 13">
                                                <path
                                                    d="M0 11.0633C0 11.5798 0.186992 12.0317 0.560976 12.419C0.95122 12.8063 1.43089 13 2 13C2.58537 13 3.06504 12.8063 3.43903 12.419C3.81301 12.0317 4 11.5798 4 11.0633C4 10.5146 3.81301 10.0546 3.43903 9.68343C3.06504 9.29609 2.58537 9.10242 2 9.10242C1.43089 9.10242 0.95122 9.29609 0.560976 9.68343C0.186992 10.0546 0 10.5146 0 11.0633ZM0 1.96089C0 2.49348 0.186992 2.95345 0.560976 3.34078C0.95122 3.72812 1.43089 3.92179 2 3.92179C2.58537 3.92179 3.06504 3.72812 3.43903 3.34078C3.81301 2.95345 4 2.49348 4 1.96089C4 1.42831 3.81301 0.968343 3.43903 0.581006C3.06504 0.193669 2.58537 0 2 0C1.43089 0 0.95122 0.193669 0.560976 0.581006C0.186992 0.968343 0 1.42831 0 1.96089Z" />
                                            </svg>
                                        </li>
                                        <li data-seconds="00">00</li>
                                    </ul>
                                </div> 
                            </div> -->
                            <a href="<?php echo get_field('special_offer_shop_now_link'); ?>" class="primary-btn1 style-2 hover-btn3"><?php echo get_field('special_offer_shop_now_label'); ?></a>
                        </div>
                    </div>
                    <div class="col-lg-8 p-lg-0">
                        <div class="slick-wrapper">
                            <div id="slick2">
   <?php $allspecialofferproducts = get_field('select_special_offer_products'); 

             foreach($allspecialofferproducts as $eachspecialoffer){

                $product = new WC_product($eachspecialoffer);
$attachment_ids = $product->get_gallery_image_ids();

  $regularprice = get_post_meta( $eachspecialoffer, '_regular_price', true); 
  $saleprice = get_post_meta( $eachspecialoffer, '_sale_price', true); 
  $discount = $regularprice - $saleprice;
  $discountpercent = $discount/$regularprice*100;

   $rating = get_field('product_rate',$eachspecialoffer);
                    $rateloopcount = 0;
                    $ratebalance = 5-$rating;


   ?>

                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img double-img">
                                            <a href="<?php echo get_the_permalink($eachspecialoffer); ?>">

                                  <?php if( (count($attachment_ids) >0) && (!(empty($attachment_ids))) )
                                { ?>

                                <img src="<?php echo get_the_post_thumbnail_url($eachspecialoffer); ?>" alt class="img0">

                                <?php 
                                  $attachmentcount = 1;
                                foreach($attachment_ids as $eachattachid)
                                {
                                      $attachmentcount++;
                                 ?>

                                <img src="<?php echo wp_get_attachment_url( $eachattachid ); ?>" alt class="img<?php echo $attachmentcount;  ?>">
                            <?php } ?>
                              

                            <?php }
                            else
                            { 
                                ?>
                                   <img src="<?php echo get_the_post_thumbnail_url($eachspecialoffer); ?>" alt class="img0">

                          <?php 
                             }

                             ?>


                                                
                                                <div class="batch">
                                                    <span>-<?php echo  number_format($discountpercent, 1);  ?>%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <?php if(is_user_logged_in())
                                   { ?>

                                   <div class="cartdiv"><a href="javascript:void(0)" class="add-to-cart-button btn btn-outline-dark" data-toggle="tooltip" data-placement="left" data-product_id="<?php echo $eachspecialoffer;  ?>" data-quantity="<?php echo "1"; ?>" class="fa-solid fa-cart-shopping" aria-label="Search" data-bs-original-title="Search"><i class="bi bi-cart"></i> Add to cart</a></div>
                               <?php 
                                   }
                                   else
                                   {
                                    ?>
                                <div class="cartdiv"> <a href="<?php echo get_site_url(); ?>/my-account"><strong>Login to add to cart</strong></a></div>

                                  <?php 
                                   }

                                    ?>
                                            </div>
                                        </div>


                                         
                                        <div class="product-card-content">
                                            <h6><a href="<?php echo get_the_permalink($eachspecialoffer); ?>" class="hover-underline"><?php echo get_the_title($eachspecialoffer); ?></a></h6>
                                           <p><?php   foreach( get_the_terms($eachspecialoffer, 'product_cat') as $cat ) { ?>
 
                                               <a href="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></a>
                                           <?php 
                                               }
                                            ?>
                                              </p>
                                            <p class="price">$<?php echo $saleprice; ?> <del>$<?php echo $regularprice; ?></del></p>
                                            <div class="rating">
                                                
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
                                               
                                                <!--<span>(50)</span> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>



                                <!--<div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-02.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Dewy Fresh
                                                    Face</a></h6>
                                            <p><a href="#">Pure Bliss</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-03.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Rose Petal
                                                    Flush</a></h6>
                                            <p><a href="#">Velvet Tint</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-04.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Hydrating
                                                    Waves</a>
                                            </h6>
                                            <p><a href="#">Crystal Gleam</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img double-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-05.png" alt class="img1">
                                                <img src="assets/img/home1/sp-product-img-01.png" alt class="img2">
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Velvet Red
                                                    Charm</a></h6>
                                            <p><a href="#">Radiant</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-06.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Intensive
                                                    Cream</a>
                                            </h6>
                                            <p><a href="#">Nectar Nouri</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-01.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Mystic Woods
                                                    Aroma</a></h6>
                                            <p><a href="#">Whispering</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-02.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Dewy Fresh
                                                    Face</a></h6>
                                            <p><a href="#">Pure Bliss</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-03.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Rose Petal
                                                    Flush</a></h6>
                                            <p><a href="#">Velvet Tint</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-04.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Hydrating
                                                    Waves</a>
                                            </h6>
                                            <p><a href="#">Crystal Gleam</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-05.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Velvet Red
                                                    Charm</a></h6>
                                            <p><a href="#">Radiant</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="product-card style-4">
                                        <div class="product-card-img">
                                            <a href="#">
                                                <img src="assets/img/home1/sp-product-img-06.png" alt>
                                                <div class="batch">
                                                    <span>-15%</span>
                                                </div>
                                            </a>
                                            <div class="overlay">
                                                <div class="cart-area">
                                                    <a href="#" class="hover-btn3 add-cart-btn"><i
                                                            class="bi bi-bag-check"></i> Add
                                                        To Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-card-content">
                                            <h6><a href="#" class="hover-underline">Intensive
                                                    Cream</a>
                                            </h6>
                                            <p><a href="#">Nectar Nouri</a></p>
                                            <p class="price">$150.00 <del>$200.00</del></p>
                                            <div class="rating">
                                                <ul>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                </ul>
                                                <span>(50)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="best-brand-section mb-110">
        <div class="container-fluid">
            <div class="section-title style-2 text-center">
                
                <h3><?php echo  $bestbrandtitle = CFS()->get( 'our_best_brand_title' ); ?> </h3>
            </div>
            <div class="best-brand-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper brand-slider">
                            <div class="swiper-wrapper">
                                <?php $ourbestbrand = CFS()->get('our_best_brand_repeat'); 
                                    foreach($ourbestbrand as $eachbestbrand){
                                ?>

                                <div class="swiper-slide">
                                    <div class="brand-icon">
                                        <a href="<?php echo $eachbestbrand['our_best_brand_link']; ?>">
                                            <img src="<?php echo $eachbestbrand['our_best_brand_image']; ?>" alt>
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

    <div class="say-about-section">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/testimonial-vector-2.png" alt class="vector3">
        <img src="<?php bloginfo('template_url'); ?>/assets/img/home1/testimonial-vector-1.png" alt class="vector4">
        <div class="container-fluid p-0">
            <div class="section-title2 style-3">
                <h3>They Say About Our Product</h3>
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


  
<?php get_footer(); ?>