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


  ?>


<!-- banner -->

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



  <div class="makeup-section mb-110">
        <div class="container">

            <div class="makeup-top-item">
                <div class="row align-items-center justify-content-center g-0 gy-4">
                    <?php if(get_the_post_thumbnail_url(get_the_ID())) 
                    {
                        ?>
                    <div class="col-lg-6">
                        <div class="makeup-img hover-img">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="makeup-content generalpage">
                           <?php the_content(); ?>
         
                        </div>
                    </div>
                <?php  
                    }
                else
                {
                    ?>
                       <div class="col-lg-12">
                        <div class="makeup-content generalpage">
                           <?php the_content(); ?>
         
                        </div>
                    </div>

              <?php
                 }


                 ?>
                </div>
            </div>
         
        </div>
    </div>




<!-- footer -->
<?php
endwhile;

 get_footer(); 
