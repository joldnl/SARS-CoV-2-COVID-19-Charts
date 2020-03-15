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

$dataItaly = new CoronaData;
$dataItaly->setCountry('Italy');
$dataItaly->boot();

$dataChina = new CoronaData;
$dataChina->setCountry('China');
$dataChina->boot();

// var_dump( $dataChina->getConfirmedFrom(10) );
// exit;
?>

<html>
    <head>
        <title>COVID-19 (Corona Virus) Confirmed Cases NL and IT</title>

        <meta property="og:title" content="COVID-19 (Corona Virus) Confirmed Cases NL and IT"/>
        <meta property="og:type" content="article"/>
        <meta property="og:description" content="This chart shows the total confirmed cases between the Netherlands and Italy."/>
        <meta property="og:image" content="http://stuff.jold.nl/sars-cov-2/nl/assets/social-screenshot.jpg"/>
        <meta property="og:image:width" content="800">
        <meta property="og:image:height" content="450">

        <?php include 'templates/head.php'; ?>

    </head>


    <body>

        <div class="background"></div>

        <main>

            <?php include 'templates/nav.php'; ?>

            <h1>COVID-19 (Corona Virus) Confirmed Cases NL and IT</h1>
            <p class="description">
                This chart shows the total confirmed cases between the Netherlands and Italy.<br>
                Day 0 is the first day with more than 10 confirmed cases.
            </p>

            <canvas id="corona-chart"></canvas>
        
            <script type="text/javascript">

                var ctx = document.getElementById('corona-chart').getContext('2d');
                var chart = new Chart(ctx, {

                    type: 'line',
                    data: {
                        labels: [<?php foreach($dataItaly->getConfirmedFrom(10) as $key => $val): ?>'Day <?php echo $key ?>', <?php endforeach; ?> ],
                        datasets: [
                            {
                                label: 'Confirmed in Italy',
                                backgroundColor: 'rgb(252, 200, 62)',
                                borderColor: 'rgb(252, 200, 62)',
                            	borderDash: [10, 5],
                                borderWidth: 1,
                            	fill: false,
                                data: [<?php foreach($dataItaly->getConfirmedFrom(10) as $dataNewIt): ?>'<?php echo $dataNewIt ?>', <?php endforeach; ?> ],
                            },
                            {
                                label: 'Confirmed in the Netherlands',
                                backgroundColor: 'rgb(9, 208, 246)',
                                borderColor: 'rgb(9, 208, 246)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [<?php foreach($data->getConfirmedFrom(10) as $dataConfirmed): ?>'<?php echo $dataConfirmed ?>', <?php endforeach; ?> ],
                            },
                            // {
                            //     label: 'Confirmed in China',
                            //     backgroundColor: 'rgb(230, 0, 0)',
                            //     borderColor: 'rgb(230, 0, 0)',
                            // 	borderDash: [10, 5],
                            // 	fill: false,
                            //     data: [<?php foreach($dataChina->getConfirmedFrom(10) as $dataConfirmedCn): ?>'<?php echo $dataConfirmedCn ?>', <?php endforeach; ?> ],
                            // },
                        ],
                    },

                    // Configuration options go here
                    options: {}
                });
            </script>
        
            <p class="source">Source: <a href="https://github.com/CSSEGISandData/" target="_blank">Novel Coronavirus (COVID-19) Cases, provided by CSSE at Johns Hopkins University</a></p>
            <?php include 'templates/footer.php'; ?>
            
        </main>

    </body>
</html>