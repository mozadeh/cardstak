<?php
    
    
    

//$array = array('countryName'=>'Iran');

$arr = array('idCountry' => 1 , 'countryName' => 'Iran');

$rows = array();

$rows[] = array_map("utf8_encode", $arr);

$arr = array('idCountry' => 2 , 'countryName' => 'Iraq' );

$rows[] = array_map("utf8_encode", $arr);

echo json_encode($rows);

    
    
    /*$mysql = new mysqli('localhost','root','root','magicsuggest', 8889);
    $result = $mysql->query("select * from countries");
    $rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = array_map("utf8_encode", $row);
    }
    echo json_encode($rows);
    $result->close();
    $mysql->close();*/

