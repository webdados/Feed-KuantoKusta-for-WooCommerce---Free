<?php
/**
 * Plugin Name:          Feed KuantoKusta for WooCommerce - Free
 * Plugin URI:           https://www.webdados.pt/wordpress/plugins/feed-kuantokusta-para-woocommerce/
 * Description:          This plugin allows you to generate a WooCommerce product feed to submit to KuantoKusta, a portuguese price comparison website and marketplace.
 * Version:              4.0-beta.1
 * Author:               PT Woo Plugins (by Webdados)
 * Author URI:           https://ptwooplugins.com
 * Text Domain:          feed-kuantokusta-for-woocommerce
 * Domain Path:          /languages
 * Requires at least:    6.2
 * Tested up to:         6.8
 * Requires PHP:         7.0
 * WC requires at least: 8.0
 * WC tested up to:      9.8
 * Requires Plugins:     woocommerce
**/

/* WooCommerce CRUD ready (except products exclusion via the _kuantokusta_hide meta) - Can be fixed with the wc_get_products meta argument (slow? need to measure query speed) */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Localization */
add_action( 'init', 'fkkwc_load_textdomain', 0 );
function fkkwc_load_textdomain() {
	load_plugin_textdomain( 'feed-kuantokusta-for-woocommerce' );
}

/* Our own order class and the main classes */
add_action( 'init', 'fkkwc_init', 1 );
function fkkwc_init() {
	if ( class_exists( 'WooCommerce' ) && version_compare( WC_VERSION, '8.0', '>=' ) ) { //We check again because WooCommerce could have "died"
		define( 'KUANTOKUSTA_FREE_PLUGIN_FILE', __FILE__ );
		require_once( dirname( __FILE__ ) . '/includes/class-wc-feed-kuantokusta.php' );
		$GLOBALS['WC_Feed_KuantoKusta'] = WC_Feed_KuantoKusta();
		/* Add settings links - This is here because inside the main class we cannot call the correct plugin_basename( __FILE__ ) */
		add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), array( WC_Feed_KuantoKusta(), 'add_settings_link' ) );
	} else {
		add_action( 'admin_notices', 'fkkwc_admin_notices_woocommerce_not_active' );
	}
}

/* Main class */
function WC_Feed_KuantoKusta() {
	return WC_Feed_KuantoKusta::instance(); 
}

/* InvoiceXpress nag */
add_action( 'admin_init', function() {
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
		require_once( 'webdados_invoicexpress_nag/webdados_invoicexpress_nag.php' );
	}
} );

/* Dependencies notice */
function fkkwc_admin_notices_woocommerce_not_active() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<strong>Feed KuantoKusta for WooCommerce</strong> is installed and active but <strong>WooCommerce (8.0 or above)</strong> is not.', 'feed-kuantokusta-for-woocommerce' ); ?></p>
	</div>
	<?php
}

/* HPOS Compatible */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
	}
} );

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
