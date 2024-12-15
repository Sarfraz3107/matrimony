<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- /views/profile/editProfileView.php -->
<div class="container">
    <h1>Edit Profile</h1>
    <?php echo form_open('profile/update'); ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?php echo $user->name; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user->email; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="photo">Profile Photo</label>
        <input type="file" name="profile_photo" id="profile_photo" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
    <?php echo form_close(); ?>
</div>


</body>
</html>