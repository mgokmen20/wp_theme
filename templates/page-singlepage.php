<?php
/*
Template Name: PageTemplate
*/

get_header(); ?>

<!-- Header Section -->
<div class="text-center position-relative">
    <?php 
    $featured_image = get_the_post_thumbnail_url(); 
    if ($featured_image): ?>
        <img src="<?php echo esc_url($featured_image); ?>" class="card-img img-fluid" alt="Offenes Höchhus">
    <?php endif; ?>

    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50">
        <h2 class="card-title text-white fw-bold fs-1 mb-5"><?php the_field('heading'); ?></h2>
        
        <p class="card-text text-white fs-3">
            <?php
            $bild_text = get_field('bild_text'); 
            if ($bild_text) {
                
                echo nl2br(esc_html($bild_text));
            }
            ?>
        </p>
    </div>
</div>



<!-- Button Row Section -->
<div class="container" style="background-color: #7f1109;">
    <div class="row text-center p-2">
        <!-- Button Row -->
        <?php 
        // Buton metinleri ve URL'ler
        $buttons = [
            ['text' => 'Begegnungscafé', 'url' => site_url('/begegnungscafe')], // Kendi sayfa URL'sini buraya yaz
            ['text' => 'Räume reservieren', 'url' => site_url('/raume-reservieren')],
            ['text' => 'Programm', 'url' => site_url('/programm-offenes-hochhus')],
            ['text' => 'Begegnung', 'url' => site_url('/begegnung')],
            ['text' => 'Geschichte', 'url' => site_url('/offeneshoechhus-geschichte')],
            
        ];

        // Butonları döngü ile oluştur
        foreach ($buttons as $button) : ?>
            <div class="col-6 col-md-4 mb-2">
                <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-outline-light w-100 fs-5">
                    <?php echo esc_html($button['text']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Offenes Höchhus Description Section -->
<div class="container ">
<h3 class="mt-5 text-center fs-1"><?php the_title(); ?></h3>
<!-- Lead Area -->
<?php $lead = get_post_meta(get_the_ID(), '_lead_area', true); ?>
<?php if (!empty($lead)): ?>
    <p class="lead fs-4 text-center"><?php echo esc_html($lead); ?></p>
<?php endif; ?>



<p class="fs-1 text-center"><?php the_content(); ?></p>
</div>




<?php get_footer(); ?>
