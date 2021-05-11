<?php 
    if(isset($_POST['save']))
    {
       $CategoryName  = isset($_POST['CategoryName'])?trim($_POST['CategoryName']) : "";
       $CategoryDescription = isset($_POST['CategoryDescription'])?trim($_POST['CategoryDescription']) : "";
       $Ordering = isset($_POST['Ordering'])?$_POST['Ordering'] : "";
       $Visibility = isset($_POST['Visibility'])?$_POST['Visibility'] : "";
       $AllowComments = isset($_POST['AllowComments'])?$_POST['AllowComments'] : "";
       $AllowAds = isset($_POST['AllowAds'])?$_POST['AllowAds'] : "";
       $subCategory = isset($_POST['subCategory'])?$_POST['subCategory'] : 0;
    //    var_dump($subCategory);
    //    exit;

        $sql = "INSERT INTO category (`CategoryName`, `CategoryDescription`,`subCategory`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
        VALUES(:CategoryName,:CategoryDescription,:subCategory,:Ordering,:Visibility,:AllowComments,:AllowAds)";
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":CategoryName",$CategoryName,PDO::PARAM_STR);
        $stmt->bindValue(":CategoryDescription",$CategoryDescription,PDO::PARAM_STR);
        $stmt->bindValue(":Ordering",$Ordering,PDO::PARAM_INT);
        $stmt->bindValue(":subCategory",$subCategory,PDO::PARAM_INT);
        $stmt->bindValue(":Visibility",$Visibility,PDO::PARAM_STR);
        $stmt->bindValue(":AllowComments",$AllowComments,PDO::PARAM_STR);
        $stmt->bindValue(":AllowAds",$AllowAds,PDO::PARAM_STR);

        $formeroor = [];

        if(empty($CategoryName))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>CategoryName</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if(empty($CategoryDescription))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>CategoryDescription</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        // if(empty($subCategory))
        // {
        //     $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        //     <strong>subCategory</strong> can not be empty
        //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //   </div>';
        // }
        if(empty($Ordering))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Ordering</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($Visibility))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Visibility</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($AllowComments))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>AllowComments</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($AllowAds))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>AllowAds</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }

        if(empty($formeroor))
        {
            if($stmt->execute())
            {
                if($stmt->rowCount() > 0 )
                {
                    $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  add succesfully</p>";
                    $url = "?action=newcategories";
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
<!-- O category (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`) -->
<div class="container theform">
        <h1> Add new Category </h1>
        <form  method="POST" enctype="application/x-www-form-urlencoded">
            <div class="mb-3 col-md-6">
                <label for="CategoryName" class="form-label">Category Name </label>
                <input type="text" name="CategoryName" class="form-control check-exists-category" id="CategoryName"
                value="<?= isset($_POST['CategoryName'])?$_POST['CategoryName'] : "" ?>"
                required
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="CategoryDescription" class="form-label"> Category Description</label>
                <input type="text" name="CategoryDescription" class="form-control" id="CategoryDescription"
                value="<?= isset($_POST['CategoryDescription'])?$_POST['CategoryDescription'] : "" ?>"
                >
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="subCategory">
                    <option> subCategory </option>
                    <option value="0"> None </option>
                    <?php
                        $allcategories = get_all("category",'WHERE subCategory = 0');
                        foreach($allcategories as $cat)
                        { ?>
                            <option value="<?= $cat['CategoryId'] ?>"> <?= $cat['CategoryName'] ?> </option>
                        <?php }
                    ?>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label for="Ordering" class="form-label">Ordering Category</label>
                <input type="number" name="Ordering"	 class="form-control check-email" id="Ordering" 
                value="<?= isset($_POST['Ordering'])?$_POST['Ordering'] : "" ?> "
                min="0" step="1"
                >
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">Visibility</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Visibility-yes" name="Visibility" value="yes" checked>
                        <label for="Visibility-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Visibility-no" name="Visibility" value="no">
                        <label for="Visibility-no">no</label>
                    </div>
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">AllowComments</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowComments-yes" name="AllowComments" value="yes" checked>
                        <label for="AllowComments-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowComments-no" name="AllowComments" value="no" >
                        <label for="AllowComments-no">no</label>
                    </div>
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">AllowAds</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowAds-yes" name="AllowAds" value="yes" checked>
                        <label for="AllowAds-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowAds-no" name="AllowAds" value="no" >
                        <label for="AllowAds-no">no</label>
                    </div>
            </div>



            <button type="submit" class="btn btn-primary submit" name="save" >Submit</button>
            </form>
</div>

