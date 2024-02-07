<?php

/**

 * Allzay

 *

 * @package Lifestyle

 */





if ( ! function_exists( 'myfirsttheme_setup' ) ) :

/**

 * Sets up theme defaults and registers support for various WordPress features.

 *

 * Note that this function is hooked into the after_setup_theme hook, which runs

 * before the init hook. The init hook is too late for some features, such as indicating

 * support post thumbnails.

 */

function myfirsttheme_setup() {

 

    /**

     * Make theme available for translation.

     * Translations can be placed in the /languages/ directory.

     */

    load_theme_textdomain( 'myfirsttheme', get_template_directory() . '/languages' );

 

    /**

     * Add default posts and comments RSS feed links to &lt;head>.

     */

    add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

 

    /**

     * Enable support for post thumbnails and featured images.

     */

    add_theme_support( 'post-thumbnails' );

 

    /**

     * Add support for two custom navigation menus.

     */

    register_nav_menus( array(

        'primary'   => __( 'Primary Menu', 'myfirsttheme' ),

        'secondary' => __('Secondary Menu', 'myfirsttheme' )

    ) );

 

    /**

     * Enable support for the following post formats:

     * aside, gallery, quote, image, and video

     */

    add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
    add_theme_support('woocommerce');

}

endif; // myfirsttheme_setup

add_action( 'after_setup_theme', 'myfirsttheme_setup' );





function register_navwalker(){

    require_once get_template_directory() . '/Walker/functions.php';

}

add_action( 'after_setup_theme', 'register_navwalker' );





function get_id_by_slug($page_slug) {

    $page = get_page_by_path($page_slug);

    if ($page) {

        return $page->ID;

    } else {

        return null;

    }

} 





function my_login_logo_url() {

    return home_url();

}

add_filter( 'login_headerurl', 'my_login_logo_url' );

function custom_login_logo() {

   /* echo '<style type="text/css">'.

    '.login h1 {background:#29bb89 !important; padding: 30px 0px 1px 0px;}'.

             'h1 a { background-image:url('.get_site_url().'/wp-content/uploads/2021/09/Layer-2.png) !important; height:auto !important; width:auto !important; background-size: auto !important;}'.

         '</style>';	*/



          echo '<style type="text/css">'.

    '.login h1 { padding: 5px 0px 1px 0px;}'.

             'h1 a { background-image:url('.get_site_url().'/wp-content/uploads/2023/01/logo.png) !important; width:auto !important; height:132px !important; background-size: auto !important;}'.

         '</style>';	

	

	

}


add_action( 'login_head', 'custom_login_logo' );



// Now, just make sure that function runs when you're on the login page and admin pages  

//add_action('login_head', 'add_favicon');

//add_action('admin_head', 'add_favicon');







add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter2', 10, 2 );



function custom_text_validation_filter2( $result, $tag ) {

    if ( 'firstname' == $tag->name ) {

        // matches any utf words with the first not starting with a number

        $re = '/[^A-Za-z_-]/';

  //$re2 = '^[0-9]';

        if (preg_match($re, $_POST['firstname'], $matches)) {

            $result->invalidate($tag, "This is not a valid First name!" );

        }

    }



    return $result;

}



add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter3', 11, 2 );



function custom_text_validation_filter3( $result1, $tag ) {

    if ( 'lastname' == $tag->name ) {

        // matches any utf words with the first not starting with a number

        $re = '/[^A-Za-z_-]/';

  //$re2 = '^[0-9]';

        if (preg_match($re, $_POST['lastname'], $matches)) {

            $result1->invalidate($tag, "This is not a valid Last name!" );

        }

    }



    return $result1;

}



add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter4', 11, 2 );



function custom_text_validation_filter4( $result2, $tag ) {

    if ( 'yourname' == $tag->name ) {

        // matches any utf words with the first not starting with a number

        $re = '/[^A-Za-z_ -]/';

  //$re2 = '^[0-9]';

        if (preg_match($re, $_POST['yourname'], $matches)) {

            $result2->invalidate($tag, "This is not a valid name!" );

        }

    }



    return $result2;

}



