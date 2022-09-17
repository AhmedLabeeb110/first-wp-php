<!-- creating page.php file automatically gets selected for displaying new pages -->

<?php
get_header();

while (have_posts()) {
    the_post(); ?>
<h2>
    <h1>This is a custom page</h1>
    <?php the_title(); ?>
    <?the_content();?>
</h2>
<?php
}

get_footer();
?>