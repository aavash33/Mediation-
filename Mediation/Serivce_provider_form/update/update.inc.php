<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $service_id = isset($_POST["service_provider_id"]) ? (int) $_POST["service_provider_id"] : null;
    $update_service_availability_time = isset($_POST["updated_service_availability"]) ? trim($_POST["updated_service_availability"]) : null;

    // Check if required fields are provided
    if ($service_id && $update_service_availability_time) {
        try {
            // Include database connection
            require_once "./dbh.inc.php";

            // Prepare the SQL query
            $query1 = "UPDATE serice_provder_table SET updated_service_avalability_time = ? WHERE service_id = ?";

            $stmt = $pdo->prepare($query1);

            $stmt->bindParam(":service_id", $service_id);

            $stmt->bindParam(":updated_service_avalability_time", $updated_service_avalability_time);

            // Execute the query with parameters
            $stmt->execute([$update_service_availability_time, $service_id]);

            // Close the connection
            $stmt = null;
            $pdo = null;

            // Redirect to the index page
            header("Location: ../../index.php");
            exit();
        } catch (PDOException $e) {
            // Log the error and display a generic message
            error_log("Database error: " . $e->getMessage());
            echo "An error occurred while updating the availability. Please try again later.";
        }
    } else {
        // Redirect to the index page if input is missing
        header("Location: ../../index.php");
        exit();
    }
} else {
    // Redirect to the index page if form is not submitted
    header("Location: ../../index.php");
    exit();
}
