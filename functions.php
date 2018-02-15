<?php
   

function enqueue_coc_scripts(){	
  
  $script_uri = get_stylesheet_directory_uri() . '/coc.js'; 
  	
  wp_register_script('coc', $script_uri);  
  
  wp_enqueue_script('coc', array('jquery'));      
  
  wp_localize_script( 'coc', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  


// run this script only to a specific page - the page with gravity form and carqueryapi query
	if(is_page(9149)){ 
		$script_uri_api_car = get_stylesheet_directory_uri() . '/carqueryapi/carquery.0.3.4.js';
  		$script_uri_api_ready= get_stylesheet_directory_uri() . '/carqueryapi/carqueryready.js';

  		wp_register_script('apicar', $script_uri_api_car);
		wp_register_script('apicarready', $script_uri_api_ready);

		wp_enqueue_script('apicar', array('jquery'));
		wp_enqueue_script('apicarready', array('jquery'));
	}

}

add_action( 'wp_enqueue_scripts', 'enqueue_coc_scripts' );



/* Added by MJ
* From Gravity form to query database and send to user email after gravity form submitted.
*/

add_filter( 'gform_notification_10', 'my_gform_notification_signature', 10, 3 );
function my_gform_notification_signature( $notification, $form, $entry ) {


    // get the field value from gravity form
    $year_field = $entry["19"];
    $make_field = $entry["20"];
    $model_field = $entry["21"];


  global $wpdb;
  $result = $wpdb->get_results("SELECT * FROM tbl_02_models where model_make_id = '".$make_field."' and model_name = '".$model_field."' and model_year = $year_field ORDER BY model_id");
  foreach($result as $row) {

    $model_sold_in_us = $row->model_sold_in_us;

    if($model_sold_in_us == 1) {
      $model_sold_in_us = 'Yes';
    } else {
      $model_sold_in_us = 'No';
    }

      $notification['message'] .= " <br><br>ID: " . $row->model_id 
      . '<br>Make: ' . $row->model_make_id 
      . '<br>Model: ' . $row->model_name 
      . '<br>Trim: ' . $row->model_trim 
      . '<br>Year: ' .$row->model_year
      . '<br>Body: ' .$row->model_body
      . '<br>Engine Position: ' .$row->model_engine_position
      . '<br>Engine CC: ' .$row->model_engine_cc
      . '<br>Engine CYL: ' .$row->model_engine_cyl
      . '<br>Engine Type: ' .$row->model_engine_type
      . '<br>Engine Valves Per CYL: ' .$row->model_engine_valves_per_cyl
      . '<br>Engine Power PS: ' .$row->model_engine_power_ps
      . '<br>Engine Power RPM: ' .$row->model_engine_power_rpm
      . '<br>Engine Torque NM: ' .$row->model_engine_torque_nm
      . '<br>Engine Torque RPM: ' .$row->model_engine_torque_rpm
      . '<br>Engine Bore MM: ' .$row->model_engine_bore_mm
      . '<br>Engine Stroke MM : ' .$row->model_engine_stroke_mm
      . '<br>Engine Compression: ' .$row->model_engine_compression
      . '<br>Engine Fuel: ' .$row->model_engine_fuel
      . '<br>Top Speed KPH: ' .$row->model_top_speed_kph
      . '<br>0 To 100 KPH: ' .$row->model_0_to_100_kph
      . '<br>Drive: ' .$row->model_drive
      . '<br>Transmission Type: ' .$row->model_transmission_type
      . '<br>Seats: ' .$row->model_seats
      . '<br>Doors: ' .$row->model_doors
      . '<br>Weight(kg): ' .$row->model_weight_kg
      . '<br>Length(mm): ' .$row->model_length_mm
      . '<br>Width(mm): ' .$row->model_width_mm
      . '<br>Height(mm): ' .$row->model_height_mm
      . '<br>Wheelbase(mm): ' .$row->model_wheelbase_mm
      . '<br>LKM HWY: ' .$row->model_lkm_hwy
      . '<br>LKM Mixed: ' .$row->model_lkm_mixed
      . '<br>LKM City: ' .$row->model_lkm_city
      . '<br>Fuel Cap 1: ' .$row->model_fuel_cap_l
      . '<br>Sold in US: ' .$model_sold_in_us
      . '<br>CO2: ' .$row->model_co2
      . '<br>Make Display: ' .$row->model_make_display;
  }

    return $notification;
}