<?php



$mail = (!empty($_POST["mail"]))?htmlspecialchars($_POST["mail"]):"";

if ($mail!="") {

    include_once('../inc/constants.inc.php');

   // $user_encode = openssl_encrypt($user, $cipher_algo, $encryption_key);

    //On essaie de se connecter
    try{
        
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $prep = $conn->prepare('SELECT * from user where (mail like :mail);');
        $prep->execute(array(":mail" => $mail));
        $count = $prep->rowCount();

        if ($count == 1) {
            echo "nok";
        }else{

            echo "ok";
        }

    }

        /*On capture les exceptions si une exception est lancée et on affiche
        *les informations relatives à celle-ci*/

    catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

}else{

    echo "nok";

}