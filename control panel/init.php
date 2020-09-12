<?php
include "conect.php";
//بختصر المسار ف متغير عشان لما اغير ف المستقبل اغير براحتى 

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
// ده هعمل شؤط واقول لو في متغير اسمو نو ناف بار متعملش انكلود للناف دي 
if(!isset($nonavbar)){
    include $tpl  . "nabar.php";
    }






