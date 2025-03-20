<?php

@include 'config.php';
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>logistic page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style_user_level.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hi, <span>Finance</span></h3>
      <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p>this is an Finance page</p>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>