<?php get_header(); ?>






<div class="container">
    

<div class="row">
    <div class="col-12">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="card-img w-100" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
    </div>
</div>
    
    <div class="row">
        <div class="col-md-6">
            <h2>Offenes Höchhus Blogbeiträge</h2>
            <?php
            // Blog 
            $blog_args = array(
                'post_type'      => 'post',  // Blog
                'posts_per_page' => 5,
                'category_name'  => 'offenes-hochhus' //  Blog Category slug
            );

            $blog_query = new WP_Query($blog_args);

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                    <div class="blog-post mb-3">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo "<p>Es gibt noch keine Blogbeiträge in dieser Kategorie.</p>";
            endif;
            ?>
        </div>

        <div class="col-md-6">
            <h2>Offenes Höchhus-Veranstaltungen</h2>
            <?php
            // Events
            $event_args = array(
                'post_type'      => 'event',  // Special post "event" type
                'posts_per_page' => 5,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'event_category', // Event category taxonomy
                        'field'    => 'slug',
                        'terms'    => 'offenes-hochhus' // Event category slug
                    ),
                ),
            );

            $event_query = new WP_Query($event_args);

            if ($event_query->have_posts()) :
                while ($event_query->have_posts()) : $event_query->the_post(); ?>
                    <div class="event-item mb-3">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>
                            📅 Tarih: <?php echo get_post_meta(get_the_ID(), 'event_date', true); ?><br>
                            ⏰ Saat: <?php echo get_post_meta(get_the_ID(), 'start_zeit', true); ?> - <?php echo get_post_meta(get_the_ID(), 'ende_zeit', true); ?>
                        </p>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo "<p>In dieser Kategorie gibt es noch keine Veranstaltungen.</p>";
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
