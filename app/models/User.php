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
    public function followUser($followerId, $followingId) {
        $this->db->query('INSERT INTO follow_requests (sender_id, receiver_id, status) VALUES (:sender_id, :receiver_id, :status)');
        $this->db->bind(':sender_id', $followerId);
        $this->db->bind(':receiver_id', $followingId);
        $this->db->bind(':status', 'pending');
        $this->db->execute();
        $requestId = $this->db->lastInsertId();

        $message = "$followerId wants to follow you.";
        $this->addNotification($followingId, $followerId, $message, $requestId);

        return true;
    }

    // Unfollow user
    public function unfollowUser($followerId, $followingId) {
        $this->db->query('DELETE FROM followers WHERE sender_id = :sender_id AND receiver_id = :receiver_id');
        $this->db->bind(':sender_id', $followerId);
        $this->db->bind(':receiver_id', $followingId);
        return $this->db->execute();
    }

    // Get followers count
    public function getFollowersCount($userId) {
        $this->db->query('SELECT COUNT(*) as count FROM followers WHERE receiver_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result->count;
    }

    // Get following count
    public function getFollowingCount($userId) {
        $this->db->query('SELECT COUNT(*) as count FROM followers WHERE sender_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result->count;
    }

    // Check if user is following another user
    public function isFollowing($followerId, $followingId) {
        $this->db->query('SELECT * FROM followers WHERE sender_id = :sender_id AND receiver_id = :receiver_id');
        $this->db->bind(':sender_id', $followerId);
        $this->db->bind(':receiver_id', $followingId);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Check if follow request is pending
    public function isRequested($followerId, $followingId) {
        $this->db->query('SELECT * FROM follow_requests WHERE sender_id = :sender_id AND receiver_id = :receiver_id AND status = :status');
        $this->db->bind(':sender_id', $followerId);
        $this->db->bind(':receiver_id', $followingId);
        $this->db->bind(':status', 'pending');
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Get followers list
    public function getFollowers($userId) {
        $this->db->query('SELECT u.username, u.id FROM followers f JOIN users u ON f.sender_id = u.id WHERE f.receiver_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Get following list
    public function getFollowing($userId) {
        $this->db->query('SELECT u.username, u.id FROM followers f JOIN users u ON f.receiver_id = u.id WHERE f.sender_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Get notifications
    public function getNotifications($userId) {
        $this->db->query('SELECT n.*, u.username as sender_name FROM notifications n JOIN users u ON n.sender_id = u.id WHERE n.user_id = :user_id ORDER BY n.created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Get notification by ID
    public function getNotificationById($notificationId) {
        $this->db->query('SELECT * FROM notifications WHERE id = :id');
        $this->db->bind(':id', $notificationId);
        return $this->db->single();
    }

    // Mark notification as read
    public function markNotificationAsRead($notificationId) {
        $this->db->query('UPDATE notifications SET status = :status WHERE id = :id');
        $this->db->bind(':status', 'read');
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    // Add notification
    public function addNotification($userId, $senderId, $message, $requestId) {
        $this->db->query('INSERT INTO notifications (user_id, sender_id, message, status, follow_request_id) VALUES (:user_id, :sender_id, :message, :status, :follow_request_id)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':sender_id', $senderId);
        $this->db->bind(':message', $message);
        $this->db->bind(':status', 'unread');
        $this->db->bind(':follow_request_id', $requestId);
        return $this->db->execute();
    }

    public function acceptFollowRequest($requestId) {
        try {
            $this->db->beginTransaction();
    
            // Get the follow request
            $this->db->query('SELECT * FROM follow_requests WHERE id = :id');
            $this->db->bind(':id', $requestId);
            $request = $this->db->single();
    
            if ($request) {
                // Add to followers table
                $this->db->query('INSERT INTO followers (sender_id, receiver_id) VALUES (:sender_id, :receiver_id)');
                $this->db->bind(':sender_id', $request->sender_id);
                $this->db->bind(':receiver_id', $request->receiver_id);
                $this->db->execute();
    
                // Delete the notification
                $this->db->query('DELETE FROM notifications WHERE follow_request_id = :follow_request_id');
                $this->db->bind(':follow_request_id', $requestId);
                $this->db->execute();
    
                // Delete the follow request
                $this->db->query('DELETE FROM follow_requests WHERE id = :id');
                $this->db->bind(':id', $requestId);
                $this->db->execute();
    
                $this->db->commit();
                return true;
            }
    
            throw new Exception('Follow request not found');
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function rejectFollowRequest($requestId) {
        try {
            $this->db->beginTransaction();
    
            // Get the follow request
            $this->db->query('SELECT * FROM follow_requests WHERE id = :id');
            $this->db->bind(':id', $requestId);
            $request = $this->db->single();
    
            if ($request) {
                // Delete the notification
                $this->db->query('DELETE FROM notifications WHERE follow_request_id = :follow_request_id');
                $this->db->bind(':follow_request_id', $requestId);
                $this->db->execute();
    
                // Delete the follow request
                $this->db->query('DELETE FROM follow_requests WHERE id = :id');
                $this->db->bind(':id', $requestId);
                $this->db->execute();
    
                $this->db->commit();
                return true;
            }
    
            throw new Exception('Follow request not found');
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

    // Get unread notifications count
    public function getUnreadNotificationsCount($userId) {
        $this->db->query('SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND status = :status');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':status', 'unread');
        $result = $this->db->single();
        return $result->count;
    }

    public function getHomeTweets($userId) {
        $this->db->query('
            SELECT t.*, u.username, 
                CASE 
                    WHEN f.receiver_id IS NOT NULL THEN 1
                    ELSE 0
                END AS is_following
            FROM tweets t
            LEFT JOIN followers f ON t.user_id = f.receiver_id AND f.sender_id = :user_id
            JOIN users u ON t.user_id = u.id
            ORDER BY is_following DESC, t.created_at DESC
        ');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    
}

?>
