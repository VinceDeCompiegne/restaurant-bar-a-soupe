<?php
include_once('inc/constants.inc.php');

function tableau()
{
    try {
        // Connexion
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('SELECT * FROM reservation where (chck!=:chck) ORDER BY id ;');
        $qry->execute(array(":chck"=>"3"));

        // Si une ligne est trouvée
        if ($qry->rowCount() != 0) {

            $string1 = ('<div class="pageSrv__div"><Table class="pageSrv__tbl_dtl" span="1" ><tbody><tr>
            <th>Detail</th>');
            $string2 = ('<form class="pageSrv__frm" action="login.php" method="post">');
            $string2 .= ('<Table class="pageSrv__tbl" span="1" ><tbody><tr>
        <th>ID</th>
        <th>PSEUDO</th>
        <th>Check</th>
        <th>Pret</th>
        <th>Delete</th>
        <th>Served</th></tr>');
            //for ($i = 0; $i < $qry->rowCount(); $i++) {
                while( $row = $qry->fetch()){
                //$row = $qry->fetch();

                
                

                $string1 .= '<tr>';
                $string1 .=  '<td><button id="pageSrv__Dtl" onclick="fonctionAJAX('.$row['id'].',`'.$row['pseudo'].'`);">Detail</button></td>';
                $string1 .= '</tr>';
                            
                $string2 .= '<tr>';
                $string2 .=  '<td>' . $row['id'].'</td>';
                $string2 .=  '<td>' . $row['pseudo'].'</td>';
                if($row['chck']==0){
                    $string2 .=  '<td><button class="pageSrv__Chck" name="check" value="' . $row['id'] . '">unChecked</button></td>';
                }elseif($row['chck']==1){
                    $string2 .=  '<td><button class="pageSrv__UnChck" name="unCheck" value="' . $row['id'] . '">Checked</button></td>';
                }else{
                    $string2 .=  '<td><button class="pageSrv__UnChck" name="unCheck" value="' . $row['id'] .'" disabled>Checked</button></td>';
                }
                if($row['chck']==1){
                    $string2 .=  '<td><button class="pageSrv__Srv" name="pret" value="' . $row['id'] . '" >PRET</button></td>';
                }else{
                    $string2 .=  '<td><button class="pageSrv__Srv" name="pret" value="' . $row['id'] . '" disabled>PRET</button></td>';
                }
                if($row['chck']<2){
                    $string2 .=  '<td><button class="pageSrv__Spr" name="supprimer" value="' . $row['id'] . '" >Delete</button></td>';
                }else{
                    $string2 .=  '<td><button class="pageSrv__Spr" name="supprimer" value="' . $row['id'] . '" disabled>Delete</button></td>';
                }
                if($row['chck']==2){
                    $string2 .=  '<td><button class="pageSrv__Srv" name="servie" value="' . $row['id'] . '" >VALID</button></td>';
                }else{
                    $string2 .=  '<td><button class="pageSrv__Srv" name="servie" value="' . $row['id'] . '" disabled>VALID</button></td>';
                }

                
                    $string2 .=  '<td></td>'; 
                
                $string2 .= '</tr>';
            }

            $string1 .= '</tbody></Table>';
            $string2 .= '</tbody></Table></form></div>';
            
            echo $string1;
            echo $string2;
        } else {
            echo 'Base vide';
        }
        
    } catch (PDOException $err) {
        if ($err->getcode()== "42S02")
        {
            return 'BaseNok';
        }
        echo $err->getmessage();
    }
}

function supprimer(String $supprimer)
{
    try {
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('DELETE FROM reservation WHERE  id=:supp;');
        $qry->execute(array(":supp" => $supprimer));
        $qry = $conn->prepare('DELETE FROM reservation_detail WHERE id=:supp');
        $qry->execute(array(":supp" => $supprimer));
    } catch (PDOException $err) {
        echo $err->getMessage();
        throw new Exception($err->getMessage());
    }
}
function check(String $active)
{
    try {

        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE reservation SET chck=:chck WHERE id=:active;');
        $qry->execute(array(":chck"=>"1",":active" => $active));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}
function unCheck(String $active)
{
    try {

        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE reservation SET chck=:chck WHERE id=:active;');
        $qry->execute(array(":chck"=>"0",":active" => $active));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}

function pret(String $servie)
{
    try {

        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE reservation SET chck=:chck WHERE id=:servie;');
        $qry->execute(array(":chck"=>"2",":servie" => $servie));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}
function servie(String $servie)
{
    try {

        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE reservation SET chck=:chck WHERE id=:servie;');
        $qry->execute(array(":chck"=>"3",":servie" => $servie));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}
?>