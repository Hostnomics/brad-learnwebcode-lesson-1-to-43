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

[Section 16 Lesson 79](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/8007366#overview).


