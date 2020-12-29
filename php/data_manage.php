<?php 
     /**
     * fichier permettant d'intéragir avec la base de données en insertion, en sélection et en suppression
     * Toutes les fonctions ont besoin d'une référence à la classe DataReading dans les paramètres
     * et les fonctions qui remplisse la base de données ont aussi besoin d'une référence 
     * à la classe DataSaving dans les paramètres
     * @package php
     */
    require_once 'class/data_reading.class.php';
    require_once 'class/data_saving.class.php';
    require_once 'class/data_delete.class.php';
    require_once 'class/connection_bd.class.php';
    require_once 'class/fonctions.class.php';


    /**
     * récupère les infos d'un utilisateur
     * @param string $user : login de l'utilisateur 
     * @return string contenant le login, le mot de passeet l'email
     */
    function InfoUser($data_reading,$user){
        $info_user = $data_reading->SelectInfoUser($user);
        return $info_user;
    }

    /**
     * vérifie si le login est déjà dans la BD
     * @param string $user : login de l'utilisateur 
     * @return int 1 si le login de l'utilisateur est déjà utilisé, 0 sinon
     */
    function LoginAlreadyTaken($data_reading,$user){
        $login_already_taken = $data_reading->SelectLoginAlreadyTaken($user);
        return $login_already_taken;
    }

    /**
     * créer un podium des trajets favoris des utilisateur 
     * @return array des 3 premiers trajets favoris 
     */
    function PodiumFavorites($data_reading,$fonctions){
        $best_favorites = $data_reading->SelectBestFavorites();
        $count_favorites =$fonctions->CounterInArray($best_favorites);
        $podium_favorites = $fonctions->PodiumInArray($count_favorites);
        $departure=0;
        $arrival=1;
        for($i=0;$i<3;$i++){
            $result=explode(',',$podium_favorites[$i]);
            $correspondance_code_aeroport = $data_reading->SelectCorrespondOACIAirportDeparture($result[$departure]);
            $correspondance_code_aeroport_1 = $data_reading->SelectCorrespondOACIAirportArrival($result[$arrival]);
            $favorite_air_trajet[$i]="$correspondance_code_aeroport,$correspondance_code_aeroport_1";
            $real_podium = explode(',',$favorite_air_trajet[$i]);
            $favorite_travel[$i] = "$real_podium[0],$real_podium[3]";
        }
        return $favorite_travel;
    }
    
    /**
     * fais un tableau des détails des vols sauvegardés par un utilisateur
     * @param string $user : login de l'utilisateur 
     * @return array du détail des vols et des trajets
     */
    function VolSauvByUser($data_reading,$user){
        $vol_sauvegarde_details = $data_reading->SelectSaveFlight($user);
        $arr_length = count($vol_sauvegarde_details);
        if($arr_length>0){
            for($i=0;$i<$arr_length;$i++){
                $result=explode(',',$vol_sauvegarde_details[$i]);
                $code_id_trajet = $data_reading->SelectCorrespondNumFlightTravel($result[7]);
                $result_1=explode(',',$code_id_trajet);
                $correspondance_code_aeroport = $data_reading->SelectCorrespondOACIAirportDeparture($result_1[2]);
                $correspondance_code_aeroport = explode(",",$correspondance_code_aeroport);
                $correspondance_code_aeroport_1 = $data_reading->SelectCorrespondOACIAirportArrival($result_1[3]);
                $correspondance_code_aeroport_1 = explode(",",$correspondance_code_aeroport_1);
                $vol_sauve[] = "$vol_sauvegarde_details[$i],$correspondance_code_aeroport[0],$correspondance_code_aeroport_1[0]";
            }
            return $vol_sauve;
            /** retourne au format : numero_vol,login,date_depart,date_arrivee,compagnie,porte_départ,
             *  porte_arrive,id_trajet,nom_aeroport,ville_aeroport,region,nom_aeroport1,ville_aeroport1,region1 
             */
        }
        else{
            return "Vous n'avez pas encore sauvegardé de vol.";
        }
    }
    
    /**
     * fais un tableau des trajets favoris d'un utilisateur
     * @param string $user : login de l'utilisateur 
     * @return array de login, d'aéroport départ et d'aéroport destination
     */
    function FavoritesTravelByLogin($data_reading,$user){
        $user_favorites_travel = $data_reading->SelectUserFavoritesTravel($user);
        $arr_length = count($user_favorites_travel);
        if($arr_length>0){
            for($i=0;$i<$arr_length;$i++){
                $result=explode(',',$user_favorites_travel[$i]);
                $correspondance_code_aeroport = $data_reading->SelectCorrespondOACIAirportDeparture($result[2]);
                $correspondance_code_aeroport=explode(",",$correspondance_code_aeroport);
                $correspondance_code_aeroport_1 = $data_reading->SelectCorrespondOACIAirportArrival($result[3]);
                $correspondance_code_aeroport_1 =explode(",",$correspondance_code_aeroport_1);
                $user_favorites_routes[] = "$result[0],$correspondance_code_aeroport[0],$correspondance_code_aeroport_1[0]";
            }
            return $user_favorites_routes;
        }
        else {
            return "Vous n'avez pas encore mis de trajet en favori.";
        }
    }

    /**
     * Vérifie si le trajet est le favori d'un utilisateur
     * @param string $travel : un tableau contenant les deux aéroports
     * @return boolean true si le trajet est le favori d'un utilisateur, false sinon
     */
    function UserGetFavoriteTravel($data_reading, $travel, $user){
        $travel_favorite_list = $data_reading->SelectBestFavorites();
        $user_favorites_travel = $data_reading->SelectUserFavoritesTravel($user);
        $arr_length = count($travel_favorite_list);
        $name_airports_ask=explode(',',$travel);
        for($i=0;$i<$arr_length;$i++){
            $result=explode(',',$travel_favorite_list[$i]);
            $name_airport[0] = SelectCorrespondOACIAirportDeparture($result[0]);
            $name_airport[1] = SelectCorrespondOACIAirportArrival($result[1]);
            if(($name_airports_ask[0]===$name_airport[0]) && ($name_airports_ask[1]===$name_airport[1])){
                return true;
            }
        }
        return false;
    }

    /**
     * 
     */
    function IsTravelInFavorite($data_reading, $icaoFrom, $icaoTo, $username){
        $user_favorites_travel = $data_reading->SelectUserFavoritesTravel($username);
        foreach($user_favorites_travel as $travel){
            $t = explode(",", $travel);
            if(count($t) < 4){
                continue;
            }
            $tFrom = $t[2];
            $tTo = $t[3];
            if($tFrom === $icaoFrom && $tTo === $icaoTo){
                return true;
            }
        }
        return false;
    }

    /**
     * insert un nouvel utilisateur dans la base de données
     * @param array $parameters contient les données de l'utilisateur
     * @return string si l'utilisateur est enregistré ou si le login est déjà utilisé par quelqu'un d'autre
     */
    function InsertNewUser($data_reading,$data_saving,$parameters){
        if(LoginAlreadyTaken($data_reading,$parameters['login'])==0){
            $data_saving->InsertUser($parameters);
            return "insertion effectué";
        }
        return "le login est déjà pris par un autre utilisateur";
    }

    /**
     * insert un trajet noter favori par un utilisateur si l'utilisateur est dans la base de données
     * @param string $login contient le login de l'utilisateur
     * @param array $travel contient les noms d'aéroports du trajet
     * @return string si l'insertion a été effectué ou non
     */
    function InsertTrajetFavoriteByUser($data_reading,$data_saving,$login,$travel){
    
        if(LoginAlreadyTaken($data_reading,$login)==1){
            $code_oaci = $data_reading->SelectCorrespondAirportOACI($travel['nom_aeroport']);
            $code_oaci_1 = $data_reading->SelectCorrespondAirportOACI($travel['nom_aeroport_1']);
            $parameters = array( 'code_oaci' => $code_oaci, 'code_oaci_1' => $code_oaci_1);
            $travel_exist = $data_reading->SelectTrajetExist($parameters);

            if($travel_exist==null){
                $data_saving->InsertTravel($parameters);
                $id_trajet = $data_reading->SelectIdTrajetMax();
                $parameters = array( 'id_trajet' => $id_trajet, 'login' => $login);
                $data_saving->InsertFavorite($parameters);
                return "insertion du favori effectué";
            }
            else if($travel_exist!=null){
                $fonctions = new Fonctions;
                if(!$fonctions->FavoriteAlreadyInsert($data_reading,$login,$travel_exist)){
                    $parameters = array( 'id_trajet' => $travel_exist, 'login' => $login);
                    $data_saving->InsertFavorite($parameters);
                    return "insertion du favori effectué";
                }
                else{
                    return "ce favori est déjà dans la base de données";
                }
                
            }
        }
        else{
            return "l'insertion du favori n'a pas pu être effectué";
        }
    }

    /**
     * insert un trajet noter favori par un utilisateur si l'utilisateur est dans la base de données
     * @param string $login contient le login de l'utilisateur
     * @param string $icaoFrom le code oaci de départ
     * @param string $icaoTo le code oaci d'arrivée
     * @return string si l'insertion a été effectué ou non
     */
    function InsertUserFavorite($data_reading, $data_saving, $login, $icaoFrom, $icaoTo){
    
        if(LoginAlreadyTaken($data_reading,$login)==1){
            $parameters = array( 'code_oaci' => $icaoFrom, 'code_oaci_1' => $icaoTo);
            $travel_exist = $data_reading->SelectTrajetExist($parameters);

            if($travel_exist==null){
                $data_saving->InsertTravel($parameters);
                $id_trajet = $data_reading->SelectIdTrajetMax();
                $parameters = array( 'id_trajet' => $id_trajet, 'login' => $login);
                $data_saving->InsertFavorite($parameters);
                return "insertion du favori effectué";
            }else{
                $fonctions = new Fonctions;
                if(!$fonctions->FavoriteAlreadyInsert($data_reading,$login,$travel_exist)){
                    $parameters = array( 'id_trajet' => $travel_exist, 'login' => $login);
                    $data_saving->InsertFavorite($parameters);
                    return "insertion du favori effectué";
                }
                else{
                    return "ce favori est déjà dans la base de données";
                }
                
            }
        }
        else{
            return "l'insertion du favori n'a pas pu être effectué";
        }
    }

     /**
     * insert un trajet sauvegarder par un utilisateur si l'utilisateur est dans la base de données
     * @param string $login contient le login de l'utilisateur
     * @param array $travel contient les noms d'aéroports du trajet
     * @param array $details_vol contient les dates, les terminaux, la compagnie
     * @return string si l'utilisateur est enregistré ou si le login est déjà utilisé par quelqu'un d'autre
     */
    function InsertTrajetSauveByUser($data_reading,$data_saving,$login,$travel,$details_vol){
        if(LoginAlreadyTaken($data_reading,$login)==1){
            $code_oaci = $data_reading->SelectCorrespondAirportOACI($travel['nom_aeroport']);
            $code_oaci_1 = $data_reading->SelectCorrespondAirportOACI($travel['nom_aeroport_1']);
            $parameters = array( 'code_oaci' => $code_oaci, 'code_oaci_1' => $code_oaci_1);
            $travel_exist = $data_reading->SelectTrajetExist($parameters);

            if($travel_exist==null){
                $data_saving->InsertTravel($parameters);
                $id_trajet = $data_reading->SelectIdTrajetMax();
                $details_vol['id_trajet'] = $id_trajet;
                $data_saving->InsertFlight($details_vol);
                $numero_vol= $data_reading->SelectNumeroVolMax();
                $sauvegarde = array('numero_vol' => $numero_vol, 'login' => $login);
                $data_saving->InsertSauveFlight($sauvegarde);
                return "Sauvegarde effectuée";
            }
            else if($travel_exist!=null){
                $vol_exist = $data_reading->SelectVolExistV2($travel_exist, $details_vol);
                if ($vol_exist==null){
                    $details_vol['id_trajet'] = $travel_exist;
                    $data_saving->InsertFlight($details_vol);
                    $numero_vol= $data_reading->SelectNumeroVolMax();
                    $sauvegarde = array('numero_vol' => $numero_vol, 'login' => $login);
                    $data_saving->InsertSauveFlight($sauvegarde);
                return "Sauvegarde effectuée";
                }
                else if($vol_exist!=null){
                    $fonctions = new Fonctions;
                    if(!$fonctions->SauvegardeAlreadyInsert($data_reading,$login,$vol_exist)){
                        return "Ce vol est déjà sauvegardé par cet utilisateur";
                    }
                    else {
                        $sauvegarde = array('numero_vol' => $vol_exist, 'login' => $login);
                        $data_saving->InsertSauveFlight($sauvegarde);
                        return "Sauvegarde effectuée";
                    }
                }
            }
        }
        else{
            return "Le vol n'a pas pu être sauvegardé";
        }
    }

    /**
     * permet de supprimer toutes les informations concernant le trajet favori d'un utilisateur
     * @param $id_trajet : id du trajet à supprimer
     * @param $login : utilisateur pour lequel on supprime le favori
     */
    function DeleteFavorite($data_reading,$data_delete,$id_trajet,$login){
        $data_delete->DeleteFavoriteTravel($id_trajet,$login);
        if(($data_reading->SelectVolExist($id_trajet))==null){
           $data_delete->DeleteTravel($id_trajet);
        }
    }

    /**
     * permet de supprimer toutes les informations concernant le vol sauvegardé d'un utilisateur
     * @param $login : utilisateur pour lequel on supprime le vol
     * @param $numero_vol : numéro du vol à supprimer
     */
    function DeleteSauve($data_reading,$data_delete,$login,$numero_vol){
        $data_delete->DeleteSauveVol($login,$numero_vol);
        $id_trajet_delete=$data_delete->DeleteVol($numero_vol);
        if(($data_reading->SelectVolExist($id_trajet_delete)==null)&&
            ($data_reading->SelectFavoriteExist($login,$id_trajet_delete)==null)){
           $data_delete->DeleteTravel($id_trajet_delete);
        }
    }

?>