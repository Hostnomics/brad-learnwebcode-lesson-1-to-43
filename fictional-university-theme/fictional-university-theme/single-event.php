<?php
get_header();


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
                          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> 
                          <span class="metabox__main"><?php the_title(); ?></span>
                        </p>
                  </div>
                  
                  
                  
                <?php  // Posted by: <?php the_author_posts_link(); ?> <!--on--> <?php //the_date('F j, Y'); ?> <!--at--> <?php //the_time('g:i a'); ?> <!--in--> <?php //echo get_the_category_list(', '); ?>
                  
                  
                   
                   
                   <div class="generic-content"> <?php the_content(); ?> </div>
               
                
    <!--LESSON 37 @ 1:39: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7466254#overview   -->
                
                
                <?php
                            // Display Related Programs Custom Field on Events
                            // Our Advanced Custom Fields Plugin gives us access to the get_field() function:
                                // in the parameter, tell it which custom field name you want to retrieve
                                
                $relatedPrograms = get_field('related_programs'); //saving the value of related_programs custom field to $relatedPrograms
                    
                            // To see what you are working with you can check it out with print_r (like dd())
                            // print_r($relatedPrograms); // returns array 
        
        
                if($relatedPrograms){
                        echo '<hr class="section-break">'; 
                        echo '<h2 class="headline headline--medium">Related Program(s)</h2>';                    
                        echo '<ul class="link-list min-list">';     
                
                        foreach($relatedPrograms as $program) { ?>
                               
                                   <?php
                                        // this works, but no the WP way: 
                                            //   echo $program->post_title; // the_title() only works when you are within the main WP loop. 
                                            //   echo '<br>';
                                        //echo "<li>" . get_the_title($program) . "</li>"; //pass it a wordpress post object or an ID of a specific post. Here use post object.
                                    ?>
                                
                            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>   
                                
                       <?php }
                        echo '</ul>';   
                }
                        ?>
 <!--END OF LESSON 37 @ 1:39: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7466254#overview   -->      
 
        </div>
       
        
        <?php //the_title(); ?>
        
        <?php //the_content(); ?>
        
        <hr>
    <?php }


get_footer();
?>  