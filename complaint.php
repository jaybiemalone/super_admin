<?php

@include 'config.php';
@include 'count.php';

session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}


// Fetch data from complaints table
$sql = "SELECT id, subject, name, email, vehicle_number, classification, status, date_submitted FROM complaints";
$result = $conn->query($sql);


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
  <link rel="icon" href="/asset/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />

  <style>
    #userTable_wrapper {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    /* Table Styling */
    .table-container {
      width: 100%;
      overflow-x: auto;
      /* Ensures responsiveness */
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 12px 15px;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
      text-transform: uppercase;
    }

    td {
      border-bottom: 1px solid #ddd;
    }

    /* Alternating row colors */
    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    /* Hover effect */
    tbody tr:hover {
      background-color: #f1f1f1;
      cursor: pointer;
    }

    /* Buttons inside the table */
    .complaint-container {
      height: 100vh;
      width: 100%;
      box-shadow: 0 0 0 1px rgba(128, 128, 128, 0.158);
      border-radius: 10px;
      box-sizing: border-box;
      padding: 20px;
    }

    .complaint-container button {
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 2px;
      transition: 0.3s;
    }

    /* View Details button */
    .complaint-container button:first-child {
      background-color: #28a745;
      color: white;
    }

    .complaint-container button:first-child:hover {
      background-color: #218838;
    }

    /* Contact button */
    .complaint-container button:last-child {
      background-color: #dc3545;
      color: white;
    }

    .complaint-container button:last-child:hover {
      background-color: #c82333;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: white;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 40%;
      text-align: center;
    }

    .close {
      color: red;
      float: right;
      font-size: 24px;
      cursor: pointer;
    }

    .btn {
      padding: 8px 15px;
      margin: 5px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
    }

    .btn-primary {
      background-color: blue;
      color: white;
    }

    .btn-warning {
      background-color: orange;
      color: white;
    }

    .btn-success {
      background-color: green;
      color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {

      th,
      td {
        padding: 10px;
        font-size: 14px;
      }

      .complaint-container button {
        padding: 6px 10px;
        font-size: 12px;
      }
    }

    /* General modal styles */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      z-index: 1000;
      /* Ensures modal appears above everything */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* Dark overlay */
      backdrop-filter: blur(5px);
      /* Adds a blur effect */
    }

    /* Modal content box */
    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 8px;
      width: 40%;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
      text-align: center;
      animation: fadeIn 0.3s ease-in-out;
    }

    /* Close button */
    .close {
      float: right;
      font-size: 24px;
      font-weight: bold;
      color: #555;
      cursor: pointer;
      transition: 0.3s;
    }

    .close:hover {
      color: #ff0000;
    }

    /* Input fields */
    input,
    select,
    textarea {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    /* Submit button */
    .form-btn,
    button {
      background-color: #28a745;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    .form-btn:hover,
    button:hover {
      background-color: #218838;
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
      .modal-content {
        width: 90%;
      }
    }
  </style>

</head>

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
            <li><a href="cfsurvey.php">Customer <br> Feedback</a></li>
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
      </li>
      <li>
        <a href="maintenance.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
          </svg>
          <span>Maintenance</span>
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
    <div class="complaint-container">
      <table id="complaintsTable" class="display">
        <thead>
          <tr>
            <th>Name</th>
            <th>Taxi #</th>
            <th>Subject</th>
            <th>classification</th>
            <th>Date submitted</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (!$conn) {
            echo "<tr><td colspan='7'>Database connection error.</td></tr>";
            exit;
          }

          $sql = "SELECT * FROM complaints";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $complaintJson = htmlspecialchars(json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
              $statusColor = $row['status'] === 'pending' ? "background-color: red; color: white;" : "background-color: green; color: white;";
              ?>
              <tr data-id="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['vehicle_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['subject'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['classification'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="status">
                  <?php echo htmlspecialchars($row['date_submitted'], ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                  <?php
                  $statusColor = match ($row['status']) {
                    'resolved' => 'background-color: green; color: white;',
                    'under investigation' => 'background-color: yellow; color: black;',
                    default => 'background-color: red; color: white;', // 'pending' or other statuses
                  };
                  ?>
                  <span
                    style="<?php echo $statusColor; ?> border-radius: 8px; padding: 8px 16px; font-size: 14px; display: inline-flex; justify-content: center; align-items: center; min-width: 100px;">
                    <?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?>
                  </span>
                </td>
                <td>
                  <button class="btn btn-primary" onclick='openDetailsModal(`<?php echo $complaintJson; ?>`)'>
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <a href="status.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <i class="fa-solid fa-repeat"></i>
                  </a>
                </td>
              </tr>
              <?php
            }
          } else {
            echo "<tr><td colspan='7'>No records found.</td></tr>";
          }
          ?>
        </tbody>

        <div id="detailsModal" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeDetailsModal()">&times;</span>
            <h2>Complaint Details</h2>
            <div>
              <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
              <p><strong>Name:</strong> <span id="modalName"></span></p>
            </div>
            <div>
              <p><strong>Email:</strong> <span id="modalEmail"></span></p>
              <p><strong>Bus Number:</strong> <span id="modalBusNumber"></span></p>
            </div>
            <div>
              <p><strong>Classification:</strong> <span id="modalClassification"></span></p>
              <p><strong>Complaint:</strong> <span id="modalComplaint"></span></p>
            </div>
            <div>
              <p><strong>Detailed Complaint:</strong> <span id="modalDetailedComplaint"></span></p>
              <p><strong>Incident Date & Time:</strong> <span id="modalIncidentDatetime"></span></p>
            </div>
            <div>
              <p><strong>Incident Location:</strong> <span id="modalIncidentLocation"></span></p>
              <p><strong>Date Submitted:</strong> <span id="modalDateSubmitted"></span></p>
            </div>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <button class="btn btn-success" onclick="closeDetailsModal()">Close</button>
          </div>
        </div>


      </table>
    </div>
  </main>

  <script>
    $(document).ready(function () {
      $('#complaintsTable').DataTable(); // Initialize DataTables
    });
  </script>

  <script>
    function openDetailsModal(busJson) {
      try {
        let busData = JSON.parse(busJson);

        // Ensure all necessary data is available before updating modal
        document.getElementById("modalSubject").textContent = busData.subject || "N/A";
        document.getElementById("modalName").textContent = busData.name || "N/A";
        document.getElementById("modalEmail").textContent = busData.email || "N/A";
        document.getElementById("modalBusNumber").textContent = busData.vehicle_number || "N/A";
        document.getElementById("modalClassification").textContent = busData.classification || "N/A";
        document.getElementById("modalComplaint").textContent = busData.complaint || "N/A";
        document.getElementById("modalDetailedComplaint").textContent = busData.detailed_complaint || "N/A";
        document.getElementById("modalIncidentDatetime").textContent = busData.incident_datetime || "N/A";
        document.getElementById("modalIncidentLocation").textContent = busData.incident_location || "N/A";
        document.getElementById("modalDateSubmitted").textContent = busData.date_submitted || "N/A";
        document.getElementById("modalStatus").textContent = busData.status || "N/A";

        document.getElementById("detailsModal").style.display = "block";
      } catch (error) {
        console.error("Error parsing JSON:", error);
        alert("Failed to load complaint details.");
      }
    }

    function closeDetailsModal() {
      document.getElementById("detailsModal").style.display = "none";
    }

    function toggleStatus(button) {
      let row = button.closest("tr");
      let statusCell = row.querySelector(".status");
      let currentStatus = statusCell.textContent.trim();

      let newStatus;
      if (currentStatus === "New") {
        newStatus = "On-going";
      } else if (currentStatus === "On-going") {
        newStatus = "Resolved";
      } else {
        return; // Stop if already "Resolved"
      }

      statusCell.textContent = newStatus;

      // Save to database via AJAX
      let busId = row.getAttribute("data-id");
      updateStatusInDatabase(busId, newStatus);
    }

    function updateStatusInDatabase(busId, newStatus) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "update_status.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(`id=${busId}&status=${newStatus}`);

      xhr.onload = function () {
        if (xhr.status === 200) {
          console.log("Status updated successfully.");
        } else {
          alert("Error updating status in database.");
          console.error("Failed to update:", xhr.responseText);
        }
      };
    }
  </script>


  <!-- for folder file password modal -->
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
</body>

</html>

<?php
$conn->close();
?>