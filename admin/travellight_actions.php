<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class travellight_actions

{
  

 
 public static function travelLightActionsIni()
  

  {
    

add_action( 'wp_ajax_filter_serviceactionfe', array( __CLASS__, 'filter_service_action' ) );
add_action( 'wp_ajax_nopriv_filter_serviceactionfe', array( __CLASS__, 'filter_service_action' ) );


add_action( 'wp_ajax_filter_placehldersactionfe', array( __CLASS__, 'filter_plcservice_action' ) );

add_action( 'wp_ajax_nopriv_filter_placehldersactionfe', array( __CLASS__, 'filter_plcservice_action' ) );


add_action( 'wp_ajax_filter_actionfilter', array( __CLASS__, 'filter_action' ) );
add_action( 'wp_ajax_nopriv_filter_actionfilter', array( __CLASS__, 'filter_action' ) );
;


add_action( 'wp_ajax_filter_plcbrd_action',array( __CLASS__, 'filter_plcbrd_action' )  );
add_action( 'wp_ajax_nopriv_filter_plcbrd_action', array( __CLASS__, 'filter_plcbrd_action' ) );

add_action( 'wp_ajax_booktrip',array( __CLASS__, 'booktrip' )  );
add_action( 'wp_ajax_nopriv_booktrip', array( __CLASS__, 'booktrip' ) );





 }

function booktrip() {


ob_clean();

check_ajax_referer( 'travel_light_secure', 'security' ,false);


global $wpdb;

$table_name = $wpdb->prefix . 'tl_trip';

foreach ($_REQUEST[itinerary] as $value)

{

  
  $wpdb->insert( 
    $table_name, 
    array( 
      
      'place' => $value, 
      'token' => $_REQUEST['token'], 
    
    )); 



}


wp_reset_postdata();

echo "new trip record inserted";

wp_die();


}






function filter_plcbrd_action() { 


   ob_clean();

   check_ajax_referer( 'travel_light_secure', 'security' ,false);


$htmls = array();

   global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[typeofc]);

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );

$image = has_post_thumbnail( $post->ID ) ;

$image = (has_post_thumbnail( $post->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';

$imageurl  = ( empty($image) ) ? '' : $image[0];

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_service', array("fields" => "all"));

$tax = $term_list[0]->name;

$tag = get_the_title($post->ID);

if(get_the_title($post->ID) === $_REQUEST[typeofb]) 

{

$html = array(
"companyID" => $post->ID,
"fullname" => $s[fullname][0],
"compDescription" => $s[description][0],
"company" => $s[company][0],
"phone" => $s[phone][0],
"email" => $s[email][0],
"website" => $s[website][0],
"latlng" => $s[latlng][0],
"country" => $s[country][0],
"address" => $s[address][0],
"typeofbusiness" => $s[typeofbusiness][0],
"service" => $tax,
"image"=>$imageurl,

);

array_push($htmls,$html);

}

   endforeach; 
   
   wp_reset_postdata();

   echo json_encode($htmls);

   wp_die();


}

function filter_plcservice_action() { 


   ob_clean();

check_ajax_referer( 'travel_light_secure', 'security' ,false);


$htmls = array();



foreach ( $_REQUEST[typeofs] as $value ) 

{



$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[typeofc]);

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );

$image = has_post_thumbnail( $post->ID ) ;

$image = (has_post_thumbnail( $post->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';

$imageurl  = ( empty($image) ) ? '' : $image[0];

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_business', array("fields" => "all"));

$businessname = $term_list[0]->name;

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_service', array("fields" => "all"));

$tax = $term_list[0]->name;

if($tax === $value) 

{


$name = str_replace("'","", $s[company][0]);

$name2 = str_replace("'","",$s[company][0]);

$latlng = str_replace('(','',$s[latlng][0]);

$latlng = str_replace(')','', $latlng);

$a = array();

$a = explode(",",$latlng);

$id = $post->ID;

$html = array(

"companyID" => "$id",
"fullname" => $s[fullname][0],
"company" =>$post->ID,
"phone" => $s[phone][0],
"email" => $s[email][0],
"website" => $s[website][0],
"latlng" => $s[latlng][0],
"country" => $s[country][0],
"address" => $s[address][0],
"typeofbusiness" => $s[typeofbusiness][0],
"service" => $value,
"image"=>$imageurl,
"icon"=>$iconurl,
"Latitude" => str_replace(' ', '',$a[0]),
"Longitude" => str_replace(' ', '',$a[1]),


);

array_push($htmls,$html);

}


endforeach; 


}


   wp_reset_postdata();

   echo json_encode($htmls);

   wp_die();



}

function filter_action() { 



    ob_clean();

check_ajax_referer( 'travel_light_secure', 'security' ,false);

    global $post;
 
    $args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' =>   $_REQUEST[typeofc],'suppress_filters' =>false);

    $myposts = get_posts( $args );

    foreach ( $myposts as $post ) : setup_postdata( $post ); 

    $html .= '<div class="row"><div class="col-sm-12" id="placetag">'.get_the_title($post->ID).'</div></div>';
    endforeach; 

    wp_reset_postdata();

    echo $html;
    
    wp_die();


}

function filter_service_action() { 



    ob_clean();

check_ajax_referer( 'travel_light_secure', 'security' ,false);

$args = array( 'hide_empty' => false,'orderby'=> 'term_taxonomy_id','order'=> 'ASC');

$terms = get_terms('place_of_interest_service',$args);


foreach ($_REQUEST[typeofb] as $dbbis)

{

foreach ($terms as $term)

{

$db_ser_option = get_option( "taxonomy_".$term->term_id );

if($db_ser_option[tax_image] === $dbbis)

{


$html .= '
  <div class="row">
  <div class="col-sm-8">'.$term->name .'</div>
  <div class="col-sm-4" id="call-back_bis" ><input value="'.$term->name.'"type="checkbox" class="dbserchk" ></div>
  </div>';



}


}


}


   wp_reset_postdata();

   echo $html;

   wp_die();
  



}



}






?>