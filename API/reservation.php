<?php

include_once('./cmd_reservation.php');
session_start();
// print_r($_GET);


// echo $_GET['reservation'];
$response = json_decode($_GET['reservation'],true);

$id = null;

if (($response != 'null')&&(isset($response))) {

    $pseudo = $response[0]['pseudo'];

    if ($response[0]['reserv'] == "-1"){
        supprimer($response[0]['id']);  
        echo(json_encode(array("id"=>"000","pseudo"=>"","valid"=>"ok","message"=>"Commande annulée.","errorMsg"=>"1")));
        return 0;
    }
    if ($response[0]['id'] > 0){
        $idResponse = $response[0]['id'];

        if (selectReservById($idResponse) == null){
            echo(json_encode(array("id"=>"000","pseudo"=>"","valid"=>"ok","message"=>"Commande annulée.","errorMsg"=>"2")));
            return 0;
        }
    }   
    $rowReservByIp = selectReservByIp($_SESSION['uid']);

    ($rowReservByIp!=null)?$select=$rowReservByIp['chck']:$select=0;

    $id = ($rowReservByIp != null)?$rowReservByIp['id']:null;
    
    if ($id!=null){
        
        switch ($select){
            case 0:
                //var_dump($response[0]);
                
                $row_selectReservByIp = selectReservByIp($_SESSION['uid']);
                $time = selectReservTimeById($id);
                
            //    if ($time > 60){   
                    try{               
                    if (updateReservSpeudoByID($id,$pseudo)==1){
                        deleteDetailByID($id);
                        InsertDetailById($response,$id);
                        echo(json_encode(array("id"=>$id,"pseudo"=>"","valid"=>"","message"=>"Veuillez maintenant valider votre commande par téléphone","errorMsg"=>"3")));
                        return 0;
                    }
                    }catch(Exception $err){
                        $err->getmessage();
                    }
                // }else{
                //      echo(json_encode(array("id"=>"000","valid"=>"ok","pseudo"=>"","message"=>"Commande servie : Veuillez attendre 10 minutes avant la prochaine commande","errorMsg"=>$time+4)));
                //      return 0; 
                // }
                break;
            case 1:
                //var_dump($response[0]);
                $row_selectReservBySpeudo = selectReservByIp($_SESSION['uid']);
                echo(json_encode(array("id"=>$row_selectReservBySpeudo['id'],"pseudo"=>$row_selectReservBySpeudo['pseudo'],"valid"=>"","message"=>"Commande pris en compte","errorMsg"=>"4")));
                $_SESSION['like']=0;
                return 0;
                break;
            case 2:
                //var_dump($response[0]);
                $row_selectReservBySpeudo = selectReservByIp($_SESSION['uid']);
                echo(json_encode(array("id"=>$row_selectReservBySpeudo['id'],"pseudo"=>$row_selectReservBySpeudo['pseudo'],"valid"=>"","message"=>"Votre Commande est prête","errorMsg"=>"5")));
          
                if($_SESSION['like']==0) {
                    $_SESSION['like']=updateAime($response);
                }
                return 0;

                
                break;
            case 3:
                //var_dump($response[0]);
                $row_selectReservByIp = selectReservByIp($_SESSION['uid']);
                $time = selectReservTimeById($row_selectReservByIp['uid']);
                
                if ($time > 60){

                    if (InsertReservBySpeudo($response[0]['pseudo'],$_SESSION['uid'])==1){
                        $row_selectReservBySpeudo = selectReservBySpeudo($response[0]['pseudo']);
                        InsertDetailById($response,$row_selectReservBySpeudo['id']);
                        echo(json_encode(array("id"=>"0","pseudo"=>"","valid"=>"","message"=>"Veuillez maintenant valider votre commande par téléphone","errorMsg"=>"")));
                        $_SESSION['like']=0;
                        return 0;
                    }

                }else{
                    echo(json_encode(array("id"=>"000","valid"=>"ok","pseudo"=>"","message"=>"Commande servie : Veuillez attendre 10 minutes avant la prochaine commande","errorMsg"=>$time)));
                    return 0;
                }
                break;
            default:
                break;
            }
     }else{

        $row_selectReservByIp = selectReservByIp(1);

        if ($row_selectReservByIp!=null){
            echo(json_encode(array("id"=>$row_selectReservByIp['id'],"pseudo"=>"","valid"=>"","message"=>"Veuillez maintenant valider votre commande par téléphone","errorMsg"=>"")));
            return 0;
        }

        if (InsertReservBySpeudo($response[0]['pseudo'],$_SESSION['uid'])==1){
            $row_selectReservBySpeudo = selectReservBySpeudo($response[0]['pseudo']);
            InsertDetailById($response,$row_selectReservBySpeudo['id']);
            echo(json_encode(array("id"=>"0","pseudo"=>"","valid"=>"","message"=>"Veuillez maintenant valider votre commande par téléphone","errorMsg"=>"")));
            return 0;
        }else{
            
        }
    }
}
