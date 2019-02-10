<?php

class City
{
    public $id;
    public $cityName;
    public $countryName;

    public function __construct($id, $cityName, $countryName)
    {
        $this->id = $id;
        $this->cityName = $cityName;
        $this->countryName = $countryName;
    }
}

 ?>
