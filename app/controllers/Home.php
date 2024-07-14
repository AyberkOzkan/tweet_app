<?php

$baseDir = dirname(dirname(__DIR__));
$corePath = $baseDir . '/core/Database.php';
$tweetModelPath = $baseDir . '/app/models/Tweet.php';
$userModelPath = $baseDir . '/app/models/User.php';  // User modelini ekleyin

if (file_exists($corePath)) {
    require_once $corePath;
} else {
    die("Database.php not found at $corePath<br>");
}

if (file_exists($tweetModelPath)) {
    require_once $tweetModelPath;
} else {
    die("Tweet.php not found at $tweetModelPath<br>");
}

if (file_exists($userModelPath)) {  // User modelini ekleyin
    require_once $userModelPath;
} else {
    die("User.php not found at $userModelPath<br>");
}

class Home {
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

        $tweets = $this->userModel->getHomeTweets($_SESSION['user_id']);

        $data = [
            'tweets' => $tweets
        ];

        $this->view('home/index', $data);
    }

    private function view($view, $data = []) {
        $viewPath = dirname(dirname(__DIR__)) . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }
}

?>
