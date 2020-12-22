<?php 
    /**
     * fichier permettant d'accéder à la base de données
     * @package php\class
     */

    /**
     * classe faisant la connexion et la déconnexion avec la BD
     * @author Zacharie
     */
    class ConnectionBD {

        /**
         * @var object $_db_connection contient le lien de connexion avec la BD
         */
        protected $_db_connection;
        /**
         * se connecte à notre BD mysql hébergé sur alwaysdata
         */
        public function __construct(){
            $db_host     = "mysql-get-the-flight.alwaysdata.net";
            $db_username = "216760_cheval";
            $db_password = "thibautlevieux";
            $db_name     = "get-the-flight_bd";
            $this->_db_connection = mysqli_connect($db_host, $db_username, $db_password,$db_name) 
                or die('could not connect to database');
        }

        public function Get_DB_Connection(){
            return $this->_db_connection;
        }

        /**
         * se déconnecte de la BD
         */
        public function Disconnection(){
            mysqli_close($this->_db_connection);
        }
    }
?>