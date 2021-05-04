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


        $sql = "INSERT INTO users (`UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`)
        VALUES(:U,:P,:E,:FN,:GI,:TS,:RS)";
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":U",$UserName,PDO::PARAM_STR);
        $stmt->bindValue(":P",$Password,PDO::PARAM_STR);
        $stmt->bindValue(":E",$Email,PDO::PARAM_STR);
        $stmt->bindValue(":FN",$FullName,PDO::PARAM_STR);
        $stmt->bindValue(":GI",$GroupID,PDO::PARAM_INT);
        $stmt->bindValue(":TS",$TrustStatus,PDO::PARAM_INT);
        $stmt->bindValue(":RS",$RegStatus,PDO::PARAM_INT);
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
        if(empty($formeroor))
        {
            if($stmt->execute())
            {
                if($stmt->rowCount() > 0 )
                {
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
        <form  method="POST" enctype="application/x-www-form-urlencoded">
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


            <button type="submit" class="btn btn-primary submit" name="save" >Submit</button>
            </form>
</div>

