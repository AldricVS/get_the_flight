<?php
    /**
    * Contient une classe qui permet de sauvegarder des informations dans la BD
    * @package php\class
    */
    include_once 'connection_bd.class.php';

    /**
     * Cette classe permet d'insérer des éléments dans la base de données
     * @author Zacharie 
     */
    class DataSaving extends ConnectionBD{


        /**
         * fonction qui connecte à la base de données
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * insère un nouvel utilisateur dans la BD
         * @param array $parameters 
         *                 contenant les informations à insérer dans la table Utilisateur
         */
        public function InsertUser($parameters){
            $_requete = $this->_db_connection->prepare("INSERT INTO Utilisateur (login, mot_de_passe, email) 
                VALUES (?, ?, ?)");
            $_requete->bind_param('sss',$login,$mot_de_passe,$email);

            $login = $parameters['login'];
            $mot_de_passe = $parameters['mot_de_passe'];
            $email = $parameters['email'];
            $_requete->execute();
        }

        /**
         * insère le trajet d'un vol dans la BD
         * @param array $parameters 
         *                  contenant les informations à insérer dans la table Trajet
         */
        public function InsertTravel($parameters){
            $_requete = $this->_db_connection->prepare("INSERT INTO Trajet ( code_oaci, code_oaci_1) 
                VALUES (?, ?)");
            $_requete->bind_param('ss',$code_oaci,$code_oaci_1);

            $code_oaci = $parameters['code_oaci'];
            $code_oaci_1 = $parameters['code_oaci_1'];
            $_requete->execute();
        }

        /**
         * insère les informations importantes d'un vol dans la BD
         * @param array $parameters 
         *                  contenant les informations à insérer dans la table Vol
         */
        public function InsertFlight($parameters){

            $_requete = $this->_db_connection->prepare("INSERT INTO Vol 
                (date_depart, date_arrivee, compagnie, porte_depart, porte_arrive, id_trajet) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $_requete->bind_param('sssssi',$date_depart,$date_arrivee,
                $compagnie, $porte_depart, $porte_arrive, $id_trajet);
            $date_depart = $parameters['date_depart'];
            $date_arrivee = $parameters['date_arrivee'];
            $compagnie = $parameters['compagnie'];
            $porte_depart = $parameters['porte_depart'];
            $porte_arrive = $parameters['porte_arrive'];
            $id_trajet = $parameters['id_trajet'];
            $_requete->execute();
        }
        
        /**
         * insert un vol sauvegardé dans la BD
         * @param array $parameters 
         *                  contenant les informations à insérer dans la table Sauvegarde
         */
        public function InsertSauveFlight($parameters){
            $_requete = $this->_db_connection->prepare("INSERT INTO Sauvegarde (numero_vol, login) 
                VALUES (?, ?)");
            $_requete->bind_param('is',$numero_vol,$login);

            $numero_vol = $parameters['numero_vol'];
            $login = $parameters['login'];
            $_requete->execute();
            }
        
        /**
         * insert un trajet favori dans la BD
         * @param array $parameters 
         *                  contenant les informations à insérer dans la table Favori
         */
        public function InsertFavorite($parameters){
            $_requete = $this->_db_connection->prepare("INSERT INTO Favori (id_trajet, login) 
                VALUES (?, ?)");
            $_requete->bind_param('is',$id_trajet,$login);

            $id_trajet = $parameters['id_trajet'];
            $login = $parameters['login'];
            $_requete->execute();
        } 
    }
?>