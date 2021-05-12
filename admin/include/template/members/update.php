<?php
    ob_start();
                            

        if(isset($_POST['save']))
        {
 
            $UserId = isset($_POST['UserId']) ? $_POST['UserId']  : "";
            $Password = (isset($_POST['Password']) && $_POST['Password'] != "") ? sha1($_POST['Password'])  : "";
            $NewPassword = (isset($_POST['NewPassword'])&& $_POST['NewPassword'] != "") ? sha1($_POST['NewPassword'])  : "";
            $UserName = isset($_POST['UserName']) ? trim($_POST['UserName'])  : "";
            $FullName = isset($_POST['FullName']) ? $_POST['FullName']  : "";
            $Email  = isset($_POST['Email']) ? $_POST['Email']  : "";
            // start file
            
            $avatars = isset($_FILES['avatar'])?$_FILES['avatar'] : "";
            $avatar_temp_name = $avatars['tmp_name'];
            $avatar_name = $avatars['name'];
            $avatar_size = $avatars['size'];
            $avatar_type = $avatars['type'];
            $avatar_extension =explode(".",$avatar_name);
             // avtat extension
            $avatar_extension = strtolower(end($avatar_extension));
     
            $allowed_Extension  =array("png","jpeg","jpg","gif","jfif");
            
     
            //allowed size
            $allowed_size = 4E6;
     
            $rand_name = rand(0,1000);
             //avatar file name random will saved in db
            $avatr_rand_name = $rand_name."_".$avatar_name;

            // eend file

            $Oldpassword;
            $formeroor = [];

            $sql2 = "SELECT Password FROM users WHERE UserId  = :UserId LIMIT 1";
            global $conn;
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindValue(":UserId",$UserId,PDO::PARAM_INT);
            if ($stmt2->execute())
            {
                $Oldpassword = $stmt2->fetch();
                // $Oldpassword = sha1($Oldpassword['Password']);
                 $Oldpassword = $Oldpassword['Password'];
            }




            // end file

            // file


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
            if( $avatars['error'] === 4)
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> soory no file uploaeded</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';        
            }
            // file
            if( !in_array($avatar_extension,$allowed_Extension) && $avatars['error'] != 4)
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> soory this type not allowed</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';        
            }
            if(  $avatar_size > $allowed_size)
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> soory max allowed size is 4 MG</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';        
            }
            if($Oldpassword  != $Password && !empty($_POST['NewPassword']))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> password not match</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';        
            }
            // end file

            if(empty($formeroor))
            {

                    
                        $sql = "UPDATE users set `Password` = ? , `UserName` = ? , `FullName` = ? , `Email` = ?  ,`avatar` = ? WHERE `UserId` = ? ";
                        global $conn;
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute(array($NewPassword,$UserName,$FullName,$Email, $avatr_rand_name,$UserId )))
                        {
                             //  //   move file
                            $dir = dirname(__FILE__);
                            $up = $dir.DS."..".DS."..".DS."..".DS."..".DS;
                            $file_direction =  $dir.DS."..".DS."..".DS."..".DS."themes".DS."images".DS."uploads".DS.$UserName.DS;
                            $file_direction_in_main = $up."themes".DS."images".DS."uploads".DS.$UserName.DS;

                            if(!file_exists($file_direction))
                            {
                                mkdir($file_direction,0777,true);
                            }
                            if(!file_exists($file_direction_in_main))
                            {
                                mkdir($file_direction_in_main,0777,true);
                            }

                            // check if file already exists before

                            $files =  glob($file_direction."*.*");
                            $mainfiles =  glob($file_direction_in_main."*.*");
                            foreach($files as $f)
                            {
                                if(is_file($f)){
                                    $fn = explode("_",$f);
                                    if(strtolower($fn[1]) == $avatar_name)
                                    {
                                        
                                        unlink($f);
                                    }

                                }
                            }
                            foreach($mainfiles as $f)
                            {
                                if(is_file($f)){
                                    $fn = explode("_",$f);
                                    if(strtolower($fn[1]) == $avatar_name)
                                    {
                                       
                                        unlink($f);
                                    }

                                }
                            }
                            

                            if(move_uploaded_file($avatar_temp_name,$file_direction.$avatr_rand_name))
                            {
                                copy($file_direction.$avatr_rand_name,$file_direction_in_main.$avatr_rand_name);
                            }
                             // end file upload
                        
                            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";
                            
                            if($_SESSION['Admin'] == $UserId)
                            {
                                $_SESSION['Admin']['UserName'] = $UserName;
                            }
                            $url = "?action=newmembers";
                            header("Refresh:0 ; url = $url");
                            
                        }
                        else
                        {
                            echo "soory";
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
        ob_end_flush();
        ?>