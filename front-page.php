<?php get_header(); ?>



<!-- Bootstrap Carousel -->
<?php get_template_part('template-parts/slider'); ?>


<!-- Events Section -->
<?php

$event_category_slug = 'event'; // we can change this to the slug of the event category

// Fetch upcoming events sorted by event_date and event_time
$args = array(
    'post_type'      => 'event',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'     => 'event_date',
            'compare' => 'EXISTS',
        ),
        array(
            'key'     => 'start_zeit',
            'compare' => 'EXISTS',
        ),
    ),
    'tax_query'      => array(
        array(
            'taxonomy' => 'event_category', 
            'field'    => 'slug',
            'terms'    => 'live',                    //! Category slug (Update this part)
        ),
    ),
    'orderby'        => 'ASC',
);

$events_query = new WP_Query($args);

if ($events_query->have_posts()) :
    // Fetch all events and store them in an array for custom sorting
    $events = array();
    while ($events_query->have_posts()) : $events_query->the_post();
        $event_date = get_post_meta(get_the_ID(), 'event_date', true);
        $start_time = get_post_meta(get_the_ID(), 'start_zeit', true);
        $end_time = get_post_meta(get_the_ID(), 'ende_zeit', true);

        // Convert event date and time to timestamp for sorting
        $event_timestamp = strtotime($event_date . ' ' . $start_time);
        
        // Store the event with timestamp for sorting later
        $events[] = array(
            'post'           => get_the_ID(),
            'event_date'     => $event_date,
            'start_time'     => $start_time,
            'end_time'       => $end_time,
            'event_timestamp'=> $event_timestamp,
            'event_title'    => get_the_title() // Store event title for later use
        );
    endwhile;

    // Custom sorting: Sort events by date first, then by time if dates are the same
    usort($events, function($a, $b) {
        return $a['event_timestamp'] <=> $b['event_timestamp'];
    });

    ?>
    <div class="container mt-5" style="position: relative; z-index: 0;">
        <div class="row">
            <div class="col-12">
                <div class="event-list">
                    <?php 
                    // Loop through the sorted events array and display them
                    foreach ($events as $event) :
                        $event_post = get_post($event['post']);
                        setup_postdata($event_post);
                        
                        $event_date = get_post_meta($event['post'], 'event_date', true);
                        $start_time = get_post_meta($event['post'], 'start_zeit', true);
                        $end_time = get_post_meta($event['post'], 'ende_zeit', true);
                        $event_timestamp = strtotime($event_date . ' ' . $start_time);

                        $event_day = date('d', $event_timestamp);
                        $event_year = date('Y', $event_timestamp);
                        
                        $months_de = array(
                            "January" => "Januar",
                            "February" => "Februar",
                            "March" => "März",
                            "April" => "April",
                            "May" => "Mai",
                            "June" => "Juni",
                            "July" => "Juli",
                            "August" => "August",
                            "September" => "September",
                            "October" => "Oktober",
                            "November" => "November",
                            "December" => "Dezember"
                        );
                        
                        $event_month = $months_de[date('F', $event_timestamp)];
                        $event_start_time = date('H:i', strtotime($start_time));
                        $event_end_time = date('H:i', strtotime($end_time));
                    ?>
                        <div class="event-card p-3 mb-3 bg-light rounded shadow-sm position-relative hover-effect">
                            <div class="row align-items-center g-0 h-100">
                                <div class="col-4 col-md-3">
                                    <div class="event-date text-center p-2 rounded h-100">
                                        <span class="d-block fs-4 fw-bold"><?php echo esc_html($event_day); ?></span>
                                        <span class="d-block"><?php echo esc_html($event_month); ?></span>
                                        <span class="d-block"><?php echo esc_html($event_year); ?></span>
                                    </div>
                                </div>
                                <div class="col-8 col-md-9 ps-3 h-100">
                                    <div class="d-flex flex-column justify-content-center h-100">
                                        <a href="<?php echo get_permalink($event['post']); ?>" class="stretched-link text-reset text-decoration-none"></a>
                                        <h3 class="event-title mb-2"><?php echo esc_html($event['event_title']); ?></h3>
                                        <div class="event-info d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center text-secondary">
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-clock me-2"></i><?php echo esc_html($event_start_time); ?> - <?php echo esc_html($event_end_time); ?> Uhr
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt me-2"></i><?php echo esc_html(get_post_meta($event['post'], 'hauptort', true)); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php
wp_reset_postdata();
endif;
?>
<!-- Event Location Ended -->










