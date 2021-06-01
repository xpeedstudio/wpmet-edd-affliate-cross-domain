<?php
/*
Plugin Name: Wpmet Essential
Plugin URI: https://wpmet.com
Description: Pass affiliate ref data to the main site, pushing campaign coupon, tweaks in ConvertFox Scripts etc
Author: Emran
Version: 1.3.1
Text Domain: wpmet-essential
Author URI: https://wpmet.com
*/

include_once 'autoloader.php';

class Wpmet_Essential{

    const DEBUG = false;

	private static $instance;

	public static function instance() {
		if(!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    public function get_file(){
        return __FILE__;
    }

    public function get_plugin_data(){
        return get_plugin_data( $this->get_file() );
    }

    public function get_version(){
        return $this->get_plugin_data()['Version'] . (self::DEBUG === true ? '-' . time() : '');
    }
    
    public function get_dir(){
        return trailingslashit(plugin_dir_path( $this->get_file() ));
    }
    
    public function get_url(){
        return trailingslashit(plugin_dir_url( $this->get_file() ));
    }

    public function get_mod_dir(){
        return $this->get_dir() . 'mods/';
    }
    
    public function get_mod_url(){
        return $this->get_url() . 'mods/';
    }

    public function init(){
        // new \Wpmet_Essential\Mods\Fix_Chatting_App_Assets();
        new \Wpmet_Essential\Mods\Affiliate_Cross_Domain();
        new \Wpmet_Essential\Mods\Integrate_Onboard_Coupon();
    }

}

add_action('wp_loaded', function(){
    \Wpmet_Essential::instance()->init();
});
