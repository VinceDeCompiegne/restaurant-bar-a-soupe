<?php
    
    // $compteUser = json_decode(urldecode($_GET['compte']),true);
    $compteUser = (isset($_GET['compte']))?json_decode(urldecode($_GET['compte']),true):null;

    if ($compteUser == null){
        echo json_encode(array("errorInfo"=>"NOK"));
        return 0;
    }else if(($compteUser[2] != "admin") &&  ($compteUser[2] != "serveur")){
        echo json_encode(array("errorInfo"=>"Type NOK"));
        return 0; 
    }

    include_once('../../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    $sql = "SELECT COUNT(type) as 'count' FROM user WHERE type=:type AND active=1;";

    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":type"=>$compteUser[2]));
        $row = $pdoStatement->fetch(PDO::FETCH_BOTH);
    } catch (PDOException $err) {
        echo $err->getmessage();
        return 0;
    }
        
    if ((intval($row['count']) < 2)&&intval($compteUser[1])==0) {
        try{
            echo json_encode(array("errorInfo"=>$row['count']));
            return 0;
        }catch(Exception $err){
            echo $err->getMessage();
        }
    }else{  

        /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
        $sql = "UPDATE user SET active = :active WHERE mail=:mail;";
  
        try{
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute(array(":mail"=>$compteUser[0],":active"=>intval($compteUser[1])));
        
        } catch (PDOException $err) {
           echo json_encode($err);
           return 0;
        }
        echo json_encode(array("errorInfo"=>"0"));
    }
?>