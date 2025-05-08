<!-- 
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
?>  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./service.js"></script>
    <link rel="stylesheet" href="style3.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar">
        <ul class="menu">
            <li><a class="a1" href="../index/home.php" >HOME</a></li>
            <li><a class="a2" href="../Serivce_provider_form/index3.php" >SERVICE-PROVIDER</a></li>
            <li><a class="a3" href="../Consumer_form/consumer.php" >CONSUMER</a></li>
            <li><a class="a4" href="../profile/profile.php" >YOUR PROFILE</a></li>
        </ul>
        <div class="menu-wrapper">
            <span class="ham"></span>
            <span class="ham"></span>
            <span class="ham"></span>
        </div>
    </nav>
    <header>
        <h1 class="head1"> WELCOME</h1>
    </header><br><br><br>
    <section>
    <form action="formhandler3.inc.php" method="post" class="form1">
            <div class="container1">
            
            <div class="container2">
            <table class="table1" cellspacing="30px">
                    <h2 class="head2">Enter Your Details Below</h2>
                <tr>
                    
                    <td><input type="text" name="fname" placeholder="First Name" class="input1"></td>
                    
                </tr>

                
               <tr>

               <td><input type="text" name="lname" placeholder="Last Name" class="input2"></td>

               </tr>

               <tr>
                <td><input type="email" name="email_address" placeholder="email address" class="email"></td>
               </tr>

                <tr>
                    <td colspan="2"><input type="text" name="business_name" placeholder="Enter the business name" class="businessname"></td>
                </tr>
                
            <tr>
                <td><input type="text" name="business_location" placeholder="Business Address"  class="business_location"></td>
            </tr>
            
            <tr>
                <td>

                <p>Select the desired Service:</p>
                            <!-- Dropdown for services -->
                            <select name="type_of_business" id="type_of_business" required>
                                <?php echo $select_str; ?>
                            </select>
               
                </td>
            </tr>

                
            <tr>
                <td>
                    <textarea name="business_description" id="description" placeholder="Enter Your Business/Serice Description Here."></textarea>
                </td>
            </tr>

            <tr>
                <td>
                    <h5>Enter you Avaliability</h5>
                    <input type="datetime-local" name="service_avalablity_time" id="servicetime"><br>
                    <button class="add" type="button">Add</button>
                </td>
            </tr>

            <tr>
            <td><input type="submit" name="submit" id="submit" value="Submit"></td>
            </tr>



            </table>
           
            <a href="./update/update.php" class="Update">Click Here to Update the Avaliability</a>

            </div>

            </div>





            

        </form>  <br><br><br><br>
    </section>

</body>
</html>