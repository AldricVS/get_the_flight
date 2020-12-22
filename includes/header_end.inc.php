</head>

<body>
	<header class="menu-relative">
		<a href="index.php">
			<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 576 512" id="main-icon">
				<!-- Font Awesome Free 5.15.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
				<path d="M480 192H365.71L260.61 8.06A16.014 16.014 0 0 0 246.71 0h-65.5c-10.63 0-18.3 10.17-15.38 20.39L214.86 192H112l-43.2-57.6c-3.02-4.03-7.77-6.4-12.8-6.4H16.01C5.6 128-2.04 137.78.49 147.88L32 256 .49 364.12C-2.04 374.22 5.6 384 16.01 384H56c5.04 0 9.78-2.37 12.8-6.4L112 320h102.86l-49.03 171.6c-2.92 10.22 4.75 20.4 15.38 20.4h65.5c5.74 0 11.04-3.08 13.89-8.06L365.71 320H480c35.35 0 96-28.65 96-64s-60.65-64-96-64z" /></svg>
			<h1 id="main-title">Get the flight</h1>
		</a>
		<svg width="40" height="30" xmlns="http://www.w3.org/2000/svg" id="menu-icon">
			<g stroke-width="1px" stroke="white">
				<line x1="2" x2="38" y1="1" y2="1" stroke-linecap="round" id="upper-line"></line>
				<line x1="2" x2="38" y1="15" y2="15" stroke-linecap="round" id="middle-line"></line>
				<line x1="2" x2="38" y1="29" y2="29" stroke-linecap="round" id="bottom-line"></line>
			</g>
		</svg>
		<div id="menu" class="menu-relative">
			<nav class="menu-relative">
				<ul class="menu-relative">
					<li class="menu-item menu-relative">
						<?php
						if (isset($_SESSION["username"])) :
						?>
							<span class="menu-relative"><?= $_SESSION["username"] ?></span>
							<ul class="menu-relative inner-menu">
								<li class="menu-relative"><a href="favori.php">Favoris</a></li>
								<li class="menu-relative"><a href="vols-sauvegardes.php">Vols sauvegardés</a></li>
								<li class="menu-relative"><a href="deconnection.php">Déconnexion</a></li>
							</ul>
						<?php
						else :
						?>
							<span class="menu-relative">Connexion ou inscription</span>
							<ul class="menu-relative inner-menu">
								<li class="menu-relative"><span id="login-popup-button" class="button">Connexion</span></li>
								<li class="menu-relative"><span id="inscription-popup-button" class="button">Inscription</span></li>
							</ul>
						<?php
						endif;
						?>
					</li>
					<li class="menu-item menu-relative">
						<span class="menu-relative">Divers</span>
						<ul class="menu-relative inner-menu">
							<li class="menu-relative"><a href="./page_contact.php">À propos des créateurs du site</a></li>
							<li class="menu-relative"><a href="./aeroports.php">Aéroports supportés</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
    </header>
<?php
    if (!isset($_SESSION["username"])) :
?>
	<div id="pop-up-login" class="pop-up pop-up-background">
		<div class="pop-up pop-up-foreground centered">
			<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
				<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
				<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
			</svg>
			<h3>Connexion</h3>

			<label class="input_label" for="login-conn">Identifiant <input type="text" name="login-conn" id="login-conn" maxlength="50" required /></label>
			<label class="input_label" for="password-conn">Mot de passe<input type="password" name="password-conn" id="password-conn" maxlength="72" required /></label>
			<button type="button" id="button-connection">Se connecter</button>

			<div class="loading not-visible">
				<div></div>
			</div>
			<div class="result"></div>
		</div>
	</div>

	<div id="pop-up-inscription" class="pop-up pop-up-background">
		<div class="pop-up pop-up-foreground centered">
			<svg class="close-pop-up" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 100 100">
				<line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="10" />
				<line x1="0" y1="100" x2="100" y2="0" stroke="black" stroke-width="10" />
			</svg>
			<h3>Inscription</h3>

			<label class="input_label" for="login-inscription">Identifiant <input type="text" name="login-inscription" id="login-inscription" maxlength="50" required /></label>
			<label class="input_label" for="email-inscription">Adresse e-mail <input type="email" name="email-inscription" id="email-inscription" maxlength="80" required /></label>
			<label class="input_label" for="password-inscription">Mot de passe<input type="password" name="password-inscription" id="password-inscription" maxlength="72" required /></label>
			<label class="input_label" for="passwordConfirm-inscription">Confirmer le mot de passe<input type="password" name="passwordConfirm-inscription" id="passwordConfirm-inscription" maxlength="72" required /></label>
			<button type="button" id="button-inscription">S'inscrire</button>

			<div class="loading not-visible">
				<div></div>
			</div>
			<div class="result"></div>
		</div>
	</div>
<?php
endif;
?>