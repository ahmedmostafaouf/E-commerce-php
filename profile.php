<?php
session_start();
$pageTitle= "Profile";
include 'init.php';
if(isset($_SESSION['user'])){

    $getuser = $con->prepare("SELECT * FROM user WHERE UserName=?");
    $getuser->execute(array($sessionUser));
    $info=$getuser->fetch();
?>  
<h1 class='text-center'> My Profile </h1>     
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class='panel-heading'> My Information </div>
            <div class='panel-body'>
                <ul class="list-unstyled">
                    <li>
                        <i class='fa fa-unlock-alt fa-fw'></i>
                        <span>Login Name</span> : <?php echo $info['UserName'] ?>
                    </li>
                    <li>
                        <i class='fa fa-envelope-o fa-fw'></i>
                        <span>Email</span> : <?php echo $info['Email'] ?>
                    </li>
                    <li>
                    <i class='fa fa-user fa-fw'></i>
                        <span>Full Name</span> : <?php echo $info['FullName'] ?>
                    </li>
                    <li>
                        <i class='fa fa-calendar fa-fw'></i>
                        <span>Registeried Date</span> : <?php echo $info['Date'] ?>
                    </li>
                    <li>
                        <i class='fa fa-tags fa-fw'></i>
                        <span>Fav category</span> : 
                    </li>
                </ul>
                <a href="#" class="btn btn-primary"> Edit Information </a>
            </div>    
        </div>    
    </div>    
</div>    
<div id="my-ads" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class='panel-heading'> My Items </div>
            <div class='panel-body'>
                     <?php
                     $getallitems=getAllfrom("*","items","where member_id= {$info['UserID']} ","","item_id","DESC");
                     if(! empty( $getallitems )){
                        echo '<div class="row">';
                        foreach( $getallitems  as $items)
                        {
                                echo '<div class = "col-sm-6 col-md-3">';
                                    echo '<div class="thumbnail item-box">';
                                    if($items['approve']==0){
                                        echo  "<span class ='approve-status' >Waiting Approval</span>";
                                    }
                                        echo '<span class="price-tag">$'.$items['price'] .'</span>';
                                        echo '<img class="img-responsive" src="img.jpg" alt="" />';
                                        echo '<div class = "caption">';
                                            echo '<h3> <a href="item.php?item_id='.$items['item_id'].'">'.$items['name'] .'</h3> </a>';
                                            echo '<p>'.$items['description'] .'</p>';
                                            echo '<div class="date">'. $items['add_date'].'</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                        }
                     echo "</div>";
                    }
                    
                    else{
                        echo 'There\'s No ADS To Show Create <a href="newad.php"> New Ad </a>';
                    }
                    
                    ?>
            </div>    
        </div>    
    </div>    
</div>    

<div class="my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class='panel-heading'> Latest Comment </div>
            <div class='panel-body'>
                  <?php
                  // v.02 function
                    $getallitems=getAllfrom("c_name","comment","where user_id= {$info['UserID']} ","","c_id","DESC");
                            /* $stmt = $con->prepare("SELECT c_name FROM comment WHERE user_id =?  ORDER BY
                            c_id DESC");
                            // هجيب البيانات دي
                            $stmt->execute(array($info['UserID']));
                            // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                            $comments = $stmt->fetchAll(); */
                            if(! empty($getallitems)){
                                foreach($getallitems as $com){
                                    echo '<P>'. $com['c_name'].'</p>';
                                }

                            }
                            else{
                                echo 'There\'s No Comment To Show ';
                            }
                        ?>
            </div>    
        </div>    
    </div>    
</div>    
<?php
}else{
    header('location: login.php');
    exit();
}
include $tpl  .  'fotar.php' ; 

?>

