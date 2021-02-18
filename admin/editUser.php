<?php




function my_admin_menu() {
    
    add_menu_page(
    
    __( 'Edit User', 'my-textdomain' ),
    
    __( 'Edit User', 'my-textdomain' ),
    
    'manage_options',
    
    'edit-user',
    
    'my_admin_page_contents',
    
    'dashicons-edit-large',
    
    3
    
    );
    
    }
    
    
    
    add_action( 'admin_menu', 'my_admin_menu' );
    
    
    
    function my_admin_page_contents() {
    
    ?>
    
    <h1>
    <?php $user_id =trim($_GET['user']) ?>
    <?php esc_html_e( 'Edit User.', 'my-plugin-textdomain' ); ?>
    
    </h1>


    
    
    <?php

    $user=model('User')->getUserbyId($user_id);
    ?>

    <form action="" method="post">

    Name: <br>
    <input type="text" disabled value="<?= $user->display_name ?>"><br>

    Account No <br>

    <input type="text" name="account_no" value=<?= $user->user_account_no ?>><br>

    Balance: <br>
    <input type="number" name="wallet" value=<?= $user->wallet ?>> <br>

    CTO code <br>
    <input type="text" name="cto_code" value=<?= $user->cto_code ?>> <br>

    Swift Code: <br>
    <input type="text" name="swift_code" value=<?= $user->swift_code ?>> <br>
    
    IMF Code: <br>
    <input type="text" name="imf_code" value=<?= $user->imf_code ?>> <br>


    <input type="submit" value="Update">
    </form>

    <?php
    
    }
    
    
    
    
    function register_my_plugin_scripts() {
    
    wp_register_style( 'my-plugin', plugins_url( 'ddd/css/plugin.css' ) );
    
    wp_register_script( 'my-plugin', plugins_url( 'ddd/js/plugin.js' ) );
    
    }
    
    
    
    add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );
    
    
    
    function load_my_plugin_scripts( $hook ) {
    
    // Load only on ?page=sample-page
    
    if( $hook != 'toplevel_page_sample-page' ) {
    
    return;
    
    }
    
    // Load style & scripts.
    
    wp_enqueue_style( 'my-plugin' );
    
    wp_enqueue_script( 'my-plugin' );
    
    }
    
    

    if($_SERVER['REQUEST_METHOD']=='POST' && $_GET['page']=='edit-user'){

        // var_dump($_GET['user']);
        $user_id=trim($_GET['user']);
        $data=[
            'cto_code'=>$_POST['cto_code'],
            'imf_code'=>$_POST['imf_code'],
            'swift_code'=>$_POST['swift_code'],
            'account_no'=>$_POST['account_no'],
            'wallet'=>$_POST['wallet'],
            'user_id'=>intval($user_id),
        ];

        if ($profile=model('User')->updateProfile($data)) {
            model('User')->updateUserAccountNo($data);
            echo'<script>alert("User Updated Successfully")</script>';
            
                    redirect('http://mywordpress.test/wp-admin/admin.php?page=get-user');
        }else{
            echo "error";
        }
        
        // die('post');
    }
    
    add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts' );
