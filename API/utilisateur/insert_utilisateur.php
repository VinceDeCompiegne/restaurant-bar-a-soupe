<?php
    
    // $compteUser = json_decode(urldecode($_GET['compte']),true);
    $compteUser = (isset($_GET['compte']))?json_decode(urldecode($_GET['compte']),true):null;

    if ($compteUser == null){
        echo json_encode(array("errorInfo"=>"NOK"));
        return 0;
    }else if (!filter_var($compteUser[0], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("errorInfo"=>"email NOK"));
        return 0;
    }else if (!is_bool($compteUser[1])) {
        echo json_encode(array("errorInfo"=>"active NOK"));
        return 0;
    }else if(($compteUser[2] != "admin") &&  ($compteUser[2] != "serveur")){
        echo json_encode(array("errorInfo"=>"Type NOK"));
        return 0; 
    }else if(strlen($compteUser[3])<9){
        echo json_encode(array("errorInfo"=>"strlen NOK"));
        return 0;
    }else{

    }

    include_once('../../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
    $sql = "INSERT INTO user (mail,active,type,pass) VALUES (:mail,:active,:type,:pass);";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":mail"=>$compteUser[0],":active"=>$compteUser[1],":type"=>$compteUser[2],":pass"=>$compteUser[3]));
        
    } catch (PDOException $err) {
           echo json_encode($err);
           return 0;
    }
    echo json_encode(array("errorInfo"=>"0"));
?>