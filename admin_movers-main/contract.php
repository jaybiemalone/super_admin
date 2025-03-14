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
                <span>Contract</span>
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
        <div class="contract-content">
            <div class="contract-container">
                <div class="contract-catigories">
                    <div class="process">
                        <button>Open Contracts</button>
                        <button>Archived Contracts</button>
                        <button>All Contracts</button>
                    </div>
                    <div class="add-contract">
                        <button>Add Contract</button>
                    </div>
                </div>
                <div class="contract-search">
                    <div class="box"><h1>Search Contracts</h1></div>
                    <div class="box"><input type="search" placeholder="Search by Name, ID, Party, or Vendor"></div>
                    <div class="box">
                        <div class="select">
                            <label for="">Vendor:</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Hospital</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Department</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Type</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Termination Date</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Contract Value</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="">Category</label>
                            <select name="" id="">
                                <option value=""></option>
                                <option value="">All</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <span></span>
                        <div class="checkbox">
                            <input type="checkbox">
                            <label for="">Active</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox">
                            <label for="">Draft</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox">
                            <label for="">Pending</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox">
                            <label for="">Expired</label>
                        </div>
                    </div>
                </div>
                <div class="contract-progress">
                    <table style="width: 100%; color: black; border-bottom: solid 1px grey; padding: 10px;">
                        <tbody>
                            <tr>
                                <td><label for="">ID</label><select name="" id="" style="outline: none; border:  none; color: grey;">
                                    <option value=""></option>
                                    <option value="">All</option>
                                    <option value=""></option>
                                </select></td>
                                <td>Name</td>
                                <td>Contract Type</td>
                                <td>Vendor</td>
                                <td>Contract Owner</td>
                                <td>Start Date</td>
                                <td>Termination Date</td>
                                <td>Status</td>
                                <td><input type="checkbox"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>