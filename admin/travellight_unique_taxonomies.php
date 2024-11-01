<?php

if ( ! defined( 'ABSPATH' ) ) exit; 
 
class travellight_unique_taxonomies

{


 
 public static function travelLightUniqueTaxonomy()

  {

     
    add_action( 'place_of_interest_service_add_form_fields', array(__CLASS__, 'add_tax_image_field' ) );

    add_action( 'place_of_interest_service_edit_form_fields', array(__CLASS__, 'edit_tax_image_field' ) );

    add_filter( 'pre_insert_term', array( __CLASS__, 'prevent_add_term' ), 20, 2 );

    add_action( 'edited_place_of_interest_service', array(__CLASS__, 'save_tax_meta' ), 10, 2 );

    add_action( 'create_place_of_interest_service', array( __CLASS__, 'save_tax_meta' ), 10, 2 );

  }
 



public static function add_tax_image_field(){


$args = array( 'hide_empty' => false,'orderby'=> 'name','order'=> 'ASC'); 

$terms = get_terms('place_of_interest_business',$args);


?>



<div class="row">

<div class="col-sm-12"> <label for="term_meta[tax_image]" style="color:red; font-weight:bold;">

What type of business would you associate this service ?</label>

&nbsp;

</br>

<select class='taxselect' id='taxselect'>

<option >  </option> 

<?php foreach( $terms as $term )



        {

            



echo "<option value='$term->name'> $term->name </option>";




        }


?>





</select>

</div>

</div>

&nbsp;


<div class="row">

  <div class="col-sm-12"> <input type="text" name="term_meta[tax_image]" id="term_meta[tax_image]" value="" class='txtinput'/> </div>

</div>

&nbsp;

 <!-- /.form-field -->

<?php

}
 





public function edit_tax_image_field( $term ){

    $term_id = $term->term_id;

    $term_meta = get_option( "taxonomy_$term_id" );

    $image = $term_meta['tax_image'] ? $term_meta['tax_image'] : '';

?>
 


<div class="row">


  <div class="col-sm-12">


<label for="term_meta[tax_image]"><select class='taxselect' id='taxselect'><option> </option> 


<?php foreach( $terms as $term )



        {

            



echo "<option value='$term->name'> $term->name </option>";




        }


?>





</select>




</label>


</div>

</div>

<div class="row">
  <div class="col-sm-12"> 

<input type="text" name="term_meta[tax_image]" id="term_meta[tax_image]" value="<?php echo sanitize_text_field( $image ); ?>" class="txtinput"/>
  </div>

</div>

               
  


<?php
} 



function prevent_add_term( $term, $taxonomy ) {

if ( $taxonomy  !== 'place_of_interest_business' ) {


if (!empty( $_POST['term_meta']['tax_image'] ) ) {
    


return $term;

} else {


$term = new WP_Error( 'invalid_term', 'Please enter a type of business that you would associate with this service ' );

  return $term;


  }



}else{



  return $term;


}







}


public function save_tax_meta($term_id) {

    if ( isset( $_POST['term_meta'] ) ) {
 
$term_meta = array();
 
$term_meta['tax_image'] = isset ( $_POST['term_meta']['tax_image'] ) ? sanitize_text_field( $_POST['term_meta']['tax_image'] ) : '';
 
        update_option( "taxonomy_$term_id", $term_meta );
 
    } 


}



}

?>