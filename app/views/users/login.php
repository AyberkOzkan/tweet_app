<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/tweet_app/public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="/tweet_app/users/login" method="post">
            <div class="form-group">
                <label for="username">Username: <sup>*</sup></label>
                <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Login" class="btn btn-success btn-block">
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($data['script'])): ?>
        <script>
            <?php echo $data['script']; ?>
        </script>
    <?php endif; ?>

    <?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
</body>
</html>
