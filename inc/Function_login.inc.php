<?php

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

            $rqt=$rqt."INSERT INTO `user` (`speudo`, `mail`, `pass`, `active`) VALUES
            ('user', :mail, :mdp, 1);";

            $qry = $conn->prepare($rqt);
            $qry->execute(array(':mail'=>$mail,':mdp'=>$mdp));
            // Si une ligne est trouvée
            
        }catch (PDOException $err) {

            throw new PDOException($err->getmessage());

        }

    }

    function inscription(string $speudo,string $mail,string $mdp) {

        try {

            // Connexion
            include_once('inc/constants.inc.php');
            $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATA . ';port=' . PORT . ';charset=utf8', USER, PASS);
            // Gestion des attributs de la connexion : exception et retour du SELECT
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Préparation requête : paramétrage pour éviter injections SQL

            $rqt="INSERT INTO `user` (`speudo`, `mail`, `pass`, `active`, `type`) VALUES
            (:speudo, :mail, :mdp, 1 , 'user');";

            $qry = $conn->prepare($rqt);
            $qry->execute(array(':speudo'=>$speudo,':mail'=>$mail,':mdp'=>$mdp));
            // Si une ligne est trouvée
            
        }catch (PDOException $err) {

            throw new PDOException($err->getmessage());

        }

    }

    ?>