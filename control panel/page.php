<?php
/*
عندي ملف عبار عن التحكم ف الاقسام كامله من اضافه وتعديل وغيره عني كذا صفحه  اخليهم ف صفحه واحده بس  
categories => [mange | edit|update|add||insert|delete|stats ]
condition ? true : false 
$do = isset($_GET['$do'] ? $_GET['$do'] : 'mange';)
*/
$do = ""; //الفاريبول الي ههعتمد عليه 
// another condition *==*  $do = isset($_GET['$do'] )? $_GET['$do'] : 'mange';
if(isset($_GET['do'])) //جاي من فورم النيم بتاعته اكشن
{
    $do =  $_GET['do']; 
}
//لو عملت حاجه غير الميثود الدوو ف العنوان هيودني ع صفحه المانج ال انا ثايله عليها تحت
else {
        $do = "mange"; // يعني ف حاله ان في جيت ركوست هخلي الدو بتساوي طب لو مفيش يبقي الدو = مانج دي الصفحه الرئيسيه بتاعتي هيحولها وبعد كده هبدأ اسم صفحتي  
     }
     // catogers ???
     if ($do == 'mange')
     {
      echo 'welecome you are in a mange catogry page';
     }
     elseif( $do == 'add')
     {
     echo 'welecome you are in a add catogry page';
     }
     elseif( $do == 'insert')
     {
     echo 'welecome you are in a insert catogry page';
     }
     else {
         echo 'error there is no page with this page';
     }