<?php
include "config.php";
include "utils.php";
session_start();

$dbConn =  connect($db);


// AUTH LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $userName = $_POST['user_name'];
        $password = $_POST['password'];

        $query = "SELECT user_id FROM api_users WHERE user_name='$userName' AND password='$password'";

        $sql = $dbConn->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();

        //Error response
        $data = [
            "error" => true,
            "txt" => "The user name or password you entered isn't correct. Try entering it again."
        ];
        //If match
        if ($result) {

            $data = [
                "error" => false,
                "txt" => "Success",
            ];
            //Saving user on session
            $_SESSION["user"]=$result[0]["user_id"];
           
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($data);
        exit();
    } catch (Exception $e) {
        error_log($e);
        exit();
    }
}

//Log out
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    //Removing session
    session_destroy();
    header("HTTP/1.1 200 OK");
    
    $data = [
        "error" => false,
        "txt" => "Success",
    ];
    echo json_encode($data);
    exit();
}


header("HTTP/1.1 400 Bad Request");
