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
    }
}