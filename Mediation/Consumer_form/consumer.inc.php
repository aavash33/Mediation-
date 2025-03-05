<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    
    $fullname = htmlspecialchars($_GET["fullname"]);
    $phonenumber = htmlspecialchars($_GET["phonenumber"]);
    $emailaddress = htmlspecialchars($_GET["emailaddress"]);
    $desired_service = htmlspecialchars($_GET["desired_service"]);
    $businesslocation = htmlspecialchars($_GET["location"]);
    $timeservicerequired = htmlspecialchars($_GET["required_time"]);

    // checks if the value of desired_service column which is required to find the desired businesses is not empty.
    if (empty($desired_service)) {
        echo "Desired service is required.";
        exit();
    }

    try {
        require_once "../dbh.inc.php";  
        
        //  Insert the consumer data into the database
        $query2 = "INSERT INTO consumer (
            full_name, 
            phone_number, 
            email_address, 
            desired_service, 
            consumer_location, 
            date_service_required, 
            updated_date_service_required, 
            service_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


        // Get the service providers based on the desired service
        $query3 = "SELECT 
        sp.service_id, 
        sp.first_name, 
        sp.last_name, 
        sp.business_name, 
        sp.business_address, 
        sp.type_of_business, 
        sp.business_description,
        t.available_time
        
        FROM 
        serice_provder_table sp
        join availabletime t on t.service_id = sp.service_id
        WHERE 
        sp.type_of_business = ?
        AND  t.available_time >= '$timeservicerequired'
         ORDER BY t.available_time";

        // Prepare and execute the query to find the service providers for the consumer's desired service
        $stmt3 = $pdo->prepare($query3);
        $stmt3->execute([$desired_service]);
        $service_providers = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        // Check if any results were found and if none found echo the message No service .......
        if (empty($service_providers)) {
            echo "No service providers found for the desired service as per your desired date and time.";
        } else {
            // echo the list of service providers
            echo "<h3>Service Providers Matching Your Desired Service:</h3>";
            echo "<ul>";
            foreach ($service_providers as $provider) {
                echo "<li>";
                
                echo "Name: " . htmlspecialchars($provider['first_name']) . " " . htmlspecialchars($provider['last_name']) . "<br>";
                echo "Business Name: " . htmlspecialchars($provider['business_name']) . "<br>";
                echo "Business Address: " . htmlspecialchars($provider['business_address']) . "<br>";

              

                echo "Description: " . htmlspecialchars($provider['business_description']) . "<br>";
                echo "Availability: " . htmlspecialchars($provider['available_time']) . "<br>";
                echo "</li>";
            }
            echo "</ul>";
        }

        // Inserting  the consumer data after showing service providers/businesses details 
        // Step 2: Insert the consumer data into the database
      
        if (!empty($service_providers)) {
            $selected_service_id = $service_providers[0]['service_id'];  // 

            $stmt2 = $pdo->prepare($query2);
            $stmt2->execute([
                $fullname, 
                $phonenumber, 
                $emailaddress, 
                $desired_service, 
                $businesslocation, 
                $timeservicerequired, 
                $timeservicerequired, 
                $selected_service_id
            ]);
        }

       
        $pdo = null;
        $stmt2 = null;
        $stmt3 = null;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index/home.html");
}
?>
