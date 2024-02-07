<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

    ?>


    <div class="makeup-section mb-110">
        <div class="container">
             <div class="makeup-top-item">
                <div class="row align-items-center justify-content-center g-0 gy-4">
                        <div class="col-md-12">
                            <header class="page-header alignwide">
                             <h1 class="page-title"><?php esc_html_e( 'Nothing here', '' ); ?></h1>
                            </header><!-- .page-header -->

                            <div class="error-404 not-found default-max-width">
                               <div class="page-content">
                               <p><?php esc_html_e( 'It looks like nothing was found at this location' ); ?></p>
                               </div><!-- .page-content -->
                            </div><!-- .error-404 -->
                        </div>
                       

                </div>
             </div>
      </div>
     </div>

<?php
get_footer();
