<?php

    $transaction_id = $_POST["transaction_id"];

    $classes_redirect = "../classes/";

    include_once $classes_redirect."Transactions.class.php";

    $transaction_obj = new Transactions();

    $transaction_obj->delete_transaction($transaction_id);

?>