<?php

class User_model {
    private $table = [
      't_user',
      't_user_detail'
    ];
    private $excluded = 'admin';
    private $role = [
      'siswa',
      'guru',
      'admin'
    ];

    private $db;

    public function __construct() 
    {
        $this->db = new Database;
    }

    public function getAllUser()
    {
      $this->db->query('SELECT t_user.id, t_user.name, t_user.role, t_user.email, t_user_detail.no_induk, 
      t_user_detail.position, t_user_detail.gender , t_user_detail.address, t_user_detail.birth FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.name != :excluded_name');
      $this->db->bind('excluded_name', $this->excluded);

      return $this->db->resultSet();
    }

    public function getAllUserPage($offset, $limit)
    {
      $this->db->query('SELECT t_user.id, t_user.name, t_user.role, t_user.email, t_user_detail.no_induk, 
      t_user_detail.position, t_user_detail.gender , t_user_detail.address, t_user_detail.birth FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.name != :excluded_name LIMIT :offset, :limit');
      $this->db->bind('excluded_name', $this->excluded);
      $this->db->bind('offset', $offset);
      $this->db->bind('limit', $limit);

      return $this->db->resultSet();
    }

    public function getAllStudent($gender)
    {
      $this->db->query('SELECT t_user.name, t_user.role, t_user.email, t_user_detail.no_induk, 
      t_user_detail.position, t_user_detail.gender , t_user_detail.address, t_user_detail.birth FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.name != :excluded_name AND t_user.role = :role AND t_user_detail.gender = :gender');
      $this->db->bind('excluded_name', $this->excluded);
      $this->db->bind('role', $this->role[0]);
      $this->db->bind('gender', $gender);

      return $this->db->resultSet();
    }

    public function getAllTeacher()
    {
      $this->db->query('SELECT t_user.name, t_user.role, t_user.email, t_user_detail.no_induk, 
      t_user_detail.position, t_user_detail.gender , t_user_detail.address, t_user_detail.birth FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.name != :excluded_name AND t_user.role = :role');
      $this->db->bind('excluded_name', $this->excluded);
      $this->db->bind('role', $this->role[1]);

      return $this->db->resultSet();
    }

    public function getAllAdmin()
    {
      $this->db->query('SELECT t_user.name, t_user.role, t_user.email, t_user_detail.no_induk, 
      t_user_detail.position, t_user_detail.gender , t_user_detail.address, t_user_detail.birth FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.name != :excluded_name AND t_user.role = :role');
      $this->db->bind('excluded_name', $this->excluded);
      $this->db->bind('role', $this->role[2]);

      return $this->db->resultSet();
    }

    public function searchUser($request)
    {
        $this->db->query('SELECT t_user.*, t_user_detail.* FROM ' . $this->table[0] . ' 
        INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
        WHERE t_user.name LIKE :keyword OR t_user.role LIKE :keyword OR t_user_detail.no_induk LIKE :keyword OR 
        t_user_detail.position LIKE :keyword OR t_user_detail.address LIKE :keyword OR t_user_detail.birth LIKE :keyword');
        $this->db->bind('keyword', '%' . $request['keyword'] . '%');
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
      $this->db->query('SELECT * FROM ' . $this->table[0] . ' WHERE id = :id');
      $this->db->bind('id', $id);

      return $this->db->single();
    }

    public function getUserProfile($id)
    {
      $this->db->query('SELECT t_user.*, t_user_detail.* FROM ' . $this->table[0] . ' 
      INNER JOIN ' . $this->table[1] . ' ON t_user.id = t_user_detail.user_id 
      WHERE t_user.id = :id');
      $this->db->bind('id', $id);

      return $this->db->single();
    }

    public function getUserByName($name)
    {
      $this->db->query('SELECT * FROM ' . $this->table[0] . ' WHERE name = :name');
      $this->db->bind('name', $name);

      return $this->db->single();
    }

    public function getUserByEmail($param) 
    {
      $this->db->query('SELECT * FROM ' . $this->table[0] . ' WHERE email =:param OR name = :param');
      $this->db->bind('param', $param);

      return $this->db->single();
    }
    
    public function createUser($request) 
    {
      // account create
      $pass = password_hash($request['password'], PASSWORD_ARGON2ID);
      $this->db->query('INSERT INTO ' . $this->table[0] . ' (name, email, password) VALUES ( :username, :email, :pass )');
      $this->db->bind('username', $request['name']);
      $this->db->bind('email', $request['email']);
      $this->db->bind('pass', $pass);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function createProfile($request)
    { 
      // get account id
      $this->db->query('SELECT id FROM ' . $this->table[0] . ' WHERE name = :name');
      $this->db->bind('name', $request['name']);
      $id = $this->db->resultSet();

      // profile create
      $this->db->query('INSERT INTO ' . $this->table[1] . ' (user_id, no_induk) VALUES ( :user_id, :no_induk )');
      $this->db->bind('user_id', $id[0]['id']);
      $this->db->bind('no_induk', $request['noinduk']);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function changeUserPassword($id, $pass)
    {
      $pass = password_hash($pass, PASSWORD_ARGON2ID);
      $this->db->query('UPDATE ' . $this->table[0] . ' SET password = :pass WHERE id = :id');
      $this->db->bind('id', $id);
      $this->db->bind('pass', $pass);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function createUserByAdmin($request)
    {
      // account create
      $pass = password_hash($request['email'], PASSWORD_ARGON2ID);
      $this->db->query('INSERT INTO ' . $this->table[0] . ' (name, email, password, role) VALUES ( :username, :email, :pass, :role )');
      $this->db->bind('username', $request['name']);
      $this->db->bind('email', $request['email']);
      $this->db->bind('pass', $pass);
      $this->db->bind('role', $request['role']);
      $this->db->execute();
      
      return $this->db->rowCount();
    }

    public function createProfileByImport($request)
    { 
      set_time_limit(420);
      // get account id
      $this->db->query('SELECT * FROM ' . $this->table[0] . ' WHERE name = :name');
      $this->db->bind('name', $request['name']);
      $user = $this->db->single();

      // profile create
      $this->db->query('INSERT INTO ' . $this->table[1] . ' (user_id, no_induk, position, gender, religion, birth_place, birth) VALUES ( :user_id, :no_induk, :position, :gender, :religion, :birth_place, :birth )');
      $this->db->bind('user_id', $user['id']);
      $this->db->bind('no_induk', $request['no_induk']);
      $this->db->bind('position', $request['position']);
      $this->db->bind('gender', $request['gender']);
      $this->db->bind('religion', $request['religion']);
      $this->db->bind('birth_place', $request['birth_place']);
      $this->db->bind('birth', $request['birth_date']);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function createUserByImport($request)
    {
      set_time_limit(420);
      // account create
      $pass = password_hash($request['name'], PASSWORD_ARGON2ID);
      $this->db->query('INSERT INTO ' . $this->table[0] . ' (name, password, role) VALUES ( :username, :pass, :role )');
      $this->db->bind('username', $request['name']);
      $this->db->bind('pass', $pass);
      $this->db->bind('role', $request['role']);
      $this->db->execute();
      
      return $this->db->rowCount();
    }

    public function editProfil($request)
    { 
      $this->db->query('UPDATE ' . $this->table[1] . ' SET no_induk = :no_induk, position = :position, gender = :gender, religion = :religion, address = :address, birth_place = :birth_place, birth = :birth, profpic = :profpic WHERE user_id = :user_id');
      $this->db->bind('user_id', $request['user_id']);
      $this->db->bind('no_induk', $request['noinduk']);
      $this->db->bind('position', $request['position']);
      $this->db->bind('gender', $request['gender']);
      $this->db->bind('address', $request['address']);
      $this->db->bind('religion', $request['religion']);
      $this->db->bind('birth_place', $request['birth_place']);
      $this->db->bind('birth', $request['birth']);
      $this->db->bind('profpic', $request['profpic']);
      $this->db->execute();

      return $this->db->rowCount();
    }
    
}