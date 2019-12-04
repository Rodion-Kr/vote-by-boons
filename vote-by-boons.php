<?php

use Codeable\Poll\PollPlugin;

/**
 *
 * Plugin Name:       Poll
 * Plugin URI:        https://premmerce.com
 * Description:       
 * Version:           1.0
 * Author:            codeable
 * Author URI:        https://premmerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vote-by-boons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {

	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	$main = new PollPlugin( __FILE__ );

	$main->run();
} );