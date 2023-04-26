<?php

class User_model {
    private $table = 't_user';

    private $db;

    public function __construct() 
    {
        $this->db = new Database;
    }

    public function getUserByEmail($email) 
    {
      $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email =:email');
      $this->db->bind('email', $email);

      return $this->db->single();
    }
    
    public function createUser($request) 
    {
      $pass = password_hash($request['password'], PASSWORD_ARGON2ID);
      $this->db->query('INSERT INTO ' . $this->table . ' (name, email, password) VALUES ( :username, :email, :pass )');
      $this->db->bind('username', $request['name']);
      $this->db->bind('email', $request['email']);
      $this->db->bind('pass', $pass);
      $this->db->execute();
      
      return $this->db->rowCount();
    }
    
}