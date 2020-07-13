<?php
include "config.php";
include "utils.php";
session_start();

$dbConn =  connect($db);

/*
  GET USERS
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $page = $_GET['page'];
  $page=(int)$page*5;
  //If the session does not exist
  if(!isset($_SESSION["user"])){
    $data = [
      "error"=>true,
    ];
    echo json_encode($data);
    exit();
  }
  
  
  //Get total of users
  $query = "SELECT count(*) as total_pages FROM students std inner join api_users apu on std.user_fk=apu.user_id inner join tb_group gp on gp.group_id=std.group_fk";
  $sql = $dbConn->prepare($query);
  $sql->execute();
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  $total_rows = $sql->fetchAll();
  //Get users 
  $query = "SELECT std.first_name,std.last_name,apu.user_name,gp.group_name FROM students std inner join api_users apu on std.user_fk=apu.user_id inner join tb_group gp on gp.group_id=std.group_fk LIMIT $page,5";
  $sql = $dbConn->prepare($query);
  $sql->execute();
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  $result = $sql->fetchAll();
  header("HTTP/1.1 200 OK");
  
  $data = [
    "total_pages" => ceil((int) $total_rows[0]["total_pages"] / 5),
    "data" => $result,
    "error"=>false,
  ];

  echo json_encode($data);
  exit();
}




header("HTTP/1.1 400 Bad Request");
