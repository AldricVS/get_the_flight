<?php
session_start();
require_once('./php/class/data_reading.class.php');
require_once('./php/data_manage.php');
require_once('./includes/header_begin.inc.php');
if(!isset($_SESSION['username'])){
	header('Location: ./index.php');
}
?>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
<title>Vols favoris</title>
<?php
require_once('./includes/header_end.inc.php');
?>
<body>
<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div id="pop-up-suppression" class="pop-up pop-up-background">
	<div class="pop-up pop-up-foreground centered">
		<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
			<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
			<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
		</svg>
		<h3>Suppression des favoris</h3>

		<p id ="suppression_pop_up_text">Etes-vous de vouloir supprimer ce vol de vos favori ?</p>
		<button type="button" id="">Supprimer</button>

		<div class="loading not-visible">
			<div></div>
		</div>
		<div class="result"></div>
	</div>
</div>

<div class="row main-content">
	<main class="col-md-9">
		<section>
			<h2>Vol favoris de <?=$_SESSION["username"]?></h2>
			<form class="centered">
				<div id="flights">
					<div class="loading"></div>
						<?php
							$data_reading = new DataReading;
							$user = $_SESSION["username"];
							$user_favorites_routes = FavoritesTravelByLogin($data_reading,$user);
							$user_favorites_routes_lenght=count($user_favorites_routes);//nombre de favoris
							for($i=0; $i < $user_favorites_routes_lenght;$i++){
								$infomartionAirport = explode(",",$user_favorites_routes[$i]);
								$departureAirport = $infomartionAirport[1];//aéroport de départ
								$arrivalAirport = $infomartionAirport[2];//aéroport d'arrivée
								echo'<div class="flight_result">';
									echo'<img src="imgs/plane.svg" alt="logo" class="logo-result"/>';
									echo'<p><span class="result-airport-begin">'.$departureAirport.'</span> ⇨ <span class="result-airport-end">'.$arrivalAirport.'</span></p>';
									echo'<button type="button" id="Suppression-popup-button">Supprimer des favoris</button>';
								echo'</div>';
							}
						?>
				</div>
			</form>
		</section>
	</main>
</div>
<!--FOOTER-->
<footer>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/user.js"></script>
</body>

</html>