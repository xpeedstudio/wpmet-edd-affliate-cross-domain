<?php
namespace Wpmet_Essential\Mods;

defined( 'ABSPATH' ) || exit;

// getgist live chat fix;

class Fix_Chatting_App_Assets{
    public function __construct(){
        remove_action( 'wp_head', array( 'InsertConvertFox', 'insert_tracker' ));
        add_action( 'wp_footer', array( 'InsertConvertFox', 'insert_tracker' ), 5);
    }
}