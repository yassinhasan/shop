<?php
ob_start();
require_once "ini.php";
$title = "add-item";
get_main_webisite_header();
get_main_webisite_navbar(); 

    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
	echo $message;
    $_SESSION['message'] = "";


    if(isset($_POST['save']))
    {
        // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId
       $itemName  = isset($_POST['itemName'])?trim($_POST['itemName']) : "";
       $itemDescription = isset($_POST['itemDescription'])?trim($_POST['itemDescription']) : "";
       $itemPrice = isset($_POST['itemPrice'])?$_POST['itemPrice'] : "";
       $itemCountryMade = isset($_POST['itemCountryMade'])?$_POST['itemCountryMade'] : "";
       $itemRating = isset($_POST['itemRating'])?$_POST['itemRating'] : "";
       $categoryId = isset($_POST['categoryId'])?$_POST['categoryId'] : "";
       $userId = isset($_SESSION['User']['UserId'])?$_SESSION['User']['UserId'] : "";

    //    avatar
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


        $sql = "INSERT INTO items (`itemName`, `itemDescription`, `itemPrice`, `itemsAddDate`,`itemCountryMade`, `itemImage`,`itemRating`,`categoryId`,`userId`)
        VALUES(:itemName,:itemDescription,:itemPrice,now(),:itemCountryMade,:itemImage,:itemRating,:categoryId,:userId)";
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":itemName",$itemName,PDO::PARAM_STR);
        $stmt->bindValue(":itemDescription",$itemDescription,PDO::PARAM_STR);
        $stmt->bindValue(":itemPrice",$itemPrice,PDO::PARAM_STR);
        $stmt->bindValue(":itemCountryMade",$itemCountryMade,PDO::PARAM_STR);
        $stmt->bindValue(":itemImage",$avatr_rand_name,PDO::PARAM_STR);
        $stmt->bindValue(":itemRating",$itemRating,PDO::PARAM_INT);
        $stmt->bindValue(":categoryId",$categoryId,PDO::PARAM_INT);
        $stmt->bindValue(":userId",$userId,PDO::PARAM_INT);

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

                    $dir = dirname(__FILE__);
                    $first_path = "themes".DS."images".DS."items";
                    $sec_path = "themes".DS."images".DS."items";
    
                    movefile_in_main($first_path,$sec_path,$itemName,$avatar_name,$avatar_temp_name,$avatr_rand_name);

                    $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  add succesfully</p>";
                    // header("Refresh:2 $url");
                    header("Refresh:0");
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
<?php 
    if(isset($_SESSION['User']))
        { ?>

     
<div class="container">

    <h1> Add new items </h1>
    <div class="row add-item-row">     
            <div class="col-md-8">
                <form  method="POST" enctype="multipart/form-data" class="theform">
                        <div class="col-md-10">
                            <label for="itemName" class="form-label">Item Name </label>
                            <input type="text" name="itemName" class="form-control check-item-exists"
                             id="itemName"
                             data-name = '.it-name'
                            value="<?= isset($_POST['itemName'])?$_POST['itemName'] : "" ?>"
                            
                            >
                        </div>
                        <div class="col-md-10">
                            <label for="itemDescription" class="form-label"> Item Description</label>
                            <input type="text" name="itemDescription" class="form-control" id="itemDescription"
                            data-name = '.it-desc'
                            value="<?= isset($_POST['itemDescription'])?$_POST['itemDescription'] : "" ?>"
                            >
                        </div>
                        <div class="col-md-10">
                            <label for="itemPrice" class="form-label">itemPrice </label>
                            <input type="text" name="itemPrice"	 class="form-control" id="itemPrice" 
                            data-name = '.it-price'
                            value="<?= isset($_POST['itemPrice'])?$_POST['itemPrice'] : "" ?> "
                            >
                        </div>         

                        <div class="mb-3 col-md-6">
                      <input type="file" name="avatar" class="form-control" id="itemImage">
                      </div>
                    <div class="col-md-10 form-group-select">
                        <select class="form-select all-countries" name="itemCountryMade">
                        <option value="">chose country</option>
                        </select>
                    </div> 
                    <div class="col-md-10 form-group-select">
                        <select class="form-select" name="itemRating">
                            <option value="">chose rating</option>
                            <option value="5">***** </option>
                            <option value="4">****</option>
                            <option value="3">***</option>
                            <option value="2">**</option>
                            <option value="1">*</option>
                        </select>
                    </div>
                    <div class="col-md-10 form-group-select">
                        <select class="form-select" name="categoryId">
                            <option value="">choose category</option>
                            <?php 
                            $sql = "SELECT categoryId,categoryName FROM category";
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
                    <button type="submit" class="btn btn-primary submit" name="save" >Submit</button>
                </form>
            </div>
            <!-- start live review -->
            <div class="col-md-3 text-center">
            <h3> live preview </h3>           
                <div class="item-content">
                                <img src="//cdn-aldawaa.com/media/catalog/product/cache/4af02630f79858b92879ba1184cb0894/1/0/101975_2.jpg" alt="test">
                                <span class="love-item"><i class="fas fa-heart rate-by-heart"></i></span>
                                <div class="item-info">
                                    <p class="it-name">TEST</p>
                                    <p class="it-desc">TEST is used for test </p>
                                    <span class="it-price">20 </span> <span> SR</span>
                                    <div class="item-rating"> 
                                      <span><i class='fas fa-star start-chekced'></i></span>
                                      <span><i class='fas fa-star start-chekced'></i></span>
                                      <span><i class='fas fa-star start-chekced'></i></span>
                                      <span><i class='fas fa-star start-chekced'></i></span>
                                      <span><i class='fas fa-star start-chekced'></i></span>
                                    <!-- for($x= 0 ; $x <  5 ; $x++)
                                    { 
                                        echo "<span><i class='fas fa-star start-chekced'></i></span>";
                                        }

                                        for($x= 0 ; $x < 5 - 3 ; $x++)
                                        { 
                                            echo "<span><i class='fas fa-star'></i></span>";
                                         } -->
                                       
                                    </div>
                                </div>
                                    <input type="hidden" value="test">
                                    <div class="item-add">
                                        <button class="add-chart"><i class="fas fa-shopping-cart"></i></button>
                                        <div>
                                            <div class="item-add-button">
                                                <button class="add-qty">+</button>
                                                <input type="number" name="item-qty" value="0" min="0" max="12"
                                                class="input-item-qty">
                                                <button class="decrease-qty">-</button>
                                            </div>
                                        </div>
                                    </div>
                 </div>  
            </div>
            <!-- end live review -->
        </div>
</div>  

<?php  } 

get_main_webisite_footer();
ob_end_flush();
?>