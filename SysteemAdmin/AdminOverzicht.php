<!DOCTYPE html>
<!-- Jeffrey Hamberg, Joshua van Gelder-->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'U moet ingelogd zijn om deze pagina te bekijken';
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
            <link href="stijl.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div id='bovenbalk'>
                <div id='logo'>
                    <img src="img/logo-bens.png" alt=""/>
                </div>
                <?php
                include 'menu.php';
                ?>
            </div>
            <div id='content'>                
                <form method="POST" action="AdminKlantOverzicht.php">
                    <input type="submit" name="Klanten Overzicht" value="Klanten Overzicht">
                </form>
                <form method="POST" action="AdminTicketOverzicht.php">
                    <input type="submit" name="Ticket Overzicht" value="Ticket Overzicht">
                </form> 
                <form method="POST" action="Adminfactuuroverzicht.php">
                    <input type="submit" name="Factuur Overzicht" value="Factuur Overzicht">
                </form>         
            </div>
            <div class='push'></div>
            <div id='footer'>
                <div id='footerleft'>Admin Systeem</div>
                <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
            </div>
        </body>       
    </html>
<?php } ?>
