<?php
namespace wspdf;

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

use Dompdf\Dompdf;

class Generator {

    protected $product;

    public function __construct( $product_id ) {
        $this->product = wc_get_product( $product_id );
    }

    public function generate() {
        if ( ! $this->product ) {
            wp_die( esc_html__( 'Invalid product.', 'wspdf' ) );
        }

        $title       = $this->product->get_name();
        $short_desc  = $this->product->get_short_description();
        $desc        = $this->product->get_description();
        $categories  = wc_get_product_category_list( $this->product->get_id(), ', ' );
        $image_id    = $this->product->get_image_id();
        $image_url   = wp_get_attachment_url( $image_id );
        $site_url    = esc_url( home_url() );
        $company     = esc_html__( 'Medivision Health Care', 'wspdf' );

        ob_start();
        ?>
        <html>
        <head><meta charset="utf-8"><style>
            body { font-family: sans-serif; line-height: 1.5; }
            h1 { font-size: 24px; }
            .pdf-header,
            .pdf-footer {
                background-color: rgb(1, 158, 244);
                color: #ffffff;
                padding: 15px;
                text-align: center;
                font-weight: bold;
                margin-bottom: 20px;
            }
            .image { text-align: center; margin-bottom: 20px; }
            .content { margin-bottom: 10px; }
        </style></head>
        <body>
            <div class="pdf-header"><?php echo esc_html( $company ); ?></div>

            <div class="image">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" width="300" />
                <?php endif; ?>
            </div>

            <h1><?php echo esc_html( $title ); ?></h1>

            <?php if ( $categories ) : ?>
                <div class="content"><strong>Category:</strong> <?php echo wp_kses_post( $categories ); ?></div>
            <?php endif; ?>

            <?php if ( $short_desc ) : ?>
                <div class="content"><strong>Short Description:</strong><br><?php echo wp_kses_post( $short_desc ); ?></div>
            <?php endif; ?>

            <?php if ( $desc ) : ?>
                <div class="content"><strong>Description:</strong><br><?php echo wp_kses_post( $desc ); ?></div>
            <?php endif; ?>

            <div class="pdf-footer"><?php echo esc_html( $site_url ); ?></div>
        </body>
        </html>
        <?php
        $html = ob_get_clean();

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);

        $dompdf->loadHtml( $html );
        $dompdf->setPaper( 'A4', 'portrait' );
        $dompdf->render();
        $dompdf->stream( sanitize_title( $title ) . '.pdf', [ 'Attachment' => 1 ] );
    }
}
