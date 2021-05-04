<?php
require_once "../ini.php";
if (isset($_POST['login']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['UserName']) ? $_POST['UserName'] : false;
    $password = isset($_POST['Password']) ? sha1($_POST['Password']) : "";

    $sql = "SELECT * FROM users WHERE UserName = :u AND Password = :p AND GroupID = 1 LIMIT 1";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":u",$username,pdo::PARAM_STR);
    $stmt->bindValue(":p", $password, pdo::PARAM_STR);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {

 
                $results = $stmt->fetchAll();
                $result =array_shift($results) ;
                if ( isset($_SESSION['user_is_loggedin'])  && $_SESSION['user_is_loggedin']== 1 )
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
                
                $_SESSION['Admin'] = $result;
                $_SESSION['Adminuser'] = true;            
                header("location: dashboard.php");
                exit();
            }
            else
            {
            
            session_write_close();
            $_SESSION['message'] ="<p class='alert alert-danger'> sorry  UserName or Password  not correct</p>";
            echo $_SESSION['message'];

            }
        
    }
}
?>

    <form class="login-form" method="post" action="<?=$_SERVER['PHP_SELF']?>">
        <div class="box">
         <h3> <?= lang("login") ?></h3>
        <div class="box">
            <div class="form-group">
                <label for="Username"> UserName</label>
                <input class="form-control form-control-lg" type="text" name="UserName" placeholder="enter your name" autocomplete="on" id="UserName"
                required
                >
            </div>
            <div class="form-group">
                <label for="Password"> Password</label>
                <input class="form-control form-control-lg" type="password" name="Password" placeholder="type your password"  id="Password" autocomplete="on"
                required
                >
            </div>
            <button class="btn btn-outline-primary block btn-login" name="login"> Log In</button>
        </div>
        </div>
    </form>