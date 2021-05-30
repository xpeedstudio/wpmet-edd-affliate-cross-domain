<?php
/*
Plugin Name: Wpmet edd affliate cross domain
Plugin URI: #
Description: Pass affliate ref data to the main site.
Author: Emran
Version: 1.2.6
Author URI: wpmet.com
*/

define('WPMET_EDD_AFF_URL', plugin_dir_url( __FILE__ ));
//define('WPMET_EDD_AFF_VAR', '1.2.5' . time()); // for testing, caching preventing
define('WPMET_EDD_AFF_VAR', '1.2.6');

add_action( 'wp_footer', 'wpmet_edd_affliate_cross_domain_function_footer' );
add_action( 'wp_head', 'wpmet_edd_aff_config_head' );


function wpmet_edd_aff_config_head() {
    
    // these are the base configuration for edd affliate scripts.
    ?>
    <script type='text/javascript'>
    /* <![CDATA[ */
    var affwp_scripts = {"ajaxurl":"https:\/\/account.wpmet.com\/wp-admin\/admin-ajax.php"};
    /* ]]> */
    </script>
    <script type="text/javascript">
        var AFFWP = AFFWP || {};
        AFFWP.referral_var = 'rui'; // refferal $_GET peram
        AFFWP.expiration = 30; // how long a refferal data will stay. (days)
        AFFWP.debug = 0; // debug true or false.
        AFFWP.wpmet = '<?php echo WPMET_EDD_AFF_VAR; ?>';
        
        AFFWP.cookie_domain = 'account.wpmet.com';
        
        AFFWP.referral_credit_last = 0;
    </script>
    <?php 
}



function wpmet_edd_affliate_cross_domain_function_footer() {
    // these two files are copied from original EDD affliate plugin.
    wp_enqueue_script('wpmet_edd_aff_cookie', WPMET_EDD_AFF_URL . "assets/js/jquery.cookie.min.js", [], WPMET_EDD_AFF_VAR, true );
    wp_enqueue_script('wpmet_edd_aff_tracking', WPMET_EDD_AFF_URL . "assets/js/tracking.js", [], WPMET_EDD_AFF_VAR, true ); // it has a little customization (may be!).
}

add_action('wp_loaded', function(){
    remove_action( 'wp_head', array( 'InsertConvertFox', 'insert_tracker' ));
    add_action( 'wp_footer', array( 'InsertConvertFox', 'insert_tracker' ), 5);
});

