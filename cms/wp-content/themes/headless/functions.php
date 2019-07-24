<?php
// Silence is golden.

/**
 * Hide the preview button in the editor
 */

function mercury_wp_admin_style() {
  wp_register_style( 'mercury_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
  wp_enqueue_style( 'mercury_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'mercury_wp_admin_style' );