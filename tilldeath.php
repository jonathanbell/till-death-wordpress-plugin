<?php
/**
 * Plugin Name: Till Death
 * Plugin URI: http://30.jonathanbell.ca
 * Description: Displays how old Jonathan Bell is in real time in the format years:months:days:hours:seconds.
 * Version: 0.01
 * Author: Jonathan Bell
 * Author URI: http://30.jonathanbell.ca
 * License: GPL2
 */

function tilldeath_add_countdown_js() {
  wp_enqueue_script('countdown', plugins_url('countdown.js', __FILE__), array('jquery'));
}
add_action('wp_enqueue_scripts', 'tilldeath_add_countdown_js');

function tilldeath_add_countdown_css() {
  wp_enqueue_style('countdown-styles', plugins_url('tilldeath.css', __FILE__));
}
add_action('init', 'tilldeath_add_countdown_css');

function tilldeath_append_html() {

  $str = '<div id="countdownwrapper"><span id="countdown"></span>';

  // check to see if you've turned 40 or not yet.
  $bday_30 = strtotime('Jan 11th, 2011, 5:33:31pm'); // the moment you turned 30
  $bday_40 = $bday_30 + 315569260; // add ten years in seconds
  $days = floor(($_SERVER['REQUEST_TIME']-$bday_30)/86400); // 86400 seconds in a day

  if ($_SERVER['REQUEST_TIME'] < $bday_40) {
    $str .= '&raquo; <span style="padding-left: 2px">'.$days.' days deep</span>';
  }
  else {
    // you are > 40 years old
    $str .= '&raquo; <span style="padding-left: 2px">It\'s all over...</span>';
  }

  $str .= '</div>';

  echo $str;

}
add_action('wp_footer', 'tilldeath_append_html', 1);

function tilldeath_add_inline_js() {
  // date example: new Date(2011, 4-1, 13, 17, 08, 0)
  // year, month-1(less one, zero based), day, 24hrs, min, sec
  echo '<script>jQuery(\'#countdown\').countdown({since: new Date(1981, 1-1, 11, 17, 35, 35), timezone:-7, format:\'YODHMS\', compact: true});</script>';
}
add_action('wp_footer', 'tilldeath_add_inline_js', 100);
