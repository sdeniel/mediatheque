<?php
session_start();

$bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fonction pour supprimer un film

$req = $bdd->prepare('DELETE FROM ListeFilm WHERE id = '.$_GET['edit']);
$req->execute();
header('Location: accueil.php');
 ?>