function custom_phone_validation($result2,$tag){



    $type = $tag->type;

    $name = $tag->name;



    if($type == 'tel' || $type == 'tel*'){



        $phoneNumber = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';



       if (preg_match("/\\s/", $phoneNumber)) {

    $result2->invalidate($tag, "The telephone number is invalid." );

        }

    

    return $result2;

}

}

add_filter('wpcf7_validate_tel','custom_phone_validation', 10, 2);

add_filter('wpcf7_validate_tel*', 'custom_phone_validation', 10, 2);







add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {

	$wp_admin_bar->remove_node( 'wp-logo' );

}






function wpb_sender_email($original_email_address)

{

    return 'Sales@allzay.com';

}





add_filter('wp_mail_from', 'wpb_sender_email');




function wpb_sender_name( $original_email_from ) {

	return 'Allzay';

}


add_filter( 'wp_mail_from_name', 'wpb_sender_name' );







/*add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {



  show_admin_bar(false);



}*/



/*function register_navwalker(){

	require_once get_template_directory() . '/Walker/class-wp-bootstrap-navwalker.php';

}

add_action( 'after_setup_theme', 'register_navwalker' ); */



add_filter( 'auto_update_plugin', '__return_false' );

add_filter( 'auto_update_theme', '__return_false' );





function prefix_create_testimonials() {
   

    $labels = array(

        'name'          => 'Testimonials', 

        'singular_name' => 'Testimonial'   

    );

  

    $supports = array(

        'title',        

        'editor',       

        'excerpt',      

        'author',       

        'thumbnail',   

        'comments',    

        'trackbacks',   

        'revisions',   

        'custom-fields' 

    );


   

    $args = array(

        'labels'              => $labels,

        'description'         => 'Post type ourtestimonials', 

        'supports'            => $supports,

        'hierarchical'        => false, 

        'public'              => true,  

        'show_ui'             => true,  

        'show_in_menu'        => true,  
        'show_in_nav_menus'   => true,  

        'show_in_admin_bar'   => true,  

        'menu_position'       => 5,     

        'menu_icon'           => true,  

        'can_export'          => true,  

        'has_archive'         => true,  

        'exclude_from_search' => false, 

        'publicly_queryable'  => true,  

        'capability_type'     => 'post',
        'rewrite'            => true

    );



    register_post_type('our-testimonials', $args); 
}

add_action('init', 'prefix_create_testimonials');




function prefix_create_ourevents() {
   

    $labels = array(

        'name'          => 'Ourevents', 

        'singular_name' => 'Ourevent'   

    );

  

    $supports = array(

        'title',        

        'editor',       

        'excerpt',      

        'author',       

        'thumbnail',   

        'comments',    

        'trackbacks',   

        'revisions',   

        'custom-fields' 

    );

   

    $args = array(

        'labels'              => $labels,

        'description'         => 'Post type ourevents', 

        'supports'            => $supports,

        'hierarchical'        => false, 

        'public'              => true,  

        'show_ui'             => true,  

        'show_in_menu'        => true,  
        'show_in_nav_menus'   => true,  

        'show_in_admin_bar'   => true,  

        'menu_position'       => 5,     

        'menu_icon'           => true,  

        'can_export'          => true,  

        'has_archive'         => true,  

        'exclude_from_search' => false, 

        'publicly_queryable'  => true,  

        'capability_type'     => 'post',
        'rewrite'            => true

    );


    register_post_type('ourevents', $args); 
}

add_action('init', 'prefix_create_ourevents');



