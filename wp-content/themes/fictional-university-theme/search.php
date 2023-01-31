<?php

get_header(); 
pageBanner(array(
  'title' => 'Search Results',
  //get_search_query() Retrieves the contents of the search WordPress query variable. By default this function also escapes HTML blocks
  //esc_html() escapes HTML blocks
  //passing false inside get_search_query() will disable the default security functions
  //This is how WP recommends we write the code for better security
  'subtitle' => 'You searched for &ldquo;'. esc_html(get_search_query(false)) .'&rdquo;'
))
?> 

<!-- It is safe to echo out get_search_query() inside strings -->
<!-- <input type="text" value="<?php echo get_search_query();?>"> -->

<div class="container container--narrow page-section">
 <?php 
  if(have_posts()){
    while(have_posts()){ 
      the_post();
      // 1st Argument: Pass the main path
      // 2nd Parameter: will add the post type to the path's end usually adds argument like -event
      // for making it dynamic we have added the the get_post_type() function.
      get_template_part('template-parts/content', get_post_type());
    }
      // This function creates pagination feature
      echo paginate_links();
    } else {
      echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
    }

    // This function automatically loads the search form created under the name of searchform.php, this is a built-in function by WordPress
    get_search_form()
 ?>
</div>

<?php get_footer();

?>