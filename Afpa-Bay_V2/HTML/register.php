<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
FICHIER.PHP QUI PERMET DE S'ENREGISTRER DANS LA BASE DE DONNEES
VERIFICATION QUE CE N'EST PAS UN BOT AVEC UN CAPTCHA
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
<?php
session_start();
//Informations d'entrées du serveur + base de données (+ table associée ?)
$_SESSION['serveur'] = "localhost";
$_SESSION['pseudo'] = "root";
$_SESSION['pass'] = "Afp4S3b!";
$_SESSION['baseDonnees'] = "Afpa-Bay";
$_SESSION['tableLogin'] = 'login';

//Sécurisation des données saisies pour l'inscription'
$loginIns = filter_input(INPUT_POST, 'loginIns', FILTER_SANITIZE_STRING);
$pseudoIns = filter_input(INPUT_POST, 'pseudoIns', FILTER_SANITIZE_STRING);
$passwordIns = filter_input(INPUT_POST, 'passwordIns', FILTER_SANITIZE_STRING);
$emailIns = filter_input(INPUT_POST, 'emailIns', FILTER_VALIDATE_EMAIL);
$captcha = filter_input(INPUT_POST, 'verif_code', FILTER_SANITIZE_STRING);

if(isset($captcha) && ($captcha == $_SESSION['aleat_nbr']))
{
  // Test Email valide ou non
    if (!$emailIns) {
        header('Location: resultatConnecte.php?res=0');
    }
    else {
        try {
            $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Préparation d'insertion, création des marqueurs
            $req = $bdd -> prepare (
                'INSERT INTO '.$_SESSION['tableLogin'].'(identifiant, password, pseudo, email)
                VALUES(:identifiant, :password, :pseudo, :email)');
            // lier nos marqueurs à nos variables (protection)
            $req->bindParam(':identifiant', $loginIns);
            $req->bindParam(':password', $passwordIns);
            $req->bindParam(':pseudo', $pseudoIns);
            $req->bindParam(':email', $emailIns);
            // Execution des instructions
            $req->execute();
            header('Location: resultatConnecte.php?res=1');
          }
          catch (Exception $e) {
              echo 'Exception reçue : ',  $e->getMessage(), "\n";
          }
     }
}
if(isset($captcha) && ($captcha != $_SESSION['aleat_nbr']))
{
  header('Location: resultatConnecte.php?res=2');
}


?>
