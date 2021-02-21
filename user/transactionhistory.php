<?php

function view_transaction_history(){
    
    $user_id=$_SESSION['user_id'];
    $data=model('Transaction')->getAllTransactions($user_id);

    
    // var_dump($data);
    // echo'

    ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <div class="col-12 mx-auto">

        <div class="table-responsive">
        <table class="table table-striped text-left">
            <thead>
                <tr>
                    <th> Transaction Id </th>
                    <th> Account Name </th>
                    <th> Account No</th>
                    <th> Amount </th>
                    <th> Transaction Type </th>
                    <th> Bank </th>
                    <th> TimeStamp </th>
                </tr>
            </thead>
            <tbody id="order">
<?php
                foreach ($data as $key => $value) {
                    
                    ?>
                <tr>

                    <td><?= $value->transaction_id ?></td>
                    <td><?= $value->account_name ?></td>
                    <td><?= $value->account_no ?></td>
                    <td><?= $value->amount ?></td>
                    <td><?= $value->transaction_type ?></td>
                    <td><?= $value->bank_name ?></td>
                    <td><?= $value->created_at ?></td>
                </tr>

                <?php
        
        }

       ?>
       
            </tbody>
        </table>
    </div>
        </div>

        <?php
        

}


function wordpress_custom_transaction_history_function() {
    view_transaction_history();
}
add_shortcode( 'wp_transaction_history', 'wp_custom_shortcode_transaction_history' );

function wp_custom_shortcode_transaction_history() {
   ob_start();
   wordpress_custom_transaction_history_function();
   return ob_get_clean();
}


function register_transactions_history_plugin_scripts() {
    
        // wp_register_style( 'getUser-css-plugin', plugins_url( '/bank/css/getUser.css' ) );
        wp_register_style( 'transaction-bootstrap-plugin', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
    
        wp_register_script( 'script-plugin', plugins_url( 'ddd/js/plugin.js' ) );
    
    }
    
    add_action( 'transactionhistory', 'register_transactions_history_plugin_scripts' );
    
    function load_transactions_history_plugin_scripts( $hook ) {
    
      

        // Load style & scripts.
    
        // wp_enqueue_style( 'getUser-css-plugin' );
        wp_enqueue_style( 'transaction-bootstrap-plugin' );
    
        wp_enqueue_script( 'my-plugin' );
    
    }
    
    add_action( 'transactionhistory', 'load_transactions_history_plugin_scripts' );
