<?php
/**
 * InvoiceXpress for WooCommerce Promotional Notice
 *
 * This file contains the functionality to display and manage a promotional
 * admin notice for the InvoiceXpress for WooCommerce plugin. The notice
 * encourages store owners to consider using automated invoicing solutions
 * and offers a discount coupon.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Display an admin notice promoting the InvoiceXpress for WooCommerce plugin
 *
 * Adds a dismissible notice in the WordPress admin area that promotes
 * the InvoiceXpress plugin with a discount coupon. The notice includes
 * JavaScript to handle the dismiss action via AJAX.
 */
function webdados_invoicexpress_nag() {
	?>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).on( 'click', '#webdados_invoicexpress_nag .notice-dismiss', function () {
				//AJAX SET TRANSIENT FOR 90 DAYS
				$.ajax( ajaxurl, {
					type: 'POST',
					data: {
						action: 'dismiss_webdados_invoicexpress_nag',
					}
				});
			});
		});
		</script>
		<div id="webdados_invoicexpress_nag" class="notice notice-info is-dismissible">
			<p style="line-height: 1.4em;">
				<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'invoicexpress-woocommerce-logo.png' ); ?>" style="float: left; max-width: 100px; height: auto; margin-right: 1em;"/>
				<strong><?php esc_html_e( 'Are you already issuing automatic invoices on your WooCommerce store?', 'feed-kuantokusta-for-woocommerce' ); ?></strong>
				<br/>
			<?php
			echo wp_kses_post(
				sprintf(
					/* translators: 1: link start tag, 2: link end tag. */
					__( 'If not, get to know our new plugin: %1$sInvoicing with InvoiceXpress for WooCommerce%2$s', 'feed-kuantokusta-for-woocommerce' ),
					sprintf(
						'<a href="%s" target="_blank">',
						esc_url( __( 'https://invoicewoo.com/', 'feed-kuantokusta-for-woocommerce' ) )
					),
					'</a>'
				)
			);
			?>
				<br/>
				<?php echo wp_kses_post( __( 'Use the coupon <strong>webdados</strong> for 10% discount!', 'feed-kuantokusta-for-woocommerce' ) ); ?>
			</p>
		</div>
		<?php
}
add_action( 'admin_notices', 'webdados_invoicexpress_nag' );


/**
 * AJAX handler for dismissing the InvoiceXpress promotional notice
 *
 * Sets a transient that hides the promotional notice for 90 days when
 * the user clicks the dismiss button. The transient prevents the notice
 * from reappearing during this period.
 */
function dismiss_webdados_invoicexpress_nag() {
	$days       = 90;
	$expiration = $days * DAY_IN_SECONDS;
	set_transient( 'webdados_invoicexpress_nag', 1, $expiration );
	wp_die();
}
add_action( 'wp_ajax_dismiss_webdados_invoicexpress_nag', 'dismiss_webdados_invoicexpress_nag' );
