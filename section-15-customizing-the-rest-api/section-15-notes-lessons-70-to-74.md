# Section 15: Customizing the REST API

## Customizing the WP Rest API

### Lesson 70: Add New Custom Field
### Add new properties to the raw JSON that WP sends back to us
Being able to customize the JSON data sent back to us, opens up all kinds of possibilites. 

[Section 15 Lesson 70](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837914#overview).

In functions.php, hook on to the rest_api_init add action and in the corresponding function, use register_rest_field. 

![functions.php](https://i.imgur.com/BVGBuGt.png)

```
<?php
    function university_custom_rest() {
           register_rest_field('post', 'authorNamePost', array(
                'get_callback' => function() {return get_the_author();}
           ));
    }

    add_action('rest_api_init', 'university_custom_rest');
?>
```

Then in our jQuery getResults() function, use a ternary operator to only display author if post type = post
```
<script>
    getResults() {

    $.when(
    wp-json-error-test/wp/v2/posts?search=` + this.searchField.val()), 
        $.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=` + this.searchField.val()),
        $.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=` + this.searchField.val())

        ).then((posts, pages) => { 

         var combinedResults = posts[0].concat(pages[0]);
                
                this.resultsDiv.html(`
                        <h2 class="search-overlay__section-title">Search Results</h2>
                    ${combinedResults.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                                ${combinedResults.map(item => `<li><a href="${item.link}" target="_blank">${item.title.rendered}</a> ${item.type == 'post' ? `by ${item.authorNamePost}` : ''}</li>`).join('')}
                    ${combinedResults.length ? '</ul>' : ''}             
                `);
                    this.isSpinnerVisible = false;    
                }, () => {
                    this.resultsDiv.html('<b>Unexpected Error; Please Try Again.</b>');
                });
              
          }    
</script>

```


### Lesson 71: Add New Custom Route (URL)
### Add new properties to the raw JSON that WP sends back to us
Instead of customizing a default WP route, we are now creating a NEW custom REST API URL.
This allows us to be in 100% control of the JSON data sent back. 

Default: **wp-json/wp/v2/posts**
Others: wp-json/wp/v2/pages 
        wp-json/wp/v2/media
        wp-json/wp/v2/users


Custom: **wp-json/university/v1/search**

Custom Post Type: **wp-json/university/v1/professor**
By default, Custom Post Types are not provided in the REST API. 

[Section 15 Lesson 71](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837916#overview).


In mu-plugins: wp-content/mu-plugins/university-post-types.php

To make a custom route for a Custom Post Type, add a property within the Custom Post Type’s associative array in MU Plugins / university-post-types.php.

[LESSON 40: REGISTER PROFESSOR Custom Post Type: (1st min)](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7484308#overview).

[LESSON 71: ADD PROPERTY TO CPT FOR CUSTOM API ROUTE: (1:41)](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837916#overview).

Add ONE line: **'show_in_rest' => true,** 

```
<?php
function university_post_types(){
        register_post_type('professor', array(
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
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

}

add_action('init', 'university_post_types');

?>
```

Now we can receive JSON data for the last 10 (default) recently created professors: 
**https://hackinwp.com/wp-json/wp/v2/professor** [View Professor API Route](https://hackinwp.com/wp-json/wp/v2/professor).


We'll use CUSTOM REST API Routes to show related professors and programs which correspond to the post/page which our search retrieves. (2:46)

This allows us to build out WP's default search logic which is not very advanced out of the box.
Default WP only searches in obvious fields like TITLE and MAIN BODY field. 
DOES NOT search within our Custom Fields

**Four Main Reasons We Are Creating Our Own New REST API URL**
* We need our own Custom Search Logic
* Respond with WAY less JSON data (load faster for visitors)
    - Default WP URLs return every field about a post, more than we need
    - All WE really need in our search is a (1) Title, (2) Permalink and maybe (3) URL to thumbnail image
    - Search loads faster, especially on slow mobile connection
* Send only 1 getJSON reqeust instead of 6 in our JS
    - Default WP POST URLs only return a single post type at a time (hence why we had to merge PAGES and POST previously)
    - Our Custom URL can be configured to search 6 post types at once (or whatever # needed).
* Good exercise to sharpen PHP skills.


(7:34) - Create separate file and include / require in functions.php

(7:45) - Create new 'includes' folder in our theme folder. File name not matter. (includes/search-route.php).

In functions.php use: **get_theme_file_path()**
```
<?php

require get_theme_file_path('/includes/search-route.php'); 

```

In search-route.php, key WP Functions we use are: 

**register_rest_route()** (10:56)
**WP_REST_SERVER::READABLE** (14:38) - WP constant that substitutes for a normal GET route
    (Some webhosts may use a slightly different variable than GET, so safer to use the WP constant)

Results up to Lesson 71: 
search-route.php
```
<?php
    add_action('rest_api_init', 'universityRegisterSearch');

    function universityRegisterSearch(){
        register_rest_route('university/v1', 'search', array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => 'universitySearchResults'                
        ));               
    } 

    function universitySearchResults(){
        return 'Congrats, you created a route';
    }           

```


### Lesson 72: Create Your Own JSON Data
### Return REAL JSON data to our Custom Route created in Lesson 71


[LESSON 72: Create Your Own JSON Data](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7909620#overview).