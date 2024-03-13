<?php
/**
 * @package Sofk Air Conditioning calculate
 */
/*
Plugin Name: Sofk Air Conditioning calculate
Plugin URI:  https://sofkpvtltd.com/shopfromreel/air-conditioning-calculator/
Description:  A short little description of the plugin. It will be displayed on the Plugins page in WordPress admin area.short code [air_condition_cal]
Version:      1.0
Author:       Sofk Pvt Ltd
Author URI:   https://sofkpvtltd.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  sofk-air-conditioning-calculate
Domain Path:  /languages

*/
if ( ! defined( 'ABSPATH' ) ) exit;
global  $plugin_url ,$plugin_dir;

$plugin_url = plugins_url()."/sofk-air-conditioning-calculate";
$plugin_dir = plugin_dir_path( __FILE__ );
if (!function_exists('SFACC_hook_css')) {
function SFACC_hook_css() {
    global $wpdb,$woocommerce,$plugin_url;	

		          wp_enqueue_script('air_cond-prototype');		
         		  wp_enqueue_script('air_cond_bootstrap',$plugin_url."/js/bootstrap.min.js");	         		  
				  wp_enqueue_style( 'bootsrap-air_cond',$plugin_url."/css/bootstrap.min.css");
                  wp_enqueue_style( 'style-air_cond',$plugin_url."/css/air-con-cala-style.css");

}

add_action('wp_head', 'SFACC_hook_css');
}

