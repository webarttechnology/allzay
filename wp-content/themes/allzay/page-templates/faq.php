<?php /* Template Name: FAQ */ 
get_header();
?>


<div class="breadcrumb-section">
<div class="container">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <?php while(have_posts()):the_post(); ?>
<li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
<?php endwhile; ?>
</ol>
</nav>
</div>
</div>


<div class="faq-section mt-110 mb-110">
<div class="container">
<div class="faq-title">
<h1>Frequently Asked Questions</h1>
</div>
<div class="row g-4 mb-110">
<div class="col-lg-4 ">
<div class="faq-item">
<h3>Orders
<svg xmlns="http://www.w3.org/2000/svg" width="27" height="25" viewBox="0 0 27 25">
<path d="M13.3613 5.35714L17.3697 0L17.5924 6.91964L24.0504 4.91071L20.042 10.396L26.5 12.7232L20.042 14.7321L24.0504 20.3125L17.3697 18.0804V25L13.1387 19.4196L9.13025 25L8.90756 18.0804L2.44958 20.0893L6.45798 14.7321L0 12.5L6.45798 10.2679L2.44958 4.91071L9.13025 6.69643V0L13.3613 5.35714Z" />
</svg>
</h3>
</div>
</div>
<div class="col-lg-8">
<div class="faq-content">
<div class="accordion" id="accordionExample">
<?php 
$faqepeat = CFS()->get( 'faq_repeat' );  
$faqcount = 0;
                             foreach($faqepeat as $eachfaq){
                               $faqcount++;

 ?>
<div class="accordion-item">
<h2 class="accordion-header" id="<?php echo $eachfaq['heading_id']; ?>">
<button class="accordion-button  <?php if($faqcount==1) echo ''; else echo ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $eachfaq['collapsetarget']; ?>" aria-expanded="true" aria-controls="<?php echo $eachfaq['collapsetarget']; ?>">
<?php echo $eachfaq['faq_title'];  ?>
</button>
</h2>
<div id="<?php echo $eachfaq['collapsetarget']; ?>" class="accordion-collapse collapse <?php if($faqcount==1) echo 'show'; ?>" aria-labelledby="<?php echo $eachfaq['heading_id']; ?>" data-bs-parent="#accordionExample">
<div class="accordion-body">
<?php echo $eachfaq['faq_answer']; ?>
</div>
</div>
</div> 
<?php  } ?>


</div>
</div>
</div>
</div>
<div class="row g-4 mb-110">
<div class="col-lg-4 ">
<div class="faq-item">
<h3>Products
<svg xmlns="http://www.w3.org/2000/svg" width="27" height="25" viewBox="0 0 27 25">
<path d="M13.3613 5.35714L17.3697 0L17.5924 6.91964L24.0504 4.91071L20.042 10.396L26.5 12.7232L20.042 14.7321L24.0504 20.3125L17.3697 18.0804V25L13.1387 19.4196L9.13025 25L8.90756 18.0804L2.44958 20.0893L6.45798 14.7321L0 12.5L6.45798 10.2679L2.44958 4.91071L9.13025 6.69643V0L13.3613 5.35714Z" />
</svg>
</h3>
</div>
</div>
<div class="col-lg-8">
<div class="faq-content">
<div class="accordion" id="accordionExample2">

<?php 
$faqepeat = CFS()->get( 'product_faq_repeat' );  
$faqcount = 0;
                              foreach($faqepeat as $eachfaq){
                                $faqcount++;

 ?>
<div class="accordion-item">
<h2 class="accordion-header" id="<?php echo $eachfaq['prod_faq_heading_id']; ?>">
<button class="accordion-button  <?php if($faqcount==1) echo ''; else echo ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $eachfaq['prod_faq_collapse_target']; ?>" aria-expanded="true" aria-controls="<?php echo $eachfaq['prod_faq_collapse_target']; ?>">
<?php echo $eachfaq['prod_faq_title'];  ?>
</button>
</h2>
<div id="<?php echo $eachfaq['prod_faq_collapse_target']; ?>" class="accordion-collapse collapse <?php if($faqcount==1) echo 'show'; ?>" aria-labelledby="<?php echo $eachfaq['prod_faq_heading_id']; ?>" data-bs-parent="#accordionExample2">
<div class="accordion-body">
<?php echo $eachfaq['prod_faq_answer']; ?>
</div>
</div>
</div>
<?php } ?>


</div>
</div>
</div>
</div>
<div class="row g-4">
<div class="col-lg-4 ">
<div class="faq-item">
<h3>Gift Cards
<svg xmlns="http://www.w3.org/2000/svg" width="27" height="25" viewBox="0 0 27 25">
<path d="M13.3613 5.35714L17.3697 0L17.5924 6.91964L24.0504 4.91071L20.042 10.396L26.5 12.7232L20.042 14.7321L24.0504 20.3125L17.3697 18.0804V25L13.1387 19.4196L9.13025 25L8.90756 18.0804L2.44958 20.0893L6.45798 14.7321L0 12.5L6.45798 10.2679L2.44958 4.91071L9.13025 6.69643V0L13.3613 5.35714Z" />
</svg>
</h3>
</div>
</div>
<div class="col-lg-8">
<div class="faq-content">
<div class="accordion" id="accordionExample3">

<?php 
$giftfaqrepeat = CFS()->get( 'gift_card_repeat' );  
$faqcount = 0; 
                             foreach($giftfaqrepeat  as $eachfaq){
                               $faqcount++;

 ?>
<div class="accordion-item">
<h2 class="accordion-header" id="<?php echo $eachfaq['gift_card_heading_id']; ?>">
<button class="accordion-button  <?php if($faqcount==1) echo ''; else echo ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $eachfaq['gift_card_collapse_target']; ?>" aria-expanded="true" aria-controls="<?php echo $eachfaq['gift_card_collapse_target']; ?>">
<?php echo $eachfaq['gift_card_title'];  ?>
</button>
</h2>
<div id="<?php echo $eachfaq['gift_card_collapse_target']; ?>" class="accordion-collapse collapse <?php if($faqcount==1) echo 'show'; ?>" aria-labelledby="<?php echo $eachfaq['gift_card_heading_id']; ?>" data-bs-parent="#accordionExample3">
<div class="accordion-body">
<?php echo $eachfaq['gift_card_answer']; ?>
</div>
</div>
</div>
<?php  } ?>


</div>
</div>
</div>
</div>
</div>
</div>


<?php get_footer(); ?>