<?php
/**
 * Recommend_Ifthenpay
 *
 * @version 1.3
 */

namespace NakedCatPlugins\Recommend_Ifthenpay;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Bail if another bundled copy of this snippet has already booted in this request.
if (
	defined( 'NAKEDCAT_RECOMMEND_IFTHENPAY' )
	||
	class_exists( 'NakedCatPlugins\Recommend_Ifthenpay\Recommend_Ifthenpay' )
) {
	return;
}

define( 'NAKEDCAT_RECOMMEND_IFTHENPAY', true );

add_action(
	'plugins_loaded',
	function () {
		if ( ! class_exists( 'NakedCatPlugins\Recommend_Ifthenpay\Recommend_Ifthenpay' ) ) {
			require_once __DIR__ . '/class-recommend-ifthenpay.php';
			( new \NakedCatPlugins\Recommend_Ifthenpay\Recommend_Ifthenpay() )->init();
		}
	}
);
