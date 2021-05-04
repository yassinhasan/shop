<?php
        if(isset($_POST['save']))
        {
 
            $UserId = isset($_POST['UserId']) ? $_POST['UserId']  : "";
            $Password = (isset($_POST['Password']) && $_POST['Password'] != "") ? sha1($_POST['Password'])  : "";
            $NewPassword = (isset($_POST['NewPassword'])&& $_POST['NewPassword'] != "") ? sha1($_POST['NewPassword'])  : "";
            $UserName = isset($_POST['UserName']) ? $_POST['UserName']  : "";
            $FullName = isset($_POST['FullName']) ? $_POST['FullName']  : "";
            $Email  = isset($_POST['Email']) ? $_POST['Email']  : "";

            $sql2 = "SELECT Password FROM users WHERE UserId  = :UserId LIMIT 1";
            global $conn;
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindValue(":UserId",$UserId,PDO::PARAM_INT);
            $Oldpassword;
            $formeroor = [];
;

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
            if(empty($Password))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Password</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($NewPassword))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>NewPassword</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($formeroor))
            {
                if ($stmt2->execute())
                {
                    $Oldpassword = $stmt2->fetch();
                    $Oldpassword = $Oldpassword['Password'];


                    if($Oldpassword  == $Password && !empty($_POST['NewPassword']))
                    {
                    
                        $sql = "UPDATE users set `Password` = ? , `UserName` = ? , `FullName` = ? , `Email` = ?  WHERE `UserId` = ? ";
                        global $conn;
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute(array($NewPassword,$UserName,$FullName,$Email, $UserId)))
                        {
                        
                            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";
                            
                            if($_SESSION['UserId'] == $UserId)
                            {
                                $_SESSION['User']['UserName'] = $UserName;
                            }
                            $url = "?action=newmembers";
                            // header("Refresh:2 $url");
                            header("Refresh:0 ; url = $url");
                            
                        }
                    }
                    else
                    {
                        
                        // $_SESSION['message'] ="<p class='alert alert-danger'> sorry  old Password  not correct</p>";
                        $path = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "?action=manage";
                        header("location: $path");
                    }
                }
            }
            else
            {
               if(isset($formeroor) && is_array($formeroor))
                {
                    $_SESSION['message'] = $formeroor;
                }
                $_SESSION['message'] = $formeroor;
                // foreach($formeroor as $err)
                // {
                //     echo $err;
                // }
                $path = $_SERVER['HTTP_REFERER'];
                header("location: $path");
                
            }

            
           

        }
        else
        {
            $path = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "?action=manage";
            header("location: $path");

        }
        ?>