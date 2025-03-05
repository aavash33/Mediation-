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
    <link rel="stylesheet" href="consumerstyle.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="navbar">
        <ul class="menu">
            <li><a href="../index/home.php" >HOME</a></li>
            <li><a href="../Serivce_provider_form/index3.php" >SERVICE-PROVIDER</a></li>
            <li><a href="../Consumer_form/consumer.php" >CONSUMER</a></li>
            <li><a href="../profile/profile.php" >YOUR PROFILE</a></li>
            
        </ul>
        <div class="menu-wrapper">
            <span class="ham"></span>
            <span class="ham"></span>
            <span class="ham"></span>
        </div>
    </nav>
<header>
        <div class="container1">
            <h1 class="head1">WELCOME</h1>
        </div>
    </header>

    <section>
        <div class="container2">
            <h1 class="head2">PLEASE FILL YOUR DETAILS BELOW</h1>
            <!-- FORM -->
            <form action="consumer.inc.php" method="get">
                <table cellspacing="40px">
                    <tr>
                        <td><p>Enter Your Full Name Below:</p>
                            <input type="text" name="fullname" class="fullname"  required>
                        </td>


                    <tr>
                        <td><p>Enter you Phone Number: </p>
                            <input type="number" name="phonenumber" id="phonenumber">
                       </td>


                    </tr>

                    <tr>
                        <td> <p>Enter your Email Address</p>
                                <input type="email" name="emailaddress" id="emailadd"></td>
                    </tr>

                    <tr>

                        <td>
                        <p>Select the desired Service:</p>
                            <!-- Dropdown for services -->
                            <select name="desired_service" id="businesstype" required>
                                <?php echo $select_str; ?>
                            </select>


                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Enter The location where service is required:</p>
                                <input type="text" class="location" name="location" required>
                            
                        </td>
                    </tr>

                    <tr>
                        <td> <p>Select the date and time service required:</p>
                            <input type="datetime-local" class="required_time" name="required_time" >
                        </td>
                    </tr>
                </table>
                <tr>
                    <input type="submit" name="submit" id="submit">
                </tr>
            </form>
        </div>
    </section>
</body>
</html>



