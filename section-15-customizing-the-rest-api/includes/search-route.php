<?php 

    add_action('rest_api_init', 'universityRegisterSearch');


    function universityRegisterSearch(){
            // LESSON 71 (10:56) - register rest route takes 3 arguments
                // register_rest_route(a, b, c); 
                    // a - URL namespace - default wp-json/wp
                        // don't use /wp - that is core wp
                        // be unique to avoid conflicts with plugins
                        // creating a namespace with a STANDARD format but updating the version number, like wp/v1, wp/v2 etc makes it easier to update when others using your API
                        
                    // b - route - in this case professor is the ending part of the URL
                    
                    // c - array() that describes what should happen when someone visits our namespace + URL
                    
                register_rest_route('university/v1', 'search', array(
            // Load data so, GET request  
            // However, the PROPER way to set a GET route in WP is WP_REST_SERVER::READABLE
                    // 'methods' => GET, 
                 
                    'methods' => WP_REST_SERVER::READABLE,
                    
            // Reference custom function we create down below
                    'callback' => 'universitySearchResults'
                
        ));
               
   
    }



    function universitySearchResults(){
        return 'Congrats, you created a route';
    } 

