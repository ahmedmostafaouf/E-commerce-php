<?php
session_start();
$pageTitle= "login";
if(isset($_SESSION['user'])) //دخلت لقتني مسجل حولني ع الداش بورد
{
  header('location: index.php');
}
include 'init.php';


// user coming from http post request
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['login'])){
    $user=$_POST['username'];
    $pass=$_POST['password'];
    
   $hachedpass=sha1($pass);//ده حمايه للباص عشان متخشش ف الداتا بيز يشوفها 
   //check the user exist in DB
   $stmt = $con-> prepare("SELECT
                                UserID,UserName , password
                           FROM
                                 user
                            WHERE
                                 UserName=?
                            AND
                                password=?");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
   $stmt->execute(array($user,$hachedpass)); // ابحثلي عنهم فى الداتا بيز 
   $get=$stmt->fetch(); 
   $count = $stmt -> rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
   //echo $count; لو موجود يبقي 1 لو مش موجود يبقي 0
   // if count >0 this main about database contain record about this user name

   if($count>0)
   {
     $_SESSION['user']=$user; //سجلت السيشن بيوزر ال جاي من الفورم
	$_SESSION['uid']=$get['UserID'];//register User ID in session
	 header('location:index.php'); //هيجولني لصفحه دي لو لقاه السيشن
     exit();
   }
  }
   else
   {  
//عندي هنا متغير اسمي للايرورز لو فيه ايروور يحط ف الاراااي دي ويعد كده عمل شرط الي جايلي من الفورم بتاعتي دي الي فيها يوزر نيم هعقمها من كل الاسكربتات والحاجه الي جايه ويطلعلني الاسم بس 
	   $formErrors=array();
	   $username = $_POST['username'];
	   $password = $_POST['password'];
	   $password2 = $_POST['password2'];
	   $email = $_POST['email'];
	   if(isset($_POST['username'])){
		   $FilterUser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);
		   if(strlen( $FilterUser) <4){
			$formErrors[]="UserName Must be Larger than 4 char";
		   }
	   }
	   // ههبعت الباص وان والباص تو ولو هما مش شبه بعض اعمل كذا 
	   if(isset($_POST['password'])&&isset($_POST['password2'])){
		   if(empty($_POST['password'])){
			$formErrors[]="Sorry password Empty";	   
		   }
		$pass1 = sha1($_POST['password']);
		$pass2 = sha1($_POST['password2']);
		if($pass1!==$pass2){
		 $formErrors[]="Sorry password is not match";
		}
	}
	if(isset($_POST['email'])){
		$FilterEmail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
		if(filter_var($FilterEmail , FILTER_VALIDATE_EMAIL)!= true){
		 $formErrors[]="This Email IS Not Valid";
		}
	}
	 //check if there no error
	 if(empty($formErrors))
	 {
	   //check if user insert in database
	   $check = checkitem("UserName" , "user" ,$username);
	   if($check==1)
	   {
		$formErrors[] = "Sorry UserName IS Exist";
	   }
	   else{
	   //Insert user info  database
		$stmt = $con->prepare("INSERT INTO user(UserName,password,Email,RegStatus,Date)VALUES(:zuser,:zpass,:zmail,0,now())");
		$stmt->execute(array('zuser' => $username , 'zpass' => sha1($password) , 'zmail' => $email));
	   
	   //ecoh massge success 
	   $successmsg="Congraits You Are Now Registerd User";
	   
	   }
	 }
  }        

}


?>
     <div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> | 
		<span data-class="signup">Signup</span>
    </h1>
    <!-- Start Login Form -->
	<form class="login"  action ="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
		<div class="input-container">
			<input 
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type your password"/>
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action ="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="UserName Must Be 4 char"
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" />
		</div>
		<div class="input-container">
			<input 
			    minlength="4"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type a Complex password"
				required />
		</div>
		<div class="input-container">
			<input 
			    minlength="4"
				class="form-control" 
				type="password" 
				name="password2" 
				autocomplete="new-password"
				placeholder="Type a password again"
				required />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="email" 
				name="email" 
				placeholder="Type a Valid email" />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
	</form>
	<!-- End Signup Form -->
	<div class="the-errors text-center">
		<?php 
		  if(!empty($formErrors))
		  {
			  foreach($formErrors as $errors){
				echo "<div class='container'>";
				echo '<div class="nice-message"> '.  $errors .' </div>';
			echo "</div>"; 
			  }
		  }
		  if(isset($successmsg)){
			echo "<div class='container'>";
			echo '<div class="succss-message"> '.  $successmsg .' </div>';
		echo "</div>"; 
			  
		  }
		?>
    </div>

<?php include $tpl  .  'fotar.php' ;?>
