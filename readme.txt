=== Feed KuantoKusta for WooCommerce - Free ===
Contributors: webdados, ptwooplugins 
Tags: marketplace, feed, comparison, e-commerce, Portugal
Requires at least: 6.2
Tested up to: 6.8
Requires PHP: 7.0
Stable tag: 4.0-beta.1
License: GPLv3

This plugin allows you to generate a WooCommerce product feed to submit to Kuanto Kusta, a Portuguese price comparison website and marketplace.

== Description ==

This plugin generates a compatible [KuantoKusta](https://www.kuantokusta.pt/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) WooCommerce product feed so that the store owner can add his products to this price comparison website and marketplace.

The store owner should first [sign up with KuantoKusta](https://mystore.kuantokusta.pt/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin).

This plugin was developed in partnership with KuantoKusta and it’s the WooCommerce-approved and advised solution by this price comparison website and marketplace. The KuantoKusta logo and brand are copyrighted and are used with their permission.

== Features ==

* Price comparison and Marketplace modes;
* Choose product types to include in the feed;
* Include product variations;
* Default values for stock, shipping cost, maximum preparation time, and maximum delivery time;
* Product-level options to hide from feed, EAN/UPC, brand, shipping cost, maximum preparation time and maximum delivery time;
* One photo per product;
* Integration with the KuantoKusta javascript tracking code (experimental);
* Developer hooks;
* Minimal technical support (bug fixing only);

== PRO add-on features ==

In addition to all you can do with the free plugin, the [paid add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) offers you several additional features:

* Priority technical support;
* Adjust price to send to KuantoKusta: add/subtract percentage, round up/down, add/subtract value to all products, and avoid current/sale price higher than regular price;
* Default values for Brand, Express shipping cost, Minimum preparation time, Minimum delivery time, and Maximum and Minimum delivery time on express shipping;
* Product-level options for Express shipping cost, Minimum preparation time, Minimum delivery time, Maximum and Minimum delivery time on express shipping, and Brand SKU;
* Variation-level EAN/UPC and Brand SKU/MPN;
* Append variation description to the product title;
* Get EAN/UPC from the WooCommerce “unique identifier” product field (default since WooCommerce 9.2 - our field before that), any taxonomy, or any custom field (for integration with other plugins)
* Get Brand, Brand SKU/MPN and EAN/UPC from our product field (default), any taxonomy, any custom field (for integration with other plugins), or from the default brand settings field;
* Get Category from the native WooCommerce product categories, any other taxonomy, or any custom field (for integration with other plugins);
* Integration with [BigBuy Dropshipping Connector for WooCommerce](https://wordpress.org/plugins/bigbuy-wc-dropshipping-connector/): get EAN from the BigBuy’s reference table
* Up to 5 photos per product;
* Custom attributes (like flavor, colour, genre, material, size, etc.) based on WooCommerce product attributes;
* [Discount Rules for WooCommerce](https://wordpress.org/plugins/woo-discount-rules/) beta and limited compatibility;
* Continued development;

== Already know our other WooCommerce (premium) plugins? ==

* [Portuguese Postcodes for WooCommerce](https://ptwooplugins.com/product/portuguese-postcodes-for-woocommerce-technical-support/) - Automatic filling of the address details at the checkout, including street name and neighborhood, based on the postal code
* [Invoicing with InvoiceXpress for WooCommerce](https://invoicewoo.com/) - Automatically issue invoices directly from the WooCommerce order
* [DPD Portugal for WooCommerce](https://ptwooplugins.com/product/dpd-portugal-for-woocommerce/) - Create shipping and return guide in the DPD API directly from the WooCommerce order
* [Multibanco, MBWAY, Credit card, Payshop and Cofidis Pay for WooCommerce – PRO add-on](https://ptwooplugins.com/product/multibanco-mbway-credit-card-payshop-ifthenpay-woocommerce-pro-add-on/) - Extra features for the plugin you already trust to receive payments on your WooCommerce store
* [Advanced Coupon Restrictions for WooCommerce](https://ptwooplugins.com/product/advanced-coupon-restrictions-for-woocommerce/) - Create coupons for any Product Taxonomy, User details, and Order destination.
* [Simple Checkout Fields Manager for WooCommerce](https://ptwooplugins.com/product/simple-custom-fields-for-woocommerce-blocks-checkout/) - Add custom fields and manage (remove, make required or optional) core fields on the new WooCommerce Block-based Checkout
* [Simple WooCommerce Order Approval](https://ptwooplugins.com/product/simple-woocommerce-order-approval/) - The hassle-free solution for WooCommerce order approval before payment
* [Shop as Client for WooCommerce](https://ptwooplugins.com/product/shop-as-client-for-woocommerce-pro-add-on/) - Quickly create orders on behalf of your customers
* [Taxonomy/Term and Role based Discounts for WooCommerce](https://ptwooplugins.com/product/taxonomy-term-and-role-based-discounts-for-woocommerce-pro-add-on/) - Easily create bulk discount rules for products based on any taxonomy terms (built-in or custom)
* [DPD / SEUR / Geopost Pickup and Lockers network for WooCommerce](https://ptwooplugins.com/product/dpd-seur-geopost-pickup-and-lockers-network-for-woocommerce/) - Deliver your WooCommerce orders on the DPD and SEUR Pickup network of Parcelshops and Lockers in 21 European countries

== Installation ==

* Use the included automatic install feature on your WordPress admin panel and search for “Feed KuantoKusta for WooCommerce”.
* Go to WooCoomerce > Settings > KuantoKusta, select the product types you want to include in the feed, and set other options as you wish.
* You can go to each product and set specific settings like hiding the product from the feed, its EAN/UPC code, brand, shipping cost, etc.

== Frequently Asked Questions ==

= I need some modifications to my feed structure or data. Is it possible? =

The plugin has a large number of WordPress hooks you can use to manipulate which products are included in the feed, which fields are shown on the feed, and even manipulate the content of each field.
If you are not comfortable with development, you can [hire us](https://www.webdados.pt/contactos/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) to make the customization for you.

= My feed URL is returning a 404 error =

Go to Settings > Permalinks > Save changes

= Is this plugin compatible with the new WooCommerce High-Performance Order Storage? =

Yes.

= Is this plugin compatible with the new WooCommerce block-based Cart and Checkout? =

Yes.

= I need technical support. Who should I contact, KuantoKusta or PT Woo Plugins? =

The development and support of this plugin is [PT Woo Plugins](https://ptwooplugins.com?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) responsibility, although KuantoKusta can help you identify problems with your feed if your products are not successfully imported into their system (and that information will be helpful when asking us for support).

We do not provide free support for this plugin, but bugs can be reported on the [support forum at WordPress.org](https://wordpress.org/support/plugin/feed-kuantokusta-for-woocommerce/)

You’ll get included support if you buy the plugin [PRO add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin).

For premium/urgent support or custom development, you should contact [Webdados](https://www.webdados.pt/contactos/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) directly. Charges will apply.

= Where do I report security vulnerabilities found in this plugin? =  
 
You can report any security bugs found in the source code of this plugin through the [Patchstack Vulnerability Disclosure Program](https://patchstack.com/database/vdp/feed-kuantokusta-for-woocommerce). The Patchstack team will assist you with verification, CVE assignment, and take care of notifying the developers of this plugin.

= Can I contribute with a translation? =

Sure. Go to [GlotPress](https://translate.wordpress.org/projects/wp-plugins/feed-kuantokusta-for-woocommerce) and help us out.

== Screenshots ==
 
1. Global settings
2. Product level settings

== Changelog ==

= 4.0 - ? =
* [NEW] Adjust price to send to KuantoKusta: add/subtract percentage, round up/down, add/subtract value to all products, and avoid current/sale price higher than regular price [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [NEW] Use the new “Brands” taxonomy from WooCommerce 9.6 and above instead of our field for Brand
* [NEW] Deprecate “Price comparison” mode
* [NEW] Replicate our fields to the field names recommended on the KuantoKusta documentation:
    - `id_product` to `id`
    - `product_url` to `link`
    - `designation` to `name`
    - `regular_price` to `price`
    - `current_price` to `sale_price`, and set it to empty if it’s not lower than `regular_price`
    - `image_url` to `image_link`
    - `image_url_x` to `additional_image_link` [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
    - `stock_availability` to `availability`, and convert from `Y/N` to `Sim/Não`
    - `stock_qty` to `stock`
    - `upc_ean` to `gtin` [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
    - `shipping_cost` to `shipping`
* [DEV] Force “no-cache” php headers to make sure KuantoKusta is not using cache when reading the feed
* [DEV] Requires WordPress 6.2 and WooCommerce 8.0
* [DEV] Tested with WordPress 6.8-beta2-59993 and WooCommerce 9.8.0-beta.1

= 3.4 - 2025-03-18 =
* [TWEAK] Show Pro add-on functionalities on the settings screen
* [FIX] Error on the settings page in comparison mode [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)

= 3.3 - 2025-02-06 =
* [TWEAK] In comparison mode, if product does not have managed stock, return 1 or 0 in the stock field instead of “Y” and “N”
* [TWEAK] In marketplace mode, if product does not have managed stock, return 1 instead of 0 if the deafult stock setting is not set
* [TWEAK] Change feed instructions from 100 to 1000 products at a time
* [DEV] Tested with WordPress 6.8-alpha-59604 and WooCommerce 9.7.0-beta.1

= 3.2 - 2024-11-13 =
* [FIX] Fatal error when WooCommerce is running update routines for 9.4 [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] License validation on websites with WPML set to have different domains per language [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Recheck for the free plugin class again on the pro class (just in case) [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Tested with WordPress 6.7 and WooCommerce 9.4.1

= 3.1 - 2024-10-08 =
* [FIX] Load text domain at the right time to avoid PHP notices on WordPress 6.7 and above
* [DEV] Change plugin loading to `init` instead of `plugins_loaded`

= 3.0 - 2024-10-07 =
* [NEW] Use the new “GTIN, UPC, EAN or ISBN” field from WooCommerce 9.2 and above instead of our field for EAN
* [NEW] Migration utility to move our EAN field value to the new WooCommerce 9.2 and above field [only on the Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Requires WooCommerce 7.0
* [DEV] Tested with WordPress 6.7-beta1-59184 and WooCommerce 9.4.0-beta.2

= 2.8 - 2024-08-02 =
* [NEW] Get “Other attributes” from parent (variable) product when not present on the product variation (not used for variations) [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Tested with WordPress 6.7-alpha-58841 and WooCommerce 9.2.0-beta.1

= 2.7 - 2024-04-30 =
* [TWEAK] New `KK_IS_FEED` constant that is set to `true` when the feed is being shown
* [NEW] “Default brand” setting, if not set on the chosen custom field or taxonomy, or our field [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Tested with WordPress 6.6-alpha-58055 and WooCommerce 9.0.0-dev

= 2.6 - 2024-04-02 =
* [FIX] Deprecated: Creation of dynamic property in PHP 8.3
* [DEV] Add “Requires Plugins” header
* [DEV] Improve plugin updater – Show translation update notices [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* [DEV] Tested with WordPress 6.5-RC4-57894 and WooCommerce 8.8.0-beta.1

= 2.5 - 2024-01-24 =
* Feedback when the license is expired [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 6.5-alpha-57299 and WooCommerce 8.5.1

= 2.4 - 2023-12-12 =
* Declare WooCommerce block-based Cart and Checkout compatibility
* Requires WordPress 5.4
* Tested with WordPress 6.5-alpha-57159 and WooCommerce 8.4.0-rc.1

= 2.3 - 2023-11-16 =
* Instructions about flushing the permalinks if the feed URL is returning a 404 error
* Clarification about Brand SKU being the MPN (Manufacturer Part Number) [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 6.5-alpha-57110 and WooCommerce 8.3.0-rc.3

= 2.2 - 2023-10-06 =
* Integration with BigBuy Dropshipping Connector for WooCommerce: New option to get EAN from the BigBuy’s reference table [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 6.4-beta2-56771 and WooCommerce 8.2.0-rc.1

= 2.1 - 2023-09-11 =
* Option to to our field if Brand, Brand SKU/MPN or EAN custom origins are empty [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Fix jQuery deprecations
* Tested with WordPress 6.4-alpha-56530 and WooCommerce 8.1.0-rc.2

= 2.0 - 2023-05-16 =
* Bugfix: when the product only had one category, the entire path was not used.
* Requires WooCoomerce 5.0 or above
* Tested with WordPress 6.3-alpha-55693 and WooCommerce 7.7

= 1.9.0 - 2023-02-01 =
* Tested and confirmed WooCommerce HPOS compatibility
* Force the inclusion of attribute names on the variation title even if it was removed via the `woocommerce_product_variation_title_include_attributes` filter [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 6.2-alpha-55171 and WooCommerce 7.4.0-beta.2

= 1.8.1 - 2022-06-27 =
* Update readme.txt
* Requires PHP 7, WooCoomerce 4.0 and WordPress 5.0 or above
* Tested with WordPress 6.1-alpha-53556 and WooCommerce 6.7.0-beta.1

= 1.8.0 - 2022-05-23 =
* New brand: PT Woo Plugins 🥳
* Documentation link [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)

= 1.7.0 - 2022-05-04 =
* May the 4th be with you
* Option to remove description from variation designation [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 6.0-beta2-53236 and WooCommerce 6.5.0-rc.1

= 1.6.0 =
* [Discount Rules for WooCommerce](https://wordpress.org/plugins/woo-discount-rules/) beta and limited compatibility [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin) - Sponsored by [Royal Work](https://www.royalwork.pt/)
* PHP 7.0 minimum requirement
* Bugfix: “WP_Scripts::localize was called incorrectly” after WordPress 5.7.0

= 1.5.3 - 2021-03-23 =
* Bugfix: it’s now possible to set shipping cost to zero at the product level
* Tested with WordPress 5.8-alpha-50563, WooCommerce 5.2.0-beta.1 and PHP 8.0.16

= 1.5.2 - 2021-03-10 =
* Tested with WordPress 5.8-alpha-50516 and WooCommerce 5.1.0

= 1.5.1 - 2020-11-25 =
* CSS fix on the settings page

= 1.5.0 - 2020-11-25 =
* Integration with the KuantoKusta javascript tracking code
* Add expiration header to the feed
* Tested with WordPress 5.6-RC1-49690 and WooCommerce 4.8.0-rc.1

= 1.4.3 - 2020-10-18 =
* New action `kuantokusta_settings_footer` to allow the Pro plugin to add scripts to the footer of the settings page
* Tested with WordPress 5.6-alpha-49109 and WooCommerce 4.6.0

= 1.4.2 - 2020-07-30 =
* Fix KuantoKusta link on readme.txt
* Tested with WordPress 5.5-beta4-48649 and WooCommerce 4.4.0-beta.1

= 1.4.1 =
* Changes on the InvoiceXpress banner

= 1.4.0 =
* Enhanced Multiselect fields
* Re-organize feed URL and Documentation on the settings page
* Tested with WordPress 5.3.3-alpha-46995 and WooCommerce 3.9.0-rc.2
* Happy New Year

= 1.3.0 =
* Tested with WordPress 5.3.2-alpha-46956 and WooCommerce 3.9.0-beta.1

= 1.2.6 =
* Hide the InvoiceXpress nag if the invoicing is already installed and active
* Tested with WordPress 5.3.1-alpha-46798 and WooCommerce 3.8.1

= 1.2.5 =
* InvoiceXpress plugin promotion

= 1.2.4 =
* Tested with WordPress 5.2.4-alpha-46074 and WooCommerce 3.8.0-beta.1

= 1.2.3 =
* Fix variation shipping cost when the default value is zero
* WordPress 4.9 minimum requirement
* PHP 5.6 minimum requirement

= 1.2.2 =
* Use variation method `get_name` instead of product `get_title` for variation designations
* WordPress 4.9 minimum requirement
* PHP 5.6 minimum requirement
* Tested with WooCommerce 3.7.0-beta.1

= 1.2.1 =
* Bugfix when changing KuantoKusta mode
* Tested with WordPress 5.2.3-alpha and WooCommerce 3.6.4

= 1.2 =
* Bugfix on default stock when the product is not managing it and is out of stock
* Tested with WordPress 5.1.1 and WooCommerce 3.6.0 (beta 1)

= 1.1 =
* Better feed URL documentation
* WPML feed URL information (on the PRO add-on)
* Tested with WordPress 5.1 and WooCommerce 3.5.5

= 1.0.2 =
* Hide publicity if the PRO add-on is installed and active
* Small readme.txt fix

= 1.0.1 =
* Small readme.txt fix

= 1.0 =
* New KuantoKusta Marketplace mode
* New fields
* Integration with [Pro add-on](https://ptwooplugins.com/product/feed-kuantokusta-for-woocommerce-pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=kk_woocommerce_plugin)
* Tested with WordPress 5.0.2 and WooCommerce 3.5.3
* Dropped WooCommerce legacy support (before 3.0)

= 0.2.1 =
* Fix: small bug when using `get_post_meta` on WooCommerce below 3.0

= 0.2 =
* Use WooCommerce 3.0 (and above) CRUD functions to read/update product meta
* New `kuantokusta_process_product_meta` filter to be able to save extra fields/meta to products 
* Fix: small typo
* Bumped `WC tested up to` tag

= 0.1.1 =
* Better installation instructions and screenshots

= 0.1 =
* Initial release.
* Thanks to Luis Grave at KuantoKusta.pt