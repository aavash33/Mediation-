<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Fetch consumer form data
    $fullname = htmlspecialchars($_GET["fullname"]);
    $phonenumber = htmlspecialchars($_GET["phonenumber"]);
    $emailaddress = htmlspecialchars($_GET["emailaddress"]);
    $desired_service = htmlspecialchars($_GET["desired_service"]);
    $businesslocation = htmlspecialchars($_GET["location"]);
    $timeservicerequired = htmlspecialchars($_GET["required_time"]);

    // Validate that desired_service is not empty
    if (empty($desired_service)) {
        echo "Desired service is required.";
        exit();
    }

    try {
        require_once "../dbh.inc.php";  // Database connection

        // Step 1: Insert the consumer data into the database
        $query2 = "INSERT INTO consumer (
            full_name, 
            phone_number, 
            email_address, 
            desired_service, 
            consumers_location, 
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
                    sp.service_avalability_time, 
                    sp.updated_service_avalability_time
                   FROM 
                    serice_provder_table sp
                   WHERE 
                    sp.type_of_business = ?";

        // Prepare and execute the query to find the service providers for the consumer's desired service
        $stmt3 = $pdo->prepare($query3);
        $stmt3->execute([$desired_service]);
        $service_providers = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        // Check if any results were found
        if (empty($service_providers)) {
            echo "No service providers found for the desired service.";
        } else {
            // Display the list of service providers
            echo "<h3>Service Providers Matching Your Desired Service:</h3>";
            echo "<ul>";
            foreach ($service_providers as $provider) {
                echo "<li>";
                echo "Service ID: " . htmlspecialchars($provider['service_id']) . "<br>";
                echo "Name: " . htmlspecialchars($provider['first_name']) . " " . htmlspecialchars($provider['last_name']) . "<br>";
                echo "Business Name: " . htmlspecialchars($provider['business_name']) . "<br>";
                echo "Business Address: " . htmlspecialchars($provider['business_address']) . "<br>";
                echo "Description: " . htmlspecialchars($provider['business_description']) . "<br>";
                echo "Availability: " . htmlspecialchars($provider['service_avalability_time']) . "<br>";
                echo "</li>";
            }
            echo "</ul>";
        }

        // Insert the consumer data after showing service providers
        // Step 2: Insert the consumer data into the database
        // Assuming you want to associate the first matching provider with the consumer
        if (!empty($service_providers)) {
            $selected_service_id = $service_providers[0]['service_id'];  // Select the first provider, you can modify this as needed

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

        // Close the PDO connection and statements
        $pdo = null;
        $stmt2 = null;
        $stmt3 = null;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php");
}
?>
