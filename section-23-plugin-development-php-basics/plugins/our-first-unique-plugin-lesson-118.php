<?php

/*
    Plugin Name: Our Test Plugin
    Description: Word Counter Tutorial Plugin
    Version: 1.0
    Author: Ian
    Author URI: https://www.hostnomics.com 
*/



//LESSON 16 - EXAMPLE FILTER, ERASED IN Lesson 17.
// add_filter('the_content', 'addToEndOfPost');      //Lesson 116 (5:38): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880720#overview

                                            // is_single works for any POST TYPE
                                            // To target a PAGE and not a POST you would use is_page() - defaults to false on POST.

// function addToEndOfPost($content) {         // L 116 (5:21) - Use UNIQUE Function names that don't conflict with other plugins or core of WP itself
//     if(is_single() && is_main_query()){     //L 116 (8:30) - a template might load or loop through other secondary posts. we only want the MAIN QUERY for this URL.
//         return $content . '<p>My Name is Ian.</p>'; //L116 @ (8:16) - RETURN exits the IF LOOP, would not reach elseif / else
//     }
//     return $content;    //L 116 @ (8:48) - IF OUR if condition is NOT met, return $content without manipulating it.
// }


class WordCountAndTimePlugin {      //L 117 @ 8:30 create class
    function __construct() {
        // INCLUDE TOP LEVEL ACTIONS OR FILTERS WE'RE GOING TO USE IN THIS CONSTRUCTOR L117 @ (10:30)
            // add_action('admin_menu', 'ourPluginSettingsLink');  //LESSON 17 - Now we'll use an ACTION HOOK to add a link to the SETTINGS tab in WP ADMIN
        add_action('admin_menu', array($this, 'adminPage'));  //LESSON 17 - 11:40 - We have to reference new adminPage function with an array
    }
    
    function adminPage(){
        // function ourPluginSettingsLink(){
        add_options_page("Word Count Settings", 'Word Counter', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));
            // 1 - Name to appear in Tab
            // 2 - Name to appear in Settings Tab pop-up menu
            // 3 - Name the permission required. User role required to see this page (Admin, Editors, etc.)
            // 4 - Name of GET route URL for our Plugin's settings view
            // 5 - function we give it to output the HTML content on our Admin Settings Page
    }
    
    function ourHTML(){ ?>  <!--L117 (6:34) Instead of return statement swwitch to HTML and display page as desired -->
        
        <!-- Lesson 117 (13:54) Actual HTML and class styings we can use in WordPress -->
        <div class="wrap">
            <h1>Word Count Settings</h1>
        </div>
        
    <?php }    
    
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();       //L 117 @ 9:15 create new instance of our class and set to variable





function ourPluginSettingsLink(){
    add_options_page("Word Count Settings", 'Word Counter', 'manage_options', 'word-count-settings-page', ourSettingsPageHTML);
        // 1 - Name to appear in Tab
        // 2 - Name to appear in Settings Tab pop-up menu
        // 3 - Name the permission required. User role required to see this page (Admin, Editors, etc.)
        // 4 - Name of GET route URL for our Plugin's settings view
        // 5 - function we give it to output the HTML content on our Admin Settings Page
}

function ourSettingsPageHTML(){ ?>  <!--L117 (6:34) Instead of return statement swwitch to HTML and display page as desired -->
    
    <h2>Hello World From Our New Plugin</h2>
    
    
<?php }






