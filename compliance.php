<?php
@include 'config.php';

session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get form data
    $bus_name = $conn->real_escape_string($_POST['bus_name']);
    $plate_number = $conn->real_escape_string($_POST['plate_number']);
    $notes = $conn->real_escape_string($_POST['notes']);
    $status = $conn->real_escape_string($_POST['status']);

    // ✅ CHECK IF THE PLATE NUMBER ALREADY EXISTS
    $check_sql = "SELECT * FROM compliance_data WHERE plate_number = '$plate_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // If plate number already exists, show an alert
        echo "<script>alert('Error: This plate number already exists!');</script>";
    } else {
        // ✅ INSERT DATA SAFELY
        $sql = "INSERT INTO compliance_data (bus_name, plate_number, status, notes) 
                VALUES ('$bus_name', '$plate_number', '$status', '$notes')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Bus added successfully');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <style>
    #userTable_wrapper{
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    /* Table Styling */
.table-container {
    width: 100%;
    overflow-x: auto; /* Ensures responsiveness */
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

th, td {
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

.compliance-container{
    box-shadow: 0 0 0 1px rgba(128, 128, 128, 0.158);
    border-radius: 10px;
    box-sizing: border-box;
    padding: 20px;
    height: 100vh;
    width: 100%;
}

/* Buttons inside the table */
.compliance-container button {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 2px;
    transition: 0.3s;
}

/* View Details button */
.compliance-container button:first-child {
    background-color: #28a745;
    color: white;
}

.compliance-container button:first-child:hover {
    background-color: #218838;
}

/* Contact button */
.compliance-container button:last-child {
    background-color: #dc3545;
    color: white;
}

.compliance-container button:last-child:hover {
    background-color: #c82333;
}

/* Responsive */
@media (max-width: 768px) {
    th, td {
        padding: 10px;
        font-size: 14px;
    }

    .compliance-container button {
        padding: 6px 10px;
        font-size: 12px;
    }
}

    /* General modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000; /* Ensures modal appears above everything */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    backdrop-filter: blur(5px); /* Adds a blur effect */
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
input, select, textarea {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Submit button */
.form-btn, button {
    background-color: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}

.form-btn:hover, button:hover {
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
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z"/></svg>
        </button>
      </li>
      <li>
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
            <li class="active"><a href="compliance.php">vehicle <br> compliance</a></li>
            <li><a href="safety.php">Accident <br> Management</a></li>
            <li><a href="inbox.php">Inbox</a></li>
            <li><a href="complaint.php">Complaint <br> Management</a></li>
            <li><a href="cfsurvey.php">Customer Feedback <br> Survey</a></li>
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
  <div class="compliance-container">

<div>
<button id="add-bus-btn">Add compliance</button>
<a href="logout.php" id="logout" style="color: white; background: red; padding: 10px; text-decoration: none; border-radius: 5px;">
      Logout
  </a>
  
  <div id="add-user-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('add-user-modal')">&times;</span>
        <h2>Add Taxi compliance</h2>
        <form action="" method="post">
            <h3>Create Account</h3>
            <input type="text" name="bus_name" required placeholder="Enter Taxi Name">
            <input type="text" name="plate_number" required placeholder="Plate Number">
            <input type="text" name="notes" required placeholder="Notes">
            <select name="status" required>
                <option value="Compliant">Compliant</option>
                <option value="Non-Compliant">Non-Compliant</option>
                <option value="Pending">Pending</option>
            </select>
            <input type="submit" name="submit" value="Add" class="form-btn">
        </form>
    </div>
</div>


</div>

<table id="userTable" class="display">
    <thead>
        <tr>
            <th>Taxi_name</th>
            <th>plate_number</th>
            <th>status</th>
            <th>notes</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!$conn) {
            die("<tr><td colspan='7'>Database connection error.</td></tr>");
        }

        $sql = "SELECT * FROM compliance_data";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $busJson = htmlspecialchars(json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');

                echo "<tr>
                        <td>" . htmlspecialchars($row['bus_name'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['plate_number'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['notes'], ENT_QUOTES, 'UTF-8') . "</td>";

                echo "<td>
                        <!-- View Details Button -->
                        <button onclick='openDetailsModal(`$busJson`)'>View Details</button>

                        <!-- Contact Button -->
                        <button onclick='openContactModal(\"" . htmlspecialchars($row['bus_name'], ENT_QUOTES, 'UTF-8') . "\")'>Contact</button>
                      </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found.</td></tr>";
        }
        ?>
    </tbody>

    <!-- View Details Modal -->
    <div id="details-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('details-modal')">&times;</span>
            <h2>Taxi Details</h2>
            <p><strong>Taxi Name:</strong> <span id="detail-bus-name"></span></p>
            <p><strong>Plate Number:</strong> <span id="detail-plate-number"></span></p>
            <p><strong>Status:</strong> <span id="detail-status"></span></p>
            <p><strong>Notes:</strong> <span id="detail-notes"></span></p>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contact-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('contact-modal')">&times;</span>
            <h2>Contact Taxi/Taxi</h2>
            <p>Send a message to <strong><span id="contact-bus-name"></span></strong></p>
            <form>
                <textarea placeholder="Enter your message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

</table>


</div>
  </main>

<script>
// Function to open a modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Function to close a modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal if the user clicks outside of the modal content
window.onclick = function(event) {
    let modals = document.querySelectorAll(".modal");
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
}

// Function to open Bus Details Modal with dynamic data
function openDetailsModal(data) {
    let busData = JSON.parse(data);
    document.getElementById('detail-bus-name').innerText = busData.bus_name;
    document.getElementById('detail-plate-number').innerText = busData.plate_number;
    document.getElementById('detail-status').innerText = busData.status;
    document.getElementById('detail-notes').innerText = busData.notes;
    
    openModal('details-modal');
}

// Function to open Contact Modal with bus name
function openContactModal(busName) {
    document.getElementById('contact-bus-name').innerText = busName;
    openModal('contact-modal');
}

// Add event listeners for opening modals
document.addEventListener("DOMContentLoaded", function() {
    // Open Add Bus Modal
    let addBusBtn = document.getElementById("add-bus-btn"); // Ensure you have this button
    if (addBusBtn) {
        addBusBtn.addEventListener("click", function() {
            openModal('add-user-modal');
        });
    }

    // Open Bus Details Modal
    let detailsBtn = document.querySelectorAll(".open-details-btn"); // Ensure these buttons exist
    detailsBtn.forEach(button => {
        button.addEventListener("click", function() {
            let busData = this.getAttribute("data-bus"); // JSON data in a data attribute
            openDetailsModal(busData);
        });
    });

    // Open Contact Modal
    let contactBtn = document.querySelectorAll(".open-contact-btn"); // Ensure these buttons exist
    contactBtn.forEach(button => {
        button.addEventListener("click", function() {
            let busName = this.getAttribute("data-bus-name");
            openContactModal(busName);
        });
    });

    // Handle Form Submission in Contact Modal
    let form = document.querySelector("#contact-modal form");
    if (form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent page reload
            alert("Message sent successfully!");
            closeModal('contact-modal');
        });
    }
});


</script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": true,
            "lengthMenu": [10], // Show only 10 rows per page
            "ordering": true,
            "info": false, 
            "searching": true
        });
    });

    $(document).ready(function() {
      $("#userTable_filter input").attr("placeholder", "Search user email...");
    });


    </script>

<?php


if (isset($stmt)) {
  $stmt->close(); // Close the prepared statement if it exists
}
$conn->close(); // Close the connection after all queries are done

?>
</body>
</html>