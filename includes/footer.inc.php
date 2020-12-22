<footer>
	<p class="infoc">Développement Web Avancé</p>
	<?php
	 /*
    	Affichage du jour de la consultation et le navigateur du visiteur
    	*/
	echo '<p class="infoc">'  .daymonth("fr")." - ".$heure = date("H:i")." - ".get_navigateur().   '</p><br />';
	?>
	<?php
	/*
    	Affichage de l'adresse IP du visiteur
  		echo '<p class="infoc"> IP du visiteur : '.$_SERVER['REMOTE_ADDR'].' ---</p>';
  	*/
	?>
</footer>
