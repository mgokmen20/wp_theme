<?php
/**
 * The template for displaying all single events.
 *
 * @package YourTheme
 */

get_header(); 
?>

<!-- Header Image -->
<div class="text-center position-relative">
    <?php
    //  (featured image) 
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            $event_image = get_the_post_thumbnail_url();
            if ($event_image) {
                echo '<img src="' . esc_url($event_image) . '" class="card-img" alt="Event Image">';
            }
        endwhile;
    endif;
    ?>
    <div class="d-flex flex-column"></div>
</div>

<div class="container" style="background-color:#7f1109;">
    <div class="row text-center p-3">
        
        <div class="col justify-content-center">
            <a href="#" class="btn btn-outline-light px-5 fs-5">Zur Übersicht</a>               <!-- You have to set a link -->  
        </div>
    </div>
</div>

<h3 class="text-center mt-5 mb-5 fs-1 fw-bold">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            the_title(); //  (Event title)
            
        endwhile;
    endif;
    ?>
</h3>
<!-- Lead Area -->
<?php $lead = get_post_meta(get_the_ID(), '_lead_area', true); ?>
<?php if (!empty($lead)): ?>
    <p class="lead fs-4 mb-5"><?php echo esc_html($lead); ?></p>
<?php endif; ?>

<div class="row justify-content-center mb-4 gap-2">
<!-- Date and Time -->
<?php
if (have_posts()) :
    while (have_posts()) : the_post();

        // ACF alanlarını al
        $event_date = get_post_meta(get_the_ID(), 'event_date', true);  
        $start_time = get_post_meta(get_the_ID(), 'start_zeit', true);  
        $end_time = get_post_meta(get_the_ID(), 'ende_zeit', true);     
        $event_location = get_post_meta(get_the_ID(), 'hauptort', true); // Location

        
        if ($event_date) {
            $event_date_formatted = date_i18n('d F Y', strtotime($event_date)); 
        }

     
        if ($start_time) {
            $start_time_formatted = date_i18n('H:i', strtotime($start_time)); 
        }

        
        if ($end_time) {
            $end_time_formatted = date_i18n('H:i', strtotime($end_time)); 
        }

        
        $event_datetime = '';
        if ($event_date_formatted) {
            $event_datetime .= $event_date_formatted;
        }
        if ($start_time_formatted) {
            $event_datetime .= ', ' . $start_time_formatted; // Start zeit
            if ($end_time_formatted) {
                $event_datetime .= ' - ' . $end_time_formatted; // Ende zeit
            }
        }
?>
        <!--  -->
        <div class="row p-1 fs-4 align-items-center bg-light mb-1">
            <div class="col-2 col-md-1 d-flex align-items-center justify-content-center p-3">
                <i class="bi bi-clock"></i>
            </div>
            <div class="col-10 col-md-11 text-md-start p-3">
                <?php echo esc_html($event_datetime); ?>
            </div>
        </div>
<?php
    endwhile;
endif;
?>







    <!-- Event Location -->
    <?php
    if ($event_location) :
    ?>
        <div class="row p-1 fs-4 align-items-center bg-light">
            <div class="col-2 col-md-1 d-flex align-items-center justify-content-center p-3">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="col-10 col-md-11 text-md-start p-3">
                <?php
                if ($event_location) {
                    echo esc_html($event_location);
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>



<!-- Etkinlik İçeriği / Açıklaması -->
<div class="mt-4 p-5">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            // Etkinlik içeriğini görüntüle
            the_content();
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); // Web sitesinin alt bilgisini (footer) getir ?>
</div>
