<?php
/*
Plugin Name: Rokhdad Manager
Plugin URI: https://rokhdad.media/
Description: https://Rokhdad.Media
Version: 0.1
Author: Rick Sanchez
Author URI: https://m4tinbeigi.ir/
License: GPL2
*/



function create_event_post_type() {
    register_post_type( 'event',
        array(
            'labels' => array(
                'name' => __( 'رخدادها' ),
                'singular_name' => __( 'رخداد' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'events'),
           'supports' => array( 'title', 'editor', 'thumbnail', 'author' )
        )

    );
}
add_action( 'init', 'create_event_post_type' );

function create_event_taxonomy() {
    register_taxonomy(
        'event_category',
        'event',
        array(
            'label' => __( 'دسته‌بندی رخدادها' ),
            'rewrite' => array( 'slug' => 'event-category' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'create_event_taxonomy' );

function events_shortcode( $atts ) {
    $args = shortcode_atts( array(
        'limit' => '10',
    ), $atts );

    $events = get_posts( array(
        'post_type' => 'event',
        'posts_per_page' => $args['limit'],
    ) );
    //print_r($events);
    if(count( $events ) == 0){echo 'رخدادی پیدا نشد';}
    ob_start();
    ?>
<table>
  <tr>
    <th style="text-align: center" >نام رخداد</th>
    <th style="text-align: center" >توضیحات</th>
    <th style="text-align: center" >زمان برگزاری</th>
  </tr>
 

<?php foreach ( $events as $event ) : ?>
 <tr>
    <td style="text-align: center" ><?php echo get_the_title( $event->ID ); ?></td>
    <td style="text-align: center" ><?php echo get_field( 'description', $event->ID ); ?></td>
    <td style="text-align: center" ><?php echo get_field( 'start_time', $event->ID ).' - '.get_field( 'h_start', $event->ID ); ?></td>
</tr>
<?php endforeach; ?>  
</table>
    
    <?php
        return ob_get_clean();
}
add_shortcode( 'events', 'events_shortcode' );

function events_today_shortcode( $atts ) {
    $args = shortcode_atts( array(
        'limit' => '10',
    ), $atts );
    
    //$today = (date( 'Y-m-d' ));
    $today = explode(',',str_replace('رخدادهای امروز | ','',YoastSEO()->meta->for_post('122')->title))[1];
    $today = explode(' ',$today);
    $month = $today[2];
    switch ($month) {case 'اسفند':  $today[2]='۱۲';    break;case 'بهمن':    $today[2]='۱۱';    break;case 'دی':    $today[2]='۱۰';    break;case 'آذر':    $today[2]='۹';    break;    case 'آبان':    $today[2]='۸';    break;    case 'مهر':    $today[2]='۷';    break;    case 'شهریور':    $today[2]='۶';    break;    case 'مرداد':    $today[2]='۵';    break;    case 'تیر':    $today[2]='۴';    break;    case 'خرداد':    $today[2]='۳';    break;    case 'اردیبهشت':    $today[2]='۲';    break;    case 'فروردین':    $today[2]='۱';    break;}
    if(strlen($today[1])== '1'){
        $today = $today[3].'-'.$today[2].'-۰'.$today[1];
    }else{
        $today = $today[3].'-'.$today[2].'-'.$today[1];
    }
    $events = get_posts( array(
        'post_type' => 'event',
        'posts_per_page' => $args['limit'],
    ) );

    if ( count( $events ) == 0 ) {
        echo 'رخدادی پیدا نشد';
        exit;
    }
    ob_start();
    ?>
    <table>
        <tr>
            <th style="text-align: center" >نام رخداد</th>
            <th style="text-align: center" >توضیحات</th>
            <th style="text-align: center" >زمان برگزاری</th>
            <th style="text-align: center" >آدرس</th>
            <th style="text-align: center" >لینک ثبت نام</th>
        </tr>
        <?php foreach ( $events as $event ) :
            if(get_field( 'start_time', $event->ID ) == $today){ ?>
            <tr>
                <td style="text-align: center" ><?php echo get_the_title( $event->ID ); ?></td>
                <td style="text-align: center" ><?php echo get_field( 'description', $event->ID ); ?></td>
                <td style="text-align: center" ><?php echo 'امروز' . ' - ' . get_field( 'h_start', $event->ID ); ?></td>
                <td style="text-align: center" ><?php echo '<a href="' . get_field( 'google_maps', $event->ID ) . '">' . get_field( 'address', $event->ID ) . '</a>'; ?></td>
                <td style="text-align: center" ><?php echo '<a href="' . get_field( 'signup_link', $event->ID ) . '">ثبت‌نام</a>'; ?></td>
            </tr>
        <?php } endforeach; ?>  
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode( 'events_today', 'events_today_shortcode' );

function events_small_shortcode( $atts ) {
    $args = shortcode_atts( array(
        'limit' => '10',
    ), $atts );

    $events = get_posts( array(
        'post_type' => 'event',
        'posts_per_page' => $args['limit'],
    ) );
    //print_r($events);
    if(count( $events ) == 0){echo 'رخدادی پیدا نشد';}
    ob_start();
    ?>
<table style="text-align: center">
  <tr>
    <th style="text-align: center">نام رخداد</th>
    <th style="text-align: center">زمان برگزاری</th>
  </tr>
 

<?php foreach ( $events as $event ) : ?>
 <tr>
    <td style="text-align: center"><?php echo get_the_title( $event->ID ); ?></td>
    <td style="text-align: center"><?php echo get_field( 'start_time', $event->ID ).' - '.get_field( 'h_start', $event->ID ); ?></td>
</tr>
<?php endforeach; ?>  
</table>
    
    <?php
        return ob_get_clean();
}
add_shortcode( 'events_small', 'events_small_shortcode' );

function events_today_small_shortcode( $atts ) {
$args = shortcode_atts( array(
        'limit' => '10',
    ), $atts );
    
    //$today = (date( 'Y-m-d' ));
    //$today = explode(',',str_replace('رخدادهای امروز | ','',YoastSEO()->meta->for_post('122')->title))[1];
    //$today = explode(' ',$today);
    //$month = $today[2];
    //switch ($month) {case 'اسفند':  $today[2]='۱۲';    break;case 'بهمن':    $today[2]='۱۱';    break;case 'دی':    $today[2]='۱۰';    break;case 'آذر':    $today[2]='۹';    break;    case 'آبان':    $today[2]='۸';    break;    case 'مهر':    $today[2]='۷';    break;    case 'شهریور':    $today[2]='۶';    break;    case 'مرداد':    $today[2]='۵';    break;    case 'تیر':    $today[2]='۴';    break;    case 'خرداد':    $today[2]='۳';    break;    case 'اردیبهشت':    $today[2]='۲';    break;    case 'فروردین':    $today[2]='۱';    break;}
   // if(strlen($today[1])== '1'){
   //     $today = $today[3].'-'.$today[2].'-۰'.$today[1];
   // }else{
   //     $today = $today[3].'-'.$today[2].'-'.$today[1];
   // }
    $events = get_posts( array(
        'post_type' => 'event',
        'posts_per_page' => $args['limit'],
    ) );

    if ( count( $events ) == 0 ) {
        echo 'رخدادی پیدا نشد';
        exit;
    }
    ob_start();
    ?>
    <table>
        <tr>
            <th style="text-align: center" >نام رخداد</th>
            <th style="text-align: center" >زمان برگزاری</th>
        </tr>
        <?php foreach ( $events as $event ) :
            if(get_field( 'start_time', $event->ID ) == $today){ ?>
            <tr>
                <td style="text-align: center" ><?php echo get_the_title( $event->ID ); ?></td>
                <td style="text-align: center" ><?php echo get_field( 'h_start', $event->ID ); ?></td>
            </tr>
        <?php } endforeach; ?>  
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode( 'events_today_small', 'events_today_small_shortcode' );


function enable_tags_for_custom_post_type() {
    register_taxonomy_for_object_type('post_tag', 'event'); // your_custom_post_type را با نام پست تایپ موردنظرتان جایگزین کنید
}
add_action('init', 'enable_tags_for_custom_post_type');

function event_details_shortcode() {
    global $post;

    if (get_post_type() !== 'event') {
        return '';
    }

    $event_title = get_the_title($post->ID);
    $event_description = get_field('description', $post->ID);
    $event_start_time = get_field('start_time', $post->ID);
    $event_h_start = get_field('h_start', $post->ID);
    $event_address = get_field('address', $post->ID);
    $event_google_maps = get_field('google_maps', $post->ID);
    $event_signup_link = get_field('signup_link', $post->ID);

    ob_start();
    ?>
    <div class="event-widget">
        <h2><?php echo $event_title; ?></h2>
        <p><?php echo $event_description; ?></p>
        <p><strong>زمان برگزاری:</strong> <?php echo $event_start_time . ' - ' . $event_h_start; ?></p>
        <p><strong>آدرس:</strong> <a href="<?php echo $event_google_maps; ?>"><?php echo $event_address; ?></a></p>
        <p><strong>لینک ثبت نام:</strong> <a href="<?php echo $event_signup_link; ?>">ثبت‌نام</a></p>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('event_details', 'event_details_shortcode');


function events_with_tag_shortcode($atts) {
    $atts = shortcode_atts(array(
        'tag' => '',
        'limit' => '10',
    ), $atts);

    $tag_slug = sanitize_title($atts['tag']);
    $tag = get_term_by('slug', $tag_slug, 'post_tag');

    if (!$tag) {
        return 'تگ یافت نشد';
    }

    $events = get_posts(array(
        'post_type' => 'event',
        'posts_per_page' => $atts['limit'],
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag->term_id,
            ),
        ),
    ));

    if (count($events) === 0) {
        return 'رویدادی با این تگ یافت نشد';
    }

    ob_start();
    ?>
    <table>
        <tr>
            <th style="text-align: center" >نام رخداد</th>
            <th style="text-align: center" >توضیحات</th>
            <th style="text-align: center" >زمان برگزاری</th>
        </tr>
        <?php foreach ( $events as $event ) :
            ?>
            <tr>
                <td style="text-align: center" ><?php echo '<a href="' . get_permalink($event->ID) . '">'.get_the_title( $event->ID ).'</a>'; ?></td>
                <td style="text-align: center" ><?php echo get_field( 'description', $event->ID ); ?></td>
                <td style="text-align: center" ><?php echo  get_field( 'h_start', $event->ID ); ?></td>
            </tr>
        <?php endforeach; ?>  
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode('events_with_tag', 'events_with_tag_shortcode');

// Define your custom API endpoint
add_action('rest_api_init', 'register_custom_event_api');

function register_custom_event_api() {
    register_rest_route('event/v1', '/add_event', array(
        'methods' => 'POST',
        'callback' => 'add_event_data',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ));
}

// Callback function to handle the API request
function add_event_data(WP_REST_Request $request) {
    $post_title = $request->get_param('title');
    $post_content = $request->get_param('content');
    $start_time = $request->get_param('start_time');
    $h_start = $request->get_param('h_start');
    // ... add more fields as needed

    $event_data = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_type' => 'event',
        'post_status' => 'publish',
    );

    // Insert the event post
    $event_id = wp_insert_post($event_data);

    if (!is_wp_error($event_id)) {
        // Update custom fields
        update_field('start_time', $start_time, $event_id);
        update_field('h_start', $h_start, $event_id);
        // ... update more fields as needed

        return array('message' => 'Event added successfully!', 'event_id' => $event_id);
    } else {
        return array('error' => 'Failed to add event.');
    }
}

// Add Schema Markup for Events
function add_event_schema_markup() {
    if (is_singular('event')) {
        global $post;

        $event_start_time = get_field('start_time', $post->ID);
        $event_h_start = get_field('h_start', $post->ID);
        $event_address = get_field('address', $post->ID);
        $event_google_maps = get_field('google_maps', $post->ID);
        $event_signup_link = get_field('signup_link', $post->ID);

        $schema_markup = array(
            '@context' => 'http://schema.org',
            '@type' => 'Event',
            'name' => get_the_title($post->ID),
            'description' => get_field('description', $post->ID),
            'startDate' => $event_start_time,
            'endDate' => $event_start_time, // You can adjust this if events have end times
            'location' => array(
                '@type' => 'Place',
                'name' => $event_address,
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => $event_address,
                    'addressLocality' => '', // Add locality if available
                    'addressRegion' => '', // Add region if available
                    'postalCode' => '', // Add postal code if available
                    'addressCountry' => '', // Add country if available
                ),
                'geo' => array(
                    '@type' => 'GeoCoordinates',
                    'latitude' => '', // Add latitude if available
                    'longitude' => '', // Add longitude if available
                ),
            ),
            'url' => get_permalink($post->ID),
            'organizer' => array(
                '@type' => 'Organization',
                'name' => get_the_author_meta('display_name', $post->post_author),
                'url' => get_author_posts_url($post->post_author),
            ),
            'offers' => array(
                '@type' => 'Offer',
                'url' => $event_signup_link,
            ),
        );

        // Check if the event is online, and remove location if it's an online event
        $is_online_event = get_field('online_event', $post->ID); // Assuming you have a custom field to determine if it's an online event
        if ($is_online_event) {
            unset($schema_markup['location']);
        }

        echo '<script type="application/ld+json">' . json_encode($schema_markup) . '</script>';
    }
}
add_action('wp_head', 'add_event_schema_markup');
