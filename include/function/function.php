<?php
/*
    **GEt all record func v2.0
    ** fun to get  all cats  from database 
       بتعرض كل الحاجات ال انا عايزها ف اي تابل بحدده
       تعديل دي الفنكشن الام شامله كل حاجه 
    */
    function getAllfrom($field,$tablename,$where=NULL,$and=NULL, $orderdBy,$ordaring ='ASC' )
    {
        global $con;
        $getAllfrom = $con->prepare("SELECT $field FROM $tablename $where $and ORDER BY $orderdBy $ordaring");
        $getAllfrom->execute();
        $all = $getAllfrom->fetchAll();
        return $all;
    }
/*
    **GEt latest record func
    ** fun to get cats  from database 
    بتعرض الكاتوجرس بتاعتي ف الناف بار 
    */
    /* function getcats()
    {
        global $con;
        $getcats = $con->prepare("SELECT * FROM categories  ORDER BY ID ASC");
        $getcats->execute();
        $cats = $getcats->fetchAll();
        return $cats;
    } */
   /*  /*
    **GEt latest record func
    ** fun to get items  from database 
        الايتمز بتاعتي ف الصفحه  + بصتلها الايدي عشان تعرض كل ايتمز معايا ف القسم بتاعه الصفحه + 
        ضفت الابؤوف لو الابروف نل فاضي يعني مكتبتش فيه حاجه اضيف ف الاستعلام امر الابؤوف 
    */
    /* function getitems($where , $value,$approve=NULL)
    {
        global $con;
        if($approve==NULL)
        {
        $sql= 'AND approve=1';
        } else{
            $sql='';
        }
        $getitems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY item_id DESC");
        $getitems->execute(array($value));
        $items = $getitems->fetchAll();
        return $items;
    }  */
     /*
        **Cheak if user is not activate
       ** function to check ragestatues in user 
       بتشيك ع الريج استاتيو بتاعي لو خو ب صفر  يبقي الادمين لازم يفهله
     */

    function checkUserStatues($user)
    {
        global $con;
        $stmtx = $con-> prepare("SELECT
                                UserName , RegStatus
                           FROM
                                 user
                            WHERE
                                 UserName=?
                            AND
                            RegStatus = 0 ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
   $stmtx->execute(array($user)); // ابحثلي عنهم فى الداتا بيز 
   $status = $stmtx -> rowCount();
   return $status;
    }

    /*
    ** v0.1
    ** titile func that echo the bage title in case the page
    **has the varible pagetitle and echo defult title for other page
    اي صفحه فيها البيدج تايتل دي هتبعطهالة
    */ 
    function gettitle()
    {
        global $pageTitle;//عشان يبقي اكسس من اي مكان 
        if(isset($pageTitle))//لو موجود اطبعلي التايتل ده 
        {
            echo $pageTitle;
        }
        else {
            echo "defult";
        }  
    }
    /*
    ** Home redirect function v0.1 [this function accept parameters]
    ** $errorsmsg= echo the error masg
    ** $seconds = second befor redirecting 
    */
 /*    function redirecthome($errorsmsg,$seconds=3)
    {
        echo "<div class='alert alert-danger'> $errorsmsg </div>";
        echo "<div class = 'alert alert-info'> You will be redirect to homepage after $seconds </div>";
        header("refresh:$seconds ; url = index.php");
        exit();

    } */
     /*
    ** Home redirect function v2.0 [this function accept parameters]
    ** $thesmsg= echo[error|success|warning]
    ** $seconds = second befor redirecting 
    ** $url= the link you want to redirect
    */
    function redirecthome($thesmsg , $url = null ,$seconds=3)
    {
         //دي كده ع حسب المسدج ايرور او ساكسس
        if($url===null){
            $url='index.php';
        }
        else {
            // لو فيه ريفيرار موجود ومش  فاضى طب لو هو فاضلى وديني ع الاندكس
            if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
                $url = $_SERVER['HTTP_REFERER'];
            }
            else {
                $url='index.php';
            }
        }
         echo $thesmsg ;
        echo "<div class = 'alert alert-info'> You will be redirect to perevious page after $seconds </div>";
        header("refresh:$seconds ; url = $url");
        exit();

    }
    /*
    ** func check items in database [accept parameter] v0.1
    ** $select= items select [ex:user,item,category]
    ** $from= the table to select from[ex:users,items categories]
    ** $value =the value of select [ ex: ahmed,box,electonics]
    */
    function checkitem($select , $from ,$value)
    {
        global $con;
        $stetment=$con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stetment->execute(array($value));
        $count = $stetment -> rowCount();
        return $count;
    }
    /*
    ** count number of items function v1.0
    ** fun to count items row 
    ** $items = the item to count
    ** $table = the table to choose from
    */
    function countitems($items,$table){
        global $con;
        $stmt2=$con->prepare("SELECT count($items) FROM $table");
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }
    /*
    **GEt latest record func
    ** fun to get latest items from database 
    **$select=field to select
    **$table = table to choose
    **$limit = num of record to get
    $order = order by ?
    */
    function getlatest($select,$table,$order,$limit = 5)
    {
        global $con;
        $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $getstmt->execute();
        $rows = $getstmt->fetchAll();
        return $rows;
    }
    