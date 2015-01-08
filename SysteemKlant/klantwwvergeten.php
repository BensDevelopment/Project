<!DOCTYPE html>
<!-- Sander van der Stelt, Léyon Courtz, Daan Hagemans -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <div id="menu">
                    <?php 
                        include 'include/php/menu.php'; // Menu wordt hier geladen.
                    ?>
                </div>
            </header>
            <div id="content">
                <h1>Wachtwoord vergeten</h1><br>
            	<form action="klantwwvergeten.php" method="POST">
                	<label>E-mail:</label><br>
                	<input type="text" name="email">
                	<br>
                	<input type="submit" name="wwaanvragen" value="wachtwoord aanvragen">
            	</form>
            	<?php
            	
            	function sha512($password, $unique_salt) {
                	return crypt($password, '$6$20$' . $unique_salt);
            	}
            	function unique_salt() {
                	return substr(sha1(mt_rand()), 0, 22);
            	}
            	
            	include "link.php"; //Connectie wordt het gemaakt.
            	if (isset($_POST['wwaanvragen']))
            	{
                	$email = $_POST['email']; //Hier komt de waarde die ingevuld is door bezoeker
                	
                	$stmt = mysqli_prepare($link, "SELECT first_name,mail FROM user WHERE mail = ?"); //Sql beveiligd tegen injecties.
                	
                	mysqli_stmt_bind_param($stmt, "s", $email);
                	mysqli_stmt_execute($stmt);
                	mysqli_stmt_bind_result($stmt, $first_name, $email); //Voornaam (die correspondeert met de juiste e-mail wordt hier opgehaald.
                	mysqli_stmt_store_result($stmt);
                	
                	$vind = mysqli_stmt_num_rows($stmt);
                	if ($vind) // Als het ingevoerde e-mail adres overeenkomt met de database (aan de hand van de bovenstaande query) gaat hij de funtie(function) in.
                	{
                    	function makepassword($length) //Functie heet makepassword
                    	{
                        	$validCharacters = "abcdefghijklmnopqrstuvwxyz123456789"; //De characters waarmee een wachtwoord wordt gemaakt.
                        	$validCharNumber = strlen($validCharacters); //Hier worden het aantal characters uit de string getelt.
                        	$result = ''; //Resultaat wordt later in de funtie ingevuld.
                        	for ($i = 0; $i < $length; $i++)
                        	{
                            	$result .= $validCharacters[mt_rand(0, $validCharNumber - 1)]; //Willekeuringe selectie wordt hier gemaakt.
                        	}
                        	return $result; //Hier wordt het resultaat terug gegeven.
                    	}
                    	$random_password = makepassword(10); //de variabel krijgt een willekeurige waarde met 10 characters.
                    	$hash = sha512($random_password, $unique_salt);
                    	$final_result = mysqli_query($link, "UPDATE user SET password ='$hash' WHERE mail = '$email' "); //willekeuringe waarde word opgeslagen.
                    	if ($final_result) //Als de willekeurige waarde is gemaakt en opgeslagen...
                    	{
                         	while (mysqli_stmt_fetch($stmt)) { //De naam die correspondeert met het e-mail adres wordt opgezocht.
                             	$naam = $first_name;
                         	}
                        	echo "<p class='succesmelding'>" . "Beste<b> " .$naam. " </b>uw wachtwoord is gewijzigd, <br>bekijk uw e-mail.<br>" . $random_password . "</p>"; //LET OP: $random_password moet er later uit worden gehaald.
                        	/*
                         	* Dit is het mail bericht wat naar de bezoeker wordt gestuurd (local kan niet).
                         	*
                        	$to = $email;
                        	$subject = 'Uw nieuwe wachtwoord';
                        	$message = '
                        	<html>
                        	<head>
                          	<title>Uw wachtwoord is gewijzigd.</title>
                        	</head>
                        	<body>
                          	<p>Beste begruiker uw nieuwe wachtwoord is:<br>'.$random_password.'</p> $random_password wordt in de bovenstaande code opgehaald.
                          	<p>Met vriendelijke groet,<br> Bens Development</p>
                        	</body>
                        	</html>
                        	';
                        	$headers  = 'MIME-Version: 1.0' . "\r\n";
                        	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        	$headers .= 'From: <support@bensdevelopment.nl>' . "\r\n"; //support is de juiste mail van Bens Development.
                        	$headers .= 'Cc:'. $email . "\r\n"; //$email wordt in de bovenstaande code opgehaald.
                        	mail($to, $subject, $message, $headers);*/
                    	}
                	}
                	else
                	{
                    	echo "<p class='foutmelding'>Uw e-mail is niet bekend.</p>"; //Deze melding komt als er geen e-mail adres wordt ingevuld en/of die niet overeenkomt met de database gegevens.
                    	mysqli_stmt_free_result($stmt); // resultset opschonen
                    	mysqli_stmt_close($stmt); // statement opruimen
                    	mysqli_close($link); // verbinding verbreken
                	}
            	}
            	?>
    	</div>
            </div>
        </div>
        <footer>
            <?php 
                include 'include/php/footer.php'; //Footer wordt hier geladen.
            ?>
        </footer>
    </body>
</html>