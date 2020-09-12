<?php
//دي فنكش بممر فيها كلمه  الكلمه دي موجودخ ف الاريي
        function lang($word)
        {
            static $lang = array( //استاتك مش كل مره استدعيها
             'name page'    => 'ahmed',
             'home admin'   =>  'Home',
             'edit profile' =>  'Edit Profile' ,
             'setting'      =>  'Setting' ,
             'out'          =>  'LogOut' ,
             'Categories'   =>  'Categories' ,
             'ITEMS'        =>  'Items' ,
             'MEMBERS'      =>  'Members' ,
             'COMMENTS'     =>  'Comment',
             'STATISTICS'   =>  'Statistics' ,
             'LOGS'          =>  'Logs' 
            );
            return $lang[$word];
        }
