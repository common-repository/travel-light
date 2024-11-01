<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

class travellight_initialisation


{
  

public static function travelLightMenuItemsCreate()


  {



 add_menu_page('Travel Light ', 'Travel Light ', 'manage_options', 'travellight',array('travellight_initialisation','travelLightTopMenuPageCallback'));

 add_submenu_page('travellight', 'Settings', 'Settings', 'manage_options', 'tl_settings', array('travellight_initialisation','travelLightSettingsPage'));

 //add_submenu_page( 'travellight', 'Instructions', 'Instructions', 'manage_options', 'tl_instruction', array('travellight_initialisation','travelLightTopMenuPageCallback'));




  }

public static function travelLightTopMenuPageCallback()

{

?>

<h3> Set up instructions </h3> 

<p> Travel Lights only works with Clear Booking Wordpress Plugin. Simple place the following HTML shortcode <span style="color:red;"> [travel-light-places-of-interest] </span> on any page and load the Travel light Map and Places of Interest widget.</p> 

<p> Once you have saved your google maps api key via the settings page your map will load, and your places of interest filter will be populated with the custom feilds that you specified via Trvael Lights add new posts pages that are found under Travel Light's menu.</p>



<?php

}

function travelLightSettingsPage() {

?>

<div class="wrap">

<?php

 if ( isset( $_POST['tl_menu_submit'] ) ) {
 

if ( 
    ! isset( $_POST['travel_light_menu_security_check'] ) 
    || ! wp_verify_nonce( $_POST['travel_light_menu_security_check'], 'travel_light_menu' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {

 
 if ( isset( $_POST['tl_goggle_key'] ) ) {
 

        update_option( "tl_goggle_key", sanitize_text_field( $_POST['tl_goggle_key']) );
 

 }

 if ( isset( $_POST['siteurl'] ) ) {
 

        update_option( "siteurl", esc_url( $_POST['siteurl']) );
 

 }

    } 




}





?>
<h2>Travel Light Settings</h2>

<form method="post" action="">

     <?php wp_nonce_field( 'travel_light_menu', 'travel_light_menu_security_check' ); ?>

    <?php settings_fields( 'tl-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'tl-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Google API key</th>
        <td><input type="text" name="tl_goggle_key" value="<?php echo esc_attr( get_option('tl_goggle_key') ); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Website URL </th>
        <td><input type="text" name="siteurl" value="<?php echo esc_attr( get_option('siteurl') ); ?>" /></td>
        </tr>  
 
    </table>


    <input type="hidden" name="tl_menu_submit" value="SUBMIT" />

    <?php submit_button(); ?>

</form>
</div>

<?php } 


  public static function travelLighttaxonomiesInitialisation()
  

  {
     

 register_post_type( 'place_of_interest',

        array(

                'labels' => array(
                'name' => 'Travel Light',
                'singular_name' => 'Place Of Interest',
                'add_new' => 'Add New Place of Interest',
                'add_new_item' => 'Add New Place Of Interest',
                'edit' => 'Edit',
                'edit_item' => 'Edit Place Of Interest',
                'new_item' => 'New Place Of Interest',
                'view' => 'View',
                'view_item' => 'View Place Of Interest',
                'search_items' => 'Search Places Of Interest',
                'not_found' => 'No Place Of Interest found',
                'not_found_in_trash' => 'No Place Of Interest found in Trash',
                'parent' => 'Parent Place Of Interest'

            ),
 
            'public' => true,
            'hierarchical'=> true,
            'menu_position' => 15,'show_ui'=>true,
            'supports' => array( 'title', 'editor', 'thumbnail','comments','post-formats'),
            'taxonomies' => array('place_of_interest_map'),
            'menu_icon' => plugins_url( 'images/cb_fav_icon.png', __FILE__ ),   'capability_type' => 'page',
            'has_archive' => true,'rewrite'=> array('slug' => 'place_of_interest'),
        )
    );


    register_taxonomy(
        'place_of_interest_map',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Maps',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );


 register_taxonomy(
        'place_of_interest_business',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Business type',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );



 register_taxonomy(
        'place_of_interest_service',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Service type',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );




  }




public static function travelLightsavePosts( $place_of_interest_id, $place_of_interest ) {


 $slug = 'place_of_interest';



if ( get_post_status( $place_of_interest_id) == 'publish' && $slug == $place_of_interest->post_type )


{



if ( !isset( $_POST['travel_light_POST_security_check'] )  || ! wp_verify_nonce( $_POST['travel_light_POST_security_check'], 'tl_POST_submit' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {



      if ( !empty( $_POST['fullname'] ) && $_POST['fullname'] != '' ) {

         
            update_post_meta( $place_of_interest_id, 'fullname', sanitize_text_field( $_POST['fullname'] ));
        

        }else{ wp_die( 'Please enter your fullname ', '' ) ; }
        

        if ( !empty( $_POST['company'] ) && $_POST['company'] != '' ) {
            update_post_meta( $place_of_interest_id, 'company', sanitize_text_field( $_POST['company']) );
        }else{ wp_die( 'Please enter your company name', '' ) ; }
        

        

        if ( !empty( $_POST['latlng'] ) && $_POST['latlng'] != '' ) {
            update_post_meta( $place_of_interest_id, 'latlng', sanitize_text_field( $_POST['latlng'] ));
        }else{ wp_die( 'Please enter you address', '' ) ; }


        if ( !empty( $_POST['country'] ) && $_POST['country'] != '' ) {
            update_post_meta( $place_of_interest_id, 'country',sanitize_text_field(  $_POST['country'] ));
        }else{ wp_die( 'Please select a country', '' ) ; }

        if ( !empty( $_POST['address'] ) && $_POST['address'] != '' ) {
            update_post_meta( $place_of_interest_id, 'address',sanitize_text_field(  $_POST['address'] ));
        }else{ wp_die( 'Please enter you address', '' ) ; }

        if ( !empty( $_POST['description'] ) && $_POST['description'] != '' ) {
            update_post_meta( $place_of_interest_id, 'description', sanitize_text_field( $_POST['description'] ));
        }else{ wp_die( 'Please enter a description of your business', '' ) ; }


        if ( !empty( $_POST['phone'] ) && $_POST['phone'] != '' ) {
            update_post_meta( $place_of_interest_id, 'phone',sanitize_text_field(  $_POST['phone'] ));
        }else{ wp_die( 'Please enter a phone number for your business', '' ) ; }


        if ( !empty( $_POST['email'] ) && $_POST['email'] != '' ) {
            update_post_meta( $place_of_interest_id, 'email', sanitize_email( $_POST['email'] ));
        }else{ wp_die( 'Please enter an email for your business', '' ) ; }

        if ( !empty( $_POST['website'] ) && $_POST['website'] != '' ) {
            update_post_meta( $place_of_interest_id, 'website', sanitize_text_field( $_POST['website'] ));
        }else{ wp_die( 'Please enter an website for your business', '' ) ; }
        


        $term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_service', array("fields" => "all"));

        $tax = $term_list[0]->name;

        if ( empty( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the option that best describes your place of interest's type of service", '' ) ; }
        

$term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_business', array("fields" => "all"));

        $tax = $term_list[0]->name;

       if ( empty( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the option that best describes your place of interest's type of business", '' ) ; }


$term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_map', array("fields" => "all"));

        $tax = $term_list[0]->name;

       if ( empty( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the map option that will be associated with your place of interest ", '' ) ; }



        }

}



}


public static function travelLightCustomPostsMeta_()
  

  {
    

 add_meta_box('details_meta_box','Place Of Interest Business Details','travellight_initialisation::travelLightbusinessDetailInitialisation','place_of_interest', 'normal', 'high');

 add_meta_box('location_meta_box','Place Of Interest Location Details','travellight_initialisation::travelLightlocationDetailInitialisation','place_of_interest', 'normal', 'high');

 

  }

public static function travelLightbusinessDetailInitialisation($place_of_interest)
  

  {


 $place_contact_name = get_post_meta( $place_of_interest->ID, 'fullname', true ) ;

 $place_company_name = get_post_meta( $place_of_interest->ID, 'company', true ) ;

 $place_company_phone = get_post_meta( $place_of_interest->ID, 'phone', true ) ;

 $place_company_email = get_post_meta( $place_of_interest->ID, 'email', true ) ;

 $place_company_website = get_post_meta( $place_of_interest->ID, 'website', true ) ;
   
 $place_company_description = get_post_meta( $place_of_interest->ID, 'description', true );

?>
   

<table id='bd_details_table'> 
 
<tr> <td><label> What is the best contact name ?&nbsp;
 </label> </td> <td><input id="fullname" class="form-control" type="text" placeholder="" name="fullname" value="<?php echo esc_attr( $place_contact_name); ?>"/> </td></tr>

<tr> <td><label>What is your company name ?&nbsp;
</label> </td> <td><input id="companyname" class="form-control" type="text" placeholder="" name="company" value="<?php echo esc_attr( $place_company_name); ?>" /> </td></tr>

<tr> <td> <label>What is you business phone number ?&nbsp;
</label></td> <td><input id="businessphone" class="form-control" type="text" placeholder="" name="phone" value="<?php echo esc_attr( $place_company_phone); ?>"/> </td></tr>

<tr> <td> <label>What is your email ?&nbsp;
</label></td> <td> <input id="email" name="email" class="form-control" type="text" placeholder="" value="<?php echo esc_attr( $place_company_email); ?>"/></td></tr>

<tr> <td> <label>What is your website url ?&nbsp;
</label></td> <td> <input id="website" class="form-control" type="text" placeholder="" name="website" value="<?php echo esc_attr( $place_company_website); ?>" /></td></tr>


<tr> <td> <label>How would you describe this place of interest?&nbsp;
</label></td> <td> <textarea id="description" class="form-control"  placeholder="" name="description" value="<?php echo esc_attr( $place_company_description); ?>" ></textarea></td></tr>


     <?php wp_nonce_field( 'tl_POST_submit', 'travel_light_POST_security_check' ); ?>

</table>
    <?php

  }

function travelLightlocationDetailInitialisation( $place_of_interest ) { 


 $place_company_latlng =  get_post_meta( $place_of_interest->ID, 'latlng', true ) ;

 $place_company_business =  get_post_meta( $place_of_interest->ID, 'address', true ) ;
   

$mapUrl = dirname( __FILE__ ) . '/map.php';



?>
  


<input id="address" class="form-control" size="75" type="text" placeholder="What is your business address ?" name="address" value="<?php echo esc_attr($place_company_business); ?>"/>

</br></br>

<?php 



 $r =  plugins_url( "map.php", __FILE__ );

 ?>



<div id="divformap" class="divformap" >

<iframe src="<?php echo  esc_url($r); ?>" width="100%" height="250" scrolling="no" seamless="seamless" id="mapframe" class="mapframe" >

  <p>Your browser does not support iframes.</p>
  
</iframe>

</div> 


<input type="hidden" name="latlng" id="latlng" value="<?php echo esc_attr($place_company_latlng); ?>"/>


     <?php wp_nonce_field( 'tl_POST_submit', 'travel_light_POST_security_check' ); ?>

<div id="multiplelist" class="multiplelist"> 



</div>


    <?php


}


}

 
?>