<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/index.css" rel="stylesheet">
    <script	type="text/javascript" src="assets/js/detailCmd.js" defer></script>
    <meta http-equiv="refresh" content="30" />
<?php
include_once('inc/constants.inc.php');
include_once('inc/Function_PageServeur.inc.php');

$supprimer = (isset($_POST['supprimer']) && !empty($_POST['supprimer'])) ? htmlspecialchars($_POST['supprimer']) : null;
$check = (isset($_POST['check']) && !empty($_POST['check'])) ? htmlspecialchars($_POST['check']) : null;
$unCheck = (isset($_POST['unCheck']) && !empty($_POST['unCheck'])) ? htmlspecialchars($_POST['unCheck']) : null;
$pret = (isset($_POST['pret']) && !empty($_POST['pret'])) ? htmlspecialchars($_POST['pret']) : null;
$servie = (isset($_POST['servie']) && !empty($_POST['servie'])) ? htmlspecialchars($_POST['servie']) : null;

?>
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
                <li><a href="ChgtMotDePasse.html">Mdp</a></li>
            </ul>
        </nav>
    </HEADER>
    <MAIN id="pageSrv__dmn">
   
    <div heigth="50px"></div>
    
    <?php
    
    if ($supprimer != null){
        try{
            supprimer($supprimer);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }  
    }elseif ($check != null){
        try{
            check($check);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }  
    }elseif ($unCheck != null){
        try{
            unCheck($unCheck);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }  
    }elseif ($pret != null){
        try{
            pret($pret);
        }catch (PDOException $err) {
            echo $err->getMessage();
        }
    }elseif ($servie != null){
        try{
            servie($servie);
        }catch (PDOException $err) {
            echo $err->getMessage();
    }  
}

    if ('BaseNok'==tableau()){
        echo 'Base inexitante.';
    } 
    
    ?>
    
    <script>
    let a = document.getElementsByClassName("pageSrv__frm")[0];
    if (a != null)  {
    a.addEventListener("submit", function(evt)  {
        console.log(evt.submitter.attributes[0].textContent);
          let str = "";  
                switch(evt.submitter.attributes[0].textContent){
                    case 'pageSrv__Chck':
                        str="voulez vous valider la commande ?"
                        break;
                    case 'pageSrv__UnChck':
                        str="voulez vous dé-valider la commande ?"
                        break;
                    case 'pageSrv__Spr':
                        str="voulez vous supprimer la commande ?"
                        break;
                    case 'pageSrv__Srv':
                        str="la commande a t'elle été servie?"
                        break;  
                    };
                if (str!=""){   
                    if(!confirm(str)) {
                        evt.preventDefault();
                    }
                }else{
                    evt.preventDefault();
                }             
            });}
    </script>
    <dialog id="mydialog" close> 
        <p>Detail</p>
        <div id="detail"></div>
		<div class="boutons"><button onclick="functionClose()">Fermer</button> 
	</dialog> 
        </MAIN>
 

    	<style> 
                dialog.boutons{ 
                        width:250px;
                        padding: 10px; 
                        margin-left:auto;
                        margin-right: auto; 
                        
                } 
                dialog{ 
                        width:400px;
                        border-radius: 10px; 
                        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
                        margin-left:auto;
                        margin-right: auto; 
                } 
                dialog::backdrop{ 
                        background-color: rgba(0, 0, 0, 0.6); 
                } 
        </style> 
    <div id="test"></div>
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
                        <div id="debug"></div>
                    </div>
                    <dialog id="mydialogUser" close> 
                        <p>Detail</p>
                        <div id="detail"></div>  
                    </dialog>
                    <dialog id="mydialogPass" close> 
                        <div id="detail_pwd"></div>  
                    </dialog>
                </SECTION>
            </FOOTER>
    </body>
</html>
