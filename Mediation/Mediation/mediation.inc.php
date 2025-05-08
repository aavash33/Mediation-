<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['services'])) {
    require_once "./dbh.inc.php";  // Adjust path if needed
    try {
        $selectedServices = $_GET['services'];
        $placeholders = str_repeat('?,', count($selectedServices) - 1) . '?';
        
        $query = "SELECT 
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
        WHERE 
            type_of_business IN ($placeholders)
        ORDER BY 
            created_at DESC
        LIMIT 10";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($selectedServices);
        $filteredProviders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($filteredProviders)) {
            echo "<div class='no-results'>No service providers found for the selected services.</div>";
        } else {
            echo "<style>
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
                .provider-card {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 20px;
                }
                .select-form {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                }
            </style>";

            echo "<div class='results-container'>";
            foreach ($filteredProviders as $provider) {
                echo "<div class='provider-card'>";
                echo "<div class='provider-info'>";
                echo "<h4>" . htmlspecialchars($provider['first_name']) . " " . htmlspecialchars($provider['last_name']) . "</h4>";
                echo "<p><strong>Business Name:</strong> " . htmlspecialchars($provider['business_name']) . "</p>";
                echo "<p><strong>Business Address:</strong> " . htmlspecialchars($provider['business_address']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($provider['business_description']) . "</p>";
                echo "</div>";
                
                echo "<form class='select-form' action='process_selection.php' method='post' onsubmit='return validateForm(this);'>";
                echo "<input type='hidden' name='provider_id' value='" . htmlspecialchars($provider['service_id']) . "'>";
                echo "<input type='hidden' name='provider_email' value='" . htmlspecialchars($provider['email_address']) . "'>";
                echo "<input type='hidden' name='business_name' value='" . htmlspecialchars($provider['business_name']) . "'>";
                echo "<div class='datetime-wrapper'>";
                echo "<input type='datetime-local' name='dateandtime' required min='" . date('Y-m-d\TH:i') . "' />";
                echo "</div>";
                echo "<button type='submit' name='submit' class='select-btn'>Select</button>";
                echo "</form>";
                
                // Add JavaScript validation
                echo "<script>
                function validateForm(form) {
                    var dateTime = form.dateandtime.value;
                    if (!dateTime) {
                        alert('Please select a date and time');
                        return false;
                    }
                    return true;
                }
                </script>";
                
                echo "</div>";
            }
            echo "</div>";
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "<div class='error'>An error occurred while processing your request.</div>";
    }
} else {
    header('Location: index.php');
    exit();
}
?>