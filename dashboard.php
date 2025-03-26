<?php
@include 'config.php';
@include 'count.php';

session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}

// Accident Reports Data
$accidentData = $conn->query("SELECT COUNT(*) as count FROM accident_reports")->fetch_assoc()['count'];

// Compliance Data
$complianceData = $conn->query("SELECT LOWER(status) as status, COUNT(*) as count FROM compliance_data GROUP BY LOWER(status)");
$compliance = ["compliance" => 0, "non-compliance" => 0, "pending" => 0];

while ($row = $complianceData->fetch_assoc()) {
  $status = strtolower($row['status']);
  if ($status === 'compliant') {
    $compliance['compliance'] = $row['count'];
  } elseif ($status === 'non-compliant') {
    $compliance['non-compliance'] = $row['count'];
  } elseif ($status === 'pending') {
    $compliance['pending'] = $row['count'];
  }
}

// Complaints Data (Ensure aggregation)
$complaintsData = $conn->query("SELECT DATE(date_submitted) as date_submitted, COUNT(*) as count FROM complaints GROUP BY DATE(date_submitted)");
$dates = [];
$counts = [];

while ($row = $complaintsData->fetch_assoc()) {
  $dates[] = $row['date_submitted'];
  $counts[] = (int) $row['count']; // Convert count to integer for proper graph plotting
}

// Maintenance Data
$maintenanceData = $conn->query("SELECT COUNT(*) as count, status FROM maintenance GROUP BY status");
$maintenance = ["pending" => 0, "on-going" => 0, "resolve" => 0];

