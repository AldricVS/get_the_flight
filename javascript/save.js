/**
 * Listeners des boutons "Sauvegarder vol" et de la case à cocher "trajet en favori"
 */

$('#flights').on('change', "#fav-checkbox", function () {
    console.log("Favorite state changed");
    //on récupère les codes oaci de départ et d'arrivée, 
    //si on ne les trouve pas, on arrête tout
    var icaoFrom = $(this).siblings("#aiport-start-fav").val();
    var icaoTo = $(this).siblings("#aiport-end-fav").val();

    if (icaoFrom.length != 4 || icaoTo.length != 4) {
        console.error("Could not find ICAO codes to manage favorites");
    } else {
        //on créé l'objet
        var data = {
            icaoFrom: icaoFrom,
            icaoTo: icaoTo
        };

        //on regarde si le checkbox est coché ou non
        if ($(this).is(':checked')) {
            //appel de la fonction d'ajout du favori
            $.post("ajax/add_fav.ajx.php", data,
                function (data) {
                    console.info(data);
                }
            );
        } else {
            //appel de la fonction de supression du favori
            $.post("ajax/del_fav.ajx.php", data,
            function (data) {
                console.info("Favorite deleted");
                console.log(data);
            }
        );
        }
    }
});

/**
 * vérification de la présence de toutes les informations nécessaires
 *      $_SESSION["username"] : si un utilisateur est connecté
 *      $_POST["nameAirportFrom"] : nom de l'aéroport de départ
 *      $_POST["nameAirportTo"] : nom de l'aéroport d'arrivé
 *      $_POST["departureDate"] : date du départ
 *      $_POST["arrivalDate"] : date d'arrivé'
 *      $_POST["airline"] : nom de la compagnie aérienne
 *      $_POST["departureTerminal"] : terminal du départ
 *      $_POST["arrivalTerminal"] : terminal d'arrivé
 */

$('#flights > .result').on('click', ".save-flight-button", function () {
    //alert("SAUVEGARDE VOL !");

    //on créé le tableau de données à envoyer 
    var flight = $(this).parent(".flight_result");

    var flightData = {
        nameAirportFrom: flight.find(".result-airport-begin").html(),
        nameAirportTo: flight.find(".result-airport-end").html(),
        departureDate: flight.children(".result-date").html(),
        arrivalDate: flight.children(".result-date").html(),
        airline: flight.find(".result-compagny").html(),
        departureTerminal: flight.find(".result-door-begin").html(),
        arrivalTerminal: flight.find(".result-door-end").html(),
        timetableStart: flight.find(".result-timetable-begin").html(),
        timetableEnd: flight.find(".result-timetable-end").html()
    }

    console.log(flightData);

    //on fait apparaitre le pop up de resultat tout en lancant la reqêuete ajax
    var popUp = $("#pop-up-save-confirm");
    var loadingIcon = popUp.children(".loading");
    popUp.addClass("visible");
    loadingIcon.removeClass("not-visible");
    $.post("ajax/save_flight.ajx.php", flightData,
        function (data) {
            loadingIcon.addClass("not-visible");
            console.log(data);
            popUp.find(".result").html(data);
        }
    );
});