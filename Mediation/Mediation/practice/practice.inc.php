<?php
$dsn = "mysql:host=localhost;dbname=mediation";
$dbusername = "root";
$dbpassword = "";

try {
   
    $pdo = new PDO($dsn, $dbusername, $dbpassword);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} 
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$select_str = "";

// Use PDO for query
$query = "SELECT * FROM typeofbusiness";
$stmt = $pdo->query($query); // Execute query
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $select_str .= "<OPTION VALUE=\"$row[typeofbusiness_id]\" > $row[Nameofthetypeofbusinesses] \n"; 
}

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
                    service_provider_table sp
           WHERE 
                    sp.type_of_business = ? 
                    AND sp.service_avalability_time >= ?";


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
sp.type_of_business = ?

IF (sp.service_avalability_time >= ?)";