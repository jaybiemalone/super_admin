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
                <span>Dashboard</span>
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
        <div class="dashboard-content">
            <div class="dashboard-header">
                <div class="title">
                    <h1>Welcome to Admin Dashboard!</h1>
                </div>
                <div class="date">
                    <button>7 days</button>
                    <button>30 days</button>
                    <button>90 days</button>
                </div>
            </div>
            <div class="dashboard-container">
                <div class="left">
                    <div class="box">
                        <div class="title">
                            <h2>HR</h2>
                        </div>
                        <div class="value">
                            <p>0</p>
                            <p><i class='bx bx-trending-up' style='color:#2dd80a'  ></i> 0%</p>
                        </div>
                        <div class="short-info">
                            <p>Register User</p>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title">
                            <h2>Finance Earning</h2>
                        </div>
                        <div class="value">
                            <p>₱ 0</p>
                            <p><i class='bx bx-trending-up' style='color:#2dd80a'  ></i> 0%</p>
                        </div>
                        <div class="short-info">
                            <p>Financial Report</p>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title">
                            <h2>Logistics</h2>
                        </div>
                        <div class="value">
                            <p>0</p>
                            <p><i class='bx bx-trending-up' style='color:#2dd80a'  ></i> 0%</p>
                        </div>
                        <div class="short-info">
                            <p>Short info</p>
                        </div>
                    </div>
                    <div class="box">
                        <div class="header"><a href="#"><h1>HR Performance</h1></a></div>
                        <div class="body">
                        <canvas id="finance"></canvas>
                        </div>
                    </div>
                    <div class="box">
                        <div class="header"><a href="#"><h1>Finance Performance</h1></a></div>
                        <div class="body">
                        <canvas id="hr"></canvas>
                        </div>
                    </div>
                    <div class="box">
                        <div class="header"><a href="#"><h1>Logistic Performance</h1></a></div>
                        <div class="body">
                        <canvas id="logistic"></canvas>
                        </div>
                    </div>
                    <div class="box">
                        <div class="header"><a href="triphistory.php"><h1>Core Performance</h1></a></div>
                        <div class="body">
                        <canvas id="booking"></canvas>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="box">
                        <div class="title">
                            <h2>Success Book</h2>
                        </div>
                        <div class="value">
                            <p>0</p>
                            <p><i class='bx bx-trending-up' style='color:#2dd80a'  ></i> 0%</p>
                        </div>
                        <div class="short-info">
                            <p>Short info</p>
                        </div>
                    </div>
                    <div class="box">
                        <div class="header">
                            <h1>Employee</h1>
                        </div>
                        <div class="body"></div>
                    </div>
                    <div class="box">
                        <div class="header">
                            <h1></h1>
                        </div>
                        <div class="body"></div>
                    </div>
                    <div class="box">
                        <div class="header">
                            <h1></h1>
                        </div>
                        <div class="body"></div>
                    </div>
                    <div class="box">
                        <div class="header">
                            <a href="triphistory.php"><h1>Traffic Location</h1></a>
                        </div>
                        <div class="body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="./javascript/chart1.js"></script>
</body>
</html>