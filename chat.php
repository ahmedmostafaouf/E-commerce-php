<?php
session_start();
 
$pageTitle="chat";
include  "init.php";
$id = isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;

    $stmt =  $con->prepare("SELECT * FROM user WHERE UserID= $id");
    $stmt->execute();
    $info = $stmt->fetch();

    $sender = $_SESSION['uid'];
    $other  =isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;
   
    //عملت عمود بحيث يجمع الرسايل الي جاي من السيندر والازر ويجمعهم ف اي دي واحد عشان اما اجي اجلبه 
   //كمان هنا عشان نوحد الشات اي دي يبقي هنعمل جمله ايف 
   if($sender > $other){
    $chatID = $sender.$other;
   }
   else{
      $chatID= $other.$sender;
   }
    // code insert 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $msg    = $_POST['msg'];
     
        
      //Insert user info  database
      $stmt = $con->prepare("INSERT INTO chat(chat_id,sender,other,msg,time,date) VALUES (:zchat,:zsender,:zother,:zmsg,now(),now())");
      $stmt->execute(array( 'zchat' => $chatID,'zsender' => $sender , 'zother' => $other  , 'zmsg' => $msg ));
    }
    //اجلب البيانات بتاعتي 
     $stmt = $con->prepare("SELECT 
                                    chat.*, user.*  
                            FROM 
                                    chat
                            INNER JOIN 
                                        user
                            ON 
                                        user.UserID = chat.sender 
                            WHERE
                                        chat.chat_id=$chatID 
                            ORDER BY 
                                        chat.time               
                                    ");
                                    // هجيب البيانات دي
                                    $stmt->execute();
                                    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                                    $chatbox = $stmt->fetchAll(); 
                                    ?> 
<div class="informations ">
<div class="continer-fluid">
    <div class="col-xs-12  posts col-sm-12 col-md-9 col-lg-9" >
         <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p> الرسائل </p>
            </div>
            <div class="panel-body">
            <div class="scroll">
                <ul class="chat">
                <?php
                        foreach($chatbox as $chat){
                            if($chat['sender']==$_SESSION['uid']){ ?>
                    <!-- Start by me-->
                    <li class="by-me">
                        <div class="avatar pull-left">
                            <img class="img-responsive img-thumbnail right" src="img.jpg">
                        </div>
                        <div class="content">
                            <div class="chat-meta">
                            <?php echo $chat['UserName'] ?> <span class="pull-right"> <?php echo $chat['time'] ?>  </span>
                            </div>
                            <div class="clearfix">
                            <?php echo $chat['msg'] ?>
                            </div>
                        </div>
                    </li> 
                     <!-- end by me-->  
                            <?php } elseif($chat['sender']==$id){ ?> 
                      <!-- Start by other-->
                    <li class="by-other">
                            <div class="avatar pull-right">
                                    <img class="img-responsive img-thumbnail left" src="img.jpg">
                                </div>
                                <div class="content">
                                    <div class="chat-meta">
                                    <?php echo $chat['time'] ?><span  class="pull-right"> <?php echo $chat['UserName'] ?> </span>
                                    </div>
                                    <div class="clearfix">
                                    <?php echo $chat['msg'] ?>
                                    </div>
                                </div>
                    </li> 
                     <!-- end by other-->
                        <?php } 
                        } ?>
                      <ul>
                      </div>
                          <form action="<?php echo $_SERVER['PHP_SELF'] .'?friend='. $id?>" method="POST"  class="form-inline">
                                <div class="form-group">
                                   <input class="form-control"  name="msg" type="text" >     
                               </div>
                               <button class="btn btn-info" type="submit"> Send</button>
                          </form>
                      </div>

                </div>    
            </div>
            
        </div>
    </div> 
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p>  الصورة الشخصية </p>
            </div>
            <div class="panel-body">
                <img class="img-responsive img-thumbnail" src="img.jpg" >
           
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-user-plus"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-comments"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-heart"></i></button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
         <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p> Items </p>
            </div>
            <div class="panel-body">
            
                   
            </div>
        </div>
    </div>  
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p>  المعلموات الشخصية </p>
            </div>
            <div class="panel-body">
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
            </div>
        </div>   
    </div>
    </div>
    </div>










<?php
    

  include $tpl  .  'fotar.php' ; 

  ?>


