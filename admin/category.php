<?php
require_once "../ini.php";
$title = (isset($_GET['action']) &&$_GET['action'] != "manage") ?$_GET['action']: "categories" ; 
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
        "cat_add",
        "cat_delete",
        "cat_edit",
        "cat_update",
        "newcategories",        
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
    elseif($action == "cat_edit")
    {
     
       get_action_form("category","edit");
     }

    // update page 
    elseif($action == "cat_update")
    {
        get_action_form("category","update");

    }

    // all members 
    elseif($action == "newcategories")
    {
        $title = (isset($_GET['action']) &&$_GET['action'] != "newcategories") ?$_GET['action']: "newcategories" ;  
        get_action_form("category","newcategories");    }

    // delete 
           //  CategoryId   // category (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
    elseif($action == "cat_delete")
    {
       $CategoryId = isset($_GET['CategoryId']) && is_numeric($_GET['CategoryId']) ? $_GET['CategoryId'] : 0; 
       $sql = "DELETE FROM category WHERE CategoryId = :CategoryId";
       global $conn;
       $stmt = $conn->prepare($sql);
       $stmt->bindValue(":CategoryId",$CategoryId,PDO::PARAM_INT);
       if($stmt->execute())
       {
        $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  deleted</p>";
        $url = "?action=newcategories";
        // header("Refresh:2 $url");
        header("Refresh:0 ; url = $url");
       }
    }

    // approve pending member


    elseif($action == "cat_add")
    {
        get_action_form("category","add");      }


getthefooter(); ?>


 