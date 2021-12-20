<?php

$nom = (isset($_GET['nom']) && !empty($_GET['nom'])) ? htmlspecialchars($_GET['nom']) : null;

if ($nom == null){
    echo json_encode(array("errorInfo"=>"nom Null"));
    return 0;
}

if ($nom != null)
{
    include_once('../inc/constants.inc.php');
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
    // Gestion des attributs de la connexion : exception et retour du SELECT
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Préparation requête : paramétrage pour éviter injections SQL

    if ($nom != "all"){
          
        try {
            // Connexion

            $qry = $conn->prepare('SELECT recette.nom,recette.energy,recette.fibers,recette.fruit_percentage,recette.proteins,recette.saturated_fats,recette.sodium,recette.sugar FROM recette INNER JOIN description WHERE (recette.nom like description.nom) and recette.nom = :nom;');
            $qry->execute(array(":nom" => $nom));

            $row = $qry->fetch();
            echo json_encode($row,JSON_NUMERIC_CHECK);
            //var_dump($row);

        } catch (PDOException $err) {
            echo 'BaseNok';
        }
    }else{

        try {
            // Connexion

            $qry = $conn->prepare('SELECT recette.nom,recette.energy,recette.fibers,recette.fruit_percentage,recette.proteins,recette.saturated_fats,recette.sodium,recette.sugar,description.image FROM recette INNER JOIN description WHERE (recette.nom like description.nom) AND description.active = 1 ORDER BY recette.nom;');
            $qry->execute();

            $row = $qry->fetchAll();
            echo json_encode($row,JSON_NUMERIC_CHECK);
           // var_dump($row);

        } catch (PDOException $err) {
            echo 'BaseNok';
        }

    }
}

?>