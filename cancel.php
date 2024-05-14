<?php 

    require_once('dbconfig.php');

    if(isset($_POST["name"]) && isset($_POST["time"])){
        
        $name = $_POST["name"];
        $time = $_POST["time"];

        $query = "UPDATE book SET book_status = 'cancelled'
        WHERE Fname = ? AND Timestamp = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $name, $time);
        $stmt->execute();
        echo "success";
    }

?>