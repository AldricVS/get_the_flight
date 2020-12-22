/**
 * Ce fichier contient le code géreant l'apparition et la disparition du menu déroulant dans le header.
 * Chaque clic sur la page va lancer une fonction vérifiant si il faut ouvrir ou fermer le menu.
*/

function isWindowSmall(){
	return window.matchMedia("(max-width: 660px)").matches;
}

/*ajout d'un listener lorque l'utilisateur clique sur l'icone de menu*/
$("#menu-icon").on("click", function(){
	$("#menu").toggleClass("menu-clicked");
	$("#menu-icon").toggleClass("menu-clicked");

	//si la fenetre est assez petite
	if(isWindowSmall()){
		$("html").toggleClass("block-scroll");
	}
});

/*Boutons d'ouverture / fermeture des pop-ups (connexion / inscription / suppresion favori)*/
$("#login-popup-button").on("click", function(){
	$("#pop-up-login").addClass("visible");
});

$("#Suppression-popup-button").on("click", function(){
	$("#pop-up-suppression").addClass("visible");
});

//si l'utilisateur clique sur un des boutons "Supprimer" des vols (sur la page "vols-sauvegardes")
//faire apparaitre le pop-up et renseigner le numéro du vol sauvegardé
$(".supp-vol-button").click(function(e){
    var popUp = $("#pop-up-supp-vol");
    popUp.addClass("visible");
    popUp.find("input:hidden").val($(this).siblings("input:hidden").val());
});

$("#inscription-popup-button").on("click", function(){
	$("#pop-up-inscription").addClass("visible");
});

$(".close-pop-up").each(function(){
	$(this).on("click", function(){
		$(this).next(".loading").addClass("not-visible");
		$(this).closest(".pop-up-background").removeClass("visible");
	});
});


/*
 * Lors du redimensionnement de la fenêtre, on vérifie si le menu est ouvert ou non afin d'éviter
 * de potentiels bugs d'affichage si le visiteur ouvre le menu et change de taille de fenêtre
 */
$(window).on('resize', function(){
	if($("#menu").hasClass("menu-clicked")){
		if(isWindowSmall()){
			$("html").addClass("block-scroll");
		}else{
			$("html").removeClass("block-scroll");
		}
	}
});

