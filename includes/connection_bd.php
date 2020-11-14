<?php 

    class ConnectionBD {

        // passage de connexion pour la base de données
        protected $_db_connection;

        public function __construct(){
            $db_host     = "mysql-get-the-flight.alwaysdata.net";
            $db_username = "216760_cheval";
            $db_password = "thibautlevieux";
            $db_name     = "get-the-flight_bd";
            $this->_db_connection = mysqli_connect($db_host, $db_username, $db_password,$db_name) 
                or die('could not connect to database');
        }

        public function Disconnection(){
            mysqli_close($this->_db_connection);
        }

        public function Get_DB_Connection(){
            return $this->_db_connection;
        }
    }
?>