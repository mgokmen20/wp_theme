<?php
// Shortcode to Fetch Events from Offenes Höchhus
function offenes_hochhus_events_shortcode() {
    ob_start(); // Start output buffering

    $args = array(
        'post_type'      => 'event', // Post type is 'event'
        'posts_per_page' => 6, // Show 6 events
        'tax_query'      => array(
            array(
                'taxonomy' => 'event_category', // Taxonomy is 'event_category'
                'field'    => 'slug', // Search by category slug
                'terms'    => 'offenes-hochhus', // The category is 'offenes-hochhus'
            ),
        ),
    );

    $events_query = new WP_Query($args); // Query the events based on defined arguments

    if ($events_query->have_posts()) :
        echo '<div class="row">'; // Start a row for events
        while ($events_query->have_posts()) : $events_query->the_post();
            get_template_part('templates/content', 'event'); // Event card template
        endwhile;
        echo '</div>';
    else :
        echo '<p>No events available yet.</p>'; // Message if no events found
    endif;

    wp_reset_postdata(); // Reset post data after the custom query

    return ob_get_clean(); // Return the buffered output
}
add_shortcode('offenes_hochhus_events', 'offenes_hochhus_events_shortcode'); // Register the shortcode
