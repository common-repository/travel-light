<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class travellight_databases


{



public static function TravelLighttripTableCreate()


  {


   	global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'tl_trip';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         tid mediumint(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	
         place varchar(100) NOT NULL,
      
         token text(100) NOT NULL,

         distance decimal(10,2) NOT NULL,

         resid mediumint(100) NOT NULL,

	 UNIQUE KEY tid (tid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

  }





}


?>