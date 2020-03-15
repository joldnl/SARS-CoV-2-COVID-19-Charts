<?php   

use League\Csv\Reader;
use League\Csv\Statement;

require 'vendor/autoload.php';


class CoronaData {

    var $datapath = 'COVID-19-DATASET/csse_covid_19_data/csse_covid_19_time_series/';
    var $days = 21;
    var $daysMin = -21;

    var $datasetConfirmed;
    var $datasetDeaths;
    var $datasetRecovered;
    var $datasetGemeentes;

    var $country;

    var $dates;
    var $confirmed;
    var $new;
    var $deaths;
    var $recovered;
    var $gemeentes;


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
        $this->setDataGemeentes();

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
    
    
    /**
     * Get the confirmed data from the date
     * with 10+ confirmed cases
     * @param   int     $from  The minimum cases
     * @return  [type]         [description]
     */
    public function getConfirmedFrom( $minimum = 10 ) {

        $key = $this->arrayFind($this->confirmed, $minimum);
        $newarr = [];

        foreach ($this->confirmed as $itemKey => $itemValue) {
            if ($itemKey >= $key) {
                $newarr[] = $itemValue;
            }
        }

        return $newarr;

    }


    public function setDatasets() {

        $confirmedData = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Confirmed.csv', 'r');
        $confirmed = $confirmedData->fetch();
        
        $deathsData = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Deaths.csv', 'r');
        $deaths = $deathsData->fetch();

        $recoveredData = Reader::createFromPath( $this->datapath . '/time_series_19-covid-Recovered.csv', 'r');
        $recovered = $recoveredData->fetch();

        $gemeenteData = Reader::createFromPath( 'data/meldingen-nederland.csv', 'r');
        $gemeenteData->setDelimiter(';');
        $gemeentes = $gemeenteData->fetch();
        
        $this->datasetConfirmed = $confirmed;
        $this->datasetDeaths = $deaths;
        $this->datasetRecovered = $recovered;
        $this->datasetGemeentes = $gemeentes;

    }


    public function arrayFind($a, $minimum) {
        foreach ($a as $key => $value) {
            if ($value >= $minimum) {
                return $key;
            }
        }
        return false;
    }


    public function setDataConfirmed() {
        
        $i = 0;

        foreach ($this->datasetConfirmed as $row) {
            
            if ($row[0] == 'Province/State') {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->dates = array_slice($row, $this->daysMin, $this->days, true);
            }
            
            if (isset($row[1]) && $row[1] === $this->getCountry()) {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->confirmed = array_slice($row, $this->daysMin, $this->days, true);
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
                $this->deaths = array_slice($row, $this->daysMin, $this->days, true);
            }

            $i++;

        }

    } 


    public function setDataRecovered() {
        
        $i = 0;
        foreach ($this->datasetRecovered as $row) {

            if (isset($row[1]) && $row[1] === $this->getCountry()) {
                unset( $row[0], $row[1], $row[2], $row[3] );
                $this->recovered = array_slice($row, $this->daysMin, $this->days, true);
            }

            $i++;

        }

    } 

    public function setDataGemeentes() {

        $i = 0;

        // var_dump( $row );
        
        $gemeentes = [];
        
        foreach ($this->datasetGemeentes as $row) {
            
            // var_dump( $row );

            if ($row[0] == '﻿"Category"') {
            } else {
                $slug = str_replace(' ', '-', strtolower($row[0]) );
                $gemeentes[$slug] = [
                    'name' => urlencode($row[0]),
                    'slug' => str_replace('\'', '', $slug),
                    'confirmed' => (int)$row[1],
                ];
            }

            $i++;
        
        }

        $this->gemeentes = $gemeentes;
        
        return $this->gemeentes;
        
    } 

    
    public function getGemeentesConfirmed() {
        $data = $this->gemeentes;
        usort( $data, [$this, 'compare_confirmed']);
        $reversed = array_slice(array_reverse($data), 0, 25);
        
        return $reversed;
        
    }


    public function compare_confirmed($a, $b) {
        return strnatcmp($a['confirmed'], $b['confirmed']);
    }

}

