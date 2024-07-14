<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetApp</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>">TweetApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#addTweetModal">Add Tweet</a>
                    </li>
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notifications <span class="badge badge-light"><?php echo count($_SESSION['notifications']); ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if (empty($_SESSION['notifications'])): ?>
                                <a class="dropdown-item" href="#">No notifications</a>
                            <?php else: ?>
                                <?php foreach ($_SESSION['notifications'] as $notification): ?>
                                    <div class="dropdown-item">
                                        <?php echo $notification->sender_name; ?> wants to follow you.
                                        <a href="<?php echo URLROOT; ?>/notifications/acceptFollowRequest/<?php echo $notification->id; ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>
                                        <a href="<?php echo URLROOT; ?>/notifications/rejectFollowRequest/<?php echo $notification->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="username">Username: <sup>*</sup></label>
                        <input type="text" name="username" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="<?php echo URLROOT; ?>/users/register" method="post">
                    <div class="form-group">
                        <label for="username">Username: <sup>*</sup></label>
                        <input type="text" name="username" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Tweet Modal -->
<div class="modal fade" id="addTweetModal" tabindex="-1" role="dialog" aria-labelledby="addTweetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTweetModalLabel">Add Tweet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tweetForm" action="<?php echo URLROOT; ?>/tweets/add" method="post">
                    <div class="form-group">
                        <textarea name="tweet" class="form-control form-control-lg" rows="3" maxlength="180" required oninput="updateCharacterCount(this)"></textarea>
                        <small id="charCount" class="form-text text-muted">180 characters remaining</small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tweet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="<?php echo URLROOT; ?>/profile/update" method="post">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $_SESSION['user_email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday: <sup>*</sup></label>
                        <input type="date" name="birthday" class="form-control form-control-lg" value="<?php echo $_SESSION['user_birthday']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateCharacterCount(textarea) {
        var maxLength = 180;
        var currentLength = textarea.value.length;
        var remaining = maxLength - currentLength;
        document.getElementById('charCount').innerText = remaining + ' characters remaining';
    }

    $(document).ready(function() {
        // SweetAlert notifications
        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['message']['type']; ?>',
                title: '<?php echo $_SESSION['message']['text']; ?>'
            });
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    });
</script>
</body>
</html>
