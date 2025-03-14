<?php
session_start(); // Start the session
include 'db.php'; // Include a valid database connection

// Check if the form is submitteds
if (isset($_POST['submit'])) {
    $uploadDirectory = 'uploads/';

    // Create uploads directory if it doesn't exist
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    // Check if a file was uploaded
    if (isset($_FILES['docu_file']) && $_FILES['docu_file']['error'] === UPLOAD_ERR_OK) {
        // Get the file details
        $fileName = basename($_FILES['docu_file']['name']); // Use basename() to avoid directory traversal
        $fileTmpName = $_FILES['docu_file']['tmp_name'];
        $fileType = $_FILES['docu_file']['type'];
        $fileSize = $_FILES['docu_file']['size'];

        // Get the document title from the form
        $documentTitle = htmlspecialchars(trim($_POST['name-file']), ENT_QUOTES, 'UTF-8');

        // Allowed file types (also checking MIME type)
        $allowedTypes = ['pdf', 'doc', 'docx'];

        // Extract file extension and validate it
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check file MIME type as well to prevent spoofing
        $allowedMimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($fileType, $allowedMimeTypes)) {
            $_SESSION['error_message'] = "Invalid file MIME type. Only PDF, DOC, and DOCX files are allowed.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Sanitize and define the full upload path
        $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
        $uniqueFileName = time() . "_" . $sanitizedFileName; // Prevent overwriting by making the filename unique
        $uploadPath = $uploadDirectory . $uniqueFileName;

        // Validate file type
        if (in_array($fileExtension, $allowedTypes)) {
            // Check if the file already exists
            if (file_exists($uploadPath)) {
                $_SESSION['error_message'] = "A file with the same name already exists. Please rename your file and try again.";
            } elseif ($fileSize > 10 * 1024 * 1024) { // Limit file size to 10MB
                $_SESSION['error_message'] = "File size exceeds the maximum limit of 10MB.";
            } else {
                // Move the file to the server
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Insert the file details into the template_document table
                    $stmt = $conn->prepare("INSERT INTO template_document (file_name, file_path, document_title, uploaded_at) VALUES (?, ?, ?, NOW())");
                    $stmt->bind_param("sss", $uniqueFileName, $uploadPath, $documentTitle);

                    if ($stmt->execute()) {
                        // Set a success message
                        $_SESSION['success_message'] = "File uploaded successfully and inserted into the database!";
                    } else {
                        $_SESSION['error_message'] = "Database error: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    $_SESSION['error_message'] = "Error moving the uploaded file to the server.";
                }
            }
        } else {
            $_SESSION['error_message'] = "Invalid file type. Only PDF, DOC, and DOCX files are allowed.";
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded or an error occurred during the upload.";
    }

    // Redirect to the same page to display messages
    header("Location: " . $_SERVER['PHP_SELF']);
    exit(); // Ensure script stops after redirect
}
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
                <span>Document</span>
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
        <div class="document-content">
            <div class="document-upload">
            <form action="template-files.php" method="POST" enctype="multipart/form-data">
                <ul>
                    <li>
                        <h1>Upload Template Document</h1>
                    </li>
                    <li>
                        <label for="name-file">Document Title</label>
                        <input type="text" name="name-file" id="name-file" placeholder="Enter Document Title" required>
                    </li>
                    <li>
                        <label for="docu_file">Upload Document</label>
                        <input type="file" id="docu_file" name="docu_file" accept=".pdf,.doc,.docx" required>
                    </li>
                    <li>
                        <button type="submit" name="submit">Upload Document</button>
                    </li>
                </ul>
            </form>
            </div>
            <div class="document-container">
                <div class="document-title">
                    <ul><h1>Document</h1></ul>
                    <ul><input type="search" placeholder="Seach Title Here"></ul>
                </div>
                <div class="document-history">
                    <ul>
                        <li><label for="document-page">Select Page</label>
                            <Select id="document-page">
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                            <option value="">4</option>
                            <option value="">5</option>
                            <option value="">6</option>
                            <option value="">7</option>
                            <option value="">8</option>
                        </Select></li>
                    </ul>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Uploaded At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Fetch uploaded files from the database
                        $result = $conn->query("SELECT * FROM template_document");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['document_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['uploaded_at']) . "</td>";
                                echo "<td>
                                        <a href='delete.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Are you sure you want to delete this file?\")'>Delete</a>
                                        <a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>View</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' style='text-align: center;'>No files have been uploaded yet.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php

$conn->close();
?>