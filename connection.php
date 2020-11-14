<?php
/*A ENLEVER SI BESOIN DE DEBUGGER (enlève les erreurs php qui seraient montrées à l'utilisateur)*/
error_reporting(E_ERROR | E_PARSE);


if(isset($_POST['login-conn']) && isset($_POST['password-conn'])){

    // connexion à la base de données
    $db_username = '216760_cheval';
    $db_password = 'thibautlevieux';
    $db_name     = 'get-the-flight_bd';
    $db_host     = 'mysql-get-the-flight.alwaysdata.net';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name) or die('Impossible de se connecter à la base de données pour l\'instant. Désolé du dérangement');
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['login-conn']));
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password-conn']));
    
    if($username !== "" && $password !== ""){
        $requete = "SELECT mot_de_passe FROM Utilisateur WHERE login='" . $username . "'";
        $exec_requete = mysqli_query($db,$requete);
        //si il y a une erreur, renvoie FALSE
        if(!$exec_requete){
            echo "Utilisateur inconnu";
        }else{
            $reponse = mysqli_fetch_array($exec_requete);
            // nom d'utilisateur et mot de passe correctes
            if(password_verify($password, $reponse['mot_de_passe'])){
                session_start();
                //on indique que l'on est connecté
                $_SESSION['username'] = $username;
                //header('Location: index.php');
                echo "Connexion réussie";
            }else{
                //mot de passe incorrect
                echo "Mot de passe incorrect";
            }
        }
    }else{
        // utilisateur ou mot de passe vide
        //header('Location: login.php?erreur=2'); 
        echo "Un des champs n'est pas rempli.";
    }
    // fermer la connexion à la base de données
    mysqli_close($db); 
}else{
    echo "Vous n'êtes pas censés être la pas vrai ?";
}
?>