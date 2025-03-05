

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0777, true);
}
?>
<!DOCTYPE html>
// ... rest of your existing code ...


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditation Registration</title>
    <style>
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
    </style>
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
                <h3>Enter Your Details:</h3><br>
                
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    echo '<div class="error-message">';
                    switch ($error) {
                        case 'mail':
                            echo "Failed to send verification email. Please try again.";
                            break;
                        case 'database':
                            echo "A database error occurred. Please try again.";
                            break;
                        case 'exists':
                            echo "Email address already registered.";
                            break;
                        case 'invalid':
                            echo "Please fill all required fields correctly.";
                            break;
                        default:
                            echo "An error occurred. Please try again.";
                    }
                    echo '</div>';
                }

                if (isset($_GET['success'])) {
                    echo '<div class="success-message">Registration successful! Please check your email for verification.</div>';
                }
                ?>

                <form action="register.inc.php" method="post">
                    <table cellspacing="20">
                        <!-- ... existing form fields ... -->
                        <tr>
                            <td>
                                <input type="text" required class="fname" name="fname" placeholder="First Name" 
                                       value="<?php echo isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" required name="lname" class="lname" placeholder="Last Name"
                                       value="<?php echo isset($_GET['lname']) ? htmlspecialchars($_GET['lname']) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="email" required name="emailaddress" class="emailadd" placeholder="Email Address"
                                       value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="number" required name="contactnumber" class="contactnumber" placeholder="Contact Number"
                                       value="<?php echo isset($_GET['contact']) ? htmlspecialchars($_GET['contact']) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" required name="userpassword" class="userpassword" placeholder="Password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn1" name="submit">Submit</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>
</body>
</html>