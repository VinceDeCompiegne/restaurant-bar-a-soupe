<?php

function connection(){
    include_once('../inc/constants.inc.php');
    
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);
    return $pdo;
}

function selectReservByIp(){
    $pdo=null;
    $pdo=connection();

    $sql = "SELECT * FROM reservation WHERE (IP = :IP) order by 'id','chck' desc limit 1;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":IP"=> $_SERVER['REMOTE_ADDR']));
        if ($pdoStatement->rowCount()!=0) {
            $row = $pdoStatement->fetch();
            return ($row);
        }else{
            return null;
        }
    } catch (PDOException $err) {
        if ($err->getCode()== "42S02")
        {
            CreateServerTable_reservation();
        }else{
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"CommandeBySpeudo","errorMsg"=>$err->getmessage())));
        }
    }
}

function selectReservBySpeudo($speudo){

    $pdo=connection();

    $sql = "SELECT * FROM reservation WHERE pseudo=:pseudo AND (IP = :IP) order by 'date' desc limit 1;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":pseudo" => $speudo,":IP"=> $_SERVER['REMOTE_ADDR']));
        if ($pdoStatement->rowCount()!=0) {
            $row = $pdoStatement->fetch();
            return ($row);
        }else{
            return null;
        }
    } catch (PDOException $err) {
        if ($err->getCode()== "42S02")
        {
            CreateServerTable_reservation();
        }else{
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"CommandeBySpeudo","errorMsg"=>$err->getmessage())));
        }
    }
}

function selectReservById($id){

    $pdo=connection();

    $sql = "SELECT * FROM reservation WHERE id=:id order by 'date' desc limit 1;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":id" => $id));
        if ($pdoStatement->rowCount()!=0) {
            $row = $pdoStatement->fetchall();
            return ($row);
        }else{
            return null;
        }
    } catch (PDOException $err) {
        if ($err->getCode()== "42S02")
        {
            CreateServerTable_reservation();
        }else{
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"CommandeById","errorMsg"=>$err->getmessage())));
        }
    }
}

function selectReservTimeById($id){

    $pdo=connection();

    $sql = "SELECT (now()-reservation.date) as 'time' FROM reservation WHERE ip=:IP AND chck>=2 order by 'date' desc limit 1;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":IP"=> $_SERVER['REMOTE_ADDR']));
        if ($pdoStatement->rowCount()!=0) {
            $row = $pdoStatement->fetch();
            return ($row['time']);
        }else{
            return -1;
        }
    } catch (PDOException $err) {
        if ($err->getCode()== "42S02")
        {
            CreateServerTable_reservation();
        }else{
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"selectReservTimeById","errorMsg"=>$err->getmessage())));
        }
    }
}

function InsertReservBySpeudo($speudo){

    $pdo=connection();

    $sql = "INSERT INTO reservation (pseudo, IP) VALUES(:pseudo, :IP)";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":pseudo" => $speudo,":IP"=> $_SERVER['REMOTE_ADDR']));
        return 1;
    }catch(PDOException $err){
        echo(json_encode(array("id"=>"","valid"=>"","message"=>"InsertBySpeudo","errorMsg"=>$err->getmessage())));
        return -1;
    }

}

function updateReservSpeudoByID($id,$pseudo){

    $pdo=connection();

    $sql = "UPDATE reservation SET PSEUDO=:pseudo WHERE (ID=:ID) and chck=0;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":pseudo" => $pseudo,":ID"=>$id)); 
        return 1; 
    }catch(PDOException $err){
        
        echo(json_encode(array("id"=>"","valid"=>"","message"=>"updateSpeudoByID","errorMsg"=>$err->getmessage())));
        return -1;
    }

}

function updateReservStatusByID($id,$Status){

    $pdo=connection();

    $sql = "UPDATE reservation SET chck=:chck WHERE (ID=:ID);";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":chck" => $Status,":ID"=>$id));  
    }catch(PDOException $err){
        echo(json_encode(array("id"=>"","valid"=>"","message"=>"updateStatusByID","errorMsg"=>$err->getmessage())));
    }

}

function updateAime($items){
    
    $pdo=connection();

    $sql = "UPDATE description SET aime = (aime + :aime) WHERE (nom=:nom);";
    foreach($items as $item){

        $Aime = ($item['aime']==1)?1:-1;

        try{
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute(array(":aime" => $Aime,":nom"=>$item['nom']));  
        }catch(PDOException $err){
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"updateStatusByID","errorMsg"=>$err->getmessage())));
        }
        
    }
    return 1;
}

function deleteDetailByID($id){

    $pdo=connection();

    $sql = "DELETE FROM reservation_detail WHERE id = :id;";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":id"=>$id));
    } catch (PDOException $err) {
        if ($err->getCode()== "42S02")
        {
            CreateServerTable_reservation_detail();
        }else{
            echo(json_encode(array("id"=>"","valid"=>"","message"=>"DeleteDetailByID","errorMsg"=>$err->getmessage())));
        }
    }

}

function InsertDetailById($response,$id){
    $sql = "insert into reservation_detail (id, recette, quantite) VALUES(:id,:recette,:nombre);";
    
    $pdo=connection();
    
    foreach ($response as $item) {
        try {
       
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->execute(array(":id"=>$id, ":recette" => $item['nom'], ":nombre" => $item['nombre']));

        } catch (Exception $err) {
            if ($err->getCode()== "42S02")
            {
                CreateServerTable_reservation_detail();
            }else{
                echo(json_encode(array("id"=>"","valid"=>"","message"=>"InsertDetailById","errorMsg"=>$err->getmessage())));            
            }
        }
    }
}

function supprimer(String $supprimer)
{
    try {

        $pdo=connection();

        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $pdo->prepare('DELETE FROM reservation WHERE  id=:supp;');
        $qry->execute(array(":supp" => $supprimer));
        $qry = $pdo->prepare('DELETE FROM reservation_detail WHERE id=:supp');
        $qry->execute(array(":supp" => $supprimer));

    } catch (PDOException $err) {
        echo $err->getMessage();
        throw new Exception($err->getMessage());
    }
}

function CreateServerTable_reservation(){

    $pdo=connection();

    // Préparation requête : paramétrage pour éviter injections SQL
    $sql="CREATE TABLE IF NOT EXISTS `reservation` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `IP` varchar(140) NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `pseudo` varchar(16) NOT NULL,
      `chck` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      KEY `id` (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;";
    try{
        $qry = $pdo->prepare($sql);
        $qry->execute();
    }catch(PDOException $err){
        echo(json_encode(array("id"=>"","valid"=>"","message"=>"","errorMsg"=>$err->getmessage()))); 
    }
}
function CreateServerTable_reservation_detail(){

    $pdo=connection();

    // Préparation requête : paramétrage pour éviter injections SQL
    $sql="CREATE TABLE IF NOT EXISTS `reservation_detail` (
        `Ref` bigint(20) NOT NULL AUTO_INCREMENT,
        `id` int(11) NOT NULL,
        `recette` varchar(80) NOT NULL,
        `quantite` int(11) NOT NULL,
        PRIMARY KEY (`Ref`)
      ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
    try{
        $qry = $pdo->prepare($sql);
        $qry->execute();
    }catch(PDOException $err){
        echo(json_encode(array("id"=>"","valid"=>"","message"=>"","errorMsg"=>$err->getmessage()))); 
    }
}

?>