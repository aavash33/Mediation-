<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Changed from GET to POST

    $service_id               = "";
    $first_name               = htmlspecialchars($_POST["fname"]);  // Changed from $_GET to $_POST
    $last_name                = htmlspecialchars($_POST["lname"]);
    $email_address            = htmlspecialchars($_POST["email_address"]);
    $business_name            = htmlspecialchars($_POST["business_name"]);
    $business_address         = htmlspecialchars($_POST["business_location"]);
    $type_of_business        = htmlspecialchars($_POST["type_of_business"]);
    $business_description     = htmlspecialchars($_POST["business_description"]);
    $service_avalability_time = htmlspecialchars($_POST["service_avalablity_time"]);

    try {
        require_once "../dbh.inc.php";
        
        $query = "INSERT INTO serice_provder_table(
                    first_name,               
                    last_name,
                    email_address,                
                    business_name,            
                    business_address,        
                    type_of_business,         
                    business_description,    
                    service_avalability_time 
                    ) 
                  VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($query);
        
        $stmt->execute([
            $first_name,
            $last_name,
            $email_address,
            $business_name,
            $business_address,
            $type_of_business,
            $business_description,
            $service_avalability_time,
        ]);

        $service_id = $pdo->lastInsertId();

        $query2 = "INSERT INTO availabletime(service_id, available_time) VALUES (?, ?)";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute([$service_id, $service_avalability_time]);
      
        echo "<h4>Service ID: " . htmlspecialchars($service_id) . "</h4>";

        $pdo = null;
        $stmt = null;
        $stmt2 = null;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
else {
    header("Location: ../index/home.php");
}
?>