<?php

if (class_exists('WooCommerce')) {

/* DECLARE THEME SUPPORT FOR WOO */
    add_theme_support('woocommerce');

//==============================================================================
    //! * Include wooCom Helper files.
    //==============================================================================

    $woocom_includes = [
        'dequeue.php',
        'hooks.php',
        'misc.php',
        'customer-detail-fields.php',
        'ajax-cart-count.php',
        'ajax-cart-remove.php',
        'variation-radios.php',        
        'email-customization.php',
    ];

    foreach ($woocom_includes as $file) {
        if (!$filepath = $file) {
            trigger_error(sprintf(__('Error locating %s for inclusion'), $file), E_USER_ERROR);
        }

        require_once $filepath;
    }

    unset($file, $filepath);

}
