<?php get_header(); 

// Primarily from: Lesson 36: Program Custom Post Type (Relationships b/t content) at 7:37: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7451310#overview
// 
        // (Template from lesson 29 archive-event.php) https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356480#overview

?>



            <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                  
                  
                <h1 class="page-banner__title">
                    <!--Welcome To Our Blog-->
                    
                    <?php //the_archive_title(); ?>
                    <!--All Events-->
                    All Programs
                </h1>
                
                
                <div class="page-banner__intro">
                  <!--<p>Keep Up With Our Blog.</p>-->
                  <p><?php // the_archive_description(); ?></p>
                  
                  <?php
                    $todaysDate = new DateTime(); 
                    $displayTodaysDate = $todaysDate->format('l jS \of F Y \a\t h:i:s A');
                  ?>
                  <p>All our Programs as of <br>
                  <?php echo $displayTodaysDate; ?></p>
                  
                </div>
              </div>
            </div>


            <div class="container container--narrow page-section">


               <ul class="link-list min-list"> 
                    <?php
                        while(have_posts()){
                            
                            the_post(); ?>
                            
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                 
                        <?php }  
                        
                            // Add Pagination Links: 
                            echo paginate_links(); ?>
                </ul>     
                    
            
                
                
                
                
            </div>


<?php get_footer(); ?>