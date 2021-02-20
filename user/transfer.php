<?php

// For transfer


function wordpress_custom_transfer_form($wallet, $account_name, $account_no, $amount, $swift_code, $imf_code, $cto_code, $bank) {
    global  $amount, $swift_code, $imf_code, $cto_code, $account_name, $account_no, $bank;

    if (!isLoggedIn()) {
        echo '<script>alert("You are not logged in")</script>';
        redirect(get_site_url());
    }
    
    ?>
        <h1>Wallet :<?= $wallet ?></h1>
        <form class="form custom_form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
            Account Name : <br>
            <input type="text" name="account_name" value="<?php ( isset( $_POST['account_name']) ? $account_name : null ) ?>"><br>
            Account No: <br>
            <input type="text" name="account_no" value="<?php ( isset( $_POST['account_no']) ? $account_no : null ) ?>"><br>
            Amount: <br>
            <input type="number" name="amount" value="<?php ( isset( $_POST['amount']) ? $amount : null ) ?>"><br>
            Swift Code <strong>*</strong> <br>
            <input type="text" name="swift_code" value="<?php ( isset( $_POST['swift_code'] ) ? $swift_code : null )?>"><br>
            IMF Code <strong>*</strong> <br>
            <input type="text" name="imf_code" value="<?php ( isset( $_POST['imf_code'] ) ? $imf_code : null )?>"><br>
            CTO Code <strong>*</strong> <br>
            <input type="text" name="cto_code" value="<?php( isset( $_POST['cto_code'] ) ? $cto_code : null ) ?>"><br>
            Bank <strong>*</strong> <br>
            <input type="text" name="bank" value="<?php ( isset( $_POST['bank'] ) ? $bank : null ) ?>"><br>
            <br>
            <input type="submit" name="submit" value="Register"/>
        </form>
    <?php

}

function wp_transfer_form_valid( $amount, $swift_code, $imf_code, $cto_code, $account_no, $account_name)  {
    global $customize_error_validation;
    $customize_error_validation = new WP_Error;
    $userProfile=getProfile($_SESSION['user_id']);
    if ( empty( $amount ) || empty( $swift_code ) || empty( $imf_code ) || empty( $cto_code ) || empty( $account_no) || empty( $account_name ) ) {
        $customize_error_validation->add('field', ' Please Fill the required fields of WordPress transfer form');
    }
    if ($swift_code !== $userProfile->swift_code) {
        $customize_error_validation->add('field', ' Please Fill in your correct Swift Code');
    }
    
    if ($imf_code !== $userProfile->imf_code) {
        $customize_error_validation->add('field', ' Please Fill in your correct IMF Code');
    }
    
    if ($cto_code !== $userProfile->cto_code) {
        $customize_error_validation->add('field', ' Please Fill in your correct CTO Code');
    }
    if ($amount > $userProfile->wallet) {
        $customize_error_validation->add('field', ' You do not have enogh money for this transaction');
    }
    if ( is_wp_error( $customize_error_validation ) ) {
        foreach ( $customize_error_validation->get_error_messages() as $error ) {
         echo '<strong>Hold</strong>:';
         echo $error . '<br/>';
        }
    }
}

function getProfile($user_id)
{
    return model('User')->getProfile($user_id);
}
 
function wordpress_user_transfer_form_completion() {
    global $customize_error_validation, $amount, $swift_code, $imf_code, $cto_code, $account_name, $account_no, $bank;
    if ( 1 > count( $customize_error_validation->get_error_messages() ) ) {

        $trans_id=generate_random_Chars();
        $transactiondata = array(
        'transaction_id' =>   $trans_id,
         'account_name' =>   $account_name,
         'account_no' =>   $account_no,
         'amount' =>   $amount,
         'transaction_type' =>   'transfer',
         'bank_name' =>   $bank,
         'user_id' =>   $_SESSION['user_id'],
         'swift_code' =>   $swift_code,
         'imf_code' =>   $imf_code, 
         'cto_code'=>$cto_code
         
 
        );
        $walletvalue=getWallet($_SESSION['user_id']);
        $newWalletValue=$walletvalue-$amount;


        // var_dump($userdata);
        if ($transfer=model('Transaction')->createTransaction($transactiondata)) {
            model('Transaction')->updateWallet($_SESSION['user_id'], $newWalletValue);
            
        echo 'Transfer Successful';
        }else{
            echo'<span class="text-danger">Unsuccessful Transaction </span>';
        }
    }
}

