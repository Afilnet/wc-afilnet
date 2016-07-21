<?php

/**
 * @class      Wc_Afilnet_Setting
 * @since      1.0.0
 * @package    Wc_Afilnet
 * @subpackage Wc_Afilnet/admin
 * @author     Afilnet Cloud Marketing <soporte@afilnet.com>
 */
class Wc_Afilnet_Setting {

    /**
     * Hook in methods
     * @since    1.0.0
     * @access   static
     */
    public static function init() {
        add_action('afilnet_setting', array(__CLASS__, 'afilnet_setting_field'));
        add_action('afilnet_setting_save_field', array(__CLASS__, 'afilnet_setting_save_field'));
        add_action('wp_ajax_afilnet_test_login', array(__CLASS__, 'afilnet_test_login'));
    }

    public static function afilnet_test_login() {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        $postFields = array(
            'class' => 'user',
            'method' => 'getbalance',
            'user' => $username,
            'password' => $password
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.afilnet.com/api/http/',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postFields,
        ));

        $resultado = curl_exec($curl);
        curl_close($curl);

        echo $resultado;
        die();
    }
    
    public static function afilnet_general_setting_save_field() {
        ///////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Afilnet Credentials', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'afilnet_settings_options');
        $fields[] = array(
            'title' => __('Account Username', 'wc-afilnet'),
            'id' => 'afilnet_settings_username',
            'desc' => __('Enter your Afilnet username.', 'wc-afilnet'),
            'type' => 'text',
            'css' => 'min-width:300px;',
        );
        $fields[] = array(
            'title' => __('Account Password', 'wc-afilnet'),
            'id' => 'afilnet_settings_password',
            'desc' => __('Enter your Afilnet password.', 'wc-afilnet'),
            'type' => 'password',
            'css' => 'min-width:300px;',
        );

        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');

        ///////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('SMS', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'afilnet_sms_accordion');

        /////////////////////////////////////////
        $fields[] = array('title' => __('Settings', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_sms_settings');
        $fields[] = array(
            'title' => __('Admin Mobile Number', 'wc-afilnet'),
            'id' => 'afilnet_admin_sms_recipients',
            'desc' => __('Enter the mobile number (starting with the country code) where the SMS for admins should be sent. Send to multiple recipients by separating numbers with commas.', 'wc-afilnet'),
            'default' => '34600000000',
            'type' => 'text'
        );
        $fields[] = array(
            'title' => __('SMS Sender name', 'wc-afilnet'),
            'id' => 'afilnet_settings_sms_from',
            'desc' => __('Enter the name of SMS message Sender. Remember that SMS senders are limited to 11 characters.', 'wc-afilnet'),
            'type' => 'text',
            'css' => 'min-width:300px;',
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Admin Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_sms_admin_notifications');
        $fields[] = array(
            'title' => __('Enable new order SMS admin notifications.', 'wc-afilnet'),
            'id' => 'afilnet_admin_send_sms',
            'default' => 'no',
            'type' => 'checkbox'
        );
        $fields[] = array(
            'title' => __('Admin SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_admin_sms_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}. Remember that SMS messages are limited to 160 characters.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have a new order ({order_id}) for {order_amount}', 'wc-afilnet'),
            'type' => 'textarea'
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Customer Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_sms_admin_notifications');
        $fields[] = array(
            'title' => __('Send SMS Notifications for these statuses', 'wc-afilnet'),
            'desc' => __('Pending', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_pending',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'start'
        );
        $fields[] = array(
            'desc' => __('On-Hold', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_on-hold',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Processing', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_processing',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Completed', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_completed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Cancelled', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_cancelled',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Refunded', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_refunded',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Failed', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_failed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'end',
            'autoload' => false
        );
        $fields[] = array(
            'title' => __('Default Customer SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_default_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}. Remember that SMS messages are limited to 160 characters.', 'wc-afilnet'),
            'default' => __('{shop_name} : Your order ({order_id}) is now {order_status}.', 'wc-afilnet'),
            'type' => 'textarea',
            'css' => 'min-width:500px;'
        );
        $fields[] = array(
            'title' => __('Pending SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_pending_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('On-Hold SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_on-hold_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Processing SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_processing_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Completed SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_completed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Cancelled SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_cancelled_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Refunded SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_refunded_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Failed SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_failed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );

        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');


        ///////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Voice', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'afilnet_voice_accordion');

        /////////////////////////////////////////
        $fields[] = array('title' => __('Settings', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_voice_settings');
        $fields[] = array(
            'title' => __('Admin Mobile Number', 'wc-afilnet'),
            'id' => 'afilnet_admin_voice_recipients',
            'desc' => __('Enter the mobile number (starting with the country code) where the message(text-to-speech) for admins should be sent. Send to multiple recipients by separating numbers with commas.', 'wc-afilnet'),
            'default' => '34600000000',
            'type' => 'text'
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Admin Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_voice_admin_notifications');
        $fields[] = array(
            'title' => __('Enable new order Voice admin notifications.', 'wc-afilnet'),
            'id' => 'afilnet_admin_send_voice',
            'default' => 'no',
            'type' => 'checkbox'
        );
        $fields[] = array(
            'title' => __('Admin Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_admin_voice_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have a new order ({order_id}) for {order_amount}', 'wc-afilnet'),
            'type' => 'textarea'
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Customer Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_voice_admin_notifications');
        $fields[] = array(
            'title' => __('Send Voice Notifications for these statuses', 'wc-afilnet'),
            'desc' => __('Pending', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_pending',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'start'
        );
        $fields[] = array(
            'desc' => __('On-Hold', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_on-hold',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Processing', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_processing',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Completed', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_completed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Cancelled', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_cancelled',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Refunded', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_refunded',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Failed', 'wc-afilnet'),
            'id' => 'afilnet_send_voice_failed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'end',
            'autoload' => false
        );
        $fields[] = array(
            'title' => __('Default Customer Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_default_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'default' => __('{shop_name} : Your order ({order_id}) is now {order_status}.', 'wc-afilnet'),
            'type' => 'textarea',
            'css' => 'min-width:500px;'
        );
        $fields[] = array(
            'title' => __('Pending Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_pending_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('On-Hold Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_on-hold_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Processing Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_processing_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Completed Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_completed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Cancelled Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_cancelled_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Refunded Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_refunded_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Failed Voice Message', 'wc-afilnet'),
            'id' => 'afilnet_voice_failed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );

        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');


        ///////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Email', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'afilnet_email_accordion');

        /////////////////////////////////////////
        $fields[] = array('title' => __('Settings', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_email_settings');
        $fields[] = array(
            'title' => __('Admin Email', 'wc-afilnet'),
            'id' => 'afilnet_admin_email_recipients',
            'desc' => __('Enter the email address where the mails for admins should be sent. Send to multiple recipients by separating numbers with commas.', 'wc-afilnet'),
            'default' => 'test@test.com',
            'type' => 'text'
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Admin Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_email_admin_notifications');
        $fields[] = array(
            'title' => __('Enable new order Email admin notifications.', 'wc-afilnet'),
            'id' => 'afilnet_admin_send_email',
            'default' => 'no',
            'type' => 'checkbox'
        );
        $fields[] = array(
            'title' => __('Admin Email Subject', 'wc-afilnet'),
            'id' => 'afilnet_admin_email_subject',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have a new order ({order_id}) for {order_amount}', 'wc-afilnet'),
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Admin Email Message', 'wc-afilnet'),
            'id' => 'afilnet_admin_email_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have a new order ({order_id}) for {order_amount}', 'wc-afilnet'),
            'type' => 'textarea'
        );

        /////////////////////////////////////////
        $fields[] = array('title' => __('Customer Notifications', 'wc-afilnet'), 'type' => 'separator', 'desc' => '', 'id' => 'afilnet_email_admin_notifications');
        $fields[] = array(
            'title' => __('Send Email Notifications for these statuses', 'wc-afilnet'),
            'desc' => __('Pending', 'wc-afilnet'),
            'id' => 'afilnet_send_email_pending',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'start'
        );
        $fields[] = array(
            'desc' => __('On-Hold', 'wc-afilnet'),
            'id' => 'afilnet_send_email_on-hold',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Processing', 'wc-afilnet'),
            'id' => 'afilnet_send_email_processing',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Completed', 'wc-afilnet'),
            'id' => 'afilnet_send_email_completed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Cancelled', 'wc-afilnet'),
            'id' => 'afilnet_send_email_cancelled',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Refunded', 'wc-afilnet'),
            'id' => 'afilnet_send_email_refunded',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Failed', 'wc-afilnet'),
            'id' => 'afilnet_send_email_failed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'end',
            'autoload' => false
        );
        $fields[] = array(
            'title' => __('Admin Email Subject', 'wc-afilnet'),
            'id' => 'afilnet_customer_email_subject',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have done a new order ({order_id})', 'wc-afilnet'),
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Default Customer Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_default_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}.', 'wc-afilnet'),
            'default' => __('{shop_name} : Your order ({order_id}) is now {order_status}.', 'wc-afilnet'),
            'type' => 'textarea',
            'css' => 'min-width:500px;'
        );
        $fields[] = array(
            'title' => __('Pending Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_pending_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('On-Hold Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_on-hold_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Processing Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_processing_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Completed Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_completed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Cancelled Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_cancelled_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Refunded Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_refunded_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Failed Email Message', 'wc-afilnet'),
            'id' => 'afilnet_email_failed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );

        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');


        /*
        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Channels Settings', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'afilnet_channels_settings');

        $fields[] = array(
            'title' => __('Admin Mobile Number', 'wc-afilnet'),
            'id' => 'afilnet_admin_sms_recipients',
            'desc' => __('Enter the mobile number (starting with the country code) where the SMS for admins should be sent. Send to multiple recipients by separating numbers with commas.', 'wc-afilnet'),
            'default' => '34600000000',
            'type' => 'text'
        );

        $fields[] = array(
            'title' => __('SMS Sender name', 'wc-afilnet'),
            'id' => 'afilnet_settings_sms_from',
            'desc' => __('Enter the name of SMS message Sender. Remember that SMS senders are limited to 11 characters.', 'wc-afilnet'),
            'type' => 'text',
            'css' => 'min-width:300px;',
        );

        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');

        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Admin Notifications', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'admin_notifications_options');

        $fields[] = array(
            'title' => __('Enable new order SMS admin notifications.', 'wc-afilnet'),
            'id' => 'afilnet_admin_send_sms',
            'default' => 'no',
            'type' => 'checkbox'
        );

        $fields[] = array(
            'title' => __('Admin SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_admin_sms_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}. Remember that SMS messages are limited to 160 characters.', 'wc-afilnet'),
            'css' => 'min-width:500px;',
            'default' => __('{shop_name}: You have a new order ({order_id}) for {order_amount}', 'wc-afilnet'),
            'type' => 'textarea'
        );
        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');

        ///////////////////////////////////////////////////////////////////////////////////////
        $fields[] = array('title' => __('Customer Notifications', 'wc-afilnet'), 'type' => 'title', 'desc' => '', 'id' => 'customer_notification_options');

        $fields[] = array(
            'title' => __('Send SMS Notifications for these statuses', 'wc-afilnet'),
            'desc' => __('Pending', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_pending',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'start'
        );
        $fields[] = array(
            'desc' => __('On-Hold', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_on-hold',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Processing', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_processing',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Completed', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_completed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Cancelled', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_cancelled',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Refunded', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_refunded',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => '',
            'autoload' => false
        );
        $fields[] = array(
            'desc' => __('Failed', 'wc-afilnet'),
            'id' => 'afilnet_send_sms_failed',
            'default' => 'no',
            'type' => 'checkbox',
            'checkboxgroup' => 'end',
            'autoload' => false
        );
        $fields[] = array(
            'title' => __('Default Customer SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_default_template',
            'desc' => __('Use these variables to customize your message: {shop_name}, {order_id}, {order_amount}. Remember that SMS messages are limited to 160 characters.', 'wc-afilnet'),
            'default' => __('{shop_name} : Your order ({order_id}) is now {order_status}.', 'wc-afilnet'),
            'type' => 'textarea',
            'css' => 'min-width:500px;'
        );
        $fields[] = array(
            'title' => __('Pending SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_pending_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('On-Hold SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_on-hold_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Processing SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_processing_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Completed SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_completed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Cancelled SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_cancelled_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Refunded SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_refunded_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array(
            'title' => __('Failed SMS Message', 'wc-afilnet'),
            'id' => 'afilnet_sms_failed_template',
            'css' => 'min-width:500px;',
            'type' => 'textarea'
        );
        $fields[] = array('type' => 'sectionend', 'id' => 'general_options');
        */
        return $fields;
    }

    public static function afilnet_setting_field() {
        $sms_setting_fields = self::afilnet_general_setting_save_field();
        $Html_output = new Wc_Afilnet_Html_output();
        ?>
        <div class="wrap">

            <form id="afilnet_sms_form" enctype="multipart/form-data" action="" method="post">
                <?php $Html_output->init($sms_setting_fields); ?>
                <p class="submit">
                    <input type="submit" name="afilnet_sms" class="button-primary" value="<?php esc_attr_e('Save changes', 'Option'); ?>" />
                </p>
            </form>
        </div>

        <?php
    }

    public static function afilnet_setting_save_field() {
        $afilnet_sms_setting_fields = self::afilnet_general_setting_save_field();
        $Html_output = new Wc_Afilnet_Html_output();
        $Html_output->save_fields($afilnet_sms_setting_fields);
    }

}

Wc_Afilnet_Setting::init();
