<?php
$con=mysqli_connect('localhost','root','','Mystore');
if(!$con){
    // die(mysqli_error($con));
    die("Connection failed: " . mysqli_connect_error());
}



?>