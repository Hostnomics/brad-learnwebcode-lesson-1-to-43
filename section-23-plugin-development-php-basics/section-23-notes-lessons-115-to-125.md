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
}


```

