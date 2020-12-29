<?php
    /**
     * fichier utilisé pour ranger les données fournies par l'api
     * @package php\class
     */
    require 'recup_data_api.class.php';

    /**
     * range les données de l'api dans des tableaux
     * @author Zacharie, Thibaut
     */
    class ProcessData extends RecupDataApi{
        /**
         * @var array $_data_for_search utilisé pour une recherche utilisateur
         */
        private $_data_for_search;

        /**
         * @var $code_error code erreur du probleme
         *          0 : aucune erreur
         *          1 : manque le code icao de l'aeroport de depart et d'arrivee
         *          2 : erreur durant l'appel de l'api
         */
        private $code_error;

        /**
         * Récupère les données de l'api pour les mettre dans 3 variables différentes, pour 
         * la recherche de l'utilisateur, pour les favoris et les vols sauvegardés si il y en a.
         */
        public function DataStorage (){

            parent::RecupData();

            //vérifie si on a bien les informations principales pour commencé une requete
            if(parent::getisReady()){
                //vérifie si l'appel de l'api a bien fonctionner
                if(parent::getErrorAPI()){

                    $max = count($this->_data['data']);
                    for($i=0;$i<$max;$i++){

                        //statut du vol
                        $flight_status = $this->_data['data'][$i]['flight_status'];

                        $airline = $this->_data['data'][$i]['airline']['name'];

                        /**
                         * Informations concernant le départ du vol
                         */
                        $airport_dep = $this->_data['data'][$i]['departure']['airport'];
                        $icao_dep = $this->_data['data'][$i]['departure']['icao'];
                        if(!$this->_data['data'][$i]['departure']['terminal']){
                            $terminal_dep = "vide";
                        }
                        else{
                            $terminal_dep = $this->_data['data'][$i]['departure']['terminal'];
                        }
                        $estimated_dep = $this->traducDate($this->_data['data'][$i]['departure']['estimated']);

                        /**
                         * Informations concernant l'arrivée du vol
                         */ 
                        $airport_arr = $this->_data['data'][$i]['arrival']['airport'];
                        $icao_arr = $this->_data['data'][$i]['arrival']['icao'];
                        if(!$this->_data['data'][$i]['arrival']['terminal']){
                            $terminal_arr = "vide";
                        }
                        else{
                            $terminal_arr = $this->_data['data'][$i]['arrival']['terminal'];
                        }
                        $estimated_arr = $this->traducDate($this->_data['data'][$i]['arrival']['estimated']);

                        $flight_number = $this->_data['data'][$i]['flight']['number'];
                        
                        //vérifie si il y a une date et n'accepte pas les dates inférieurs 
                        if(parent::getOptionReady()){
                            if(parent::getDate() > $estimated_dep['date']){
                                //arrêt de cette itération et va directement à la prochiaine itération
                                continue;
                            }
                        }


                        /**
                         * Données pour la recherche de l'utilisateur
                         */
                        $this->_data_for_search[]=array( 
                            "nom_aeroport" => $airport_dep,
                            "nom_aeroport_1" => $airport_arr,
                            "porte_depart" => $terminal_dep,
                            "porte_arrive" => $terminal_arr,
                            "code_oaci" => $icao_dep,
                            "code_oaci_1" => $icao_arr,
                            "status_du_vol" => $flight_status,
                            "date_dep" => $estimated_dep['date'],
                            "heure_dep" => $estimated_dep['heure'],
                            "date_arr" => $estimated_arr['date'],
                            "heure_arr" => $estimated_arr['heure'],
                            "numero_vol" => $flight_number,
                            "airline" => $airline
                        );
                    }
                    //aucune erreur
                    $this->code_error = 0;
                }else{
                    //erreur : durant l'appel de l'api
                    $this->code_error = 2;
                }
            }else{
                //erreur : manque des informations
                $this->code_error = 1;
            }
        }

        /**
         * traduit une date de type 2019-12-12T04:20:00+00:00 à 'date' => 2019-12-12 et 'heure' => 04:20:00
         */
        public function traducDate($date){
            $temp1 = explode("+", $date);
            $date = $temp1[0];
            $temp1 = explode("T", $date);
            $newdate = array(
                "date" => $temp1[0],
                "heure" => $temp1[1]
            );
            return $newdate;
        }

        public function getDataForSearch(){
            return $this->_data_for_search;
        }

        public function getCodeError(){
            return $this->code_error;
        }
    }

    /*
    $data = new ProcessData;
    $data->correspondanceICAO();
    $data->RecupData();
    //var_dump($data->getData());
    $data->DataStorage();
    var_dump($data->getDataForSearch());
    */

?>