<?php
$compteUser = json_decode(urldecode($_GET['compte']),true);

if ($compteUser != 'null') {
    include_once('../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
    $sql = "UPDATE 'user' SET pass=:mdp WHERE (mail=:mail);";
    try{
        $pdoStatement = $pdo->prepare($sql);
        
        $mdp = sha1(md5($compteUser['mail']) . md5($compteUser['mdp']));
        $pdoStatement->execute(array(":mail" => $compteUser['mail'],":mdp" => $mdp));
        
    } catch (PDOException $err) {
            echo $err->getmessage();
    }
    if ($pdoStatement->rowCount()!=0) {
        $row = $pdoStatement->fetchAll();
        echo json_encode($row,JSON_NUMERIC_CHECK);
    }
}
?>