<?php
// include_once 'Country.php';
require '../components/autoload.php';
include_once '../views/functions.php';
connect();
if(checkToken($_POST['token'])){

    // Country
    if($_POST['param'] == 'getCountries'){
        $items = [];
        $res = mysql_query('select * from countries');
        while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            $items[] = new Country($row['id'], $row['countryName']);
        }
        file_put_contents('test.txt', json_encode($items));
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
      $res = mysql_query("select c.id, c.cityName from cities as c
        join countries on countries.id = c.countryId
        where countries.countryName = '$countryName'");

      while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $items[] = new City($row['id'], $row['cityName']);
      }
      file_put_contents('test2.txt', json_encode($items));
      echo json_encode($items);
    }

}else
    echo '<h1>Gonduras</h1>';
