
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

    <div class="search-overlay">  <!--<div class="search-overlay search-overlay--active">    -->
   
        <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
        </div>
     
            <div class="container">
	    	<div id="search-overlay__results">
	    		
	    	</div>
	    </div>
        
    </div>
    


 <script>
 // RESOURCES
 	// JavaScript Selectors: https://www.educative.io/answers/what-are-the-different-ways-to-select-dom-elements-in-javascript
 	// Add Event Listener on Search Button: https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onclick_addeventlistener
 	// Add / Remove Class in JS: 
 		// https://www.w3schools.com/howto/howto_js_add_class.asp
 		// https://stackoverflow.com/questions/507138/how-to-add-a-class-to-a-given-element
 		// Class List Docs: https://developer.mozilla.org/en-US/docs/Web/API/Element/classList
    
           	// document.getElementsByClassName("js-search-trigger").onclick = function() { fun() }; 
	 document.getElementById("glasstest").addEventListener("click", openFunction);

	// don't set as constant const isOverlayOpen = false
	let isOverlayOpen = false; 

	// Find a specific Key Code: https://www.toptal.com/developers/keycode/for/escape
	// onkeypress is deprecated: https://stackoverflow.com/questions/52882144/replacement-for-deprecated-keypress-dom-event
	// MAIN SOLUTION used below: (From "Ian" in 2013): https://stackoverflow.com/questions/16089421/how-do-i-detect-keypresses-in-javascript 
		// Team Tree House solution using keydown in 2014: https://teamtreehouse.com/community/how-do-i-make-an-event-happen-when-pressing-a-specific-key 
		// Keyboard Event Docs: https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key
		// older tutorial: https://www.javascripttutorial.net/javascript-dom/javascript-keyboard-events/
		// difference b/t onkeydown and onkeyup: https://stackoverflow.com/questions/38502560/whats-the-difference-between-keyup-keydown-keypress-and-input-events

// Dom keydown			
		//document.onkeydown = function (e) {
		
		document.onkeydown = function(e) {shortcutKeyFunction()};
		
		//let allInputs = document.querySelectorAll("input");
		//let allInputs = document.getElementsByTagName(input);
		//let allTextAreas = document.getElementsByTagName(textarea);
		
		function shortcutKeyFunction(e){
		    e = e || window.event;
		    	// use e.keyCode
		    //if (e.keyCode == 83 && isOverlayOpen == false){
		    					// L. 62 at 18:49 - check input not in focus elsewhere -- LOOK FOR HIS JAVASCRIPT SOLUTI)ON
		    //if (e.keyCode == 83 && !isOverlayOpen && !allInputs.hasFocus() && !allTextAreas.hasFocus() ){   in jQuery !$('input textarea').is(:focus)
// I prefer to use the ~ key (192) instead of the 's' key (83)		    
		 //   if (e.keyCode == 83 && !isOverlayOpen){
		    if (e.keyCode == 192 && !isOverlayOpen){
		    	openFunction();
		    	// document.querySelector(".search-overlay").classList.add("search-overlay--active");
			// document.querySelector("body").classList.add("body-no-scroll");
		    }
	
		 //   if (e.keyCode == 27 && isOverlayOpen == true){
		    if (e.keyCode == 27 && isOverlayOpen){
		    	closeFunction(); 
		    }
		    
		};

