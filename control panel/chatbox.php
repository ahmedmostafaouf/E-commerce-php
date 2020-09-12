    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="facivon.ico">

    <title>Facebook like chat</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="themes/js/script.js"></script>
  
  <div class="chat_box">
	<div class="chat_head"> Chat Box</div>
	<div class="chat_body"> 
	<div class="user"><img style="height:30px;width:30px; border-radius:30px;" src="Upload/Avatar/user.png"> List Frineds Name</div>
        <input name="msg Search" class='placeicon form-control' type="text"  placeholder="&#xf002; Search..." >
	</div>
      
  </div>

<div class="msg_box" style="right:290px">
	<div class="msg_head"><img style="height:30px;width:30px; border-radius:30px;" src="Upload/Avatar/user.png"> Frined Name
	<div class="close">x</div>
	</div>
	<div class="msg_wrap">
		<div class="msg_body">
            <!-- start by me -->
            <div class="avatar pull-left">
                <img style="height:30px; width:30px; border-radius:30px;"  src="Upload/Avatar/user.png">
                </div>
                <div class="msg_a">This is from A</div>
            <!-- end by me -->
            <!-- start by other -->
                <div class="avatar pull-right">
    			 <img style="height:30px;width:30px; border-radius:30px; float:right" src="Upload/Avatar/user.png">
                </div>
            <div class="msg_b">This is from B, and its amazingly kool nah... i know it even i liked it :)   
            </div>
            <!-- end by other -->
		</div>
	<div class="msg_footer">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <textarea name="msg_input" class="form-control"></textarea><br>
    <button type="submit" class="btn btn-primary btn-block" >Send</button>
</form>
        </div>
</div>
</div>