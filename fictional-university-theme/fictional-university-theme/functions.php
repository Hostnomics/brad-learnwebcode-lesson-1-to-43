<?php


// LESSON 44: REUSABLE BLOCK FOR PAGE BANNER
function pageBanner() {
    // php logic will live here
    
    ?>
     <div class="page-banner">
              <div class="page-banner__bg-image" 
                    style="background-image: url(
                        <?php //echo get_theme_file_uri('/images/ocean.jpg'); 
                            // Updated in Lesson 43 at (7:46)
                            $pageBannerImage = get_field('page_banner_background_image'); //This variable is an array. ACF creates an array for us.
                            echo $pageBannerImage['sizes']['pageBanner'];
                        ?>
                    )">
              </div>
              
              <div class="page-banner__content container container--narrow">
  <!--LESSON 43 AT (10:22) - USE print_r() TO INSPECT ANY OBJECT YOU ARE WORKING WITH, ie $pageBannerImage['url']  -->
                 <?php //print_r($pageBannerImage); ?>
                  
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <div class="page-banner__intro">
                  <p><?php the_field('page_banner_subtitle'); ?> <?php //bloginfo('description'); ?></p>
                </div>
              </div>
        </div>
    
    
<?php  }



// add_action('a', 'b'); 
// a = what type of instructions we are giving it. Load file hook name - wp_enqueue_scripts (load scripts/files)
// b = function

function university_files(){
        //load css or js files. For now, load main style.css
        // to load javascript file use university_main_script

    //AT 16:12 FROM: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/27481246#overview 
// Load Javascript files: 5 Arguments:  1-name,    2 location of js file,   3 dependencies, NULL if none, 4- version #, 5- Load at bottom = true, load at top = false     
        wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true); 

// Load external CDN links
        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    // Load LOCAL CSS files in our Build Folder
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    
        
    // By default will look for style.css    
        // wp_enqueue_style('university_main_styles', get_stylesheet_uri()); 
}

add_action('wp_enqueue_scripts', 'university_files'); 



function university_features(){
    // LESSON 20 - REGISTER NAVIGATION MENU - Two Arguments
        // 1 - random name, 2- HUMAN FRIENDLY NAME - This shows up in the Admin Screnn ex Header Menu Location | REMOVED AT END OF LESSON:
    // register_nav_menu('headerMenuLocation', 'Header Menu Location'); 
    
// LESSON 20 DYNAMIC SECOND MENU LOCATION FOR FOOTER - REMOVED AT END OF LESSON:
    // register_nav_menu('footerLocationOne', 'Footer Location One'); 
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
    
    add_theme_support('title-tag');
//Add support for post thumbnails in Lesson 41 (1:57)
    add_theme_support('post-thumbnails'); 
//Add support for images in Lesson 41 (13:43)
    add_image_size('professorLandscape', 400, 260, true); //default is false, no crop. true, wp will crop saving the center of the image
    add_image_size('professorPortrait', 480, 650, true); // Applies to images added AFTER these image sizes added. Won't retroactively apply.  
// Add custom image size for our Custom Field Banner Image in Lesson 43 at (4:33)
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features'); 


// From Lesson 27: Custom Post Types around 4th minute: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7343034#overview
// moved to mu-plugins



// From Lesson 34: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7440942#overview
                        // we want to bring in the wp query object as a parameter
function university_adjust_queries($query){
    //adjust query for custom post type events on archive-events page
        // set method has two arguments
    
// From Lesson 36 Add on with Program custom post type: URL Based Query for new Program Post Type: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7451310#overview    
    if (!is_admin() AND is_post_type_archive('program') AND is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
        
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){    
        // $query->set('posts_per_page', '1'); 
        $query->set('meta_key', 'event_date'); 
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        
        $today = date('Ymd');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date', 
                'compare' => '>=',
                'value' => $today, 
                'type' => 'numeric'
                )
            ));
    }
}

// The name of the WP action we want to hook on to is pre_get_posts
add_action('pre_get_posts', 'university_adjust_queries'); 






















