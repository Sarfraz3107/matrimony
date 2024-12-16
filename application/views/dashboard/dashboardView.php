<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Dashboard</title>
    <style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
}

/* Container for the Dashboard */
.container {
    width: 80%;
    margin: 30px auto;
    background-color: #fff;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

/* Title Styling */
h2 {
    text-align: center;
    color: #333;
    font-size: 28px;
    font-weight: 600;
}

/* Sub-Title Styling */
h3 {
    margin-top: 30px;
    color: #555;
    font-size: 22px;
    font-weight: 500;
}

/* Profile Card */
.profile {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

/* Hover Effect for Profile Card */
.profile:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

/* Profile Text Styling */
.profile p {
    margin: 0;
    font-size: 16px;
    color: #333;
}

/* Profile Button Styling */
.profile .btn {
    display: inline-block;
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    text-decoration: none; /* Remove underline */
    border-radius: 50px; /* Rounded corners */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease; /* Smooth transition for hover and focus */
}

/* Button Hover Effect */
.profile .btn:hover {
    background-color: #45a049; /* Slightly darker green */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
}

/* Button Focus Effect (for accessibility) */
.profile .btn:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.4); /* Green outline */
}

/* Button Active Effect (when clicked) */
.profile .btn:active {
    transform: translateY(2px); /* Pressed down effect */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Shadow contracts */
}

/* Disabled State for Buttons */
.profile .btn-disabled {
    background-color: #ccc; /* Light gray background */
    color: #666; /* Dark gray text */
    border: 1px solid #999; /* Gray border */
    cursor: not-allowed;
    opacity: 0.6;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    border-radius: 50px;
    box-shadow: none;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

/* Modal (Popup) Styles */
#popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    width: 40%;
    height: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
}

.popup-content h3 {
    margin: 0;
    color: #4CAF50;
    font-size: 24px;
    font-weight: 600;
}

.popup-content button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.popup-content button:hover {
    background-color: #45a049;
}

/* Mobile Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }

    .profile {
        flex-direction: column;
        align-items: flex-start;
    }

    .profile .btn {
        margin-top: 10px;
        width: 100%;
        text-align: center;
    }

    .popup-content {
        width: 80%;
        padding: 15px;
    }
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}


    </style>
</head>
<body>

<div class="container">
    <h2>Dashboard</h2>
    <h3>Profiles</h3>

    <?php if ($profiles): ?>
        <?php foreach ($profiles as $profile): ?>
            <div class="profile" id="profile-<?php echo $profile->id; ?>">
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo $profile->name; ?></p>
        <p><strong>Age:</strong> <?php echo $profile->age; ?></p>
        <p><strong>Gender:</strong> <?php echo $profile->gender == 1 ? 'Male' : 'Female'; ?></p>
        <!-- Link to the profile details page -->
        <a href="<?php echo base_url('profile/details/' . $profile->id); ?>" class="btn">View Details</a>
    </div>
    <div class="profile-actions">
        <?php if ($profile->interest_sent): ?>
            <button class="btn btn-disabled" disabled>Already Interest Sent</button>
        <?php else: ?>
            <button class="btn send-interest-btn" data-profile-id="<?php echo $profile->id; ?>">Send Interest</button>
        <?php endif; ?>
    </div>
</div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Popup Modal -->
<div id="popup">
    <div class="popup-content">
        <h3>Interest Sent Successfully!</h3>
        <button onclick="closePopup()">Close</button>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#popup').hide();

    $(document).on('click', '.send-interest-btn', function() {
        var button = $(this);
        var profileId = button.data('profile-id');

        $.ajax({
            url: '<?php echo base_url("InterestController/send_interest"); ?>',
            type: 'POST',
            data: { receiver_id: profileId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 200) {
                    showPopup(); // Show the success popup
                    button.removeClass('send-interest-btn').addClass('btn-disabled')
                        .prop('disabled', true).text('Already Interest Sent');
                } else {
                    alert(response.message || 'Unexpected error occurred.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
                console.error('Error details:', xhr.responseText);
            }
        });
    });
});

// Global function to show the popup
function showPopup() {
    $('#popup').fadeIn();

    // Auto-close the popup after 3 seconds (3000 milliseconds)
    setTimeout(function() {
        $('#popup').fadeOut();
    }, 500);
}

// Global function to close the popup manually (if needed)
function closePopup() {
    $('#popup').fadeOut();
}

</script>
</body>
</html>
