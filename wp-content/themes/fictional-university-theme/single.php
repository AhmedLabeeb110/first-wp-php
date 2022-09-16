<!-- creating single.php file automatically gets selected for rendering single posts -->

<?php
while (have_posts()) {
    the_post(); ?>
<h2>
    <?php the_title(); ?>
    <?the_content();?>
</h2>
<?php
}
?>