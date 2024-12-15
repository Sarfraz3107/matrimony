<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/styles.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Navbar Section -->
        <nav>
            <ul>
                <li><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li><a href="<?= base_url('profile'); ?>">Profile</a></li>
                <li><a href="<?= base_url('interests'); ?>" id="interests-btn">Interests</a></li> <!-- New Interests button -->
                <li><a href="<?= base_url('logout'); ?>">Logout</a></li>
            </ul>
        </nav>

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
