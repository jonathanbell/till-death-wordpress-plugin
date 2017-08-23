<?php
/**
 * Plugin Name: Till Death
 * Plugin URI: https://github.com/jonathanbell/till-death-wordpress-plugin
 * Description: Displays how old Jonathan Bell is in real time. Format: years:months:days:hours:seconds.
 * Version: 1.0.0
 * Author: Jonathan Bell
 * Author URI: http://30.jonathanbell.ca
 * License: MIT
 */

function tilldeath_add_countdown_js() {
  wp_enqueue_script('countdown', plugins_url('js/countdown.min.js', __FILE__), array(), null, true);
}
add_action('wp_enqueue_scripts', 'tilldeath_add_countdown_js');

function tilldeath_append_html() {

  $str = '<div style="margin: 1rem 0; text-align: center; font-family: monospace, \'Andale Mono\';" id="countdownwrapper"><span id="countdown"></span> ';

  // Check to see if you've turned 40 or not yet.
  $bday_30 = strtotime('Jan 11th, 2011, 5:33:31pm'); // the moment you turned 30
  $bday_40 = $bday_30 + 315569260; // Add ten years in seconds.
  $days = floor(($_SERVER['REQUEST_TIME']-$bday_30) / 86400); // Divide by 86400 seconds in a day.

  if ($_SERVER['REQUEST_TIME'] < $bday_40) {
    $str .= '&raquo; '.$days.' days deep';
  }
  else {
    // Jonathan Bell is > 40 years old.
    $str .= '&raquo; It\'s all over...';
  }

  $str .= '</div>';

  echo $str;

}
add_action('wp_footer', 'tilldeath_append_html', 1);

function tilldeath_add_inline_js() {

  // year, month-1(less one, zero based), day, 24hrs, min, sec
  $output = <<<EOF

  <script>
    var bday_clock = document.getElementById('countdown');
    var bday = new Date(1981, 0, 11, 17, 33, 11, 0);

    function padZeros(str) {
      var str = '' + str;
      var pad = '00';
      var padded = pad.substring(0, pad.length - str.length) + str;

      return padded;
    }

    window.setInterval(function() {

      var current = countdown(bday);
      bday_clock.textContent = current.years + ':' + current.months + ':' + current.days + ':' + current.hours + ':' + padZeros(current.minutes) + ':' + padZeros(current.seconds);

    }, 1000);
  </script>

EOF;

  echo $output;

}
add_action('wp_footer', 'tilldeath_add_inline_js');
