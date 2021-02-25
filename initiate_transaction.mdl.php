<?php

    header("Content-Type: application/json");

    if(isset($_POST["user_id"]) && isset($_POST["amount"])){
        $user_id = $_POST["user_id"];
        $amount = $_POST["amount"];

        if($amount < 1){

            echo json_encode([
                "Message" => "Amount cannot be less than 1"
            ]);
            
            die();

        }

        $classes_redirect = "classes/";
        include_once $classes_redirect."Transactions.class.php";

        $transactions_obj = new Transactions();

        $transaction_added = $transactions_obj->add_new_transaction($user_id, $amount);

        if($transaction_added[0]){

            $transaction_id = $transaction_added[1];

            $transaction_details = $transactions_obj->get_transaction_details($transaction_id);

            echo json_encode([
                "Message" => "Transaction Initiated Successfully",
                "TransactionInformation" => [
                    "TransactionID" => $transaction_id,
                    "UserID" => $transaction_details["UserID"],
                    "ReferenceID" => $transaction_details["ReferenceID"],
                    "Amount" => $transaction_details["Amount"]
                ]
            ]);

        }else{

            echo json_encode([
                "Message" => "Error Initiating Transaction"
            ]);

        }

    }else{

        echo json_encode([
            "Message" => "All fields not set"
        ]);

    }

?>