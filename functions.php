<?php

add_action( 'wp_enqueue_scripts', 'stm_enqueue_parent_styles' );

function stm_enqueue_parent_styles() {

  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

}

function enqueue_coc_scripts(){ 
  
  $script_uri = get_stylesheet_directory_uri() . '/coc.js'; 
    
  wp_register_script('coc', $script_uri);  
  
  wp_enqueue_script('coc', array('jquery'));      
  
  wp_localize_script( 'coc', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  

  if(is_page(9149) and !isset ( $_POST ['gform_submit'] )){ 
    
    $script_uri_api_car = get_stylesheet_directory_uri() . '/carqueryapi/carquery.0.3.4.js';
      $script_uri_api_ready= get_stylesheet_directory_uri() . '/carqueryapi/carqueryready.js';

      wp_register_script('apicar', $script_uri_api_car);
    wp_register_script('apicarready', $script_uri_api_ready);

    wp_enqueue_script('apicar', array('jquery'));
    wp_enqueue_script('apicarready', array('jquery'));

  }

  else if(is_page(9149) and isset ( $_POST ['gform_submit'] )){ 

    // empty carquery script to avoid getModels error message.
  }

}
add_action( 'wp_enqueue_scripts', 'enqueue_coc_scripts' );



/* Added by MJ
* From Gravity form to query database and send to user email after gravity form submitted.
*/

add_filter( 'gform_notification_10', 'gform_carquery', 10, 3 );
function gform_carquery( $notification, $form, $entry ) {


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
      . '<br><strong>Make:</strong> ' . $row->model_make_id 
      . '<br><strong>Model:</strong> ' . $row->model_name 
      . '<br><strong>Trim:</strong> ' . $row->model_trim 
      . '<br><strong>Year:</strong> ' . $row->model_year
      . '<br><strong>Body:</strong> ' . $row->model_body
      . '<br><strong>Engine Position:</strong> ' . $row->model_engine_position
      . '<br><strong>Engine CC:</strong> ' . $row->model_engine_cc
      . '<br><strong>Engine CYL:</strong> ' . $row->model_engine_cyl
      . '<br><strong>Engine Type:</strong> ' . $row->model_engine_type
      . '<br><strong>Engine Valves Per CYL:</strong> ' . $row->model_engine_valves_per_cyl
      . '<br><strong>Engine Power PS:</strong> ' . $row->model_engine_power_ps
      . '<br><strong>Engine Power RPM:</strong> ' . $row->model_engine_power_rpm
      . '<br><strong>Engine Torque NM:</strong> ' . $row->model_engine_torque_nm
      . '<br><strong>Engine Torque RPM:</strong> ' . $row->model_engine_torque_rpm
      . '<br><strong>Engine Bore MM:</strong> ' . $row->model_engine_bore_mm
      . '<br><strong>Engine Stroke MM:</strong> ' . $row->model_engine_stroke_mm
      . '<br><strong>Engine Compression:</strong> ' . $row->model_engine_compression
      . '<br><strong>Engine Fuel:</strong> ' . $row->model_engine_fuel
      . '<br><strong>Top Speed KPH:</strong> ' . $row->model_top_speed_kph
      . '<br><strong>0 To 100 KPH:</strong> ' . $row->model_0_to_100_kph
      . '<br><strong>Drive:</strong> ' . $row->model_drive
      . '<br><strong>Transmission Type:</strong> ' . $row->model_transmission_type
      . '<br><strong>Seats:</strong> ' . $row->model_seats
      . '<br><strong>Doors:</strong> ' . $row->model_doors
      . '<br><strong>Weight(kg):</strong> ' . $row->model_weight_kg
      . '<br><strong>Length(mm):</strong> ' . $row->model_length_mm
      . '<br><strong>Width(mm):</strong> ' . $row->model_width_mm
      . '<br><strong>Height(mm):</strong> ' . $row->model_height_mm
      . '<br><strong>Wheelbase(mm):</strong> ' . $row->model_wheelbase_mm
      . '<br><strong>LKM HWY:</strong> ' . $row->model_lkm_hwy
      . '<br><strong>LKM Mixed:</strong> ' . $row->model_lkm_mixed
      . '<br><strong>LKM City:</strong> ' . $row->model_lkm_city
      . '<br><strong>Fuel Cap 1:</strong> ' . $row->model_fuel_cap_l
      . '<br><strong>Sold in US:</strong> ' . $model_sold_in_us
      . '<br><strong>CO2:</strong> ' . $row->model_co2
      . '<br><strong>Make Display:</strong> ' . $row->model_make_display
      . '<br><br><br>';
  }

    return $notification;
}
