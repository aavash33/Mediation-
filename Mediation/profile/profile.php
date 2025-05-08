<?php
session_start();
require_once '../dbh.inc.php';

if (!isset($_SESSION['registration_id'])) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT 
                            r.registration_id,
                            r.firstname,
                            r.lastname,
                            r.emailaddress,
                            r.contactnumber,
                            r.status,
                            p.photo_data,
                            p.photo_name 
                          FROM registration r 
                          LEFT JOIN user_photos p ON r.registration_id = p.registration_id 
                          AND p.photo_id = (
                              SELECT MAX(photo_id) 
                              FROM user_photos 
                              WHERE registration_id = r.registration_id
                          )
                          WHERE r.registration_id = ? 
                          AND r.status != 'deleted'");
                          
    $stmt->execute([$_SESSION['registration_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: index.php?error=usernotfound");
        exit();
    }

} catch(PDOException $e) {
    error_log("Profile Error: " . $e->getMessage());
    header("Location: index.php?error=database");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<nav class="navbar">
    <ul class="menu">
        <li class="close-menu">X</li> <!-- Add this line -->
        <li><a href="../index/home.php">HOME</a></li>
        <li><a href="../Serivce_provider_form/index3.php">SERVICE-PROVIDER</a></li>
        <li><a href="../Consumer_form/consumer.php">CONSUMER</a></li>
        <li><a href="profile.php">YOUR PROFILE</a></li>
    </ul>
    <div class="menu-wrapper">
        <span class="ham"></span>
        <span class="ham"></span>
        <span class="ham"></span>
    </div>
</nav>
   
        
        <div class="profile-card">
        <div class="profile-header">
    <div class="profile-image">
        <?php if($user['photo_data']): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($user['photo_data']); ?>" alt="Profile Photo">
        <?php else: ?>
            <img src="images/default-avatar.png" alt="Default Profile Photo">
        <?php endif; ?>
        <form id="photoForm" enctype="multipart/form-data">
            <input type="file" id="photoInput" name="photo" accept="image/*">
            <button type="button" class="select-btn">Select Photo</button>
            <button type="submit" class="upload-btn" style="display: none;">Upload Photo</button>
        </form>
    </div>
</div>
            
            <div class="profile-info">
                <form id="updateForm">
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" id="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" id="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" id="email" value="<?php echo htmlspecialchars($user['emailaddress']); ?>" readonly class="readonly-field">
                    </div>
                    <div class="form-group">
                        <label>Contact:</label>
                        <input type="text" id="contact" value="<?php echo htmlspecialchars($user['contactnumber']); ?>" readonly class="readonly-field">
                    </div>
                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Photo History Section -->
        <div class="photo-history">
            <h3>Photo History</h3>
            <?php
            try {
                $photoStmt = $pdo->prepare("SELECT photo_data, uploaded_at 
                                          FROM user_photos 
                                          WHERE registration_id = ? 
                                          ORDER BY uploaded_at DESC");
                $photoStmt->execute([$_SESSION['registration_id']]);
                $photos = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

                if ($photos) {
                    echo '<div class="photo-grid">';
                    foreach ($photos as $photo) {
                        echo '<div class="photo-item">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($photo['photo_data']) . '" alt="Profile Photo">';
                        echo '<span class="upload-date">' . date('M d, Y', strtotime($photo['uploaded_at'])) . '</span>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>No previous photos found.</p>';
                }
            } catch(PDOException $e) {
                error_log("Photo History Error: " . $e->getMessage());
                echo '<p>Unable to load photo history.</p>';
            }
            ?>
        </div>
    </div>
    <script src="profile.js"></script>
    <button class="logout"><a href="../logout.php" class="logouta">Log Out</a></button>
    <div class="container">


    <script>
        //navbar ham roggle menu js
        document.addEventListener("DOMContentLoaded", () => {
    const menuWrapper = document.querySelector(".menu-wrapper");
    const menu = document.querySelector(".menu");
    const closeMenu = document.querySelector(".close-menu");

    function toggleMenu() {
        menuWrapper.classList.toggle("active");
        menu.classList.toggle("active");
    }

    menuWrapper.addEventListener("click", toggleMenu);
    closeMenu.addEventListener("click", toggleMenu);

    // Close menu when clicking on a menu item
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', toggleMenu);
    });
});


    </script>
</body>
</html>