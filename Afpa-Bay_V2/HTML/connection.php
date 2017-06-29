<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
FICHIER.PHP QUI PERMET DE VERIFIER L'AUTHENTIFICATION ET ENVOI VERS L'ACCUEIL
SI LOGIN ET MDP CORRESPONDANT A CEUX DE LA BASE DE DONNEES
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->

<?php
session_start();
//Informations d'entrées du serveur + base de données (+ table associée ?)
$_SESSION['serveur'] = "localhost";
$_SESSION['pseudo'] = "root";
$_SESSION['pass'] = "Afp4S3b!";
$_SESSION['baseDonnees'] = "Afpa-Bay";
$_SESSION['nomUser']= filter_input(INPUT_POST, 'pseudoCo', FILTER_SANITIZE_STRING);

//Sécurisation des données saisies pour la connection
$log = htmlspecialchars($_POST['pseudoCo']);
$password = htmlspecialchars($_POST['passwordCo']);


//On récupère nos données de la BDD, de la table des login
try {
    $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $reponse = $bdd->query('SELECT * FROM login WHERE identifiant = "'.$log.'"');
    $donnees = $reponse->fetch(PDO::FETCH_ASSOC);

    // On vérifie les ID et mot de passe de l'utilisateur, si ok on passe à la page d'accueil
    if (isset($donnees['identifiant'])&&($donnees['identifiant'] == $log)&&($donnees['password'] == $password)){
      header('Location: accueil.php');
      exit();
    }
    // sinon on reste sur la page de login
    else {
        header('Location: resultatConnecte.php?res=3');
    }
}
catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

?>
