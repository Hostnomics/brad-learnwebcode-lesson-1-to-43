<?php
get_header();


    while(have_posts()){
        the_post();  // gets the data ready for us
        
        // Majority changes from: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7277616#notes
         
        ?>
    

        <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php  echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php  the_title(); ?></h1>
                <div class="page-banner__intro">
                  <p>CHANGE LATER - <?php bloginfo('description'); ?></p>
                </div>
              </div>
        </div>

   
   
       
       
       <div class="container container--narrow page-section">
           
           <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                  <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Blog Home</a> 
                  <span class="metabox__main">Posted by: <?php the_author_posts_link(); ?> on <?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?> in <?php echo get_the_category_list(', '); ?></span>
                </p>
          </div>
           
           
           <div class="generic-content">
               
               <?php the_content(); ?>
               
           </div>
           
        </div>
       
        
        <?php //the_title(); ?>
        
        <?php //the_content(); ?>
        
        <hr>
    <?php }


get_footer();
?>  