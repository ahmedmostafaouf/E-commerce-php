<?php

session_start();
session_unset();//unset the data 
session_destroy();// destroy the session
header("location:index.php"); // هنا هحوله ع صفحه معينه 
exit();
?>