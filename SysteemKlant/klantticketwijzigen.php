<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
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
                    include 'menubackend.php';
                    ?>
                </div>
                <!--EINDE MENU-->
            </header>
            <!--BEGIN CONTENT-->
            <div id="content">
                <h1>Ticket wijzigen</h1>
                <?php                
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                if (isset($_POST["verzenden"]))
                {
                    $tidarray = $_POST['tid'];
                    foreach ($tidarray as $t => $notused)
                    {
                        $ticketid = $t;
                    }
                    echo $ticketid;
                }
                else
                {
                    $ticketidarray = $_POST["ticketid"];
                    foreach ($ticketidarray as $ticket => $notused)
                    {
                        $ticketid = $ticket;
                    }
                }
                include "link.php";
                $loginQuery = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($loginQuery);
                mysqli_stmt_bind_result($loginQuery, $userid, $fname, $lname);
                while (mysqli_stmt_fetch($loginQuery))
                {
                    $userid;
                    $fname;
                    $lname;
                }
                mysqli_close($link);

                include "link.php";
                $GetDescription = mysqli_prepare($link, "SELECT ticket_id, description, category FROM Ticket WHERE ticket_id=$ticketid");
                mysqli_stmt_execute($GetDescription);
                mysqli_stmt_bind_result($GetDescription, $tid, $description, $category);
                while (mysqli_stmt_fetch($GetDescription))
                {
                    $tid;
                    $description;
                    $category;
                }
                mysqli_close($link);

                date_default_timezone_set('CET');
                $datetime = date("Y-m-d H:i:s");  //function to get date and time                
                ?>                
                <p> 
                    Naam: <?php echo "$fname $lname"; ?> 
                </p>                                                            
                <!--<form method="POST" action="">
                    <input type="submit" name="BestandUploaden" value="Bestand Uploaden">
                </form> -->                  
                <p> 
                    Datum: <?php echo $datetime; ?>                
                </p>                
                <form method="POST" action="klantticketwijzigen.php">
                    <p>
                        <select id="Categorie" name="categorie">
                            <option value="<?php echo "$category" ?>"><?php echo "$category" ?></option>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt, Léyon Courtz -->
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
                    include 'menubackend.php';
                    ?>
                </div>
                <!--EINDE MENU-->
            </header>
            <!--BEGIN CONTENT-->
            <div id="content">
                <h1>Ticket wijzigen</h1>
                <?php                
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                if (isset($_POST["verzenden"]))
                {
                    $tidarray = $_POST['tid'];
                    foreach ($tidarray as $t => $notused)
                    {
                        $ticketid = $t;
                    }
                    echo $ticketid;
                }
                else
                {
                    $ticketidarray = $_POST["ticketid"];
                    foreach ($ticketidarray as $ticket => $notused)
                    {
                        $ticketid = $ticket;
                    }
                }
                include "link.php";
                $loginQuery = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($loginQuery);
                mysqli_stmt_bind_result($loginQuery, $userid, $fname, $lname);
                while (mysqli_stmt_fetch($loginQuery))
                {
                    $userid;
                    $fname;
                    $lname;
                }
                mysqli_close($link);

                include "link.php";
                $GetDescription = mysqli_prepare($link, "SELECT ticket_id, description, category FROM Ticket WHERE ticket_id=$ticketid");
                mysqli_stmt_execute($GetDescription);
                mysqli_stmt_bind_result($GetDescription, $tid, $description, $category);
                while (mysqli_stmt_fetch($GetDescription))
                {
                    $tid;
                    $description;
                    $category;
                }
                mysqli_close($link);

                date_default_timezone_set('CET');
                $datetime = date("Y-m-d H:i:s");  //function to get date and time                
                ?>                
                <p> 
                    Naam: <?php echo "$fname $lname"; ?> 
                </p>                                                            
                <!--<form method="POST" action="">
                    <input type="submit" name="BestandUploaden" value="Bestand Uploaden">
                </form> -->                  
                <p> 
                    Datum: <?php echo $datetime; ?>                
                </p>                
                <form method="POST" action="klantticketwijzigen.php">
                    <p>
                        <select id="Categorie" name="categorie">
                            <option value=""></option>
                            <option value="website">Website</option>
                            <option value="cms">CMS</option>
                            <option value="hosting">Hosting</option>
                        </select>                                                            
                    </p>                    
                    <textarea name="beschrijving"><?php echo "$description" ?></textarea>
                    <br>
                    <input type="hidden" <?php echo 'name="tid[' . $tid . ']"' ?>>
                    <input type="submit" name="verzenden" value="Verzenden">                    
                </form>
                <form method="POST" action="klantticketoverzicht.php">
                    <input type="submit" name="annuleren" value="Annuleren"> 
                </form>

                <!-- text field and button to send text field and cancel button to go back -->            
                <?php
                if (isset($_POST["verzenden"]))//Met deze if loop wordt de ticket geupdate. Ook wordt er gekeken of de huidige categorie en text veld wel volledig zijn meegegeven.
                {
                    $description = $_POST["beschrijving"];
                    $category = $_POST["categorie"];
                    $creation_date = $datetime;
                    if ($description == "" || $category == "")
                    {
                        echo "<p class='foutmelding'>Er is geen categorie en/of beschrijving gegeven.</p>";
                    }
                    else
                    {
                        include"link.php";
                        $insert = mysqli_prepare($link, "UPDATE ticket SET last_time_date=NOW(), description='$description', category='$category' WHERE ticket_id=$ticketid");
                        mysqli_stmt_execute($insert);
                        mysqli_close($link);

                        echo "<p class='succesmelding'>Uw ticket is verzonden.</p>";
                        header("location: klantticketoverzicht.php");

                        /* Deze code werkt niet op de local server.
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
            <!--EINDE CONTENT-->
        </div>
        <footer>
<?php include 'footer.php'; ?>
        </footer>
    </body>
</html>

