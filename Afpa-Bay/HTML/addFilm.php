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
			<a class="lienImgImportant" href="addFilm.php?ANNIHILER=true&edit=<?php echo $_GET['edit']?>"><img class="imgImportant imgDestroy" src="../IMG/pirates.png" /></a>
			<h1>The Afpa Bay</h1>
			<a href="accueil.php"><img alt="Logo Afpa-Bay" src="../IMG/logo.png" /></a>
		</header>
		<main>
			<form method="POST" action="addFilm.php?ANNIHILER=false&edit=<?php echo $_GET['edit'];?>">
				<label>titre : </label><input type="text" name="titre" />
				<label>réalisateur : </label><input type="text" name="realisateur" />
				<label>acteurs : </label><input type="text" name="acteurs" />
				<label>genres : </label><input type="text" name="genres" />
				<label>date de parution</label><input type="number" name="dateParution" />
				<label>type</label><input type="text" name="type" />
				<label>durée</label><input type="number" name="duree" />
				<label>jacquette : </label><input type="url" name="image" />
				<label>synopsis : </label><input type="textarea" name="synopsis">
				<label>nationalité</label><input type="text" name="nationalite" />
				<label>trailer</label><input type="text" name="trailer" />
				<input type="submit" name="ok" value="ok" />
			</form>
		</main>
		<?php

		if(isset($_POST)){
					$bdd = new PDO('mysql:host=localhost;dbname=Afpa-Bay;charset=utf8','root','Afp4S3b!');
					// Permet de générer la liste des erreurs pour pouvoir corriger plus efficacement !
					//$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


					// Fonction pour supprimer un film
					if ($_GET['ANNIHILER'] == "true" && $_GET['edit'] != 0) {
							echo "suppression";
							$req = $bdd->prepare('DELETE FROM ListeFilm WHERE id = '.$_GET['edit']);
							$req->execute();
							header('Location: accueil.php');
					}


					// AJOUT D'UN NOUVEAU FILM
					if ($_GET['edit'] == 0) {
							$req = $bdd -> prepare ('INSERT INTO ListeFilm(titre, realisateur, acteurs, genres, dateParution, type, duree, image, synopsis, nationalite, trailer)
							 											   VALUES(:titre, :realisateur, :acteurs, :genres, :dateParution, :type, :duree, :image, :synopsis, :nationalite, :trailer)');
							$req->execute(array(
									'titre'=> filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING),
									'realisateur' => filter_input(INPUT_POST, 'realisateur', FILTER_SANITIZE_STRING),
									'acteurs' => filter_input(INPUT_POST, 'acteurs', FILTER_SANITIZE_STRING),
									'genres' => filter_input(INPUT_POST, 'genres', FILTER_SANITIZE_STRING),
									'dateParution' => filter_input(INPUT_POST, 'dateParution', FILTER_SANITIZE_NUMBER_INT),
									'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
									'duree' => filter_input(INPUT_POST, 'duree', FILTER_SANITIZE_NUMBER_INT),
									'image' => filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL),
									'synopsis' => filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_STRING),
									'nationalite' => filter_input(INPUT_POST, 'nationalite', FILTER_SANITIZE_STRING),
									'trailer' => filter_input(INPUT_POST, 'trailer', FILTER_SANITIZE_STRING)
									));
									header('Location: accueil.php');
					 }


					// MODIFICATION D'UN FILM SELECTIONNE

					if ($_GET['ANNIHILER'] == "false" && $_GET['edit'] != 0) {
						echo "EN COURS DE CODAGE ...";
								$req = $bdd->prepare('UPDATE ListeFilm SET titre = :titre,
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
																													 WHERE id ='.$_GET['edit']);

									$req->execute(array(
										 'titre' => $titre,
										 'realisateur' => $realisateur,
										 'acteurs' => $acteurs,
										 'genres' => $genres,
										 'dateParution' => $dateParution,
										 'type' => $type,
										 'duree' => $duree,
										 'image' => $image,
										 'synopsis' => $synopsis,
										 'nationalite' => $nationalite,
										 'trailer' => $trailer
									));


					}
	}

		?>
	</body>
</html>
