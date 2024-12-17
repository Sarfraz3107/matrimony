<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add the path to your Bootstrap CSS file -->
    <style>
        body {
            background-color: #f9fbfd; /* Softer gray for background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            width: 80%; /* Take up 80% of the width */
            max-width: 800px; /* Restrict max width */
            border: none;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        .card-header {
            background-color: #5fa8d3; /* Lighter blue */
            color: white;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
            text-align: center;
            font-size: 1.7rem;
            padding: 15px 20px;
        }
        .card-body {
            padding: 30px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #495057;
            width: 30%; /* Align label on the left */
            margin-right: 20px;
            text-align: right; /* Right-align label text */
        }
        .form-control {
            width: 70%; /* Inputs take up remaining space */
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            font-size: 1rem;
            background-color: #fff;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #5fa8d3;
            box-shadow: 0 0 6px rgba(95, 168, 211, 0.5);
            outline: none;
        }
        .btn-primary {
            background-color: #5fa8d3; /* Lighter blue */
            border-color: #5fa8d3;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            display: block; /* Make it a block to center it */
            margin: 20px auto 0; /* Center button horizontally with margin */
            width: 50%; /* Adjust button size */
            text-align: center;
        }
        .btn-primary:hover {
            background-color: #4a90c0; /* Slightly darker blue on hover */
            border-color: #4a90c0;
            transform: scale(1.02); /* Slight zoom effect */
        }
        .btn-primary:active {
            transform: scale(0.98); /* Slight press effect */
        }
        .card-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 15px;
            border-radius: 0 0 12px 12px;
        }
        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Edit Profile
        </div>
        <div class="card-body">
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
                <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" class="form-control" value="<?php echo $user->age; ?>" required>
            </div>
            <div class="form-group">
                <label for="subscription_id">Subscription Type</label>
                <select name="subscription_id" id="subscription_id" class="form-control">
                    <option value="1" <?php echo $user->subscription_id == 1 ? 'selected' : ''; ?>>Free</option>
                    <option value="2" <?php echo $user->subscription_id == 2 ? 'selected' : ''; ?>>Premium</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <?php echo form_close(); ?>
        </div>
        <div class="card-footer">
            <small class="text-muted">Ensure your information is accurate before submitting.</small>
        </div>
    </div>
    <script src="path/to/bootstrap.bundle.js"></script> <!-- Add the path to your Bootstrap JS file -->
</body>
</html>
