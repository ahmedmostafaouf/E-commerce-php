<?php

$dsn="mysql:host=localhost;dbname=shop";//data source name
$user='root'; //the user to conect
$pass="";  // pass to conect
$option =  array(
     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',//ده اوبشن عشان للو كتبت عربي يطلع صح 

);
try // حاول اتصل 
{
     $con = new PDO($dsn,$user,$pass,$option); //start anew conection with pdo class
     // set attriput
     $con->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);// كده اول حاجه بكتب بي دي او وبعد كده ماشي ع ايه  الي هو التراي والكاتش 

    
}
catch(PDOException $e)
{
    echo 'faild'. $e->getMessage();//موجود ف النظام
}
