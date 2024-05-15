<?php
// Include your database configuration file
require_once("dbconfig.php");

// Retrieve form data
$cid = $_POST['clinic'];
$did = $_POST['doctor'];
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];

// Loop through selected days
foreach ($_POST['daylist'] as $daylist) {
    // Insert data into doctor_availability table
    $sql = "INSERT INTO doctor_availability (CID, DID, Day, Starttime, Endtime) VALUES ('$cid','$did','$daylist','$starttime','$endtime')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<h2>Record created successfully (CID=$cid DID=$did Day=$daylist)!!</h2>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
