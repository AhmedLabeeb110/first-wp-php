<?php

// Important note -  Removed all HTML comments because of errors.

// Using the add_action function WP allow's us to pass instruction; 
// the first argument tells WP what type of function we are giving it,
// the second argument takes in the type of function we want to run
// we will need to create the custom function.

// wp_enqueue_scripts instructs WP to load CSS and JS files
// university_files is the function we have created.

// wp_enqueue_style - first argument takes in the CSS file name , second argument takes in the file location.

// get_stylesheet_uri function automatically loads the style.css file

// get_theme_file_uri function allows loading custom CSS files

// $args as in arguments, we can name the arguments anything we want. In this case, we are passing some associative arrays as arguments by passing $args. 
// $args = NULL, this makes the arguments optional



// This built-in Wordpress Function Retrieves the path of a file in the theme.

require get_theme_file_path('/inc/search-route.php');

function university_custom_rest()
{
  // This function takes in three arguments
  // First argument: the post type you want ot customize
  // Second argument: Whatever you want ot name the new field
  // Third argument: The data you want to show. In this case, get_the_author(); (Retrieves the author of the current post).
  register_rest_field('post', 'authorName', array(
    'get_callback' => function () { return get_the_author(); }
  ));
}

// Fires when preparing to serve a REST API request.
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL)
{
  if (!$args['title']) {
    $args['title'] = get_the_title();
  }

  if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }

  if (!$args['photo']) {
    if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }


?>
<div class="page-banner">

  <!-- Create a variable called, run the get_field function inside it, 
     and pass the custom field name as an argument that you want to show on the front-end
     $pageBannerImage = get_field('page_banner_background_image');

     then echo the $pageBannerImage['url'](this is echoed out as array - url is one of the array values, the url will give us a path to the image)
     
     To echo a specific sized image: $pageBannerImage['sizes']['pageBanner']
 -->
  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">
      <!-- echo the array value that you want to show on the front-end of your website -->
      <?php echo $args['title'] ?>
    </h1>
    <div class="page-banner__intro">
      <p>
        <?php echo $args['subtitle'] ?>
      </p>
    </div>
  </div>
</div>
<?php }


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
  // Localize a script. This WP function helps us to make a specific JS file flexible 
  // 1st argument: the name of the JavaScript file you want to make flexible
  // 2nd argument: make up a variable name(this will create a JS variable) 
  // 3rd argument: array of data that you want to pass inside the JS file, this will show as Object in JS.  
  wp_localize_script(
    'main-university-js',
    'universityData',
    array(
      // Retrieves the URL for a given site where WordPress application files (e.g. wp-blog-header.php or the wp-admin/ folder) are accessible. In simple words this function returns the Wordpress Local Website URL
      //Name the property as you like, then pass the get_site_url() as the value
      'root_url' => get_site_url(),
      // This is how we create nonce
      // wp_create_nonce creates a cryptographic token tied to a specific action, user, user session, and window of time.
      'nonce' => wp_create_nonce('wp_rest')
    )
  );
}

add_action('wp_enqueue_scripts', 'university_files');

//Must be called in the theme’s functions.php file to work.
//If attached to a hook, it must be ‘after_setup_theme’.
//The ‘init’ hook may be too late for some features.

function university_features()
{
  // Shows page name on tabs
  add_theme_support('title-tag');
  // Enables the Post Thumbnail option for default post types 
  add_theme_support('post-thumbnails');
  // This function allows us to create resized images. 
  //For the first argument name the image, second and third define the size(width x height) that you want to convert your image, third do you want to crop the image or not 

  // Tutorial No. 42 - Usually Worpress cuts towards the center. but this can be controlled as well, but this is not the best practise:
  // add_image_size('professorLandscape', 400, 260, array('left', 'top'));          
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}

// after_setup_theme, This hook is called during each page load, after the theme is initialized. It is generally used to perform basic setup, registration, and init actions for a theme.

add_action('after_setup_theme', 'university_features');

// Pass the $query object as an argument so that it can be manipulated.
function university_adjust_queries($query)
{

  if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  //is_admin() function checks if you are in the Admin dashboard
  // we will pass !is_admin(); as argument, so the posts will show only when we are on the frontend  
  //is_post_type_archive() checks the posts archive type
  // $query->is_main_query() checks if the query is a default/main query 
  if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
    //First argument - Query parameter that we want to change(in this case 'meta_key')
    //Second argument - data you want to show(in this case 'event_date')
    $query->set('meta_key', 'event_date');
    //Similar process for all queries.  
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $today = date('Ymd');
    $query->set(
      'meta_query',
      array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
      )
    );
  }
}

// Fires after the query variable object is created, but before the actual query is run.
// This helps us adjust the queries(this provides a refernce to the Wordpress Query object as well) 

add_action('pre_get_posts', 'university_adjust_queries');

// Redirect subscriber accounts out of admin dashboard and onto homepage
// first argument - Fires as an admin screen or script is being initialized.
// second argument - The function we want to call 
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend(){
  //wp_get_current_user()
  //Retrieves the current user object.
  $ourCurrentUser = wp_get_current_user();
  //count method returns the number of elements in an array:
  if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
    wp_redirect(site_url('/'));
    //exit/exit() — Output a message and terminate the current script
    exit;
  }
};

//wp_loaded This hook is fired once WP, all plugins, and the theme are fully loaded and instantiated.

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
  //wp_get_current_user()
  //Retrieves the current user object.
  $ourCurrentUser = wp_get_current_user();
  //count method returns the number of elements in an array:
  if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
    // the commented code below no longer works.
    // show_admin_bar() - Sets the display status of the admin bar.
    // show_admin_bar(false);
    add_filter('show_admin_bar', '__return_false');
  }
};

// Customize Login Screen
// Wordpress Function
// 1st Argument: name of the value or object that you want to customize, filter or change in some way. 
// 2nd Argument: a function that returns whatever you want to use insead. 
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
  return esc_url(site_url('/'));
}

//Customizing the Login page

//login_enqueue_scripts is the proper hook to use when enqueuing items that are meant to appear on 
// the login page. Despite the name, it is used for enqueuing both scripts and styles, on all login
// and registration related screens.

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS(){
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  // this is the process of loading font awesome
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

//Change the login page website title
add_filter('login_headertitle', 'ourLoginTile');
function ourLoginTile()
{
  return get_bloginfo('name');
}

//Force Note Posts To Be Private

//'wp_insert_post_data' is the name of the filter hook we want to use, this hook filters slashed post data just before it is inserted into the database.

//The wp_insert_post_data filter allows you to modify the post data that 
//is being inserted into the database. You can add, remove or modify any 
//of the post data, including the post title, post content, post excerpt,
// post status, post author, post category, post tags, etc.

//passing $data as argument passes all the post data
add_filter('wp_insert_post_data', 'makeNotePrivate');

// This code will be applicable for all posts if no conditions are passed properly
// function makeNotePrivate($data){
//   $data['post_status'] = "private";
//   return $data;
// }

//$data is an array WordPress puts together
function makeNotePrivate($data){
  if($data['post_type'] == 'note'){
    // // Gets the number of posts a user has written. count_user_posts()
    // if(count_user_posts(get_current_user_id(), 'note') > 4){

    // };
    //The function is like sanitize_text_field() , but preserves new lines (\n) and other whitespace, which are legitimate input in textarea elements.
    // Sanitizes a multiline string from user input or from the database.
     $data['post_content'] = sanitize_textarea_field($data['post_content']);
     $data['post_title'] = sanitize_textarea_field($data['post_title']);
  }

  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){
    $data['post_status'] = "private"; 
  }
  return $data;
}