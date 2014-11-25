<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <!--BEGIN MENU-->
                <div id="menu">
                    <?php
                    include 'menu.php';
                    ?>
                </div>
                <!--EINDE MENU-->
            </header>
            <!--BEGIN CONTENT-->
            <div id="content">
                <h1>Ticket aanmaken</h1>
                <?php
                include "link.php";
                $customerID = 1; //name or Id of the customer
                date_default_timezone_set('CET');
                $datetime = date("F j, Y");  //function to get date and ti
                $TicketID = $TicketIDcount + 1; //Counting the number of tickets in the database and gives the ticket a uniek ID
                ?>
                <form method="GET" action="AdminTicketAanmaken.php">
                    <p> Naam Klant: <?php print ($Fname . " " . $lname); ?> </p>
                    <br>
                    Klant ID: <?php print ($customerID); ?>
                    <br><!-- dropdown menu -->         
                    <p> 
                        E-mail klant: <?php print ($mail); ?> 
                    </p>
                    <!--<form method="POST" action="">
                        <input type="submit" name="BestandUploaden" value="Bestand Uploaden">
                    </form> -->                  
                    <p> 
                        Datum: <?php print($datetime); ?> 
                    </p>
                    <select id="Categorie" name="Categorie">
                        <option value="">Selecteer Categorie</option>
                        <option value="Webapplication">Webapplication</option>
                        <option value="Internetsite">Internetsite</option>
                        <option value="Hosting">Hosting</option>
                    </select>
                    <p> Beschrijving:</p><p>TicketID: <?php print($TicketID); ?></p>
                    <textarea name="Beschrijving"></textarea><br>
                    <input type="submit" name="Verzenden" value="Verzenden">
                </form>
                <form method="GET" action="AdminKlantOverzicht.php">
                    <input type="submit" name="Annuleren" value="Annuleren">
                </form><!-- text field and button to send text field and cancel button to go back -->            
                <?php
                if (isset($_GET["Verzenden"])) {
                    $description = $_GET["Beschrijving"];
                    $category = $_GET["Categorie"];
                    if ($description == "" || $category == "") {
                        print ("Er is geen categorie en/of beschrijving gegeven.");
                    } else {
                        print("Beschrijving = ".$description . "<br>");
                        print("Categorie = ".$category . "<br>");
                    }
                     //$stat = mysqli_prepare($link, "INSERT INTO ticket VALUES (?,?,?,?,?,?,?,?,?, ?)");
                     //mysqli_stmt_bind_param($stat, "sssssssss", $TicketID, $category, $datetime, $datetime, $description, $datetime, $customerID, 0, 0, Nill);
                     //mysqli_stmt_execute($stat);            
                }
                ?>
            </div>
            <!--EINDE CONTENT-->
            <footer>
                <p class="copyright">Copyright © 2014 <b>Bens Development</b>, All Right Reserved.</p>
            </footer>
        </div>
    </body>
</html>

