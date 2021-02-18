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

    public function updateWallet(){
        // here is to update the profile wallet by user_id
    }

    public function createTransaction($data){

        // here requires user id, swift code, transaction type, beneficiary account_no

        $this->db->query('INSERT INTO transactions (user_id, account_no, amount, transaction_type, swift_code, wallet) VALUES(:name, :email, :password, :usertype, :membership_plan, :wallet)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':usertype', $data['usertype']);
        $this->db->bind(':membership_plan', $data['membership_plan']);
        $this->db->bind(':wallet', $data['wallet']);

        if ($this->db->execute()) {
            // return true;
            return $this->db->getLastId();
        } else {
            return false;
        }
    }
}