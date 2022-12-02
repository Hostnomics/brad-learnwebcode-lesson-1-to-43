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
        add_action('admin_init', array($this, 'settings'));   //L118 @ 3:26 
    }
    
    function settings(){
        add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');        //L 118 at (11:22)
        // add_settings_section(1, 2, 3, 4); 
            // 1 - Name of the section we named/referenced in the 5th parameter of add_settings_field() below
            // 2 - Subtitle for the section, here subtitle on each input field. If none, set as null. 
            // 3 - generic description area, paragrpah, html. If none, set as null
            // 4 - Reference the GET URL we set up originally in add_options_page() in our adminPage() function below
        
        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section'); //L118 @ 8:27 - html for our field
        // add_settings_field(1, 2, 3, 4, 5); 
        // 1- Name of option or setting we want to set this to, So first one, wcp_location
        // 2 - Display name for end-user
        // 3 - Your Custom Function which is Responsible for displaying the actual HTML.
        // 4 - page slug for this GET URL we created for our Plugins Settings Page. We choose word-count-settings-page
        // 5 - The section you want to add this field to. We will create section later in episode 118
        
        
        register_settings('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0')); 
            // register_settings(1, 2, 3);  (group nam, field name, )
            // 1 - GROUP NAME -name of group this setting belongs to. (5:15)
            // 2 - Field Name
            // 3 - Array 
                // (3a) sanitize callback, how we want to sanitize the value, 
                // (3b) default value if none given
    }
    
    
    function locationHTML(){        // L 118 @ (13:13) ?>
      Testing
      
<?php } 
    
    
    
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


// ************** ORIGINAL adminPage and ourHTML functions; 

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









