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

    // Follow user
    public function followUser($follower_id, $followed_id) {
        $this->db->query('INSERT INTO follows (follower_id, followed_id) VALUES (:follower_id, :followed_id)');
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':followed_id', $followed_id);
        return $this->db->execute();
    }

    // Unfollow user
    public function unfollowUser($follower_id, $followed_id) {
        $this->db->query('DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id');
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':followed_id', $followed_id);
        return $this->db->execute();
    }

    // Check if user is following another user
    public function isFollowing($follower_id, $followed_id) {
        $this->db->query('SELECT * FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id');
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':followed_id', $followed_id);
        $row = $this->db->single();
        return ($this->db->rowCount() > 0);
    }

    // Get followers count
    public function getFollowersCount($user_id) {
        $this->db->query('SELECT COUNT(*) as count FROM follows WHERE followed_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row->count;
    }

    // Get following count
    public function getFollowingCount($user_id) {
        $this->db->query('SELECT COUNT(*) as count FROM follows WHERE follower_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row->count;
    }

    // Add notification
    public function addNotification($user_id, $follower_id, $message) {
        $this->db->query('INSERT INTO notifications (user_id, follower_id, message, status) VALUES (:user_id, :follower_id, :message, "unread")');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }

    // Get notifications
    public function getNotifications($user_id) {
        $this->db->query('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Mark notification as read
    public function markNotificationAsRead($notification_id) {
        $this->db->query('UPDATE notifications SET status = "read" WHERE id = :notification_id');
        $this->db->bind(':notification_id', $notification_id);
        return $this->db->execute();
    }

    // Get unread notifications count
    public function getUnreadNotificationsCount($user_id) {
        $this->db->query('SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND status = "unread"');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row->count;
    }

    public function getNotificationById($notification_id) {
        $this->db->query('SELECT * FROM notifications WHERE id = :notification_id');
        $this->db->bind(':notification_id', $notification_id);
        return $this->db->single();
    }         
    
}

?>
