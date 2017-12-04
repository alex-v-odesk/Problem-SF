<?php

//==============
//! LANDSCAPE or PORTRAIT
//! check orientation of image
//==============

function image_orientation($width, $height)
{
    $width  = $width;
    $height = $height;

    $orientationCalc = $width / $height;
    $orientation     = '';

    if ($orientationCalc < 1) {
        $orientation = true;
    } elseif ($orientationCalc > 1) {
        $orientation = false;
    }

    return $orientation;
}
