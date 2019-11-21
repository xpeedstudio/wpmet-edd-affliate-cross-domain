<?php
/*
Plugin Name: Wpmet edd affliate cross domain
Plugin URI: #
Description: Pass affliate ref data to the main site.
Author: Emran
Version: 1.0.0
Author URI: wpmet.com
*/

if(session_id() == ''){
    session_start();
}

if(!is_admin() && isset($_GET['rui']) && !empty($_GET['rui']) && is_numeric($_GET['rui'])){
    $_SESSION["_rui"] = $_GET['rui'];
    add_action( 'wp_footer', 'wpmet_edd_affliate_cross_domain_function' );
}

if(!is_admin() && isset($_SESSION["_rui"])){
    add_action( 'wp_footer', 'wpmet_edd_affliate_cross_domain_function' );
}

function wpmet_edd_affliate_cross_domain_function() {
    $refurl = 'https://account.wpmet.com/affiliate-tracker.php?rui=' . (isset($_SESSION["_rui"]) ? $_SESSION["_rui"] : -1);
    // echo $refurl;
    ?>
        <iframe src="<?php echo $refurl; ?>" style="height:1px; width:1px; border:0; z-index:-999; opacity:0; overflow: hidden"></iframe>
    <?php
}