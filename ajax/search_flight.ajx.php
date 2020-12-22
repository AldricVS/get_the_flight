<?php
session_start();
/**fromAirport: fromAirport,
                toAirport: toAirport,
                dateFrom: dateFromString,
                dateTo */
if (isset($_POST["fromAirport"]) && isset($_POST["toAirport"]) && isset($_POST["dateFrom"]) && isset($_POST["dateTo"])) {

	//process data s'occupe de faire l'appel à l'API
	require_once('../php/class/process_data.class.php');
	require_once('../php/class/data_reading.class.php');
	require_once('../php/data_manage.php');
	require_once('../php/misc.php');

	$process_data = new ProcessData;
	$data_reading = new DataReading;

	//insertion des infos, on sait que les dates sont bonnes 
	$process_data->setAeroportDepart($_POST["fromAirport"]);
	$process_data->setAeroportArrivee($_POST["toAirport"]);
	$process_data->setDate($_POST["dateFrom"]);
	//Lancement de la recherche
	$process_data->DataStorage();

	//3 codes "d'erreur" : 
	//0 = tout va bien
	//1 = le nom d'un des aéroports n'est pas reconnu
	//2 = l'API a eu un problème 
	$searchResults = NULL;
	switch ($process_data->getCodeError()) {
		case 0:
			$searchResults = $process_data->getDataForSearch();
			break;
		case 1:
			echo "<p>Le nom de l'aéroport de départ ou de celui d'arrivée n'est pas reconnu. Utilisez l'auto complétion pour éviter tout ambiguïté.</p>";
			break;
		case 2:
			echo "<p>L'accès à l'API est impossible pour l'instant. Réessayez plus tard.</p>";
			break;
		default:
			//normalement impossible d'arriver ici (normalement...)
			echo "<p>Il y a eu un problème inconnu lors de la recherche...</p>";
			break;
	}

	//on vérifie si le tableau est vide ou jamais initialisé (donc == NULL)
	if (!empty($searchResults)) {
		

		if (isset($_SESSION["username"])) {
			//on regarde si le trajet est en favori
			$checkedAttribute = "";
			if (IsTravelInFavorite($data_reading, $process_data->getCodeStart(), $process_data->getCodeFinish(), $_SESSION["username"])) {
				$checkedAttribute = "checked";
			}
			//on va pouvoir commencer à afficher les résultats
			echo 	"<div class='row'>\n\t
				<p class='col-md-8' id='number-flights'>Nombre de résultats : " . count($searchResults) . "</p>\n\t
				<div class='col-md-4'>\n\t\t
					<span>Ajouter en favori</span>\n\t\t
					<input type='checkbox' id='fav-checkbox' name='fav-checkbox' $checkedAttribute/>\n\t\t
					<label for='fav-checkbox'></label>\n\t\t
					<input type='hidden' id='aiport-start-fav' value='" . $process_data->getCodeStart() . "'/>\n\t
					<input type='hidden' id='aiport-end-fav' value='" . $process_data->getCodeFinish() . "'/>\n\t
				</div>\n
				</div>\n";

				foreach ($searchResults as $result) {
					echo 	"<div class=\"flight_result\">\n\t
								<img src=\"imgs/plane.svg\" alt=\"logo\" class=\"logo-result\"/>\n\t
								<p class=\"result-date\">" . convertDateFormat($result["date_dep"]) . "</p>\n\t
								<p><span class=\"result-airport-begin\">" . $_POST["fromAirport"] . "</span> (Porte <span class=\"result-door-begin\">" . $result["porte_depart"] . "</span>) 
								⇨ <span class=\"result-airport-end\">" . $_POST["toAirport"] . "</span> (Porte <span class=\"result-door-end\">" . $result["porte_arrive"] . "</span>)</p>\n\t
								<p><span class=\"result-timetable-begin\">" . $result["heure_dep"] . "</span> ⇨ <span class=\"result-timetable-end\">" . $result["heure_arr"] . "</span></p>\n\t
								<p><span class=\"result-compagny\">" . $result["airline"] . "</span></p>\n\t
								<button type=\"button\" class=\"save-flight-button\">Sauvegarder ce vol</button>\n
									</div>\n";
			}
		}else{ 
			//l'utilisateur n'est pas connecté
				echo 	"<div class='row'>\n\t
							<p class='col-md-8' id='number-flights'>Nombre de résultats : " . count($searchResults) . "</p>\n\t
							<div class='col-md-4'>\n\t\t
								<span>Vous devez être connecté afin d'ajouter ce trajet en favori</span>
							</div>\n
						</div>\n";

				foreach ($searchResults as $result) {
					echo 	"<div class=\"flight_result\">\n\t
								<img src=\"imgs/plane.svg\" alt=\"logo\" class=\"logo-result\"/>\n\t
								<p class=\"result-date\">" . convertDateFormat($result["date_dep"]) . "</p>\n\t
								<p><span class=\"result-airport-begin\">" . $_POST["fromAirport"] . "</span> (Porte <span class=\"result-door-begin\">" . $result["porte_depart"] . "</span>) 
								⇨ <span class=\"result-airport-end\">" . $_POST["toAirport"] . "</span> (Porte <span class=\"result-door-end\">" . $result["porte_arrive"] . "</span>)</p>\n\t
								<p><span class=\"result-timetable-begin\">" . $result["heure_dep"] . "</span> ⇨ <span class=\"result-timetable-end\">" . $result["heure_arr"] . "</span></p>\n\t
								<p><span class=\"result-compagny\">" . $result["airline"] . "</span></p>\n\t
							</div>\n";
			}
		}
	} else {
		//si on est ici, on a pas trouvé de résultats
		if (isset($_SESSION["username"])) {
			//on regarde si le trajet est en favori
			$checkedAttribute = "";
			if (IsTravelInFavorite($data_reading, $process_data->getCodeStart(), $process_data->getCodeFinish(), $_SESSION["username"])) {
				$checkedAttribute = "checked";
			}
			echo 	"<div class='row'>\n\t
					<p class='col-md-8' id='number-flights'>Aucun vol trouvé</p>\n\t
					<div class='col-md-4'>\n\t\t
						<span>Ajouter en favori</span>\n\t\t
						<input type='checkbox' id='fav-checkbox' name='fav-checkbox' $checkedAttribute/>\n\t\t
						<label for='fav-checkbox'></label>\n\t\t
						<input type='hidden' id='aiport-start-fav' value='" . $process_data->getCodeStart() . "'/>\n\t
						<input type='hidden' id='aiport-end-fav' value='" . $process_data->getCodeFinish() . "'/>\n\t
					</div>\n
				</div>\n";
		}else{
			echo 	"<div class='row'>\n\t
				<p class='col-md-8' id='number-flights'>Aucun vol trouvé</p>\n\t
				<div class='col-md-4'>\n\t\t
					<span>Vous devez être connecté afin d'ajouter ce trajet en favori</span>\n\t\t
				</div>\n
			</div>\n";
		}
		
	}
}
