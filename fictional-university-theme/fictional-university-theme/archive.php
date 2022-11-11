<?php get_header(); 

// Primarily from: Lesson 24: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7277618#notes

?>



            <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                  
                  
                <h1 class="page-banner__title">
                    <!--Welcome To Our Blog-->
                    <?php
                    
                    the_archive_title(); 
                    
                    // Pre-2014 before WP released function the_archive_title()
                        // if(is_category()){
                        //     // echo "category name will go here.";
                        //     single_cat_title(); 
                        // }
                        
                        // if(is_author()){
                        //     // echo "author name will go here";
                        //     echo "Posts By "; the_author(); 
                        // }
                        
                        
                    ?>
                </h1>
                
                
                <div class="page-banner__intro">
                  <!--<p>Keep Up With Our Blog.</p>-->
                  <p><?php the_archive_description(); ?></p>
                </div>
              </div>
            </div>


            <div class="container container--narrow page-section">
                
                <?php
                
                    while(have_posts()){
                        
                        the_post(); ?>
                        
                        <div class="post-item">
                            
                            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                            
                                <div class="metabox">
                                    <p>Posted by: <?php the_author_posts_link(); ?> on <?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?> in <?php echo get_the_category_list(', '); ?></p>
                                                                                                                                                      <?php // get_the_category(); ?>
                                </div>
                                
                                <div class="generic-content">
                                    <?php the_excerpt(); ?>
                                    <a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a>
                                </div>
                            
                        </div>
                        
                        
                        
                    <?php }  
                    
                        // Add Pagination Links: 
                        echo paginate_links(); 
                    
                    
                    ?>
                
                
                
                
            </div>


<?php get_footer(); ?>