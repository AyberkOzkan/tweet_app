<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2><?php echo $data['user']->username; ?>'s Profile</h2>
            <img src="https://via.placeholder.com/150" alt="Profile Picture" class="rounded-circle mt-2">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email:</strong> <?php echo $data['user']->email; ?></p>
                    <p><strong>Birthday:</strong> <?php echo $data['user']->birthday; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Followers:</strong> <?php echo $data['followersCount']; ?></p>
                    <p><strong>Following:</strong> <?php echo $data['followingCount']; ?></p>
                </div>
            </div>

            <?php if ($_SESSION['user_id'] != $data['user']->id) : ?>
                <?php if ($data['isFollowing']) : ?>
                    <form action="<?php echo URLROOT; ?>/profile/unfollow/<?php echo $data['user']->id; ?>" method="post">
                        <button type="submit" class="btn btn-secondary">Unfollow</button>
                    </form>
                <?php elseif ($data['isRequested']) : ?>
                    <button class="btn btn-info" disabled>Requested</button>
                <?php else : ?>
                    <form action="<?php echo URLROOT; ?>/profile/follow/<?php echo $data['user']->id; ?>" method="post">
                        <button type="submit" class="btn btn-primary">Follow</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <h3 class="mt-4">Followers</h3>
            <?php if (!empty($data['followers'])) : ?>
                <ul class="list-group mb-4">
                    <?php foreach ($data['followers'] as $follower) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="https://via.placeholder.com/30" alt="Profile Picture" class="rounded-circle mr-2">
                                <a href="<?php echo URLROOT; ?>/profile/userProfile/<?php echo $follower->id; ?>"><?php echo $follower->username; ?></a>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No followers found</p>
            <?php endif; ?>

            <h3>Following</h3>
            <?php if (!empty($data['following'])) : ?>
                <ul class="list-group mb-4">
                    <?php foreach ($data['following'] as $following) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="https://via.placeholder.com/30" alt="Profile Picture" class="rounded-circle mr-2">
                                <a href="<?php echo URLROOT; ?>/profile/userProfile/<?php echo $following->id; ?>"><?php echo $following->username; ?></a>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Not following anyone</p>
            <?php endif; ?>

            <h3>Tweets</h3>
            <?php if (!empty($data['tweets'])) : ?>
                <ul class="list-group">
                    <?php foreach ($data['tweets'] as $tweet) : ?>
                        <li class="list-group-item">
                            <?php echo $tweet->tweet; ?>
                            <br>
                            <small class="text-muted">Written on <?php echo $tweet->created_at; ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No tweets found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
