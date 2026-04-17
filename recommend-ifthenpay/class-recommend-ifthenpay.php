<?php
/**
 * Class Recommend_Ifthenpay
 *
 * @version 1.3
 */

namespace NakedCatPlugins\Recommend_Ifthenpay;

/**
 * Recommend Ifthenpay.
 *
 * @package NakedCatPlugins\Recommend_Ifthenpay
 */
class Recommend_Ifthenpay {

	/**
	 * Unique identifier for the injected entry in the WooCommerce providers list.
	 */
	const SUGGESTION_ID = 'nakedcat-recommend-ifthenpay';

	/**
	 * WP.org slug of the Ifthenpay plugin the Install/Activate button targets.
	 *
	 * Must match the plugin's folder name on wordpress.org so that WooCommerce's
	 * React UI can drive the core plugin installer without any extra wiring.
	 */
	const PLUGIN_SLUG = 'multibanco-ifthen-software-gateway-for-woocommerce';

	/**
	 * Our icon
	 */
	const ICON_URL = 'https://ps.w.org/multibanco-ifthen-software-gateway-for-woocommerce/assets/icon-256x256.gif';

	/**
	 * ISO 3166-1 alpha-2 code of the only country for which the entry is shown.
	 *
	 * Compared against the REST `location` request parameter (with fallback to
	 * `WC()->countries->get_base_country()`) so the entry only appears on stores
	 * whose base country is Portugal.
	 */
	const ALLOWED_COUNTRY = 'PT';

	/**
	 * `user_meta` key used to persist a per-user "hide this suggestion" flag.
	 *
	 * Set by the dismiss REST route, read on every subsequent REST filter call
	 * to short-circuit injection for that user.
	 */
	const DISMISSED_USER_META = '_nakedcat_recommend_ifthenpay_dismissed';

	/**
	 * WooCommerce REST route to intercept to inject the entry.
	 */
	const PROVIDERS_ROUTE = '/wc-admin/settings/payments/providers';

	/**
	 * Number of seconds a dismissal is remembered before the suggestion reappears.
	 */
	const DISMISS_DURATION = 180 * 86400; // 180 days in seconds.

	/**
	 * Namespace for the REST routes.
	 *
	 * Kept separate from Woo's `wc-admin` namespace so the custom suggestion id
	 * doesn't collide with Woo's built-in `suggestion/{id}/hide` handler, which
	 * only knows about Woo-registered suggestions and would 404 for custom suggestions.
	 */
	const DISMISS_NAMESPACE = 'nakedcat-recommend-ifthenpay/v1';

	/**
	 * Array of translatable strings.
	 *
	 * @var array
	 */
	private $strings = array();

	/**
	 * Initialize the plugin by registering hooks.
	 */
	public function init() {
		$this->strings = $this->get_strings();
		$this->register_hooks();
	}

	/**
	 * Build the UI strings for the current admin locale.
	 *
	 * @return array
	 */
	private function get_strings(): array {
		$strings      = array(
			'recommended_for_portugal' => 'Recommended for Portugal',
			'about_url'                => 'https://wordpress.org/plugins/multibanco-ifthen-software-gateway-for-woocommerce/',
			'pricing_url'              => 'https://ifthenpay.com/?lang=en#tarifario',
			'description'              => 'Receive payments from customers in Portugal and around the world with Ifthenpay, the most comprehensive Portuguese payment processor for WooCommerce stores.',
			'title'                    => 'Multibanco, MB WAY, Apple Pay, Google Pay, PIX and more',
		);
		$admin_locale = $this->get_admin_locale();
		if ( stripos( $admin_locale, 'pt' ) === 0 ) {
			$strings = array(
				'recommended_for_portugal' => 'Recomendado para Portugal',
				'about_url'                => 'https://pt.wordpress.org/plugins/multibanco-ifthen-software-gateway-for-woocommerce/',
				'pricing_url'              => 'https://ifthenpay.com/?lang=pt#tarifario',
				'description'              => 'Receba pagamentos de clientes em Portugal e no mundo com a Ifthenpay, o processador de pagamentos Português mais completo para lojas WooCommerce.',
				'title'                    => 'Multibanco, MB WAY, Apple Pay, Google Pay, PIX e mais',
			);
		}
		return $strings;
	}

	/**
	 * Get the current admin locale.
	 *
	 * @return string
	 */
	private function get_admin_locale(): string {
		if ( is_admin() && function_exists( 'get_user_locale' ) ) {
			return (string) get_user_locale();
		}
		if ( function_exists( 'determine_locale' ) ) {
			return (string) determine_locale();
		}
		return (string) get_locale();
	}

