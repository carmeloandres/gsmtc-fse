<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package gsmtc-blockº
 * @since 1.0.0
 */

/**
 * The theme version.
 *
 * @since 1.0.0
 */
define( 'GSMTC_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Add theme support for block styles and editor style.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gsmtc_setup() {
	add_theme_support( 'wp-block-styles' );
	add_editor_style( './assets/css/style-shared.min.css' );

	/*
	 * Load additional block styles.
	 * See details on how to add more styles in the readme.txt.
	 */
	$styled_blocks = [ 'button', 'file', 'latest-comments', 'latest-posts', 'quote', 'search' ];
	foreach ( $styled_blocks as $block_name ) {
		$args = array(
			'handle' => "gsmtc-$block_name",
			'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.min.css" ),
			'path'   => get_theme_file_path( "assets/css/blocks/$block_name.min.css" ),
		);
		// Replace the "core" prefix if you are styling blocks from plugins.
		wp_enqueue_block_style( "core/$block_name", $args );
	}

}
add_action( 'after_setup_theme', 'gsmtc_setup' );

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gsmtc_styles() {
	wp_enqueue_style(
		'gsmtc-style',
		get_stylesheet_uri(),
		[],
		GSMTC_VERSION
	);
	wp_enqueue_style(
		'gsmtc-shared-styles',
		get_theme_file_uri( 'assets/css/style-shared.min.css' ),
		[],
		GSMTC_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'gsmtc_styles' );

// Filters.
require_once get_theme_file_path( 'inc/filters.php' );

// Block variation example.
require_once get_theme_file_path( 'inc/register-block-variations.php' );

// Block style examples.
require_once get_theme_file_path( 'inc/register-block-styles.php' );

// Block pattern and block category examples.
require_once get_theme_file_path( 'inc/register-block-patterns.php' );

/**
 * Actualizaciones del Theme
 */
require_once(dirname(__FILE__).'/update-checker/update-checker.php');

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
        'https://gesimatica.com/updates/?action=get_metadata&slug=gsmtc',
        __FILE__, //Full path to the main plugin file or functions.php.
        'gsmtc'
);

$myUpdateChecker->addQueryArgFilter('wsh_filter_update_checks');
function wsh_filter_update_checks($queryArgs) {
//    $settings = get_option('my_plugin_settings');
//    if ( !empty($settings['license_key']) ) {
//        $queryArgs['license_key'] = $settings['license_key'];
//    }
    $queryArgs['user_id'] = '1';

    $queryArgs['license_key'] = '123456789';
//    error_log(var_export($queryArgs,true));
    return $queryArgs;
}