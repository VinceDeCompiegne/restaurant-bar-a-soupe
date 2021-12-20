<?php
session_start();
// Nettoie les données passées dans POST : htmlspecialchars
$mail = (isset($_POST['mail']) && !empty($_POST['mail'])) ? htmlspecialchars($_POST['mail']) : null;
$pass = (isset($_POST['pass']) && !empty($_POST['pass'])) ? htmlspecialchars($_POST['pass']) : null;
if ($mail == null){
    $mail = (isset($_SESSION['mail']) && !empty($_SESSION['mail'])) ? htmlspecialchars($_SESSION['mail']) : null;
    $pass = (isset($_SESSION['pass']) && !empty($_SESSION['pass'])) ? htmlspecialchars($_SESSION['pass']) : null;
    }

$_SESSION['mail'] = $mail;
$_SESSION['pass'] = $pass;

// Si mail et mot de passe exploitables 
if ($mail && $pass) {
    // Crypte le mail et le mot de passe pour comparaison vs BDD
    //$mail = md5(md5($mail) . strlen($mail));
    //$pass = sha1(md5($mail) . md5($pass));

    // Connexion à BDD
    include_once('inc/Function_login.inc.php');
    try {
        
        if ("admin" == login($mail,$pass)){
            include_once('PageAdmin.php');
            //header("location: PageAdmin.php");
        }else if("serveur" == login($mail,$pass)){
            include_once('pageServeur.php');
        }

    } catch (Exception $err) {
        
        if ($err->getmessage() == "42S02"){

            $mail = "root@root.net";
            $mdp = "motdepasse";

            echo "<table><tbody>";
            echo "<tr>Base inexistante: création de celle-ci en mode démo :   - -</tr>";
            echo "<tr>mail : '".$mail."'    - -   </tr>";
            echo "<tr>mot de passe : '".$mdp."'</tr>";
            echo "</tbody></table>";

            try{
                createBaseLogin($mail,$mdp);
            } catch (Exception $err2) {
                echo $err2->getMessage();
            }

        }else{
            echo $err->getmessage();
        }
    }
} else {
    echo 'Mail ou mot de passe inexploitable!';
}
