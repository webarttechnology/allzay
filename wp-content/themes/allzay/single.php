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
            <?php if(get_the_post_thumbnail_url(get_the_ID()))
            { ?>

            <div class="col-md-7 text-left">
               <?php the_content(); ?>
            </div>
            <div class="col-md-4 text-left">
                <div class="about-image float-end">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID());  ?>">
                </div>
            </div>
        <?php }
        else
        {
            ?>
              <div class="col-md-12 text-left">
                 <?php the_content(); ?>
              </div>

            <?php 
        }

         ?>


        </div>
    </div>
</section>



<!-- footer -->
<?php
endwhile;

 get_footer(); ?>
