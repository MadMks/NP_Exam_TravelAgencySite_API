<?php
// include_once 'Country.php';
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
        // file_put_contents('test.txt', json_encode($items));
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
        // file_put_contents('test.txt', json_encode($items));
        echo json_encode($items);
    }
    if($_POST['param'] == 'addCountry'){
        $item = json_decode($_POST['object']);
        // $country = $item['countryName'];
        $country = $item->countryName;
        // file_put_contents('test.txt', $country);
        mysql_query("insert into countries(countryName) VALUES ('$country')");
        $err = mysql_errno();
        if(!err){
            echo 2002;
        }
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
      // file_put_contents('test2.txt', json_encode($items));
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
      // file_put_contents('test2.txt', json_encode($items));
      echo json_encode($items);
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
        // file_put_contents('test3.txt', json_encode($items));
        echo json_encode($items);
    }
    // Register
    // TODO Register
    if ($_POST['param'] == 'regUser') {
      // $items = json_decode($_POST['object']);

      $login = $_POST['login'];
      $pass = md5($_POST['pass']);
      $email = $_POST['email'];
      $insert = "insert into users (login, pass, email, roleId)
                  values('$login', '$pass', '$email', 2)";
      mysql_query($insert);
      // $err = mysql_errno();
      echo 200;
      // if(!err){
      //     echo 200;
      // }
      // TODO code...mysqli_errno OR PDO
      // echo 404;
    }
    // TODO image for admin
    // if(true){
    //
    // }
    // TODO Method does not exist
    // echo 404;

}else
    echo '<h1>Api page.</h1>';
