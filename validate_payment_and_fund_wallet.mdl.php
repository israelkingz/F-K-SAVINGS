<?php

    header("Content-Type: application/json");

    if(!isset($_POST["reference_id"])){

        echo json_encode([
            "Message" => "Error validating payment"
        ]);

        die();

    }

    $reference_id = $_POST["reference_id"];

    $classes_redirect = "../classes/";

    include_once $classes_redirect."Transactions.class.php";

    $transaction_obj = new Transactions();

    if($transaction_obj->reference_id_exists($reference_id)){

        $transaction_id = $transaction_obj->get_transaction_id($reference_id);

        $transaction_details = $transaction_obj->get_transaction_details($transaction_id);

        $user_id = $transaction_details["UserID"];
        $amount = $transaction_details["Amount"];

        if($transaction_obj->validate_transaction($reference_id, $user_id, $amount)){

            $transaction_obj->update_transaction_datum($transaction_id, "IsValid", 1);

            include_once $classes_redirect."Users.class.php";

            $users_obj = new Users();

            $users_obj->fund_wallet($user_id, $amount);

            echo json_encode([
                "Message" => "Payment Validated and Wallet Funded"
            ]);

        }else{

            echo json_encode([
                "Message" => "Error validating payment"
            ]);

        }

    }else{

        echo json_encode([
            "Message" => "Error validating payment"
        ]);

    }

?>