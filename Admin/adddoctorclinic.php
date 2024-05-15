<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="adminmain.css"> 
</head>
<body background="clinicview.jpg">
<ul>
<li class="dropdown"><font color="yellow" size="10">ADMIN MODE</font></li>
<br>
<h2>
  <li class="dropdown">    
  <a href="javascript:void(0)" class="dropbtn">Doctor</a>
    <div class="dropdown-content">
      <a href="adddoctor.php">Add Doctor</a>
      <a href="deletedoctor.php">Delete Doctor</a>
      <a href="showdoctor.php">Show Doctor</a>
      <a href="showdoctorschedule.php">Show Doctor Schedule</a>
    </div>
  </li>
  
  <li class="dropdown">
  <a href="javascript:void(0)" class="dropbtn">Clinic</a>
    <div class="dropdown-content">
      <a href="addclinic.php">Add Clinic</a>
      <a href="deleteclinic.php">Delete Clinic</a>
      <a href="adddoctorclinic.php">Assign Doctor to Clinic</a>
      <a href="addmanagerclinic.php">Assign Manager to Clinic</a>
      <a href="deletedoctorclinic.php">Delete Doctor from Clinic</a>
      <a href="deletemanagerclinic.php">Delete Manager from Clinic</a>
      <a href="showclinic.php">Show Clinic</a>
    </div>
  </li>
  <li class="dropdown">    
  <a href="javascript:void(0)" class="dropbtn">Manager</a>
    <div class="dropdown-content">
      <a href="addmanager.php">Add Manager</a>
      <a href="deletemanager.php">Delete Manager</a>
      <a href="showmanager.php">Show Manager</a>
    </div>
  </li>
   <li>  
  <form method="post" action="mainpage.php">  
  <button type="submit" class="cancelbtn" name="logout" style="float:right;font-size:22px"><b>Log Out</b></button>
  </form>
  </li>
  
</ul>
</h2>
<center><h1>ASSIGN DOCTOR TO A CLINIC</h1><hr>
<form id="clinicForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label style="font-size:20px">City:</label>
<select name="city" id="city-list" class="demoInputBox">
    <option value="" disabled selected>Select City</option>
    <?php
    include 'dbconfig.php';
    $sql1 = "SELECT DISTINCT region FROM doctor";
    $results = $conn->query($sql1); 
    while($rs = $results->fetch_assoc()) { 
        ?>
        <option value="<?php echo $rs["region"]; ?>"><?php echo $rs["region"]; ?></option>
        <?php
    }
    ?>
</select>

<label style="font-size:20px">Clinic:</label>
<select id="clinic-list" name="clinic" disabled>
    <option value="" disabled selected>Select Clinic</option>
</select>

<label style="font-size:20px">Doctor:</label>
<select name="doctor" id="doctor-list" disabled>
    <option value="">Select Doctor</option>
</select>

<label style="font-size:20px">Available Days</label>
<table>
<tr><td>Monday:</td><td><input type="checkbox" value="Monday" name="daylist[]"/></td></tr>
<tr><td>Tuesday:</td><td><input type="checkbox" value="Tuesday" name="daylist[]"/></td></tr>
<tr><td>Wednesday:</td><td><input type="checkbox" value="Wednesday" name="daylist[]"/></td></tr>
<tr><td>Thursday:</td><td><input type="checkbox" value="Thursday" name="daylist[]"/></td></tr>
<tr><td>Friday:</td><td><input type="checkbox" value="Friday" name="daylist[]"/></td></tr>
<tr><td>Saturday:</td><td><input type="checkbox" value="Saturday" name="daylist[]"/></td></tr>
</table>

<label style="font-size:20px">Availability (24 hour Format):</label><br>
From: <input type="time" name="starttime"><br>
To: <input type="time" name="endtime"><br>

<button type="button" name="Submit" id="submit">Submit</button>
</form>
<script src="insert.js"></script>
<!-- <?php
session_start();
require_once("dbconfig.php");

if(isset($_POST['Submit'])) {
    // Retrieve form data
    $cid = $_POST['clinic'];
    $did = $_POST['doctor']; // Selected doctor ID
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    
    // Loop through selected days
    foreach($_POST['daylist'] as $daylist) {
        // Insert data into doctor_availability table
        $sql = "INSERT INTO doctor_availability (CID, DID, Day, Starttime, Endtime) VALUES ('$cid','$did','$daylist','$starttime','$endtime')";
        
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "<h2>Record created successfully (CID=$cid DID=$did Day=$daylist)!!</h2>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>


<script>
function submitForm() {
    $('#clinicForm').submit(); // Submit the form
}
</script> -->



<script>


$('#city-list').change(function(){
    var city = $(this).val();
    if(city) {
        $('#clinic-list').prop('disabled', false);
        $.ajax({
            type: "POST",
            url: "getclinic.php",
            data: {'city': city},
            success: function(data){
                $('#clinic-list').html(data);
                $('#doctor-list').html('<option value="" disabled selected>Select Doctor</option>');
                $('#doctor-list').prop('disabled', true);
            }
        });
    } else {
        $('#clinic-list').prop('disabled', true);
        $('#clinic-list').html('<option value="" disabled selected>Select Clinic</option>');
    }
});

$('#clinic-list').change(function(){
    var clinic = $(this).val();
    if(clinic) {
        $('#doctor-list').prop('disabled', false);
        // Get the CID value of the selected clinic
        var cid = $(this).find(':selected').attr('data-cid');
        $.ajax({
            type: "POST",
            url: "getdoctor.php",
            data: {'clinic': clinic, 'cid': cid}, // Pass the clinic ID (CID) to getdoctor.php
            success: function(data){
                $('#doctor-list').html(data);
            }
        });
    } else {
        $('#doctor-list').prop('disabled', true);
        $('#doctor-list').html('<option value="" disabled selected>Select Doctor</option>');
    }
});

</script>


<div id="response"></div>

</body>
</html>
