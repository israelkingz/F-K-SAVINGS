<?php

    include_once $classes_redirect."Dbh.class.php";

    class Transactions extends Dbh{

        const TRANSACTIONS_TABLE = "transactions";

        public function get_transaction_details($transaction_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $transaction_id = htmlentities($transaction_id);

            //operations
            $sql = "SELECT * FROM ". self::TRANSACTIONS_TABLE ." WHERE TransactionID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$transaction_id]);

            return $prepared_statement->fetchAll()[0];

        }

        public function reference_id_exists($reference_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $reference_id = htmlentities($reference_id);

            //operations
            $sql = "SELECT ReferenceID FROM ". self::TRANSACTIONS_TABLE ." WHERE ReferenceID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$reference_id]);

            return ($prepared_statement->rowCount() == 1);

        }

        public function generate_reference_id($user_id){

            $reference_id = "";

            for(;;){

                $reference_id = $user_id.uniqid();

                if(!$this->reference_id_exists($reference_id)){

                    return $reference_id;

                }

            }

        }

        public function get_user_transactions($user_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);

            //operations
            $sql = "SELECT * FROM ". self::TRANSACTIONS_TABLE . " WHERE UserID = ? ORDER BY TransactionID DESC";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$user_id]);

            return $prepared_statement->fetchAll();

        }

        public function get_transaction_id($reference_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $reference_id = htmlentities($reference_id);

            //operations
            $sql = "SELECT TransactionID FROM ". self::TRANSACTIONS_TABLE ." WHERE ReferenceID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$reference_id]);

            return $prepared_statement->fetchAll()[0]["TransactionID"];

        }

        public function get_transaction_datum($transaction_id, $datum_key){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $transaction_id = htmlentities($transaction_id);
            $datum_key = htmlentities($datum_key);

            //operations
            $sql = "SELECT $datum_key FROM ". self::TRANSACTIONS_TABLE ." WHERE TransactionID = ?";
            $prepared_statement = $conn->prepare($sql);
            $prepared_statement->execute([$transaction_id]);

            return $prepared_statement->fetchAll()[0][$datum_key];

        }

        public function validate_transaction($reference_id, $user_id, $amount){

            $curl = curl_init();
  
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: sk_test_dae6cbc9dbf88d2e68aa34b2bf950e1fd504e7b6",
                "Cache-Control: no-cache",
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                
                return false;
                
            } else {

                $response = json_decode($response, true);

                if($response["status"] == 1 && $response["message"] == "Verification successful" && $response["data"]["status"] == "success"
                && $response["data"]["amount"] == $amount*100 && $response["data"]["metadata"]["custom_fields"][0]["user_id"] == $user_id){

                    return true;

                }else{

                    return false;

                }
                
            }

        }

        public function add_new_transaction($user_id, $amount){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $user_id = htmlentities($user_id);
            $amount = htmlentities($amount);

            $new_reference_id = $this->generate_reference_id($user_id);
            $is_valid = 0;

            //operations
            $sql = "INSERT INTO ".self::TRANSACTIONS_TABLE."(UserID, ReferenceID, Amount, IsValid) VALUES(?, ?, ?, ?)";
            $prepared_statement = $conn->prepare($sql);
            
            $transaction_added = $prepared_statement->execute([$user_id, $new_reference_id, $amount, $is_valid]);

            if($transaction_added){

                return [$transaction_added, $conn->lastInsertId()];

            }else{

                return [$transaction_added];

            }

        }

        public function update_transaction_datum($transaction_id, $datum_key, $datum_value){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $transaction_id = htmlentities($transaction_id);
            $datum_key = htmlentities($datum_key);
            $datum_value = htmlentities($datum_value);

            //operations
            $sql = "UPDATE ".self::TRANSACTIONS_TABLE." SET $datum_key = ? WHERE TransactionID = ?";
            $prepared_statement = $conn->prepare($sql);
            
            return $prepared_statement->execute([$datum_value, $transaction_id]);

        }

        public function delete_transaction($transaction_id){

            //database object
            $conn = $this->getConnection();

            //sanitizing fields
            $transaction_id = htmlentities($transaction_id);

            //operations
            $sql = "DELETE FROM ".self::TRANSACTIONS_TABLE." WHERE TransactionID = ?";
            $prepared_statement = $conn->prepare($sql);
            
            return $prepared_statement->execute([$transaction_id]);

        }

    }

?>