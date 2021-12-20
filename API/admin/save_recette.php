<?php


$param = (isset($_GET['id_recette']))?json_decode(urldecode($_GET['id_recette']),true):null;

if ($param == null){
    echo json_encode(array("errorInfo"=>"NOK"));
    return 0;
}

try{
    include_once('../../inc/constants.inc.php');

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
// Gestion des attributs de la connexion : exception et retour du SELECT
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// Préparation requête : paramétrage pour éviter injections SQL
$qry = $conn->prepare('UPDATE recette JOIN description ON (recette.nom like description.nom) SET 
recette.energy=:energy,
recette.fibers=:fibers,
recette.fruit_percentage=:fruit_percentage,
recette.proteins=:proteins,
recette.saturated_fats=:saturated_fats,
recette.sodium=:sodium,
recette.sugar=:sugar,
recette.nom=:nom
WHERE description.id LIKE :id;');

$qry->execute(array(
':energy'=>$param[':energy'],
':fibers'=>$param[':fibers'] ,
':fruit_percentage'=>$param[':fruit_percentage'],
':proteins'=>$param[':proteins'],
':saturated_fats'=>$param[':saturated_fats'],
':sodium'=>$param[':sodium'],
':sugar'=>$param[':sugar'],
':nom'=>$param[':nom'],
':id'=>$param[':id']));

$qry = $conn->prepare('UPDATE description SET 
aime=:aime,
description=:description,
nom=:nom,
prix=:prix,
image=:image
WHERE id LIKE :id;');

$qry->execute(array(':aime'=>$param[':aime'],':description'=>$param[':description'],':nom'=>$param[':nom'],':prix'=>$param[':prix'],':id'=>$param[':id'],':image'=>$param[':image']));

echo "ok";

} catch (PDOException $err) {

    throw new Exception($err->getMessage());

}

?>