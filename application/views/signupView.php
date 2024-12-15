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
        <?php echo form_open('signup/submit', ['id' => 'signupForm', 'method' => 'POST']); ?>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>">
            <div class="error"><?php echo form_error('name'); ?></div>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>">
            <div class="error"><?php echo form_error('email'); ?></div>
        </div>

        <div class="form-group">
            <label for="marital_status">Marital Status:</label>
            <select name="marital_status" id="marital_status">
                <option value="" disabled selected>Select an option</option>
                <option value="1" <?php echo set_select('marital_status', '1'); ?>>Never Married</option>
                <option value="2" <?php echo set_select('marital_status', '2'); ?>>Married</option>
                <option value="3" <?php echo set_select('marital_status', '3'); ?>>Divorced</option>
                <option value="4" <?php echo set_select('marital_status', '4'); ?>>Separated</option>
            </select>
            <div class="error"><?php echo form_error('marital_status'); ?></div>
        </div>

        <div class="form-group">
            <label for="on_behalf">On Behalf:</label>
            <select name="on_behalf" id="on_behalf">
                <option value="" disabled selected>Select an option</option>
                <option value="Self" <?php echo set_select('on_behalf', 'Self'); ?>>Self</option>
                <option value="Daughter" <?php echo set_select('on_behalf', 'Daughter'); ?>>Daughter</option>
                <option value="Son" <?php echo set_select('on_behalf', 'Son'); ?>>Son</option>
                <option value="Brother" <?php echo set_select('on_behalf', 'Brother'); ?>>Brother</option>
                <option value="Sister" <?php echo set_select('on_behalf', 'Sister'); ?>>Sister</option>
            </select>
            <div class="error"><?php echo form_error('on_behalf'); ?></div>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="<?php echo set_value('age'); ?>">
            <div class="error"><?php echo form_error('age'); ?></div>
        </div>

        <div class="form-group">
            <label for="income">Income:</label>
            <input type="text" name="income" id="income" value="<?php echo set_value('income'); ?>">
            <div class="error"><?php echo form_error('income'); ?></div>
        </div>

        <div class="form-group">
            <label for="education">Education:</label>
            <input type="text" name="education" id="education" value="<?php echo set_value('education'); ?>">
            <div class="error"><?php echo form_error('education'); ?></div>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="" disabled selected>Select an option</option>
                <option value="1" <?php echo set_select('gender', '1'); ?>>Male</option>
                <option value="2" <?php echo set_select('gender', '2'); ?>>Female</option>
            </select>
            <div class="error"><?php echo form_error('gender'); ?></div>
        </div>

        <div class="form-group">
            <label for="property_owner">Property Owner:</label>
            <select name="property_owner" id="property_owner">
                <option value="" disabled selected>Select an option</option>
                <option value="1" <?php echo set_select('property_owner', '1'); ?>>Home</option>
                <option value="2" <?php echo set_select('property_owner', '2'); ?>>Land</option>
            </select>
            <div class="error"><?php echo form_error('property_owner'); ?></div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <div class="error"><?php echo form_error('password'); ?></div>
        </div>

        <button type="submit">Submit</button>

        <?php echo form_close(); ?>
    </div>


    <!-- <script>
        $(document).ready(function () {
            $('#signupForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: "<?php echo base_url('signup/submit'); ?>", // Correct backend URL
                    type: "POST",
                    data: $(this).serialize(), // Serialize form data
                    dataType: "json", // Expect a JSON response
                    success: function (response) {
                        if (response.status === 'success') {
                            // Success message and redirect
                            alert('Signup successful! Redirecting to dashboard...');
                            window.location.href = "<?php echo base_url('dashboard'); ?>";
                        } else if (response.status === 'error') {
                            // Show validation errors
                            $.each(response.errors, function (key, value) {
                                $('#' + key + '_error').html(value);
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText); // Log server response for debugging
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script> -->

</body>
</html>
