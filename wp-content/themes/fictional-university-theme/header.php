<!DOCTYPE html>
<!--This function automatically detects the language type on a website-->
<html <?php language_attributes();?>>

<head>
    <!--This function automatically determines the type of characters being used on a website-->
    <meta charset="<?php bloginfo('charset');?>">
    <!-- This meta tag tells devices to use their native size -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This let's WP be in control of the head section -->
    <?php wp_head(); ?>

</head> 
<!-- This function gives all sorts of useful information on classes, IDs, etc.l-->
<body <?php body_class();?>>
<header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left">
          <!-- setup homepage URL -->
          <a href="<?php echo site_url()?>"><strong>Fictional</strong> University</a>
        </h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <ul>
              <!-- set up url best practise -->
              <!-- is_page(); function takes in the slug as argument and confirms the ID of a page -->
              <!-- This condition renders the color of the clicked page link based on this condition -->
              <!-- passing 0 as argument in the wp_get_post_parent_id(); will automatically look for the id of the opened page  -->
              <!-- Then compare with the parent page ID -->
              <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 18) echo 'class="current-menu-item"'?>><a href="<?php echo site_url('/about-us')?>">About Us</a></li>
              <li <?php if(get_post_type() == 'program') echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link('program');?>">Programs</a></li>
              <li <?php if(get_post_type() == 'event' OR is_page('past-events')) echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
              <li><a href="#">Campuses</a></li>
              <!-- Retrieves the post type of the current post or of a given post. -->
              <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"'?>><a href="<?php echo site_url('/blog');?>">Blog</a></li>
            </ul>
          </nav>
          <div class="site-header__util">
            <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
            <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </header>
