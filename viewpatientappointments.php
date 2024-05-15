<html>
<head>
<link rel="stylesheet" href="main.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
table{
    width: 85%;
    border-collapse: collapse;
	border: 4px solid black;
    padding: 5px;
	font-size: 25px;
}

th{
border: 4px solid black;
	background-color: #4CAF50;
    color: white;
	text-align: left;
}
tr,td{
	border: 4px solid black;
	background-color: white;
    color: black;
}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head><?php include "dbconfig.php"; ?>
<body style="background-image:url(images/cancelback.jpg)">
<div class="header">
				<ul>
					<li style="float:left;border-right:none"><strong><?php session_start(); echo $_SESSION['user']; ?></strong></li>
					<li><a href="ulogin.php">Home</a></li>
				</ul>
</div>
<center>

<?php
include "dbconfig.php";

$username = $_SESSION['username'];
$sql1 = "SELECT * FROM book WHERE username ='".$username."' AND book_status = 'pending' ORDER BY DOV DESC";
$result1 = mysqli_query($conn, $sql1);

echo "<table>
        <tr>
            <th>Appointment-Date</th>
            <th>Name</th>
            <th>Clinic</th>
            <th>Doctor</th>
            <th>Status</th>
            <th>Booked-On</th>
        </tr>";

while ($row1 = mysqli_fetch_array($result1)) {
    $sql2 = "SELECT * FROM doctor WHERE did=".$row1['DID'];
    $result2 = mysqli_query($conn, $sql2);
    
    while ($row2 = mysqli_fetch_array($result2)) {
        $sql3 = "SELECT * FROM clinic WHERE CID=".$row1['CID'];
        $result3 = mysqli_query($conn, $sql3);
        
        while ($row3 = mysqli_fetch_array($result3)) {
            echo "<tr>";
            echo "<td>" . $row1['DOV'] . "</td>";
            echo "<td>" . $row1['Fname'] . "</td>";
            echo "<td>" . $row3['name']."-".$row3['town'] . "</td>";
            echo "<td>" . $row2['name'] . "</td>";
            echo "<td>" . $row1['Status'] . "</td>";
            echo "<td>" . $row1['Timestamp'] . "</td>";
            echo "</tr>";
            
            $currentDate = date("Y-m-d");
            $appointmentDate = $row1['DOV'];
            $twoDaysBeforeAppointment = date("Y-m-d", strtotime("-2 days", strtotime($appointmentDate)));

            if ($currentDate == $twoDaysBeforeAppointment || $currentDate == $appointmentDate) {
                echo "<script>
                        console.log('Appointment approaching:', '".$appointmentDate."');
                        $(document).ready(function() {
                            console.log('Document ready, triggering SweetAlert');
                            Swal.fire({
                                title: 'Appointment Reminder',
                                html: 'Your appointment is scheduled for ".$appointmentDate." at ".$row3['name']."-".$row3['town']."<br>Booked-On: ".$row1['Timestamp']."',
                                icon: 'info',
                                confirmButtonText: 'Okay',
                                showCancelButton: true,
                            }).then((result) => {
                                if(result.isDismissed) {
                                    console.log('Cancel button clicked');
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'You won\\'t be able to revert this!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, cancel it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            console.log('Confirm button clicked, performing cancel action');
                                            handleCancelAction('".$row1['Fname']."', '".$row1['Timestamp']."');
                                        }
                                    });
                                }
                            });
                        });
                    </script>";
            }

            

        }
    }
}
?>
<script src="cancel.js"></script>
</center>
</body>
</html>