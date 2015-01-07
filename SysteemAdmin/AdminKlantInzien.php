<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'U moet ingelogd zijn om deze pagina te bekijken.';
    session_unset();
    session_destroy();
}
else
{
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
                <p><?php
                    include "link.php";
                    if(isset($_POST['CID'])){
                        $_SESSION["CID"] = $_POST['CID'];
                    } else {}
                    $customerID = $_SESSION['CID'];
                    echo "<label>Klant ID:</label><label>" . $customerID . "</label>";
                    if ($customerID != "")
                    {
                        $stat = mysqli_prepare($link, "SELECT company_name, street, house_number, postal_code, city, phone_number, fax_number, emailadress, kvk_number, btw_number FROM customer WHERE customer_id = $customerID ");
                        mysqli_stmt_execute($stat);
                        mysqli_stmt_bind_result($stat, $comname, $street, $house, $postal, $city, $phone, $fax, $email, $kvk, $btw);
                        while (mysqli_stmt_fetch($stat))
                        {
                            echo "<br><label>Bedrijfsnaam:</label><label>$comname</label><br><label>Adres:</label><label>" . $street . $house . "</label><br><label>Email:</label><label>$email</label><br><label>Woonplaats:</label><label>$city</label><br><label>Phone:</label><label>$phone</label><br><label>FAX nummer:</label><label>$fax</label><br><label>KVK nummer:</label><label>$kvk</label><br><label>BTW nummer:</label><label>$btw</label>";
                        }
                    }
                    else
                    {
                        echo "customer ID is niet geselecteerd";
                    }

                    mysqli_close($link);
                    ?>
                </p>
                <hr> 
                <?php
            include 'include/php/footeradmin.php';
            ?>
        </body>
    </html>
<?php }
?>
