<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar">
    <ul class="menu">
        <li><a href="home.php">HOME</a></li>
        <li><a href="../Serivce_provider_form/index3.php">SERVICE-PROVIDER</a></li>
        <li><a href="../Consumer_form/consumer.php">CONSUMER</a></li>
        <li> <a href="../index.php" class="inx">Index</a></li>
        <li class="profile-dropdown">
            <a href="#">YOUR PROFILE ▼</a>
            <div class="dropdown-content">
                <a href="../profile/profile.php">Your Profile</a>
                <a href="../logout.php">Logout</a>
            </div>
        </li>
    </ul>
    <div class="menu-wrapper">
    <div class="menu-wrapper">
        <div class="ham-container">
            <span class="ham"></span>
            <span class="ham"></span>
            <span class="ham"></span>
        </div>
        <span class="close-btn">×</span>
    </div>
</nav>
    <header>
        <div class="container1">
            <h1 class="heading">WELCOME TO MEDIATION </h1>
        </div>
        </header>
        <div class="container2">
            <div class="container3">
            <h2>Are you a service provider?</h2><br>
            <h3 class="h31">OR</h3><br>
            <h3 class="h32">Are a Customer</h3><br>
            <div class="container4">
                <button class="btn1"><a href="../Serivce_provider_form/index3.php" class="anchor1">Provider</a></button>
                <button class="btn2"><a href="../Consumer_form/consumer.php" class="anchor2">Consumer</a></button>
                
            </div>
           
        </div>
        </div>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const menuWrapper = document.querySelector(".menu-wrapper");
    const hamContainer = document.querySelector(".ham-container");
    const closeBtn = document.querySelector(".close-btn");
    const menu = document.querySelector(".menu");
    const container1 = document.querySelector(".container1");
    const profileLink = document.querySelector(".profile-dropdown > a");
    
    function toggleMenu() {
        menu.classList.toggle("active");
        menuWrapper.classList.toggle("active");
        container1.style.opacity = menu.classList.contains("active") ? "0" : "1";
        container1.style.visibility = menu.classList.contains("active") ? "hidden" : "visible";
    }

    // Separate event listeners for hamburger and close button
    hamContainer.addEventListener("click", toggleMenu);
    closeBtn.addEventListener("click", toggleMenu);

    // Handle profile dropdown click
    profileLink.addEventListener("click", (e) => {
        if (window.innerWidth <= 650) {
            e.preventDefault();
            const dropdownContent = e.currentTarget.nextElementSibling;
            const allDropdowns = document.querySelectorAll(".dropdown-content");
            
            // Close other dropdowns
            allDropdowns.forEach(dropdown => {
                if (dropdown !== dropdownContent) {
                    dropdown.style.display = "none";
                }
            });

            // Toggle current dropdown
            dropdownContent.style.display = 
                dropdownContent.style.display === "block" ? "none" : "block";
        }
    });
});
        </script>
</body>
</html>