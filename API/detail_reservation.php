<?php
$id_reservation = (urldecode($_GET['id_reservation'])!==null) && !empty(urldecode($_GET['id_reservation'])) ? htmlspecialchars(urldecode($_GET['id_reservation'])): null;

if ($id_reservation == null){
    echo json_encode(array("errorInfo"=>"Id Null"));
    return 0;
}else if(is_integer($id_reservation)){
    echo json_encode(array("errorInfo"=>"Id NOK"));
    return 0; 
}

if ($id_reservation != 'null') {
    include_once('../inc/constants.inc.php');
    $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, USER, PASS, $options);

    /*Requete pour savoir si l'utilisateur à déjà fait une commande dans un temps déterminé*/
    $sql = "SELECT reservation_detail.*, description.prix,(reservation_detail.quantite*description.prix) as result FROM reservation_detail join description WHERE reservation_detail.id = :id AND (description.nom = reservation_detail.recette);";
    try{
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":id" => $id_reservation));
        
    } catch (PDOException $err) {
            echo $err->getmessage();
    }
    if ($pdoStatement->rowCount()!=0) {
        $row = $pdoStatement->fetchAll();
        echo json_encode($row,JSON_NUMERIC_CHECK);
    }
}
?>