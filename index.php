<?php

 
    /*
    Plugin Name: Travel Light
    Plugin URI: https://travellight.herokuapp.com
    Description: Plugin for displaying places of interest 
    Author: M. Slack
    Version: 1.0
    Author URI: http://unifieddigitalmedia.com

   Travel Light is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 2 of the License, or
   any later version.
 
   Travel Lightis distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
 
   You should have received a copy of the GNU General Public License
   along with Travel Light. If not, see http://www.gnu.org/licenses/gpl-2.0.html.



    */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


spl_autoload_register(function ($class) {


if (file_exists(dirname( __FILE__ ) . '/admin/'. $class .'.php')) {


include dirname( __FILE__ ) . '/admin/'. $class .'.php';

}

else 

{


include dirname( __FILE__ ) . '/includes/'. $class .'.php';


}




});


if ( is_admin() ) {

  register_activation_hook(__FILE__, 'travellight_installation_checks::tl_installation_checks_');

  register_activation_hook( __FILE__, 'travellight_databases::TravelLighttripTableCreate' );

  add_action('init', 'travellight_initialisation::travelLighttaxonomiesInitialisation' );

  add_action( 'add_meta_boxes','travellight_initialisation::travelLightCustomPostsMeta_' );

  add_action('admin_menu', 'travellight_initialisation::travelLightMenuItemsCreate');

  add_action('save_post', 'travellight_initialisation::travelLightsavePosts', 10, 2 );

  add_action( 'admin_enqueue_scripts', 'travellight_enqueue::TravelLightEnqueueFunctions');

  add_action('init', 'travellight_actions::travelLightActionsIni' );

  add_action('init', 'travellight_unique_taxonomies::travelLightUniqueTaxonomy' );




}

else

{


   add_shortcode('travel-light-places-of-interest', 'travellight_shortcode::handle_shortcode');
 
   add_action('wp_enqueue_scripts', 'travellight_enqueue::TravelLightEnqueueFunctionsFe' );

    add_action('init', 'travellight_initialisation::travelLighttaxonomiesInitialisation' );




}



?>