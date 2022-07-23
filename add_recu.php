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

if (isset($_POST['sub'])) {
    $recu = htmlspecialchars($_POST['recu']);
    if (!empty($recu)) {
        $req = $bdd->prepare('INSERT INTO recus(recu) VALUE(:recu)');
        $req->execute(array(
            'recu' => $recu
        ));
        $success = 'Votre reçu a été inséré dans la base de donnée.';
    } else {
        $msg = 'Vous devez saisir quelque chose dans le champs.';
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
                <h2 style="color: white; font-weight: 200; margin-bottom: 25px;">Ajouter un reçu</h2>
                <form action="" method="POST">
                    <input type="text" name="recu" id="recu" placeholder="Somme reçu" required>
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