<?php


// Appel des constantes permettant la connexion à la DB
require_once "config.php";

// Connexion à la DB en mysqli procédural
$db = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

// on met notre connexion au format utf8
mysqli_set_charset($db, DB_CHARSET);

/*
Si on a envoyé le formulaire, on va essayer de l'insérer dans la DB
*/

// la méthode POST n'est pas vide
if (!empty($_POST)) {

    // on retire les espaces à l'avant et à l'arrière du texte
    $leNom = trim($_POST['themessagesname']);
    // on empèche les attaques par scripts, et toutes les balises html etc...
    $leNom = strip_tags($leNom);
    // on va convertir les caractères spéciaux en entités html avec le ' et le " compris
    $leNom = htmlspecialchars($leNom, ENT_QUOTES);

    // Même chose que leNom en une seule ligne
    $leMessage = htmlspecialchars(strip_tags(trim($_POST['themessagestext'])), ENT_QUOTES);

    // si le captcha de Google n'a pas été coché
    if(empty($_POST['g-recaptcha-response'])||strlen($_POST['g-recaptcha-response'])!=462){
        $erreur = "Etes-vous un robot?";

    // on vérifie si au moins un de nos résultat est vide    
    }elseif (empty($leNom) || empty($leMessage)) { 
        $erreur = "Vos champs ne peuvent être vides!";

    // sinon on insère dans la DB    
    } else {

        mysqli_query($db, "INSERT INTO themessages (themessagesname,themessagestext) 
        VALUES ('$leNom','$leMessage')") or die(mysqli_error($db));
    }
}


/*
Récupération des messages
*/

// on va récupérer tous les messages de la table "messages" 
// par date descendante et ensuite par ID desc (pour le même jour, on respecte l'ordre)
$recupDatas = mysqli_query($db, "SELECT * FROM themessages ORDER BY themessagesdate DESC") or die(mysqli_error($db));

// on transforme le résultat en tableau associatif
$datas = mysqli_fetch_all($recupDatas, MYSQLI_ASSOC);

// on récupère le nombre de messages
$nbMessages = mysqli_num_rows($recupDatas);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil livre d'or</title>
    <meta name="last-modified" content="DD-MM-YYYY" />
    <meta name="language" content="en" />
    <link rel="canonical" href="">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!-- reCaptcha v2 -->
    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6Lcn5G8aAAAAAJiyFkfQPXprBmU30wW0z-qdSUjR',
          'callback' : verifyCallback,
        });
        var verifyCallback = function(response) {
            alert(response);
        };
      };
    </script>
</head>

<body>
    <h1>Accueil livre d'or</h1>
    <form name="livredor" method="post" action="">
        <fieldset>
            <legend>Laissez-nous un message</legend>
            <div>
                <label for="themessagesname" hidden>Votre nom</label>
                <input type="text" name="themessagesname" id="themessagesname" placeholder="Votre nom" minlength="3" maxlength="50" required>
            </div>
            <div>
                <label for="themessagestext" hidden>Votre message</label>
                <textarea name="themessagestext" id="themessagestext" placeholder="Votre message" minlength="3" maxlength="550"  required ></textarea>
            </div>
            <div>
                <?php if(isset($erreur)) echo "<h3>$erreur</h3>" ; ?>
            </div>
            <div id="html_element"></div>
            <div>
                <button type="submit" name="commit">Envoyer</button>
            </div>
            
        </fieldset>
    </form>
    <h2>Vos messages</h2>
    <p>Nombre de message: <?=$nbMessages?></p>
    <?php
    foreach ($datas as $item) {
        echo "<h4>Ecrit par {$item['themessagesname']} Le {$item['themessagesdate']}</h4>";
        echo "<p>{$item['themessagestext']}</p><hr>";
    }
    ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>

</body>
</html>