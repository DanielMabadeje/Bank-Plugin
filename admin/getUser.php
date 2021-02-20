<?php




function my_get_user_menu() {
    
    add_menu_page(
    
    __( 'Get User', 'my-textdomain' ),
    
    __( 'Get User', 'my-textdomain' ),
    
    'manage_options',
    
    'get-user',
    
    'my_get_user_page_contents',
    
    'dashicons-groups',
    
    3
    
    );
    
    }
    
    
    
    add_action( 'admin_menu', 'my_get_user_menu' );
    
    
    
    function my_get_user_page_contents() {
    

        $users=model("User")->getUsers();
        // var_dump($users);
    ?>
    
    <h1>
    
    <?php esc_html_e( 'Get Users.', 'my-plugin-textdomain' ); ?>
    
    </h1>


    <table class="table text-left">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Account No</th>
                                        <th> Swift Code </th>
                                        <th> Imf Code </th>
                                        <th> Cto Code </th>
                                        <th> Wallet </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody id="order">
    
    <?php

    foreach ($users as $key => $user) {

        ?>

<tr>

    <td><?= $user->display_name; ?></td>
            <td><?= $user->user_email; ?></td>
            <td><?= $user->user_account_no; ?></td>
                                            <td><?= $user->wallet; ?></td>
                                            <td><?= $user->swift_code; ?></td>
                                            <td><?= $user->imf_code; ?></td>
                                            <td><?= $user->cto_code; ?></td>
                                            <td><a href="<?=get_site_url()?>/wp-admin/admin.php?page=edit-user&user=<?= $user->ID ?>">Edit</a></td>
                                            
                                        </tr>

        <?php
    }
    ?>

    </tbody>
    </table>

    <?php
    
    }
    
    
    
    function register_get_user_plugin_scripts() {
    
    wp_register_style( 'my-plugin', plugins_url( 'ddd/css/plugin.css' ) );
    
    wp_register_script( 'my-plugin', plugins_url( 'ddd/js/plugin.js' ) );
    
    }
    
    
    
    add_action( 'admin_enqueue_scripts', 'register_get_user_plugin_scripts' );
    
    
    
    function load_get_user_plugin_scripts( $hook ) {
    
    // Load only on ?page=sample-page
    
    if( $hook != 'toplevel_page_sample-page' ) {
    
    return;
    
    }
    
    // Load style & scripts.
    
    wp_enqueue_style( 'my-plugin' );
    
    wp_enqueue_script( 'my-plugin' );
    
    }
    
    
    
    add_action( 'admin_enqueue_scripts', 'load_get_user_plugin_scripts' );
