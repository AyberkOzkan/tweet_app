<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tweet</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Add Tweet</h2>
        <form action="<?php echo URLROOT; ?>/tweets/add" method="post">
            <div class="form-group">
                <textarea name="tweet" class="form-control form-control-lg <?php echo (!empty($data['tweet_err'])) ? 'is-invalid' : ''; ?>" rows="3"><?php echo $data['tweet']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['tweet_err']; ?></span>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Tweet" class="btn btn-success btn-block">
                </div>
            </div>
        </form>
    </div>

    <?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
</body>
</html>
