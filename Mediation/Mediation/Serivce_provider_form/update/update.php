<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="update.css">
    <title>Update</title>
</head>
<body>
    <header>
        <div class="container1">
            <h1 class="head1">Please Enter the updated Date Below</h1>
        </div>
    </header>

    <section>
        <div class="container2">
            <h1 class="head2">Update Date</h1>
            <!-- FORM -->
            <form action="./update.inc.php" method="post">
                <table cellspacing="40px">
                    <tr>
                        <td>
                            <input type="number" name="service_provider_id" class="service_provider_id" placeholder="Enter Your ID" required>
                        </td>
 
                    <tr>
                        <td>
                            <input type="datetime-local" class="update_date" name="updated_service_availability" required>
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
