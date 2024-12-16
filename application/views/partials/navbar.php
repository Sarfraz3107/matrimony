<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #2c3e50; /* Darker shade for navbar */
            padding: 15px 30px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .navbar .logo img {
            height: 50px; /* Adjusted logo size */
        }

        .navbar .nav-links {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center align links */
            align-items: center;
        }

        .navbar .nav-links li {
            margin-left: 30px; /* More spacing between items */
        }

        .navbar .nav-links a {
            color: #ecf0f1; /* Lighter text for better contrast */
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 30px; /* Rounded edges */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Hover effect for links */
        .navbar .nav-links a:hover {
            background-color: #3498db; /* Blue color on hover */
            transform: translateY(-3px); /* Slight lift effect */
            color: #fff;
        }

        /* User info (logged-in users) */
        .navbar .user-info {
            color: #ecf0f1;
            margin-right: 30px;
            font-size: 16px;
            font-weight: 600;
        }

        /* Logout button */
        .navbar .logout-btn {
            background-color: #e74c3c;
            padding: 10px 20px;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .navbar .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            .navbar {
                padding: 10px 20px;
            }

            .navbar .logo img {
                height: 40px; /* Adjusted logo size for mobile */
            }

            .navbar .nav-links {
                display: block;
                text-align: center;
                width: 100%;
            }

            .navbar .nav-links li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar Section -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo"></a>
            </div>

            <ul class="nav-links">
                <!-- Dashboard link (active on Dashboard page) -->
                
                
                <!-- Conditional display for logged-in users -->
                <?php if ($this->session->userdata('logged_in')): ?>
                    <!-- Show user name and logout button -->
                    <li class="user-info">
                        <span>Welcome, <?php echo $this->session->userdata('name'); ?>!</span> <!-- Display user name -->
                    </li>
                    <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                
                <!-- Profile link -->
                <li><a href="<?php echo base_url('profile'); ?>">Profile</a></li>
                <li><a href="<?php echo base_url('interests/sent'); ?>">send Interest </a></li>
                <!-- Interests link -->
                <li><a href="<?php echo base_url('interest'); ?>">Recieve Interests</a></li>
                    <li><a href="<?php echo base_url('logout'); ?>" class="logout-btn">Logout</a></li>
                <?php else: ?>
                    <!-- Login and Signup links for non-logged-in users -->
                    <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                    <li><a href="<?php echo base_url('signup'); ?>">Signup</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Other content goes here -->

</body>
</html>
