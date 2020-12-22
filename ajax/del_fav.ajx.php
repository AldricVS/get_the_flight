<?php
session_start();

if(isset($_SESSION["username"]) && isset($_POST["icaoFrom"]) && isset($_POST["icaoTo"])){
    require_once('../php/class/data_reading.class.php');
    require_once('../php/class/data_delete.class.php');
    require_once('../php/data_manage.php');
    
    //simple suppression de favori
    $dataReading = new DataReading;
    $dataDelete = new DataDelete;
    //on cherche l'id du trajet en question
    $travel = [
        'code_oaci' =>  $_POST["icaoFrom"],
        'code_oaci_1' => $_POST["icaoTo"]
    ];
    $idTravel = $dataReading->SelectTrajetExist($travel);

    echo("je suis " . $idTravel);

    if(!empty($idTravel)){
        DeleteFavorite($dataReading, $dataDelete, $idTravel, $_SESSION["username"]);
        echo("ça marche");
    }else{
        echo("pas de trajet trouvé");
    }
}
?>