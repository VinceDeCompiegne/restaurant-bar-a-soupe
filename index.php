<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Bar à soupe">
    <meta name="decription" content="site vitrine développé lors de ma formation de concepteur développeur d'application en 2021">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="assets/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" defer/>
    <!-- <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> -->
    <script type="text/javascript" src="assets/js/index.js" defer></script>
    <title>Restaurant Bar à Soupe</title>
</head>
<body>
    <HEADER>
        <img src="assets/images/Bol_Icon.png" alt="logo restaurant"/>
        <h1>Restaurant Bar à Soupe</h1>
        <nav>
            <ul>
                <li><a href="index.php">Acceuil</a></li>
                <li><a href="Galerie.php">Plats et Menus</a></li>
                <li><a href="Reservation.html">Reservation</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="Admin.php" id="btnInscription" data-toggle="modal" data-target="#staticBackdropInscription">Inscription</a></li>
            </ul>
        </nav>
    </HEADER>
    <div style="background-color:brown;text-align:right;heigth:20px;"><?php if (isset($_SESSION['speudo'])){echo '<p style="margin-bottom: 0px;">Bienvenue ' . $_SESSION['speudo'] . ' <a style="color:red;" href="/site/restaurant-bar-a-soupe/logout.php">(logout)</a></p>';}else{echo '<a  href="#" style="cursor:pointer;" id="btnLogin" data-toggle="modal" data-target="#staticBackdrop">login</a>';}; ?></div>
    
    <MAIN>
        <SECTION id="partieHaute">
            <div id="PhotoPrincipal" style="margin-left:auto;">
                <img src="assets/images/restaurant_7.jpg" style="width:80%;height:auto;" alt="Photo Principal"/>
            </div>
        </SECTION>
        <SECTION id="Plat">
            <?php 
                if (isset($_SESSION['speudo'])){echo "<h3>" . $_SESSION['speudo'] . ", vous commandez le plus...</h3>";}else{echo "<h3>Vous aimez...</h3>";}
            ?>            
            <div id="VousAimez">
            <?php
                include_once('inc/constants.inc.php');
    try {
        $uid = isset($_SESSION['uid'])?$_SESSION['uid']:"%";
    // Connexion
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
    // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare("SELECT recette,reservation_detail.id,count(recette) AS 'COUNT' 
        FROM reservation_detail  
        JOIN reservation
        WHERE reservation_detail.id = reservation.id
        AND reservation.uid like :uid
        GROUP BY  recette 
        ORDER BY COUNT(recette) 
        DESC  limit 3;");

        $qry->execute(array("uid"=>$uid));
        // $result = $qry->fetchAll();
        // var_dump($result);

        $pdoStatement = $conn->prepare('SELECT * FROM description where active=1 ORDER BY nom;');
        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll();

        // Si une ligne est trouvée
        if ($qry->rowCount() != 0) {
            
            for ($i = 1; $i <= $qry->rowCount(); $i++) {
                
                    $row = $qry->fetch();

                    $nom=$row["recette"];
                    $index=$row["id"];

                    $image = "Bol_Fumant_M.gif";
                    $count=0;
                    $index=0;
                    foreach($result as $item){
                        $count++;
                        if($item['nom']==$nom){
                            $index=$count;
                            $image=$item["image"];
                        }
                    }
                                      
                    echo  '<article id="Plat'.$i.'">
                    <h4>'.$nom.'</h4>
                    <img src="assets/images/recette/'.$image.'" alt="Photo Plat '.$i.'"/>
                    <form action="Galerie.php#Plat_'.$index.'" method="post">
                    <div><input type="submit" name="ResPlatPromo" value="Commander"></div>
                    </form>
                    </article>';
                
            }

            

        } else {
            echo '<div style="display:flex;"><p style="text-align:center">Aucun j\'aime dans la base de données</p></div>';
        }
?>
        </div>
        <h3 style="margin-top:100px;">Vous liker...</h3> 
        <div id="VousLikez">
        
<?php
        $qry = $conn->prepare("SELECT aime,nom,image FROM description  ORDER BY aime DESC limit 3;");
        $qry->execute();

        if ($qry->rowCount() != 0) {
            
            for ($i = 1; $i <= $qry->rowCount(); $i++) {
                
                    $row = $qry->fetch();

                    $nom=$row["nom"];
                    
                    $image = ($row["image"]==null)?"Bol_Fumant_M.gif":$row["image"];
                     
                    $count=0;
                    $index=0;
                    foreach($result as $item){
                        $count++;
                        if($item['nom']==$nom){
                            $index=$count;
                        }
                    }

                    echo  '<article id="Plat'.($i+3).'">
                    <h4>'.$nom.'</h4>
                    <img src="assets/images/recette/'.$image.'" alt="Photo Plat '.($i+3).'"/>
                    <form action="Galerie.php#Plat_'.$index.'" method="post">
                    <div><input type="submit" name="ResPlatPromo" value="Commander"></div>
                    </form>
                    </article>';
                
            }

    

        } else {
            echo '<div style="display:flex;"><p style="text-align:center">Aucun Like dans la base de données</p></div>';
        }

    } catch (PDOException $err) {
        echo $err->getMessage();
        //return 'BaseNok';
    } 
    ?>
                <!--article id="Plat1">
                    <h4>1er  Plat</h4>
                    <img src="assets/images/Bol_Fumant_M.gif" alt="Photo Plat 1"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlat1" value="Commander"></div>
                    </form>
                </-article>
                <article id="Plat2">
                    <h4>2eme Plat</h4>
                    <img src="assets/images/Bol_Fumant_M.gif" alt="Photo Plat 2"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlat2" value="Commander"></div>
                    </form>
                </article>
                <article-- id="Plat3">
                    <h4>3eme Plat</h4>
                    <img src="assets/images/Bol_Fumant_M.gif" alt="Photo Plat 3"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlat3" value="Commander"></div>
                    </form>
                </article-->
            </div>
  

        </SECTION>
        <SECTION id="PartieBasse">
                <article id="PlatDuJour">
                    <h4>Plat du Jour</h4>
                    <img src="assets/images/Bol_Bientot.png" alt="Bientot"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlatDuJour" value="Commander"></div>
                    </form>
                </article>
                <article id="PromoSemaine">
                    <h4>Promo de la semaine</h4>
                    <img src="assets/images/Bol_Bientot.png" alt="Bientot"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlatPromo" value="Commander"></div>
                    </form>
                </article>
                <article id="TooGoogToGo">
                    <h4>TooGoogToGo</h4>
                    <img src="assets/images/Bol_Bientot.png" alt="Bientot"/>
                    <form action="form.php" method="post">
                        <div><input type="submit" name="ResPlatTooGood" value="Commander"></div>
                    </form>
                </article>
        </SECTION>
        <article id="horaire">
            <h3 class="Hidden">horaire</h3>
            <table class="acceuil__Table">
                <tr class="horaire_Titre"><td>Horaires</td></tr>
                <tr class="horaire_Jour"><td>Du lundi au vendredi</td></tr>
                <tr class="horaire_Jour"><td>Midi</td><td>Soir</td></tr> 
                <tr class="horaire_Heure"><td>12h00-15h00</td><td>19h00-22h00</td></tr>
                <tr class="horaire_Heure"><td>12h00-15h00</td><td>19h00-22h00</td></tr>
                <tr class="horaire_Jour"><td>Samedi et dimanche</td></tr>
                <tr class="horaire_Jour"><td>Matin</td></tr>
                <tr class="horaire_Heure"><td>6h30-8h30</td></tr>
                <tr class="horaire_Jour"><td>Midi</td><td>Soir</td></tr>
                <tr class="horaire_Heure"><td>12h00-15h00</td><td>19h00-23h00</td></tr>
            </table>
        </article>
    </MAIN>
    <FOOTER>
    <SECTION id="PiedDePage">
        <div>  
                <h4>Contacter Nous</h4>
                <img src="assets/images/iconfinder_square-facebook.svg" alt="logo Facebook"/>
                <img src="assets/images/iconfinder_circle-twitter.svg" alt="logo Twitter"/>
                <img src="assets/images/iconfinder_pinterest.svg" alt="logo Pinterest"/>
        </div>
        <div>
            <h3>Vincent Deramaux - 2021</h3>
        </div>
    </SECTION>
    </FOOTER>
        <!-- Modal Login-->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
                        <button type="button" id="btnCloseModal1" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="connexion-form" action="login.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="mail">Identifiant</label>
                                <input type="email" autocomplete ="true" class="form-control" id="mail1" name="mail" required>
                                <p id="mailForm1" style="color:red;font-size:12px;"></p>
                            </div>
                            <div class="form-group">
                                <label for="current-password">Mot de passe</label>
                                <input type="password" autocomplete ="true" class="form-control" id="currentPassword" name="current-password" pattern="[A-Za-z0-9_$]{8,}" required>
                                <p id="currentPasswordForm" style="color:red;font-size:12px;"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnFermer1" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <input type="submit" id="validConnection" value="Se connecter" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Inscription-->
        <div class="modal fade" id="staticBackdropInscription" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Inscription</h5>
                        <button type="button" id="btnCloseModal2" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="contact-form" action="inscription.php" method="post">
                        <div class="modal-body">
                        <div class="form-group">
                                <label for="speudo">Speudo</label>
                                <input type="text" autoComplete ="on" class="form-control" id="speudo" name="speudo" required>
                                <p id="speudoForm" style="color:red;font-size:12px;"></p>
                            </div>
                            <div class="form-group">
                                <label for="mail">mail</label>
                                <input type="email" autoComplete ="on" class="form-control" id="mail2" name="mail" required>
                                <p id="mailForm2" style="color:red;font-size:12px;"></p>
                            </div>
                            <div class="form-group">
                                <label for="current-password">Mot de passe</label>
                                <input type="password" autoComplete ="off" class="form-control" id="newPassword" name="new-password" pattern="[A-Za-z0-9_$]{8,}" required>
                                <p style="font-size:11px;">8 caractéres minimum - Accepte majuscules, minuscules et caractéres spéciaux</p>
                                <p id="newPasswordForm" style="color:red;font-size:12px;"></p>
                            </div>
                            <div class="form-group">
                                <label for="password">Confirmation Mot de Passe</label>
                                <input type="password" autoComplete ="off" class="form-control" id="password" name="password" pattern="[A-Za-z0-9_$]{8,}" required>
                                <p id="passwordForm" style="color:red;font-size:12px;"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnFermer2" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <input type="submit" id="validInscription" value="Se connecter" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>