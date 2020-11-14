<?php
require_once("connection_bd.php");

    //si on a pas le post, on envoie rien du tout
    if(isset($_POST["airport-name"]) && !empty($_POST["airport-name"])){

        $bd = new ConnectionBD;
        //récupération des aéroprts qui ont le même début que la chaine reçue par l'utilisateur

        //D'abord, on formailse un peu la chaine de l'utilisateur pour qu'elle ressemble aux noms stockés dans la base de données
        $airportName = strtoupper($_POST["airport-name"]);
        $airportName = str_replace(" ", "-", $airportName);
        $airportName = "%$airportName%";
        
        //maintenant, on peut faire la recherche (on ne prend que les 5 premiers resultats)
        //"SELECT nom_aeroport FROM Aeroport WHERE nom_aeroport LIKE ?%a ORDER BY nom_aeroprt LIMIT 5"
        if($result = $bd->Get_DB_Connection()->prepare("SELECT nom_aeroport FROM Aeroport WHERE nom_aeroport LIKE ? ORDER BY nom_aeroport")){
            if($result->bind_param('s', $airportName)){
                $result->execute();
                $result->bind_result($airportResultName);
                
                while($result->fetch()){
                    echo '<option value="'. $airportResultName .'">';
                }
                $result->close();
            }else{
                echo "<option value='Pas de results'/>";
            }
        }else{
            echo "<option value='pas de co'/>";
        }
        $bd->Disconnection();
    }else{
        echo "<option value='NADA'/>";
    }

