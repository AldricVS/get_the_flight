<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: index.php");
}
$user = $_SESSION["username"];

require_once("php/class/data_reading.class.php");
require_once("php/data_manage.php");
require_once("php/misc.php");

$data_reading = new DataReading;

//supprimer le vol selectionnné si l'utilisateur a cliqué sur le pop-up
if (isset($_POST["number-flight"])) {
	require_once("php/class/data_delete.class.php");
	$data_delete = new DataDelete;
	DeleteSauve($data_reading, $data_delete, $_SESSION["username"], $_POST["number-flight"]);
	unset($_POST["number-flight"]);
	header("Location: vols-sauvegardes.php");
}



//try to get all saved flights of user : 


$savedFlights = VolSauvByUser($data_reading, $user);

require_once("includes/header_begin.inc.php");
?>
<title>Vols sauvegardés par <?= $user ?></title>
<meta name="description" content="Vous pouvez afficher vos vols sauvegardés. N'hésitez pas à faire le ménage si ils ne vous intéresse plus." />
<?php
require_once("includes/header_end.inc.php");
?>


<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div id="pop-up-supp-vol" class="pop-up pop-up-background">
	<div class="pop-up pop-up-foreground centered">
		<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
			<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
			<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
		</svg>
		<h3>Supprimer le vol ?</h3>
		<form action="vols-sauvegardes.php" method="POST">
			<input type="hidden" name="number-flight" />
			<p>Voulez-vous vraiment supprimer ce vol ?</p>
			<p class="empty-space">L'action sera irréversible.</p>
			<button type="submit" id="supp-vol-button">Supprimer</button>
		</form>
		<div class="loading not-visible">
			<div></div>
		</div>
		<div class="result"></div>
	</div>
</div>

<div class="row main-content">
	<main class="col-md-9">
		<section>
			<h2>Vol(s) sauvegardé(s) de <?= $user ?> :
				<?php
				if (is_array($savedFlights)) {
					$arr_length = count($savedFlights);
					echo "$arr_length";
				} else {
					echo "0";
				}
				?> </h2>
			<div id="flights">
				<?php
				if (!is_array($savedFlights)) { ?>
					<div class="flight_result centered">
						<p><?= $savedFlights ?></p>
					</div>
					<?php	} else {
					// retourne au format : numero_vol,login,date_depart,date_arrivee,compagnie,porte_départ,
					//porte_arrive,id_trajet,nom_aeroport,ville_aeroport,region,nom_aeroport1,ville_aeroport1,region1
					for ($i = 0; $i < count($savedFlights); $i++) :
						$split = explode(",", $savedFlights[$i]);
						$nbFlight = intval($split[0]);
						$fromDate = explode(" ", $split[2]);
						$toDate = explode(" ", $split[3]);
						$compagny = $split[4];
						$fromDoor = $split[5];
						$toDoor = $split[6];
						$fromAirportName = $split[8];
						$toAirportName = $split[9];

					?>

						<div class="flight_result centered">
							<input type="hidden" value="<?= $nbFlight ?>" />
							<img src="imgs/plane.svg" alt="logo" class="logo-result" />
							<p class="result-date">Date du vol : <?= convertDateFormat($fromDate[0]) ?></p>
							<p><span class="result-airport-begin"><?= $fromAirportName ?></span> ⇨ <span class="result-airport-end"><?= $toAirportName ?></span></p>
							<p><span class="result-timetable-begin"><?= $fromDate[1] ?></span> ⇨ <span class="result-timetable-end"><?= $toDate[1] ?></span></p>
							<p><span class="result-compagny">Vol assuré par la compagnie <?= $compagny ?></span></p>
							<button type="button" class="supp-vol-button">Supprimer ce vol</button>
						</div>
				<?php
					endfor;
				}
				?>
			</div>
		</section>
	</main>

	<?php
	include("includes/aside.inc.php");
	?>
</div>
<?php
include("includes/footer.inc.php");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="javascript/menu.js"></script>
</body>

</html>