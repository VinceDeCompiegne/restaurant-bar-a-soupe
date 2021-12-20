
<?php

$Add = (isset($_GET['id_recette']))?json_decode(urldecode($_GET['id_recette']),true):null;

if ($Add == null){
    echo json_encode(array("errorInfo"=>"NOK"));
    return 0;
}else if($Add[':energy']==null){
    echo json_encode(array("errorInfo"=>"energy"));
    return 0; 
}else if($Add[':fibers']==null){
    echo json_encode(array("errorInfo"=>"fibers"));
    return 0; 
}else if($Add[':fruit_percentage']==null){
    echo json_encode(array("errorInfo"=>"fruit_percentage"));
    return 0; 
}else if($Add[':proteins']==null){
    echo json_encode(array("errorInfo"=>"proteins"));
    return 0; 
}else if($Add[':saturated_fats']==null){
    echo json_encode(array("errorInfo"=>"saturated_fats"));
    return 0; 
}else if($Add[':sodium']==null){
    echo json_encode(array("errorInfo"=>"sodium"));
    return 0; 
}else if($Add[':sugar']==null){
    echo json_encode(array("errorInfo"=>"sugar"));
    return 0; 
}else if($Add[':nom']==null){
    echo json_encode(array("errorInfo"=>"nom"));
    return 0; 
}else if($Add[':prix']==null){
    echo json_encode(array("errorInfo"=>"prix"));
    return 0; 
}else if($Add[':aime']==null){
    echo json_encode(array("errorInfo"=>"aime"));
    return 0; 
}else if($Add[':img']==null){
    echo json_encode(array("errorInfo"=>"img"));
    return 0; 
}else if($Add[':description']==null){
    echo json_encode(array("errorInfo"=>"description"));
    return 0; 
}


try {
    include_once('../../inc/constants.inc.php');
    // Connexion
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
    // Gestion des attributs de la connexion : exception et retour du SELECT
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Préparation requête : paramétrage pour éviter injections SQL
    $sql = "insert into description (nom, description,prix,image,aime) values(:nom, :description,:prix,:img,:aime)";
    $pdoStatement = $conn->prepare($sql);
    try {
        $pdoStatement->execute(array(":nom" => htmlspecialchars($Add[':nom']), ":description" => htmlspecialchars($Add[':description']),":prix" => $Add[':prix'], ":img" => htmlspecialchars($Add[':img']), ":aime" => $Add[':aime'] ));
    } catch (Exception $ex) {

        echo $ex->getMessage();
    }

    $sql = "insert into recette (nom,energy,fibers,fruit_percentage,proteins,saturated_fats,sodium,sugar) values(:nom,:energy,:fibers,:fruit_percentage,:proteins,:saturated_fats,:sodium,:sugar)";
    $pdoStatement = $conn->prepare($sql);
    try {
        $pdoStatement->execute(array(":nom" => htmlspecialchars($Add[':nom']), ':energy' => $Add[':energy'], ':fibers' => $Add[':fibers'], ':fruit_percentage' => $Add[':fruit_percentage'], ':proteins' => $Add[':proteins'], ':saturated_fats' => $Add[':saturated_fats'], ':sodium' => $Add[':sodium'], ':sugar' => $Add[':sugar']));
    } catch (Exception $ex) {

        echo $ex->getMessage();
    }

} catch (PDOException $err) {
    if ($err->getCode()===23000){
        echo json_encode(array("errorInfo"=>($err->getCode())));
        return 0;
    }else{
        echo $err->getmessage();
        return 0;
    }
       
}

echo json_encode(array("errorInfo"=>"OK"));

?>