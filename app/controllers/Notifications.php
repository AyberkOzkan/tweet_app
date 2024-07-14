<?php

class Notifications {
    private $userModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->userModel = new User();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
    
        $notifications = $this->userModel->getNotifications($_SESSION['user_id']);
    
        $data = [
            'notifications' => $notifications
        ];
    
        $this->view('notifications/index', $data);
    }    

    public function viewNotification($id) {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }

        $notification = $this->userModel->getNotificationById($id);
        if ($notification) {
            $this->userModel->markNotificationAsRead($id);
        }

        header('location: ' . URLROOT . '/notifications');
        exit();
    }

    public function acceptFollowRequest($id) {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }

        if ($this->userModel->acceptFollowRequest($id)) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Follow request accepted.'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Something went wrong. Check error logs for details.'
            ];
        }

        $this->updateNotifications();
    }

    public function rejectFollowRequest($id) {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }

        if ($this->userModel->rejectFollowRequest($id)) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Follow request rejected.'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Something went wrong. Check error logs for details.'
            ];
        }

        $this->updateNotifications();
    }

    private function updateNotifications() {
        $notifications = $this->userModel->getNotifications($_SESSION['user_id']);
        $_SESSION['notifications'] = $notifications;
        $_SESSION['unread_notifications_count'] = $this->userModel->getUnreadNotificationsCount($_SESSION['user_id']);
    
        header('location: ' . URLROOT);
        exit();
    }

    private function view($view, $data = []) {
        $viewPath = APPROOT . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }
}

?>
