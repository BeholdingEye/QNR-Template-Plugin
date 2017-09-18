<?php
/*
Plugin Name: QNR Template Plugin
Plugin URI: http://github.com/beholdingeye
Description: A WordPress plugin template 
Version: 1.0.0
Author: Karl Dolenc
Author URI: http://www.beholdingeye.com
License: GPL2
*/


// -----------------------  Error Handler for debugging

error_reporting(E_ALL); // Report all PHP errors
ini_set('display_errors', 1); // Change default PHP config

function qnr_template_plugin_exception_error_handler($severity, $message, $file, $line) {
  if (!(error_reporting() & $severity)) {
    // This error code is not included in error_reporting
    return;
  }
  throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler('qnr_template_plugin_exception_error_handler');


// ----------------------- Try/catch

try {
  // Abort if called directly
  if (!defined('WPINC') || !defined('ABSPATH')) die;

  /**
  * Base Plugin, required methods
  */
  interface Plugin_Template_Base {
    public function __construct();
    public static function activate();
    public static function deactivate();
  }

  /**
  * Plugin with Settings, required methods
  */
  interface Plugin_Template_Settings extends Plugin_Template_Base {
    public function admin_init();
    public function admin_menu();
    public function plugin_settings_page();
    public function plugin_settings_link($links);
  }

  /**
   * Plugin class
   *------------------------------------------------------------------*/
  class QNR_Template_Plugin implements Plugin_Template_Settings {
    
    public function __construct() {
      add_action('admin_init', array($this, 'admin_init'));
      add_action('admin_menu', array($this, 'admin_menu'));
      add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_settings_link'));
      add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    public static function activate() {}
    public static function deactivate() {}
    
    public function admin_init() {
      // We don't use Settings API to create sections and fields, controlling
      //   the structure more simply with ready-made HTML in settings.php
      // Register settings for this plugin, all options in one value
      register_setting('qnr_template_plugin-group', 'qnr_template_settings_array', array($this, 'sanitize_settings_array'));
    }
    public function admin_menu() {
      // Add admin menu item for settings page
      add_options_page( 'QNR Template Plugin Settings',       // Page title
                        'QNR Template Plugin',                // Menu title
                        'manage_options',                     // Permission/Capability
                        'qnr_template_plugin',                // Options page/menu slug
                        array($this, 'plugin_settings_page')  // Callback below
                        );
    }
    public function plugin_settings_page() { // Callback for admin_menu above
      if (!current_user_can('manage_options')) wp_die('Access not permitted.');
      // Output settings page (we use older format, easier and lighter than Settings API)
      require_once(dirname(__FILE__) . '/settings.php');
    }
    public function plugin_settings_link($links) { // Callback for filter in __construct
      // Link to settings page on plugin page
      $settings_link = '<a href="options-general.php?page=qnr_template_plugin">Settings</a>'; 
      array_unshift($links, $settings_link); // Prepend to other links
      return $links; 
    }
    public function sanitize_settings_array($input) {
      // Sanitize callback for register_setting in admin_init (redundant but good to have; validation done in Javascript on submit)
      // Unpack setting array into individual values
      $string = isset($input['set_a']) ? $input['set_a'] : '';
      $email = isset($input['set_b']) ? $input['set_b'] : '';
      $checkbox = isset($input['set_c']) ? $input['set_c'] : 0;
      $radio = isset($input['set_d']) ? $input['set_d'] : 0;
      $menu = isset($input['set_e']) ? $input['set_e'] : 0;
      // Validate email
      $valEmail = sanitize_email($email);
      if ($valEmail !== $email || ! is_email($valEmail)) {
        $type = 'error';
        $message = 'Invalid email address';
        add_settings_error('qnr_template_settings_array', esc_attr('invalid-email'), $message, $type);
      }
      // Return validated setting array
      $valArray = array();
      $valArray['set_a'] = esc_attr(esc_html($string));
      $valArray['set_b'] = $valEmail;
      $valArray['set_c'] = $checkbox;
      $valArray['set_d'] = $radio;
      $valArray['set_e'] = $menu;
      return $valArray;
    }
    public function admin_enqueue_scripts($hook) {
      // The hook was found with 'wp_die($hook)'
      if($hook == 'settings_page_qnr_template_plugin') {
        wp_enqueue_style('qnr-template-plugin-stylesheet', plugins_url('qnr_template_plugin.css', __FILE__), null, null);
        // As this is an admin page, we don't bother placing the script at end of page
        wp_enqueue_script('qnr-template-plugin-js', plugins_url('qnr_template_plugin.js', __FILE__), null, null);
      }
    }
    
  } // End of class
  // Installation and uninstallation hooks (require static methods)
  register_activation_hook(__FILE__, array('QNR_Template_Plugin', 'activate'));
  register_deactivation_hook(__FILE__, array('QNR_Template_Plugin', 'deactivate'));

  $qnr_template_plugin = new QNR_Template_Plugin();
}
catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n"; // ErrorException($message, 0, $severity, $file, $line)
  echo ' Line: ', $e->getLine(), "\n";
}


