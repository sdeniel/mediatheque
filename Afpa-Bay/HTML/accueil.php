<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Accueil &mdash; Afpa-Bay</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css">
	</head>

	<!--------------------------------------------------------------------------->
	<!--Entête avec ajout de film, formulaire de recherche de films dans la BDD-->
	<!--------------------------------------------------------------------------->
	<body>
		<header>
			<a class="lienImgImportant" href="addFilm.php?ANNIHILER=false&edit=0"><img class="imgImportant" src="../IMG/coffre.png"></a>
			<h1>The Afpa Bay</h1>
			<a href="accueil.php"><img alt="Logo Afpa-Bay" src="../IMG/logo.png" /></a>
		</header>
		<nav>
			<form method="post" action="accueil.php">
				<input type="text" name="recherche" placeholder="Rechercher ..." />
				<input type="submit" name="ok" value="Lancer la recherche" />
			</form>
			<div>
					<em>Fermer la session </em><a href="login.php"><img class="logout" alt="Logo Afpa-Bay" src="../IMG/logout.png" /></a>
			</div>
		</nav>

		<!------------------------------------------------------------------------->
		 <!--  												Début de la partie PHP				   					-->
		<!------------------------------------------------------------------------->
		<main>
			<ul>
				<?php
				  // PDO : PHP data object permet de se connecter à la BDD selectionnée : localisation, login&mdp admin
				  $bdd = new PDO('mysql:host=localhost;dbname=Afpa-Bay;charset=utf8','root','Afp4S3b!');

					// on fait une requête à la BDD pour savoir tout ce qu'il y a dans notre table ListeFilm affiliée à la BDD Afpa-Bay
					if (!($_POST))
					$reponse = $bdd->query('SELECT * from ListeFilm');
					// WHERE ... LIKE + % permet de faire une recherche sur un titre entier ou une partie du titre dans la table ListeFilm
					else $reponse = $bdd->query('SELECT * from ListeFilm WHERE titre LIKE "%'.$_POST['recherche'].'%"');

					// on exporte par lignes les informations de $reponse
					/* En cliquant sur le lien (titre) on est envoyé vers une nouvelle page qui détaille le film*/
					$donnees = $reponse->fetch(PDO::FETCH_ASSOC);
					if (!($donnees)) echo '<br/><p class="error">Il n\'y a aucun résultat pour "'.$_POST['recherche'].'"</p>';
					do
					{

						// calcul en heures et minutes de la durée du film
						$min = $donnees["duree"]%60;
						$heure = ($donnees["duree"]-$min)/60;

					    if($donnees) echo "<li class='film'>";
					    else echo "<li class='hidden'>";
					    	echo "<div class='filmInfo'>
					    		<a target='_blank' href='".$donnees["image"]."'>
					    			<img src='".$donnees["image"]."' />
						    	</a>
							    <div class='filmInfoText'>
						    		<a href='../HTML/filmDetail.php?id=".$donnees['id']."'>
							    		<h3>".$donnees["titre"]."</h3>
							    	</a>
							    	<p class='synopsis'>".substr($donnees['synopsis'],0,200)."..."."</p>
							    	<p class='infoDivers'>".$donnees["type"]." | ".$donnees["dateParution"]." | ".$donnees["genres"]."
							    </div>
						    </div>
						    <div class='tag'>
						    	<p>".$heure.'h'.$min.'min'."</p>
						    </div>
					    </li>";
					} while ($donnees = $reponse->fetch(PDO::FETCH_ASSOC));
				?>
			</ul>
		</main>
	</body>
</html>
