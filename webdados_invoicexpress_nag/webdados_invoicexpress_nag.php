<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	// Add InvoiceXpress for WooCommerce nag
	add_action( 'admin_notices', 'webdados_invoicexpress_nag' );
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
				<img src="<?php echo plugin_dir_url( __FILE__ ) . 'invoicexpress-woocommerce-logo.png'; ?>" style="float: left; max-width: 100px; height: auto; margin-right: 1em;"/>
				<strong><?php _e( 'Are you already issuing automatic invoices on your WooCommerce store?', 'feed-kuantokusta-for-woocommerce' ); ?></strong>
				<br/>
				<?php echo sprintf(
					__( 'If not, get to know our new plugin: %1$sInvoicing with InvoiceXpress for WooCommerce%2$s', 'feed-kuantokusta-for-woocommerce' ),
					sprintf(
						'<a href="%s" target="_blank">',
						esc_url( __( 'https://invoicewoo.com/', 'feed-kuantokusta-for-woocommerce' ) )
					),
					'</a>'
				); ?>
				<br/>
				<?php _e( 'Use the coupon <strong>webdados</strong> for 10% discount!', 'feed-kuantokusta-for-woocommerce' ); ?>
			</p>
		</div>
		<?php
	}
	add_action( 'wp_ajax_dismiss_webdados_invoicexpress_nag', 'dismiss_webdados_invoicexpress_nag' );
	function dismiss_webdados_invoicexpress_nag() {
		$days = 90;
		$expiration = $days * DAY_IN_SECONDS;
		set_transient( 'webdados_invoicexpress_nag', 1, $expiration );
		wp_die();
	}