<!-- Card Group Template -->
<div class="row mt-4 ms-1">
  <?php
  // Fetch the latest 3 posts from a specific category
  $args = array(
      'category_name'  => 'live',       //! Replace with your category slug
      'posts_per_page' => 3,
      'post_status'    => 'publish',
  );

  $latest_posts = new WP_Query($args);

  if ($latest_posts->have_posts()) :
      while ($latest_posts->have_posts()) : $latest_posts->the_post();
          // Get the post thumbnail URL
          $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  ?>
          <div class="col-md-4 mb-4">
              <div class="card h-100">
                  <div class="row g-0 flex-md-column flex-row h-100">
                      <!-- Image Section -->
                        <div class="col-md-12 col-5 card-thumbnails">
                          <img src="<?php echo esc_url($thumbnail_url); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>">
                        </div>
                      <!-- Title Section -->
                      <div class="col-md-12 col-7 d-flex align-items-center">
                          <div class="card-body">
                              <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-reset">
                                  <h5 class="card-title text-center fs-4"><?php the_title(); ?></h5>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  <?php
      endwhile;
      wp_reset_postdata();
  endif;
  ?>
</div>
<!-- Ended cards -->







<!-- Section 2-->

    <!-- Image Area -->


    <div class="text-center position-relative">
      <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/Politpodium-BVG-Reform-800x533.jpg" class="w-100" alt="...">
      <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50">
        <h2 class="card-title text-white fw-bold fs-1">Lorem ipsum dolor sit amet.</h2>
        <p class="card-text text-white fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic neque dolores deleniti ducimus et adipisci unde culpa quaerat non? Provident!</p>
      </div>
    </div>
    <button class="btn w-100 btn-bar">Claim</button>
    

    
  <!-- Events Section -->
<?php

$event_category_slug = 'event'; // we can change this to the slug of the event category

// Fetch upcoming events sorted by event_date and event_time
$args = array(
    'post_type'      => 'event',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'     => 'event_date',
            'compare' => 'EXISTS',
        ),
        array(
            'key'     => 'start_zeit',
            'compare' => 'EXISTS',
        ),
    ),
    'tax_query'      => array(
        array(
            'taxonomy' => 'event_category', 
            'field'    => 'slug',
            'terms'    => array('offenes-hochhus','digitales-wissen'),                    //! Category slug (Update this part)
            
        ),
    ),
    'orderby'        => 'ASC',
);

$events_query = new WP_Query($args);

