<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript">//alert("sdfsd");</script>
<body>
<?php
require_once("dbconfig.php");

// Check if clinic value is set via POST
if(isset($_POST["clinic"])) {
    $clinic_id = $_POST["clinic"];
?>
    <option value="">Select Doctor</option>
<?php
    // Fetch doctors associated with the selected clinic
    $query1 = "SELECT DISTINCT d.did, d.name FROM doctor d JOIN clinic dc ON d.did = dc.cid WHERE dc.cid = '$clinic_id'";
    $result1 = $conn->query($query1);
    
    // Check if query executed successfully
    if ($result1) {
        while($rs1 = $result1->fetch_assoc()) {
?>
            <option value="<?php echo $rs1["did"]; ?>"><?php echo $rs1["name"]; ?></option>
<?php
        }
    } else {
        echo "Error: " . $conn->error; // Output error if query fails
    }
}
?>

</body>
</html>
