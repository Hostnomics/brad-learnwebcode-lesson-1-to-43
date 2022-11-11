<?php
get_header();


    while(have_posts()){
        the_post();  // gets the data ready for us
        
        // Majority of single-professor.php: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview
                // Original single.php file from: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7277616#notes 
        ?>

<!--LESSON 44: EXTRACT THIS DIV PAGE BANNER CODE INTO A REUSABLE BLOCK VIA Functions.php Function *******************************  -->
<!--LESSON 44: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7576170#overview-->

   <?php pageBanner(); ?>

 <!--LESSON 44: EXTRACT THIS DIV PAGE BANNER CODE INTO A REUSABLE BLOCK VIA Functions.php Function *******************************  -->       
       
       
       <div class="container container--narrow page-section">
           
        
                <?php  // Posted by: <?php the_author_posts_link(); ?> <!--on--> <?php //the_date('F j, Y'); ?> <!--at--> <?php //the_time('g:i a'); ?> <!--in--> <?php //echo get_the_category_list(', '); ?>
                  
                  
                   
<!--LESSON 41 (5:12) Display the featured image with the_post_thumbnail();  -->
                  <!-- <div class="generic-content"> --> <?php //the_post_thumbnail(); the_content(); ?> 
                   <div class="generic-content">
                            <div class="row group">
                                
                                <div class="one-third">
                                    <?php the_post_thumbnail('professorPortrait'); ?>
                                </div>
                                
                                <div class="two-thirds">
                                    <?php the_content(); ?>
                                </div>
                                
                            </div>
                   </div>
               
                
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
                        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';                    
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