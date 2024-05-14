<html>
<head>
<link rel="stylesheet" href="../main.css">
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
</head>
<body style="background-image:url(mgrchange.jpg)">
<div class="header">
				<ul>
					<li style="float:left;border-right:none"><strong><?php session_start(); echo $_SESSION['mgrname']; ?></strong></li>
					<li><a href="mgrmenu.php">Home</a></li>
				</ul>
</div>
<div class="container" style="width:100%;background-image:url(mgrchange.jpg)">
	<div class="container" style="background-color:white">
	<form method="post">
	  <button type="button" name="change" onclick="window.location.href='changebookingstatus.php'">Change/View Booking Status</button>
	  <button type="submit" name="logout" style="float:right">Log Out</button>
	</form>
    </div>
</div>
<?php
include "dbconfig.php";

if(isset($_POST['check']))
{
    include 'dbconfig.php';
    $name=$_SESSION['user'];
    $sql = "SELECT * FROM book WHERE name='$name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($rows = mysqli_fetch_assoc($result)) 
        {
            echo "Username:".$rows["username"]."Name:".$rows["name"]."Date of Visit:".$rows["dov"]."Town:".$rows["town"]."<br>";
        }
    } 
    else 
    {
        echo "0 results";
    }
}

if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    header("Refresh:1; url=../cover.php"); 
}

$username = $_SESSION['username'];
$sql1 = "SELECT * FROM book WHERE book_status = 'cancelled' ORDER BY DOV DESC";
$result1 = mysqli_query($conn, $sql1);

echo "<table>
        <tr>
            <th>Appointment-Date</th>
            <th>Name</th>
            <th>Clinic</th>
            <th>Doctor</th>
            <th>Booked-On</th>
			<th>Status</th>
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
            echo "<td>" . $row1['Timestamp'] . "</td>";
			echo "<td>" . $row1['book_status'] . "</td>";
            echo "</tr>";
        }
    }
}
?>

</body>
</html>