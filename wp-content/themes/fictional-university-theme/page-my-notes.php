<?php
 
 // This statement checks if a user is logged in or not, the page will load 
//  if the user is logged in otherwise the user will be redirected to any page 
// we will set the redirect to
if (!is_user_logged_in()){
    wp_redirect(esc_url(site_url()));
    exit;
}

get_header();

while (have_posts()) {
    the_post();
    //This function comes from the functions.php, this function outputs the page banner.
    pageBanner();
    ?>

    <div class="container container--narrow page-section">
        <ul class="min-list link-list" id="my-notes">
           <?php 
             $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => -1,
                //This is the line that makes notes user specific
                'author' => get_current_user_id()
             ));

             while($userNotes->have_posts()){
                $userNotes->the_post(); ?>
                <!-- 
                    the_ID() - Displays the ID of the current item in the WordPress Loop.

                The "data-id" attribute is an HTML5 custom data attribute that can be used to store custom data within an HTML element. 
                This attribute can be used to store any kind of data in a key-value format, such as IDs, values, and other relevant information.
                The "data-id" attribute can be used by web developers to manipulate and retrieve the data stored within an element through JavaScript 
                or other programming languages. This attribute can also be used to make the HTML code more semantic and understandable by other developers 
                who may be working on the same project. For example, if you have a list of items, each item can have a unique identifier that can be stored 
                in the "data-id" attribute. This identifier can then be used to manipulate or retrieve information about that particular item using JavaScript 
                or other programming languages.
                -->
                <li data-id="<?php the_ID()?>">
                    <!-- 
                        Escaping for HTML attributes. 
                        esc_attr()

                        Also, passing 'readonly' as an attribute makes the input fields readonly 
                    -->
                    <input readonly class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                    <!-- 
                        Properly strips all HTML tags including script and style 
                        wp_strip_all_tags()
                    -->
                    <span class="edit-note"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content()))?></textarea>
                    <span class="update-note btn btn--blue btn-small"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>
            <?php
             }
           ?>
        </ul>
    </div>

<?php
}

get_footer();
?>