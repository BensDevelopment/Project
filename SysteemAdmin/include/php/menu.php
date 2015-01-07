<?php
echo ("<div id='gebruiker'>
                <ul id='nav'>
                    <li><a href='#'> <img src='afbeeldingen/gebruiker.png' style='margin-top: -5px;'> <div id='showname'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admin</div> <img  src='afbeeldingen/pijltje.png' id='pijltje'></a>
                        <ul>
                            <li><a href='AdminOverzicht.php'>Home</a></li>
                            <li id='uitloggen'><a href='Adminlogin.php?link=loguit'>Uitloggen</a></li>
                        </ul>
                    </li>
                </ul>
        </div>
        <div id='menu'>
            <div id='klant_menu'>
                <a href='AdminKlantOverzicht.php'>Klantoverzicht</a>
            </div>
            <div id='ticket_menu'>
                <a href='AdminTicketOverzicht.php'>Ticketoverzicht</a>
            </div>
            <div id='factuur_menu'>
                <a href='AdminFactuurOverzicht.php'>Factuuroverzicht</a>
            </div>
        </div>");
?>