function prefix_create_ourgallery() {
   

    $labels = array(

        'name'          => 'Ourgallery', 

        'singular_name' => 'Ourgallery'   

    );

  

    $supports = array(

        'title',        

        'editor',       

        'excerpt',      

        'author',       

        'thumbnail',   

        'comments',    

        'trackbacks',   

        'revisions',   

        'custom-fields' 

    );

   

    $args = array(

        'labels'              => $labels,

        'description'         => 'Post type ourgallery', 

        'supports'            => $supports,

        'hierarchical'        => false, 

        'public'              => true,  

        'show_ui'             => true,  

        'show_in_menu'        => true,  
        'show_in_nav_menus'   => true,  

        'show_in_admin_bar'   => true,  

        'menu_position'       => 5,     

        'menu_icon'           => true,  

        'can_export'          => true,  

        'has_archive'         => true,  

        'exclude_from_search' => false, 

        'publicly_queryable'  => true,  

        'capability_type'     => 'post',
        'rewrite'            => true

    );


    register_post_type('ourgallery', $args); 
}

add_action('init', 'prefix_create_ourgallery');




/*function slug_provide_walker_instance( $args ) {

    if ( isset( $args['walker'] ) && is_string( $args['walker'] ) && class_exists( $args['walker'] ) ) {

        $args['walker'] = new $args['walker'];

    }

    return $args;

}

add_filter( 'wp_nav_menu_args', 'slug_provide_walker_instance', 1001 );*/







 function slugify($text, string $divider = '-')

{

  // replace non letter or digits by divider

  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate

  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters

  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim

  $text = trim($text, $divider);

  // remove duplicate divider

  $text = preg_replace('~-+~', $divider, $text);

  // lowercase

  $text = strtolower($text);

  if (empty($text)) {

    return 'n-a';

  }

  return $text;

}



    /*  add active class in the anchor */


add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
  if (in_array('current-menu-item', $classes) ){
    $classes[] = 'current ';
  }
  return $classes;
}



/*add_action( 'wpcf7_init', 'wpcf7_add_form_tag_text12' );
 
function wpcf7_add_form_tag_text12() {
  wpcf7_add_form_tag(
    array( 'time', 'time*' ),
    'wpcf7_text_form_tag_handler',
    array( 'name-attr' => true )
  );
}*/



function k99_relative_time() { 
    $post_date = get_the_time('U');
    $delta = time() - $post_date;
    if ( $delta < 60 ) {
        echo 'Less than a minute ago';
    }
    elseif ($delta > 60 && $delta < 120){
        echo 'About a minute ago';
    }
    elseif ($delta > 120 && $delta < (60*60)){
        echo strval(round(($delta/60),0)), ' minutes ago';
    }
    elseif ($delta > (60*60) && $delta < (120*60)){
        echo 'About an hour ago';
    }
    elseif ($delta > (120*60) && $delta < (24*60*60)){
        echo strval(round(($delta/3600),0)), ' hours ago';
    }
    else {
        echo the_time('j\<\s\u\p\>S\<\/\s\u\p\> M y g:i a');
    }
}




/*function update_price() 
{
    $postid = $_POST['formid'];

    $service = $_POST['service'];
    if($service=='Engine Diagnostic & Repair')
    {

        $updatedprice = 100;
         

     }
      else if($service=='Maintanence Inspection')
    {

        $updatedprice = 200;
         

     }
        else if($service=='Electrical System Diagnostic')
    {

        $updatedprice = 300;
         

     }

     else if($service=='Wheel Allignment & Installation')
    {

        $updatedprice = 400;
         

     }
     else if($service=='Air Conditioner Service & Repair')
    {

        $updatedprice = 500;
         

     }
     else{
        $updatedprice = 0;
     }
     if(update_post_meta($postid,'_cf7pp_price',$updatedprice))
     {
        echo 'success';
     }
     else
     {
        echo 'failed';
     }
       
        wp_die();  

}

add_action( 'wp_ajax_nopriv_update_price', 'update_price' );
add_action( 'wp_ajax_update_price', 'update_price' ); */






function start_session() {
if(!session_id()) {
session_start();
}
}
add_action('init', 'start_session', 1);



/*function wpcf7_before_send_mail_function( $contact_form, $abort, $submission ) 
{
  
 
    $form_id = $contact_form->id();
    if($form_id==240)
    {
         // do something 
        $_SESSION['payonline'] = 'yes';
    }

    return $contact_form;
    
}
add_filter( 'wpcf7_before_send_mail', 'wpcf7_before_send_mail_function', 10, 3 );*/



