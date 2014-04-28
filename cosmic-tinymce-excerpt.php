<?php
/**
 * Plugin Name: Cosmic TinyMCE Excerpt
 * Description: TinyMCE pour les extraits
 * Author: Agence Cosmic
 * Author URI: http://agencecosmic.com/
 * Version: 1.0
 */

function cosmic_activate_page_excerpt() {
  add_post_type_support('page', array('excerpt'));
}
add_action('init', 'cosmic_activate_page_excerpt');

# Retire les extraits par défaut et les remplace par de nouveaux blocs
function cosmic_replace_post_excerpt() {
  foreach (array("post", "page") as $type) {
    remove_meta_box('postexcerpt', $type, 'normal');
    add_meta_box('postexcerpt', __('Excerpt'), 'cosmic_create_excerpt_box', $type, 'normal');
  }
}
add_action('admin_init', 'cosmic_replace_post_excerpt');

function cosmic_create_excerpt_box() {
  global $post;
  $id = 'excerpt';
  $excerpt = cosmic_get_excerpt($post->ID);

  wp_editor($excerpt, $id);
}

function cosmic_get_excerpt($id) {
  global $wpdb;
  $row = $wpdb->get_row("SELECT post_excerpt FROM $wpdb->posts WHERE id = $id");
  return $row->post_excerpt;
}
