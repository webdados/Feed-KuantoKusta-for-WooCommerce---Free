<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
	<h2 class="kk_section_title"><?php _e( 'KuantoKusta feed URL', 'feed-kuantokusta-for-woocommerce' ); ?></h2>

	<div class="kk_settings_section">
		
		<p>
			<?php _e( 'This is the feed you should provide to KuantoKusta', 'feed-kuantokusta-for-woocommerce' ); ?>:
			<?php
			$url = get_feed_link( 'kuantokusta' );
			echo '<a href="'.esc_url( $url ).'?TOTAL_PRODUTOS=1000&LIMIT=0" target="_blank">'.$url.'</a>';
			?>
		</p>
		<p>
			<?php
			printf(
				__( 'If you get an error when opening the feed link, you need to %sflush/save the permalinks%s', 'feed-kuantokusta-for-woocommerce' ),
				'<a href="options-permalink.php" target="_blank">',
				'</a>'
			);
			?>
		</p>
		<p>
			<?php _e( 'The <code>TOTAL_PRODUTOS</code> and <code>LIMIT</code> arguments should be used to control the feed pagination.', 'feed-kuantokusta-for-woocommerce' ); ?>
			<br/>
			<?php _e( 'For example, to show 1000 products at a time, KuantoKusta should fetch the feed like this:', 'feed-kuantokusta-for-woocommerce' ); ?>
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
				- <?php _e( '&hellip; and so on, until no more products are returned', 'feed-kuantokusta-for-woocommerce' ); ?>
			</li>
		</ul>

		<?php do_action( 'kuantokusta_documentation_before_fields_inner' ); ?>

	</div>