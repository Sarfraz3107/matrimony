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

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
        }

        h3 {
            margin-top: 30px;
            color: #555;
            font-size: 22px;
        }

        .profile {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile p {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .profile .btn {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .profile .btn:hover {
            background-color: #45a049;
            cursor: pointer;
        }

        .btn-disabled {
            background-color: #ccc; /* Light gray background to indicate disabled state */
            color: #666; /* Dark gray text color */
            border: 1px solid #999; /* Gray border */
            cursor: not-allowed; /* Correct cursor to indicate it is not clickable */
            opacity: 0.6; /* Slightly transparent to reinforce disabled look */
            padding: 10px 15px; /* Consistent padding */
            font-size: 14px; /* Text size */
            border-radius: 5px; /* Rounded corners */
            text-align: center; /* Center-align text */
            pointer-events: none; /* Ensures it is not clickable */
            transition: opacity 0.3s ease; /* Smooth transition for hover effect */
        }

        /* Modal (Popup) Styles */
        #popup {
    display: none;
    position: fixed;
    top: 50%; /* Vertically center */
    left: 50%; /* Horizontally center */
    width: 40%;
    height: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    transform: translate(-50%, -50%); /* Adjust for exact centering */
}


        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .popup-content h3 {
            margin: 0;
            color: #4CAF50;
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
                cursor: pointer;
            }
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
                    showPopup();
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
}

// Global function to close the popup
function closePopup() {
    $('#popup').fadeOut();
}
</script>
</body>
</html>
