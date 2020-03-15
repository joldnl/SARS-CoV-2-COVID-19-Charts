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
        <title>COVID-19 (Corona Virus) in <?php echo $selectCountry; ?></title>
              
        <meta property="og:title" content="COVID-19 (Corona Virus) in <?php echo $selectCountry; ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:description" content="This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>"/>
        <meta property="og:image" content="http://stuff.jold.nl/sars-cov-2/nl/assets/social-screenshot.jpg"/>
        <meta property="og:image:width" content="800">
        <meta property="og:image:height" content="450">

        <?php include 'templates/head.php'; ?>

    <body>

        <div class="background"></div>

        <main>

            <?php include 'templates/nav.php'; ?>

            <h1>COVID-19 (Corona Virus) in <?php echo $selectCountry; ?> - Chart</h1>
            <p class="description">This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in <?php echo $selectCountry; ?>.</p>
            <p class="description-small">Please note that for some countries, there is no recovery information available.</p>

            <canvas id="corona-chart"></canvas>
        
            <script type="text/javascript">

                var ctx = document.getElementById('corona-chart').getContext('2d');
                var chart = new Chart(ctx, {

                    type: 'line',
                    data: {
                        labels: [<?php foreach($data->dates as $date): ?><?php $date = new \DateTime($date); ?>'<?php echo $date->format('d M') ?>', <?php endforeach; ?>],
                        datasets: [
                            {
                                label: 'Estimated RIVM',
                                backgroundColor: 'rgb(99, 111, 113)',
                                borderColor: 'rgb(99, 111, 113)',
                            	borderDash: [10, 5],
                                borderWidth: 1,
                            	fill: false,
                                data: [<?php foreach($data->confirmed as $dataConfirmed): ?>'<?php echo ($dataConfirmed * 5.2) ?>', <?php endforeach; ?>]
                            },
                            {
                                label: 'Confirmed',
                                backgroundColor: 'rgb(9, 208, 246)',
                                borderColor: 'rgb(9, 208, 246)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [<?php foreach($data->confirmed as $dataConfirmed): ?>'<?php echo $dataConfirmed ?>', <?php endforeach; ?>]
                            },
                            {
                                label: 'New per day',
                                backgroundColor: 'rgb(252, 200, 62)',
                                borderColor: 'rgb(252, 200, 62)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [<?php foreach($data->new as $dataNew): ?>'<?php echo $dataNew ?>', <?php endforeach; ?>]
                            },
                            {
                                label: 'Fatalities',
                                backgroundColor: 'rgb(230, 0, 0)',
                                borderColor: 'rgb(230, 0, 0)',
                            	borderDash: [10, 5],
                            	fill: false,
                                data: [<?php foreach($data->deaths as $dataDeaths): ?>'<?php echo $dataDeaths ?>', <?php endforeach; ?>]
                            },
                            {
                                label: 'Recovered',
                                backgroundColor: 'rgb(28, 175, 53)',
                                borderColor: 'rgb(28, 175, 53)',
                            	borderDash: [10, 5],
                                borderWidth: 1,
                            	fill: false,
                                data: [<?php foreach($data->recovered as $dataRecovered): ?>'<?php echo $dataRecovered ?>', <?php endforeach; ?> ]
                            },

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