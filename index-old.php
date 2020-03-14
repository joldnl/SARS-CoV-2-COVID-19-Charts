<?php 

use League\Csv\Reader;

require 'vendor/autoload.php';

$confirmedData  = Reader::createFromPath('COVID-19-DATASET/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Confirmed.csv', 'r');
$confirmed      = $confirmedData->fetch();

$deathsData     = Reader::createFromPath('COVID-19-DATASET/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Deaths.csv', 'r');
$deaths         = $deathsData->fetch();

$recoveredData  = Reader::createFromPath('COVID-19-DATASET/csse_covid_19_data/csse_covid_19_time_series/time_series_19-covid-Recovered.csv', 'r');
$recovered      = $recoveredData->fetch();

$dates = [];
$dataHubei = [];
$dataItaly = [];
$dataBelgium = [];
$dataGermany = [];
$dataFrance = [];

$dates = [];
$dataNetherlandsConfirmed = [];
$dataNetherlandsNew = [];
$dataNetherlandsDeaths = [];
$dataNetherlandsRecovered = [];


// Confirmed
$i = 0;
foreach ($confirmed as $row) {
    
    // var_dump( $i );
    if ($row[0] == 'Province/State') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        $dates = array_slice($row, -21, 21, true);
    }
    
    if (isset($row[1]) && $row[1] === 'Netherlands') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        // var_dump( $row );
        $dataNetherlandsConfirmed = array_slice($row, -21, 21, true);
        // var_dump( $row );
    }
    
    // if (isset($row[1]) && $row[1] === 'Netherlands') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     var_dump( $row );
    //     $dataNetherlandsNew = array_slice($row, -21, 21, true);
    // }

    $i++;

    // if (isset($row[0]) && $row[0] === 'Hubei') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     // var_dump( $row );
    //     $dataHubei = array_slice($row, -21, 21, true);
    // }
    // 
    // if (isset($row[1]) && $row[1] === 'Italy') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     // var_dump( $row );
    //     $dataItaly = array_slice($row, -21, 21, true);
    // }
    // 
    // if (isset($row[1]) && $row[1] === 'Belgium') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     // var_dump( $row );
    //     $dataBelgium = array_slice($row, -21, 21, true);
    // }
    // 
    // if (isset($row[1]) && $row[1] === 'Germany') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     // var_dump( $row );
    //     $dataGermany = array_slice($row, -21, 21, true);
    // }
    // 
    // if (isset($row[0]) && $row[0] === 'France') {
    //     unset( $row[0], $row[1], $row[2], $row[3] );
    //     // var_dump( $row );
    //     $dataFrance = array_slice($row, -21, 21, true);
    // }
}



// Deaths
$i = 0;
foreach ($deaths as $row) {
    
    // var_dump( $i );
    if ($row[0] == 'Province/State') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        $dates = array_slice($row, -21, 21, true);
    }
    
    if (isset($row[1]) && $row[1] === 'Netherlands') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        // var_dump( $row );
        $dataNetherlandsDeaths = array_slice($row, -21, 21, true);
        // var_dump( $row );
    }

    $i++;

}


// Recovered
$i = 0;
foreach ($recovered as $row) {
    
    // var_dump( $i );
    if ($row[0] == 'Province/State') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        $dates = array_slice($row, -21, 21, true);
    }
    
    if (isset($row[1]) && $row[1] === 'Netherlands') {
        unset( $row[0], $row[1], $row[2], $row[3] );
        // var_dump( $row );
        $dataNetherlandsRecovered = array_slice($row, -21, 21, true);
        // var_dump( $row );
    }

    $i++;

}


$y = 0;
foreach ($dataNetherlandsConfirmed as $key => $value) {

    $diff = 0;

    if ($y > 0 ) {
        $diff = $value - $dataNetherlandsConfirmed[$key - 1];
        // var_dump( $diff );
    }

    $dataNetherlandsNew[] = $diff;
    // var_dump( $value );
    $y++;
}

?>
<html>
    <head>
        <title>SARS-CoV-2 (COVID-19) in the Netherlands</title>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&family=Roboto:wght@300;400&display=swap" rel="stylesheet">

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
            canvas#myChart {
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
            <h1>SARS-CoV-2 (COVID-19) in the Netherlands - Chart</h1>
            <p class="description">This chart shows the total of confirmed cases, new cases per day, and the number of fatalities in the Netherlands.</p>
            <p class="description-small">Please note that for the Netherlands, there is no recovery information available.</p>

            <canvas id="myChart"></canvas>
        
        <script type="text/javascript">

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [
                        <?php foreach($dates as $date): ?>
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
                                <?php foreach($dataNetherlandsConfirmed as $data): ?>
                                    '<?php echo $data ?>',
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
                                <?php foreach($dataNetherlandsNew as $data): ?>
                                    '<?php echo $data ?>',
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
                                <?php foreach($dataNetherlandsDeaths as $data): ?>
                                    '<?php echo $data ?>',
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
                                <?php foreach($dataNetherlandsRecovered as $data): ?>
                                    '<?php echo $data ?>',
                                <?php endforeach; ?>
                            ]
                        },
                        // {
        				// 	label: 'Besmettingen Italie',
        				// 	fill: false,
        				// 	backgroundColor: 'rgb(28, 175, 53)',
        				// 	borderColor: 'rgb(28, 175, 53)',
        				// 	borderDash: [5, 5],
        				// 	data: [
                        //         <?php foreach($dataItaly as $data): ?>
                        //             '<?php echo $data ?>',
                        //         <?php endforeach; ?>
        				// 	],
        				// },
                        // {
        				// 	label: 'Besmettingen Hubei China',
        				// 	fill: false,
        				// 	backgroundColor: 'rgb(156, 15, 15)',
        				// 	borderColor: 'rgb(156, 15, 15)',
        				// 	borderDash: [5, 5],
        				// 	data: [
                        //         <?php foreach($dataHubei as $data): ?>
                        //             '<?php echo $data ?>',
                        //         <?php endforeach; ?>
        				// 	],
        				// },
                        // {
        				// 	label: 'Besmettingen Belgie',
        				// 	fill: false,
        				// 	backgroundColor: 'rgb(203, 173, 29)',
        				// 	borderColor: 'rgb(203, 173, 29)',
        				// 	borderDash: [5, 5],
        				// 	data: [
                        //         <?php foreach($dataBelgium as $data): ?>
                        //             '<?php echo $data ?>',
                        //         <?php endforeach; ?>
        				// 	],
        				// },          
                        // {
        				// 	label: 'Besmettingen Duitsland',
        				// 	fill: false,
        				// 	backgroundColor: 'rgb(237, 131, 28)',
        				// 	borderColor: 'rgb(237, 131, 28)',
        				// 	borderDash: [5, 5],
        				// 	data: [
                        //         <?php foreach($dataGermany as $data): ?>
                        //             '<?php echo $data ?>',
                        //         <?php endforeach; ?>
        				// 	],
        				// }
                    ],
                },

                // Configuration options go here
                options: {}
            });
        </script>
        
            <p class="source">
                Source: <a href="https://github.com/CSSEGISandData/" target="_blank">Novel Coronavirus (COVID-19) Cases, provided by CSSE at Johns Hopkins University</a>
            </p>
            <p class="source">
                Visualization by: <a href="https://github.com/joldnl/" target="_blank">Jurgen Oldenburg</a>
            </p>
        </main>


    </body>
</html>