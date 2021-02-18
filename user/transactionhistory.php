<?php

function view_transaction_history(){
    
    $user_id=$_SESSION['user_id'];
    $data=model('Transaction')->getAllTransactions($user_id);

    // var_dump($data);
    echo'    
    <table class="table text-left">
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
                                <tbody id="order">';

    foreach ($data as $key => $value) {
      echo  '<tr>

    <td>'. $value->transaction_id .'</td>
            <td>'. $value->account_name .'</td>
            <td>'. $value->account_no .'</td>
                                            <td>'. $value->amount .'</td>
                                            <td>'.$value->transaction_type .'</td>
                                            <td>'. $value->bank_name .'</td>
                                            <td>'.$value->created_at .'</td>
                                            
                                            
                                        </tr>

        ';
    }

    echo '</tbody>
    </table>';

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