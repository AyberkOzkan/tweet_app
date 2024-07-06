<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="/tweet_app/public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if (!empty($data['script'])): ?>
        <script>
            <?php echo $data['script']; ?>
        </script>
    <?php endif; ?>

    <?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
</body>
</html>
