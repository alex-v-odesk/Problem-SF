<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
    'lib/assets.php', // Scripts and stylesheets
    'lib/extras.php', // Custom functions
    'lib/setup.php', // Theme setup
    'lib/titles.php', // Page titles
    'lib/wrapper.php', // Theme wrapper class
    'lib/customizer.php', // Theme customizer
    'lib/custom-tax.php', // Custom Post Types & Taxonomies

    'lib/_woo/functions.php', //woo functions
    'lib/_custom/functions.php', //custom functions
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

//WRITE LOG FUNCTION

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
