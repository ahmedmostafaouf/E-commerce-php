<?php
/* هنا صفحه الداش بورد دي ال اتحولتلها من الفورم بعد اما اتاكدت ان فيه
يوزر نيم لو مشم وجود هيحولني ع اللوجين تاني   */
session_start();

if(isset($_SESSION['usersesion'])) //لو السنشن موجود هقولو ويلكم 
{
  $pageTitle = "dashpoard";
  include  "init.php"; 
  //echo 'welcome';
   /* start dashboard page */
  
   $usernum = 5;
   $latestuser = getlatest("*","user","UserID",$usernum) ;
   $itemnum = 5;
   $latestitem = getlatest("*","items","item_id",$itemnum) ;
   $comnum  = 2;
   $latestcomment = getlatest("*","comment","c_id",$comnum) ;
     ?>
      <div class = "container home-stats text-center">
            <h1> Dashboard </h1>
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                        Total Members
                        <span> <a href = "member.php"> <?php echo countitems('UserID','user'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-pending">
                        <i class="fa fa-plus"></i>
                        <div class="info">
                        Pending Members
                        <span> <a href = "member.php?do=mange&page=pending" > <?php echo checkitem("RegStatus" , "user" , 0)  ?> </a></span>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-items">
                    <i class="fa fa-tag"></i>
                      <div class="info">
                      Total Items
                      <span><span> <a href = "item.php"> <?php echo countitems('item_id','items'); ?></a></span></span>
                      </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-comments">
                    <i class="fa fa-comment"></i>
                      <div class="info">
                      Total Comments
                      <span><a href = "comment.php"> <?php echo countitems('c_id','comment'); ?></a></span>
                      </div>
                    </div>
                </div>
            
            </div>
      </div>
      <div class = "latest">
        <div class= "container">
              <div class="row">
                <div class = "col-sm-6">
                  <div class = "panel panel-default">
                    <div class= "panel-heading">
                      <i class = "fa fa-users"></i> Latest <?php echo $usernum; ?> Registerd Users
                      <span class="toggel-info pull-right">
                        <i class="fa fa-plus fa_lg"></i>
                      </span>
                    </div>  
                    <div class= "panel-body">
                    <ul class="list-unstyled latest-users">
                      <?php 
                      
                      if(! empty( $latestuser )){
                      
                      foreach($latestuser as $user)
                      {
                        echo"<li>";
                        echo $user['UserName'];
                        echo "<a href='member.php?do=edit&userid= ".$user['UserID']."'>";
                            echo'<span class ="btn btn-success pull-right">';
                                  echo "<i class='fa fa-edit'></i> Edit";
                                  if($user['RegStatus']==0)
                                  {
                                   echo "<a href = 'member.php?do=activate&userid=".$user['UserID']. "'class = 'btn btn-info pull-right activate '> <i class='fa fa-check'></i> Activate </a>";
                                  }
                            echo '</span>';
                        echo "</a>";      
                        echo'</li>';
                      }
                    }else{
                      echo 'There\'s No Record To Show';
                    }
                      ?>
                    </ul>
                    </div>
                   </div> 
                </div>  
                <div class = "col-sm-6">
                  <div class = "panel panel-default">
                      <div class= "panel-heading">
                        <i class = "fa fa-tag"></i> Latest  <?php echo $itemnum; ?> Items
                        <span class="toggel-info pull-right">
                        <i class="fa fa-plus fa_lg"></i>
                      </span>
                      </div>  
                        <div class= "panel-body">
                        <ul class="list-unstyled latest-users">
                      <?php 
                      
                      if(!empty( $latestitem )){
                     
                      foreach($latestitem as $item)
                      {
                        echo"<li>";
                        echo $item['name'];
                        echo "<a href='item.php?do=edit&item_id= ".$item['item_id']."'>";
                            echo'<span class ="btn btn-success pull-right">';
                                  echo "<i class='fa fa-edit'></i> Edit";
                                  if($item['approve']==0)
                                  {
                                   echo "<a href = 'item.php?do=approve&item_id=".$item['item_id']. "'class = 'btn btn-info pull-right activate '> <i class='fa fa-check'></i> Activate </a>";
                                  }
                            echo '</span>';
                        echo "</a>";      
                        echo'</li>';
                      }
                    }else{
                      echo 'There\'s No Items To Show';
                    }
                      ?>
                    </ul>
                        </div>
                      </div> 
                  </div>
                </div> 
                <!--start latest comment -->
                <div class="row">
                <div class = "col-sm-6">
                  <div class = "panel panel-default">
                    <div class= "panel-heading">
                      <i class = "fa fa-comment-o"></i> Latest   <?php echo $comnum; ?> Comment
                      <span class="toggel-info pull-right">
                        <i class="fa fa-plus fa_lg"></i>
                      </span>
                    </div>  
                    <div class= "panel-body">
                    <?php
                   
                              $stmt = $con->prepare("SELECT 
                              comment.*, user.UserName AS Member  
                              FROM 
                                  comment
                              INNER JOIN 
                                  user
                              ON 
                                  user.UserID = comment.user_id 
                              ORDER by
                                  c_id DESC
                              LIMIT $comnum " );
                              // هجيب البيانات دي
                              $stmt->execute();
                              // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                              $comments = $stmt->fetchAll();
                              $count=$stmt->rowCount();
                              if(! empty($comments)){
                              foreach($comments as $com)
                              {
                                echo "<div class='comment-box'>";
                                    echo "<span class='member-n'>".$com['Member']."</span>";
                                    echo "<p class='member-c'>".$com['c_name']."</p>";
                                echo "</div>";
                              }
                            }
                            else{
                              echo 'There\'s No Comments To Show';
                            }

                    ?>
                    </div>
                    </div>
                    </div>
                    </div>
                    <!--end latest comment -->
                  
                    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e77dd79eec7650c3321dd31/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
                                 
               </div>   
         </div> 
       </div>
     <?php
   /* end dashboard page */
  include $tpl  .  'fotar.php' ; 

}else { // لو مش موجود هحوله للوجين يسجل من جديد
    //echo 'not login please login';
    header('location:index.php');
    exit();
}