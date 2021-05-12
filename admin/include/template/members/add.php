<?php 


    if(isset($_POST['save']))
    {
       $UserName = isset($_POST['UserName'])?trim($_POST['UserName']) : "";
       $Password = isset($_POST['Password'])?sha1(trim($_POST['Password'])) : "";
       $Email = isset($_POST['Email'])?$_POST['Email'] : "";
       $FullName = isset($_POST['FullName'])?$_POST['FullName'] : "";
       $GroupID = isset($_POST['GroupID'])?$_POST['GroupID'] : "";
       $TrustStatus = isset($_POST['TrustStatus'])?$_POST['TrustStatus'] : "";
       $RegStatus = isset($_POST['RegStatus'])?$_POST['RegStatus'] : "";
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
        //avatar file name random
       $avatr_rand_name = $rand_name."_".$avatar_name;

        $sql = "INSERT INTO users (`UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`,`avatar`)
        VALUES(:U,:P,:E,:FN,:GI,:TS,:RS,:av)";
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":U",$UserName,PDO::PARAM_STR);
        $stmt->bindValue(":P",$Password,PDO::PARAM_STR);
        $stmt->bindValue(":E",$Email,PDO::PARAM_STR);
        $stmt->bindValue(":FN",$FullName,PDO::PARAM_STR);
        $stmt->bindValue(":GI",$GroupID,PDO::PARAM_INT);
        $stmt->bindValue(":TS",$TrustStatus,PDO::PARAM_INT);
        $stmt->bindValue(":RS",$RegStatus,PDO::PARAM_INT);
        $stmt->bindValue(":av",$avatr_rand_name,PDO::PARAM_STR);
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
          </div>';        }
          if($GroupID == "")
          {
              $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>GroupID</strong> can not be empty
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';        }
        if($TrustStatus == "")
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>TrustStatus</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if($RegStatus == "")
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>RegStatus</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if( $avatars['error'] === 4)
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> soory no file uploaeded</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        
        }
        if( !in_array($avatar_extension,$allowed_Extension))
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
        if(empty($formeroor))
        { 
            if($stmt->execute())
            {
                if($stmt->rowCount() > 0 )
                {
                // //  //   move file
                //     $dir = dirname(__FILE__);
                //     $up = $dir.DS."..".DS."..".DS."..".DS."..".DS;
                //     $file_direction =  $dir.DS."..".DS."..".DS."..".DS."themes".DS."images".DS."uploads".DS.$UserName.DS;
                //     $file_direction_in_main = $up."themes".DS."images".DS."uploads".DS.$UserName.DS;

                //     if(!file_exists($file_direction))
                //     {
                //         mkdir($file_direction,0777,true);
                //     }
                //     if(!file_exists($file_direction_in_main))
                //     {
                //         mkdir($file_direction_in_main,0777,true);
                //     }

                //     // check if file already exists before

                //     $files =  glob($file_direction."*.*");
                //     $mainfiles =  glob($file_direction_in_main."*.*");
                //     foreach($files as $f)
                //     {
                //         if(is_file($f)){
                //             $fn = explode("_",$f);
                //             if(strtolower($fn[1]) == $avatar_name)
                //             {
                //                 unlink($f);
                //             }

                //         }
                //     }
                //     foreach($mainfiles as $f)
                //     {
                //         if(is_file($f)){
                //             $fn = explode("_",$f);
                //             if(strtolower($fn[1]) == $avatar_name)
                //             {
                //                 unlink($f);
                //             }

                //         }
                //     }

                //     if(move_uploaded_file($avatar_temp_name,$file_direction.$avatr_rand_name))
                //     {
                //         copy($file_direction.$avatr_rand_name,$file_direction_in_main.$avatr_rand_name);
                //     }
                $dir = dirname(__FILE__);
                $first_path = "themes".DS."images".DS."uploads";
                $sec_path = "themes".DS."images".DS."uploads";

                movefile($dir,$first_path,$sec_path,$UserName,$avatar_name,$avatar_temp_name,$avatr_rand_name);
                    $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  add succesfully</p>";
                    $url = "?action=newmembers";
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

?>
<div class="container theform">
        <h1> Add new Members </h1>
        <form  method="POST" enctype="multipart/form-data">
            <div class="mb-3 col-md-6">
                <label for="exampleInputname" class="form-label">your name</label>
                <input type="text" name="UserName" class="form-control check-exists-user" id="exampleInputname"
                value="<?= isset($_POST['UserName'])?$_POST['UserName'] : "" ?>"
                required
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputFullName" class="form-label"> Full Name</label>
                <input type="text" name="FullName" class="form-control" id="exampleInputFullName"
                value="<?= isset($_POST['FullName'])?$_POST['UserName'] : "" ?>"
                required
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputemail" class="form-label">your email</label>
                <input type="email" name="Email"	 class="form-control check-email" id="exampleInputemail" 
                value="<?= isset($_POST['Email'])?$_POST['UserName'] : "" ?>"
                required
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputPassword1" class="form-label">new Password</label>
                <input type="password" name="Password" class="form-control" id="exampleInputPassword1" 
                required
                >
            </div>
            <div class="mb-3 col-md-6 confirmdiv">
                <label for="exampleInputPassword2" class="form-label">confirm Password</label>
                <input type="password" name="ConfirmPassword" class="form-control" id="exampleInputPassword2" >
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="GroupID">
                    <option value=""> choose  group </option>
                    <option value="1">Admin </option>
                    <option value="0">not Admin member</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="TrustStatus">
                    <option value=""> choose trusted group </option>
                    <option value="1">trusted </option>
                    <option value="0">not trusted member</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="RegStatus">
                    <option value=""> choose approvaol type </option>
                    <option value="1">approved </option>
                    <option value="0">pending approval member</option>
                </select>
            </div>
            <div class="mb-3 col-md-6 confirmdiv">
                <input type="file" name="avatar" class="form-control" id="avatar" >
            </div>


            <button type="submit" class="btn btn-primary submit" name="save" >Submit</button>
            </form>
</div>