while ($row = $maintenanceData->fetch_assoc()) {
  $maintenance[strtolower($row['status'])] = $row['count'];
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
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
  nav ul{
    padding-left: 0;
  }
</style>

<body>

  <nav id="sidebar">
    <ul>
      <li>
        <span class="logo"><img src="./Asset/logo.png" alt="" width="150"></span>
        <button onclick=toggleSidebar() id="toggle-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z" />
          </svg>
        </button>
      </li>
      <li>
        <a href="dashboard.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
          </svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h207q16 0 30.5 6t25.5 17l57 57h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Zm400-160v40q0 17 11.5 28.5T600-320q17 0 28.5-11.5T640-360v-40h40q17 0 28.5-11.5T720-440q0-17-11.5-28.5T680-480h-40v-40q0-17-11.5-28.5T600-560q-17 0-28.5 11.5T560-520v40h-40q-17 0-28.5 11.5T480-440q0 17 11.5 28.5T520-400h40Z" />
          </svg>
          <span>Document <br> Management</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li class="active"><a href="#" onclick="showPasswordPrompt()">Folder</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z" />
          </svg>
          <span>Management</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="legal.php">Legal <br> Overview</a></li>
            <li><a href="compliance.php">vehicle <br> compliance</a></li>
            <li><a href="safety.php">Accident <br> Management</a></li>
            <li><a href="inbox.php">Inbox</a></li>
            <li><a href="complaint.php">Complaint <br> Management</a></li>
          </div>
        </ul>
      </li>
      <li>
        <a href="user.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>User</span>
        </a>
      </li>
      <li>
        <a href="announcement.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
          </svg>
          <span>Announcement</span>
        </a>
      </li>
      <li>
        <a href="maintenance.php">
        <i class="fa-solid fa-screwdriver-wrench"></i><span>Maintenance</span>
        </a>
      </li>
    </ul>
  </nav>
  <main>
    <header>
      <div></div>
      <div>
        <button id="notifyBtn"
          class="flex items-center gap-2 px-4 py-2 text-black bg-[#F5F5F5] hover:bg-[#E0E0E0] rounded-lg shadow-lg transition-transform transform hover:scale-105">
          <i class="fa-solid fa-bell"></i><span class="count"><?php echo $total; ?></span>
        </button>
        <button onclick="openLogout()" class="px-4 py-2 text-white bg-red-500 rounded">Logout</button>
      </div>
    </header>
    <div class="header-dashboard">
      <i class="fa-solid fa-house-chimney"></i>
      <h1>Dashboard</h1>
    </div>

    <div class="dashboard-content">
      <div class="dashboard-barchar">
        <div class="graph">
          <h4>Accident Reports</h4>
          <canvas id="circleGraph"></canvas>
        </div>

        <div class="graph">
          <h4>Compliance Data</h4>
          <canvas id="barGraphCompliance"></canvas>
        </div>

        <div class="graph">
          <h4>Complaints Over Time</h4>
          <canvas id="lineGraph"></canvas>
        </div>

        <div class="graph">
          <h4>Maintenance Status</h4>
          <canvas id="barGraphMaintenance"></canvas>
        </div>
      </div>
    </div>

    <div id="passwordModall"
      style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
      <label for="passwordInput">Enter password:</label>
      <input type="password" id="passwordInput" placeholder="Enter Super Admin Pass:" />
      <button onclick="checkPassword()">Submit</button>
      <a href="#" onclick="closeModal(event)">Close</a>
    </div>

    <!-- Logout modal -->
    <div id="modal-logout" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-xl font-semibold">Confirm Logout</h2>
        <p class="my-4">Are you sure you want to logout?</p>
        <div class="flex justify-end gap-3">
          <button onclick="logoutClose()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
          <button onclick="confirmLogout()" class="px-4 py-2 text-white bg-red-500 rounded">Logout</button>
        </div>
      </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal-notify" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
        <h2 class="text-xl font-bold mb-4">Maintenance Updates</h2>
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500">&times;</button>
        <div id="updateContent" class="space-y-4 max-h-80 overflow-y-auto">
          <!-- Updates will be injected here -->
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js">

  </script>
  <script>
    // Circle Graph (Accident Reports)
    const circleCtx = document.getElementById('circleGraph').getContext('2d');
    new Chart(circleCtx, {
      type: 'doughnut',
      data: {
        labels: ['Accident Reports'],
        datasets: [{
          data: [<?php echo $accidentData; ?>],
          backgroundColor: ['#FF6384'],
        }],
      },
    });

    // Bar Graph (Compliance Data)
    const barCtx = document.getElementById('barGraphCompliance').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Compliance', 'Non-Compliance', 'Pending'], // Add "Pending"
        datasets: [{
          label: 'Compliance Status',
          data: [
            <?php echo $compliance['compliance']; ?>,
            <?php echo $compliance['non-compliance']; ?>,
            <?php echo $compliance['pending']; ?> // Add Pending Data
          ],
          backgroundColor: ['#36A2EB', '#FF6384', '#FFCD56'], // Add color for "Pending"
        }],
      },
    });


    document.addEventListener("DOMContentLoaded", function () {
      const lineCtx = document.getElementById('lineGraph').getContext('2d');
      new Chart(lineCtx, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($dates); ?>,
          datasets: [{
            label: 'Complaints',
            data: <?php echo json_encode($counts); ?>,
            borderColor: '#FF9F40',
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              title: {
                display: true,
                text: 'Date Submitted'
              }
            },
            y: {
              title: {
                display: true,
                text: 'Number of Complaints'
              },
              beginAtZero: true
            }
          }
        }
      });
    });

    // Bar Graph (Maintenance Status tite)
    const maintenanceCtx = document.getElementById('barGraphMaintenance').getContext('2d');
    new Chart(maintenanceCtx, {
      type: 'bar',
      data: {
        labels: ['Pending', 'On-Going', 'Resolve'],
        datasets: [{
          label: 'Maintenance Status',
          data: [<?php echo $maintenance['pending']; ?>, <?php echo $maintenance['on-going']; ?>, <?php echo $maintenance['resolve']; ?>],
          backgroundColor: ['#FFCD56', '#4BC0C0', '#9966FF'],
        }],
      },
    });
  </script>
</body>

</html>