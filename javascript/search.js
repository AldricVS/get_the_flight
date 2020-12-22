/**
 * Tout ce qui s'approche à la recherche des vols (suggestions de ) 
 */

/*Pour éviter tout problème de cache, on va supprimer tout ce qui est dans les datalists des champs d'aéroport*/
$("airport-datalist").empty();

$(".airport-search").on("input", function(){
    /* On veut avoir la liste des aéroports qui correspondent à ce qu'écrit l'utilisateur.
     * Pour cela, on va récupérer le texte et l'envoyer à un script php, qui va nous renvoyer une liste d'options,
     * qu'on aura plus qu'à insérer cette liste dans la datalist associée à cet input.
     */
    
    var inputField = $(this);
    var inputFieldValue = inputField.val();

    //si le champ est vide, on vide aussi la datalist 
    if(inputFieldValue == ""){
        console.log("erase all");
        inputField.next("datalist").empty();
    }else{
        $.post("ajax/search-airport.ajx.php", {"airport-name": inputFieldValue}, function(data){
            inputField.next("datalist").html(data);
        });
    }
});

$("#search-flight-from").submit(function (e) { 
    let flightDivId = "#flights";
    //nous ne voulons pas que le navigateur rafrachisse la page
    e.preventDefault();
    var flightDiv = $(flightDivId);
    var flightResultsDiv = flightDiv.find(".result");
    flightResultsDiv.empty();
    //on fait apparaitre l'icone de chargement, le temps que la recherche se fasse
    flightDiv.find(".loading").removeClass("not-visible");

    //nous allons vérifier si la date de départ est antérieure à la date d'arrivée
    var dateFromString = $("#date-debut").val();
    var dateToString = $("#date-fin").val();
    var dateFrom = new Date(dateFromString);
    var dateTo = new Date(dateToString);

    //les '+' sont nécéssaires pour comparer si elles sont égales (vérifie les dates avec le temps epoch)
    if(+dateFrom <= +dateTo){
        //on récupère l'aéroport de départ et d'arrivée 
        var fromAirport = $("#lieu-depart").val();
        var toAirport = $("#arrivee").val();

        //et on lance la requête AJAX
        $.post("ajax/search_flight.ajx.php", 
            {
                fromAirport: fromAirport,
                toAirport: toAirport,
                dateFrom: dateFromString,
                dateTo: dateToString
            },
            function (data) {
                flightDiv.find(".loading").addClass("not-visible");
                flightResultsDiv.html(data);
            }
        );
    }else{
        flightDiv.find(".loading").addClass("not-visible");
        flightResultsDiv.html("<p>La date de fin ne doit pas être antérieure à celle du début</p>");
    }

    //on va jusqu'au champ de recherche avec un défilement fluide
    document.querySelector(flightDivId).scrollIntoView({
        behavior: 'smooth',
        block: "start", 
    });
});
