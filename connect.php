<?php

$con =new mysqli ("localhost" , "root" , "" , "ajwt");


if($con->connect_error){
    die("connection failed:".$con->connect_error);
}


?>