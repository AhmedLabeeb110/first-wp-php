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

function createLike(){
  return 'Thanks for creating a Like';
}

function deleteLike(){
  return 'Thanks for deleting a Like';
}