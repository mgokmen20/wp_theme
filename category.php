<?php get_header(); ?>

<div class="container">
    <h1><?php single_cat_title(); ?></h1>

    <?php 
    $category = get_queried_object(); // Mevcut kategori bilgisini al
    $category_slug = $category->slug; // Kategori slug'ını al

    // Kategoriye özel bir şablon dosyası var mı kontrol et
    if (locate_template("template-parts/categories/category-{$category_slug}.php")) {
        get_template_part("template-parts/categories/category", $category_slug);
    } else {
        get_template_part("template-parts/categories/category", "default"); // Varsayılan kategori şablonu
    }
    ?>
</div>

<?php get_footer(); ?>
