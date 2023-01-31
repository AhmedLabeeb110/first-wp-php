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