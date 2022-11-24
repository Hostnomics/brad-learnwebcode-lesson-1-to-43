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
     
            
        $professors = new WP_Query(array(       // L72 @ 5:20 - create a new instance of the WP Query class
                'post_type' => 'professor',
            // 's' => 'Barksalot'                   // L73 @ 1:32 NEW Arg 's'; Arguments we've used in the past - posts_per_page, meta_query, order_by
            // 's' => $data;  <----- if you use a ';' semi-colon, it throws a parsking error. Only use comma ',' until final item in an array! L73 @ 6th min
            // 's' => $data['term']                    // L73 @ 4:50 - term=barksalot is what we are hardcoding to our custom URL: /university/v1/search?term=barksalot
            's' => sanitize_text_field($data['term'])                // L73 @ 7:20 - sanitize user input with WP built in function sanitize_text_field()
        )); 
    
        
        $professorResults = array(); 
    
      
        while($professors->have_posts()){   // While our WP_Query object ($professors) has posts  
            $professors->the_post();        // load the post object for each one? In lesson 72, 5:30 - 6th min
                
            array_push($professorResults, array(    // array_push($professorResults, 'hello');
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
            
            
        }
        
        return $professorResults;
       
    } 










