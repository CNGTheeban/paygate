<?php
    class Orders {
        // DB Stuff
        private $connection;
        private $table = "orders";

        // POST Properties
        public $id;
        public $item_id;
        public $customer_id;
        public $transferRef;
        public $amount;
        public $order_status;
        public $paydate;

        // Constructor with DB
        public function __construct($db){
            $this->connection = $db;
        }

        // Get Customers
        public function read(){
            // Create query            
            $query = 'SELECT
                id,
                item_id,
                customer_id,
                transferRef,
                amount,
                order_status,
                paydate
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

        //Get Single Order
        public function read_single(){
            // Create query            
            $query = 'SELECT
                id,
                item_id,
                customer_id,
                transferRef,
                amount,
                order_status,
                paydate
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
            $this->item_id = $row['item_id'];
            $this->customer_id = $row['customer_id'];
            $this->transferRef = $row['transferRef'];
            $this->amount = $row['amount'];
            $this->order_status = $row['order_status'];
            $this->paydate = $row['paydate'];
        }

        //Create Orders
        public function create(){
            //Create Query
            $query = "INSERT INTO " . 
                    $this->table . 
                    "(item_id, customer_id, transferRef, amount, order_status, paydate) values (:item_id, :customer_id, :transferRef, :amount, :order_status, :paydate)";

            //prepare statement
            $stmt = $this->connection->prepare($query);

            //Clean Data
            $this->item_id = htmlspecialchars(strip_tags($this->item_id));
            $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
            $this->transferRef = htmlspecialchars(strip_tags($this->transferRef));
            $this->amount = htmlspecialchars(strip_tags($this->amount));
            $this->order_status = htmlspecialchars(strip_tags($this->order_status));
            $this->paydate = htmlspecialchars(strip_tags($this->paydate));

            // Bind Data
            $stmt->bindParam(':item_id', $this->item_id);
            $stmt->bindParam(':customer_id', $this->customer_id);
            $stmt->bindParam(':transferRef', $this->transferRef);
            $stmt->bindParam(':amount', $this->amount);
            $stmt->bindParam(':order_status', $this->order_status);
            $stmt->bindParam(':paydate', $this->paydate);

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