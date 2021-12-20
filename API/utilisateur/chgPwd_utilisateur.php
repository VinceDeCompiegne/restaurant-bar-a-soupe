<?php
    
    // $compteUser = json_decode(urldecode($_GET['compte']),true);
    $compteUser = (isset($_GET['compte']))?json_decode(urldecode($_GET['compte']),true):null;

    if ($compteUser == null){
        echo json_encode(array("errorInfo"=>"NOK"));
        return 0;
    }else if(strlen($compteUser[1])<9){
        echo json_encode(array("errorInfo"=>"strlen"));
        return 0;
    }

    include_once('../../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    $sql = "SELECT * FROM user WHERE mail=:mail AND pass=:pass;";

    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":mail"=>$compteUser[0],":pass"=>$compteUser[1]));
        $row = $pdoStatement->fetch(PDO::FETCH_BOTH);
    } catch (PDOException $err) {
        echo $err->getmessage();
        return 0;
    }
    if ($pdoStatement->rowCount()==0) {
        try{
            echo json_encode(array("errorInfo"=>"NOK"));
            return 0;
        }catch(Exception $err){
            echo $err->getMessage();
        }
    }else{  

        /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
        $sql = "UPDATE user SET pass = :passNew WHERE mail=:mail;";
  
        try{
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute(array(":mail"=>$compteUser[0],":passNew"=>$compteUser[2]));
        
        } catch (PDOException $err) {
           echo json_encode($err);
           return 0;
        }

        echo json_encode(array("errorInfo"=>"0"));
        
    }
?>