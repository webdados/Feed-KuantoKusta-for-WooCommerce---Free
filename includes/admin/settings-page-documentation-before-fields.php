<?php
/**
 * Settings Page Documentation
 *
 * This file renders the documentation section that appears at the top of the
 * KuantoKusta plugin settings page. It explains the feed URL structure and
 * demonstrates how to use pagination parameters when accessing the feed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
	<h2 class="kk_section_title">
		<?php esc_html_e( 'KuantoKusta feed URL', 'feed-kuantokusta-for-woocommerce' ); ?>
	</h2>

	<div class="kk_settings_section">
		
		<p>
			<?php esc_html_e( 'This is the feed you should provide to KuantoKusta', 'feed-kuantokusta-for-woocommerce' ); ?>:
			<?php
			$url = get_feed_link( 'kuantokusta' );
			echo '<a href="' . esc_url( $url ) . '?TOTAL_PRODUTOS=1000&LIMIT=0" target="_blank">' . esc_url( $url ) . '</a>';
			?>
		</p>
		<p>
			<?php
			echo wp_kses_post(
				sprintf(
					/* translators: 1: link start tag, 2: link end tag. */
					__( 'If you get an error when opening the feed link, you need to %1$sflush/save the permalinks%2$s', 'feed-kuantokusta-for-woocommerce' ),
					'<a href="options-permalink.php" target="_blank">',
					'</a>'
				)
			);
			?>
		</p>
		<p>
			<?php echo wp_kses_post( __( 'The <code>TOTAL_PRODUTOS</code> and <code>LIMIT</code> arguments should be used to control the feed pagination.', 'feed-kuantokusta-for-woocommerce' ) ); ?>
			<br/>
			<?php esc_html_e( 'For example, to show 1000 products at a time, KuantoKusta should fetch the feed like this:', 'feed-kuantokusta-for-woocommerce' ); ?>
		</p>
		<ul>
			<li>
				- <a href="<?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=0" target="_blank"><?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=0</a>
			</li>
			<li>
				- <a href="<?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=1000" target="_blank"><?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=1000</a>
			</li>
			<li>
				- <a href="<?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=2000" target="_blank"><?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=2000</a>
			</li>
			<li>
				- <a href="<?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=3000" target="_blank"><?php echo esc_url( $url ); ?>?TOTAL_PRODUTOS=1000&amp;LIMIT=3000</a>
			</li>
			<li>
				- <?php esc_html_e( '&hellip; and so on, until no more products are returned', 'feed-kuantokusta-for-woocommerce' ); ?>
			</li>
		</ul>

		<?php do_action( 'kuantokusta_documentation_before_fields_inner' ); ?>

	</div>