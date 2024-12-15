<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Management</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Section to Send Interest -->
        <div class="send-interest">
            <h2>Send Interest</h2>
            <form id="send-interest-form">
                <label for="target_user_id">Enter Target User ID:</label>
                <input type="text" name="target_user_id" id="target_user_id" placeholder="Enter User ID" required />
                <button type="submit">Send Interest</button>
            </form>
            <div id="send-interest-message"></div>
        </div>

        <!-- Section to View Incoming Interest Requests -->
        <div class="incoming-interests">
            <h2>Incoming Interest Requests</h2>
            <div id="incoming-interest-list">
                <!-- Interest requests will be displayed here -->
            </div>
        </div>
    </div>

    <script>
        // Send interest via AJAX
        $(document).ready(function() {
            $('#send-interest-form').submit(function(e) {
                e.preventDefault();

                var targetUserId = $('#target_user_id').val();

                $.ajax({
                    url: '<?= base_url('interests/send'); ?>',
                    type: 'POST',
                    data: { target_user_id: targetUserId },
                    success: function(response) {
                        $('#send-interest-message').text('Interest sent successfully!');
                        $('#target_user_id').val(''); // Clear input after sending
                    },
                    error: function() {
                        $('#send-interest-message').text('Failed to send interest.');
                    }
                });
            });

            // Load incoming interest requests
            function loadIncomingInterests() {
                $.ajax({
                    url: '<?= base_url('interests/load_incoming_interests'); ?>',
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#incoming-interest-list').html(response);
                    },
                    error: function() {
                        $('#incoming-interest-list').html('<p>No incoming interest requests.</p>');
                    }
                });
            }

            // Load incoming interests on page load
            loadIncomingInterests();

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
        });
    </script>
</body>
</html>
