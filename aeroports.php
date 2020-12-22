<?php
session_start();
    
    //récupération de tous les aéroports depuis la base de données
    require_once("php/class/connection_bd.class.php");
    $bd = new ConnectionBD;
    //on cherche à avoir un tableau accessible comme : $airports["region"][0]["nom_aeroport"]
    $airports = [];
    $currentRegion = "";
    if($result = $bd->Get_DB_Connection()->query("SELECT * FROM Aeroport ORDER BY region")){
        //si on est dans une nouvelle région, on ajoute une ligne au tableau
        while($row = $result->fetch_assoc()){
            /*if(empty($currentRegion) || $currentRegion !== $row["region"]){
                $currentRegion = $row["region"];

            }*/
            $airports[$row["region"]][] = $row;
        }
    }
    $bd->Disconnection();
    require_once("includes/header_begin.inc.php");
?>
    <title>Liste des aéroports connus</title>
    <meta name="description" content="Tous les aéroports du site sont disponibles ici. Il y a normalement tous les aéroports de France. Des informations complémentaires, telles que le code de l'aéroport, sa région ou sa ville sont aussi disponibles"/>
<?php
    require_once("includes/header_end.inc.php");
?>

<img id="background-image" src="imgs/background-image-flou.png" alt="arrière plan" />

<div class="row main-content">
	<main class="col-md-9">
        <?php
            if(empty($airports)):
        ?>
        <section class="centered">
            <p>La liste des aéroports n'est pas diponible pour l'instant désolé du dérangement.</p>
        </section>
        <?php
            else:
        ?>
		<section class="centered">
            <h2>Liste des aéroports connus</h2>
            <p>Il est possible de faire une recherche de vols avec tous les aéroports de France métropolitaine significatifs.</p>
            <p>Une grande partie des informations ont été récupérées <a target="_blank" href="https://www.data.gouv.fr/fr/datasets/aeroports-francais-coordonnees-geographiques/">ici</a>.</p>
            <p>En voici la liste avec des détails : </p>
        </section>
        <?php
            foreach($airports as $region => $airport):
        ?>
        <section>
            <h2><?=$region?></h2>
            <table class="table table-striped table-bordered table-dark table-responsive-md">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Code OACI</th>
                        <th>Ville</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($airport as $elt):
                ?>
                    <tr>
                        <td><?=$elt["nom_aeroport"]?></td>
                        <td><?=$elt["code_oaci"]?></td>
                        <td><?=$elt["ville_aeroport"]?></td>
                    </tr>
                <?php
                    endforeach;
                ?>
                </tbody>
            </table>
        </section>
        <?php
            endforeach;
        ?>
        <?php
            endif;
        ?>
       
	</main>

	<aside class="col-md-3">
		<section>
			<h2>Vols populaires</h2>
			<p>Un vol sera affiché à la fois, et il y aura une modification toutes les 30 secondes</p>
		</section>
		<?php
			if(isset($_SESSION["username"])):
		?>
		<section>
			<p style="font-size: 22px;">Bienvenue, <?=$_SESSION["username"]?> !</p>
		</section>
		<?php
			endif;
		?>
	</aside>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/user.js"></script>
</body>

</html>