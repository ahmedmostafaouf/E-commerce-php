<?php
//دي فنكش بممر فيها كلمه  الكلمه دي موجودخ ف الاريي
        function lang($word)
        {
            static $lang = array(
             'MASSAGE'=> 'اهلا',
             'admin'  =>  'المسؤل' 
            );
            return $lang[$word];
        }
