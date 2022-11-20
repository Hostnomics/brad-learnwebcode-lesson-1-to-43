<!-- THE REUSABLE PORTION OF THE EVENT CODE LOGIC WHICH IS USED IN FOUR DIFFERENT TEMPLATES
(1) Homepage (front-page.php)
(2) All Events Archive (archive-event.php) 
(3) Past Events (Custom Page) (page-past-events.php)
(4) Single Program Page  (single-program.php)
 (which uses our Events Code Logic to show upcoming events Related To that single program)

(single-event.php does not contain our Events Code Logic) -->
 


<?php

// Extract the repeating code in our event-summary div out to 
// get_template_part('template-parts/content', 'event');

// then replace the div section below on each of the four templates listed above with: 

get_template_part('template-parts/content', 'event');


// get_template_part() Lesson 47 at 3:40: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7576532#overview *************************************
                     get_template_part('template-parts/event'); //DON'T INCLUDE FILE NAME .php      
//  WORD PRESS NAMING CONVENTION - IT'LL LOOK FOR event-excerpt.php          
                       get_template_part('template-parts/event', 'excerpt'); //DON'T INCLUDE FILE NAME .php 
                        
// LESSON 47 at 6th minute: This WP naming convention gets cool when we can make it dynamic, 
// using a WP function like get_post_type() instead of a static name. Thus serving up different files dynamically!
                       get_template_part('template-parts/content', get_post_type());


                    //    So using something like get_template_part('template-parts/content', get_post_type()); 

                    //    To load dynamic content on an All Search Results Screen (hint upcoming lesson)
                    //    Could get us 
                    //    content-event.php
                    //    content-post.php
                    //    content-professor.php
                    //    For all of our different post types. 
                       
                    //    Just like our DCT Invoice → SMALLER functions in AccountantController (Fri 11/11/22) 
                                            

?>



<?php // ************************* CLEANER VERSION FROM archive-event.php ***************************** ?>

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









<?php // ********************************** MORE DETAILED/NOTED VERSION ********************************************************
                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                                    
<!--DISPLAY EVENT DATE MONTH HERE - Most Changes From Lesson 31 around 11th - 13th+ minute -->
                                      <span class="event-summary__month">
                                          
                                          <?php // the_time('M'); 
//  Lesson 31 at 15:30 could not get DateTime with get_field to work: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356484#notes                                 
                                                // $eventDate = new DateTime(get_field('event_date')); //using class as blueprint (YYYY-MM-DD)
                                                // echo $eventDate->format('M');
                                                
                                               
// HAD TO USE THIS WHEN EVENT DATE WASN'T BEING SET! Lesson 31 at 11:35    the_time('M');
                                                
                                                                    //   $eventDate = new DateTime(the_field('event_date'));
                                                                    //     echo $eventDate->format('M');
                                            
                                    // Lesson 31 at 11:35 
                                            // the_field('event_date'); 
                                    // Lesson 31 at 13:17:          use get_field() as parameter to DateTime object: 
                                            $eventDate = new DateTime(get_field('event_date')); // New Date object,by default, current server date. basic php
                                            echo $eventDate->format('M'); // echo out THREE LETTER month. 
                                               
                                          ?>
                                      </span>
<!-- END OF DISPLAY EVENT DATE MONTH HERE-->  


<!-- END OF DISPLAY EVENT DATE DAY - DIA HERE--> 
                                  <span class="event-summary__day">
                                        <?php 
                                        
                                            // the_time('d'); 
                                         echo $eventDate->format('d');
                                                
                                          ?>
                                  </span>
<!-- END OF DISPLAY EVENT DATE DAY - DIA HERE--> 
                                </a>
                                <div class="event-summary__content">
                                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                  <p>
                                      <?php //echo wp_trim_words(get_the_content(), 18); ?>
                                      
                                      <?php // the_excerpt(); 
                                                if(has_excerpt()){
                                                    // the_excerpt(); 
                                                   echo get_the_excerpt();  
                                                }else{
                                                    echo wp_trim_words(get_the_content(), 18);
                                                }
                                      ?>
                                  
                                  <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                                </div>
                          </div>
                            
                      

