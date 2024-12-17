<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <script>
        // Function to show a popup notification
        function showPopupMessage(message, type) {
            const popup = document.createElement('div');
            popup.textContent = message;
            popup.className = `popup-message ${type}`;
            document.body.appendChild(popup);

            // Automatically hide after 3 seconds
            setTimeout(() => {
                popup.style.opacity = '0';
                setTimeout(() => popup.remove(), 300); // Remove element after fade-out
            }, 3000);
        }
    </script>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin-top: 30px;
            overflow: hidden;
            padding: 60px;
            margin: 40px;
            transition: transform 0.3s ease;
        }

        /* .container:hover {
            transform: scale(1.02);
        } */

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .profile-header h1 {
            font-size: 28px;
            color: #444;
            font-weight: bold;
        }

        .edit-btn {
            background-color: #007bff;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .edit-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .popup-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background-color: #28a745; /* Success green */
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .popup-message.error {
            background-color: #dc3545; /* Error red */
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-photo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-photo img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 4px solid #ddd;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-photo img:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .profile-details {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-details p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }

        .profile-details p strong {
            color: #333;
            font-weight: 600;
        }

        .upload-error {
            color: #dc3545;
            font-size: 16px;
            margin-bottom: 15px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
                padding: 30px;
            }

            .profile-header h1 {
                font-size: 26px;
            }

            .edit-btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .profile-photo img {
                width: 150px;
                height: 150px;
            }

            .profile-details p {
                font-size: 16px;
            }
        }

        @media screen and (max-width: 480px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .edit-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>View Profile</h1>
                </div>

        <?php if ($this->session->flashdata('error')): ?>
            <script>
                // Show error popup
                showPopupMessage("<?= $this->session->flashdata('error'); ?>", "error");
            </script>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <script>
                // Show success popup
                showPopupMessage("<?= $this->session->flashdata('success'); ?>", "success");
            </script>
        <?php endif; ?>

        <div class="profile-info">
            <div class="profile-photo">
                <img src="<?= !empty($user->photo_path) ? base_url($user->photo_path) : 'https://www.w3schools.com/howto/img_avatar.png'; ?>" 
                     alt="User Avatar" 
                     onclick="startFileInput()">
            </div>

            <!-- Profile content goes here -->
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo isset($user->name) ? $user->name : 'N/A'; ?></p>
                <p><strong>Email:</strong> <?php echo isset($user->email) ? $user->email : 'N/A'; ?></p>
                <p><strong>Age:</strong> <?php echo isset($user->age) ? $user->age : 'N/A'; ?></p>
                <p><strong>Marital Status:</strong> 
    <?php 
        switch ($user->marital_status_id) {
            case 1:
                echo 'Never Married ';
                break;
            case 2:
                echo 'Married';
                break;
            case 3:
                echo 'Divorced';
                break;
            case 4:
                echo 'Separated';
                break;
            default:
                echo 'Unknown'; // In case there's an invalid value
                break;
        }
    ?>
</p>

                <p><strong>Income:</strong> <?php echo isset($user->income) ? $user->income : 'N/A'; ?></p>
                <p><strong>Education:</strong> <?php echo isset($user->education) ? $user->education : 'N/A'; ?></p>
                <p><strong>Gender:</strong> <?php echo isset($user->gender) && $user->gender == '1' ? 'Male' : 'Female'; ?></p>
                <p><strong>Property Owner:</strong> <?php echo isset($user->property_owner) ? $user->property_owner : 'N/A'; ?></p>
                <p><strong>Subscription Type:</strong> <?php echo isset($user->subscription_id) && $user->subscription_id == '1' ? 'Free' : 'Premium'; ?></p>
            </div>
            <div class="btn">
            <a href="<?php echo base_url('profile/edit'); ?>" class="edit-btn">Edit Profile</a>

            </div>
        </div>

        <!-- Profile Photo Upload -->
        <?= form_open('photo/upload_file/'.$user->id, ['id' => 'upload-form', 'enctype' => 'multipart/form-data']); ?>
        <input type="file" id="input-file" name="file" style="display: none;" onchange="submitForm()">
        <?= form_close(); ?>

        <script>
            // Function to open the file input dialog when the user clicks on the image
            function startFileInput() {
                document.getElementById('input-file').click();
            }

            // Function to submit the form after the file has been selected
            function submitForm() {
                document.getElementById('upload-form').submit();
            }
        </script>
    </div>
</body>
</html>
