<?php
/**
 * ce fichier permet la sauvegarde d'un vol pour l'utilisateur connecté
 */

session_start();

/**
 * vérification de la présence de toutes les informations nécessaires
 *      $_SESSION["username"] : si un utilisateur est connecté
 *      $_POST["nameAirportFrom"] : nom de l'aéroport de départ
 *      $_POST["nameAirportTo"] : nom de l'aéroport d'arrivé
 *      $_POST["departureDate"] : date du départ
 *      $_POST["arrivalDate"] : date d'arrivé'
 *      $_POST["airline"] : nom de la compagnie aérienne
 *      $_POST["departureTerminal"] : terminal du départ
 *      $_POST["arrivalTerminal"] : terminal d'arrivé
 */
if(isset($_SESSION["username"]) && isset($_POST["nameAirportFrom"]) && isset($_POST["nameAirportTo"]) && isset($_POST["departureDate"]) 
    && isset($_POST["arrivalDate"]) && isset($_POST["airline"]) && isset($_POST["departureTerminal"]) && isset($_POST["arrivalTerminal"])){

    require_once('../php/class/data_reading.class.php');
    require_once('../php/class/data_saving.class.php');
    require_once("../php/data_manage.php");
    require_once("../php/misc.php");

    $dataReading = new DataReading;
    $dataSaving = new DataSaving;

    $travel = array (
        "nom_aeroport"  => $_POST["nameAirportFrom"],
        "nom_aeroport_1" => $_POST["nameAirportTo"]
    );

    $details_vol = array (
        'date_depart' => restoreDateFormat($_POST["departureDate"]),
        'date_arrivee' => restoreDateFormat($_POST["arrivalDate"]),
        'compagnie' => $_POST["airline"],
        'porte_depart' => $_POST["departureTerminal"],
        'porte_arrive' => $_POST["arrivalTerminal"]
    );

    //insertion du vol
    echo "<p>" . InsertTrajetSauveByUser($dataReading, $dataSaving, $_SESSION["username"], $travel, $details_vol) . "</p>";
}else{
    echo "<p>Une erreur est survenue lors du traitement de la sauvegarde.</p>";
}
?>