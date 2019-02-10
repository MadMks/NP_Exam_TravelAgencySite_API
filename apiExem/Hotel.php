<?php
  /**
   *
   */
  class Hotel
  {
    public $id;
    public $hotelName;
    public $cityName;
    public $countryName;
    public $stars;
    public $cost;
    public $info;

    function __construct($id, $hotelName,
      $cityName, $countryName,
      $stars, $cost, $info)
    {
      $this->id = $id;
      $this->hotelName = $hotelName;
      $this->cityName = $cityName;
      $this->countryName = $countryName;
      $this->stars = $stars;
      $this->cost = $cost;
      $this->info = $info;
    }
  }

 ?>
