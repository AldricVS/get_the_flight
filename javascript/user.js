/**
 * Fonctions utilisées pour gérer la connexion / inscription avec l'utilisateur
 */

$("#button-connection").click(function () {
    /*On fait apparaitre le chargement*/
    var buttonConnection = $(this);
    buttonConnection.next(".loading").removeClass("not-visible");

    /*On récupère les champs nécéssaires pour se connecter*/
    var userName = $("#login-conn").val();
    var password = $("#password-conn").val();
    console.log("Verif attributs");
    var errors = "";

    if (userName == "") {
        errors += "Identifiant non renseigné.</br>";
    }
    if (password == "") {
        errors += "Mot de passe non renseigné.</br>";
    }

    if (userName.length > 50) {
        errors += "Identifiant trop long.</br>";
    }
    if (password.length > 72) {
        errors += "Mot de passe trop long.</br>";
    }

    if (errors.length != 0) {
        buttonConnection.siblings(".result").html(errors);
        buttonConnection.siblings(".loading").addClass("not-visible");
    } else {
        /*Maintenant on peut lancer la requête Ajax*/
        $.post("connection.php", { "login-conn": userName, "password-conn": password }, function (data) {
            buttonConnection.siblings(".loading").addClass("not-visible");
            buttonConnection.siblings(".result").html(data);
            //si la connexion  est réussie, on recharge la page afin que php puisse "apercevoir" l'utilisateur
            if(data == "Connexion réussie"){
                Location.reload();
            }
        });
    }
});

$("#button-inscription").click(function () {
    /*On fait apparaitre le chargement*/
    var buttonConnection = $(this);
    buttonConnection.siblings(".loading").removeClass("not-visible");

    /*On récupère les champs nécéssaires pour se connecter*/
    var userName = $("#login-inscription").val();
    var email = $("#email-inscription").val();
    var password = $("#password-inscription").val();
    var passwordConfirm = $("#passwordConfirm-inscription").val();

    var errors = "";

    /*Vérifications de taille*/
    if (userName == "") {
        errors += "Identifiant non renseigné.</br>";
    }
    if (email == "") {
        errors += "Adresse e-mail non fournie.</br>";
    }
    if (password == "") {
        errors += "Mot de passe non renseigné.</br>";
    }
    if (passwordConfirm == "") {
        errors += "Mot de passe de confirmation non renseigné.</br>";
    }

    if (userName.length > 50) {
        errors += "Identifiant trop long.</br>";
    }
    if (email.length > 80) {
        errors += "Adresse e-mail trop longue.</br>";
    }
    if (password.length > 72) {
        errors += "Mot de passe trop long.</br>";
    }

    if (passwordConfirm.length > 72) {
        errors += "Mot de passe de confirmation trop long.</br>";
    }

    if (errors.length != 0) {
        buttonConnection.siblings(".result").html(errors);
    } else {
        /*Maintenant on peut lancer la requête Ajax*/
        $.post("inscription.php",
            { "login-inscription": userName, "email-inscription": email, "password-inscription": password, "passwordConfirm-inscription": passwordConfirm },
            function (data) {
                buttonConnection.siblings(".loading").addClass("not-visible");
                buttonConnection.siblings(".result").html(data);
                if (data == "Inscription réussie") {
                    Location.reload(true);
                }
            });
    }
});