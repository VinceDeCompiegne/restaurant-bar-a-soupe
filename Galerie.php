<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" defer/>

    
    <title>Restaurant Bar à Soupe</title>
</head>
<body>
    <HEADER>
        <img src="assets/images//Bol_Icon.png" alt="logo restaurant"/>
        <h1>Restaurant Bar à Soupe</h1>
        <nav>
            <ul>
                <li><a href="index.php">Acceuil</a></li>
                <li><a href="Galerie.php">Plats et Menus</a></li>
                <li><a href="Reservation.html">Reservation</a></li>
                <li><a href="Contact.html">Contact</a></li>
            </ul>
        </nav>
    </HEADER>
    <MAIN>
        <H2>Plats et Menus</H2>
        <SECTION id="MENU">
          
  <?php
          session_start();
          $index=1;

          try {
            // Connexion
            include_once('inc/constants.inc.php');
            $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
            // Gestion des attributs de la connexion : exception et retour du SELECT
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Préparation requête : paramétrage pour éviter injections SQL
            $qry = $conn->prepare('SELECT * FROM description where active=1 ORDER BY nom;');
            $qry->execute();
            
            // Si une ligne est trouvée
            if ($qry->rowCount()!=0) {
                    
             
                for($i=0;$i<$qry->rowCount();$i++){
                    $row = $qry->fetch();

                    echo('<article Class="PlatMenu" id="Plat_'.$index.'">
                    </div><img src="https://vincent-deramaux.hd.free.fr/site/restaurant-bar-a-soupe/assets/images/recette/'.$row['image'].'" alt="Photo Principal" style="max-height:400px;max-width:400px;height:100%;width:auto;margin-left:15%;"/>
                    <div class="plat">
                    <H4>'.$row['nom'].'</H4>
                    <H6>'.$row['description'].'</H6>
                    <div class="BoutonGalerie">
                      <div>
                        <FORM NAME="choixPlat'.$index.'" class="Gal__liste">
                          <SELECT NAME="liste" onChange="javascript:selected('.$index.')">
                          <OPTION VALUE="1" SELECTED>1
                          <OPTION VALUE="2">2
                          <OPTION VALUE="3">3
                          <OPTION VALUE="4">4
                          </SELECT>
                          </FORM>
                        <a class="Reserver" href="javascript:checkReserv('.$index.')">
                          <i class="fa fa-square-o" aria-hidden="true">_RESERVATION</i>
                        </a>
                        <a class="coeur" href="javascript:checkAime('.$index.')">
                          <i class="fa fa-heart-o" aria-hidden="true">_Aime</i>
                        </a>
                      </div>
                      <div class="nutriScore"><img class="img" src="assets/images/nutriscore.gif" alt="nutriscore"/>
                </article>');

                $index++;
                }

            } else {
                echo 'Base vide';
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
  ?>

            
        </SECTION>
    </MAIN>
    <FOOTER>
        <SECTION id="PiedDePage">
            <div>  
                    <h3>Contacter Nous</h3>
                    <img src="assets/images//iconfinder_square-facebook.svg" alt="logo Facebook"/>
                    <img src="assets/images//iconfinder_circle-twitter.svg" alt="logo Twitter"/>
                    <img src="assets/images//iconfinder_pinterest.svg" alt="logo Pinterest"/>
            </div>
            <div>
                <h3>© Copyright 2021</h3>
            </div>
        </SECTION>
        </FOOTER>
        <script	type="text/javascript" src="assets/js/Galerie.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/nutri-score/nutriScore.js" defer></script>
    </body>
    </html>