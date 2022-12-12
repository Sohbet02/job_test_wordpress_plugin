<?php

if (! defined('WP_UNINSTALL_PLUGIN') ) {
    die();
}

// clear DB
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'dealer_catalog'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );


$wpdb->query( "DELETE FROM wp_terms WHERE term_id IN (SELECT term_id FROM wp_term_taxonomy WHERE taxonomy = 'city')" );
$wpdb->query( "DELETE FROM wp_term_taxonomy WHERE taxonomy = 'city'" );