<?php
    class Database {
        //DB Params        
        private $host = "localhost";
        private $dbname = "paygate";
        private $username = "root";
        private $password = "";
        private $connection;

        //Database Connect
        public function connect(){
            $this->conection = null;

            try{
                $this->connection = new PDO("mysql:host=" . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Connection Error: ". $e->getMessage();
            }

            return $this->connection;
        }
    }
?>