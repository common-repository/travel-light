<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class travellight_enqueue
{
  




  public static function TravelLightEnqueueFunctionsFe() {




wp_enqueue_script( 'travel-light', plugins_url( 'front-end-index.js' , __FILE__ ),array('jquery','jquery-ui-core') ,'1.0.0', true ); 

wp_enqueue_style( 'travel-light', plugins_url( 'index.css', __FILE__ ) );

wp_enqueue_style( 'w3', plugins_url( 'w3.css', __FILE__ ) );

wp_localize_script( 'main_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ),false,false,false );

wp_enqueue_style('jquery'); 

wp_enqueue_style('jquery-ui-core'); 

}


public static function TravelLightEnqueueFunctions() {




wp_register_script('travel-light-admin',plugins_url( 'index.js', __FILE__ ),array('jquery','jquery-ui-core') ,'1.0.0', true ); 

wp_enqueue_script('travel-light-admin'); 

wp_enqueue_style( wp_register_style('travel-light-admin',plugins_url( 'index.css', __FILE__ ) )); 

wp_localize_script( 'travel-light-admin', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

wp_register_script('w3',plugins_url( 'w3.css', __FILE__ ));

wp_enqueue_script('w3'); 

wp_enqueue_script('googlemap',"https://maps.googleapis.com/maps/api/js?key=".esc_attr( get_option('travel-light_goggle_key'))."&sensor=true");

wp_register_script('googlemap1','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');

wp_enqueue_script('googlemap1'); 





}




}

 
?>