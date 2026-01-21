<?php
/**
 * Plugin Name:          Feed KuantoKusta for WooCommerce - Free
 * Plugin URI:           https://www.webdados.pt/wordpress/plugins/feed-kuantokusta-para-woocommerce/
 * Description:          This plugin allows you to generate a WooCommerce product feed to submit to KuantoKusta, a portuguese price comparison website and marketplace.
 * Version:              5.1
 * Author:               Naked Cat Plugins (by Webdados)
 * Author URI:           https://nakedcatplugins.com
 * Text Domain:          feed-kuantokusta-for-woocommerce
 * Domain Path:          /languages
 * Requires at least:    6.2
 * Tested up to:         6.9
 * Requires PHP:         7.2
 * WC requires at least: 8.0
 * WC tested up to:      10.5
 * Requires Plugins:     woocommerce
 **/

/* WooCommerce CRUD ready (except products exclusion via the _kuantokusta_hide meta) - Can be fixed with the wc_get_products meta argument (slow? need to measure query speed) */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Initialize the plugin.
 * Our own order class and the main classes.
 *
 * @return void
 */
function fkkwc_init() {
	if ( class_exists( 'WooCommerce' ) && version_compare( WC_VERSION, '8.0', '>=' ) ) { // We check again because WooCommerce could have "died"
		define( 'KUANTOKUSTA_FREE_PLUGIN_FILE', __FILE__ );
		require_once __DIR__ . '/includes/class-wc-feed-kuantokusta.php';
		$GLOBALS['WC_Feed_KuantoKusta'] = WC_Feed_KuantoKusta();
		/* Add settings links - This is here because inside the main class we cannot call the correct plugin_basename( __FILE__ ) */
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( WC_Feed_KuantoKusta(), 'add_settings_link' ) );
	} else {
		add_action( 'admin_notices', 'fkkwc_admin_notices_woocommerce_not_active' );
	}
}
add_action( 'init', 'fkkwc_init', 1 );

/**
 * Load the main class.
 *
 * @return WC_Feed_KuantoKusta
 */
function WC_Feed_KuantoKusta() { //phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return WC_Feed_KuantoKusta::instance();
}

/**
 * Admin nag for InvoiceXpress for WooCommerce.
 */
add_action(
	'admin_init',
	function () {
		if (
		( ! defined( 'WEBDADOS_INVOICEXPRESS_NAG' ) )
		&&
		( ! class_exists( '\Webdados\InvoiceXpressWooCommerce\Plugin' ) )
		&&
		empty( get_transient( 'webdados_invoicexpress_nag' ) )
		&&
		apply_filters( 'kk_webdados_invoicexpress_nag', true )
		) {
			define( 'WEBDADOS_INVOICEXPRESS_NAG', true );
			require_once 'webdados-invoicexpress-nag/webdados-invoicexpress-nag.php';
		}
	}
);

/**
 * Dependencies notice
 *
 * @return void
 */
function fkkwc_admin_notices_woocommerce_not_active() {
	?>
	<div class="notice notice-error is-dismissible">
		<p>
			<?php
			echo wp_kses_post(
				__( '<strong>Feed KuantoKusta for WooCommerce</strong> is installed and active but <strong>WooCommerce (8.0 or above)</strong> is not.', 'feed-kuantokusta-for-woocommerce' )
			);
			?>
		</p>
	</div>
	<?php
}


function fkkwc_admin_notices_pro_incompatible() {
	?>
	<div class="notice notice-error is-dismissible">
		<p>
			<?php
			echo wp_kses_post(
				__( '<strong>Feed KuantoKusta for WooCommerce</strong> is installed and active but <strong>KuantoKusta PRO (5.0 or above)</strong> is not. You need to update the PRO plugin or disable it for the feed to be generated.', 'feed-kuantokusta-for-woocommerce' )
			);
			?>
		</p>
	</div>
	<?php
}

/**
 * Declare compatibility with WooCommerce High Performance Order Storage and Cart & Checkout Blocks.
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
		}
	}
);

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
