<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Daan Hagemans-->
<?php
session_start();
if ($_SESSION["login"] != 1) {
    echo 'YOU DONT BELONG HERE';
    session_unset();
    session_destroy();
} else {
    include 'link.php';
    if (isset($_POST["wijzigen"])) {
        $query = mysqli_prepare($link, 'INSERT INTO ticket (customer_id, creation_date, last_time_date, send_date, user_id, description ) VALUES (?,?,?,?,?,?)');
        mysqli_stmt_bind_param($query, 'isssis', $CID, $creation, $lastchange, $send, $user_id, $desc);
        $CID=$_POST["Customer_ID"];
        $creation=$_POST["Creation Date"];
        $lastchange=$_POST["Last Changed Date"];
        $send=$_POST["Send Date to Hosting"];
        $user_id=$_POST["User ID"];
        $desc=$_POST["Description"];
    } else {
        
    }
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
                    <img src="img/logo-bens.png" alt="">
                </div>
                <?php
                include 'menu.php';
                ?>
            </div>
            <div id='content'>
                <?php
                include 'link.php';
                foreach ($_POST["close/wijzig"] AS $ticketid => $notused) {
                    $ticket_id = $ticketid;
                }
                $stmt1 = mysqli_prepare($link, "SELECT customer_id, creation_date, last_change_date, send_date, user_id, category C.company_name, U.mail, description FROM ticket T JOIN customer C On c.customer_id = T.customer_id JOIN User U ON U.user_id = T.user_id WHERE ticket_id=$ticket_id ");
                mysqli_stmt_bind_result($stmt1, $CID, $creation, $lastchange, $send, $userid, $comp, $mail, $category, $desc);
                mysqli_stmt_execute($stmt1);
                while (mysqli_stmt_fetch($stmt1)) {

                    echo "
                <form action='' method='POST'>
                    <input type='text' value='$CID' name='Customer_ID'>
                    Klant: $comp
                    <input type='text' value='$creation' name='Creation Date'> 
                    <input type='text' value='$lastchange' name='Last Changed Date'> 
                    <input type='text' value='$send' name='Send Date to Hosting'> 
                    <input type='text' value='$userid' name='User ID'> 
                    Mail: $mail
                    <select id='Categorie' name='categorie'>
                            <option value='$category'><?php echo $category; ?></option>
                            <option value='website'>Website</option>
                            <option value='cms'>CMS</option>
                            <option value='hosting'>Hosting</option>
                        </select>
                    <textarea cols='4' name='Description'>$desc</textarea>";
                } $stmt2 = mysqli_prepare($link, "SELECT TIME, TEXT, U.mail reaction_id FROM reaction R JOIN User U ON U.user_id = R.user_ID JOIN Ticket T ON T.ticket_id = R.ticket_id WHERE R.ticket_id = $ticket_id");
                mysqli_stmt_bind_result($stmt1, $time, $text, $mail, $reaction_id);
                mysqli_stmt_execute($stmt1);
                while (mysqli_stmt_fetch($stmt1)) {

                    echo"
                    <textarea cols='4' name='Reaction[$reaction_id]'>$mail: $text  -$time</textarea>
                    <input type='submit' name='wijzigen' value='wijzigen' formaction=''>";
                }
                ?>
            </form>
            <div class='push'></div>
            <div id='footer'>
                <div id='footerleft'>Admin Systeem</div>

                <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
            </div>
    </body>
    </html>

<?php } ?>