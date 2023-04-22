<?php declare(strict_types=1);
namespace Nextgenthemes\WP;

// TODO: deprecated use register_asset in all ARVE addons
function asset( array $args ) {
	register_asset( $args );
}

function register_asset( array $args ) {
	$args['enqueue'] = false;
	new Asset( $args );
}

function enqueue_asset( array $args ) {
	$args['enqueue'] = true;
	new Asset( $args );
}

function add_dep_to_script( string $handle, string $dep ) {

	$asset = wp_scripts()->query( $handle, 'registered' );

	return add_dep_to_asset( $asset, $dep );
}

function add_dep_to_style( string $handle, string $dep ) {

	$asset = wp_styles()->query( $handle, 'registered' );

	return add_dep_to_asset( $asset, $dep );
}

function add_dep_to_asset( $asset, string $dep ) {

	if ( ! $asset ) {
		return false;
	}

	if ( ! in_array( $dep, $asset->deps, true ) ) {
		$asset->deps[] = $dep;
	}

	return true;
}
