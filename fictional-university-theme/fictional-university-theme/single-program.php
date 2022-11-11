<?php

//the_ID(); 

get_header();

// single-program.php from Lesson 36: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7451310#overview

    while(have_posts()){
        the_post();  // gets the data ready for us
        
        // Majority of single-event.php: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356480#overview
                // Original single.php file from: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7277616#notes 
        ?>
        
        <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <div class="page-banner__intro">
                  <p>CHANGE LATER - <?php bloginfo('description'); ?></p>
                </div>
              </div>
        </div>
        
       
       
       <div class="container container--narrow page-section">
           
               <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                                            <?php // use WP function to autmoatically get URL for events in chase it chages. Remoe echo site_url('/events') 
                                                // From 19th minute of https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356480#overview
                                            ?>
                      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                          <i class="fa fa-home" aria-hidden="true"></i> 
                          All Programs
                      </a>
                      
                      <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
              </div>
              
              
              
            <?php  // Posted by: <?php the_author_posts_link(); ?> <!--on--> <?php //the_date('F j, Y'); ?> <!--at--> <?php //the_time('g:i a'); ?> <!--in--> <?php //echo get_the_category_list(', '); ?>
              
              
               
               
               <div class="generic-content"><?php the_content(); ?></div>
 <!--END OF PROGRAM DESCRIPTION  -->
          
<!--START OF INCLUDING PROFESSORS WHO TEACH THIS SUBJECT FROM LESSON 40 MINUTE (11:39): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview -->


            <?php
            
        // $today = date('Ymd'); Don't need first filter returning events greater/equal to today
                $relatedProfessors = new WP_Query(array(
  
                    'posts_per_page' => -1,
                    'post_type' => 'professor',
                    // 'meta_key' => 'event_date', // we don't need a custom meta key to order professors by (11:51)
                    'orderby' => 'title', // orderby name alphabetically
                    'order' => 'ASC', // default is DESC - (usually date)
                    
                    'meta_query' => array(
    // Remove 1st filter returning events greater than or equal to today:
                    //     array(
                    //         'key' => 'event_date', 
                    //         'compare' => '>=',
                    //         'value' => $today, 
                    //         'type' => 'numeric'
                    //     ),
        // We will keep the second filter    
                        array(
                            'key' => 'related_programs',
                            'compare' => 'LIKE', 
                            'value' => '"' . get_the_ID() . '"' //Lesson 31 at 19:20; this may be dated, it was working for me with just get_the_ID()
                            
                            // Lesson 37 - Serialize Array - array(12, 120, 1200) can't be saved in DB.
                            // so after serializing it, it gets saved as a:3:{i:0;i:12;i:1:120;i:2;i1200;}
                            // WP wraps each array value in quotes so they can be searched, ie "12" vs "120" vs "1200"
                        )
                    )
                   
                )); 
       
    if($relatedProfessors->have_posts()){  
       echo '<hr class="section-break">';
       echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
            
            echo '<ul class="professor-cards">';    
                while($relatedProfessors->have_posts()){
                    // gets the data ready for each post, each time the code repeats itself
                        $relatedProfessors->the_post(); ?> 
           
                <!--Display Name of Professor with link to Professor's page at Lesson 40 (13:55)  -->
                       <!--<li><a href="<?php //the_permalink(); ?>">--> <?php //the_title(); //the_ID(); ?> <!--</a></li>-->
                <!--Style and feature image as thumbnail added in Lesson 41 at (8:06) -->        
                        <li class="professor-card__list-item">
                            <a class="professor-card" href="<?php the_permalink(); ?>">
                                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                                <span class="professor-card__name"><?php the_title(); ?></span>
                            </a>
                        </li>
 
                    <?php } // end of while loop //wp_reset_postdata();
            echo "</ul>"; 
    } // end of IF statement  
    
    // Minute 15:19 of Lesson 40: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview
    // THE FIX to show related events is to run the wp_reset_postdata() after our first Custom Query While Loop!
            wp_reset_postdata();
    ?>

<!--END OF INCLUDING PROFESSORS WHO TEACH THIS SUBJECT FROM LESSON 40 MINUTE (11:39): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview -->                   
          
          
          
<!--START OF PROGRAM -> EVENT RELATIONSHIP IN LESSON 37  (MIN 13 - 15): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7466254#overview -->          
            <?php
            
        $today = date('Ymd');
                $relatedEvents = new WP_Query(array(

                    'post_type' => 'event',
                    'posts_per_page' => 2,
                    'order' => 'ASC', // default is DESC - (usually date)  // 'order' => 'rand'
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date', 
                            'compare' => '>=',
                            'value' => $today, 
                            'type' => 'numeric'
                        ),
                        array(
                            'key' => 'related_programs',
                            'compare' => 'LIKE', 
                            'value' => '"' . get_the_ID() . '"' //Lesson 31 at 19:20; this may be dated, it was working for me with just get_the_ID()
                            
                            // Lesson 37 - Serialize Array - array(12, 120, 1200) can't be saved in DB.
                            // so after serializing it, it gets saved as a:3:{i:0;i:12;i:1:120;i:2;i1200;}
                            // WP wraps each array value in quotes so they can be searched, ie "12" vs "120" vs "1200"
                        )
                    )
                   
                )); 
       
    if($relatedEvents->have_posts()){  
       echo '<hr class="section-break">';
       echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
                
                while($relatedEvents->have_posts()){
                    // gets the data ready for each post, each time the code repeats itself
                        $relatedEvents->the_post(); ?> 
           

                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                                    
        <!--DISPLAY EVENT DATE MONTH HERE - Most Changes From Lesson 31 around 11th - 13th+ minute -->
                                      <span class="event-summary__month">
                                          
                                          <?php // the_time('M'); 

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
                            
                      
                    <?php } //wp_reset_postdata();
    } // end of IF statement              
                ?>


<!--END OF PROGRAM -> EVENT RELATIONSHIP IN LESSON 37  (MIN 13 - 15): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7466254#overview --> 
           
        </div>
       
        
        <?php //the_title(); ?>
        
        <?php //the_content(); ?>
        
        <hr>
    <?php }


get_footer();
?>  