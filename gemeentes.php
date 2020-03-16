<?php 

use League\Csv\Reader;

require 'vendor/autoload.php';
require 'CoronaData.class.php';

$selectCountry = 'Netherlands';

if (isset($_GET['country'])) {
    $selectCountry = $_GET['country'];
}

$data = new CoronaData;
$data->setCountry($selectCountry);
$data->boot();

$gemeentes = $data->gemeentes;

// var_dump( $data->gemeentes );
// var_dump( $data->getGemeentesConfirmed() );
// exit;
?>

<html>
    <head>
        <title>COVID-19 (Corona Virus) Top Cities by Confirmed cases</title>

        <meta name="twitter:creator" content="@staxxnl" />
        <meta name="twitter:title" content="COVID-19 (Corona Virus) Top Cities by Confirmed cases"/>
        <meta name="twitter:description" content="This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>"/>
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="author" content="Jurgen Oldenburg"/>
        <meta name="twitter:image:src" content="https://stuff.jold.nl/sars-cov-2/assets/social-screenshot.jpg"/>

        <meta property="og:title" content="COVID-19 (Corona Virus) Top Cities by Confirmed cases"/>
        <meta property="og:type" content="article"/>
        <meta property="og:description" content="This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>"/>
        <meta property="og:image" content="https://stuff.jold.nl/sars-cov-2/assets/social-screenshot.jpg"/>
        <meta property="og:image:width" content="800">
        <meta property="og:image:height" content="450">

        <?php include 'templates/head.php'; ?>

    <body>

        <div class="background"></div>

        <main>

            <?php include 'templates/nav.php'; ?>

            <h1>COVID-19 (Corona Virus) Top Cities by Confirmed cases</h1>
            <p class="description">This chart shows the top cities in the Netherlands ordered by confirmed cases.</p>

            <canvas id="corona-chart" height="250"></canvas>
        
            <script type="text/javascript">

                var ctx = document.getElementById('corona-chart').getContext('2d');
                var chart = new Chart(ctx, {

                    type: 'horizontalBar',
                    data: {
                        labels: [
                                <?php foreach($data->getGemeentesConfirmed() as $gemeente): ?>
                                    '<?php echo $gemeente['name'] ?>',
                                <?php endforeach; ?>
                            ],
                        datasets: [
                            {
                                label: 'Confirmed',
                                backgroundColor: 'rgb(9, 208, 246)',
                                borderColor: 'rgb(9, 208, 246)',
                            	borderDash: [10, 5],
                            	fill: false,
                                minBarLength: 10,
                                data: [
                                    <?php foreach($data->getGemeentesConfirmed() as $dataConfirmed): ?>
                                        '<?php echo $dataConfirmed['confirmed'] ?>',
                                    <?php endforeach; ?>
                                ]
                            },
                        ],
                    },

                    // Configuration options go here
                    options: {}
                });
            </script>
        
            <p class="source">Source: <a href="https://www.rivm.nl/coronavirus-kaart-van-nederland" target="_blank">RIVM Ccoronavirus Kaart van Nederland 14-03-2020</a></p>
            <?php include 'templates/footer.php'; ?>
            
        </main>

    </body>
</html>