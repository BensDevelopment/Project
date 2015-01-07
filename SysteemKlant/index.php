<!--
Sander van der Stelt.
Dit is de index, dit is hardcode geprogrammeerd.
Bens Development kan dit zelf uitbreiden zoals gewenst tevens geld dit ook voor de overige pagina's.
-->
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
                        include "include/php/menu.php"; 
                    ?>
                </div>
            </header>
            <div id="slider">
                <div class="txt_veld">
                    <h1>CMS met host voor maar €800,- </h1>
                    <input type="submit" value="lees meer">
                </div>
                <div class="img_veld">
                    <img src="afbeeldingen/imac_286x346.png" alt=""/>
                </div>
            </div>
            <div id="content">
                <?php
                ?>
                <h1>Paketten</h1>
                <div id="kolommen">
                    <div class="kol1">
                        <div id="kol_hdr" class="klein">
                            <h1>Hosting klein</h1>
                            <h2>Het pakket voor de starters</h2>
                        </div>
                        <div class="kol_cnt">
                            <p>€ 4,50</p>
                        </div>
                        <div id="kol_tabel" class="t_links">
                            <table>
                                <tr>
                                    <td>Dataverkeer</td>
                                    <td>5 GB</td>
                                </tr>
                                <tr>
                                    <td>Schijfruimte</td>
                                    <td>512 MB</td>
                                </tr>
                                <tr>
                                    <td>Domeinnaam</td>
                                    <td><img src="afbeeldingen/kruis.png" alt=""/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="kol2">
                        <div id="kol_hdr" class="middel">
                            <h1 style="color:white;">Hosting middel</h1>
                            <h2>Het pakket voor een (zeer) interactieve website</h2>
                        </div>
                        <div class="kol_cnt">
                            <p>€ 6,95</p>
                        </div>
                        <div id="kol_tabel" class="t_middel">
                            <table>
                                <tr>
                                    <td>Dataverkeer</td>
                                    <td>10 GB</td>
                                </tr>
                                <tr>
                                    <td>Schijfruimte</td>
                                    <td>1024 MB</td>
                                </tr>
                                <tr>
                                    <td>Domeinnaam</td>
                                    <td><img src="afbeeldingen/vink.png" alt=""/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="kol3">
                        <div id="kol_hdr" class="groot">
                            <h1>Hosting groot</h1>
                            <h2>Het pakket dat geschikt is VOOR EEN WEBSHOP</h2>
                        </div>
                        <div class="kol_cnt">
                            <p>€ 12,50</p>
                        </div>
                        <div id="kol_tabel" class="t_rechts">
                            <table>
                                <tr>
                                    <td>Dataverkeer</td>
                                    <td>30 GB</td>
                                </tr>
                                <tr>
                                    <td>Schijfruimte</td>
                                    <td>3413 MB</td>
                                </tr>
                                <tr>
                                    <td>Domeinnaam</td>
                                    <td><img src="afbeeldingen/vink.png" alt=""/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <?php 
                include 'include/php/footer.php'; 
            ?>
        </footer>
    </body>
</html>

