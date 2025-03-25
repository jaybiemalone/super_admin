<?php

include 'config.php';

session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}

// File Upload Section
if (isset($_POST['submit'])) {
  $uploadDirectory = 'uploads/';
  if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
  }

  if (!isset($_FILES['docu_file']['name']) || empty($_FILES['docu_file']['name'])) {
    echo "Error: No file selected.";
    exit();
  }

  $fileName = $_FILES['docu_file']['name'];
  $fileTmpName = $_FILES['docu_file']['tmp_name'];
  $fileType = $_FILES['docu_file']['type'];
  $documentTitle = trim($_POST['name-file']);
  $department = trim($_POST['department']);
  $filePassword = isset($_POST['file_password']) && !empty($_POST['file_password'])
    ? password_hash(trim($_POST['file_password']), PASSWORD_DEFAULT)
    : null;
  $userEmail = trim($_POST['email']);

  $allowedTypes = ['pdf', 'doc', 'docx'];
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $fileName);
  $uploadPath = $uploadDirectory . $sanitizedFileName;

  if (in_array($fileExtension, $allowedTypes)) {
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
      $stmt = $conn->prepare("INSERT INTO file_management (email, file_name, file_path, document_title, file_password, department, uploaded_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
      if (!$stmt) {
        echo "Error: " . $conn->error;
        exit();
      }

      $stmt->bind_param("ssssss", $userEmail, $sanitizedFileName, $uploadPath, $documentTitle, $filePassword, $department);

      if ($stmt->execute()) {
        $_SESSION['success_message'] = ucfirst($fileExtension) . " file uploaded successfully!";
      } else {
        echo "Error: " . $stmt->error;
      }

      $stmt->close();
    } else {
      echo "Error uploading the file.";
    }
  } else {
    echo "Invalid file type. Only PDF, DOC, and DOCX files are allowed.";
  }

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />

  <style>
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .modal-content-unlocked {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 300px;
      margin: 15% auto;
      position: relative;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      cursor: pointer;
    }

    .unlocked-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      margin-top: 10px;
      cursor: pointer;
    }

    .unlocked-btn:hover {
      background-color: #45a049;
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
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z" />
          </svg>
          <span>Financial</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
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
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z" />
          </svg>
          <span>Logistic</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
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
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z" />
          </svg>
          <span>HR</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
              d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
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
    <header>
      <div></div>
      <div>
        <button onclick="openLogout()" class="px-4 py-2 text-white bg-red-500 rounded">Logout</button>
      </div>
    </header>
    <div class="container">
      <div class="document-upload">
        <form action="file.php" method="POST" enctype="multipart/form-data">
          <ul>
            <li>
              <h1>Upload Document</h1>
            </li>
            <li>
              <label for="email">Email</label>
              <input type="text" name="email" id="email" placeholder="Enter Email">
            </li>
            <li>
              <label for="name-file">Document Title</label><br>
              <input type="text" name="name-file" id="name-file" placeholder="Enter Document Title" required>
            </li>
            <li>
              <label for="docu_file">Upload Document</label><br>
              <input type="file" id="docu_file" name="docu_file" accept=".pdf,.doc,.docx" required>
            </li>
            <li>
              <label for="department" required>Department</label><br>
              <select name="department" id="department">
                <option value="#">Select Department</option>
                <option value="hr1">HR 1</option>
                <option value="hr2">HR 2</option>
                <option value="hr3">HR 3</option>
                <option value="logistic1">Logistic 1</option>
                <option value="logistic2">Logistic 2</option>
                <option value="admin">Admin</option>
                <option value="core1">Core 1</option>
                <option value="core2">Core 2</option>
              </select>
            </li>
            <li>
              <label for="file_password">Password</label><br>
              <input type="password" name="file_password" id="file_password" placeholder="Enter the password">
            </li>
            <li>
              <button type="submit" name="submit">Upload Document</button>
            </li>
          </ul>
        </form>
      </div>

      <div class="file-content">
        <table id="userTable" class="display" style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th>Email</th>
              <th>File Name</th>
              <th>Uploaded At</th>
              <th>Department</th>
              <th>Password</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT id, email, document_title, uploaded_at, file_password, file_path, department FROM file_management");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['document_title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['uploaded_at']) . "</td>";
                echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                echo "<td>";
                if (!empty($row['file_password'])) {
                  echo '<span style="background-color: red; color: white; padding: 5px 10px; border-radius: 12px;">Lock</span>';
                } else {
                  echo '<span style="background-color: green; color: white; padding: 5px 10px; border-radius: 12px;">Unlocked</span>';
                }
                echo "</td>";
                echo "<td>
                              <a href='delete.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Are you sure you want to delete this file?\")' style='background-color: #ff4d4d; color: white; padding: 8px 12px; margin-right: 8px; text-decoration: none; border-radius: 5px;'>Delete</a>";
                if (!empty($row['file_password'])) {
                  echo "<button onclick=\"openPasswordModal('" . $row['id'] . "')\" style='background-color: #ffa500; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px;'>Unlocked?</button>";
                } else {
                  echo "<a href='" . htmlspecialchars($row['file_path']) . "' target='_blank' style='background-color: #4CAF50; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px;'>Download</a>";
                }
                echo "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4'>No files found.</td></tr>";
            }
            ?>
          </tbody>


          <div class="unlocked">
            <div id="passwordModal" class="modal">
              <div class="modal-content-unlocked">
                <span class="close-btn" onclick="closePasswordModal()">&times;</span>
                <h3>Enter Password</h3>
                <input type="password" id="filePassword" placeholder="Enter password" />
                <input type="hidden" id="fileId" />
                <button class="unlocked-btn" onclick="submitPassword()">Submit</button>
                <a href="forget.php">Forgot Password?</a>
              </div>
            </div>
          </div>

        </table>
      </div>
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

  </main>
  <script>
    $(document).ready(function () {
      $('#userTable').DataTable({
        "paging": true,
        "lengthMenu": [10], // Show only 10 rows per page
        "ordering": true,
        "info": false,
        "searching": true
      });
    });

    $(document).ready(function () {
      $('#userTable').DataTable();
    });


  </script>
  <script>
    function openPasswordModal(fileId) {
      document.getElementById('passwordModal').style.display = 'block';
      document.getElementById('fileId').value = fileId;
    }

    function closePasswordModal() {
      document.getElementById('passwordModal').style.display = 'none';
    }

    function submitPassword() {
      const password = document.getElementById('filePassword').value;
      const fileId = document.getElementById('fileId').value;

      if (!password) {
        alert("Please enter a password.");
        return;
      }

      window.location.href = `validate_password.php?id=${fileId}&password=${encodeURIComponent(password)}`;
    }
  </script>

</body>

</html>