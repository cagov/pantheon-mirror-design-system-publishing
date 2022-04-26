<?php

/**
 * Plugin Name: ca.gov Headless Wordpress
 * Plugin URI: https://github.com/cagov/cagov-headless-wordpress
 * Description: Create content with the California Design System to flattened sites.
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.1.5
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: ca-design-system
 *
 * @package  CaGovHeadlessWordPress
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/cagov-headless-wordpress#README
 */

if (!defined('ABSPATH')) {
	exit;
}

// Plugin Constants.
define('CAGOV_HEADLESS_WORDPRESS__VERSION', '1.1.5');
define('CAGOV_HEADLESS_WORDPRESS__DIR_PATH', plugin_dir_path(__FILE__));
define('CAGOV_HEADLESS_WORDPRESS__ADMIN_URL', plugin_dir_url(__FILE__));
define('CAGOV_HEADLESS_WORDPRESS__FILE', __FILE__);

/**
 * Plugin API/Action Reference
 * Actions Run During an Admin Page Request.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_an_Admin_Page_Request
 */
add_action('admin_init', 'cagov_headless_wordpress_admin_init');

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 * 
 * This pings the latest GitHub release and makes it available to plugin users to pull down changes.
 * For scheduling updates, please refer to GitHub. 
 * https://github.com/cagov/ca-design-system-gutenberg-blocks#README 
 * @NOTE will rename to https://github.com/cagov/cagov-design-system-headless-wordpress
 *
 * @category add_action( 'init', 'cagov_headless_wordpress_admin_init' );
 * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_headless_wordpress_admin_init()
{
	// include_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-plugin-update.php';
}

/* Include publishing system integrations and features */
// Convert The SEO Framework data to OG_meta spec for the design system
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_autodescription.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_redirection.php';

// Deliver page template names in safe location that does not break the WP API
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_page_templates.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_meta_categories.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_rest_api_headless.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_meta_tags.php';
// Headless publishing features
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_publishing.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/api_preview.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/preview_button.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/media_headless_permalink.php';
require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/gutenberg-fixes.php';


// Planned for future
// require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/site_options.php';

// require_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/publishing/notifications.php';


// We host this plugin on multiple platforms and WordPress base installs. Accomodate the differences in themes, and support monolithic WordPress as well as ODI Publishing headless wordpress.

include_once CAGOV_HEADLESS_WORDPRESS__DIR_PATH . 'includes/roles.php';


