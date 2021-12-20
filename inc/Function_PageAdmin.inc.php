<?php
include_once('inc/constants.inc.php');


function modeDemo(string $demo = '')
{
    if (strtoupper($demo) == 'OUI') {

        $dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATA;
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $pdo = new PDO($dsn, USER, PASS, $options);
        include_once('inc/recette.inc.php');

        $sql = "CREATE DATABASE IF NOT EXISTS `barrestsoupe` DEFAULT CHARACTER SET utf8;
            USE `barrestsoupe`;
            DROP TABLE IF EXISTS `description`;
            CREATE TABLE IF NOT EXISTS `description` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `nom` varchar(80) CHARACTER SET utf8 NOT NULL,
              `description` varchar(1024) CHARACTER SET utf8 NOT NULL,
              `prix` float NOT NULL DEFAULT '0' COMMENT '€',
              `image` varchar(80) NOT NULL,
              `active` tinyint(1) NOT NULL DEFAULT '1',
              `aime` bigint(1) DEFAULT '0',
              PRIMARY KEY (`id`),
              UNIQUE KEY `nom` (`nom`),
              UNIQUE KEY `id` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            COMMIT;";
        $pdoStatement = $pdo->prepare($sql);
        try {
            $pdoStatement->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        foreach ($recette as $item) {
            $sql = "insert into description (nom, description,prix,image,aime) values(:nom, :description,:prix,:img,:aime)";
            $pdoStatement = $pdo->prepare($sql);
            try {
                $pdoStatement->execute(array(":nom" => $item['fname'], ":description" => $item['txt'],":prix" => $item['prix'], ":img" => $item['image'], ":aime" => $item['aime'] ));
            } catch (Exception $ex) {

                echo $ex->getMessage();
            }
        }

        $sql = "USE `barrestsoupe`;
        DROP TABLE IF EXISTS `recette`;
        CREATE TABLE IF NOT EXISTS `recette` (
          `nom` varchar(80) CHARACTER SET utf8 NOT NULL,
          `energy` int(11) NOT NULL COMMENT 'KJ',
          `fibers` int(11) NOT NULL COMMENT 'g',
          `fruit_percentage` int(11) NOT NULL COMMENT '%',
          `proteins` int(11) NOT NULL COMMENT 'g',
          `saturated_fats` int(11) NOT NULL COMMENT 'g',
          `sodium` int(11) NOT NULL COMMENT 'mg',
          `sugar` int(11) NOT NULL COMMENT 'g',
          UNIQUE KEY `nom` (`nom`)
          
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        COMMIT;";
    $pdoStatement = $pdo->prepare($sql);
    try {
        $pdoStatement->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

        foreach ($recette as $item) {
            $sql = "insert into recette (nom,energy,fibers,fruit_percentage,proteins,saturated_fats,sodium,sugar) values(:nom,:energy,:fibers,:fruit_percentage,:proteins,:saturated_fats,:sodium,:sugar)";
            $pdoStatement = $pdo->prepare($sql);
            try {
                $pdoStatement->execute(array(":nom" => $item['fname'], ':energy' => $item['nutriscore']['energy'], ':fibers' => $item['nutriscore']['fibers'], ':fruit_percentage' => $item['nutriscore']['fruit_percentage'], ':proteins' => $item['nutriscore']['proteins'], ':saturated_fats' => $item['nutriscore']['saturated_fats'], ':sodium' => $item['nutriscore']['sodium'], ':sugar' => $item['nutriscore']['sugar']));
            } catch (Exception $ex) {

                echo $ex->getMessage();
            }
        }
    }
}
function active(String $active)
{
    try {

        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE description SET active = "1" WHERE id=:active');
        $qry->execute(array(":active" => $active));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}

function desactive(String $desactive)
{
    try {
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('UPDATE description SET active = "0" WHERE id=:desactive');
        $qry->execute(array(":desactive" => $desactive));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
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
        $qry = $conn->prepare('DELETE FROM recette USING recette  JOIN description ON (recette.nom like description.nom) WHERE  description.id=:supp;');
        $qry->execute(array(":supp" => $supprimer));
        $qry = $conn->prepare('DELETE FROM description WHERE id=:supp');
        $qry->execute(array(":supp" => $supprimer));
    } catch (PDOException $err) {

        throw new Exception($err->getMessage());
    }
}

function tableau()
{
    try {
        // Connexion
        $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
        // Gestion des attributs de la connexion : exception et retour du SELECT
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Préparation requête : paramétrage pour éviter injections SQL
        $qry = $conn->prepare('SELECT * FROM description ORDER BY nom;');
        $qry->execute();

        // Si une ligne est trouvée
        if ($qry->rowCount() != 0) {
            
            echo '<div class="pageAd__tbl_cntnr">';
            
            $string1 = '<Table width="100px" ><tbody><tr><th>Nom de recette</th></tr>';

            $string2 ='<form  action="login.php" method="post">';
            $string2 .= '<Table  style="width:50px;"><tbody><tr><th>activer</th></tr>';

            $string3 ='<form  action="login.php" method="post">';
            $string3 .= '<Table  style="width:50px;"><tbody><tr><th>supprimer</th></tr>';

            $string4 = '<td><Table  style="width:50px;"><tbody><tr><th>modifier</th></tr>';

            for ($i = 0; $i < $qry->rowCount(); $i++) {
                $row = $qry->fetch();
                $string1 .=  '<tr><td ><p style="margin-top:4px;">' . $row['nom'] . '</p></td></tr>';
                $string2 .= '<tr>';
                if ($row['active'] == 1) {
                    $string2 .=  '<td><button class="pageAd__ctv" name="desactive" value="' . $row['id'] . '">desactive</button></td>';
                } else {
                    $string2 .=  '<td><button class="pageAd__ctv" name="active" value="' . $row['id'] . '">active</button></td>';
                }
                $string2 .= '</tr>';
                $string3 .=  '<tr><td><button class="pageAd__spp" name="supprimer" value="' . $row['id'] . '">Supprimer</button></td></tr>';
                $string4 .=  '<tr><td><button class="pageAd__spp" name="modifier" onclick="lectureRecette(' . $row['id'] . ')">modifier</button></td></tr>';
                
            }
            $string1 .= '<tr><td height="20px"></td></tr>';      
            $string1 .= '</tbody></Table>';
            $string2 .= '<tr><td height="20px"></td></tr>';
            $string2 .= '</tbody></Table></form>';
            $string3 .= '<tr><td height="20px"></td></tr>';
            $string3 .= '</tbody></Table></form>';
            $string4 .= '<tr><td><button class="pageAd__spp" name="modifier" onclick="addRecette()">Ajouter</button></td></tr>';
            $string4 .= '</tbody></Table></td>';

            echo '<Table><tbody><tr><th></th><th></th><th></th><th></th></tr>';
            echo '<td>';
            echo $string1;
            echo '</td><td>';
            echo $string2;
            echo '</td><td>';
            echo $string3;
            echo '</td><td>';
            echo $string4;
            echo '</td>';
            echo '</tbody></Table></form>';
            
            echo '</div>';
        } else {
            echo 'Base vide';
        }
    } catch (PDOException $err) {
        return 'BaseNok';
    }
}

