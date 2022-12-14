# Section 23: Plugin Development: PHP

## Overview of Plugin Developmet covered in Sections 23, 24 and 25 

### Lesson 115: Introduction to Plugin Development

Display the results from our new CUSTOM API in section 15.


[Lesson 115 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880712#overview).


## Plugin Dev: Three Sections
23- PHP (actions, filters, admin settings, pages & menus)
24- JavaScript (Gutenberg Block Types, React)
25- Database (Custom Post Type vs Our Own DB Table)


The plugin we'll create counts the words and total characters in a post. From that it will estimate about how long it would take to read the post. 


-The ADMIN panel of our Plugin will allow a user to select the location of the Word Counter Plugin (Top or Bottom of post) with a drop down menu.  

-The user can set the title which is displayed above the Word Counter Details on EACH post via a text box. 

-Finally the user can select which features to include or exclude with a checkbox. 
(Three features include Total Words, Total Characters and Estimated Read Time)



## Lesson 116: Setting Up Our First Plugin

Display the results from our new CUSTOM API in section 15.


[Lesson 116 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880720#overview).


**Navigate to wp-content/plugins** and create a new folder for our plugin (1:20)

Give it a Unique plugin directory name _(avoid conflict with others)_ since we are manually adding a plugin in our back end. 

**In reality, WP verifies that your plugin is unique to avoid confict I think**


We'll call ours **our-first-unique-plugin** 

Inside our plugin directory we created a php file of the same name. 

**REQUIRED COMMENT AT TOP**

Must have 'Plugin Name'

**WordPress is looking for attribute _Plugin Name_**

```
<?php

/*
    Plugin Name: Our Test Plugin


*/

```

Common attributes included as well: (We'll add more later)


```
<?php

/*
    Plugin Name: Our Test Plugin
    Description: Word Counter Tutorial Plugin
    Version: 1.0
    Author: Ian
    Author URI: https://www.hostnomics.com 

*/

```


First thing we'll build is a dynamic (user sets) string that gets added to the end of a single post

Use **add_filter('the_content', ourCustomFunction)** 

```
<?php

/*
    Plugin Name: Our Test Plugin
    Description: Word Counter Tutorial Plugin
    Version: 1.0
    Author: Ian
    Author URI: https://www.hostnomics.com 

*/

add_filter('the_content', 'addToEndOfPost');

function addToEndOfPost($content){
    if(is_single() && is_main_query()){                 //Use is_page() for page NOT post.
        return $content  . '<p>Test Text Here.</p>';
    }

    return $content;  //Don't forget return $content if the conditional is not met.
}


```

At its essence, that's all a plugin is. 
Your leveraging the different **action hooks** and **filter hooks** that WP makes available to us. 



## Lesson 117: Settings Page For Our Plugin

Start laying out the template for our Word Counter plugin.

WP Plugin + Settings

[Lesson 117 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880724#overview).


First, Add a Link to our Plugin in the WP-Admin Settings Tab


```
add_action('admin_menu', 'ourPluginSettingsLink');

function ourPluginSettingsLink(){
    add_options_page("Word Count Settings", 'Word Counter', 'manage_options', 'word-count-settings-page', ourSettingsPageHTML);

    // add_options_page(1, 2, 3, 4, 5) takes five arguments. 
        // 1 - Name to appear in Tab
        // 2 - Name to appear in Settings Tab pop-up menu
        // 3 - Name the permission required. User role required to see this page (Admin, Editors, etc.)
        // 4 - Name of GET route URL for our Plugin's settings view
        // 5 - function we give it to output the HTML content on our Admin Settings Page
}

function ourSettingsPageHTML(){ ?>  <!--L117 (6:34) Instead of return statement swwitch to HTML and display page as desired -->
    
    <h2>Hello World From Our New Plugin</h2>
    
    
<?php }

```

L 117 @ ~(8:30) Set up a PHP Class to handle the issue of conflicting function names with other WP functions


Classes don't have the parenthesis ()
When we call our class it will automatically run the **__construct()** function. (10:23)

To avoid conflict with other Core WP or plugins your customer may have installed, we can place our functios
in the class and then call a new instance of ocur class. 
```

class WordCountAndTimePluigin {
    function __construct() {
        add_action('admin_menu', 'ourPluginSettingsLink');
    }

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

}


$wordCountAndTimePlugin = new WordCountAndTimePlugin();       //L 117 @ 9:15 create new instance of our class 

```


LESSON 17 - 11:40 - We have to reference new adminPage function with an array
We need to use the callable syntax in PHP, so the second argument in our add_action() hook will become an array. (11:54).


The first argument is an object, and we here we want to point to the current instance of this class
so we use **$this** just like in javascript.

```
add_action('admin_menu', array($this, 'adminPage'));  //LESSON 17 - 11:40 - We have to reference new adminPage function with an array

add_options_page("Word Count Settings", 'Word Counter', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));

```




## Lesson 118: Settings API (Saving Settings Data)

Save the settings from user submitted form data (drop down, text field and checkboxes)


[Lesson 118 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880730#overview).


L118 @ (1:24) we looked at the wp_options table for our WP DB. 

(3rd min) - We cover how to run a DB Migration to add fields in the **wp_options** table for our plugin


To be efficient, we'll say that a value of 0 is display at top of post, value of 1 displays at end. 

To run a migration and add the fields our plugin needs to the wp_options table, use an 
**add_action hook** with value of **admin_init** and in the corresponding function use 
**register_setting** with the options shown below to set up the field information: 

```
class WordCountAndTimePlugin {      //L 117 @ 8:30 create class
    function __construct() {
        // INCLUDE TOP LEVEL ACTIONS OR FILTERS WE'RE GOING TO USE IN THIS CONSTRUCTOR L117 @ (10:30)
            // add_action('admin_menu', 'ourPluginSettingsLink');  //LESSON 17 - Now we'll use an ACTION HOOK to add a link to the SETTINGS tab in WP ADMIN
        add_action('admin_menu', array($this, 'adminPage'));  //LESSON 17 - 11:40 - We have to reference new adminPage function with an array
        add_action('admin_init', array($this, 'settings'));   //L118 @ 3:26 
    }
    
    function settings(){
        register_settings('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0')); 
            // register_settings(1, 2, 3);  (group nam, field name, )
            // 1 - GROUP NAME -name of group this setting belongs to. (5:15)
            // 2 - Field Name
            // 3 - Array 
                // (3a) sanitize callback, how we want to sanitize the value, 
                // (3b) default value if none given
    }

}
```


Updated solution after [Lesson 118](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880730#overview).

```
class WordCountAndTimePlugin {
  function __construct() {
    add_action('admin_menu', array($this, 'adminPage'));
    add_action('admin_init', array($this, 'settings'));
  }

  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
  }

  function locationHTML() { ?>
    <select name="wcp_location">                                <!-- L118 @ (16:32) Field Name Created in register_settings -->
      <option value="0">Beginning of post</option>
      <option value="1">End of post</option>
    </select>
  <?php }

  function adminPage() {
    add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));
  }

  function ourHTML() { ?>
    <div class="wrap">
      <h1>Word Count Settings</h1>
      <form action="options.php" method="POST">
      <?php
                    //paramter takes name of the field group we set in register_settings() above in our settings() function.
        settings_fields('wordcountplugin');                     //L118 @ (17:40) - THIS allows you to submit & save the input via our POST route         
        do_settings_sections('word-count-settings-page');       //L118 @ (14:45) 
        submit_button();                                        //L118 @ (15:37)
      ?>
      </form>
    </div>
  <?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
```


## Lesson 119: Finishing Our Settings Form


[Lesson 119 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880730#overview).

We'll show the user the currently selected value from the drop down menu (0:52) in the locationHTML() function. 


We'll compare the value in the database for the field named **wcp_location** to the value assigned to each drop down menu option. 
If it matches, then we will use the built in **selected()** WP function 

**selected() Format**
selected('what you want to compare', 'what to compare it to');

For the first paramater we'll use WP built in function **get_option('field_name_here')** 

So the solution we'll use in our drop down menu is: 

**selected(get_option('wcp_location'), "0")** 

```
  function locationHTML() { ?>
    <select name="wcp_location">                                
      <option value="0" <?php selected(get_option(), "0"); ?>>Beginning of post</option>
      <option value="1" <?php selected(get_option(), "1"); ?>>End of post</option>
    </select>
  <?php }

```



Add text input field
```
  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

//Drop Down    
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

//Text Field L119 @ (4:38)
    add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));   
    
  }
 
```

Then create the HTML for the text input with name 'wcp_headline'. 
We can load the value from the DB with **get_option('field_name')**

```
  function headlineHTML() { ?>
     
      <input type="text" name="wcp_headline" value="<?php echo get_option("wcp_headline") ?>">
  
 <?php }
```

Any time we load information from DB to an input field(?), wrap in esc_attr() which is similar to esc_URL() for 
loading URLs from database. 

```
<input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option("wcp_headline")) ?>">

```


We added a 5th parameter option for our three Check boxes and then used one checkboxHTML() function since all three used
the same logic. (12th - 14th minute) 

```

add_settings_field('wcp_wordcount', 'Word count', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_wordcount')); //L119 (13:17)
register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));   

add_settings_field('wcp_charactercount', 'Character count', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_charactercount')); //L119 (13:17)
register_setting('wordcountplugin', 'wcp_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1')); 

add_settings_field('wcp_readtime', 'Read Time', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_readtime')); //L119 (13:17) - add 5th argument set 'theName' as field name
register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1')); 


//Same checkboxHTML function for all three checkboxes created above:
function checkboxHTML($args){    ?>    
        <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1') ?>>    
<?php }

```


**Final part of lesson 119, we focused on Custom Validation Logic**
(14:00 - 19:58)

In our class' Settings function, we'll improve our santize_callback
```
  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');
    
//Drop Down    
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

//REWRITE TO
  register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));

```

**array('sanitize_callback' => array($this, 'sanitizeLocation')** 


Our custom sanitize function will check the values of our drop down menu. Only desired inputs are 0 or 1. 

use **add_settings_error(1, 2, 3)** function
1 - the name of the option (field) that the error is related to. Here (wcp_location)
2 - A slug or identifier for this particular error. WP adds this as an ID
3 - The error message to display to user

```
    function sanitizeLocation($input) { // when sanitizeLocation is called, WP will pull in the value that WP is trying to save
        if ($input != '0' AND $input != '1'){
           // add_settings_error(1, 2, 3);
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end');
          //Get the previously saved value for wcp_location, which may be default '0'
            return get_option('wcp_location');
        } 
        
        //If input IS either 0 or 1:
            return $input; 
    }

```



## Lesson 120: Actually Counting the Words, Characters and Road Time

[Lesson 120 in Section 23](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880762#overview).

Start filtering posts with our plugin.

In wp-content/plugins/our-first-unique-plugin/our-first-unique-plugin.php

We added a filter to our WordCountAndTimePlugin class' __construct()
**add_filter('the_content', array($this, 'customFunction'));**

```
class WordCountAndTimePlugin {
  function __construct() {
   
    add_filter('the_content', array($this, 'ifWrap'));  //L120 (2:33)
  }

  function ifWrap($content) {
  if ( 
          is_main_query() AND 
          is_single()  AND     //L120 (5:15) - BOTH is main query is single post
          (
              get_option('wcp_wordcount', '1') OR       // and ONE of our plugin checkboxes is checked.
              get_option('wcp_charactercount', '1') OR 
              get_option('wcp_readtime', '1')
          ) 
        ) 
    {
        return $this->createHTML($content);
    }
  
    return $content; 
  } //end of ifWrap


  function createHTML($content) {      
      // return $content . ' hello'; //L120 (9:00) - testing: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880762#overview
  
  //create var we can add on to as we go L120 (10:20)
      $html = '<h3>' . get_option('wcp_headline', 'Post Statistics From createHTML') . '</h3><p>';
      
  // Set Word Count to variable L120 (13:24) - both wordcount and readtime will need it. 
      
      
      if (get_option('wcp_location', '0') == '0') {
          return $html . $content;  
      } 
      // else { - L120 - 12:28 - did not use else statment
          return $content . $html;
      // }
  }

```

L120 @ (13:57) - To get the word count of the post content, we'll use PHP functions

**str_word_count()**

But we'll wrap the_content with **strip_tags()** to remove any html tags so we end up with: 

```
$wordCount = str_word_count(strip_tags($content));

```

## get_option() is SINGULAR - NOT PLURAL

NOT get_option**s**() !!!


To get the total characters we use **strlen()** on content while also wrapping it in strip_tags()

```
    if (get_option('wcp_charactercount', '1')){
        $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
    } 

```

So the final solution was: 

```
<?php

class WordCountAndTimePlugin {
  function __construct() {
    add_action('admin_menu', array($this, 'adminPage'));
    add_action('admin_init', array($this, 'settings'));
    
    add_filter('the_content', array($this, 'ifWrap'));  //L120 (2:33)
  }
  
  
    function ifWrap($content) {
        if ( 
              is_main_query() AND 
              is_single()  AND     //L120 (5:15) - BOTH is main query is single post
              (
                  get_option('wcp_wordcount', '1') OR       // and ONE of our plugin checkboxes is checked.
                  get_option('wcp_charactercount', '1') OR 
                  get_option('wcp_readtime', '1')
              ) 
            ) 
        {
            return $this->createHTML($content);
        }
      
      return $content; 
    } //end of ifWrap
  

 
    function createHTML($content) {
        
        // return $content . ' hello'; //L120 (9:00) - testing: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880762#overview
    
    //create var we can add on to as we go L120 (10:20)
        $html = '<h3>' . get_option('wcp_headline', 'Post Statistics From createHTML') . '</h3><p>';
    
/* GET_OPTION IS SINGULAR - NOT FING PLURAL!!!
    if (get_options('wcp_wordcount', '1') OR get_options('wcp_readtime', '1')) {         //L120 (14:50) - We only want to count the number of words if Word Count or Read Time boxes are checked      
                                                                                        // Set Word Count to variable L120 (13:24) - both wordcount and readtime will need it.
        $wordCount = str_word_count(strip_tags($content));                              //L120 - 13:57 - passing just $content may include html tags, so use strip_tags($content) to remove them
    }    
*/   

    if (get_option('wcp_wordcount', '1') OR get_option('wcp_readtime', '1')) {
        $wordCount = str_word_count(strip_tags($content));
    }
    
    if (get_option('wcp_wordcount', '1')){
        $html .= 'This post has ' . $wordCount . ' words.<br>';
    }   
    
    
    if (get_option('wcp_charactercount', '1')){
        $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
    } 

        
        if (get_option('wcp_location', '0') == '0') {
            return $html . $content;  
        } 
        // else { - L120 - 12:28 - did not use else statment
            return $content . $html;
        // }
        
    }

```


**Final Pro Tip** when displaying text from our database, always wrap it in **esc_html()**

So in this line here: 
```
$html = '<h3>' . esc_html(get_option('wcp_headline', 'Post Statistics From createHTML')) . '</h3><p>';
```

