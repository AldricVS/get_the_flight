/**
 * Fichier contenant tout ce qui est relatif à la recherche de vols (lancement de la recherche, ajout en favori, sauvegarde...)
 */

/**
 * Lance la recherche en asynchrone des vols. 
 * Si un problème survient, renvoie "true" afin de rafraichir la page.
 */
function searchFlights(event){
    console.log("recherche en cours...");
    //on prend ce qu'il y  a dans les champs
    var airportStart = $("#lieu-depart").val();
    var airportEnd = $("#lieu-arrivee").val();
    return false;
}