// Search Box Overlay Key down
// Format of setting action to Anonymous JS Function from: https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onkeydown_dom
		
	// Lesson 61 @ 	5:10 Better to make sue of JS variables than making multiple calls to the DOM (slow): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/7741004#overview	
		let searchField = document.getElementById("search-term");  
	// Lesson 61 @ 11:54: set variable to help us control multiple search keydown strokes
		let typingTimer = ""; 
	
	// Lesson 62 use Keyup instead of KeyDown at 19:58:	
		//searchField.onkeydown = function() {typingLogic()};
		searchField.onkeyup = function() {typingLogic()};

	// Lesson 62: Variables used to display user input and control spinner
		let resultsDiv = document.querySelector("#search-overlay__results"); 
	// Lesson 62 at 7:49: Keeps spinner from running after EVERY Key Stroke to be less choppy. More seamless user experience.
		let isSpinnerVisible = false; 
	// Lesson 62 at 10:50 - 
		let previousValue = "";

	function typingLogic() {
		
		if(searchField.value != previousValue){			
				// setTimeout(function/method or anonymous fn, time) from: https://www.w3schools.com/jsref/met_win_settimeout.asp	1 sec = 1000 ms		
				// clearTimeOut from: https://www.w3schools.com/jsref/met_win_cleartimeout.asp	and used around 13th minute of Lesson 61
			clearTimeout(typingTimer);
			
		// if input value means IF NOT empty	
			//if(searchField.value != ""){
			if(searchField.value){
				if(!isSpinnerVisible){
					resultsDiv.innerHTML = ('<div class="spinner-loader"></div>');
					isSpinnerVisible = true;
				}
				// typingTimer = setTimeout(timeTest, 2000); 
				    typingTimer = setTimeout(getResult, 2000); 
					// Anonymous Funciton
					//setTimeout(function () {alert(`This is from anonymous function {$searchKeyStroke}`);}, 2000);				
			
			}else{
				resultsDiv.innerHTML = ""; 	
				isSpinnerVisible = false;
			}				
	
		}
		// Lesson 62 (13:41) using onKeydown it fires before this can be evaluated. So have to use onKeyup to work	
			previousValue =  searchField.value;		
	}
	
	function getResult(){		
			//Helpful testing tool: https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_text_value2
		let inputResults = document.getElementById("search-term").value;		
			//document.getElementById("search-overlay__results").innerHTML = inputResults;
			// Move this to typingLogic function before calling this getResult() (timeTest) resultsDiv.innerHTML = ('<div class="spinner-loader"></div>');
		resultsDiv.innerHTML = inputResults;	
	//Lesson 62 at 9:27:
		isSpinnerVisible = false;			 			
	}


	function openFunction() {
		//document.getElementById("demo").innerHTML = "YOU CLICKED ME!";
		//alert('function ran');
		document.querySelector(".search-overlay").classList.add("search-overlay--active");
		document.querySelector("body").classList.add("body-no-scroll");
		isOverlayOpen = true;
	}

				 
	document.querySelector(".search-overlay__close").addEventListener("click", closeFunction);
	
	function closeFunction(){
		document.querySelector(".search-overlay").classList.remove("search-overlay--active");
		document.querySelector("body").classList.remove("body-no-scroll");
		isOverlayOpen = false;
	}





    
   //import $ from 'jquery';    
    class Search {
      //1. describe and create/initiate our object  
            constructor() {
                alert('Alert from constructor in class Search!');
                // this.name = "Jane";
               // const openButton = document.getElementsByClassName("js-search-trigger");
                //this.openButton = $(".js-search-trigger");
                //this.openButton = $(".fa-search");
                
               // this.openButton = $(".search-overlay__icon");
                this.closeButton = $(".search-overlay__close");
                this.searchOverlay = $(".search-overlay");
              //We want this to run as soon as our object is born / we want our page listeners to get added to the page right away
              	this.events(); 
              	
              	
            }
            

        
        //2. List all my events (when things get clicked on)
            // on the event that this.name feels cold, respond with method openOverlay
            // create a method called events
            
           //  openButton.addEventListener("click", myScript);
            
	            events(){       
	            	//Watch for open button and close button being clicked.
	            	// select the element, jquery .on() takes event, then function/method call in response:        
	                this.openButton.on("click", this.openOverylay.bind(this));
	                this.closeButton.on("click", this.closeOverylay.bind(this));
	            }
        
        //3. Where our methods will live  (action words). 
        	

          
            openOverlay() {
                this.searchOverlay.addClass("search-overlay--active"); 
            }
            
            closeOverlay() {
                this.searchOverlay.removeClass("search-overlay--active");
            }
    }
    
  // const search = new Search()
</script>   
    
    
    
<?php wp_footer(); ?>
    </body>
</html>