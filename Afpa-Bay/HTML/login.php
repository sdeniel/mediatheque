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
					<h1>The Afpa Bay</h1>
			</header>

    	<section id="inscription">
	        <!-- FORMULAIRE CONNECTION -->
	        <form class="formConnection" action="login.php" method="POST"> <!--action="accueil.php"-->
	            <h2>Se connecter</h2>
	            <div class="imgcontainer">
	                <img src="../IMG/avatar.png" alt="Avatar" class="avatar">
	            </div>

	            <div class="container">
	                <p><input type="text" name="pseudoCo" placeholder="Pseudo ..." required></p>
	                <p><input type="password" name="passwordCo" placeholder="Password" required></p>
	                <p><input type="submit" value="Connection"></p>
	            </div>
	        </form>

	        <!-- FORMULAIRE INSCRIPTION -->
	        <form class="formConnection" action="register.php" method="POST">
	            <h2>S'enregistrer</h2>
	            <div class="imgcontainer">
	                <img src="../IMG/avatar.png" alt="Avatar" class="avatar">
	            </div>

	            <div class="container">
		              <p><input type="text" name="loginIns" placeholder="Login ..." required/></p>
		              <p><input type="text" name="pseudoIns" placeholder="Pseudo ..." required/></p>
		              <p><input type="text" name="passwordIns" placeholder="Mot de passe ..." required/></p>
		              <p><input type="text" name="emailIns" placeholder="Email ..." required/></p>
		              <p>CAPTCHA : Veuillez taper le mot :"<?php echo captcha(); ?>"</p><input type="text" name="captcha" />
		              <p><input type="submit" value="Connection"/></p>
	            </div>
	        </form>
     </section>

    <?php
    //Sécurisation des données saisies pour la connection
    $_SESSION['login'] = htmlspecialchars($_POST['pseudoCo']);
    $password = htmlspecialchars($_POST['passwordCo']);

		//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
		// ---------------------PARTIE SE CONNECTER ------------------------------//
		//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    //On récupère nos données de la BDD, de la table des login
    $bdd = new PDO('mysql:host=localhost;dbname=Afpa-Bay;charset=utf8','root','Afp4S3b!');
    $reponse = $bdd->query('SELECT * FROM login WHERE identifiant = "'.$_SESSION['login'].'"');
    $donnees = $reponse->fetch(PDO::FETCH_ASSOC);

    // On vérifie les ID et mot de passe de l'utilisateur
    if (isset($donnees['identifiant'])&&($donnees['identifiant'] == $_SESSION['login'])&&($donnees['password'] == $password)){
      header('Location: accueil.php');
      exit();}

    //Création fonction captcha
    function captcha() {
      $listeMot = array('trampoline','ballon','escargot','antilope','telephone');
      $mot = $listeMot[array_rand($listeMot)];
      $_SESSION['captcha'] = $mot;
      return $mot;
    }

    ?>
	</body>
</html>
