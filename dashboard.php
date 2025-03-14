<?php 
@include 'config.php';

session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch data
$sql = "SELECT * FROM active_users";
$result = $conn->query($sql);

$emailAccounts = 67550;
$emailAccountPercentage = 80;
$requestAccounts = 67550;
$requestPercentage = 34;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['type'] === 'Email Account') {
            $emailAccounts = $row['count'];
            $emailAccountPercentage = $row['percentage'];
        } elseif ($row['type'] === 'Requests') {
            $requestAccounts = $row['count'];
            $requestPercentage = $row['percentage'];
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movers.com</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/admin_movers-main/Asset/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="app.js" defer></script>
  <style>
    .dashboard-container .box:nth-child(7){
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    }
    .box:nth-child(7) {
        border-radius: 10px;
        padding: 20px;
        width: 350px;
    }
    .chart-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }
    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: #ddd;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 5px;
    }
    .bar-fill {
        height: 100%;
        border-radius: 4px;
    }
    .bar-email {
        background-color: purple;
        width: <?php echo $emailAccountPercentage; ?>%;
    }
    .bar-request {
        background-color: green;
        width: <?php echo $requestPercentage; ?>%;
    }
    .label {
        font-size: 14px;
        color: #333;
        font-weight: bold;
    }
    .percent-value {
        float: right;
    }
  </style>
</head>
<body>
  <nav id="sidebar">
    <ul>
      <li>
        <span class="logo">Movers</span>
        <button onclick=toggleSidebar() id="toggle-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z"/></svg>
        </button>
      </li>
      <li class="active">
        <a href="dashboard.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h207q16 0 30.5 6t25.5 17l57 57h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Zm400-160v40q0 17 11.5 28.5T600-320q17 0 28.5-11.5T640-360v-40h40q17 0 28.5-11.5T720-440q0-17-11.5-28.5T680-480h-40v-40q0-17-11.5-28.5T600-560q-17 0-28.5 11.5T560-520v40h-40q-17 0-28.5 11.5T480-440q0 17 11.5 28.5T520-400h40Z"/></svg>
          <span>Document <br> Management</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="file.php">Folder</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z"/></svg>
          <span>Management</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="legal.php">Legal <br> Overview</a></li>
            <li><a href="compliance.php">vehicle <br> compliance</a></li>
            <li><a href="safety.php">Accident <br> Management</a></li>
            <li><a href="inbox.php">Inbox</a></li>
          </div>
        </ul>
      </li>
      <li>
        <a href="user.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>User</span>
        </a>
      </li>
      <li>
        <a href="announcement.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Announcement</span>
        </a>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z"/></svg>
          <span>Financial</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z"/></svg>
          <span>Logistic</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z"/></svg>
          <span>HR</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
            <li><a href="#">#</a></li>
          </div>
        </ul>
      </li>
    </ul>
  </nav>
  <main>
    <div class="dashboard-container">
      <div class="box">
        <ul>
          <li>Total Completions</li>
          <li><img src="./icons/pie.gif" alt="" width="50">Total Balance <span>Aug 18 2018</span></li>
          <li>$13,750</li>
          <li>
            <p><span>This Week</span>234 <span>36%</span></p>
          </li>
          <li></li>
        </ul>
      </div>
      <div class="box">
        <ul>
          <li>Completion rate</li>
          <li><img src="./icons/pie.gif" alt="" width="50">Credit Available <span>Sep 12 2018</span></li>
          <li>$8,345</li>
          <li>
            <p><span>This Week</span>$3487 <span>44%</span></p>
          </li>
          <li></li>
        </ul>
      </div>
      <div class="box">
        <ul>
          <li><p>Total Expenses</p></li>
          <li><p>$65, 650 <span>+876</span></p></li>
          <li><p>view statement</p></li>
          <li><img src="./icons/growth.gif" alt="" width="50"></li>
        </ul>
      </div>
      <div class="box">
        <ul>
          <li><p>Total Invoice</p></li>
          <li><p>$65, 650 <span>+876</span></p></li>
          <li><p>view statement</p></li>
          <li><img src="./icons/growth.gif" alt="" width="50"></li>
        </ul>
      </div>
      <div class="box">
        <ul>
          <li><p>Amount Due</p></li>
          <li><p>$65, 650 <span>+876</span></p></li>
          <li><p>view statement</p></li>
          <li><img src="./icons/growth.gif" alt="" width="50"></li>
        </ul>
      </div>
      <div class="box">
        <ul>
          <li><p>Unpaid Invoice</p></li>
          <li><p>$65, 650 <span>+876</span></p></li>
          <li><p>view statement</p></li>
          <li><img src="./icons/growth.gif" alt="" width="50"></li>
        </ul>
      </div>
      <div class="box">
      <h2>Active Users</h2>
        <div class="chart-container">
            <div>
                <div class="label">
                    <?php echo number_format($emailAccounts); ?> Email account &nbsp;
                    <span class="percent-value"><?php echo $emailAccountPercentage; ?>%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill bar-email"></div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div>
                <div class="label">
                    <?php echo number_format($requestAccounts); ?> Requests &nbsp;
                    <span class="percent-value"><?php echo $requestPercentage; ?>%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill bar-request"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="box">
          <ul>
            <li><p>Amount Due</p></li>
            <li><p>$5998</p><span>Milestone Completed</span></li>
            <li><p>Payment for next week</p></li>
          </ul>
          <ul>
          </ul>
      </div>
      <div class="box">
        <ul>
          <li>Realtime Statistics</li>
          <li></li>
        </ul>
        <ul>
          <li>Updated at 08:32pm, Aug 2018</li>
          <li>Overview Status</li>
          <ul>
            <li>
              <p>Marketing <span>2018</span></p>
              <p>34% <span>Mar</span></p>
            </li>
            <li>
              <p>Marketing <span>2018</span></p>
              <p>34% <span>Mar</span></p>
            </li>
            <li>
              <p>Marketing <span>2018</span></p>
              <p>34% <span>Mar</span></p>
            </li>
          </ul>
        </ul>
      </div>
      <div class="box"></div>
    </div>
  </main>
</body>
</html>