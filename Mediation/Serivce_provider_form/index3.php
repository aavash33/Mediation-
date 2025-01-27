<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1 class="head1"> WELCOME</h1>
    </header>
    <section>
        <form action="formhandler3.inc.php" method="get" class="form1">
            <div class="container1">
            </div>
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
                    <td colspan="2"><input type="text" name="business_name" placeholder="Enter the business name" class="businessname"></td>
                </tr>
                
            <tr>
                <td><input type="text" name="business_location" placeholder="Business Address"  class="business_location"></td>
            </tr>
            
            <tr>
                <td>
                    <select name="type_of_business" id="businesstype">
                        <option value="">Selecy An Option</option>
                        <option value="Groomer">GROOMER</option>
                        <option value="Hair_Dresser">Hair Dresser</option>
                        <option value="Mower">Lawn Mower</option>
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
                    <input type="datetime-local" name="service_avalablity_time" id="servicetime">
                </td>
            </tr>

            <tr>
                <td><input type="submit" name="submit" id="submit"></td>
            </tr>



            </table>
           
            <a href="./update/update.php" class="Update">Click Here to Update the Avaliability</a>

            </div>







            

        </form>
    </section>
</body>
</html>