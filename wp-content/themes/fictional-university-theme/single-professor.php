<!-- creating single.php file automatically gets selected for rendering single posts -->

<?php
get_header();

while (have_posts()) {
  the_post();
  //This function comes from the functions.php, this function outputs the page banner.
  pageBanner();
  ?>

  <div class="container container--narrow page-section">



    <div class="generic-content">
      <div class="row group">

        <div class="one-third">
          <!-- the_post_thumbnail(); function creates and HTML Image Tag and pulls in the featured image -->
          <!-- Pass in the custom image size Name as an argument for loading puposes -->
          <?php the_post_thumbnail('professorLandscape'); ?>
        </div>

        <div class="two-thirds">
          <?php
          $likeCount = new WP_Query(
            array(
              'post_type' => 'like',
              'meta_query' => array(
                array(
                  'key' => 'liked_professor_id',
                  'compare' => '=',
                  'value' => get_the_ID()
                )
              )
            )
          );

          $existStatus = 'no';

          if (is_user_logged_in()) {
            $existQuery = new WP_Query(
              array(
                'author' => get_current_user_id(),
                'post_type' => 'like',
                'meta_query' => array(
                  array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => get_the_ID()
                  )
                )
              )
            );

            if ($existQuery->found_posts) {
              $existStatus = 'yes';
            }
          }


          ?>

          <!-- 
     The data-exists attribute is a custom attribute that can be used to store data on an element. 
     It is not part of the HTML standard, but is supported by most browsers. 
     The data-exists attribute is prefixed with the word "data-" to avoid conflicts with standard HTML attributes.
     The data-exists attribute can be used to store any type of data, including strings, numbers, and objects. 
     The data is stored as a key-value pair, where the key is the name of the attribute and the value is the data itself. 
    -->

          <span class="like-box" data-like="<?php echo $existQuery->posts[0]->ID;?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
            <li class="fa fa-heart-o" aria-hidden="true"></li>
            <li class="fa fa-heart" aria-hidden="true"></li>
            <!-- found_posts attribute shows the total number of posts the query found, also this property ignores pagination  -->

            <span class="like-count">
              <?php echo $likeCount->found_posts; ?>
            </span>
          </span>
          <?php the_content(); ?>
        </div>

      </div>
    </div>

    <!-- Showing related fields on the frontend from ACF  -->
    <?php
    $relatedPrograms = get_field('related_programs');
    // The print_r() function prints the information about a variable in a more human-readable way. Need to pass variable name as argument for output
  
    if ($relatedPrograms) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
      echo '<ul class="link-list min-list">';
      foreach ($relatedPrograms as $program) { ?>
        <!-- the_title() function will not work in this case, it only works inside the main WordPress loop.
         
         Pass a specific post ID that you want to render or do the best pratise of passing POST Object as an argument.
         echo get_the_title($program); -->
        <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
        <?php
      }
      echo '</ul>';
    }

    ?>
  </div>
  <?php
}

get_footer();
?>