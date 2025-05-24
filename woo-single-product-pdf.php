<?php
/**
 * Plugin Name: Woo Single Product PDF
 * Description: Generate a PDF catalog from WooCommerce single product page.
 * Version: 1.0.0
 * Author: Sanket Thakkar
 */

defined( 'ABSPATH' ) || exit;

define( 'WSPDF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once WSPDF_PLUGIN_DIR . '/vendor/autoload.php'; // Ensure dompdf is autoloaded

require_once WSPDF_PLUGIN_DIR . 'includes/class-wspdf-generator.php';

add_shortcode( 'wspdf_download_button', __NAMESPACE__ . '\\add_pdf_download_button' );

function add_pdf_download_button() {
    ob_start();
    ?>
    <form method="post">
        <button type="submit" name="wspdf_generate_pdf" class="th-btn shadow-1 mt-4">
            <?php esc_html_e( 'Download Product PDF', 'wspdf' ); ?>
        </button>
    </form>
    <?php
    return ob_get_clean();
}

add_action( 'template_redirect',  __NAMESPACE__ . '\\handle_pdf_generation' );

function handle_pdf_generation() {
    if ( isset( $_POST['wspdf_generate_pdf'] ) && is_product() ) {
        $product_id = get_the_ID();
        $pdf = new \wspdf\Generator( $product_id );
        $pdf->generate();
        exit;
    }
}
