<?php
require_once("../php/class/connection_bd.class.php");

function startsWith($string, $substring){
    $strLength = strlen($substring);
    return substr($string, 0, $strLength) === $substring;
}

    //si on a pas le post, on envoie rien du tout
    if(isset($_POST["airport-name"]) && !empty($_POST["airport-name"])){

        $bd = new ConnectionBD;
        //récupération des aéroprts qui ont le même début que la chaine reçue par l'utilisateur

        //D'abord, on formailse un peu la chaine de l'utilisateur pour qu'elle ressemble aux noms stockés dans la base de données
        $airportName = strtoupper($_POST["airport-name"]);

        //on récupère l'initiale (on sait que l'on a au minimum une lettre ici)
        $initial = $airportName[0];

        $airportName = str_replace(" ", "-", $airportName);
        $airportName = "%$airportName%";
        
        //maintenant, on peut faire la recherche (on ne prend que les 5 premiers resultats)
        //"SELECT nom_aeroport FROM Aeroport WHERE nom_aeroport LIKE ?%a ORDER BY nom_aeroprt LIMIT 5"
        if($result = $bd->Get_DB_Connection()->prepare("SELECT nom_aeroport FROM Aeroport WHERE nom_aeroport LIKE ? ORDER BY nom_aeroport")){
            if($result->bind_param('s', $airportName)){
                $result->execute();
                $result->bind_result($airportResultName);

                //on va mettre tous les résultats qui commencent par la même lettre que celle écrite par l'utilisateur en premier
                $airportsArr = [];
                
                while($result->fetch()){
                    if(startsWith($airportResultName, $initial)){
                        array_unshift($airportsArr, $airportResultName);
                    }else{
                        array_push($airportsArr, $airportResultName);
                    }
                }
                $result->close();

                //et on envoie toutes les options dans l'ordre
                foreach ($airportsArr as $name) {
                    echo '<option value="'. $name .'"/>';
                }
            }else{
                echo "<option value='Pas de resultats.'/>";
            }
        }else{
            echo "<option value='Connexion à la base de données impossible.'/>";
        }
        $bd->Disconnection();
    }else{
        echo "<option value='Un erreur innatendue a eu lieu.'/>";
    }

