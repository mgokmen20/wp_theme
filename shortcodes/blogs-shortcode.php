<?php
// Shortcode to Fetch Blog Posts from Offenes Höchhus
function offenes_hochhus_blogs_shortcode() {
    ob_start(); // Start output buffering

    $args = array(
        'post_type'      => 'post', // Post type is 'post'
        'posts_per_page' => 6, // Show 6 blog posts
        'category_name'  => 'offenes-hochhus', // The category is 'offenes-hochhus'
    );

    $blog_query = new WP_Query($args); // Query the blog posts based on defined arguments

    if ($blog_query->have_posts()) :
        echo '<div class="row">'; // Start a row for blog posts
        while ($blog_query->have_posts()) : $blog_query->the_post();
            get_template_part('templates/content', 'blog'); // Blog post card template
        endwhile;
        echo '</div>';
    else :
        echo '<p>No blog posts available yet.</p>'; // Message if no blog posts found
    endif;

    wp_reset_postdata(); // Reset post data after the custom query

    return ob_get_clean(); // Return the buffered output
}
add_shortcode('offenes_hochhus_blogs', 'offenes_hochhus_blogs_shortcode'); // Register the shortcode
