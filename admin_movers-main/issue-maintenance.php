<?php
include 'db.php';

// Initialize variables
$total_rows = 0;
$total_task = 0;

// Execute queries for counts
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_rows FROM issue_management");
$stmt2 = $conn->prepare("SELECT COUNT(*) AS total_task FROM request_management");

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
$sql = "SELECT * FROM issue_management";
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
                <a href="dashbord.php">
                    <span>Home</span>
                </a>
                <i class='bx bx-chevron-right'></i>
                <span>Maintenance</span>
                <i class='bx bx-chevron-right'></i>
                <span>Issue</span>
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
        <div class="issue-content">
    <div class="issue-dashboard">
        <div class="box">
            <div class="card">
                <ul>
                    <li>
                    <?php
                    if ($total_rows > 0) {
                        echo "<h1>" . htmlspecialchars($total_rows) . "</h1>";
                    } else {
                        echo "<h1>0</h1>";
                    }
                    ?>
                    </li>
                    <li><h3>Report Issue</h3></li>
                    <li><img src="./Asset/building_up_down.gif" alt="" width="60"></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><h1>0</h1></li>
                    <li><h3>Issue Solve</h3></li>
                    <li><img src="./Asset/building_up_down.gif" alt="" width="60"></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li>
                        <?php
                        if ($total_rows > 0) {
                            echo "<h1>" . htmlspecialchars($total_task) . "</h1>";
                        } else {
                            echo "<h1>0</h1>";
                        }
                        ?>
                    </li>
                    <li><h3>Task Active</h3></li>
                    <img src="./Asset/building_up_down.gif" alt="" width="60">
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="card">
                <ul>
                    <li><img src="./Asset/assembly-line.gif" alt="" width="45"></li>
                    <li><h1>Assembly</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><img src="./Asset/electric-car.gif" alt="" width="45"></li>
                    <li><h1>Electricity</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><img src="./Asset/maintenance.gif" alt="" width="45"></li>
                    <li><h1>Maintenance</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><img src="./Asset/mop.gif" alt="" width="45"></li>
                    <li><h1>Cleaning</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><img src="./Asset/request.gif" alt="" width="45"></li>
                    <li><h1>Request</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
            <div class="card">
                <ul>
                    <li><img src="./Asset/more.gif" alt="" width="45"></li>
                    <li><h1>Others</h1></li>
                    <li><h1 style="font-size: 18px;">0</h1></li>
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="issue-container">
                <div class="top">
                    <div class="left">
                        <div class="issue"><button id="Issue">Issue</button></div>
                        <div class="solve"><button id="Solve">Solve</button></div>
                        <div class="actived"><button id="Actived">Active</button></div>
                    </div>
                    <div class="right">
                        <div class="button">
                            <button>Add-issue</button>
                        </div>
                    </div>
                </div>
                <div id="bottom" class="bottom">
                    <div class="header">
                        <ul>
                            <li><h1>Task Name</h1></li>
                        </ul>
                        <ul>
                            <li><h1>Category</h1></li>
                            <li><h1>Reporter</h1></li>
                            <li><h1>Action</h1></li>
                        </ul>
                    </div>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class=\"problem\">";
                            
                            echo "<ul>";
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '" alt="Issue Image" width="80">';
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li>" . htmlspecialchars($row['task_name']) . "</li>";
                            echo "<li>" . htmlspecialchars($row['short_discrip']) . "</li>";
                            echo "<li><i class='bx bxs-been-here'></i> " . htmlspecialchars($row['location']) . "</li>";
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li>" . htmlspecialchars($row['category']) . "</li>";
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li>" . htmlspecialchars($row['reporter']) . "</li>";
                            echo "</ul>";

                            echo "<ul>";
                            echo "<li><button><i class='bx bx-dots-vertical-rounded' ></i></button></li>";
                            echo "</ul>";

                            echo "</div>";
                        }
                    } else {
                        echo "<p>No issues found.</p>";
                    }
                    ?>
                </div>
                <div class="bottom2" id="bottom2" style="display: none;"></div>
                <div class="bottom3" id="bottom3" style="display: none;"></div>
            </div>
        </div>
    </div>
    <div class="right-sidebar">
        <div class="activity">
            <div class="top">
                <h1>Activity</h1>
            </div>
            <div class="bottom"></div>
        </div>
        <div class="all-report">
            <div class="top">
                <h1>ALL report</h1>
            </div>
            <div class="bottom"></div>
            <div class="footer">
                <div class="box">
                <?php
                if ($total_rows > 0) {
                    echo "<span>" . htmlspecialchars($total_rows) . "</span>";
                } else {
                    echo "<p>0</p>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    <script src="./javascript/show-button.js"></script>
</body>
</html>

<?php
$conn->close();
?>