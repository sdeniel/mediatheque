<?php
session_start();

if(isset($_POST)){
    $bdd = new PDO('mysql:host='.$_SESSION['serveur'].'; dbname='.$_SESSION['baseDonnees'].'; charset=utf8', $_SESSION['pseudo'], $_SESSION['pass']);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // MODIFICATION D'UN FILM SELECTIONNE
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

    $req->bindParam('titre', $titre);
    $req->bindParam('realisateur', $realisateur);
    $req->bindParam('acteurs', $acteurs);
    $req->bindParam('genres', $genres);
    $req->bindParam('dateParution', $dateParution);
    $req->bindParam('type', $type);
    $req->bindParam('duree', $duree);
    $req->bindParam('image', $image);
    $req->bindParam('synopsis', $synopsis);
    $req->bindParam('nationalite', $nationalite);
    $req->bindParam('trailer', $trailer);

    $req->execute();
}

 ?>
