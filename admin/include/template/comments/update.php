<?php 
    if(isset($_POST['save']))
    {
     // <!-- commentsId commentsDescription commentsApprove userId categoryId commentsDate -->

        
        $commentsDescription  = isset($_POST['commentsDescription'])?trim($_POST['commentsDescription']) : "";
        $categoryId = isset($_POST['categoryId'])?$_POST['categoryId'] : "";
        $userId = isset($_POST['userId'])?$_POST['userId'] : "";
        $commentsId = isset($_POST['commentsId'])?$_POST['commentsId'] : "";
      
 


        $formeroor = [];

        if(empty($commentsDescription))
        {
            $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>commentsDescription</strong> can not be empty
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
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
            // <!-- commentsId commentsDescription commentsApprove userId categoryId commentsDate -->

          $sql = " UPDATE  comments  SET commentsDescription = ? , userId  = ? WHERE commentsId =  ?";
          global $conn;
           


          $stmt = $conn->prepare($sql);
          if ($stmt->execute(array($commentsDescription,$userId,$commentsId)))
            {
                    
              $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";

              $url = "?action=allcomments";
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
