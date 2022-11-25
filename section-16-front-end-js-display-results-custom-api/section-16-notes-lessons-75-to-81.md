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

