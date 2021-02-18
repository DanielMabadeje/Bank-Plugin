<?php
// namespace App\Models;
class Transaction
{
    private $db;

    /**
     * User constructor.
     * @param null $data
     */
    public function __construct()
    {
        $this->db = new Database;
        $this->query = new WP_Query('cat=12');
    }

    public function updateWallet($user_id, $value){
        // here is to update the profile wallet by user_id
        $this->db->query("UPDATE wp_user_profile 
        SET wallet=:wallet
        
        WHERE user_id=:user_id");
$this->db->bind(':wallet', $value);
$this->db->bind(':user_id', $user_id);

if ($this->db->execute()) {
    return true;
}else{
    return false;
}
    }

    public function createTransaction($data){

        // here requires user id, swift code, transaction type, beneficiary account_no


        // var_dump($data);
        // die;
        $this->db->query('INSERT INTO wp_transactions 
        (transaction_id, user_id, account_name, account_no, amount, transaction_type, bank_name) 
        VALUES(:transaction_id, :user_id, :account_name, :account_no, :amount, :transaction_type, :bank_name)');
        $this->db->bind(':transaction_id', $data['transaction_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':account_name', $data['account_name']);
        $this->db->bind(':account_no', $data['account_no']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':transaction_type', $data['transaction_type']);
        $this->db->bind(':bank_name', $data['bank_name']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getWallet($user_id)
    {
        $this->db->query('SELECT wallet FROM wp_user_profile WHERE user_id= :user_id');
        $this->db->bind(':user_id', $user_id);

        $row = $this->db->single();
        return $row;
    }
}