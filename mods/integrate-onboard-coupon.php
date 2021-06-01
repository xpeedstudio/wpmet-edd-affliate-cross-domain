<?php
namespace Wpmet_Essential\Mods;

defined( 'ABSPATH' ) || exit;

class Integrate_Onboard_Coupon{
    private $fired = false;

    public function __construct(){
        if(isset($_GET['promo']) && $_GET['promo'] == 'onboard-coupon'){
            setcookie('wctct63xjdefsaj', 'fired', time() + (3600 * 6), "/");
            $this->fired = true;
        }
        
        if(isset($_COOKIE['wctct63xjdefsaj']) && $_COOKIE['wctct63xjdefsaj'] == 'fired'){
            $this->fired = true;
        }
        
        if($this->fired === true){
            add_filter( 'body_class',[ $this, 'discount_code_body_class'] );
            add_action('wp_footer', [ $this, 'discount_code_iframe']);
        }
    }

    public function discount_code_iframe(){
        echo    '<iframe 
                style="height:0;width:0;opacity:0;overflow:hidden;" 
                src="https://account.wpmet.com/?discount=ONBOARDSPECIAL"></iframe>';
    }
    
    public function discount_code_body_class( $classes ) {
        
        $classes[] = 'show-discounted-pricing';
        $classes[] = 'discount-from-onboard';
        
        return $classes;    
    }
}