<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="consumerstyle.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                            <select name="desired_service" id="businesstype" required>
    <option value="">Select An Option</option>
    <option value="Groomer">GROOMER</option>
    <option value="Hair_Dresser">Hair Dresser</option>
    <option value="Mower">Lawn Mower</option>
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



