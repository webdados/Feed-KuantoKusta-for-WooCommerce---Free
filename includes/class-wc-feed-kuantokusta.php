<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Our main class
 *
 */
final class WC_Feed_KuantoKusta {
	
	/* ID, Version, Plugin mode */
	public $id           = 'wc_feed_kuantokusta';
	public $version      = false;
	public $mode         = '';
	public $out_link_utm = '';

	/* Settings */
	public $settings = array();

	/* Single instance */
	protected static $_instance = null;

	/* Constructor */
	public function __construct() {
		if ( ! function_exists( 'get_plugin_data' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Should not be necessary, but we never know...
		$data = get_plugin_data( KUANTOKUSTA_FREE_PLUGIN_FILE, false, false );
		$this->version = $data['Version'];
		// Hooks
		$this->init_hooks();
		// Settings
		$this->init_settings();
	}

	/* Ensures only one instance of our plugin is loaded or can be loaded */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/* Hooks */
	private function init_hooks() {
		// Re-init settings to get the default values from the Pro version
		add_filter( 'init', array( $this, 'init_settings' ), PHP_INT_MAX ); // After the Pro plugin
		// Add settings
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab'), 999 );
		add_action( 'woocommerce_settings_tabs_kuantokusta', array( $this, 'settings_tab' ) );
		add_action( 'woocommerce_update_options_kuantokusta', array( $this, 'update_settings' ) );
		// Add Documentation URL information
		add_action( 'kuantokusta_documentation_before_fields', array( $this, 'documentation_before_fields' ) );
		// Custom product fields
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'woocommerce_product_data_tabs' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'woocommerce_product_data_panels' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'woocommerce_process_product_meta' ) );
		// Add feed
		add_action( 'init', array( $this, 'add_products_feed' ) );
		// Add tracking
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'woocommerce_order_details_after_order_table', array( $this, 'add_tracking_order' ) );
	}

	/* Enqueue frontend scripts */
	public function wp_enqueue_scripts() {
		if ( $tracking_code = trim( get_option( $this->id.'_tracking_code' ) ) ) {
			wp_enqueue_script( $this->id.'_tracking', plugin_dir_url( __FILE__ ) . '../assets/js/tracking.js', array(), $this->version, false );
			$url = parse_url( get_home_url() );
			wp_localize_script( $this->id.'_tracking', $this->id, array(
				'storeId'    => $tracking_code,
				'serverAddr' => $url['host'],
			) );
		}
	}

	/* Init settings */
	public function init_settings() {
		// Vars
		$this->out_link_utm = '?utm_source='.rawurlencode( esc_url( home_url( '/' ) ) ).'&amp;utm_medium=link&amp;utm_campaign=kk_woocommerce_plugin';
		// Mode
		$this->mode = get_option( $this->id.'_plugin_mode' ) != '' ? get_option( $this->id.'_plugin_mode' ) : 'comparison';
		// Settings
		$temp = $this->get_settings();
		foreach ( $temp as $key => $value ) {
			if ( isset( $value['id_'] ) && $value['id_'] != '' ) {
				$this->settings[ $value['id_'] ] = get_option( $value['id'] );
			}
		}
	}

	/* Get setting */
	public function get_setting( $setting ) {
		if ( isset( $this->settings[ $setting ] ) ) {
			return $this->settings[ $setting ];
		}
		return '';
	}

	/* Add settings */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['kuantokusta'] = apply_filters( 'kuantokusta_settings_tab_title', __( 'KuantoKusta', 'feed-kuantokusta-for-woocommerce' ) );
		return $settings_tabs;
	}
	public function get_settings() {

		// General
		$settings = array(
			'general_section_title' => array(
				'name'		=> __( 'General', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'title',
			),
			'plugin_mode' => array(
				'name'     => __( 'Mode', 'feed-kuantokusta-for-woocommerce' ),
				'type'     => 'select',
				'desc'     => __( 'Are you using KuantoKusta in Price comparison or Marketplace mode?', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip' => true,
				'id_'      => 'plugin_mode',
				'options'  => array(
					'marketplace' => __( 'Marketplace', 'feed-kuantokusta-for-woocommerce' ),
					'comparison'  => __( 'Price comparison', 'feed-kuantokusta-for-woocommerce' ) . ' - ' . __( 'Deprecated', 'feed-kuantokusta-for-woocommerce' ),
				),
			),
			'product_types' => array(
				'name'		=> __( 'Product types', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'multiselect',
				'desc'		=> __( 'Select which product types should be included in the KuantoKusta feed', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip'	=> true,
				'id_'		=> 'product_types',
				'options'	=> wc_get_product_types(),
				'class'         => 'wc-enhanced-select',
			),
			'general_section_end' => array(
				'type'		=> 'sectionend',
			)
		);

		// Deprecate "Price comparison"
		if ( $this->mode === 'comparison' ) {
			$settings['plugin_mode']['desc_tip'] = false;
			$settings['plugin_mode']['desc'] .= sprintf(
				' <br/><span style="color: red;">%s</span>',
				__( 'The “Price comparison” mode is deprecated and we don’t recommend you use it anymore, as it will be removed shortly', 'feed-kuantokusta-for-woocommerce' )
			);
		}
		
		// Tracking
		$settings = array_merge( $settings, array(
			'tracking_section_title' => array(
				'name'		=> __( 'Tracking', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'title',
				'desc'		=> __( 'KuantoKusta tracking code functionalities, so that you can see navigation and conversion stats on their dashboard.', 'feed-kuantokusta-for-woocommerce' ),
			),
			'tracking_code'         => array(
				'name'		        => __( 'Tracking code', 'feed-kuantokusta-for-woocommerce' ),
				'type'		        => 'text',
				'desc'		        => __( 'The tracking code provided by KuantoKusta (optional)', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip'	        => true,
				'id_'		        => 'tracking_code',
				'placeholder'       => 'KK-XXXXX-XX',
				'custom_attributes' => array(
					'pattern'     => 'KK-([0-9]{4,9})-([0-9]{1,4})',
				),
			),
			'tracking_section_end' => array(
				'type'		 => 'sectionend',
			)
		) );
		
		// Variable products
		$settings = array_merge( $settings, array(
			'variations_section_title' => array(
				'name'		=> __( 'Variable products', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'title',
				'desc'		=> __( 'If you choose to include each product variation to the KuantoKusta feed, the product variation title will be set from the base variable product title concatenated with the variation description.', 'feed-kuantokusta-for-woocommerce' ),
			),
			'variable_show_method' => array(
				'name'		=> __( 'Include', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'select',
				'desc'		=> __( 'How should variable products be included in the feed', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip'	=> true,
				'id_'		=> 'variable_show_method',
				'options'	=> array(
					'base'		=> __( 'Only base variable product (with lower price)', 'feed-kuantokusta-for-woocommerce' ),
					'variation'	=> __( 'Each product variation', 'feed-kuantokusta-for-woocommerce' ),
				),
				'default' 	=> 'base',
			),
			'variations_section_end' => array(
				'type'		=> 'sectionend',
			)
		) );
		
		// Product description
		$settings = array_merge( $settings, array(
			'description_section_title' => array(
				'name'		=> __( 'Product description', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'title',
			),
			'description_type' => array(
				'name'		=> __( 'Get description from', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'select',
				'desc'		=> __( 'Where to get the product description from', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip'	=> true,
				'id_'		=> 'description_type',
				'options'	=> array(
					'full'		=> __( 'Full product description (defaults to short description if empty)', 'feed-kuantokusta-for-woocommerce' ),
					'short'	=> __( 'Short product description', 'feed-kuantokusta-for-woocommerce' ),
				),
				'default' 	=> 'base',
			),
			'description_section_end' => array(
				'type'		=> 'sectionend',
			)
		) );

		if ( $this->mode == 'marketplace' ) {
			// Product stock
			$settings = array_merge( $settings, array(
				'stock_section_title' => array(
					'name'		=> __( 'Product stock', 'feed-kuantokusta-for-woocommerce' ),
					'type'		=> 'title',
					'desc'		=> __( 'KuantoKusta marketplace requires the definition of a numeric stock value for all the products.', 'feed-kuantokusta-for-woocommerce' ),
				),
				'stock_default' => array(
					'name'		=> __( 'Default stock', 'feed-kuantokusta-for-woocommerce' ),
					'type'		=> 'number',
					'desc'		=> __( 'Default stock value for products not managing stock', 'feed-kuantokusta-for-woocommerce' ),
					'desc_tip'	=> true,
					'id_'		=> 'stock_default',
					'default' 	=> 1,
					'custom_attributes' => array(
						'min' => 1,
					),
				),
				'stock_section_end' => array(
					'type'		=> 'sectionend',
				),
			) );
		}
		
		// Product shipping
		$settings = array_merge( $settings, array(
			'shipping_section_title' => array(
				'name'		=> __( 'Product shipping', 'feed-kuantokusta-for-woocommerce' ),
				'type'		=> 'title',
				'desc'		=> __( 'KuantoKusta requires the definition of a shipping value for each product submitted to the feed. According to how WooCommerce calculates the shipping costs, it may not be possible to include the exact value in the feed. If you need exact shipping cost, custom development will be needed.', 'feed-kuantokusta-for-woocommerce' ),
			),
			'shipping_cost_default' => array(
				'name'		=> __( 'Default cost', 'feed-kuantokusta-for-woocommerce' ).' ('.get_woocommerce_currency_symbol().')',
				'type'		=> 'text',
				'desc'		=> __( 'Default shipping cost (with tax) per product (can be overriden at the product level)', 'feed-kuantokusta-for-woocommerce' ),
				'desc_tip'	=> true,
				'id_'		=> 'shipping_cost_default',
			)
		) );
		if ( $this->mode == 'marketplace' ) {
			$settings = array_merge( $settings, array(
				'preparation_days_max_default' => array(
					'name'		=> __( 'Maximum preparation time', 'feed-kuantokusta-for-woocommerce' ).' ('.__( 'days', 'feed-kuantokusta-for-woocommerce' ).')',
					'type'		=> 'number',
					'desc'		=> __( 'The default maximum amount of days a product takes to be prepared before it is shipped', 'feed-kuantokusta-for-woocommerce' ),
					'desc_tip'	=> true,
					'id_'		=> 'preparation_days_max_default',
					'custom_attributes' => array(
						'min' => 0,
					),
				),
				'delivery_days_max_default' => array(
					'name'		=> __( 'Maximum delivery time', 'feed-kuantokusta-for-woocommerce' ).' ('.__( 'days', 'feed-kuantokusta-for-woocommerce' ).')',
					'type'		=> 'number',
					'desc'		=> __( 'The default maximum amount of days the shipping of a product takes', 'feed-kuantokusta-for-woocommerce' ),
					'desc_tip'	=> true,
					'id_'		=> 'delivery_days_max_default',
					'custom_attributes' => array(
						'min' => 0,
					),
				),
			) );
		}
		$settings = array_merge( $settings, array(
			'shipping_section_end' => array(
				'type'		=> 'sectionend',
			),
		) );
		$settings = apply_filters( 'wc_settings_kuantokusta_settings', $settings, $this->mode );

		foreach ( $settings as $key => $value ) {
			if ( isset( $value['id_'] ) && $value['id_'] != '' ) {
				$settings[$key]['id'] = $this->id.'_'.$value['id_'];
			}
		}

		return $settings;
	}
	public function settings_tab() {
		include( dirname( __FILE__ ) . '/admin/settings-page.php' );
	}
	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
		do_action( 'woocommerce_update_options_kuantokusta_after' );
		wp_safe_redirect( 'admin.php?page=wc-settings&tab=kuantokusta' );
	}

	/* Add Documentation URL information */
	public function documentation_before_fields() {
		include( dirname( __FILE__ ) . '/admin/settings-page-documentation-before-fields.php' );
	}

	/* Add settings link to plugin actions */
	public function add_settings_link( $links ) {
		$action_links = array(
			'kk_settings' => '<a href="admin.php?page=wc-settings&amp;tab=kuantokusta">' . __( 'Settings', 'feed-kuantokusta-for-woocommerce' ) . '</a>',
		);
		return array_merge( $action_links, $links );
	}

	/* Add our own product fields */
	public function woocommerce_product_data_tabs( $tabs ) {
		$tabs['kuantokusta'] = array(
			'label'  => apply_filters( 'kuantokusta_settings_tab_title', __( 'KuantoKusta', 'feed-kuantokusta-for-woocommerce' ) ),
			'target' => 'kuantokusta',
			'class'  => array(),
			'priority' => 9999,
		);
		return $tabs;
	}
	public function woocommerce_product_data_panels() {
		global $post;
		$product = wc_get_product( $post->ID );
		?>
		<div id="kuantokusta" class="panel woocommerce_options_panel">
			<div class="options_group">
				<p>
					<strong><?php _e( 'The fields below are only used on the KuantoKusta products feed', 'feed-kuantokusta-for-woocommerce' ); ?></strong>
				</p>
				<?php
				// Hide it?
				woocommerce_wp_checkbox( array(
					'id'			=> '_kuantokusta_hide',
					'label'			=> __( 'Hide from feed', 'feed-kuantokusta-for-woocommerce' ),
				) );
				// EAN - It should be by variation... - It is on the Pro Add-on
				if (
					version_compare( WC_VERSION, '9.2', '<' )
					||
					(
						version_compare( WC_VERSION, '9.2', '>=' )
						&&
						empty( $product->get_global_unique_id() )
						&&
						! empty( $product->get_meta( '_kuantokusta_ean' ) )
					)
				) {
					$ean_description = '';
					if ( version_compare( WC_VERSION, '9.2', '>=' ) ) {
						$ean_description = '<span style="color: red">' . esc_html__( 'The EAN / UPC should now be set on the WooCommerce “GTIN, UPC, EAN or ISBN” field on the Inventory tab - once you fill that field, this one will be removed', 'feed-kuantokusta-for-woocommerce' ) . '</span>';
					}
					woocommerce_wp_text_input( array(
						'id'			=> '_kuantokusta_ean',
						'label'			=> __( 'EAN / UPC', 'feed-kuantokusta-for-woocommerce' ),
						'placeholder'	=> __( 'Barcode', 'feed-kuantokusta-for-woocommerce' ),
						'description'   => $ean_description
					) );
				} else {
					?>
					<p class="form-field _kuantokusta_ean_field ">
						<label>
							<?php esc_html_e( 'EAN / UPC', 'feed-kuantokusta-for-woocommerce' ); ?>
						</label>
						<?php esc_html_e( 'The EAN / UPC is now set on the WooCommerce “GTIN, UPC, EAN or ISBN” field on the Inventory tab', 'feed-kuantokusta-for-woocommerce' ); ?>
					</p>
					<?php
				}
				// Brand
				if (
					version_compare( WC_VERSION, '9.6', '<' )
					||
					(
						version_compare( WC_VERSION, '9.6', '>=' )
						&&
						empty( $this->get_product_brands_terms( $product ) )
						&&
						! empty( $product->get_meta( '_kuantokusta_brand' ) )
					)
				) {
					$brand_description = '';
					if ( version_compare( WC_VERSION, '9.6', '>=' ) ) {
						$brand_description = '<span style="color: red">' . esc_html__( 'The Brand should now be set on the WooCommerce “Brands” taxonomy - once you set them there, this field will be removed', 'feed-kuantokusta-for-woocommerce' ) . '</span>';
					}
					woocommerce_wp_text_input( array(
						'id'			=> '_kuantokusta_brand',
						'label'			=> __( 'Brand', 'feed-kuantokusta-for-woocommerce' ),
						'description'   => $brand_description
					) );
				} else {
					?>
					<p class="form-field _kuantokusta_ean_field ">
						<label>
							<?php esc_html_e( 'Brand', 'feed-kuantokusta-for-woocommerce' ); ?>
						</label>
						<?php esc_html_e( 'The Brand is now set on the WooCommerce “Brands” taxonomy', 'feed-kuantokusta-for-woocommerce' ); ?>
						<?php
						$brand_terms = $this->get_product_brands_terms( $product );
						if ( count( $brand_terms ) > 1 ) {
							?>
							<br/>
							<span style="color: red">
								<?php
								echo esc_html(
									sprintf(
										__( 'Kuanto Kusta only supports one brand, and you have more than one set. The current brand on the feed is “%s”.', 'feed-kuantokusta-for-woocommerce' ),
										$brand_terms[0]->name
									)
								);
								?>
							</span>
							<?php
						}
						?>
					</p>
					<?php
				}
				// Shipping cost
				woocommerce_wp_text_input( array(
					'id'			=> '_kuantokusta_shipping',
					'label'			=> __( 'Shipping cost', 'feed-kuantokusta-for-woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
					'placeholder'	=> sprintf( __( 'With tax - Blank for default (%s)', 'feed-kuantokusta-for-woocommerce' ), $this->get_setting( 'shipping_cost_default' ) ),
					'data_type'		=> 'price',
				) );
				if ( $this->mode == 'marketplace' ) {
					// Preparation days
					woocommerce_wp_text_input( array(
						'id'			    => '_kuantokusta_preparation_days_max',
						'label'			    => __( 'Maximum preparation time', 'feed-kuantokusta-for-woocommerce' ).' ('.__( 'days', 'feed-kuantokusta-for-woocommerce' ).')',
						'placeholder'	    => sprintf( __( 'Blank for default (%s)', 'feed-kuantokusta-for-woocommerce' ), $this->get_setting( 'preparation_days_max_default' ) ),
						'type'		        => 'number',
						'custom_attributes' => array(
							'min' => 0,
						),
					) );
					// Delivery days
					woocommerce_wp_text_input( array(
						'id'			    => '_kuantokusta_delivery_days_max',
						'label'			    => __( 'Maximum delivery time', 'feed-kuantokusta-for-woocommerce' ).' ('.__( 'days', 'feed-kuantokusta-for-woocommerce' ).')',
						'placeholder'	    => sprintf( __( 'Blank for default (%s)', 'feed-kuantokusta-for-woocommerce' ), $this->get_setting( 'delivery_days_max_default' ) ),
						'type'		        => 'number',
						'custom_attributes' => array(
							'min' => 0,
						),
					) );
				}
				// Action for integration...
				do_action( 'kuantokusta_product_data_panel_end' );
				?>
			</div>
			<script type="text/javascript">
				jQuery( function( $ ) {
					function kk_hide_fields() {
						if ( $( '#_kuantokusta_hide' ).is(":checked") ) {
							$( '#kuantokusta p.form-field' ).hide();
							$( '#kuantokusta p.kuantokusta-title' ).hide();
							$( '#kuantokusta  p.form-field._kuantokusta_hide_field' ).show();
						} else {
							$( '#kuantokusta p.form-field' ).show();
							$( '#kuantokusta p.kuantokusta-title' ).show();
						}
					}
					kk_hide_fields();
					$( '#_kuantokusta_hide' ).on( 'change', function() {
						kk_hide_fields();
					} );
				} );
			</script>
			<style type="text/css">
				#woocommerce-product-data ul.wc-tabs li.kuantokusta_options a::before,
				.kuantokusta_plugin_title::before {
					content: url('<?php echo esc_url( plugins_url( '../images/kk_icon.svg', __FILE__ ) ); ?>');
					width: 13px;
					height: 13px;
					display: inline-block;
				}
			</style>
		</div>
		<?php
	}

	/* Admin - Save fields */
	public function woocommerce_process_product_meta( $post_id ) {
		$meta    = array();
		$product = wc_get_product( $post_id );
		// Hide
		$meta['_kuantokusta_hide'] = ! empty( $_POST['_kuantokusta_hide'] ) ? wc_clean( $_POST['_kuantokusta_hide'] ) : '';
		// EAN
		$meta['_kuantokusta_ean'] = isset( $_POST['_kuantokusta_ean'] ) && ! empty( $_POST['_kuantokusta_ean'] ) ? wc_clean( $_POST['_kuantokusta_ean'] ) : '';
		if ( version_compare( WC_VERSION, '9.2', '>=' ) && ! empty( $_POST['_global_unique_id'] ) ) {
			// If the core field is filled in, remove ours from the database
			unset( $meta['_kuantokusta_ean'] );
			$product->delete_meta_data( '_kuantokusta_ean' );
		}
		// Brand
		$meta['_kuantokusta_brand'] = isset( $_POST['_kuantokusta_brand'] ) && ! empty( $_POST['_kuantokusta_brand'] ) ? wc_clean( $_POST['_kuantokusta_brand'] ) : '';
		if ( version_compare( WC_VERSION, '9.6', '>=' ) && ! empty( $this->get_product_brands_terms( $product ) ) ) {
			// If the core field is filled in, remove ours from the database
			unset( $meta['_kuantokusta_brand'] );
			$product->delete_meta_data( '_kuantokusta_brand' );
		}
		// Shipping
		$meta['_kuantokusta_shipping'] = trim( $_POST['_kuantokusta_shipping'] ) != '' ? wc_clean( $_POST['_kuantokusta_shipping'] ) : '';
		// Shipping
		$meta['_kuantokusta_preparation_days_max'] = ! empty( $_POST['_kuantokusta_preparation_days_max'] ) ? wc_clean( $_POST['_kuantokusta_preparation_days_max'] ) : '';
		// Shipping
		$meta['_kuantokusta_delivery_days_max'] = ! empty( $_POST['_kuantokusta_delivery_days_max'] ) ? wc_clean( $_POST['_kuantokusta_delivery_days_max'] ) : '';
		// Filter for integration ( Use this filter to add to $meta the keys/values of the fields added by the `kuantokusta_product_data_panel_end` action )
		$meta = apply_filters( 'kuantokusta_process_product_meta', $meta );
		// Update meta - CRUD
		foreach ( $meta as $key => $value ) {
			$product->update_meta_data( $key, $value );
		}
		$product->save();
		// Action for integration - ONLY if the filter above was not used
		do_action( 'kuantokusta_process_product_meta_end', $post_id );
	}

	/* Add feed */
	public function add_products_feed() {
		add_feed( 'kuantokusta', array( $this, 'render_products_feed' ) );
	}

	/* Render feed */
	/**
	 * Render feed.
	 * KK rules at https://sites.google.com/kk.pt/estruturafeedskk/regras-para-cria%C3%A7%C3%A3o?authuser=0
	 */
	public function render_products_feed() {
		// Missing plugins cache constant
		define( 'KK_IS_FEED', true );
		@define( 'DONOTCACHEPAGE', true ); // Cache plugins
		header( 'Content-Type: application/rss+xml; charset=utf-8' );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() - 1 ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
		header( 'Cache-Control: post-check=0, pre-check=0', false) ;
		header( 'Pragma: no-cache' );
		$offset = intval( isset( $_GET['LIMIT'] ) ? $_GET['LIMIT'] : 0 );
		$posts_per_page = intval( isset( $_GET['TOTAL_PRODUTOS'] ) ? $_GET['TOTAL_PRODUTOS'] : -1 );
		echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>
';
		?>
<products><?php
		// Exclude products - Not CRUD ready
		global $wpdb;
		$exclude = array();
		$sql_exclude = "SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE ( meta_key = '_kuantokusta_hide' AND meta_value = 'yes' )";
		// Debug and only include specific SKU
		if ( isset( $_GET['sku'] ) && trim( $_GET['sku'] ) != '' ) {
			$sql_exclude .= " || ( meta_key = '_sku' AND meta_value NOT LIKE '%".sanitize_text_field( trim( $_GET['sku'] ) )."%' )";
		}
		if ( $results = $wpdb->get_results( $sql_exclude, ARRAY_A ) ) {
			if ( count( $results ) > 0 ) {
				foreach ( $results as $value ) {
					$exclude[] = intval( $value['post_id'] );
				}
			}
		}
		// Query - Current WordPress
		$args = array(
			'status' => 'publish',
			'type' => $this->get_setting( 'product_types' ),
			'limit' => $posts_per_page,
			'offset' => $offset,
		);
		if ( count( $exclude ) > 0 ) $args['exclude'] = $exclude;
		$args = apply_filters( 'kuantokusta_query_args', $args );
		$products = wc_get_products( $args );
		if ( count( $products ) > 0 ) {
			foreach ( $products as $product ) {
				$product_type = $product->get_type();
				if ( apply_filters( 'kuantokusta_product_node_show', true, $product, $product_type ) ) {
					switch ( $product_type ) {
						case 'variable':
							switch ( $this->get_setting( 'variable_show_method' ) ) {
								case 'variation':
									$variations = $product->get_available_variations();
									foreach ( $variations as $variation ) {
										$variation = wc_get_product( $variation['variation_id'] );
										if ( apply_filters( 'kuantokusta_variation_node_show', true, $product, $variation ) ) {
											$product_node = $this->render_product_feed_variation( $product, $variation );
											echo apply_filters( 'kuantokusta_product_node_variation', $product_node, $product, $variation );
										}
									}
									break;
								case 'base':
								default:
									// Just like simple products
									$product_node = $this->render_product_feed_default( $product, $product_type );
									echo apply_filters( 'kuantokusta_product_node_default', $product_node, $product, $product_type );
									break;
							}
							break;
						default: // Including 'simple'
							$product_node = $this->render_product_feed_default( $product, $product_type );
							echo apply_filters( 'kuantokusta_product_node_default', $product_node, $product, $product_type );
							break;
					}
				}
			}
		}
		?>

</products>
		<?php
	}

	/* Render default/simple feed */
	public function render_product_feed_default( $product, $product_type ) {
		$id_product    = $product->get_id();
		$url           = $product->get_permalink();
		$title         = apply_filters( 'kuantokusta_product_node_default_title', trim( $product->get_title() ), $product, $product_type );
		$regular_price = apply_filters( 'kuantokusta_product_node_default_regular_price', wc_get_price_including_tax( $product, array( 'price' => $product->get_regular_price() ) ), $product, $product_type ); // With VAT
		$current_price = apply_filters( 'kuantokusta_product_node_default_current_price', wc_get_price_including_tax( $product ),  $product, $product_type ); // With VAT
		if ( $current_price > $regular_price && apply_filters( 'kuantokusta_avoid_current_higher_regular', false ) ) {
			$current_price = $regular_price;
		}
		$stock         = apply_filters( 'kuantokusta_product_node_default_comparison_stock', $this->get_comparison_product_stock( $product ), $product, $product_type );
		$categories    = apply_filters( 'kuantokusta_product_node_default_categories', $this->get_product_category( $id_product ), $product, $product_type );
		$image         = apply_filters( 'kuantokusta_product_node_default_image', $this->get_product_image( $product ), $product, $product_type );
		$description   = apply_filters( 'kuantokusta_product_node_default_description', $this->get_product_description( $product ), $product, $product_type );
		$brand         = apply_filters( 'kuantokusta_product_node_default_brand', $this->get_product_brand( $product ), $product, $product_type );
		$ean           = apply_filters( 'kuantokusta_product_node_default_ean', $this->get_product_ean( $product ), $product, $product_type );
		$reference     = apply_filters( 'kuantokusta_product_node_default_reference', $product->get_sku(),  $product, $product_type );
		$weight        = apply_filters( 'kuantokusta_product_node_default_weight', $product->get_weight(),  $product, $product_type );
		$shipping_cost = apply_filters( 'kuantokusta_product_node_default_shipping', $this->get_product_shipping_cost( $product ), $product, $product_type );

		// Comparison and Marketplace
		$xml_fields = array(
			'mode'                     => array(
				'value' => trim( $this->mode ),
				'cdata' => false,
			),
			'woocommerce_product_type' => array(
				'value' => $product_type,
				'cdata' => false,
			),
			'id_product'               => array(
				'value' => trim( $id_product ),
				'cdata' => false,
			),
			'product_url'              => array(
				'value' => trim( $url ),
				'cdata' => true,
			),
			'designation'              => array(
				'value' => trim( $title ),
				'cdata' => true,
			),
			'regular_price'            => array(
				'value' => round( floatval( $regular_price ), wc_get_price_decimals() ),
				'cdata' => false,
			),
			'current_price'            => array(
				'value' => round( floatval( $current_price ), wc_get_price_decimals() ),
				'cdata' => false,
			),
			'stock'                    => array(
				'value' => $stock,
				'cdata' => false,
			),
			'category'                 => array(
				'value' => trim( $categories ),
				'cdata' => true,
			),
			'image_url'                => array(
				'value' => trim( $image ),
				'cdata' => true,
			),
			'description'              => array(
				'value' => trim( $description ),
				'cdata' => true,
			),
			'brand'                    => array(
				'value' => trim( $brand ),
				'cdata' => true,
			),
			'upc_ean'                  => array(
				'value' => trim( $ean ),
				'cdata' => true,
			),
			'reference'                => array(
				'value' => trim( $reference ),
				'cdata' => true,
			),
			'weight'                   => array(
				'value' => floatval( $weight ) > 0 ? floatval( $weight ).' '.get_option( 'woocommerce_weight_unit' ) : '',
				'cdata' => false,
			),
			'shipping_cost'            => array(
				'value' =>  ( trim( $shipping_cost ) != '' && floatval( $shipping_cost ) >= 0 ) ? round( floatval( $shipping_cost ), wc_get_price_decimals() ) : '',
				'cdata' => false,
			),
		);
		if ( $this->mode == 'marketplace' ) {
			// Marketplace
			unset( $xml_fields['stock'] );
			$stock_qty            = apply_filters( 'kuantokusta_product_node_default_marketplace_stock', $this->get_marketplace_product_stock( $product ), $product, $product_type );
			$stock_availability   = apply_filters( 'kuantokusta_product_node_default_marketplace_availability', $stock_qty > 0 ? 'Y' : 'N', $product, $product_type );
			$preparation_days_max = apply_filters( 'kuantokusta_product_node_default_preparation_days_max', $this->get_product_preparation_days_max( $product ), $product, $product_type );
			$delivery_days_max    = apply_filters( 'kuantokusta_product_node_default_delivery_days_max', $this->get_product_delivery_days_max( $product ), $product, $product_type );

			$xml_fields = array_merge( $xml_fields, array(
				'stock_qty'                    => array(
					'value' => $stock_qty,
					'cdata' => false,
				),
				'stock_availability'           => array(
					'value' => $stock_availability,
					'cdata' => false,
				),
				'preparation_days_max'     => array(
					'value' => ! empty( $preparation_days_max ) ? intval( $preparation_days_max ) : '',
					'cdata' => false,
				),
				'delivery_days_max'     => array(
					'value' => ! empty( $delivery_days_max ) ? intval( $delivery_days_max ) : '',
					'cdata' => false,
				),
			) );
		}
		$xml_fields = apply_filters( 'kuantokusta_product_node_default_xml_fields', $xml_fields, $product, $product_type );
		ob_start();
		?>
	<product>
<?php
		foreach ( $xml_fields as $key => $value ) {
			?>
		<<?php echo $key; ?>><?php echo $value['cdata'] ? '<![CDATA['.$value['value'].']]>' : $value['value'] ; ?></<?php echo $key; ?>>
<?php
		}
		// We should remove this filter in the future
		echo apply_filters( 'kuantokusta_product_node_default_extra_fields', '', $product, $product_type ); ?>
	</product>
<?php
		return ob_get_clean();
	}

	/* Render variation feed */
	public function render_product_feed_variation( $product, $variation ) {
		$id_variation = $variation->get_id();
		$id_product   = $product->get_id().'-'.$id_variation;
		$url          = $variation->get_permalink();
		$title        = trim( apply_filters( 'kuantokusta_product_node_pre_variation_title', $variation->get_name(), $product, $variation ) );
		if ( trim( $title ) == '' ) {
			$title = trim( $product->get_title() );
		}
		$reference = $variation->get_sku();
		if ( apply_filters( 'kuantokusta_product_node_variation_title_append_description', true, $product, $variation ) ) {
			if ( trim( $variation->get_description() ) != '' ) {
				// Variation description
				$title .= apply_filters( 'woocommerce_product_variation_title_attributes_separator', ' - ', $variation ).trim( $variation->get_description() );
			} else {
				if ( apply_filters( 'kuantokusta_product_node_variation_title_append_sku_or_id', true, $product, $variation ) ) {
					if ( trim( $reference ) != '' ) {
						// Variation sku
						$title .= ' ('.trim( $reference ).')';
					} else {
						// Variation ID (absolute last resort)
						$title .= ' ('.trim( $id_variation ).')';
					}
				}
			}
		}
		$title         = apply_filters( 'kuantokusta_product_node_variation_title', $title, $product, $variation );
		$regular_price = apply_filters( 'kuantokusta_product_node_variation_regular_price', wc_get_price_including_tax( $variation, array( 'price' => $variation->get_regular_price() ) ), $product, $variation ); // With VAT
		$current_price = apply_filters( 'kuantokusta_product_node_variation_current_price', wc_get_price_including_tax( $variation ), $product, $variation ); // With VAT
		if ( $current_price > $regular_price && apply_filters( 'kuantokusta_avoid_current_higher_regular', false ) ) {
			$current_price = $regular_price;
		}
		$stock         = apply_filters( 'kuantokusta_product_node_variation_comparison_stock', $this->get_comparison_product_variation_stock( $product, $variation ), $product, $variation );
		$categories    = apply_filters( 'kuantokusta_product_node_variation_categories', $this->get_product_category( $id_product ), $product, $variation );
		$image         = apply_filters( 'kuantokusta_product_node_variation_image', $this->get_product_variation_image( $product, $variation ), $product, $variation );
		$description   = apply_filters( 'kuantokusta_product_node_variation_description', $this->get_product_variation_description( $product, $variation ), $product, $variation );
		$brand         = apply_filters( 'kuantokusta_product_node_variation_brand', $this->get_product_brand( $product ), $product, $variation );
		$ean           = apply_filters( 'kuantokusta_product_node_variation_ean', $this->get_product_ean( $product ), $product, $variation ); // On the free version we only read EAN from the main product
		if ( trim( $reference ) == '' ) $reference = $product->get_sku();
		$reference     = apply_filters( 'kuantokusta_product_node_variation_reference', $reference, $product, $variation );
		$weight        = $variation->get_weight();
		if ( floatval( $weight ) == 0 ) $weight = $product->get_weight();
		$weight        = apply_filters( 'kuantokusta_product_node_variation_weight', $weight, $product, $variation );
		$shipping_cost = apply_filters( 'kuantokusta_product_node_variation_shipping', $this->get_product_shipping_cost( $product ), $product, $variation );

		// Comparison and Marketplace
		$xml_fields = array(
			'mode'                     => array(
				'value' => trim( $this->mode ),
				'cdata' => false,
			),
			'woocommerce_product_type' => array(
				'value' => 'variation',
				'cdata' => false,
			),
			'id_product'               => array(
				'value' => trim( $id_product ),
				'cdata' => false,
			),
			'product_url'              => array(
				'value' => trim( $url ),
				'cdata' => true,
			),
			'designation'              => array(
				'value' => trim( $title ),
				'cdata' => true,
			),
			'regular_price'            => array(
				'value' => ! empty( $regular_price ) ? round( floatval( $regular_price ), wc_get_price_decimals() ) : '',
				'cdata' => false,
			),
			'current_price'            => array(
				'value' => ! empty( $current_price ) ? round( floatval( $current_price ), wc_get_price_decimals() ) : '',
				'cdata' => false,
			),
			'stock'                    => array(
				'value' => $stock,
				'cdata' => false,
			),
			'category'                 => array(
				'value' => trim( $categories ),
				'cdata' => true,
			),
			'image_url'                => array(
				'value' => trim( $image ),
				'cdata' => true,
			),
			'description'              => array(
				'value' => trim( $description ),
				'cdata' => true,
			),
			'brand'                    => array(
				'value' => trim( $brand ),
				'cdata' => true,
			),
			'upc_ean'                  => array(
				'value' => trim( $ean ),
				'cdata' => true,
			),
			'reference'                => array(
				'value' => trim( $reference ),
				'cdata' => true,
			),
			'weight'                   => array(
				'value' => ! empty( $weight ) ? floatval( $weight ).' '.get_option( 'woocommerce_weight_unit' ) : '',
				'cdata' => false,
			),
			'shipping_cost'            => array(
				'value' => ( trim( $shipping_cost ) != '' && floatval( $shipping_cost ) >= 0 ) ? round( floatval( $shipping_cost ), wc_get_price_decimals() ) : '',
				'cdata' => false,
			),
		);
		if ( $this->mode == 'marketplace' ) {
			// Marketplace
			unset( $xml_fields['stock'] );
			$stock_qty            = apply_filters( 'kuantokusta_product_node_variation_marketplace_stock', $this->get_marketplace_product_variation_stock( $product, $variation ), $product, $variation );
			$stock_availability   = apply_filters( 'kuantokusta_product_node_variation_marketplace_availability', $stock_qty > 0 ? 'Y' : 'N', $product, $variation );
			$preparation_days_max = apply_filters( 'kuantokusta_product_node_variation_preparation_days_max', $this->get_product_preparation_days_max( $product ), $product, $variation );
			$delivery_days_max    = apply_filters( 'kuantokusta_product_node_variation_delivery_days_max', $this->get_product_delivery_days_max( $product ), $product, $variation );

			$xml_fields = array_merge( $xml_fields, array(
				'stock_qty'                    => array(
					'value' => $stock_qty,
					'cdata' => false,
				),
				'stock_availability'           => array(
					'value' => $stock_availability,
					'cdata' => false,
				),
				'preparation_days_max'     => array(
					'value' => ! empty( $preparation_days_max ) ? intval( $preparation_days_max ) : '',
					'cdata' => false,
				),
				'delivery_days_max'     => array(
					'value' => ! empty( $delivery_days_max ) ? intval( $delivery_days_max ) : '',
					'cdata' => false,
				),
			) );
		}
		$xml_fields = apply_filters( 'kuantokusta_product_node_variation_xml_fields', $xml_fields, $product, $variation );
		ob_start();
		?>
	<product>
<?php
		foreach ( $xml_fields as $key => $value ) {
			?>
		<<?php echo $key; ?>><?php echo $value['cdata'] ? '<![CDATA['.$value['value'].']]>' : $value['value'] ; ?></<?php echo $key; ?>>
<?php
		}
		// We should remove this filter in the future
		echo apply_filters( 'kuantokusta_product_node_variation_extra_fields', '', $product, $variation ); ?>
	</product>
<?php
		return ob_get_clean();
	}

	/* Get product categories */
	public function get_product_category( $id_product ) {
		$category = '';
		if ( $terms = wc_get_product_terms( $id_product, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
			$category = '';
			// From class-wc-breadcrumb.php
			$main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
			$ancestors = array_reverse( get_ancestors( $main_term->term_id, 'product_cat' ) );
			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, 'product_cat' );
				if ( ! is_wp_error( $ancestor ) && $ancestor ) {
					$category .= trim( $ancestor->name ).' > ';
				}
			}
			$category .= trim( $main_term->name );
		}
		return $category;
	}

	/* Get product description */
	public function get_product_description( $product ) {
		if ( $this->get_setting( 'description_type' ) == 'full' ) {
			$description = trim( $product->get_description() );
			if ( trim( $description ) == '' ) $description = trim( $product->get_short_description() );
		} else {
			$description = trim( $product->get_short_description() );
		}
		if ( trim( $description ) == '' ) $description = trim( $product->get_title() );
		// Necessário remover HTML e ou newlines?
		return wpautop( $description );
	}
	public function get_product_variation_description( $product, $variation ) {
		$product_description = $this->get_product_description( $product );
		$variation_description = trim( $variation->get_description() );
		$description = trim( $product_description.'

'.$variation_description );
		// Necessário remover HTML e ou newlines?
		return wpautop( $description );
	}

	/* Get product image */
	public function get_product_image( $product ) {
		$id_image = $product->get_image_id();
		return $id_image > 0 ? wp_get_attachment_url( $id_image ) : '';
	}
	public function get_product_variation_image( $product, $variation ) {
		$id_image = $variation->get_image_id();
		$image = $id_image > 0 ? wp_get_attachment_url( $id_image ) : '';
		if ( empty( $image ) ) $image =  $this->get_product_image( $product );
		return $image;
	}

	/* Get product stock */
	public function get_comparison_product_stock( $product ) {
		if ( $product->managing_stock() ) {
			return intval( $product->get_stock_quantity() );
		} else {
			return $product->is_in_stock() ? 1 : 0;
		}
	}
	public function get_marketplace_product_stock( $product ) {
		if ( $product->managing_stock() ) {
			return intval( $product->get_stock_quantity() );
		} else {
			return intval( $product->is_in_stock() ? ( intval( $this->get_setting( 'stock_default' ) ) > 0 ? intval( $this->get_setting( 'stock_default' ) ) : 1 ) : 0 );
		}
	}

	/* Get variation stock */
	public function get_comparison_product_variation_stock( $product, $variation ) {
		$managing_stock = $variation->managing_stock();
		if ( is_bool( $managing_stock ) ) {
			$stock_qty = $variation->get_stock_quantity();
			if ( is_null( $stock_qty ) ) {
				return $variation->is_in_stock() ? 'Y' : 'N';
			} else {
				return $stock_qty;
			}
		} else {
			switch ( $managing_stock ) {
				case 'parent':
					return $this->get_comparison_product_stock( $product );
					break;
				default: // ???
					return '';
					break;
			}
		}
	}
	public function get_marketplace_product_variation_stock( $product, $variation ) {
		$managing_stock = $variation->managing_stock();
		if ( is_bool( $managing_stock ) ) {
			if ( $managing_stock ) {
				$stock_qty = $variation->get_stock_quantity();
				if ( is_null( $stock_qty ) ) {
					return intval( $this->get_setting( 'stock_default' ) ) > 0 ? intval( $this->get_setting( 'stock_default' ) ) : 1;
				} else {
					return $stock_qty;
				}
			} else {
				return intval( $variation->is_in_stock() ? ( intval( $this->get_setting( 'stock_default' ) ) > 0 ? intval( $this->get_setting( 'stock_default' ) ) : 1 ) : 0 );
			}
		} else {
			switch ( $managing_stock ) {
				case 'parent':
					return $this->get_marketplace_product_stock( $product );
					break;
				default: // ???
					return '';
					break;
			}
		}
	}

	/* Get product shipping cost - It should be by variation... */
	public function get_product_shipping_cost( $product ) {
		$shipping_cost = $product->get_meta( '_kuantokusta_shipping' );
		// We do not use empty() because the shop owner might want to offer free shipping
		if ( trim( $shipping_cost ) == '' ) $shipping_cost = $this->get_setting( 'shipping_cost_default' );
		return $shipping_cost;
	}

	/* Get product maximum preparation time */
	public function get_product_preparation_days_max( $product ) {
		$preparation_days_max = $product->get_meta( '_kuantokusta_preparation_days_max' );
		if ( empty( $preparation_days_max ) ) $preparation_days_max = $this->get_setting( 'preparation_days_max_default' );
		return $preparation_days_max;
	}

	/* Get product maximum delivery time */
	public function get_product_delivery_days_max( $product ) {
		$delivery_days_max = $product->get_meta( '_kuantokusta_delivery_days_max' );
		if ( empty( $delivery_days_max ) ) $delivery_days_max = $this->get_setting( 'delivery_days_max_default' );
		return $delivery_days_max;
	}

	/* Get product EAN */
	public function get_product_ean( $product ) {
		if ( version_compare( WC_VERSION, '9.2', '>=' ) ) {
			$ean = $product->get_global_unique_id();
			if ( ! empty( trim( $ean ) ) ) {
				return trim( $ean );
			}
		}
		return $product->get_meta( '_kuantokusta_ean' );
	}

	/**
	 * Get product brands terms as WooCommerce lacks this
	 *
	 * @param WC_Product $product The product.
	 * @return array
	 */
	private function get_product_brands_terms( $product ) {
		return get_the_terms( $product->get_id(), 'product_brand' );
	}

	/* Get product brand */
	public function get_product_brand( $product ) {
		if ( version_compare( WC_VERSION, '9.6', '>=' ) ) {
			// $brands = $product->get_global_unique_id();
			$brands = $this->get_product_brands_terms( $product );
			if ( ! empty( $brands ) ) {
				foreach ( $brands as $key => $brand ) {
					// $brands[$key] = trim( $brand->name ); // KK does not support several brands (email 2025-03-19)
					// Only one
					return trim( $brand->name );
				}
				// return trim( implode( ', ', $brands ) ); // KK does not support several brands (email 2025-03-19)
			}
		}
		// Return from old field if brands are not set as taxonomy terms
		return $product->get_meta( '_kuantokusta_brand' );
	}

	/* Track order */
	public function add_tracking_order( $order ) {
		if ( $tracking_code = trim( get_option( $this->id.'_tracking_code' ) ) ) {
			if ( $order ) {
				// Revenue: get_total() - Includes taxes, so the item prices will also include taxes
				?><script type="text/javascript">
	__trackk( 'ecommerce:addTransaction', {
		'id':       '<?php echo $order->get_id(); ?>',
		'revenue':  '<?php echo $order->get_total(); ?>',
		'shipping': '<?php echo $order->get_total_shipping(); ?>',
		'tax':      '<?php echo $order->get_total_tax(); ?>',
		'currency': '<?php echo get_woocommerce_currency(); ?>'
	} );
<?php
				foreach ( $order->get_items() as $k => $item ) {
					$sku = 'GENERATED_SKU_'.$item->get_product_id();
					$cat = '-';
					if ( $product = wc_get_product( $item->get_product_id() ) ) {
						if ( $product->get_sku() ) {
							$sku = $product->get_sku();
						}
						if ( $categories = $product->get_category_ids() ) {
							$cat = get_term_by( 'id', $categories[0], 'product_cat' );
							$cat = $cat->name;
						}
					}
					?>
	__trackk('ecommerce:addItem', {
		'id':       '<?php echo $order->get_id(); ?>', 
		'name':     '<?php echo esc_attr( trim( $item->get_name() ) ); ?>',
		'sku':      '<?php echo esc_attr( trim( $sku ) ); ?>', 
		'category': '<?php echo esc_attr( trim( $cat ) ); ?>', 
		'price':    '<?php echo esc_attr( trim( $order->get_item_subtotal( $item, true, true ) ) ); ?>', 
		'quantity': '<?php echo esc_attr( trim( $item->get_quantity() ) ); ?>' 
	});
<?php
				}
				?>
	__trackk( 'ecommerce:send' );
				</script><?php
			}
		}
	}

}

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
