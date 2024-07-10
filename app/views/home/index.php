<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <h2>Tweets</h2>
    <?php if (!empty($data['tweets'])): ?>
        <?php foreach ($data['tweets'] as $tweet) : ?>
            <div class="card card-body mb-3">
                <p><?php echo $tweet->tweet; ?></p>
                <div class="bg-light p-2 mb-3">
                    Written by <a href="<?php echo URLROOT; ?>/profile/userProfile/<?php echo $tweet->user_id; ?>"><?php echo $tweet->username; ?></a> on <?php echo $tweet->created_at; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tweets found.</p>
    <?php endif; ?>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