/*add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link header-menu-list'; // or something based on $item
    $atts['class'] = $class;
   
    return $atts;
}*/






function add_to_cart_js() {
    ?>
    <style>
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        jQuery(function($) {
            $('body').on('click', '.add-to-cart-button', function(e) {
                e.preventDefault();

                var button = $(this);
                // var loader = '<span class="loader"></span>';
                // button.html(loader);
                button.prop('disabled', true);
                button.css('pointer-events', 'none');

                var product_id = button.data('product_id');
                var quantity = button.data('quantity');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'add_to_cart_action',
                        product_id: product_id,
                        quantity: quantity,
                    },
                    success: function(response) {
                        // Update button content after successful addition
                        button.prop('disabled', false);
                        button.css('pointer-events', 'auto');
                        button.html('<a href="<?php echo wc_get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i>View Cart</a>');
                    }
                });
            });

            // Redirect to the cart page when "View Cart" is clicked
            $('body').on('click', '.add-to-cart-button a', function(e) {

                
                button.html('<a href="<?php echo wc_get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i>View Cart</a>');
                e.preventDefault();
                window.location.href = '<?php echo wc_get_cart_url(); ?>';
            });
        });
    </script>
    <?php
}

add_action('wp_footer', 'add_to_cart_js');



function add_to_cart_ajax_handler() {
    if (isset($_POST['product_id'])) {
        $product_id = absint($_POST['product_id']);
        $quantity = isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : 1;

        WC()->cart->add_to_cart($product_id, $quantity);
        echo json_encode(array('status' => 'success'));
    }

    die();
}

add_action('wp_ajax_add_to_cart_action', 'add_to_cart_ajax_handler');
add_action('wp_ajax_nopriv_add_to_cart_action', 'add_to_cart_ajax_handler');




add_filter('post_class', function($classes, $class, $product_id) {
    if(is_product_category()) {
        //only add these classes if we're on a product category page.
        $classes = array_merge(['prodlist','prodlist1'], $classes);
    }
    return $classes;
},10,3);



add_filter( 'woocommerce_get_price_html', 'bbloomer_hide_price_addcart_not_logged_in', 9999, 2 );
 
function bbloomer_hide_price_addcart_not_logged_in( $price, $product ) {
   if ( ! is_user_logged_in() ) { 
      $price = '<div><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '" class="loginpricee">' . __( 'View Price', 'bbloomer' ) . '</a></div>';
      remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
      add_filter( 'woocommerce_is_purchasable', '__return_false' );
   }
   return $price;
}


add_filter('gettext', 'change_ymal');

function change_ymal($translated) 
{
	$translated = str_ireplace('You may also like…', 'Related products', $translated);
	return $translated; 
}

/*add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 3; 
    }
}*/


add_action( 'woocommerce_single_product_summary', 'dev_designs_show_sku', 5 );
function dev_designs_show_sku(){
    global $product;
  $categoryids = $product->get_category_ids();
  $termnamearray = array();
  foreach($categoryids as $eachcatid)
  {
    $term = get_term_by('term_id', $eachcatid, 'product_cat'); 
          $termnamearray[]=$term->name;
  }

    
    echo '<div class="product_meta"><span>SKU: ' . $product->get_sku().' Categories: '.implode(",",$termnamearray).'</span></div>';
}




add_filter( 'get_search_form', 'my_search_form1' );

function my_search_form1( $form ) {

    $form = '<form role="search" class="text-end"  action="'. get_site_url().'/shop">
                        
                           <div class="form-inner">
                             <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" required />
                            <button type="submit"><i class="bx bx-search"></i></button>
                            </div>
                        
                    </form> 

                    ';

    return $form;
}



/* Only restricting woocommerce default search to search by title    */

function wpse_11826_search_by_title_only( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

       /* 
       Removing user logged in restrictions
       if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''"; */

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}

add_filter( 'posts_search', 'wpse_11826_search_by_title_only', 10, 2 );
/* Only restricting woocommerce default search to search by title    */