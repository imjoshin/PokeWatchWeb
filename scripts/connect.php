<?php
function db_connect()
    {
        $result = new mysqli(DBHOST,
                             DBUSER,
                             DBPASS,
                             DBNAME);
        if(!$result)
        {
            throw new Exception('Could not connect to db server');
        }
        //echo mysqli_connect_error();
        return $result;
    }
?>
