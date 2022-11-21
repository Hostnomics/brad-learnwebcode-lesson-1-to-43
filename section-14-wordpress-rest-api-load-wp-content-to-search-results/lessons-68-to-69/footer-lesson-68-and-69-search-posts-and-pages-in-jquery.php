<footer class="site-footer">
      <div class="site-footer__inner container container--narrow">
        <div class="group">
          <div class="site-footer__col-one">
            <h1 class="school-logo-text school-logo-text--alt-color">
              <a href="<?php echo site_url(); ?>"><strong>Fictional</strong> University</a>
            </h1>
            <p><a class="site-footer__link" href="#">555.555.5555</a></p>
          </div>

          <div class="site-footer__col-two-three-group">
            <div class="site-footer__col-two">
              <h3 class="headline headline--small">Explore</h3>
              <nav class="nav-list">
                  
        <!--LOCATION OF FOOTER ONE MENU (Lesson 20) -->
                <?php
                // END OF LESSON 20 -Go back to hard coded menu:
                    // wp_nav_menu(array(
                    //     'theme_location' => 'footerLocationOne'
                        
                    // )); 
                ?>
        
                    <ul>
                      <li><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
                      <li><a href="#">Programs</a></li>
                      <li><a href="#">Events</a></li>
                      <li><a href="#">Campuses</a></li>
                    </ul>
                    
              </nav>
            </div>

            <div class="site-footer__col-three">
              <h3 class="headline headline--small">Learn</h3>
              <nav class="nav-list">
        <!--LOCATION OF FOOTER TWO MENU (Lesson 20) -->
                <?php
                // END OF LESSON 20 -Go back to hard coded menu:
                        // wp_nav_menu(array(
                        //     'theme_location' => 'footerLocationTwo'
                            
                        // )); 
                ?>          
                    <ul>
                      <li><a href="#">Legal</a></li>
                      <li><a href="<?php echo site_url('/privacy-policy'); ?>">Privacy</a></li>
                      <li><a href="#">Careers</a></li>
                    </ul>
                    
              </nav>
            </div>
          </div>

          <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Us</h3>
            <nav>
              <ul class="min-list social-icons-list group">
                <li>
                  <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </footer>

  
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<script>
$(document).ready(function(){

            class Search {
          // 1. describe and create/initiate our object
          constructor() {
            this.addSearchHTML(); 
            this.resultsDiv = $("#search-overlay__results")
            this.openButton = $(".js-search-trigger")
            this.closeButton = $(".search-overlay__close")
            this.searchOverlay = $(".search-overlay")
            this.searchField = $("#search-term")
            this.events()
            this.isOverlayOpen = false
            this.isSpinnerVisible = false
            this.previousValue
            this.typingTimer
          }
        
          // 2. events
          events() {
            this.openButton.on("click", this.openOverlay.bind(this))
            this.closeButton.on("click", this.closeOverlay.bind(this))
            $(document).on("keydown", this.keyPressDispatcher.bind(this))
            this.searchField.on("keyup", this.typingLogic.bind(this))
          }
        
          // 3. methods (function, action...)
          typingLogic() {
            if (this.searchField.val() != this.previousValue) {
              clearTimeout(this.typingTimer)
        
              if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                  this.resultsDiv.html('<div class="spinner-loader"></div>')
                  this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750)
              } else {
                this.resultsDiv.html("")
                this.isSpinnerVisible = false
              }
            }
        
            this.previousValue = this.searchField.val()
          }


// LESSON 69 - A-SYNCHRONOUS SOLUTION:https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837908#overview
          getResults() {
              // jQuery has when() and then() methods, 
              // .when() lets us run as many JSON request as we want. And they will all run Asynchronously
                        // .when() will babysit all of our JSON requests (pages & posts) 
              // .then() - action to take after all our JSON requests have completed.
              
            //   $.when(a, b).then(anonymous function to run); 
            
    // The a JSON request will automatically MAP to arrow function one, and b to two:         
            //   $.when(a, b).then(one, two) => {};  
              
              $.when(
                //  Testing Custom Error Code Below: $.getJSON(universityData.root_url + `/wp-json-error-test/wp/v2/posts?search=` + this.searchField.val()), 
                  $.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=` + this.searchField.val()),
                  $.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=` + this.searchField.val())
                  
    // Lesson 69 @ 8:40: To display an error message to user, add solution to the .then() jQuery function: 
                //   ).then((posts, pages) => {
                     ).then((posts, pages) => {    
                      
//***********************************************************************************************************************************************************************************                        
                //.then() method returns slightly different variables for posts and pages, so get the first result for each with [0]
                //.then() includes addtional information about whether the request succeeded for failed, so exclude that with [0]
                // var combinedResults = posts.concat(pages);
                var combinedResults = posts[0].concat(pages[0]);
                
                this.resultsDiv.html(`
                        <h2 class="search-overlay__section-title">Search Results</h2>
                    ${combinedResults.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                                ${combinedResults.map(item => `<a href="${item.link}" target="_blank"><li>${item.title.rendered} - ${item.excerpt.rendered}</li></a>`).join('')}
                    ${combinedResults.length ? '</ul>' : ''}             
                `);
                    this.isSpinnerVisible = false; 
//***********************************************************************************************************************************************************************************                  
            //   });  <== ADD SECOND ARGUMENT TO .THEN() to display an error message - Lesson 69 @ 9:01
              }, () => {
    // This is like the else{} clause. If you end up here, something went wrong, so write an generic error message:          
                    this.resultsDiv.html('<b>Unepected Error; Please Try Again.</b>');
              
              });
              
          }      
              
                // $.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=` + this.searchField.val(), posts => { 

                    //Any code here will not run until the server has had a chance to send back the data Lesson 68 @ 2:56: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837906#overview
                    
                        // So in this callback area, let's set up ANOTHER JSON request
                        // $.getJSON(url, method);
                        // $.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=` + this.searchField.val(), pages => {
