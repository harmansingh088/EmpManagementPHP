<?php 
    class db{
        public function connect(){
            $host = "localhost";
            $user = "root";
            $pass = "";
            $dbname = "Employee";

            //Build the data source name
            $dsn = 'mysql:host=' .$host . ';dbname=' .$dbname; 

            //Options for PDO
            $options = array ( PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

            //Connect
            try {
                return new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $pe)  {
                echo $pe->getMessage();
            }
        }
    }