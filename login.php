<?php
ob_start();
require_once "ini.php";
$title = "login";
get_main_webisite_header();
get_main_webisite_navbar();

    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
	echo $message;
    $_SESSION['message'] = "";
if (isset($_POST['login']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['Email']) ? $_POST['Email'] : false;
    $rememberme = isset($_POST['RememberMe']) ? $_POST['RememberMe'] : false;
    $password = isset($_POST['Password']) ? sha1($_POST['Password']) : "";

    $sql = "SELECT * FROM users WHERE Email = :e AND Password = :p";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":e",$email,pdo::PARAM_STR);
    $stmt->bindValue(":p", $password, pdo::PARAM_STR);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                $results = $stmt->fetchAll();
                $result =array_shift($results) ;
				if($rememberme == "on")
				{
					$username = hash("md5",$result['UserName']);
					$userid = $result['UserId'];
					$_SESSION['user_is_loggedin'] = 1;
					setcookie("username",$username,time()+3600,"/","shop.com");
					setcookie("email",$email,time()+3600,"/","shop.com");
					setcookie("password",$_POST['Password'],time()+3600,"/","shop.com");
					$sql = "UPDATE users set login_session = ? WHERE UserId = ?";
					$stmt = $conn->prepare($sql);
					$stmt->execute(array($username,$userid));
				}
				else
				{
					setcookie("email",$email,time()-3600,"/","shop.com");
					setcookie("password",$_POST['Password'],time()-3600,"/","shop.com");

				}
				$status = check_pending_users($result['UserName']);
				if($status)
				{
					header("location: pedning.php");
					exit;
				}

				if($result['GroupID'] == 1)
				{
					$_SESSION['Adminuser'] = true;
					$_SESSION['Admin'] = $result;
					header("location: /admin/dashboard.php");
					exit();
				}          
				else
				{               
					 $_SESSION['User'] = $result;
					header("location: profile.php");
					exit();
				}

            }
            else
            {
            
            session_write_close();
            $_SESSION['message'] ="<p class='alert alert-danger'> sorry  UserName or email  not correct</p>";
            echo $_SESSION['message'];

            }
        
    }
}
// start register
if(isset($_POST['register']))
{
   $UserName = isset($_POST['UserName'])?trim($_POST['UserName']) : "";
   $Password = isset($_POST['Password'])?sha1(trim($_POST['Password'])) : "";
   $CPassword = isset($_POST['ConfirmPassword'])?sha1(trim($_POST['ConfirmPassword'])) : "";
   $Email = isset($_POST['Email'])?$_POST['Email'] : "";
   $FullName = isset($_POST['FullName'])?$_POST['FullName'] : "";



	$sql = "INSERT INTO users (`UserName`, `Password`, `Email`, `FullName`)
	VALUES(:U,:P,:E,:FN)";
	global $conn;
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(":U",$UserName,PDO::PARAM_STR);
	$stmt->bindValue(":P",$Password,PDO::PARAM_STR);
	$stmt->bindValue(":E",$Email,PDO::PARAM_STR);
	$stmt->bindValue(":FN",$FullName,PDO::PARAM_STR);
	$formeroor = [];

	if(empty($UserName))
	{
		$formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>UserName</strong> can not be empty
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>';
	}
	if(empty($FullName))
	{
		$formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>FullName</strong> can not be empty
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>';
	}
	if(empty($Email))
	{
		$formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Email</strong> can not be empty
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>';        
	}
	if(empty($_POST['Password']))
	{
		$formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Password</strong> can not be empty
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>'; 
	        
	}
	if(!empty($_POST['Password']) && ($_POST['Password'] !== $_POST['ConfirmPassword']))
	{
		$formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Password must be matched</strong> 
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>'; 
	}


	if(empty($formeroor))
	{
		if($stmt->execute())
		{
			if($stmt->rowCount() > 0 )
			{
				$_SESSION['message'] ="<p class='alert alert-success'> welccome ".$_POST['UserName']."</p>";
				$url = "login.php";
				// header("Refresh:2 $url");
				header("Refresh:0 ; url = $url");
			}
		}
		else
		{
			error_redirection("this page not found");
		}
	   
	}
	else
	{
		foreach($formeroor as $err)
		{
			echo $err;
		}
	}

}
// end register
?>


<div class="login-page">
  <div class="box">
    <div class="left">
      <h2>
        Create Acoount
      </h2>
      <button class="btn-register">
        Register
      </button>
    </div>
    <div class="right">
      <h2>
        Have An Acount
      </h2>
      <button class="btn-login">
        Log IN
      </button>
    </div>
		<div class="form">
		<!-- start login form -->
			<div class="login-form <?= isset($_POST['register']) ? 'hidden-form': '' ?>">
			<h2>
			Log In
			</h2>
				<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<div class="form-group">
					<input type="email" name="Email" placeholder="type your email" class="form-control"
					value="<?= !empty($_COOKIE['email'])? $_COOKIE['email'] : ""?>"
					>
				</div>
				<div class="form-group">
					<input type="password" name="Password" placeholder="type your password" class="form-control"
					value="<?= isset($_COOKIE['password'])? $_COOKIE['password'] : ""?>"
					>
				</div>
			<div class="check-group">
			<label>
				<input type="checkbox" name="RememberMe">
				Remember Me
 			</label>
			</div>
			<div>
					<button class="btn-login" name="login">
					LogIN
				</button>
			</div>
				</form>
			</div>
			<!-- end login form -->
		<!-- start register form -->
			<div class="register-form <?= !isset($_POST['register']) ? 'hidden-form': '' ?>">
			<h2>
			REGISTER
			</h2>
			<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<div class="form-group">
					<input type="text" name="UserName" class="form-control check-exists-user" id="exampleInputname"
					placeholder="User Name"
					value="<?= isset($_POST['UserName'])?$_POST['UserName'] : "" ?>"
					
					>	
				</div>
				<div class="form-group">
					<input type="text" name="FullName" class="form-control" id="exampleInputFullName"
					value="<?= isset($_POST['FullName'])?$_POST['FullName'] : "" ?>"
					placeholder="Full Name "
					
					>	
				</div>
				<div class="form-group">
			</div>
				<div class="form-group">
                <input type="email" name="Email"	 
				class="form-control check-email" id="exampleInputemail" 
				placeholder="Email"
                value="<?= isset($_POST['Email'])?$_POST['Email'] : "" ?>"
                >				</div>
				<div class="form-group">
                <input type="password" name="Password" class="form-control" id="exampleInputPassword1" 
				placeholder="User Password"
                
                >
				</div>
				<div class="form-group">
                <input type="password" name="ConfirmPassword" class="form-control" id="exampleInputPassword2" 
				placeholder="User Confirm Password"
				>
				</div>

				<button class="btn-register" name="register">
					NEW test 
				</button>
			
			</form>
			<!-- end register form -->
		</div>
  </div>
	</div>
</div>



<?php global $conn;
get_main_webisite_footer();
ob_end_flush();