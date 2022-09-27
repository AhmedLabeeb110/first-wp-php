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
            <!-- This function renders the custom menu we have created, pass the menu name(first argument using the associate arrays)
                 inside the function to have it working -->
            <?php 
              wp_nav_menu(array(
                'theme_location' => 'headerMenuLocation'
              ));
            ?>
          </nav>
          <div class="site-header__util">
            <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
            <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </header>
