<?php

$baseDir = dirname(dirname(__DIR__));
$corePath = $baseDir . '/core/Database.php';
$userModelPath = $baseDir . '/app/models/User.php';

if (file_exists($corePath)) {
    require_once $corePath;
} else {
    die("Database.php not found at $corePath<br>");
}

if (file_exists($userModelPath)) {
    require_once $userModelPath;
} else {
    die("User.php not found at $userModelPath<br>");
}

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

    public function view($view, $data = []) {
        $viewPath = dirname(dirname(__DIR__)) . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }
}

?>
