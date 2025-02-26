<?php
/*
Template Name: Offenes Höchhus
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

<!-- Events Section -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="mt-5 text-start">Nächste Veranstaltungen im Offenen Höchhus</h3>
            <hr>
            <div class="event-list text-start">
                <?php echo do_shortcode('[offenes_hochhus_events]'); // Shortcode for events ?>
            </div>
        </div>
    </div>
</div>

<!-- View More Events Button -->
<div class="container-fluid text-center">
    <a href="<?php echo site_url('/category/event_category/offenes-hochhus/'); ?>" class="btn btn-program"> Weitere Veranstaltungen</a>
</div>

<!-- Insight Section -->
<h2 style="margin: 20px;">Einblicke</h2>
<hr>

<!-- Blog Section -->
<div class="row mt-4">
    
    <?php echo do_shortcode('[offenes_hochhus_blogs]'); // Shortcode for blogs ?>
</div>

<!-- View More Insights Button -->
<div class="container-fluid text-center">
    <button class="btn btn-program" type="button">Weitere Beiträge</button> 
</div>

<?php get_footer(); ?>
