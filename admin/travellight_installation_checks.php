<?php


class travellight_installation_checks

{
  

 
 public static function tl_installation_checks_()
  

  {
    


    $category_ext = 'Clear Booking/index.php';

  
    if( !is_plugin_active( $category_ext ) ) {
	

	 echo '<h3>'.__('Please activate Clear Booking plugin before activating. <a target="_blank" href="https://clear-booking.herokuapp.com">Clear Booking</a>', 'ap').'</h3>';

        @trigger_error(__('Please activate Clear Booking plugin before activating.', 'ap'), E_USER_ERROR);
    


    }



 



  }






}


?>