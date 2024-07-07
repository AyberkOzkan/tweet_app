<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <h2>Profile</h2>
    <form action="<?php echo URLROOT; ?>/profile/update" method="post">
        <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->email; ?>">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="birthday">Birthday: <sup>*</sup></label>
            <input type="date" name="birthday" class="form-control form-control-lg <?php echo (!empty($data['birthday_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->birthday; ?>">
            <span class="invalid-feedback"><?php echo $data['birthday_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="password">New Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>
        <div class="row">
            <div class="col">
                <input type="submit" value="Update" class="btn btn-success btn-block">
            </div>
        </div>
    </form>

    <h2 class="mt-5">Your Tweets</h2>
    <?php if (!empty($data['tweets'])): ?>
        <?php foreach ($data['tweets'] as $tweet) : ?>
            <div class="card card-body mb-3">
                <p><?php echo $tweet->tweet; ?></p>
                <div class="bg-light p-2 mb-3">
                    Written on <?php echo $tweet->created_at; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have not posted any tweets yet.</p>
    <?php endif; ?>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
