<!DOCTYPE html>
<!-- Jeffrey Hamberg, Joshua van Gelder, Sander van der Stelt-->
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
                <h1>Factuur aanmaken</h1>
            <form method="POST" >

                <?php
                include 'link.php';
                date_default_timezone_set('Europe/Amsterdam');
                echo '<label>Datum: </label>' . date('d-m-Y') . '<br>';
                $date = date('Y-m-d');
                $stmt1 = mysqli_prepare($link, "SELECT company_name FROM Customer");
                mysqli_execute($stmt1);
                mysqli_stmt_bind_result($stmt1, $comp);
                ?> <label>Bedrijfsnaam:</label><select id='Bedrijfsnaam' name='Bedrijfsnaam'> <?php
                    while (mysqli_stmt_fetch($stmt1)) {
                        echo"<option value='$comp'>$comp</option>";
                    }
                    $factuurnr = mysqli_prepare($link, "SELECT MAX(invoice_number) FROM invoice ");
                    mysqli_stmt_bind_result($factuurnr, $var1);
                    mysqli_stmt_execute($factuurnr);
                    ?>
                </select> <br>
                <label>Factuur nummer:</label> <?php
                    while (mysqli_stmt_fetch($factuurnr)) {
                        echo $var1 + 1;
                    }
                    ?>
                <br>
                <table>
                    <tr><th><label>Omschrijving:</label></th><th><label>Aantal:</label></th><th><label>Prijs:</label></th></tr>
                    <tr><td><input type="text" name="description1" value="<?php
                            if (isset($_POST["submit"])) {
                                echo $_POST["description1"];
                            }
                            ?>"></td><td><input type="number" name="Count1" value="<?php
                                if (isset($_POST["submit"])) {
                                    echo $_POST["Count1"];
                                }
                                ?>"></td><td><input type="number" name="Price1" value="<?php
                                       if (isset($_POST["submit"])) {
                                           echo $_POST["Price1"];
                                       }
                                       ?>"></td></tr>
                    <tr><td><input type="text" name="description2" value="<?php
                            if (isset($_POST["submit"])) {
                                echo $_POST["description2"];
                            }
                            ?>"></td><td><input type="number" name="Count2" value="<?php
                                if (isset($_POST["submit"])) {
                                    echo $_POST["Count2"];
                                }
                                ?>"></td><td><input type="number" name="Price2" value="<?php
                                       if (isset($_POST["submit"])) {
                                           echo $_POST["Price2"];
                                       }
                                       ?>"></td></tr>
                    <tr><td><input type="text" name="description3" value="<?php
                            if (isset($_POST["submit"])) {
                                echo $_POST["description3"];
                            }
                            ?>"></td><td><input type="number" name="Count3" value="<?php
                                if (isset($_POST["submit"])) {
                                    echo $_POST["Count3"];
                                }
                                ?>"></td><td><input type="number" name="Price3" value="<?php
                                       if (isset($_POST["submit"])) {
                                           echo $_POST["Price3"];
                                       }
                                       ?>"></td></tr>
                    <tr><td><input type="text" name="description4" value="<?php
                            if (isset($_POST["submit"])) {
                                echo $_POST["description4"];
                            }
                            ?>"></td><td><input type="number" name="Count4" value="<?php
                                if (isset($_POST["submit"])) {
                                    echo $_POST["Count4"];
                                }
                                ?>"></td><td><input type="number" name="Price4" value="<?php
                                       if (isset($_POST["submit"])) {
                                           echo $_POST["Price4"];
                                       }
                                       ?>"></td></tr>
                    <tr><td><input type="text" name="description5" value="<?php
                            if (isset($_POST["submit"])) {
                                echo $_POST["description5"];
                            }
                            ?>"></td><td><input type="number" name="Count5" value="<?php
                                if (isset($_POST["submit"])) {
                                    echo $_POST["Count5"];
                                }
                                ?>"></td><td><input type="number" name="Price5" value="<?php
                                       if (isset($_POST["submit"])) {
                                           echo $_POST["Price5"];
                                       }
                                       ?>"></td></tr>

                    <?php
                    if (isset($_POST["submit"])) {

                        if ($_POST["description1"] == "" && $_POST["Price1"] == "" && $_POST["Count1"] == "") {
                            echo "Begin bij de eerste regel met invullen.";
                        } else {
                            $test1 = 1; // test wordt aangemaakt om te checken of beide tests goed zijn uitgevuld. voornamelijk voor het testen van de code
                            for ($i = 1; $i <= 5; $i++) { // for loop zodat alle regels van de if niet handmatig moeten worden geschreven
                                if ($_POST['description' . $i] == "" && $_POST['Count' . $i] == "" && $_POST['Price' . $i] != "" || $_POST['Price' . $i] == "" && $_POST['Count' . $i] == "" && $_POST['description' . $i] != "" || $_POST['description' . $i] == "" && $_POST['Price' . $i] == "" && $_POST['Count' . $i] != "" || $_POST['description' . $i] == "" && $_POST['Count' . $i] != "" && $_POST['Price' . $i] != "" || $_POST['Count' . $i] == "" && $_POST['description' . $i] != "" && $_POST['Price' . $i] != "" || $_POST['Price' . $i] == "" && $_POST['Count' . $i] != "" && $_POST['description' . $i] != "") {
                                    echo 'factuur regel ' . $i . ' is niet goed ingevuld.<br>';
                                    $test2 = 0;
                                    break 1;
                                } else {
                                    $test2 = 1;
                                }
                            }
                            if ($test1 == 1 && $test2 == 1) {
                                $compname = $_POST['Bedrijfsnaam'];
                                $stmt2 = mysqli_prepare($link, "SELECT customer_id FROM Customer WHERE company_name = '$compname'");
                                mysqli_stmt_bind_result($stmt2, $CID);
                                mysqli_stmt_execute($stmt2);
                                while (mysqli_stmt_fetch($stmt2)) {
                                    $CID = $CID;
                                }
                                $stmt3 = mysqli_prepare($link, "SELECT user_id FROM customer_user WHERE customer_id = $CID");
                                mysqli_stmt_bind_result($stmt3, $UID);
                                mysqli_stmt_execute($stmt3);
                                mysqli_stmt_fetch($stmt3);
                                while (mysqli_stmt_fetch($stmt3)) {
                                    $UID = $UID;
                                }
                                $stmt4 = mysqli_prepare($link, "INSERT INTO Invoice (customer_id, user_id, payment_completed, date) VALUES ($CID,$UID,0,'$date') ");
                                mysqli_stmt_execute($stmt4);
                                $stmt5 = mysqli_prepare($link, "SELECT MAX(invoice_number) FROM invoice");
                                mysqli_stmt_bind_result($stmt5, $Inmr);
                                mysqli_stmt_execute($stmt5);
                                while (mysqli_stmt_fetch($stmt5)) {
                                    $Inmr = $Inmr;
                                }
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($_POST['description' . $i] != "" && $_POST['Count' . $i] != "" && $_POST['Price' . $i] != "") {
                                        $description = $_POST['description' . $i];
                                        $count = $_POST['Count' . $i];
                                        $price = $_POST['Price' . $i];
                                        $statement = mysqli_prepare($link, "INSERT INTO Line (invoice_number, description, amount, price, btw) VALUES ($Inmr,'$description',$count,$price, 21)");
                                        mysqli_stmt_execute($statement);
                                    } else {

                                    }
                                }
                            }
                        }
                    }
                    ?>
                </table>
                <input type="submit" formaction="AdminOverzicht.php" value="terug" name="terug">
                <input type="submit" name="submit" value="opslaan" onclick="this.form.submit">
            </form>
            </div>
                <?php
                include 'footeradmin.php';
                ?>
        </body>       
    </html>
