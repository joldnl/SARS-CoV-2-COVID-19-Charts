
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
        <link href="node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

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
                padding: 0 2rem 2rem 2rem;
            }
            .nav {
                padding-top: 2rem;
                padding-bottom: 1rem;
                text-align: center;
            }
            .nav ul {
                list-style: none;
            }
            .nav ul li {
                display: inline-block;
            }
            .nav ul li a {
                display: inline-block;
                padding: 10px 20px;
                border-radius: 10px;
                margin: 0 10px;
                background: #FFF;
                color: #000;
                text-decoration: none;
                font-size: 12px;
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
            a.github-icon-link {
                color: #FFF;
                margin-left: 10px;
            }
            a {
                color: rgb(156, 156, 156);
            }
        </style>
    </head>

