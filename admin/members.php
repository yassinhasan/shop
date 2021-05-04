<?php
require_once "../ini.php";
$title = (isset($_GET['action']) &&$_GET['action'] != "manage") ?$_GET['action']: "members" ; 

gettheheader();


    

    // check if session is set

    if(! isset($_SESSION['Adminuser'])  )
    {
 
       $_SESSION['access'] = '<div class="alert alert-danger alert-dismissible fade show login-alert"             role="alert">
         Wellcome<strong>  sorry  account   not allowed to acces this page </strong>.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'; 
       header("location: /admin/");
       session_write_close();
       exit();
    }

    get_dashboard_navbar();

    $access = [
        "add",
        "delete",
        "edit",
        "update",
        "newmembers",
        "activate",
        "blocked"
        
    ];


    $action = isset($_GET['action']) ? $_GET['action'] : "";

    // acton = manage
    if($action == "" || $action == "manage" || !in_array($action,$access))
    {
        echo "wellcome to manage";
            //
      $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
      echo $message;
    $_SESSION['message'] = "";

    //
    }

    // edit page
    elseif($action == "edit")
    {
     
        get_action_form("MEMBER","edit");
     }

    // update page 
    elseif($action == "update")
    {
        get_action_form("MEMBER","update");

    }

    // all members 
    elseif($action == "newmembers")
    {
        $title = (isset($_GET['action']) &&$_GET['action'] != "newmembers") ?$_GET['action']: "newmembers" ;  
        get_action_form("MEMBER","newmembers");
    }

    // delete 
    elseif($action == "delete")
    {
       $UserId = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? $_GET['UserId'] : 0; 
       $sql = "DELETE FROM users WHERE UserId = :UserId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  deleted</p>";
        $url = "?action=newmembers";
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    // approve pending member
    elseif($action == "activate")
    {
       $UserId = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? $_GET['UserId'] : 0; 
       $sql = "UPDATE users SET RegStatus = 1 WHERE UserId = :UserId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $url;
        if(isset($_GET['dash']) && $_GET['dash']== 'yes')
        {
            $url = "/admin/dashboard.php"; 
        }
        else
        {
            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";
            $url = "?action=newmembers";
        }
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    elseif($action == "blocked")
    {
       $UserId = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? $_GET['UserId'] : 0; 
       $sql = "UPDATE users SET RegStatus = 0 WHERE UserId = :UserId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $_SESSION['message'] ="<p class='alert alert-warning'> <strong> ".$stmt->rowCount() ."</strong>  blocked</p>";
        $url = "?action=newmembers";
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    elseif($action == "add")
    {
        get_action_form("MEMBER","add");
    }


    getthefooter(); ?>
