<?php include_once APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Your Profile</h2>
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

            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>

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

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo URLROOT; ?>/profile/update" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $data['user']->email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" name="birthday" class="form-control" value="<?php echo $data['user']->birthday; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once APPROOT . '/app/views/inc/footer.php'; ?>
