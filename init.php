<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
include "control panel/conect.php";
//بختصر المسار ف متغير عشان لما اغير ف المستقبل اغير براحتى 
//ده انا بوظفه عشان لو عوز اطبع الاسم ف اي مكان استخدم المتغير ده 
 $sessionUser='';
 if(isset($_SESSION['user'])){
     $sessionUser=$_SESSION['user'];
 }
//route
$tpl = 'include/templets/'; //حدد مسار لفولدر تيمبلتس عشان لو حبيت اغيره فيما بعد
$css='layout/css/'; //css dirictury
$func= 'include/function/';//function direction
$js="layout/js/";   //js dirictury
$lang="include/language/";   //مشىل dirictury
// البدجات المهمه
include $func . 'function.php';
include $lang . 'en.php';
//include $lang . 'arabic.php'; // استدعي ملف اللغه الانجلش  والمفروض نعمل زيها بظبط عربي
include $tpl  . 'header.php';
 






