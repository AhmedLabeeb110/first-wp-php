<?php
//Don't need to close a PHP tag if your file contains of PHP only  

add_action('rest_api_init', 'universityLikeRoutes');
function universityLikeRoutes()
{
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
  ));
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ));
}

function createLike($data){

  // The current_user_can() function in WordPress checks if the current user has a specific capability. Capabilities are permissions that are assigned to users in WordPress. For example, the edit_posts capability allows users to edit posts.

  // The current_user_can() function takes two arguments:

  // The first argument is the name of the capability that you want to check.
  // The second argument is an optional object that can be used to specify the context of the check. For example, you can use this argument to check if the user has a capability on a specific post or page.
  // If the current user has the specified capability, the current_user_can() function will return true. If the current user does not have the specified capability, the function will return false.

  // if(current_user_can('publish_note')){

  // }

  // The above code is a theoretical example of what we are doing right below:

  if(is_user_logged_in()){
    $professor = sanitize_text_field($data['professorId']);

    // This WordPress function will let us programatically create posts from within our PHP code
   
    // we need to return something so from the server so that we have something to see in our JS if the user is logged in
    // if the wp_insert_post is successful, it returns the ID number of the new post it just created.


    $existQuery = new WP_Query(
      array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_professor_id',
            'compare' => '=',
            'value' => $professor
          )
        )
      )
    );
    
    if($existQuery->found_posts == 0 AND get_post_type($professor === 'professor')){
      // Create new like post
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_title' => '2nd PHP Test',
        // This is create WordPress Native Custom Fields/Meta Fields
        // This is used for creating key value pairs
        'meta_input' => array(
            //this key is matched with th ACF custom field, ACF plugin is just an extration layer between the Navtive WP Meta Fields in giving us a luxurious intuative UI
            // So luckily for us, the Advanced Custom Fields plugin matches, whatever you used for the custom field name,
            // It also uses that exact name for the key name, meaning we can use this WordPress native way of adding
            // a meta field and if we use the exact custom field name for our key, well we can just give it a value
            'liked_professor_id' => $professor
        )
        )
      );
    } else {
      die("Invalid Professor ID");
    }
   
    
  } else {
    die("Only logged in users can create like.");
  }
}

function deleteLike(){
  return 'Thanks for deleting a Like';
}