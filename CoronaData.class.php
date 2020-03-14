<?php   

use League\Csv\Reader;

require 'vendor/autoload.php';


class CoronaData {

    var $datapath = 'COVID-19-DATASET/csse_covid_19_data/csse_covid_19_time_series/';

    var $datasetConfirmed;
    var $datasetDeaths;
    var $datasetRecovered;

    var $country;

    var $dates;
    var $confirmed;
    var $new;
    var $deaths;
    var $recovered;


    public function __construct() {

        // Set the datasets from csv
        // $this->setDatasets();
        // 
        // $this->setDataConfirmed();
        // $this->setDataConfirmedNew();
        // $this->setDataDeaths();
        // $this->setDataRecovered();

    }

    public function boot() {

        // Set the datasets from csv
        $this->setDatasets();

        $this->setDataConfirmed();
        $this->setDataConfirmedNew();
        $this->setDataDeaths();
        $this->setDataRecovered();

    }


    public function readDataset( $type = null ) {
        if (isset($type) && !empty($type)) {

        }
    }

    public function setCountry( $country = null ) {
        if (isset($country) && !empty($country)) {
            $this->country = $country;
        }
    }
    
    public function getCountry() {
        if (empty($this->country)) {
            $this->setCountry('Netherlands');
        }
        return $this->country;
    }


    public function setDatasets() {

        $confirmedData  = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Confirmed.csv', 'r');
        $confirmed      = $confirmedData->fetch();
        
        $deathsData     = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Deaths.csv', 'r');
        $deaths         = $deathsData->fetch();

        $recoveredData  = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Recovered.csv', 'r');
        $recovered      = $recoveredData->fetch();

        $this->datasetConfirmed = $confirmed;
        $this->datasetDeaths = $deaths;
        $this->datasetRecovered = $recovered;

    }


    public function setDataConfirmed() {
        
        $i = 0;

        foreach ($this->datasetConfirmed as $row) {
            
            if ($row[0] == 'Province/State') {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->dates = array_slice($row, -21, 21, true);
            }
            
            if (isset($row[1]) && $row[1] === $this->getCountry()) {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->confirmed = array_slice($row, -21, 21, true);
            }

            $i++;

        }
        
    } 

    

    public function setDataConfirmedNew() {

        $y = 0;
        foreach ($this->confirmed as $key => $value) {

            $diff = 0;

            if ($y > 0 ) {
                $diff = $value - $this->confirmed[$key - 1];
            }

            $this->new[] = $diff;

            $y++;

        }
        
    } 



    public function setDataDeaths() {
        
        $i = 0;
        foreach ($this->datasetDeaths as $row) {

            if (isset($row[1]) && $row[1] === $this->getCountry()) {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->deaths = array_slice($row, -21, 21, true);
            }

            $i++;

        }

    } 


    public function setDataRecovered() {
        
        $i = 0;
        foreach ($this->datasetRecovered as $row) {

            if (isset($row[1]) && $row[1] === $this->getCountry()) {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->recovered = array_slice($row, -21, 21, true);
            }

            $i++;

        }

    } 
    
}

