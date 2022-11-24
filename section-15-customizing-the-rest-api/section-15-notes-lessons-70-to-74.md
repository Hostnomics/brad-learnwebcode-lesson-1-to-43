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
**https://hackinwp.com/wp-json/wp/v2/professor** 


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
### Return REAL JSON data to our Custom Route created in Lesson 72


[LESSON 72: Create Your Own JSON Data](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7909620#overview).

WP automatically converts php data into JSON data

```
<?php
    function universitySearchResults(){
        return array('BTC', 'ETH', 'MATIC'); 
    } 

// RETURNS
{
    ["BTC","ETH","MATIC"]
}   


```

(4:54) - create custom logic to return JSON we need 
In includes/search-route.php
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
        $professors = new WP_Query(array(
            'post_type' => 'professor'
        )); 

        return $professors->posts;
    }  

```

Now we get the 10 last CUSTOM POST TYPES of 'professor' at our custom route: https://hackinwp.com/wp-json/university/v1/search


Just return the title and permalink of the Custom Post type 'Professor' posts
```
<?php

    function universitySearchResults() {
        $professors = new WP_Query(array(
            'post_type' => 'professor'
        )); 

        //set up empty array
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

```

Returns all Professor Post Types:
```
[
    {
        "title": "Dr. Froggerson",
        "permalink": "https://hackinwp.com/professor/dr-froggerson/"
    },
    {
        "title": "Dr. Barksalot",
        "permalink": "https://hackinwp.com/professor/dr-barksalot/"
    },
    {
        "title": "Dr. Meowsalot",
        "permalink": "https://hackinwp.com/professor/dr-meowsalot/"
    }
]
```
We can now create a custom array which contains only the exact data we want from an object, here a Custom Post Type.


### Lesson 73: WP_Query and Keyword Searching
### keyword searching within our Custom Post Type Results via our custom route


[LESSON 73: WP_Query and Keyword Searching](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7909626#overview).

This lesson, we'll filter the Professor Custom Post Types in our WP_Query if they match the users' query. 

In includes/search-route.php:
``` 
<?php   
    $professors = new WP_Query(array(
            'post_type' => 'professor',
// L73 @ 1:32 Arguments we've used in the past - posts_per_page, meta_query, order_by
// NEW ARGUMENT 's' which stands for search
            's' => 'Barksalot'
        )); 

// RETURNS
[
    {
        "title": "Dr. Barksalot",
        "permalink": "https://hackinwp.com/professor/dr-barksalot/"
    }
]
 ```  
The new argument use used in our WP_Query array,(**'s' => 'Barksalot'**) does the trick of matching the search term to the appropriate Professor type if a match exists

Here we are HARD CODING a search specifically for dummy Professor Post Type with the word 'Barksalot'
**'s' => 'Barksalot'**

Custom URL: **hackinwp.com/wp-json/university/v1/search?term=barksalot**
```
    function universitySearchResults($data){    // L73 @ 4:05 - Add $data parameter (name not matter), to catch the extra data WP sends about the callback this function receives
                                                // $data is an array that WP puts together and within this array we can access any parameter someone adds on to our custom URL    
            
        $professors = new WP_Query(array(       // L72 @ 5:20 - create a new instance of the WP Query class
                'post_type' => 'professor',
                's' => 'Barksalot'                   // L73 @ 1:32 NEW Arg 's'; Arguments we've used in the past - posts_per_page, meta_query, order_by
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


// RETURNS

[
    {
        "title": "Dr. Barksalot",
        "permalink": "https://hackinwp.com/professor/dr-barksalot/"
    }
]

```


### sanitize_text_field()
WordPress provides built in sql injection protection for searches on a site

L73 @ 7th min - We have to sanitize the input from a user.
SO, always wrap your input fields with WP function **sanitize_text_field()**

```
<?php

    $professors = new WP_Query(array(
        'post_type' => 'professor',
        
        //'s' => $data['term']
        's' => sanitize_text_field($data['term'])
    ));

```


### Lesson 74: Working With Multiple Post Types
### Search Results From ALL post types

We will now return data in our search from ALL post types, instead of only the Professor Custom Post Type.
After that we'll go back to working on the display for our search overlay (via footer.php)
We'll sort the results in 3 columns. (1) Posts/Pages, (2) Professors/Programs, (3) Campus/Events (Section 16)

[LESSON 74: Working With Multiple Post Types](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7909630#overview).