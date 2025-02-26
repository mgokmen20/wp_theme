<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- Header Image and Title -->
<div class="row">
    <div class="col-12">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="card-img w-100" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
    </div>
</div>

<!-- Post Title -->
<div class="social-share-icons">
    <a href="#" class="social-icon facebook" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="social-icon twitter" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fab fa-twitter"></i></a>
    <a href="#" class="social-icon linkedin" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="social-icon instagram" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fab fa-instagram"></i></a>
    <a href="#" class="social-icon whatsapp" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fab fa-whatsapp"></i></a>
    <a href="#" class="social-icon email" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fas fa-envelope"></i></a>
    <a href="#" class="social-icon link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>"><i class="fas fa-link"></i></a>
    <a href="#" class="social-icon comment"><i class="fas fa-comment"></i></a> <!-- Yorum ikonu -->
</div>





<h2 class="text-center mt-5 display-4 fw-bold"><?php the_title(); ?></h2>

<!-- Lead Area -->
<?php $lead = get_post_meta(get_the_ID(), '_lead_area', true); ?>
<?php if (!empty($lead)): ?>
    <p class="lead fs-4"><?php echo esc_html($lead); ?></p>
<?php endif; ?>

<!-- Date and Author Information -->
<div class="row justify-content-between align-items-end">
    <div class="col-6 col-sm-6 col-md-6 mb-3 mb-sm-0 p-4">
        <p class="fw-lighter fs-6"><?php echo get_the_date('l, d. F Y'); ?></p>
    </div>
    <div class="col-5 col-sm-5 col-md-5 d-flex justify-content-end align-items-end p-4">
        <!-- Get Co-Authors -->
        <?php 
        if (function_exists('get_coauthors')) :
            $coauthors = get_coauthors();
            
            if (!empty($coauthors)) :
                foreach ($coauthors as $author) :
                    // Get first name and last name using get_user_meta
                    $first_name = get_user_meta($author->ID, 'first_name', true);
                    $last_name = get_user_meta($author->ID, 'last_name', true);
                    $full_name = trim($first_name . ' ' . $last_name);

                    // If full name is empty, fall back to display name
                    if (empty($full_name)) {
                        $full_name = $author->display_name;
                    }

                    // Get birthdate from ACF for the user
                    $birthdate = get_field('birthdate', 'user_' . $author->ID);

                    // Calculate age if birthdate is available
                    $age = '';
                    if ($birthdate) {
                        // Create DateTime objects
                        $birthDateObj = new DateTime($birthdate);
                        $today = new DateTime();
                        
                        // Calculate age
                        $age = $today->diff($birthDateObj)->y;
                    }
                    ?>
                    <a href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>" class="text-decoration-none d-flex link-user align-items-center">
                        <!-- Display Author Avatar -->
                        <?php echo get_avatar($author->ID, 60, '', esc_attr($full_name), array('class' => 'img-user rounded-circle me-2')); ?>
                        <!-- Display Author Name and Age -->
                        <span class="user-name fw-lighter">
                            <?php echo esc_html($full_name); ?>
                            <?php if (!empty($age)) : ?>
                                (<?php echo $age; ?>)
                            <?php endif; ?>
                        </span>
                    </a>
                <?php 
                endforeach;
            else :
                echo '<p class="text-muted">No authors found or incorrect data format.</p>';
            endif;
        else :
            echo '<p class="text-muted">Co-Authors Plus plugin not activated.</p>';
        endif;
        ?>
    </div>
</div>

<!-- Post Content -->
<div class="row">
    <div class="col">
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; else : ?>
    <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>



<?php
    if (comments_open() || get_comments_number()) :
        comments_template(); // Comments template
    endif;
?>



<?php get_footer(); ?>
