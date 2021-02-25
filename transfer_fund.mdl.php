<?php

    header("Content-Type: application/json");

    if(isset($_POST["from_user"]) && isset($_POST["to_user"]) && isset($_POST["amount"])){

        $from_user = $_POST["from_user"];
	$to_user = $_POST["to_user"];
        $amount = $_POST["amount"];

        if($amount < 1){

            echo json_encode([
                "Message" => "Amount cannot be less than 1"
            ]);
            
            die();

        }

        $classes_redirect = "classes/";

        include_once $classes_redirect."Users.class.php";

        $users_obj = new Users();

        if(!$users_obj->user_exists_by_id($from_user) || !$users_obj->user_exists_by_id($to_user)){

            echo json_encode([
                "Message" => "User does not exist"
            ]);

            die();

        }

        include_once $classes_redirect."Users.class.php";

        $users_obj = new Users();

        if($users_obj->transfer_fund($from_user, $to_user, $amount)){

            echo json_encode([
                "Message" => "Fund Transferred Successfully"
            ]);

        }else{

            echo json_encode([
                "Message" => "Error Transferring Fund"
            ]);

        }

    }else{

        echo json_encode([
            "Message" => "All fields not set"
        ]);

    }

?>