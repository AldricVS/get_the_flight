<?php
/*
 *	Fonction permettant de calculer le nombre de visiteurs
*/
function nbvisiteurs()
{
    if (file_exists('./compteur/cptvisites.txt'))
    {
        $ouverturefic = fopen('./compteur/cptvisites.txt', 'r+');
        $nombre = fgets($ouverturefic);
    }
    else
    {
        $ouverturefic = fopen('./compteur/cptvisites.txt', 'a+');
        $nombre = 0;
    }
    if (!isset($_SESSION['compteur_de_visite']))
    {
        $_SESSION['compteur_de_visite'] = 'visite';
        $nombre++;
        fseek($ouverturefic, 0);
        fputs($ouverturefic, $nombre);
    }
    fclose($ouverturefic);
    echo '<strong>Nombres de visites :' . $nombre . '</strong>';
}
/**
* Récupération du navigateur de visiteur
*/
function get_navigateur()
{
    if (strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') !== false) // Comparaison à Firefox
    {
        $navigateur = "Mozilla Firefox";
    }
    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Edge") !== false) // Comparaison à Edge
    {
        $navigateur = "Microsoft Edge";
    }
    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) // Comparaison à Opera
    {
        $navigateur = "Opera";
    }
    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) // Comparaison à Chrome
    {
        $navigateur = "Google Chrome";
    }
    elseif (strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') !== false) // Comparaison à Safari
    {
        $navigateur = "Apple Safari";
    }
    else
    {
        $navigateur = "navigateur inconnu"; // Si introuvable "erreur"
    }
    return $navigateur;
}
/*
	Fonction permettant d'afficher la date
*/
function daymonth($lang="fr"){
	
		$j=date("d"); // Jour écrit	
		$s=date("w"); // Date numerique
		$y=date("Y"); // Année
		$m=date("n"); // Mois

	$jour=array("Dimanche","Lundi","Mardi","Mercredi","Jeudi", "Vendredi", "Samedi"); // Liste nom des jours 
	$mois=array(1=>"Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"); // Liste nom des mois
    $datedujour=$jour[$s]." ".$j." ".$mois[$m]." ".$y; // Assemblage des éléments
	return $datedujour; // Renvoyer le résultat 
}
?>
