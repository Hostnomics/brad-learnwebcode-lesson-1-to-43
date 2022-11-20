
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

<script>
    // const search = new Search()
</script>

<!--LOAD FROM jQuery function addSearchHTML() in Lesson 67-->
    <!--<div class="search-overlay">  <!--<div class="search-overlay search-overlay--active">    -->
   
    <!--    <div class="search-overlay__top">-->
    <!--        <div class="container">-->
    <!--            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>-->
    <!--            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">-->
    <!--            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>-->
    <!--        </div>-->
    <!--    </div>-->
     
    <!--        <div class="container">-->
	   <!-- 	<div id="search-overlay__results">-->
	    		
	   <!-- 	</div>-->
	   <!-- </div>-->
        
    <!--</div>-->
    
   
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<script>
$(document).ready(function(){

            class Search {
          // 1. describe and create/initiate our object
          constructor() {
// Lesson 67 - (4th min) We have to call addSearchHTML before the others because they use classes/IDs which this adds to the DOM
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


// Lesson 64: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7742840#overview 
                        // JSON Formatter: https://jsonformatter.org/json-pretty-print
                        // use jQuery to send out a request to a URL. 
                        // Dollar sign to begin using jQuery
                        // DOT to look inside the jQuery object
                            // jQuery getJSON takes two arguments. (1) First the URL. (2) Second the function/method to call. 
          
          getResults() {

                    // OUR URL: https://hackinwp.com/wp-json/wp/v2/posts?search=biology
                    
                // $.getJSON('https://hackinwp.com/wp-json/wp/v2/posts?search=biology', function (posts) {
                // $.getJSON(`https://hackinwp.com/wp-json/wp/v2/posts?search=${searchTerm}`, function (posts) { 
                
                                                        
// ARROW FN => Whenever we use an anonymous in-line function like this WE CAN USE AN "ES6 Arrow Function" - Lesson 65 @ 7:45 
                // jQuery docs on getJSON: https://api.jquery.com/jquery.getjson/
// Lesson 65 @ 8:13 - A benefit of the ARROW FUNCTION is that IT DOES NOT CHANGE THE VALUE OF THE "this" KEYWORD
                // $.getJSON(`https://hackinwp.com/wp-json/wp/v2/posts?search=` + this.searchField.val(), function (posts) { 
      
              //  $.getJSON(`https://hackinwp.com/wp-json/wp/v2/posts?search=` + this.searchField.val(), posts => {    
              //  $.getJSON(`${universityData.root_url}/wp-json/wp/v2/posts?search=` + this.searchField.val(), posts => { 
// Lesson 66 @ 16:42: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7779400#overview
            // our use of ${universityData.root_url} was working, but he called it this way: 
                $.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=` + this.searchField.val(), posts => { 
                                                // We want to access all of the JSON data that we get back
                                                        // var postResult = posts[0].title.rendered; 
                                                        // alert(postResult); 
                                         // We are in the callback function that will run once the URL to the server has had a chance to respond              
                                            // THIS refers to the getJSON method.
                                            // We want to refer to the MAIN search OBJECT
                                                // 1- use bind like in our events function above and would be attached at the end of this getJSON function "}.bind(this)); "
                                                // 2- Use an Arrow Function
                                                
                        // this.resultsDiv.html('<h2>General Information</h2>\
                        // <ul><li></li></ul>'); 
                                            // Lesson 65 @ 10th minute - JS Template Literals = backticks
                                            
                                                            // var postTitle = posts[0].title.rendered; 
                                                            // var postExcerpt = posts[0].excerpt.rendered;
                                                            // var displayTitleAndExcerpt = postTitle + "- " + postExcerpt;
                                                            // var postLink = posts[0].link;
                                                            // <li><a href="${postLink}" target="_blank">${postTitle} - ${postExcerpt}</a></li>
                                                            // <li><a href="${postLink}" target="_blank">${displayTitleAndExcerpt}</a></li>
                                                            
                                                            // var testArray = ['red', 'orange', 'yelleow'];
                                                            // ${testArray.map(item => `<li>${item}</li>`).join('')}
                                                             

                            this.resultsDiv.html(`
                                    <h2 class="search-overlay__section-title">Search Results</h2>
                                    
                                ${posts.length ? '<ul class="link-list min-list">' : '<b>No posts matched your search. Please try again.</b>'}    
                                        
                                            ${posts.map(item => `<a href="${item.link}" target="_blank"><li>${item.title.rendered} - ${item.excerpt.rendered}</li></a>`).join('')}
                                            
                                ${posts.length ? '</ul>' : ''}             
                            `);
                    // Lesson 66 @ 8:48 - adds isSpinnerVisible to false to make spinner appear as soon as we type something else in search
                                this.isSpinnerVisible = false; 
                // }.bind(this)); 
                });
              
              
                // this.resultsDiv.html("Imagine real search results here...")
                // this.isSpinnerVisible = false
          }
 
          
          keyPressDispatcher(e) {
            if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) {
              this.openOverlay()
            }
        
            if (e.keyCode == 27 && this.isOverlayOpen) {
              this.closeOverlay()
            }
          }

     
          openOverlay() {
            //These two lines are responsible for adding classes
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll")
// Lesson 67 @ 10:16 - clear searchField text input & results when you open or reopen the search overlay (clear out previous search results)
            this.searchField.val('');
            this.resultsDiv.html('');
// Lesson 67 @ 5:54 we added focus to the search text input: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837904#overview
    // This is the function that is responsible for making the Search overlay appear   
    //Add focus to search text input which we set to searchField in the constructor above
            // this.searchField.focus();
        //Need to delay the focus() function to get it to work. He estimates 301
        
    // Anonymous Fn to Delay focus with setTimeout    
            // setTimeout(function() {this.searchField.focus();}, 301);
    // Arrow Fn to Delay focus with setTimeout - no variable so just '()' and remove { } and ; because we are writing it on a single line.    
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