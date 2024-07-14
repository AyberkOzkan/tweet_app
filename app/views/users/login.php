<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="stylesheet" href="/tweet_app/public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .auth-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .auth-container h2 {
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control {
            height: 45px;
            font-size: 16px;
        }
        .form-group label {
            font-weight: 500;
            color: #555;
        }
        .text-center {
            text-align: center;
        }
        .toggle-btn {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2 class="text-center" id="form-title">Login</h2>
        <form id="auth-form" action="/tweet_app/users/login" method="post">
            <div id="form-fields">
                <div class="form-group">
                    <label for="username">Username: <sup>*</sup></label>
                    <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>">
                    <span class="invalid-feedback"><?php echo isset($data['username_err']) ? $data['username_err'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>">
                    <span class="invalid-feedback"><?php echo isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Login" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>
        <p class="text-center mt-3">Don't have an account? <span class="toggle-btn" onclick="toggleForm()">Register here</span></p>
    </div>

    <script>
        function toggleForm() {
            const formTitle = document.getElementById('form-title');
            const authForm = document.getElementById('auth-form');
            const formFields = document.getElementById('form-fields');
            const toggleBtn = document.querySelector('.toggle-btn');

            if (formTitle.textContent === 'Login') {
                formTitle.textContent = 'Register';
                authForm.action = '/tweet_app/users/register';
                toggleBtn.textContent = 'Login here';
                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="username">Username: <sup>*</sup></label>
                        <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>">
                        <span class="invalid-feedback"><?php echo isset($data['username_err']) ? $data['username_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>">
                        <span class="invalid-feedback"><?php echo isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['confirm_password']) ? $data['confirm_password'] : ''; ?>">
                        <span class="invalid-feedback"><?php echo isset($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
                    </div>
                `;
                document.querySelector('input[type="submit"]').value = 'Register';
            } else {
                formTitle.textContent = 'Login';
                authForm.action = '/tweet_app/users/login';
                toggleBtn.textContent = 'Register here';
                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="username">Username: <sup>*</sup></label>
                        <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>">
                        <span class="invalid-feedback"><?php echo isset($data['username_err']) ? $data['username_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>">
                        <span class="invalid-feedback"><?php echo isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                `;
                document.querySelector('input[type="submit"]').value = 'Login';
            }
        }
    </script>
</body>
</html>
