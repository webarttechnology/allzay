<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
get_header();
$pageid = get_id_by_slug('site-general-settings');

$s=get_search_query();

$args = array(
                's' =>$s
	             
            );
    // The Query
$the_query = new WP_Query( $args );

?>

 <!--Page Title-->
     <section class="page-title" style="background-image:url(<?php //echo get_field('inner_banner'); ?>);">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <h1>Search Result</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
                    <li>Search result</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Services Section -->
    <section class="services-page-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- Service Block -->
                <?php 
				if($the_query->have_posts()):
							
				while($the_query->have_posts()):$the_query->the_post(); ?>
                <div class="service-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure><img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt=""></figure>
                            <div class="title"><h4><?php the_title(); ?></h4></div>
                        </div>
                        <div class="caption-box">
                            <div class="title-box">
                                <span class="icon flaticon-electrical"></span>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                            <p><?php echo wp_trim_words(get_the_content(),12,'...'); ?></p>
                            <a href="<?php the_permalink(); ?>" class="read-more">Read More <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endwhile;wp_reset_query(); 
				else:
				  echo '<p>Sorry nor services abailable for the specified search</p>';
				
				
				endif; ?>

            
            </div>
      
        
        </div>
    </section>
    <!-- End Services Section -->
  
    <!--End Clients Section-->

 <?php get_footer(); ?>
