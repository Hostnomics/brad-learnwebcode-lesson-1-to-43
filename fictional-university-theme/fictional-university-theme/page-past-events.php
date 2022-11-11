<?php get_header(); 

// Primarily from: Lesson 35: Displaying PAST EVENTS Custom Post Types of type 'event'
// https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7440944#overview

?>



            <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                  
                  
                <h1 class="page-banner__title">
                    <!--Welcome To Our Blog-->
                    
                    <?php //the_archive_title(); ?>
                    <!--All Events-->
                    Past Events
                </h1>
                
                
                <div class="page-banner__intro">
                  <!--<p>Keep Up With Our Blog.</p>-->
                  <p><?php // the_archive_description(); ?></p>
                  
                  <?php
                    $todaysDate = new DateTime(); 
                    $displayTodaysDate = $todaysDate->format('l jS \of F Y \a\t h:i:s A');
                  ?>
                  <p>A recap of our past events prior to: <br>
                  <?php echo $displayTodaysDate; ?></p>
                  
                </div>
              </div>
            </div>


            <div class="container container--narrow page-section">
                
                <?php
                
                
        // Create Custom Query at 4:10 of Lesson 35: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7440944#overview    
        $today = date('Ymd');    
            $pastEvents = new WP_Query(array(
            
            // NEW parameter added for Custom Page (past-events) to enable pagination at Lesson 35 at 11:38
                'paged' => get_query_var('paged', 1),
                
                'post_type' => 'event',
                'posts_per_page' => 5,
                    // 'posts_per_page' => -1, // means give us everything that meets our query
                'order' => 'ASC', // default is DESC - (usually date)  // 'order' => 'rand'
        //Minute 6:58 Lesson 33 - using meta            
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date', 
                            'compare' => '<=',
                            'value' => $today, 
                            'type' => 'numeric'
                        )
                    )
         
            )); 
            
                    // while(have_posts()){
                    while($pastEvents->have_posts()){
                        
                       // the_post(); 
                    
                        $pastEvents->the_post(); 
                        
                        ?>
                        
                        
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
                        // echo paginate_links();  // Lesson 35 at 9:32 - Trying to work with default URL based query. But here, we are on past-events (custom slug)
    // Lesson 35 at 10th minute, here is the parameters we need to pass to paginate_links() to get it to work on a custom page / past events custom post type                
                       echo paginate_links(array(
                                // we named our query object $pastEvents
                            'total' => $pastEvents->max_num_pages    
                       )); 
                    
                    
                    ?>
                
                
                
                
            </div>


<?php get_footer(); ?>