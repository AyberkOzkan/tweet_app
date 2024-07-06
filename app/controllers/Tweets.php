<?php

$baseDir = dirname(dirname(__DIR__));
$corePath = $baseDir . '/core/Database.php';
$tweetModelPath = $baseDir . '/app/models/Tweet.php';

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

class Tweets {
    private $tweetModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->tweetModel = new Tweet();
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            die('User not logged in');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    
            // Init data
            $data = [
                'user_id' => $_SESSION['user_id'],
                'tweet' => trim($_POST['tweet']),
                'tweet_err' => ''
            ];
    
            // Validate tweet
            if (empty($data['tweet'])) {
                $data['tweet_err'] = 'Please enter a tweet';
            } elseif (strlen($data['tweet']) > 180) {
                $data['tweet_err'] = 'Tweet must be less than 180 characters';
            }
    
            // Make sure errors are empty
            if (empty($data['tweet_err'])) {
                // Add tweet
                if ($this->tweetModel->addTweet($data)) {
                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => 'Tweet added successfully.'
                    ];
                    header('location: ' . URLROOT);
                    exit();
                } else {
                    $_SESSION['message'] = [
                        'type' => 'error',
                        'text' => 'Something went wrong.'
                    ];
                    header('location: ' . URLROOT);
                    exit();
                }
            } else {
                // Load view with errors
                $this->index($data);
                return;
            }
        } else {
            // Init data
            $data = [
                'tweet' => '',
                'tweet_err' => ''
            ];
        }
    
        // Load view
        $this->index($data);
    }    

    public function index($data = []) {
        // Get tweets
        $tweets = $this->tweetModel->getTweets();
        $data['tweets'] = $tweets;

        // Load view
        $this->view('tweets/index', $data);
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
