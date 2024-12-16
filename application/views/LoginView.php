<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 2rem auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group .error {
            color: red;
            font-size: 0.9rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login Form</h1>

        <!-- Show error message if there's any flashdata -->
        <div id="error-message" style="color: red; text-align: center; margin-bottom: 15px;"></div>

        <!-- Login form -->
        <div id="login-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <div class="error" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <div class="error" id="password-error"></div>
            </div>

            <button type="button" id="login-btn">Login</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login-btn').click(function() {
                // Clear previous error messages
                $('#error-message').text('');
                $('#email-error').text('');
                $('#password-error').text('');

                // Get the values from the form
                var email = $('#email').val();
                var password = $('#password').val();

                // Perform client-side validation
                if (email === "" || password === "") {
                    $('#error-message').text("Please fill out both fields.");
                    return;
                }

                // Send AJAX request to backend
                $.ajax({
                    url: '<?php echo site_url('login/submit'); ?>',
                    type: 'POST',
                    data: { email: email, password: password },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '<?php echo site_url('dashboard'); ?>'; // Redirect to dashboard
                        } else {
                            $('#error-message').text(response.error);
                        }
                    },
                    error: function() {
                        $('#error-message').text("An error occurred. Please try again.");
                    }
                });
            });
        });
    </script>
</body>
</html>
