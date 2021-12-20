<?php

    include_once('../../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
    $sql = "SELECT mail,active,type FROM `user`;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();
        
    } catch (PDOException $err) {
            echo $err->getmessage();
    }
    if ($pdoStatement->rowCount()!=0) {
        $row = $pdoStatement->fetchAll();
        echo json_encode($row);
    }

?>