if ($events_query->have_posts()) :
    // Fetch all events and store them in an array for custom sorting
    $events = array();
    while ($events_query->have_posts()) : $events_query->the_post();
        $event_date = get_post_meta(get_the_ID(), 'event_date', true);
        $start_time = get_post_meta(get_the_ID(), 'start_zeit', true);
        $end_time = get_post_meta(get_the_ID(), 'ende_zeit', true);

        // Convert event date and time to timestamp for sorting
        $event_timestamp = strtotime($event_date . ' ' . $start_time);
        
        // Store the event with timestamp for sorting later
        $events[] = array(
            'post'           => get_the_ID(),
            'event_date'     => $event_date,
            'start_time'     => $start_time,
            'end_time'       => $end_time,
            'event_timestamp'=> $event_timestamp,
            'event_title'    => get_the_title() // Store event title for later use
        );
    endwhile;

    // Custom sorting: Sort events by date first, then by time if dates are the same
    usort($events, function($a, $b) {
        return $a['event_timestamp'] <=> $b['event_timestamp'];
    });

    ?>
    <div class="container mt-5 mb-5" style="position: relative; z-index: 0;">
        <div class="row">
            <div class="col-12">
                <div class="event-list">
                    <?php 
                    // Loop through the sorted events array and display them
                    foreach ($events as $event) :
                        $event_post = get_post($event['post']);
                        setup_postdata($event_post);
                        
                        $event_date = get_post_meta($event['post'], 'event_date', true);
                        $start_time = get_post_meta($event['post'], 'start_zeit', true);
                        $end_time = get_post_meta($event['post'], 'ende_zeit', true);
                        $event_timestamp = strtotime($event_date . ' ' . $start_time);

                        $event_day = date('d', $event_timestamp);
                        $event_year = date('Y', $event_timestamp);
                        
                        $months_de = array(
                            "January" => "Januar",
                            "February" => "Februar",
                            "March" => "März",
                            "April" => "April",
                            "May" => "Mai",
                            "June" => "Juni",
                            "July" => "Juli",
                            "August" => "August",
                            "September" => "September",
                            "October" => "Oktober",
                            "November" => "November",
                            "December" => "Dezember"
                        );
                        
                        $event_month = $months_de[date('F', $event_timestamp)];
                        $event_start_time = date('H:i', strtotime($start_time));
                        $event_end_time = date('H:i', strtotime($end_time));
                    ?>
                        <div class="event-card p-3 mb-3 bg-light rounded shadow-sm position-relative hover-effect">
                            <div class="row align-items-center g-0 h-100">
                                <div class="col-4 col-md-3">
                                    <div class="event-date text-center p-2 rounded h-100">
                                        <span class="d-block fs-4 fw-bold"><?php echo esc_html($event_day); ?></span>
                                        <span class="d-block"><?php echo esc_html($event_month); ?></span>
                                        <span class="d-block"><?php echo esc_html($event_year); ?></span>
                                    </div>
                                </div>
                                <div class="col-8 col-md-9 ps-3 h-100">
                                    <div class="d-flex flex-column justify-content-center h-100">
                                        <a href="<?php echo get_permalink($event['post']); ?>" class="stretched-link text-reset text-decoration-none"></a>
                                        <h3 class="event-title mb-2"><?php echo esc_html($event['event_title']); ?></h3>
                                        <div class="event-info d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center text-secondary">
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-clock me-2"></i><?php echo esc_html($event_start_time); ?> - <?php echo esc_html($event_end_time); ?> Uhr
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt me-2"></i><?php echo esc_html(get_post_meta($event['post'], 'hauptort', true)); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php
wp_reset_postdata();
endif;
?>
<!-- Event Location Ended -->

<!-- Section 2 finished -->


<!-- Section 3 Blau-->

    <!-- Image Area -->
<div class="text-center position-relative">
      <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/steffisburger sagt ja.jpg" class="w-100" alt="...">
      <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50">
        <h2 class="card-title text-white fw-bold fs-1">Lorem ipsum dolor sit amet.</h2>
        <p class="card-text text-white fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic neque dolores deleniti ducimus et adipisci unde culpa quaerat non? Provident!</p>
      </div>
  </div>

    <!-- Text Below Button -->
<button class="btn w-100 btn-bar-blue">Claim</button>
    
<!-- Card Group Template -->
<div class="row mt-4 ms-1">
  <?php
  // Fetch the latest 3 posts from a specific category
  $args = array(
      'category_name'  => 'generationenforum',       //! Replace with your category slug
      'posts_per_page' => 3,
      'post_status'    => 'publish',
  );

  $latest_posts = new WP_Query($args);

  if ($latest_posts->have_posts()) :
      while ($latest_posts->have_posts()) : $latest_posts->the_post();
          // Get the post thumbnail URL
          $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  ?>
          <div class="col-md-4 mb-4">
              <div class="card h-100">
                  <div class="row g-0 flex-md-column flex-row h-100">
                      <!-- Image Section -->
                        <div class="col-md-12 col-5 card-thumbnails">
                          <img src="<?php echo esc_url($thumbnail_url); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>">
                        </div>
                      <!-- Title Section -->
                      <div class="col-md-12 col-7 d-flex align-items-center">
                          <div class="card-body">
                              <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-reset">
                                  <h5 class="card-title text-center fs-4"><?php the_title(); ?></h5>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  <?php
      endwhile;
      wp_reset_postdata();
  endif;
  ?>
