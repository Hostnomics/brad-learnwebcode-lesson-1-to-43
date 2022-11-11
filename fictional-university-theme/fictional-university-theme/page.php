<?php

get_header(); 

    while(have_posts()){
        the_post(); ?>
          
        
        <?php pageBanner(); ?> 
    <!-- 
 REMOVED IN LESSON 44 to replace WITH FUNCTIONS PHP PAGE BANNER FUNCTION (REUSABLE CODE): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7576170#overview
        <div class="page-banner">
            <div class="page-banner">
              <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
              <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php //the_title(); ?></h1>
                <div class="page-banner__intro">
                  <p>CHANGE LATER - <?php //bloginfo('description'); ?></p>
                </div>
              </div>
            </div>
    -->    
    
    
    
            <div class="container container--narrow page-section">
                
           <?php 
            
            //Bulk of page.php parent-child relationship from: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7153988#notes
            
                $theParent = wp_get_post_parent_id(get_the_ID());
            
            // IF no parent id, evaluates to zero which is FALSE!
                // if (wp_get_post_parent_id(get_the_ID())){ 
                if ($theParent){                                            ?>

                  <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                      <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                  </div>
                  
          <?php  }; ?>
        
 
 
    <?php 
        // Don't show the side bar links of the Page is a stand alone, has not children / parent
            // Check if Child with the $theParent trick
            // Work Around to see if Parent --> get_pages(); 
                    // get_pages() is VERY similar to wp_list_pages() - Only difference, wp_list_pages handles OUTPUTTING the pages to the screen 
                    // whereas get_pages() just returns the pages in memory. 
            $testArray = get_pages(array(
                 'child_of' => get_the_ID() // ID of current page. If it has children,   get_pages returns collection of children. Otherwise NULL/false/zero.    
            )); 
        
        if ($theParent or $testArray ) { ?>
    
 <!--************************* PAGE LINKS DIV SECTION START *************************************************** -->
              <div class="page-links">
                                                            <!--WP get_the_title INTERPRETS ZERO (Parent Page) AS THE CURRENT PAGE!-->
                    <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
                            <ul class="min-list">
                                
                                        <?php
                                    
                                                    // wp_list_pages takes an Associative Array        
                                                                // $animalSounds = array(  'cat' => 'meow', 
                                                                //                         'dog' => 'bark', 
                                                                //                         'pig' => 'oink'
                                                                //                     ); 
                                                                // echo $animalSounds['dog']; 
                                            
                                            // Previously set up  $theParent = wp_get_post_parent_id(get_the_ID());
                                                // $theParent will equal the ID of the current pages' Parent page
                                                    //  OR if the current page IS a parent, it will just equal zero. (false and not execute the if condition)
                                            
                                            if ($theParent){ // Only if the current page is a child page (has a parent)
                                                $findChildrenOf = $theParent; 
                                            }else{
                                                $findChildrenOf = get_the_ID(); 
                                            }
                                            
                                            
                                            wp_list_pages(array(
                                                // Parameter to tell WP not to print 'Pages'
                                                'title_li' => NULL, 
                                                'child_of' => $findChildrenOf,
                                                'sort_column' => 'menu_order'
                                                //
                                                
                                                
                                            )); 
                                        ?>
                                        
                                        
                                      <!--<li class="current_page_item"><a href="#">Our History</a></li>-->
                                      <!--<li><a href="#">Our Goals</a></li>-->
                              
                            </ul>
              </div>
        <?php } ?>
 <!--************************* PAGE LINKS DIV SECTION END *************************************************** -->        
        
        
              <div class="generic-content">
                <?php the_content(); ?>
              </div>
            </div>
        
    <?php }

get_footer(); 

?>   