<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $service_id = isset($_POST["service_provider_id"]) ? (int) $_POST["service_provider_id"] : null; //this checks if the service provider id is present and not null. if the id is not present it returns null.
    $update_service_availability_time = isset($_POST["updated_service_availability"]) ? trim($_POST["updated_service_availability"]) : null;

    // Checks if required fields are provided and the conditions are true if true it executes the querty below
    if ($service_id && $update_service_availability_time) {
        try {
     
            require_once "./dbh.inc.php";

  
            $query1 = "UPDATE serice_provder_table SET updated_service_avalability_time = ? WHERE service_id = ?";

            $stmt = $pdo->prepare($query1);

            $stmt->bindParam(":service_id", $service_id);

            $stmt->bindParam(":updated_service_avalability_time", $updated_service_avalability_time);

            $stmt->execute([$update_service_availability_time, $service_id]);

            $stmt = null;
            $pdo = null;

          
            header("Location: ../../index.php");
            exit();
        } catch (PDOException $e) {
            
            error_log(" error: " . $e->getMessage());
            echo "An error occurred while updating the availability. Please try again later.";
        }
    } else {
       
        header("Location: ../../index.php");
        exit();
    }
} else {
    
    header("Location: ../../index.php");
    exit();
}
