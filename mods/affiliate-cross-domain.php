<?php
namespace Wpmet_Essential\Mods;

defined( 'ABSPATH' ) || exit;

class Affiliate_Cross_Domain{
    public function __construct(){
        add_action( 'wp_footer', [$this, 'tracking_script'] );
        add_action( 'wp_head', [$this, 'config_script'] );
    }

    public function tracking_script() {
        // these two files are copied from original EDD affiliate plugin.
        wp_enqueue_script('wpmet_edd_aff_cookie', \Wpmet_Essential::instance()->get_url() . "assets/js/jquery.cookie.min.js", [], \Wpmet_Essential::instance()->get_version(), true );
        wp_enqueue_script('wpmet_edd_aff_tracking', \Wpmet_Essential::instance()->get_url() . "assets/js/tracking.js", [], \Wpmet_Essential::instance()->get_version(), true ); // it has a little customization (may be!).
    }

    public function config_script() {
    
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
            AFFWP.wpmet = '<?php echo \Wpmet_Essential::instance()->get_version(); ?>';
            
            AFFWP.cookie_domain = 'account.wpmet.com';
            
            AFFWP.referral_credit_last = 0;
        </script>
        <?php 
    }
}