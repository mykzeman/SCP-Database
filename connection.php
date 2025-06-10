<?php
include "security.php";
$connection= new mysqli("localhost",$un,$pw,$db);
$all=$connection->prepare("select * from records");
$all->execute();
$result=$all->get_result();


?>
