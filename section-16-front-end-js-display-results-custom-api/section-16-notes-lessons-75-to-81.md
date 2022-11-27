# Section 16: Updating Front-End JS to Use Our New REST API URL

## Combining Front-End & Back-End

### Lesson 75: Front-End & Back-End
### Add new properties to the raw JSON that WP sends back to us
Display the results from our new CUSTOM API in section 15.



[Section 16 Lesson 75](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7956668#overview).



Previously we were using a getJSON call for EACH post type we wanted to search. 
In this case, two jQuery getJSON calls, one for posts, one for pages. 

```
<script>

    getResults() {
        $.when(       
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
                // This is like the else{} clause. If you end up here, something went wrong, so write an generic error message:          
                    this.resultsDiv.html('<b>Unexpected Error; Please Try Again.</b>');
              
              });              
          }                         
</script>
```

Now we have our OWN custom API which returns data for ALL six of our post types.


results is just the parameter name we decided to use. Could be anything. 

generalInfo is the array we created for posts and pages in includes/search-route.php


May have to run gulp scripts for a one-time compile
or run gulp watch which will automatically trigger every time you save a change to your file.

Initial change to the jQuery getResults() function
We use jQuery's .html() function with backticks to display our three column search results in a template literal.

In footer.php: 
```
<script>
          getResults() {
                $.getJSON(universityData.root_url + `/wp-json/university/v1/search?term=` + this.searchField.val(), (results) => {
                    this.resultsDiv.html(`
                        <div class="row">
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">General Information</h2>
                                    ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                                    ${results.generalInfo.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorNamePost}` : ''}</li>`).join('')}
                                    ${results.generalInfo.length ? '</ul>' : ''}                                
                            </div>
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Programs</h2>
                                <h2 class="search-overlay__section-title">Professors</h2>
                            </div
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Campuses</h2>
                                <h2 class="search-overlay__section-title">Events</h2>
                            </div
                        </div>
                    `); 
                });
          } //end of getResults function  

</script>
```

We can use tempalte literals when we use backticks as the opening & closing quotes.

Final version of getResults() function at the end of Lesson 75:

```
<script>
          getResults() {
                $.getJSON(universityData.root_url + `/wp-json/university/v1/search?term=` + this.searchField.val(), (results) => {
                    this.resultsDiv.html(`
                        <div class="row">
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">General Information</h2>
                                    ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                                    ${results.generalInfo.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.generalInfo.length ? '</ul>' : ''}                                
                            </div>
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Programs</h2>
                                    ${results.programs.length ? '<ul class="link-list min-list">' : `<b>No programs matched your search. <a href="${universityData.root_url}/programs" target="_blank">View all Programs.</a></b>`}    
                                    ${results.programs.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.programs.length ? '</ul>' : ''}                                   
                                <h2 class="search-overlay__section-title">Professors</h2>
                            </div>
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Campuses</h2>
                                    ${results.campuses.length ? '<ul class="link-list min-list">' : `<b>No Campuses matched your search. <br><a href="${universityData.root_url}/campuses" target="_blank">View all Campuses.</a></b>`}    
                                    ${results.campuses.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.campuses.length ? '</ul>' : ''}                                 
                                <h2 class="search-overlay__section-title">Events</h2>
                            </div>
                        </div>
                    `); 
                    this.isSpinnerVisible = false;
                });
          } //end of getResults function

</script>
```



### Lesson 76: Custom Layout & JSON based on Post Type
### Customize the Search Results on Professor and Event Post Types


