<?php

// Theme Styles Enqueue
function enqueue_theme_styles() {
    // Bootstrap CSS 
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', 
        array(),
        '5.3.3'
    );

    // Bootstrap Icons
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css',
        array(),
        '1.11.2'
    );

    // Google Fonts 
    // wp_enqueue_style(
    //     'google-fonts',
    //     'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Roboto&display=swap',
    //     array(),
    //     null
    // );

    // Google Fonts Enqueue
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap',
        array(),
        null
    );



    // Main theme stylesheet
    wp_enqueue_style(
        'theme-main-style',
        get_template_directory_uri() . '/style.css',
        array('bootstrap-css'),
        filemtime(get_template_directory() . '/style.css')
    );

    wp_enqueue_style(
        'dynamic-styles',
        get_template_directory_uri() . '/dynamic-styles.php',
        array(),
        filemtime(get_template_directory() . '/dynamic-styles.php')
    );
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

// Theme Scripts Enqueue
function my_theme_scripts() {
    
    wp_enqueue_script(
        'bootstrap-bundle', 
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', 
        array(), 
        '5.3.0-alpha3', 
        true 
    );

    
    wp_enqueue_script(
        'custom-script', 
        get_template_directory_uri() . '/assets/script.js', 
        array(), 
        null, 
        true 
    );
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');


function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');



// Slider Custom Post Type
function custom_slider_post_type() {
    register_post_type('slider',
        array(
            'labels'      => array(
                'name'          => __('Slider'),
                'singular_name' => __('Slider Item'),
            ),
            'public'      => true,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'menu_icon'   => 'dashicons-images-alt2',
        )
    );
}
add_action('init', 'custom_slider_post_type');



// Theme Image Support 
function theme_support_setup() {
    add_theme_support('post-thumbnails'); // Enable featured images
    add_image_size('slider-image', 1920, 1080, true); // Custom image size for slider (adjust if necessary)
}
add_action('after_setup_theme', 'theme_support_setup');


function save_slider_link_on_update($post_id) {

    if (get_post_type($post_id) === 'slider') {
        
        if (isset($_POST['acf']['field_67a5bd2254761'])) { 
            $slider_link = sanitize_text_field($_POST['acf']['field_67a5bd2254761']); //Take link

            
            if ($slider_link) {
                update_post_meta($post_id, 'slider_link', $slider_link);
            }
        }
    }
}
add_action('save_post', 'save_slider_link_on_update');


function theme_header_footer_setup() {

    add_action('wp_head', function() {
        ?>
        <!-- Theme Header Section -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
        <?php
    });


    add_action('wp_footer', function() {
        ?>
        <!-- Theme Footer Section -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <?php
    });
}
add_action('after_setup_theme', 'theme_header_footer_setup');






// Register Custom Post Type: Events
function register_events_post_type() {
    $labels = array(
        'name'               => 'Events',
        'singular_name'      => 'Event',
        'menu_name'          => 'Events',
        'name_admin_bar'     => 'Event',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Event',
        'new_item'           => 'New Event',
        'edit_item'          => 'Edit Event',
        'view_item'          => 'View Event',
        'all_items'          => 'All Events',
        'search_items'       => 'Search Events',
        'not_found'          => 'No events found.',
    );

    $args = array(
        'label'             => 'Events',
        'labels'            => $labels,
        'public'            => true,
        'menu_icon'         => 'dashicons-calendar-alt',
        'supports'          => array('title', 'editor', 'thumbnail'),
        'has_archive'       => true,
        'rewrite'           => array('slug' => 'events'),
        'show_in_rest'      => true,
        'taxonomies'        => array('event_category'), // Link to event_category taxonomy
    );

    register_post_type('event', $args);
}
add_action('init', 'register_events_post_type');

// Register Custom Taxonomy: Event Categories
function register_event_categories() {
    $labels = array(
        'name'              => 'Event Categories',
        'singular_name'     => 'Event Category',
        'search_items'      => 'Search Categories',
        'all_items'         => 'All Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Event Categories',
    );

    $args = array(
        'hierarchical'      => true, // Works like post categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'event-category'),
    );

    register_taxonomy('event_category', array('event'), $args);
}
add_action('init', 'register_event_categories');



// Hook to update the event_timestamp when the event is saved or updated
function update_event_timestamp($post_id) {
    // Check if this is a valid 'event' post type
    if (get_post_type($post_id) != 'event') {
        return;
    }

    // Get the event date and time
    $event_date = get_post_meta($post_id, 'event_date', true);
    $event_time = get_post_meta($post_id, 'event_time', true);

    // If both the date and time are provided
    if (!empty($event_date) && !empty($event_time)) {
        // Combine the date and time and convert it into a timestamp
        $event_datetime = $event_date . ' ' . $event_time;
        $event_timestamp = strtotime($event_datetime);

        // Save the timestamp as a new custom field 'event_timestamp'
        update_post_meta($post_id, 'event_timestamp', $event_timestamp);
    }
}

// Hook to save the event timestamp whenever the event post is saved
add_action('save_post', 'update_event_timestamp');


function set_event_template($single_template) {
    global $post;

    // Wenn der Beitragstyp „Event“ ist, verwenden Sie die Vorlage „single-event.php“.
    if ($post->post_type == 'event') {
    
        $single_template = locate_template('single-event.php');
    }
    return $single_template;
}

add_filter('single_template', 'set_event_template');



function load_custom_scripts() {
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'load_custom_scripts');







// (Blog post)
// Add Lead Field to Post, Page, and Event Editor
function add_lead_meta_box() {
    $post_types = array('post', 'page', 'event'); // Apply to posts, pages, and events

    foreach ($post_types as $post_type) {
        add_meta_box('lead_area', 'Lead Area', 'lead_area_callback', $post_type, 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'add_lead_meta_box');

function lead_area_callback($post) {
    $lead_content = get_post_meta($post->ID, '_lead_area', true);
    echo '<textarea name="lead_area" style="width:100%; height:100px;">' . esc_textarea($lead_content) . '</textarea>';
}

function save_lead_area($post_id) {
    // Security check: Prevent auto-save, check nonce, and verify permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['lead_area'])) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, '_lead_area', sanitize_textarea_field($_POST['lead_area']));
}
add_action('save_post', 'save_lead_area');








//Gutenberg 
require_once( 'library/gutenberg.php' );


//Responsive images
require_once( 'library/responsive-images.php' );


// Entry meta user
require_once( 'library/entry-meta.php' );



function my_acf_init() {
	acf_update_setting('google_api_key', 'GOOGLE_API__API_KEY');
}

add_action('acf/init', 'my_acf_init');




// Custom Dashboard for Login UND
function custom_dashboard_widget() {
    
    echo "<h2>Login-Dashboard</h2>";

    
    echo "<p>Um auf alle Tools des UND Generationentandem zuzugreifen, gelangen Sie hier zur Login-Dashboard-Seite.</p>";

    
    echo '<a href="https://login.generationentandem.ch/" target="_blank" style="background-color: #2271b1; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin-top: 10px;">Login - Dashboard</a>';
}

function add_custom_dashboard_widget() {
    wp_add_dashboard_widget(
        'custom_dashboard_widget', 
        'Özel Dashboard Widget',   
        'custom_dashboard_widget' 
    );
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');





// Menü settings
function register_my_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu' ),
        )
    );
}
add_action( 'init', 'register_my_menus' );

function add_bootstrap_menu_classes($classes, $item, $args) {
    if ($args->theme_location == 'primary-menu') {
        $classes[] = 'nav-item'; // Adds Bootstrap class to each menu item
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_bootstrap_menu_classes', 10, 3);

function add_bootstrap_menu_link_class($atts, $item, $args) {
    if ($args->theme_location == 'primary-menu') {
        $atts['class'] = 'nav-link text-dark hover-effect'; // Adds Bootstrap styles to links
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_bootstrap_menu_link_class', 10, 3);



// Introducing Custom Templates
function custom_templates_register($templates) {
    $templates['templates/page-offenes-hochhus.php'] = 'Offenes Höchhus';
    $templates['templates/page-politpodium.php'] = 'Politpodium';
    $templates['templates/page-singlepage.php'] = 'PageTemplate';
    return $templates;
}
add_filter('theme_page_templates', 'custom_templates_register');

function load_custom_templates($template) {
    global $post;
    if (!$post) return $template;

    $template_name = get_page_template_slug($post->ID);
    if ($template_name && file_exists(get_template_directory() . '/' . $template_name)) {
        return get_template_directory() . '/' . $template_name;
    }

    return $template;
}
add_filter('template_include', 'load_custom_templates');



// Update Shortcode 
require_once get_template_directory() . '/shortcodes/events-shortcode.php';
require_once get_template_directory() . '/shortcodes/blogs-shortcode.php';


// to change the content font size
function add_bootstrap_fs_class_to_content($content) {
    
    if (is_singular()) { 
        $content = '<div class="fs-5">' . $content . '</div>';
    }
    return $content;
}
add_filter('the_content', 'add_bootstrap_fs_class_to_content');





// Comment
function my_custom_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $author = get_comment_author();
    ?>
    <li <?php comment_class('media my-4'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="media-body my-5">
            <div class="d-flex justify-content-between">
                <h5 class="mt-5"><?php echo $author; ?></h5>
                <span class="text-muted"><?php echo get_comment_date(); ?></span>
            </div>
            <p><?php comment_text(); ?></p>
            <?php if ($comment->comment_approved == '0') : ?>
                <em>Ihr Kommentar steht noch aus.</em>
            <?php endif; ?>
        </div>
    </li>
<?php
}