</div>
<!-- Ended cards -->

<!-- Section 3 finished -->


<!-- Section 4-->

    <!-- Image Area -->
    <div class="text-center position-relative">
      <div class="parallax parallax-effect" style="background-image: url('<?php bloginfo( 'template_directory' ); ?>/assets/img/OffenesHochhus.jpg'); background-size: cover; background-attachment: fixed; background-position: center; height: 800px;">
        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50" style="height: 100%;">
          <h2 class="card-title text-white fw-bold fs-1 text-center">Begegnungszentrum Offenes Höchhus <br> von und für alle!</h2>
          <p class="card-text text-white fs-3 mt-4 p-4">Öffnungzeiten <br> Mo, Mi, Do : 9-17 Uhr <br> Di und Fr :9 - 22 Uhr <br> Sa : 10 - 16 Uhr</p>
        </div>
      </div>
    </div>
    
    <div class="position-relative text-center" style="background-color: #6c1611; height: 100px; margin-bottom: 30px;">
      <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/LogoHöchhusWeiss.png" alt="" style="height: 100px;" class="img-fluid">
    </div>
    

<!-- Card Group Template -->
<div class="row mt-4 ms-1">
  <?php
  // Fetch the latest 3 posts from a specific category
  $args = array(
      'category_name'  => 'politpodien',       //! Replace with your category slug
      'posts_per_page' => 3,
      'post_status'    => 'publish',
  );

  $latest_posts = new WP_Query($args);

  if ($latest_posts->have_posts()) :
      while ($latest_posts->have_posts()) : $latest_posts->the_post();
          // Get the post thumbnail URL
          $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  ?>
          <div class="col-md-4 mb-4">
              <div class="card h-100">
                  <div class="row g-0 flex-md-column flex-row h-100">
                      <!-- Image Section -->
                        <div class="col-md-12 col-5 card-thumbnails">
                          <img src="<?php echo esc_url($thumbnail_url); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>">
                        </div>
                      <!-- Title Section -->
                      <div class="col-md-12 col-7 d-flex align-items-center">
                          <div class="card-body">
                              <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-reset">
                                  <h5 class="card-title text-center fs-4"><?php the_title(); ?></h5>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  <?php
      endwhile;
      wp_reset_postdata();
  endif;
  ?>
</div>
<!-- Ended cards -->
<!-- Section 4 finished -->


<!-- Section 5-->

    <!--  Freiwilligenarbeit Image Area -->
    <div class="text-center position-relative"> 
  <a href="/freiwilligenarbeit">
    <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/Politpodium-BVG-Reform-800x533.jpg" class="w-100" alt="...">
  
  <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50">
    <h2 class="card-title text-white fw-bold fs-1 text-center mb-3">Freiwilligenarbeit</h2>
    <p class="card-text text-white fs-6 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic neque dolores deleniti ducimus et adipisci unde culpa quaerat non? Provident!</p>
  </div></a>
</div>
<!-- Button with Link -->
<a href="/freiwilligenarbeit" class="btn w-100 btn-bar">Claim</a>

  

  
<!-- Card Group Template -->
<div class="row mt-4 ms-1">
  <?php
  // Fetch the latest 3 posts from a specific category
  $args = array(
      'category_name'  => 'politpodien',       //! Replace with your category slug
      'posts_per_page' => 3,
      'post_status'    => 'publish',
  );

  $latest_posts = new WP_Query($args);

  if ($latest_posts->have_posts()) :
      while ($latest_posts->have_posts()) : $latest_posts->the_post();
          // Get the post thumbnail URL
          $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  ?>
          <div class="col-md-4 mb-4">
              <div class="card h-100">
                  <div class="row g-0 flex-md-column flex-row h-100">
                      <!-- Image Section -->
                        <div class="col-md-12 col-5 card-thumbnails">
                          <img src="<?php echo esc_url($thumbnail_url); ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>">
                        </div>
                      <!-- Title Section -->
                      <div class="col-md-12 col-7 d-flex align-items-center">
                          <div class="card-body">
                              <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-reset">
                                  <h5 class="card-title text-center fs-4"><?php the_title(); ?></h5>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  <?php
      endwhile;
      wp_reset_postdata();
  endif;
  ?>
