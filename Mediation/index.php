<?php
$dsn = "mysql:host=localhost;dbname=mediation";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // Fetch services directly into an array
    $query = "SELECT typeofbusiness_id, Nameofthetypeofbusinesses FROM typeofbusiness";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add this new query for recent providers
    $recentQuery = "SELECT 
        service_id,
        first_name,
        last_name,
        email_address,
        business_name,
        business_address,
        type_of_business,
        business_description,
        created_at
    FROM 
        serice_provder_table
    ORDER BY 
        created_at DESC
    LIMIT 10";
    
    $recentStmt = $pdo->prepare($recentQuery);
    $recentStmt->execute();
    $recentProviders = $recentStmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
} finally {
    // Close the database connection
    $stmt = null;
    $pdo = null;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mediation.css">
    <title>Mediation</title>
</head>
<body>
    <nav class="navbar">
        <h1 class="navhead">Mediation
            <input type="search" placeholder="search" class="searchbar">
        </h1>
        <ul class="menu">
            <li><a href="./index/home.php"></a></li>
            <li><a href="./index.php">HOME</a></li>
            <li><a href="./signin/signin.php" class="login">LOG IN</a></li>
        </ul>
        <div class="menu-wrapper">
            <span class="ham"></span>
            <span class="ham"></span>
            <span class="ham"></span>
        </div>
    </nav>

    <!-- Add the sidebar -->
    <div class="sidebar">
        <h3>Services Available</h3>
        <form action="./mediation.inc.php" method="get">
            <?php if (!empty($services)): ?>
                <?php foreach($services as $service): ?> 
                    <div class="service-option">
                        <input type="checkbox" 
                               id="service_<?php echo htmlspecialchars($service['typeofbusiness_id']); ?>" 
                               name="services[]" 
                               value="<?php echo htmlspecialchars($service['typeofbusiness_id']); ?>">
                        <label for="service_<?php echo htmlspecialchars($service['typeofbusiness_id']); ?>">
                            <?php echo htmlspecialchars($service['Nameofthetypeofbusinesses']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="filter-btn">Filter Services</button>
            <?php else: ?>
                <p>No services available</p>
            <?php endif; ?>
        </form>
    </div>

    <div id="results-container">
        <style>
      .provider-card {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    width: calc(100% - 40px);
    background: #fff;
}

.provider-info {
    flex: 1;
    margin-right: 20px;
}

.select-btn {
    background: #852626;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.select-btn:hover {
    background: #6a1f1f;
}

.select-form {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.datetime-wrapper input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 200px;
}
        </style>

        <?php if (!empty($recentProviders)): ?>
            <?php foreach($recentProviders as $provider): ?>
                <div class="provider-card">
                    <div class="provider-info">
                        <h4><?php echo htmlspecialchars($provider['first_name']) . " " . htmlspecialchars($provider['last_name']); ?></h4>
                        <p><strong>Business Name:</strong> <?php echo htmlspecialchars($provider['business_name']); ?></p>
                        <p><strong>Business Address:</strong> <?php echo htmlspecialchars($provider['business_address']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($provider['business_description']); ?></p>
                    </div>
                    
                    <form class="select-form" action="process_selection.php" method="post" onsubmit="return validateForm(this);">
                        <input type="hidden" name="provider_id" value="<?php echo htmlspecialchars($provider['service_id']); ?>">
                        <input type="hidden" name="provider_email" value="<?php echo htmlspecialchars($provider['email_address']); ?>">
                        <input type="hidden" name="business_name" value="<?php echo htmlspecialchars($provider['business_name']); ?>">
                        <div class="datetime-wrapper">
                            <input type="datetime-local" name="dateandtime" required min="<?php echo date('Y-m-d\TH:i'); ?>" />
                        </div>
                        <button type="submit" name="submit" class="select-btn">Select</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <script>
            function validateForm(form) {
                var dateTime = form.dateandtime.value;
                if (!dateTime) {
                    alert('Please select a date and time');
                    return false;
                }
                return true;
            }
            </script>
        <?php else: ?>
            <p>No service providers available</p>
        <?php endif; ?>
    </div>
</body>
</html>