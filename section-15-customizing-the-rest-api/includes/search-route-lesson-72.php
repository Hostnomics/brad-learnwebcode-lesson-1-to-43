<?php 

    add_action('rest_api_init', 'universityRegisterSearch');


    function universityRegisterSearch(){
            // LESSON 71 (10:56) - register rest route takes 3 arguments                  
                register_rest_route('university/v1', 'search', array(
            // The PROPER way to set a GET route in WP is WP_REST_SERVER::READABLE
                    // 'methods' => GET,                  
                    'methods' => WP_REST_SERVER::READABLE,
                    
            // Reference custom function we create down below
                    'callback' => 'universitySearchResults'
                
        ));
               
   
    }



    function universitySearchResults(){
            // L72 @ 5:20 - create a new instance of the WP Query class
                // ALL of the data for the 10 most recent Professor CUSTOM POST TYPES lives in variable $professors  
        $professors = new WP_Query(array(
            'post_type' => 'professor'
        )); 
            
        // return ENTIRE POSTS property of $professors (this is the data we looped through earlier) (6:37)
                // return $professors->posts; // array of objects.
        
        //(8:14) - Now, we'll return JUST the fields we need on Professor Posts in our REST API
        //set up empty array to collect the fields we need ($professorResults)
        $professorResults = array(); 
            
        // While our WP_Query object ($professors) has posts        
        while($professors->have_posts()){
            $professors->the_post(); 
                // array_push($professorResults, 'hello');
            
            array_push($professorResults, array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));                        
        }
        
        return $professorResults;

    } 

