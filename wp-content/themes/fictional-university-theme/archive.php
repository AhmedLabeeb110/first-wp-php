<?php

get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">

    <!-- is_category(); Determines whether the query is for an existing category archive page. -->
    <!-- is_author(); Determines whether the query is for an existing author archive page. -->
    <!-- single_cat_title(); Display or retrieve page title for category archive. -->
    <!-- the_author(); Displays the name of the author of the current post. -->

    <!-- the_archive_title(); enables all types of archives, for eg date, author and category based archives 
         Formally
    -->
    <!-- the_archive_description(); function enables description of archives such as author, category, etc. description -->
      <?php
      // if (is_category()) {
      //   single_cat_title();
      // }
      // if(is_author()){
      //   echo "Posts By "; the_author();
      // }
      the_archive_title();
      ?>
    </h1>
    <div class="page-banner__intro">
      <p><?php the_archive_description();?></p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
 <?php 
  while(have_posts()){ 
    the_post(); ?>
    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

      <div class="metabox">
        <!-- 1. This function creates a link with Archive of all the posts by an author. -->
        <!-- 2. This function shows the date and time when the blogs were posted, the format can be manipulated by passing arguments inside the functions -->
        <!-- 3. This function gets the category list of the post, if the post is posted in multiple categories, passing an argument like and, comma, etc. will show the categories separately -->
        <p>Posted by <?php the_author_posts_link();?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ')?></p>
      </div>

      <div class="generic-content">
        <!-- This function shows an extract/excerpt of the main content -->
        <?php the_excerpt();?>
        <p><a class="btn btn--blue" href="<?php the_permalink();?>">Continue Reading &raquo;</a></p>
      </div>
    </div>
   <?php
  }
  // This function creates pagination feature
  // echo paginate_links();
 ?>

</div>

<?php get_footer();

?>