<?php
    /**
     * Ce fichier sert à trier des tableaux et vérifier si des trajets ou des vols 
     * sont mis en favoris ou sauvegardés.
     * @package @package php\class
     */

    /**
     * contient plusieurs fonctions utiles pour trier des tableaux et regarder
     * si des trajets ou des vols ne sont pas déjà favoris ou sauvegardés.
     * @author Zacharie
     */
    class Fonctions{

        /**
         * trie les trajets favoris en ordre décroissant
         * @return array $count_favorites 
         *                          les trajets triés de façon décroissante
         */
        public function CounterInArray($array){
            $arr_length = count($array);
            $count_favorites=array();
            for($i=0;$i<$arr_length;$i++){
                if(!array_key_exists($array[$i], $count_favorites)){
                    $count_favorites[$array[$i]]="$array[$i],1";
                }
                else {
                    $result=explode(',',$count_favorites[$array[$i]]);
                    $valeur=(int)$result[2];
                    $valeur++;
                    $valeur=(string)$valeur;
                    $count_favorites[$array[$i]]="$array[$i],$valeur";
                }
            }
            return $count_favorites;
        }

        /**
         * trouve le trajet avec le maximum de favori
         * @return string $max_row : trajet avec le nombre de favoris le plus haut
         */
        public function MaxFavourite($array){
            $max_value = 0;
            $arr_length = count($array);
            $array_key = array_keys($array);
            for($index = 0; $index < $arr_length; $index++){
                $i = $array_key[$index];
                $result = explode(',',$array[$i]);
                if($max_value < $result[2]){
                    $max_value = $result[2];
                    $max_row = $array[$i];
                }
            }
            return $max_row;
        }

        /**
         * fais un top 3 des trajets les plus populaires
         * @return array $podium 
         *                  top 3 des trajets les plus populaires
         */
        public function PodiumInArray($array){
            for($i=0;$i<3;$i++){
                // Renvoi la ligne avec le max de favori
                $max_favorite = Fonctions::MaxFavourite($array);
                unset($array[array_search($max_favorite,$array)]);
                $podium[]=$max_favorite;
            }
            return $podium;
        }

        

        /**
         * vérifie si le trajet n'est pas déjà sauvegardé dans la base de données pour un utilisateur
         * @return boolean vrai si il est déjà dedans, faux si il n'y est pas
         */
        public function SauvegardeAlreadyInsert($data_reading,$login,$numero_vol_to_sauve){
            // contient tous les vols sauegardés d'un utilisateur
            $numero_vol = $data_reading->SelectSaveInSauvegarde($login);
            $arr_length = count($numero_vol);
            for($i=0;$i<$arr_length;$i++){
                if($numero_vol[$i] === $numero_vol_to_sauve){
                    return true;
                }
            }
            return false;
        }

        /**
         * vérifie si le trajet n'est pas déjà favori dans la base de données pour un utilisateur
         * @return boolean vrai si il est déjà dedans, faux si il n'y est pas
         */
        public function FavoriteAlreadyInsert($data_reading,$login,$id_trajet_to_fav){
            // contient tous les favoris d'un utilisateur
            /*$id_trajet = $data_reading->SelectFavoriteInFavori($login);
            $arr_length = count($id_trajet);
            for($i=0 ; $i < $arr_length; $i++){
                if($id_trajet[$i] === $id_trajet_to_fav){
                    return true;
                }
            }
            return false;*/

            $trajets = $data_reading->SelectUserFavoritesTravel($login);
            $arr_length = count($trajets);
            for($i=0 ; $i < $arr_length; $i++){
                $id_trajet = explode(",", $trajets[$i]);
                if(count($id_trajet) > 1){
                    if($id_trajet[1] === $id_trajet_to_fav){
                        return true;
                    }
                } 
            }
            return false;
        }
    }

?>