<?php  
      
    function connect_db() {  
        $server = 'database.dev'; // this may be an ip address instead  
        $user = 'root';  
        $pass = 'root';
        $database = 'oms'; // name of your database
        $port='3306';
        $connection = new mysqli($server, $user, $pass, $database,$port);  
      
        if ($connection->connect_error) {
                die('Connect Error: ' . $mysqli->connect_error);
        } else {
            echo "Mysql connected: Success coupon</br>" ;
        }
        return $connection;  
    }  
    ?>

