<?php
/**
 * Project Specific Includes
 *
 * The $project_includes array determines the code library included in your theme.
 *
 * Please note that missing files will produce a fatal error.
 *
 *
 */
$project_includes = [
    'hair-ball.php',                //Setup some basic functions we always use
    'acf.php',                      //ACF Related functions
    'imageorientation.php',         //Image Orientation function
    'instagram.php',                //Instagram feed function (non-API)
    'getrandomstring.php',          //Get a random string
    'comments.php',                 //Obliterate Comments
    'ajax-forms.php',               //AJAX-ify the login/register forms
    'admin-customization.php',      //Custom styles on Admin
    '_problems/functions.php',
];

foreach ($project_includes as $file) {
    if (!$filepath = $file) {
        trigger_error(sprintf(__('Error locating %s for inclusion'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}

unset($file, $filepath);
