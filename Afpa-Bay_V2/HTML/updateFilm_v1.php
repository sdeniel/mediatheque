<?php
 session_start();
 ?>
 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouveau film &mdash; Afpa-Bay</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css">
		<link rel="stylesheet" href="../CSS/add.css">
	</head>

	<body>
		<header>
			<img alt="Logo Afpa-Bay" src="../IMG/logo.png" /></a>
			<h1>The Afpa Bay</h1>
			<a href="accueil.php"><img alt="Logo Afpa-Bay" src="../IMG/logo.png" /></a>
		</header>
		<main>
<!--///////////////////////////////////////////////////////////////////////////
//        Partie de PHP qui permet de récupérer les infos des films          //
//        depuis la BDD pour les écrire dans nos champs à modifier           //
/////////////////////////////////////////////////////////////////////////////-->
      <?php

      try {
          $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
          $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $reponse = $bdd->query("SELECT * FROM ListeFilm WHERE id=".$_GET['edit']);
          while ($donnees = $reponse->fetch())
            {
              echo'<form method="POST" action="updateFilm.php">
                   <label>titre : </label><input type="text" name="titre" value ="'. $donnees['titre'].'" disabled>
                   <label>réalisateur : </label><input type="text" name="realisateur" value ="'.$donnees['realisateur'].'">
                   <label>acteurs : </label><input type="text" name="acteurs" value ="'.$donnees['acteurs'].'">
           				 <label>genres : </label><input type="text" name="genres" value ="'.$donnees['genres'].'">
           				 <label>date de parution</label><input type="number" name="dateParution" value ="'.$donnees['dateParution'].'">
           				 <label>type</label><input type="text" name="type" value ="'.$donnees['type'].'">
           				 <label>durée</label><input type="number" name="duree" value ="'.$donnees['duree'].'">
           			   <label>jacquette : </label><input type="url" name="image" value ="'.$donnees['image'].'">
           			   <label>synopsis : </label><textarea name="synopsis">'.$donnees['synopsis'].'</textarea>
           			   <label>nationalité</label><input type="text" name="nationalite" value ="'.$donnees['nationalite'].'">
           				 <label>trailer</label><input type="text" name="trailer" value ="'.$donnees['trailer'].'">
           				 <input type="submit" name="ok" value="ok" />
                   </form>';
            }
        }
        catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }

       ?>
		</main>
<!--///////////////////////////////////////////////////////////////////////////
//           Partie de PHP qui permet de modifier les infos affichées        //
/////////////////////////////////////////////////////////////////////////////-->
<?php
try {
    $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $realisateur = filter_input(INPUT_POST, 'realisateur', FILTER_SANITIZE_STRING);
    $acteurs = filter_input(INPUT_POST, 'acteurs', FILTER_SANITIZE_STRING);
    $genres = filter_input(INPUT_POST, 'genres', FILTER_SANITIZE_STRING);
    $dateParution = filter_input(INPUT_POST, 'dateParution', FILTER_SANITIZE_NUMBER_INT);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $duree = filter_input(INPUT_POST, 'duree', FILTER_SANITIZE_NUMBER_INT);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
    $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_STRING);
    $nationalite = filter_input(INPUT_POST, 'nationalite', FILTER_SANITIZE_STRING);
    $trailer = filter_input(INPUT_POST, 'trailer', FILTER_SANITIZE_STRING);

    $modif = $bdd->prepare("UPDATE ListeFilm SET
             realisateur = :realisateur,
             acteurs = :acteurs,
             genres = :genres,
             dateParution = :dateParution,
             type = :type,
             duree = :duree,
             image = :image,
             synopsis = :synopsis,
             nationalite = :nationalite,
             trailer = :trailer
             WHERE id=".$_GET['edit']);

   $modif->bindParam(':realisateur', $realisateur); // ou bindValue ?
   $modif->bindParam(':acteurs', $acteurs);
   $modif->bindParam('genres', $genres);
   $modif->bindParam('dateParution', $dateParution);
   $modif->bindParam('type', $type);
   $modif->bindParam('duree', $duree);
   $modif->bindParam('image', $image);
   $modif->bindParam('synopsis', $synopsis);
   $modif->bindParam('nationalite', $nationalite);
   $modif->bindParam('trailer', $trailer);

   $modif->execute();
   header('location : accueil.php');
    }
catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }


 ?>
</body>
</html>
