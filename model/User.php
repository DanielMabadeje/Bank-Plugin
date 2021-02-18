<?php
// namespace App\Models;
class User
{
    private $db;

    /**
     * User constructor.
     * @param null $data
     */
    public function __construct()
    {
        $this->db = new Database;
        // $this->query = new WP_Query('cat=12');
        require_once( ABSPATH . WPINC . '/class-phpass.php');
    }



    // function to register user
    public function register($data)
    {
        // var_dump($data);
        // die();
        $this->db->query('INSERT INTO users (name, email, password, usertype, membership_plan, wallet) VALUES(:name, :email, :password, :usertype, :membership_plan, :wallet)');
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


    // function to login user

    public function login($email,  $password)
    {
        $this->db->query('SELECT * FROM wp_users WHERE user_email=:email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        $hashed_password = $row->user_pass;

        
        $wp_hasher = new PasswordHash(8, TRUE);
        if ($wp_hasher->CheckPassword($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }


    public function getUserbyId($user_id)
    {
        $this->db->query('SELECT user.display_name, user.ID, profile.user_id, profile.wallet, user.user_account_no, profile.cto_code, profile.swift_code, profile.imf_code FROM wp_users AS user
        INNER JOIN wp_user_profile AS profile
        ON user.ID=profile.user_id WHERE user.ID= :user_id');
        $this->db->bind(':user_id', $user_id);

        $row = $this->db->single();
        return $row;
    }


    public function getProfile($user_id){
        $this->db->query('SELECT * FROM wp_user_profile WHERE user_id= :user_id');
        $this->db->bind(':user_id', $user_id);

        $row = $this->db->single();
        return $row;
    }


    public function getUsers()
    {
        $this->db->query('SELECT user.ID, user.user_email, user.user_account_no, user.display_name, profile.wallet, profile.user_id, profile.swift_code, profile.imf_code, profile.cto_code FROM wp_users AS user
        INNER JOIN wp_user_profile AS profile
        ON user.ID=profile.user_id');


        return $this->db->resultSet();
    }

    public function createProfile($user_id)
    {
        $this->db->query('INSERT INTO wp_user_profile (user_id) VALUES(:user_id)');
        $this->db->bind(':user_id', $user_id);
        // $this->db->bind(':email', $data['email']);

        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function updateProfile($data)
    {
        $this->db->query("UPDATE wp_user_profile 
        SET wallet=:wallet,
        cto_code=:cto_code,
        swift_code=:swift_code,
        imf_code=:imf_code
        WHERE user_id=:user_id");

$this->db->bind(':wallet', $data['wallet']);
$this->db->bind(':user_id', $data['user_id']);
$this->db->bind(':swift_code', $data['swift_code']);
$this->db->bind(':cto_code', $data['cto_code']);
$this->db->bind(':imf_code', $data['imf_code']);


    if ($this->db->execute()) {
        return true;
    }else{
        return false;
    }
}

public function updateUserAccountNo($data)
{
    $this->db->query("UPDATE wp_users
    SET user_account_no=:account_no
    WHERE ID=:user_id ");

$this->db->bind(':account_no', $data['account_no']);
$this->db->bind(':user_id', $data['user_id']);

if ($this->db->execute()) {
    return true;
} else {
    # code...
}

}
}