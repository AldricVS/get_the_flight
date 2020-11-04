<?php
/*A METTRE EN COMMENTAIRE SI BESOIN DE DEBUGGER (enlève les erreurs php qui seraient montrées à l'utilisateur)*/
//error_reporting(E_ERROR | E_PARSE);

if(isset($_POST['login-inscription']) && isset($_POST['email-inscription']) && isset($_POST['password-inscription']) && isset($_POST['passwordConfirm-inscription'])){
    if($_POST['login-inscription'] == "" || $_POST['email-inscription'] == "" || $_POST['password-inscription'] == "" || $_POST['passwordConfirm-inscription'] == ""){
        //tous les champs ne sont pas remplis
        echo "Tous les champs ne sont pas remplis";
    }else{

    }

    //vérification de la conformité du mail
    $email = htmlspecialchars($_POST['email-inscription']);
    if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $email)){

        //vérification que les deux mots de passe sont identique
        if($_POST['password-inscription'] == $_POST['passwordConfirm-inscription']){

            // hachage du mot de passe
            $pass = password_hash($_POST['password-inscription'], PASSWORD_BCRYPT);
            unset($_POST['password-inscription']);
    
            // connexion à la base de données
            $db_username = '216760_cheval';
            $db_password = 'thibautlevieux';
            $db_name     = 'get-the-flight_bd';
            $db_host     = 'mysql-get-the-flight.alwaysdata.net';
            $db = mysqli_connect($db_host, $db_username, $db_password,$db_name) or die('Impossible de se connecter à la base de données pour l\'instant. Désolé du dérangement');
            

            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['login-conn']));
            $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email']));
            $password = mysqli_real_escape_string($db,htmlspecialchars($pass));
    
            $requeteN = "SELECT count(*) FROM utilisateur WHERE login = '".$username."' ";
            $exec_requeteN = mysqli_query($db,$requeteN);
            $reponse = mysqli_fetch_array($exec_requeteN);
            $count = $reponse['count(*)'];
            if($count == 0){
                $requete = "INSERT INTO utilisateur (login, password, mail) VALUES ('" . $username ."','" . $password . "','" . $email . "')";
                $exec_requete = mysqli_query($db,$requete);
                echo "Inscription réussie";
                
            }else{
                // login déja utilisé
                echo "Le Identifiant est déjà utilisé";
            }
    
            // fermer la connexion à la base de données
            mysqli_close($db); 
        }else{
            // les 2 mots de passe ne sont pas identique
            echo "Les deux mots de passe ne sont pas identiques";
        }
    }else{
        //adresse mail invalide
        echo "L'adresse mail est invalide";
    }
}else{
    echo "Vous n'êtes pas censés être la pas vrai ?";
}
?>