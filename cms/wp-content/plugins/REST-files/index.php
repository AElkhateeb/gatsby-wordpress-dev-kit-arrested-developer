<?php
/**
 * @package REST files
 * @version 1
 */
/*
Plugin Name: REST files for Gatsby
Description: Provides Gatsby with documents as well as images via the REST api /media endpoint
Author: Michael Watts
Version: 1
Author URI: https://michaelwatts.co
*/

// overwrite the standard media GET endpoint
add_action( 'rest_api_init', function () {
  register_rest_route( 'wp/v2', '/media', array(
    'methods' => 'GET',
    'callback' => 'neuhack_get_media_documents',
  ) );
} );

function neuhack_get_media_documents() {
  // WP_Query arguments
  $args = array(
    'posts_per_page'   => -1,
    'post_type'        => 'attachment',
    'post_status'           => 'any',
);
// The Query
$query = new WP_Query( $args );

$output = Array();

foreach ($query->posts as $post) {
    $output[] = attachment_post_to_media_item($post);
}

return $output;
}


function attachment_post_to_media_item($post) {
// return $post;
  $meta = get_post_meta($post->ID);
  return Array(
    id => $post->ID,
    date => $post->post_date,
    date_gmt => $post->post_date_gmt,
    guid => [
      rendered => $post->guid,
    ],
    modified => $post->post_modified,
    modified_gmt => $post->post_modified_gmt,
    status => $post->post_status,
    type => $post->post_type,
    link => $post->guid,
    title => [
      rendered => $post->post_title,
    ],
    author => $post->post_author,
    media_type => $post->post_mime_type === 'image/jpeg' ? 'image' : 'file',
    mime_type => $post->post_mime_type,
    media_details => Array(),
    source_url => $post->guid,
    post => $post->post_parent,
  );
}