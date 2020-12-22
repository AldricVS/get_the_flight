<?php
    /**
     * fichier permettant de supprimer des lignes dans la base de données
     * @package php\class
     */
    require_once 'connection_bd.class.php';

    /**
     * classe servant à supprimer des données de la BD
     * @author Zacharie
     */
    class DataDelete extends ConnectionBD{

        /**
         * fonction qui connecte à la base de données
         */
        public function __construct(){
            parent::__construct();
        }

        /**
         * supprime un vol sauvegardé selon le nom de l'utilisateur et son numéro de vol
         * @param $login : utilisateur qui veut supprimer son vol sauvegardé
         * @param $flight_number : numéro du vol à supprimer
         */
        public function DeleteSauveVol($login,$flight_number){
            $requete = $this->_db_connection->prepare("DELETE FROM Sauvegarde WHERE login = ? AND numero_vol = ?");
            $requete->bind_param('si',$login,$flight_number);
            $requete->execute();
        }

        /**
         * supprime un vol selon son numéro de vol
         * @param $flight_number : numéro du vol à supprimer
         */
        public function DeleteVol($flight_number){
            if ($stmt = $this->_db_connection->prepare("SELECT id_trajet FROM Vol WHERE numero_vol = ?" )) {
                $stmt->bind_param('i', $flight_number);
                $stmt->execute();
                $stmt->bind_result($col1);
                while ($stmt->fetch()) {
                    $row="$col1";
                }
                $stmt->close();
            }
            $requete = $this->_db_connection->prepare("DELETE FROM Vol WHERE numero_vol = ?");
            $requete->bind_param('i',$flight_number);
            $requete->execute();
            return $row;
        }

        /**
         * supprime un favori selon son id trajet et le login
         * @param $id_trajet : trajet favori à supprimer
         * @param $login : utilisateur souhaitant supprimer son trajet favori
         */
        public function DeleteFavoriteTravel($id_trajet,$login){
            $requete = $this->_db_connection->prepare("DELETE FROM Favori WHERE id_trajet = ? AND login = ?");
            $requete->bind_param('is',$id_trajet,$login);
            $requete->execute();
        }

        /**
         * supprime un vol selon son numéro de vol
         * @param $flight_number : numéro du vol à supprimer
         */
        public function DeleteTravel($id_trajet){
            $requete = $this->_db_connection->prepare("DELETE FROM Trajet WHERE id_trajet = ?");
            $requete->bind_param('i',$id_trajet);
            $requete->execute();
        }

    }