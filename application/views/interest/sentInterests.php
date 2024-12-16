<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sent Interests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            /* margin: 0 auto; */
            margin-top: 40px;
            padding: 40px;
        }
        .interest-card {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .interest-card h3 {
            margin: 0;
            font-size: 18px;
        }
        .interest-card p {
            font-size: 16px;
            margin: 10px 0;
        }
        .interest-card .status {
            font-weight: bold;
            color: #ff4500; /* Red color for status */
        }
        .interest-card .status.accepted {
            color: green;
        }
        .interest-card .status.rejected {
            color: red;
        }
        .interest-card .status.blocked {
            color: grey;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Sent Interests</h1>

        <?php if (!empty($interests)): ?>
            <?php foreach ($interests as $interest): ?>
                <div class="interest-card">
                    <h3>Interest sent to: <?php echo htmlspecialchars($interest->name); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($interest->email); ?></p>
                    <p>Age: <?php echo htmlspecialchars($interest->age); ?></p>
                    <p>Education: <?php echo htmlspecialchars($interest->education); ?></p>
                    <p>Gender: <?php echo $interest->gender == 1 ? 'Male' : 'Female'; ?></p>

                    <p class="status <?php echo htmlspecialchars($interest->status); ?>">
                        Status: 
                        <?php 
                            if ($interest->status == 'pending') {
                                echo 'Pending';
                            } elseif ($interest->status == 'accepted') {
                                echo 'Accepted';
                            } elseif ($interest->status == 'rejected') {
                                echo 'Rejected';
                            } elseif ($interest->status == 'blocked') {
                                echo 'Blocked';
                            }
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No interests sent yet.</p>
        <?php endif; ?>

    </div>

</body>
</html>
