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

```



```