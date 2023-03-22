<?php
function kaufmannic_theme_setup() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'kaufmannic_theme' ),
    ) );
}
add_action( 'after_setup_theme', 'kaufmannic_theme_setup' );

function kaufmannic_theme_enqueue_styles() {
    wp_enqueue_style( 'kaufmannic_theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'kaufmannic_theme_enqueue_styles' );

function custom_page_template() {
    add_theme_support( 'custom-page-template' );
  }
  add_action( 'after_setup_theme', 'custom_page_template' );

  function my_include_main() {
    get_template_part( 'main' );
}