[Section 16 Lesson 76](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7956670#overview).


To pass the thumbnail image to the Professor Post Type we'll use **get_the_post_thumbnail_url()** WP function. (6:55)

It has two arguments
*1 - Which post you want to get the thumbnail image for
*2 - The size of the image to be displayed 
**get_the_post_thumbnail_url(which post, image size)**

0 tells WP that you want the current post. (7:05)
**get_the_post_thumbnail_url(0, size)**

We'll use this the size we created as 'professorLandscape' (maybe in Lesson 41 at (8:06))
**get_the_post_thumbnail_url(0, 'professorLandscape')**

So we added this to the Professor fields in our custom API URL in includes/search-route.php: 
```
<?php

    if(get_post_type() == 'professor'){    
        array_push($results['professors'], array(         
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'type' => get_post_type(),
            'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));
    }  

// GET REQUEST IN POSTMAN TO: https://hackinwp.com/wp-json/university/v1/search?term=barksalot
// RETURNS
{
    "generalInfo": [],
    "professors": [
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        }
    ],
    "programs": [],
    "events": [],
    "campuses": []
}

```

(make sure your JS is getting compiled and bundled up - (8:33))

## Lesson 75 @ 9th minute - Set up Event Custom Post Type Results

(To edit Programs custom page, edit archive-program.php)

We'll add the formatted Month and Day of the Event Custom Post Type to the our Event API route
And we'll add the excerpt logic

So in includes/search-route.php:
```
<?php

    if(get_post_type() == 'event'){   
        
        $eventDate = new DateTime(get_field('event_date')); 
        $formatted_month = $eventDate->format('M'); 
        $formatted_day = $eventDate->format('d');

        if(has_excerpt()){
            $display_excerpt = get_the_excerpt();  
        }else{
            $display_excerpt = wp_trim_words(get_the_content(), 18);
        }

        array_push($results['events'], array(         
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'type' => get_post_type(),
            'month' => $formatted_month,
            'day' => $formatted_day,
            'excerpt' => $display_excerpt
        ));
    } 

// GET ROUTE TO: https://hackinwp.com/wp-json/university/v1/search?term=poetry
// RETURNS:
{
    "generalInfo": [],
    "professors": [],
    "programs": [],
    "events": [
        {
            "title": "Poetry Day",
            "permalink": "https://hackinwp.com/events/poetry-day/",
            "type": "event",
            "month": "Nov",
            "day": "24",
            "excerpt": "Poetry day is going to be amazing."
        }
    ],
    "campuses": []
}

```



### Lesson 78: Search Logic That's Aware of Relationships
### PART 1: Related search hard coded for Program Custom Post Type of biology (ID 89)

A search for biology should return Professor, Campus & Event Custom Post Types tagged with Biology

Currently a search for biology only retrieves Posts, Pages and Programs CPT. 

[Section 16 Lesson 77 NOTE](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/20613988#overview).

[Section 16 Lesson 78 LESSON](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7956672#overview).

Currently our search is only looking for the search term in the TITLE or MAIN BODDY field. 

When we created our Professor Custom Post Type with ACF, we set up a field for 'Related Programs'. 
WP does not store the word 'Biology' in the DB, but instead stores the numerical ID for 'biology'.  (3:11)

'Biology' is a Program Custom Post type. To find the ID, edit the Biology Program and the 'post id' number is displayed in the URL. 
In this example, it was **/wp-admin/post.php?post=89&action=edit** 89. 

*Biology = 89
*English = 90
*Math = 88


We want a filter that looks within the related programs custom field (8:25)

So in search-route.php we'll add a second WP_Query 

```
<?php

// LESSON 78 @  7:10 - Create a 2nd WP Query to get Professors related to the search query

        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',         // 1. Identify the post type we are looking for
            'meta_query' => array(                             // 2. Meta Queries are how we can search based on a custom field.
                    array(                                              // we use an array nested within an array, b/c WP lets you search multiple filters
                        'key' => 'related_programs',    // 2a. Name of the ACF that we want to look within.
                        'compare' => 'LIKE',            // 2b. The comparison type. Here we'll use 'LIKE'
                        'value' => '"89"'               // 2c. The ID number of the Program we are looking for. Here, 89 = Biology.
                    ) 
                )
        
        ));
        
        while($programRelationshipQuery->have_posts()){
            $programRelationshipQuery->the_post(); 
            
            if(get_post_type() == 'professor'){    
                array_push($results['professors'], array(         
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            }            
        }

```


A search for 'biology' will return the SAME Professor Barksalot post twice, because it finds 
Program ID 89 (Biology) as well as the TEXT we added to the body with the word 'biology'.


Search for 'biology': https://hackinwp.com/wp-json/university/v1/search?term=biology
RETURNS the same post for 'barksalot' twice:
```
{
    "generalInfo": [
        {
            "title": "Biology is Cool",
            "permalink": "https://hackinwp.com/2022/11/18/biology-is-cool/",
            "type": "post",
            "authorName": "dAppin"
        }
    ],
    "professors": [
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        {
            "title": "Dr. Meowsalot",
            "permalink": "https://hackinwp.com/professor/dr-meowsalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/meowsalot-400x260.jpg"
        }
    ],
    "programs": [
        {
            "title": "Biology",
            "permalink": "https://hackinwp.com/programs/biology/",
            "type": "program"
        }
    ],
    "events": [],
    "campuses": []
}

```

To remove the duplicates we'll add: 
```
$results['professors'] = array_unique($results['professors'], SORT_REGULAR); 
```

This removes the duplicate post, but it adds key numbers to each result. 
```
{
    "generalInfo": [
        {
            "title": "Biology is Cool",
            "permalink": "https://hackinwp.com/2022/11/18/biology-is-cool/",
            "type": "post",
            "authorName": "dAppin"
        }
    ],
    "professors": {
        "0": {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        "2": {
            "title": "Dr. Meowsalot",
            "permalink": "https://hackinwp.com/professor/dr-meowsalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/meowsalot-400x260.jpg"
        }
    },
    "programs": [
        {
            "title": "Biology",
            "permalink": "https://hackinwp.com/programs/biology/",
            "type": "program"
        }
    ],
    "events": [],
    "campuses": []
}

```

We we can remove the key numbers by wrapping our array_unique with **array_values()**

$results['professors'] = array_values **(array_unique(**$results['professors'], SORT_REGULAR)**)**;

```
$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
```

To give us a final result of: https://hackinwp.com/wp-json/university/v1/search?term=biology
```
{
    "generalInfo": [
        {
            "title": "Biology is Cool",
            "permalink": "https://hackinwp.com/2022/11/18/biology-is-cool/",
            "type": "post",
            "authorName": "dAppin"
        }
    ],
    "professors": [
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        {
            "title": "Dr. Meowsalot",
            "permalink": "https://hackinwp.com/professor/dr-meowsalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/meowsalot-400x260.jpg"
        }
    ],
    "programs": [
        {
            "title": "Biology",
            "permalink": "https://hackinwp.com/programs/biology/",
            "type": "program"
        }
    ],
    "events": [],
    "campuses": []
}
```



### Lesson 79: Search Logic That's Aware of Relationships PART 2
### PART 2: Related search of custom post types that is NOT hard coded to biology (ID 89)

[Section 16 Lesson 79](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007366#overview).

Modify the WP_Query for related custom post types that is not hard coded:
```
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',         // 1. Identify the post type we are looking for
            'meta_query' => array(                             // 2. Meta Queries are how we can search based on a custom field.
                    array(                                              // we use an array nested within an array, b/c WP lets you search multiple filters
                        'key' => 'related_programs',    // 2a. Name of the ACF that we want to look within.
                        'compare' => 'LIKE',            // 2b. The comparison type. Here we'll use 'LIKE'
                        'value' => '"89"'               // 2c. The ID number of the Program we are looking for. Here, 89 = Biology.
                    ) 
                )
        
        ));

```



In the while loop for the $mainQuery WP_Query, we'll add a field to our custom API route for the 'programs' array. 

We'll use the WP built-in function **get_the_id()** to dynamically retrieve the ID of the Program Custom Post Type

In includes/search-route.php:
```
<?php

    if(get_post_type() == 'program'){    
        array_push($results['programs'], array(         
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'type' => get_post_type(),
            'id' => get_the_id()            // L79 @ 2:38 added dynamic ID for Programs: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007366#overview
        ));
    } 

```

This returns: https://hackinwp.com/wp-json/university/v1/search?term=biology
```
    "programs": [
        {
            "title": "Biology",
            "permalink": "https://hackinwp.com/programs/biology/",
            "type": "program",
            "id": 89
        }
    ],
```


Then down in our second WP_Query (_$programRelationshipQuery_), we can set the value of the **meta_query** array for Professor to use
**$results['programs'][0]['id']**
The _[0]_ to get the first item in the JSON array

```
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',         // 1. Identify the post type we are looking for
            'meta_query' => array(                             // 2. Meta Queries are how we can search based on a custom field.
                    array(                                              // we use an array nested within an array, b/c WP lets you search multiple filters
                        'key' => 'related_programs',    // 2a. Name of the ACF that we want to look within.
                        'compare' => 'LIKE',            // 2b. The comparison type. Here we'll use 'LIKE'
                        // 'value' => '"89"'               // 2c. The ID number of the Program we are looking for. Here, 89 = Biology.
                        'value' => '"' . $results['programs'][0]['id'] . '"'   // L79 @ (3:14) - Dynamically get the ID of the matching program
                    ) 
                )
        ));
```

Lesson 79 @ (4:27) - Currently we are ALWAYS returning the first PROGRAM match at position [0].

That's the limitation of our current Professior meta_query: 
```
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',         
            'meta_query' => array(                            
                    array(                                              
                        'key' => 'related_programs',    
                        'compare' => 'LIKE',            
                        'value' => '"' . $results['programs'][0]['id'] . '"'   // L79 @ (4:27) - Works until more than 1 program match.
                    ) 
                )
        ));

```


**Lesson 79 @ (11:30)** - This section of our code dynamically each Program match (the [0], [1], [2] issue)



```
        $programsMetaQuery = array('relation' => 'OR');     // L79 @ 11:39 -Solution returns ALL Professors if no match found, empty professors[], ex jibberish search.
        
        foreach($results['programs'] as $item){
            array_push($programsMetaQuery, array( 
                        'key' => 'related_programs',    
                        'compare' => 'LIKE',            
                        // 'value' => '"' . $results['programs'][$counter]['id'] . '"'      // 
                        
                        'value' => '"' . $item['id'] . '"'  // Lesson 79 @ 10:30
                    )
            ); 
        }



        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',  
            'meta_query' => $programsMetaQuery
        ));

```

So a return for jibberish 'asdfaswefsd' will return ALL 3 of our Professor CPT:
```
{
    "professors": [
        {
            "title": "Dr. Froggerson",
            "permalink": "https://hackinwp.com/professor/dr-froggerson/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/frog-bio-400x260.jpg"
        },
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        {
            "title": "Dr. Meowsalot",
            "permalink": "https://hackinwp.com/professor/dr-meowsalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/meowsalot-400x260.jpg"
        }
    ],
    "programs": [],
    "events": [],
    "campuses": []
}
```

**Lesson 79 @ (12:31)** - fix the ALL Program CPT results for jibberish by wrapping it with if statement.
The IF statement checks IF ANY Program CPT matches a search term, prevents, 
so we don't return ALL Professor CPTs when no match is found.

```
if($results['programs']){ 

}
```

Now a search with no Program matches will return 
```
{
    "generalInfo": [],
    "professors": [],
    "programs": [],
    "events": [],
    "campuses": []
}
```


Lesson 79 @ (15:26) - The problem where 'math' search matches BIOLOGY post with the word 'math' in the TEXT BODY. 

**Solution**
So we’ll create a new ACF field only for Programs (called main_body_content) which will store the “Text Body” content, so it will be outside the scope of our custom includes/search-route.php. 


See Doc Notes. 

Final part of Lesson 79 (18:44) we will fix the user experience to remove the default text editor for PROGRAM Custom Post Type ONLY, and instead leave only the ACF (wysiwyg editor, main_body_content) area for the user to use, without realizing what they type in the main_body_content text is excluded from our search. 

Finally, in mu-plugins/university-post-types.php, we just remove supports editor to remove the default editor 
for solemente Program Custom Post Type: 

```
    register_post_type('program', array(
        //    'supports' => array('title', 'editor'),       //L79 @ 
            'supports' => array('title'),
            
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs', 
                'singular_name' => 'Program'
                ),
            'menu_icon' => 'dashicons-awards'
    ));      

```

This completes the relationship between Programs and Professors. 

Our search now returns Professors based on their relationship to Programs. (ie 'biology').

Next, we'll build a similar relationship between **Campuses & Events** and **Programs.**

Lesson 80: Completing our Search Overlay


**RECAP**
the_content() - retrieves the default wysiwyg editor content.

To get any Custom Post Type field, use **the_field()** and pass the name of the CPT field as the parameter
the_field('main_body_content');


### Lesson 80: Build Relationships b/t Programs and Campuses & Events
### Duplicate the relationship we built b/t Programs and Professors in Lesson 80

[Lesson 80 - Section 16](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007368#overview).


In includes/search-route.php update the **$programRelationshipQuery** WP Query to identify CPTs Professor AND Events by setting it to an array (1:43)
```
    $programRelationshipQuery = new WP_Query(array(
       // 'post_type' => array('professor','events'), // Didn't work b/c must use singular 'event' NOT 'events'
        'post_type' => array('professor','event'),
        'meta_query' => $programsMetaQuery
    ));
```

In the $programRelationshipQuery check for 'events'
```
                    while($programRelationshipQuery->have_posts()){
                        $programRelationshipQuery->the_post(); 
                        
                        if(get_post_type() == 'professor'){    
                            array_push($results['professors'], array(         
                                'title' => get_the_title(),
                                'permalink' => get_the_permalink(),
                                'type' => get_post_type(),
                                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                            ));
                        }

//*******************************************************************************************************************                        
                        if(get_post_type() == 'event'){                                 // L80 @ 2nd minute added check for event
                                $eventDate = new DateTime(get_field('event_date')); 
                                $formatted_month = $eventDate->format('M'); 
                                $formatted_day = $eventDate->format('d');
                                
                                $display_excerpt = null; //L76 @ 7:45 - set excerpt to null in case event has no excerpt OR content and it throws an error
                                if(has_excerpt()){
                                   $display_excerpt = get_the_excerpt();  
                                }else{
                                    $display_excerpt = wp_trim_words(get_the_content(), 18);
                                }
                                
                                array_push($results['events'], array(         
                                    'title' => get_the_title(),
                                    'permalink' => get_the_permalink(),
                                    'type' => get_post_type(),
                                    'month' => $formatted_month,
                                    'day' => $formatted_day,
                                    'excerpt' => $display_excerpt
                                ));
                        }
//*********************************************************************************************************                        
            }
```

Remove Duplicate 'event' posts:

```
$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));

```

Previously a search for 'biology' would return an empty events array 'events[]'
POSTMAN GET: https://hackinwp.com/wp-json/university/v1/search?term=biology
```
{
    "generalInfo": [
        {
            "title": "Biology is Cool",
            "permalink": "https://hackinwp.com/2022/11/18/biology-is-cool/",
            "type": "post",
            "authorName": "dAppin"
        }
    ],
    "professors": [
        {
            "title": "Dr. Barksalot",
            "permalink": "https://hackinwp.com/professor/dr-barksalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/barksalot-400x260.jpg"
        },
        {
            "title": "Dr. Meowsalot",
            "permalink": "https://hackinwp.com/professor/dr-meowsalot/",
            "type": "professor",
            "image": "https://hackinwp.com/wp-content/uploads/2022/11/meowsalot-400x260.jpg"
        }
    ],
    "programs": [
        {
            "title": "Biology",
            "permalink": "https://hackinwp.com/programs/biology/",
            "type": "program",
            "id": 89
        }
    ],
    "events": [],
    "campuses": []
}
```

Now we are getting the Events CPT which are tagged as 'biology' in their related programs field.


...
    "events": [
        {
            "title": "Winter Study Night",
            "permalink": "https://hackinwp.com/events/winter-study-night/",
            "type": "event",
            "month": "Dec",
            "day": "10",
            "excerpt": "Join us in Austin when we move back and start engine wp ipsum dolor sit amet, consectetur adipiscing&hellip;"
        },
        {
            "title": "The Science of Cats",
            "permalink": "https://hackinwp.com/events/the-science-of-cats/",
            "type": "event",
            "month": "Nov",
            "day": "08",
            "excerpt": "Curabitur gravida arcu ac tortor dignissim convallis aenean et. Amet facilisis magna etiam tempor orci eu lobortis. Vestibulum&hellip;"
        }
    ],
    "campuses": []
}

```
```

**Going Back To Lesson 54: Campus Continued** (9:05): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7639710#overview
Create Custom Field "Related Campuses" **related_campus**

1. Field Type = 'Relationship'
2. Filter by Post Type = 'Campus' (what we will be selecting from, belongs to)
3. Filters: Uncheck 'Taxonomy' and 'Post Type'. Leave 'Search' Checked
4. Location Rule: Show if _Post Type_ is equal to **Program**


Then when we edit Program, we can select the Campus location where that Program is taught: 

![Related Campus Selection on Programs](https://i.imgur.com/Uczmjg9.png)

Lesson 54: Show programs available at Campus with WP Query
https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7639710#overview



**Returning back to Lesson 80 @ 9:21**
We will set up the relationship b/t Campus and Related Programs (taught @ Campus)

In the $mainQuery as we are using if statements to check for each post type, add this to Program CPT
```
<?php

    if(get_post_type() == 'program'){  
                                                            // Set up related Campuses in Lesson 54 (9:05)
        $relatedCampuses = get_field('related_campus');     // L80 @ 9:21 : https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007368#overview
        
            if($relatedCampuses){       //As long as variable not empty, this evaluates to true.
                foreach($relatedCampuses as $campus) {
                    array_push($results['campuses'], array(

                   //     'title' => get_the_title(),             // L80 (12:54) - **SCOPE ISSUE** GETTING TITLE OF ie 'MATH' PROGRAM, and NOT the CAMPUS CPT Title. 
                   //     'permalink' => get_the_permalink()

                        'title' => get_the_title($campus),             // L80 (13:26) - **SCOPE ISSUE** specify titel and permalink of the CAMPUS CPT by passing it as parameter
                        'permalink' => get_the_permalink($campus)

                    ));
                }
            }
        
        
        array_push($results['programs'], array(         
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'type' => get_post_type(),
            'id' => get_the_id()            // L79 @ 2:38 added dynamic ID for Programs: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007366#overview
        ));
    } 


```


### Lesson 81: jQuery Free Live Search
Updated june 20

[Lesson 81 - Section 16](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/20613720#overview).
