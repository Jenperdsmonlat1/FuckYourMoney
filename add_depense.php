<?php

$db_infos = array(
    'db_host' => 'localhost',
    'db_name' => '',
    'db_user' => '',
    'db_password' => ''
);

try {
    $bdd = new PDO('mysql:host='.$db_infos['db_host'].';dbname='.$db_infos['db_name'].';charset=utf8', $db_infos['db_user'], $db_infos['db_password']);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur: '.$e->getMessage());
}

$categories = array(
    "Voiture" => '',
    "Nourriture" => '',
    "Maison" => '',
    "Santé" => '',
    "Multimedia" => '',
    "Autre" => ''
);

if (isset($_POST['sub'])) {
    $categorie = htmlspecialchars($_POST['categorie']);
    $depense = htmlspecialchars($_POST['depense']);
    $date = date('d-m-y h:i:s');

    if (!empty($categorie) AND !empty($depense)) {
        if (array_key_exists($categorie, $categories)) {
            $req = $bdd->prepare('INSERT INTO depenses(categorie, depense, dates) VALUE(:categorie, :depense, :dates)');
            $req->execute(array(
                'categorie' => $categorie,
                'depense' => $depense,
                'dates' => $date
            ));
            $success = 'Votre dépense a été inséré dans la base de donnée.';
        } else {
            $msg = 'Erreur lors de la saisie, les catégories  disponibles sont: Voiture, Nourriture, Maison, Santé, Multimedia, Autre.';
        }
    } else {
        $msg = 'Vous devez saisir quelque chose dans les champs.';
    }
}


?>


<!DOCTYPE html>
<html>
    <head>
        <title>Fuck Your Money - Home</title>
        <meta charset="utf-8">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="stylesheets/style.css">
        <link rel="stylesheet" href="stylesheets/sidebar.css">
        <link rel="stylesheet" href="stylesheets/add.css">

    </head>

    <body>
        <?php include('code/sidebar.php'); ?>

        <center>
            <div class="form_container">
                <h2 style="color: white; font-weight: 200; margin-bottom: 25px;">Ajouter une dépense</h2>
                <form action="" method="POST">
                    <input type="text" name="categorie" id="categorie" placeholder="Catégorie" required>
                    <input type="text" name="depense" id="depense" placeholder="Dépense" required>
                    <input type="submit" name="sub" value="Valider">
                </form>
                <?php
                if (isset($msg)) {
                ?>
                <div class="error">
                    <div style="color: #7d3333;"><?php echo $msg; ?></div>
                </div>
                <?php
                } if (isset($success)) {
                ?>
                <div class="success">
                    <div style="color: #337d40;"><?php echo $success; ?></div>
                </div>
                <?php
                }
                ?>
            </div>
        </center>

        <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
                sidebar.classList.toggle("active");
        }
        </script>
    </body> 
</html>