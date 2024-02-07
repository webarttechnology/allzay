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

$pageid = get_id_by_slug('site-general-settings');
while(have_posts()):the_post();

  ?>


<!-- banner -->

    <section class="banner-part innerbanner" style="background-image:url(<?php the_field('inner_banner'); ?>);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="banner-text">
                    <h1><?php the_title(); ?></h1>
                                  
                </div>
            </div>
        </div>
    </div>
</section>


<!-- selling-product -->
<section class="innerContent">
    <div class="categories-image1">
        <img src="<?php echo get_field('greenish_leaves',$pageid); ?>">
    </div>
    <div class="categories-image2">
        <img src="<?php echo get_field('fishes',$pageid); ?>">
    </div>
    <div class="container">
        <div class="row justify-content-center">
       
              <div class="col-md-12 text-left">
                <ul>
                    <li><h3>Title : <?php the_title(); ?></h3></li>
                    <li><h3>Date : <?php echo get_the_date(); ?></h3></li>
                    <li><h3>Location : <?php echo get_field('event_address',get_the_ID()); ?></h3></li>
                    <li><h3>Room/booth no : <?php echo get_field('booth_number',get_the_ID()); ?></h3></li>
                </ul>
                <hr>
                 <h4><i><?php the_content(); ?></i></h4>
              </div>
   


        </div>
    </div>
</section>



<!-- footer -->
<?php
endwhile;

 get_footer(); ?>
