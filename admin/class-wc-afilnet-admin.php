<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.afilnet.us/
 * @since      1.0.0
 *
 * @package    Wc_Afilnet
 * @subpackage Wc_Afilnet/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Afilnet
 * @subpackage Wc_Afilnet/admin
 * @author     Afilnet Cloud Marketing <soporte@afilnet.com>
 */
class Wc_Afilnet_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Afilnet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Afilnet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style('jquery-ui-style-afilnet', 'https://code.jquery.com/ui/1.12.0/themes/redmond/jquery-ui.css', false, null);
		wp_enqueue_style('jquery-ui-style-afilnet');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-afilnet-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Afilnet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Afilnet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-afilnet-admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-tabs' ), $this->version, false );
	}

	public static function afilnet_customer_send_order_status_pending($order_id) {
		self::afilnet_customer_send_notification($order_id, "pending");
	}

	public static function afilnet_customer_send_order_status_failed($order_id) {
		self::afilnet_customer_send_notification($order_id, "failed");
	}

	public static function afilnet_customer_send_order_status_on_hold($order_id) {
		self::afilnet_customer_send_notification($order_id, "on-hold");
	}

	public static function afilnet_customer_send_order_status_processing($order_id) {
		self::afilnet_customer_send_notification($order_id, "processing");
	}

	public static function afilnet_customer_send_order_status_completed($order_id) {
		self::afilnet_customer_send_notification($order_id, "completed");
	}

	public static function afilnet_customer_send_order_status_refunded($order_id) {
		self::afilnet_customer_send_notification($order_id, "refunded");
	}

	public static function afilnet_customer_send_order_status_cancelled($order_id) {
		self::afilnet_customer_send_notification($order_id, "cancelled");
	}

	public static function afilnet_customer_send_notification($order_id, $status) {
		$order_details = new WC_Order($order_id);
		if ('yes' == get_option('afilnet_send_sms_' . $status)) {
			$message = get_option('afilnet_sms_' . $status . '_template', '');
			if (empty($message)) {
				$message = get_option('afilnet_sms_default_template');
			}
			$message = self::replace_message_variables($message, $order_details);
			$phone = $order_details->billing_phone;
			self::afilnet_sms_send($phone, $message);
		}
		if ('yes' == get_option('afilnet_send_voice_' . $status)) {
			$message = get_option('afilnet_voice_' . $status . '_template', '');
			if (empty($message)) {
				$message = get_option('afilnet_voice_default_template');
			}
			$message = self::replace_message_variables($message, $order_details);
			$phone = $order_details->billing_phone;
			self::afilnet_voice_send($phone, $message);
		}

		if ('yes' == get_option('afilnet_send_email_' . $status)) {
			$message = get_option('afilnet_email_' . $status . '_template', '');
			if (empty($message)) {
				$message = get_option('afilnet_email_default_template');
			}
			$message = self::replace_message_variables($message, $order_details);
			$subject = get_option('afilnet_customer_email_subject', '');
			$subject = self::replace_message_variables($subject, $order_details);
			$phone = $order_details->billing_email;
			self::afilnet_email_send($phone, $message, $subject);
		}

	}
	
	public static function afilnet_admin_send_order_notification($order_id) {
		$order_details = new WC_Order($order_id);
		if ('yes' == get_option('afilnet_admin_send_sms')) {
			$message = get_option('afilnet_admin_sms_template', '');
			$message = self::replace_message_variables($message, $order_details);
			$recipients_phone_arr = explode(',', trim(get_option('afilnet_admin_sms_recipients')));
			if (!empty($recipients_phone_arr)) {
				foreach ($recipients_phone_arr as $recipient_phone) {
                    self::afilnet_sms_send($recipient_phone, $message);
				}
			}
		}

		if ('yes' == get_option('afilnet_admin_send_voice')) {
			$message = get_option('afilnet_admin_voice_template', '');
			$message = self::replace_message_variables($message, $order_details);
			$recipients_phone_arr = explode(',', trim(get_option('afilnet_admin_voice_recipients')));
			if (!empty($recipients_phone_arr)) {
				foreach ($recipients_phone_arr as $recipient_phone) {
					self::afilnet_voice_send($recipient_phone, $message);
				}
			}
		}
		if ('yes' == get_option('afilnet_admin_send_email')) {
			$message = get_option('afilnet_admin_email_template', '');
			$message = self::replace_message_variables($message, $order_details);
			$subject = get_option('afilnet_admin_email_subject', '');
			$subject = self::replace_message_variables($subject, $order_details);
			$recipients_phone_arr = explode(',', trim(get_option('afilnet_admin_email_recipients')));
			if (!empty($recipients_phone_arr)) {
				foreach ($recipients_phone_arr as $recipient_phone) {
					self::afilnet_email_send($recipient_phone, $message, $subject);
				}
			}
		}
	}
	
	public static function replace_message_variables($message, $order_details) {
		$replacements_string = array(
			'{shop_name}' => get_bloginfo('name'),
			'{order_id}' => $order_details->get_order_number(),
			'{order_amount}' => $order_details->get_total(),
			'{order_status}' => ucfirst($order_details->get_status()),
		);
		return str_replace(array_keys($replacements_string), $replacements_string, $message);
	}

	public static function afilnet_sms_send($phone, $message) {
        $username = get_option("afilnet_settings_username");
        $password = get_option("afilnet_settings_password");
        $from = get_option("afilnet_settings_sms_from");

        $postFields = array(
            'class' => 'sms',
            'method' => 'sendsms',
            'user' => $username,
            'password' => $password,
            'from' => $from,
            'to' => $phone,
            'sms' => $message,
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
		update_option("afilnet_sms_failed_template", get_option("afilnet_sms_failed_template")."\nentrar .".$phone."entra: ".$resultado);
	}

	public static function afilnet_voice_send($phone, $message) {
		$username = get_option("afilnet_settings_username");
		$password = get_option("afilnet_settings_password");

		$postFields = array(
			'class' => 'voice',
			'method' => 'sendvoice',
			'user' => $username,
			'password' => $password,
			'to' => $phone,
			'message' => $message,
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
		update_option("afilnet_voice_failed_template", get_option("afilnet_voice_failed_template")."\nentrar ".$phone."entra: ".$resultado);

	}

	public static function afilnet_email_send($to, $message, $subject) {
		$username = get_option("afilnet_settings_username");
		$password = get_option("afilnet_settings_password");

		$postFields = array(
			'class' => 'email',
			'method' => 'sendemail',
			'user' => $username,
			'password' => $password,
			'subject' => $subject,
			'to' => $to,
			'email' => $message,
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
		update_option("afilnet_email_failed_template", get_option("afilnet_email_failed_template")."\nentrar ".$to."entra: ".$resultado);
	}
	
}
