<?php
    
require_once('../config.php');
    
// connecting to mysql


    
    $mysql = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
    $result = $mysql->query("select * from experience order by name asc");
    $rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = array_map("utf8_encode", $row);
    }
    echo json_encode($rows);
    $result->close();
    $mysql->close();

?>