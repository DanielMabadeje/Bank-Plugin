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
        $this->query = new WP_Query('cat=12');
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
        $this->db->query('SELECT * FROM users WHERE id= :user_id');
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


}