<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (username, password) VALUES (:username, :password)');
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($row) {
            $hashedPassword = $row->password;
            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function updateUserProfile($data) {
        $this->db->query('UPDATE users SET email = :email, birthday = :birthday, password = :password WHERE id = :id');
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':birthday', $data['birthday']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }
    
    public function getUserTweets($userId) {
        $this->db->query('SELECT * FROM tweets WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
}

?>
