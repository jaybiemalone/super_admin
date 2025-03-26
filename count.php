<?php
function getMaintenanceCount($conn) {
    $sqlcount = "SELECT COUNT(*) AS total FROM maintenance";
    $countresult = mysqli_query($conn, $sqlcount);

    if ($countresult) {
        $row = mysqli_fetch_assoc($countresult);
        return $row['total'];
    } else {
        return 0;
    }
}

$total = getMaintenanceCount($conn);
?>