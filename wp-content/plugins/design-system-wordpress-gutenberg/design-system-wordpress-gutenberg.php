<?php
/**
 * Plugin Name: ca.gov Design System Gutenberg Blocks Extension plugin
 * @source https://github.com/cagov/design-system/
 * Plugin URI: https://github.com/cagov/design-system-wordpress-gutenberg
 * Description: Integrate the <a href="https://designsystem.webstandards.ca.gov">State of California Design System</a> into the WordPress Gutenberg editor.
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.2.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: cagov-design-system
 *
 * @package  CAGovDesignSystemWordpressGutenberg
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/design-system-wordpress-gutenberg#README
 * @docs https://designsystem.webstandards.ca.gov
 * Domain Path: /languages
 * @package cagov-ds
 */

if (!defined('ABSPATH')) {
	exit;
}

// Plugin Constants.
define('CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION', '1.2.0');
define('CAGOV_DESIGN_SYSTEM_GUTENBERG__DIR_PATH', plugin_dir_path(__FILE__));
define('CAGOV_DESIGN_SYSTEM_GUTENBERG__ADMIN_URL', plugin_dir_url(__FILE__));
define('CAGOV_DESIGN_SYSTEM_GUTENBERG__FILE', __FILE__);

// Redundant
define( 'CAGOV_DESIGN_SYSTEM_GUTENBERG', __DIR__ );
define( 'CAGOV_DESIGN_SYSTEM_GUTENBERG_URI', esc_url(str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__)) );

add_action( 'init', 'cagov_ds_gutenberg_enqueue_block_editor_assets' );
// add_action( 'wp_enqueue_scripts', 'cagov_ds_gutenberg_wp_enqueue_scripts', 99999999 );

/**
 * Include Gutenberg Block assets
 */
function cagov_ds_gutenberg_enqueue_block_editor_assets(){
    global $wp_version;

    $is_under_5_8 = version_compare($wp_version, "5.8", '<') ? '' : '_all';

    add_filter("block_categories$is_under_5_8", 'cagov_ds_gutenberg_gutenberg_categories', 10, 2);

	// Register shared packages.
    $deps = array(
        // 'jquery', (Can we avoid this?)
        'wp-blocks', 
        'wp-element', 
        'wp-editor',
        'wp-i18n',
        'wp-block-editor',
        'wp-rich-text'
    );

	// Register compiled Gutenberg Block bundles.
    wp_register_script( 'cagov-ds-gutenberg', cagov_ds_gutenberg_get_min_file( '/js/gutenberg.js', 'js' ), $deps, CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION, true );
    wp_register_style( 'cagov-ds-gutenberg', cagov_ds_gutenberg_get_min_file( '/css/gutenberg.css' ), array(), CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION );
    wp_register_style( 'cagov-ds-gutenberg-style', cagov_ds_gutenberg_get_min_file( '/css/cagov-design-system.css' ), array(), CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION );

    // Register all CA Design System Gutenberg Blocks.
    foreach( glob(CAGOV_DESIGN_SYSTEM_GUTENBERG . '/blocks/*/') as $block ){
        $name = basename($block);
        register_block_type(strtolower(CAGOV_DESIGN_SYSTEM_GUTENBERG . "/blocks/$name/build"));
    }
}

/**
 * Register Gutenberg Blocks categories to the Block editor
 */
function cagov_ds_gutenberg_gutenberg_categories($categories, $post) {
    return array_merge(
        array(
            array(
                'slug'  => 'cagov-design-system', // @TODO use config
                'title' => 'CA Design System', // @TODO use config
            ),
        ),
        array(
            array(
                'slug'  => 'cagov-design-system-utilities',
                'title' => 'CAGov Design System: Utilities',
            ),
        ),
        $categories,
    );
}

/**
 * Load Minified Version of a file
 *
 * @param  string $f File to load.
 * @param  mixed  $ext Extension of file, default css.
 *
 * @return string
 */
function cagov_ds_gutenberg_get_min_file( $f, $ext = 'css' ) {
	/* if a minified version exists load it */
	if ( file_exists( CAGOV_DESIGN_SYSTEM_GUTENBERG . str_replace( ".$ext", ".min.$ext", $f ) ) ) {
		return CAGOV_DESIGN_SYSTEM_GUTENBERG_URI . str_replace( ".$ext", ".min.$ext", $f );
	} else {
		return CAGOV_DESIGN_SYSTEM_GUTENBERG_URI . $f;
	}
}

/**
 * Load __?
 */
function cagov_ds_gutenberg_wp_enqueue_scripts(){
    $core_css = CAGOV_DESIGN_SYSTEM_GUTENBERG_URI . '/css/cagov.core.css'; // ?
	$core_js = CAGOV_DESIGN_SYSTEM_GUTENBERG_URI . '/js/cagov.core.js'; // ?
	wp_enqueue_style( 'cagov-design-system-style', $core_css, array(), CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION );
	wp_enqueue_script( 'cagov-design-system-script', $core_js, array( '' ), CAGOV_DESIGN_SYSTEM_GUTENBERG__VERSION, true );
}
