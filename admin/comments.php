<?php
require_once "../ini.php";
$title = (isset($_GET['action']) &&$_GET['action'] != "manage") ?$_GET['action']: "comments" ; 
gettheheader();
if(! isset($_SESSION['Adminuser'])  )
    {
 //     $_SESSION['access'] ="<p class='alert alert-danger'> sorry  account   not allowed to acces this page</p>";
       $_SESSION['access'] = '<div class="alert alert-danger alert-dismissible fade show login-alert" role="alert">
    Wellcome<strong>  sorry  account   not allowed to acces this page </strong>.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>'; 
       header("location: /admin/");
       session_write_close();
       exit();
    }
    get_dashboard_navbar();    
    $access = [
        "comments_delete",
        "comments_edit",
        "comments_update",
        "comments_approve",
        "allcomments",  
        "comments_pending"      
    ];


    $action = isset($_GET['action']) ? $_GET['action'] : "";

    // acton = manage
    if($action == "" || $action == "manage" || !in_array($action,$access))
    {
            //
      $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
      echo $message;
    $_SESSION['message'] = "";

    //
    }

    // edit page
    elseif($action == "comments_edit")
    {
     
        get_action_form("comments","edit");
     }

    // update page 
    elseif($action == "comments_update")
    {
        get_action_form("comments","update");

    }

    // all members 
    elseif($action == "allcomments")
    {
        $title = (isset($_GET['action']) &&$_GET['action'] != "allcomments") ?$_GET['action']: "allcomments" ;  
        get_action_form("comments","allcomments");
    }

    // delete 
           //  commentsId   // comments (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
    elseif($action == "comments_delete")
    {
       $commentsId = isset($_GET['commentsId']) && is_numeric($_GET['commentsId']) ? $_GET['commentsId'] : 0; 
       $sql = "DELETE FROM comments WHERE commentsId = :commentsId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":commentsId",$commentsId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  deleted</p>";
        $url = "?action=allcomments";
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    elseif($action == "comments_approve")
    {
        $commentsId = isset($_GET['commentsId']) && is_numeric($_GET['commentsId']) ? $_GET['commentsId'] : 0; 
        $sql = "UPDATE comments set commentsApprove = 1 WHERE commentsId = :commentsId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":commentsId",$commentsId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $url;
        if(isset($_GET['dash']) && $_GET['dash']== 'yes')
        {
            $url = "/admin/dashboard.php"; 
            header("Refresh:0 ; url = $url");
        }
        else
        {
            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  approved</p>";
            $url = "?action=allcomments";
            // header("Refresh:2 $url");
            header("Refresh:0 ; url = $url");
           }
        }
    }
    elseif($action == "comments_pending")
    {
        $commentsId = isset($_GET['commentsId']) && is_numeric($_GET['commentsId']) ? $_GET['commentsId'] : 0; 
        $sql = "UPDATE comments set commentsApprove = 0 WHERE commentsId = :commentsId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":commentsId",$commentsId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $url;
        if(isset($_GET['dash']) && $_GET['dash']== 'yes')
        {
            $url = "/admin/dashboard.php"; 
            header("Refresh:0 ; url = $url");
        }
        else
        {
            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  pending </p>";
            $url = "?action=allcomments";
            // header("Refresh:2 $url");
            header("Refresh:0 ; url = $url");
           }
        }
    }

    // approve pending member


getthefooter(); ?>


 