<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="signin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditation Login</title>
</head>
<body>
    <header>
        <div class="container1">
            <h1 class="heading">WELCOME TO MEDIATION </h1>
        </div>
    </header>

    <section>
        <div class="container2">
            <div class="container3">
                <h1 class="head2">Enter Your Credentials Below</h1>
                <form action="./signin.inc.php" method="post">
                    <table class="table1" cellspacing="15">
                        <tr>
                            <td>
                                <input type="email" name="emailaddress" class="emailaddress" placeholder="Email Address" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="userpassword" id="pwd" placeholder="Enter Your Password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn1" name="submit">Submit</button>
                            </td>
                        </tr>
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<tr><td><p style="color: red;">Invalid email or password</p></td></tr>';
                        }
                        ?>
                        <tr>
                            <td>
                                <marquee behavior="slide" direction="left" class="marqu1">
                                    <a href="../Register/register.php" class="anchor1">Click Here To Register New Account</a>
                                </marquee>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>
</body>
</html>