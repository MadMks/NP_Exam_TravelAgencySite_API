<?php
// include_once 'Country.php';
require '../components/autoload.php';
include_once '../views/functions.php';
connect();
if(checkToken($_POST['token'])){

    // Country
    if($_POST['param'] == 'getCountries'){
        $items = [];
        // TODO вернуть только те, у которых есть города.
        $res = mysql_query('select * from countries');
        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            $items[] = new Country($row['id'], $row['countryName']);
        }
        // file_put_contents('test.txt', json_encode($items));
        echo json_encode($items);
    }
    if($_POST['param'] == 'insCountries'){
        $items = json_decode($_POST['object']);
        $c = $items['countryName'];
        file_put_contents('test.txt', $c);
        mysql_query("insert into countries(countryName)VALUES ('$c')");
        $err = mysql_errno();
        if(!err){
            echo 200;
        }
    }
    // City
    if ($_POST['param'] == 'getCities') {
      $items = [];
      $countryName = $_POST['country'];
      // вернуть только те, у которых есть отели.
      $res = mysql_query("select distinct c.id, c.cityName from cities as c
        join countries on countries.id = c.countryId
        join hotels on hotels.cityId = c.id
        where countries.countryName = '$countryName'");

      while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $items[] = new City($row['id'], $row['cityName']);
      }
      // file_put_contents('test2.txt', json_encode($items));
      echo json_encode($items);
    }
    // Hotels
    if($_POST['param'] == 'getHotels'){
        $items = [];
        $countryName = $_POST['country'];
        $cityName = $_POST['city'];

        $res = mysql_query("
          select h.id, hotelName, stars, cost, info
          from hotels as h
          join countries on countries.id = h.countryId
          join cities on cities.id = h.cityId
          where countries.countryName = '$countryName'
          and cities.cityName = '$cityName'");

        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
          $items[] = new Hotel(
            $row['id'],
            $row['hotelName'],
            $row['stars'],
            $row['cost'],
            $row['info']
          );
        }
        // file_put_contents('test3.txt', json_encode($items));
        echo json_encode($items);
    }

}else
    echo '<h1>Gonduras</h1>';
