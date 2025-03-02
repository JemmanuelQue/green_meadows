<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Meadows</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="shortcut icon" href="images/green-meadows-logo.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #2E8B57;
            color: white;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            text-align: center;
            transition: width 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .logo img {
            width: 50px;
            height: 50px;
        }

        .sidebar.collapsed h2 {
            display: none;
        }

        .sidebar.collapsed .nav-links a span {
            display: none;
        }

        .sidebar.collapsed .nav-links li a i {
            margin-right: 0;
            text-align: center;
            width: 100%;
            position: relative;
        }

        .sidebar ul {
            list-style-type: none;
            padding-left: 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            transition: width 0.3s, height 0.3s;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        .nav-links li {
            width: 100%;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .nav-links li a:hover {
            background: #256845;
        }

        .nav-links li a.active {
            background: #256845;
            cursor: none;
        }

        .nav-links li a i {
            margin-right: 15px;
            font-size: 18px;
        }

        .dropdown {
            display: none;
            background: #3CB371;
            padding-left: 20px;
        }

        .dropdown a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .dropdown a:hover {
            background: #2E8B57;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .sidebar.collapsed .dropdown {
            padding-left: 0;
        }

        .sidebar.collapsed .dropdown a {
            padding: 5px 5px 5px 5px; /* Adjusted padding */
            text-align: center;
            font-size: 12px; /* Smaller font size */
        }

        /* Top Navigation */
        .top-nav {
            position: fixed;
            top: 0;
            right: 0;
            width: calc(100% - 220px);
            height: 60px;
            background-color: #256845;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            color: white;
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .hamburger-menu {
            font-size: 24px;
            cursor: pointer;
            color: white !important; /* Ensures white color */
            filter: none !important; /* Removes any unexpected filter */
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Main Content */
        .main-content {
            margin-left: 220px;
            margin-top: 60px;
            padding: 20px;
            width: calc(100% - 20px);
            background: #ffffff;
            min-height: 100vh;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .sidebar.collapsed ~ .top-nav {
            width: calc(100% - 70px);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        /* Tooltip */
        .tooltip {
            position: absolute;
            left: 70px;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            display: none;
            white-space: nowrap;
        }

        .tooltip::after {
            content: '';
            position: absolute;
            top: 50%;
            left: -5px;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent #333 transparent transparent;
        }

        .sidebar.collapsed .nav-links li:hover .tooltip {
            display: block;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 30%;
            text-align: center;
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 15px;
        }

        .modal-content input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content button {
            background-color: #2E8B57;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .modal-content button:hover {
            background-color: #256845;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Preview Profile Picture */
        .profile-preview {
            display: block;
            margin: 10px auto;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="../images/green-meadows-logo.jpg" alt="Logo">
        </div>
        <h2>GREEN MEADOWS</h2>
        <ul class="nav-links">
            <li>
                <a href="#" class="active"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span>
                    <div class="tooltip">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-toggle"><i class="fas fa-users"></i> <span>Guards</span>
                    <div class="tooltip">Guards</div>
                </a>
                <ul class="dropdown">
                    <li><a href="view_guards.php">View Guards</a></li>
                    <li><a href="add_guards.php">Disciplinary Guards</a></li>
                    <li><a href="remove_guards.php">Inactive Guards</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle"><i class="fas fa-user-tie"></i> <span>Employees</span>
                    <div class="tooltip">Employees</div>
                </a>
                <ul class="dropdown">
                    <li><a href="add_employees.php">View Employees</a></li>
                    <li><a href="remove_employees.php">Disciplinary Employees</a></li>
                    <li><a href="view_employees.php">Inactive Employees</a></li>
                </ul>
            </li>
            <li>
                <a href="attendance.php"><i class="fa fa-clock" aria-hidden="true"></i> <span>Attendance</span>
                    <div class="tooltip">Attendance</div>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-toggle"><i class="fa fa-money-bill-wave" aria-hidden="true"></i> <span>Payroll</span>
                    <div class="tooltip">Payroll</div>
                </a>
                <ul class="dropdown">
                    <li><a href="generate_payslip.php">Generate Payslip</a></li>
                    <li><a href="disciplinary_employees.php">Disciplinary Employees</a></li>
                </ul>
            </li>
            <li>
                <a href="../index.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Top Navigation Bar -->
    <div class="top-nav">
        <div class="hamburger-menu">☰</div>
        <img src="images/profile.jpg" alt="Profile Picture" class="profile-pic">
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Welcome Super Admin!</h1>
        <p>This is your dashboard.</p>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Profile</h2>
            <form id="profileForm">
                <input type="text" id="userName" placeholder="Enter your name" required>
                <input type="file" id="profilePicInput" accept="image/*">
                <img src="images/profile.jpg" alt="Profile Picture" id="profilePreview" class="profile-preview">
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.hamburger-menu').on('click', function() {
                $('.sidebar').toggleClass('collapsed');
                $('.main-content').toggleClass('collapsed');
            });

            $('.dropdown-toggle').on('click', function() {
                $(this).next('.dropdown').slideToggle();
            });

            $('.nav-links li a').hover(function() {
                if ($('.sidebar').hasClass('collapsed')) {
                    $(this).find('.tooltip').show();
                }
            }, function() {
                $(this).find('.tooltip').hide();
            });
        });

        $(document).ready(function () {
            // Open modal when clicking profile picture
            $(".profile-pic").on("click", function () {
                $("#profileModal").fadeIn();
            });

            // Close modal when clicking close button
            $(".close").on("click", function () {
                $("#profileModal").fadeOut();
            });

            // Close modal when clicking outside modal content
            $(window).on("click", function (event) {
                if (event.target.id === "profileModal") {
                    $("#profileModal").fadeOut();
                }
            });

            // Preview image before upload
            $("#profilePicInput").on("change", function (event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $("#profilePreview").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle form submission
            $("#profileForm").on("submit", function (e) {
                e.preventDefault();
                
                let userName = $("#userName").val();
                let profilePic = $("#profilePicInput")[0].files[0];

                // Create FormData to send image and name to server
                let formData = new FormData();
                formData.append("userName", userName);
                if (profilePic) {
                    formData.append("profilePic", profilePic);
                }

                // AJAX request to update profile
                $.ajax({
                    url: "update_profile.php", // Backend PHP script
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alert("Profile updated successfully!");
                        $("#profileModal").fadeOut();

                        // Update profile picture on the sidebar
                        if (profilePic) {
                            let reader = new FileReader();
                            reader.onload = function (e) {
                                $(".profile-pic").attr("src", e.target.result);
                            };
                            reader.readAsDataURL(profilePic);
                        }

                        // Update user name if changed
                        if (userName) {
                            $(".profile-name").text(userName);
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>