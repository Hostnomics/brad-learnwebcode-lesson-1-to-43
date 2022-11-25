
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


// GET SEARCH RESULTS:
// LESSON 69 - A-SYNCHRONOUS SOLUTION:https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7837908#overview
// LESSON 75 - Rewrite getResults function to use the Custom API we set up in includes/search-route.php: https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7956668#overview

          getResults() {
                $.getJSON(universityData.root_url + `/wp-json/university/v1/search?term=` + this.searchField.val(), (results) => {
                    this.resultsDiv.html(`
                        <div class="row">
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">General Information</h2>
                                    ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<b>No Posts matched your search. Please try again.</b>'}    
                                    ${results.generalInfo.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.generalInfo.length ? '</ul>' : ''}                                
                            </div>
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Programs</h2>
                                    ${results.programs.length ? '<ul class="link-list min-list">' : `<b>No Programs matched your search. <a href="${universityData.root_url}/programs" target="_blank">View all Programs.</a></b>`}    
                                    ${results.programs.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.programs.length ? '</ul>' : ''} 
                                    
                                <h2 class="search-overlay__section-title">Professors</h2>
                                    ${results.professors.length ? '<ul class="professor-cards">' : `<b>No Professors matched your search.</b>`}    
                                    
                                    ${results.professors.map(item => `
                                            <li class="professor-card__list-item">
                                                <a class="professor-card" href="${item.permalink}">
                                                    <img class="professor-card__image" src="${item.image}">
                                                    <span class="professor-card__name">${item.title}</span>
                                                </a>
                                            </li>                                   
                                    `).join('')}
               
                                    ${results.professors.length ? '</ul>' : ''}                                 
                            </div>
                            <div class="one-third">
                                <h2 class="search-overlay__section-title">Campuses</h2>
                                    ${results.campuses.length ? '<ul class="link-list min-list">' : `<b>No Campuses matched your search. <br><a href="${universityData.root_url}/campuses" target="_blank">View all Campuses.</a></b>`}    
                                    ${results.campuses.map(item => `<li><a href="${item.permalink}" target="_blank">${item.title}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                                    ${results.campuses.length ? '</ul>' : ''}   
                                    
                                <h2 class="search-overlay__section-title">Events</h2>
                                    ${results.events.length ? '' : `<b>No Events matched your search. <a href="${universityData.root_url}/events" target="_blank">View all Events.</a></b>`}    

                                    ${results.events.map(item => `
                                    
                                                <div class="event-summary">
                                                    <a class="event-summary__date t-center" href="${item.permalink}">
                                                        
                                                          <span class="event-summary__month">
                                                            ${item.month}
                                                          </span>
                    
                                                          <span class="event-summary__day">
                                                            ${item.day}
                                                          </span>
                                                    </a>
                                                    <div class="event-summary__content">
                                                      <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                                                      <p>
                                                            ${item.excerpt}
                                                      <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                                                    </div>
                                              </div>                                     
                                    
                                   
                                    `).join('')}
                                    
                                    
                                    ${results.events.length ? '</ul>' : ''}                                 
                            </div>
                        </div>
                    `); 
                    this.isSpinnerVisible = false;
                });
          } //end of getResults function      
// END OF getResults function              


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