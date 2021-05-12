<?php 
    
    // var_dump($_SESSION['message']);
    $message =(isset($_SESSION['message']) && !empty($_SESSION['message'])) ? $_SESSION['message'] : false;
    
    if(false != $message && is_array($message))
    {
        foreach($message as $msg)
        {
            echo $msg;
        }
    }
    $_SESSION['message'] = "";
    $UserId = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? $_GET['UserId'] : 0; 
    $sql = "SELECT * FROM users WHERE UserId  = :UserId LIMIT 1";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $User = array_shift($Users);

                ?>

<div class="container theform">
        <h1> Edit your Porfile</h1>
        <form action="?action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= $UserId ?>"  name="UserId">
            <div class="mb-3 col-md-6">
                <label for="exampleInputname" class="form-label">your name</label>
                <input type="text" name="UserName" class="form-control check-edit-username" id="exampleInputname" 
                required
                value="<?= isset($User['UserName']) ? $User['UserName'] : "" ?> ">
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputFullName" class="form-label"> Full Name</label>
                <input type="text" name="FullName" class="form-control" id="exampleInputFullName" 
                required
                value="<?= isset($User['FullName']) ?$User['FullName'] : "" ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputemail" class="form-label">your email</label>
                <input type="email" name="Email"	 class="form-control check-edit-email" id="exampleInputemail" 
                required
                value="<?= isset($User['Email']) ?$User['Email'] : "" ?>" >
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputPassword1" class="form-label">Old Password</label>
                <input type="password" name="Password" class="form-control checkoldpassword"
                value="" id="exampleInputPassword1" 
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="exampleInputPassword2" class="form-label">New Password</label>
                <input type="password" name="NewPassword" class="form-control" id="exampleInputPassword2"
                value="" >
            </div>
            <div class="mb-3 col-md-6">
                <input type="file" name="avatar" class="form-control" id="avatar" >
            </div>

            <button type="submit" class="btn btn-primary submit" name="save">Submit</button>
            </form>
</div>

<?php
            }
            else
            {
                error_redirection("soory eroor");
            }
        }

        
        ?>