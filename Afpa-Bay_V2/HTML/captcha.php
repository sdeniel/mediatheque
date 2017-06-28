<?php
session_start();
//FONCTION CAPTCHA TEMPORAIREMENT ICI (A DEPLACER ULTERIEUREMENT ...)
//-----------------------------------------------------------------------------
//Création fonction captcha
//-----------------------------------------------------------------------------
    // Nombre de chiffres qui formeront le nombre
    $nbr_chiffres = 4;
    // Là, on définit le header de la page pour la transformer en image
    header ("Content-type: image/png");
    // Là, on crée notre image
    $_img = imagecreatefrompng('fond_verif_img.png');
    // Couleur de fond : Au cas où on n'utiliserait pas d'image de fond
    $arriere_plan = imagecolorallocate($_img, 0, 0, 0);
    // Couleur des chiffres
    $avant_plan = imagecolorallocate($_img, 255, 255, 255);

    $i = 0;
    while($i < $nbr_chiffres) {
          $chiffre = mt_rand(0, 9); // On génère le nombre aléatoire
          $chiffres[$i] = $chiffre;
          $i++;
    }
    $nombre = null;
    // On explore le tableau $chiffres afin d'y afficher toutes les entrées qui s'y trouvent
    foreach ($chiffres as $caractere) {
        $nombre .= $caractere;
    }
    ##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####
    $_SESSION['aleat_nbr'] = $nombre;
    // On détruit les variables inutiles :
    unset($chiffre);
    unset($i);
    unset($caractere);
    unset($chiffres);
//-----------------------------------------------------------------------------
//Création fonction captcha
//-----------------------------------------------------------------------------
imagestring($_img, 5, 18, 8, $nombre, $avant_plan);

imagepng($_img);

?>
