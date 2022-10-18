<!--Using the add_action function WP allow's us to pass instruction; 
    the first argument tells WP what type of function we are giving it,
    the second argument takes in the type of function we want to run
    we will need to create the custom function.
     
    wp_enqueue_scripts instructs WP to load CSS and JS files
    university_files is the function we have created.

    wp_enqueue_style - first argument takes in the CSS file name , second argument takes in the file location.

    get_stylesheet_uri function automatically loads the style.css file

    get_theme_file_uri function allows loading custom CSS files
-->

<?php
function university_files()
{ 
    // wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    // loading JS file using wp_enqueue_script function
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    // this is the process of loading google fonts
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // this is the process of loading font awesome
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts', 'university_files');

//Must be called in the theme’s functions.php file to work.
//If attached to a hook, it must be ‘after_setup_theme’.
//The ‘init’ hook may be too late for some features.

function university_features()
{
    // Shows page name on tabs
    add_theme_support('title-tag');
}

// after_setup_theme, This hook is called during each page load, after the theme is initialized. It is generally used to perform basic setup, registration, and init actions for a theme.

add_action('after_setup_theme', 'university_features');

// Pass the $query object as an argument so that it can be manipulated.
function university_adjust_queries($query){
  //is_admin() function checks if you are in the Admin dashboard
  // we will pass !is_admin(); as argument, so the posts will show only when we are on the frontend  
  //is_post_type_archive() checks the posts archive type
  // $query->is_main_query() checks if the query is a default/main query 
  if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
    //First argument - Query parameter that we want to change(in this case 'meta_key')
    //Second argument - data you want to show(in this case 'event_date')
    $query->set('meta_key', 'event_date'); 
    //Similar process for all queries.  
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $today = date('Ymd');
    $query->set('meta_query', array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
        ));
  }
}

// Fires after the query variable object is created, but before the actual query is run.
// This helps us adjust the queries(this provides a refernce to the Wordpress Query object as well) 

add_action('pre_get_posts', 'university_adjust_queries');