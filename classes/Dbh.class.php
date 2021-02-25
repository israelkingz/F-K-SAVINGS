<?php

    class Dbh{

         const HOST_NAME = "localhost";
         const USER_NAME = "root";
         const PASSWORD = "";
         const DATABASE_NAME = "php_auth_api";

         const DSN = "mysql:host=".self::HOST_NAME.";dbname=".self::DATABASE_NAME;

        public function GetConnection(){

            $conn_object = new PDO(self::DSN, self::USER_NAME, self::PASSWORD);
            $conn_object->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conn_object;

        }

    }

?>