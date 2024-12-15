<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- /views/partials/sidebar.php -->
<aside class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
        <li><a href="<?php echo base_url('profile/edit'); ?>">Edit Profile</a></li>
        <li><a href="<?php echo base_url('interest'); ?>">My Interests</a></li>
        <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
    </ul>
</aside>

</body>
</html>