<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Daan Hagemans, Sander van der Stelt, Léyon Courtz-->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'YOU DONT BELONG HERE';
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
                <?php
                // Hieronder wordt gechecked welke POST gebruikt moet worden
                include 'link.php';
                if (isset($_POST["Wijzigen"]))
                {
                    $ticket_id = $_POST["ticket_id"];
                    $description = $_POST["Description"];
                    $userid = $_POST["User_ID"];
                    $category = $_POST["categorie"];
                    $CID = $_POST["Customer_ID"];
                    $titel = $_POST["titel"];
                    $insert = mysqli_prepare($link, "UPDATE ticket SET last_time_date=NOW(), description='$description', user_id=$userid, category='$category', customer_id=$CID, title='$titel' WHERE ticket_id=$ticket_id");
                    mysqli_stmt_execute($insert);
                }
                else
                {
                    $ticket_id = $_POST['ticket_id'];
                }
                $stmt1 = mysqli_prepare($link, "SELECT T.customer_id, creation_date, last_time_date, send_date, T.user_id, C.company_name, U.mail, category, description, T.title FROM ticket T JOIN customer C On c.customer_id = T.customer_id JOIN User U ON U.user_id = T.user_id WHERE ticket_id=$ticket_id ");
                mysqli_stmt_bind_result($stmt1, $CID, $creation, $lastchanged, $send, $userid, $compname, $mail, $category, $desc, $titel);
                mysqli_execute($stmt1);
                while (mysqli_stmt_fetch($stmt1))
                {
                    echo"
                <form action='' method='POST'>
                    <label>Klant ID: </label><label><input type='text' value='$CID' name='Customer_ID'></label><br><br>
                    <label>Klant: </label><label>$compname</label><br>
                    <label>Aanmaak Datum: </label><label>$creation</label><br>
                    <label>Laatst Gewijzigd: </label><label>$lastchanged</label><br>
                    <label>Verzonden Hosting: </label><label>$send</label><br>
                    <label>User ID: </label><label><input type='text' value='$userid' name='User ID'></label><br><br>
                    <label>E-mail: </label><label>$mail</label><br>
                        <label>Titel: </label><input type=text name=titel value='$titel'><br>
                    <label>Categorie: </label><select id=''Categorie' name='categorie'>
                    
                            <option value='$category'>$category</option>
                                <option value='cms'>CMS</option>
                                <option value='factuur'>Factuur</option>
                                <option value='hosting'>Hosting</option>
                                <option value='website'>Website</option>
                            
                            
                        </select> <br>
                    <label>Omschrijving: </label><br><textarea rows='4' cols='40' name='Description'>$desc</textarea><br>"
                    . "<input type='hidden' name='ticket_id' value=$ticket_id></label>";
                }
                $stmt2 = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticket_id");
                mysqli_stmt_bind_result($stmt2, $text, $time, $mail);
                mysqli_execute($stmt2);
                echo '<label>Reactie:</label><br>';
                while (mysqli_stmt_fetch($stmt2))
                {
                    echo"
                <br><table class='table_admin'><td class='table_reactie'><span class='datum'>Aan: $mail<br>$time</span><br>$text</td></table>
                <br>";
                }
                ?>
                <input type="submit" name="Wijzigen" value="Wijzigen">
                </form>
                <form action="AdminTicketOverzicht.php">
                    <input type="submit" name="Terug" value="Terug">
                </form>
            </div>
    <?php
    include 'include/php/footeradmin.php';
    ?>
        </body>
    </html>

<?php } ?>
