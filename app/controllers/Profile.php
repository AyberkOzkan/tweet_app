<?php

$baseDir = dirname(dirname(__DIR__));
$corePath = $baseDir . '/core/Database.php';
$userModelPath = $baseDir . '/app/models/User.php';
$tweetModelPath = $baseDir . '/app/models/Tweet.php';

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

if (file_exists($tweetModelPath)) {
    require_once $tweetModelPath;
} else {
    die("Tweet.php not found at $tweetModelPath<br>");
}

class Profile {
    private $userModel;
    private $tweetModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->userModel = new User();
        $this->tweetModel = new Tweet();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
    
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $tweets = $this->tweetModel->getUserTweets($_SESSION['user_id']);
    
        $followersCount = $this->userModel->getFollowersCount($_SESSION['user_id']);
        $followingCount = $this->userModel->getFollowingCount($_SESSION['user_id']);
    
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_birthday'] = $user->birthday;
    
        $data = [
            'user' => $user,
            'tweets' => $tweets,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ];
    
        $this->view('profile/index', $data);
    }
    

    public function userProfile($id) {
        $user = $this->userModel->getUserById($id);
        $tweets = $this->tweetModel->getUserTweets($id);
    
        if (!$user) {
            header('location: ' . URLROOT);
            exit();
        }
    
        $followersCount = $this->userModel->getFollowersCount($id);
        $followingCount = $this->userModel->getFollowingCount($id);
        $isFollowing = $this->userModel->isFollowing($_SESSION['user_id'], $id);
    
        $data = [
            'user' => $user,
            'tweets' => $tweets,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'isFollowing' => $isFollowing
        ];
    
        $this->view('profile/view', $data);
    }
    

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    
            $data = [
                'id' => $_SESSION['user_id'],
                'email' => trim($_POST['email']),
                'birthday' => trim($_POST['birthday']),
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'email_err' => '',
                'birthday_err' => '',
                'password_err' => ''
            ];
    
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            }
    
            if (empty($data['birthday'])) {
                $data['birthday_err'] = 'Please enter your birthday';
            }
    
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a new password';
            }
    
            if (empty($data['email_err']) && empty($data['birthday_err']) && empty($data['password_err'])) {
                if ($this->userModel->updateUserProfile($data)) {
                    $_SESSION['user_email'] = $data['email'];
                    $_SESSION['user_birthday'] = $data['birthday'];
                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => 'Profile updated successfully.'
                    ];
                    header('location: ' . URLROOT . '/profile');
                    exit();
                } else {
                    $_SESSION['message'] = [
                        'type' => 'error',
                        'text' => 'Something went wrong.'
                    ];
                    header('location: ' . URLROOT . '/profile');
                    exit();
                }
            } else {
                $this->view('profile/index', $data);
            }
        } else {
            header('location: ' . URLROOT . '/profile');
            exit();
        }
    }
    
    private function view($view, $data = []) {
        $viewPath = dirname(dirname(__DIR__)) . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }

    public function follow($id) {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
    
        if ($this->userModel->followUser($_SESSION['user_id'], $id)) {
            $message = $_SESSION['username'] . ' started following you.';
            $this->userModel->addNotification($id, $_SESSION['user_id'], $message);
    
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'You are now following this user.'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Something went wrong.'
            ];
        }
    
        header('location: ' . URLROOT . '/profile/userProfile/' . $id);
        exit();
    }
    
    
    public function unfollow($id) {
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
    
        if ($this->userModel->unfollowUser($_SESSION['user_id'], $id)) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'You have unfollowed this user.'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Something went wrong.'
            ];
        }
    
        header('location: ' . URLROOT . '/profile/userProfile/' . $id);
        exit();
    }
    
    
}

?>
