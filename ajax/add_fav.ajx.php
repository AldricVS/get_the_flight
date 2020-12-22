<?php
session_start();

if(isset($_SESSION["username"]) && isset($_POST["icaoFrom"]) && isset($_POST["icaoTo"])){
    require_once('../php/class/data_reading.class.php');
    require_once('../php/class/data_saving.class.php');
    require_once('../php/data_manage.php');
    
    //simple ajout du favori
    $dataReading = new DataReading;
    $dataSaving = new DataSaving;
    echo InsertUserFavorite($dataReading, $dataSaving, $_SESSION["username"], $_POST["icaoFrom"], $_POST["icaoTo"]);
}
?>