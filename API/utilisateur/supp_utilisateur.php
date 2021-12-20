<?php

$compteUser = (isset($_GET['compte']))?json_decode(urldecode($_GET['compte']),true):null;

if ($compteUser == null){
    echo json_encode(array("errorInfo"=>"NOK"));
    return 0;
}else if (!filter_var($compteUser[0], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("errorInfo"=>"email NOK"));
    return 0;
}else if(($compteUser[1] != "admin") &&  ($compteUser[1] != "serveur")){
    echo json_encode(array("errorInfo"=>"Type NOK"));
    return 0; 
}else{
    
}

try{
    include_once('../../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);
}catch(Exception $err){
    echo $err->getMessage();
}

$sql = "SELECT COUNT(type) as 'count' FROM user WHERE type=:type;";

try{
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute(array(":type"=>$compteUser[1]));
    $row = $pdoStatement->fetch(PDO::FETCH_BOTH);
} catch (PDOException $err) {
    echo $err->getmessage();
    return 0;
}
    
if (intval($row['count']) < 2){
    try{
        echo json_encode(array("errorInfo"=>$row['count']));
        return 0;
    }catch(Exception $err){
        echo $err->getMessage();
    }
}else{   
        /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
    $sql = "DELETE FROM user WHERE mail=:mail AND type=:type;";

    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":mail"=>$compteUser[0],":type"=>$compteUser[1]));
        
    } catch (PDOException $err) {
        echo $err->getmessage();
        return 0;
    }

    try{
        echo json_encode(array("errorInfo"=>"ok"));
    }catch(Exception $err){
        echo $err->getMessage();
    }
}

?>