
<?php

    $idModif = (isset($_GET['id_recette']))?json_decode(urldecode($_GET['id_recette']),true):null;

    if ($idModif == null){
        echo json_encode(array("errorInfo"=>"NOK"));
        return 0;
    }else if(!is_integer($idModif)){
        echo json_encode(array("errorInfo"=>"Type NOK"));
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
        $qry = $conn->prepare('SELECT description.id,description.nom,description.prix,recette.energy,recette.fibers,recette.fruit_percentage,recette.proteins,recette.saturated_fats,recette.sodium,recette.sugar,description.description,description.aime,description.image FROM recette INNER JOIN description  WHERE (recette.nom like description.nom) and  description.id=:id;');
        $qry->execute(array(":id" => $idModif));
        $qry->execute();

        if ($qry->rowCount() != 0) {
            $row = $qry->fetch();
            echo json_encode($row);
        }

    } catch (PDOException $err) {
            echo $err->getmessage();
    }

?>