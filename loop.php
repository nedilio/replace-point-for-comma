<?php
$post_type = 'portfolio';
global $wpdb;
$where = get_posts_by_author_sql( $post_type );
$query = "SELECT * FROM $wpdb->posts p where p.post_type = 'attachment' AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit') AND p.post_parent IN (SELECT $wpdb->posts.ID FROM $wpdb->posts  {$where} ) ORDER BY p.post_date DESC";
$results =  $wpdb->get_results( $query );

if ( $results ) {
  foreach ( (array) $results as $image ) {
  	$url = get_attachment_link($image->post_parent);
  	$thumb = wp_get_attachment_thumb_url( $image->ID );
  	$alt = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
  	print '<li><a href="' . $url . '"><img src="' . $thumb . '" alt="' . $alt . '" /></a></li>';
  }
}
;?>