</div>
<!-- Ended cards -->
<!-- Section 5 finished -->



<!-- Section 6 Digital Wissen-->
<!-- Image Area -->
<div class="position-relative text-center" style="margin-top: 30px;">
  <!-- Image -->
  <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/Digitales-Wissen.jpg" class="img-fluid w-100 img-header" alt="...">
  
  <!-- Overlay -->
  <div class="overlay-green position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4">
    
    <a href="/digitale-teilhabe"><button type="button" class="btn btn-lg btn-Digitales-type1">Digitales Teilhabe</button></a>
  </div>
</div>


<div class="position-relative text-center" style="background-color: #50701D; height: 100px; margin-bottom:5px;">
  <div class="container-fluid px-5 d-flex justify-content-between align-items-center h-100">
    <button type="button" class="btn btn-Digitales-type2 ">Technikhilfe buchen</button>
    <button type="button" class="btn btn-Digitales-type2 ">Kursreihe Digitales Wissen</button>
  </div>
</div>

<!-- Section 6 Digital Wissen finished -->


<!-- Section 7 Generationenfestival-->
<!-- Image Area -->
<div class="position-relative text-center">
  <!-- Image -->
  <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/generationenfestival.jpg" class="img-fluid w-100 img-header" alt="...">
  
  <!-- Overlay -->
  <div class="overlay-yellow position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4 ">
    <button type="button" class="btn btn-lg btn-generationenfestival">Generationen Festival</button>
  </div>
</div>
<!-- Section 7 Generationenfestival finished -->

<!-- Section 8 Kerzenziehen-->
<!-- Image Area -->
<div class="position-relative text-center" style="margin-top: 5px;margin-bottom: 5px;">
  <!-- Image -->
  <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/Kerzenziehen.jpg" class="img-fluid w-100" alt="...">
  
  <!-- Overlay -->
  <div class="overlay-red position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4">
    <a href="#" class="text-decoration-none">
      <button type="button" class="btn btn-lg btn-red" style="pointer-events: auto; z-index: 1000;">Kerzenziehen</button>
    </a>
  </div>
</div>
<!-- Section 8 Kerzenziehen finished -->



<?php if( have_rows('homepage_sections') ): ?>
    <?php while( have_rows('homepage_sections') ): the_row(); ?>

        <?php if( get_row_layout() == 'digital_wissen' ): ?>
            <div class="position-relative text-center" style="margin-top: 30px;">
                <img src="<?php the_sub_field('image'); ?>" class="img-fluid w-100 img-header" alt="...">
                <div class="overlay-green position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4">
                    <a href="<?php the_sub_field('button_link'); ?>">
                        <button type="button" class="btn btn-lg btn-Digitales-type1">
                            <?php the_sub_field('button_text'); ?>
                        </button>
                    </a>
                </div>
            </div>

        <?php elseif( get_row_layout() == 'generationenfestival' ): ?>
            <div class="position-relative text-center">
                <img src="<?php the_sub_field('image'); ?>" class="img-fluid w-100 img-header" alt="...">
                <div class="overlay-yellow position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4">
                    <a href="<?php the_sub_field('button_link'); ?>">
                        <button type="button" class="btn btn-lg btn-generationenfestival">
                            <?php the_sub_field('button_text'); ?>
                        </button>
                    </a>
                </div>
            </div>

        <?php elseif( get_row_layout() == 'kerzenziehen' ): ?>
            <div class="position-relative text-center" style="margin-top: 5px;margin-bottom: 5px;">
                <img src="<?php the_sub_field('image'); ?>" class="img-fluid w-100" alt="...">
                <div class="overlay-red position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center pb-4">
                    <a href="<?php the_sub_field('button_link'); ?>" class="text-decoration-none">
                        <button type="button" class="btn btn-lg btn-red" style="pointer-events: auto; z-index: 1000;">
                            <?php the_sub_field('button_text'); ?>
                        </button>
                    </a>
                </div>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>
<?php endif; ?>







<?php get_footer(); ?>


