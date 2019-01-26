<?php
  /**
   *
   */
  class Hotel
  {
    public $id;
    public $hotelName;
    // TODO: id
    // TODO: id
    public $stars;
    public $cost;
    public $info;

    function __construct($id, $hotelName, $stars, $cost, $info)
    {
      $this->id = $id;
      $this->hotelName = $hotelName;
      // ?
      // ?
      $this->stars = $stars;
      $this->cost = $cost;
      $this->info = $info;
    }
  }

 ?>
