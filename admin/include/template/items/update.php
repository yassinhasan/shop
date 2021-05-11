<?php 
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
        $userId = isset($_POST['userId'])?$_POST['userId'] : "";
        $itemId = isset($_POST['itemId'])?$_POST['itemId'] : "";
        $tags = isset($_POST['tags'])?$_POST['tags'] : "";
      

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

          $sql = " UPDATE  items  SET itemName = ? , itemDescription  = ? , itemPrice = ? , itemImage = ? , itemCountryMade  = ? , itemRating  = ?, categoryId  = ? , userId  = ?,tags = ? WHERE itemId =  ?";
          global $conn;
           


          $stmt = $conn->prepare($sql);
          if ($stmt->execute(array($itemName,$itemDescription,$itemPrice,$itemImage,$itemCountryMade,$itemRating,$categoryId,$userId,$tags,$itemId)))
            {
                    
              $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";

              $url = "?action=newitems";
                    // header("Refresh:2 $url");
                    header("Refresh:0 ; url = $url");
                    
                }
                else
                {
                    
                    // $_SESSION['message'] ="<p class='alert alert-danger'> sorry  old Password  not correct</p>";
                    $path = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "?action=manage";
                    header("location: $path");
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
