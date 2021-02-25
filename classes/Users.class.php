<?php

    include_once $classes_redirect."Dbh.class.php";

    class Users extends Dbh{

        const USERS_TABLE = "users";

        public function get_users(){

            //database object
            $conn = $this->getConnection();

            //operations
            $sql = "SELECT * FROM ". self::USERS_TABLE . " ORDER BY UserID DESC";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([]);

            return $prepared_statement->fetchAll();

        }

        public function get_user_datum($user_id, $datum_key){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);
            $datum_key = htmlentities($datum_key);

            //operations
            $sql = "SELECT $datum_key FROM ". self::USERS_TABLE ." WHERE UserID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$user_id]);

            return $prepared_statement->fetchAll()[0][$datum_key];

        }

        public function user_exists_by_id($user_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);

            //operations
            $sql = "SELECT UserID FROM ". self::USERS_TABLE ." WHERE UserID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$user_id]);

            return ($prepared_statement->rowCount() == 1);

        }

        public function user_exists_by_username($username){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $username = htmlentities($username);

            //operations
            $sql = "SELECT UserID FROM ". self::USERS_TABLE ." WHERE email = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$username]);

            return ($prepared_statement->rowCount() == 1);

        }

        public function add_user($username){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $username = htmlentities($username);

            //operations
            $sql = "INSERT INTO ". self::USERS_TABLE ."(email, Wallet) VALUES(?, ?)";
            $prepared_statement = $conn->prepare($sql);
            
            return $prepared_statement->execute([$username, 0]);

        }

        public function update_user_datum($user_id, $datum_key, $datum_value){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);
            $datum_key = htmlentities($datum_key);
            $datum_value = htmlentities($datum_value);

            //operations
            $sql = "UPDATE ".self::USERS_TABLE." SET $datum_key = ? WHERE UserID = ?";
            $prepared_statement = $conn->prepare($sql);
            
            return $prepared_statement->execute([$datum_value, $user_id]);

        }

        public function fund_wallet($user_id, $amount){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);
            $amount = htmlentities($amount);

            $new_amount = $this->get_user_datum($user_id, "Wallet") + $amount;

            //operations
            $sql = "UPDATE ". self::USERS_TABLE ." SET Wallet = ? WHERE UserID = ?";
            $prepared_statement = $conn->prepare($sql);
            
            return $prepared_statement->execute([$new_amount, $user_id]);

        }

        public function transfer_fund($from_user, $to_user, $amount){

            $from_user_new_wallet =  $this->get_user_datum($from_user, "Wallet") - $amount;
            $to_user_new_wallet = $this->get_user_datum($to_user, "Wallet") + $amount;

            return ($this->update_user_datum($from_user, "Wallet", $from_user_new_wallet) 
            && $this->update_user_datum($to_user, "Wallet", $to_user_new_wallet));

        }

    }

?>