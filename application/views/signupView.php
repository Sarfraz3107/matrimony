<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Signup Form</title>
    <style>
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
        .form-group input,
        .form-group select {
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
        <h1>Signup Form</h1>
        <form id="signupForm" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">
                <div class="error" id="nameError"></div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
                <div class="error" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="marital_status">Marital Status:</label>
                <select name="marital_status" id="marital_status">
                    <option value="" disabled selected>Select an option</option>
                    <option value="1">Never Married</option>
                    <option value="2">Married</option>
                    <option value="3">Divorced</option>
                    <option value="4">Separated</option>
                </select>
                <div class="error" id="maritalStatusError"></div>
            </div>

            <div class="form-group">
                <label for="on_behalf">On Behalf:</label>
                <select name="on_behalf" id="on_behalf">
                    <option value="" disabled selected>Select an option</option>
                    <option value="Self">Self</option>
                    <option value="Daughter">Daughter</option>
                    <option value="Son">Son</option>
                    <option value="Brother">Brother</option>
                    <option value="Sister">Sister</option>
                </select>
                <div class="error" id="onBehalfError"></div>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" id="age">
                <div class="error" id="ageError"></div>
            </div>

            <div class="form-group">
                <label for="income">Income:</label>
                <input type="text" name="income" id="income">
                <div class="error" id="incomeError"></div>
            </div>

            <div class="form-group">
                <label for="education">Education:</label>
                <input type="text" name="education" id="education">
                <div class="error" id="educationError"></div>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="" disabled selected>Select an option</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
                <div class="error" id="genderError"></div>
            </div>

            <div class="form-group">
                <label for="property_owner">Property Owner:</label>
                <select name="property_owner" id="property_owner">
                    <option value="" disabled selected>Select an option</option>
                    <option value="1">Home</option>
                    <option value="2">Land</option>
                </select>
                <div class="error" id="propertyOwnerError"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <div class="error" id="passwordError"></div>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#signupForm').on('submit', function(e) {
    e.preventDefault(); // This should prevent the page from reloading

    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
        url: '<?php echo base_url('signup/submit'); ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            console.log("Response -->", response); // For debugging

            if (response.status === 'error') {
                // Clear previous error messages
                $('.error').text('');
                // Loop through each error and display it in the respective input field
                $.each(response.errors, function(key, value) {
                    $('#' + key + 'Error').text(value);
                });
            } else if (response.status === 'success') {
                if (response.redirect) {
                    console.log("Redirecting to: " + response.redirect); // For debugging
                    // Redirect after success
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 500); // Optional delay for better UX
                } else {
                    alert(response.message); // Display success message
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + error);
            console.error("Response: " + xhr);
        }
    });
});

});


</script>
</body>
</html>