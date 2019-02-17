<?php
require '../components/autoload.php';
include_once '../views/functions.php';
connect();
if(checkToken($_POST['token'])){

    // Country
    if($_POST['param'] == 'getCountries'){
        $items = [];

        $res = mysql_query('
        select distinct c.id, c.countryName
        from countries as c
        join cities on cities.countryId = c.id
        join hotels on hotels.countryId = c.id');
        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            $items[] = new Country($row['id'], $row['countryName']);
        }

        echo json_encode($items);
    }
    if($_POST['param'] == 'getAllCountries'){
        $items = [];

        $res = mysql_query('
        select distinct c.id, c.countryName
        from countries as c');
        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            $items[] = new Country($row['id'], $row['countryName']);
        }

        echo json_encode($items);
    }
    if($_POST['param'] == 'addCountry'){
        $item = json_decode($_POST['object']);
        $country = $item->countryName;

        mysql_query("insert into countries(countryName) VALUES ('$country')");

        echo 200;
    }
    if($_POST['param'] == 'delCountry'){
        $countryId = $_POST['countryId'];

        mysql_query("delete from countries
          where countries.id = '$countryId'");

        echo 200;
    }
    // City
    if ($_POST['param'] == 'getCities') {
      $items = [];
      $countryName = $_POST['country'];

      $res = mysql_query("select distinct c.id, c.cityName,
          countries.countryName
        from cities as c
        join countries on countries.id = c.countryId
        join hotels on hotels.cityId = c.id
        where countries.countryName = '$countryName'");

      while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $items[] = new City($row['id'], $row['cityName'],
          $row['countryName']);
      }

      echo json_encode($items);
    }
    if ($_POST['param'] == 'getAllCities') {
      $items = [];

      $res = mysql_query("select c.id, c.cityName, countries.countryName
        from cities as c
        join countries on countries.id = c.countryId");

      while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $items[] = new City(
          $row['id'],
          $row['cityName'],
          $row['countryName']);
      }

      echo json_encode($items);
    }
    if($_POST['param'] == 'addCity'){
        $item = json_decode($_POST['object']);
        $city = $item->cityName;
        $country = $item->countryName;

        $res = mysql_query("select id from countries
          where countryName = '$country'");
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $countryId = $row['id'];
        mysql_query("insert into cities(cityName, countryId)
          VALUES ('$city', '$countryId')");

        echo 200;
    }
    if($_POST['param'] == 'delCity'){
        $cityId = $_POST['cityId'];

        mysql_query("delete from cities
          where cities.id = '$cityId'");

        echo 200;
    }
    // Hotels
    if($_POST['param'] == 'getHotels'){
        $items = [];
        $countryName = $_POST['country'];
        $cityName = $_POST['city'];

        $res = mysql_query("
          select h.id, hotelName,
            cities.cityName, countries.countryName,
            stars, cost, info
          from hotels as h
          join countries on countries.id = h.countryId
          join cities on cities.id = h.cityId
          where countries.countryName = '$countryName'
          and cities.cityName = '$cityName'");

        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
          $items[] = new Hotel(
            $row['id'],
            $row['hotelName'],
            $row['cityName'],
            $row['countryName'],
            $row['stars'],
            $row['cost'],
            $row['info']
          );
        }

        echo json_encode($items);
    }
    if($_POST['param'] == 'getAllHotels'){
        $items = [];

        $res = mysql_query("
          select h.id, hotelName,
            cities.cityName, countries.countryName,
            stars, cost, info
          from hotels as h
          join countries on countries.id = h.countryId
          join cities on cities.id = h.cityId");

        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
          $items[] = new Hotel(
            $row['id'],
            $row['hotelName'],
            $row['cityName'],
            $row['countryName'],
            $row['stars'],
            $row['cost'],
            $row['info']
          );
        }

        echo json_encode($items);
    }
    if($_POST['param'] == 'addHotel'){
        $item = json_decode($_POST['object']);

        $hotel = $item->hotelName;
        $city = $item->cityName;
        $country = $item->countryName;
        $stars = $item->stars;
        $cost = $item->cost;
        $info = $item->info;

        $res = mysql_query("select id, countryId
          from cities
          where cityName = '$city'");

        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $cityId = $row['id'];
        $countryId = $row['countryId'];

        mysql_query("insert into hotels
          (hotelName, cityId, countryId, stars, cost, info)
          VALUES
          ('$hotel', $cityId, $countryId, $stars, $cost, '$info')");

        echo 200;
    }
    if($_POST['param'] == 'delHotel'){
        $hotelId = $_POST['hotelId'];

        mysql_query("delete from hotels
          where hotels.id = '$hotelId'");

        echo 200;
    }
    // Register
    if ($_POST['param'] == 'regUser') {
      $login = $_POST['login'];
      $pass = md5($_POST['pass']);
      $email = $_POST['email'];
      $insert = "insert into users (login, pass, email, roleId)
                  values('$login', '$pass', '$email', 2)";
      mysql_query($insert);

      echo 200;
    }

}else
    echo '<h1>Api page.</h1>';
