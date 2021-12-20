<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" defer/>
    <link href="assets/css/index.css" rel="stylesheet">
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
                <li><a href="Admin.php" id="btnLogin" data-toggle="modal" data-target="#staticBackdrop">Admin</a></li>
            </ul>
        </nav>

    </HEADER>
    <MAIN>
        <SECTION id="partieHaute">
            <div id="PhotoPrincipal" style="margin-left:auto;">
                <img src="assets/images/restaurant_7.jpg" style="width:80%;height:auto;" alt="Photo Principal"/>
            </div>
        </SECTION>
        <SECTION id="Plat">
            <h3>Vous aimez...</h3>            
            <div id="VousAimez">
            <?php
                include_once('inc/constants.inc.php');
    try {

    // Connexion
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
    // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare("SELECT recette,id,count(recette) AS 'COUNT' FROM reservation_detail  GROUP BY  recette ORDER BY COUNT(recette) DESC  limit 3;");
        $qry->execute();

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
            <h4>© Copyright 2021</h4>
        </div>
    </SECTION>
    </FOOTER>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="login.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="mail">Identifiant</label>
                                <input type="email" class="form-control" id="mail" name="mail" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Mot de passe</label>
                                <input type="password" class="form-control" id="pass" name="pass" pattern="[A-Za-z0-9_$]{8,}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <input type="submit" value="Se connecter" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>