if (!function_exists('SFACC_cal_function')) {
  function SFACC_cal_function() {
  ob_start();
  $room_length_min = !empty(get_option('room_length_min'))?get_option('room_length_min'): 2.5;
  $room_length_max = !empty(get_option('room_length_max'))?get_option('room_length_max'): 10;
  $room_width_min = !empty(get_option('room_width_min'))?get_option('room_width_min'): 2.5;
  $room_width_max = !empty(get_option('room_width_max'))?get_option('room_width_max'): 10;
  $room_height_below_27 = !empty(get_option('room_height_below_27'))?get_option('room_height_below_27'): 1;
  $room_height_27_to_30 = !empty(get_option('room_height_27_to_30'))?get_option('room_height_27_to_30'): 1.1;
  $room_height_above_30 = !empty(get_option('room_height_above_30'))?get_option('room_height_above_30'): 1.2;
  $sunlight_exposure_shaded = !empty(get_option('sunlight_exposure_shaded'))?get_option('sunlight_exposure_shaded'): 1;
  $sunlight_exposure_sunny = !empty(get_option('sunlight_exposure_sunny'))?get_option('sunlight_exposure_sunny'): 1.15;
  $insulated_yes = !empty(get_option('insulated_yes'))?get_option('insulated_yes'): 1;
  $insulated_no = !empty(get_option('insulated_no'))?get_option('insulated_no'): '1.11';
  $btn_text = !empty(get_option('btn_text'))?get_option('btn_text'): 'Calculate Your Space';
  $btn_color = !empty(get_option('btn_color'))?get_option('btn_color'): 'black';
  $btn_bg = !empty(get_option('btn_bg'))?get_option('btn_bg'): 'transparent';
  $btn_border = !empty(get_option('btn_border'))?get_option('btn_border'): 'black';
  $btn_hover_color = !empty(get_option('btn_hover_color'))?get_option('btn_hover_color'): 'black';
  $btn_hover_bg = !empty(get_option('btn_hover_bg'))?get_option('btn_hover_bg'): 'transparent';
  $btn_hover_border = !empty(get_option('btn_hover_border'))?get_option('btn_hover_border'): 'black';
  $toshiba_ac_url = !empty(get_option('toshiba_ac_url'))?get_option('toshiba_ac_url'): plugin_dir_url( __FILE__ ).'/woocommerce-placeholder.png';
  $daikin_ac_url = !empty(get_option('daikin_ac_url'))?get_option('daikin_ac_url'): plugin_dir_url( __FILE__ ).'/woocommerce-placeholder.png';
  $contact_url = !empty(get_option('contact_url'))?get_option('contact_url'): '#';
  ?>
  <style>
      .air_condition_cal button{    background-color: <?php echo esc_html($btn_bg)?>;
      border-color: <?php echo esc_html($btn_border)?>;
      color: <?php echo esc_html($btn_color)?>;}
      .air_condition_cal button:hover{    background-color: <?php echo esc_html($btn_hover_bg)?>;
      border-color: <?php echo esc_html($btn_hover_border)?>;
      color: <?php echo esc_html($btn_hover_color)?>;}
  </style>

  <div class="air_condition_cal">
      <div class="container">
          <div class="air_condition_cal_div">
              <form>
                  <div class="form-group">
                      <div class="row">
                          <div class="col range-wrap">
                              <label for="length" class="form-label">Room Length</label>
                              <output class="bubble"></output>
                              <input type="range" class="form-range range" id="length"  min="<?php echo esc_html($room_length_min);?>" max="<?php echo esc_html($room_length_max);?>" step="0.5" value="0" name="length">
                              
                          </div>
                          <div class="col range-wrap">
                              <label for="width" class="form-label">Room Width</label>
                              <output class="bubble"></output>
                              <input type="range" class="form-range range" id="width"  min="<?php echo esc_html($room_width_min);?>" max="<?php echo esc_html($room_width_max);?>" step="0.5" value="0" name="width">
                          </div>
                      </div> 
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlInput1">Room Height</label>
                      <div class="check_group row">
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="room_height" id="room_height1" value="<?php echo esc_html($room_height_below_27);?>">
                            <label class="form-check-label" for="room_height1">Below 2.7m</label>
                          </div>
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="room_height" id="room_height2" value="<?php echo esc_html($room_height_27_to_30);?>">
                            <label class="form-check-label" for="room_height2">2.7m to 3.0m</label>
                          </div>
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="room_height" id="room_height3" value="<?php echo esc_html($room_height_above_30);?>">
                            <label class="form-check-label" for="room_height3">3.0m Above</label>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlInput1">Sunlight Exposure</label>
                      <div class="check_group row">                        
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="sunlight" id="sunlight1" value="<?php echo esc_html($sunlight_exposure_shaded);?>">
                            <label class="form-check-label" for="sunlight1">Shaded</label>
                          </div>
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="sunlight" id="sunlight2" value="<?php echo esc_html($sunlight_exposure_sunny);?>">
                            <label class="form-check-label" for="sunlight2">Sunny</label>
                          </div>       
                      </div>             
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlInput1">Is the roof area insulated?</label>
                      <div class="check_group row">
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="insulated" id="insulated1" value="<?php echo esc_html($insulated_yes);?>">
                            <label class="form-check-label" for="insulated1">Yes</label>
                          </div>
                          <div class="form-check form-check-inline col">
                            <input class="form-check-input" type="radio" name="insulated" id="insulated2" value="<?php echo esc_html($insulated_no);?>">
                            <label class="form-check-label" for="insulated2">No</label>
                          </div>    
                      </div>                
                  </div>
                  <span class="error_message text-danger"></span>
                  <div class="form-group">
                      <button type="button" class="air_calculate"><?php echo esc_html($btn_text);?></button> 
                      <div class="air_cal_result">Result: <span class="result_value">NaN kW</span></div> 
                      <div class="form-group floor-input">Floor: <span class="floor"></span></div>
                  </div>
              </form>
              <div class="ac_listing">
                  <div class="row">
                      
                  </div>
              </div>
          </div>
      </div>
  </div>
  <script>

      jQuery(".air_calculate").click(function(){
        flag = 1;
        length = jQuery('input[name="length"]').val();
        if(length == ''){
          jQuery('.error_message').html('Enter your Room Length');
          flag = 0;
          return;
        }
        
        width = jQuery('input[name="width"]').val();
        if(width == ''){
          jQuery('.error_message').html('Enter your Room width');
          flag = 0;
          return;
        }
        
        room_height = jQuery('input[name="room_height"]:checked').val();
      
        // if(room_height == '' || room_height == undefined){
        if(isNaN(room_height)){
          jQuery('.error_message').html('Enter your Room Height');
          flag = 0;
          return;
        }
        

        sunlight = jQuery('input[name="sunlight"]:checked').val();
        // if(sunlight == '' || sunlight == undefined){
        if(isNaN(sunlight)){
          jQuery('.error_message').html('Enter your Sunlight Exposure');
          flag = 0;
          return;
        }
        

        insulated = jQuery('input[name="insulated"]:checked').val();
        // if(insulated == '' || insulated == undefined){
        if(isNaN(insulated)){
          jQuery('.error_message').html('Enter your Roof Area Insulated');
          flag = 0;
          return;
        }
        result = '';
        Sunlight = '';
        rooHeight = '';
        width_length = (length * width);
        new_width_length = width_length * 0.135;
        if (!isNaN(room_height)) {
            rooHeight = new_width_length * room_height;
        }
        if (!isNaN(sunlight)) {
            Sunlight = rooHeight * sunlight;
        }
        if (!isNaN(insulated)) {
            if (insulated == '1') {
                result = Sunlight * 1.1;
            }else{
                result = Sunlight * insulated;
            }
        }
        
        // result = length * width * room_height * sunlight * insulated;
        
        if(result != ''){
          jQuery('.result_value').html(result.toFixed(2)+' kW');
          jQuery('.air_cal_result').show();
          jQuery('.error_message').hide();
          jQuery('.floor-input').show();
          jQuery('.floor').html(width_length.toFixed(2)+' m2');
        }
    
  }); 
  </script>
  <script>
      const allRanges = document.querySelectorAll(".range-wrap");
  allRanges.forEach(wrap => {
    const range = wrap.querySelector(".range");
    const bubble = wrap.querySelector(".bubble");

    range.addEventListener("input", () => {
      setBubble(range, bubble);
    });
    setBubble(range, bubble);
  });

  function setBubble(range, bubble) {
    const val = range.value;
    const min = range.min ? range.min : 0;
    const max = range.max ? range.max : 100;
    const newVal = Number(((val - min) * 100) / (max - min));
    bubble.innerHTML = val+'m';

    // Sorta magic numbers based on size of the native UI thumb
    bubble.style.left = `calc(${newVal}% + (${18 - newVal * 0.3}px))`;
  }

  </script>
  <?php
  $output = ob_get_clean();
    return  $output; 
    ob_end_clean();
      
  } 
  add_shortcode( 'air_condition_cal', 'SFACC_cal_function' );
}


