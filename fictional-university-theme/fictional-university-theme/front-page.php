<?php get_header(); ?>

<?php
    
// echos out result    
    // the_title(); 
    // the_ID(); 

// returns the value.     
    // get_the_title(); 
    // get_the_ID(); 

?>



    <div class="page-banner">
                                                                    <!--USE get_theme_file_uri to get images/library-hero.jpg-->
          <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div>
          <div class="page-banner__content container t-center c-white">
            <h1 class="headline headline--large">Welcome!</h1>
            <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
            <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
            <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
          </div>
    </div>


    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events (Limit 2)</h2>
          
            <?php
// Start of: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356480#overview
        $today = date('Ymd');
                $homepageEvents = new WP_Query(array(
                    // 'posts_per_page' => 2,
                    
// Order By in Lesson 33 minute 1:30: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7399554#notes
                    // 'orderby' => 'post_date' // DEFAULT
                    // 'orderby' => 'title',
    
                    'post_type' => 'event',
                //End of Lesson 31 he wants us to limit 2: 
                    'posts_per_page' => 2,
                    // 'posts_per_page' => -1, // means give us everything that meets our query
                    'order' => 'ASC', // default is DESC - (usually date)  // 'order' => 'rand'
        
        //Minute 6:58 Lesson 33 - using meta            
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date', 
                            'compare' => '>=',
                            'value' => $today, 
                            'type' => 'numeric'
                        )
                    )
                    
                    // 'orderby' => 'post_date',
                    
                )); 
                
                while($homepageEvents->have_posts()){
                    // gets the data ready for each post, each time the code repeats itself
                        $homepageEvents->the_post(); ?>
                
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
                            
                      
                    <?php } //wp_reset_postdata();
                    
                ?>
                    

          
          
          <!--<div class="event-summary">-->
          <!--  <a class="event-summary__date t-center" href="#">-->
          <!--    <span class="event-summary__month">Apr</span>-->
          <!--    <span class="event-summary__day">02</span>-->
          <!--  </a>-->
          <!--  <div class="event-summary__content">-->
          <!--    <h5 class="event-summary__title headline headline--tiny"><a href="#">Quad Picnic Party</a></h5>-->
          <!--    <p>Live music, a taco truck and more can found in our third annual quad picnic day. <a href="#" class="nu gray">Learn more</a></p>-->
          <!--  </div>-->
          <!--</div>-->

          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blog</h2>
          
            <?php 
            
                // $homepagePosts = new WP_Query(); // new instance of the WP Query class (blueprint / recipe). $homepagePosts is an object.
                    // $dog = new Animal(); 
                    //     $dog->drinkWater();
                    // $cat = new Animal();
                 
                            // Takes array of arguments
                 $homepagePosts = new WP_Query(array(
                            //  'post_type' => 'page',
                            //  'category_name' => 'awards'
                     'posts_per_page' => 2,
    
                     ));
                
                                    // have_posts and the_post are tied to the default automatic query that WP makes on its own, which is tied to the url (here home page)
                                        // while(have_posts()){
                while($homepagePosts->have_posts()){
                                        //the_post(); // gets all of the appropriate data ready 
                    $homepagePosts->the_post(); ?>
                                
                                <div class="event-summary">
                                    <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
                                      <span class="event-summary__month"><?php the_time('M'); ?></span>
                                      <span class="event-summary__day"><?php the_time('d'); ?></span>
                                    </a>
                                    <div class="event-summary__content">
                                      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h5>
                                      
                                          <p>
                                              <?php //the_excerpt(); 
                                              // wp_trim_words from 17:54 of https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7291138#notes
                                              // wp_trim_words takes two args (1) identify content (2) limiter in number of characters
                                              ?> 
                                              <?php //echo wp_trim_words(get_the_content(), '18'); ?>
                                              
                                              <?php // Excerpt below from Lesson 30: (2:20: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356482#overview ?>
                                              
                                              <?php // the_excerpt(); ?>
                                              
                                              <?php // the_excerpt(); 
                                                if(has_excerpt()){
                                                    // the_excerpt(); 
                                                   echo get_the_excerpt();  
                                                }else{
                                                    echo wp_trim_words(get_the_content(), 18);
                                                }
                                              ?>
                                          
                                              <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
                                          </p>
                                      
                                    </div>
                                </div>
                    
                    <!--RUN wp_reset_postdata() after you run through the wp posts-->
            <?php    } wp_reset_postdata();  // Good habit, better if it's up towards the top of the template. 
            
            ?>
          
          
            <!--<div class="event-summary">-->
                
            <!--</div>-->
          
          
                <!--USE DIV CLASS EVENT-SUMMARY -->
                          <!--<div class="event-summary">-->
                          <!--  <a class="event-summary__date event-summary__date--beige t-center" href="#">-->
                          <!--    <span class="event-summary__month">Jan</span>-->
                          <!--    <span class="event-summary__day">20</span>-->
                          <!--  </a>-->
                          <!--  <div class="event-summary__content">-->
                          <!--    <h5 class="event-summary__title headline headline--tiny"><a href="#">We Were Voted Best School</a></h5>-->
                          <!--    <p>For the 100th year in a row we are voted #1. <a href="#" class="nu gray">Read more</a></p>-->
                          <!--  </div>-->
                          <!--</div>-->
                      
                      
                          <!--<div class="event-summary">-->
                          <!--  <a class="event-summary__date event-summary__date--beige t-center" href="#">-->
                          <!--    <span class="event-summary__month">Feb</span>-->
                          <!--    <span class="event-summary__day">04</span>-->
                          <!--  </a>-->
                          <!--  <div class="event-summary__content">-->
                          <!--    <h5 class="event-summary__title headline headline--tiny"><a href="#">Professors in the National Spotlight</a></h5>-->
                          <!--    <p>Two of our professors have been in national news lately. <a href="#" class="nu gray">Read more</a></p>-->
                          <!--  </div>-->
                          <!--</div>-->

                                                                  <!--/category/awards/-->
          <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View Our Blog</a></p>
          
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
                                                                    
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg'); ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
                                                                
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg'); ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
                                                            
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg'); ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>



<?php get_footer(); ?>

    
    
    
    
    