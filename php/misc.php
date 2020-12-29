<?php

/**
 * Change une date sous la forme yyyy-mm-dd par une date sous la forme dd/mm/yyyy
 * Exemple : convertDateFormat("2020-12-21") = "21/12/2020"
 * @param string $date la date à formater
 * @return string la même date sous la forme dd/mm/yyyy 
 *  OU la chaine de caractères initiale si il y a une erreur dans la formation de celle-ci
 */
function convertDateFormat($date){
    $dateTab = explode("-", $date);
    if(count($dateTab) == 3){
        return $dateTab[2] . "/" . $dateTab[1] . "/" . $dateTab[0];
    }else{
        //date non valide, on retourne ce qu'on a reçu
        return $date;
    }
}

/**
 * Change une date sous la forme dd/mm/yyyy par une date sous la forme yyyy-mm-dd
 * Exemple : restoreDateFormat("21/12/2020") = "2020-12-21"
 * @param string $date la date à formater
 * @return string la même date sous la forme yyyy-mm-dd
 *  OU la chaine de caractères initiale si il y a une erreur dans la formation de celle-ci
 */
function restoreDateFormat($date){
    $dateTab = explode("/", $date);
    if(count($dateTab) == 3){
        return $dateTab[2] . "-" . $dateTab[1] . "-" . $dateTab[0];
    }else{
        //date non valide, on retourne ce qu'on a reçu
        return $date;
    }
}

/**
 * Recupère la date d'aujourd'hui dans le format yyyy-mm-dd
 * @return string une chaine de caractères représentant une date
 */
function getCurrentDate(){
    return date("Y-m-d");
}
