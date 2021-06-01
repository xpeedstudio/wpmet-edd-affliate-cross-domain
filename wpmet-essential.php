<?php
/*
Plugin Name: Wpmet Essential
Plugin URI: #
Description: Pass affiliate ref data to the main site, pushing campaign coupon, tweaks in ConvertFox Scripts etc
Author: Emran
Version: 1.3.0
Author URI: wpmet.com
*/

define('WPMET_EDD_AFF_URL', plugin_dir_url( __FILE__ ));
//define('WPMET_EDD_AFF_VAR', '1.2.5' . time()); // for testing, caching preventing
define('WPMET_EDD_AFF_VAR', '1.3.0');

add_action( 'wp_footer', 'wpmet_edd_affliate_cross_domain_function_footer' );
add_action( 'wp_head', 'wpmet_edd_aff_config_head' );


function wpmet_edd_aff_config_head() {
    
    // these are the base configuration for edd affiliate scripts.
    ?>
    <script type='text/javascript'>
    /* <![CDATA[ */
    var affwp_scripts = {"ajaxurl":"https:\/\/account.wpmet.com\/wp-admin\/admin-ajax.php"};
    /* ]]> */
    </script>
    <script type="text/javascript">
        var AFFWP = AFFWP || {};
        AFFWP.referral_var = 'rui'; // referral $_GET param
        AFFWP.expiration = 30; // how long a referral data will stay. (days)
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

function discount_code(){
    $iframe = '
    <iframe style="height:0;width:0;opacity:0;overflow:hidden;" src="https://account.wpmet.com/?discount=ONBOARDSPECIAL"></iframe>
    ';

    if(isset($_COOKIE['wctct63xjdefsaj']) && $_COOKIE['wctct63xjdefsaj'] == 'fired'){
        echo $iframe;
    }    

}

add_action('wp_loaded', function(){
    if(isset($_GET['promo']) & $_GET['promo'] == 'onboard-coupon'){
        setcookie('wctct63xjdefsaj', 'fired', time() + (3600 * 6), "/");
    }

    add_action('wp_footer', 'discount_code');

    remove_action( 'wp_head', array( 'InsertConvertFox', 'insert_tracker' ));
    add_action( 'wp_footer', array( 'InsertConvertFox', 'insert_tracker' ), 5);
});

