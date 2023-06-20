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
  $professor = sanitize_text_field($data['professorId']);

  // This WordPress function will let us programatically create posts from within our PHP code
  wp_insert_post(array(
    'post_type' => 'like',
    'post_status' => 'publish',
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
}

function deleteLike(){
  return 'Thanks for deleting a Like';
}