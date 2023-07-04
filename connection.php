<?php
  $host='earth.cs.utep.edu';
  $user='mchacon3';
  $password='M@1984ri';
  $database= $user;
  $connection = new mysqli($host, $user, $password, $database);

  if(!$connection){
    die($connection->error);
  }

?>
