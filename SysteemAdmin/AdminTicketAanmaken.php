<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Sander van der Stelt-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Systeem</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        <div id='bovenbalk'>
            <div id='logo'>
                <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
            </div>
            <?php
            include 'include/php/menu.php';
            ?>
        </div>
        <div id='content'>
            <div id="ticket">
                <h1>Ticket aanmaken</h1>
                <br>
                <?php
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                include "link.php"; // Met deze query wordt de naam en userid van de ingelogde klant opgehaald.
                $userinfo = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userinfo);
                mysqli_stmt_bind_result($userinfo, $login, $fname, $lname);
                while (mysqli_stmt_fetch($userinfo))
                {
                    $login;
                    $fname;
                    $lname;
                }
                mysqli_close($link);

                date_default_timezone_set('CET');
                $datetime = date("Y-m-d H:i:s");  //Met deze functie wordt de datum bepaald.
                ?>
                <p>
                    Admin user: <?php echo "$fname $lname"; ?>
                </p>
                <!-- Bij deze form kan een bestand worden geupload om mee te geven met de ticket -->
                <form method="POST" action="AdminTicketAanmaken.php">
                    Selecteer een bestand om te uploaden:<br><br>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <p>
                        Titel: <input type="text" name="titel">
                    </p>
                    <p>
                        Datum: <?php echo $datetime; ?>
                    </p>
                    <select id="Categorie" name="categorie">
                        <option value="">Selecteer Categorie</option>
                        <option value="website">Website</option>
                        <option value="cms">CMS</option>
                        <option value="hosting">Hosting</option>
                        <option value="Factuur">Factuur</option>
                    </select>
                    <select name="customerid">
                        <?php
                        echo "<option value=''>Selecteer een bedrijf</option>";
                        include "link.php"; // Deze query haald de verschillende bedrijven opgehaald die de ingelogde user heeft.
                        $customer_id = mysqli_prepare($link, "SELECT company_name, customer_id FROM Customer ");
                        mysqli_stmt_execute($customer_id);
                        mysqli_stmt_bind_result($customer_id, $companyname, $customerid);
                        while (mysqli_stmt_fetch($customer_id))
                        {
                            echo "<option value='$customerid'>$companyname</option>";
                        }
                        mysqli_close($link);
                        ?>
                    </select>
                    <br>
                    <br>
                    <textarea name="beschrijving"></textarea>
                    <br>
                    <input type="submit" name="back" value="Terug" formaction="AdminOverzicht.php">
                    <input type="submit" name="verzenden" value="Verzenden">
                </form>


                <!-- text field and button to send text field and cancel button to go back -->
                <?php
                include"link.php";
                if (isset($_POST["verzenden"]))
                { //Deze if loop doet de insert in de tabel ticket. Ook wordt er gekeken of er wel een beschrijving en categorie mee wordt gegeven
                    $description = $_POST["beschrijving"];
                    $category = $_POST["categorie"];
                    $customer = $_POST["customerid"];
                    $creation_date = $datetime;
                    $titel = $_POST["titel"];
                    if ($description == "" || $category == "" || $customer == "")
                    {
                        echo "<p class='foutmelding'>Er is geen categorie en/of beschrijving gegeven.</p>";
                    }
                    else
                    {
                        include"link.php"; //Dit is de insert query waar de nieuwe informatie in de tabel wordt geinsert.
                        $insert = mysqli_prepare($link, "INSERT INTO ticket SET category='$category', creation_date=NOW(), last_time_date='$creation_date', description='$description', customer_id=$customer, user_id=$login, completed_status=0, archived_status=0, title='$titel'");
                        mysqli_stmt_execute($insert);
                        mysqli_close($link);
                        echo "<p class='succesmelding'>Uw ticket is verzonden.</p>";

                        /* !Deze code werkt niet op de local server.!
                          //default headers
                          $headers = "MIME-Version: 1.0" . "\r\n";
                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          //more headers
                          $headers .= 'From: <ticketsysteem@bensdevelopment.nl>' . "\r\n";
                          $headers .= 'Cc: admin@bensdevelopment.nl' . "\r\n";
                          $to="jpjvangelder@gmail.com";
                          $subject="Niewe ticket aangemaakt";
                          $message="Beste, <br><br> er is een niewe ticket aangemaakt met category:$category";
                          mail($to,$subject,$message,$headers); */
                    }
                }
                ?>
            </div>
        </div>
<?php
include 'include/php/footeradmin.php';
?>
    </body>
</html>
<?php ?>
