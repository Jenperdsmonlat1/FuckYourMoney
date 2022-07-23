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

$req = $bdd->prepare('SELECT SUM(recu) AS recu_sum FROM recus');
$req->execute();
$recus = $req->fetch(PDO::FETCH_ASSOC);

$req = $bdd->prepare('SELECT SUM(depense) AS depense_sum FROM depenses');
$req->execute();
$depenses = $req->fetch(PDO::FETCH_ASSOC);

$balance = $recus['recu_sum'] - $depenses['depense_sum'];

$req = $bdd->prepare('SELECT * FROM depenses LIMIT 3');
$req->execute();
$last_depenses = $req->fetchAll();

$query_chart = $bdd->query('SELECT depense, dates FROM depenses LIMIT 10');

foreach($query_chart as $datas) {
    $dates[] = $datas['dates'];
    $dep[] = $datas['depense'];
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
        <link rel="stylesheet" href="stylesheets/home.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="js/crypto_price.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>

        <?php include('code/sidebar.php'); ?>

        <div class="home">
            <div class="container_money">
                <div class="balance">
                    <div class="title">
                        <div class="icone_portefeuille"></div>
                        <h3 style="color: white; font-weight: 200; font-size: 25px;">Balance</h3>
                    </div>
                    <h3 style="color: white; font-size: 30px;"><?php echo $balance; ?>€</h3>
                </div>
                <div class="depense">
                    <div class="title">
                        <div class="icone_billet"></div>
                        <h3 style="color: white; font-weight: 200; font-size: 25px;">Dépense</h3>
                    </div>
                    <h3 style="color: white; font-size: 30px;"><?php print_r($depenses['depense_sum']); ?>€</h3>
                </div>
                <div class="recu">
                    <div class="title">
                        <div class="icone_recu"></div>
                        <h3 style="color: white; font-weight: 200; font-size: 25px;">Reçu</h3>
                    </div>
                    <h3 style="color: white; font-size: 30px;"><?php print_r($recus['recu_sum']); ?>€</h3>
                </div>
            </div>

            <div class="infos">
                <div class="stats">
                    <h3 class="title">Statistiques des dépenses</h3>
                    <canvas id="myChart" class="chart"></canvas>
                </div>
                <div class="last_depense">
                    <h3 class="title">Dernière dépenses</h3>
                    <div class="historique">
                        <?php
                        foreach ($last_depenses as $dep) {
                        ?>
                        <div class="line">
                            <div class="dart"></div>
                            <div class="categorie">
                                <h5 class="cat_price"><?php echo $dep['categorie']; ?></h5>
                            </div>
                            <div class="prix">
                                <h5 class="cat_price"><?php echo $dep['depense']; ?></h5>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="cours">
                <h3 style="color: white; font-weight: 200; margin-top: 5px;">Cours des cryptomonnaies</h3>
                <div class="crypto_cours">
                    <div class="crypto_money">
                        <div class="bitcoin_icone"></div>
                        <h3 style="color: white; font-weight: 200;">Bitcoin</h3>
                        <h3 id="btc" style="color: white; font-weight: 600;"></h3>
                    </div>
                    <div class="crypto_money">
                        <div class="ethereum_icone"></div>
                        <h3 style="color: white; font-weight: 200;">Ethereum</h3>
                        <h3 id="eth" style="color: white; font-weight: 600;"></h3>
                    </div>
                    <div class="crypto_money">
                        <div class="tether_icone"></div>
                        <h3 style="color: white; font-weight: 200;">Tether</h3>
                        <h3 id="usd" style="color: white; font-weight: 600;"></h3>
                    </div>
                    <div class="crypto_money">
                        <div class="monero_icone"></div>
                        <h3 style="color: white; font-weight: 200;">Monero</h3>
                        <h3 id="xmr" style="color: white; font-weight: 600;"></h3>
                    </div>
                    <div class="crypto_money">
                        <div class="ripple_icone"></div>
                        <h3 style="color: white; font-weight: 200;">Ripple</h3>
                        <h3 id="xrp" style="color: white; font-weight: 600;"></h3>
                    </div>
                </div>

                <h3 style="color: white; font-weight: 200; margin-top: 15px;">Cours de la monnaie</h3>
                <div class="money_cours">
                    <div class="crypto_money">
                        <div class="euro"></div>
                        <h3 style="color: white; font-weight: 200;">Euro</h3>
                        <h3 style="color: white; font-weight: 600;">2000€</h3>
                    </div>
                    <div class="crypto_money">
                        <div class="dollars"></div>
                        <h3 style="color: white; font-weight: 200;">Dollars</h3>
                        <h3 style="color: white; font-weight: 600;">1900€</h3>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            const div_chart = document.getElementById('myChart');
            const labels = <?php echo json_encode($dates); ?>;
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Dernière Dépenses',
                    backgroundColor: '#24273F',
                    borderColor: 'rgb(125, 255, 10)',
                    data: <?php echo json_encode($dep); ?>,
                    tension: 0.1
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {}
            };

            var chart = new Chart(
                div_chart,
                config
            );
        </script>

        <script>
            getBTCPrice();
            getETHPrice();
            getUSDPrice();
            getXMRPrice();
            getXRPPrice();
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