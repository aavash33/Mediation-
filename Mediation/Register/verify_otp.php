<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <header>
        <div class="container1">
            <h1 class="heading">Email Verification</h1>
        </div>
    </header>

    <section>
        <div class="container2">
            <div class="container3">
                <h3>Enter OTP sent to your email:</h3><br>
                <form action="verify_otp.inc.php" method="post">
                    <table cellspacing="20">
                        <tr>
                            <td>
                                <input type="text" required name="otp" placeholder="Enter OTP" maxlength="6">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn1" name="verify">Verify OTP</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>
</body>
</html>