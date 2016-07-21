<?php

/**
 * @link              http://www.afilnet.us/
 * @since             1.0.0
 * @package           Wc_Afilnet
 *
 * @wordpress-plugin
 * Plugin Name:       Afilnet for WooCommerce
 * Plugin URI:        https://github.com/Afilnet/wc-afilnet
 * Description:       Customizable notifications delivery by SMS, email and voice, for the administrator as well as for clients, when there is an event in WooCommerce.
 * Version:           1.0.0
 * Author:            Afilnet Cloud Marketing
 * Author URI:        http://www.afilnet.us/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       afilnet-for-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-afilnet-activator.php
 */
function activate_wc_afilnet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-afilnet-activator.php';
	Wc_Afilnet_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-afilnet-deactivator.php
 */
function deactivate_wc_afilnet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-afilnet-deactivator.php';
	Wc_Afilnet_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_afilnet' );
register_deactivation_hook( __FILE__, 'deactivate_wc_afilnet' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-afilnet.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_afilnet() {

	$plugin = new Wc_Afilnet();
	$plugin->run();

}
run_wc_afilnet();
