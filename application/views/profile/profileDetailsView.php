<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <style>
        /* Reset some default browser styles */
        body, h1, h2, p, ul, figure {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f7f9fb; /* Light background */
            color: #333;
            font-size: 16px;
            line-height: 1.5;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-card {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            padding: 40px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        /* Hover effect to lift the profile card */
        /* .profile-card:hover {
            transform: translateY(-10px);
        } */

        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4CAF50;
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .profile-card img:hover {
            transform: scale(1.1);
        }

        h2 {
            font-size: 32px;
            color: #333;
            font-weight: 600;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        p strong {
            font-weight: 700;
            color: #333;
        }

        .btn-back-wrapper {
            margin-top: 30px;
        }

        .btn-back {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 18px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #45a049;
        }

        /* Styling for the "Show Premium Details" button */
        #showPremiumDetailsBtn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        #showPremiumDetailsBtn:hover {
            background-color: #555;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
            padding-top: 60px;
            transition: opacity 0.3s ease-in-out;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 30px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #333;
        }

        /* Hidden Premium Details */
        .premium-details {
            display: none;
            margin-top: 20px;
        }

        .premium-details p {
            font-size: 18px;
            color: #555;
        }

        /* Add hover effect on details */
        .premium-details p strong {
            color: #4CAF50;
        }

    </style>
</head>
<body>

<div class="profile-card">
    <!-- Check if user image exists, if not show a default image -->
    <img src="<?php echo $profile->image ? base_url('uploads/images/' . $profile->image) :'https://www.w3schools.com/howto/img_avatar.png'; ?>" alt="User Image">
    
    <h2>Profile Details</h2>
    
    <!-- Display profile data or "Not Available" if missing -->
    <p><strong>Name:</strong> <?php echo $profile->name ? $profile->name : 'Not Available'; ?></p>
    <p><strong>Age:</strong> <?php echo $profile->age ? $profile->age : 'Not Available'; ?></p>
    <p><strong>Gender:</strong> <?php echo $profile->gender_id  == 1 ? 'Male' : 'Femal'; ?></p>
    <p><strong>Income:</strong> <?php echo $profile->income ? $profile->income : 'Not Available'; ?></p>
    <p><strong>Email:</strong> <?php echo $profile->email ? $profile->email : 'Not Available'; ?></p>

    <p><strong>Marital Status:</strong> 
    <?php 
        if ($profile->marital_status_id == 1) {
            echo 'Never Married';
        } elseif ($profile->marital_status_id == 2) {
            echo 'Married';
        } elseif ($profile->marital_status_id == 3) {
            echo 'Divorced';
        } elseif ($profile->marital_status_id == 4) {
            echo 'Rejected';
        } else {
            echo 'Not Available';
        }
    ?>
    </p>

    <!-- Button for both free and premium users to reveal premium details -->
    <button id="showPremiumDetailsBtn" onclick="revealPremiumDetails()">Show Premium Details</button>

    <!-- Hidden Premium Details for both Free and Premium users -->
    <div id="premiumDetails" class="premium-details">
    <p><strong>On Behalf:</strong> 
    <?php 
        switch ($profile->on_behalf_id) {
            case 1:
                echo 'Self';
                break;
            case 2:
                echo 'Daughter';
                break;
            case 3:
                echo 'Son';
                break;
            case 4:
                echo 'Brother';
                break;
            case 5:
                echo 'Sister';
                break;
            default:
                echo 'Not Available'; // In case there is no valid value
                break;
        }
    ?>
</p>

        <p><strong>Education:</strong> <?php echo $profile->education ? $profile->education : 'Not Available'; ?></p>
        <p><strong>Property Owner:</strong> <?php echo $profile->property_owner ? ($profile->property_owner == 1 ? 'Home' : 'Land') : 'Not Available'; ?></p>
    </div>

    <!-- Button to go back to the dashboard -->
    <div class="btn-back-wrapper">
        <a href="<?php echo base_url('dashboard'); ?>" class="btn-back">Back to Dashboard</a>
    </div>
</div>

<!-- Modal for Free Users -->
<div id="premiumModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Access Restricted</h2>
    <p>These details are only available for Premium users. Please upgrade to Premium to view this information.</p>
  </div>
</div>

<script>
    // Function to reveal premium details
    function revealPremiumDetails() {
        <?php if ($this->session->userdata('subscription_id') == '2'): ?>
            // If the user is premium, show the details
            document.getElementById("premiumDetails").style.display = "block";
        <?php else: ?>
            // If the user is free, show the modal and simulate an AJAX request
            document.getElementById("premiumModal").style.display = "block";

            // Simulate AJAX request (this would usually be a real request to the server)
            setTimeout(function() {
                // Simulate the server response for free users
                closeModal();
            }, 2000); // Close modal after 3 seconds
        <?php endif; ?>
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("premiumModal").style.display = "none";
    }

    // Close modal if user clicks outside of the modal content
    window.onclick = function(event) {
        var modal = document.getElementById("premiumModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
