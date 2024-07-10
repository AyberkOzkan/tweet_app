<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <h2>Profile of <?php echo $data['user']->username; ?></h2>
    <p>Email: <?php echo $data['user']->email; ?></p>
    <p>Birthday: <?php echo $data['user']->birthday; ?></p>
    <p>Followers: <?php echo $data['followersCount']; ?></p>
    <p>Following: <?php echo $data['followingCount']; ?></p>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $data['user']->id) : ?>
        <?php if ($data['isFollowing']) : ?>
            <a href="<?php echo URLROOT; ?>/profile/unfollow/<?php echo $data['user']->id; ?>" class="btn btn-danger">Unfollow</a>
        <?php else : ?>
            <a href="<?php echo URLROOT; ?>/profile/follow/<?php echo $data['user']->id; ?>" class="btn btn-primary">Follow</a>
        <?php endif; ?>
    <?php endif; ?>

    <h2 class="mt-5">Tweets</h2>
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
        <p>This user has not posted any tweets yet.</p>
    <?php endif; ?>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