	/**
	 * Register hooks.
	 */
	public function register_hooks() {
		add_filter( 'rest_request_after_callbacks', array( $this, 'inject_suggestion' ), 10, 3 );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		add_action( 'admin_print_styles-woocommerce_page_wc-settings', array( $this, 'print_entry_styles' ) );
	}

	/**
	 * Register REST routes.
	 */
	public function register_routes() {

		register_rest_route(
			self::DISMISS_NAMESPACE,
			'/dismiss',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'rest_dismiss' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_woocommerce' ); // phpcs:ignore WordPress.WP.Capabilities.Unknown
				},
			)
		);
	}

	/**
	 * Print the inline styles scoped to the injected Ifthenpay entry.
	 */
	public function print_entry_styles() {
		$id = self::SUGGESTION_ID;

		$pill_text = '🇵🇹 ' . $this->strings['recommended_for_portugal'];
		$pill_text = str_replace(
			array( '\\', '"', '</' ),
			array( '\\\\', '\\"', '<\/' ),
			$pill_text
		);

		printf(
			'<style id="nakedcat-recommend-ifthenpay-styles">'
			. '#%1$s .woocommerce-official-extension-badge{display:none !important;}'
			. '#%1$s .woocommerce-list__item-title::after{'
				. 'content:"%2$s";'
				. 'display:inline-block;'
				. 'margin-left:8px;'
				. 'padding:2px 8px;'
				. 'background:#e3f5ff;'
				. 'color:#000000;'
				. 'border-radius:3px;'
				. 'font-weight:400;'
				. 'font-size:11px;'
				. 'line-height:1.6;'
				. 'vertical-align:middle;'
			. '}'
			. '.other-payment-gateways__content__grid-item:has(img[src*="' . esc_attr( self::PLUGIN_SLUG ) . '"]) .woocommerce-official-extension-badge__container {display:none !important;}'
			. '</style>' . "\n",
			esc_attr( $id ),
			$pill_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	/**
	 * Inject the Ifthenpay suggestion into the WooCommerce payment providers REST response.
	 *
	 * @param \WP_HTTP_Response|\WP_Error $response The response object.
	 * @param array                       $handler  The matched route handler.
	 * @param \WP_REST_Request            $request  The request.
	 * @return \WP_HTTP_Response|\WP_Error
	 */
	public function inject_suggestion( $response, $handler, $request ) {

		if ( ! ( $response instanceof \WP_REST_Response ) ) {
			return $response;
		}

		if ( self::PROVIDERS_ROUTE !== $request->get_route() ) {
			return $response;
		}

		// Only inject when WooCommerce is active and Ifthenpay is not already active.
		if ( ! class_exists( 'WooCommerce' ) || function_exists( 'mbifthen_init' ) ) {
			return $response;
		}

		// Country gate: use the request's location param, fall back to WC base country.
		$location = $request->get_param( 'location' );

		if ( empty( $location ) && function_exists( 'WC' ) && WC()->countries ) {
			$location = WC()->countries->get_base_country();
		}

		if ( self::ALLOWED_COUNTRY !== strtoupper( (string) $location ) ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
			// If a Portuguese plugin is installed, why would we want to remove this?
			// return $response;
		}

		$data = $response->get_data();

		if ( ! is_array( $data ) || ! isset( $data['providers'] ) || ! is_array( $data['providers'] ) ) {
			return $response;
		}

		// Add to "More payment options" section - No dismissal possuble
		array_unshift( $data['suggestions'], $this->build_suggestion_entry() );
		array_unshift( $data['suggestion_categories'], $this->build_suggestion_category_entry() );

		$response->set_data( $data );

		// Per-user dismiss: hide for 180 days from the stored timestamp.
		$dismissed_at = (int) get_user_meta( get_current_user_id(), self::DISMISSED_USER_META, true );
		if ( $dismissed_at && ( time() - $dismissed_at ) < self::DISMISS_DURATION ) {
			return $response;
		}

		// Don't duplicate if an entry with the same id (or Woo already promoted the real Ifthenpay plugin) is present.
		foreach ( $data['providers'] as $provider ) {
			if ( ! empty( $provider['id'] ) && self::SUGGESTION_ID === $provider['id'] ) {
				return $response;
			}

			if ( ! empty( $provider['plugin']['slug'] ) && self::PLUGIN_SLUG === $provider['plugin']['slug'] ) {
				return $response;
			}
		}

		// Add payment entry to the beginning of the providers list so it appears at the top of the list in the UI.
		array_unshift( $data['providers'], $this->build_payment_entry() );

		$response->set_data( $data );

		return $response;
	}

	/**
	 * Build a provider-list entry that mirrors the shape WooCommerce uses for
	 * promoted suggestions.
	 *
	 * @return array
	 */
	private function build_payment_entry(): array {

		return array(
			'id'             => self::SUGGESTION_ID,
			'_suggestion_id' => self::SUGGESTION_ID,
			'_type'          => 'suggestion', // PaymentsProviders::TYPE_SUGGESTION
			'_order'         => -1, // Force top of list.
			'title'          => esc_html( $this->strings['title'] ),
			'description'    => esc_html( $this->strings['description'] ),
			'image'          => esc_url( self::ICON_URL ),
			'icon'           => esc_url( self::ICON_URL ),
			'plugin'         => array(
				'_type'  => 'wporg', // PaymentsProviders::EXTENSION_TYPE_WPORG
				'slug'   => self::PLUGIN_SLUG,
				'status' => $this->detect_plugin_status(),
			),
			'links'          => array(
				array(
					'_type' => 'about',
					'url'   => esc_url( $this->strings['about_url'] ),
				),
				array(
					'_type' => 'pricing',
					'url'   => esc_url( $this->strings['pricing_url'] ),
				),
			),
			'tags'           => array( 'preferred' ),
			'category'       => 'category_other',
			'_links'         => array(
				'hide' => array(
					'href' => rest_url( self::DISMISS_NAMESPACE . '/dismiss' ),
				),
			),
		);
	}

	/**
	 * Build a suggestion category entry that mirrors the shape WooCommerce uses for
	 * promoted suggestion categories.
	 *
	 * @return array
	 */
	private function build_suggestion_category_entry(): array {
		return array(
			'id'          => self::SUGGESTION_ID,
			'_priority'   => -1, // Force top of list.
			'title'       => esc_html( $this->strings['recommended_for_portugal'] ),
			'description' => esc_html( $this->strings['description'] ),
		);
	}

	/**
	 * Build a suggestion entry that mirrors the shape WooCommerce uses for
	 * promoted suggestions.
	 *
	 * @return array
	 */
	private function build_suggestion_entry(): array {
		return array(
			'id'          => self::SUGGESTION_ID,
			'_type'       => self::SUGGESTION_ID, // Our own category.
			'title'       => esc_html( $this->strings['title'] ),
			'description' => esc_html( $this->strings['description'] ),
			'icon'        => esc_url( self::ICON_URL ),
			'plugin'      => array(
				'_type' => 'wporg', // WordPress.org
				'slug'  => self::PLUGIN_SLUG,
			),
			'links'       => array(
				array(
					'_type' => 'about',
					'url'   => esc_url( $this->strings['about_url'] ),
				),
				array(
					'_type' => 'pricing',
					'url'   => esc_url( $this->strings['pricing_url'] ),
				),
			),
			'tags'        => array( 'preferred' ),
		);
	}

	/**
	 * Detect the install/active status of the target Ifthenpay plugin so the
	 * React UI shows the correct "Install" or "Activate" button.
	 *
	 * @return string One of not_installed, installed, active.
	 */
	private function detect_plugin_status(): string {

		if ( function_exists( 'mbifthen_init' ) ) {
			return 'active'; // PaymentsProviders::EXTENSION_ACTIVE
		}

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$installed = get_plugins();

		foreach ( $installed as $plugin_file => $plugin_data ) {
			if ( 0 === strpos( $plugin_file, self::PLUGIN_SLUG . '/' ) ) {
				return 'installed'; // PaymentsProviders::EXTENSION_INSTALLED
			}
		}

		return 'not_installed'; // PaymentsProviders::EXTENSION_NOT_INSTALLED
	}

	/**
	 * REST callback for the dismiss route. Stores a per-user flag so the
	 * suggestion is not re-injected on subsequent page loads.
	 */
	public function rest_dismiss() {

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return new \WP_Error(
				'not_logged_in',
				'You must be logged in.',
				array(
					'status' => 401,
				)
			);
		}

		update_user_meta( $user_id, self::DISMISSED_USER_META, time() );

		return rest_ensure_response( array( 'success' => true ) );
	}
}
