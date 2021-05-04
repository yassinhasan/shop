<?php
// function lang
function lang($key)
{

    $langaugue = isset($_SESSION['lang'])? $_SESSION['lang'] : "EN";
   if($langaugue == "AR")
   {
       require AR_LANG;
        if (array_key_exists($key, $lang)) {
            return $lang[$key];
        } else {
            return "soory unkown";
        }       
   }
   elseif($langaugue == "EN")
   {
   
        require ENG_LANG;
        if (array_key_exists($key, $lang)) {
            return $lang[$key];
        } else {
            return "soory unkown";
        }        
    }
    

}

function gettheheader()
{
    require_once HTML_PARTS . "header.php";
}
function getthefooter()
{
    require_once HTML_PARTS . "footer.php";
}
function get_login_form()
{
      require_once TEMPLATE_PATH 
      . "login.php";

}


// get action by writing section to get path and action to get action

function get_action_form($section = null , $action = null)
{
    if($section != null && $action != null)
    {
        $section = strtoupper($section);
        // echo constant($section."_PATH") 
        // .$action.".php";
       require_once constant($section."_PATH") 
       .$action.".php";    
    }
}



// index home redirect from dashboard
function check_access()
{
        if(isset($_SESSION['UserName']) )
    {
       header("location: dashboard.php");
       exit();
    }
    else
    {
       if(isset($_SESSION['access']) && $_SESSION['access'] != "")
        {
            echo $_SESSION['access'];
            $_SESSION['access'] = "";

        }
    }
}



function get_main_webisite_navbar()
{

        require_once MAIN_PAGE_PARTS . "navbar.php";
}
function get_main_webisite_header()
{

        require_once MAIN_PAGE_PARTS . "header.php";
}
function get_main_webisite_footer()
{

        require_once MAIN_PAGE_PARTS . "footer.php";
}

function get_dashboard_navbar()
{

        require_once HTML_PARTS . "dashboard_navbar.php";
}

// get title

function gettitle()

{
   global $title;
    return  isset($title) ? lang($title) : lang("default") ;
}
// set active

function set_active_class($page , $sec_page = null)

{
   global $title;
    return  (isset($title) &&($title == $page || $title == $sec_page)) ? 'active' :'' ;
}

function error_redirection($msg,$seconds = 2,$url="?action=manage")
{

    $_SESSION['message'] ="<p class='alert alert-danger'> <strong> ".$msg ."</strong></p>"; 
    header("refresh: $seconds ; url = $url" );
    exit;
}

//  get count member 

function get_count($value ,$table_name,$where = null )
{
    global $conn;
    $sql = "SELECT $value FROM $table_name $where";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function get_last_by_order($value,$table_name,$orderby,$flags='DESC',$where = null,$lmit)
{
    global $conn;
    $sql = "SELECT $value FROM $table_name ORDER BY $orderby $flags $where LIMIT $lmit ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



// function to add checked when edit
function add_check_onedit($obje , $checked)
{
    if(isset($obje[$checked]) && $obje[$checked] == "no")
    {
        return "checked = checked";
    }
    else
    {
        return;
    }
}

 function get_rating($num_of_star)
{
    for($x =1; $x <= $num_of_star ; $x++)
    {
        echo " * ";
    }
}


//get categories
function get_categories()
{
    global $conn;
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result; 
}


//get items

function get_items($categoryId)
{
    global $conn;
    $sql = "SELECT * FROM items WHERE categoryId = :categoryId ORDER BY itemId DESC" ;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":categoryId",$categoryId,PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result; 
}

function get_by_id($table_name,$id_name,$id_value)
{
    global $conn;
    $sql = "SELECT * FROM $table_name WHERE $id_name = :$id_name" ;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":$id_name",$id_value,PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results; 

}

function checkislogin()
    {
        if(!empty($_COOKIE) && isset($_COOKIE['username']))
        {
            $username = $_COOKIE['username'];
            $sql = "SELECT * FROM users WHERE login_session = ? AND RegStatus = 1";
            global $conn;
            $stmt = $conn->prepare($sql);
            if ( $stmt->execute(array($username)))
            {
        
                $count = $stmt->rowCount();
                if($count > 0)
                    {
                        
                        $results = $stmt->fetchAll();
                        $result =array_shift($results) ;
                        if($result['GroupID'] == 1)
                        {
                            $_SESSION['Adminuser'] = true;
                            $_SESSION['Admin'] = $result;
                        }
                        else
                        {
                            $_SESSION['User'] = $result;
                        }          
                    }          
            }
        }
        
}
//check pending users
 function check_pending_users($username)
{
    $sql = "SELECT UserName,RegStatus FROM users WHERE UserName = ? AND RegStatus = 0 ";
    global $conn;
    $stmt = $conn->prepare($sql);
    if ( $stmt->execute(array($username)) )
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                
                return true;
            }
            else
            {
                return false;
            }          
    }
    

}
checkislogin();
   

