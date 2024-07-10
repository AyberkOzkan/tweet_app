<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <h2>Notifications</h2>
    <?php if (!empty($data['notifications'])): ?>
        <ul class="list-group">
            <?php foreach ($data['notifications'] as $notification) : ?>
                <li class="list-group-item">
                    <a href="<?php echo URLROOT; ?>/notifications/viewNotification/<?php echo $notification->id; ?>">
                        <?php echo $notification->message; ?>
                    </a>
                    - <small><?php echo $notification->created_at; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No notifications found.</p>
    <?php endif; ?>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
