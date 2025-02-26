<?php

$event_date = get_post_meta(get_the_ID(), 'event_date', true); 
$start_time = get_post_meta(get_the_ID(), 'start_zeit', true); 
$end_time = get_post_meta(get_the_ID(), 'ende_zeit', true); 
$event_location = get_post_meta(get_the_ID(), 'hauptort', true); 


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

<div class="event-card p-3 mb-3 bg-light rounded shadow-sm hover-effect position-relative">
    <div class="row align-items-center g-0">
        <div class="col-4 col-md-3">
            <div class="event-date text-center p-2 rounded">
                <span class="d-block fs-4 fw-bold"><?php echo esc_html($event_day); ?></span>
                <span class="d-block"><?php echo esc_html($event_month); ?></span>
                <span class="d-block"><?php echo esc_html($event_year); ?></span>
            </div>
        </div>
        <div class="col-8 col-md-9 ps-3 position-static">
            <div class="d-flex flex-column justify-content-center h-100">
                <a href="<?php the_permalink(); ?>" class="stretched-link text-reset text-decoration-none"></a>
                <h3 class="event-title mb-2"><?php the_title(); ?></h3>
                <div class="event-info d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center text-secondary">
                    <span class="d-flex align-items-center">
                        <i class="bi bi-clock me-2"></i><?php echo esc_html($event_start_time); ?> - <?php echo esc_html($event_end_time); ?> Uhr
                    </span>
                    <span class="d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i><?php echo esc_html($event_location); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
