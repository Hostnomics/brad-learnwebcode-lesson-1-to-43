<?php

/*
    Plugin Name: Our Test Plugin
    Description: Word Counter Tutorial Plugin
    Version: 1.0
    Author: Ian
    Author URI: https://www.hostnomics.com 
*/



class WordCountAndTimePlugin {
  function __construct() {
    add_action('admin_menu', array($this, 'adminPage'));
    add_action('admin_init', array($this, 'settings'));
  }
 
  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');
    
//Drop Down    
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    // register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));      
    // L119 (15:41): https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880736?start=270#overview
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));  // LL119 (16th) - create custom santizeLocation function outside of this settings function
    
//Text Field L119 @ (4:38)
    add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));   
    
// Check Box L119 @ (8:17) - Word Count
    // add_settings_field('wcp_wordcount', 'Word count', array($this, 'wordcountHTML'), 'word-count-settings-page', 'wcp_first_section');
    add_settings_field('wcp_wordcount', 'Word count', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_wordcount')); //L119 (13:17): 
    register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));    
    
// Check Box L119 @ (11:22) - Character Count
    // add_settings_field('wcp_charactercount', 'Character count', array($this, 'charactercountHTML'), 'word-count-settings-page', 'wcp_first_section');
    add_settings_field('wcp_charactercount', 'Character count', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_charactercount')); //L119 (13:17)
    register_setting('wordcountplugin', 'wcp_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));    
    
  
// Check Box L119 @ (11:22) - Read Time
    // add_settings_field('wcp_readtime', 'Read Time', array($this, 'readtimeHTML'), 'word-count-settings-page', 'wcp_first_section');
                                                                                                                        // this array passes the value into our HTML callback function
    add_settings_field('wcp_readtime', 'Read Time', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_readtime')); //L119 (13:17) - add 5th argument set 'theName' as field name
    register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));         
      
  }
  
  
 
    function sanitizeLocation($input) { // when sanitizeLocation is called, WP will pull in the value that WP is trying to save
        if ($input != '0' AND $input != '1'){
            // add_settings_error(1, 2, 3);
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end');
        //Get the previously saved value for wcp_location, which may be default '0'
            return get_option('wcp_location');
        } 
        
        //If input IS either 0 or 1:
        return $input;
    }  
  

    function checkboxHTML($args){    ?>
        <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1') ?>>    
<?php }


/* L119 (12:14) - Replace repetitive checkbox functions with one generic checkboxHTML function
      function readtimeHTML() { ?>
          <input type="checkbox" name="wcp_readtime" value="1" <?php checked(get_option('wcp_readtime'), '1') ?>>      
     <?php }    
    
      function charactercountHTML() { ?>
          <input type="checkbox" name="wcp_charactercount" value="1" <?php checked(get_option('wcp_charactercount'), '1') ?>>      
     <?php }
        
    
      function wordcountHTML() { ?>
          <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option('wcp_wordcount'), '1') ?>>      <?php // WP checked method L119 (10:20) checked(a, b) ?>
     <?php }
*/
  
  function headlineHTML() { ?>
      <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option("wcp_headline")) ?>">
 <?php }


  function locationHTML() { ?>
    <select name="wcp_location">                                <!-- L118 @ (16:32) Field Name Created in register_settings -->
      <option value="0" <?php selected(get_option('wcp_location'), "0") ?>>Beginning of post</option>
      <option value="1" <?php selected(get_option('wcp_location'), "1") ?>>End of post</option>
    </select>
  <?php }

  function adminPage() {
    add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));
  }

  function ourHTML() { ?>
    <div class="wrap">
      <h1>Word Count Settings</h1>
      <form action="options.php" method="POST">
      <?php
                    //paramter takes name of the field group we set in register_settings() above in our settings() function.
        settings_fields('wordcountplugin');                     //L118 @ (17:40) - THIS allows you to submit & save the input via our POST route         
        do_settings_sections('word-count-settings-page');       //L118 @ (14:45) https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/learn/lecture/26880730#overview
        submit_button();                                        //L118 @ (15:37)
      ?>
      </form>
    </div>
  <?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