//***********************************************************************************************************************************************************************************                        
                                        //smush both together with .concat():
                            // var combinedResults = posts.concat(pages);
                            
                            // this.resultsDiv.html(`
                            //         <h2 class="search-overlay__section-title">Search Results</h2>
                            //     ${combinedResults.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                            //                 ${combinedResults.map(item => `<a href="${item.link}" target="_blank"><li>${item.title.rendered} - ${item.excerpt.rendered}</li></a>`).join('')}
                            //     ${combinedResults.length ? '</ul>' : ''}             
                            // `);
                            //     this.isSpinnerVisible = false; 
//***********************************************************************************************************************************************************************************                            
        //                 });
        //         });

        //   }




// LESSON 68 - SYNCHRONOUS SOLUTION: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837906#overview
        //   getResults() {
        //         $.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=` + this.searchField.val(), posts => { 

                    //Any code here will not run until the server has had a chance to send back the data Lesson 68 @ 2:56: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837906#overview
                    
                            // So in this callback area, let's set up ANOTHER JSON request
                            // $.getJSON(url, method);
                    // $.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=` + this.searchField.val(), pages => {
//***********************************************************************************************************************************************************************************                        
                                        //smush both together with .concat():
                            // var combinedResults = posts.concat(pages);
                            
                            // this.resultsDiv.html(`
                            //         <h2 class="search-overlay__section-title">Search Results</h2>
                            //     ${combinedResults.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                            //                 ${combinedResults.map(item => `<a href="${item.link}" target="_blank"><li>${item.title.rendered} - ${item.excerpt.rendered}</li></a>`).join('')}
                            //     ${combinedResults.length ? '</ul>' : ''}             
                            // `);
                            //     this.isSpinnerVisible = false; 
//***********************************************************************************************************************************************************************************                            
                        // });
                        
                        
//***********************************************************************************************************************************************************************************                        
                            // this.resultsDiv.html(`
                            //         <h2 class="search-overlay__section-title">Search Results</h2>
                            //     ${posts.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                            //                 ${posts.map(item => `<a href="${item.link}" target="_blank"><li>${item.title.rendered} - ${item.excerpt.rendered}</li></a>`).join('')}
                            //     ${posts.length ? '</ul>' : ''}             
                            // `);
                            //     this.isSpinnerVisible = false; 
//***********************************************************************************************************************************************************************************
        //         });

        //   }
 
          
          keyPressDispatcher(e) {
            if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) {
              this.openOverlay()
            }
        
            if (e.keyCode == 27 && this.isOverlayOpen) {
              this.closeOverlay()
            }
          }

     
          openOverlay() {
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll")
            this.searchField.val('');
            this.resultsDiv.html('');
            setTimeout(() => this.searchField.focus(), 301); 
            console.log("our open method just ran!")
            this.isOverlayOpen = true
          }
        
          closeOverlay() {
            this.searchOverlay.removeClass("search-overlay--active")
            $("body").removeClass("body-no-scroll")
            console.log("our close method just ran!")
            this.isOverlayOpen = false
          }
          
// Added in Lesson 67 to have the jQuery load the footer HTML: 
          addSearchHTML() {
            $("body").append(`
              <div class="search-overlay">
                <div class="search-overlay__top">
                  <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                  </div>
                </div>
                
                <div class="container">
                  <div id="search-overlay__results"></div>
                </div>
        
              </div>
            `)
          }
 
          
}


const search = new Search();





});
    
    
</script>

 
    
    
    
<?php wp_footer(); ?>
    </body>
</html>