<?php
session_start();
// Nettoie les données passées dans POST : htmlspecialchars
$mail = (isset($_POST['mail']) && !empty($_POST['mail'])) ? htmlspecialchars($_POST['mail']) : null;
$pass = (isset($_POST['current-password']) && !empty($_POST['current-password'])) ? htmlspecialchars($_POST['current-password']) : null;


// Si mail et mot de passe exploitables 
if (($mail != "") && ($pass != "")) {

    $_SESSION['mail'] = $mail;
    $_SESSION['pass'] = $pass;

    // Crypte le mail et le mot de passe pour comparaison vs BDD
    //$mail = md5(md5($mail) . strlen($mail));
    //$pass = sha1(md5($mail) . md5($pass));

    // Connexion à BDD
    include_once('inc/constants.inc.php');

    try{
        
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $prep = $conn->prepare('SELECT * from user where (mail like :mail) and (pass like :pass) ;');
        $prep->execute(array(":mail" => $mail,":pass"=>$pass));
        $count = $prep->rowCount();
        $row = $prep->fetch();

        if ($count == 1) {

            $_SESSION['type'] = $row['type']; 
            $_SESSION['speudo'] =  $row['speudo']; 
            $_SESSION['uid'] =  $row['uid']; 
                         
            if ("admin" == $_SESSION['type']){
                header('Location: /site/restaurant-bar-a-soupe/PageAdmin.php');
                die();
            }else if("serveur" == $_SESSION['type']){
                header('Location: /site/restaurant-bar-a-soupe/pageServeur.php');
                die();
            }else{
                header('Location: /site/restaurant-bar-a-soupe/index.php'); 
                die();
            }

        }else{

            echo "nok";

        }
  
    } catch (Exception $err) {  

            echo $err->getmessage();

    }

} else {

     echo 'nok';

}
