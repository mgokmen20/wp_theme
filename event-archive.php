<?php
/**
 * Template Name: Event Archive
 */
get_header();
?>

<div class="container mt-5">
    <h1 class="mb-4">Alle Veranstaltungen</h1>
    
    <div class="row">
        <?php
        $args = array(
            'post_type'      => 'event', // Just bring events
            'posts_per_page' => 6, 
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        );

        $event_query = new WP_Query($args);

        if ($event_query->have_posts()) :
            while ($event_query->have_posts()) : $event_query->the_post();
                get_template_part('templates/content', 'event'); 
            endwhile;
        else :
            echo "<p>Es gibt noch keine Veranstaltungen.</p>";
        endif;
        wp_reset_postdata();
        ?>
    </div>

    <!-- Page design -->
    <div class="text-center mt-4">
        <?php
        echo paginate_links(array(
            'total' => $event_query->max_num_pages,
            'prev_text' => '&laquo; letzte',
            'next_text' => 'Nächste &raquo;',
        ));
        ?>
    </div>
</div>

<?php get_footer(); ?>
