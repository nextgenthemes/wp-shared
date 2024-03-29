<?php declare(strict_types=1);
namespace Nextgenthemes\WP;

use \Nextgenthemes\WP\Settings;

require_once 'Settings.php';

/**
 * @return mixed
 */
function nextgenthemes_settings_instance( string $base_url, string $base_path ) {

	static $inst = null;

	if ( ! $inst instanceof Settings ) {

		$inst = new Settings(
			array(
				'namespace'           => 'nextgenthemes',
				'settings'            => nextgenthemes_settings(),
				'sections'            => array(
					'keys'         => esc_html__( 'License Keys', 'advanced-responsive-video-embedder' ),
					'beta-updates' => esc_html__( 'Beta Updates', 'advanced-responsive-video-embedder' ),
				),
				'menu_title'          => esc_html__( 'NextGenThemes Settings', 'advanced-responsive-video-embedder' ),
				'settings_page_title' => esc_html__( 'NextGenThemes Settings', 'advanced-responsive-video-embedder' ),
				'base_url'            => $base_url,
				'base_path'           => $base_path,
			)
		);

		$inst->setup_license_options();
	}

	return $inst;
}

function nextgenthemes_settings(): array {

	$products = get_products();

	foreach ( $products as $p => $value ) {
		$settings[ $p ] = array(
			'default' => '',
			'option'  => true,
			'tag'     => 'keys',
			// translators: %s is Product name
			'label'   => sprintf( esc_html__( '%s license Key', 'advanced-responsive-video-embedder' ), $value['name'] ),
			'type'    => 'string',
			'ui'      => 'license_key',
		);

		$settings[ $p . '_status' ] = array(
			'default' => '',
			'option'  => true,
			'tag'     => 'keys',
			// translators: %s is Product name
			'label'   => sprintf( esc_html__( '%s license Key Status', 'advanced-responsive-video-embedder' ), $value['name'] ),
			'type'    => 'string',
			'ui'      => 'hidden',
		);
	}

	foreach ( $products as $key => $value ) {
		$settings[ $key . '_beta' ] = array(
			'default' => false,
			'option'  => true,
			'tag'     => 'beta-updates',
			// translators: Product name
			'label'   => sprintf( esc_html__( '%s beta updates', 'advanced-responsive-video-embedder' ), $value['name'] ),
			'type'    => 'boolean',
		);
	}

	/*
	$settings['cdn'] = array(
		'tag'     => 'keys',
		'default' => false,
		'option'  => true,
		'label'   => esc_html__( 'Use jsDelivr CDN for some assets', 'advanced-responsive-video-embedder' ),
		'type'    => 'boolean',
	);
	*/

	$settings['action'] = array(
		'tag'     => 'keys',
		'default' => '',
		'option'  => true,
		'label'   => esc_html__( 'Action', 'advanced-responsive-video-embedder' ),
		'type'    => 'string',
		'ui'      => 'hidden',
	);

	return $settings;
}

function get_products(): array {

	$products = array(
		'arve_pro' => array(
			'namespace' => 'ARVE\Pro',
			'name'      => 'ARVE Pro',
			'id'        => 1253,
			'type'      => 'plugin',
			'author'    => 'Nicolas Jonas',
			'url'       => 'https://nextgenthemes.com/plugins/arve-pro/',
		),
		'arve_amp' => array(
			'namespace' => 'ARVE\AMP',
			'name'      => 'ARVE AMP',
			'id'        => 16941,
			'type'      => 'plugin',
			'author'    => 'Nicolas Jonas',
			'url'       => 'https://nextgenthemes.com/plugins/arve-amp/',
		),
		'arve_random_video' => array(
			'namespace' => 'ARVE\RandomVideo',
			'name'      => 'ARVE Random Video',
			'id'        => 31933,
			'type'      => 'plugin',
			'author'    => 'Nicolas Jonas',
			'url'       => 'https://nextgenthemes.com/plugins/arve-random-video/',
		),
		'arve_sticky_videos' => array(
			'namespace' => 'ARVE\StickyVideos',
			'name'      => 'ARVE Sticky Videos',
			'id'        => 42602,
			'type'      => 'plugin',
			'author'    => 'Nicolas Jonas',
			'url'       => 'https://nextgenthemes.com/plugins/arve-sticky-videos/',
		),
	);

	foreach ( $products as $key => $value ) :

		$products[ $key ]['active']    = false;
		$products[ $key ]['file']      = false;
		$products[ $key ]['installed'] = false;
		$products[ $key ]['slug']      = $key;
		$products[ $key ]['valid_key'] = has_valid_key( $key );

		$version_define = strtoupper( $key ) . '_VERSION';
		$file_define    = strtoupper( $key ) . '_FILE';

		if ( defined( $version_define ) ) {
			$products[ $key ]['version'] = constant( $version_define );
		}

		if ( defined( $file_define ) ) {
			$products[ $key ]['file'] = constant( $file_define );
		}

		$version = "\\Nextgenthemes\\{$value['namespace']}\\VERSION";
		$file    = "\\Nextgenthemes\\{$value['namespace']}\\PLUGIN_FILE";

		if ( defined( $version ) ) {
			$products[ $key ]['version'] = constant( $version );
		}

		if ( defined( $file ) ) {
			$products[ $key ]['file']   = constant( $file );
			$products[ $key ]['active'] = true;
		}
	endforeach;

	return $products;
}
