<?php
   $servername = "localhost:3306";
   $username = "root";
   $password = "root";
   $schema = "salah_michelle_development";
   // Create connection
   $db = new mysqli($servername, $username, $password, $schema);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $id = $_REQUEST["id"];
    $dayOfWeek = $_REQUEST["day"];

    $stylists = [];

    $sql = "SELECT staff.id, staff.first_name, staff_schedule.start_time, staff_schedule.end_time FROM staff, staff_schedule, staff_provides WHERE (staff.id = staff_schedule.staff_id AND staff.id = staff_provides.staff_id) AND staff_schedule.day = ? AND staff_provides.service_id = ?";
 
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si",$dayOfWeek,$id);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_object()) {
        array_push($stylists,$row);
    };

    echo json_encode($stylists);
    $db->close();
?>