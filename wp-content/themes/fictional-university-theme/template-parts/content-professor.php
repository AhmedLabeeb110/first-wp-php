<div class="post-item">
<li class="professor-card__list-item">
     <a class="professor-card" href="<?php the_permalink();?>">
     <!-- the_post_thumbnail_url(); This function loads the Thumbnail Images for posts and the links to the main post where the thumbnail exists-->
      <img src="<?php the_post_thumbnail_url('professorLandscape');?>" alt="" class="professor-card__image">
      <span class="professor-card__name"><?php the_title();?></span>
     </a>
   </li>
</div>