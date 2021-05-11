<?php
        if(isset($_POST['save']))
        {
     //  CategoryId   // category (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
     
            $CategoryId = isset($_POST['CategoryId']) ? $_POST['CategoryId']  : "";
            $CategoryName = isset($_POST['CategoryName']) ? $_POST['CategoryName']  : "";
            $CategoryDescription = isset($_POST['CategoryDescription']) ? $_POST['CategoryDescription']  : "";
            $Ordering  = isset($_POST['Ordering']) ? $_POST['Ordering']  : "";
            $Visibility  = isset($_POST['Visibility']) ? $_POST['Visibility']  : "";
            $AllowComments  = isset($_POST['AllowComments']) ? $_POST['AllowComments']  : "";
            $AllowAds  = isset($_POST['AllowAds']) ? $_POST['AllowAds']  : "";
            $subCategory  = isset($_POST['subCategory']) ? $_POST['subCategory']  : "";

            // $sql2 = "SELECT Password FROM users WHERE CategoryId  = :CategoryId LIMIT 1";
            // global $conn;
            // $stmt2 = $conn->prepare($sql2);
            // $stmt2->bindValue(":CategoryId",$CategoryId,PDO::PARAM_INT);
            // $Oldpassword;
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
            if(empty($subCategory))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>subCategory</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            if(empty($Ordering))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Ordering</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($Visibility))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Visibility</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($AllowComments))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>AllowComments</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($AllowAds))
            {
                $formeroor[] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>AllowAds</strong> can not be empty
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';      
            }
            if(empty($formeroor))
            {
       //  CategoryId   // category (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
                    $sql = "UPDATE category set `CategoryName` = ? , `CategoryDescription` = ? , `subCategory` = ? , `Ordering` = ? , `Visibility` = ? , `AllowComments` = ? , `AllowAds` = ?  WHERE `CategoryId` = ? ";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute(array($CategoryName,$CategoryDescription,$subCategory,$Ordering,$Visibility,$AllowComments,$AllowAds,$CategoryId)))
                    {
                    
                        $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt->rowCount() ."</strong>  updated</p>";

                        $url = "?action=newcategories";
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