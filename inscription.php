<?php

// Nettoie les données passées dans POST : htmlspecialchars
$speudo = (isset($_POST['speudo']) && !empty($_POST['speudo'])) ? htmlspecialchars($_POST['speudo']) : null;
$mail = (isset($_POST['mail']) && !empty($_POST['mail'])) ? htmlspecialchars($_POST['mail']) : null;
$pass = (isset($_POST['new-password']) && !empty($_POST['new-password'])) ? htmlspecialchars($_POST['new-password']) : null;
$pass2 = (isset($_POST['password']) && !empty($_POST['password'])) ? htmlspecialchars($_POST['password']) : null;

if (($pass !== $pass2) || ($speudo == "")||((!filter_var($mail, FILTER_VALIDATE_EMAIL)))) {
    die;
}


// Si mail et mot de passe exploitables 
if (($mail != "") && ($pass != "")) {
    // Crypte le mail et le mot de passe pour comparaison vs BDD
    //$mail = md5(md5($mail) . strlen($mail));
    //$pass = sha1(md5($mail) . md5($pass));

    // Connexion à BDD
    include_once('inc/Function_login.inc.php');
      try{
        inscription($speudo,$mail,$pass);
      }  catch(PDOException $err){
          echo $err->getMessage();
      }
      header('Location: /site/restaurant-bar-a-soupe/index.php');
} else {

    echo 'Mail ou mot de passe inexploitable!';
}