<?php

$resultat = $_GET['res'];

// les différents cas de figure
if ($resultat == 0){
    echo "L'adresse email a été mal renseigné, veuillez recommencer ..."."<br/>";
}
else if ($resultat == 1){
    echo "Vous vous êtes bien enregistré. A présent, vous pouvez vous connecter pour profiter de notre merveilleux site"."<br/>";
}
else if ($resultat == 2){
    echo "Le captcha a été mal renseigné, veuillez recommencer ..."."<br/>";
}
else if ($resultat == 3){
    echo "La combinaison pseudo & password renseignée n'est pas dans notre base de données."."<br/>".
    "Veuillez recommencer ..."."<br/>";
}

echo '<a href="."login.php".">'."Retour à la page d'identification".'</a>';
// redirection sur l'espace de login avec un clic
?>
