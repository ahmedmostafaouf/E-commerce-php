<?php 
session_start();
include "conect.php";
$other = isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;
$sender = $_SESSION['uid'];

if($sender>$other)
{
    $chatid = $sender.$other;

}elseif($other > $sender){
    $chatid = $other.$sender;
}
$stmt = $con->prepare("SELECT 
                                    chat.*, user.*  
                            FROM 
                                    chat
                            INNER JOIN 
                                        user
                            ON 
                                        user.UserID = chat.sender 
                            WHERE
                                        chat.chat_id=$chatid 
                            ORDER BY 
                                        chat.time               
                                    ");
                                    // هجيب البيانات دي
                                    $stmt->execute();
                                    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                                    $chatbox = $stmt->fetchAll(); 
                                   

                                    foreach($chatbox as $chat){
                                       // عشان اما اقف واعمل ريفرش الرساله تروح
                                       $stmt = $con->prepare("UPDATE chat SET seen=1 WHERE other=".$_SESSION['uid']." AND sender=".$chat['sender']."");
                                       $stmt->execute();
                                        if($chat['sender']==$_SESSION['uid']){
                                              // استعلام جدول اليوزر عشان اجيب الاسم
                                              $stmt = $con->prepare("SELECT * FROM user WHERE UserID=". $chat['sender']."");
                                              $stmt->execute();
                                              $userinfo = $stmt->fetch();  
                                          ?>    
                             <!-- start  by me --> 
                               <li class="by-me margin-bottom-10" >
                                  <div class="avatar pull-left" > 
                                    <img height="50px" width="50px" src="ss.jpg"   >
                                  </div>
                                  <div class="content" >
                                     <div class="chat-meta" > <?php echo  $userinfo['UserName'] ?> <span class="pull-right"> <?php echo $chat['time'] ?> </span></div>
                                     <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                                  </div> 
                               </li>
                             <!-- end by me -->
                                        <?php } elseif($chat['other']== $_SESSION['uid']){?>
                            
                             <!-- start  by other -->
                               <li class="by-other margin-bottom-10" >
                                 <div class="avatar pull-right" > 
                                    <img height="50px" width="50px" src="img.jpg" >
                                  </div>
                                  <div class="content" >
                                     <div class="chat-meta" > <?php echo $chat['time'] ?> <span class="pull-right"> <?php echo $chat['UserName'] ?> </span></div>
                                     <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                                  </div> 
                               </li>
                             <!-- end  by other -->
                                        <?php } }

?>