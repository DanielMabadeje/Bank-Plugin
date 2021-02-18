<?php

function view_transaction_history(){
    global;
    $user_id=$_SESSION['user_id'];
    // $data=model('Transaction')->getAllTransactions($user_id);

    ?>
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

}


function wordpress_custom_transaction_history_function() {
    view_transaction_history();
}
add_shortcode( 'wp_transaction_history', 'wp_custom_shortcode_transaction_history' );

function wp_custom_shortcode_transaction_history() {
   ob_start();
   wordpress_custom_transfer_history_function();
   return ob_get_clean();
}