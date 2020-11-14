<?php
session_start();
include('./includes/header.inc_index.php');
?>

<!--PARTIE PRINCIPALE-->

<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div class="row main-content">
	<main class="col-md-9">
		<section>
			<p class="introduction">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tellus ante, sollicitudin a ex vitae, consectetur convallis diam. Maecenas fringilla mattis varius. Cras sit amet eleifend purus.</p>
			<h2>Rechercher un vol</h2>
			<form class="centered" onsubmit="return searchFlights();">
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label class="input_label" for="lieu-depart">Départ</label>
						<div id="depart-group">
							<input type="text" class="airport-search" list="lieu-depart-results" id="lieu-depart" name="lieu-depart" required />
							<datalist id="lieu-depart-results">
							</datalist>
							<button type="button">Trouver avec ma position</button>
						</div>
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label class="input_label" for="arrivee">Arrivée</label>
						<input type="text" list="arrivee-results" id="arrivee" class="airport-search" name="arrivee" required />
						<datalist id="arrivee-results">
						</datalist>
					</div>
				</div>
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label class="select_label" for="date-debut">Du</label>
						<!--Mettre date et heure d'ajd-->
						<input type="date" id="date-debut" name="date-debut" required />
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label class="select_label" for="date-fin">Au</label>
						<!--Mettre dans une heure-->
						<input type="date" id="date-fin" name="date-fin" required />
					</div>
				</div>
				<button type="submit">Rechercher les vols</button>

				<div id="flights">
					<div class="loading"></div>
					<div class="row">
						<p class="col-md-8" id="number-flights">Nombre de réultats : 20</p>
						<div class="col-md-4">
							<!-- !! Listener onCheck nécéssaire-->
							<input type="checkbox" id="fav-checkbox" name="fav-checkbox" />
							<label for="fav-checkbox"></label>
						</div>
					</div>
					<div class="flight_result">
						<img src="imgs/plane.svg" alt="logo" class="logo-result"/>
						<p class="result-date">Date</p>
						<p><span class="result-airport-begin">horaires départ</span> ⇨ <span class="result-airport-end">horaires arrivée</span></p>
						<p><span class="result-timetable-begin">horaires départ</span> ⇨ <span class="result-timetable-end">horaires arrivée</span></p>
						<p><span class="result-compagny">Compagnie aérienne</span></p>
						<button type="button">Sauvegarder ce vol</button>
					</div>
				</div>
			</form>
		</section>
	</main>

	<aside class="col-md-3">
		<section>
			<h2>Vols populaires</h2>
			<p>Un vol sera affiché à la fois, et il y aura une modification toutes les 30 secondes</p>
		</section>
	</aside>
</div>

<!--FOOTER-->
<footer>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/user.js"></script>
<script src="javascript/searchFields.js"></script>
<script src="javascript/flightsResults.js"></script>
</body>

</html>