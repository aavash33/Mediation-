<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Use $_GET instead of $GET
    $service_id               = "";
    $first_name               = htmlspecialchars($_GET["fname"]);
    $last_name                = htmlspecialchars($_GET["lname"]);
    $business_name            = htmlspecialchars($_GET["business_name"]);
    $business_address         = htmlspecialchars($_GET["business_location"]);
    $type_of_business         = htmlspecialchars($_GET["type_of_business"]);
    $business_description     = htmlspecialchars($_GET["business_description"]);
    $service_avalability_time = htmlspecialchars($_GET["service_avalablity_time"]);
    // Add this variable

    try {
        require_once "../dbh.inc.php";
        
       
        $query = "INSERT INTO serice_provder_table(
                    first_name,               
                    last_name,                
                    business_name,            
                    business_address,        
                    type_of_business,         
                    business_description,    
                    service_avalability_time 
                    ) 
                  VALUES (?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($query);
        
        
        $stmt->execute([
            
            $first_name,
            $last_name,
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
else{
    header("Location: ../index/home.php");
}
