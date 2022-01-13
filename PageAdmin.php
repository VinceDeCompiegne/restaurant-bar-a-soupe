<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/index.css" rel="stylesheet">
    <script	type="text/javascript" src="assets/js/userChg.js" defer></script>
<?php
include_once('inc/constants.inc.php');
include_once('inc/Function_PageAdmin.inc.php');
// Nettoie les données passées dans POST : htmlspecialchars
$active = null;
$desactive = null;
$supp = null;
$modifier = null;

$mail = (isset($_POST['mail']) && !empty($_POST['mail'])) ? htmlspecialchars($_POST['mail']) : null;
$pass = (isset($_POST['pass']) && !empty($_POST['pass'])) ? htmlspecialchars($_POST['pass']) : null;
$active = (isset($_POST['active']) && !empty($_POST['active'])) ? htmlspecialchars($_POST['active']) : null;
$desactive = (isset($_POST['desactive']) && !empty($_POST['desactive'])) ? htmlspecialchars($_POST['desactive']) : null;

$supprimer = (isset($_POST['supprimer']) && !empty($_POST['supprimer'])) ? htmlspecialchars($_POST['supprimer']) : null;

//$modif_OK = (isset($_POST['modif_OK']) && !empty($_POST['modif_OK'])) ? htmlspecialchars($_POST['modif_OK']) : null;
$energy = (isset($_POST['energy']) && !empty($_POST['energy'])) ? htmlspecialchars($_POST['energy']) : null;
$fibers = (isset($_POST['fibers']) && !empty($_POST['fibers'])) ? htmlspecialchars($_POST['fibers']) : null;
$fruit_percentage = (isset($_POST['fruit_percentage']) && !empty($_POST['fruit_percentage'])) ? htmlspecialchars($_POST['fruit_percentage']) : null;
$proteins = (isset($_POST['proteins']) && !empty($_POST['proteins'])) ? htmlspecialchars($_POST['proteins']) : null;
$saturated_fats = (isset($_POST['saturated_fats']) && !empty($_POST['saturated_fats'])) ? htmlspecialchars($_POST['saturated_fats']) : null;
$sodium = (isset($_POST['sodium']) && !empty($_POST['sodium'])) ? htmlspecialchars($_POST['sodium']) : null;
$sugar = (isset($_POST['sugar']) && !empty($_POST['sugar'])) ? htmlspecialchars($_POST['sugar']) : null;
$description = (isset($_POST['description']) && !empty($_POST['description'])) ? htmlspecialchars($_POST['description']) : null;
$nom = (isset($_POST['nom']) && !empty($_POST['nom'])) ? htmlspecialchars($_POST['nom']) : null;
$aime = (isset($_POST['aime']) && !empty($_POST['aime'])) ? htmlspecialchars($_POST['aime']) : 0;
$prix = (isset($_POST['prix']) && !empty($_POST['prix'])) ? htmlspecialchars($_POST['prix']) : 0;

if ($mail == null){
$mail = (isset($_SESSION['mail']) && !empty($_SESSION['mail'])) ? htmlspecialchars($_SESSION['mail']) : null;
$pass = (isset($_SESSION['pass']) && !empty($_SESSION['pass'])) ? htmlspecialchars($_SESSION['pass']) : null;
}

$_SESSION['mail'] = $mail;
$_SESSION['pass'] = $pass;
$demo = null;
$demo = (isset($_POST['demo']) && !empty($_POST['demo'])) ? htmlspecialchars($_POST['demo']) : 'non';
try {
    modeDemo($demo);
}catch (PDOException $err) {
    echo $err->getMessage();
}
?>
<script	type="text/javascript" src="assets/js/admin/modRecette.js" defer></script>
<script	type="text/javascript" src="assets/js/admin/addRecette.js" defer></script>   
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
                <li><a onclick="fonctionAJAX()">USER</a></li>
                <li><a href="ChgtMotDePasse.html">Mdp</a></li>
            </ul>
        </nav>
    </HEADER>
    <MAIN id="pageAd__dmn">
    <form class="pageAd__frm" action="login.php" method="post">
        <div >
            <div>
                <label id="pageAd__lbl" for="demo">Réinitialisation de la base (ecrire "oui")</label>
                <input id="pageAd__npt" type="text"  name="demo" required>
                <input id="pageAd__sbmt" type="submit" value="Valider" >
            </div>
        </div>
    </form>
    <div heigth="50px"></div>
    <?php

if ($active != null){

        try{
            active($active);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }
 

} elseif ($desactive != null){

        try{
            desactive($desactive);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }  

} elseif ($supprimer != null){

        try{
            supprimer($supprimer);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }  

}


    if ('BaseNok'==tableau()){
        echo 'Base inexitante. Veuillez enclencher le mode Démo';
    }  
        
    ?>
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
                <h4> Vincent Deramaux @ Copyright 2021</h4>
                <div id="debug"></div>
            </div>
        </SECTION>
        </FOOTER>
        <dialog id="mydialogUser" close> 
            <p>Detail</p>
            <div id="detail"></div>  
        </dialog>

        

</body>
</html>