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
<!--///////////////////////////////////////////////////////////////////////////
//        Partie de PHP qui permet de récupérer les infos des films          //
//        depuis la BDD pour les écrire dans nos champs à modifier           //
/////////////////////////////////////////////////////////////////////////////-->
<?php
    try
        {
        $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }

        $reponse = $bdd->prepare("SELECT * FROM ListeFilm WHERE id=".$_GET['edit']);
        $reponse->execute();
        $donnees = $reponse->fetch();
?>
    <main>
        <form method="POST" action="updateFilm.php?edit=<?php echo $_GET['edit']?>">
               <input type="hidden" name="id" value ='<?php echo $donnees['id'];?>'>
               <label>titre : </label><input type="text" name="titre" value ='<?php echo $donnees['titre'];?>'>
               <label>réalisateur : </label><input type="text" name="realisateur" value ='<?php echo $donnees['realisateur'];?>'>
               <label>acteurs : </label><input type="text" name="acteurs" value ='<?php echo $donnees['acteurs'];?>'>
       				 <label>genres : </label><input type="text" name="genres" value ='<?php echo $donnees['genres'];?>'>
       				 <label>date de parution</label><input type="number" name="dateParution" value ='<?php echo $donnees['dateParution'];?>'>
       				 <label>type</label><input type="text" name="type" value ='<?php echo $donnees['type'];?>'>
       				 <label>durée</label><input type="number" name="duree" value ='<?php echo $donnees['duree'];?>'>
       			   <label>jacquette : </label><input type="url" name="image" value ='<?php echo $donnees['image'];?>'>
       			   <label>synopsis : </label><textarea name="synopsis"><?php echo $donnees['synopsis'];?></textarea>
       			   <label>nationalité</label><input type="text" name="nationalite" value ='<?php echo $donnees['nationalite'];?>'>
       				 <label>trailer</label><input type="text" name="trailer" value ='<?php echo $donnees['trailer'];?>'>
       				 <input type="submit" name="validation" value="ok" />
         </form>
		</main>
<!--///////////////////////////////////////////////////////////////////////////
//           Partie de PHP qui permet de modifier les infos affichées        //
/////////////////////////////////////////////////////////////////////////////-->
<?php

if(isset($_POST['validation'])) {
    // on verifie que les entrées sont ok (filtrage). Pour accéder aux données tapées on prend leur name du formulaire

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
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

    $modif = $bdd->prepare("UPDATE ListeFilm SET   titre=:titre,
                                                   realisateur=:realisateur,
                                                   acteurs=:acteurs,
                                                   genres=:genres,
                                                   dateParution=:dateParution,
                                                   type=:type,
                                                   duree=:duree,
                                                   image=:image,
                                                   synopsis=:synopsis,
                                                   nationalite=:nationalite,
                                                   trailer=:trailer
                                             WHERE id=".$_POST['id']);

   $modif->bindParam(':titre', $titre);
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

   if (!empty($titre)) {
      $modif->execute();
      header('Location: accueil.php');
    }
}

 ?>
</body>
</html>
