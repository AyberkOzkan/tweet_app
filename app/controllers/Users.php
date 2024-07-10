<?php

$baseDir = dirname(dirname(__DIR__));
$corePath = $baseDir . '/core/Database.php';
$modelPath = $baseDir . '/app/models/User.php';

if (file_exists($corePath)) {
    require_once $corePath;
} else {
    die("Database.php not found at $corePath<br>");
}

if (file_exists($modelPath)) {
    require_once $modelPath;
} else {
    die("User.php not found at $modelPath<br>");
}

class Users {
    private $userModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];
    
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
    
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
    
            if (empty($data['username_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
    
                if ($loggedInUser) {
                    $_SESSION['user_id'] = $loggedInUser->id;
                    $_SESSION['username'] = $loggedInUser->username;
                    $_SESSION['user_email'] = $loggedInUser->email;
                    $_SESSION['user_birthday'] = $loggedInUser->birthday;
    
                    // Get notifications
                    $notifications = $this->userModel->getNotifications($loggedInUser->id);
                    $_SESSION['notifications'] = $notifications;
                    $_SESSION['unread_notifications_count'] = $this->userModel->getUnreadNotificationsCount($loggedInUser->id);
    
                    foreach ($notifications as $notification) {
                        if ($notification->status == 'unread') {
                            echo "<script>
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    icon: 'info',
                                    title: '{$notification->message}'
                                });
                            </script>";
                            $this->userModel->markNotificationAsRead($notification->id);
                        }
                    }
    
                    header('location: ' . URLROOT . '/');
                } else {
                    $data['password_err'] = 'Password incorrect';
    
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''
            ];
    
            $this->view('users/login', $data);
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    
            // Init data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
    
            // Validate username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
                if ($this->userModel->findUserByUsername($data['username'])) {
                    $data['username_err'] = 'Username is already taken';
                }
            }
    
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
    
            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
    
            // Make sure errors are empty
            if (empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
                // Register user
                if ($this->userModel->register($data)) {
                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => 'You are registered and can log in.'
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
                $this->view('users/register', $data);
                return;
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
        }
    
        // Load view
        $this->view('users/register', $data);
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'You are logged out.'
        ];
        header('location: ' . URLROOT);
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
