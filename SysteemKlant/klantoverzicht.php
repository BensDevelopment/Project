<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Overzicht</title>
        <link rel="stylesheet" href="stijl.css" type="text/css"/>
    </head>    
    <body>        
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <div id="menu">
                    <?php
                    include 'menubackend.php';
                    include 'link.php';                    
                    ?>
                </div>
            </header>
            <div id="content">
                <form method="POST" action="klantticketaanmaken.php">
                    <input type="submit" name="ticketmaken" value="Ticket aanmaken">
                </form>
                <form method="POST" action="klantticketoverzicht.php">
                    <input type="submit" name="ticketinzien" value="Tickets inzien">
                </form>                     
                <form method="POST" action="klantfactuuroverzicht.php">
                    <input type="submit" name="klantfactuuroverzicht" value="Factuur Overzicht">
                </form>
                <form method="POST" action="klantoverzicht.php">
                    <input type="submit" name="loguit" value="Uitloggen">
                </form>
                <?php
                if (isset($_POST["loguit"])) // Met deze if loop wordt een gebruiker als offline gezet als hij uitlogt
                {
                    $username = $_SESSION['username'];
                    $password = $_SESSION['password'];
                    $loguit   = mysqli_prepare($link, "UPDATE User SET status='Offline' WHERE mail='$username'");
                    mysqli_stmt_execute($loguit);
                    session_destroy();
                    header("location: klantlogin.php");
                }
                ?>
            </div>                        
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
