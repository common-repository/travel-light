<?php


if ( ! defined( 'ABSPATH' ) ) exit; 

class travellight_shortcode

{
  
     

 function handle_shortcode($atts) {


         $a = shortcode_atts( array('map' => 'something'), $atts ,'places-of-interest');


ob_start();

    


        


 ?>



<div class="main-container" >

<div class="left-panel" id="left-panel">



<div class="row filter-first-row">

<div class="col-sm-12" id="firstrow" > REFINE YOUR EXPERIENCE </div>

</div>

<section class = "filter-section-1" >

<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="secondrow"  > Venue: </div>


</div>

<div class="row" id="containerdiv" >

<div class="col-sm-12"  id="thridrow"> 


<input id="place" class="target"  name="place" type="text" onkeydown="searchbrand()"/> 


</div>

</div>

<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="thridrow" > 


  <div id="fourthrowdiv" class="brandservice"> 



</div> 






  </div>


</div>


</section>

<section class = "filter-section-2" >

<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="secondrow"  > Special Interest: </div>


</div>

<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="thridrow" > 



<div id="fourthrowdiv" class='typeofbusiness' >



<?php 


$args = array( 'hide_empty' => false,'orderby'=> 'name','order'=> 'ASC');

$terms = get_terms('place_of_interest_business',$args);




foreach ($terms as $term)

{
$d = $term->name;


$html .= '
  <div class="row">
  <div class="col-sm-8">'.$term->name .'</div>
  <div class="col-sm-4" id="call-back_bis" ><input value="'.$term->name.'"type="checkbox" class="dbtob" ></div>
  </div>';

}



echo $html;

 ?>

</div>




  </div>


</div>

</section>

<section class = "filter-section-3" >

<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="secondrow"  > Type Of Service </div>


</div>


<div class="row" id="containerdiv" >

<div class="col-sm-12"  id="thridrow"> 

<div id="fourthrowdiv" class="typeofservice" >



</div> 

  </div>

</div>


</section>


<section>


<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

Country:

  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

<div id="fourthrowdivC">

<select name='country' id='country' class='country' >

<option> </option>

<?php 

$args = array( 'hide_empty' => false ); 

$taxonomies = array('place_of_interest_map');

$countries = array();

$countries = get_terms('place_of_interest_map',$args);



foreach( $countries as $country )



        {

            


echo "<option value='$country->name'> $country->name </option>";




        }








 ?>


</select>
</form>
</div>

  </div>

</div>


</section>

  
 </div>
      
 <a href="javascript:void(0);" class="slider-arrow show">&raquo;</a>


<div id="map" >

</div>

<div class="right-panel" id="right-panel">

<ul class="side-panel-right-list" id="side-panel-right-list" >  </ul>

<div class='form-button-wrapper'  >

<form action="../<?php $reservation_page = get_option('cb_reservation_page'); echo $reservation_page;  ?>/" method="post" name="tripconfirmform" id="tripconfirmform" class="tripconfirmform" >

<input type="hidden" id="chktoken" class="chktoken" name="token" />

<input type="hidden" name="trip" value="submit"/>

<button type="button" id="booktrip" class="btn btn-default btn-block input-sm outline-res"> Get rates </button>

</div>

</div>



<a href="javascript:void(0);" class="slider-arrow-right show">&laquo;</a>
      


</div>


<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr( get_option('tl_goggle_key')); ?>&libraries=weather&callback=initMap"
        async ></script>

<script type="text/javascript">

function initMap() {

map = new google.maps.Map(document.getElementById('map'), {

          center: {lat: 18.171100, lng: -76.442305},

           zoomControl: true,
    zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    },

          zoom: 8
        
        });

      }


      </script>



    <?php 

   

    return ob_get_clean();

    }



	








}






?>