function getWallet($user_id){
    $data=model('Transaction')->getWallet($user_id);
    return $data->wallet;
}
function wordpress_custom_transfer_form_function() {
    global $account_name, $account_no,$amount, $swift_code, $imf_code, $cto_code, $bank ;
    if ( isset($_POST['submit'] ) ) {
        wp_transfer_form_valid(
         $_POST['amount'],
         $_POST['swift_code'],
         $_POST['imf_code'],
         $_POST['cto_code'],
         $_POST['account_no'],
         $_POST['account_name']
       );
 
        $amount   =   sanitize_user( $_POST['amount'] );
        $swift_code   =   esc_attr( $_POST['swift_code'] );
        $imf_code=sanitize_text_field( $_POST['imf_code'] );
        $cto_code   =   sanitize_email( $_POST['cto_code'] );
        $account_name =   sanitize_text_field( $_POST['account_name'] );
        $account_no  =   sanitize_text_field( $_POST['account_no'] );
        $bank  =   sanitize_text_field( $_POST['bank'] );
       wordpress_user_transfer_form_completion(
         $amount,
         $swift_code,
         $imf_code, 
         $cto_code,
         $account_name,
         $account_no,
         $bank
        );
    }
    wordpress_custom_transfer_form(
        getWallet($_SESSION['user_id']),
        $amount,
        $swift_code,
        $imf_code, 
        $cto_code,
        $account_name,
        $account_no,
        $bank
    );
}
 
add_shortcode( 'wp_transfer_form', 'wp_custom_shortcode_transfer' );
 
function wp_custom_shortcode_transfer() {
    ob_start();
    wordpress_custom_transfer_form_function();
    return ob_get_clean();
}
 
// Custom Validation Field Method
// add_filter( 'transfer_errors', 'custom_validation_error_method', 10, 2 );
// function custom_validation_error_method( $errors, $lname, $account_no ) {
 
//     if ( empty( $_POST['fname'] ) || ( ! empty( $_POST['fname'] ) && trim( $_POST['fname'] ) == '' ) ) {
//         $errors->add( 'fname_error', __( '<strong>Error</strong>: Enter Your First Name.' ) );
//     }
 
//     if ( empty( $_POST['lname'] ) || ( ! empty( $_POST['lname'] ) && trim( $_POST['lname'] ) == '' ) ) {
//         $errors->add( 'lname_error', __( '<strong>Error</strong>: Enter Your Last Name.' ) );
//     }
//     return $errors;
// }



//Styles and Scripts


function register_transfer_plugin_scripts() {
    
        wp_register_style( 'transfer-css-plugin', plugins_url( '/bank/css/transaction.css' ) );
        wp_register_style( 'bootstrap-plugin', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
    
        wp_register_script( 'script-plugin', plugins_url( 'bank/js/transaction.js' ) );
    
}
    
add_action( 'admin_enqueue_scripts', 'register_transfer_plugin_scripts' );
    
function load_transfer_plugin_scripts( $hook ) {
    
        // Load only on ?page=sample-page
        // if( $hook != 'toplevel_page_get-user' ) {
    
        //     return;
    
        // }

        // Load style & scripts.
        wp_enqueue_style( 'getUser-css-plugin' );
        wp_enqueue_style( 'bootstrap-plugin' );
    
        wp_enqueue_script( 'my-plugin' );
    
}
    
add_action( 'admin_enqueue_scripts', 'load_transfer_plugin_scripts' );