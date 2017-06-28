<?php
 session_start();
 ?>
 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Détail &mdash; Afpa-Bay</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css">
		<link rel="stylesheet" type="text/css" href="../CSS/detail.css">
	</head>

	<body>
		<!-- récupération des données provenant de la table choisie de la BDD   -->
		<?php
			$bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$reponse = $bdd->query('SELECT * from ListeFilm WHERE id = '.$_GET["id"]);
			$donnees = $reponse->fetch(PDO::FETCH_ASSOC);
		?>

		<header>
			<a class="lienImgImportant" href="addFilm.php"><img class="imgImportant" src="../IMG/coffre.png"></a>
			<h1>The Afpa Bay</h1>
			<a href="accueil.php"><img alt="Logo Afpa-Bay" src="../IMG/logo.png" /></a>
		</header>
		<main>
			<section>
				<div class="text">
					<h2><?php echo $donnees["titre"];?></h2>
					<p><?php echo $donnees["synopsis"];?></p>
				</div>
				<hr />
				<div class="list">
						<img src=<?php echo '"'.$donnees["image"].'"';?> />
						<div class="miseEnForme">
													<p><em>Réalisateur : </em><?php
														if($donnees["realisateur"]) echo $donnees["realisateur"];
														else echo "???";?>
													</p>
													<p><em>Acteurs : </em><?php
						                if($donnees["acteurs"]) echo $donnees["acteurs"];
						                else echo "???";?>
						              </p>
													<p><em>Genres : </em><?php
												    if($donnees["genres"]) echo $donnees["genres"];
												    else echo "???";?>
						              </p>
													<p><em>Date de parution : </em><?php
												    if($donnees["dateParution"]) echo $donnees["dateParution"];
												    else echo "???";?>
						              </p>
													<p><em>Durée : </em><?php
												    if($donnees["duree"]) {
															$min = $donnees["duree"]%60;
															$heure = ($donnees["duree"]-$min)/60;
															echo $heure.'h'.$min.'min';}
												    else echo "???";?>
						              </p>
													<p><em>Nationalité : </em><?php
												    if($donnees["nationalite"]) echo $donnees["nationalite"];
												    else echo "???";?>
						              </p>
						</div>
				</div>
			</section>
			<section>
			 	<?php if($donnees["trailer"]) echo '<iframe src="https://www.youtube.com/embed/'.$donnees["trailer"].'"></iframe>';?>
			</section>
		</main>
		<div class="buttonEditSuppr">
				<div>
						<p>Editer les infos</p>
						<a class="lienImgImportant" href="updateFilm.php?edit=<?php echo $donnees['id']?>"><img class="imgImportant" src="../IMG/modif.png"></a>
				</div>
				<div>
						<p>Supprimer ce film</p>
						<a class="lienImgImportant" href="deleteFilm.php?edit=<?php echo $donnees['id']?>"><img class="imgImportant" src="../IMG/pirates.png"></a>
				</div>
		</div>
	</body>
</html>
