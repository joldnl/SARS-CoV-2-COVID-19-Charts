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

?>

<html>
    <head>
        <title>SARS-CoV-2 (COVID-19) in <?php echo $selectCountry; ?></title>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&family=Roboto:wght@300;400&display=swap" rel="stylesheet">

              
        <meta property="og:title" content="SARS-CoV-2 (COVID-19) in <?php echo $selectCountry; ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:description" content="This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>"/>
        <meta property="og:image" content="http://stuff.jold.nl/sars-cov-2/nl/assets/social-screenshot.jpg"/>
        <meta property="og:image:width" content="800">
        <meta property="og:image:height" content="450">

        <style media="screen">
            body {
                background: rgb(6, 30, 34);
                color: rgb(156, 156, 156);
                font-family: 'Roboto', cursive;
                position: relative;
                padding: 0;
                margin: 0;
            }

            .background {
                background-image: url('assets/JtVH5Khvihib7dBDFY9ZDR.jpg');
                background-size:  cover;
                background-repeat: no-repeat;
                background-position: center;
                opacity: .1;
                z-index: -1;
                position: absolute;
                height: 100%;
                width: 100%;
            }

            main {
                padding: 2rem;
            }

            h1 {
                font-weight: normal;
                text-align: center;
                font-family: 'Patua One', cursive;
                color: rgb(255, 255, 255);
                margin-bottom: 0;
                padding-bottom: 0;
            }
            p.description {
                padding-top: 0;
                padding-bottom: 0px;
                font-size: 14px;
                text-align: center;
                font-weight: 300;
                color: rgb(255, 255, 255);
            } 
            p.description-small {
                padding-top: 0;
                padding-bottom: 20px;
                font-size: 12px;
                text-align: center;
                font-weight: 300;
                color: rgb(255, 255, 255);
            } 
            canvas#corona-chart {
                margin-left: auto;
                margin-right: auto;
                max-width: 768px; 
            }
            p.source {
                font-size: 12px;
                text-align: center;
                font-weight: 300;
            } 
            a {
                color: rgb(156, 156, 156);
            }
        </style>
    </head>


    <body>

        <div class="background"></div>

        <main>
            <h1>SARS-CoV-2 (COVID-19) in <?php echo $selectCountry; ?> - Chart</h1>
            <p class="description">This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>.</p>
            <p class="description-small">Please note that for some countries, there is no recovery information available.</p>

            <canvas id="corona-chart"></canvas>
        
            <script type="text/javascript">

                var ctx = document.getElementById('corona-chart').getContext('2d');
                var chart = new Chart(ctx, {

                    type: 'line',
                    data: {
                        labels: [
                            <?php foreach($data->dates as $date): ?>
                                <?php $date = new \DateTime($date); ?>
                                '<?php echo $date->format('d M') ?>',
                            <?php endforeach; ?>
                        ],
                        datasets: [
                            {
                                label: 'Total infected',
                                backgroundColor: 'rgb(9, 208, 246)',
                                borderColor: 'rgb(9, 208, 246)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [
                                    <?php foreach($data->confirmed as $dataConfirmed): ?>
                                        '<?php echo $dataConfirmed ?>',
                                    <?php endforeach; ?>
                                ]
                            },
                            {
                                label: 'New infections',
                                backgroundColor: 'rgb(252, 200, 62)',
                                borderColor: 'rgb(252, 200, 62)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [
                                    <?php foreach($data->new as $dataNew): ?>
                                        '<?php echo $dataNew ?>',
                                    <?php endforeach; ?>
                                ]
                            },
                            {
                                label: 'Total Deceased',
                                backgroundColor: 'rgb(230, 0, 0)',
                                borderColor: 'rgb(230, 0, 0)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [
                                    <?php foreach($data->deaths as $dataDeaths): ?>
                                        '<?php echo $dataDeaths ?>',
                                    <?php endforeach; ?>
                                ]
                            },
                            {
                                label: 'Total recovered',
                                backgroundColor: 'rgb(28, 175, 53)',
                                borderColor: 'rgb(28, 175, 53)',
                            	borderDash: [10, 5],
                                borderWidth: 1,
                            	fill: false,
                                data: [
                                    <?php foreach($data->recovered as $dataRecovered): ?>
                                        '<?php echo $dataRecovered ?>',
                                    <?php endforeach; ?>
                                ]
                            },

                        ],
                    },

                    // Configuration options go here
                    options: {}
                });
            </script>
        
            <p class="source">Source: <a href="https://github.com/CSSEGISandData/" target="_blank">Novel Coronavirus (COVID-19) Cases, provided by CSSE at Johns Hopkins University</a></p>
            <p class="source">Visualization by: <a href="https://github.com/joldnl/" target="_blank">Jurgen Oldenburg</a></p>
            <p class="source">version: v0.1.1 - 14-03-2020</p>
            
        </main>

    </body>
</html>