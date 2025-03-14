<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movers.com</title>
    <link rel="icon" href="/Asset/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/index.css">
    <script type="text/javascript" src="app.js" defer></script>
    <script type="text/javascript" src="storingdata.js" defer></script>
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
                <span>Trip</span>
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
        <div class="Trips-Container">
            <div class="trip-box">
                <ul>
                    <li>Booked Trips</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'  ></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <ul>
                    <li>Total Earning</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <ul>
                    <li>Available Cabs</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <ul>
                    <li>Cancel trips</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <ul>
                    <li>Tourist</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <ul>
                    <li>Feedback</li>
                    <li><span><i class='bx bxs-up-arrow' style='color:#ffffff' ></i> 0%</span></li>
                </ul>
                <ul>
                    <li><h2>0</h2></li>
                    <li><a href="#">Details <i class='bx bxs-right-arrow' style='color:#1207f7'></i></a></li>
                </ul>
            </div>
            <div class="trip-box">
                <div class="first-box">
                    <p>Trips Statistics</p>
                </div>
                <div class="second-box">
                </div>
            </div>
            <div class="trip-box">
                <div class="top">
                    <h1>Upcoming Trips</h1>
                </div>
                <div class="bottom"></div>
            </div>
            <div class="trip-box">
                <div class="top">
                    <h1>Peak hours Trip</h1>
                </div>
                <div class="bottom"></div>
            </div>
        </div>
    </div>
</body>
</html>