<?php

class Class_model {
    private $table = [
        't_class',
        't_class_member',
        't_user',
        't_class_post',
        't_class_attachment',
        't_user_assignment'
    ];

    private $db;

    public function __construct() 
    {
        $this->db = new Database;
    }

    public function getUserClass($id)
    {
      $this->db->query('SELECT 
      t_class.grade, t_class.subject, t_class.code, t_class.teacher, t_class.pict, t_user.name 
      FROM ' . $this->table[1] . ' 
      INNER JOIN ' . $this->table[0] . ' ON t_class_member.class_id = t_class.id 
      INNER JOIN ' . $this->table[2] . ' ON t_class.teacher = t_user.id 
      WHERE t_class_member.user_id = :id ');
      $this->db->bind('id', $id);

      return $this->db->resultSet();
    }

    public function getTeacherClass($id)
    {
        $this->db->query('SELECT 
        t_class.grade, t_class.subject, t_class.code, t_class.teacher, t_class.pict, t_user.name 
        FROM ' . $this->table[0] . ' 
        INNER JOIN ' . $this->table[2] . ' ON t_class.teacher = t_user.id 
        WHERE teacher = :id ');
        $this->db->bind('id', $id);

        return $this->db->resultSet();
    }

    public function getClassByCode($code)
    {
        $this->db->query('SELECT t_class.*, t_user.name FROM ' . $this->table[0] . ' 
        INNER JOIN ' . $this->table[2] . ' ON t_class.teacher = t_user.id 
        WHERE code = :code');
        $this->db->bind('code', $code);

        return $this->db->single();
    }

    public function getClassById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table[0] . ' WHERE id = :id');
        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function getMemberById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table[1] . ' WHERE user_id = :id');
        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function memberCheck($request)
    {
        $this->db->query('SELECT * FROM ' . $this->table[1] . ' WHERE user_id = :user_id && class_id = :class_id');
        $this->db->bind('user_id', $request['user_id']);
        $this->db->bind('class_id', $request['class_id']);

        return $this->db->single();
    }

    public function getClassMember($class_id)
    {
        $this->db->query('SELECT * FROM ' . $this->table[1] . ' WHERE class_id = :class_id');
        $this->db->bind('class_id', $class_id);

        return $this->db->resultSet();
    }

    public function getClassPost($id)
    {
        $this->db->query('SELECT t_class_post.*, t_user.name FROM ' . $this->table[3] . ' 
        INNER JOIN ' . $this->table[2] . ' ON t_class_post.author = t_user.id 
        WHERE class_id = :id  ORDER BY t_class_post.id DESC');
        $this->db->bind('id', $id);

        return $this->db->resultSet();
    }

    public function createClass($request)
    {
      $this->db->query('INSERT INTO ' . $this->table[0] . ' (grade, subject, code, teacher, pict) 
      VALUES ( :grade, :subject, :code, :teacher, :pict )');
      $this->db->bind('grade', $request['grade']);
      $this->db->bind('subject', $request['subject']);
      $this->db->bind('code', $request['code']);
      $this->db->bind('teacher', $request['teacher']);
      $this->db->bind('pict', $request['pict']);
      $this->db->execute();

      return $this->db->rowCount();
    }

    public function joinClass($request)
    {
        $this->db->query('INSERT INTO ' . $this->table[1] . ' (class_id, user_id) 
        VALUES ( :class_id, :user_id)');
        $this->db->bind('class_id', $request['class_id']);
        $this->db->bind('user_id', $request['user_id']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function createPost($request)
    {
        $this->db->query('INSERT INTO ' . $this->table[3] . ' (class_id, author, categories, title, description, slug) 
        VALUES ( :class_id, :author, :categories, :title, :description, :slug)');
        $this->db->bind('class_id', $request['class_id']);
        $this->db->bind('author', $request['author']);
        $this->db->bind('categories', $request['categories']);
        $this->db->bind('title', $request['title']);
        $this->db->bind('description', $request['description']);
        $this->db->bind('slug', $request['slug']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delPost($id)
    {
        $this->db->query('DELETE FROM ' . $this->table[3] . ' WHERE id = :id');
        $this->db->bind('id', $id);
        $this->db->execute();

        return $this->db->rowCount();

    }

    public function setAttachment($request)
    {
        $this->db->query('INSERT INTO ' . $this->table[4] . ' (post_id, dirname, filename) VALUES
        (:post_id, :dirname, :filename)');
        $this->db->bind('post_id', $request['post_id']);
        $this->db->bind('dirname', $request['dirname']);
        $this->db->bind('filename', $request['filename']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getAttachment($post_id)
    {
        $this->db->query('SELECT * FROM ' . $this->table[4] . ' WHERE post_id = :post_id');
        $this->db->bind('post_id', $post_id);

        return $this->db->resultSet();
    }

    public function setAssignment($request)
    {
        $this->db->query('INSERT INTO ' . $this->table[5] . ' (post_id, user_id) VALUES
        (:post_id, :user_id)');
        $this->db->bind('post_id', $request['post_id']);
        $this->db->bind('user_id', $request['user_id']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getAssignment($user_id, $post_id)
    {

        $this->db->query('SELECT t_user_assignment.*, t_user.name FROM ' . $this->table[5] . ' 
        INNER JOIN ' . $this->table[2] . ' ON t_user_assignment.user_id = t_user.id 
        WHERE user_id = :user_id && post_id = :post_id');
        $this->db->bind('user_id', $user_id);
        $this->db->bind('post_id', $post_id);
    
        return $this->db->single();
        
    }

    public function submitWork($request)
    {
        $this->db->query('UPDATE '. $this->table[5] .' SET filename = :filename, dirname = :dirname 
        WHERE user_id = :user_id && post_id = :post_id');
        $this->db->bind('filename', $request['filename']);
        $this->db->bind('dirname', $request['dirname']);
        $this->db->bind('user_id', $request['user_id']);
        $this->db->bind('post_id', $request['post_id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function setMark($request)
    {
        $this->db->query('UPDATE '. $this->table[5] .' SET mark = :mark, teacher_note = :teacher_note 
        WHERE user_id = :user_id && post_id = :post_id');
        $this->db->bind('mark', $request['mark']);
        $this->db->bind('teacher_note', $request['teacher_note']);
        $this->db->bind('user_id', $request['user_id']);
        $this->db->bind('post_id', $request['post_id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getPostBySlug($slug)
    {
        $this->db->query('SELECT * FROM ' . $this->table[3] . ' WHERE '. $this->table[3] .'.slug = :slug');
        $this->db->bind('slug', $slug);

        return $this->db->single();
    }
    
    public function getPostByClass($class_id)
    {
        $this->db->query('SELECT * FROM ' . $this->table[3] . ' WHERE class_id = :class_id');
        $this->db->bind('class_id', $class_id);

        return $this->db->resultSet();
    }

    public function getPostAndAssignment($slug)
    {
        $this->db->query('SELECT t_class_post.*, t_user_assignment.*, t_user.name FROM ' . $this->table[3] . ' 
        INNER JOIN ' . $this->table[5] . ' ON t_class_post.id = t_user_assignment.post_id
        INNER JOIN ' . $this->table[2] . ' ON t_user_assignment.user_id = t_user.id 
        WHERE t_class_post.slug = :slug');
        $this->db->bind('slug', $slug);
    
        return $this->db->resultSet();
    }
}