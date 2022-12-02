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


