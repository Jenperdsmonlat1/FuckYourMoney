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

$req = $bdd->prepare("SELECT SUM(depense) AS depense_voiture FROM depenses WHERE categorie = 'Voiture'");
$req->execute();
$query_voiture = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT SUM(depense) AS depense_nourriture FROM depenses WHERE categorie = 'Nourriture'");
$req->execute();
$query_nourriture = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT SUM(depense) AS depense_maison FROM depenses WHERE categorie = 'Maison'");
$req->execute();
$query_maison = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT SUM(depense) AS depense_sante FROM depenses WHERE categorie = 'Santé'");
$req->execute();
$query_sante = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT SUM(depense) AS depense_multimedia FROM depenses WHERE categorie = 'Multimedia'");
$req->execute();
$query_multimedia = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT SUM(depense) AS depense_autre FROM depenses WHERE categorie = 'Autre'");
$req->execute();
$query_autre = $req->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Fuck Your Money - Home</title>
        <meta charset="utf-8">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="stylesheets/style.css">
        <link rel="stylesheet" href="stylesheets/sidebar.css">
        <link rel="stylesheet" href="stylesheets/stats.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        <?php include('code/sidebar.php'); ?>

        <center>
            <div class="container_graph">
                <canvas id="chart" height="720"></canvas>
            </div>
        </center>

        <script type="text/javascript">
            const div_chart = document.getElementById('chart');
            const data = {
                labels: ['Voiture', 'Nourriture', 'Maison', 'Santé', 'Multimedia', 'Autre'],
                datasets: [{
                    label: 'Dépenses en fonction des catégories.',
                    data: [
                        <?php echo $query_voiture['depense_voiture']; ?>,
                        <?php echo $query_nourriture['depense_nourriture']; ?>,
                        <?php echo $query_maison['depense_maison']; ?>,
                        <?php echo $query_sante['depense_sante']; ?>,
                        <?php echo $query_multimedia['depense_multimedia']; ?>,
                        <?php echo $query_autre['depense_autre']; ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            const config = {
                type: 'polarArea',
                data: data,
                options: options
            };

            const myChart = new Chart(
                div_chart,
                config
            );
        </script>

        <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
                sidebar.classList.toggle("active");
        }
        </script>
    </body> 
</html>