<!DOCTYPE html>
<!--
Daan Hagemans
-->
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>Admin Systeem</title> 
        <link href="stijl.css" rel="stylesheet" type="text/css"/> 
    </head> 
    <body> 
        <div id='bovenbalk'> 
            <div id='logo'> 
                <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
            </div> 
            <div id='gebruiker'> 
                <ul id='nav'> 
                    <li><a href='#'> <img src='img/gebruiker.png' style='margin-top: -5px;'> <div id='showname'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admin</div> <img  src='img/pijltje.png' id='pijltje'></a> 
                        <ul> 

                            <li><a href='#'>Klanten</a></li> 
                            <li><a href='#'>Tickets</a></li> 
                            <li><a href='#'>Facturen</a></li> 
                            <li id='uitloggen'><a href='#'>Uitloggen</a></li> 
                        </ul> 
                    </li> 
                </ul> 
            </div> 
        </div> 


        <div id='menu'> 


            <div id='pagina'> 
                <a href='#'>Tickets</a> 
            </div> 


            <div id='module'> 
                <a href='#'>Facturen</a> 
            </div> 


        </div> 


        <div id='content'> 
            <form method="POST" action=""> 


                <?php
                include 'link.php';
                date_default_timezone_set('Europe/Amsterdam');
                echo '<label>Datum: </label>' . date('Y-m-d H:i:s') . '<br>';
                $stmt1 = mysqli_prepare($link, "SELECT company_name FROM Customer");
                mysqli_execute($stmt1);
                mysqli_stmt_bind_result($stmt1, $comp);
                ?> <label>Bedrijfsnaam: </label><select id='Bedrijfsnaam' name='Bedrijfsnaam'> <?php
                    while (mysqli_stmt_fetch($stmt1))
                    {
                        echo" <label><option value='$comp'>$comp</option></label>";
                    }
                    ?> 
                </select></label> <br> 
                <label>Factuur nummer:</label> <input type="text" name="invoicenr" value="<?php if (isset($_POST["submit"]))
                    {
                        echo $_POST["invoicenr"];
                    } ?>"><br> 
                <table> 
                    <tr><th><label>Omschrijving:</label></th><th><label>Aantal:</label></th><th><label>Prijs:</label></th></tr> 
                    <tr><td><input type="text" name="description1" value="<?php if (isset($_POST["submit"]))
                    {
                        echo $_POST["description1"];
                    } ?>"></td><td><input type="text" name="Count1" value="<?php if (isset($_POST["submit"]))
                    {
                        echo $_POST["Count1"];
                    } ?>"></td><td><input type="text" name="Price1" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Price1"];
            } ?>"></td></tr> 
                    <tr><td><input type="text" name="description2" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["description2"];
            } ?>"></td><td><input type="text" name="Count2" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Count2"];
            } ?>"></td><td><input type="text" name="Price2" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Price2"];
            } ?>"></td></tr> 
                    <tr><td><input type="text" name="description3" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["description3"];
            } ?>"></td><td><input type="text" name="Count3" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Count3"];
            } ?>"></td><td><input type="text" name="Price3" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Price3"];
            } ?>"></td></tr> 
                    <tr><td><input type="text" name="description4" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["description4"];
            } ?>"></td><td><input type="text" name="Count4" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Count4"];
            } ?>"></td><td><input type="text" name="Price4" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Price4"];
            } ?>"></td></tr> 
                    <tr><td><input type="text" name="description5" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["description5"];
            } ?>"></td><td><input type="text" name="Count5" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Count5"];
            } ?>"></td><td><input type="text" name="Price5" value="<?php if (isset($_POST["submit"]))
            {
                echo $_POST["Price5"];
            } ?>"></td></tr> 
                </table> 
                <input type="submit" formaction="AdminOverzicht.php" value="terug" name="terug"> 
                <input type="submit" name="submit" value="opslaan" fromaction=""> 
            </form> 
<?php
if (isset($_POST["submit"]))
{
    if ($_POST['invoicenr'] == "")
    {
        echo 'Invoicenummer moet ingevult worden.';
    }
    else
    {
        $invoicenr = $_POST['invoicenr'];
    }
    for ($i = 1; $i <= 5; $i++)
    {
        if ($_POST['description' . $i] == "" && $_POST['Count' . $i] == "" && $_POST['Price' . $i] != "" || $_POST['Price' . $i] == "" && $_POST['Count' . $i] == "" && $_POST['description' . $i] != "" || $_POST['description' . $i] == "" && $_POST['Price' . $i] == "" && $_POST['Count' . $i] != "" || $_POST['description' . $i] == "" && $_POST['Count' . $i] != "" && $_POST['Price' . $i] != "" || $_POST['Count' . $i] == "" && $_POST['description' . $i] != "" && $_POST['Price' . $i] != "" || $_POST['Price' . $i] == "" && $_POST['Count' . $i] != "" && $_POST['description' . $i] != "")
        {
            echo 'Een van uw factuur regels is niet goed ingevuld';
        }
    }
}
?> 
        </div> 
    </body> 
</html> 
