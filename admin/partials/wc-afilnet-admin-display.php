<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.afilnet.us/
 * @since      1.0.0
 *
 * @package    Wc_Afilnet
 * @subpackage Wc_Afilnet/admin/partials
 */

class Afilnet_Admin_Display {

    /**
     * Hook in methods
     * @since    1.0.0
     * @access   static
     */
    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_settings_menu'));
    }

    /**
     * add_settings_menu Add menu for pluging setting
     * @since    1.0.0
     * @access   public
     */
    public static function add_settings_menu() {
        add_options_page('Afilnet', 'Afilnet', 'manage_options', 'afilnet-option', array(__CLASS__, 'afilnet_options'));
    }

    /**
     * afilnet_options Handle all the settings section
     * @since    1.0.0
     * @access   public
     */
    public static function afilnet_options() {
        do_action('afilnet_setting_save_field');
        do_action('afilnet_setting');
    }

}

Afilnet_Admin_Display::init();

//<!-- This file should primarily consist of HTML with a little bit of PHP. -->
