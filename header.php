<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Open Graph Meta Tags -->
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:image" content="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php the_title(); ?>" />
<meta name="twitter:description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>" />
<meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" />

<meta property="og:image" content="<?php echo has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : 'URL_TO_DEFAULT_IMAGE'; ?>" />
<meta name="twitter:image" content="<?php echo has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : 'URL_TO_DEFAULT_IMAGE'; ?>" />




    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> 
<div class="container my-0 custom-container">
    <!-- Header -->
    <header class="main-header w-100 flex-grow-1">
        <div class="container-fluid d-flex justify-content-between align-items-center sticky-top">
            <div class="logo">
                <a href="<?php echo home_url(); ?>"><img class="logo-image" src="<?php bloginfo( 'template_directory' ); ?>/assets/img/Logo-weiss-UND-Generationentandem.png" alt="Site Logo"></a>
            </div>
            <div class="header-right d-flex align-items-center">
                <div class="search-container" id="searchContainer">
                    <i class="bi bi-search search-icon fs-4 text-white m-2 hover-effect" id="searchIcon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search..." aria-label="Search">
                </div>
                <div class="menu-icon">
                    <button class="btn menu-hamburger fs-2 text-white m-2 hover-effect" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                        ☰
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Finished -->



<!-- Right Off-Canvas menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menü</h5>
    <button type="button" class="btn-close text-reset p-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-4">
    <nav class="navbar navbar-light">
      <?php
          wp_nav_menu(array(
              'theme_location' => 'primary-menu',
              'container' => false, 
              'menu_class' => 'nav flex-column gap-1', 
              'fallback_cb' => false
          ));
      ?>
    </nav>
  </div>
</div>


