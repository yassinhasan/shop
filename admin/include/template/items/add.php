<?php

use function PHPSTORM_META\type;

if(isset($_POST['save']))
    {
        // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId
       $itemName  = isset($_POST['itemName'])?trim($_POST['itemName']) : "";
       $itemDescription = isset($_POST['itemDescription'])?trim($_POST['itemDescription']) : "";
       $itemPrice = isset($_POST['itemPrice'])?$_POST['itemPrice'] : "";
       $itemCountryMade = isset($_POST['itemCountryMade'])?$_POST['itemCountryMade'] : "";
       $itemImage = isset($_POST['itemImage'])?$_POST['itemImage'] : "";
       $itemRating = isset($_POST['itemRating'])?$_POST['itemRating'] : "";
       $categoryId = isset($_POST['categoryId'])?$_POST['categoryId'] : "";
       $subCategoryId = isset($_POST['subCategoryId'])?$_POST['subCategoryId'] : "";
       $userId = isset($_POST['userId'])?$_POST['userId'] : "";
       $tags = isset($_POST['tags'])?$_POST['tags'] : "";


 
        $sql = "INSERT INTO items (`itemName`, `itemDescription`, `itemPrice`, `itemsAddDate`,`itemCountryMade`, `itemImage`,`itemRating`,`categoryId`,`subCategoryId`,`userId`,`tags`)
        VALUES(:itemName,:itemDescription,:itemPrice,now(),:itemCountryMade,:itemImage,:itemRating,:categoryId,:subCategoryId,:userId,:tags)";
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":itemName",$itemName,PDO::PARAM_STR);
        $stmt->bindValue(":itemDescription",$itemDescription,PDO::PARAM_STR);
        $stmt->bindValue(":itemPrice",$itemPrice,PDO::PARAM_STR);
        $stmt->bindValue(":itemCountryMade",$itemCountryMade,PDO::PARAM_STR);
        $stmt->bindValue(":itemImage",$itemImage,PDO::PARAM_STR);
        $stmt->bindValue(":itemRating",$itemRating,PDO::PARAM_INT);
        $stmt->bindValue(":categoryId",$categoryId,PDO::PARAM_INT);
        $stmt->bindValue(":subCategoryId",$subCategoryId,PDO::PARAM_INT);
        $stmt->bindValue(":userId",$userId,PDO::PARAM_INT);
        $stmt->bindValue(":tags",$tags,PDO::PARAM_STR);

        $formeroor = [];

        if(empty($itemName))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemName</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if(empty($itemDescription))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemDescription</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if(empty($itemPrice))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemPrice</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($itemCountryMade))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemCountryMade</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($itemImage))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemImage</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($itemRating))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>itemRating</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($categoryId))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>categoryId</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }
        if(empty($userId))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>userId</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';        }

        if(empty($formeroor))
        {
            if($stmt->execute())
            {
                if($stmt->rowCount() > 0 )
                {
                    $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  add succesfully</p>";
                    $url = "?action=newitems";
                    // header("Refresh:2 $url");
                    header("Refresh:0 ; url = $url");
                }
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
        <!-- // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId -->
<div class="container theform">
        <h1> Add new items </h1>
        <form  method="POST" enctype="application/x-www-form-urlencoded">
                <div class="mb-3 col-md-6">
                    <label for="itemName" class="form-label">Item Name </label>
                    <input type="text" name="itemName" class="form-control" id="itemName"
                    value="<?= isset($_POST['itemName'])?$_POST['itemName'] : "" ?>"
                    
                    >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="itemDescription" class="form-label"> Item Description</label>
                    <input type="text" name="itemDescription" class="form-control" id="itemDescription"
                    value="<?= isset($_POST['itemDescription'])?$_POST['itemDescription'] : "" ?>"
                    >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="itemPrice" class="form-label">itemPrice </label>
                    <input type="text" name="itemPrice"	 class="form-control" id="itemPrice" 
                    value="<?= isset($_POST['itemPrice'])?$_POST['itemPrice'] : "" ?> "
                    >
                </div>         

            <div class="mb-3 col-md-6">
                <label for="itemImage" class="form-label">select image </label>
                <input type="text" name="itemImage"	 class="form-control" id="itemImage" 
                value="<?= isset($_POST['itemImage'])?$_POST['itemImage'] : "" ?> "
                >
            </div>
            <div class="mb-3 col-md-6">
                <select class="form-select all-countries" name="itemCountryMade">
                <option value="">chose country</option>
                </select>
            </div> 
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="itemRating">
                    <option value="">chose rating</option>
                    <option value="5">***** </option>
                    <option value="4">****</option>
                    <option value="3">***</option>
                    <option value="2">**</option>
                    <option value="1">*</option>
                </select>
            </div>
            <div class="mb-3 col-md-6 parent-test">
                <select class="chosen-select select-cat" name="categoryId">
                    <option value="">choose category</option>
                    <?php 
                    $sql = "SELECT categoryId,categoryName FROM category where subCategory = 0";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if($stmt->execute())
                    {
                        if($stmt->rowCount() > 0)
                        { 
                            $results = $stmt->fetchAll();
                            foreach($results as $result)
                            { ?>
                                <option value="<?= $result['categoryId']?>"><?= $result['categoryName']?></option>
                     <?php   }
                       }
                    }
                    
                    ?>
                </select>
            </div>

            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="userId">
                    <option value="">choose user</option>
                    <?php 
                    $sql = "SELECT userId,userName FROM users";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if($stmt->execute())
                    {
                        if($stmt->rowCount() > 0)
                        { 
                            $results = $stmt->fetchAll();
                            foreach($results as $result)
                            { ?>
                                <option value="<?= $result['userId']?>"><?= $result['userName']?></option>
                     <?php   }
                       }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="tag-container mb-3 col-md-6">
                    <input type="text" <?= isset($_POST['tags'])?$_POST['tags'] : "" ?>>
                    <input name="tags" type="hidden">
            </div>
            <!-- <div class="mb-3 col-md-6">
                    <label for="tags" class="form-label">tags Names </label>
                    <input type="text" name="tags" class="form-control" id="tags"
                    value="<?= isset($_POST['tags'])?$_POST['tags'] : "" ?>">
            </div> -->


            <button type="submit" class="btn btn-primary submit" name="save" >Submit</button>
            </form>
</div>

