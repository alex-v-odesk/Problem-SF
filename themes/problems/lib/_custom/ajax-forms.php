<?php

//==============
// AJAX Login
//==============
function ajax_login_register_init() {

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');

    add_action('wp_ajax_nopriv_register_user', 'ajax_reg_new_user');

}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_register_init');
}

function ajax_login() {

    if (!$_POST['username']) {
        echo json_encode(array('registered' => false, 'message' => 'Whoops, Please enter an email address'));
        die();
    }

    if (!$_POST['password']) {
        echo json_encode(array('registered' => false, 'message' => 'Hmm... Please enter a password'));
        die();
    }


    // First check the nonce, if it fails the function will break
    check_ajax_referer('woocommerce-login', 'security');

    // Nonce is checked, get the POST data and sign user on
    $info                  = array();
    $info['user_login']    = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember']      = true;

    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {

        echo json_encode(array('loggedin' => false, 'message' => __('Whoops, wrong username or password.')));

    } else {

        echo json_encode(array('loggedin' => true, 'message' => __('Hooray, login successful, redirecting...')));
    }

    die();
}

//==============
// AJAX Register
//==============

/**
 * New User registration
 *
 */
function ajax_reg_new_user()
{

    // Verify nonce
    check_ajax_referer('woocommerce-register', 'security');

    // Nonce is checked, get the POST data and sign user on
    $info               = array();
    $info['user_login'] = $_POST['email'];
    $info['user_pass']  = $_POST['password'];
    $info['user_email'] = $_POST['email'];


    if (!$_POST['email']) {
        echo json_encode(array('registered' => false, 'message' => 'Whoops, Please enter an email address'));
        die();
    }

    if (!$_POST['password']) {
        echo json_encode(array('registered' => false, 'message' => 'Hmm... Please enter a password'));
        die();
    }

    $user_signup = wp_insert_user($info);

    if (is_wp_error($user_signup)) {

        echo json_encode(array('registered' => false, 'message' => 'Uh oh! ' . $user_signup->get_error_message()));

    } else {

        //Meta Data
        update_user_meta( $user_signup, 'first_name', $_POST['fname'] );
        update_user_meta( $user_signup, 'last_name', $_POST['lname'] );

        //Extra Fields
        //
        //add_user_meta( $user_signup, 'user_phone', $_POST['phone']);
        //add_user_meta( $user_signup, 'billing_phone', $_POST['phone']);
        //add_user_meta( $user_signup, 'billing_email', $_POST['email']);
        //add_user_meta( $user_signup, 'billing_first_name', $_POST['fname']);
        //add_user_meta( $user_signup, 'billing_last_name', $_POST['lname']);

        echo json_encode(array('user' => $user_signup, 'registered' => true, 'message' => __('Awesome, You/re Signed Up. Logging you in now...')));
    }

    die();
}







//==============
// AJAX Forgot Pass
//==============

/*
 *  @desc   Process lost password
 */
 
add_action( 'wp_ajax_nopriv_lost_pass', 'ajax_lost_pass' );
add_action( 'wp_ajax_lost_pass', 'ajax_lost_pass' );

function ajax_lost_pass() {

     if ( isset( $_POST['user_login'] ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'lost_password' ) ) {

        $success = WC_Shortcode_My_Account::retrieve_password();

        // If successful, redirect to my account with query arg set
        if ( $success ) {
            //wp_redirect( add_query_arg( 'reset-link-sent', 'true', remove_query_arg( array( 'key', 'login', 'reset' ) ) ) );

            echo 'Thanks, Check your e-mail for the password reset link.';
            wc_clear_notices();
            
            die();

        } else {

            echo 'Whoops... Invalid username or email';

            die();

        }
     }

}


//==============
// AJAX Reset Password
//==============

/*
 *  @desc   Process password reset
 */

add_action( 'wp_ajax_nopriv_reset_pass', 'ajax_reset_pass' );
add_action( 'wp_ajax_reset_pass', 'ajax_reset_pass' );

function ajax_reset_pass() {

    $posted_fields = array( 'password_1', 'password_2', 'reset_key', 'reset_login', '_wpnonce' );

    foreach ( $posted_fields as $field ) {
        if ( ! isset( $_POST[ $field ] ) ) {
            return;
        }
        $posted_fields[ $field ] = $_POST[ $field ];
    }

    if ( ! wp_verify_nonce( $posted_fields['_wpnonce'], 'reset_password' ) ) {
        return;
    }

    $user = WC_Shortcode_My_Account::check_password_reset_key( $posted_fields['reset_key'], $posted_fields['reset_login'] );

    if ( $user instanceof WP_User ) {
        if ( empty( $posted_fields['password_1'] ) ) {
            //wc_add_notice( __( 'Please enter your password.', 'woocommerce' ), 'error' );
            echo "Please enter a password.";
            die();
        }

        if ( $posted_fields[ 'password_1' ] !== $posted_fields[ 'password_2' ] ) {
            //wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' );
            echo "Passwords do not match.";
            die();
        }

        $errors = new WP_Error();

        do_action( 'validate_password_reset', $errors, $user );

        //wc_add_wp_error_notices( $errors );

        if ( 0 === wc_notice_count( 'error' ) ) {
            WC_Shortcode_My_Account::reset_password( $user, $posted_fields['password_1'] );

            do_action( 'woocommerce_customer_reset_password', $user );

            //wp_redirect( add_query_arg( 'reset', 'true', remove_query_arg( array( 'key', 'login', 'reset-link-sent' ) ) ) );
            echo "Success! Your Password has been reset";

            wc_clear_notices();

            die();
            //exit;
        }
    }

}