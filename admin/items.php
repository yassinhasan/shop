<?php
require_once "../ini.php";
$title = (isset($_GET['action']) &&$_GET['action'] != "manage") ?$_GET['action']: "items" ; 
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
        "items_add",
        "items_delete",
        "items_edit",
        "items_update",
        "item_approve",
        "newitems",  
        "item_pending"      
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
    elseif($action == "items_edit")
    {
     
        get_action_form("items","edit");
     }

    // update page 
    elseif($action == "items_update")
    {
        get_action_form("items","update");

    }

    // all members 
    elseif($action == "newitems")
    {
        $title = (isset($_GET['action']) &&$_GET['action'] != "newitems") ?$_GET['action']: "newitems" ;  
        get_action_form("items","newitems");
    }

    // delete 
           //  itemsId   // items (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
    elseif($action == "items_delete")
    {
       $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? $_GET['itemId'] : 0; 
       $sql = "DELETE FROM items WHERE itemId = :itemId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  deleted</p>";
        $url = "?action=newitems";
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    elseif($action == "item_approve")
    {
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? $_GET['itemId'] : 0; 
        $sql = "UPDATE items set itemApprove = 1 WHERE itemId = :itemId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
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
            $url = "?action=newitems";
            // header("Refresh:2 $url");
            header("Refresh:0 ; url = $url");
           }
        }
    }
    elseif($action == "item_pending")
    {
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? $_GET['itemId'] : 0; 
        $sql = "UPDATE items set itemApprove = 0 WHERE itemId = :itemId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
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
            $url = "?action=newitems";
            // header("Refresh:2 $url");
            header("Refresh:0 ; url = $url");
           }
        }
    }

    // approve pending member


    elseif($action == "items_add")
    {
        get_action_form("items","add");
    }


getthefooter(); ?>


 