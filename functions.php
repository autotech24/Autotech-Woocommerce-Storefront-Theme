<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

/**
 * Include non-public functions
 */
$current_directory = dirname(__FILE__);
$secret_functions_file = $current_directory . DIRECTORY_SEPARATOR . 'secret_functions.php';
if (file_exists($secret_functions_file)) {
    require_once($secret_functions_file);
}

/**
 * Includes icons from https://favicomatic.com
 */
add_action('wp_head', 'wp_head_autotech');
function wp_head_autotech(){
    ?>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?php
};

/**
 * Enables billing phone as required in Woocommerce
 */
add_action('wp_footer', 'wp_footer_autotech');
function wp_footer_autotech(){
    ?>
    <script>
        jQuery("#billing_phone").attr("required", "true");
    </script>
    <?php
};

/**
 * Disable address 2 field
 */
add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
function custom_remove_woo_checkout_fields( $fields ) {
    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_address_2']);

    return $fields;
}

/**
 * Billing phone required
 */
add_filter( 'woocommerce_billing_fields', function($address_fields) {
    $address_fields['billing_phone']['required'] = true;
    return $address_fields;
}, 10, 1 );

/**
 * Changes copyright text to simple one
 */
function custom_storefront_credit() {

    $current_year = date('Y');
    $site_name = get_bloginfo('name');

    echo '&copy; ' . esc_html( $current_year ) . ' ' . esc_html( $site_name );
}
add_action( 'init', function() {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
});
add_action( 'storefront_footer', 'custom_storefront_credit', 20 );

/**
 * Generate submission ID for Contact form
 */
function cf7_generate_submission_id() {

    $submission_id = uniqid('submission_', true);
    return esc_html($submission_id);
}

add_shortcode('submission_id', 'cf7_generate_submission_id');