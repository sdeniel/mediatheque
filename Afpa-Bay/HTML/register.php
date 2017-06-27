
<?php


      //Sécurisation des données saisies pour l'inscription'
      $loginIns = filter_input(INPUT_POST, 'loginIns', FILTER_SANITIZE_STRING);
      $pseudoIns = filter_input(INPUT_POST, 'pseudoIns', FILTER_SANITIZE_STRING);
      $passwordIns = filter_input(INPUT_POST, 'passwordIns', FILTER_SANITIZE_STRING);
      $emailIns = filter_input(INPUT_POST, 'emailIns', FILTER_VALIDATE_EMAIL);
      $captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING);

      if($_captcha == $_SESSION['captcha'])
      {
          // Test Email valide ou non
          if (!$emailIns) {
              /*echo "Email non valide";*/
              header('Location: login.php');

          }
          else {
            $bdd = new PDO('mysql:host=localhost;dbname=Afpa-Bay;charset=utf8','root','Afp4S3b!');
            $req = $bdd -> prepare ('INSERT INTO login(identifiant, password, id, pseudo, email)
            VALUES(:identifiant, :password, :id, :pseudo, :email )');
            $req->execute(array(
                'identifiant' => $loginIns,
                'password' => $passwordIns,
                'id' => $_GET['id'],
                'pseudo' => $pseudoIns,
                'email' => $emailIns
            ));
            header('Location: accueil.php');
          }
      }



  ?>
