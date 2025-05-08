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
        sp.email_address,
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

        if (empty($service_providers)) {
            echo "<div class='no-results'>No service providers found for the desired service as per your desired date and time.</div>";
        } else {
            echo "<div class='results-container'>";
            echo "<h3>Service Providers Matching Your Desired Service:</h3>";
            
            foreach ($service_providers as $provider) {
                echo "<div class='provider-card'>";
                echo "<div class='provider-info'>";
                echo "<h4>" . htmlspecialchars($provider['first_name']) . " " . htmlspecialchars($provider['last_name']) . "</h4>";
                echo "<p><strong>Business Name:</strong> " . htmlspecialchars($provider['business_name']) . "</p>";
                echo "<p><strong>Business Address:</strong> " . htmlspecialchars($provider['business_address']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($provider['business_description']) . "</p>";
                echo "<p><strong>Availability:</strong> " . htmlspecialchars($provider['available_time']) . "</p>";
                echo "</div>";
                






                
                echo "<form class='select-form' method='post' action='./business_profile.php'>";
                echo "<input type='hidden' name='provider_id' value='" . htmlspecialchars($provider['service_id']) . "'>";
                echo "<input type='hidden' name='provider_email' value='" . htmlspecialchars($provider['email_address']) . "'>";
                echo "<input type='hidden' name='selected_time' value='" . htmlspecialchars($provider['available_time']) . "'>";
                echo "<input type='hidden' name='business_name' value='" . htmlspecialchars($provider['business_name']) . "'>";
                // Fix: Remove the array access, use $fullname directly
                echo "<input type='hidden' name='consumer_name' value='" . htmlspecialchars($fullname) . "'>";
                echo "<input type='hidden' name='consumer_email' value='" . htmlspecialchars($emailaddress) . "'>";
                echo "<input type='hidden' name='consumer_contact' value='" . htmlspecialchars($phonenumber) . "'>";
                echo "<input type='datetime-local' name='dateandtime' required />";
                echo "<button type='submit' class='select-btn'>Select</button>";
                echo "</form>";
                
                echo "</div>";
            }
        
            echo "</div>";

            echo "<style>
                .results-container {
                    max-width: 1200px;
                    margin: 20px auto;
                    padding: 20px;
                }

                .no-results {
                    text-align: center;
                    padding: 20px;
                    background: #fff3cd;
                    border: 1px solid #ffeeba;
                    border-radius: 5px;
                    margin: 20px auto;
                    max-width: 600px;
                }

                .provider-card {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    margin-bottom: 20px;
                    padding: 20px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .provider-info {
                    flex: 1;
                }

                .provider-info h4 {
                    margin: 0 0 10px 0;
                    color: #333;
                }

                .provider-info p {
                    margin: 5px 0;
                    color: #666;
                }

                .select-form {
                    margin-left: 20px;
                }

                .select-btn {
                    background: #007bff;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background 0.3s ease;
                }

                .select-btn:hover {
                    background: #0056b3;
                }
            </style>";
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
