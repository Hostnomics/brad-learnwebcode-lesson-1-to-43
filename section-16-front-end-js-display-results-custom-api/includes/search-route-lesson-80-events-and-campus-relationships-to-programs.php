<?php 

    add_action('rest_api_init', 'universityRegisterSearch');


    function universityRegisterSearch(){
        // LESSON 71 (10:56) - register rest route takes 3 arguments:
        
                register_rest_route('university/v1', 'search', array(   // 1 - namespace, 2 - route name, 3 - array options

                    'methods' => WP_REST_SERVER::READABLE,      // The PROPER way to set a GET route in WP is WP_REST_SERVER::READABLE // 'methods' => GET, 
            
            // Set the custom function to run when WP returns relevant data L73 @ (3:45)        
                    'callback' => 'universitySearchResults'     // L 73 @ (3:45) - When WP runs this callback function, it passes along a bit of data about the current request being sent
                                                                // We can access that data included in the callback by simply adding a parameter name in our custom function universitySearchResults
                
        ));
               
   
    }



    function universitySearchResults($data){    // L73 @ 4:05 - Add $data parameter (name not matter), to catch the extra data WP sends about the callback this function receives
                                                // $data is an array that WP puts together and within this array we can access any parameter someone adds on to our custom URL
     
            
                                                // $professors = new WP_Query(array(       // L72 @ 5:20 - create a new instance of the WP Query class  // L72 @ 5:20 - create a new instance of the WP Query class
        $mainQuery = new WP_Query(array(        // L74 @ 3:35 - rename WP_Query object    
            
            // 'post_type' => 'professor',
            'post_type' => array('post', 'page', 'professor', 'program', 'event', 'campus'),
            
            // 's' => 'Barksalot'                   // L73 @ 1:32 NEW Arg 's'; Arguments we've used in the past - posts_per_page, meta_query, order_by
            // 's' => $data;  <----- if you use a ';' semi-colon, it throws a parsking error. Only use comma ',' until final item in an array! L73 @ 6th min
            // 's' => $data['term']                    // L73 @ 4:50 - term=barksalot is what we are hardcoding to our custom URL: /university/v1/search?term=barksalot
            's' => sanitize_text_field($data['term'])                // L73 @ 7:20 - sanitize user input with WP built in function sanitize_text_field()
       
        )); 
    
                                            //unused now - L74 @ 4:12    
                                                $professorResults = array(); 
                                                
                                                $programResults = array();
                                                $eventResults = array();
    
        $results = array(               // L74 @ (4:12) - Rename empty array we use from $professorsResults to just $results
            'generalInfo' => array(),   // blog post or page
            'professors' => array(),    // professor
            'programs' => array(),
            'events' => array(),
            'campuses' => array()
        );
        
                                            // while($professors->have_posts()){   // While our WP_Query object ($professors) has posts   // While our WP_Query object ($professors) has posts
        while($mainQuery->have_posts()){   
                                            // $professors->the_post();     // load the post object for each one? In lesson 72, 5:30 - 6th min
            $mainQuery->the_post();        
 
 
            // if(get_post_type() == 'post' || 'page'){            // L 74 @ 7:41: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7909630#overview
            if(get_post_type() == 'post'OR get_post_type() == 'page'){    
                array_push($results['generalInfo'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'authorName' => get_the_author()
                ));
            }
            
            if(get_post_type() == 'professor'){    
                array_push($results['professors'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            }   
            
            if(get_post_type() == 'program'){  
                                                                    // Set up related Campuses in Lesson 54 (9:05)
                $relatedCampuses = get_field('related_campus');     // L80 @ 9:21 : https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007368#overview
                
                    if($relatedCampuses){       //As long as variable not empty, this evaluates to true.
                        foreach($relatedCampuses as $campus) {
                            array_push($results['campuses'], array(
                                // 'title' => get_the_title(),             // L80 (12:54) - **SCOPE ISSUE** GETTING TITLE OF ie 'MATH' PROGRAM, and NOT the CAMPUS CPT Title. 
                                // 'permalink' => get_the_permalink()
                     
                                'title' => get_the_title($campus),             // L80 (13:26) - to fix this, pass $campus variable to get_the_title() and get_the_permalink()
                                'permalink' => get_the_permalink($campus)
                            ));
                        }
                    }
                
                
                array_push($results['programs'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'id' => get_the_id()            // L79 @ 2:38 added dynamic ID for Programs: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007366#overview
                ));
            } 
        
            
            if(get_post_type() == 'event'){   
                
                $eventDate = new DateTime(get_field('event_date')); 
                $formatted_month = $eventDate->format('M'); 
                $formatted_day = $eventDate->format('d');
                
                $display_excerpt = null; //L76 @ 7:45 - set excerpt to null in case event has no excerpt OR content and it throws an error
                if(has_excerpt()){
                   $display_excerpt = get_the_excerpt();  
                }else{
                    $display_excerpt = wp_trim_words(get_the_content(), 18);
                }
                
                array_push($results['events'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'month' => $formatted_month,
                    'day' => $formatted_day,
                    'excerpt' => $display_excerpt
                ));
            } 
            
            
            if(get_post_type() == 'campus'){    
                array_push($results['campuses'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type()
                ));
            } 
                        
            
        
            
        } // end of while loop
        
        
    
        if($results['programs']){                                           //L79 @ 12:31 - If programs EXISTS / MATCH the search
                        $programsMetaQuery = array('relation' => 'OR');     // L79 @ 11:39 -Solution returns ALL Professors if no match found, empty professors[], ex jibberish search.
                        
                        foreach($results['programs'] as $item){
                            array_push($programsMetaQuery, array( 
                                        'key' => 'related_programs',    
                                        'compare' => 'LIKE',            
                                        // 'value' => '"' . $results['programs'][$counter]['id'] . '"'      // 
                                        
                                        'value' => '"' . $item['id'] . '"'  // Lesson 79 @ 10:30
                                    )
                            ); 
                        }
                    
            
                
                    $programRelationshipQuery = new WP_Query(array(
                        'post_type' => array('professor','event'),
                        'meta_query' => $programsMetaQuery
                    ));
                            
            
            // $programsMetaQuery will return all Professor Custom Post Types if NO search term is found (empty array "professors[]")
            // It would be same as just creating a query for ALL professors: Lesson 79 @ 12:10
                    // $programRelationshipQuery = new WP_Query(array(
                    //     'post_type' => 'professor',  
                    // ));
                            
            
                    while($programRelationshipQuery->have_posts()){
                        $programRelationshipQuery->the_post(); 
                        
                        if(get_post_type() == 'professor'){    
                            array_push($results['professors'], array(         
                                'title' => get_the_title(),
                                'permalink' => get_the_permalink(),
                                'type' => get_post_type(),
                                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                            ));
                        }

//*******************************************************************************************************************                        
                        if(get_post_type() == 'event'){                                 // L80 @ 2nd minute added check for event
                                $eventDate = new DateTime(get_field('event_date')); 
                                $formatted_month = $eventDate->format('M'); 
                                $formatted_day = $eventDate->format('d');
                                
                                $display_excerpt = null; //L76 @ 7:45 - set excerpt to null in case event has no excerpt OR content and it throws an error
                                if(has_excerpt()){
                                   $display_excerpt = get_the_excerpt();  
                                }else{
                                    $display_excerpt = wp_trim_words(get_the_content(), 18);
                                }
                                
                                array_push($results['events'], array(         
                                    'title' => get_the_title(),
                                    'permalink' => get_the_permalink(),
                                    'type' => get_post_type(),
                                    'month' => $formatted_month,
                                    'day' => $formatted_day,
                                    'excerpt' => $display_excerpt
                                ));
                        }
//*********************************************************************************************************                        
                    }
                    
                                                                                                                // LESSON 78 @   14:10 - USE array_unique() TO REMOVE DUPLICATE PROFESSOR RESULTS
                                                                                                                // LESSON 78 @ 14:15: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7956672#overview
                    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));  // L78 @ 15th minute array_values() removes the numerical index from JSON results [0], [2]

                    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    
        } //END OF LESSON 79 @ (12:41) IF SATEMENT CHECKING THAT $results['programs'] IS NOT AN EMPTY ARRAY aka EXISTS.
    
    return $results;

       
    } // end of function universitySearchResults







