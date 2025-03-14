<?php
include 'db.php';

// Initialize variables
$total_rows = 0;
$total_task = 0;

// Execute queries for counts
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_rows FROM issue_management");
$stmt2 = $conn->prepare("SELECT COUNT(*) AS total_task FROM inbox_communication");

if ($stmt1 && $stmt2) {
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $total_rows = $row['total_rows'];
    }
    $stmt1->close();

    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $total_task = $row['total_task'];
    }
    $stmt2->close();
}

// Fetch all rows for display
$sql = "SELECT * FROM inbox_communication";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movers.com</title>
    <link rel="icon" href="/Asset/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/index.css">
    <script type="text/javascript" src="app.js" defer></script>
    <script type="text/javascript" src="click.js" defer></script>
    <script type="text/javascript" src="sidebar.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="sidebar2" style="display: none;" id="sideshow">
        <ul>
            <li>
                <div class="Logo">
                    <img src="./Asset/logo.png" alt="" width="180" height="62">
                    <button onclick=toggleSidebar() id="toggle-btn">
                    </button>
                </div>
            </li>
            <li class="active">
                <a href="dashbord.php">
                    <i class='bx bxs-dashboard'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="user.php">
                    <i class='bx bx-user'></i>
                    <span>User</span>
                </a>
            </li>
            <li>
                <a href="facility.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span>Facility</span>
                </a>
            </li>
            <li>
                <a href="request-meeting.php">
                    <i class='bx bxs-comment-dots' undefined ></i>
                    <span>Request</span>
                </a>
            </li>
            <li>
                <button onclick="toggleSubMenu(this)" class="dropdown-btn">
                    <i class='bx bxs-data' ></i>
                    <span>Documents</span>
                    <i class='bx bx-chevron-right'></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="contract.php">Contract</a></li>
                        <li><a href="template-files.php">Template</a></li>
                        <li><a href="marketing-files.php">Marketing</a></li>
                        <li><a href="project-files.php">Projects</a></li>
                    </div>
                </ul>
            </li>
            <li>
                <a href="legal.php">
                    <i class='bx bx-file'></i>
                    <span>Legal Compliance</span>
                </a>
            </li>
            <li>
                <button onclick="toggleSubMenu(this)" class="dropdown-btn">
                    <i class='bx bx-sitemap'></i>
                    <span>Communication Management</span>
                    <i class='bx bx-chevron-right'></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="issue-maintenance.php">Issue & Concern</a></li>
                        <li><a href="inbox-management.php">Inbox</a></li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
    <div class="sidebar">
        <ul>
            <li>
                <div class="Logo">
                    <img src="./Asset/logo.png" alt="" width="180" height="62">
                    <button onclick=toggleSidebar() id="toggle-btn">
                    </button>
                </div>
            </li>
            <li class="active">
                <a href="dashbord.php">
                    <i class='bx bxs-dashboard'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="user.php">
                    <i class='bx bx-user'></i>
                    <span>User</span>
                </a>
            </li>
            <li>
                <a href="facility.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span>Facility</span>
                </a>
            </li>
            <li>
                <a href="request-meeting.php">
                    <i class='bx bxs-comment-dots' undefined ></i>
                    <span>Request</span>
                </a>
            </li>
            <li>
                <button onclick="toggleSubMenu(this)" class="dropdown-btn">
                    <i class='bx bxs-data' ></i>
                    <span>Documents</span>
                    <i class='bx bx-chevron-right'></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="contract.php">Contract</a></li>
                        <li><a href="template-files.php">Template</a></li>
                        <li><a href="marketing-files.php">Marketing</a></li>
                        <li><a href="project-files.php">Projects</a></li>
                    </div>
                </ul>
            </li>
            <li>
                <a href="legal.php">
                    <i class='bx bx-file'></i>
                    <span>Legal Compliance</span>
                </a>
            </li>
            <li>
                <button onclick="toggleSubMenu(this)" class="dropdown-btn">
                    <i class='bx bx-sitemap'></i>
                    <span>Communication Management</span>
                    <i class='bx bx-chevron-right'></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="issue-maintenance.php">Issue & Concern</a></li>
                        <li><a href="inbox-management.php">Inbox</a></li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <nav>
            <div class="logo-nav-container">
                <img src="./Asset/logo.png" alt="" width="120" height="40">
            </div>
            <div class="leftbar">
                <button>
                    <i class='bx bx-home-alt-2'></i>
                </button>
                <a href="index.php">
                    <span>Home</span>
                </a>
                <i class='bx bx-chevron-right'></i>
                <span>Maintenance</span>
                <i class='bx bx-chevron-right'></i>
                <span>Inbox</span>
            </div>
            <div class="log-out">
                <button id="toggleBtn"><i class='bx bx-cog' ></i></button>
                <div id="logout" class="hidden">
                    <p style="padding-top: 5px;"><a href="../index.php">Log out</a></p>
                </div>
            </div>
            <div class="display-menu">
                <button style="display: none;" id="sidebtn"><i class='bx bx-menu bx-rotate-180' ></i></button>
            </div>
        </nav>
        <div class="inbox-content">
            <div class="message-inbox">
                <div class="top">
                    <h1>Message <?php
                    if ($total_task > 0) {
                        echo "<span>+" . htmlspecialchars($total_task) . "</span>";
                    } else {
                        echo "<span>0</span>";
                    }
                    ?></h1>
                </div>
                <div class="body">
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="close-button" onclick="showModal(' . htmlspecialchars(json_encode($row)) . ')">';
                            echo "<ul>";
                            echo "<li><h2>" . htmlspecialchars($row['name_issue']) . "</h2></li>";
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li>" . htmlspecialchars($row['email_id']) . "</li>";
                            echo "<li>" . htmlspecialchars($row['date_id']) . "</li>";
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li>" . htmlspecialchars($row['action_issue']) . "</li>";
                            echo "<li>" . htmlspecialchars($row['send_at']) . "</li>";
                            echo "</ul>";

                            echo "</div>";
                        }
                    } else {
                        echo "<p>No issues found.</p>";
                    }
                ?>
                </div>
            </div>
            <div class="message-display" >
                <div class="ibox-modal-content" id="inbox-modal" style="display: none;">
                    <span class="close-button" onclick="closeModal()">&times;</span>
                    <h2 id="inbox-modal-title">Modal Title</h2>
                    <p id="inbox-modal-date">Modal Date</p>
                    <p id="inbox-modal-action">Modal Action</p>
                    <p id="inbox-modal-name">Name</p>
                    <p id="inbox-modal-email">Email</p>
                    <p id="inbox-modal-send_at">Send At</p>
                    <p id="inbox-modal-description">Description</p>
                    <div class="send-feedback">
                        <textarea name="" id="" placeholder="Write a Message"></textarea>
                        <button>Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Function to show the modal with dynamic data
    function showModal(data) {
        if (data.name_issue) document.getElementById('inbox-modal-title').textContent = data.name_issue;
        if (data.date_id) document.getElementById('inbox-modal-date').textContent = "Date: " + data.date_id;
        if (data.action_issue) document.getElementById('inbox-modal-action').textContent = "Action: " + data.action_issue;
        if (data.name) document.getElementById('inbox-modal-name').textContent = "Name: " + data.name;
        if (data.email_id) document.getElementById('inbox-modal-email').textContent = "Email: " + data.email_id;
        if (data.send_at) document.getElementById('inbox-modal-send_at').textContent = data.send_at;
        if (data.description_issue) document.getElementById('inbox-modal-description').textContent = "Description: " + data.description_issue;

        document.getElementById('inbox-modal').style.display = "flex"; // Show the modal
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('inbox-modal').style.display = "none"; // Hide the modal
    }
    </script>

</body>
</html>

<?php
$conn->close();
?>