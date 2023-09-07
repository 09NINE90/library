<?php
  $hostname = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "lib";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Ошибка подключения к БД".mysqli_connect_error();
  }
?>
