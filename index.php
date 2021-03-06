<?php
session_start();
require_once('./includes/header_begin.inc.php');
include_once('./php/misc.php');
?>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
<title>Get the flight ! - Accueil</title>
<?php
require_once('./includes/header_end.inc.php');
$currentDate = getCurrentDate();
?>

<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div id="pop-up-save-confirm" class="pop-up pop-up-background">
	<div class="pop-up pop-up-foreground centered">
		<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
			<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
			<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
		</svg>
		<div class="loading not-visible">
			<div></div>
		</div>
		<div class="result" style="padding: 10px;"></div>
	</div>
</div>

<div class="row main-content">
	<main class="col-md-9">
		<section>
			<p class="introduction">Notre site vous permet de rechercher des vols rapidement et dans toute la France métropolitaine. Choisissez un aéroport de départ, un d'arrivée, choisissez une plage horaire et ça y est !</p>
			<p class="introduction">Nous vous souhaitons une bonne visite sur Get the flight !</p>
			<h2>Rechercher un vol</h2>
			<form class="centered" id="search-flight-from">
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label class="input_label" for="lieu-depart">Départ</label>
						<div id="depart-group">
							<input type="text" class="airport-search" list="lieu-depart-results" id="lieu-depart" name="lieu-depart" placeholder="Nom de l'aéroport..." required <?php if (isset($_GET["airportFrom"])) echo "value='" . htmlspecialchars($_GET["airportFrom"], ENT_QUOTES) . "'" ?> />
							<datalist class="airport-datalist" id="lieu-depart-results">
							</datalist>
						</div>
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label class="input_label" for="arrivee">Arrivée</label>
						<input type="text" list="arrivee-results" id="arrivee" class="airport-search" name="arrivee" placeholder="Nom de l'aéroport..." required <?php if (isset($_GET["airportTo"])) echo "value='" . htmlspecialchars($_GET["airportTo"], ENT_QUOTES) . "'" ?> />
						<datalist class="airport-datalist" id="arrivee-results">
						</datalist>
					</div>
				</div>
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label class="select_label" for="date-debut">Du</label>
						<input type="date" id="date-debut" name="date-debut" required value="<?= $currentDate ?>"/>
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label class="select_label" for="date-fin">Au</label>
						<input type="date" id="date-fin" name="date-fin" required value="<?= $currentDate ?>"/>
					</div>
				</div>
				<button type="submit" id="search-flights-button">Rechercher les vols</button>

				<div id="flights">
					<div class="loading not-visible">
						<div></div>
					</div>
					<div class="result">

					</div>
				</div>
			</form>
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
<script src="javascript/user.js"></script>
<script src="javascript/search.js"></script>
<script src="javascript/save.js"></script>
<script>
	function isEmpty(string){
      return !$.trim(string);
  	}
	/* À la fin du chagement de la page, on descend jusqu'au champ de recherche 
	 * si on a déja des champs remplis dedans (si l'utilisateur vient des favoris par exemple) 
	 */
	$(document).ready(function() {
		if(!isEmpty($("#lieu-depart").val())){
			location.replace("#search-flights-button");
		}
	});
</script>
</body>

</html>