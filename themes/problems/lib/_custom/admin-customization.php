<?php	

// changing the logo link from wordpress.org to your site
function hair_login_url() {  return home_url(); }

add_filter( 'login_headerurl', 'hair_login_url' );

// changing the alt text on the logo to show your site name
function hair_login_title() { return get_option( 'blogname' ); }

add_filter( 'login_headertitle', 'hair_login_title' );


// calling your own login css so you can style it
function hair_login_styles() {
    wp_enqueue_style( 'hair-login', get_stylesheet_directory_uri() . '/dist/styles/main.css' );
}

add_action( 'login_enqueue_scripts', 'hair_login_styles' );
