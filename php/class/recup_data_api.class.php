<?php
    /**
     * fichier récupérant les données de l'api qu'on lui demande
     * @package php\class
     */
    require 'correspond_name.class.php';

    /**
     * Récupère toutes les données de l'api pour la recherche de l'utilisateur
     * @author Zacharie, Thibaut
     */
    class RecupDataApi extends CorrespondenceName{
        /**
         * @var $_data données de l'api stockées
         */
        protected $_data;

        /**
         * @var bool $error_api vérifie si il y a une erreur durant l'utilisation de l'api
         *          true : aucune erreur
         *          false : erreur
         */
        private $error_api;

        /**
         * Fais le lien avec l'api et récupère les données ce dont on a besoin
         */
        public function RecupData(){

            parent::searchOCAI();

            //vérifi si on a bien les informations principal pour commencé une requete
            if(parent::getisReady()){

                //mise en place de l'url de l'api avec les paramettre voulu
                $url = "http://api.aviationstack.com/v1/flights?access_key=03c3113361c2800c70ee3a9583ce6ac5";
                
                /*
                //la date est en option
                if(parent::getOptionReady()){
                    $url = $url . "&flight_date=" . parent::getDate();
                }*/

                $url = $url . "&dep_icao=" . parent::getCodeStart();
                $url = $url . "&arr_icao=" . parent::getCodeFinish();


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
                    $this->error_api = false;
                }else{
                    //si il y a une erreur dans le statut de l’api(erreur404 par exemple)
                    if(curl_getinfo($curl,CURLINFO_HTTP_CODE)===200){
                        $this->_data=json_decode($data,true);
                        $this->error_api = true;
                    /**traitement*/
                    }else{
                        $this->error_api = false;
                    }
                }
            }
        }

        public function getErrorAPI(){
            return $this->error_api;
        }
    }
    
?>