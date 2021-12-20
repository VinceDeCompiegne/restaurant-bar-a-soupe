<?php

function login(string $mail,string $pass) {       // Connexion

        try{

            include_once('inc/constants.inc.php');
            $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
            // Gestion des attributs de la connexion : exception et retour du SELECT
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Préparation requête : paramétrage pour éviter injections SQL
            $qry = $conn->prepare('SELECT * FROM user WHERE mail=? AND pass=? AND active=?');
            $qry->execute(array($mail, $pass, 1));
            // Si une ligne est trouvée

            if ($qry->rowCount()===1) {
                $row = $qry->fetch();
                return $row['type'];
                
                

            } else {

                echo 'User inconnu';

            }

        } catch (PDOException $err) {
            
            throw new Exception($err->getcode());
        }
        
    }



    function createBaseLogin(string $mail,string $mdp) {

        try {

            // Connexion
            include_once('inc/constants.inc.php');
            $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
            // Gestion des attributs de la connexion : exception et retour du SELECT
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Préparation requête : paramétrage pour éviter injections SQL

            $rqt = "CREATE DATABASE IF NOT EXISTS `barrestsoupe` DEFAULT CHARACTER SET utf8;
            USE `barrestsoupe`;
            CREATE TABLE IF NOT EXISTS `user` (
            `uid` smallint(6) NOT NULL AUTO_INCREMENT,
            `speudo` varchar(20) CHARACTER SET utf8 NOT NULL,
            `mail` varchar(255) CHARACTER SET utf8 NOT NULL,
            `pass` varchar(255) CHARACTER SET utf8 NOT NULL,
            `active` tinyint(4) NOT NULL,
            `type` varchar(12) NOT NULL COMMENT 'admin/serveur'
            PRIMARY KEY (`uid`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";

            $rqt=$rqt."INSERT INTO `user` (`uid`, `speudo`, `mail`, `pass`, `active`) VALUES
            (1, 'user', :mail, :mdp, 1);";

            $qry = $conn->prepare($rqt);
            $qry->execute(array(':mail'=>$mail,':mdp'=>$mdp));
            // Si une ligne est trouvée

        }catch (PDOException $err) {

            throw new PDOException($err->getmessage());

        }

    }
    ?>