<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>                
                <div id="menu">
                    <?php
                    include 'include/php/menubackend.php';
                    ?>
                </div>                
            </header>            
            <div id="content">
                <h1>Ticket aanmaken</h1>
                <br>
                <?php
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];

                include "link.php";
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
                $datetime = date("Y-m-d H:i:s");
                ?>
                <p>
                    Naam: <?php echo "$fname $lname"; ?>
                </p>                
                <form method="POST" action="klantticketaanmaken.php">
                    Selecteer een bestand om te uploaden:
                    <br>
                    <br>
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
                        <option value="factuur">Factuur</option> 
                    </select>
                    <select name="customerid">
                        <?php
                        echo "<option value=''>Selecteer uw bedrijf</option>";
                        include "link.php";
                        $customer_id = mysqli_prepare($link, "SELECT C.company_name, C.customer_id FROM Customer C JOIN Customer_User U ON C.customer_id=U.customer_id WHERE U.user_id=$login");
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
                    <input type="submit" name="verzenden" value="Verzenden">
                </form>
                <form method="POST" action="klantoverzicht.php">
                    <input type="submit" name="annuleren" value="Annuleren">
                </form>

                <?php
                include"link.php";
                if (isset($_POST["verzenden"]))
                {
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
                        include"link.php";                        
                        $insert = mysqli_prepare($link, "INSERT INTO ticket SET category='$category', creation_date=NOW(), last_time_date='$creation_date', description='$description', customer_id=$customer, user_id=$login, completed_status=0, archived_status=0, titel='$titel'");
                        mysqli_stmt_execute($insert);
                        mysqli_close($link);
                        echo "<p class='succesmelding'>Uw ticket is verzonden.</p>";
                        /*
                          $headers = "MIME-Version: 1.0" . "\r\n";
                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers .= 'From: <ticketsysteem@bensdevelopment.nl>' . "\r\n";
                          $headers .= 'Cc: admin@bensdevelopment.nl' . "\r\n";
                          $to = "jpjvangelder@gmail.com";
                          $subject = "Niewe ticket aangemaakt";
                          $message = "Beste, <br><br> er is een niewe ticket aangemaakt met category:$category en titel:$titel";
                          mail($to, $subject, $message, $headers);
                         */
                    }
                }
                ?>
            </div>
        </div>
        <footer>
            <?php 
                include 'include/php/footer.php'; 
            ?>
        </footer>
    </body>
</html>

