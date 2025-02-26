<?php
// Blog post Card
?>

<div class="blog-card mb-4">
    <div class="row g-0 flex-md-column flex-row">
        <div class="col-md-12 col-5">
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>">
        </div>
        <div class="col-md-12 col-7 d-flex align-items-center">
            <div class="card-body">
                <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-reset">
                    <h5 class="card-title text-center fs-4"><?php the_title(); ?></h5>
                </a>
                <p class="card-text mt-2"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
        </div>
    </div>
</div>
