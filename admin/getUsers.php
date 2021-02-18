<?php



function my_get_users() {
    
    add_menu_page(
    
    __( 'Get Users', 'my-textdomain' ),
    
    __( 'Get Users', 'my-textdomain' ),
    
    'manage_options',
    
    'get-users',
    
    'my_get_users_page_contents',
    
    'dashicons-schedule',
    
    3
    
    );
    
    }
    
    
    
    add_action( 'get_users', 'my_get_users' );
    
    
    
    function my_get_users_page_contents() {
    
    ?>
    
    <h1>
    
    <?php esc_html_e( 'Welcome to my get Users admin page.', 'my-plugin-textdomain' ); ?>
    
    </h1>


    
    
    <?php
    
    }
    
    
    
    function register_get_users_plugin_scripts() {
    
    wp_register_style( 'my-plugin', plugins_url( 'ddd/css/plugin.css' ) );
    
    wp_register_script( 'my-plugin', plugins_url( 'ddd/js/plugin.js' ) );
    
    }
    
    
    
    add_action( 'admin_enqueue_scripts', 'register_get_users_plugin_scripts' );
    
    
    
    function load_get_users_plugin_scripts( $hook ) {
    
    // Load only on ?page=sample-page
    
    if( $hook != 'toplevel_page_sample-page' ) {
    
    return;
    
    }
    
    // Load style & scripts.
    
    wp_enqueue_style( 'my-plugin' );
    
    wp_enqueue_script( 'my-plugin' );
    
    }
    
    
    
    add_action( 'admin_enqueue_scripts', 'load_get_users_plugin_scripts' );
