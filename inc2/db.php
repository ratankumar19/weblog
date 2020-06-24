<?php
$db['db_host']='localhost';
$db['db_user']='phpmyadmin';
$db['db_pass']='Ratankumar@96';
$db['db_name']='cms';
/*
foreach($db as $key => $value){

	define(strtoupper($key), $value);
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($connection){
}*/

$con=mysqli_connect('localhost','phpmyadmin','Ratankumar@96','cms');
/*if($connection){
	echo "connection true";
}*/
?>