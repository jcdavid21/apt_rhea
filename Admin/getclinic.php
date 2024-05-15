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
if(isset($_POST["city"])) {
    $city = $_POST["city"];
    $query ="SELECT * FROM clinic WHERE City = '$city'";
    $results = $conn->query($query);
    ?>
    <option value="">Select Clinic</option>
    <?php
    while($rs=$results->fetch_assoc()) {
        ?>
        <option value="<?php echo $rs["cid"]; ?>"><?php echo $rs["name"] . "-" . $rs["town"] . "(CID-" . $rs["cid"] . ")"; ?></option>
        <?php
    }
} else {
    ?>
    <option value="">Select Clinic</option>
    <?php
}
?>
</body>
</html>
