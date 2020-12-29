<aside class="col-md-3">
	<section>
		<h2>Trajets populaires : </h2>
		<div id="popular-flights" class="centered">
			<?php 
				require_once('php/data_manage.php');
				require_once('php/class/data_reading.class.php');
				require_once('php/class/fonctions.class.php');
				$data_reading = new DataReading();
				$fonctions = new Fonctions();
				$favorites_travel = PodiumFavorites($data_reading,$fonctions);
				for($i = 0; $i < count($favorites_travel); $i++):
					$travel = explode(',', $favorites_travel[$i]);
            ?>
            <div>
			    <p class="podium_favorite">
                    <span class="trav-airport-begin"><?=$travel[0]?></span> ⇨ <span class="trav-airport-end"><?= $travel[1] ?></span>
                </p>
                <button type="button" class="podium-search-button">Voir les vols</button>
            </div>
			<?php
				endfor;
			?>
		</div>
	</section>
    <?php
        //affichage du nom de l'utilisateur si il est connecté
	    if (isset($_SESSION["username"])) :
	?>
		<section>
			<p>Bienvenue, <?=$_SESSION["username"] ?> !</p>
		</section>
	<?php
	    endif;
	?>
</aside>