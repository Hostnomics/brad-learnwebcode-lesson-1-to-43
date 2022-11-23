<?php




// From Lesson 27: Custom Post Types around 4th minute: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7343034#overview

function university_post_types(){
    // WP function register_post_type() takes care of heavy lifting for us. 
        // first parameter is name of post type
        // second argument is an array of options that describe your post type in an associative array

// EVENT POST TYPE        
    register_post_type('event', array(
        
// Lesson 31, minute 2:17: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7356484#overview  
        // 'supports' => array('title', 'editor', 'excerpt'),
        'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
        
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events', 
            'singular_name' => 'Event'
            ),
        'menu_icon' => 'dashicons-calendar' // google for wordpress dashicons
    ));
    
    
// LESSON 36: PROGRAM POST TYPE: (1:22): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7451310#overview
        register_post_type('program', array(
                // He removed excerpt. I don't think we were supposed to include custom-fields in the final version of events
            // 'supports' => array('title', 'editor', 'custom-fields'),
            'supports' => array('title', 'editor'),
            
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs', 
                'singular_name' => 'Program'
                ),
            'menu_icon' => 'dashicons-awards'
    ));


// LESSON 40: REGISTER PROFESSOR Custom Post Type: (1st min): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview
        register_post_type('professor', array(
                // He removed excerpt. I don't think we were supposed to include custom-fields in the final version of events
            // 'supports' => array('title', 'editor', 'custom-fields'),

// LESSON 70 (1:41): ADD CUSTOM REST API ROUTE WITH ONE LINE:
            'show_in_rest' => true,

    // Lesson 41 (2:50) - To add Featured Image support to Custom Post Type Professor, 
    // add 'thumbnail' to the supports array: 
            'supports' => array('title', 'editor', 'thumbnail'),
            
            // 'rewrite' => array('slug' => 'professors'),
            // 'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professor', 
                'singular_name' => 'Professor'
                ),
            'menu_icon' => 'dashicons-welcome-learn-more'
    ));


    
} // End of university_post_type



// Attach on to event hook called init. 
add_action('init', 'university_post_types');