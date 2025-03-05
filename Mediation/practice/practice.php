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
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice</title>
</head>
<body>
<H1>Skills Profile</H1>
  <FORM METHOD="POST" action="practice.inc.php">
  <label for="skills">Skill Set:</label> <br>
  <SELECT NAME="skills[]" SIZE="10" MULTIPLE ID="skills"> 
        <?php echo $select_str; ?> 
  </SELECT> <BR><BR>
</FORM>
</body>
</html>
<!-- SELECT 
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
        sp.type_of_business = 4
        AND  t.available_time >= '2025-01-01 00:00' -->