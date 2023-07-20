<?php
    class Customers {
        // DB Stuff
        private $connection;
        private $table = "customers";

        // POST Properties
        public $id;
        public $customer_name;
        public $customer_email;
        public $customer_contactno;
        public $customer_status;

        // Constructor with DB
        public function __construct($db){
            $this->connection = $db;
        }

        // Get Customers
        public function read(){
            // Create query            
            $query = 'SELECT
                id,
                customer_name,
                customer_email,
                customer_contactno,
                customer_status
            FROM
                ' . $this->table . '
            ORDER BY
                id DESC';

            //prepare statement
            $stmt = $this->connection->prepare($query);

            // Excute query
            $stmt->execute();

            return $stmt;
        }

        //Get Single Customer
        public function read_single(){
            // Create query            
            $query = 'SELECT
                id,
                customer_name,
                customer_email,
                customer_contactno,
                customer_status
            FROM
                ' . $this->table . '
            WHERE
                id = ?
            LIMIT 0, 1';

            //prepare statement
            $stmt = $this->connection->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id);

            // Excute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->customer_id = $row['id'];
            $this->customer_name = $row['customer_name'];
            $this->customer_email = $row['customer_email'];
            $this->customer_conactno = $row['customer_contactno'];
            $this->customer_status = $row['customer_status'];
        }

        //Create Customers
        public function create(){
            //Create Query
            $query = "INSERT INTO " . 
                    $this->table . 
                    "(customer_name, customer_email, customer_contactno, customer_status) values (:customer_name, :customer_email, :customer_contactno, :customer_status)";

            //prepare statement
            $stmt = $this->connection->prepare($query);

            //Clean Data
            $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
            $this->customer_email = htmlspecialchars(strip_tags($this->customer_email));
            $this->customer_contactno = htmlspecialchars(strip_tags($this->customer_contactno));
            $this->customer_status = htmlspecialchars(strip_tags($this->customer_status));

            // Bind Data
            $stmt->bindParam(':customer_name', $this->customer_name);
            $stmt->bindParam(':customer_email', $this->customer_email);
            $stmt->bindParam(':customer_contactno', $this->customer_contactno);
            $stmt->bindParam(':customer_status', $this->customer_status);

            //execute query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }
    }
?>