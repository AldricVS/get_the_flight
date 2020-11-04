<?php
include('./includes/header.inc_index.php');
?>

<!--PARTIE PRINCIPALE-->

<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div id="pop-up-login" class="pop-up pop-up-background">
	<div class="pop-up pop-up-foreground centered">
		<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
			<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
			<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
		</svg>
		<h3>Connexion</h3>
		<label for="login-conn">Identifiant <input type="text" name="login-conn" id="login-conn" maxlength="50" required/></label>
		<label for="password-conn">Mot de passe<input type="password" name="password-conn" id="password-conn" maxlength="72" required/></label>
		<button type="button" id="button-connection">Se connecter</button>
		<div class="loading not-visible">
			<div></div>
		</div>
		<div class="result" style="color: red;"></div>
	</div>
</div>

<div id="pop-up-inscription" class="pop-up pop-up-background">
	<div class="pop-up pop-up-foreground centered">
		<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
			<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
			<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
		</svg>
		<h3>Inscription</h3>
		<label for="login-inscription">Identifiant <input type="text" name="login-inscription" id="login-inscription" maxlength="50" required/></label>
		<label for="email-inscription">Adresse e-mail <input type="mail" name="email-inscription" id="email-inscription" maxlength="80" required/></label>
		<label for="password-inscription">Mot de passe<input type="password" name="password-inscription" id="password-inscription" maxlength="72" required/></label>
		<label for="passwordConfirm-inscription">Confirmer le mot de passe<input type="password" name="passwordConfirm-inscription" id="passwordConfirm-inscription" maxlength="72" required/></label>
		<button type="button" id="button-inscription">S'inscrire</button>
		<div class="loading not-visible">
			<div></div>
		</div>
		<div class="result" style="color: red;"></div>
	</div>
</div>

<div class="row main-content">
	<main class="col-md-9">
		<section>
			<p class="introduction">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tellus ante, sollicitudin a ex vitae, consectetur convallis diam. Maecenas fringilla mattis varius. Cras sit amet eleifend purus.</p>
			<h2>Rechercher un vol</h2>
			<form class="centered">
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label for="lieu-depart">Départ</label>
						<div id="depart-group">
							<input type="text" id="lieu-depart" name="lieu-depart" required />
							<button type="button">Trouver avec ma position</button>
						</div>
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label for="arrivee">Arrivée</label>
						<input type="text" id="arrivee" name="arrivee" required />
					</div>
				</div>
				<div id="compagny">
					<label for="compagnie-combobox" style="display:inline;">Compagnie aerienne</label>
					<select name="compagnie" id="compagnie-combobox">
						<option value="0">N'importe laquelle</option>
						<option value="Air France">Air France</option>
						<option value="Easyjet">Easyjet</option>
						<option value="Ryanair">Ryanair</option>
					</select>
				</div>
				<div class="row">
					<!--Partie gauche du formulaire-->
					<div class="col-md-6">
						<label for="date-debut">Du</label>
						<!--Mettre date et heure d'ajd-->
						<input type="date" id="date-debut" name="date-debut" required />
					</div>
					<!--Partie droite du formulaire-->
					<div class="col-md-6">
						<label for="date-fin">Au</label>
						<!--Mettre dans une heure-->
						<input type="date" id="date-fin" name="date-fin" required />
					</div>
				</div>
				<button type="submit">Rechercher les vols</button>

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
</body>

</html>