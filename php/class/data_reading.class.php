<?php
    /**
     * fichier permettant de lire dans la base de données
     * @package php\class
     */
    require_once 'connection_bd.class.php';

    /**
     * classe servant à attraper des données de la BD
     * @author Zacharie
     */
    class DataReading extends ConnectionBD{

        /**
         * fonction qui connecte à la base de données
         */
        public function __construct(){
            parent::__construct();
        }

        /**
         * récupère l'id trajet maximum dans la table Trajet
         * @return int $reponse : l'id trajet maximum
         */
        public function SelectIdTrajetMax(){
            $requeteN = "SELECT MAX(id_trajet) FROM Trajet";
            $exec_requeteN = mysqli_query($this->_db_connection,$requeteN);
            $reponse = mysqli_fetch_row($exec_requeteN);
            return $reponse[0];
        }
        
        /**
         * récupère le numéro de vol maximum dans la table Vol
         * @return int $reponse : le numero du vol maximum
         */
        public function SelectNumeroVolMax(){
            $requeteN = "SELECT MAX(numero_vol) FROM Vol";
            $exec_requeteN = mysqli_query($this->_db_connection,$requeteN);
            $reponse = mysqli_fetch_row($exec_requeteN);
            return $reponse[0];
        }

        /**
         * récupère si le trajet existe déjà 
         * @return int null si le trajet n'existe pas et le numéro du trajet si il existe
         */
        public function SelectTrajetExist($trajet){
            if ($stmt = $this->_db_connection->prepare("SELECT id_trajet FROM Trajet WHERE code_oaci = ? AND code_oaci_1 = ?")) {
                $stmt->bind_param('ss', $trajet['code_oaci'], $trajet['code_oaci_1']);
                $stmt->execute();  
                $stmt->bind_result($col1);
                $row=null;
                while ($stmt->fetch()) {
                    $row=$col1;
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère si (la référence au) trajet existe déjà 
         * @return int null si (la référence au) trajet n'existe pas et le numéro du trajet si il existe
         */
        public function SelectIdTrajetExist($id_trajet){
            if ($stmt = $this->_db_connection->prepare("SELECT id_trajet FROM Trajet WHERE id_trajet = ?")) {
                $stmt->bind_param('i', $id_trajet);
                $stmt->execute();
                $stmt->bind_result($col1);
                $row=null;
                while ($stmt->fetch()) {
                    $row=$col1;
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère si le vol existe déjà
         * @return int null si le vol n'existe pas renvoie null, sinon renvoie numero_vol
         */
        public function SelectVolExist($trajet){
            if ($stmt = $this->_db_connection->prepare("SELECT numero_vol FROM Vol 
                WHERE id_trajet = ?")) {
                $stmt->bind_param('i', $trajet);
                $stmt->execute();
                $stmt->bind_result($col1);
                $row=null;
                while ($stmt->fetch()) {
                    $row=$col1;
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère le login, mot de passe et email d'un utilisateur
         * @return string $row au format : login,mot_de_passe,email
        */
        public function SelectInfoUSer($condition){
            //requête pour connaître les paramètres de l'utilisateur
            /* Préparation de la requête */
            if ($stmt = $this->_db_connection->prepare("SELECT * FROM Utilisateur WHERE login = ? ")) {
                $stmt->bind_param('s', $user);
                $user = $condition;
                $stmt->execute();
                /* Insertion de la variable */
                $stmt->bind_result($col1, $col2, $col3);       
                /* Récupération des valeurs */
                while ($stmt->fetch()) {
                    //echo "<p>$col1 , $col2 , $col3</p>";
                    $row = "$col1,$col2,$col3";
                }
                /* Fermeture du traitement */
                $stmt->close();
                return $row;
            }
        }

        /**
         * vérifie si un utilisateur a déjà le login souhaité
         * @return int $row = 1 si le login est déjà dans la BD
         */
        public function SelectLoginAlreadyTaken($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT COUNT(*) FROM Utilisateur WHERE login = ?")) {
                $stmt->bind_param('s', $user);
                $user = $condition;
                $stmt->execute();
                $stmt->bind_result($col1);
                while ($stmt->fetch()) {
                    $row="$col1";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère l'aéroport correspondant au code OACI de départ
         * @return string $row au format : nom_aeroport,ville_aeroport,region
         */
        public function SelectCorrespondOACIAirportDeparture($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT nom_aeroport, ville_aeroport, region FROM 
                    Aeroport AS a INNER JOIN Trajet AS t ON a.code_oaci = t.code_oaci WHERE a.code_oaci = ?")) {
                $stmt->bind_param('s', $code_oaci);
                $code_oaci = $condition;
                $stmt->execute();
                $stmt->bind_result($col1,$col2,$col3);
                while ($stmt->fetch()) {
                    $row="$col1,$col2,$col3";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère l'aéroport correspondant au code OACI d'arrivée
         * @return string $row au format : nom_aeroport,ville_aeroport,region
         */
        public function SelectCorrespondOACIAirportArrival($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT nom_aeroport, ville_aeroport, region FROM 
                    Aeroport AS a INNER JOIN Trajet AS t ON a.code_oaci = t.code_oaci_1 WHERE a.code_oaci = ?")) {
                $stmt->bind_param('s', $code_oaci);
                $code_oaci = $condition;
                $stmt->execute();
                $stmt->bind_result($col1,$col2,$col3);
                while ($stmt->fetch()) {
                    $row="$col1,$col2,$col3";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère le code_oaci associé à un nom d'aéroport
         * @return string $row : le code oaci correspondant au nom de l'aéroport
         */
        public function SelectCorrespondAirportOACI($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT code_oaci FROM 
                    Aeroport AS a WHERE a.nom_aeroport = ?")) {
                $stmt->bind_param('s', $nom_aeroport);
                $nom_aeroport = $condition;
                $stmt->execute();
                $stmt->bind_result($col1);
                while ($stmt->fetch()) {
                    $row="$col1";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère les trajets favoris des utilisateurs 
         * @return array $row au format : code_oaci,code_oaci_1
         */
        public function SelectBestFavorites(){
            if ($stmt = $this->_db_connection->prepare("SELECT code_oaci,code_oaci_1 FROM 
                    Favori AS f INNER JOIN Trajet AS t ON f.id_trajet = t.id_trajet")) {
                $stmt->execute();
                $stmt->bind_result($col1,$col2);
                while ($stmt->fetch()) {
                    $row[]="$col1,$col2";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère tous les vols déjà sauvegardés d'un utilisateur
         * @return array $row au format : numero_vol
         */
        public function SelectSaveInSauvegarde($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT numero_vol FROM Sauvegarde WHERE login= ?" )) {
                $stmt->bind_param('s', $user);
                $user = $condition;
                $stmt->execute();
                $stmt->bind_result($col1);
                $row=array();
                while ($stmt->fetch()) {
                    $row[]="$col1";
                }
                $stmt->close();
                return $row;
            }
        }
        /**
         * recupère les vols déjà favori d'un utilisateur
         * @return array $ row au format : id_trajet
         */
        public function SelectFavoriteExist($login, $id_trajet){
            if ($stmt = $this->_db_connection->prepare("SELECT id_trajet FROM Favori WHERE login= ? AND id_trajet = ?" )) {
                $stmt->bind_param('si', $login, $id_trajet);
                $stmt->execute();
                $stmt->bind_result($col1);
                $row=null;
                while ($stmt->fetch()) {
                    $row=$col1;
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère les vols sauvegardés par un utilisateur
         * @return array $row au format : numero_vol,login,date_depart,date_arrivee,
         *                      compagnie,porte_départ,porte_arrive,id_trajet
         */
        public function SelectSaveFlight($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT s.numero_vol, login, date_depart, date_arrivee, compagnie, 
            porte_depart, porte_arrive, id_trajet FROM Sauvegarde AS s
                    INNER JOIN Vol AS v ON s.numero_vol = v.numero_vol WHERE login= ?" )) {
                $stmt->bind_param('s', $user);
                $user = $condition;
                $stmt->execute();
                $stmt->bind_result($col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8);
                $row =array();
                while ($stmt->fetch()) {
                    $row[]="$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère le trajet d'un numéro de vol
         * @return string $row au format : numero_vol,id_trajet,code_oaci,code_oaci_1
         */
        public function SelectCorrespondNumFlightTravel($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT numero_vol,t.id_trajet,code_oaci,code_oaci_1 FROM Trajet AS t
                    INNER JOIN Vol AS v ON t.id_trajet = v.id_trajet WHERE t.id_trajet= ?" )) {
                $stmt->bind_param('i', $id_trajet);
                $id_trajet = $condition;
                $stmt->execute();
                $stmt->bind_result($col1, $col2, $col3, $col4);
                while ($stmt->fetch()) {
                    $row="$col1,$col2,$col3,$col4";
                }
                $stmt->close();
                return $row;
            }
        }

        /**
         * récupère les trajets favoris d'un utilisateur
         * @return array $row au format : login,id_trajet,code_oaci,code_oaci_1
         */
        public function SelectUserFavoritesTravel($condition){
            if ($stmt = $this->_db_connection->prepare("SELECT login, f.id_trajet, code_oaci,code_oaci_1 FROM 
                    Favori AS f INNER JOIN Trajet AS t ON f.id_trajet = t.id_trajet WHERE login = ?")) {
                $stmt->bind_param('s', $user);
                $user = $condition;
                $stmt->execute();
                $stmt->bind_result($col1,$col2,$col3,$col4);
                $row = array();
                while ($stmt->fetch()) {
                    $row[]="$col1,$col2,$col3,$col4";
                }
                $stmt->close();
                return $row;
            }
        }

    }

?>