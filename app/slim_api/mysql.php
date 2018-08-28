<?php  
      
    function connect_db() {  
        $server = 'database.dev'; // this may be an ip address instead  
        $user = 'root';  
        $pass = 'root';
        $database = 'oms'; // name of your database
        $connection = new mysqli($server, $user, $pass, $database);  
      
        if ($connection->connect_error) {
                die('Connect Error: ' . $mysqli->connect_error);
        } else {
            echo "Mysql connected: Success slimdddddd </br>" ;
        }
        return $connection;  
    }  
    ?>

