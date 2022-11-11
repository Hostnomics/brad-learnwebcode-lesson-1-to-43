<?php get_header(); 

// Primarily from: Lesson 29: Displaying Custom Post Types (min 16:30) 
// https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356480#overview

?>



            <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                  
                  
                <h1 class="page-banner__title">
                    <!--Welcome To Our Blog-->
                    
                    <?php //the_archive_title(); ?>
                    <!--All Events-->
                    Upcoming Events
                </h1>
                
                
                <div class="page-banner__intro">
                  <!--<p>Keep Up With Our Blog.</p>-->
                  <p><?php // the_archive_description(); ?></p>
                  
                  <?php
                    $todaysDate = new DateTime(); 
                    $displayTodaysDate = $todaysDate->format('l jS \of F Y \a\t h:i:s A');
                  ?>
                  <p>See what is going on in our world as of <br>
                  <?php echo $displayTodaysDate; ?></p>
                  
                </div>
              </div>
            </div>


            <div class="container container--narrow page-section">
                
                <?php
                
                    while(have_posts()){
                        
                        the_post(); ?>
                        
                        
                            <div class="event-summary">
                                    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                                        
                                      <span class="event-summary__month">
                                            <?php 
                                                // the_time('M'); 
                                                
                                                $eventDate = new DateTime(get_field('event_date')); // New Date object,by default, current server date. basic php
                                                echo $eventDate->format('M'); //
     
                                            ?>
                                      </span>
                                      
                                      <span class="event-summary__day">
                                            
                                            <?php 
                                                // the_time('d'); 
                                                echo $eventDate->format('d'); 
                                            
                                            ?>
                                    
                                        </span>
                                         
                                    </a>
                                    
                                    <div class="event-summary__content">
                                      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                      <p><?php echo wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                                    </div>
                            </div>
                        
                        
                        
                    <?php }  
                    
                        // Add Pagination Links: 
                        echo paginate_links(); 
                    
                    
        // Lesson 35 at 15th minute add link to see Past Events Page
                    ?>
                    
        <hr class="section-break">
            <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events'); ?>">Click Here To Check Out Our Past Events Archive.</a></p> 
            
                
                
                
                
            </div>


<?php get_footer(); ?>