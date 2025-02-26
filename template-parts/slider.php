<?php
$args = array(
    'post_type'      => 'slider',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$slider_query = new WP_Query($args);
?>

<?php if ($slider_query->have_posts()) : ?>
    <div id="carouselExampleCaptions" class="carousel slide position-relative" data-bs-ride="carousel">
        <!-- Carousel Indicators (Dots) -->
        <div class="carousel-indicators">
            <?php $slide_count = 0; ?>
            <?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $slide_count; ?>" 
                    class="<?php echo ($slide_count === 0) ? 'active' : ''; ?>" 
                    aria-label="Slide <?php echo $slide_count + 1; ?>"></button>
                <?php $slide_count++; ?>
            <?php endwhile; ?>
        </div>
        
        <div class="carousel-inner">
            <?php $slide_count = 0; ?>
            <?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
                <?php 
                    // Get the featured image (or placeholder if not available)
                    $slide_img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://via.placeholder.com/1920x1080';
                    
                    // Get the link from ACF field (assuming 'slider_link' is a single link field)
                    $slide_link = get_field('slider_link');
                    
                    // Ensure the link is a string, not an array
                    if (is_array($slide_link)) {
                        $slide_link = !empty($slide_link['url']) ? esc_url($slide_link['url']) : ''; // Get URL from array
                    } else {
                        $slide_link = esc_url($slide_link); // If it's not an array, just escape it
                    }

                    // Get the content for the paragraph (use content instead of excerpt for more text)
                    $slide_excerpt = get_the_content(); // Use full content instead of excerpt
                ?>
                <div class="carousel-item <?php echo ($slide_count === 0) ? 'active' : ''; ?>">
                    <?php if (!empty($slide_link)): ?>
                        <a href="<?php echo $slide_link; ?>" class="slider-link">
                    <?php endif; ?>
                        <img src="<?php echo esc_url($slide_img); ?>" class="d-block w-100" alt="<?php the_title(); ?>">
                        <div class="carousel-caption w-75 ">
                            <h2 class="fs-3 p-3" ><?php the_title(); ?></h2>
                            <p class="fs-4 text-center p-3" ><?php echo wp_kses_post($slide_excerpt); ?></p> <!-- Output the content of the post -->
                        </div>
                    <?php if (!empty($slide_link)): ?>
                        </a> <!-- Close the anchor tag -->
                    <?php endif; ?>
                </div>
                <?php $slide_count++; ?>
            <?php endwhile; ?>
        </div>
        <!-- Carousel Navigation (Prev/Next buttons) -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<?php endif; wp_reset_postdata(); ?>
