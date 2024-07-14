<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Edit Profile</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo URLROOT; ?>/profile/update" method="post">
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday: <sup>*</sup></label>
                    <input type="date" name="birthday" class="form-control form-control-lg <?php echo (!empty($data['birthday_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['birthday']; ?>">
                    <span class="invalid-feedback"><?php echo $data['birthday_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
