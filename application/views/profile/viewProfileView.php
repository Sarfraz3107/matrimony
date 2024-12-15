<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- /views/profile/viewProfileView.php -->
<div class="container">
    <h1>View Profile</h1>
    
    <div class="profile-info">
        <!-- Display Profile Photo -->
        <div class="profile-photo">
            <img src="<?php echo base_url($user->photo_path); ?>" alt="Profile Photo" width="150" height="150" class="profile-img">
        </div>

        <!-- Display Profile Information -->
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo $user->name; ?></p>
            <p><strong>Email:</strong> <?php echo $user->email; ?></p>
            <p><strong>Age:</strong> <?php echo $user->age; ?></p>
            <p><strong>Marital Status:</strong> <?php echo $user->marital_status; ?></p>
            <p><strong>Income:</strong> <?php echo $user->income; ?></p>
            <p><strong>Education:</strong> <?php echo $user->education; ?></p>
            <p><strong>Gender:</strong> <?php echo $user->gender; ?></p>
            <p><strong>Property Owner:</strong> <?php echo $user->property_owner; ?></p>
        </div>

        <!-- Edit Profile Button -->
        <div class="edit-profile-btn">
            <a href="<?php echo base_url('profile/edit'); ?>" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>

<!-- Styling -->
<style>
    .container {
        width: 80%;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .profile-photo img {
        border-radius: 50%;
    }

    .profile-details {
        margin-left: 20px;
    }

    .profile-details p {
        font-size: 16px;
        margin: 8px 0;
    }

    .edit-profile-btn {
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>

</body>
</html>