/* air condition calculation admin setting*/
add_action('admin_menu', 'SFACC_cal_create_menu');

if (!function_exists('SFACC_cal_create_menu')) {
function SFACC_cal_create_menu() {

    //create new top-level menu
    add_menu_page('Air Condition Cal Settings', 'Air Condition Cal', 'administrator', 'air_condition_cal', 'SFACC_cal_settings_page' );

    //call register settings function
    add_action( 'admin_init', 'SFACC_cool_plugin_settings' );
}
}

if (!function_exists('SFACC_cool_plugin_settings')) {
function SFACC_cool_plugin_settings() {
    //register our settings
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_length_min' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_length_max' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_width_min' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_width_max' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_height_below_27' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_height_27_to_30' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'room_height_above_30' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'sunlight_exposure_shaded' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'sunlight_exposure_sunny' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'insulated_yes' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'insulated_no' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_text' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_color' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_bg' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_border' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_hover_color' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_hover_bg' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'btn_hover_border' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'toshiba_ac_url' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'daikin_ac_url' );
    register_setting( 'SFACC-cool-plugin-settings-group', 'contact_url' );

}
}

if (!function_exists('SFACC_cal_settings_page')) {
  function SFACC_cal_settings_page() {
  ?>
  <style>
  .myheader input{ width: 100%; }
  .myheader .button-primary { width: 10%; }
  .air_condition_cal_settings label{    width: 100%;
      float: left;}
  .air_condition_cal_settings input[type='color']{max-width: 40px;}

  </style>
  <div class="wrap myheader">
  <h1>Air Condition Cal Settings</h1>
  Short Code :   [air_condition_cal]
  <form method="post" action="options.php">
      <?php settings_fields( 'SFACC-cool-plugin-settings-group' ); ?>
      <?php do_settings_sections( 'SFACC-cool-plugin-settings-group' ); ?>
      <table class="form-table air_condition_cal_settings">
          <tr valign="top">
          <th scope="row">Room Length</th>
          <td><label>Room Min Length</label><input type="text" name="room_length_min" value="<?php echo esc_attr( get_option('room_length_min') ); ?>" placeholder="Enter Room Min Length"/></td>
          <td><label>Room Max Length</label><input type="text" name="room_length_max" value="<?php echo esc_attr( get_option('room_length_max') ); ?>" placeholder="Enter Room Max Length"/></td>
          <td></td>
          <td></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">Room Width</th>
          <td><label>Room Min Width</label><input type="text" name="room_width_min" value="<?php echo esc_attr( get_option('room_width_min') ); ?>" placeholder="Enter Room Min Width"/></td>
          <td><label>Room Max Width</label><input type="text" name="room_width_max" value="<?php echo esc_attr( get_option('room_width_max') ); ?>" placeholder="Enter Room Max Width"/></td>
          <td></td>
          <td></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">Room Height</th>
          <td><label>Room Height Value for  Below 2.7m</label><input type="text" name="room_height_below_27" value="<?php echo esc_attr( get_option('room_height_below_27') ); ?>" placeholder="Enter Room Height Below 2.7m"/></td>
          <td><label> Room Height Value for  2.7m to 3.0m</label><input type="text" name="room_height_27_to_30" value="<?php echo esc_attr( get_option('room_height_27_to_30') ); ?>" placeholder="Enter Room Height 2.7m to 3.0m"/></td>
          <td><label> Room Height Value for  3.0m Above</label><input type="text" name="room_height_above_30" value="<?php echo esc_attr( get_option('room_height_above_30') ); ?>" placeholder="Enter Room Height 3.0m Above"/></td>
          <td></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">Sunlight Exposure</th>
          <td><label> Sunlight Exposure Shaded Value</label><input type="text" name="sunlight_exposure_shaded" value="<?php echo esc_attr( get_option('sunlight_exposure_shaded') ); ?>" placeholder="Enter Sunlight Exposure Shaded"/></td>
          <td><label>Sunlight Exposure Sunny Value</label><input type="text" name="sunlight_exposure_sunny" value="<?php echo esc_attr( get_option('sunlight_exposure_sunny') ); ?>" placeholder="Enter Sunlight Exposure Sunny"/></td>
          <td></td>
          <td></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">Roof Area Insulated</th>
          <td><label>Roof Area Insulated Yes</label><input type="text" name="insulated_yes" value="<?php echo esc_attr( get_option('insulated_yes') ); ?>" placeholder="Enter Roof Area Insulated Yes"/></td>
          <td><label>Roof Area Insulated No</label><input type="text" name="insulated_no" value="<?php echo esc_attr( get_option('insulated_no') ); ?>" placeholder="Enter Roof Area Insulated No"/></td>
          <td></td>
          <td></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">Button</th>
          <td><label>Button Text</label><input type="text" name="btn_text" value="<?php echo esc_attr( get_option('btn_text') ); ?>" placeholder="Enter Button Text"/></td>
          <td><label> Button color</label><input type="color" name="btn_color" value="<?php echo esc_attr( get_option('btn_color') ); ?>" placeholder="Enter Button color"/></td>
          <td><label> Button Background color</label><input type="color" name="btn_bg" value="<?php echo esc_attr( get_option('btn_bg') ); ?>" placeholder="Enter Button Background color"/></td>
          <td><label> Button Border color</label><input type="color" name="btn_border" value="<?php echo esc_attr( get_option('btn_border') ); ?>" placeholder="Enter Button Border color"/></td>
          </tr>
          <tr valign="top">
          <th scope="row">Button Hover</th>
          <td><label> Button Hover color</label><input type="color" name="btn_hover_color" value="<?php echo esc_attr( get_option('btn_hover_color') ); ?>" placeholder="Enter Button Hover color"/></td>
          <td><label> Button Hover Background color</label><input type="color" name="btn_hover_bg" value="<?php echo esc_attr( get_option('btn_hover_bg') ); ?>" placeholder="Enter Button Hover Background color"/></td>
          <td><label> Button Hover Border color</label><input type="color" name="btn_hover_border" value="<?php echo esc_attr( get_option('btn_hover_border') ); ?>" placeholder="Enter Button Hover Border color"/></td>
          <td></td>
          </tr>
          
         
      </table>
      
      <?php submit_button(); ?>

  </form>
  </div>
  <?php } 
}


