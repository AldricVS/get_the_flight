<?php

/**
 * fichier permettant d'associer les lieux de départs et d'arrivées à leurs codes
 * ICAO correspondant
 * @package php/class
 */

require_once("data_reading.class.php");

/** 
 * récupère les noms des aéroports de départ et d'arrivée, puis trouve leur code ICAO correspondant
 * @author Zacharie
 * @var 
 */
class CorrespondenceName
{
    /**
     * @var string $_aeroport_depart nom de l'aéroport de départ
     * @var string $_aeroport_arrivee nom de l'aéroport d'arrivee
     */
    private $_aeroport_depart;
    private $_aeroport_arrivee;

    /**
     * @var string $_code_start code icao de l'aéroport de départ
     * @var string $_code_finish code icao de l'aéroport d'arrivee
     */
    private $_code_start;
    private $_code_finish;

    /**
     * @var bool $_isReady information principal ont été mis
     * @var bool $_option_Ready information secondaire qui est la date et non essentiel a la requete
     */
    private $_isReady;
    private $_option_Ready;

    /**
     * @var string $_date date de la recherche du vol
     *          Attention, le format de la date doit être comme ceci : YYYY-MM-DD (Example: 2019-02-31)
     */
    private $_date;

    /**
    * recherche le code ocai a partir des nom des aeroport
    */
    function searchOCAI()
    {
        //cherche dans la base de données les codes ocai correspondants aux noms de aéroprts reçus.
        $data_reading = new DataReading();
        $this->_code_start = $data_reading->SelectCorrespondAirportOACI($this->_aeroport_depart);
        $this->_code_finish = $data_reading->SelectCorrespondAirportOACI($this->_aeroport_arrivee);

        //verifie si on a bien les element principal pour une requete de l'api
        $this->_isReady = $this->_code_start && $this->_code_finish;

        //vérifie si il y a une date pour l'ajouter a la requete de l'api
        if(isset($this->_date) && !empty($this->_date)){
            $this->_option_Ready = true;
        }
    }

    public function setAeroportDepart($aeroport_name)
    {
        $this->_aeroport_depart = $aeroport_name;
    }

    public function setAeroportArrivee($aeroport_name)
    {
        $this->_aeroport_arrivee = $aeroport_name;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function getAeroportDepart()
    {
        return $this->_aeroport_depart;
    }

    public function getAeroportArrivee()
    {
        return $this->_aeroport_arrivee;
    }

    public function getCodeStart(){
        return $this->_code_start;
    }

    public function getCodeFinish(){
        return $this->_code_finish;
    }

    public function getDate(){
        return $this->_date;
    }

    public function getisReady(){
        return $this->_isReady;
    }

    public function getOptionReady(){
        return $this->_option_Ready;
    }
}
