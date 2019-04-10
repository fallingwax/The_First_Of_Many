<?php

ini_set('display_errors', '1');

function getTable($config, $tableName, $playerID) {
    require($config);
    $con = new mysqli($host, $username, $password, $db_name);
    if(mysqli_connect_errno()) {
        printf("Connection failed %s\n", mysqli_connect_error());
        exit();
    } else {
        $query = "SELECT * FROM ".$tableName." WHERE playerID = ?";
        $tableArray = array();
        $stmt = $con->$stmt_init();
        if ($stmt->prepare($query)) {
            $stmt->bind_param('s', $playerID);
            $stmt->execute();
            
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $tableArray[] = $row;
            }
        }
    }
    return json_encode($tableArray);
    $stmt->close();
    $con->close();
}

function updateField($config, $tableName,$columnname,$value, $playerID){
    require($config);
    if(mysqli_connect_errno()) {
        printf("Connection failed %s\n", mysqli_connect_error());
        exit();
    } else {
        $query = "UPDATE ? SET ? = ? WHERE playerID = ?";
        
    }
}


?>