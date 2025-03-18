<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
	<h2 class="kk_section_title"><?php
	echo apply_filters( 'kuantokusta_settings_title', sprintf(
		__( 'KuantoKusta settings (%s)', '' ),
		$this->version
	) );
	?></h2>

	<div class="kk_settings_section" id="kk_wrap">
		<?php if ( ! apply_filters( 'kuantokusta_hide_settings_right_bar', false ) ) { ?>
			<div id="kk_rightbar">
				<h4><?php _e( 'Commercial information', 'feed-kuantokusta-for-woocommerce' ); ?>:</h4>
				<p><a href="https://www.kuantokusta.pt/<?php echo esc_attr( $this->out_link_utm ); ?>" title="<?php echo esc_attr( sprintf( __( 'Please contact %s', 'feed-kuantokusta-for-woocommerce' ), 'KuantoKusta' ) ); ?>" target="_blank"><img src="<?php echo plugins_url( '../../images/kk.svg', __FILE__ ); ?>" width="200"/></a></p>
				<h4><?php _e( 'Technical support or custom WordPress/WooCommerce development', 'feed-kuantokusta-for-woocommerce' ); ?>:</h4>
				<p><a href="https://www.webdados.pt/contactos/<?php echo esc_attr( $this->out_link_utm); ?>" title="<?php echo esc_attr( sprintf( __( 'Please contact %s', 'feed-kuantokusta-for-woocommerce' ), 'Webdados' ) ); ?>" target="_blank"><img src="<?php echo plugins_url( '../../images/webdados.svg', __FILE__ ); ?>" width="200"/></a></p>
				<h4><?php _e( 'Please rate our plugin at WordPress.org', 'feed-kuantokusta-for-woocommerce' ); ?>:</h4>
				<a href="https://wordpress.org/support/view/plugin-reviews/feed-kuantokusta-for-woocommerce?filter=5#postform" target="_blank" style="text-align: center; display: block;">
					<div class="star-rating"><div class="star star-full"></div><div class="star star-full"></div><div class="star star-full"></div><div class="star star-full"></div><div class="star star-full"></div></div>
				</a>
				<hr/>
				<h4>
					<?php esc_html_e( 'Useful links:', 'feed-kuantokusta-for-woocommerce' ); ?>
				</h4>
				<?php
				$links = array(
					array(
						'text' => __( 'Buy PRO add-on', 'feed-kuantokusta-for-woocommerce' ),
						'url'  => 'https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/'.$this->out_link_utm,
					),
					array(
						'text' => __( 'Create an account on KuantoKusta', 'feed-kuantokusta-for-woocommerce' ),
						'url'  => 'https://www.kuantokusta.pt/autenticacao'.$this->out_link_utm,
					),
					array(
						'text' => __( 'Free plugin on WordPress.org', 'feed-kuantokusta-for-woocommerce' ),
						'url'  => __( 'https://wordpress.org/plugins/feed-kuantokusta-for-woocommerce/', 'feed-kuantokusta-for-woocommerce' ),
					),
					array(
						'text' => __( 'PRO add-on technical support', 'feed-kuantokusta-for-woocommerce' ),
						'url'  => 'https://ptwooplugins.com/my-account/'.$this->out_link_utm,
					),
					array(
						'text' => __( 'Free plugin support forum', 'feed-kuantokusta-for-woocommerce' ),
						'url'  => 'https://wordpress.org/support/plugin/feed-kuantokusta-for-woocommerce',
					),
				);
				?>
				<ul>
					<?php
					foreach ( $links as $link ) {
						?>
						<li>
							<a href="<?php echo esc_url( trim( $link['url'] ) ); ?>" target="_blank">
								<?php echo wp_kses_post( $link['text'] ); ?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
				<?php if ( ! apply_filters( 'kuantokusta_hide_settings_pro_ad', false ) ) { ?>
					<hr/>
					<iframe src="https://www.webdados.pt/kuantokustaiframe" scrolling="no"></iframe>
				<?php } ?>
				<div class="clear"></div>
			</div>
		<?php } ?>
		<div id="kk_settings">
			<?php if ( ! apply_filters( 'kuantokusta_hide_settings_pro_ad', false ) ) { ?>
				<h3>
					<a href="https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/<?php echo esc_attr( $this->out_link_utm ); ?>" target="_blank">
						<?php _e( 'Get the PRO add-on and get more features', 'feed-kuantokusta-for-woocommerce' ); ?>
					</a>
				</h3>
				<ul>
					<li><?php esc_html_e( 'Priority technical support;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'In the next version: Adjust price to send to Kuanto Kusta: add/subtract percentage, round up/down, and add/subtract value to all products;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Default values for Brand, Express shipping cost, Minimum preparation time, Minimum delivery time, and Maximum and Minimum delivery time on express shipping;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Product-level options for Express shipping cost, Minimum preparation time, Minimum delivery time, Maximum and Minimum delivery time on express shipping, and Brand SKU;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Variation-level EAN/UPC and Brand SKU/MPN;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Append variation description to the product title;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Get EAN/UPC from the WooCommerce “unique identifier” product field (default since WooCommerce 9.2 - our field before that), any taxonomy, or any custom field (for integration with other plugins)', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Get Brand, Brand SKU/MPN and EAN/UPC from our product field (default), any taxonomy or any custom field (for integration with other plugins), or from the default brand settings field;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Get Category from the native WooCommerce product categories, any other taxonomy, or any custom field (for integration with other plugins);', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Integration with BigBuy Dropshipping Connector for WooCommerce: get EAN from the BigBuy’s reference table', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Up to 5 photos per product;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Custom attributes (like flavor, colour, genre, material, size, etc.) based on WooCommerce product attributes;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Discount Rules for WooCommerce beta and limited compatibility;', 'feed-kuantokusta-for-woocommerce' ); ?>
					<li><?php esc_html_e( 'Continued development;', 'feed-kuantokusta-for-woocommerce' ); ?>
				</ul>
				<hr/>
			<?php } ?>
			<?php woocommerce_admin_fields( $this->get_settings() ); ?>
		</div>
	</div>

	<p>
		<input type="button" id="kk_settings_section_docs_toggle" class="button kk_settings_section_docs_toggle" value="<?php echo esc_attr( __( 'Show / hide feed URL and documentation', 'feed-kuantokusta-for-woocommerce' ) ); ?>"/>
	</p>

	<div id="kk_settings_section_docs">

		<?php do_action( 'kuantokusta_documentation_before_fields' ); ?>

		<h2 class="kk_section_title"><?php _e( 'Documentation', 'feed-kuantokusta-for-woocommerce' ); ?></h2>
		
		<div class="kk_settings_section kk_settings_section_hide_free">
	
			<?php
			$fields = array(
				'mode' => array(
					'desc'        => __( 'The mode the plugin is running on.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => false,
					'comparison'  => true,
					'marketplace' => true,
				),
				'woocommerce_product_type' => array(
					'desc'        => __( 'The WooCommerce product type.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => false,
					'comparison'  => true,
					'marketplace' => true,
				),
				'id_product' => array(
					'desc'        => __( 'From the database product id.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => false,
					'comparison'  => true,
					'marketplace' => true,
				),
				'product_url' => array(
					'desc'        => __( 'The product URL.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => false,
					'comparison'  => true,
					'marketplace' => true,
				),
				'designation' => array(
					'desc'        => __( 'The product title. (In variations the variation description field is concatenated to the product title).', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'regular_price' => array(
					'desc'        => __( 'The product regular price.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'current_price' => array(
					'desc'        => __( 'The product current price.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'stock' => array(
					'desc'        => __( 'The product stock status (Y/N) or quantity, depending on the global and product settings.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => false,
				),
				'stock_qty' => array(
					'desc'        => __( 'The product stock quantity.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => false,
				),
				'stock_availability' => array(
					'desc'        => __( 'The product stock status (Y/N).', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => false,
				),
				'category' => array(
					'desc'        => __( 'The product category tree. Only the first category found is used and it\'s entire path is used.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'image_url' => array(
					'desc'        => __( 'The product main image url.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'description' => array(
					'desc'        => __( 'The product long or short description (depending on the settings above). (In variations the variation description field is concatenated to the product description)', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'brand' => array(
					'desc' => __( 'The product brand from the KuantoKusta metabox on the product edit screen.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'upc_ean' => array(
					'desc'        =>
						version_compare( WC_VERSION, '9.2', '>=' )
						?
						__( 'The product GTIN, UPC, EAN or ISBN (or EAN from the KuantoKusta metabox on the product edit screen - deprecated).', 'feed-kuantokusta-for-woocommerce' )
						:
						__( 'The product EAN barcode from the KuantoKusta metabox on the product edit screen.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'reference' => array(
					'desc'        => __( 'The product SKU.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'weight' => array(
					'desc'        => __( 'The product weight in kg.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'shipping_cost' => array(
					'desc'        => __( 'The product shipping cost from the KuantoKusta metabox on the product edit screen. If not set, the default value above is used.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => true,
					'marketplace' => true,
				),
				'preparation_days_max' => array(
					'desc'        => __( 'The maximum amount of days a product takes to be prepared before it is shipped, from the KuantoKusta metabox on the product edit screen. If not set, the default value above is used.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => false,
					'marketplace' => true,
				),
				'delivery_days_max' => array(
					'desc'        => __( 'The maximum amount of days the shipping of a product takes, from the KuantoKusta metabox on the product edit screen. If not set, the default value above is used.', 'feed-kuantokusta-for-woocommerce' ),
					'filter'      => true,
					'comparison'  => false,
					'marketplace' => true,
				),
			);
			$fields = apply_filters( 'kuantokusta_documentation_fields', $fields );
			?>

			<h3><?php _e( 'KuantoKusta feed fields', 'feed-kuantokusta-for-woocommerce' ); ?></h3>
			<?php
			foreach ( $fields as $field => $args ) {
				?>
				<p>
					<code><strong><?php echo $field; ?></strong></code>
					<br/>
					<?php echo $args['desc']; ?>
					<?php echo $args['filter'] ? __( 'Filterable.', 'feed-kuantokusta-for-woocommerce' ) : '' ; ?>
					<?php echo $args['comparison'] ? __( 'Comparison.', 'feed-kuantokusta-for-woocommerce' ) : '' ; ?>
					<?php echo $args['marketplace'] ? __( 'Marketplace.', 'feed-kuantokusta-for-woocommerce' ) : '' ; ?>
				</p>
				<?php
			}
			?>

			<?php
			$hooks = array(
				'filters' => array(
					'wc_settings_kuantokusta_settings' => array(
						'arguments' => array(
							'$settings',
							'$mode',
						),
						'desc' => __( 'Add settings to this page.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_query_args' => array(
						'arguments' => array(
							'$args',
						),
						'desc' => __( 'Products query arguments for the wc_get_products function.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_show' => array(
						'arguments' => array(
							'$bool',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Either to include (or not) the product on the feed.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_variation_node_show' => array(
						'arguments' => array(
							'$bool',
							'$product',
							'$variation',
						),
						'desc' => __( 'Either to include (or not) the product variation on the feed.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default' => array(
						'arguments' => array(
							'$product_node',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product node XML.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation' => array(
						'arguments' => array(
							'$product_node',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation node XML.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_title' => array(
						'arguments' => array(
							'$title',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product title.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_title' => array(
						'arguments' => array(
							'$title',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation title.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_regular_price' => array(
						'arguments' => array(
							'$price',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product regular price.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_regular_price' => array(
						'arguments' => array(
							'$price',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation regular price.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_current_price' => array(
						'arguments' => array(
							'$price',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product current price.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_current_price' => array(
						'arguments' => array(
							'$price',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation current price.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_comparison_stock' => array(
						'arguments' => array(
							'$stock',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product stock in comparison mode.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_marketplace_stock' => array(
						'arguments' => array(
							'$stock_qty',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product stock in marketplace mode.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_marketplace_availability' => array(
						'arguments' => array(
							'$stock_availability',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product availability in marketplace mode.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_comparison_stock' => array(
						'arguments' => array(
							'$stock',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation stock in comparison mode.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_marketplace_stock' => array(
						'arguments' => array(
							'$stock_qty',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation stock in marketplace mode.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_marketplace_availability' => array(
						'arguments' => array(
							'$stock_availability',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation availability in marketplace mode.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_categories' => array(
						'arguments' => array(
							'$categories',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product categories.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_categories' => array(
						'arguments' => array(
							'$categories',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation categories.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_image' => array(
						'arguments' => array(
							'$image',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product image url.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_image' => array(
						'arguments' => array(
							'$image',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation image url.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_description' => array(
						'arguments' => array(
							'$description',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product description.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_description' => array(
						'arguments' => array(
							'$description',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation description.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_brand' => array(
						'arguments' => array(
							'$brand',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product brand.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_brand' => array(
						'arguments' => array(
							'$brand',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation brand.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_ean' => array(
						'arguments' => array(
							'$ean',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product ean barcode.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_ean' => array(
						'arguments' => array(
							'$ean',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation ean barcode.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_reference' => array(
						'arguments' => array(
							'$sku',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product sku.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_reference' => array(
						'arguments' => array(
							'$sku',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation sku.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_weight' => array(
						'arguments' => array(
							'$weight',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product weight.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_weight' => array(
						'arguments' => array(
							'$weight',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation weight.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_shipping' => array(
						'arguments' => array(
							'$shipping_cost',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product shipping cost.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_shipping' => array(
						'arguments' => array(
							'$shipping_cost',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation shipping cost.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_preparation_days_max' => array(
						'arguments' => array(
							'$preparation_days_max',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product maximum preparation time.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_preparation_days_max' => array(
						'arguments' => array(
							'$preparation_days_max',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation maximum preparation time.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_default_delivery_days_max' => array(
						'arguments' => array(
							'$delivery_days_max',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Filter on the product maximum delivery time.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_delivery_days_max' => array(
						'arguments' => array(
							'$delivery_days_max',
							'$product',
							'$variation',
						),
						'desc' => __( 'Filter on the product variation maximum delivery time.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					//'kuantokusta_product_node_default_extra_fields' => array(
					//	'arguments' => array(
					//		'$empty',
					//		'$product',
					//		'$product_type',
					//	),
					//	'desc' => __( 'Allows to add extra fields to the product variation node XML.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					//),
					//'kuantokusta_product_node_variation_extra_fields' => array(
					//	'arguments' => array(
					//		'$empty',
					//		'$product',
					//		'$variation',
					//	),
					//	'desc' => __( 'Allows to add extra fields to the product variation node XML.', 'feed-kuantokusta-for-woocommerce' ).' '.__( 'If "Include each product variation" is choosen.', 'feed-kuantokusta-for-woocommerce' ),
					//),
					'kuantokusta_product_node_default_xml_fields' => array(
						'arguments' => array(
							'$xml_fields',
							'$product',
							'$product_type',
						),
						'desc' => __( 'Allows to add extra fields to the product node XML.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_product_node_variation_xml_fields' => array(
						'arguments' => array(
							'$xml_fields',
							'$product',
							'$variation',
						),
						'desc' => __( 'Allows to add extra fields to the product node XML.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_process_product_meta' => array(
						'arguments' => array(
							'meta',
						),
						'desc' => __( 'Allows to save to the database the extra fields of the KuantoKusta panel on the product edit screen, by adding them to the $meta array.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_documentation_fields' => array(
						'arguments' => array(
							'$fields',
						),
						'desc' => __( 'Filter for this documentation fields array.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_documentation_hooks' => array(
						'arguments' => array(
							'$fields',
						),
						'desc' => __( 'Filter for this documentation hooks array.', 'feed-kuantokusta-for-woocommerce' ),
					),
				),
				'actions' => array(
					'kuantokusta_product_data_panel_end' => array(
						'arguments' => array(
						),
						'desc' => __( 'Allows to add extra fields to the KuantoKusta panel on the product edit screen.', 'feed-kuantokusta-for-woocommerce' ),
					),
					'kuantokusta_process_product_meta_end' => array(
						'arguments' => array(
							'post_id',
						),
						'desc' => __( 'Allows to save to the database the extra fields of the KuantoKusta panel on the product edit screen, if the `kuantokusta_process_product_meta` filter was not used, which is the preferred method.', 'feed-kuantokusta-for-woocommerce' ),
					),
				),
			);
			$hooks = apply_filters( 'kuantokusta_documentation_hooks', $hooks );

			foreach ( $hooks as $type => $thehooks ) {
				?>
				<h3><?php _e( 'Developer hooks', 'feed-kuantokusta-for-woocommerce' ); ?> - <?php echo ucfirst($type); ?></h3>
				<?php
				foreach ( $thehooks as $filter => $args ) {
					?>
					<p>
						<code><strong><?php echo $filter; ?></strong></code>
						<?php
						$temp_args = array();
						foreach ( $args['arguments'] as $argument ) {
							$temp_args[] = '<code>'.$argument.'</code>';
						}
						if ( count( $temp_args ) > 0 ) {
							echo '<br/>'.__( 'Arguments', 'feed-kuantokusta-for-woocommerce' ).': '.implode( ', ' , $temp_args );
						}
						?>
						<br/>
						<?php echo $args['desc'] ?>
					</p>
					<?php
				}
			}
			?>

		</div>

		<div class="kk_settings_section kk_settings_section_hide_pro">
			<p>
				<a href="<?php echo esc_url( 'https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/'.$this->out_link_utm ); ?>" target="_blank">
					<?php _e( 'Available on the PRO add-on', 'feed-kuantokusta-for-woocommerce' ); ?>
				</a>
			</p>
		</div>

	</div>


	<style type="text/css">
		.kk_section_title {
			padding-bottom: 0.5em;
			border-bottom: 1px solid #CCC;
			margin-top: 2em;
		}
		.kk_settings_section {
			padding: 1em;
			padding-left: 3em;
			margin-bottom: 2em;
		}
		.kk_settings_section_hide_free {
			display: none;
		}
		#kk_settings_section_docs {
			display: none;
		}
		.forminp .description {
			display: block;
		}
		#kk_settings ul {
			list-style: disc;
			padding-left: 1em;
		}
		<?php if ( ! apply_filters( 'kuantokusta_hide_settings_right_bar', false ) ) { ?>
			#kk_rightbar {
				display: none;
			}
			@media (min-width: 961px) {
				#kk_wrap {
					height: auto;
					overflow: hidden;
				}
				#kk_settings {
					width: auto;
					overflow: hidden;
				}
				#kk_rightbar {
					display: block;
					float: right;
					width: 220px;
					max-width: 20%;
					margin-left: 20px;
					padding: 15px;
					background-color: #fff;
				}
				#kk_rightbar hr {
					margin-top: 2em;
					margin-bottom: 1em;
				}
				#kk_rightbar iframe {
					width: 100%;
					border: none;
					margin: 0;
					padding: 0;
					height: 250px;
					overflow: hidden;
				}
				#kk_rightbar h4:first-child {
					margin-top: 0px;
				}
				#kk_rightbar p {
				}
				#kk_rightbar p img {
					max-width: 100%;
					height: auto;
				}
			}
		<?php } ?>
	</style>

	<script type="text/javascript">
		jQuery( '.kk_settings_section_docs_toggle' ).on( 'click', function() {
			jQuery( '#kk_settings_section_docs' ).slideToggle();
		});
		jQuery( '#wc_feed_kuantokusta_plugin_mode' ).on( 'change', function() {
			//jQuery( '#mainform' ).submit(); //Stopped working, dunno why
			jQuery( 'p.submit .button-primary' ).click();
		});
	</script>

	<?php do_action( 'kuantokusta_settings_footer' ); ?>