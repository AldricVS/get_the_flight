<?php

include_once('../php/class/process_data.class.php');
//include('correspond_name.class.php');

//variable test
$aeroport_depart = "PARIS-CHARLES-DE-GAULLE";
$aeroport_arrive = "MARSEILLE-PROVENCE";
$date = "2020-12-04";



$test = new ProcessData;

//insertion des informations
$test->setAeroportDepart($aeroport_depart);
$test->setAeroportArrivee($aeroport_arrive);
//attention au format de la date
$test->setDate($date);

//appel de l'api avec les informations qui ont été mis
$test->DataStorage();

//vérifie le code erreur (regarder les commentaire pour voir la correspondance du code erreur dans le fichier process_data.class.php)
if($test->getCodeError() != 0){

    //echo $test->getAeroportDepart() . " " . $test->getCodeStart() . " " . $test->getAeroportArrivee() . " " . $test->getCodeFinish() . " " . $test->getisReady();
    echo $test->getCodeError();

}else{
    var_dump($test->getDataForSearch());
}





/**
 * test juste pour connaitre les limites de l'api
 */

/*
//mise en place de l'url de l'api avec les paramettre voulu
$url = "http://api.aviationstack.com/v1/flights?access_key=03c3113361c2800c70ee3a9583ce6ac5";

//$url = $url . "&flight_date=2020-11-23";
$url = $url . "&dep_icao=LFPG";
$url = $url . "&arr_icao=LFML";

//appel de l'api
$curl=curl_init($url);
curl_setopt_array($curl,[
    CURLOPT_CAINFO => __DIR__.DIRECTORY_SEPARATOR.'cert.cer',
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_TIMEOUT=>5
]);
$data=curl_exec($curl);
//si il y a une erreur
if($data===false){
    var_dump(curl_error($curl));
}else{
    //si il y a une erreur dans le statut de l’api(erreur404 par exemple)
    if(curl_getinfo($curl,CURLINFO_HTTP_CODE)===200){
        $data=json_decode($data,true);
        var_dump($data);
    }else{
        var_dump(curl_getinfo($curl,CURLINFO_HTTP_CODE));
    }
}
*/
?>