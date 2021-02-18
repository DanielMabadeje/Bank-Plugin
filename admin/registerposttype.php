<?php

function bankplugin_register_user_type() {
    
   // movies
   $labels = array( 
       'name' => __( 'BankPlugin' , 'bankplugin' ),
       'singular_name' => __( 'BankPlugin' , 'bankplugin' ),
       'add_new' => __( 'New User' , 'bankplugin' ),
       'add_new_item' => __( 'Add New Movie' , 'bankplugin' ),
       'edit_item' => __( 'Edit User' , 'bankplugin' ),
       'new_item' => __( 'New Movie' , 'bankplugin' ),
       'view_item' => __( 'View User' , 'bankplugin' ),
       'search_items' => __( 'Search User' , 'bankplugin' ),
       'not_found' =>  __( 'No Movies Found' , 'bankplugin' ),
       'not_found_in_trash' => __( 'No Movies found in Trash' , 'bankplugin' ),
   );
   $args = array(
       'labels' => $labels,
       'has_archive' => true,
       'public' => true,
       'hierarchical' => false,
       'supports' => array(
           'title', 
           'editor', 
           'excerpt', 
           'custom-fields', 
           'thumbnail',
           'page-attributes'
       ),
       'rewrite'   => array( 'slug' => 'movies' ),
       'show_in_rest' => true

   );
   register_post_type( 'bankplugin_movie', $args );
        
}

add_action( 'init', 'bankplugin_register_user_type' );