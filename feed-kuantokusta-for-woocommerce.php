<?php
/**
 * Plugin Name: Feed KuantoKusta for WooCommerce - Free
 * Plugin URI: https://www.webdados.pt/wordpress/plugins/feed-kuantokusta-para-woocommerce/
 * Description: This plugin allows you to generate a WooCommerce product feed to submit to KuantoKusta, a portuguese price comparison website and marketplace.
 * Version: 2.8
 * Author: PT Woo Plugins (by Webdados)
 * Author URI: https://ptwooplugins.com
 * Text Domain: feed-kuantokusta-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 5.4
 * Tested up to: 6.6
 * Requires PHP: 7.0
 * WC requires at least: 5.0
 * WC tested up to: 9.2
 * Requires Plugins: woocommerce
**/

/* WooCommerce CRUD ready (except products exclusion via the _kuantokusta_hide meta) - Can be fixed with the wc_get_products meta argument (slow? need to measure query speed) */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Localization */
add_action( 'plugins_loaded', 'fkkwc_load_textdomain', 0 );
function fkkwc_load_textdomain() {
	load_plugin_textdomain( 'feed-kuantokusta-for-woocommerce' );
}

/* Check if WooCommerce is active - Get active network plugins - "Stolen" from Novalnet Payment Gateway */
function fkkwc_active_nw_plugins() {
	if ( !is_multisite() )
		return false;
	$fkkwc_activePlugins = ( get_site_option( 'active_sitewide_plugins' ) ) ? array_keys( get_site_option( 'active_sitewide_plugins' ) ) : array();
	return $fkkwc_activePlugins;
}
if ( in_array( 'woocommerce/woocommerce.php', (array) get_option( 'active_plugins' ) ) || in_array( 'woocommerce/woocommerce.php', (array) fkkwc_active_nw_plugins() ) ) {


	/* Our own order class and the main classes */
	add_action( 'plugins_loaded', 'fkkwc_init', 1 );
	function fkkwc_init() {
		if ( class_exists( 'WooCommerce' ) && version_compare( WC_VERSION, '5.0', '>=' ) ) { //We check again because WooCommerce could have "died"
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


} else {


	add_action( 'admin_notices', 'fkkwc_admin_notices_woocommerce_not_active' );


}


function fkkwc_admin_notices_woocommerce_not_active() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<strong>Feed KuantoKusta for WooCommerce</strong> is installed and active but <strong>WooCommerce (5.0 or above)</strong> is not.', 'feed-kuantokusta-for-woocommerce' ); ?></p>
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


/* TO-DO */
/*
- Opção nas categorias de produto para as remover do feed - Versão PRO

- Campo na variação para o sub-título do produto - Não é fácil. Temos de ver como o fazer: https://wordpress.org/plugins/woo-custom-fields-for-variation/
	- Na descrição usa-se o já existente description concatenado com o do produto base
*/
