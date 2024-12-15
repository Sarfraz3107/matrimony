<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/styles.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fc;
    padding: 20px;
}

.container {
    width: 80%;
    margin: auto;
}

/* Navbar Styling */
nav {
    background-color: #2c3e50;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 30px;
}

nav ul {
    list-style-type: none;
    display: flex;
    justify-content: space-around;
}

nav ul li {
    padding: 10px;
}

nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
}

nav ul li a:hover {
    color: #3498db;
}

/* Incoming Interest Section */
.incoming-interests {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.incoming-interests h2 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 20px;
}

#incoming-interest-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 80px;
}

/* Interest Card Styling */
.interest-card {
    background-color: #f0f3f7;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: transform 0.3s ease-in-out;
    height: 100%;
}

.interest-card:hover {
    transform: translateY(-10px);
}

.interest-card h3 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 20px;
}

.interest-card p {
    color: #7f8c8d;
    margin-bottom: 20px;
    font-size: 16px;
}

/* Button Styling */
.respond-buttons {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: 10px;
}

.respond-buttons button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: #fff;
    width: 30%;
}

.respond-buttons .accept {
    background-color: #2ecc71;
}

.respond-buttons .reject {
    background-color: #e74c3c;
}

.respond-buttons .block {
    background-color: #f39c12;
}

.respond-buttons button:hover {
    opacity: 0.8;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .incoming-interests h2 {
        font-size: 20px;
    }

    .respond-buttons {
        flex-direction: column;
        align-items: center;
    }

    .respond-buttons button {
        margin-bottom: 10px;
        width: 80%;
    }
} 
</style>

</head>
<body>
    <div class="container">
        <!-- Navbar Section -->
        <!-- <nav>
            <ul>
                <li><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?= base_url('profile'); ?>">Profile</a></li>
                <li><a href="<?= base_url('interests'); ?>" id="interests-btn">Interests</a></li>
                <li><a href="<?= base_url('logout'); ?>">Logout</a></li>
            </ul>
        </nav> -->

        <!-- Section to View Incoming Interest Requests -->
        <div class="incoming-interests">
            <h2>Incoming Interest Requests</h2>
            <div id="incoming-interest-list">
                <!-- Interests will be displayed here -->
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Load incoming interest requests
            function loadIncomingInterests() {
                $.ajax({
                    url: '<?= base_url('interests/load_incoming_interests'); ?>',
                    type: 'GET',
                    success: function(response) {
                        $('#incoming-interest-list').html(response);
                    },
                    error: function() {
                        $('#incoming-interest-list').html('<p>No incoming interest requests.</p>');
                    }
                });
            }

            // Load incoming interests when clicking on the 'Interests' button in navbar
            $('#interests-btn').click(function(e) {
                e.preventDefault();
                loadIncomingInterests();
            });

            // Respond to an incoming interest (Accept, Reject, Block)
            $(document).on('click', '.respond-interest', function() {
                var interestId = $(this).data('interest-id');
                var response = $(this).data('response');

                $.ajax({
                    url: '<?= base_url('interests/respond/'); ?>' + interestId + '/' + response,
                    type: 'POST',
                    success: function(response) {
                        loadIncomingInterests(); // Reload incoming interest list after response
                    },
                    error: function() {
                        alert('Error responding to interest request.');
                    }
                });
            });

            // Initial load of incoming interests when the page loads
            loadIncomingInterests();
        });
    </script>
</body>
</html>
